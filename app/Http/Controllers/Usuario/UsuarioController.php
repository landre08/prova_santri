<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Usuario;
use App\Autorizacao;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct() 
     {
        $this->middleware(\App\Http\Middleware\UsuarioMiddleware::class);
     }
    public function index()
    {
        $usuarios = Usuario::all();
        $autorizacao_usuario = Autorizacao::select('CHAVE_AUTORIZACAO')->where('USUARIO_ID', session()->get('login'))->get();
        $array_autorizacao = array();

        foreach($autorizacao_usuario as $auto) {
            array_push($array_autorizacao, $auto->CHAVE_AUTORIZACAO);
        }

        return view('usuario.index', compact('usuarios', 'array_autorizacao'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuario.usuario');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Valida os compos do usuário e marca o campo se for enviado em branco.
        $regras = [
            'nome_completo' => 'required',
            'login' => 'required',
            'senha' => 'required'
        ];

        $mensagens = [
            'nome_completo.required' => 'O :attribute é obrigatório.',
            'login.required' => 'O :attribute é obrigatório.',
            'senha.required' => 'A :attribute é obrigatória.'
        ];

        $request->validate($regras, $mensagens);

        // Caso não marque pelo menos um permissão, estoura uma mensagem para o usuário questionando isso.
        if (is_null($request->input('permissao'))) {
            flash('Você precisa escolher pelo menos uma das permissões.')->error();
            return redirect()->route('usuario.create')->withInput();
        }

        // Caso tudo ocorra aqui o cadastro do usuário com suas permissão são realizadas
        $usuario = new Usuario();
        $usuario->nome_completo = $request->input('nome_completo');
        $usuario->login = $request->input('login');
        $usuario->senha = $request->input('senha');
        $usuario->ativo = $request->input('ativo');
        $usuario->save();
    
        $permissoes = $request->input('permissao');

        foreach($permissoes as $per) {
            $autorizacao = new Autorizacao();
            $autorizacao->USUARIO_ID = $usuario->USUARIO_ID;
            $autorizacao->CHAVE_AUTORIZACAO = $per;
            $autorizacao->save();
        }

        return redirect()->route('usuario.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = Usuario::where('USUARIO_ID', $id)->first();
        $autorizacao = Autorizacao::where('USUARIO_ID', $id)->get();

        return view('usuario.editar', compact('usuario', 'autorizacao'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Valida os compos do usuário e marca o campo se for enviado em branco.
        $regras = [
            'nome_completo' => 'required',
            'login' => 'required',
            'senha' => 'required'
        ];

        $mensagens = [
            'nome_completo.required' => 'O :attribute é obrigatório.',
            'login.required' => 'O :attribute é obrigatório.',
            'senha.required' => 'A :attribute é obrigatória.'
        ];

        $request->validate($regras, $mensagens);

        // Caso não marque pelo menos um permissão, estoura uma mensagem para o usuário questionando isso.
        if (is_null($request->input('permissao'))) {
            flash('Você precisa escolher pelo menos uma das permissões.')->error();
            return redirect()->route('usuario.edit', $id)->withInput();
        }

        // Busca o usuário na baase
        $usuario = Usuario::where('USUARIO_ID', $id)->first();

        // Se o encontrar, faz a atualização.
        if (isset($usuario)) {
            $usuario->NOME_COMPLETO = $request->input('nome_completo');
            $usuario->LOGIN = $request->input('login');
            $usuario->SENHA = $request->input('senha');
            $usuario->ATIVO = $request->input('ativo');

            $usuario->save();
        }

        $permissoes = $request->input('permissao');
        $autorizacao = Autorizacao::where('USUARIO_ID', $id)->first();
        foreach($permissoes as $per) {
            $autorizacao->delete();
            $autorizacao = new Autorizacao();
            $autorizacao->usuario_id = $usuario->USUARIO_ID;
            $autorizacao->chave_autorizacao = $per;
            $autorizacao->save();
        }

        return redirect()->route('usuario.index');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // recebe via ajax o id e excluir na base
        // exclui primeiro a autorizacao, devido ao relacionamento de um pra muito e ter chave estrangeira.
        $autorizacao = Autorizacao::where('USUARIO_ID', $id)->first();
        $autorizacao->delete();

        $usuario = Usuario::where('USUARIO_ID', $id)->first();
        $usuario->delete();

        // Retorna o status com verdadeiro para poder ser redirecionado no javascript para a tela principal
        $sucesso = 'ok';
        return $sucesso;
    }
}

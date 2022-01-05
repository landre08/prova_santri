<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Usuario;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('login.login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Elimina a sessão de erro quando não há usuário na base.
        $request->session()->flush('login_invalido');

        // Valida os compos do login e marca o campo se for enviado em branco.
        $regras = [
            'usuario' => 'required',
            'senha' => 'required'
        ];

        $mensagens = [
            'usuario.required' => 'O :attribute é obrigatório.',
            'senha.required' => 'A :attribute é obrigatório.'
        ];

        $request->validate($regras, $mensagens);

        // Busca o usuário na base para e faz a validações
        $usuario = Usuario::where('login', $request->input('usuario'))
            ->where('senha', $request->input('senha'))
            ->where('ativo', 's')
            ->first();

        // Aqui o usuário foi encontrado na base de dados, além de está ativo no sistema
        if (!is_null($usuario)) {
            $usuario = $usuario->toArray();
            $request->session()->put('login', $usuario['USUARIO_ID']);
            $request->session()->put('usuario', ($usuario['NOME_COMPLETO']? $usuario['NOME_COMPLETO']: $usuario['LOGIN']));
            return redirect()->route('usuario.index');          
        }

        // Redireciona de volta caso o login seja inválido.
        flash('Não existe o usuário ou senha cadastrado no sistema.')->error();
        return redirect()->route('login')->withInput();
        
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sair(Request $request) {
        $request->session()->flush('login');

        return redirect()->route('login');
    }
}

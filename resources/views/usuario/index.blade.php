@extends('layout.logado.principal')

@section('logado')
<main class="container mt-5 pt-5">
        <div class="card border">
            <div class="card-header">
                Listagem de usuários
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <form class="form-inline my-2 my-lg-0">
                            <input class="form-control mr-sm-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
                            <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Pesquisar</button>
                        </form>
                    </div>
                    @if(in_array('cadastrar_clientes', $array_autorizacao))
                        <div class="col-md-6 text-right">
                            <a href="{{ route('usuario.create') }}" class="btn btn-outline-primary">Novo Usuário</a>
                        </div>
                    @endif
                </div>

                <table class="table table-striped table-hover mt-5">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Login</th>
                            <th scope="col">Ativo</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach($usuarios as $usuario)
                        <tr>
                            <th scope="row">{{ $usuario->USUARIO_ID }}</th>
                            <td>{{ $usuario->NOME_COMPLETO }}</td>
                            <td>{{ $usuario->LOGIN }}</td>
                            <td>{{ $usuario->ATIVO }}</td>
                            <td>
                                @if(in_array('editar_clientes', $array_autorizacao))
                                    <a href="/usuario/{{$usuario->USUARIO_ID}}/edit" class="btn btn-sm btn-warning">Editar</a>
                                @endif

                                @if(in_array('excluir_clientes', $array_autorizacao))
                                    <a  href="javascript:;" id="deletar" data-ide={{ $usuario->USUARIO_ID }} class="btn btn-sm btn-danger">Excluir</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div class="modal" tabindex="-1" role="dialog" id="modal-excluir">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header" style="background-color: #e3342f; color: #FFF">
                <h5 class="modal-title">Confirmação?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Você tem certeza que deseja excluir?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" id="c-m-excluir">Apagar</button>
            </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.js') }}">
    </script>
    <script>    
        $(function() {

            var ide = null;
            $(document).on('click', '#deletar', function(e) {
                e.preventDefault();
                
                ide = $(this).attr('data-ide');
                $('#modal-excluir').modal('show');
            });

            $(document).on('click', '#c-m-excluir', function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                
                    $.ajax({
                    type: 'DELETE',
                    url: '/usuario/'+ide,
                    context: this,
                    success: function(data) {
                        console.log(data);
                        if (data) {
                            $('#modal-excluir').modal('hide');
                            window.location.href = "/usuario";
                        }

                    },
                    error: function(error) {
                        console.log(error);
                    }

                });
            });

        })</script>
@endsection

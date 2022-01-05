@extends('layout.logado.principal')

@section('logado')

    <main class="container mt-5 pt-5">
        <div class="card border">
            <div class="card-header">
                Cadastro de usuário
            </div>
            <div class="card-body">
                <form action="{{ route('usuario.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input class="form-control {{ $errors->has('nome_completo') ? 'is-invalid' : '' }}" type="text" placeholder="Nome..." name="nome_completo" id="nome_completo" value="{{ old('nome_completo') }}" />
                        @if($errors->has('nome_completo'))
                            <div class="invalid-feedback">
                                {{ $errors->first('nome_completo') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input class="form-control {{ $errors->has('login') ? 'is-invalid' : '' }}" type="text" placeholder="Login..." name="login" id="login" value="{{ old('login') }}" />
                    @if($errors->has('login'))
                        <div class="invalid-feedback">
                            {{ $errors->first('login') }}
                        </div>
                    @endif
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input class="form-control {{ $errors->has('senha') ? 'is-invalid' : '' }}" type="password" placeholder="Senha..." name="senha" id="senha"  value="{{ old('senha') }}" />
                    @if($errors->has('senha'))
                        <div class="invalid-feedback">
                            {{ $errors->first('senha') }}
                        </div>
                    @endif
                    </div>
                    <div class="form-group">
                        <label for="senha">Ativo:</label>
                        <select class="form-control" name="ativo">
                            <option value='S' {{ old('ativo') == 'S' ? 'selected': '' }}>Sim</option>
                            <option value='N' {{ old('ativo') == 'N' ? 'selected': '' }}>Não</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Permissões:</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="cadastrar_clientes" name="permissao[]" value="cadastrar_clientes">
                            <label class="form-check-label" for="cadastrar_clientes">Cadastrar clientes</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="editar_clientes" name="permissao[]" value="editar_clientes">
                            <label class="form-check-label" for="editar_clientes">Editar clientes</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="excluir_clientes" name="permissao[]" value="excluir_clientes">
                            <label class="form-check-label" for="excluir_clientes">Excluir clientes</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
                    <a href="{{ route('usuario.index') }}" class="btn btn-primary btn-sm">Cancelar</a>
                </form>
            </div>
        </div>
        @include('flash::message')
    </main>
@endsection
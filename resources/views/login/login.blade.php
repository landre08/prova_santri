@extends('layout.naologado.principal')

@section('naologado')

<div class="container">
    <div class="card text-center mt-5">
        <div class="card-header">
            <img alt="logo da empresa" src="{{ asset('imagens/logo_cliente.jpg') }}" width="230" />
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('novologin') }}">
                @csrf()
                <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="usuario">Usuário</label>
                            <input type="text" value="{{ old('usuario') }}" class="form-control {{ $errors->has('usuario') ? 'is-invalid' : '' }} " id="usuario" name="usuario" placeholder="Seu usuario...">
                            @if($errors->has('usuario'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('usuario') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="senha">Senha</label>
                            <input type="password" class="form-control {{ $errors->has('senha') ? 'is-invalid' : '' }}" id="senha" name="senha" placeholder="Sua senha...">
                            @if($errors->has('senha'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('senha') }}
                                </div>
                            @endif
                        </div>
                </div>
                <button type="submit" class="btn btn-primary">Acessar</button>
                <button type="reset" class="btn btn-secondary">Limpar</button>
            </form>
        </div>
        <div class="card-footer text-muted">
            <img alt="logo da empresa" src="{{ asset('imagens/logo_santri.svg') }}" width="230" />
        </div>
    </div>
    @include('flash::message')
</div>

@endsection
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Prova Santri - Luciano André</title>
</head>
<body>

    <nav class="navbar fixed-top navbar-light bg-light">
        <a class="navbar-brand"><img alt="logo da empresa" src="{{ asset('imagens/logo_santri.svg') }}" width="120" /></a>
        <div>
            <span class="text-uppercase font-weight-bold">Ola, {{ session()->get('usuario') }} </span> 
            <form class="form-inline d-inline" action="/sair">
                <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Sair</button>
            </form>
        </div>
    </nav>
    @yield('logado')

    <script src="{{ asset('js/app.js') }}">
    </script>
</body>
</html>
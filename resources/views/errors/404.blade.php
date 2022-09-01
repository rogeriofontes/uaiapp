<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>404 Error</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown" style="max-width: 600px">
        <h1>{{$exception->getStatusCode()}}</h1>
        <h3 class="font-bold">Página não encontrada =(</h3>

        <div class="error-desc">
        Desculpe, mas está página não foi encontrada . Tente checar a url e atualize sua página, caso o erro persista entre com contato com o adminstrador do sistema. Obrigado.
            <br /><a href="javascript:history.back()" class="btn btn-primary m-t">Voltar</a>
        </div>

        <br />
        <div class="bg-danger">
            {{$exception->getFile()}}
            <br />
            <b>Code: </b>{{ $exception->getCode()}} 
            <br />
            <b>Line: </b>{{$exception->getLine()}} 
            <br />
            <b>Message: </b>{{$exception->getMessage()}}
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

</body>

</html>

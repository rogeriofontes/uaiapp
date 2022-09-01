<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>500 Error</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown" style="max-width: 600px">
        <h1>500</h1>
        <h3 class="font-bold">Internal Server Error =(</h3>

        <div class="error-desc">
            O servidor encontrou algum erro enquanto você completava a ação. Pedimos desculpas pelo acontecido.
            Você pode voltar para página anterior, caso o erro persista entre em contato com o administrador do sistema.
           <br /><a href="javascript:history.back()" class="btn btn-primary m-t">Voltar</a>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

</body>

</html>

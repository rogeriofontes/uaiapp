<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>{{ $seoData['title'] }}</title>
    <meta name="description" content="{{ $seoData['description'] }}">
    <meta name="keywords" content="{{ $seoData['keywords'] }}">
    <meta name="author" content="Agência DW3">

    <!-- Twitter Card data -->
    <meta name="twitter:card" value="summary">

    <meta name="theme-color" content="#FFC577">
    <link rel="icon" sizes="192x192" href="{{ asset('img/landing/logo_192x192.png')}}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $seoData['title'] }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ $seoData['ogUrl'] }}" />
    <meta property="og:image" content="{{ $seoData['ogImage'] }}" />
    <meta property="og:description" content="{{ $seoData['description'] }}" />
    
    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <!-- Animate -->
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <!-- CSS Default -->
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
  </head>
  <body data-spy="scroll">
    <!-- Menu Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="{{ url('/')}}">
          <img src="{{ asset('img/landing/logo.png')}}" alt="Logo" class="img-fluid">
          <center><p class="d-none d-lg-block">O aplicativo <br />que dá sorte</p></center>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item mx-2 d-block d-lg-none">
              <a class="nav-link scroll" href="#section-one">Sobre o Aplicativo</a>
            </li>
            <li class="nav-item mx-2 d-none d-lg-block">
              <a class="nav-link scroll" href="#free-download">Sobre o Aplicativo</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link scroll" href="#functions">Funções do App</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link scroll" href="#versions">Versões</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    
    @yield('content')

    <!-- Footer -->
    <footer class="footer py-3">
      <div class="container">
        <ul class="social-icons">
          <!-- <li><a href="https://www.instagram.com/" target="_blank" class="instagram"><i class="fab fa-3x fa-instagram"></i></a></li> -->
          <li><a href="https://www.facebook.com/UAI-APP-1961034610873458" target="_blank" class="facebook"><i class="fab fa-3x fa-facebook-square"></i></a></li>
        </ul>
      </div>
    </footer>
    <div class="footer-copyright py-3">
      <p class="text-center text-white m-0">&copy; Copyright 2018 - Todos os Direitos Reservados</p>
      <p class="text-center m-0"><a href="{{ asset('pdf/termos_e_condicoes.pdf')}}" class="text-white" target="_blank">Termos e Condições Gerais de Uso</a></p>
      <p class="text-center text-white m-0">CNPJ: 30.850.902/0001-88</p>
      <p class="text-center text-white m-0">Developed by <a href="http://agenciadw3.com.br/" target="_blank" class="text-white text-uppercase font-italic">Agência DW3</a></p>
      <p class="text-center text-white m-0">Designed by <a href="https://www.upwardwebagency.com/" target="_blank" class="text-white text-uppercase font-italic">UpWard</a></p>
    </div>

    <a href="#" id="back-to-top">
      <i class="fas fa-angle-double-up"></i>
    </a>

    <!-- Jquery For Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <!-- Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <!-- WOW JS -->
    <script src="{{ asset('js/wow.min.js') }}"></script>
    
    <script type="text/javascript">
      //URLS JAVASCRIPT
      var base = "{{ url('/') }}";
    </script>
    <script src="{{ url('js/site.js') }}"></script>

  </body>
</html>
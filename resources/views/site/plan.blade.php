<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ $seoData['title'] }}</title>
  <meta name="description" content="{{ $seoData['description'] }}">
  <meta name="keywords" content="{{ $seoData['keywords'] }}">
  <meta name="author" content="Agência DW3">
  <meta name="theme-color" content="#FFC577">
  <link rel="icon" sizes="192x192" href="{{ asset('img/landing/logo_192x192.png')}}">

  <!-- FontAwesome 5 -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
  <!-- Plano CSS -->
  <link rel="stylesheet" href="{{ asset('css/plan.css') }}">

  <script>
    var URL = "{{ url('/') }}";
  </script>
</head>
<body>
  <section class="plans d-flex align-items-center">
    <div class="container">
      <div class="row mt-5 mt-lg-0">
        @foreach($plans as $plan)
          <div class="col-lg-4">
            <div class="card border-0 mb-5">
              <div class="card-body">
                <h5 class="card-title text-center text-uppercase">{{ $plan->plan }}</h5>
                <h5 class="card-subtitle text-center text-muted">Anuncie por {{ $plan->days }} dias</h5>
                <hr>
                <h6 class="card-price text-center mb-4">{{ $plan->getPrice() }}</h6>
                <a href="{{ url('checkout?api_token=' . \Input::get('api_token') . '&product_id=' . \Input::get('product_id') . '&plan_id=' . $plan->id) }}" class="btn btn-block text-uppercase p-3">Anunciar</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- Jquery For Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <!-- Popper -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <!-- Bootstrap -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>
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
  <!-- Checkout Sucesso -->
  <link rel="stylesheet" href="{{ asset('css/checkout-success.css') }}">
  
  <script>
    var URL = "{{ url('/') }}";
  </script>
</head>
<body>
  <section class="checkout-success d-flex align-items-center">
    <div class="container">
      <div class="row mt-5 mt-lg-0">
        <div class="col-12 col-lg-6 offset-lg-3">
          <div class="card border-0">
            <div class="card-body">
              @if($checkout->paymentMethod == 1)
                @if($checkout->status == 3)
                  <h5 class="card-title text-center text-uppercase mb-3">Anúncio cadastrado com sucesso!</h5>
                  <h5 class="card-description">Produto: <span>{{ $checkout->getProduct->name }}</span></h5>
                  <h5 class="card-description">Plano: <span>{{ $checkout->getPlan->plan }}</span></h5>
                  <h5 class="card-description">Anúncio expira em: <span>{{ $checkout->getProduct->date_end->format('d/m/Y') }}</span></h5>
                @else
                  <h5 class="card-title text-center text-uppercase mb-3">Estamos processando seu pagamento!</h5>
                @endif
              @elseif($checkout->paymentMethod == 2)
                <a href="{{ $checkout->link_boleto }}" class="card-link" target="_blank">
                  <h5 class="card-title text-center text-uppercase">Clique aqui para imprimir seu boleto</h5>
                  <div class="d-flex justify-content-center mb-4">
                    <i class="fas fa-5x fa-barcode"></i>
                  </div>
                </a>
                <p class="border-top border-dark fw-5 pt-3 m-0">Obs: seu anúncio entrará em vigor assim que for detectado o pagamento deste boleto pelo nosso sistema.</p>
              @else
                <h5 class="card-title text-center text-uppercase mb-3">Anúncio cadastrado com sucesso!</h5>
                <h5 class="card-description">Produto: <span>{{ $checkout->getProduct->name }}</span></h5>
                <h5 class="card-description">Plano: <span>{{ $checkout->getPlan->plan }}</span></h5>
                <h5 class="card-description">Anúncio expira em: <span>{{ $checkout->getProduct->date_end->format('d/m/Y') }}</span></h5>
              @endif
            </div>
          </div>
        </div>  
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
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
  <!-- Material Design for Bootstrap fonts and icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
  <!-- Bootstrap Material Design -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap-material-design.min.css') }}">
  <!-- Sweet Alert -->
  <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
  <!-- Checkout CSS -->
  <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
  <!-- Jquery Card CSS -->
  <link rel="stylesheet" href="{{ asset('css/card.css') }}">

  <script>
    var URL = "{{ url('/') }}";
  </script>
</head>
<body>
  <section class="checkout py-3">
    <div class="container">
      <div class="row">
        <!-- Grid Formulário -->
        <div class="col-lg-8 order-2 order-lg-1">
          @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>OPS!</strong> Ocorreu algum erro ao cadastrar.
              @if (count($errors) > 0)
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              @endif
            </div>
          @endif

          <h4 class="text-white">Dados de cobrança</h4>
          {{ Form::open(['url' => 'set-checkout?api_token=' . Input::get('api_token') . '&product_id=' . Input::get('product_id') . '&plan_id=' . Input::get('plan_id'), 'id' => 'formCheckout', 'class' => 'payment-form', 'style' => 'padding-bottom: 20px']) }}
            {{ Form::hidden('senderHash', null, ['id' => 'senderHash']) }}
            {{ Form::hidden('price', $plan->price) }}
            
            {{ Form::model($userAccess->getPerson->getAddress()->first()) }}

            {{ Form::hidden('city_id', null, ['id' => 'city_id']) }}
            <div class="form-group m-0">
              {{ Form::label('name', 'Nome completo', ['class' => 'bmd-label-floating']) }}
              {{ Form::text('name', $userAccess->getPerson->name, ['class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off']) }}
            </div>
            <div class="form-group m-0">
              {{ Form::label('birthday', 'Data de Nascimento', ['class' => 'bmd-label-floating']) }}
              {{ Form::date('birthday', $userAccess->getPerson->birthday, ['class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off']) }}
            </div>
            <div class="form-group m-0">
              {{ Form::label('cep', 'CEP', ['class' => 'bmd-label-floating']) }}
              {{ Form::text('cep', $userAccess->cep, ['class' => 'form-control cep', 'required' => 'required']) }}
            </div>
            <div class="form-group m-0">
              {{ Form::label('address', 'Endereço', ['class' => 'bmd-label-floating']) }}
              {{ Form::text('address', $userAccess->address, ['class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off']) }}
            </div>
            <div class="form-group m-0">
              {{ Form::label('neighborhood', 'Bairro', ['class' => 'bmd-label-floating']) }}
              {{ Form::text('neighborhood', $userAccess->neighborhood, ['class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off']) }}
            </div>
            <div class="form-group m-0">
              {{ Form::label('number', 'Número', ['class' => 'bmd-label-floating']) }}
              {{ Form::text('number', $userAccess->number, ['class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off']) }}
            </div>
            <div class="form-group m-0">
              {{ Form::label('city', 'Cidade', ['class' => 'bmd-label-floating']) }}
              {{ Form::text('city', $userAccess->getCityAttribute, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
            <div class="form-group m-0">
              {{ Form::label('state', 'Estado', ['class' => 'bmd-label-floating']) }}
              {{ Form::text('state', $userAccess->getStateAttribute, ['class' => 'form-control', 'required' => 'required']) }}
            </div>

            <!-- Forma de Pagamento -->
            @if($plan->price > 0)
              <h4 class="text-white mt-4">Forma de pagamento</h4>
              <div class="payment-radio d-flex">
                <div class="radio mr-3">
                  <label>
                    <input type="radio" name="paymentMethod" id="credit_card" value="1" checked required>
                    Cartão
                  </label>
                </div>
                <div class="radio ml-3">
                  <label>
                    <input type="radio" name="paymentMethod" id="bank_slip" value="2" required>
                    Boleto
                  </label>
                </div>
              </div>
            @else
              <br />
            @endif
            <!-- Botão Continuar -->
            <button type="submit" class="btn btn-checkout btn-raised btn-block text-uppercase font-weight-bold p-3 m-0">Continuar</button>
          {{ Form::close() }}
        </div>
        
        <!-- Grid Seu Carrinho -->
        <div class="col-lg-4 order-1 order-lg-2 mb-4">
          <div class="card">
            <div class="card-body">
              <h4 class="mb-3">Seu carrinho</h4>
              <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between">
                  <div>
                    <h6 class="my-0">{{ $plan->plan }}</h6>
                    <small class="text-muted fw-5">{{ $plan->days }} dias de anúncio</small>
                  </div>
                  <span class="text-muted fw-5">{{ $plan->getPrice() }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <h6 class="my-0">Total</h6>
                  <strong>{{ $plan->getPrice() }}</strong>
                </li>
              </ul>
              <div class="payment-methods">
                <p class="pt-2 mb-2 fw-5">Opções de pagamento</p>
                <hr>
                <ul class="list-inline d-flex m-0">
                  <li class="mx-1 text-black">
                    <i class="fab fa-2x fa-cc-visa"></i>
                  </li>
                  <li class="mx-1 text-black">
                    <i class="fab fa-2x fa-cc-mastercard"></i>
                  </li>
                  <li class="mx-1 text-black">
                    <i class="fas fa-2x fa-barcode"></i>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
  <script src="{{ asset('js/popper.js') }}"></script>
  <script src="{{ asset('js/bootstrap-material-design.min.js') }}"></script>
  <!-- Jquery -->
  <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> -->
  <!-- Popper -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->
  <!-- Jquery Mask -->
  <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
  <!-- Sweet alert -->
  <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
  <!-- Checkout -->
  <script src="{{ asset('js/checkout.js') }}"></script>
  <!-- PagSeguro -->
  <script type="text/javascript" src="{{ PagSeguro::getUrl()['javascript'] }}"></script>
  <script>
    PagSeguroDirectPayment.setSessionId('{{ PagSeguro::startSession() }}'); //PagSeguroRecorrente tem um método identico, use o que preferir neste caso, não tem diferença.

    $(document).on('click', '.btn-checkout', function(e) {
      if($('input[name=paymentMethod]:checked').val() == '2') {
        e.preventDefault();
        $('#senderHash').val(PagSeguroDirectPayment.getSenderHash());
        $('#formCheckout').submit();
      }
    });
  </script>
  
</body>
</html>
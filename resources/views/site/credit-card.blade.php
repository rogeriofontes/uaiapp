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
  
  <!-- Material Design for Bootstrap fonts and icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
  <!-- Bootstrap Material Design -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap-material-design.min.css') }}">
  <!-- Credit Card CSS -->
  <link rel="stylesheet" href="{{ asset('css/credit-card.css') }}">
  <!-- Jquery Card CSS -->
  <link rel="stylesheet" href="{{ asset('css/card.css') }}">

  <script>
    var URL = "{{ url('/') }}";
  </script>
</head>
<body>
  <section class="credit-card d-flex align-items-center py-3">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-6 offset-lg-3">
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

          {{ Form::open(['url' => 'set-credit-card?api_token=' . Input::get('api_token') . '&product_id=' . Input::get('product_id') . '&plan_id=' . Input::get('plan_id'), 'id' => 'formCreditCard', 'class' => 'credit-card-form m-0']) }}
            {{ Form::hidden('senderHash', null, ['id' => 'senderHash']) }}
            {{ Form::hidden('creditCardToken', null, ['id' => 'creditCardToken']) }}
            <div class="form-group">
              <div class="card-wrapper"></div>
            </div>
            <div class="form-group m-0">
              <label for="number" class="bmd-label-floating">Número do cartão</label>
              <input type="text" id="card_number" required="required" name="number" class="form-control" value="{{ old('number') }}" autocomplete="off" onBlur="getBrand();">
            </div>
            <div class="form-group m-0">
              <label for="expiry" class="bmd-label-static">Data de validade</label>
              <div class="expiration-date d-flex">
                <input id="expiry_mm" type="tel" name="expiry_mm" class="form-control mr-3" value="{{ old('expiry_mm') }}" placeholder="MM" required="required" autocomplete="off">
                <span class="date-separator">/</span>
                <input id="expiry_aa" type="tel" name="expiry_aa" class="form-control ml-3" value="{{ old('expiry_aa') }}" placeholder="AAAA" required="required" autocomplete="off">
              </div>
            </div>
            <div class="form-group m-0">
              <label for="cvv" class="bmd-label-floating">CVC</label>
              <input type="text" id="cvv" name="cvc" class="form-control" value="{{ old('cvc') }}" required="required" autocomplete="off">
            </div>
            <div class="form-group m-0">
              <label for="name" class="bmd-label-floating">Títular do cartão</label>
              <input type="text" name="name" class="form-control" value="{{ old('name') }}" required="required" autocomplete="off">
            </div>
            <div class="form-group m-0">
              <label for="cpf_cnpj" class="bmd-label-static">CPF</label>
              <input type="text" name="cpf_cnpj" class="form-control cpf" cpf="{{ auth()->user()->getPerson->cpf_cnpj }}" value="{{ old('cpf_cnpj') }}" required="required" autocomplete="off">
            </div>
            @if(auth()->user()->getPerson->type_person == 'F')
              <div class="form-group pt-2">
                <div class="checkbox">
                  <label class="text-white">
                    <input type="checkbox" class="send-cpf"> Usar mesmo CPF do cadastro
                  </label>
                </div>
              </div>
            @else
              <br />
            @endif
            <button type="submit" class="btn btn-credit-card btn-raised btn-block text-uppercase font-weight-bold p-3 m-0">Continuar</button>
          {{ Form::close() }}
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
  <!-- Credit Card JS -->
  <script src="{{ asset('js/credit-card.js') }}"></script>
  <!-- PagSeguro -->
  <script type="text/javascript" src="{{ PagSeguro::getUrl()['javascript'] }}"></script>
  <script>
    PagSeguroDirectPayment.setSessionId('{{ PagSeguro::startSession() }}'); //PagSeguroRecorrente tem um método identico, use o que preferir neste caso, não tem diferença.
  </script>
  <!-- Singer Checkout -->
  <script src="{{ asset('js/singerCheckout.js') }}"></script>
  <!-- Card JS -->
  <script src="{{ asset('js/jquery.card.js') }}"></script>

  <script>
    $('.credit-card-form').card({
      container: '.card-wrapper',
      placeholders: {
        number: '•••• •••• •••• ••••',
        name: 'Nome Completo',
        expiry_mm: '••/••••',
        cvc: '•••'
      },
      messages: {
        monthYear: ''
      },
    });

    
    $('.send-cpf').on('click', function(){
      var isChecked = $('input[type=checkbox]:checked').length > 0;
      var input_cpf = $('.cpf');
      if(isChecked) {
        input_cpf.val(input_cpf.attr('cpf'));
      } else {
        input_cpf.val('');
      }
    });
  </script>
</body>
</html>
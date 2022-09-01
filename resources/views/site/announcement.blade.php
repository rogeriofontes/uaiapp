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
    <!-- Material Design for Bootstrap fonts and icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <!-- Bootstrap Material Design -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-material-design.min.css') }}">
    <!-- Announcement -->
    <link rel="stylesheet" href="{{ asset('css/announcement.css') }}">

    <script>
      var URL = "{{ url('/') }}";
    </script>
  </head>
  <body>
    <div class="announcement d-flex align-items-center">
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-6 offset-lg-3">
            @if(Session::has('error'))
              <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>OPS!</strong> Ocorreu algum erro ao salvar.
                @if (count($errors) > 0)
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                @endif
              </div>
            @endif
            @if(Session::has('success'))
              <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Sucesso!</strong> Registro criado com sucesso.
              </div>
            @endif

            {{ Form::open(['url' => 'set-announcement?api_token=' . \Input::get('api_token'), 'method' => 'POST', 'class' => 'form-announcement', 'files' => true]) }}
              <!-- Inputs Hidden -->
              {{ Form::hidden('type', 'A') }}
              {{ Form::hidden('status', '0') }}
              {{ Form::hidden('person_id', $userAccess->getPerson->id) }}
              <!-- Categoria -->
              <div class="form-group m-0">
                {{ Form::label('product_category_id', 'Categoria', ['class' => 'bmd-label-static']) }}
                {{ Form::select('product_category_id', $productCategories, null, ['class' => 'form-control type_person', 'placeholder' => 'Selecione', 'required' => 'required']) }}
              </div>
              <!-- Sub Categoria -->
              <div class="form-group m-0">
                {{ Form::label('product_sub_category_id', 'SubCategoria', ['class' => 'bmd-label-static']) }}
                <?php
                  if (old('product_category_id')) {
                    $productSubcategories = 'App\ProductSubCategory'::where('product_category_id', old('product_category_id'))->pluck('subcategory', 'id');
                    echo Form::select('product_sub_category_id', $productSubcategories, null, ['class' => 'form-control type_person', 'required' => 'required']);
                  } else {
                    echo Form::select('product_sub_category_id', [], null, ['class' => 'form-control type_person', 'required' => 'required', 'disabled' => 'disabled']);
                  }
                ?>
              </div>
              <!-- Nome -->
              <div class="form-group m-0">
                {{ Form::label('name', 'Nome', ['class' => 'bmd-label-floating']) }}
                {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off']) }}
              </div>
              <!-- Preço -->
              <div class="form-group m-0">
                {{ Form::label('price', 'Preço', ['class' => 'bmd-label-floating']) }}
                {{ Form::text('price', null, ['class' => 'form-control money2', 'inputMode' => 'numeric', 'required' => 'required', 'autocomplete' => 'off']) }}
              </div>
              <!-- Descrição -->
              <div class="form-group">
                {{ Form::label('content', 'Descrição', ['class' => 'bmd-label-floating']) }}
                {{ Form::textarea('content', null, ['class' => 'form-control', 'rows' => '2', 'required' => 'required', 'autocomplete' => 'off']) }}
              </div>
              <!-- Fotos -->
              <div class="form-group">
                {{ Form::label('image', ' Adicionar Foto(s)', ['class' => 'label-bordered']) }}
                {{ Form::file('image[]', ['class' => 'form-control', 'accept' => 'image/*', 'id' => 'image', 'multiple' => 'multiple']) }}
                <div class="file-name file-name-image"></div>
              </div>
              <!-- Video -->
              <div class="form-group">
                {{ Form::label('video', ' Adicionar Video', ['class' => 'label-bordered']) }}
                {{ Form::file('video', ['class' => 'form-control', 'accept' => 'video/*', 'id' => 'video']) }}
                <div class="file-name file-name-video"></div>
              </div>
              <div class="form-group m-0">
                <button type="submit" class="btn btn-raised btn-announcement btn-block text-uppercase font-weight-bold p-3 m-0">ANUNCIAR</button>
              </div>
            {{ Form::close() }}
          </div>
        </div>
      </div>
    </div>

    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap-material-design.min.js') }}"></script>
    <!-- Jquery -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> -->
    <!-- Popper -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->
    <!-- Mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script>
    <!-- Announcement JS -->
    <script src="{{ asset('js/announcement.js') }}"></script>
    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Validar imagens e vídeo -->
    <script>
      $('form').submit(function(event) {
        var video = $('#video').get(0).files;
        if (video.length > 0 && video[0].size > 10000000) {
          swal({
            title: 'Oops!',
            text: 'O tamanho do vídeo excede o limite de 10MB.',
            icon: 'error',
            button: 'Ok',
          });
          event.preventDefault();
        }
        
        var images = $('#image').get(0).files;
        for (var i = 0; i < images.length; i++){
          if (images[i].size > 5000000) {
            swal({
              title: 'Oops!',
              text: 'O tamanho da imagem ' + images[i].name + ' excede o limite de 5MB.',
              icon: 'error',
              button: 'Ok',
            });
            event.preventDefault();
            break;
          }
        }
      });
    </script>
  </body>
</html>
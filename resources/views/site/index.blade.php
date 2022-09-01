@extends('layouts.site')

@section('content')
<section class="free-download" id="free-download">
  <div class="container">
    <div class="row">
      <div class="col-lg-3">
        <div class="content">
          <h4>Baixe Grátis</h4>
          <a href="https://play.google.com/store/apps/details?id=br.com.agenciadw3.uaiapp" target="_blank" class="btn-google-play">
            <img src="{{ asset('img/landing/google-play.png') }}" alt="Google Play" class="img-fluid">
          </a>
          <a href="https://itunes.apple.com/us/app/uaiapp/id1404979079" target="_blank" class="btn-apple-store">
            <img src="{{ asset('img/landing/apple-store.png') }}" alt="Apple Store" class="img-fluid">
          </a>
        </div>
      </div>
    </div>
    <!-- About Title => 992px -->
    <div class="title title-about d-none d-lg-block wow fadeInUp" data-wow-duration="2s" data-wow-delay=".2s">
      <img src="{{ asset('img/landing/icon-about.png') }}" alt="Icone" class="img-fluid">
      <span>Sobre o aplicativo</span>
    </div>
    <!-- End About Title => 992px -->
  </div>
</section>

<section class="section-one" id="section-one">
  <!-- About Title <= 991px -->
  <div class="d-block d-lg-none">
    <div class="container">
      <div class="title title-about wow fadeInUp" data-wow-duration="2s" data-wow-delay=".2s">
        <img src="{{ asset('img/landing/icon-about.png') }}" alt="Icone" class="img-fluid">
        <span>Sobre o aplicativo</span>
      </div>
    </div>
  </div>
  <!-- End About Title <= 991px -->
  <div class="container-fluid">
    <!-- About -->
    <div class="about">
      <div class="row">
        <div class="col-lg-6">
          <div class="background-1 wow fadeInUp" data-wow-duration="2s" data-wow-delay=".4s">
            <img src="{{ asset('img/landing/about.png')}}" alt="Sobre o App" class="img-fluid">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="content wow fadeInUp" data-wow-duration="2s" data-wow-delay=".4s">
            <p class="text-center">Criado nas versões IOS e Android, o UAI APP chegou para facilitar o mercado de produtos agropecuários diretamente do empresário rural. Com funções simples você pode negociar produtos do campo como: máquinas agrícolas, insumos agrícolas, gados, grãos, equipamentos novos e usados.</p>
            <p class="text-center">Além de ter acesso a notícias do mercado, o aplicativo veio para preencher um espaço que existe a muito tempo, agora com a tecnologia ficará mais fácil comprar e vender em todo Brasil.</p>
          </div>
        </div>
      </div>
    </div>
    <!-- Functions -->
    <div class="functions" id="functions">
      <div class="title title-functions wow fadeInUp" data-wow-duration="2s" data-wow-delay=".2s">
        <img src="{{ asset('img/landing/icon-role.png') }}" alt="Icone Funções" class="img-fluid">
        <span>Funções do App</span>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="background-2 wow fadeInUp" data-wow-duration="2s" data-wow-delay=".4s">
            <img src="{{ asset('img/landing/iphone-x.png')}}" alt="Iphone X" class="img-fluid">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="row content">
            <div class="col-md-6 col-lg-12 col-xl-6 flex-item wow fadeInUp" data-wow-duration="2s" data-wow-delay=".1s">
              <img src="{{ asset('img/landing/1.png')}}" alt="Gados" class="img-fluid">
              <span>Gostaria de vender ou comprar cabeças de gado? Utilize esta função!</span>
            </div>
            <div class="col-md-6 col-lg-12 col-xl-6 flex-item wow fadeInUp" data-wow-duration="2s" data-wow-delay=".2s">
              <img src="{{ asset('img/landing/2.png')}}" alt="Máquinas Agrícolas" class="img-fluid">
              <span>Gostaria de vender ou comprar máquinas agrícolas? Utilize esta função!</span>
            </div>
            <div class="col-md-6 col-lg-12 col-xl-6 flex-item wow fadeInUp" data-wow-duration="2s" data-wow-delay=".3s">
              <img src="{{ asset('img/landing/3.png')}}" alt="Insumos Agrícolas" class="img-fluid">
              <span>Gostaria de vender ou comprar insumos agrícolas? Utilize esta função!</span>
            </div>
            <div class="col-md-6 col-lg-12 col-xl-6 flex-item wow fadeInUp" data-wow-duration="2s" data-wow-delay=".4s">
              <img src="{{ asset('img/landing/4.png')}}" alt="Grãos" class="img-fluid">
              <span>Gostaria de vender ou comprar milho e soja? Utilize esta função!</span>
            </div>
            <div class="col-md-6 col-lg-12 col-xl-6 flex-item wow fadeInUp" data-wow-duration="2s" data-wow-delay=".5s">
              <img src="{{ asset('img/landing/5.png')}}" alt="Serviços" class="img-fluid">
              <span>Aqui você também pode contratar serviços diversos e essenciais para sua propriedade rural como: aluguel de máquinas, consultoria veterinária, análises de solos, etc... </span>
            </div>
            <div class="col-md-6 col-lg-12 col-xl-6 flex-item wow fadeInUp" data-wow-duration="2s" data-wow-delay=".6s">
              <img src="{{ asset('img/landing/6.png')}}" alt="Parceiros" class="img-fluid">
              <span>Você tem uma loja de materiais agrícolas e gostaria de se tornar um parceiro? Anuncie sua loja aqui!</span>
            </div>
            <div class="col-md-6 col-lg-12 col-xl-6 flex-item wow fadeInUp" data-wow-duration="2s" data-wow-delay=".7s">
              <img src="{{ asset('img/landing/7.png')}}" alt="Propriedade Rural" class="img-fluid">
              <span>Procura por uma propriedade rural para comprar, locar ou arrendar? Utilize esta função!</span>
            </div>
            <div class="col-md-6 col-lg-12 col-xl-6 flex-item wow fadeInUp" data-wow-duration="2s" data-wow-delay=".8s">
              <img src="{{ asset('img/landing/8.png')}}" alt="Transportadora" class="img-fluid">
              <span>Procura por uma transportadora confiável para transporte de seu produto? Utilize esta função!</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="versions" id="versions">
  <div class="container">
    <div class="title title-versions wow fadeInUp" data-wow-duration="2s" data-wow-delay=".2s">
      <img src="{{ asset('img/landing/icon-about.png') }}" alt="Icone Versões" class="img-fluid">
      <span>Versões do Aplicativo</span>
    </div>
    <div class="row content">
      <div class="col-lg-6 wow fadeInUp" data-wow-duration="2s" data-wow-delay=".4s">
        <img src="{{ asset('img/landing/versions.png')}}" alt="Versões" class="img-fluid">
      </div>
      <div class="col-lg-6 buttons">
        <a href="https://itunes.apple.com/us/app/uaiapp/id1404979079" target="_blank" class="btn-apple-store">
          <img src="{{ asset('img/landing/apple-store.png') }}" alt="Apple Store" class="img-fluid wow fadeInUp" data-wow-duration="2s" data-wow-delay=".4s">
        </a>
        <a href="https://play.google.com/store/apps/details?id=br.com.agenciadw3.uaiapp" target="_blank" class="btn-google-play">
          <img src="{{ asset('img/landing/google-play.png') }}" alt="Google Play" class="img-fluid wow fadeInUp" data-wow-duration="2s" data-wow-delay=".4s">
        </a>
      </div>
    </div>
  </div>
</section>

<section class="team">
  <div class="container">
    <div class="title title-team wow fadeInUp" data-wow-duration="2s" data-wow-delay=".2s">
      <img src="{{ asset('img/landing/icon-team.png') }}" alt="Icone Time" class="img-fluid">
      <span>Equipe</span>
    </div>
    <div class="row content">
      <div class="col-lg-10 offset-lg-1">
        <div class="row">
          <div class="col-md-6 py-3 profile wow fadeInUp" data-wow-duration="2s" data-wow-delay=".3s">
            <img src="{{ asset('img/landing/rodrigo.png') }}" alt="Rodrigo" class="img-fluid">
            <span>Rodrigo Heitor</span>
            <span class="m-0"><small><i class="fab fa-whatsapp"></i> (34) 99125-2731</small></span>
          </div>
          <div class="col-md-6 py-3 profile wow fadeInUp" data-wow-duration="2s" data-wow-delay=".6s">
            <img src="{{ asset('img/landing/hebert.png') }}" alt="Hebert" class="img-fluid">
            <span>Hebert Ferreira</span>
            <span class="m-0"><small><i class="fab fa-whatsapp"></i> (34) 99974-3503</small></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
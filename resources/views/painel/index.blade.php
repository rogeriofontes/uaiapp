@extends('layouts.app')

@section('title', 'Main page')

@section('content')
  <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="text-center m-t-lg">
          <h1>
            Bem vindo ao Dashboard
          </h1>
          <small>
            Aqui você pode gerenciar todo seu aplicativo.
          </small>
        </div>
      </div>

      <div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 m-t-xl">
        <div class="row">
          <div class="col-sm-12">
            <a href="{{ url('painel/interests') }}">
              <div class="widget red-bg p-lg text-center">
                <div class="m-b-md">
                  <i class="fa fa-bell fa-4x"></i>
                  <h1 class="m-xs">{{ $interests }}</h1>
                  <h3 class="font-bold no-margins">
                    Interesses
                  </h3>
                  <small>Interesses em negociação</small>
                </div>
              </div>
            </a>
          </div>

          <div class="col-sm-6">
            <div class="widget lazur-bg p-lg text-center">
              <div class="m-b-md">
                <i class="fa fa-users fa-4x"></i>
                <h1 class="m-xs">{{ $usersApp }}</h1>
                <h3 class="font-bold no-margins">
                  Usuários
                </h3>
                <small>Usuários cadastrados através do app</small>
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="widget navy-bg p-lg text-center">
              <div class="m-b-md">
                <i class="fa fa-cubes fa-4x"></i>
                <h1 class="m-xs">{{ $productsApp }}</h1>
                <h3 class="font-bold no-margins">
                  Produtos
                </h3>
                <small>Produtos cadastrados através do app</small>
              </div>
            </div>
          </div>
        </div>
      </div>
          
      
    </div>
  </div>
@endsection

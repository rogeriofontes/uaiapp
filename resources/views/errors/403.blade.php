@extends('layouts.app')

@section('title', 'Main page')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="middle-box text-center animated fadeInDown">
                            <h1>403</h1>
                            <h3 class="font-bold">=(</h3>

                            <div class="error-desc">
                                Ops, você não tem permissão para acessar esse link, caso precisa realmente contact o administrador do sistema.
                                <br/>
                                <a href="javascript:history.back()" class="btn btn-primary m-t">Voltar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

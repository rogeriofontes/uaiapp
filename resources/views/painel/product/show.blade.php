@extends('layouts.app')

@section('css')
@endsection

@section('title',  $title)

@section('content')

@include('layouts.breadcrumb')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="tabs-container">

                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-info" class="tab-info" aria-expanded="true"> <i class="fa fa-info"></i> Dados</a></li>
                        <li><a data-toggle="tab" href="#tab-interests" class="tab-interests" aria-expanded="false"><i class="fa fa-user"></i> Interessados</a></li>
                    </ul>
                        
                    <div class="tab-content">
                        <div id="tab-info" class="tab-pane active">
                            <div class="panel-body">

                            
                                {{ Form::open(['method'=>'PUT', 'route'=>['products.update', $product->id], 'class'=>'form-inline']) }}
                                    {{ Form::hidden('update_status', 1) }}
                                @if($product->status == '0')
                                    {{ Form::hidden('status', 1) }}
                                    <button title="Desbloquear" data-toggle="tooltip" data-placement="top" type="submit" class="btn-warning btn btn-xs"> <i class="fa fa-lock"></i></button>
                                @else
                                    {{ Form::hidden('status', 0) }}
                                    <button title="Bloquear" data-toggle="tooltip" data-placement="top" type="submit" class="btn-warning btn btn-xs"> <i class="fa fa-unlock"></i></button>
                                @endif
                                {{ Form::close() }}

                                <div class="row">
                                    <div class="col-xs-12 mb-2">
                                        <span class="item"><label>Nome</label>
                                            {{ $product->name }}
                                        </span>
                                        <br />
                                        <span class="item"><label>Categoria</label>
                                            {{ $product->getProductSubCategory->getProductCategory->category }}
                                        </span>
                                        <br />
                                        <span class="item"><label>Sub Categoria</label>
                                            {{ $product->getProductSubCategory->subcategory  }}
                                        </span>
                                        <br />
                                        <span class="item"><label>Preço</label>
                                            R$ {{ number_format($product->price, 2, ',', '.') }}
                                        </span>
                                        <br />
                                        <span class="item"><label>Usuário</label>
                                            @if($product->type == 'L')
                                                <a href="{{ route('store.edit', $product->getPerson->getStore->id) }}">
                                                    {{ $product->getPerson->name }}
                                                </a>
                                            @else
                                                <a href="{{ route('users-app.show', $product->getPerson->getUserApp->id) }}">
                                                    {{ $product->getPerson->name }}
                                                </a>
                                            @endif
                                        </span>
                                        <br />
                                        <span class="item"><label>Descrição</label>
                                                {{ $product->content }}
                                        </span>
                                        <hr />

                                        <span class="item"><label>Fotos</label></span>
                                        <div class="row">
                                            @if(count($product->getMedias))
                                                @foreach($product->getMedias as $media)
                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <img src="{{ Storage::disk('public')->url($media->getMedia->path) }}" class="img-responsive" />
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="col-sm-12 text-center">
                                                    <img src="{{ asset('img/image_not_found.jpg') }}" style="max-width:200px;" class="m-b">
                                                    <p class=" text-muted">Produto sem imagens.</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                                    
                        </div>

                        <div id="tab-interests" class="tab-pane">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td>Nome</td><td>Status</td><td>Ações</td>
                                        </td>
                                    </thead>

                                    @foreach($product->getProductHasInterest as $interest)
                                        <tr>
                                            <td>{{ $interest->getUserApp->getPerson->name }}</td>
                                            <td><span class="td-status">{{ $interest->getStatus() }}</span></td>
                                            <td>
                                                <div class="d-i-flex">
                                                    <a title="Visualizar Usuário" data-toggle="tooltip" data-placement="top" href="{{ route('users-app.show', $interest->user_app_id) }}" class="btn-success btn btn-xs"> <i class="fa fa-eye fa-fw"></i></a>
                                                    @if($interest->status == '0')
                                                        <a title="Vendido" data-toggle="tooltip" data-placement="top" href="#" class="btn-warning btn btn-xs m-l-xs update-interest-status" product-has-interest-id="{{ $interest->id }}" status="1"> <i class="fa fa-dollar fa-fw"></i></a>
                                                        <a title="Cancelado" data-toggle="tooltip" data-placement="top" href="#" class="btn-danger btn btn-xs m-l-xs update-interest-status" product-has-interest-id="{{ $interest->id }}" status="2"> <i class="fa fa-ban fa-fw"></i></a>
                                                    @elseif($interest->status == '1')                                                    
                                                        <a title="Cancelado" data-toggle="tooltip" data-placement="top" href="#" class="btn-danger btn btn-xs m-l-xs update-interest-status" product-has-interest-id="{{ $interest->id }}" status="2"> <i class="fa fa-ban fa-fw"></i></a>
                                                        <a title="Negociando" data-toggle="tooltip" data-placement="top" href="#" class="btn-primary btn btn-xs m-l-xs update-interest-status" product-has-interest-id="{{ $interest->id }}" status="0"> <i class="fa fa-briefcase fa-fw"></i></a>
                                                    @else
                                                        <a title="Vendido" data-toggle="tooltip" data-placement="top" href="#" class="btn-warning btn btn-xs m-l-xs update-interest-status" product-has-interest-id="{{ $interest->id }}" status="1"> <i class="fa fa-dollar fa-fw"></i></a>
                                                        <a title="Negociando" data-toggle="tooltip" data-placement="top" href="#" class="btn-primary btn btn-xs m-l-xs update-interest-status" product-has-interest-id="{{ $interest->id }}" status="0"> <i class="fa fa-briefcase fa-fw"></i></a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tfoot>
                                        <tr>
                                            <td>Nome</td><td>Status</td><td>Ações</td>
                                        </tr>
                                 </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="panel-body">
                            <a class="btn btn-success mb-2" href="{{ url('painel/products') }}" role="button">Voltar</a>   
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
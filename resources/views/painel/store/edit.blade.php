@extends('layouts.app')

@section('css')
    <!-- Sweet Alert -->
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <!-- Dropzone CSS -->
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
@endsection

@section('title',  $title)

@section('content')

@include('layouts.breadcrumb')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">

            @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible bg-danger" role="alert">
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
                <div class="alert alert-success alert-dismissible bg-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Sucesso!</strong> Registro alterado com sucesso.
                </div>
            @endif

            <div class="col-xs-12">
                <div class="tabs-container">

                    <ul class="nav nav-tabs">
                        <li class="@if(\Request::input('tab') == 1 || \Request::input('tab') == null) active @endif"><a data-toggle="tab" href="#tab-info" class="tab-info" aria-expanded="true"> <i class="fa fa-info"></i> Dados</a></li>
                        <li class="@if(\Request::input('tab') == 2) active @endif"><a data-toggle="tab" href="#tab-address" class="tab-address" aria-expanded="false"><i class="fa fa-map"></i> Endereço</a></li>
                    </ul>

                    {!! Form::model($data, ['method' => 'PATCH','route' => [$routeFather .'.update', $data->id], 'class' => 'form-horizontal', 'files' => true, 'autocomplete' => 'off'] ) !!}
                        <div class="tab-content">
                        
                            <!-- TAB INFO -->
                            <div id="tab-info" class="tab-pane @if(\Request::input('tab') == 1 || \Request::input('tab') == null) active @endif">
                                <div class="panel-body">
                                    <!-- Nome -->
                                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                                        {{ Form::label('name', 'Nome', ['class' => 'col-sm-2 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('name', $data->getPerson->name, ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <!-- Tipo do Cadastro da Pessoa -->
                                    <div class="form-group @if ($errors->has('type_person')) has-error @endif">
                                        {{ Form::label('type_person', 'Tipo de Pessoa', ['class' => 'col-sm-2 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::select('type_person', ['F' => 'Física', 'J' => 'Jurídica'], $data->getPerson->type_person, ['class' => 'form-control type_person', 'placeholder' => 'Selecione']) }}
                                        </div>
                                    </div>
                                    <!-- CPF/CNPJ -->
                                    <div class="form-group @if ($errors->has('cpf_cnpj')) has-error @endif">
                                        {{ Form::label('cpf_cnpj', 'CPF/CNPJ', ['class' => 'col-sm-2 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('cpf_cnpj', $data->getPerson->cpf_cnpj, ['class' => 'form-control cpf_cnpj']) }}
                                        </div>
                                    </div>
                                    <!-- Inscrição Estadual -->
                                    <div class="form-group @if ($errors->has('ie')) has-error @endif">
                                        {{ Form::label('ie', 'Inscrição Estadual', ['class' => 'col-sm-2 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('ie', $data->getPerson->ie, ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <!-- Email -->
                                    <div class="form-group @if ($errors->has('email')) has-error @endif">
                                        {{ Form::label('email', 'E-mail', ['class' => 'col-sm-2 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::email('email', $data->getPerson->getUser->email, ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <!-- Telefone -->
                                    <div class="form-group @if ($errors->has('phone')) has-error @endif">
                                        {{ Form::label('phone', 'Telefone', ['class' => 'col-sm-2 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('phone', $data->getPerson->getUser->phone, ['class' => 'form-control phones']) }}
                                        </div>
                                    </div>
                                    <!-- Imagem -->
                                    <div class="form-group @if ($errors->has('media_id')) has-error @endif">
                                        {{ Form::label('media_id', 'Imagem', ['class' => 'col-sm-2 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::file('media_id', ['class' => 'form-control', 'accept' => 'image/*']) }}
                                        </div>
                                    </div>
                                    <!-- Imagem Atual -->
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-8">
                                            <img src="{{ Storage::disk('public')->url($data->getPerson->getMedia->path) }}" class="img-responsive" />
                                        </div>
                                    </div>
                                    <!-- Buttons -->
                                    <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <div class="btn-inline">
                                                <div class="btn-left">
                                                    <a data-toggle="tab" class="btn btn-info to-tab-address" aria-expanded="false">Próximo</a>
                                                </div>
                                                <div class="btn-right">
                                                    <a href="{{ route($routeFather. '.index') }}" class="btn btn-white" type="submit">Cancelar</a>
                                                    <button type="submit" class="btn btn-success">Salvar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB ENDEREÇOS -->
                            <div id="tab-address" class="tab-pane @if(\Request::input('tab') == 2) active @endif">
                                <div class="panel-body">
                                    <!-- CEP -->
                                    <div class="form-group @if ($errors->has('cep')) has-error @endif">
                                        {{ Form::label('cep', 'CEP', ['class' => 'col-sm-2 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('cep', $data->getPerson->getAddress->cep, ['class' => 'form-control cep']) }}
                                        </div>
                                    </div>
                                    <!-- Endereço -->
                                    <div class="form-group @if ($errors->has('address')) has-error @endif">
                                        {{ Form::label('address', 'Endereço', ['class' => 'col-sm-2 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('address', $data->getPerson->getAddress->address, ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <!-- Número -->
                                    <div class="form-group @if ($errors->has('number')) has-error @endif">
                                        {{ Form::label('number', 'Número', ['class' => 'col-sm-2 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('number', $data->getPerson->getAddress->number, ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <!-- Complemento -->
                                    <div class="form-group @if ($errors->has('complement')) has-error @endif">
                                        {{ Form::label('complement', 'Complemento', ['class' => 'col-sm-2 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('complement', $data->getPerson->getAddress->complement, ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <!-- Bairro -->
                                    <div class="form-group @if ($errors->has('neighborhood')) has-error @endif">
                                        {{ Form::label('neighborhood', 'Bairro', ['class' => 'col-sm-2 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('neighborhood', $data->getPerson->getAddress->neighborhood, ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <!-- Cidade -->
                                    <div class="form-group @if ($errors->has('city_id')) has-error @endif">
                                        {{ Form::label('city', 'Cidade', ['class' => 'col-sm-2 control-label' ]) }}
                                        <div class="col-sm-8">
                                            {{ Form::hidden('city_id', $data->getPerson->getAddress->getCity->id, ['id' => 'city_id']) }}
                                            {{ Form::text('city', $data->getPerson->getAddress->getCity->city, ['class' => 'form-control', 'placeholder' => 'Selecione' , 'readonly' => 'readonly']) }}
                                        </div>
                                    </div>
                                    <!-- Estado -->
                                    <div class="form-group @if ($errors->has('state_id')) has-error @endif">
                                        {{ Form::label('state', 'Estado', ['class' => 'col-sm-2 control-label' ]) }}
                                        <div class="col-sm-8">
                                            {{ Form::hidden('state_id', $data->getPerson->getAddress->getCity->getState->id, ['id' => 'state_id']) }}
                                            {{ Form::text('state', $data->getPerson->getAddress->getCity->getState->state, ['class' => 'form-control', 'placeholder' => 'Selecione' , 'readonly' => 'readonly']) }}
                                        </div>
                                    </div>
                                    <!-- Maps -->
                                    {{ Form::hidden('latitude', str_replace(',', '.', $data->getPerson->getAddress->latitude), ['id' => 'latitude']) }}
                                    {{ Form::hidden('longitude', str_replace(',', '.', $data->getPerson->getAddress->longitude), ['id' => 'longitude']) }}
                                    <div class="form-group">
                                        <label for="mapa" class="control-label col-sm-2">Mapa</label>
                                        <div class="col-sm-8">
                                            <div id="mapa" class="form-control" style="width: 100%; height: 300px;"></div>
                                        </div>
                                    </div>
                                    <!-- Buttons -->
                                    <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <div class="btn-inline">
                                                <div class="btn-left">
                                                    <a data-toggle="tab" class="btn btn-warning to-tab-info" aria-expanded="false">Anterior</a>
                                                </div>
                                                <div class="btn-right">
                                                    <a href="{{ route($routeFather. '.index') }}" class="btn btn-white" type="submit">Cancelar</a>
                                                    <button type="submit" class="btn btn-success">Salvar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>                            
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Google Maps -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeFP_-njYJOtecli02Re12_LSDAJadqWA&amp;"></script>
    <!-- Sweet alert -->
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <!-- Company JS -->
    <script src="{!! asset('js/company.js') !!}" type="text/javascript"></script>
    <script>
        showMaps();
    </script>
@endsection
@extends('layouts.app')

@section('css')
    <!-- Sweet Alert -->
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
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
                    <strong>Sucesso!</strong> Registro criado com sucesso.
                </div>
            @endif

            {{ Form::open(['url' => route($routeFather . '.store'), 'class' => 'form-horizontal', 'files' => true, 'autocomplete' => 'off']) }}
                <div class="col-xs-12">
                    <!-- Tipo -->
                    {{ Form::hidden('type', 'L') }}
                    <!-- Empresa -->
                    <div class="form-group @if ($errors->has('person_id')) has-error @endif">
                        {{ Form::label('person_id', 'Empresa', ['class' => 'col-sm-2 control-label']) }}
                        <div class="col-sm-8">
                            {{ Form::select('person_id', $stores, null, ['class' => 'form-control type_person', 'placeholder' => 'Selecione', 'required' => 'required']) }}
                        </div>
                    </div>
                    <!-- Status -->
                    <div class="form-group @if ($errors->has('status')) has-error @endif">
                        {{ Form::label('status', 'Status', ['class' => 'col-sm-2 control-label']) }}
                        <div class="col-sm-8">
                            {{ Form::select('status', ['0' => 'Inativo', '1' => 'Ativo'], null, ['class' => 'form-control type_person', 'placeholder' => 'Selecione', 'required' => 'required']) }}
                        </div>
                    </div>
                    <!-- Nome -->
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        {{ Form::label('name', 'Nome', ['class' => 'col-sm-2 control-label']) }}
                        <div class="col-sm-8">
                            {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) }}
                        </div>
                    </div>
                    <!-- Categoria -->
                    <div class="form-group @if ($errors->has('product_category_id')) has-error @endif">
                        {{ Form::label('product_category_id', 'Categoria', ['class' => 'col-sm-2 control-label']) }}
                        <div class="col-sm-8">
                            {{ Form::select('product_category_id', $productCategories, null, ['class' => 'form-control type_person', 'placeholder' => 'Selecione', 'required' => 'required']) }}
                        </div>
                    </div>
                    <!-- Subcategoria -->
                    <div class="form-group @if ($errors->has('product_sub_category_id')) has-error @endif">
                        {{ Form::label('product_sub_category_id', 'Subcategoria', ['class' => 'col-sm-2 control-label']) }}
                        <div class="col-sm-8">
                            <?php
                                if (old('product_category_id')) {
                                    $productSubcategories = 'App\ProductSubCategory'::where('product_category_id', old('product_category_id'))->pluck('subcategory', 'id');
                                    echo Form::select('product_sub_category_id', $productSubcategories, null, ['class' => 'form-control type_person', 'placeholder' => 'Selecione', 'required' => 'required']);
                                } else {
                                    echo Form::select('product_sub_category_id', [], null, ['class' => 'form-control type_person', 'placeholder' => 'Selecione', 'required' => 'required', 'disabled' => 'disabled']);
                                }
                            ?>
                        </div>
                    </div>
                    <!-- Preço -->
                    <div class="form-group @if ($errors->has('price')) has-error @endif">
                        {{ Form::label('price', 'Preço', ['class' => 'col-sm-2 control-label']) }}
                        <div class="col-sm-8">
                            {{ Form::text('price', null, ['class' => 'form-control money2', 'required' => 'required']) }}
                        </div>
                    </div>
                    <!-- Descrição -->
                    <div class="form-group @if ($errors->has('content')) has-error @endif">
                        {{ Form::label('content', 'Descrição', ['class' => 'col-sm-2 control-label']) }}
                        <div class="col-sm-8">
                            {{ Form::textarea('content', null, ['class' => 'form-control', 'required' => 'required']) }}
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="btn-inline">
                                <div class="btn-right">
                                    <a href="{{ route($routeFather. '.index') }}" class="btn btn-white" type="submit">Cancelar</a>
                                    <button type="submit" name="submit" class="btn btn-success">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                            
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Sweet alert -->
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection
@extends('layouts.app')

@section('css')
<?php echo $css ?>
@endsection

@section('title',  $title)

@section('content')

    @include('layouts.breadcrumb')

    <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
               
                <div class="col-lg-12">
                <div class="ibox float-e-margins">   
                                 
                    <div class="ibox-content">

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
                        @foreach($fillables as $property)
                            <div class="form-group @if ($errors->has($property)) has-error @endif">
                                <?php
                                    echo Form::label($property, ucwords($labels[$property]), ['class' => 'col-sm-2 control-label']);
                                    echo ' <div class="col-sm-8">';
                                    switch ($property){
                                        case 'email':                                 
                                            echo Form::email($property, null, ['class' => 'form-control']);
                                            break;
                                        case 'birthday':
                                            echo Form::date($property, null, ['class' => 'form-control']);
                                            break;
                                        case 'date':
                                            echo Form::date($property, null, ['class' => 'form-control']);
                                            break;
                                        case 'password':
                                            echo Form::password($property, ['class' => 'form-control']);
                                            break;
                                        case 'media_id':
                                            echo Form::file($property, ['class' => 'form-control']);
                                            break;
                                        case 'salary':
                                            echo Form::text($property, null, ['class' => 'form-control']);
                                            break;
                                        case 'start_hiring':
                                            echo Form::date($property, null, ['class' => 'form-control']);
                                            break;
                                        case 'stop_hiring':
                                            echo Form::date($property, null, ['class' => 'form-control']);
                                            break;
                                        case 'content':
                                            echo Form::textarea($property, null, ['class' => 'form-control', 'rows' => '5']);
                                            break;
                                        case 'phone':
                                            echo Form::text($property, null, ['class' => 'form-control phones']);
                                            break;
                                        case 'days':
                                            echo Form::number($property, null, ['class' => 'form-control', 'min' => '1']);
                                            break;
                                        case 'price':
                                            echo Form::text($property, null, ['class' => 'form-control money']);
                                            break;
                                        default:
                                            echo Form::text($property, null, ['class' => 'form-control']);
                                            break;
                                    }
                                    echo '</div>';
                                ?>
                            </div>
                        @endforeach

                        @foreach ($fillablesSelects as $key => $select)
                            <div class="form-group @if ($errors->has($select['name'])) has-error @endif">
                                <?php
                                    echo Form::label($select['name'], ucwords($key), ['class' => 'col-sm-2 control-label']);
                                    echo ' <div class="col-sm-8">';
                                        echo Form::select($select['name'], $select['values'], null, ['class' => 'form-control', 'placeholder' => 'Selecione']);
                                    echo '</div>';
                                ?>
                             </div>
                        @endforeach

                        <?php echo $otherElements ?>

                        @if($gallery)

                        @endif

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a href="{{ route($routeFather. '.index') }}" class="btn btn-white" type="submit">Cancelar</a>
                                <button class="btn btn-success" value="" name="submit" type="submit">Cadastrar</button>
                                <button class="btn btn-info" value="close" name="submit" type="submit">Cadastrar e Fechar</button>
                            </div>
                        </div>
                            
                    {{ Form::close() }}   
                    </div>
                </div>
            </div>
            </div>
        </div>
@endsection

@section('scripts')
<script>
<?php echo $scripts ?>
</script>
@endsection
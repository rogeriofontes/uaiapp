@extends('layouts.app')

@section('css')
<?php echo $css ?>
@endsection

@section('title',  $title)

@section('content')

    @include('layouts.breadcrumb')

    <div class="wrapper wrapper-content animated fadeInRight visualize">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row">
                    <!-- Comprador -->
                    <div class="col-xs-12">
                        <h1>Usuário</h1>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 mb-2">
                                <span class="item"><label>Nome</label>
                                        {{ $userApp->getPerson->name }}
                                </span>
                                <br />
                                <span class="item"><label>Telefone</label>
                                        {{ $userApp->getPerson->getUser->phone }}
                                </span>
                                <br />
                                <span class="item"><label>Email</label>
                                        {{ $userApp->getPerson->getUser->email }}
                                </span>
                                <br />
                                <span class="item"><label>Tipo de Pessoa</label>
                                        {{ $userApp->getPerson->getType() }}
                                </span>
                                <br />
                                <span class="item"><label>CPF</label>
                                        {{ $userApp->getPerson->cpf_cnpj }}
                                </span>
                                <br />
                                <span class="item"><label>IE</label>
                                        {{ $userApp->getPerson->ie }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Comprador; Fim; -->

                </div>
                <a class="btn btn-success mb-2" href="{{ url('painel/users-app') }}" role="button">Voltar</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
<?php echo $scripts ?>
</script>
@endsection
@extends('layouts.app')

@section('css')
    <!-- dataTable -->
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <style>
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active {
            color: #fff!important;
            background-color: #286090!important;
            border-color: #204d74!important;
        }
    </style>
@endsection

@section('title',  $title)

@section('content')

    @include('layouts.breadcrumb')

    <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
               
                <div class="col-lg-12">
                <div class="ibox float-e-margins">   
                                 
                    <div class="ibox-content">

                    <button class="btn btn-outline btn-success dim" data-toggle="tooltip" data-placement="top" title="Adicionar Registro" onclick="location.href='{{ route($routeFather . '.create') }}'">
                      <i class="fa fa-plus"></i>   Adicionar
                    </button>
                    <hr />

                        <div class="table-responsive">
                             <table class="table table-striped table-bordered table-hover dataTables" >
                                <thead>
                                    <tr>
                                        @foreach($collumns as $collumn)
                                            <th>{{ $collumn }}</th>
                                        @endforeach
                                     </tr>
                                 </thead>

                                <tfoot>
                                    <tr>
                                        @foreach($collumns as $collumn)
                                            <th>{{ $collumn }}</th>
                                        @endforeach
                                     </tr>
                                 </tfoot>
                             </table>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
@endsection

@section('scripts')
 <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
 
 <!-- Sweet alert -->
 <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

 <!-- Page-Level Scripts -->
    <script>

        $(document).on('click', '.btn-del', function(){
            var obj = $(this);
            swal({
                title: "Você tem certeza?",
                text: "Ao deletar esse arquivo, ele ainda permanecesse por 30 dias na base de dados, até ser deletado completamente.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, deletar!",
                cancelButtonText: "Não, cancele por favor!",
                closeOnConfirm: false,
                closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                        type: 'DELETE',
                        dataType: 'JSON',
                        url:  obj.find('.form-delete').attr('action'),
                        data:{},
                        success: function(data){
                            if(data){
                                swal("Deletado!", "Seu registro foi deletado com sucesso.", "success");
                                if(data.ids){
                                    var table = obj.parents('table');                                                                        
                                }else{
                                    obj.parents('tr').remove();
                                }
                            }else{
                                swal("Error", "Ops, ocorreu um erro ao excluir. :(", "error");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            if(jqXHR.status == 403){
                                swal("Error", "Você não tem permissão para excluir. :(", "error");
                            }
                        }
                        });                        
                    } else {
                        swal("Cancelado", "Você cancelou deletar o registro :)", "error");
                    }
                });
            });
            

        $(document).ready(function(){           
            $('.dataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route($routeFather . '.index') }}",
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ itens por página",
                    "zeroRecords": "Nenhum dado cadastrado.",
                    "info": "Mostrando página _PAGE_ de _PAGES_ no total de _TOTAL_ linhas.",
                    "infoEmpty": "Nenhuma linha disponível",
                    "infoFiltered": "(Filtrando de _MAX_ linhas)",
                    "search":         "Pesquisar:",
                    "paginate": {
                        "first":      "Primeira",
                        "last":       "Última",
                        "next":       "Próxima",
                        "previous":   "Anterior"
                    },
                }     
            });

        });

    </script>
@endsection
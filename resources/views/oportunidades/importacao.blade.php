@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div class="card">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page"><strong>Importação Oportunidades</strong></li>
            </ol>
        </nav>
        <div>
            @if(!empty($successMsg))
                <div id="msg" class="alert alert-success"> {{ $successMsg }}</div>
            @endif
            @if(!empty($errorMsg))
                <div id="msg" class="alert alert-danger"> {{ $errorMsg }}</div>
            @endif
        </div>
        <div id="registros">
            <form method="POST" id="formImportar" action="{{route('importarxls')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row justify-content-end">
                    <label class="col-sm-2 col-form-label">Arquivo:</label>
                    <div class="col-sm-9">
                        <input type="file" required name="planilhaexcel" class="form-control" id="planilhaexcel">
                    </div>
                    <div class="col-sm-1" style="top: 15px;">
                        <button type="submit" id="btnSubmit" 
                            class="btn btn-secondary fa fa-upload nav-icon" 
                            data-toggle="tooltip" name="salvar" 
                            value="importarxls" title="Importar" 
                            data-placement="top">
                        </button>
                       
                    </div>
                </div>
            </form>
            @if(!empty($successMsg) and count($logs) > 0)
                <h4 style="margin-bottom: 20px;">Log Importação</h4>
                <table id="myTable" class="table table-striped table-responsive-sm">
                    <thead class="tbl-cabecalho">
                    <tr>
                        <th scope="col"><strong>Arquivo</strong></th>
                        <th scope="col"><strong>Data Importação</strong></th>
                        <th scope="col"><strong>Log</strong></th>
                        <th scope="col"><strong>Status</strong></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td scope="row">{{$log->nome_arquivo}} </td>
                            <td scope="row">{{$log->data_hora_importacao}} </td>
                            <td scope="row">{{$log->log}} </td>
                            <td scope="row">{{$log->nome}} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <style>
                    .dataTables_wrapper .dataTables_length {
                        float: right!important;
                        padding-left: 8px!important;
                        padding-right: 8px!important;
                    }
                    .dataTables_paginate .paging_simple_numbers{
                        margin-bottom: 10px!important;
                    }
                    .bottom{
                        margin-top: 5px!important;
                    }
                    select {
                        border-left-width: 5px!important;
                        border-right-width: 5px!important;
                    }
                </style>
                <script>
                    $(document).ready(function() {
                        $('#myTable').DataTable( {
                            "dom": '<"top">rt<"bottom"ip><"clear">'
                        } );
                    } );
                </script>
            @endif
        </div>
    </div>
    <div class="modal fade" id="modalPergunta" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Atenção</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(!empty($openModal))
                        <div class="row">
                            <div class="col-sm-12">
                                <h6> {{ $openModal }}</h6>
                            </div>
                        </div>
                        <br>
                        <div class="row pull-right">
                            <form method="POST" action="{{route('importarModal')}}" enctype="multipart/form-data">
                                @csrf   
                                <div class="col-sm-12">
                                    <button type="submit" id="btnYes" 
                                        class="btn btn-secondary fa fa-thumbs-o-up"
                                        data-toggle="tooltip"
                                        value="yesModal" title="Yes" 
                                        data-placement="top">
                                    </button>
                                    <button type="submit" id="btnNo" 
                                        class="btn btn-secondary fa fa-thumbs-o-down"
                                        data-toggle="tooltip" data-dismiss="modal"
                                        value="noModal" title="No" 
                                        data-placement="top">
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if(!empty($openModal))
        <script>
            $(function(){ 
                $('#modalPergunta').modal('show');
            });
        </script>
        @endif
    </div>
</div>

@yield('scripts')
<script>
    $(function(){ 
        $("#btnSubmit").click(function() {
            var form = $( "#formImportar" );
            if(form.valid()){
                $("#loading").show();
                $("#btnSubmit").hide();
            }           
        });
    });
</script>
@endsection
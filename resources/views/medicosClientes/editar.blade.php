@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="card">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{route('medicosClientes.pesquisa')}}">
                        Consulta Cliente Medico
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <strong>Cadastro Cliente Medicos</strong>
                </li>
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
            <form id="formEditar">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtCRM">CRM</label>
                            <input type="text" class="form-control" id="txtCRM"
                                name="txtCRM"  value="{{$medicoOportunidadeCliente->crmMedico}}">
                            <input id="txtIdMedicoCRM" type="hidden" 
                                value="{{$medicoOportunidadeCliente->idMedico}}">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="txtMedico">Medico</label>
                            <input name="txtMedico" id="txtMedico" class="form-control"
                                    autocomplete="off"  value="{{$medicoOportunidadeCliente->nomeMedico}}">
                            <input id="txtIdMedico" name="txtIdMedico" type="hidden"
                                value="{{$medicoOportunidadeCliente->idMedico}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="txtEmail">Email</label>
                            <input name="txtEmail" id="txtEmail" 
                                class="form-control" autocomplete="off"  
                                value="{{$medicoOportunidadeCliente->emailMedico}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtDtNasc">Data Nascimento</label>
                            <input name="txtDtNasc" id="txtDtNasc" 
                                class="form-control" autocomplete="off"  
                                value="{{$medicoOportunidadeCliente->dtNascMedico}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txtFone">Telefone</label>
                            <input name="txtFone" id="txtFone" 
                                class="form-control" autocomplete="off"  
                                value="{{$medicoOportunidadeCliente->foneMedico}}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h5 style="font-weight: bold;">
                    Especialidades
                </h5>
                <br/>
            </div>
            <br/>
        </div>
        <div class="row">
            <div class="col-md-11">
                <div class="form-group">
                    <label for="txtEspecialidade">Especialidade</label>
                    <input name="txtEspecialidade" id="txtEspecialidade" 
                        class="form-control" autocomplete="off">
                    <input id="txtIdEspecialidade" name="txtIdEspecialidade" type="hidden"
                        value="{{$medicoOportunidadeCliente->idCliente}}">
                </div>
            </div>
            <div class="col-sm-1" style="align-self: center;">
                <button type="submit" id="btnAddEspecialidade" 
                    class="btn btn-secondary btn-sm fa fa-plus-circle nav-icon" 
                    data-toggle="tooltip" name="salvar" data-placement="top">
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="tblEspecliades" class="display table table-striped" style="width:100%!important;">
                    <thead class="tbl-cabecalho">
                        <tr>
                            <th scope="col" style="text-align: center;">
                                <input type="checkbox" id="chkSelectAll" style="margin-left:10px">
                            </th>
                            <th scope="col"><strong>Especialidade</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($especialidades as $especialidade)
                            <tr class="dados">   
                                <td style="width: 3px;" class="dt-body-center">
                                    <input type="checkbox"  name="chkOportunidade[]"  
                                        class="chkSelect">
                                </td>
                                <td class="clickable" style="max-width:50px">
                                    {{$especialidade->nome}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h5 style="font-weight: bold;">
                    Clientes
                </h5>
                <br/>
            </div>
            <br/>
        </div>
        <div class="row">
            <div class="col-md-11">
                <div class="form-group">
                    <label for="txtCliente">Cliente</label>
                    <input name="txtCliente" id="txtCliente" class="form-control"
                        autocomplete="off">
                    <input id="txtIdCliente" name="txtIdCliente" type="hidden"
                        value="{{$medicoOportunidadeCliente->idCliente}}">
                </div>
            </div>
            <div class="col-sm-1" style="align-self: center;">
                <button type="submit" id="btnAddCliente" 
                    class="btn btn-secondary btn-sm fa fa-plus-circle nav-icon" 
                    data-toggle="tooltip" name="salvar" data-placement="top">
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="tblClientes" class="display table table-striped" style="width:100%!important;" >
                    <thead class="tbl-cabecalho">
                        <tr>
                            <th scope="col" style="text-align: center;">
                                <input type="checkbox" id="chkSelectAll" style="margin-left:10px">
                            </th>
                            <th scope="col"><strong>Cliente Nome</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $cliente)
                            <tr class="dados">   
                                <td style="width: 3px;" class="dt-body-center">
                                    <input type="checkbox"  name="chkCliente[]"  
                                        class="chkSelect">
                                </td>
                                <td class="clickable" style="max-width:50px">
                                    {{$cliente->nome}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@yield('scripts')
<script>
    $(function(){
        $("#txtEspecialidade").autocomplete({
            search  : function()
            {
                $("#loading").show();   
            },
            open    : function()
            {
                  $("#loading").hide();   
            },
            source: function( request, response ) {
                $.ajax( {
                    url: "{{route('especialidade.autocomplete_cliente')}}",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function( data ) {
                        response($.map(data, function(item) {
                            return {
                                label: item.nome,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 2,
            select: function( event, ui ) {
                $('#txtEspecialidade').val(ui.item.label);
                return false;
            }
        });

        $("#txtCliente").autocomplete({
            search  : function()
            {
                $("#loading").show();   
            },
            open    : function()
            {
                  $("#loading").hide();   
            },
            source: function( request, response ) {
                $.ajax( {
                    url: "{{route('oportunidades.autocomplete_cliente')}}",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function( data ) {
                        response($.map(data, function(item) {
                            return {
                                label: item.nome,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 2,
            select: function( event, ui ) {
                $('#txtCliente').val(ui.item.label);
               
                return false;
            }
        });

        $("#tblEspecliades").DataTable({
            "columnDefs": [
                { 
                    "orderable": false, 
                    "targets": 0,
                    "className": 'select-checkbox',
                    "width": "7%", 
                },
            ]
        });

        $("#tblClientes").DataTable({
            "columnDefs": [
                { 
                    "orderable": false, 
                    "targets": 0,
                    "className": 'select-checkbox',
                    "width": "7%", 
                },
            ]
        });

        $("#btnAddCliente").on('click', function(){
            $("#tblClientes").DataTable().row.add( [
                '1',
                'teste cliente',
            ] ).draw( false );
        });

        $("#btnAddEspecialidade").on('click', function(){
            alert('add especialidades')
        });
    });
</script>
@endsection
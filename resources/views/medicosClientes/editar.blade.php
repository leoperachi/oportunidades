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
                            <th scope="col"><strong></strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($especialidades as $especialidade)
                            <tr class="dados">   
                                <td style="width: 3px;" class="dt-body-center">
                                    <input type="checkbox"  name="chkEspecialidade[]"  
                                        class="chkSelect">
                                </td>
                                <td class="clickable" style="max-width:50px">
                                    {{$especialidade->nome}}
                                </td>
                                <td style="text-align:end;">
                                    <button class="btn btn-sm btn-dark btnRmvEspecialidade" data-toggle="tooltip" data-id="{{$especialidade->id}}"
                                        value="cancelar"  type="button" data-placement="bottom" title="Cancelar">
                                        <i class="fa fa-minus-circle"></i>
                                    </button>
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
                            <th scope="col"><strong></strong></th>
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
                                <td style="text-align:end;">
                                    <button class="btn btn-sm btn-dark btnRmvCliente" data-toggle="tooltip" data-id="{{$cliente->id}}"
                                        value="cancelar"  type="button" data-placement="bottom" title="Cancelar">
                                        <i class="fa fa-minus-circle"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row">
            <div class="col-md-12" style="float: right;">
                <div style="float: right;">
                    <input type="submit" class="btn btn-success" name="salvar" value="Salvar">
                    <input type="submit" class="btn btn-default" name="remover" value="Remover">
                    <a href="{{ route('aviso.listar') }}" class="btn btn-default" name="cancelar">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</div>

@yield('scripts')
<script>
    $(function(){
        $("#txtDtNasc").datepicker();

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
                '<input type="checkbox" name="chkCliente[]" class="chkSelect">',
                $("#txtCliente").val(),
                '<div style="text-align: end;"><button class="btn btn-sm btn-dark btnRmvCliente" ' + 
                'data-toggle="tooltip" value="cancelar"  type="button" data-placement="bottom" ' + 
                'title="Cancelar"><i class="fa fa-minus-circle"></i></button></div>',
            ] ).draw( false );

            $("#txtCliente").val('');
            $("#tblClientes tbody tr .select-checkbox").addClass('dt-body-center');
        });

        $("#btnAddEspecialidade").on('click', function(){
            $("#tblEspecliades").DataTable().row.add( [
                '<input type="checkbox" name="chkEspecialidade[]" class="chkSelect">',
                $("#txtEspecialidade").val(),
                '<div style="text-align: end;"><button class="btn btn-sm btn-dark btnRmvEspecialidade" ' + 
                'data-toggle="tooltip" value="cancelar"  type="button" data-placement="bottom" title="Cancelar"> ' + 
                '<i class="fa fa-minus-circle"></i></button></div>',
            ] ).draw( false );

            $("#txtEspecialidade").val('');
            $("#tblEspecliades tbody tr .select-checkbox").addClass('dt-body-center');
        });
    });
</script>
@endsection
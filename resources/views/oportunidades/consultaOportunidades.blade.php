@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div class="card" id="app">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <strong>Consulta Oportunidades</strong>
                </li>
            </ol>
        </nav>
        <br/>
        <div>
            @if(!empty($successMsg))
                <div id="msg" class="alert alert-success"> {{ $successMsg }}</div>
            @endif
            @if(!empty($errorMsg))
                <div id="msg" class="alert alert-danger"> {{ $errorMsg }}</div>
            @endif
        </div>
        <div id="registros">
            <form id="formConsultar" method="post" action="{{route('oportunidades.consultar')}}">
                @csrf
                <div id="filtroAvancado">
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-md-4" style="padding-left: 0px;padding-right: 0px;">
                            <div class="ck-button">
                                <label style="margin-bottom: 0px;">
                                    <input id="chkPrioritarias" onChange="" 
                                        name="chkTipoOportunidade[]" style="display: none;" 
                                        type="checkbox" value="3" <?php echo ($filtroObject->chkPrioritarias==true ? 'checked' : '');?>>
                                    <span style="height: 40px;padding-top: 10px;">Prioritárias</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4" style="padding-left: 0px;padding-right: 0px;">
                            <div class="ck-button">
                                <label style="margin-bottom: 0px;">
                                    <input id="chkRecorrentes" onChange="" 
                                        name="chkTipoOportunidade[]" style="display: none;" 
                                        type="checkbox" value="1" <?php echo ($filtroObject->chkRecorrentes==true ? 'checked' : '');?>>
                                    <span style="height: 40px;padding-top: 10px;">Recorrentes</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4" style="padding-left: 0px;padding-right: 0px;">
                            <div class="ck-button">
                                <label style="margin-bottom: 0px;">
                                    <input id="chkEventuais" onChange="" 
                                        name="chkTipoOportunidade[]" style="display: none;" 
                                        type="checkbox" value="2" <?php echo ($filtroObject->chkEventuais==true ? 'checked' : '');?>>
                                    <span style="height: 40px;padding-top: 10px;">Eventuais</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nome_fantasia">Código</label>
                                <input type="text" class="form-control" id="codigo"
                                    name="codigo" value="{{$filtroObject->codigo}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cmbEspecialidade">Especialidade</label>
                                <select id="cmbEspecialidade" name="cmbEspecialidade" class="form-control">
                                    <option value="0" selected>Selecione...</option>
                                    @foreach($especialidades as $especialidade)
                                        @if(isset($especialidade->checked))
                                            <option value="{{$especialidade->id}}" selected>
                                                {{$especialidade->nome}}
                                            </option>
                                        @else
                                            <option value="{{$especialidade->id}}">
                                                {{$especialidade->nome}}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtCliente">Cliente</label>
                                <input name="txtCliente" id="txtCliente" class="form-control"
                                    value="{{$filtroObject->nomeCliente}}" autocomplete="off">
                                <input id="txtIdCliente" name="txtIdCliente" type="hidden"
                                    value="{{$filtroObject->idCliente}}" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="0" selected>Selecione...</option>
                                    @foreach($status as $st)
                                        @if(isset($st->checked))
                                            <option value="{{$st->id}}" selected>{{$st->nome}}</option>
                                        @else
                                            <option value="{{$st->id}}">{{$st->nome}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtDtInicio">Data Inicio</label>
                                <input type="text" name="txtDtInicio" style="padding-bottom: 0px;"
                                    id="txtDtInicio" autocomplete="off" class="form-control" value="{{$filtroObject->dtInicio}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtDtFinal">Data Final</label>
                                <input type="text" name="txtDtFinal" style="padding-bottom: 0px;"
                                    id="txtDtFinal" autocomplete="off" class="form-control" value="{{$filtroObject->dtFinal}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtperini">Periodo Inicio</label>
                                <input type="time" class="form-control" id="txtperini"
                                    name="txtperini" autocomplete="off" min="00:00" max="23:59" value="{{$filtroObject->periodoini}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtperfim">Periodo Final</label>
                                <input type="time" class="form-control" id="txtperfim"
                                    name="txtperfim" autocomplete="off" min="00:00" max="23:59" value="{{$filtroObject->periodofim}}">
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-left: 0px;">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" <?php echo ($filtroObject->seg == true ? 'checked' : '');?> 
                                    name="chkSeg" id="chkSeg">
                                <label for="chkSeg">Segunda</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <input type="checkbox" <?php echo ($filtroObject->ter == true ? 'checked' : '');?> 
                                    name="chkTer" id="chkTer">
                                <label for="chkTer">Terça</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <input type="checkbox" id="chkQua" <?php echo ($filtroObject->qua == true ? 'checked' : '');?> 
                                    name="chkQua">
                                <label for="chkQua">Quarta</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" <?php echo ($filtroObject->qui == true ? 'checked' : '');?> 
                                    name="chkQui" id="chkQui">
                                <label for="chkQui">Quinta</label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-left: 0px;">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" <?php echo ($filtroObject->sex == true ? 'checked' : '');?> 
                                    name="chkSex" id="chkSex">
                                <label for="chkSex">Sexta</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" <?php echo ($filtroObject->sab == true ? 'checked' : '');?> 
                                    name="chkSab" id="chkSab">
                                <label for="chkSab">Sabado</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" <?php echo ($filtroObject->dom == true ? 'checked' : '');?> 
                                    name="chkDom" id="chkDom">
                                <label for="chkDom">Domingo</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <input type="checkbox" <?php echo ($filtroObject->comb == true ? 'checked' : '');?> 
                                    name="chkCombinar" id="chkCombinar">
                                    <label for="chkCombinar">A Combinar</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <br>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-10">
                        <br>
                    </div>
                    <div class="col-sm-2">
                        <div id="form-acoes" class="form-group float-right">

                            {{-- Campo de pesquisa --}}
                            <div class="input-group" style="bottom: 10px;">

                                <div class="input-group-append">
                                    <button  id="btnShowFiltro" type="button"
                                        title="Filtro avançado" data-placement="top"
                                        class="btn btn-secondary fa fa-filter nav-icon"
                                        style="float: left;width:24px">
                                    </button>
                                    <button  id="btnLimpar" name="acao" value="limpar"
                                        title="Limpar" data-placement="top" type="submit"
                                        class="btn btn-secondary fa fa-eraser nav-icon"
                                        style="width:50px">
                                    </button>
                                    <button id="btnConsultar" type="submit"
                                        class="btn btn-secondary fa fa-search nav-icon btnConsultar"
                                        data-toggle="tooltip" title="Pesquisar" value="consultar"
                                        data-placement="top" style="width:50px">
                                    </button>
                                    <button type="button" id="status" class="btn btn-secondary dropdown-toggle-split" 
                                        title="Ações" data-placement="top" data-toggle="dropdown" 
                                        aria-haspopup="true" aria-expanded="false">
                                        
                                        <i class="fa fa-check"></i>
                                        <i class="dropdown-toggle"></i>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <input type="submit" class="dropdown-item" 
                                            name="acao" value="priorizar">
                                        <input type="submit" class="dropdown-item" 
                                            name="acao" value="despriorizar">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <table id="myTable" class="table table-striped table-responsive-sm" style="width:100%!important;">
                    <thead class="tbl-cabecalho">
                        <tr>
                            <th scope="col" style="text-align: center">
                                <input style="margin-left:10px" type="checkbox" id="chkSelectAll">
                            </th>
                            <th scope="col"><strong>Cód</strong></th>
                            <th scope="col"><strong>Tipo</strong></th>
                            <th scope="col"><strong>P.</strong></th>
                            <th scope="col"><strong>Dia</strong></th>
                            <th scope="col"><strong>Data </strong></th>
                            <th scope="col"><strong>Periodo</strong></th>
                            <th scope="col"><strong>Status</strong></th>
                            <th scope="col"><strong>Especialidade</strong></th>
                            <th scope="col"><strong>Cliente/Unidade</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($oportunidades as $c)
                            <tr class="dados">
                                <td style="" class="dt-body-center">
                                    <input type="checkbox" name="chkOportunidade[]"  
                                        class="chkSelect" value="{{$c->id}}">
                                </td>
                                <td class="clickable" style="max-width:50px" data-id="{{$c->id}}">
                                    {{$c->id}}
                                </td>
                                <td class="clickable" data-id="{{$c->id}}">
                                    {{$c->oportunidadeTipoNome}}
                                </td>
                                <td class="clickable dt-body-center" data-id="{{$c->id}}">
                                    @if($c->prioridade==1)
                                        <i class="fa fa-thumbs-o-up fa-2" aria-hidden="true"></i>
                                    @endif
                                </td>
                                <td class="clickable" data-id="{{$c->id}}">
                                    {{$c->diaSemanastr}}
                                </td>
                                <td class="clickable" data-id="{{$c->id}}">
                                    @if(isset($c->data_inicio))
                                        {{ date('d-m-y', strtotime($c->data_inicio)) }}
                                    @endif
                                </td>
                                <td class="clickable" data-id="{{$c->id}}">
                                    {{$c->periodo}}
                                </td>
                                <td class="clickable" data-id="{{$c->id}}">
                                    {{$c->statusNome}}
                                </td>
                                <td class="clickable" data-id="{{$c->id}}">
                                    {{$c->especialidadeNome}}
                                </td>
                                <td class="clickable" data-id="{{$c->id}}">
                                    {{$c->oportunidadeClienteNome}}
                                </td>
                            </tr>                        
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
@yield('scripts')
<script>
    function bindAllDocReadyThings(url){
        window.history.pushState('page2', 'Title', url);   
    }

    $(function(){
        @if(isset($filtroObject->openFiltroAvancado) and 
            $filtroObject->openFiltroAvancado==false)
            $("#filtroAvancado").hide();
        @endif

        $( "#txtDtInicio" ).datepicker();
        $( "#txtDtFinal" ).datepicker();

        $("#txtCliente").autocomplete({
            source: function( request, response ) {
                $.ajax( {
                    url: "/homolog_oportunidade/oportunidades/public/oportunidades/autocomplete_cliente",
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
                var v = ui.item.value;
                $('#txtCliente').val(ui.item.label);
                $('#txtIdCliente').val(ui.item.value);
                return false;
            }
        });

        $('#myTable').DataTable({
            "pageLength": 50,
            "columnDefs": [
                { 
                    "orderable": false, 
                    "targets": 0,
                    "className": 'select-checkbox',
                    "width": "4%", 
                },
                { 
                    "targets": 1,
                    "width": "5%", 
                },
                { 
                    "targets": 3,
                    "width": "5%", 
                },
                { 
                    "targets": 4,
                    "width": "10%", 
                },
                { 
                    "targets": 7,
                    "width": "9%", 
                }
            ],
        });
        
        $("#btnShowFiltro").off('click').on('click', function(event) {
            if($("#filtroAvancado").is(":visible")){
                $("#filtroAvancado").hide();
            }
            else{
                $("#filtroAvancado").show();
            }

            return false;
        });

        $("#btnLimpar").off('click').on('click', function(event) {
            $("#loading").show();
        });

        $("#btnConsultar").off('click').on('click', function(event) {
            $("#loading").show();
        });

        $('.ck-button').off('click').on('click', function(event) {
            event.stopPropagation();
            $("#loading").show();
            var esseCheckbox = $(this).find('input[type=checkbox]')[0];
            var esseSpan = $(this).find('span')[0];

            if($(esseCheckbox).prop("checked") == true){
                $(esseCheckbox).prop("checked", false);
            }else{
                var btns = $(".ck-button");

                for(i=0;i<btns.length;i++){
                    var curSpan = $(btns[i]).find('span')[0];
                    if($(esseSpan).text() != $(curSpan).text()){
                        var p = $(curSpan).parent()[0];
                        var curCheckbox  = $(p).find('input[type=checkbox]')[0];
                        var checked = $(curCheckbox).prop("checked");
                        if(checked){
                            $(curCheckbox).prop("checked", false);
                        }
                    }
                }

                $(esseCheckbox).prop("checked", true);
                $("#formConsultar").submit();
            }

            return false;
        });

        $(".clickable").on('click', function(event) {
            $("#loading").show();        
            window.location.href = "{{url('/')}}/oportunidades/acompanhamento/" + $(this).data('id');
        });

        $("#chkSelectAll").on('click', function(){
            if ($(this).is( ":checked" )) {
                $(".chkSelect").attr('checked', true);
            } else {
                $(".chkSelect").attr('checked', false); 
            }   
        });
    });
</script>
@endsection
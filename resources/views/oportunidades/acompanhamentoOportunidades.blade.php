@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<form id="formAcompanhamento" method="post" 
    action="{{route('oportunidades.selecionar')}}">
    <div class="card" id="app">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('oportunidades.consulta')}}">Consulta</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <strong>Acompanhamento</strong>
                    </li>
                </ol>
            </nav>
            <div>
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <button class="btn btn-sm btn-gray" data-toggle="tooltip"
                                value="excluir" data-placement="bottom" title="Excluir" id="btnexcluir" >
                                <i class="fa fa-trash-o fa-2"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-11" style="text-align:end;">
                        <div class="form-group">
                            <button class="btn btn-sm btn-gray btnAntProx" data-placement="bottom"
                                data-toggle="tooltip" title="Anterior" id="btnAnt" value="anterior"
                                <?php echo ($primeiraIdOportunidade==$oportunidade->id ? 'disabled' : '');?>>
                                <i class="fa fa-arrow-circle-left"></i>
                            </button>
                            <button class="btn btn-sm btn-dark btnAntProx" data-toggle="tooltip" id="btnProx" 
                                value="proximo" data-placement="bottom" title="Proximo" 
                                <?php echo ($ultIdOportunidade==$oportunidade->id ? 'disabled' : '');?>>
                                <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>    
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="txtCodigo">Código</label>
                            <input type="text" class="form-control" id="txtCodigo"
                                name="txtCodigo" value="{{$oportunidade->id}}" disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtStatus">Status</label>
                            <input name="txtStatus" class="form-control" disabled
                                value="{{$oportunidade->statusNome}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtOportunidadeTipoNome">Tipo Oportunidade</label>
                            <input name="txtOportunidadeTipoNome" class="form-control" disabled
                                value="{{$oportunidade->oportunidadeTipoNome}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cmbEspecialidade">Especialidade</label>
                            <select id="cmbEspecialidade" disabled name="cmbEspecialidade" class="form-control" disabled>
                                <option value="0" selected>Selecione...</option>
                                @foreach($especialidades as $especialidade)
                                    @if(isset($especialidade->checked))
                                        <option value="{{$especialidade->id}}" selected>{{$especialidade->nome}}</option>
                                    @else
                                        <option value="{{$especialidade->id}}">{{$especialidade->nome}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if($oportunidade->oportunidadeTipoNome == 'Eventuais')
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtData">Data</label>
                            <input type="text" class="form-control" id="txtData"
                                name="txtData" disabled value="{{$oportunidade->dataStr}}">
                        </div>
                    </div>
                    @else
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="txtFrequencia">Frequência</label>
                                <input type="text" class="form-control" id="txtFrequencia"
                                name="txtFrequencia" disabled value="{{$oportunidade->frequenciaStr}}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="txtTpAtend">T. Atendimento</label>
                            <input type="text" class="form-control" id="txtTpAtend"
                                name="txtTpAtend" disabled value="{{$oportunidade->tipo_atendimento}}">
                        </div>
                    </div>
                    @endif
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtHorario">Horário</label>
                            <input type="text" class="form-control" id="txtHorario"
                                name="txtHorario" disabled value="{{$oportunidade->horaStr}}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="txtDiadaSemana">Dia da Semana</label>
                            <input type="text" class="form-control" id="txtDiadaSemana"
                                name="txtDiadaSemana" disabled value="{{$oportunidade->diaDaSemana}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtCliente">Cliente</label>
                            <input name="txtCliente" id="txtCliente" class="form-control"
                                value="{{$oportunidade->oportunidadeClienteNome}}" disabled>

                            <input id="txtIdCliente" type="hidden" 
                                value="{{$oportunidade->oportunidadeClienteId}}">
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    <section id="medicos">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5 style="font-weight: bold;">
                            Candidaturas
                        </h5>
                        <br/>
                    </div>
                    <br/>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tableCandidaturas" class="table table-striped table-responsive-sm">
                            <thead class="tbl-cabecalho">
                                <tr>
                                    <th scope="col"><strong>Medico</strong></th>
                                    <th scope="col"><strong>CRM</strong></th>
                                    <th scope="col"><strong>Fone</strong></th>                                    
                                    <th scope="col"><strong>Email</strong></th>
                                    <th scope="col"><strong></strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($oportunidadesMedicosInteressados as $omi)
                                    <tr class="dados <?php if($oportunidade->idmedico === $omi->idmedico) { echo 'selected'; } ?>">
                                        <td class="clickable">
                                            {{$omi->nomeMedico}}
                                        </td> 
                                        <td data-id="{{$omi->id}}">
                                            {{$omi->crmMedico}} {{$omi->crmMedicoUf}}
                                        </td>
                                        <td class="clickable">
                                            {{$omi->telefone}}
                                        </td>
                                        <td class="clickable">
                                            {{$omi->email}}
                                        </td>
                                        <td style="text-align:end;">
                                            <button class="btn btn-sm btn-gray btnGrid " data-toggle="tooltip" data-id="{{$omi->id}}" 
                                                <?php if($oportunidade->idmedico === $omi->idmedico) { echo 'disabled'; } ?> 
                                                value="selecionar" type="button" data-placement="bottom" title="Selecionar">
                                                <i class="fa fa-plus-circle"></i>
                                            </button>
                                            <button class="btn btn-sm btn-dark btnGrid" data-toggle="tooltip" data-id="{{$omi->id}}"
                                                <?php if($oportunidade->idmedico !== $omi->idmedico) { echo 'disabled'; } ?> 
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
    </section>
</form>

@yield('scripts')
<script>
      function bindAllDocReadyThings(url){
        window.history.pushState('page2', 'Title', url);
    }
    $(function(){
        setTimeout(() => {
            $("#loading").hide();    
        }, 1000);
        
        $('#tableCandidaturas').DataTable({
            "columnDefs": [
                { 
                    "width": "35%", 
                    "targets": 0
                },
                { 
                    "width": "20%", 
                    "targets": 1
                },
                { 
                    "width": "15%", 
                    "targets": 2
                },
                { 
                    "width": "20%", 
                    "targets": 3
                },
                { 
                    "orderable": false, 
                    "width": "10%", 
                    "targets": 4
                }
            ]
        });

        $(".btnAntProx").click(function(event) {
            $("#loading").show();
            event.preventDefault();
            var tipo = $(this).val();
            var idOportunidade = $("#txtCodigo").val();

            $.ajax({
                url: "{{ route('oportunidades.proximoAnterior') }}",
                type: 'GET',
                data: { tipo: tipo, idOportunidade: idOportunidade } ,
                contentType: 'application/json; charset=utf-8',
                success: function (response) {
                    window.location.href = 
                        "/homolog_oportunidade/oportunidades/public/oportunidades/acompanhamento/" + 
                            response;
                },
                error: function () {
                    alert("error");
                }
            }); 
        });

        $(".btnGrid").click(function(event) {
            event.preventDefault();
            var tipo = $(this).val();
            var idOportMedInt = $(this).data('id');
            
            $("#loading").show(); 

            if(tipo == 'selecionar'){
                $.ajax({
                    url: "{{ route('oportunidades.selecionar') }}",
                    type: 'GET',
                    data: 
                    { 
                        tipo: tipo, 
                        idOportMedInt: idOportMedInt 
                    } ,
                    contentType: 'application/json; charset=utf-8',
                    success: function (response) {
                        var table = $('#tableCandidaturas').DataTable();
                        var indexes = table.rows().eq( 0 ).filter( function (rowIdx) {
                            return table.cell( rowIdx, 0 ).data() === response ? true : false;
                        } );

                        var row = table.rows( indexes ).nodes().to$();
                        var btns = $(row[0]).find('td > button');

                        if($(btns[0]).val() == tipo){
                            $(btns[0]).attr("disabled", true);
                            $(btns[1]).removeAttr("disabled");
                        }else{
                            $(btns[1]).attr("disabled", true);
                        }

                        $('#tableCandidaturas tr').each(function() {
                            var btns = $(this).find('td > button');
                            if($(this).hasClass('selected') == true){
                                $(this).removeClass('selected');
                                $(btns[0]).removeAttr("disabled", true);
                            }
                        });

                        row.addClass( 'selected' );
                    },
                    error: function (ex) {
                        alert("error" + ex.responseJSON.message);
                    },
                    complete: function(){
                        setTimeout(() => {
                            $("#loading").hide();    
                        }, 500);
                    }
                }); 
            }
            else{
                $.ajax({
                    url: "{{ route('oportunidades.cancelar') }}",
                    type: 'GET',
                    data: 
                    { 
                        tipo: tipo, 
                        idOportMedInt: idOportMedInt 
                    } ,
                    contentType: 'application/json; charset=utf-8',
                    success: function (response) {

                        var table = $('#tableCandidaturas').DataTable();
                        var indexes = table.rows().eq( 0 ).filter( function (rowIdx) {
                            return table.cell( rowIdx, 0 ).data() === response ? true : false;
                        } );

                        var row = table.rows( indexes ).nodes().to$();
                        var btns = $(row[0]).find('td > button');

                        if($(btns[0]).val() == tipo){
                            $(btns[1]).removeAttr("disabled", true);
                        }else{
                            $(btns[0]).removeAttr("disabled", true);
                            $(btns[1]).attr("disabled", true);
                        }

                        row.removeClass( 'selected' );
                    },
                    error: function (ex) {
                        alert("error" + ex.responseJSON.message);
                    },
                    complete: function(){
                        setTimeout(() => {
                            $("#loading").hide(); 
                        }, 500);
                    }
                }); 
            }
        });

        setTimeout(() => {
            $("#tableCandidaturas").DataTable().destroy();
            $('#tableCandidaturas').DataTable( {
                    "pageLength": 20
                }).draw();
        }, 50); 
    });
</script>
@endsection
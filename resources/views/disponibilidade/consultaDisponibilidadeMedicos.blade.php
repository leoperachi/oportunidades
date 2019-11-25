@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<script src="{{ asset('js/consultaOportunidades.js') }}"></script>
<div class="card" id="app">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page"><strong>Pesquisa Disponibilidade</strong></li>
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
            <form id="busca" method="post" action="{{route('disponibilidade.consultar')}}">
                @csrf
                <div id="filtroAvancado">
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-md-6" style="padding-left: 0px;padding-right: 0px;">
                            <div class="ck-button">
                                <label style="margin-bottom: 0px;">
                                    <input id="chkRecorrentes" onChange="this.form.submit()" 
                                        name="chkTipoOportunidade[]" style="display: none;" 
                                        type="checkbox" value="1">
                                    <span style="height: 40px;padding-top: 10px;">Recorrentes</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding-left: 0px;padding-right: 0px;">
                            <div class="ck-button">
                                <label style="margin-bottom: 0px;">
                                    <input id="chkEventuais" onChange="this.form.submit()" 
                                        name="chkTipoOportunidade[]" style="display: none;" 
                                        type="checkbox" value="2">
                                    <span style="height: 40px;padding-top: 10px;">Especificas</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label id="label-cpf" for="cpf">CRM:</label>
                            <input type="text" name="crm" id="crm" class="form-control" value="{{old('crm')}}">
                            <input id="txtIdMedicoCRM" type="hidden">
                        </div>
                        @if ($errors->has('crm'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('crm') }}</strong>
                            </span>
                        @endif
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtMedico">Médico</label>
                                <input name="txtMedico" id="txtMedico" class="form-control">
                                <input id="txtIdMedico" type="hidden">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cmbEspecialidade">Especialidade</label>
                                <select id="cmbEspecialidade" name="cmbEspecialidade" class="form-control">
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
                                    id="txtDtInicio" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtDtFinal">Data Inicio</label>
                                <input type="text" name="txtDtFinal" style="padding-bottom: 0px;"
                                    id="txtDtFinal" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtperini">Periodo Inicio</label>
                                <input type="text" class="form-control" id="txtperini"
                                    name="txtperini">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtperfim">Periodo Final</label>
                                <input type="text" class="form-control" id="txtperfim"
                                    name="txtperfim">
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-left: 0px;">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" id="chkSeg">
                                <label for="chkSeg">Segunda</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <input type="checkbox" id="chkTer">
                                <label for="chkTer">Terça</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <input type="checkbox" id="chkQua">
                                <label for="chkQua">Quarta</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" id="chkQui">
                                <label for="chkQui">Quinta</label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-left: 0px;">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" id="chkSex">
                                <label for="chkSex">Sexta</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" id="chkSab">
                                <label for="chkSab">Sabado</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" id="chkDom">
                                <label for="chkDom">Domingo</label>
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
                                    <button  id="filtrar"
                                        title="Filtro avançado" data-placement="top"
                                        class="btn btn-secondary fa fa-filter nav-icon"
                                        style="float: left;width:24px">
                                    </button>
                                    <button  type="submit" id="consultar"
                                        class="btn btn-secondary fa fa-search nav-icon"
                                        data-toggle="tooltip" title="Pesquisar" value="consultar"
                                        data-placement="top" style="width:50px">
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="myTable" class="table table-striped table-responsive-sm">
                    <thead class="tbl-cabecalho">
                        <tr>                            
                            <th scope="col"><strong>Médico</strong></th>
                            <th scope="col"><strong>Telefone</strong></th>
                            <th scope="col"><strong>CRM/UF</strong></th>
                            <th scope="col"><strong>Tipo</strong></th>                            
                            <th scope="col"><strong>Especialidade</strong></th>
                            <th scope="col"><strong>Semana</strong></th>
                            <th scope="col"><strong>Data</strong></th>
                            <th scope="col"><strong>Período</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicoDisponibilidade as $c)
                            <tr class="dados">
                                <td class="clickable" data-id="{{$c->id}}">
                                    {{$c->disponibilidadeMedicoNome}}
                                </td>
                                <td class="clickable" data-id="{{$c->id}}">
                                    {{$c->disponibilidadeMedicoTelefone}}
                                </td>
                                <td class="clickable" data-id="{{$c->id}}">
                                    {{$c->disponibilidadeMedicoCrm}} {{$c->disponibilidadeMedicoCrmUf}}  
                                </td>
                                <td class="clickable" data-id="{{$c->id}}">
                                    {{$c->disponibilidadeMedicoOportunidadeTipoNome}}
                                </td>
                                <td class="clickable" data-id="{{$c->id}}">
                                    {{$c->disponibilidadeMedicoEspecialidadeNome}}
                                </td>
                                <td class="clickable" data-id="{{$c->id}}">
                                    {{$c->disponibilidadeMedicoDiaSemana}}
                                </td>
                                <td class="clickable" data-id="{{$c->id}}">
                                    {{date("d/m/Y", strtotime($c->disponibilidadeMedicoData))}}
                                </td>
                                <td class="clickable" data-id="{{$c->id}}">
                                    {{$c->disponibilidadeMedicoHoraInicio}} - {{$c->disponibilidadeMedicoHoraTermino}}
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
        $(function(){
            @if(isset($openFiltroAvancado) and $openFiltroAvancado==false)
                $("#filtroAvancado").hide();
            @endif
        });

        $(document).ready(function() {            
        

            var inputCRM = $('#crm');
            /**
            *   Autocomplete em ID do Médico, CRM e Nome do Médico: Por CRM
            */
            $('#crm').autocomplete({
                source: function(request, response){
                    $.ajax({
                        url: "{{ route('disponibilidade.crm') }}",
                        type: "GET",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function(data){ 
                            response(data);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                },
                minLength: 2,
                select: function( event, ui ) {
                    var crmuf = ui.item.crm + ui.item.crm_uf
                    

                    $( "#txtIdMedico" ).val( ui.item.id );
                    $( "#txtIdMedicoCRM" ).val(ui.item.id);                    
                    $( "#crm" ).val( crmuf );
                    $( "#txtMedico" ).val( ui.item.nomeMedico );
                   
                    
                    return false;
                }
            })
            .autocomplete('instance')._renderItem = function(ul, item) {
                return $( "<li>" )
                    .append( "<div>" + item.crm + "" + item.crm_uf + " - " + item.nomeMedico + "</div>" )
                    .appendTo( ul );
            }
            /**
                Fim autocomplete
            */
            var inputMedico = $('#txtMedico');
            /**
            *   Autocomplete em ID do Médico, CRM e Nome do Médico: Por Nome de Médico
            */
            $('#txtMedico').autocomplete({
                source: function(request, response){
                    $.ajax({
                        url: "{{ route('disponibilidade.medico') }}",
                        type: "GET",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function(data){ 
                            response(data);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                },
                minLength: 2,
                select: function( event, ui ) {
                    var crmuf = ui.item.crm + ui.item.crm_uf                    

                    $( "#txtIdMedico" ).val( ui.item.id );
                    $( "#txtIdMedicoCRM" ).val(ui.item.id);                    
                    $( "#crm" ).val( crmuf );
                    $( "#txtMedico" ).val( ui.item.nomeMedico );
                   
                    
                    return false;
                }
            })
            .autocomplete('instance')._renderItem = function(ul, item) {
                return $( "<li>" )
                    .append( "<div>" + item.crm + "" + item.crm_uf + " - " + item.nomeMedico + "</div>" )
                    .appendTo( ul );
            }
            /**
                Fim autocomplete
            */
            

    });

</script>



@endsection
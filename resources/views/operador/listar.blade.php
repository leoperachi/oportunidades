@extends('layouts.app')

@section('content')
    <div class="card" id="app">
        <div class="card-body">
            <div class="tab-pane">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><strong>Operador</strong></li>
                    </ol>
                </nav>
                <div id="registros">
                    <form id="buscar-banco" method="post" action="{{route('operador.listar')}}">
                        @csrf
                        <div class="form-row" style="margin: 0 auto;">
                            {{-- Campo de pesquisa --}}
                            <div class="col-10">
                                <input type="text" name="filtro" id="filtro" class="form-control form-control-lg" placeholder="Filtro"
                                       style="width:100%;" value="{{$filtro}}">
                            </div>
                            {{-- btn-consultar --}}
                            <div>
                                <button type="button" id="consultar" class="btn btn-secondary fa fa-search nav-icon"
                                        style="float: left; width: 40px;"></button>
                            </div>
                            {{-- btn-filtro-avançado --}}
                            <div>
                                <button type="button"
                                    id="filtrar" data-toggle="tooltip"
                                    title="Filtro avançado" data-placement="top"
                                    class="btn btn-secondary fa fa-filter nav-icon" 
                                    style="float: left; width: 40px;">
                                </button>
                            </div>
                            {{-- btn-status --}}
                            <div class="dropdown" style="margin-left: 5px;">
                                <button type="button"
                                        class="btn btn-secondary "
                                        style="height: 40px;">
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="dropdown-content">
                                    <input type="submit" class="dropbtn" name="acao" value="Ativar">
                                    <input type="submit" class="dropbtn" name="acao" value="Inativar">
                                    <input type="submit" class="dropbtn" name="acao" value="Remover">
                                </div>
                            </div>
                            {{-- btn-cadastro --}}
                            <div style="margin-left: 5px; padding-top: 11px;">
                                <a href="{{route('operador')}}" class="btn-mais">+</a>
                            </div>
                            {{-- filtro avancado --}}
                            <div id="filtro_avancado" class="row" >
                                <div class="form-row">
                                    <label for="operadora" class="col-sm-2 col-form-label">Operadora</label>
                                    <div class="col-md-9">
                                        <select id="operadora" name="operadora" class="form-control">
                                            <option value=""></option>
                                            @foreach($operadoras as $operadora)
                                                <option value="{{$operadora->id}}">{{$operadora->nome}}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    <label for="unidade" class="col-sm-2 col-form-label">Unidade</label>
                                    <div class="col-md-9">
                                        <select id="unidade" name="unidade" class="form-control">
                                            <option value=""></option>
                                            @foreach($unidades as $unidade)
                                                <option value="{{$unidade->id}}">{{$unidade->nome}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="perfil" class="col-sm-2 col-form-label">Perfil</label>
                                    <div class="col-md-9">
                                        <select id="perfil" name="perfil" class="form-control">
                                            <option value=""></option>
                                            @foreach($perfis as $perfil)
                                                <option value="{{$perfil->id}}">{{$perfil->nome}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-md-9">
                                        <select id="status" name="status" class="form-control">
                                            <option value="">Selecione</option>
                                            <option value="A">Ativo</option>
                                            <option value="I">Inativo</option>
                                            <!-- <option value="E">Removido</option> -->
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-secondary" id="consultar"><strong>Filtrar</strong></button>
                            </div>
                        </div>

                        <table class="table table-striped table-responsive-sm">
                            <thead class="tbl-cabecalho">
                            <tr>
                                <th><input type="checkbox" id="chkTodos"></th>
                                <th scope="col"><strong>CPF</strong></th>
                                <th scope="col"><strong>Nome</strong></th>
                                <th scope="col"><strong>Operadora</strong></th>
                                <th scope="col"><strong>Unidade</strong></th>
                                <th scope="col"><strong>Perfil</strong></th>
                                <th scope="col"><strong>Status</strong></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($operadores as $operador)
                                <tr>
                                    <td scope="row">
                                        <input type="checkbox" name="chkBanco[]" class="chkOperador" value="{{$operador->idoperadora}}">
                                    </td>
                                    <td scope="row" class="clickable" data-id="{{$operador->id}}" id="cpf">{{$operador->cpf}} </td>
                                    <td scope="row" class="clickable" data-id="{{$operador->id}}">{{$operador->nome}} </td>
                                    <td scope="row" class="clickable" data-id="{{$operador->id}}">{{$operador->operadora}} </td>
                                    <td scope="row" class="clickable" data-id="{{$operador->id}}">{{$operador->unidade}} </td>
                                    <td scope="row" class="clickable" data-id="{{$operador->id}}">{{$operador->perfil}} </td>
                                    <td scope="row" class="clickable" data-id="{{$operador->id}}">{{$operador->status == 'A' ? 'Ativo' : 'Inativo'}} </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    $(document).ready(function(){

        $(".clickable").click(function() {    
            window.location.href = "{{url('/')}}/operador/alterar/" + $(this).data('id')
        });
        
        $("#chkTodos").click(function() {
            
            if($('#chkTodos').is(':checked')){

                $('.chkOperador').attr('checked', true);
            }else{

                $('.chkOperador').attr('checked', false);
            }
        });

        $("#consultar").click(function() {
            
            $('form').submit();
        });

        $('#filtrar').click(function(event) {
            var divFiltro = $('#filtro_avancado');
            divFiltro.toggle();
            event.stopPropagation;            
        });

        $('td[id^=cpf').each(function() {
            $(this).mask('000.000.000-00', {reverse: false});
        });
        $('#filtrar').css('margin-left','6px');
    });
</script>
@endsection
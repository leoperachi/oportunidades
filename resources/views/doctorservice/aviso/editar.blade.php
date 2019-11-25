@extends('layouts.app')

@section('content')

<div class="card" id="app">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('aviso.listar') }}">Aviso</a></li>
                <li class="breadcrumb-item active" aria-current="page"><strong>Edição</strong></li>
            </ol>
        </nav>
        <div id="registros">
            <form method="POST" action="{{route('aviso.atualizar', $aviso->id)}}">
                @method('PUT')
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Módulo:</label>
                    <div class="col-sm-10">
                        <select name="modulo" id="modulo" class="form-control" onchange="selecionarModulos()">
                        @foreach ($modulos as $modulo)
                            @if ($modulo->id === $aviso->idmodulo)
                                <option value="{{$modulo->id}}" selected>{{$modulo->nome}}</option>
                            @else
                                <option value="{{$modulo->id}}">{{$modulo->nome}}</option>
                            @endif
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Operadora:</label>
                    <div class="col-md-10" style="padding-top: 15px;">
                        <select name="operadora" id="operadora" class="form-control" onchange="selecionarOperadoras()">
                            <option value="">Selecione</option>
                            @foreach ($operadoras['original'] as $op)
                                @if ($op['id'] == $aviso->idoperadora)
                                    <option value="{{$op['id']}}" selected>{{$op['nome_fantasia']}}</option>
                                @else
                                    <option value="{{$op['id']}}">{{$op['nome_fantasia']}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Unidade:</label>
                    <div class="col-sm-10" style="padding-top: 15px;">
                        <select name="unidade" id="unidade" class="form-control">
                            <option value="">Selecione</option>
                            @foreach ($unidades['original'] as $unidade)
                                @if ($aviso->idoperadora_unidade == $unidade['id'])
                                    <option value="{{$unidade['id']}}" selected>{{$unidade['nome']}}</option>
                                @else
                                    <option value="{{$unidade['id']}}">{{$unidade['nome']}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Grupo:</label>
                    <div class="col-sm-10" style="padding-top: 15px;">
                        <select name="unidade" id="grupo_medico" class="form-control">
                            <option value="">Selecione</option>
                            @foreach ($grupos['original'] as $grupo)
                                @if ($grupo['id'] == $aviso->idoperadora_grupo_medico)
                                    <option value="{{$grupo['id']}}" selected>{{$grupo['nome']}}</option>
                                @else
                                    <option value="{{$grupo['id']}}">{{$grupo['nome']}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Mensagem:</label>
                    <div class="col-sm-10">
                        <textarea name="mensagem" placeholder="Sua mensagem..." rows="3" class="form-control rounded-0">{{$aviso->mensagem}}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">URL:</label>
                    <div class="col-md-10">
                        <input type="text" name="url" placeholder="http://www.exemplo.com" class="form-control" value="{{$aviso->url}}">
                        <p>Use http://</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="visivel1" class="col-md-2 col-form-label">Visivel:</label>
                    <div style="margin: 20px 15px;">
                        <input type="checkbox" name="visivel" id="visivel" v-model="visivel">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Data:</label>
                    <div class="col-md-10">
                        <input type="datetime-local" name="data" class="form-control" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}">
                        <p>(dd/mm/aaaa hh:mm)</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Visível Até</label>
                    <div class="col-md-10">
                        <input type="datetime-local" name="data_hora_encerramento" class="form-control" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}">
                        <p>(dd/mm/aaaa hh:mm)</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status:</label>
                    <div class="col-sm-2">
                        <select name="status" class="form-control form-control-md">
                            <option value="A" {{($aviso->ativo == 'A')?'selected':''}}>Ativo</option>
                            <option value="I" {{($aviso->ativo == 'I')?'selected':''}}>Inativo</option>
                        </select>
                    </div>
                </div>
                <div style="float: right;">
                    <input type="submit" class="btn btn-success" name="salvar" value="Salvar">
                    <input type="submit" class="btn btn-default" name="remover" value="Remover">
                    <a href="{{ route('aviso.listar') }}" class="btn btn-default" name="cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
    <script>

        $(document).ready(function() {
            $('#operadora').select2();
            new Vue({
             el: '#app',
             data: {
                 visivel: "{{$aviso->visivel == 1 ? 'checked' : ''}}"
             }
            })
    </script>
    <script>
        $(document).ready(function() {
            $('#operadora').select2();
            $('#unidade').select2();
            $('#grupo_medico').select2();
        });
        function selecionarModulos(){
            var idModulo = $('#modulo').val();
            if (idModulo != 1) {
                resetSelects()
                getOperadoras();
            }else{
                resetSelects();
            }
        }
        function resetSelects() {
            $('#operadora').html('<option value="">Selecione</option>');
            $('#unidade').html('<option value="">Selecione</option>');
            $('#grupo_medico').html('<option value="">Selecione</option>');
        }

        function selecionarOperadoras(){
            var idOperadora = $('#operadora').val();
            if (idOperadora) {
                $('#unidade').html('<option value="">Selecione</option>');
                $('#grupo_medico').html('<option value="">Selecione</option>');
                getUnidades(idOperadora);
                getGrupoMedico(idOperadora);
            }
        }

        function getOperadoras() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var operadoras = JSON.parse(this.responseText);
                    $('#unidade').html('<option value="">Selecione</option>');
                    var select = document.getElementById("operadora");
                    operadoras.forEach(function(operadora) {
                        var option = document.createElement('option');
                        option.setAttribute('value', operadora['id']);
                        option.innerText = operadora['nome_fantasia'];
                        select.append(option);
                    });
                }
            };
            xhttp.open("GET", "{{route('aviso.operadoras')}}", true);
            xhttp.send();
        }

        function getUnidades(id) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var unidades = JSON.parse(this.responseText);
                    if($.isEmptyObject(unidades)){
                        $('#unidade').html('<option value="">Selecione</option>');
                    }else{
                        var select = document.getElementById("unidade");
                        unidades.forEach(function(unidade) {
                            var option = document.createElement('option');
                            option.setAttribute('value', unidade['id']);
                            option.innerText = unidade['nome'];
                            select.append(option);
                        });
                    }
                }
            };
            xhttp.open("GET", "/aviso/operadoras/unidades/"+id, true);
            xhttp.send();
        }

        function getGrupoMedico(id){
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var gruposMedicos = JSON.parse(this.responseText);
                    if($.isEmptyObject(gruposMedicos)){
                        $('#grupo_medico').html('<option value="">Selecione</option>');
                    }else{
                        var select = document.getElementById("grupo_medico");
                        gruposMedicos.forEach(function(grupoMedico) {
                            var option = document.createElement('option');
                            option.setAttribute('value', grupoMedico['id']);
                            option.innerText = grupoMedico['nome'];
                            select.append(option);
                        });
                    }
                }
            };
            xhttp.open("GET", "/aviso/operadoras/"+id+"/grupo_medico", true);
            xhttp.send();
        }
        
    </script>
@endsection

@endsection

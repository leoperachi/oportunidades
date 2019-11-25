@extends('layouts.app')

@section('content')
    
<div class="card" id="app">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
              <li class="breadcrumb-item" aria-current="page"><a href="{{ route('aviso.listar') }}">Aviso</a></li>
              <li class="breadcrumb-item active" aria-current="page"><strong>Cadastro</strong></li>
            </ol>
        </nav>
        <div id="registros">
            <form method="POST" action="{{route('aviso.cadastrar')}}">
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
                        <select name="modulo" id="modulo" class="form-control" v-model="modulo" onchange="selecionarModulos()">
                            @foreach ($modulos as $modulo)
                                <option value="{{$modulo->id}}">{{$modulo->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Operadora:</label>
                    <div class="col-md-10" style="padding-top:15px;">
                        <select name="operadora" id="operadora" class="form-control" :disabled="modulo == 4" onchange="selecionarOperadoras()">
                            <option value="">Selecione</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Unidade:</label>
                    <div class="col-sm-10">
                        <select name="unidade" id="unidade" class="form-control" :disabled="modulo == 4">

                            <option value="">Selecione</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Grupo Médico:</label>
                    <div class="col-sm-10">
                        <select name="grupo_medico" id="grupo_medico" class="form-control" :disabled="modulo == 4">
                            <option value="">Selecione</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Mensagem:</label>
                    <div class="col-sm-10">
                        <textarea name="mensagem" placeholder="Sua mensagem..." rows="3" class="form-control rounded-0">{{old('mensagem')}}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">URL:</label>
                    <div class="col-md-10">
                        <input type="email" name="url" placeholder="http://www.exemplo.com" class="form-control" value="{{old('url')}}">
                        <p>Use http://</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="visivel1" class="col-md-2 col-form-label">Visivel:</label>
                    <div style="margin: 20px 15px;">
                        <input type="checkbox" name="visivel" id="visivel1" value="{{old('visivel')}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Data:</label>
                    <div class="col-md-10">
                        <input type="datetime-local" id="data_hora_abertura" name="data_hora_abertura" class="form-control" 

                        pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}">
                        <p>(dd/mm/aaaa hh:mm)</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Visível Até</label>
                    <div class="col-md-10">
                        <input type="datetime-local" name="data_hora_encerramento" class="form-control"
                        pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}">
                        <p>(dd/mm/aaaa hh:mm)</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status:</label>
                    <div class="col-sm-2">
                        <select name="status" class="form-control form-control-md">
                            <option value="A" selected>Ativo</option>
                            <option value="I">Inativo</option>
                        </select>
                    </div>
                </div>                
                <div class="btn-cadastro">
                    <input type="submit" class="btn btn-success" name="salvar" value="Salvar">
                    <a href="{{ route('aviso.listar') }}" class="btn btn-default" name="cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        new Vue({
            el: '#app',
            data: {
                modulo: 4
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#operadora').select2();
            $('#unidade').select2();
            $('#grupo_medico').select2();            
        });
        function selecionarModulos(){
            var idModulo = $('#modulo').val();
            if (idModulo != 4) {
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

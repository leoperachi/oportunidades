@extends('layouts.app')

@section('content')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
    <div class="card" id="vagas">
        <div class="card-body">
            <div id="vaga">
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="escala">Escala</label>
                                <input type="text" class="form-control" id="escala" name="escala" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unidade">Unidade</label>
                                <select class="form-control" name="unidade" id="unidade" v-model="unidade">
                                    <option></option>
                                    @foreach($unidades as $unidade)
                                        <option value="{{$unidade->id}}">{{$unidade->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unidade">Sala</label>
                                <select class="form-control" name="sala" id="sala" v-model="sala" v-bind:readonly="!isDisabledSala">
                                    <option v-for="s in salas" :value="s.id">@{{s.nome}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="especialidade">Especialidade</label>
                                <select class="form-control" name="especialidade" id="especialidade">
                                    <option></option>
                                    @foreach($especialidades as $especialidade)
                                        <option value="{{$especialidade->id}}">{{$especialidade->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="data_inicio">Início</label>
                                <input type="text" class="form-control" id="data_inicio" name="data_inicio" data-toggle="datetimepicker" data-target="#data_inicio">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="data_fim">Fim</label>
                                <input type="text" class="form-control" id="data_fim" name="data_fim" data-toggle="datetimepicker" data-target="#data_fim">
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="medico">Médico</label>
                                <select class="form-control" name="medico" id="medico">

                                </select>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tabela_preco">Tabela de preço</label>
                                <select class="form-control" name="tabela_preco" id="tabela_preco" v-model="tabela_preco" v-bind:readonly="!isDisabledSala">
                                    <option v-for="p in precos" :value="p.id">@{{p.nome}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clt">Tipo de contratação</label>
                                @foreach($tipoContratacoes as $tipoContratacao)
                                    <label class="" for="contrato-{{$tipoContratacao->id}}">
                                        <input type="checkbox" class="" id="contrato-{{$tipoContratacao->id}}" name="tipo_contratacao[]" value="{{$tipoContratacao->id}}">
                                        {{$tipoContratacao->nome}}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modalidade_pagamento">Modalidade de pagamento</label>
                                @foreach($modalidadesPag as $modalidadePag)
                                    <label class="" for="modalidade-{{$modalidadePag->id}}">
                                        <input type="checkbox" class="" id="modalidade-{{$modalidadePag->id}}" name="modalidade_pagamento[]" value="{{$modalidadePag->id}}">
                                        {{$modalidadePag->nome}}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tabela_preco">Bônus</label>
                                <input type="text" class="form-control" id="bonus" name="bonus">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="possivel_clt">Possível CLT</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="possivel_clt" name="possivel_clt">
                                    <label class="custom-control-label" for="possivel_clt">Sim</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="visibilidade">Visibilidade</label>
                                <select class="form-control" name="visibilidade" id="visibilidade">
                                    <option value="P">Público</option>
                                    <option value="PR">Privado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="recorrencia">Recorrencia</label>
                                <select class="form-control" name="recorrencia" id="recorrencia" v-model="recorrencia">
                                    <option value="D">Diária</option>
                                    <option value="S">Semanal</option>
                                    <option value="M">Mensal</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="recorrencia == 'D' || recorrencia == 'M'">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="data_fim">Recorrencia Fim</label>
                                <input type="text" class="form-control" id="data_fimrecorrencia" name="data_fimrecorrencia" data-toggle="datetimepicker" data-target="#data_fimrecorrencia">
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="recorrencia == 'S'">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="modalidade_pagamento">Dias semanas recorrencia</label>
                                <br/>
                                <label for="recorrencia-dom">
                                    <input type="checkbox" id="recorrencia-dom" name="recorrencia[]" value="dom">
                                    Dom
                                </label>
                                <label for="recorrencia-seg">
                                    <input type="checkbox" id="recorrencia-seg" name="recorrencia[]" value="seg">
                                    Seg
                                </label>
                                <label for="recorrencia-ter">
                                    <input type="checkbox" id="recorrencia-ter" name="recorrencia[]" value="ter">
                                    Ter
                                </label>
                                <label for="recorrencia-qua">
                                    <input type="checkbox" id="recorrencia-qua" name="recorrencia[]" value="qua">
                                    Qua
                                </label>
                                <label for="recorrencia-qui">
                                    <input type="checkbox" id="recorrencia-qui" name="recorrencia[]" value="qui">
                                    Qui
                                </label>
                                <label for="recorrencia-sex">
                                    <input type="checkbox" id="recorrencia-sex" name="recorrencia[]" value="sex">
                                    Sex
                                </label>
                                <label for="recorrencia-sab">
                                    <input type="checkbox" id="recorrencia-sab" name="recorrencia[]" value="sab">
                                    Sáb
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="observacao">Observação</label>
                                <textarea  class="form-control" id="observacao" name="observacao"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <input type="submit" class="btn btn-primary" style="margin-left:10px;" value="Salvar">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#data_inicio').datetimepicker({
            format: 'DD/MM/Y'
        });
        $('#data_fim').datetimepicker({
            format: 'DD/MM/Y'
        });
        $('#data_fimrecorrencia').datetimepicker({
            format: 'DD/MM/Y'
        });
    });
    var app = new Vue({
        el: '#vagas',
        data:{
            unidade: "",
            isDisabledSala: false,
            salas: [],
            precos: [],
            recorrencia: ""
        },
        methods:{

        },
        watch: {
            unidade: function (val) {

                if(val != ""){

                    this.$http.get('{{route("tabela.buscar.buscar-por-unidade")}}/' + val).then(response => {

                        this.precos = response.body.vagas;

                        this.isDisabledSala = true;
                    });
                }else{

                    this.isDisabledSala = false;
                }

                if(val != ""){

                    this.$http.get('{{route("sala.buscar.buscar-por-unidade")}}/' + val).then(response => {

                        this.salas = response.body.salas;

                        this.isDisabledSala = true;
                    });
                }else{

                    this.isDisabledSala = false;
                }
            },
        }
    });
</script>
@endsection
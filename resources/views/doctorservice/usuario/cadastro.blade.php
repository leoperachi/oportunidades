@extends('layouts.app')

@section('content')
    
<div class="card" id="usuario">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('usuario.listar') }}">Usuário</a></li>
                <li class="breadcrumb-item active" aria-current="page"><strong>Cadastro</strong></li>
            </ol>
        </nav>
        <div id="registros">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{route('usuario.cadastrar')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Módulo:</label>
                    <div class="col-sm-10">
                        <select name="modulo" id="modulo" v-model="modulo" 
                        v-on:change="buscarPerfis(modulo)" class="form-control">
                            <option value="">Selecione</option>
                            @foreach ($modulos as $modulo)
                                <option value="{{$modulo->id}}">{{$modulo->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Perfil:</label>
                    <div class="col-md-10">
                        <select name="perfil" id="perfil" class="form-control">
                            <option value="">Selecione</option>
                            <option v-for="p in perfil" :value="p.id" >@{{p.nome}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row" v-show="modulo == 2">
                    <label class="col-sm-2 col-form-label">Operadora:</label>
                    <div class="col-md-10">
                        <select name="operadora" id="operadora" class="form-control">
                            <option value="">Selecione</option>
                            @foreach ($operadoras as $operadora)
                                <option value="{{$operadora->id}}">{{$operadora->nome_operadora}}</option>
                            @endforeach                            
                        </select>                            
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label id="label-cpf" class="col-form-label col-md-3">CPF:</label>
                            <select name="cpf" id="cpf" class="form-control">
                                <option value="">Selecione</option>
                                <option v-for="usuario in usuarios" :value="usuario.cpf">@{{ usuario.cpf }}</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label id="label-nome" class="col-form-label col-md-4">Nome:</label>
                            <select name="idpessoa" id="nome" class="form-control" onchange="getNome()">
                                <option value="">Selecione</option>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{$usuario->id}}">{{$usuario->nome}}</option>              
                                @endforeach
                            </select>
                            <input type="hidden" name="nome" id="pessoa" value="">
                            {{-- <select name="nome" class="form-control" id="nome" v-model="nome" v-on:change="getIdPessoa(nome)">
                                <option value="">Selecione</option>                            
                                <option v-for="usuario in usuarios" :value="usuario.nome">
                                    @{{ usuario.nome }}
                                </option>                            
                            </select> --}}
                        </div>
                    </div>
                </div>
                {{-- <div class="form-group row"> --}}
                {{-- </div> --}}
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Sexo:</label>
                    <div class="col-md-4">
                        <select name="sexo" id="sexo" class="form-control">
                            <option value="">Selecione</option>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Estado Civil:</label>
                    <div class="col-md-4">
                        <select name="estado_civil" id="estado_civil" class="form-control">
                            <option value="">Selecione</option>
                            @foreach ($estadoCivil as $estado)
                                <option value="{{$estado->id}}">{{$estado->estado}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Data de Nascimento:</label>
                    <div class="col-md-4 input-group-date" style="padding-top:10px;">
                        <input type="text" name="data_nascimento" id="data_nascimento" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Apelido:</label>
                    <div class="col-md-10">
                        <input type="text" name="apelido" class="form-control">
                        <p>Como gosta de ser chamado.</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">E-mail:</label>
                    <div class="col-md-10">
                        <input type="email" name="email" class="form-control" placeholder="dominio@email.com.br">
                    </div>
                </div>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                <div class="form-group row">
                    <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                    <div class="col-md-10" style="padding-top:15px;">
                        <input type="file" name="foto" id="foto" readonly>
                        <p>(JPG ou PNG)</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="senha" class="col-sm-2 col-form-label">Senha:</label>
                    <div class="col-md-10">
                        <input type="password" name="password" v-model="senha" id="senha" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}">
                    </div>
                </div>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <div class="form-group row">
                    <label for="senha" class="col-sm-2 col-form-label">Confirmar Senha:</label>
                    <div class="col-md-10">
                        <input type="password" name="password_confirmation" v-model="confirmSenha" id="confirmSenha" class="form-control">
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
                    <input type="submit" class="btn btn-primary" name="salvar" value="Salvar">
                    <a href="{{ route('usuario') }}" class="btn btn-default" name="cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function() {            
            $('#data_nascimento').mask('00/00/0000');
            $('.select2-selection.select2-selection--single').css('margin-top','15px');
            $('.select2-selection__arrow').css('top','15px');
        });
        function getNome() {
            var select = document.getElementById('nome');
            var option = select.children[select.selectedIndex];
            var texto = option.textContent;
            document.getElementById('pessoa').value = texto;
            var valor = parseInt(option.value);
            if(isNaN(valor)){
                option.value = '';
            }
        }
    </script>
    <script>
        new Vue({
            el: '#usuario',
            data: {
                modulo: '',
                perfil: '',
                usuarios: '',
                nome: '',
                cpf: '',
                senha: null,
                confirmSenha: null,
                errors: []
            },
            methods: {
                buscarPerfis(modulo){
                    this.$http.get('/usuario/perfil/' + this.modulo).then(function(res) {
                        this.perfil = res.data;
                    });
                }
            },
            mounted: function () {
                $('#nome').select2({
                    tags: true
                });
                $('#cpf').select2({
                    tags: true,
                    maximumInputLength: 11
                });
                this.$nextTick(function () {
                    this.$http.get("{{route('usuario.nome')}}").then(function(res) {
                        this.usuarios = res.data;
                    });
                })
            }
        });
    </script>
    
@endsection

@endsection
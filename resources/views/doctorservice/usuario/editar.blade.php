@extends('layouts.app')

@section('content')

<div class="card" id="usuario">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('usuario.listar') }}">Usuário</a></li>
                <li class="breadcrumb-item active" aria-current="page"><strong>Edição</strong></li>
            </ol>
        </nav>
        <div id="registros">
            <form method="POST" action="{{route('usuario.atualizar', $usuario->id)}}">
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
                        <select name="perfil" id="perfil" v-model="perfilEscolhido" class="form-control">
                            <option value="">Selecione</option>
                        <option v-for="p in perfil" :value="p.id">@{{p.nome}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row" v-show="modulo == 2">
                    <label class="col-sm-2 col-form-label">Operadoras:</label>
                    <div class="col-md-10">
                        <select name="operadora" id="operadora" class="form-control">
                            <option value="">Selecione</option>
                            @foreach ($operadoras as $operadora)
                                <option value="{{$operadora->id}}">{{$operadora->nome_operadora}}</option>
                            @endforeach                            
                        </select>                            
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">CPF:</label>
                    <div class="col-md-4" style="padding-top: 15px;">
                        <select name="cpf" id="cpf" v-model="cpf" class="form-control">
                            <option value="">Selecione</option>
                            <option v-for="usuario in usuarios" :value="usuario.cpf">@{{ usuario.cpf }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nome:</label>
                    <div class="col-md-10" style="padding-top: 15px;">
                        <select name="idpessoa" id="nome" class="form-control" v-model="nome" onchange="getNome()">
                            <option value="">Selecione</option>
                            @foreach ($pessoas as $pessoa)
                                <option value="{{$pessoa->id}}">{{$pessoa->nome}}</option>              
                            @endforeach
                        </select>
                        <input type="hidden" name="nome" id="pessoa" :value="nomePessoa">
                        {{-- <select name="nome" class="form-control" id="nome" v-model="nome" v-on:change="getIdPessoa(nome)">
                            <option value="">Selecione</option>                            
                            <option v-for="usuario in usuarios" :value="usuario.nome">
                                @{{ usuario.nome }}
                            </option>                            
                        </select> --}}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Sexo:</label>
                    <div class="col-md-4">
                        <select name="sexo" id="sexo" class="form-control">
                            <option value="">Selecione</option>
                            <option value="M" {{($usuario->sexo == 'M') ? 'selected' : ''}}>Masculino</option>
                            <option value="F" {{($usuario->sexo == 'F') ? 'selected' : ''}}>Feminino</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Estado Civil:</label>
                    <div class="col-md-4">
                        <select name="estado_civil" id="estado_civil" class="form-control">
                            <option value="">Selecione</option>
                            @foreach ($estadoCivil as $estado)
                                @if ($usuario->idestado_civil === $estado->id)
                                    <option value="{{$estado->id}}" selected>{{$estado->estado}}</option>
                                @else
                                    <option value="{{$estado->id}}" >{{$estado->estado}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Data de Nascimento:</label>
                    <div class="col-md-4 input-group-date" style="padding-top:10px;">
                        <input type="text" name="data_nascimento" value="{{date('d/m/Y', strtotime($usuario->data_nascimento))}}" id="data_nascimento" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Apelido:</label>
                    <div class="col-md-10">
                        <input type="text" name="apelido" value="{{$usuario->apelido}}" class="form-control">
                        <p>Como gosta de ser chamado.</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">E-mail:</label>
                    <div class="col-md-10">
                        <input type="email" name="email" class="form-control" placeholder="dominio@email.com.br" value="{{$usuario->email}}">
                    </div>
                </div>
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
                        <input type="password" required name="password" v-model="senha" id="senha" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}">
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
                        <input type="password" required name="password_confirmation" v-model="confirmSenha" id="confirmSenha" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status:</label>
                    <div class="col-sm-2">
                        <select name="status" class="form-control form-control-md">
                            <option value="A" {{($usuario->ativo == 'A') ? 'selected' : ''}}>Ativo</option>
                            <option value="I" {{($usuario->ativo == 'I') ? 'selected' : ''}}>Inativo</option>
                        </select>
                    </div>
                </div>                
                <div class="btn-cadastro">
                    <input type="submit" class="btn btn-primary" name="salvar" value="Salvar">
                    <input type="submit" class="btn btn-default" name="remover" value="Remover">
                    <a href="{{ route('usuario.listar') }}" class="btn btn-default" name="cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function() {            
            $('#data_nascimento').mask('00/00/0000');            
        });
        function getNome() {
            var select = document.getElementById('nome');
            var option = select.children[select.selectedIndex];
            var texto = option.textContent;
            var valor = parseInt(option.value);
            document.getElementById('pessoa').value = texto;
            if(isNaN(valor)){
                option.value = '';
            }
        }
    </script>
    <script>
        new Vue({
            el: '#usuario',
            data: {
                modulo: "{{$usuario->idmodulo != '' ? $usuario->idmodulo : 'Selecione'}}",
                perfil: '',
                perfilEscolhido: '{{$usuario->idperfil != '' ? $usuario->idperfil : ''}}',
                nomePessoa: '{{$usuario->name != '' ? $usuario->name : ''}}',
                usuarios: '',
                nome: '{{$usuario->idpessoa != '' ? $usuario->idpessoa : ''}}',
                cpf: '{{$usuario->cpf != '' ? $usuario->cpf : ''}}',
                senha: null,
                confirmSenha: null
            },
            methods: {
                buscarPerfis(modulo){
                    this.$http.get('/usuario/perfil/' + this.modulo).then(function(res) {
                        this.perfil = res.data;
                        console.log(this.modulo);
                    });
                }
            },
            mounted: function () {
                $('#nome').select2({
                    tags: true
                });
                $('#cpf').select2({
                    tags: true
                });
                this.$nextTick(function () {
                    this.$http.get("{{route('usuario.nome')}}").then(function(res) {
                        this.usuarios = res.data;
                        console.log(this.usuarios);
                    });
                });
                this.buscarPerfis(this.modulo);
            }
        });
    </script>
@endsection

@endsection
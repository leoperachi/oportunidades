<header>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>

    <!-- <script src="https://github.com/igorescobar/jQuery-Mask-Plugin/blob/master/dist/jquery.mask.min.js"></script> -->
</header>

<div id="operador">
    <form method="POST" enctype="multipart/form-data" {{isset($operador->id) ? 'action='.route('operador.alterar', ['id' => $operador->id]).'' : ''}}>
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
        <div class="row">    
            <div class="col-md-10">
                <div class="form-group">
                    <label for="perfil">Perfil</label>
                    <select class="form-control" name="perfil" id="perfil">
                        @if(isset($operador->perfil))
                            <option value="{{$operador->idperfil}}">{{$operador->perfil}}</option>
                        @else
                            <option value=""></option>
                            @foreach($perfis as $perfil)
                                <option value="{{$perfil->id}}">{{$perfil->nome}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{$operador->nome}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <!-- <input type="text" class="form-control" id="cpf" name="cpf" value="{{$operador->cpf}}"> -->
                    <select class="form-control" name="cpf" id="cpf">
                        @if(isset($operador->cpf))
                            <option value="{{$operador->cpf}}">{{$operador->nome.' - '.$operador->cpf}}</option>
                        @else
                            <option value=""></option>
                            @foreach($pessoas as $pessoa)
                                <option value='{{$pessoa->cpf}}'>{{$pessoa->nome.' - '.$pessoa->cpf}}</option>
                            @endforeach
                        @endif
                    </select>
                    <!-- <input type="text" class="form-control" id="cpf" name="cpf" data-mask-clearifnotmatch="true"> -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="apelido">Apelido</label>
                    <input type="text" class="form-control" name="apelido" id="apelido" value="{{$operador->apelido}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select class="form-control" name="sexo" id="sexo" value="{{$operador->sexo}}">
                        @if(isset($operador->sexo))
                            <option value="{{$operador->sexo}}">{{$operador->sexo == 'F' ? 'Feminino' : 'Masculino'}}</option>
                            <option value="{{$operador->sexo == 'F' ? 'M' : 'F'}}">{{$operador->sexo == 'F' ? 'Masculino' : 'Feminino'}}</option>
                        @else
                            <option value="F">Feminino</option>
                            <option value="M">Masculino</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="dataNascimento">Data de Nascimento</label>
                    <input type="date" class="form-control" id="data-nascimento" name="dataNascimento" value="{{$operador->dataNascimento}}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-10">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{$operador->email}}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="foto" style="margin-bottom: 16px; margin-top: 16px;">Foto</label>
                        <input type="file" id="foto" class="filepond" name="foto" data-max-file-size="3MB">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <!-- <div class="form-group">
                        <label for="senha" >Senha</label>
                        <input id="senha" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="senha" required>
                    </div> -->

                    @if ($errors->has('senha'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('senha') }}</strong>
                        </span>
                    @endif
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control{{ $errors->has('senha') ? ' is-invalid' : '' }}" name="senha" id="senha" required="requerid">
                        <div id="senhaBarra" class="progress" style="display: none; height: 14px; background-color: white;">
                            <div id="senhaForca" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 0.8rem; font-size: 0.78rem;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="senha_confirmation" >Senha Confirmação</label>
                        <input id="senha_confirmation" type="password" class="form-control{{ $errors->has('senha_confirmation') ? ' is-invalid' : '' }}" name="senha_confirmation" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="operadora">Operadora</label>
                        <!-- <select class="form-control" name="operadora" id="operadora"> -->
                        <select class="form-control" name="operadora" id="operadora" onChange="selecionarOperadoras()">
                            <option value=""></option>
                                @if(isset($operador->operadora))
                                    <option value="{{$operador->idoperadora}}">{{$operador->operadora}}</option>
                                @else
                                    <option value=""></option>
                                    @foreach($operadoras as $operadora)
                                        <option value="{{$operadora->id}}">{{$operadora->nome}}</option>
                                    @endforeach 
                                @endif
                        </select>   
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="unidade">Unidade</label>
                        <!-- <select class="form-control" name="unidade" id="unidade"> -->
                        <select class="form-control" name="unidade" id="unidade" >
                            
                            <option value="">Selecione</option>
                        </select>   
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{$operador->telefone}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="celular">Celular</label>
                    <input type="text" class="form-control" id="celular" name="celular" value="{{$operador->celular}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="ramal">Ramal</label>
                    <input type="text" class="form-control" id="ramal" name="ramal" value="{{$operador->ramal}}">
                </div>
            </div>
            
            <div class="col-md-3">
                    <label for="cidade">CEP</label>
                    <input type="text" class="form-control" id="cep" v-model="cep" name="cep" value="{{$operador->cep}}">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-default mg-top-34" v-on:click="buscarCep">
                        <i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="endereco">Endereco</label>
                    <input type="text" class="form-control" id="endereco" v-model="endereco" name="endereco">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="bairro">Bairro</label>
                    <select class="form-control" name="bairro" id="bairro" v-bind:readonly="!isDisabledBairro" v-model="bairro">
                        <option v-for="b in bairros" :value="b.id">@{{b.bairro}}</option>
                    </select>
                </div>
            </div>
                <div class="form-group">
                    <button class="btn btn-default mg-top-34" v-bind:disabled="!isDisabledBairro" v-on:click="adicionarBairro">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                </div>
                
            <div class="col-md-2">
                <div class="form-group">
                    <label for="uf">UF</label>
                    <select class="form-control" name="uf" id="uf" v-model="uf" v-bind:readonly="!isDisabledUf">
                        <option v-for="estado in ufs" :value="estado.id">@{{estado.estado}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="cidade">Cidade</label>
                    <select class="form-control" name="cidade" id="cidade" v-bind:readonly="!isDisabledCidade" v-model="cidade">
                        <option v-for="c in cidades" :value="c.id">@{{c.cidade}}</option>
                    </select>
                </div>
            </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <button class="btn btn-default mg-top-34" v-bind:disabled="!isDisabledCidade" v-on:click="adicionarCidade">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1" {{$operador->status == 'A' ? 'checked' : ''}} name="status" Checked>
                            <label class="custom-control-label" for="customSwitch1">Ativo</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <input type="submit" class="btn btn-primary" style="margin-left:10px;" value="Salvar">
            </div>
        </div>
    </form>
</div>
    <div class="area-modal">
        <div class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@{{modal.titulo}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="form-control" v-model="modal_input">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" v-on:click="salvarModal">Salvar</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script type="text/javascript">

function selecionarOperadoras(){
    var id = $('#operadora').val();
    console.log(id);
    if (id) {
        $('#unidade').html('<option value="">Selecione</option>');
        getUnidades(id);
    }else{
        console.log('id com erro da operadora');
    }
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

$(document).ready(function(){
    

    $('#cpf').select2({
        tags: true,
        maximumInputLength: 11
    });
    // $('#cpf').mask('000.000.000-00', {reverse: true});


    $('#operadora').select2();

    //correção css do select2 CPF
    $('.select2-selection.select2-selection--single').css('margin-top','22px');
    $('.select2-selection__arrow').css('top','23px');

    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginImageExifOrientation,
        FilePondPluginFileValidateSize
    );
    
    FilePond.setOptions({
        server: {
            url: '/upload',
            process: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }
        }
    });

    const inputElement = document.querySelector('input[type="file"]');
    const pond = FilePond.create( inputElement );

    $(function (){
        $('#senha').keyup(function (e){
            var senha = $(this).val();        
            if(senha == ''){
                $('#senhaBarra').hide();
            }else{
                var fSenha = forcaSenha(senha);
                var texto = "";
                $('#senhaForca').css('width', fSenha + '%');
                $('#senhaForca').removeClass();
                $('#senhaForca').addClass('progress-bar');
                if(fSenha <= 40){
                    texto = 'Fraca';
                    $('#senhaForca').addClass('progress-bar-danger');
                    $('#senhaForca').css("background-color","#D50000");
                }
                if(fSenha > 40 && fSenha <= 70){
                    texto = 'Razoavel';
                    $('#senhaForca').css("background-color","#FFCC80");

                }if(fSenha > 70 && fSenha <= 90){
                    texto = 'Boa';
                    $('#senhaForca').addClass('progress-bar-success');
                    $('#senhaForca').css("background-color","#00E676");
                }if(fSenha >= 90){
                    texto = 'Muito boa';
                    $('#senhaForca').addClass('progress-bar-success');
                    $('#senhaForca').css("background-color","#00C853");

                }

                $('#senhaForca').text(texto);
                $('#senhaBarra').show();
            }
        });
    });
    
    function forcaSenha(senha){
        var forca = 0;
        
        var regLetrasMa     = /[A-Z]/;
        var regLetrasMi     = /[a-z]/;
        var regNumero       = /[0-9]/;
        var regEspecial     = /[!@#$%&*?]/;
        
        var tam         = false;
        var tamM        = false;
        var letrasMa    = false;
        var letrasMi    = false;
        var numero      = false;
        var especial    = false;

    //    console.clear();
    //    console.log('senha: '+senha);

        if(senha.length >= 8) tam = true;
        if(senha.length >= 10) tamM = true;
        if(regLetrasMa.exec(senha)) letrasMa = true;
        if(regLetrasMi.exec(senha)) letrasMi = true;
        if(regNumero.exec(senha)) numero = true;
        if(regEspecial.exec(senha)) especial = true;
        
        if(tam) forca += 10;
        if(tamM) forca += 10;
        if(letrasMa) forca += 10;
        if(letrasMi) forca += 10;
        if(letrasMa && letrasMi) forca += 20;
        if(numero) forca += 20;
        if(especial) forca += 20;
            
    //    console.log('força: '+forca);
        
        return forca;
    }
    // $('#unidade').prop('disabled',true);
    // $('#cpf').mask('000.000.000-00', {reverse: false});
    // $('#cep').mask('00000-000');
    $('#telefone').mask('(00) 0000-0000');
    $('#celular').mask('(00) 00000-0000');
    $('#ramal').mask('0000');
});
// moment($('#data-nascimento')).format("dd/MM/yyyy");

var app = new Vue({
  el: '#operador',
  data: {
    cep: "{{$operador->cep != '' ? $operador->cep : ''}}",
    pais: "{{$operador->idpais != '' ? $operador->idpais : ''}}",
    uf: "{{$operador->idpais != '' ? $operador->idpais : ''}}",
    ufs: {!!isset($estados) ? $estados : '[]' !!},
    cidades: {!!isset($cidades) ? $cidades : '[]' !!},
    cidade: "{{$operador->idcidade != '' ? $operador->idcidade : ''}}",
    bairro: "{{$operador->idbairro != '' ? $operador->idbairro : ''}}",
    bairros: {!! isset($bairros) ? $bairros : '[]' !!},
    endereco: "{{$operador->logradouro != '' ? $operador->logradouro : ''}}",
    modal_input: '',
    modal:{
        'titulo': "",
        'tipo': ""
    },
    isDisabledUf: {{$operador->idestado != '' ? 'true' : 'false'}},
    isDisabledCidade: {{$operador->idcidade != '' ? 'true' : 'false'}},
    isDisabledBairro: {{$operador->idbairro != '' ? 'true' : 'false'}},
    dadosCorreios: {}
  },
  methods: {
      buscarCep: function (event){

        event.preventDefault();

        if(this.cep.length == 8){

            this.pais = 1;

            this.$http.get('https://viacep.com.br/ws/' + this.cep +'/json/').then(response => {

                // get body data
                this.dadosCorreios = response.body;

                this.endereco = this.dadosCorreios.logradouro + ' ' +  this.dadosCorreios.complemento;

                this.$http.get('{{route("estado.buscar")}}?uf=' + this.dadosCorreios.uf).then(response => {

                    // get body data
                    var dadosEstado = response.body;

                    this.uf = dadosEstado.uf.id;

                    this.$http.get('{{route("cidade.buscar")}}?cidade=' + this.dadosCorreios.localidade + '&uf=' + this.uf).then(response => {

                        // get body data
                        var dadosCidade = response.body;

                        this.$http.get('{{route("cidade.buscar.buscar-por-estado")}}/' + this.uf).then(response => {

                            // get body data
                            this.cidades = response.body.cidades;

                            this.isDisabledCidade = true;

                            this.cidade = dadosCidade.cidade.id;

                            this.$http.get('{{route("bairro.buscar")}}?cidade=' + dadosCidade.cidade.id + '&bairro=' + this.dadosCorreios.bairro).then(response => {

                                // get body data
                               // this.bairros = response.body.bairros;
                               var dadosBairro = response.body;

                               this.$http.get('{{route("bairro.buscar.buscar-por-cidade")}}/' + dadosCidade.cidade.id).then(response => {

                                    // get body data
                                    this.bairros = response.body.bairros;

                                    this.isDisabledBairro = true;

                                    this.bairro = dadosBairro.bairro.id;
                               });
                            });

                        });
                    });
                });

                }, response => {
                // error callback
            });
        }else{

            alert("Formato cep inválido");
        }
      },
      adicionarCidade: function(event){

        event.preventDefault();

        $('.modal').modal('show');

        this.modal.titulo = 'Cidade';
        this.modal.tipo = 'c';
        this.modal_input = '';

      },
      adicionarBairro: function(event){

        event.preventDefault();

        $('.modal').modal('show');

        this.modal.titulo = 'Bairro';
        this.modal.tipo = 'b';
        this.modal_input = '';
      },

      salvarModal: function(event){

        event.preventDefault();
        if(this.modal.tipo == 'c'){

            this.$http.get('{{route("cidade.criar")}}?uf=' + this.uf + "&cidade=" + this.modal_input).then(response => {

                var uf = this.uf;

                this.uf = '';

                $('.modal').modal('hide')
            });
        }else if(this.modal.tipo == 'b'){

            this.$http.get('{{route("bairro.criar")}}?cidade=' + this.cidade + "&bairro=" + this.modal_input).then(response => {

                var cidade = this.cidade;

                this.cidade = '';

                $('.modal').modal('hide')
            });
        }
      }
  },
  watch: {
    pais: function (val) {

        if(val != ""){

            this.$http.get('{{route("estado.buscar.buscar-por-pais")}}/' + val).then(response => {

                // get body data
                this.ufs = response.body.estados;

                this.isDisabledUf = true;
            });
        }else{

            this.isDisabledUf = false;
        }
    },
    uf: function (val) {

      if(val != ""){

          this.$http.get('{{route("cidade.buscar.buscar-por-estado")}}/' + val).then(response => {

              // get body data
              this.cidades = response.body.cidades;

              this.isDisabledCidade = true;
          });
      }else{

          this.cidade = '';
          this.isDisabledCidade = false;
      }
    },
    cidade: function(val){

        if(val != ""){

            this.$http.get('{{route("bairro.buscar.buscar-por-cidade")}}/' + val).then(response => {

                // get body data
                this.bairros = response.body.bairros;

                this.isDisabledBairro = true;
            });
        }else{

          this.bairro = '';
          this.isDisabledCidade = false;
      }
    }
  }
})

</script>
@endsection

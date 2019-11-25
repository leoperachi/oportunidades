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
</header>

<div id="unidade">
    <form method="POST" id="form-unidade" enctype="multipart/form-data" {{isset($unidade->id) ? 'action='.route('unidade.alterar', ['id' => $unidade->id]).'' : ''}}>
    
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
            <div class="col-md-12">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{$unidade->nome}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{$unidade->telefone}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name="endereco" value="{{$unidade->endereco}}">
                </div>
            </div>
            <div class="col-md-4">
                <label for="cidade">CEP</label>
                <input type="text" class="form-control" id="cep" v-model="cep" name="cep">
            </div>
            
            <div class="col-md-1">
                <button class="btn btn-default mg-top-34" v-on:click="buscarCep">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pais">Pais</label>
                        <select class="form-control" name="pais" id="pais" v-model="pais">
                            @foreach($paises as $pais)
                                <option value="{{$pais->id}}">{{$pais->pais}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="uf">UF</label>
                        <select class="form-control" name="uf" id="uf" v-model="uf" v-bind:readonly="!isDisabledUf">
                            <option v-for="estado in ufs" :value="estado.id">@{{estado.estado}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
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
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="bairro">Bairro</label>
                    <select class="form-control" name="bairro" id="bairro" v-bind:readonly="!isDisabledBairro" v-model="bairro">
                        <option v-for="b in bairros" :value="b.id">@{{b.bairro}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="foto" style="margin-bottom: 16px; margin-top: 16px;">Foto</label>
                    <input type="file" id="foto" class="filepond" name="foto[]" multiple data-max-file-size="3MB" data-max-files="3">
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-6">
                <div class="form-group">
                    <label for="legenda" id="legenda" >legenda</label>
                    <!-- <input type="text" class="form-control" id="legenda" v-model="legenda" name="legenda"> -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="latitude">Latitude</label>
                    <input type="text" class="form-control" id="latitude" name="latitude" value="{{$unidade->latitude}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="longitude">Longitude</label>
                    <input type="text" class="form-control" id="longitude" name="longitude" value="{{$unidade->longitude}}">
                </div>
            </div>
        </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="status">Status</label>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" {{$unidade->ativo == 'A' ? 'checked' : ''}} name="ativo" checked>
                    <label class="custom-control-label" for="customSwitch1">Ativo</label>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <input id="btn_submit" type="submit" class="btn btn-primary" style="margin-left:10px;" value="salvar">
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
<script>

$(document).ready(function(){

    $('#btn_submit').on('click',function(){
        $("#form-unidade").submit();
    });
    
    $('#telefone').mask('(00) 00000-0000');

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
                },
                onload: (response) => {
                    console.log(response);
                    $('#legenda').append('<input type="text" id="legenda" name="legenda[]" class="form-control" style="width:780px;">');
                    return response;
                }
            }
        }
    });

    const inputElement = document.querySelector('input[type="file"]');
    const pond = FilePond.create( inputElement );

});

var app = new Vue({
  el: '#unidade',
  data: {
    modal_input: '',
    modal:{},
    cep: "{{$unidade->cep != '' ? $unidade->cep : ''}}",
    pais: "{{$unidade->idpais != '' ? $unidade->idpais : ''}}",
    uf: "{{$unidade->idpais != '' ? $unidade->idpais : ''}}",
    ufs: {!!isset($estados) ? $estados : '[]' !!},
    cidades: {!!isset($cidades) ? $cidades : '[]' !!},
    cidade: "{{$unidade->idcidade != '' ? $unidade->idcidade : ''}}",
    bairro: "{{$unidade->idbairro != '' ? $unidade->idbairro : ''}}",
    bairros: {!! isset($bairros) ? $bairros : '[]' !!},
    modal:{
        'titulo': "",
        'tipo': ""
    },
    isDisabledUf: {{$unidade->idestado != '' ? 'true' : 'false'}},
    isDisabledCidade: {{$unidade->idcidade != '' ? 'true' : 'false'}},
    isDisabledBairro: {{$unidade->idbairro != '' ? 'true' : 'false'}},
    dadosCorreios: {}
  },
  methods: {
      
    salvarModal: function(event){

        // event.preventDefault();
        if(this.modal.tipo == 'a'){

            this.$http.get('{{route("imagem.adicionar")}}?legenda=' + this.legenda + "&imagem=" + this.modal_input).then(response => {
                
                var legenda = this.legenda;

                this.legenda = '';

                $('.modal').modal('hide')
            });
        }else if(this.modal.tipo == 'c'){

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
    },
      buscarCep: function (event){

        // event.preventDefault();

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

        // event.preventDefault();

        $('.modal').modal('show');

        this.modal.titulo = 'Cidade';
        this.modal.tipo = 'c';
        this.modal_input = '';

      },
      adicionarBairro: function(event){

        // event.preventDefault();

        $('.modal').modal('show');

        this.modal.titulo = 'Bairro';
        this.modal.tipo = 'b';
        this.modal_input = '';
      },    
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
});


</script>
@endsection

@extends('layouts.app')

@section('content')

<div class="card" id="app">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('instituicao.listar') }}">Instituição</a></li>
                <li class="breadcrumb-item active" aria-current="page"><strong>Edição</strong></li>
            </ol>
        </nav>
        <div id="registros">
            <form method="POST" action="{{route('instituicao.atualizar', $instituicao->id)}}">
                @method('PUT')
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nome:</label>
                    <div class="col-sm-10">
                        <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{$instituicao->nome}}">
                    </div>
                </div>
                @error('nome')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descrição:</label>
                    <div class="col-sm-10">
                        <textarea name="descricao" rows="4" class="form-control rounded-0">{{$instituicao->descricao}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="pais">País:</label>
                            <select name="pais" v-model="pais" class="form-control @error('pais') is-invalid @enderror">
                            @foreach ($paises as $pais)
                                <option value="">Selecione...</option>
                                <option value="{{$pais->id}}">{{$pais->pais}}</option>
                            @endforeach
                            </select>
                            @error('pais')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="uf">UF:</label>
                            <select name="uf" v-model="uf" class="form-control @error('uf') is-invalid @enderror" v-on:change="buscarCidades(uf)">
                                <option value="">Selecione</option>
                                @foreach ($estados as $estado)
                                    <option value="{{$estado->id}}">{{$estado->estado}}</option>
                                @endforeach
                            </select>
                            @error('uf')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cidade">Cidade:</label>
                            <select name="cidade" class="form-control @error('cidade') is-invalid @enderror">
                                <option value="">Selecione</option>
                                @foreach ($cidades as $cidade)
                                    <option value="{{$cidade->id}}" {{$cidade->id == $instituicao->cidade_idcidade ? 'selected' : ''}}>
                                        {{ $cidade->cidade }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cidade')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status:</label>
                    <div class="col-sm-10">
                        <select name="status" class="form-control" value="{{$instituicao->ativo}}">
                            @if ($instituicao->ativo == 'A')
                                <option value="A" selected>Ativo</option>
                                <option value="I">Inativo</option>
                            @else
                                <option value="A" >Ativo</option>
                                <option value="I" selected>Inativo</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div style="float: right;">
                    <input type="submit" class="btn btn-success" name="salvar" value="Salvar">
                    <input type="submit" class="btn btn-default" name="remover" value="Remover">
                    <a href="{{ route('instituicao.listar') }}" class="btn btn-default" name="cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

    new Vue({
        el: '#app',
        data: {
            pais: 1,
            uf: '',
            cidades: ""
        },
        methods: {
            buscarCidades(uf) {
                this.$http.get('/instituicao/cidade/' + this.uf).then(function(res) {
                    this.cidades = res.data;
                    console.log(this.cidades);
                });
            }
        }
    });

</script>
@endsection
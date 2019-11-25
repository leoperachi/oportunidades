@extends('layouts.app')

@section('content')
    
<div class="card" id="app">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
              <li class="breadcrumb-item" aria-current="page"><a href="{{ route('prospect.listar') }}">Prospect</a></li>
              <li class="breadcrumb-item active" aria-current="page"><strong>Cadastro</strong></li>
            </ol>
        </nav>
        <div id="registros">
            <form method="GET">
                @csrf
                <input type="hidden" name="idprospect" id="idprospect" value="{{$prospectCadastrado->id}}">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nome:</label>
                    <div class="col-sm-10">
                        <input type="text" name="nome" class="form-control" value="{{$prospectCadastrado->nome}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Apelido:</label>
                    <div class="col-md-10">
                        <input type="text" name="apelido" class="form-control" value="{{$prospectCadastrado->apelido}}">
                        <p>Como gosta de ser chamado.</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">E-mail:</label>
                    <div class="col-md-10">
                        <input type="email" name="email" placeholder="exemplo@email.com" class="form-control" value="{{$prospectCadastrado->email}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Telefone:</label>
                    <div class="col-md-4">
                        <input type="tel" name="telefone" id="telefone1" class="form-control" value="{{$prospectCadastrado->telefone1}}">
                    </div>
                    <label class="col-sm-2 col-form-label">Ramal:</label>
                    <div class="col-md-4">
                        <input type="text" name="ramal1" class="form-control" value="{{$prospectCadastrado->ramal1}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Celular:</label>
                    <div class="col-md-4">
                        <input type="tel" name="celular" class="form-control" value="{{$prospectCadastrado->telefone2}}">
                    </div>
                    <label class="col-sm-2 col-form-label">Ramal:</label>
                    <div class="col-md-4">
                        <input type="text" name="ramal2" class="form-control" value="{{$prospectCadastrado->ramal2}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descrição:</label>
                    <div class="col-sm-10">
                        <textarea name="descricao" rows="2" class="form-control rounded-0">
                            {{$prospectCadastrado->descricao}}
                        </textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Status:</label>
                    <div class="col-md-10">
                       <select name="status" class="form-control">
                            @foreach ($status as $s)
                                @if ($prospectCadastrado->idstatus_prospect == $s->id)
                                    <option value="{{$s->id}}" selected>{{$s->nome}}</option>
                                @else
                                    <option value="{{$s->id}}">{{$s->nome}}</option>
                                @endif
                            @endforeach
                       </select>
                    </div>
                </div>                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Ativo:</label>
                    <div class="col-sm-2">
                        <select name="ativo" class="form-control form-control-md">
                            @if ($prospectCadastrado->ativo == 'A')
                                <option value="A" selected>Ativo</option>
                                <option value="I">Inativo</option>
                            @else
                                <option value="A">Ativo</option>
                                <option value="I" selected>Inativo</option>
                            @endif
                        </select>
                    </div>
                </div>                
                <div class="form-group">
                    <div class="row" style="padding-left: 82%;">
                        <a href="{{ route('prospect.listar') }}" class="btn btn-success" name="salvar">Salvar</a>
                        <a href="{{ route('prospect.listar') }}" class="btn btn-default" name="cancelar">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                </div>
            </div>
        </div>
    </div>

</div>

<div class="card">
    <div class="comunicacao card-body">
        <h4>Comunicação</h4>
        <a href="{{route('comunicacao.cadastro')}}" id="abrirModal" class="btn btn-primary" >Adicionar</a>
        <table class="table table-striped table-hover">
            <thead>
                <tr class="tbl-cabecalho">
                    <th>Tipo</th>
                    <th style="width: 70%">Mensagem</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comunicacao as $c)
                <tr>
                    <td>
                        @foreach ($comunicacaoTipo as $tipo)
                            @if ($c->idcomunicacao_tipo == $tipo->id)
                                {{$tipo->nome}}
                            @endif                                
                        @endforeach
                    </td>
                    <td>{{$c->mensagem}}</td>                            
                    <td>{{date('d/m/Y H:i', strtotime($c->data))}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@section('scripts')

<script>
    $('#abrirModal').on('click', function(e) {
        e.preventDefault();
        $('.modal-container').html('Carregando...');
        $('.modal').show();

        var link = $(this).attr('href');

        $.ajax({
            url: link,
            type: 'GET',
            success: function(html) {
                $('.modal-container').html(html);
                $('#close').on('click', function(e) {
                    e.preventDefault()
                    $('.modal').css('display', 'none');
                });
            }
        });
    })
</script>

@endsection

@endsection
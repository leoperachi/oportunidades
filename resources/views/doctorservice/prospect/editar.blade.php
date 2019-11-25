@extends('layouts.app')

@section('content')

<header>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
</header>

<div class="card" id="app">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('prospect.listar') }}">Prospect</a></li>
                <li class="breadcrumb-item active" aria-current="page"><strong>Edição</strong></li>
            </ol>
        </nav>
        <div id="registros">
            <form method="POST" action="{{route('prospect.atualizar', $prospect->id)}}">
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
                    <label class="col-sm-2 col-form-label">Nome:</label>
                    <div class="col-sm-10">
                        <input type="text" name="nome" class="form-control"
                        value="{{$prospect->nome}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Apelido:</label>
                    <div class="col-md-10">
                        <input type="text" name="apelido" class="form-control"
                        value="{{$prospect->apelido}}">
                        <p>Como gosta de ser chamado.</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">E-mail:</label>
                    <div class="col-md-10">
                        <input type="email" name="email" placeholder="exemplo@email.com"
                        value="{{$prospect->email}}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Telefone:</label>
                    <div class="col-md-4">
                        <input type="tel" id="telefone" name="telefone" class="form-control"
                        value="{{$prospect->telefone1}}">
                    </div>
                    <label class="col-sm-2 col-form-label">Ramal:</label>
                    <div class="col-md-4">
                        <input type="text" id="ramal1" name="ramal1" class="form-control"
                        value="{{$prospect->ramal1}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Celular:</label>
                    <div class="col-md-4">
                        <input type="tel" id="celular" name="celular" class="form-control"
                        value="{{$prospect->telefone2}}">
                    </div>
                    <label class="col-sm-2 col-form-label">Ramal:</label>
                    <div class="col-md-4">
                        <input type="text" id="ramal2" name="ramal2" class="form-control"
                        value="{{$prospect->ramal2}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descrição:</label>
                    <div class="col-sm-10">
                        <textarea name="descricao" rows="2" class="form-control rounded-0">{{$prospect->descricao}}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Status:</label>
                    <div class="col-md-10">
                        <select name="status" class="form-control">
                            @foreach ($statusProspect as $status)
                                @if ($prospect->idstatus_prospect == $status->id)
                                    <option value="{{$status->id}}" selected>{{$status->nome}}</option>
                                @else            
                                <option value="{{$status->id}}">{{$status->nome}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Ativo:</label>
                    <div class="col-sm-2">
                        <select name="ativo" class="form-control form-control-md">
                            <option value="A" {{($prospect->ativo == 'A')?'selected':''}}>Ativo</option>
                            <option value="I" {{($prospect->ativo == 'I')?'selected':''}}>Inativo</option>
                        </select>
                    </div>
                </div>                
                <div class="form-group">
                    <div class="row" style="padding-left: 70%;">
                        <input type="submit" class="btn btn-success" name="salvar" value="Salvar">
                        <input type="submit" class="btn btn-default" name="remover" value="Remover">
                        <a href="{{ route('prospect') }}" class="btn btn-default" name="cancelar">Cancelar</a>
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

    $(function (){

        $('#telefone').mask('(00) 0000-0000');
        $('#celular').mask('(00) 00000-0000');
        $('#ramal1').mask('0000');
        $('#ramal2').mask('0000');

    });
</script>

@endsection

@endsection
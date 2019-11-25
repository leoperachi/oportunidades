@extends('layouts.app')

@section('content')
    
<div class="card" id="app">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
              <li class="breadcrumb-item" aria-current="page"><a href="{{ route('convenio.listar') }}">Convenio</a></li>
              <li class="breadcrumb-item active" aria-current="page"><strong>Cadastro</strong></li>
            </ol>
        </nav>
        <div id="registros">
            <form method="POST" action="{{route('convenio.cadastrar')}}">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nome</label>
                    <div class="col-sm-10">
                        <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{old('nome')}}">
                    </div>
                </div>
                @error('nome')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descrição:</label>
                    <div class="col-sm-10">
                        <input type="text" name="descricao" class="form-control form-control-md  @error('descricao') is-invalid @enderror" value="{{old('descricao')}}">
                    </div>
                </div>
                @error('descricao')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status:</label>
                    <div class="col-sm-10">
                        <select name="status" class="form-control form-control-md">
                            <option value="A">Ativo</option>
                            <option value="I" selected>Inativo</option>
                        </select>
                    </div>
                </div>
                <br><br>
                <div class="btn-cadastro">
                    <input type="submit" class="btn btn-success" name="salvar" value="Salvar">
                    <a href="{{ route('convenio.listar') }}" class="btn btn-default" name="cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
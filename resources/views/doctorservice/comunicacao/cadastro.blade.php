<form method="POST" action="{{route('comunicacao.cadastrar')}}">
    @csrf
    <span id="close" class="close">&times;</span>
    <div class="form-group row">
        <h5 class="col-sm-3 col-form-label"><b>Comunicação</b></h5>
    </div>
    <div class="form-group row">
        <label for="tipo" class="col-sm-2 col-form-label">Tipo:</label>
        <div class="col-md-10">
            <select name="tipo" class="form-control @error('tipo') is-invalid @enderror">
                <option value="">Selecione</option>
                @foreach ($tipo as $t)
                    <option value="{{$t->id}}">{{$t->nome}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @error('tipo')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="form-group row">
        <label for="mensagem" class="col-sm-3 col-form-label">Mensagem:</label>
        <div class="col-md-9">
            <textarea name="mensagem" class="form-control" rows="5"></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="data" class="col-sm-2 col-form-label">Data:</label>
        <div class="col-md-10">
            <input type="datetime-local" name="data" class="form-control">
        </div>
    </div>
    <div class="form-group row">
            <label for="ativo" class="col-sm-2 col-form-label">Status:</label>
            <div class="col-sm-10">
                <select name="ativo" class="form-control form-control-md">
                    <option value="A" selected>Ativo</option>
                    <option value="I">Inativo</option>
                </select>
            </div>
        </div>
    <div class="form-group row" style="float: right">
        <div class="col-md-12" >
            <a href="{{route('prospect')}}" id="close" class="btn btn-secondary">Cancelar</a>
            <button class="btn btn-success">Salvar</button>
        </div>
    </div>
</form>
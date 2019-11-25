@extends('layouts.app')

@section('content')
    <div class="card" id="app">
        <div class="card-body">
            <div class="tab-pane">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><strong>Unidade</strong></li>
                    </ol>
                </nav>
                <div id="registros">
                    <form id="buscar-banco" method="post" action="{{route('unidade.listar')}}">
                        @csrf
                        <div class="form-row" style="margin: 0 auto;">
                            {{-- Campo de pesquisa --}}
                            <div class="col-10">
                                <input type="text" name="filtro" id="filtro" class="form-control form-control-lg" placeholder="Filtro"
                                       style="width:100%;" value="{{$filtro}}">
                            </div>
                            {{-- btn-consultar --}}
                            <div>
                                <button type="button" id="consultar" class="btn btn-secondary fa fa-search nav-icon"
                                        style="float: left; width: 40px;"></button>
                            </div>
                            {{-- btn-status --}}
                            <div class="dropdown" style="margin-left: 5px;">
                                <button type="button"
                                        class="btn btn-secondary "
                                        style="height: 40px;">
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="dropdown-content">
                                    <input type="submit" class="dropbtn" name="acao" value="Ativar">
                                    <input type="submit" class="dropbtn" name="acao" value="Inativar">
                                    <input type="submit" class="dropbtn" name="acao" value="Remover">
                                </div>
                            </div>
                            {{-- btn-cadastro --}}
                            <div style="margin-left: 5px; padding-top: 11px;">
                                <a href="{{route('unidade')}}" class="btn-mais">+</a>
                            </div>
                        </div>

                        <table class="table table-striped table-responsive-sm">
                            <thead class="tbl-cabecalho">
                            <tr>
                                <th><input type="checkbox" id="chkTodos"></th>
                                <th scope="col"><strong>Nome</strong></th>
                                <th scope="col"><strong>Telefone</strong></th>
                                <th scope="col"><strong>Cidade</strong></th>
                                <th scope="col"><strong>UF</strong></th>
                                <th scope="col"><strong>Fotos</strong></th>
                                <th scope="col"><strong>Status</strong></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($unidades as $unidade)
                                <tr>
                                    <td scope="row">
                                        <input type="checkbox" name="chkBanco[]" class="chkUnidade" value="{{$unidade->id}}">
                                    </td>
                                    <td scope="row" class="clickable" data-id="{{$unidade->id}}">{{$unidade->nome}} </td>
                                    <td scope="row" class="clickable" data-id="{{$unidade->id}}" id="telefone">{{$unidade->telefone}} </td>
                                    <td scope="row" class="clickable" data-id="{{$unidade->id}}">{{$unidade->cidade}} </td>
                                    <td scope="row" class="clickable" data-id="{{$unidade->id}}">{{$unidade->uf}} </td>
                                    <td scope="row" class="clickable" data-id="{{$unidade->id}}">{{$unidade->fotos}} </td>
                                    <td scope="row" class="clickable" data-id="{{$unidade->id}}">{{$unidade->status == 'A' ? 'Ativo' : 'Inativo'}} </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    $(document).ready(function(){

        $("#chkTodos").click(function() {
            
            if($('#chkTodos').is(':checked')){

                $('.unidade').attr('checked', true);
            }else{

                $('.unidade').attr('checked', false);
            }
        });

        $(".clickable").click(function() {
            
            window.location.href = "{{url('/')}}/unidade/alterar/" + $(this).data('id')
        });

        $("#consultar").click(function() {
            
            $('form').submit();
        });
        $('td[id^=telefone').each(function() {
            $(this).mask('(00) 00000-0000');
        });
    });
</script>
@endsection
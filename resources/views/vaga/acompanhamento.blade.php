@extends('layouts.app')

@section('content')

<div class="card" id="acompanhamentos">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <b>Status: </b>
                <p>Escala: <b>#00031233</b></p>
                <p>Tipo Contratação: <b>PJ</b></p>
                <p>Visibilidade: <b>{{$vaga->visibilidade == 'P' ? 'Público' : 'Privado'}}</b></p>
                <p>Recorrencia: Semanal Até: 22/07/2019</p>
                <p>Dias: <b>Seg - Ter - Qui</b></p>
            </div>
            <div class="col-md-4">
                <p>Unidade: <b>{{$vaga->sala->unidade->nome}} - {{$vaga->sala->nome}}</b></p>
                <p>Data: <b>{{$vaga->dataInicioHoraFormatada()}} - {{$vaga->dataFinalHoraFormatada()}}</b></p>
                <p>Observação:</p>
                <span>{{$vaga->observacao}}</span>
            </div>
            <div class="col-md-4">
                <p>Especialidade: <b>{{$vaga->especialidade->nome}}</b></p>
                <p>Modalidade de Pagamento: <b>Hora</b></p>
                <p>Tabela de Preço:</p>
                <span>Clinico: Hora: R$100,00 Consulta: R$50,00</span>
                <span>Pediatra: Hora: R$150,00 Consulta: R$57,00</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <input type="text" class="form-control" id="pesquisa" name="pesquisa" placeholder="Digite o nome do médico para adicionar">
            </div>
            <div class="col-md-2">
                <button class="btn btn-success">Adicionar</button>
            </div>
        </div>
    </div>
</div>
<section id="medicos">
    <div class="card">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <td>
                        <b>Nome</b><br/>
                        Eric Foreman
                    </td>
                    <td>
                        <b>Crm</b><br/>
                        0001 - RS
                    </td>
                    <td>
                        <b>Tipo Contratação</b><br/>
                        CLT
                    </td>
                    <td>
                        <b>Dt Candidatura</b><br/>
                        17/06/2019
                    </td>
                    <td>
                        <b>Status</b><br/>
                        Candidato
                    </td>
                    <td>
                        <b>Plantões</b><br/>
                        70/3963,7H
                    </td>
                    <td>
                        <b>Atrasos</b><br/>
                        9/35,50H
                    </td>
                    <td>
                        <b>Especializações</b><br/>
                        9/35,50H
                    </td>
                    <td>
                        <button class="btn btn-sm btn-success">Adicionar</button>
                        <button class="btn btn-sm btn-danger">Remover</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</section>
<section id="opcoes">
    <div class="row">
        <div class="col-md-12">
            <div class="float-right">
                <div class="btn-group">
                    <button type="button" class="btn btn-danger">Cancelar Vaga</button>
                    <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <p class="float-left">
                Legenda
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    Candidato disponível
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="background-color: #fdffd1">
                <div class="card-body">
                    Candidato escolhido
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="background-color: #e0e0da">
                <div class="card-body">
                    Trocar o plantão
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="background-color: #cef0ef">
                <div class="card-body">
                    Candidato confirmado
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

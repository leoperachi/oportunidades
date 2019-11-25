@extends('layouts.app')

@section('content')
    <div class="card" id="app">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><strong>Operadora</strong></li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-12">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-operadora" role="tab" aria-controls="nav-home" aria-selected="true">Operadora</a>
                            <a class="nav-item nav-link {{$operadora->id != '' ? '' : 'disabled'}}" id="nav-profile-tab" data-toggle="tab" href="#nav-unidade" role="tab" aria-controls="nav-profile" aria-selected="false">Unidade</a>
                            <a class="nav-item nav-link {{$operadora->id != '' ? '' : 'disabled'}}" id="nav-contact-tab" data-toggle="tab" href="#nav-medico" role="tab" aria-controls="nav-contact" aria-selected="false">Médico</a>
                            <a class="nav-item nav-link {{$operadora->id != '' ? '' : 'disabled'}}" id="nav-contact-tab" data-toggle="tab" href="#nav-vagas" role="tab" aria-controls="nav-contact" aria-selected="false">Vagas</a>
                        </div>
                    </nav>
                    <br>
                    <div class="tab-content" id="nav-tabContent">
                        
                        <div class="tab-pane fade show active" id="nav-operadora" role="tabpanel" aria-labelledby="nav-home-tab">
                            @include('operadora.operadora')
                        </div>
                        <div class="tab-pane fade" id="nav-unidade" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
                        <div class="tab-pane fade" id="nav-medico" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
                        <div class="tab-pane fade" id="nav-vagas" role="tabpanel" aria-labelledby="nav-contact-tab">
                            @include('vaga.pesquisa-lista')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


    <div class="card" id="app">
        <div class="card-body">
            <div class="tab-pane">
                @if(!isset($include))
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><strong>Vaga</strong></li>
                    </ol>
                </nav>
                @endif
                <div id="registros">
                    <form id="buscar-banco" method="post" action="{{route('vaga.listar')}}">
                        @csrf
                        <div class="form-row" style="margin: 0 auto;">
                            {{-- Campo de pesquisa --}}
                            <div class="col-10">
                                <input type="text" name="filtro" id="filtro" class="form-control form-control-lg" placeholder="Filtro"
                                       style="width:100%;" value="">
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
                                <a href="{{route('vaga.cadastro')}}" class="btn-mais">+</a>
                            </div>
                        </div>

                        <table class="table table-striped table-responsive-sm">
                            <thead class="tbl-cabecalho">
                            <tr>
                                <th><input type="checkbox" id="chkTodos"></th>
                                <th scope="col"><strong>Unidade</strong></th>
                                <th scope="col"><strong>Sala</strong></th>
                                <th scope="col"><strong>Especialidade</strong></th>
                                <th scope="col"><strong>Valor</strong></th>
                                <th scope="col"><strong>Médico</strong></th>
                                <th scope="col"><strong>Início</strong></th>
                                <th scope="col"><strong>Semana</strong></th>
                                <th scope="col"><strong>Período</strong></th>
                            </tr>
                            </thead>
                            <tbody id="myTable">
                                @foreach($vagas as $vaga)
                                <tr class="clickable" data-id="{{$vaga->id}}">
                                    <td>
                                    	<input type="checkbox" name="chkBanco[]" class="chkvaga" value="{{$vaga->id}}">
                                    </td>
                                    <td scope="col">{{$vaga->operadora_unidade}}</td>
                                    <td scope="col">{{$vaga->sala}}</td>
                                    <td scope="col">{{$vaga->especialidade}}</td>
                                    <td scope="col"></th>
                                    <td scope="col">{{$vaga->medico}}</td>
                                    <td scope="col">{{$vaga->dataInicioFormatada()}}</td>
                                    <td scope="col"><strong>Semana</strong></td>
                                    <td scope="col">{{$vaga->dataInicioSoHoraFormatada()}} - {{$vaga->dataFinalSoHoraFormatada()}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("#chkTodos").click(function() {
            
            if($('#chkTodos').is(':checked')){
    
                $('.chkvaga').attr('checked', true);
            }else{
    
                $('.chkvaga').attr('checked', false);
            }
        });
        $("#filtro").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

 		$(".clickable").click(function() {
            
            window.location.href = "{{url('/')}}/vaga/acompanhamento/" + $(this).data('id')
        });
    </script>
    

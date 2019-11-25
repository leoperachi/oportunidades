<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <strong>Consulta Cliente Medicos</strong>
                </li>
            </ol>
        </nav>
        <div>
            @if(!empty($successMsg))
                <div id="msg" class="alert alert-success"> {{ $successMsg }}</div>
            @endif
            @if(!empty($errorMsg))
                <div id="msg" class="alert alert-danger"> {{ $errorMsg }}</div>
            @endif
        </div>
        <div id="registros">
            <form id="formConsultar" method="post" 
                action="{{route('medicosClientes.consultar')}}">
                @csrf
                <div id="filtroAvancado">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtCRM">CRM</label>
                                <input type="text" class="form-control" id="txtCRM"
                                    name="txtCRM"  value="{{$filtroObject->crmMedico}}">
                                <input id="txtIdMedicoCRM" type="hidden" 
                                    value="{{$filtroObject->idMedico}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtMedico">Medico</label>
                                <input name="txtMedico" id="txtMedico" class="form-control"
                                     autocomplete="off"  value="{{$filtroObject->nomeMedico}}">
                                <input id="txtIdMedico" name="txtIdMedico" type="hidden"
                                    value="{{$filtroObject->idMedico}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtCliente">Cliente</label>
                                <input name="txtCliente" id="txtCliente" class="form-control"
                                     autocomplete="off" value="{{$filtroObject->nomeCliente}}">
                                <input id="txtIdCliente" name="txtIdCliente" type="hidden"
                                    value="{{$filtroObject->idCliente}}">
                            </div>
                        </div>
                    </div>
                    <br/>
                </div>
                <br/>
                <div class="row">
                        <div class="col-sm-10">
                            <br>
                        </div>
                        <div class="col-sm-2">
                            <div id="form-acoes" class="form-group float-right">
                                <div class="input-group" style="bottom: 10px;">
                                    <div class="input-group-append">
                                        <button  id="btnShowFiltro" type="button"
                                            title="Filtro avançado" data-placement="top"
                                            class="btn btn-secondary fa fa-filter nav-icon"
                                            style="float: left;width:24px">
                                        </button>
                                        <button  id="btnLimpar" name="acao" value="limpar"
                                            title="Limpar" data-placement="top" type="button"
                                            class="btn btn-secondary fa fa-eraser nav-icon"
                                            style="width:50px" url="{{route('medicosClientes.pesquisa')}}">
                                        </button>
                                        <button type="button" id="btnConsultar" 
                                            url="{{route('medicosClientes.consultar')}}"
                                            class="btn btn-secondary fa fa-search nav-icon" 
                                            data-toggle="tooltip" title="Pesquisar" 
                                            data-placement="top" style="width:50px">
                                        </button>
                                        <button type="button" id="status" 
                                            class="btn btn-secondary dropdown-toggle-split" 
                                            data-toggle="dropdown" aria-haspopup="true" 
                                            aria-expanded="false" title="Ações" data-placement="top">
                                            <i class="fa fa-check"></i>
                                            <i class="dropdown-toggle"></i>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <input type="submit" class="dropdown-item" name="acao" value="Ativar">
                                            <input type="submit" class="dropdown-item" name="acao" value="Inativar">
                                            <input type="submit" class="dropdown-item" name="acao" value="Remover">
                                        </div>

                                        <a href="javascript:navigate('{{route('medicosClientes.inserir')}}');" 
                                            id="cadastro" class="btn btn-secondary" 
                                            title="Cadastrar" data-placement="top"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                <table id="myTable" class="display table table-striped" >
                    <thead class="tbl-cabecalho">
                        <tr>
                            <th scope="col" style="text-align: center;">
                                <input type="checkbox" id="chkSelectAll" style="margin-left:10px">
                            </th>
                            <th scope="col"><strong>CRM/UF</strong></th>
                            <th scope="col"><strong>Medico</strong></th>
                            <th scope="col"><strong>Cliente Unidade</strong></th>
                            <th scope="col"><strong>Ativo</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicoCLientes as $mc)
                            <tr class="dados">   
                                <td style="width: 3px;" class="dt-body-center">
                                    <input type="checkbox"  name="chkOportunidade[]"  
                                        class="chkSelect" value="{{$mc->id}}">
                                </td>
                                <td class="clickable" style="max-width:50px" data-id="{{$mc->id}}">
                                    {{$mc->crmMedico}}
                                </td>
                                <td class="clickable" data-id="{{$mc->id}}">
                                    {{$mc->nomeMedico}}
                                </td>
                                <td class="clickable" data-id="{{$mc->id}}">
                                    {{$mc->clienteNome}}
                                </td>
                                <td class="clickable" data-id="{{$mc->id}}">
                                    @if($mc->ativo == 'A')
                                        Ativo
                                    @else
                                        Inativo
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
<script>
    function bindAllDocReadyThings(url){
        window.history.pushState('page2', 'Title', url); 
        $("#txtCliente").autocomplete({
            source: function( request, response ) {
                $.ajax( {
                    url: "/oportunidades/autocomplete_cliente",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function( data ) {
                        response($.map(data, function(item) {
                            return {
                                label: item.nome,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 2,
            select: function( event, ui ) {
                $('#txtCliente').val(ui.item.label);
                $('#txtIdCliente').val(ui.item.value);
                return false;
            }
        });

        $('#txtCRM').autocomplete({
            source: function(request, response){
                $.ajax({
                    url: "{{ route('disponibilidade.crm') }}",
                    type: "GET",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data){ 
                        response(data);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            },
            minLength: 2,
            select: function( event, ui ) {
                var crmuf = ui.item.crm + ui.item.crm_uf
                

                $( "#txtIdMedico" ).val( ui.item.id );
                $( "#txtIdMedicoCRM" ).val(ui.item.id);                    
                $( "#txtCRM" ).val( crmuf );
                $( "#txtMedico" ).val( ui.item.nomeMedico );
            
                
                return false;
            }
        })
        .autocomplete('instance')._renderItem = function(ul, item) {
            return $( "<label>" )
                .append( "<div>" + item.crm + "" + item.crm_uf + " - " + item.nomeMedico + "</div>" )
                .appendTo( ul );
        }

        $('#txtMedico').autocomplete({
            source: function(request, response){
                $.ajax({
                    url: "{{ route('disponibilidade.medico') }}",
                    type: "GET",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data){ 
                        response(data);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            },
            minLength: 2,
            select: function( event, ui ) {
                var crmuf = ui.item.crm + ui.item.crm_uf                    

                $( "#txtIdMedico" ).val( ui.item.id );
                $( "#txtIdMedicoCRM" ).val(ui.item.id);                    
                $( "#txtCRM" ).val( crmuf );
                $( "#txtMedico" ).val( ui.item.nomeMedico );
                
                
                return false;
            }
        })
        .autocomplete('instance')._renderItem = function(ul, item) {
            return $( "<li>" )
                .append( "<div>" + item.crm + "" + item.crm_uf + " - " + item.nomeMedico + "</div>" )
                .appendTo( ul );
        }
    }

    $(function(){
        $("#chkSelectAll").on('click', function(){
            if ($(this).is( ":checked" )) {
                $(".chkSelect").attr('checked', true);
            } else {
                $(".chkSelect").attr('checked', false); 
            }   
        });
        
        $("#myTable").DataTable({
            "pageResize": true,
            "order": [[ 1, "desc" ]],
            "pageLength": 50,
            "columnDefs": [
                { 
                    "orderable": false, 
                    "targets": 0,
                    "className": 'select-checkbox',
                    "width": "4%", 
                },
                { 
                    "targets": 1,
                    "width": "10%", 
                },
                { 
                    "targets": 2,
                    "width": "38%", 
                },
                { 
                    "targets": 3,
                    "width": "37%", 
                }
            ],
        });

        $("#btnConsultar").off('click').on('click', function(){
            var url = $(this).attr('url');
            $("#loading").show();  
            $.ajax({
                url: url,
                method: "POST",
                data: $("#formConsultar").serialize(),
                success: function( data ) {
                    $("#divPrincipal").html(data);
                    bindAllDocReadyThings(url);
                },
                complete: function(){
                    setTimeout(() => {
                        $("#loading").hide();  
                    },600);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });

        $("#btnLimpar").off('click').on('click', function(event) {
            $("#loading").show();
            var url = $(this).attr('url');

            $.ajax({
                url: url,
                success: function( data ) {
                    $("#divPrincipal").html(data);
                },
                complete: function(){
                    setTimeout(() => {
                        $("#loading").hide();  
                        bindAllDocReadyThings(url);
                    },600);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });

        $(".clickable").on('click', function(event) {
            $("#loading").show();    
            var url = "/medicosClientes/editar/" + $(this).data('id');
            $.ajax({
                url: url,
                success: function( data ) {
                    $("#divPrincipal").html(data);
                },
                complete: function(){
                    setTimeout(() => {
                        $("#loading").hide();  
                        bindAllDocReadyThings(url);
                    },600);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });

            return false;
        });

        $("#btnShowFiltro").off('click').on('click', function(event) {
            if($("#filtroAvancado").is(":visible")){
                $("#filtroAvancado").hide();
            }
            else{
                $("#filtroAvancado").show();
            }

            return false;
        });
    });
</script>

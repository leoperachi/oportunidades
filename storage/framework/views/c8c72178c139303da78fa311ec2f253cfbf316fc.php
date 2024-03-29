
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<div class="card" id="app">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php echo e(route('home')); ?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <strong>Consulta Oportunidades</strong>
                </li>
            </ol>
        </nav>
        <br/>
        <div>
            <?php if(!empty($successMsg)): ?>
                <div id="msg" class="alert alert-success"> <?php echo e($successMsg); ?></div>
            <?php endif; ?>
            <?php if(!empty($errorMsg)): ?>
                <div id="msg" class="alert alert-danger"> <?php echo e($errorMsg); ?></div>
            <?php endif; ?>
        </div>
        <div id="registros">
            <form id="formConsultar" method="post" action="<?php echo e(route('oportunidades.consultar')); ?>">
                <?php echo csrf_field(); ?>
                <div id="filtroAvancado">
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-md-4" style="padding-left: 0px;padding-right: 0px;">
                            <div class="ck-button">
                                <label style="margin-bottom: 0px;">
                                    <input id="chkPrioritarias" onChange="" 
                                        name="chkTipoOportunidade[]" style="display: none;" 
                                        type="checkbox" value="3" <?php echo ($filtroObject->chkPrioritarias==true ? 'checked' : '');?>>
                                    <span style="height: 40px;padding-top: 10px;">Prioritárias</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4" style="padding-left: 0px;padding-right: 0px;">
                            <div class="ck-button">
                                <label style="margin-bottom: 0px;">
                                    <input id="chkRecorrentes" onChange="" 
                                        name="chkTipoOportunidade[]" style="display: none;" 
                                        type="checkbox" value="1" <?php echo ($filtroObject->chkRecorrentes==true ? 'checked' : '');?>>
                                    <span style="height: 40px;padding-top: 10px;">Recorrentes</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4" style="padding-left: 0px;padding-right: 0px;">
                            <div class="ck-button">
                                <label style="margin-bottom: 0px;">
                                    <input id="chkEventuais" onChange="" 
                                        name="chkTipoOportunidade[]" style="display: none;" 
                                        type="checkbox" value="2" <?php echo ($filtroObject->chkEventuais==true ? 'checked' : '');?>>
                                    <span style="height: 40px;padding-top: 10px;">Eventuais</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nome_fantasia">Código</label>
                                <input type="text" class="form-control" id="codigo"
                                    name="codigo" value="<?php echo e($filtroObject->codigo); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cmbEspecialidade">Especialidade</label>
                                <select id="cmbEspecialidade" name="cmbEspecialidade" class="form-control">
                                    <option value="0" selected>Selecione...</option>
                                    <?php $__currentLoopData = $especialidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $especialidade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($especialidade->checked)): ?>
                                            <option value="<?php echo e($especialidade->id); ?>" selected>
                                                <?php echo e($especialidade->nome); ?>

                                            </option>
                                        <?php else: ?>
                                            <option value="<?php echo e($especialidade->id); ?>">
                                                <?php echo e($especialidade->nome); ?>

                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtCliente">Cliente</label>
                                <input name="txtCliente" id="txtCliente" class="form-control"
                                    value="<?php echo e($filtroObject->nomeCliente); ?>" autocomplete="off">
                                <input id="txtIdCliente" name="txtIdCliente" type="hidden"
                                    value="<?php echo e($filtroObject->idCliente); ?>" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="0" selected>Selecione...</option>
                                    <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($st->checked)): ?>
                                            <option value="<?php echo e($st->id); ?>" selected><?php echo e($st->nome); ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo e($st->id); ?>"><?php echo e($st->nome); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtDtInicio">Data Inicio</label>
                                <input type="text" name="txtDtInicio" style="padding-bottom: 0px;"
                                    id="txtDtInicio" autocomplete="off" class="form-control" value="<?php echo e($filtroObject->dtInicio); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtDtFinal">Data Final</label>
                                <input type="text" name="txtDtFinal" style="padding-bottom: 0px;"
                                    id="txtDtFinal" autocomplete="off" class="form-control" value="<?php echo e($filtroObject->dtFinal); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtperini">Periodo Inicio</label>
                                <input type="time" class="form-control" id="txtperini"
                                    name="txtperini" autocomplete="off" min="00:00" max="23:59" value="<?php echo e($filtroObject->periodoini); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtperfim">Periodo Final</label>
                                <input type="time" class="form-control" id="txtperfim"
                                    name="txtperfim" autocomplete="off" min="00:00" max="23:59" value="<?php echo e($filtroObject->periodofim); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-left: 0px;">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" <?php echo ($filtroObject->seg == true ? 'checked' : '');?> 
                                    name="chkSeg" id="chkSeg">
                                <label for="chkSeg">Segunda</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <input type="checkbox" <?php echo ($filtroObject->ter == true ? 'checked' : '');?> 
                                    name="chkTer" id="chkTer">
                                <label for="chkTer">Terça</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <input type="checkbox" id="chkQua" <?php echo ($filtroObject->qua == true ? 'checked' : '');?> 
                                    name="chkQua">
                                <label for="chkQua">Quarta</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" <?php echo ($filtroObject->qui == true ? 'checked' : '');?> 
                                    name="chkQui" id="chkQui">
                                <label for="chkQui">Quinta</label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-left: 0px;">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" <?php echo ($filtroObject->sex == true ? 'checked' : '');?> 
                                    name="chkSex" id="chkSex">
                                <label for="chkSex">Sexta</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" <?php echo ($filtroObject->sab == true ? 'checked' : '');?> 
                                    name="chkSab" id="chkSab">
                                <label for="chkSab">Sabado</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" <?php echo ($filtroObject->dom == true ? 'checked' : '');?> 
                                    name="chkDom" id="chkDom">
                                <label for="chkDom">Domingo</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <input type="checkbox" <?php echo ($filtroObject->comb == true ? 'checked' : '');?> 
                                    name="chkCombinar" id="chkCombinar">
                                    <label for="chkCombinar">A Combinar</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <br>
                        </div>
                    </div>
                </div>
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
                                        style="width:50px" url="<?php echo e(route('oportunidades.consulta')); ?>">
                                    </button>
                                    <button id="btnConsultar" type="button" url="<?php echo e(route('oportunidades.consultar')); ?>"
                                        class="btn btn-secondary fa fa-search nav-icon btnConsultar"
                                        data-toggle="tooltip" title="Pesquisar" value="consultar"
                                        data-placement="top" style="width:50px">
                                    </button>
                                    <button type="button" id="status" class="btn btn-secondary dropdown-toggle-split" 
                                        title="Ações" data-placement="top" data-toggle="dropdown" 
                                        aria-haspopup="true" aria-expanded="false">
                                        
                                        <i class="fa fa-check"></i>
                                        <i class="dropdown-toggle"></i>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <input type="button" class="dropdown-item" 
                                            name="acao" value="priorizar" id="">
                                        <input type="button" class="dropdown-item" 
                                            name="acao" value="despriorizar" id="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <table id="myTable" class="display table table-striped" >
                    <thead class="tbl-cabecalho">
                        <tr>
                            <th scope="col" style="text-align: center">
                                <input style="margin-left:10px" type="checkbox" id="chkSelectAll">
                            </th>
                            <th scope="col"><strong>Cód</strong></th>
                            <th scope="col"><strong>Tipo</strong></th>
                            <th scope="col"><strong>P.</strong></th>
                            <th scope="col"><strong>Dia</strong></th>
                            <th scope="col"><strong>Data </strong></th>
                            <th scope="col"><strong>Periodo</strong></th>
                            <th scope="col"><strong>Status</strong></th>
                            <th scope="col"><strong>Especialidade</strong></th>
                            <th scope="col"><strong>Cliente/Unidade</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $oportunidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="dados">
                                <td style="" class="dt-body-center">
                                    <input type="checkbox" name="chkOportunidade[]"  
                                        class="chkSelect" value="<?php echo e($c->id); ?>">
                                </td>
                                <td class="clickable" style="max-width:50px" data-id="<?php echo e($c->id); ?>">
                                    <?php echo e($c->id); ?>

                                </td>
                                <td class="clickable" data-id="<?php echo e($c->id); ?>">
                                    <?php echo e($c->oportunidadeTipoNome); ?>

                                </td>
                                <td class="clickable dt-body-center" data-id="<?php echo e($c->id); ?>">
                                    <?php if($c->prioridade==1): ?>
                                        <i class="fa fa-thumbs-o-up fa-2" aria-hidden="true"></i>
                                    <?php endif; ?>
                                </td>
                                <td class="clickable" data-id="<?php echo e($c->id); ?>">
                                    <?php echo e($c->diaSemanastr); ?>

                                </td>
                                <td class="clickable" data-id="<?php echo e($c->id); ?>">
                                    <?php if(isset($c->data_inicio)): ?>
                                        <?php echo e(date('d-m-y', strtotime($c->data_inicio))); ?>

                                    <?php endif; ?>
                                </td>
                                <td class="clickable" data-id="<?php echo e($c->id); ?>">
                                    <?php echo e($c->periodo); ?>

                                </td>
                                <td class="clickable" data-id="<?php echo e($c->id); ?>">
                                    <?php echo e($c->statusNome); ?>

                                </td>
                                <td class="clickable" data-id="<?php echo e($c->id); ?>">
                                    <?php echo e($c->especialidadeNome); ?>

                                </td>
                                <td class="clickable" data-id="<?php echo e($c->id); ?>">
                                    <?php echo e($c->oportunidadeClienteNome); ?>

                                </td>
                            </tr>                        
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                var v = ui.item.value;
                $('#txtCliente').val(ui.item.label);
                $('#txtIdCliente').val(ui.item.value);
                return false;
            }
        });
    }
    $(function(){
        <?php if(isset($filtroObject->openFiltroAvancado) and 
            $filtroObject->openFiltroAvancado==false): ?>
            $("#filtroAvancado").hide();
        <?php endif; ?>

        $( "#txtDtInicio" ).datepicker();
        $( "#txtDtFinal" ).datepicker();
        
        $("#btnShowFiltro").off('click').on('click', function(event) {
            if($("#filtroAvancado").is(":visible")){
                $("#filtroAvancado").hide();
            }
            else{
                $("#filtroAvancado").show();
            }

            return false;
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

        $('.ck-button').off('click').on('click', function(event) {
            event.stopPropagation();
            $("#loading").show();
            var esseCheckbox = $(this).find('input[type=checkbox]')[0];
            var esseSpan = $(this).find('span')[0];

            if($(esseCheckbox).prop("checked") == true){
                $(esseCheckbox).prop("checked", false);
            }else{
                var btns = $(".ck-button");

                for(i=0;i<btns.length;i++){
                    var curSpan = $(btns[i]).find('span')[0];
                    if($(esseSpan).text() != $(curSpan).text()){
                        var p = $(curSpan).parent()[0];
                        var curCheckbox  = $(p).find('input[type=checkbox]')[0];
                        var checked = $(curCheckbox).prop("checked");
                        if(checked){
                            $(curCheckbox).prop("checked", false);
                        }
                    }
                }

                $(esseCheckbox).prop("checked", true);
                var filtro = $("#formConsultar").serialize();
                filtro['idTipo'] = $($(this).find('input')).val();
                var x = this;
                $.ajax( {
                    url: "<?php echo e(route('oportunidades.consultar')); ?>",
                    method: "POST",
                    data: filtro,
                    success: function( data ) {
                        $("#loading").hide();               
                        $("#divPrincipal").html(data);

                    },
                    complete: function(){
                        setTimeout(() => {
                            $('#myTable').DataTable({
                                "order": [[ 3, "desc" ]],
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
                                        "width": "5%", 
                                    },
                                    { 
                                        "targets": 3,
                                        "width": "5%", 
                                    },
                                    { 
                                        "targets": 4,
                                        "width": "10%", 
                                    },
                                    { 
                                        "targets": 7,
                                        "width": "9%", 
                                    }
                                ],
                            });
                            $("#loading").hide();               
                        }, 600);
        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(thrownError);
                    }
                });   
            }

            return false;
        });

        $(".clickable").on('click', function(event) {
            $("#loading").show();    
            var url = "/oportunidades/acompanhamento/" + $(this).data('id');
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

        $("#chkSelectAll").on('click', function(){
            if ($(this).is( ":checked" )) {
                $(".chkSelect").attr('checked', true);
            } else {
                $(".chkSelect").attr('checked', false); 
            }   
        });

        $('.btnConsultar').off('click').on('click', function(event) {
            $("#loading").show();
            var u = $(this).attr('url');
            $.ajax( {
                url: u,
                method: "POST",
                data: $("#formConsultar").serialize(),
                success: function( data ) {      
                    $("#divPrincipal").html(data);  
                },
                complete: function(){
                    setTimeout(() => {
                        $('#myTable').DataTable({
                                "order": [[ 3, "desc" ]],
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
                                        "width": "5%", 
                                    },
                                    { 
                                        "targets": 3,
                                        "width": "5%", 
                                    },
                                    { 
                                        "targets": 4,
                                        "width": "10%", 
                                    },
                                    { 
                                        "targets": 7,
                                        "width": "9%", 
                                    }
                                ],
                            });
                        $("#loading").hide();    
                        bindAllDocReadyThings(u); 
                    }, 600);

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
            
            return false;
        });
    });
</script>
<?php /**PATH E:\Backup HD Toshiba\Projetos\juliano\docservice\resources\views/oportunidades/consultaOportunidades.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
    
<div class="card" id="app">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page"><strong>Aviso</strong></li>
            </ol>
        </nav>
        <div id="registros">             
            <form id="busca" method="post" action="<?php echo e(route('aviso.listar')); ?>">
                <?php echo csrf_field(); ?>
                <div id="form-acoes" class="form-group">
                    
                    <div class="input-group">
                        <input type="text" name="filtro" id="filtro" class="form-control form-control-md" placeholder="Filtro">
                        <div class="input-group-append">

                            
                            <button type="button" id="consultar" class="btn btn-secondary fa fa-search nav-icon"  data-toggle="tooltip" title="Pesquisar" data-placement="top"></button>

                            
                            <button type="button"
                                id="filtrar" data-toggle="tooltip"
                                title="Filtro avançado" data-placement="top"
                                class="btn btn-secondary fa fa-filter nav-icon" 
                                style="float: left; width: 40px;">
                                <i class="dropdown-toggle"></i>
                            </button>
                            
                            
                            <button type="button" id="status" class="btn btn-secondary dropdown-toggle-split" data-toggle="dropdown" title="Ações" data-placement="top" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-check"></i>
                                <i class="dropdown-toggle"></i>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                <input type="submit" class="dropdown-item" name="acao" value="Ativar">
                                <input type="submit" class="dropdown-item" name="acao" value="Inativar">
                                <input type="submit" class="dropdown-item" name="acao" value="Remover">
                            </div>

                            
                            <a href="<?php echo e(route('aviso')); ?>" id="cadastro" class="btn btn-secondary" data-toggle="tooltip" title="Cadastrar" data-placement="top"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div id="filtro_avancado" class="row" >
                        <div class="form-row">
                            <label for="sel-modulo" class="col-sm-2 col-form-label-sm">Visibilidade</label>
                            <div class="col-sm-9">
                                <select id="sel-modulo" class="form-control">
                                    <option value="">Selecione</option>
                                </select>
                            </div>
                            <label for="sel-operadoras" class="col-sm-2 col-form-label-sm">Operadoras</label>
                            <div class="col-sm-9">
                                <select id="sel-operadoras" class="form-control">
                                    <option value="">Selecione</option>
                                </select>
                            </div>
                            <label for="sel-unidades" class="col-sm-2 col-form-label-sm">Unidades</label>
                            <div class="col-sm-9">
                                <select id="sel-unidades" class="form-control">
                                    <option value="">Selecione</option>
                                </select>
                            </div>
                            <label for="sel-grupos" class="col-sm-2 col-form-label-sm">Grupos</label>
                            <div class="col-sm-9">
                                <select id="sel-grupos" class="form-control">
                                    <option value="">Selecione</option>
                                </select>
                            </div>
                            <label for="sel-grupos" class="col-sm-2 col-form-label-sm">Status</label>
                            <div class="col-sm-9">
                                <select id="sel-ativo" class="form-control">
                                    <option value="">Selecione</option>
                                    <option value="A">Ativo</option>
                                    <option value="I">Inativo</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="btn btn-default fa fa-search" id="btn-filtrar">Filtrar</button>
                    </div>
                </div>
            
                <table class="table table-striped table-hover">
                    <thead class="tbl-cabecalho">
                        <tr>
                            <th style="width: 1px;">
                                <input type="checkbox" id="chkTodos">
                            </th>
                            <th scope="col"><strong>Visibilidade</strong></th>
                            <th scope="col"><strong>Operadora</strong></th>
                            <th scope="col"><strong>Unidade</strong></th>
                            <th scope="col"><strong>Grupo Médico</strong></th>
                            <th scope="col"><strong>Período</strong></th>
                            <th scope="col"><strong>Status</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $aviso; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aviso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="dados">
                                <td scope="row">
                                    <input type="checkbox" name="chkAviso[]" class="chkAviso" value="<?php echo e($aviso->id); ?>">
                                </td>
                                <td class="clickable" data-id="<?php echo e($aviso->id); ?>">
                                    <?php $__currentLoopData = $modulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($modulo->id == $aviso->idmodulo): ?>
                                            <?php echo e($modulo->nome); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td class="clickable" data-id="<?php echo e($aviso->id); ?>">
                                    <?php $__currentLoopData = $operadoras['original']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $op): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($op['id'] == $aviso->idoperadora): ?>
                                            <?php echo e($op['nome_fantasia']); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td class="clickable" data-id="<?php echo e($aviso->id); ?>">
                                    <?php $__currentLoopData = $unidades['original']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unidade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($unidade['id'] == $aviso->idoperadora_unidade): ?>
                                            <?php echo e($unidade['nome']); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td class="clickable" data-id="<?php echo e($aviso->id); ?>">
                                    <?php $__currentLoopData = $grupos['original']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($grupo['id'] == $aviso->idoperadora_grupo_medico): ?>
                                            <?php echo e($grupo['nome']); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td class="clickable" data-id="<?php echo e($aviso->id); ?>">
                                    <?php echo e(date('d/m/Y', strtotime($aviso->data_hora_abertura))); ?>  até  <?php echo e(date('d/m/Y', strtotime($aviso->data_hora_encerramento))); ?>

                                </td>
                                <?php if($aviso->ativo == 'A'): ?>
                                    <td class="clickable" data-id="<?php echo e($aviso->id); ?>">Ativo</td>
                                <?php elseif($aviso->ativo == 'I'): ?>
                                    <td class="clickable" data-id="<?php echo e($aviso->id); ?>">Inativo</td>
                                <?php endif; ?>
                            </tr>                        
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
<script>
    function ajaxModulos () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var modulos = JSON.parse(this.responseText);
                var select = document.getElementById("sel-modulo");
                modulos.forEach(function(modulo) {
                    var option = document.createElement('option');
                    option.setAttribute('value', modulo['id']);
                    option.innerText = modulo['nome'];
                    select.append(option);
                });
            }
        };
        xhttp.open("GET", "<?php echo e(route('aviso.modulos')); ?>", true);
        xhttp.send();
    }

    function ajaxOperadoras () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var operadoras = JSON.parse(this.responseText);
                var select = document.getElementById("sel-operadoras");
                operadoras.forEach(function(operadora) {
                    var option = document.createElement('option');
                    option.setAttribute('value', operadora['id']);
                    option.innerText = operadora['nome_fantasia'];
                    select.append(option);
                });
            }
        };
        xhttp.open("GET", "<?php echo e(route('aviso.operadoras')); ?>", true);
        xhttp.send();
    }

    function ajaxUnidades () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var unidades = JSON.parse(this.responseText);
                var select = document.getElementById("sel-unidades");
                unidades.forEach(function(unidade) {
                    var option = document.createElement('option');
                    option.setAttribute('value', unidade['id']);
                    option.innerText = unidade['nome'];
                    select.append(option);
                });
            }
        };
        xhttp.open("GET", "<?php echo e(route('aviso.unidades')); ?>", true);
        xhttp.send();
    }
    function ajaxGrupos() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var grupos = JSON.parse(this.responseText);
                var select = document.getElementById("sel-grupos");
                grupos.forEach(function(grupo) {
                    var option = document.createElement('option');
                    option.setAttribute('value', grupo['id']);
                    option.innerText = grupo['nome'];
                    select.append(option);
                });
            }
        };
        xhttp.open("GET", "<?php echo e(route('aviso.grupos')); ?>", true);
        xhttp.send();
    }

    $(function(){

        ajaxModulos(); 
        ajaxOperadoras(); 
        ajaxUnidades(); 
        ajaxGrupos(); 

        $("#consultar").click(function(){
            $('#busca').submit();
        });

        $(".clickable").click(function() {            
            window.location.href = "<?php echo e(url('/')); ?>/aviso/editar/" + $(this).data('id')
        });

        $('#filtrar').click(function(event) {
            var divFiltro = $('#filtro_avancado');
            divFiltro.toggle();
            event.stopPropagation;            
        });

        $('#btn-filtrar').on('click', function() {            
            var modulo = $('#sel-modulo option:selected').text();
            var operadoras = $('#sel-operadoras option:selected').text();
            var unidades = $('#sel-unidades option:selected').text();
            var grupos = $('#sel-grupos option:selected').text();
            var ativo = $('#sel-ativo option:selected').text();
            $('.dados').each(function() {
                if(modulo != 'Selecione'){
                    var nome = $(this).text().toUpperCase()
                                    .indexOf(' '+modulo.toUpperCase());

                } else if(operadoras != 'Selecione'){
                    var nome = $(this).text().toUpperCase()
                                    .indexOf(' '+operadoras.toUpperCase());
                } else if(unidades != 'Selecione'){
                    var nome = $(this).text().toUpperCase()
                                    .indexOf(' '+unidades.toUpperCase());
                } else if(grupos != 'Selecione'){
                    var nome = $(this).text().toUpperCase()
                                    .indexOf(' '+grupos.toUpperCase());
                } else if(ativo != 'Selecione'){
                    var nome = $(this).text().toUpperCase()
                                    .indexOf(' '+ativo.toUpperCase());
                }
                if (nome < 0) {
                    $(this).fadeOut();
                } else {
                    $(this).fadeIn();
                }
            });
        })
        
        $('#chkTodos').change(function(){
            var status = this.checked;
            $('.chkAviso').each(function(){
                this.checked = status;
            });
        })

    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Backup HD Toshiba\Projetos\juliano\docservice\resources\views/doctorservice/aviso/pesquisa.blade.php ENDPATH**/ ?>
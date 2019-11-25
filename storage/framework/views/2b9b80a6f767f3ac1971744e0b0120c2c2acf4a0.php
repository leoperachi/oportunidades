<?php $__env->startSection('content'); ?>
    
<div class="card" id="app">
    <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><strong>Convenio</strong></li>
                </ol>
            </nav>
            <div id="registros">             
                <form id="busca" method="post" action="<?php echo e(route('convenio.listar')); ?>">
                    <?php echo csrf_field(); ?>
                    <div id="form-acoes" class="form-group">
                        
                        <div class="input-group">
                            <input type="text" name="filtro" id="filtro" class="form-control form-control-md" placeholder="Filtro">
                            <div class="input-group-append">

                                
                                <button type="button" id="consultar" class="btn btn-secondary fa fa-search nav-icon" data-toggle="tooltip" title="Pesquisar" data-placement="top"></button>

                                
                                <button type="button" id="status" class="btn btn-secondary dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Ações" data-placement="top">
                                    <i class="fa fa-check"></i>
                                    <i class="dropdown-toggle"></i>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                    <input type="submit" class="dropdown-item" name="acao" value="Ativar">
                                    <input type="submit" class="dropdown-item" name="acao" value="Inativar">
                                    <input type="submit" class="dropdown-item" name="acao" value="Remover">
                                </div>

                                
                                <a href="<?php echo e(route('convenio')); ?>" id="cadastro" class="btn btn-secondary" title="Cadastrar" data-placement="top"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-responsive-sm">
                        <thead class="tbl-cabecalho">
                            <tr>
                                <th><input type="checkbox" id="chkTodos"></th>
                                <th scope="col"><strong>Nome</strong></th>
                                <th scope="col"><strong>Status</strong></th>
                            </tr>
                        </thead>
                        <tbody>  
                            <?php $__currentLoopData = $convenio; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="dados">
                                    <td style="width: 3px;">
                                        <input type="checkbox" name="chkConvenio[]"  class="chkConvenio" value="<?php echo e($c->id); ?>">
                                    </td>
                                    <td class="clickable" data-id="<?php echo e($c->id); ?>">
                                        <?php echo e($c->nome); ?>

                                    </td>
                                    <?php if($c->ativo == 'A'): ?>
                                        <td class="clickable" data-id="<?php echo e($c->id); ?>">Ativo</td>
                                    <?php else: ?>
                                        <td class="clickable" data-id="<?php echo e($c->id); ?>">Inativo</td>
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
        $(function(){ 
    
            $("#consultar").click(function() {            
                $('#busca').submit();
            });

            $(".clickable").click(function() {            
                window.location.href = "<?php echo e(url('/')); ?>/convenio/editar/" + $(this).data('id')
            });
            
            $('#chkTodos').change(function(){
                var status = this.checked;
                $('.chkConvenio').each(function(){
                    this.checked = status;
                });
            })
    
        });
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Backup HD Toshiba\Projetos\juliano\docservice\resources\views/doctorservice/convenio/pesquisa.blade.php ENDPATH**/ ?>
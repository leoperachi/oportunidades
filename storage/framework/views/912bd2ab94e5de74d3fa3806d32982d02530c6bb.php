<?php $__env->startSection('content'); ?>
    <div class="card" id="app">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><strong>Perfil</strong></li>
                </ol>
            </nav>
            <div id="registros">
                <form id="busca" method="post" action="<?php echo e(route('perfil.listar')); ?>">
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

                                
                                <a href="<?php echo e(route('perfil')); ?>" id="cadastro" class="btn btn-secondary" title="Cadastrar" data-placement="top"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped table-responsive-sm">
                        <thead class="tbl-cabecalho">
                        <tr>
                            <th><input type="checkbox" id="chkTodos"></th>
                            <th scope="col"><strong>Módulo</strong></th>
                            <th scope="col"><strong>Perfil</strong></th>
                            <th scope="col"><strong>Statis</strong></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $perfil; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td scope="row" style="width: 1px;">
                                    <input type="checkbox" name="chkPerfil[]" class="chkPerfil" value="<?php echo e($p->id); ?>">
                                </td>
                                <td scope="row" class="clickable" data-id="<?php echo e($p->id); ?>"><?php echo e($p->modulo); ?></td>
                                <td scope="row" class="clickable" data-id="<?php echo e($p->id); ?>"><?php echo e($p->nome); ?></td>
                                <td scope="row" class="clickable" data-id="<?php echo e($p->id); ?>"><?php echo e($p->ativo == 'A' ? 'Ativo' : 'Inativo'); ?> </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function(){

        $("#chkTodos").click(function() {
            
            if($('#chkTodos').is(':checked')){

                $('.chkPerfil').attr('checked', true);
            }else{

                $('.chkPerfil').attr('checked', false);
            }
        });

        $(".clickable").click(function() {
            
            window.location.href = "<?php echo e(url('/')); ?>/perfil/editar/" + $(this).data('id')
        });

        $("#consultar").click(function() {
            
            $('#busca').submit();
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Backup HD Toshiba\Projetos\juliano\docservice\resources\views/doctorservice/perfil/pesquisa.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
    <div class="card" id="app">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('perfil.listar')); ?>">Perfil</a></li>
                    <?php if(isCadastro()): ?>                        
                        <li class="breadcrumb-item active" aria-current="page"><strong>Cadastro</strong></li>
                    <?php else: ?>    
                        <li class="breadcrumb-item active" aria-current="page"><strong>Edição</strong></li>
                    <?php endif; ?>
                </ol>
            </nav>
            <div class="row">
                <div class="col-12">
                    <?php echo $__env->make('doctorservice.perfil.perfil', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Backup HD Toshiba\Projetos\juliano\docservice\resources\views/doctorservice/perfil/cadastro.blade.php ENDPATH**/ ?>
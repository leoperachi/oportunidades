<?php $__env->startSection('content'); ?>
    
<div class="card" id="app">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Dashboard</a></li>
              <li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('banco.listar')); ?>">Banco</a></li>
              <li class="breadcrumb-item active" aria-current="page"><strong>Cadastro</strong></li>
            </ol>
        </nav>
        <div id="registros">
            <form method="POST" action="<?php echo e(route('banco.cadastrar')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Número:</label>
                    <div class="col-sm-10">
                        <input type="text" name="numero" class="form-control <?php if ($errors->has('numero')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('numero'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" value="<?php echo e(old('numero')); ?>">
                    </div>
                </div>
                <?php if ($errors->has('numero')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('numero'); ?>
                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nome:</label>
                    <div class="col-sm-10">
                        <input type="text" name="nome" class="form-control <?php if ($errors->has('nome')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('nome'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" value="<?php echo e(old('nome')); ?>">
                    </div>
                </div>
                <?php if ($errors->has('nome')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('nome'); ?>
                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status:</label>
                    <div class="col-sm-10">
                        <select name="status" class="form-control form-control-md">
                            <option value="A">Ativo</option>
                            <option value="I" selected>Inativo</option>
                        </select>
                    </div>
                </div>                
                <div class="btn-cadastro">
                    <input type="submit" class="btn btn-success" name="salvar" value="Salvar">
                    <a href="<?php echo e(route('banco.listar')); ?>" class="btn btn-default" name="cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Backup HD Toshiba\Projetos\juliano\docservice\resources\views/doctorservice/banco/cadastro.blade.php ENDPATH**/ ?>
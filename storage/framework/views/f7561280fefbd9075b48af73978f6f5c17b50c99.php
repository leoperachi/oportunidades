<?php $__env->startSection('content'); ?>

<div class="card" id="app">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('convenio.listar')); ?>">Convenio</a></li>
                <li class="breadcrumb-item active" aria-current="page"><strong>Edição</strong></li>
            </ol>
        </nav>
        <div id="registros">
            <form method="POST" action="<?php echo e(route('convenio.atualizar', $convenio->id)); ?>">
                <?php echo method_field('PUT'); ?>
                <?php echo csrf_field(); ?>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nome:</label>
                    <div class="col-sm-10">
                        <input type="text" name="nome" class="form-control" value="<?php echo e($convenio->nome); ?>">
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
                    <label class="col-sm-2 col-form-label">Descrição:</label>
                    <div class="col-sm-10">
                        <input type="text" name="descricao" class="form-control" value="<?php echo e($convenio->descricao); ?>">
                    </div>
                </div>
                <?php if ($errors->has('descricao')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('descricao'); ?>
                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status:</label>
                    <div class="col-sm-10">
                        <select name="status" class="form-control" value="<?php echo e($convenio->ativo); ?>">
                            <option value="A" <?php echo e(($convenio->ativo == 'A') ? 'selected' : ''); ?>>Ativo</option>
                            <option value="I" <?php echo e(($convenio->ativo == 'I') ? 'selected' : ''); ?>>Inativo</option>
                        </select>
                    </div>
                </div>
                <div style="float: right;">
                    <input type="submit" class="btn btn-success" name="salvar" value="Salvar">
                    <input type="submit" class="btn btn-default" name="remover" value="Remover">
                    <a href="<?php echo e(route('convenio.listar')); ?>" class="btn btn-default" name="cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Backup HD Toshiba\Projetos\juliano\docservice\resources\views/doctorservice/convenio/editar.blade.php ENDPATH**/ ?>
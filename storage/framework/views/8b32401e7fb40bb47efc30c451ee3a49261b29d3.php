<?php $__env->startSection('content'); ?>

<div class="">
    <div class="row justify-content-end">
        <div class="col-lg-3 col-md-5 card-login">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="d-flex justify-content-center">
                            <img src="img/logo_cliente.png" alt="">
                        </div>
                        <div class="form-group form-group-input row">
                            <div class="col-md-12">
                                <input id="email" type="email"   required autofocus 
                                    placeholder="E-mail" name="email" value="<?php echo e(old('email')); ?>" 
                                    class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>">
                                <?php if($errors->has('email')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group form-group-input row">
                            <div class="col-md-12">
                                <input id="password" type="password"  placeholder="Password" 
                                    class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" 
                                    name="password" required>
                                <?php if($errors->has('password')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
    
                        <div class="form-group form-group-button row">
                            <div class="col-md-12">
                                <div class="float-right">
                                    <?php if(Route::has('password.request')): ?>
                                        <a class="btn btn-link" href="<?php echo e(route('password.request')); ?>">
                                            <?php echo e(__('Forgot Your Password?')); ?>

                                        </a>
                                    <?php endif; ?>
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo e(__('Login')); ?>

                                    </button>
                                    
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->yieldContent('scripts'); ?>
<script>
    $(document).ready(function(){
        $(".btn-primary").click(function(){
            $("#loading").show(); 
        });

        setTimeout(() => {
            $("#loading").hide();    
        }, 500);
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Backup HD Toshiba\Projetos\juliano\docservice\resources\views/auth/login.blade.php ENDPATH**/ ?>
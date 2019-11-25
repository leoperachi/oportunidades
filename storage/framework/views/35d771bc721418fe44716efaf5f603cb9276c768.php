<?php $__env->startSection('content'); ?>
    
<div class="card" id="usuario">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('usuario.listar')); ?>">Usuário</a></li>
                <li class="breadcrumb-item active" aria-current="page"><strong>Cadastro</strong></li>
            </ol>
        </nav>
        <div id="registros">
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form method="POST" action="<?php echo e(route('usuario.cadastrar')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Módulo:</label>
                    <div class="col-sm-10">
                        <select name="modulo" id="modulo" v-model="modulo" 
                        v-on:change="buscarPerfis(modulo)" class="form-control">
                            <option value="">Selecione</option>
                            <?php $__currentLoopData = $modulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($modulo->id); ?>"><?php echo e($modulo->nome); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Perfil:</label>
                    <div class="col-md-10">
                        <select name="perfil" id="perfil" class="form-control">
                            <option value="">Selecione</option>
                            <option v-for="p in perfil" :value="p.id" >{{p.nome}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row" v-show="modulo == 2">
                    <label class="col-sm-2 col-form-label">Operadora:</label>
                    <div class="col-md-10">
                        <select name="operadora" id="operadora" class="form-control">
                            <option value="">Selecione</option>
                            <?php $__currentLoopData = $operadoras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $operadora): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($operadora->id); ?>"><?php echo e($operadora->nome_operadora); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                            
                        </select>                            
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label id="label-cpf" class="col-form-label col-md-3">CPF:</label>
                            <select name="cpf" id="cpf" class="form-control">
                                <option value="">Selecione</option>
                                <option v-for="usuario in usuarios" :value="usuario.cpf">{{ usuario.cpf }}</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label id="label-nome" class="col-form-label col-md-4">Nome:</label>
                            <select name="idpessoa" id="nome" class="form-control" onchange="getNome()">
                                <option value="">Selecione</option>
                                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($usuario->id); ?>"><?php echo e($usuario->nome); ?></option>              
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <input type="hidden" name="nome" id="pessoa" value="">
                            
                        </div>
                    </div>
                </div>
                
                
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Sexo:</label>
                    <div class="col-md-4">
                        <select name="sexo" id="sexo" class="form-control">
                            <option value="">Selecione</option>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Estado Civil:</label>
                    <div class="col-md-4">
                        <select name="estado_civil" id="estado_civil" class="form-control">
                            <option value="">Selecione</option>
                            <?php $__currentLoopData = $estadoCivil; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($estado->id); ?>"><?php echo e($estado->estado); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Data de Nascimento:</label>
                    <div class="col-md-4 input-group-date" style="padding-top:10px;">
                        <input type="text" name="data_nascimento" id="data_nascimento" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Apelido:</label>
                    <div class="col-md-10">
                        <input type="text" name="apelido" class="form-control">
                        <p>Como gosta de ser chamado.</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">E-mail:</label>
                    <div class="col-md-10">
                        <input type="email" name="email" class="form-control" placeholder="dominio@email.com.br">
                    </div>
                </div>
                <?php if($errors->has('email')): ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($errors->first('email')); ?></strong>
                    </span>
                <?php endif; ?>
                <div class="form-group row">
                    <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                    <div class="col-md-10" style="padding-top:15px;">
                        <input type="file" name="foto" id="foto" readonly>
                        <p>(JPG ou PNG)</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="senha" class="col-sm-2 col-form-label">Senha:</label>
                    <div class="col-md-10">
                        <input type="password" name="password" v-model="senha" id="senha" class="form-control <?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>">
                    </div>
                </div>
                <?php if($errors->has('password')): ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($errors->first('password')); ?></strong>
                    </span>
                <?php endif; ?>
                <div class="form-group row">
                    <label for="senha" class="col-sm-2 col-form-label">Confirmar Senha:</label>
                    <div class="col-md-10">
                        <input type="password" name="password_confirmation" v-model="confirmSenha" id="confirmSenha" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status:</label>
                    <div class="col-sm-2">
                        <select name="status" class="form-control form-control-md">
                            <option value="A" selected>Ativo</option>
                            <option value="I">Inativo</option>
                        </select>
                    </div>
                </div>                
                <div class="btn-cadastro">
                    <input type="submit" class="btn btn-primary" name="salvar" value="Salvar">
                    <a href="<?php echo e(route('usuario')); ?>" class="btn btn-default" name="cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {            
            $('#data_nascimento').mask('00/00/0000');
            $('.select2-selection.select2-selection--single').css('margin-top','15px');
            $('.select2-selection__arrow').css('top','15px');
        });
        function getNome() {
            var select = document.getElementById('nome');
            var option = select.children[select.selectedIndex];
            var texto = option.textContent;
            document.getElementById('pessoa').value = texto;
            var valor = parseInt(option.value);
            if(isNaN(valor)){
                option.value = '';
            }
        }
    </script>
    <script>
        new Vue({
            el: '#usuario',
            data: {
                modulo: '',
                perfil: '',
                usuarios: '',
                nome: '',
                cpf: '',
                senha: null,
                confirmSenha: null,
                errors: []
            },
            methods: {
                buscarPerfis(modulo){
                    this.$http.get('/usuario/perfil/' + this.modulo).then(function(res) {
                        this.perfil = res.data;
                    });
                }
            },
            mounted: function () {
                $('#nome').select2({
                    tags: true
                });
                $('#cpf').select2({
                    tags: true,
                    maximumInputLength: 11
                });
                this.$nextTick(function () {
                    this.$http.get("<?php echo e(route('usuario.nome')); ?>").then(function(res) {
                        this.usuarios = res.data;
                    });
                })
            }
        });
    </script>
    
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Backup HD Toshiba\Projetos\juliano\docservice\resources\views/doctorservice/usuario/cadastro.blade.php ENDPATH**/ ?>
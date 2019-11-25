<div id="perfil">
    <form method="POST" enctype="multipart/form-data" <?php echo e(isset($perfil->id) ? 'action='.route('perfil.atualizar', ['id' => $perfil->id]) : ''); ?>>
        <?php echo csrf_field(); ?>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="modulo">Módulo</label>
                    <select name="modulo" id="modulo" v-model="modulo" v-on:change="buscarTelas(modulo)" class="form-control" >
                        <option value="">Selecione</option>
                        <?php $__currentLoopData = $modulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($modulo->id); ?>"><?php echo e($modulo->nome); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="nome_perfil">Nome</label>
                    <input type="text" class="form-control" id="nome_perfil" name="nome_perfil" value="<?php echo e($perfil->nome); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="A" <?php echo e($perfil->ativo == 'A' ? 'selected' : ''); ?>>Ativo</option>
                        <option value="I" <?php echo e($perfil->ativo == 'I' ? 'selected' : ''); ?>>Inativo</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="acessos" class="table table-striped table-hover">
                    <thead class="tbl-cabecalho tbl-perfil">
                        <tr>
                            <th style="width:40%; text-align: left;">Acessos</th>
                            <th><strong>Acessar</strong></th>
                            <th><strong>Adicionar</strong></th>
                            <th><strong>Atualizar</strong></th>
                            <th><strong>Remover</strong></th>
                        </tr>
                    </thead>
                    <tbody id="tblPerfil">
                        <tr class="tbl-perfil" v-for="acesso in acessos" v-show="modulo != '' ">
                            <td class="nome-tela">
                                <input type="checkbox" name="id_acesso[]" v-model="acesso.id" :value="acesso.id" style="display: none;">
                                {{acesso.acesso}}
                            </td>
                            <td><input type="checkbox" name="id_acesso_acessar[]" v-model="acesso.visualizar" :value="acesso.id"></td>
                            <td><input type="checkbox" name="id_acesso_adicionar[]" v-model="acesso.adicionar" :value="acesso.id" v-bind:disabled="!acesso.visualizar" v-bind:checked="!acesso.visualizar"></td>
                            <td><input type="checkbox" name="id_acesso_atualizar[]" v-model="acesso.atualizar" :value="acesso.id" v-bind:disabled="!acesso.visualizar" v-bind:checked="!acesso.visualizar"></td>
                            <td><input type="checkbox" name="id_acesso_remover[]" v-model="acesso.remover" :value="acesso.id" v-bind:disabled="!acesso.visualizar" v-bind:checked="!acesso.visualizar"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <a href="<?php echo e(route('perfil.listar')); ?>" class="btn btn-secondary" data-dismiss="modal">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </form>
<script>
    var app = new Vue({
        el: '#perfil',
        data: {
            checkAll: false,
            modulo: "<?php echo e($perfil->idmodulo != '' ? $perfil->idmodulo : ''); ?>",
            acessos: '',
            idPerfil: "<?php echo e($perfil->id != '' ? $perfil->id : ''); ?>",
            perfilAcesso: '',
            idacessos: [],
        },
        methods: {
            buscarTelas(modulo){            
                this.$http.get("/perfil/modulo/" + this.modulo).then(function(res){
                    this.acessos = res.data;
                    console.log(this.acessos);                    
                });                            
            },
            desmarcarCheckboxes(){
                this.checkAll = !this.checkAll;
            },
            getPerfilAcesso(idPerfil){
                this.$http.get("/perfil/acessos/" + this.idPerfil).then(function(res){
                    
                    for(var i=0; i < res.data.length; i++) {
 
                        console.log(res.data[i]);
                        if(res.data[i].Idacesso > 0){
                            res.data[i].id = res.data[i].Idacesso;
                        }
                        if(res.data[i].Visualizacao == 1){
                            res.data[i].visualizar = true;
                        } 
                        if(res.data[i].Cadastro == 1){
                            res.data[i].adicionar = true;
                        } 
                        if(res.data[i].Edicao == 1){
                            res.data[i].atualizar = true;
                        } 
                        if(res.data[i].Exclusao == 1){
                            res.data[i].remover = true;
                        } 
                    }
 
                    this.acessos = res.data;
                })
            }
        },
        mounted: function(){
            if (this.idPerfil != '') {
                this.getPerfilAcesso(this.idPerfil);    
            } else {
                this.buscarTelas(this.modulo);
            }
        }
    });
</script><?php /**PATH E:\Backup HD Toshiba\Projetos\juliano\docservice\resources\views/doctorservice/perfil/perfil.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
    
<div class="card" id="app">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page"><strong>Usuário</strong></li>
            </ol>
        </nav>
        <div id="registros">             
            <form id="busca" method="post" action="<?php echo e(route('usuario.listar')); ?>">
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
                            
                            
                            <button type="button" id="status" class="btn btn-secondary dropdown-toggle-split" title="Ações" data-placement="top" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-check"></i>
                                <i class="dropdown-toggle"></i>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                <input type="submit" class="dropdown-item" name="acao" value="Ativar">
                                <input type="submit" class="dropdown-item" name="acao" value="Inativar">
                                <input type="submit" class="dropdown-item" name="acao" value="Remover">
                            </div>

                            
                            <a href="<?php echo e(route('usuario')); ?>" id="cadastro" class="btn btn-secondary" data-toggle="tooltip" title="Cadastrar" data-placement="top"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div id="filtro_avancado">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="select-perfil">Perfil</label>
                                    <select id="select-perfil" class="form-control" style="width: 100%;">
                                        <option value="">Selecione</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                <label for="sel-grupos">Status</label>
                                <select id="select-ativo" class="form-control">
                                    <option value="">Selecione</option>
                                    <option value="A">Ativo</option>
                                    <option value="I">Inativo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <button type="button" id="btn-filtrar" 
                                    class="fa fa-search btn btn-default">
                                Filtrar
                            </button>
                        </div>
                    </div>
                </div>
            
                <table class="table table-striped table-hover">
                    <thead class="tbl-cabecalho">
                        <tr>
                            <th style="width: 1px;">
                                <input type="checkbox" id="chkTodos">
                            </th>
                            <th scope="col"><strong>CPF</strong></th>
                            <th scope="col"><strong>Nome</strong></th>
                            <th scope="col"><strong>Módulo</strong></th>
                            <th scope="col"><strong>Perfil</strong></th>
                            <th scope="col"><strong>Status</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="dados">
                                <td scope="row">
                                    <input type="checkbox" name="chkUsuario[]" class="chkUsuario" value="<?php echo e($usuario->id); ?>">
                                </td>
                                <td scope="row" class="clickable" data-id="<?php echo e($usuario->id); ?>">
                                    <?php echo e($usuario->cpf); ?>  
                                </td>
                                <td scope="row" class="clickable" data-id="<?php echo e($usuario->id); ?>">
                                    <?php echo e($usuario->nome); ?>

                                </td>
                                <td scope="row" class="clickable" data-id="<?php echo e($usuario->id); ?>">
                                    <?php echo e($usuario->modulo); ?>

                                </td>
                                <td scope="row" class="clickable" data-id="<?php echo e($usuario->id); ?>">
                                    <?php echo e($usuario->perfil); ?>

                                </td>
                                <td scope="row" class="clickable" data-id="<?php echo e($usuario->id); ?>">
                                    <?php echo e(($usuario->ativo == 'A') ? 'Ativo' : 'Inativo'); ?>

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
    $(function(){

        perfis();

        $('#select-perfil').select2({
            minimumResultsForSearch: 5
        });

        $("#consultar").click(function(){
            $('#busca').submit();
        });

        function perfis() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var perfis = JSON.parse(this.responseText);
                    var select = document.getElementById("select-perfil");
                    perfis.forEach(function(perfil) {
                        var option = document.createElement('option');
                        option.setAttribute('value', perfil['id']);
                        option.innerText = perfil['nome'];
                        select.append(option);
                    });
                }
            };
            xhttp.open("GET", "/usuario/perfil", true);
            xhttp.send();
        }

        $(".clickable").click(function() {            
            window.location.href = "/usuario/editar/" + $(this).data('id')
        });

        $('#filtrar').click(function(event) {
            var divFiltro = $('#filtro_avancado');
            divFiltro.toggle();
            event.stopPropagation;            
        });

        $('#btn-filtrar').on('click', function() {            
            var perfil = $('#select-perfil option:selected').text();
            var ativo = $('#select-ativo option:selected').text();
            
            $('.dados').each(function() {
                if(perfil != 'Selecione'){
                    var nome = $(this).text().toUpperCase()
                                    .indexOf(' '+perfil.toUpperCase());

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
            $('.chkUsuario').each(function(){
                this.checked = status;
            });
        })

    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Backup HD Toshiba\Projetos\juliano\docservice\resources\views/doctorservice/usuario/pesquisa.blade.php ENDPATH**/ ?>
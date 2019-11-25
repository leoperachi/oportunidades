<div class="card">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page"><strong>Importação Oportunidades</strong></li>
            </ol>
        </nav>
        <div>
            <?php if(!empty($successMsg)): ?>
                <div id="msg" class="alert alert-success"> <?php echo e($successMsg); ?></div>
            <?php endif; ?>
            <?php if(!empty($errorMsg)): ?>
                <div id="msg" class="alert alert-danger"> <?php echo e($errorMsg); ?></div>
            <?php endif; ?>
        </div>
        <div id="registros">
            <form method="POST" id="formImportar" action="<?php echo e(route('importarxls')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form-group row justify-content-end">
                    <label class="col-sm-2 col-form-label">Arquivo:</label>
                    <div class="col-sm-9">
                        <input type="file" required name="planilhaexcel" class="form-control" id="planilhaexcel">
                    </div>
                    <div class="col-sm-1" style="top: 15px;">
                        <button type="submit" id="btnSubmit" 
                            class="btn btn-secondary fa fa-upload nav-icon" 
                            data-toggle="tooltip" name="salvar" 
                            value="importarxls" title="Importar" 
                            data-placement="top">
                        </button>
                       
                    </div>
                </div>
            </form>
            <?php if(!empty($successMsg) and count($logs) > 0): ?>
                <h4 style="margin-bottom: 20px;">Log Importação</h4>
                <table id="myTable" class="table table-striped table-responsive-sm">
                    <thead class="tbl-cabecalho">
                    <tr>
                        <th scope="col"><strong>Arquivo</strong></th>
                        <th scope="col"><strong>Data Importação</strong></th>
                        <th scope="col"><strong>Log</strong></th>
                        <th scope="col"><strong>Status</strong></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td scope="row"><?php echo e($log->nome_arquivo); ?> </td>
                            <td scope="row"><?php echo e($log->data_hora_importacao); ?> </td>
                            <td scope="row"><?php echo e($log->log); ?> </td>
                            <td scope="row"><?php echo e($log->nome); ?> </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <style>
                    .dataTables_wrapper .dataTables_length {
                        float: right!important;
                        padding-left: 8px!important;
                        padding-right: 8px!important;
                    }
                    .dataTables_paginate .paging_simple_numbers{
                        margin-bottom: 10px!important;
                    }
                    .bottom{
                        margin-top: 5px!important;
                    }
                    select {
                        border-left-width: 5px!important;
                        border-right-width: 5px!important;
                    }
                </style>
                <script>
                    $(document).ready(function() {
                        $('#myTable').DataTable( {
                            "dom": '<"top">rt<"bottom"ip><"clear">'
                        } );
                    } );
                </script>
            <?php endif; ?>
        </div>
    </div>
    <div class="modal fade" id="modalPergunta" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Atenção</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if(!empty($openModal)): ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <h6> <?php echo e($openModal); ?></h6>
                            </div>
                        </div>
                        <br>
                        <div class="row pull-right">
                            <form method="POST" action="<?php echo e(route('importarModal')); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>   
                                <div class="col-sm-12">
                                    <button type="submit" id="btnYes" 
                                        class="btn btn-secondary fa fa-thumbs-o-up"
                                        data-toggle="tooltip"
                                        value="yesModal" title="Yes" 
                                        data-placement="top">
                                    </button>
                                    <button type="submit" id="btnNo" 
                                        class="btn btn-secondary fa fa-thumbs-o-down"
                                        data-toggle="tooltip" data-dismiss="modal"
                                        value="noModal" title="No" 
                                        data-placement="top">
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if(!empty($openModal)): ?>
        <script>
            $(function(){ 
                $('#modalPergunta').modal('show');
            });
        </script>
        <?php endif; ?>
    </div>
</div>

<?php echo $__env->yieldContent('scripts'); ?>
<script>
     function bindAllDocReadyThings(url){
        window.history.pushState('page2', 'Title', url);
    }
    $(function(){ 
       

        $("#btnSubmit").click(function() {
            var form = $( "#formImportar" );
            
            if(form.valid()){
                $("#loading").show();
                $("#btnSubmit").hide();
            }           
        });
    });
</script><?php /**PATH E:\Backup HD Toshiba\Projetos\juliano\docservice\resources\views/oportunidades/importacao.blade.php ENDPATH**/ ?>
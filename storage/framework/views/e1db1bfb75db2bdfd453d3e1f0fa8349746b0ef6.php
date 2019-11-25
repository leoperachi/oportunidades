<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Aquitetura Padrao')); ?></title>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js')); ?>" defer></script>
    <script src="<?php echo e(asset('js/adminlte.min.js')); ?>" defer></script>
    <script src="<?php echo e(asset('js/jquery.smartWizard.min.js')); ?>" defer></script>
    <script src="<?php echo e(asset('plugins/jquery-mask-plugin/jquery.mask.min.js')); ?>" defer></script>
    <script src="<?php echo e(asset('js/vue-resource.min.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    
    <link rel="shortcut icon" type="image/x-icon" href="img/logo_cliente_red.ico">
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    
    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/modal_comunicacao.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/banco.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/adminlte.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/materia.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('plugins/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/customizacao.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/smart_wizard.min.css')); ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="<?php echo e(asset('js/jquery-datatables.js')); ?>"></script>
    <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
</head>
<body class="sidebar-mini sidebar-open" style="background:#f1f1f1">
<div id="app" class="wrapper">
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" id="btnMenuLateral" 
                    data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="fa fa-user"></i>
                    <?php if(auth()->guard()->check()): ?>
                        <?php echo e(Auth::user()->name); ?>

                    <?php endif; ?>
                    <i class="fa fa-caret-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">My Info</a>
                    <div class="dropdown-divider"></div>
                    <form method="post" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="dropdown-item dropdown-footer">Logout</button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">

            <div class="d-flex justify-content-center">
                <img src="img/logo_cliente.png" alt="" height="32px">
            </div>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="pages/widgets.html" class="nav-link">
                            <i class="nav-icon fa fa-th"></i>
                            <p>
                                Widgets
                                <span class="right badge badge-danger">New</span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-pie-chart"></i>
                            <p>
                                Charts
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="pages/charts/chartjs.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>ChartJS</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/charts/flot.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Flot</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/charts/inline.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Inline</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-tree"></i>
                            <p>
                                UI Elements
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="pages/UI/general.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>General</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/UI/icons.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Icons</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/UI/buttons.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Buttons</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/UI/sliders.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Sliders</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-table"></i>
                            <p>
                                Administrativos
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if(\Auth::user()->hasAcesso("Banco")): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('banco.listar')); ?>" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Banco</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Aviso")): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('aviso.listar')); ?>" class="nav-link">                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Aviso</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Especialidade")): ?>                            
                            <li class="nav-item">
                                <a href="<?php echo e(route('especialidade.listar')); ?>" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Especialidade</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Feriado")): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('feriado.listar')); ?>" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Feriado</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Convênio")): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('convenio.listar')); ?>" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Convênio</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Instituição")): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('instituicao.listar')); ?>" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Instituição</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Prospect")): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('prospect.listar')); ?>" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Prospect</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Usuário")): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('usuario.listar')); ?>" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Usuário</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Perfil")): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('perfil.listar')); ?>" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Perfil</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Operadora")): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('operadora.listar')); ?>" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Operadora</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Operador")): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('operador.listar')); ?>" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Operador</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Unidade")): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('unidade.listar')); ?>" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Unidade</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Tabela")): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('tabela-valor.listar')); ?>" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Tabela</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Vaga")): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('vaga.listar')); ?>" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Vaga</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Empresa")): ?>
                            <li class="nav-item">
                                <a href="pages/tables/data.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Empresa</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Blacklist")): ?>
                            <li class="nav-item">
                                <a href="pages/tables/data.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Blacklist</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("FAQ")): ?>
                            <li class="nav-item">
                                <a href="pages/tables/data.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>FAQ</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("LOG")): ?>
                            <li class="nav-item">
                                <a href="pages/tables/data.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>LOG</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Banner")): ?>
                            <li class="nav-item">
                                <a href="pages/tables/data.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Banner</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Página")): ?>
                            <li class="nav-item">
                                <a href="pages/tables/data.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Página</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            
                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-handshake-o"></i>
                            <p>
                                Oportunidades
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if(\Auth::user()->hasAcesso("Importacao")): ?>
                                <li class="nav-item">
                                    <a url="<?php echo e(route('importacao')); ?>" class="nav-link btnCLick">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Importação</p>
                                        </a>
                                    </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Oportunidades")): ?>
                                <li class="nav-item">
                                    <a url="<?php echo e(route('oportunidades.consulta')); ?>" class="nav-link btnCLick">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Consulta Oportunidades</p>
                                        </a>
                                    </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("Disponibilidade")): ?>
                                <li class="nav-item">
                                    <a url="<?php echo e(route('disponibilidade.pesquisa')); ?>" class="nav-link btnCLick">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Disponibilidade</p>
                                        </a>
                                    </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->hasAcesso("MedicosClientes")): ?>
                                <li class="nav-item">
                                    <a class="nav-link btnCLick" url="<?php echo e(route('medicosClientes.pesquisa')); ?>">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Cliente \ Medicos</p>
                                        </a>
                                    </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <!-- /.navbar -->
    <div class="content-wrapper" id="divPrincipal">
        <section class="content">
            <div class="container-fluid">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </section>
    </div>
</div>
<div id="loading" class="loading" >Loading&#8230;</div>
<?php echo $__env->yieldContent('scripts'); ?>
    <script>
        function navigate(url){
            $("#loading").show();  
            $.ajax({
                url: url,
                success: function( data ) {
                    $("#divPrincipal").html(data);
                    bindAllDocReadyThings(url);
                },
                complete: function(){
                    setTimeout(() => {
                        $("#loading").hide();  
                    },600);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        }

        $(document).ready(function(){
            var tam = $(window).width();
            if (tam <=991) {
                $(".sidebar-mini").removeClass('sidebar-open');
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', ".nav-treeview > .nav-item > .nav-link", function(){
                $("#loading").show(); 
            });

            $("#btnMenuLateral").click();

            setTimeout(() => {
                $("#loading").hide();               
            }, 500);
        
            $(".btnCLick").off('click').on('click', function(){ 
                $("#loading").show();
                var u = $(this).attr('url');
                $.ajax( {
                    url: u,
                    success: function( data ) {
                        $("#loading").hide();               
                        $("#divPrincipal").html(data);
                        bindAllDocReadyThings(u);
                    },
                    complete: function(){
                        setTimeout(() => {
                            $("#loading").hide();
                        }, 600);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
</body>
</html>
<?php /**PATH E:\Backup HD Toshiba\Projetos\juliano\docservice\resources\views/layouts/app.blade.php ENDPATH**/ ?>
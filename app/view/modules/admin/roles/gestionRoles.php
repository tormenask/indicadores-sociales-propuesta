<?php
include_once 'model/log.php';
include_once 'controller/log.php';
include_once 'model/modulo.php';
include_once 'controller/modulo.php';
include_once 'model/rol.php';
include_once 'controller/rol.php';
session_start();
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$permiso = $rol->consultarPermisoRol("roles", $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
}
?>
<html>
    <head>
        
        <?php include 'view/modules/head.php'; ?>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">    
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
        <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script> 
        <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script> 
        <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script>
        <style type="text/css">
            td#prewrap {
                white-space: pre-wrap;
            }
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'view/modules/header.php'; ?>
            <?php include 'view/modules/side.php'; ?>
            <div class="content-wrapper" style="padding: 20px; background-color: #fff;">
                <?php
                $modulo = new Modulo();
                $nombreModulo = "roles";
                $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
                $log = new LogController();
                $log->crearLog($idModulo, "Ingreso a módulo de gestión de roles");
                $role = new RolController();
                $resp = $role->listarRoles();
                ?>
            </div>
        </div>
        <?php include 'view/modules/footer.php'; ?>
        <script>
            $("#roles").addClass("active");
        </script>
    </body>
</html>
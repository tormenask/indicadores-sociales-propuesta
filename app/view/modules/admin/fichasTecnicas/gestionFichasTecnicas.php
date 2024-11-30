<?php
include_once 'model/fichaTecnica.php';
include_once 'controller/fichaTecnica.php';
include_once 'model/indicador.php';
include_once 'controller/indicador.php';
include_once 'model/tematica.php';
include_once 'controller/tematica.php';
include_once 'model/dimension.php';
include_once 'controller/dimension.php';
include_once 'model/rol.php';
include_once 'controller/rol.php';
include_once 'model/log.php';
include_once 'controller/log.php';
include_once 'model/modulo.php';
include_once 'controller/modulo.php';
session_start();
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$idConj = "";
if (isset($_GET['conj'])) {
    $idConj = $_GET['conj'];
}
$permiso = $rol->consultarPermisoRol("fichasTecnicas" . $idConj, $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
}
?>
<html>
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
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'view/modules/header.php'; ?>
            <?php include 'view/modules/side.php'; ?>
            <div class="content-wrapper" style="padding: 20px; background-color: #fff;">
                <?php
                if (!empty($idConj)) {
                    $modulo = new Modulo();
                    $nombreModulo = "fichastecnicas";
                    $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
                    $log = new LogController();
                    $log->crearLog($idModulo, "Ingreso a módulo de gestión de fichas técnicas del conjunto " . $idConj);
                    $ser = new FichaTecnicaController();
                    $resp = $ser->listarFichas($idConj);
                }
                ?>
            </div>
        </div>
        <?php include 'view/modules/footer.php'; ?>
        <script>
            var conjunto = "#fichasTecnicas" + "<?php echo $idConj; ?>";
            $(conjunto).addClass("active");
            $("#fichasTecnicas").addClass("active");
        </script>
    </body>
</html>
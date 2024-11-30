<?php
include_once 'model/estado.php';
include_once 'controller/estado.php';
include_once 'model/rol.php';
include_once 'controller/rol.php';
session_start();
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$permiso = $rol->consultarPermisoRol("estados", $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$eliminar && ($crear || $modificar)) {
    header("Location: index.php?action=admin/estados/gestionEstados");
}
?>
<html>
    <?php include 'view/modules/head.php'; ?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'view/modules/header.php'; ?>
            <?php include 'view/modules/side.php'; ?>
            <div class="content-wrapper" style="background-color: #fff;">
                <?php
                $idEst= "";
                if (isset($_GET['est'])) {
                    $idEst = $_GET['est'];
                }
                if (!empty($idEst)) {
                    $est = new EstadoController();
                    $resp = $est->eliminarEstadoForm($idEst);
                }
                ?>
            </div>
        </div>
        <?php include 'view/modules/footer.php'; ?>
    </body>
</html>
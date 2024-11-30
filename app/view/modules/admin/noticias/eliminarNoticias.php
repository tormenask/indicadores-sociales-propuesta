<?php
include_once 'model/noticias.php';
include_once 'controller/noticias.php';
include_once 'model/rol.php';
include_once 'controller/rol.php';
session_start();
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$permiso = $rol->consultarPermisoRol("noticias", $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$modificar && ($crear || $eliminar)) {
    header("Location: index.php?action=admin/noticias/gestionNoticias");
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
                $idNot = "";
                if (isset($_GET['not'])) {
                    $idNot= $_GET['not'];
                }
                if (!empty($idNot)) {
                    $not = new NoticiasController();
                    $resp = $not->eliminarNoticiasForm($idNot);
                }
                ?>
            </div>
        </div>
        <?php include 'view/modules/footer.php'; ?>
    </body>
</html>
<?php
include_once 'model/rol.php';
include_once 'controller/rol.php';
include_once 'model/organismo.php';
include_once 'controller/organismo.php';
include_once 'model/estado.php';
include_once 'controller/estado.php';
session_start();
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$permiso = $rol->consultarPermisoRol("roles", $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$eliminar && ($crear || $modificar)) {
    header("Location: index.php?action=admin/roles/gestionRoles");
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
                $rolEl = "";
                if (isset($_GET['rol'])) {
                    $rolEl = $_GET['rol'];
                }
                if (!empty($rolEl)) {
                    $role = new RolController();
                    $resp = $role->eliminarRolForm($rolEl);
                }
                ?>
            </div>
        </div>
        <?php include 'view/modules/footer.php'; ?>
    </body>
</html>
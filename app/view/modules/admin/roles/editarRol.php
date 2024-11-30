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
} elseif (!$modificar && ($crear || $eliminar)) {
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
                $rolEd = "";
                if (isset($_GET['rol'])) {
                    $rolEd= $_GET['rol'];
                }
                if (!empty($idRol)) {
                    $role = new RolController();
                    $resp = $role->editarRolForm($rolEd);
                }
                ?>
            </div>
        </div>
        <?php include 'view/modules/footer.php'; ?>
    </body>
</html>
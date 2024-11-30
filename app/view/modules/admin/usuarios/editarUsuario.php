<?php
include_once 'model/crud_usuario.php';
include_once 'controller/usuario.php';
include_once 'model/rol.php';
include_once 'controller/rol.php';
include_once 'model/organismo.php';
include_once 'controller/organismo.php';
include_once 'model/estado.php';
include_once 'controller/estado.php';
session_start();
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$permiso = $rol->consultarPermisoRol("usuarios", $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$modificar && ($crear || $eliminar)) {
    header("Location: index.php?action=admin/usuarios/gestionUsuarios");
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
                $numeroIdentificacion = "";
                if (isset($_GET['user'])) {
                    $numeroIdentificacion = $_GET['user'];
                }
                if (!empty($numeroIdentificacion)) {
                    $user = new UsuarioController();
                    $resp = $user->editarUsuarioForm($numeroIdentificacion);
                }
                ?>
            </div>
        </div>
        <?php include 'view/modules/footer.php'; ?>
    </body>
</html>
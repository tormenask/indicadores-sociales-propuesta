<?php
include_once 'model/rol.php';
include_once 'controller/rol.php';
include_once 'model/log.php';
include_once 'controller/log.php';
include_once 'model/modulo.php';
include_once 'controller/modulo.php';
include_once 'model/conjuntoIndicadores.php';
include_once 'controller/conjuntoIndicadores.php';
include_once 'model/modulo.php';
include_once 'controller/modulo.php';
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
                $idRolCP = "";
                if (isset($_GET['rol'])) {
                    $idRolCP = $_GET['rol'];
                }
                if (!empty($idRolCP)) {
                    $modulo = new Modulo();
                    $nombreModulo = "roles";
                    $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
                    $log = new LogController();
                    $log->crearLog($idModulo, "Ingreso a módulo de gestión de permisos para el rol " . $idRolCP . ".");
                    $role = new RolController();
                    $resp = $role->cambiarPermisosForm($idRolCP);
                }
                ?>
            </div>
        </div>
        <?php include 'view/modules/footer.php'; ?>
    </body>
</html>
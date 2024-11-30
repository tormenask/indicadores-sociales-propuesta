<?php
include_once 'model/publicaciones.php';
include_once 'controller/publicaciones.php';
include_once 'model/conjuntoIndicadores.php';
include_once 'controller/conjuntoIndicadores.php';
include_once 'model/rol.php';
include_once 'controller/rol.php';
session_start();
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$conjunto = new ConjuntoIndicadores();
$idConj = "";
if (isset($_GET['conj'])) {
    $idConj = $_GET['conj'];
}
$conjuntoAct = $conjunto->consultarConjuntoIndicadores($idConj);
$permiso = $rol->consultarPermisoRol("publicaciones" . $idConj, $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$eliminar && ($crear || $modificar)) {
    header("Location: index.php?action=admin/publicaciones/gestionPublicaciones&conj=" . $idConj);
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
                $idUrl = "";
                if (isset($_GET['publi'])) {
                    $idUrl = $_GET['publi'];
                }
                if (!empty($idUrl)) {
                    $public = new PublicacionesController();
                    $resp = $public->eliminarPublicacionesForm($idUrl);
                }
                ?>
            </div>
        </div>
        <?php include 'view/modules/footer.php'; ?>
    </body>
</html>
<?php
include_once 'model/indicadorVariable.php';
include_once 'controller/indicadorVariable.php';
include_once 'model/indicador.php';
include_once 'controller/indicador.php';
include_once 'model/variable.php';
include_once 'controller/variable.php';
include_once 'model/rol.php';
include_once 'controller/rol.php';
session_start();
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$idConj = "";
if (isset($_GET['conj'])) {
    $idConj = $_GET['conj'];
}
$permiso = $rol->consultarPermisoRol("indicadoresvariables" . $idConj, $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$eliminar && ($crear || $modificar)) {
    header("Location: index.php?action=admin/indicadoresvariables/gestionIndicadoresvariables&conj=" . $idConj);
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
                $idIndV= "";
                if (isset($_GET['indV'])) {
                    $idIndV= $_GET['indV'];
                }
                if (!empty($idIndV)) {
                    $indicadorV = new IndicadorVariableController();
                    $resp = $indicadorV->eliminarRelacionForm($idIndV);
                }
                ?>
            </div>
        </div>
        <?php include 'view/modules/footer.php'; ?>
    </body>
</html>
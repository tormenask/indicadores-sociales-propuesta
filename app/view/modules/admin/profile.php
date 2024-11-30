<?php
include_once 'model/organismo.php';
include_once 'model/estado.php';
include_once 'model/rol.php';
include_once 'model/crud_usuario.php';
include_once 'controller/usuario.php';
session_start();
?>
<html><meta charset="UTF-8">
    <?php include 'view/modules/head.php'; ?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'view/modules/header.php'; ?>
            <?php include 'view/modules/side.php'; ?>
            <div class="content-wrapper">
                <div id="content-profile" style="padding-top:20px;">
                    <?php
                    $role = new UsuarioController();
                    $resp = $role->buscarUsuario($_SESSION['userData']['correoElectronico']);
                    ?>
                </div>
            </div>
        </div>
        <?php include 'view/modules/footer.php'; ?>
    </body>
</html>

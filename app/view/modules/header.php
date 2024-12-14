<?php
if (isset($_SESSION['userData'])) {

    include_once 'model/rol.php';
    include_once 'controller/rol.php';

    $nombre = $_SESSION['userData']['nombre'];
    $genero = $_SESSION['userData']['genero'];
    $idRol = $_SESSION['userData']['idRol'];
    $rol = new Rol();
    $permiso = $rol->consultarPermisoRol("notificaciones", $idRol);
    $crear = $permiso["crear"];
    $modificar = $permiso["modificar"];
    $eliminar = $permiso["eliminar"];
}
?>
<header class="main-header">
    <!-- Logo -->
    <a href="index.php?action=admin/home" class="logo" style="color: #2fb56a;background-color: #fff; height: 60px;">
        <span class="logo-mini" style="padding: 5px 10px;">
            <b>SIS</b>
        </span>
        <span class="logo-lg">
            <img src="app/view/resources/images/logo.png" alt="Logo del Sistema de Indicadores Sociales" style="height: 60px;">
        </span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" style="padding: 20px 15px;">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav navbar-right">
                <?php
                if ($crear && $modificar && $eliminar) {
                    echo ' 
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle"id="notif"  data-toggle="dropdown">
                                <span class="label label-pill label-danger count" style="border-radius:10px;"></span>
                                <span class="glyphicon glyphicon-bell" style="font-size:18px;"></span>
                            </a>
                            <ul class="dropdown-menu" id="notif-menu"></ul>
                        </li>
                        <script>
                            var url = "app/view/resources/js/update-notifications.js";
                            $.getScript(url);
                        </script>
                        ';
                }
                ?>

                <li class="dropdown" style="margin-right: 20px;margin-top: 5px;">
                    <button class="btn btn-default dropdown-toggle" type="button" id="profile" data-toggle="dropdown">
                        <?php
                        if ($genero == "Femenino") {
                            echo ' <img src="app/view/resources/images/login-female.png" style="height: 35px;">';
                        } elseif ($genero == "Masculino"){
                            echo ' <img src="app/view/resources/images/login-male.png" style="height: 35px;">';
                        }
                        ?>

                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu menu-left" role="menu" aria-labelledby="profile">
                        <li role="presentation" class="dropdown-header"><p><?php echo $nombre ?></p></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="index.php?action=admin/home">Panel de administración</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="index.php?action=admin/profile">Mi perfil</a></li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="index.php?action=admin/salir">Salir</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
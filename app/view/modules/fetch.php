<?php

include_once '../../model/connection.php';
include_once '../../model/notificacion.php';
include_once '../../controller/notificacion.php';

if ($_POST['view'] !== "" && $_POST['view'] !== NULL) {

    $notificacion = new NotificacionController();
    $resp = $notificacion->listarNotificacionesSinLeer();
}
?>
<?php

require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/notificacion.php';
require_once '../../../../model/notificacion.php';

class FuncionesNotificaciones {

    public $idNotificacion;

    public function cambiarEstadoNotificacion() {
        $resp = new NotificacionController();
        $ret = $resp->cambiarEstadoNotificacion($this->idNotificacion);
        echo $ret;
    }

}

if (isset($_POST['idNotificacion'])) {
    $notificacion = new FuncionesNotificaciones();
    $notificacion->idNotificacion= $_POST['idNotificacion'];
    $notificacion->cambiarEstadoNotificacion();
}

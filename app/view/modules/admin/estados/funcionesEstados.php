<?php

require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/estado.php';
require_once '../../../../model/estado.php';
require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/rol.php';
require_once '../../../../model/rol.php';

class FuncionesEstados {

    public $nombreEstado, $descripcionEstado;
    public $idEstadoEd, $nombreEstadoEd, $descripcionEstadoEd;
    public $idEstadoEl;

    public function crearEstado() {
        $resp = new EstadoController();
        $ret = $resp->crearEstado($this->nombreEstado, $this->descripcionEstado);
        echo $ret;
    }

    public function editarEstado() {
        $resp = new EstadoController();
        $ret = $resp->editarEstado($this->idEstadoEd, $this->nombreEstadoEd, $this->descripcionEstadoEd);
        echo $ret;
    }

    public function eliminarEstado() {
        $resp = new EstadoController();
        $ret = $resp->eliminarEstado($this->idEstadoEl);
        echo $ret;
    }

}

if (isset($_POST['nombreEstado']) && isset($_POST['descripcionEstado'])) {
    $estado = new FuncionesEstados();
    $estado->nombreEstado = $_POST['nombreEstado'];
    $estado->descripcionEstado = $_POST['descripcionEstado'];
    $estado->crearEstado();
}
if (isset($_POST['idEstadoEd']) && isset($_POST['nombreEstadoEd']) && isset($_POST['descripcionEstadoEd'])) {
    $estado = new FuncionesEstados();
    $estado->idEstadoEd = $_POST['idEstadoEd'];
    $estado->nombreEstadoEd = $_POST['nombreEstadoEd'];
    $estado->descripcionEstadoEd = $_POST['descripcionEstadoEd'];
    $estado->editarEstado();
}
if (isset($_POST['idEstadoEl'])) {
    $estado = new FuncionesEstados();
    $estado->idEstadoEl = $_POST['idEstadoEl'];
    $estado->eliminarEstado();
}
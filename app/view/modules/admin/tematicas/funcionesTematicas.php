<?php

require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/notificacion.php';
require_once '../../../../model/notificacion.php';
require_once '../../../../controller/tematica.php';
require_once '../../../../model/tematica.php';
require_once '../../../../controller/dimension.php';
require_once '../../../../model/dimension.php';

class FuncionesTematicas {

    public $nombreTematica, $descripcionTematica, $idDimension, $posicion;
    public $idTematicaEd, $nombreTematicaEd, $descripcionTematicaEd, $idDimensionEd, $posicionEd;
    public $idTematicaEl;
    public $dimensionIndicador;

    public function crearTematica() {
        $data1 = $this->nombreTematica;
        $data2 = $this->descripcionTematica;
        $data3 = $this->idDimension;
        $data4 = $this->posicion;
        $resp = new TematicaController();
        $ret = $resp->crearTematica($data1, $data2, $data3, $data4);
        echo $ret;
    }

    public function editarTematica() {
        $data1 = $this->idTematicaEd;
        $data2 = $this->nombreTematicaEd;
        $data3 = $this->descripcionTematicaEd;
        $data4 = $this->idDimensionEd;
        $data5 = $this->posicionEd;
        $resp = new TematicaController();
        $ret = $resp->editarTematica($data1, $data2, $data3, $data4, $data5);
        echo $ret;
    }

    public function eliminarTematica() {
        $data1 = $this->idTematicaEl;
        $resp = new TematicaController();
        $ret = $resp->eliminarTematica($data1);
        echo $ret;
    }

    public function listarTematicasDimension() {
        $data1 = $this->dimensionIndicador;
        $resp = new TematicaController();
        $ret = $resp->listarTematicasDimension($data1);
        echo $ret;
    }

}

if (isset($_POST['nombreTematica']) && isset($_POST['descripcionTematica']) && isset($_POST['dimensionTematica']) && isset($_POST['posicion'])) {
    $tematica = new FuncionesTematicas();
    $tematica->nombreTematica = $_POST['nombreTematica'];
    $tematica->descripcionTematica = $_POST['descripcionTematica'];
    $tematica->idDimension = $_POST['dimensionTematica'];
    $tematica->posicion = $_POST['posicion'];
    $tematica->crearTematica();
}

if (isset($_POST['idTematicaEd']) && isset($_POST['nombreTematicaEd']) && isset($_POST['descripcionTematicaEd']) && isset($_POST['idDimensionEd']) && isset($_POST['posicionEd'])) {
    $tematica = new FuncionesTematicas();
    $tematica->idTematicaEd = $_POST['idTematicaEd'];
    $tematica->nombreTematicaEd = $_POST['nombreTematicaEd'];
    $tematica->descripcionTematicaEd = $_POST['descripcionTematicaEd'];
    $tematica->idDimensionEd = $_POST['idDimensionEd'];
    $tematica->posicionEd = $_POST['posicionEd'];
    $tematica->editarTematica();
}

if (isset($_POST['idTematicaEl'])) {
    $tematica = new FuncionesTematicas();
    $tematica->idTematicaEl = $_POST['idTematicaEl'];
    $tematica->eliminarTematica();
}

if (isset($_POST['dimensionInd'])) {
    $tematica = new FuncionesTematicas();
    $tematica->dimensionIndicador = $_POST['dimensionInd'];
    $tematica->listarTematicasDimension();
}


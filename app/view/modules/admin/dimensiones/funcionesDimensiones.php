<?php

require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/notificacion.php';
require_once '../../../../model/notificacion.php';
require_once '../../../../controller/dimension.php';
require_once '../../../../model/dimension.php';
require_once '../../../../controller/conjuntoIndicadores.php';
require_once '../../../../model/conjuntoIndicadores.php';

class FuncionesDimensiones {

    public $nombreDimension, $descripcionDimension, $idConjuntoDimension, $posicion, $icono, $color;
    public $idDimensionEd, $nombreDimensionEd, $descripcionDimensionEd, $idConjuntoEd, $posicionEd, $iconoEd, $colorEd;
    public $idDimensionEl;
    public $conjuntoTem;

    public function crearDimension() {
        $data1 = $this->nombreDimension;
        $data2 = $this->descripcionDimension;
        $data3 = $this->idConjuntoDimension;
        $data4 = $this->posicion;
        $data5 = $this->icono;
        $data6 = $this->color;
        $resp = new DimensionController();
        $ret = $resp->crearDimension($data1, $data2, $data3, $data4, $data5, $data6);
        echo $ret;
    }

    public function editarDimension() {
        $data1 = $this->idDimensionEd;
        $data2 = $this->nombreDimensionEd;
        $data3 = $this->descripcionDimensionEd;
        $data4 = $this->idConjuntoEd;
        $data5 = $this->posicionEd;
        $data6 = $this->iconoEd;
        $data7 = $this->colorEd;
        $resp = new DimensionController();
        $ret = $resp->editarDimension($data1, $data2, $data3, $data4, $data5, $data6, $data7);
        echo $ret;
    }

    public function eliminarDimension() {
        $data1 = $this->idDimensionEl;
        $resp = new DimensionController();
        $ret = $resp->eliminarDimension($data1);
        echo $ret;
    }

    public function listarDimensionesConjunto() {
        $data1 = $this->conjuntoTem;
        $resp = new DimensionController();
        $ret = $resp->listarDimensionesConjunto($data1);
        echo $ret;
    }

}

if (isset($_POST['nombreDimension']) && isset($_POST['descripcionDimension']) && isset($_POST['conjuntoDimension']) && isset($_POST['posicion']) && isset($_POST['file']) && isset($_POST['color'])) {
    $dimension = new FuncionesDimensiones();
    $dimension->nombreDimension = $_POST['nombreDimension'];
    $dimension->descripcionDimension = $_POST['descripcionDimension'];
    $dimension->idConjuntoDimension = $_POST['conjuntoDimension'];
    $dimension->posicion = $_POST['posicion'];
    if ($_POST['file'] == TRUE && isset($_FILES['icono'])) {
        $dimension->icono = $_FILES['icono'];
    } else {
        $dimension->icono = "noIcono";
    }
    $dimension->color = $_POST['color'];
    $dimension->crearDimension();
}

if (isset($_POST['idDimensionEd']) && isset($_POST['nombreDimensionEd']) && isset($_POST['descripcionDimensionEd']) && isset($_POST['idConjuntoEd']) && isset($_POST['posicionEd']) && isset($_POST['file']) && isset($_POST['colorEd'])) {
    $dimension = new FuncionesDimensiones();
    $dimension->idDimensionEd = $_POST['idDimensionEd'];
    $dimension->nombreDimensionEd = $_POST['nombreDimensionEd'];
    $dimension->descripcionDimensionEd = $_POST['descripcionDimensionEd'];
    $dimension->idConjuntoEd = $_POST['idConjuntoEd'];
    $dimension->posicionEd = $_POST['posicionEd'];
    if ($_POST['file'] == TRUE && isset($_FILES['iconoEd'])) {
        $dimension->iconoEd = $_FILES['iconoEd'];
    } else {
        $dimension->iconoEd = "noIcono";
    }
    $dimension->colorEd = $_POST['colorEd'];
    $dimension->editarDimension();
}

if (isset($_POST['idDimensionEl'])) {
    $dimension = new FuncionesDimensiones();
    $dimension->idDimensionEl = $_POST['idDimensionEl'];
    $dimension->eliminarDimension();
}

if (isset($_POST['conjuntoTem'])) {
    $dimension = new FuncionesDimensiones();
    $dimension->conjuntoTem = $_POST['conjuntoTem'];
    $dimension->listarDimensionesConjunto();
}


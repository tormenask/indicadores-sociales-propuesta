<?php

require_once '../../../../controller/conjuntoIndicadores.php';
require_once '../../../../model/conjuntoIndicadores.php';
require_once '../../../../controller/rol.php';
require_once '../../../../model/rol.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/notificacion.php';
require_once '../../../../model/notificacion.php';
require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';

class FuncionesConjuntosIndicadores {

    public $idConjunto, $nombreConjunto, $descripcionConjunto, $idOrganismoConjunto;
    public $idConjuntoEd, $nombreConjuntoEd, $descripcionConjuntoEd, $idOrganismoConjuntoEd;
    public $idConjuntoEl;

    public function crearConjunto() {
        $data1 = $this->idConjunto;
        $data2 = $this->nombreConjunto;
        $data3 = $this->descripcionConjunto;
        $data4 = $this->idOrganismoConjunto;
        $resp = new ConjuntoIndicadoresController();
        $ret = $resp->crearConjunto($data1, $data2, $data3, $data4);
        echo $ret;
    }

    public function editarConjunto() {
        $data1 = $this->idConjuntoEd;
        $data2 = $this->nombreConjuntoEd;
        $data3 = $this->descripcionConjuntoEd;
        $data4 = $this->idOrganismoConjuntoEd;
        $resp = new ConjuntoIndicadoresController();
        $ret = $resp->editarConjunto($data1, $data2, $data3, $data4);
        echo $ret;
    }

    public function eliminarConjunto() {
        $data1 = $this->idConjuntoEl;
        $resp = new ConjuntoIndicadoresController();
        $ret = $resp->eliminarConjunto($data1);
        echo $ret;
    }

}

if (isset($_POST['idConjunto']) && isset($_POST['nombreConjunto']) && isset($_POST['descripcionConjunto']) && isset($_POST['idOrganismoConjunto'])) {
    $conjunto = new FuncionesConjuntosIndicadores();
    $conjunto->idConjunto = $_POST['idConjunto'];
    $conjunto->nombreConjunto = $_POST['nombreConjunto'];
    $conjunto->descripcionConjunto = $_POST['descripcionConjunto'];
    $conjunto->idOrganismoConjunto = $_POST['idOrganismoConjunto'];
    $conjunto->crearConjunto();
}
if (isset($_POST['idConjuntoEd']) && isset($_POST['nombreConjuntoEd']) && isset($_POST['descripcionConjuntoEd']) && isset($_POST['idOrganismoConjuntoEd'])) {
    $conjunto = new FuncionesConjuntosIndicadores();
    $conjunto->idConjuntoEd = $_POST['idConjuntoEd'];
    $conjunto->nombreConjuntoEd = $_POST['nombreConjuntoEd'];
    $conjunto->descripcionConjuntoEd = $_POST['descripcionConjuntoEd'];
    $conjunto->idOrganismoConjuntoEd = $_POST['idOrganismoConjuntoEd'];
    $conjunto->editarConjunto();
}
if (isset($_POST['idConjuntoEl'])) {
    $conjunto = new FuncionesConjuntosIndicadores();
    $conjunto->idConjuntoEl = $_POST['idConjuntoEl'];
    $conjunto->eliminarConjunto();
}
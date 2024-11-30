<?php

require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/variable.php';
require_once '../../../../model/variable.php';
require_once '../../../../controller/rol.php';
require_once '../../../../model/rol.php';

class FuncionesDatosVariables {

    public $fechaDato, $valorDato, $estadoObservacionDato, $idVariableDat;
    public $idDatoEdit, $fechaDatoEdit, $valorDatoEdit, $estadoObservacionDatoEdit, $idVariableDatEdit;
    public $idDatoDelete, $fechaDatoDelete, $idVariableDatDelete;

    public function crearDato() {
        $resp = new VariableController();
        $ret = $resp->crearDatoVariable($this->fechaDato, $this->valorDato, $this->estadoObservacionDato, $this->idVariableDat);
        echo $ret;
    }

    public function editarDato() {
        $resp = new VariableController();
        $ret = $resp->editarDatoVariable($this->idDatoEdit, $this->fechaDatoEdit, $this->valorDatoEdit, $this->estadoObservacionDatoEdit, $this->idVariableDatEdit);
        echo $ret;
    }

    public function eliminarDato() {
        $resp = new VariableController();
        $ret = $resp->eliminarDatoVariable($this->idDatoDelete, $this->fechaDatoDelete, $this->idVariableDatDelete);
        echo $ret;
    }

}

if (isset($_POST['fechaDato']) && isset($_POST['valorDato']) && isset($_POST['estadoObservacionDato']) && isset($_POST['idVariableDat'])) {
    $datosV = new FuncionesDatosVariables();
    $datosV->fechaDato = $_POST['fechaDato'];
    $datosV->valorDato = $_POST['valorDato'];
    $datosV->estadoObservacionDato = $_POST['estadoObservacionDato'];
    $datosV->idVariableDat = $_POST['idVariableDat'];
    $datosV->crearDato();
}

if (isset($_POST['idDatoEdit']) && isset($_POST['fechaDatoEdit']) && isset($_POST['valorDatoEdit']) && isset($_POST['estadoObservacionDatoEdit']) && isset($_POST['idVariableDatEdit'])) {
    $datosV = new FuncionesDatosVariables();
    $datosV->idDatoEdit = $_POST['idDatoEdit'];
    $datosV->fechaDatoEdit = $_POST['fechaDatoEdit'];
    $datosV->valorDatoEdit = $_POST['valorDatoEdit'];
    $datosV->estadoObservacionDatoEdit = $_POST['estadoObservacionDatoEdit'];
    $datosV->idVariableDatEdit = $_POST['idVariableDatEdit'];
    $datosV->editarDato();
}

if (isset($_POST['idDatoDelete']) && isset($_POST['fechaDatoDelete']) && isset($_POST['idVariableDatDelete'])) {
    $datosV = new FuncionesDatosVariables();
    $datosV->idDatoDelete = $_POST['idDatoDelete'];
    $datosV->fechaDatoDelete = $_POST['fechaDatoDelete'];
    $datosV->idVariableDatDelete= $_POST['idVariableDatDelete'];
    $datosV->eliminarDato();
}
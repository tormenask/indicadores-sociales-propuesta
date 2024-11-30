<?php

require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/indicadorVariable.php';
require_once '../../../../model/indicadorVariable.php';
require_once '../../../../controller/indicador.php';
require_once '../../../../model/indicador.php';
require_once '../../../../controller/variable.php';
require_once '../../../../model/variable.php';

class FuncionesIndicadoresVariables {

    public $idIndicador, $idVariable;
    public $idIndVEd, $idIndicadorEd, $idVariableEd;
    public $idIndVEl;

    public function crearRelacion() {
        $resp = new IndicadorVariableController();
        $ret = $resp->crearRelacion($this->idIndicador, $this->idVariable);
        echo $ret;
    }

    public function editarRelacion() {
        $resp = new IndicadorVariableController();
        $ret = $resp->editarRelacion($this->idIndVEd, $this->idIndicadorEd, $this->idVariableEd);
        echo $ret;
    }

    public function eliminarRelacion() {
        $resp = new IndicadorVariableController();
        $ret = $resp->eliminarRelacion($this->idIndVEl);
        echo $ret;
    }

}

if (isset($_POST['indicadorIndV']) && isset($_POST['variableIndV'])) {
    $indV = new FuncionesIndicadoresVariables();
    $indV->idIndicador = $_POST['indicadorIndV'];
    $indV->idVariable = $_POST['variableIndV'];
    $indV->crearRelacion();
}

if (isset($_POST['idIndVEd']) && isset($_POST['indicadorIndVEd']) && isset($_POST['variableIndVEd'])) {
    $indV = new FuncionesIndicadoresVariables();
    $indV->idIndVEd = $_POST['idIndVEd'];
    $indV->idIndicadorEd = $_POST['indicadorIndVEd'];
    $indV->idVariableEd = $_POST['variableIndVEd'];
    $indV->editarRelacion();
}

if (isset($_POST['idIndVEl'])) {
    $indV = new FuncionesIndicadoresVariables();
    $indV->idIndVEl = $_POST['idIndVEl'];
    $indV->eliminarRelacion();
}


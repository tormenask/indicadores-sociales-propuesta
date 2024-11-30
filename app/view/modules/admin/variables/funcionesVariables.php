<?php

require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/variable.php';
require_once '../../../../model/variable.php';
require_once '../../../../controller/indicador.php';
require_once '../../../../model/indicador.php';
require_once '../../../../controller/conjuntoIndicadores.php';
require_once '../../../../model/conjuntoIndicadores.php';

class FuncionesVariables {

    public $nombreVariable, $tipoDato, $tipoZonaGeografica, $zonaGeografica, $periodicidad, $entidadCompiladora, $fuenteDatos, $urlFuenteDatos, $desagregacionTematica, $notas, $unidadMedida, $idConjuntoIndicadores;
    public $idVariableEd, $nombreVariableEd, $tipoDatoEd, $tipoZonaGeograficaEd, $zonaGeograficaEd, $periodicidadEd, $entidadCompiladoraEd, $fuenteDatosEd, $urlFuenteDatosEd, $desagregacionTematicaEd, $notasEd, $unidadMedidaEd, $idConjuntoIndicadoresEd;
    public $idVariableEl;
    public $idVariableDat;

    public function crearVariable() {
        $resp = new VariableController();
        $ret = $resp->crearVariable($this->nombreVariable, $this->tipoDato, $this->tipoZonaGeografica, $this->zonaGeografica, $this->periodicidad, $this->entidadCompiladora, $this->fuenteDatos, $this->urlFuenteDatos, $this->desagregacionTematica, $this->notas, $this->unidadMedida, $this->idConjuntoIndicadores);
        echo $ret;
    }

    public function editarVariable() {
        $resp = new VariableController();
        $ret = $resp->editarVariable($this->idVariableEd, $this->nombreVariableEd, $this->tipoDatoEd, $this->tipoZonaGeograficaEd, $this->zonaGeograficaEd, $this->periodicidadEd, $this->entidadCompiladoraEd, $this->fuenteDatosEd, $this->urlFuenteDatosEd, $this->desagregacionTematicaEd, $this->notasEd, $this->unidadMedidaEd, $this->idConjuntoIndicadoresEd);
        echo $ret;
    }

    public function eliminarVariable() {
        $resp = new VariableController();
        $ret = $resp->eliminarVariable($this->idVariableEl);
        echo $ret;
    }

    public function consultarDatosVariable() {
        $resp = new VariableController();
        $ret = $resp->listarDatosVariable($this->idVariableDat);
        echo $ret;
    }

}

if (
        isset($_POST['nombreVariable']) && isset($_POST['tipoDatoVariable']) &&
        isset($_POST['tipoZonaGeograficaVariable']) && isset($_POST['zonaGeograficaVariable']) &&
        isset($_POST['periodicidadVariable']) && isset($_POST['entidadCompiladoraVariable']) &&
        isset($_POST['fuenteDatosVariable']) && isset($_POST['urlFuenteDatosVariable']) &&
        isset($_POST['desagregacionTematicaVariable']) && isset($_POST['notasVariable']) &&
        isset($_POST['unidadMedidaVariable']) && isset($_POST['conjuntoVariable'])
) {
    $variable = new FuncionesVariables();
    $variable->nombreVariable = $_POST['nombreVariable'];
    $variable->tipoDato = $_POST['tipoDatoVariable'];
    $variable->tipoZonaGeografica = $_POST['tipoZonaGeograficaVariable'];
    $variable->zonaGeografica = $_POST['zonaGeograficaVariable'];
    $variable->periodicidad = $_POST['periodicidadVariable'];
    $variable->entidadCompiladora = $_POST['entidadCompiladoraVariable'];
    $variable->fuenteDatos = $_POST['fuenteDatosVariable'];
    $variable->urlFuenteDatos = $_POST['urlFuenteDatosVariable'];
    $variable->desagregacionTematica = $_POST['desagregacionTematicaVariable'];
    $variable->notas = $_POST['notasVariable'];
    $variable->unidadMedida = $_POST['unidadMedidaVariable'];
    $variable->idConjuntoIndicadores = $_POST['conjuntoVariable'];
    $variable->crearVariable();
}
if (
        isset($_POST['idVariableEd']) &&
        isset($_POST['nombreVariableEd']) && isset($_POST['tipoDatoVariableEd']) &&
        isset($_POST['tipoZonaGeograficaVariableEd']) && isset($_POST['zonaGeograficaVariableEd']) &&
        isset($_POST['periodicidadVariableEd']) && isset($_POST['entidadCompiladoraVariableEd']) &&
        isset($_POST['fuenteDatosVariableEd']) && isset($_POST['urlFuenteDatosVariableEd']) &&
        isset($_POST['desagregacionTematicaVariableEd']) && isset($_POST['notasVariableEd']) &&
        isset($_POST['unidadMedidaVariableEd']) && isset($_POST['conjuntoVariableEd'])
) {
    $variable = new FuncionesVariables();
    $variable->idVariableEd = $_POST['idVariableEd'];
    $variable->nombreVariableEd = $_POST['nombreVariableEd'];
    $variable->tipoDatoEd = $_POST['tipoDatoVariableEd'];
    $variable->tipoZonaGeograficaEd = $_POST['tipoZonaGeograficaVariableEd'];
    $variable->zonaGeograficaEd = $_POST['zonaGeograficaVariableEd'];
    $variable->periodicidadEd = $_POST['periodicidadVariableEd'];
    $variable->entidadCompiladoraEd = $_POST['entidadCompiladoraVariableEd'];
    $variable->fuenteDatosEd = $_POST['fuenteDatosVariableEd'];
    $variable->urlFuenteDatosEd = $_POST['urlFuenteDatosVariableEd'];
    $variable->desagregacionTematicaEd = $_POST['desagregacionTematicaVariableEd'];
    $variable->notasEd = $_POST['notasVariableEd'];
    $variable->unidadMedidaEd = $_POST['unidadMedidaVariableEd'];
    $variable->idConjuntoIndicadoresEd = $_POST['conjuntoVariableEd'];
    $variable->editarVariable();
}

if (isset($_POST['idVariableEl'])) {
    $variable = new FuncionesVariables();
    $variable->idVariableEl = $_POST['idVariableEl'];
    $variable->eliminarVariable();
}

if (isset($_POST['idVariableDat'])) {
    $variable = new FuncionesVariables();
    $variable->idVariableDat = $_POST['idVariableDat'];
    $variable->consultarDatosVariable();
//    var_dump($variable->idVariableDat);
}

<?php

require_once '../../../../controller/dato.php';
require_once '../../../../model/dato.php';
require_once '../../../../controller/serieDatos.php';
require_once '../../../../model/serieDatos.php';
require_once '../../../../controller/indicador.php';
require_once '../../../../model/indicador.php';
require_once '../../../../controller/tematica.php';
require_once '../../../../model/tematica.php';
require_once '../../../../controller/dimension.php';
require_once '../../../../model/dimension.php';
require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/rol.php';
require_once '../../../../model/rol.php';

class FuncionesDatos {

    public $idConjuntoIndicadoresDim, $idDimensionTem, $idTematicaInd, $idIndicadorDat;
    public $idIndicadorDat2, $tipoZonaDat;
    public $idIndicadorDat3, $tipoZonaDat3, $zonaDat3;
    public $idIndicadorDat4, $tipoZonaDat4, $zonaDat4, $desagregacionTematicaDat4, $idRolDat4;
    public $fechaDato, $valorDato, $estadoObservacionDato, $idSerieDatos;
    public $idDatoEdit, $fechaDatoEdit, $valorDatoEdit, $estadoObservacionDatoEdit, $idSerieDatosEdit;
    public $idDatoDelete, $fechaDatoDelete, $idSerieDatosDelete;

    public function crearDato() {
        $resp = new DatoController();
        $ret = $resp->crearDato($this->fechaDato, $this->valorDato, $this->estadoObservacionDato, $this->idSerieDatos);
        echo $ret;
    }

    public function editarDato() {
        $resp = new DatoController();
        $ret = $resp->editarDato($this->idDatoEdit, $this->fechaDatoEdit, $this->valorDatoEdit, $this->estadoObservacionDatoEdit, $this->idSerieDatosEdit);
        echo $ret;
    }

    public function eliminarDato() {
        $resp = new DatoController();
        $ret = $resp->eliminarDato($this->idDatoDelete, $this->fechaDatoDelete, $this->idSerieDatosDelete);
        echo $ret;
    }

    public function consultarDimensionesConjunto() {
        $resp = new DimensionController();
        $ret = $resp->listarDimensionesConjuntoDatos($this->idConjuntoIndicadoresDim);
        echo $ret;
    }

    public function consultarTematicasDimension() {
        $resp = new TematicaController();
        $ret = $resp->listarTematicasDimensionDatos($this->idDimensionTem);
        echo $ret;
    }

    public function consultarIndicadoresTematica() {
        $resp = new IndicadorController();
        $ret = $resp->listarIndicadoresTematicaDatos($this->idTematicaInd);
        echo $ret;
    }

    public function consultarTiposZonasIndicador() {
        $resp = new SerieDatosController();
        $ret = $resp->listarTiposZonasGeograficasPorIndicador($this->idIndicadorDat);
        echo $ret;
    }

    public function consultarZonasIndicador() {
        $resp = new SerieDatosController();
        $ret = $resp->listarZonasGeograficasPorTipo($this->idIndicadorDat2, $this->tipoZonaDat);
        echo $ret;
    }

    public function consultarDesagregacionesTematicasIndicador() {
        $resp = new SerieDatosController();
        $ret = $resp->listarDesagregacionesTematicasPorIndicadorTipoZona($this->idIndicadorDat3, $this->tipoZonaDat3, $this->zonaDat3);
        echo $ret;
    }

    public function consultarDatos() {
        $resp = new DatoController();
        $ret = $resp->listarDatosIndicador($this->idIndicadorDat4, $this->tipoZonaDat4, $this->zonaDat4, $this->desagregacionTematicaDat4, $this->idRolDat4);
        echo $ret;
    }

}

if (isset($_POST['idConjuntoIndicadoresDim'])) {
    $datos = new FuncionesDatos();
    $datos->idConjuntoIndicadoresDim = $_POST['idConjuntoIndicadoresDim'];
    $datos->consultarDimensionesConjunto();
}

if (isset($_POST['idDimensionTem'])) {
    $datos = new FuncionesDatos();
    $datos->idDimensionTem = $_POST['idDimensionTem'];
    $datos->consultarTematicasDimension();
}

if (isset($_POST['idTematicaInd'])) {
    $datos = new FuncionesDatos();
    $datos->idTematicaInd = $_POST['idTematicaInd'];
    $datos->consultarIndicadoresTematica();
}

if (isset($_POST['idIndicadorDat'])) {
    $datos = new FuncionesDatos();
    $datos->idIndicadorDat = $_POST['idIndicadorDat'];
    $datos->consultarTiposZonasIndicador();
}

if (isset($_POST['idIndicadorDat2']) && isset($_POST['tipoZonaDat'])) {
    $datos = new FuncionesDatos();
    $datos->idIndicadorDat2 = $_POST['idIndicadorDat2'];
    $datos->tipoZonaDat = $_POST['tipoZonaDat'];
    $datos->consultarZonasIndicador();
}

if (isset($_POST['idIndicadorDat3']) && isset($_POST['tipoZonaDat3']) && isset($_POST['zonaDat3'])) {
    $datos = new FuncionesDatos();
    $datos->idIndicadorDat3 = $_POST['idIndicadorDat3'];
    $datos->tipoZonaDat3 = $_POST['tipoZonaDat3'];
    $datos->zonaDat3 = $_POST['zonaDat3'];
    $datos->consultarDesagregacionesTematicasIndicador();
}

if (isset($_POST['idIndicadorDat4']) && isset($_POST['tipoZonaDat4']) && isset($_POST['zonaDat4']) && isset($_POST['desagregacionTematicaDat4']) && isset($_POST['idRolDat4'])) {
    $datos = new FuncionesDatos();
    $datos->idIndicadorDat4 = $_POST['idIndicadorDat4'];
    $datos->tipoZonaDat4 = $_POST['tipoZonaDat4'];
    $datos->zonaDat4 = $_POST['zonaDat4'];
    $datos->desagregacionTematicaDat4 = $_POST['desagregacionTematicaDat4'];
    $datos->idRolDat4 = $_POST['idRolDat4'];
    $datos->consultarDatos();
}

if (isset($_POST['fechaDato']) && isset($_POST['valorDato']) && isset($_POST['estadoObservacionDato']) && isset($_POST['idSerieDatos'])) {
    $datos = new FuncionesDatos();
    $datos->fechaDato = $_POST['fechaDato'];
    $datos->valorDato = $_POST['valorDato'];
    $datos->estadoObservacionDato = $_POST['estadoObservacionDato'];
    $datos->idSerieDatos = $_POST['idSerieDatos'];
    $datos->crearDato();
}

if (isset($_POST['idDatoEdit']) && isset($_POST['fechaDatoEdit']) && isset($_POST['valorDatoEdit']) && isset($_POST['estadoObservacionDatoEdit']) && isset($_POST['idSerieDatosEdit'])) {
    $datos = new FuncionesDatos();
    $datos->idDatoEdit = $_POST['idDatoEdit'];
    $datos->fechaDatoEdit = $_POST['fechaDatoEdit'];
    $datos->valorDatoEdit = $_POST['valorDatoEdit'];
    $datos->estadoObservacionDatoEdit = $_POST['estadoObservacionDatoEdit'];
    $datos->idSerieDatosEdit = $_POST['idSerieDatosEdit'];
    $datos->editarDato();
}

if (isset($_POST['idDatoDelete']) && isset($_POST['fechaDatoDelete']) && isset($_POST['idSerieDatosDelete'])) {
    $datos = new FuncionesDatos();
    $datos->idDatoDelete = $_POST['idDatoDelete'];
    $datos->fechaDatoDelete = $_POST['fechaDatoDelete'];
    $datos->idSerieDatosDelete = $_POST['idSerieDatosDelete'];
    $datos->eliminarDato();
}
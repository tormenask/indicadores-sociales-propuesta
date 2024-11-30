<?php

require_once '../../../controllers/consultas.php';
require_once '../../../models/consultas.php';

require_once '../../../controllers/dimensiones.php';
require_once '../../../models/dimensiones.php';

require_once '../../../controllers/tematicas.php';
require_once '../../../models/tematicas.php';

require_once '../../../controllers/indicadores.php';
require_once '../../../models/indicadores.php';

require_once '../../../controllers/seriesDatos.php';
require_once '../../../models/seriesDatos.php';

require_once '../../../controllers/datos.php';
require_once '../../../models/datos.php';

require_once '../../../models/fichaTecnica.php';

require_once '../../../controllers/consultas.php';
require_once '../../../models/consultas.php';

require_once '../../../controllers/consultas_visualizadores.php';
require_once '../../../models/consultas_visualizadores.php';

class ConsultasIndicador {

//  Para consultas generales
    public $idIndicador1, $idIndicadorFte;
    public $idIndicador2, $desagregacionesGeograficas2;
    public $idIndicador3, $fuente3, $desagregacionesTematicas3, $desagregacionesGeograficas3;
    public $idIndicador4, $fuente4;
    public $idIndicador5, $desagregacionesGeograficas5, $fuente5;
//  Para consultas de comunas y corregimientos
    public $idIndicadorCC1;
//  Para consultas de ODRAF
    public $idIndicadorODRAF1;
//  Para realizar consulta
    public $tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuente, $desagregacionesTematicas, $fechas, $desagregacionesGeograficas;

//  Para consultas generales
    public function consultarFuentesDiferenteComunasPorIndicador() {
        $resp = new SeriesDatosController();
        $resp->consultarFuentesPorIdIndicadorDiferenteComunasFiltroController($this->idIndicadorFte);
    }

    public function consultarDesagregacionesGeograficasPorIndicador() {
        $resp = new SeriesDatosController();
        $resp->consultarDesagregacionesGeograficasPorIndicadorController($this->idIndicador1);
    }

    public function consultarDesagregacionesGeograficasPorIndicadorYFuente() {
        $resp = new SeriesDatosController();
        $resp->consultarDesagregacionesGeograficasPorIndicadorYFuenteController($this->idIndicador4, $this->fuente4);
    }

    public function consultarDesagregacionesGeograficasPorIndicadorODRAF() {
        $resp = new SeriesDatosController();
        $resp->consultarDesagregacionesGeograficasPorIndicadorTotalController($this->idIndicadorODRAF1);
    }

    public function consultarDesagregacionesTematicasPorIndicadorYDesagregacionesGeograficas() {
        $resp = new SeriesDatosController();
        $resp->consultarDesagregacionesTematicasPorIndicadorYDesagregacionesGeograficasController($this->idIndicador2, $this->desagregacionesGeograficas2);
    }
    public function consultarDesagregacionesTematicasPorIndicadorDesagregacionesGeograficasYFuente() {
        $resp = new SeriesDatosController();
        $resp->consultarDesagregacionesTematicasPorIndicadorDesagregacionesGeograficasYFuenteController($this->idIndicador5, $this->desagregacionesGeograficas5, $this->fuente5);
    }

    public function consultarFechasPorIndicadorFuenteYDesagregaciones() {
        $this->fuente3 = str_replace('_', ' ', $this->fuente3);
        $this->fuente3 = str_replace('!', '.', $this->fuente3);
        $resp = new DatosController();
        $resp->consultarFechasPorDesagregacionesIndicadorYFuenteController($this->idIndicador3, $this->fuente3, $this->desagregacionesGeograficas3, $this->desagregacionesTematicas3);
    }

//  Para consultas de comunas y corregimientos

    public function consultarDesagregacionesGeograficasComunasCorregimientosPorIndicador() {
        $resp = new SeriesDatosController();
        $resp->consultarComunasCorregimientosPorIndicadorController($this->idIndicadorCC1);
    }

//  Para realizar consulta del indicador

    public function consultaIndicador() {
        $this->fuente = str_replace('_', ' ', $this->fuente);
        $this->fuente = str_replace('!', '.', $this->fuente);
        $resp = new ConsultasController();
        if ($this->tipoConsulta == 'IGC') {
            $resp->consultaIGCController($this->idDimension, $this->idTematica, $this->idIndicador, $this->fuente, $this->desagregacionesTematicas, $this->fechas, $this->desagregacionesGeograficas, $this->tipoConsulta);
        } elseif ($this->tipoConsulta == 'ODS') {
            $resp->consultaIndicadorODSController($this->tipoConsulta, $this->idDimension, $this->idTematica, $this->idIndicador, $this->fuente, $this->desagregacionesTematicas, $this->fechas, $this->desagregacionesGeograficas);
        } else {
            $resp->consultaIndicadorController($this->tipoConsulta, $this->idDimension, $this->idTematica, $this->idIndicador, $this->fuente, $this->desagregacionesTematicas, $this->fechas, $this->desagregacionesGeograficas);
        }
    }

}

//  Para consultas generales

if (isset($_POST['idIndicadorFte'])) {
    $consulta = new ConsultasIndicador();
    $consulta->idIndicadorFte = $_POST['idIndicadorFte'];
    $consulta->consultarFuentesDiferenteComunasPorIndicador();
}

if (isset($_POST['idIndicador1'])) {
    $consulta = new ConsultasIndicador();
    $consulta->idIndicador1 = $_POST['idIndicador1'];
    $consulta->consultarDesagregacionesGeograficasPorIndicador();
}

if (isset($_POST['idIndicador4']) && isset($_POST['fuente4'])) {
    $consulta = new ConsultasIndicador();
    $consulta->idIndicador4 = $_POST['idIndicador4'];
    $consulta->fuente4 = $_POST['fuente4'];
    $consulta->consultarDesagregacionesGeograficasPorIndicadorYFuente();
}

if (isset($_POST['idIndicadorODRAF'])) {
    $consulta = new ConsultasIndicador();
    $consulta->idIndicadorODRAF1 = $_POST['idIndicadorODRAF'];
    $consulta->consultarDesagregacionesGeograficasPorIndicadorODRAF();
}

if (isset($_POST['idIndicador2']) && isset($_POST['desagregacionesGeograficas2'])) {
    $desagregaciones = new ConsultasIndicador();
    $desagregaciones->idIndicador2 = $_POST['idIndicador2'];
    $desagregaciones->desagregacionesGeograficas2 = $_POST['desagregacionesGeograficas2'];
    $desagregaciones->consultarDesagregacionesTematicasPorIndicadorYDesagregacionesGeograficas();
}

if (isset($_POST['idIndicador5']) && isset($_POST['desagregacionesGeograficas5']) && isset($_POST['fuente5'])) {
    $desagregaciones = new ConsultasIndicador();
    $desagregaciones->idIndicador5 = $_POST['idIndicador5'];
    $desagregaciones->desagregacionesGeograficas5 = $_POST['desagregacionesGeograficas5'];
    $desagregaciones->fuente5 = $_POST['fuente5'];
    $desagregaciones->consultarDesagregacionesTematicasPorIndicadorDesagregacionesGeograficasYFuente();
}

if (isset($_POST['idIndicador3']) && isset($_POST['fuente3']) && isset($_POST['desagregacionesGeograficas3']) && isset($_POST['desagregacionesTematicas3'])) {
    $consulta = new ConsultasIndicador();
    $consulta->idIndicador3 = $_POST['idIndicador3'];
    $consulta->fuente3 = $_POST['fuente3'];
    $consulta->desagregacionesGeograficas3 = $_POST['desagregacionesGeograficas3'];
    $consulta->desagregacionesTematicas3 = $_POST['desagregacionesTematicas3'];
    $consulta->consultarFechasPorIndicadorFuenteYDesagregaciones();
}

//  Para consultas de comunas y corregimientos

if (isset($_POST['idIndicadorCC1'])) {
    $consulta = new ConsultasIndicador();
    $consulta->idIndicadorCC1 = $_POST['idIndicadorCC1'];
    $consulta->consultarDesagregacionesGeograficasComunasCorregimientosPorIndicador();
}

if (isset($_POST['idIndicadorCC2']) && isset($_POST['desagregacionesGeograficasCC2'])) {
    $desagregaciones = new ConsultasIndicador();
    $desagregaciones->idIndicador2 = $_POST['idIndicadorCC2'];
    $desagregaciones->desagregacionesGeograficas2 = $_POST['desagregacionesGeograficasCC2'];
    $desagregaciones->consultarDesagregacionesTematicasPorIndicadorYDesagregacionesGeograficas();
}

if (isset($_POST['idIndicadorCC3']) && isset($_POST['fuenteCC3']) && isset($_POST['desagregacionesGeograficasCC3']) && isset($_POST['desagregacionesTematicasCC3'])) {
    $consulta = new ConsultasIndicador();
    $consulta->idIndicador3 = $_POST['idIndicadorCC3'];
    $consulta->fuente3 = $_POST['fuenteCC3'];
    $consulta->desagregacionesGeograficas3 = $_POST['desagregacionesGeograficasCC3'];
    $consulta->desagregacionesTematicas3 = $_POST['desagregacionesTematicasCC3'];
    $consulta->consultarFechasPorIndicadorFuenteYDesagregaciones();
}

if (isset($_POST['tipoConsulta']) && isset($_POST['idDimension']) && isset($_POST['idTematica']) &&
        isset($_POST['idIndicador']) && isset($_POST['fuente']) &&
        isset($_POST['desagregaciones']) && isset($_POST['fechas']) &&
        isset($_POST['zonas'])) {
    $consulta = new ConsultasIndicador();
    $consulta->tipoConsulta = $_POST['tipoConsulta'];
    $consulta->idDimension = $_POST['idDimension'];
    $consulta->idTematica = $_POST['idTematica'];
    $consulta->idIndicador = $_POST['idIndicador'];
    $consulta->fuente = $_POST['fuente'];
    $consulta->desagregacionesTematicas = $_POST['desagregaciones'];
    $consulta->fechas = $_POST['fechas'];
    $consulta->desagregacionesGeograficas = $_POST['zonas'];
    $consulta->consultaIndicador();
}







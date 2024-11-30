<?php

require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/serieDatos.php';
require_once '../../../../model/serieDatos.php';
require_once '../../../../controller/indicador.php';
require_once '../../../../model/indicador.php';
require_once '../../../../controller/tematica.php';
require_once '../../../../model/tematica.php';
require_once '../../../../controller/dimension.php';
require_once '../../../../model/dimension.php';

class FuncionesSeries {

    public $idIndicador, $tipoDato, $geografia, $zonaActual, $periodicidad, $entidadGeneradora, $fuenteDatos, $urlDatos, $desagregacionTematica, $notas, $unidadMedicion;
    public $idSerieDatosEd, $idIndicadorEd, $tipoDatoEd, $geografiaEd, $zonaActualEd, $periodicidadEd, $entidadGeneradoraEd, $fuenteDatosEd, $urlDatosEd, $desagregacionTematicaEd, $notasEd, $unidadMedicionEd;
    public $idSerieDatosEl;
    public $idIndicadorSer;
    public $idIndicadorTipo, $tipoZonaGeograficaSer;
    public $idIndicadorTipo2, $tipoZonaGeograficaSer2, $zonaGeograficaSer2;
    public $idIndicadorTipo3, $tipoZonaGeograficaSer3, $zonaGeograficaSer3, $desagregacionTematicaSer3;

    public function crearSerie() {
        $resp = new SerieDatosController();
        $ret = $resp->crearSerieDatos($this->tipoDato, $this->geografia, $this->zonaActual, $this->periodicidad, $this->entidadGeneradora, $this->fuenteDatos, $this->urlDatos, $this->desagregacionTematica, $this->notas, $this->unidadMedicion, $this->idIndicador);
        echo $ret;
    }

    public function editarSerie() {
        $resp = new SerieDatosController();
        $ret = $resp->editarSerieDatos($this->idSerieDatosEd, $this->tipoDatoEd, $this->geografiaEd, $this->zonaActualEd, $this->periodicidadEd, $this->entidadGeneradoraEd, $this->fuenteDatosEd, $this->urlDatosEd, $this->desagregacionTematicaEd, $this->notasEd, $this->unidadMedicionEd, $this->idIndicadorEd);
        echo $ret;
    }

    public function eliminarSerie() {
        $resp = new SerieDatosController();
        $ret = $resp->eliminarSerieDatos($this->idSerieDatosEl);
        echo $ret;
    }

    public function consultarTiposZonasGeograficas() {
        $resp = new SerieDatosController();
        $ret = $resp->consultarTiposZonasGeograficasPorIndicador($this->idIndicadorSer);
        echo $ret;
    }

    public function consultarZonasGeograficas() {
        $resp = new SerieDatosController();
        $ret = $resp->consultarZonasGeograficasPorTipo($this->idIndicadorTipo, $this->tipoZonaGeograficaSer);
        echo $ret;
    }

    public function consultarDesagregacionesTematicas() {
        $resp = new SerieDatosController();
        $ret = $resp->consultarDesagregacionesTematicasPorIndicadorTipoZona($this->idIndicadorTipo2, $this->tipoZonaGeograficaSer2, $this->zonaGeograficaSer2);
        echo $ret;
    }

    public function consultarFuentes() {
        $resp = new SerieDatosController();
        $ret = $resp->consultarFuentesPorIndicadorTipoZonaDesagregacion($this->idIndicadorTipo3, $this->tipoZonaGeograficaSer3, $this->zonaGeograficaSer3, $this->desagregacionTematicaSer3);
        echo $ret;
    }

}

if (
        isset($_POST['indicadorSerie']) && isset($_POST['tipoDatosSerie']) &&
        isset($_POST['geografiaSerie']) && isset($_POST['zonaActualSerie']) &&
        isset($_POST['periodicidadSerie']) && isset($_POST['entidadGeneradoraSerie']) &&
        isset($_POST['fuenteDatosSerie']) && isset($_POST['urlDatosSerie']) &&
        isset($_POST['desagregacionTematicaSerie']) && isset($_POST['notasSerie']) &&
        isset($_POST['unidadMedicionSerie'])
) {
    $serie = new FuncionesSeries();
    $serie->idIndicador = $_POST['indicadorSerie'];
    $serie->tipoDato = $_POST['tipoDatosSerie'];
    $serie->geografia = $_POST['geografiaSerie'];
    $serie->zonaActual = $_POST['zonaActualSerie'];
    $serie->periodicidad = $_POST['periodicidadSerie'];
    $serie->entidadGeneradora = $_POST['entidadGeneradoraSerie'];
    $serie->fuenteDatos = $_POST['fuenteDatosSerie'];
    $serie->urlDatos = $_POST['urlDatosSerie'];
    $serie->desagregacionTematica = $_POST['desagregacionTematicaSerie'];
    $serie->notas = $_POST['notasSerie'];
    $serie->unidadMedicion = $_POST['unidadMedicionSerie'];
    $serie->crearSerie();
}

if (
        isset($_POST['idSerieEd']) && isset($_POST['indicadorSerieEd']) &&
        isset($_POST['tipoDatosSerieEd']) && isset($_POST['geografiaSerieEd']) &&
        isset($_POST['zonaActualSerieEd']) && isset($_POST['periodicidadSerieEd']) &&
        isset($_POST['entidadGeneradoraSerieEd']) && isset($_POST['fuenteDatosSerieEd']) &&
        isset($_POST['urlDatosSerieEd']) && isset($_POST['desagregacionTematicaSerieEd']) &&
        isset($_POST['notasSerieEd']) && isset($_POST['unidadMedicionSerieEd'])
) {
    $serie = new FuncionesSeries();
    $serie->idSerieDatosEd = $_POST['idSerieEd'];
    $serie->idIndicadorEd = $_POST['indicadorSerieEd'];
    $serie->tipoDatoEd = $_POST['tipoDatosSerieEd'];
    $serie->geografiaEd = $_POST['geografiaSerieEd'];
    $serie->zonaActualEd = $_POST['zonaActualSerieEd'];
    $serie->periodicidadEd = $_POST['periodicidadSerieEd'];
    $serie->entidadGeneradoraEd = $_POST['entidadGeneradoraSerieEd'];
    $serie->fuenteDatosEd = $_POST['fuenteDatosSerieEd'];
    $serie->urlDatosEd = $_POST['urlDatosSerieEd'];
    $serie->desagregacionTematicaEd = $_POST['desagregacionTematicaSerieEd'];
    $serie->notasEd = $_POST['notasSerieEd'];
    $serie->unidadMedicionEd = $_POST['unidadMedicionSerieEd'];
    $serie->editarSerie();
}


if (isset($_POST['idSerieDatosEl'])) {
    $serie = new FuncionesSeries();
    $serie->idSerieDatosEl = $_POST['idSerieDatosEl'];
    $serie->eliminarSerie();
}

if (isset($_POST['idIndicadorSer'])) {
    $serie = new FuncionesSeries();
    $serie->idIndicadorSer = $_POST['idIndicadorSer'];
    $serie->consultarTiposZonasGeograficas();
}

if (isset($_POST['idIndicadorTipo']) && isset($_POST['tipoZonaGeograficaSer'])) {
    $serie = new FuncionesSeries();
    $serie->idIndicadorTipo = $_POST['idIndicadorTipo'];
    $serie->tipoZonaGeograficaSer = $_POST['tipoZonaGeograficaSer'];
    $serie->consultarZonasGeograficas();
}

if (isset($_POST['idIndicadorTipo2']) && isset($_POST['tipoZonaGeograficaSer2']) && isset($_POST['zonaGeograficaSer2'])) {
    $serie = new FuncionesSeries();
    $serie->idIndicadorTipo2 = $_POST['idIndicadorTipo2'];
    $serie->tipoZonaGeograficaSer2 = $_POST['tipoZonaGeograficaSer2'];
    $serie->zonaGeograficaSer2 = $_POST['zonaGeograficaSer2'];
    $serie->consultarDesagregacionesTematicas();
}

if (isset($_POST['idIndicadorTipo3']) && isset($_POST['tipoZonaGeograficaSer3']) && isset($_POST['zonaGeograficaSer3']) && isset($_POST['desagregacionTematicaSer3'])) {
    $serie = new FuncionesSeries();
    $serie->idIndicadorTipo3 = $_POST['idIndicadorTipo3'];
    $serie->tipoZonaGeograficaSer3 = $_POST['tipoZonaGeograficaSer3'];
    $serie->zonaGeograficaSer3 = $_POST['zonaGeograficaSer3'];
    $serie->desagregacionTematicaSer3 = $_POST['desagregacionTematicaSer3'];
    $serie->consultarFuentes();
}



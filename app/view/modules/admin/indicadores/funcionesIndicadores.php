<?php

require_once '../../../../controller/indicador.php';
require_once '../../../../model/indicador.php';
require_once '../../../../controller/tematica.php';
require_once '../../../../model/tematica.php';
require_once '../../../../controller/dimension.php';
require_once '../../../../model/dimension.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';

class FuncionesIndicadores {

    public $nombreIndicador, $descripcionIndicador, $idTematica, $posicion, $mapa;
    public $idIndicadorEd, $nombreIndicadorEd, $descripcionIndicadorEd, $idTematicaEd, $posicionEd, $mapaEd;
    public $idIndicadorEl;
    public $tematicaSer;
    public $idIndicadorAc;

    public function crearIndicador() {
        $data1 = $this->nombreIndicador;
        $data2 = $this->descripcionIndicador;
        $data3 = $this->idTematica;
        $data4 = $this->posicion;
        $data5 = $this->mapa;
        $resp = new IndicadorController();
        $ret = $resp->crearIndicador($data1, $data2, $data3, $data4, $data5);
        echo $ret;
    }

    public function editarIndicador() {
        $data1 = $this->idIndicadorEd;
        $data2 = $this->nombreIndicadorEd;
        $data3 = $this->descripcionIndicadorEd;
        $data4 = $this->idTematicaEd;
        $data5 = $this->posicionEd;
        $data6 = $this->mapaEd;
        $resp = new IndicadorController();
        $ret = $resp->editarIndicador($data1, $data2, $data3, $data4, $data5, $data6);
        echo $ret;
    }

    public function eliminarIndicador() {
        $data1 = $this->idIndicadorEl;
        $resp = new IndicadorController();
        $ret = $resp->eliminarIndicador($data1);
        echo $ret;
    }

    public function listarIndicadoresTematica() {
        $data1 = $this->tematicaSer;
        $resp = new IndicadorController();
        $ret = $resp->listarIndicadoresTematica($data1);
        echo $ret;
    }

    public function activarIndicador() {
        $data1 = $this->idIndicadorAc;
        $resp = new IndicadorController();
        $ret = $resp->activarIndicador($data1);
        echo $ret;
    }

}

if (isset($_POST['nombreIndicador']) && isset($_POST['descripcionIndicador']) && isset($_POST['tematicaIndicador']) && isset($_POST['posicion']) && isset($_POST['mapa'])) {
    $indicador = new FuncionesIndicadores();
    $indicador->nombreIndicador = $_POST['nombreIndicador'];
    $indicador->descripcionIndicador = $_POST['descripcionIndicador'];
    $indicador->idTematica = $_POST['tematicaIndicador'];
    $indicador->posicion = $_POST['posicion'];
    $indicador->mapa = $_POST['mapa'];
    $indicador->crearIndicador();
}

if (isset($_POST['idIndicadorEd']) && isset($_POST['nombreIndicadorEd']) && isset($_POST['descripcionIndicadorEd']) && isset($_POST['idTematicaEd']) && isset($_POST['posicionEd']) && isset($_POST['mapaEd'])) {
    $indicador = new FuncionesIndicadores();
    $indicador->idIndicadorEd = $_POST['idIndicadorEd'];
    $indicador->nombreIndicadorEd = $_POST['nombreIndicadorEd'];
    $indicador->descripcionIndicadorEd = $_POST['descripcionIndicadorEd'];
    $indicador->idTematicaEd = $_POST['idTematicaEd'];
    $indicador->posicionEd = $_POST['posicionEd'];
    $indicador->mapaEd = $_POST['mapaEd'];
    $indicador->editarIndicador();
}

if (isset($_POST['idIndicadorEl'])) {
    $indicador = new FuncionesIndicadores();
    $indicador->idIndicadorEl = $_POST['idIndicadorEl'];
    $indicador->eliminarIndicador();
}

if (isset($_POST['tematicaSer'])) {
    $indicador = new FuncionesIndicadores();
    $indicador->tematicaSer = $_POST['tematicaSer'];
    $indicador->listarIndicadoresTematica();
}

if (isset($_POST['idIndicadorAc'])) {
    $indicador = new FuncionesIndicadores();
    $indicador->idIndicadorAc = $_POST['idIndicadorAc'];
    $indicador->activarIndicador();
}




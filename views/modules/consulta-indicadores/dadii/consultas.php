<?php

require_once '../../../../controllers/dimensiones.php';
require_once '../../../../models/dimensiones.php';

require_once '../../../../controllers/tematicas.php';
require_once '../../../../models/tematicas.php';

require_once '../../../../controllers/indicadores.php';
require_once '../../../../models/indicadores.php';

require_once '../../../../controllers/seriesDatos.php';
require_once '../../../../models/seriesDatos.php';

require_once '../../../../controllers/datos.php';
require_once '../../../../models/datos.php';

require_once '../../../../models/fichaTecnica.php';

require_once '../../../../controllers/consultas.php';
require_once '../../../../models/consultas.php';

class ConsultasDadii {

    public $idDimensionC, $idTematicaC;
    public $consultaProceso;
    public $idConjunto;
    public $conjuntoIndicador;
    public $indicadorSelect;
    
    public function consultaDadii() {
        $resp = new ConsultasController();
        $resp->consultaDadiiControllerConIndicador($this->idDimensionC, $this->idTematicaC);
    }
    
    public function consultaProcesoDadii() {
        $resp = new ConsultasController();
        $resp->consultarMacroprocesoPorProceso($this->consultaProceso);
    }
    
    public function consultarIndicadoresGenerales() {
        $resp = new ConsultasController();
        $resp->consultaDadiiGeneralIndicadores($this->idConjunto);
    }
    
    public function listarIndicadores() {
        $resp = new IndicadoresController();
        $resp->listarIndicadoresDadii($this->conjuntoIndicador);
    }
    
    public function indicadorSeleccionado() {
        $resp = new ConsultasController();
        $resp->crearRutaBuscadorDadii($this->indicadorSelect);
    }
   
}
if (isset($_POST['idDimensionC']) && isset($_POST['idTematicaC'])) {
    $consulta = new ConsultasDadii();
    $consulta->idDimensionC = $_POST['idDimensionC'];
    $consulta->idTematicaC = $_POST['idTematicaC'];
    $consulta->consultaDadii();
}
if (isset($_POST['consultaProceso'])) {
    $consulta = new ConsultasDadii();
    $consulta->consultaProceso = $_POST['consultaProceso'];
    $consulta->consultaProcesoDadii();
}
if (isset($_POST['idConjunto'])) {
    $consulta = new ConsultasDadii();
    $consulta->idConjunto = $_POST['idConjunto'];
    $consulta->consultarIndicadoresGenerales();
}
if (isset($_POST['conjuntoIndicador'])) {
    $consulta = new ConsultasDadii();
    $consulta->conjuntoIndicador = $_POST['conjuntoIndicador'];
    $consulta->listarIndicadores();
}
if (isset($_POST['indicadorSelect'])) {
    $consulta = new ConsultasDadii();
    $consulta->indicadorSelect = $_POST['indicadorSelect'];
    $consulta->indicadorSeleccionado();
}


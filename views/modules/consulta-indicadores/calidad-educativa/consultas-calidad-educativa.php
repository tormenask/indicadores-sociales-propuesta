<?php

require_once '../../../../controllers/consultas.php';
require_once '../../../../models/consultas.php';

require_once '../../../../controllers/seriesDatos.php';
require_once '../../../../models/seriesDatos.php';

require_once '../../../../controllers/datos.php';
require_once '../../../../models/datos.php';

require_once '../../../../controllers/consultas_visualizadores.php';
require_once '../../../../models/consultas_visualizadores.php';

class ConsultasCalidadEducativa{

    public $nombreComuna, $selected;

    public function consultarEstablecimientosComuna() {
        $resp = new ConsultasVisualizadoresController();
        $resp->consultarEstablecimientosComunaController($this->nombreComuna);
    }
    
    public function consultarGraficosEstablecimientos() {
        $resp = new ConsultasVisualizadoresController();
        $resp->consultarGraficosEstablecimientosController($this->selected);
    }
}

if (isset($_POST['nombreComuna'])) {
    $consultas = new ConsultasCalidadEducativa();
    $consultas->nombreComuna = $_POST['nombreComuna'];
    $consultas->consultarEstablecimientosComuna();
}

if (isset($_POST['selected'])) {
    $consultas = new ConsultasCalidadEducativa();
    $consultas->selected = $_POST['selected'];
    $consultas->consultarGraficosEstablecimientos();
}
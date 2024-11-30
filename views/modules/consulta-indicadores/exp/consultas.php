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

class ConsultasExpediente {

    public $nombreDimension;
    public $idIndicador1;
    public $idIndicador2, $geografia2;
    public $idIndicador3, $geografia3, $zonaActual3;
    public $idIndicador4, $geografia4, $zonaActual4, $desagregacionesTem4;
    public $idDimensionC, $idTematicaC, $idIndicadorC, $tipoZonaGeograficaC, $zonaGeograficaC, $desagregacionesTematicasC, $fechasC;

    public function consultarIndicadoresExpPorNombreDimension() {
        $data = $this->nombreDimension;
        $resp = new ConsultasController();
        $resp->consultarIndicadoresExpPorNombreDimensionController($data);
    }

    public function consultarGeografiasExpPorIndicador() {
        $data1 = $this->idIndicador1;
        $resp = new SeriesDatosController();
        $resp->consultarGeografiasPorIndicadorExpedienteController($data1);
    }

    public function consultarZonaActualExpPorIndicador() {
        $data1 = $this->idIndicador2;
        $data2 = $this->geografia2;
        $resp = new SeriesDatosController();
        $resp->consultarZonaActualPorIndicadorExpedienteController($data1, $data2);
    }

    public function consultarDesagregacionesTematicasExpPorIndicador() {
        $data1 = $this->idIndicador3;
        $data2 = $this->geografia3;
        $data3 = $this->zonaActual3;
        $resp = new SeriesDatosController();
        $resp->consultarDesagregacionesTematicasPorIndicadorExpedienteController($data1, $data2, $data3);
    }

    public function consultarFechasExpPorIndicadorYFuenteDesagregaciones() {
        $data1 = $this->idIndicador4;
        $data2 = $this->geografia4;
        $data3 = $this->zonaActual4;
        $data4 = $this->desagregacionesTem4;
        $resp = new DatosController();
        $resp->consultarFechasPorDesagregacionesIndicadorYDesagregacionGeograficaExpedienteController($data1, $data2, $data3, $data4);
    }

    public function consultaExpediente() {
        $resp = new ConsultasController();
        $resp->consultaExpedienteController($this->idDimensionC, $this->idTematicaC, $this->idIndicadorC, $this->desagregacionesTematicasC, $this->fechasC, $this->tipoZonaGeograficaC, $this->zonaGeograficaC);
    }

}

if (isset($_POST['nombreDimension'])) {
    $consulta = new ConsultasExpediente();
    $consulta->nombreDimension = $_POST['nombreDimension'];
    $consulta->consultarIndicadoresExpPorNombreDimension();
}

if (isset($_POST['idIndicador1'])) {
    $consulta = new ConsultasExpediente();
    $consulta->idIndicador1 = $_POST['idIndicador1'];
    $consulta->consultarGeografiasExpPorIndicador();
}

if (isset($_POST['idIndicador2']) && isset($_POST['geografia2'])) {
    $consulta = new ConsultasExpediente();
    $consulta->idIndicador2 = $_POST['idIndicador2'];
    $consulta->geografia2 = $_POST['geografia2'];
    $consulta->consultarZonaActualExpPorIndicador();
}

if (isset($_POST['idIndicador3']) && isset($_POST['geografia3']) && isset($_POST['zona3'])) {
    $consulta = new ConsultasExpediente();
    $consulta->idIndicador3 = $_POST['idIndicador3'];
    $consulta->geografia3 = $_POST['geografia3'];
    $consulta->zonaActual3 = $_POST['zona3'];
    $consulta->consultarDesagregacionesTematicasExpPorIndicador();
}

if (isset($_POST['idIndicador4']) && isset($_POST['geografia4']) && isset($_POST['zona4']) && isset($_POST['desagregaciones4'])) {
    $consulta = new ConsultasExpediente();
    $consulta->idIndicador4 = $_POST['idIndicador4'];
    $consulta->geografia4 = $_POST['geografia4'];
    $consulta->zonaActual4 = $_POST['zona4'];
    $consulta->desagregacionesTem4 = $_POST['desagregaciones4'];
    $consulta->consultarFechasExpPorIndicadorYFuenteDesagregaciones();
}


if (isset($_POST['idDimensionC']) && isset($_POST['idTematicaC']) &&
        isset($_POST['idIndicadorC']) && isset($_POST['tipoZonaGeograficaC']) &&
        isset($_POST['desagregacionesTematicasC']) && isset($_POST['fechasC']) && isset($_POST['zonaGeograficaC'])) {
    $consulta = new ConsultasExpediente();
    $consulta->idDimensionC = $_POST['idDimensionC'];
    $consulta->idTematicaC = $_POST['idTematicaC'];
    $consulta->idIndicadorC = $_POST['idIndicadorC'];
    $consulta->tipoZonaGeograficaC = $_POST['tipoZonaGeograficaC'];
    $consulta->desagregacionesTematicasC = $_POST['desagregacionesTematicasC'];
    $consulta->fechasC = $_POST['fechasC'];
    $consulta->zonaGeograficaC = $_POST['zonaGeograficaC'];
    $consulta->consultaExpediente();
}

<?php

require_once '../../../../controllers/perfiles.php';
require_once '../../../../models/perfilesComunas.php';

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

class ConsultasPerfilesComunas{

    public $nombreComuna;
    public $nombreComuna2;

    public function consultarIndicadoresPerfilComuna() {
        $data = $this->nombreComuna;
        $resp = new PerfilesController();
        $resp->consultarIndicadoresPerfilesController($data);
    }

    public function consultarGraficosComuna() {
        $data = $this->nombreComuna2;
        $resp = new PerfilesController();
        $resp->consultarGraficosComunaController($data);
    }

}

if (isset($_POST['nombreComuna'])) {
    $indicadores = new ConsultasPerfilesComunas();
    $indicadores->nombreComuna = $_POST['nombreComuna'];
    $indicadores->consultarIndicadoresPerfilComuna();
}

if (isset($_POST['nombreComuna2'])) {
    $graficos = new ConsultasPerfilesComunas();
    $graficos->nombreComuna2 = $_POST['nombreComuna2'];
    $graficos->consultarGraficosComuna();
}
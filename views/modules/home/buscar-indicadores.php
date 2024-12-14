<?php

require_once '../../../controllers/consultas.php';
require_once '../../../models/consultas.php';
require_once '../../../controllers/indicadores.php';
require_once '../../../models/indicadores.php';
require_once '../../../controllers/seriesDatos.php';
require_once '../../../models/seriesDatos.php';
require_once '../../../controllers/tematicas.php';
require_once '../../../models/tematicas.php';
require_once '../../../controllers/dimensiones.php';
require_once '../../../models/dimensiones.php';
require_once '../../../models/conjuntosIndicadores.php';
require_once '../../../controllers/datos.php';
require_once '../../../models/datos.php';

class ConsultarIndicadores {

    public $param;

    public function buscarIndicador() {
        $data = $this->param;
        $cons = new ConsultasController();
        $resp = $cons->buscarIndicadoresActivosPorNombreController($data);
        if ($resp == "empty") {
            echo "   <div class='alert alert-info alert-dismissable'>\n
                        No existen indicadores con el parámetro ingresado.<br>\n
                        Para volver a la página principal, haga clic <a href='/siscali' id='btn-accept' class='alert-link'><strong>aquí.</strong></a>\n
                    </div>";
        } else {
            $this->crearTabla($resp, $data);
        }
    }

    public function crearTabla($resp, $param) {

        echo '	
            <script>
                $(document).ready(function() {
                    $("#tablaConsulta").DataTable({
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                        },
                        "aoColumnDefs": [{ 
                            "bSortable": false, "aTargets": [ 4 ] , 
                            "bSearchable": false, "aTargets": [ 4 ]
                        }]
                    });
                });
            </script>
            <div class="row" style="padding-top:10px;">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-body" style="padding: 10px;">
                            <h6><b>Resultado de la consulta</b></h6>
                            <p style="font-family:Source Sans Pro, sans-serif; font-size:15px;">
                                Parámetro de búsqueda: ' . $param . ' 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
           <style>
                td#prewrap {white-space: pre-wrap;}
                li {white-space: pre-wrap;}
            </style>
            <div class="row" style="padding-top: 10px;">
                <div class="col-sm-12">
                        <table id="tablaConsulta" class="table table-striped table-bordered dt-responsive nowrap display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Conjunto de indicadores</th>
                                    <th>Dimensión</th>
                                    <th>Temática</th>
                                    <th>Indicador</th>
                                    <th style="padding:0px 5px;">Consultar</th>
                                </tr>
                            </thead>
                            <tbody>';
        foreach ($resp as $row => $item) {
            $nombreIndicador = $item[3];
            $nombreIndArr = explode(" ", $param);
            for ($i = 0; $i < count($nombreIndArr); $i++) {
                $actual = $nombreIndArr[$i];
                if (strpos($nombreIndicador, $actual) !== FALSE) {
                    $nombreIndicador = str_replace($actual, '<b>' . $actual . '</b>', $nombreIndicador);
                } elseif (strpos($nombreIndicador, ucfirst($actual)) !== FALSE) {
                    $nombreIndicador = str_replace(ucfirst($actual), '<b>' . ucfirst($actual) . '</b>', $nombreIndicador);
                }
            }


            echo '
                                <tr>
                                    <td id="prewrap">' . $item[0] . '</td>
                                    <td id="prewrap">' . $item[1] . '</td>
                                    <td id="prewrap">' . $item[2] . '</td>
                                    <td id="prewrap">' . $nombreIndicador . '</td>
                                    <td class="consultarIndicadorBuscador" style="text-align:center;">
                                        <a class="consultarIndicadorBuscador" href="' . $item[4] . '">
                                            <i class="fa fa-search fa-lg"></i>
                                        </a>
                                    </td>
                                </tr>';
        }
        echo'
                            </tbody>
                        </table>
                    
                </div>
            </div>';
    }

}

if (isset($_POST['param'])) {
    $buscados = new ConsultarIndicadores();
    $buscados->param = $_POST['param'];
    $buscados->buscarIndicador();
}

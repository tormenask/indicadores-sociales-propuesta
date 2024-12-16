<?php
require_once './controllers/dimensiones.php';
require_once './models/dimensiones.php';

require_once './controllers/tematicas.php';
require_once './models/tematicas.php';

require_once './controllers/indicadores.php';
require_once './models/indicadores.php';
?>

<div class="col-12">
    <div id="page-content-wrapper">
        <div id="text-index">
            <h1>Sobre los Objetivos de Desarrollo Sostenible para Santiago de Cali</h1>
            <hr>
            <?php
            $dim = new DimensionesController();
            $tem = new TematicasController();
            $ind = new IndicadoresController();
            $cons = new ConsultasController();
            $objetivos = $dim->consultarDimensionesPorIdConjuntoIndicadores('ODS');
            if (!empty($objetivos)) {
                foreach ($objetivos as $objetivo => $row) {
                    $idObjetivo = $row["idDimension"];
                    $nombreObjetivo = $row["nombreDimension"];
                    $iconoObjetivo = $row["icono"];
                    $metas = $tem->consultarTematicasPorIdDimension($idObjetivo);

                    if ($idObjetivo != "ODS_14" && $idObjetivo != "ODS_15") {
                        echo '
                            <div class="row border-consulta" style="padding-bottom:0px !important;">
                                <div class = "col-xs-12 col-sm-3">
                                    <img alt="' . $nombreObjetivo . '" style="width: 100%;margin: 15px 0px;" 
                                        src="/siscali/' . $iconoObjetivo . '">
                                </div>
                                <div class="col-xs-12 col-sm-9">
                                    <h4 style="font-weight:bold;">' . $nombreObjetivo . '</h4>
                                    <table id="tablaObjetivos" class="table table-striped" style="text-align:center">
                                        <thead>
                                            <tr>
                                                <td style="background-color:#3a70ba; color:#fff; text-align:center;">Metas</td>
                                                <td style="background-color:#3a70ba; color:#fff; text-align:center;">Indicadores</td>
                                            </tr>
                                        </thead>
                                        <tbody style="width:100%;">';
                        foreach ($metas as $meta => $row_meta) {
                            $idMeta = $row_meta['idTematica'];
                            $nombreMeta = $row_meta['nombreTematica'];
                            $descripcionMeta = $row_meta['descripcionTematica'];
                            $indicadores = $ind->consultarIndicadoresActivosPorIdTematicaController($idMeta);
                            $numIndicadores = count($indicadores);
                            echo '      <tr>';
                            if ($numIndicadores < 2) {
                                echo '      <td style="text-align:left;">
                                                    <h5 style="font-weight:bold;">' . $nombreMeta . ':</h5>
                                                    ' . $descripcionMeta . '
                                                </td>';
                                foreach ($indicadores as $indicador => $row_indicador) {
                                    $idIndicador = $row_indicador['idIndicador'];
                                    $nombreIndicador = $row_indicador['nombreIndicador'];
                                    $informacionEnlace = $ind->consultarInformacionEnlacePorIdIndicadorCategoriaController($idIndicador, "Municipal");
                                    $enlace = $cons->crearEnlace($informacionEnlace, 'ODS');
                                    echo '  <td style="text-align:left;">
                                                    <a href="' . $enlace . '" target="_blank">' . $nombreIndicador . '</a>
                                                </td>';
                                }
                                echo '  </tr>';
                            } else {
                                echo '      <td rowspan="' . $numIndicadores . '" style="text-align:left;">
                                                    <h5 style="font-weight:bold;">' . $nombreMeta . ':</h5>
                                                    ' . $descripcionMeta . '
                                                </td>';

                                for ($indi = 0; $indi < count($indicadores); $indi++) {
                                    $idIndicador = $indicadores[$indi]['idIndicador'];
                                    $nombreIndicador = $indicadores[$indi]['nombreIndicador'];
                                    $informacionEnlace = $ind->consultarInformacionEnlacePorIdIndicadorCategoriaController($idIndicador, "Municipal");
                                    $enlace = $cons->crearEnlace($informacionEnlace, 'ODS');
                                    if ($indi == 0) {
                                        echo '  <td style="text-align:left;">
                                                        <a href="' . $enlace . '" target="_blank">' . $nombreIndicador . '</a>
                                                    </td>
                                                </tr>';
                                    } else {
                                        echo '  <td style="text-align:left;">
                                                        <a href="' . $enlace . '" target="_blank">' . $nombreIndicador . '</a>
                                                    </td>';
                                    }
                                }
                            }
                        }

                        echo '      </tbody>
                                    </table>
                                </div>
                            </div>';
                    }
                }
            }
            ?>
        </div>
    </div>
</div>

<script>
    $("#consulta-indicadores").addClass("active");
    $("#consulta-ods").addClass("active");
    $("#ods-objetivos").addClass("back-item-menu");
</script>
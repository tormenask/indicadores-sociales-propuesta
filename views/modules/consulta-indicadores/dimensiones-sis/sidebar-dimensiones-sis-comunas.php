<!-- Sidebar -->
<?php
require_once 'controllers/dimensiones.php';
require_once 'models/dimensiones.php';

require_once 'controllers/tematicas.php';
require_once 'models/tematicas.php';

require_once 'controllers/indicadores.php';
require_once 'models/indicadores.php';

require_once 'controllers/seriesDatos.php';
require_once 'models/seriesDatos.php';

require_once 'controllers/datos.php';
require_once 'models/datos.php';

require_once 'controllers/consultas.php';
require_once 'models/consultas.php';

$resp = new ConsultasController();
?>

<link href="/views/resources/css/perfiles-comunas.css" rel="stylesheet" media="all">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/jquery.jqplot.min.css" />
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://d3js.org/d3.v3.min.js"></script>
<script src="/views/resources/lib/jquery-number/jquery.number.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/jquery.jqplot.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.pyramidGridRenderer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.pyramidAxisRenderer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.pyramidRenderer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.canvasTextRenderer.min.js"></script>

<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading" style="background-color: #fff;text-align: center; margin: 5rem;">
        <img src="/views/resources/images/home/indicadores_comunas.png"
            alt="Imagen de presentación de los Indicadores por comunas" style="height: 90px;" />
        <h6 style="font-weight: 700;font-size: 2.0rem;">Indicadores para la medición del desarrollo social, por comunas
        </h6>
    </div>
    <div class="row" style="margin: 5rem;">
        <div class="col-12">
            <div id="page-content-wrapper">
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <div id="text-index">
                            <h1>Consulta de perfiles por comunas</h1>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-bottom: 20px;">
                    <div id="mapa_container" class="col-xs-12 col-sm-5">
                        <div class="panel mapa_panel">
                            <p style="text-align: center; margin: 10px;">
                                Haga clic en la comuna que desea consultar.
                            </p>
                        </div>
                        <div id="mapa" style="margin-top: -25px;"></div>
                        <script src="/views/resources/js/perfiles-comunas-script.js"></script>
                        <br>
                    </div>
                    <div class="col-sm-7 col-xs-12"
                        style="background-color: #eee; padding: 0px; border: 1px solid #ccc;">
                        <div id="panel_informacion_comunas" class="panel" style="margin: 20px; border: 1px #ccc solid;">
                            <p style="margin: 20px;">
                                Las comunas, son unidades administrativas en las cuales se ha subdividido el área urbana
                                de la ciudad y que agrupan diversos barrios. Los corregimientos, de forma similar,
                                corresponden a divisiones del área rural. Estas unidades de desagregación geográfica
                                permiten estudiar de manera más profunda y específica los datos de acuerdo a un contexto
                                de cercanía y realizar análisis comparativos en la ciudad que permiten identificar la
                                heterogeneidad u homogeneidad en los diversos escenarios de interés.
                            </p>
                            <p style="margin: 20px;">
                                Los perfiles por comunas para Santiago de Cali presentan información para cada una de
                                las 22 comunas. Se encuentra organizado por diferentes temáticas con datos de población,
                                salud, educación, cultura, paz y seguridad ciudadana, y los resultados de la Encuesta de
                                Empleo y Calidad de Vida de 2013. Igualmente, incorpora las proyecciones de población
                                mediante la pirámide poblacional, con datos desde el 2010 al 2035. Este perfil incluye
                                las series de tiempo de indicadores clave para el municipio, realizando una comparación
                                histórica entre Cali y la comuna.
                            </p>
                        </div>
                        <div id="informacion_comuna" hidden="true">
                            <h3 id="nombre_comuna"
                                style="font-weight: bold; margin: 30px 20px 15px 20px; line-height: 0.2 !important;">
                                <span></span>
                            </h3>
                            <div id="indicadoresPerfilComunas" class="col-sm-12">
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
                <!-- <div id="piramideComunas" hidden="true" style="padding: 0px; border: solid 1px #ccc; border-radius: 5px; padding: 5px; margin-bottom: 15px;">
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <div id="graf" style="background-color:#fff; padding: 0px 15px 10px;">
                            <h3 id="nombreIndicador" style="text-align:center"></h3>
                            <div class="row">
                                <div class="col-sm-3" style="text-align: center; margin-left: -30px;">
                                    <table class="table table-striped table-bordered table-hover table-responsive" 
                                           style="font-size: 12px; margin-bottom: 10px;">
                                        <tr>
                                            <td style="background-color:#0e6e37; color:#fff; text-align:center; width: 50%">Año</td>
                                            <td style="background-color:#0e6e37; color:#fff; text-align:center">
                                                <p style="margin: 0px;" id="year">2018</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#0e6e37; color:#fff; text-align:center">Población total</td>
                                            <td style="text-align:center">
                                                <p style="margin: 0px;" id="totalPopulation"></p>
                                                <script> $("#totalPopulation").number(2420114);</script>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#0e6e37; color:#fff; text-align:center">Total mujeres</td>
                                            <td style="text-align:center">
                                                <p style="margin: 0px;" id="totalFemalePopulation"></p>
                                                <script>$("#totalFemalePopulation").number(1263275);</script>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#0e6e37; color:#fff; text-align:center">Total hombres</td>
                                            <td style="text-align:center">
                                                <p style="margin: 0px;" id="totalMalePopulation"></p>
                                                <script>$("#totalMalePopulation").number(1156839);</script>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#0e6e37; color:#fff; text-align:center">Proporción H/M</td>
                                            <td style="text-align:center;">
                                                <p style="margin: 0px;" id="ratioTotal"></p>
                                                <script>$("#ratioTotal").number(0.9157, 4);</script>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#0e6e37; color:#fff; text-align:center; width: 50%;">Proyecciones de población</td>
                                            <td style="text-align: center;">Proyecciones DAP</td>
                                        </tr>
                                    </table>
                                    <table class="table table-striped table-bordered table-hover table-responsive" style="font-size: 13px; margin-bottom: 10px;">
                                        <tr>
                                            <td colspan="2">
                                                <div id="amount" style="color:#0e6e37; font-weight:bold; text-align: center">2018</div>
                                                <div style="margin: 5px 10px 5px 10px; padding: 8px 0px; border: solid 2px #0e6e37;" id="slider-range-max"></div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-sm-6" style="padding-left: 30px; margin-right:30px;">
                                    <div class="chart-pyramid">
                                        <div id="chartPerfilesComunas"></div>
                                    </div>
                                </div>
                                <div class="col-md-3" style="margin-left: 0px;">
                                    <table class="table table-striped table-bordered table-hover table-responsive" 
                                           style="font-size: 12px; margin-bottom: 10px;">
                                        <tr>
                                            <td style="background-color:#0e6e37; color:#fff; text-align:center; width: 50%;">Rango de edad</td>
                                            <td style="text-align: center; width: 50%">
                                                <div class="tooltip-item" id="tooltipAge">&nbsp;</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#0e6e37; color:#fff; text-align:center; width: 50%;">Porcentaje de hombres</td>
                                            <td style="text-align: center;">
                                                <div class="tooltip-item" id="tooltipMale">&nbsp;</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#0e6e37; color:#fff; text-align:center; width: 50%;">Porcentaje de mujeres</td>
                                            <td style="text-align: center;">
                                                <div class="tooltip-item" id="tooltipFemale">&nbsp;</div>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="panel" style="background-color: #d6d6d6; margin-bottom: 10px; border: 1px #0e6e37 solid;">
                                        <p style="font-size: 12px; text-align: justify; margin: 10px;">
                                            Para consultar la información de un rango de edad, pase con el mouse sobre el rango de interés.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12" style="margin-left: -30px;">
                        <script>
                            var url = "/views/resources/js/descargarGrafico.js";
                            $.getScript(url);
                        </script>                            
                        <div class="btn-group" role="group" style="width:100%;">
                            <button type="button" id="imagenPng" class="btn bt bt-ripple btn-consultar" style="background-color:#52b1fe; color:#fff; margin-left: 30px;">
                                <i class="fa fa-file-image-o" aria-hidden="true" style="margin-right:10px;"></i>
                                <b>Descargar gráfico</b>
                            </button>
                            <img src="/views/resources/images/loading3.gif" id="loadingPng" style="display: none; margin-left: 10px;"/>
                        </div>
                    </div>
                </div>
            </div> -->
            </div>
        </div>
    </div>
</div>
<?php
$resp->consultarListadoIndicadoresPorConjunto('SIS', 'Comunas');
?>
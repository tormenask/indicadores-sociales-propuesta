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
<div class="bg-light border-right" id="sidebar-wrapper" style="margin: 5rem;">
    <div class="sidebar-heading" style="background-color: #fff;text-align: center;">
        <img src="/views/resources/images/home/ODS-circulo.png"
            alt="Imagen de presentación de los Objetivos de Desarrollo Sostenible para Santiago de Cali"
            style="height: 90px;" />
        <h6 style="font-weight: 700;font-size: 2.0rem;">Objetivos de Desarrollo Sostenible para Santiago de Cali</h6>
    </div>
    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #215a9a;">
                <h4 class="panel-title" style="font-size: 14px; color: #fff;">
                    Acerca de los Objetivos de Desarrollo Sostenible
                </h4>
            </div>
            <div id="informacion-conjunto" class="panel-collapse collapse in">
                <ul class="list-group" style="font-size: 13px;">
                    <li class="list-group-item" id="ods-presentacion"><a style="color: #000;"
                            href="/consulta-indicadores/ods/presentacion">¿Qué son los Objetivos de Desarrollo
                            Sostenible?</a></li>
                    <li class="list-group-item" id="ods-seguimiento"><a style="color: #000;"
                            href="/consulta-indicadores/ods/seguimiento">Seguimiento y reporte de los ODS para Santiago
                            de Cali</a></li>
                    <li class="list-group-item" id="ods-indicadores"><a style="color: #000;"
                            href="/consulta-indicadores/ods/indicadores">Sobre los indicadores ODS para Santiago de
                            Cali</a></li>
                    <li class="list-group-item" id="ods-metodologia"><a style="color: #000;"
                            href="/consulta-indicadores/ods/metodologia">Metodología para el seguimiento a indicadores
                            de los ODS para Santiago de Cali</a></li>
                    <li class="list-group-item" id="ods-objetivos"><a style="color: #000;"
                            href="/consulta-indicadores/ods/objetivos">Indicadores por objetivo</a></li>
                    <li class="list-group-item" id="ods-ejecucion-presupuestal"><a style="color: #000;"
                            href="/consulta-indicadores/ods/ejecucion-presupuestal">Ejecución presupuestal</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
    <?php
    $resp->consultarListadoIndicadoresPorConjunto('ODS', '');
    ?>
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
<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading" style="background-color: #fff;text-align: center;">
        <img src="views/resources/images/home/indicadores_odraf.png" alt="Imagen de presentación de los Indicadores Observatorio del Deporte, la Recreación y la Actividad Física" style="height: 90px;"/>
    </div>
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #2fb56a;">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#informacion-conjunto" 
                       style="font-size: 14px; color: #fff;">
                        Acerca de los indicadores
                    </a>
                </h4>
            </div>
            <div id="informacion-conjunto" class="panel-collapse collapse in">
                <ul class="list-group" style="font-size: 13px;">
                    <li class="list-group-item"><a style="color: #000;" href="consulta-indicadores/odraf/presentacion">Presentación</a></li>
                </ul>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #2fb56a;">
                <h4 class="panel-title" style="font-size: 14px; color: #fff;">
                    Consulta de indicadores
                </h4>
            </div>
        </div>

        <?php
        $resp->consultarListadoIndicadoresPorConjunto('ODRAF', '');
        ?>
    </div>
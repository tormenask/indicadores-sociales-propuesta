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
<div class="bg-light border-right" id="sidebar-wrapper" style="margin:5rem;">
    <div class="sidebar-heading" style="background-color: #fff;text-align: center;">
        <img src="views/resources/images/home/indicadores_expediente_municipal.png"
            alt="Imagen de presentación de los Indicadores del Expediente Municipal" style="height: 90px;" />
        <h6 style="font-weight: 700;font-size: 2.0rem;">Indicadores del Expediente Municipal</h6>
    </div>
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne"
                style="background-color:white; background-color:white; display:flex; justify-content:space-between; align-items:center; margin: 5px;">
                <h4 class="panel-title" style="font-size:20px;">
                    Presentación
                </h4>
                <button
                    style="padding:8px; background-color:#215a9a; border: 1px white solid; border-radius: 5px; hover:pointer; color:white">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                        href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="color:white;">
                        Ver más
                    </a>
                </button>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <?php include_once('./views/modules/consulta-indicadores/exp/presentacion.php') ?>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo"
                style="background-color:white; background-color:white; display:flex; justify-content:space-between; align-items:center; margin: 5px;">
                <h4 class="panel-title" style="font-size:20px;">
                    Sobre los indicadores
                </h4>
                <button
                    style="padding:8px; background-color:#215a9a; border: 1px white solid; border-radius: 5px; hover:pointer; color:white">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                        href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="color:white;">
                        Ver más
                    </a>
                </button>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="panel-body">
                    <?php include_once('./views/modules/consulta-indicadores/exp/indicadores.php') ?>
                </div>
            </div>
        </div>

    </div>
</div>

    <?php
    $resp->consultarListadoIndicadoresPorConjunto('EXP', '');
 ?>
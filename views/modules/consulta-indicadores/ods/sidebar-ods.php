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
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin: 5rem;">
    <div class="sidebar-heading" style="background-color: #fff;text-align: center;">
        <img src="/siscali/views/resources/images/home/ODS-circulo.png"
            alt="Imagen de presentación de los Objetivos de Desarrollo Sostenible para Santiago de Cali"
            style="height: 90px;" />
        <h6 style="font-weight: 700; font-size: 2.0rem;">Objetivos de Desarrollo Sostenible para Santiago de Cali
        </h6>
    </div>
    <div class="panel panel-default"  style="border-color:white; box-shadow: 0px 2px 6px 0px rgba(32,32,32,0.3);">
        <div class="panel-heading" role="tab" id="headingOne"
            style="background-color:white; background-color:white; display:flex; justify-content:space-between; align-items:center; margin: 5px;">
            <h4 class="panel-title" style="font-size:20px;">
                ¿Qué son los Objetivos de Desarrollo Sostenible?
            </h4>
            <button
                style="padding:8px; background-color:#215a9a; border: 1px white solid; border-radius: 5px; hover:pointer; color:white">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                    aria-expanded="false" aria-controls="collapseOne" style="color:white;">
                    Ver más
                </a>
            </button>
        </div>
        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <?php include_once('./views/modules/consulta-indicadores/ods/presentacion.php') ?>
            </div>
        </div>
    </div>
    <div class="panel panel-default"  style="border-color:white; box-shadow: 0px 2px 6px 0px rgba(32,32,32,0.3);">
        <div class="panel-heading" role="tab" id="headingTwo"
            style="background-color:white; background-color:white; display:flex; justify-content:space-between; align-items:center; margin: 5px;">
            <h4 class="panel-title" style="font-size:20px;">
                Seguimiento y reporte de los ODS para Santiago
                de Cali
            </h4>
            <button
                style="padding:8px; background-color:#215a9a; border: 1px white solid; border-radius: 5px; hover:pointer; color:white">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"
                    aria-expanded="false" aria-controls="collapseTwo" style="color:white;">
                    Ver más
                </a>
            </button>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
                <?php include_once('./views/modules/consulta-indicadores/ods/seguimiento.php') ?>
            </div>
        </div>
    </div>
    <div class="panel panel-default"  style="border-color:white; box-shadow: 0px 2px 6px 0px rgba(32,32,32,0.3);">
        <div class="panel-heading" role="tab" id="headingThree"
            style="background-color:white; background-color:white; display:flex; justify-content:space-between; align-items:center; margin: 5px;">
            <h4 class="panel-title" style="font-size:20px;">
                Sobre los indicadores ODS para Santiago de
                Cali
            </h4>
            <button
                style="padding:8px; background-color:#215a9a; border: 1px white solid; border-radius: 5px; hover:pointer; color:white">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree"
                    aria-expanded="false" aria-controls="collapseThree" style="color:white;">
                    Ver más
                </a>
            </button>
        </div>
        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">
                <?php include_once('./views/modules/consulta-indicadores/ods/indicadores.php') ?>
            </div>
        </div>
    </div>
    <div class="panel panel-default"  style="border-color:white; box-shadow: 0px 2px 6px 0px rgba(32,32,32,0.3);">
        <div class="panel-heading" role="tab" id="headingFour"
            style="background-color:white; background-color:white; display:flex; justify-content:space-between; align-items:center; margin: 5px;">
            <h4 class="panel-title" style="font-size:20px;">
                Metodología para el seguimiento a indicadores
                de los ODS para Santiago de Cali
            </h4>
            <button
                style="padding:8px; background-color:#215a9a; border: 1px white solid; border-radius: 5px; hover:pointer; color:white">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour"
                    aria-expanded="false" aria-controls="collapseFour" style="color:white;">
                    Ver más
                </a>
            </button>
        </div>
        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
            <div class="panel-body">
                <?php include_once('./views/modules/consulta-indicadores/ods/metodologia.php') ?>
            </div>
        </div>
    </div>
    <div class="panel panel-default"  style="border-color:white; box-shadow: 0px 2px 6px 0px rgba(32,32,32,0.3);">
        <div class="panel-heading" role="tab" id="headingFive"
            style="background-color:white; background-color:white; display:flex; justify-content:space-between; align-items:center; margin: 5px;">
            <h4 class="panel-title" style="font-size:20px;">
                Indicadores por objetivo
            </h4>
            <button
                style="padding:8px; background-color:#215a9a; border: 1px white solid; border-radius: 5px; hover:pointer; color:white">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive"
                    aria-expanded="false" aria-controls="collapseFive" style="color:white;">
                    Ver más
                </a>
            </button>
        </div>
        <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
            <div class="panel-body">
                <?php include_once('./views/modules/consulta-indicadores/ods/objetivos.php') ?>
            </div>
        </div>
    </div>
    <div class="panel panel-default"  style="border-color:white; box-shadow: 0px 2px 6px 0px rgba(32,32,32,0.3);">
        <div class="panel-heading" role="tab" id="headingSix"
            style="background-color:white; background-color:white; display:flex; justify-content:space-between; align-items:center; margin: 5px;">
            <h4 class="panel-title" style="font-size:20px;">
                Indicadores por objetivo
            </h4>
            <button
                style="padding:8px; background-color:#215a9a; border: 1px white solid; border-radius: 5px; hover:pointer; color:white">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix"
                    aria-expanded="false" aria-controls="collapseSix" style="color:white;">
                    Ver más
                </a>
            </button>
        </div>
        <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
            <div class="panel-body">
                <?php include_once('./views/modules/consulta-indicadores/ods/ejecucion-presupuestal.php') ?>
            </div>
        </div>
    </div>
</div>

<?php
$resp->consultarListadoIndicadoresPorConjunto('ODS', '');
?>
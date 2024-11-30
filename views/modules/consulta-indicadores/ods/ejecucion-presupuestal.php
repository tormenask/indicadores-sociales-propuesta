<?php
include './views/modules/header.php';

require_once './controllers/consultas_visualizadores.php';
require_once './models/consultas_visualizadores.php';
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-treemap@0.2.2"></script>
<script src="/views/resources/js/ods-script.js"></script>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="/index.php" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li><a href="/consulta-indicadores/ods">Objetivos de Desarrollo Sostenible para Santiago de Cali</a></li>
        <li class="active"><a href="/consulta-indicadores/ods/ejecucion-presupuestal">Ejecución presupuestal</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-4" id="wrapper">
        <?php include './views/modules/consulta-indicadores/ods/sidebar-ods.php'; ?>
    </div>
    <div class="col-xs-12 col-sm-8">
        <div id="page-content-wrapper">
            <div id="text-index">
                <h1>Ejecución presupuestal</h1>
                <hr>
                <p>A continuación, se presenta la ejecución presupuestal en cada uno de los Objetivos de Desarrollo Sostenible, para el periodo 2016-2019.</p>
                <br>
                <div class="canvas-holder">
                    <canvas id="chart-area" style="width: 100%;"></canvas>
                </div>
                <?php
                $cons = new ConsultasController();
                $ejecucionPresupuestal = $cons->consultarEjecucionPresupuestalODS();
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!--Footer-->
    <?php include './views/modules/footer.php'; ?>
</div>
<script>
    $("#consulta-indicadores").addClass("active");
    $("#consulta-ods").addClass("active");
    $("#ods-ejecucion-presupuestal").addClass("back-item-menu");
</script>
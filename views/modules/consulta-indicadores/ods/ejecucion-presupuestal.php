<?php
require_once './controllers/consultas_visualizadores.php';
require_once './models/consultas_visualizadores.php';
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-treemap@0.2.2"></script>
<script src="views/resources/js/ods-script.js"></script>
<div class="col-12">
    <div id="page-content-wrapper">
        <div id="text-index">
            <p>A continuación, se presenta la ejecución presupuestal en cada uno de los Objetivos de Desarrollo
                Sostenible, para el periodo 2016-2019.</p>
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

<script>
    $("#consulta-indicadores").addClass("active");
    $("#consulta-ods").addClass("active");
    $("#ods-ejecucion-presupuestal").addClass("back-item-menu");
</script>
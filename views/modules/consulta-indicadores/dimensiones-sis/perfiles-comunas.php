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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.canvasTextRenderer.min.js"></script>
<?php include 'views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="/" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li><a href="/consulta-indicadores/dimensiones-sis-comunas">Indicadores por Comunas</a></li>
        <li class="active"><a href="/consulta-indicadores/dimensiones-sis-comunas/perfiles">Perfiles por Comuna</a></li>
    </ul>
</div>
<?php include 'views/modules/footer.php'; ?>
<script>
    $("#sis_cali").addClass("back-item-menu");
    $("#consultaComunas").addClass("active");
    $("#consultaIndicadores").addClass("active");
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/jquery.jqplot.min.css" />
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/jquery.jqplot.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.pyramidGridRenderer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.pyramidAxisRenderer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.pyramidRenderer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script src="../views/resources/lib/jquery-number/jquery.number.min.js"></script>
<?php include './views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li class="active"><a href="consulta-indicadores/calidad-educativa">Visualizador de datos de Calidad Educativa</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div id="text-index">
                    <h1>Visualizador de datos de Calidad Educativa</h1>
                    <hr>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 20px;">
            <div id="mapa_container" class="col-xs-12 col-sm-4">
                <div class="panel mapa_panel">
                    <p style="text-align: center; margin: 10px;">
                        Haga clic en la comuna que desea consultar.
                    </p>
                </div>
                <div id="mapa" style="margin-top: -25px;"></div>
                <script src="../views/resources/js/calidad-educativa-script.js"></script>
                <br>
            </div>
            <div class="col-xs-12 col-sm-8" style="background-color: #eee; padding: 0px; border: 1px solid #ccc;">
                <div id="panel_informacion_comunas" class="panel" style="margin: 20px; border: 1px #ccc solid;">
                    <p style="margin: 20px;">
                        Se presenta la información del desempeño en las Pruebas Saber 11, para los diferentes establecimientos educativos oficiales del Municipio, distribuidos por comunas.
                    </p>
                </div>
                <div id="informacion_comuna" hidden="true">
                    <div id="establecimientos_comuna" style="margin: 15px;">
                    </div>
                    <div id="graficos_comuna" style="margin: 15px;">
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php include './views/modules/footer.php'; ?>
<script>
    function consultarSeleccionados() {
        var selected = [];
        $("#tablaDatos input:checked").each(function () {
            selected.push($(this).attr("value"));
        });
        if (selected.length === 0) {
            alert("Seleccione al menos un establecimiento educativo");
        } else {
            var data = new FormData();
            data.append('selected', selected);
            var url = "/siscali/views/modules/consulta-indicadores/calidad-educativa/consultas-calidad-educativa.php";
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (resp) {
                    $("#graficos_comuna").html(resp);
                    $("#informacion_comuna").show();
                }
            });
        }
        console.log("Seleccionados: " + selected.toString());
    }

//    $("#consultaComunas").addClass("active");
//    $("#consultaIndicadores").addClass("active");
</script>
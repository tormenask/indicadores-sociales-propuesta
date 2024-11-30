<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!--<script type="text/javascript" src="Chart.BarFunnel.js"></script>-->
  <!--<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>-->
  <!--<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
<!--<script type="text/javascript" src="\\views\resources\tacometro\kuma-gauge.jquery.js"></script>-->
<script src="https://d3js.org/d3.v3.min.js" language="JavaScript"></script>
<!--<script src="\views\resources\tacometro\liquidFillGauge.js" language="JavaScript"></script>-->
<script type="text/javascript"></script>
<style>
    #wrapper {transition: all .4s ease 0s;height: 100%;}
    #sidebar-wrapper {height: 100%;transition: all .4s ease 0s;}
    .sidebar-nav {display: block;list-style: none;margin: 0;padding: 0;}
    #page-content-wrapper {margin-left: 0%; width: 94%;}
    #wrapper.active #sidebar-wrapper {left: 100px;}
    .chart-stage {padding: 5px !important;}
    .panel-group {margin-bottom: 10px;}

</style>
<?php include './views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="/index.php" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li class="active"><a href="/consulta-indicadores/dadii">Visualizador de indicadores del Departamento Administrativo de Desarrollo e Innovación Institucional</a></li>
    </ul>
</div>
<div class="row">
    <div  class="col-xs-12 col-sm-3" id="wrapper">
        <?php include './views/modules/consulta-indicadores/dadii/sidebar-dadii.php'; ?>        
    </div>
    <div class="col-xs-12 col-sm-9">
        <div id="page-content-wrapper">
            <div id="text-index" hidden>
                <!--<h1>Consulta de Indicadores del Departamento Administrativo de Desarrollo e Innovación Institucional</h1>-->
                <h1>Consulta de indicadores de desempeño institucional</h1>
                <p>Para comenzar, seleccione el macroproceso y el proceso a consultar, en el panel lateral.</p>
            </div>
            <div id="tabsTematica" style="min-height: 720px; margin-bottom: 15px;"></div>
        </div>
    </div>
</div>
<?php include './views/modules/footer.php'; ?>
<script>
    $("#consultaIndicadores").addClass("active");
    $("#consultaDADII").addClass("active");
    $(document).ready(function () {
        listarIndicadores();
    });
    function listarIndicadores() {
        var data = new FormData();
        var url = "/views/modules/consulta-indicadores/dadii/consultas.php";
        var conjuntoIndicador = "DADII";
        data.append("conjuntoIndicador", conjuntoIndicador);
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            async: true,
            contentType: false,
            processData: false,
            success: function (resp) {
                var result = eval(resp);
                $('#listarIndicadores').multiselect('dataprovider', result);
            }
        });
    }
</script>
<?php
if (isset($_GET['idDim']) && isset($_GET['idTem']) && $_GET['idDim'] == "GENERALIDADES" && $_GET['idTem'] == "INDICADORES") {
    ?> <script>
        $("#tabsTematica").LoadingOverlay("show", {
            background: "rgba(255, 255, 255, 0.5)",
            image: "/views/resources/images/cube_load.gif"
        });
        setTimeout(function () {
            $("#tabsTematica").LoadingOverlay("hide");
        }, 3000);

        var idConjunto = 'DADII';
        var data = new FormData();
        data.append('idConjunto', idConjunto);
        var url = "/views/modules/consulta-indicadores/dadii/consultas.php";
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            async: true,
            contentType: false,
            processData: false,
            success: function (resp) {
                $("#tabsTematica").html(resp);
                $("#tabsTematica").show();
            }
        });
    </script>    
    <?php
} else {

    if (isset($_GET['idDim']) && isset($_GET['idTem'])) {
        $idDimension = $_GET['idDim'];
        $idTematica = $_GET['idTem'];
    } else {
        echo '<script> $("#text-index").show(); $("#tabsTematica").hide(); </script>';
    }

    if (!empty($idDimension) && !empty($idTematica)) {
        ?> 
        <script>
            $("#tabsTematica").LoadingOverlay("show", {
                background: "rgba(255, 255, 255, 0.5)",
                image: "/views/resources/images/cube_load.gif"
            });
            setTimeout(function () {
                $("#tabsTematica").LoadingOverlay("hide");
            }, 3000);

            var idDimension = '<?php echo $idDimension; ?>';
            var idTematica = '<?php echo $idTematica; ?>';
            var data = new FormData();
            data.append('idDimensionC', idDimension);
            data.append('idTematicaC', idTematica);
            var url = "/views/modules/consulta-indicadores/dadii/consultas.php";
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                cache: false,
                async: true,
                contentType: false,
                processData: false,
                success: function (resp) {
                    $("#tabsTematica").html(resp);
                    $("#tabsTematica").show();
                }
            });
        </script>    
    <?php } else { ?>
        <script>
            var resp = "<div class='alert alert-danger alert-dismissable'>\n\
                            Error al realizar la consulta. Debe seleccionar todos los filtros.<br>\n\
                            Para volver a la página anterior, haga clic <a href='javascript:history.back(-1);' id='btn-accept' class='alert-link'><strong>aquí.</strong></a>\n\
                        </div>";
            $('#tabsTematica').html(resp);
        </script>
        <?php
    }
}
?>
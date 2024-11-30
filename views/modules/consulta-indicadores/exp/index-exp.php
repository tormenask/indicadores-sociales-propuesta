<?php include './views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="/" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li class="active"><a href="/consulta-indicadores/exp">Indicadores del Expediente Municipal</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-4" id="wrapper">
        <?php include './views/modules/consulta-indicadores/exp/sidebar-exp.php'; ?>
    </div>
    <div class="col-xs-12 col-sm-8">
        <div id="page-content-wrapper">
            <div id="text-index" hidden>
                <h1>Consulta de Indicadores del Expediente Municipal</h1>
                <p>Para comenzar, selecciona la dimensión, temática e indicador a consultar, en el panel lateral.</p>
            </div>
            <div id="tabsIndicador" style="min-height: 720px; margin-bottom: 15px;"></div>
        </div>
    </div>
</div>
<?php include './views/modules/footer.php'; ?>
<script>
    $("#consultaIndicadores").addClass("active");
    $("#consultaEXP").addClass("active");
</script>
<?php
if (isset($_GET['idDim']) && isset($_GET['idTem']) && $_GET['idInd'] && $_GET['desGeo'] && $_GET['fte'] && isset($_GET['desTem']) && $_GET['fchs']) {
    $idDimension = $_GET['idDim'];
    $idTematica = $_GET['idTem'];
    $idIndicador = $_GET['idInd'];
    $tipoZonaGeografica = $_GET['fte'];
    $desagregacionesTematicas = $_GET['desTem'];
    $fechas = $_GET['fchs'];
    $zonaGeografica = $_GET['desGeo'];
} else {
    echo '<script> $("#text-index").show(); $("#tabsIndicador").hide(); </script>';
}
if (!empty($idDimension) && !empty($idTematica) && !empty($idIndicador) && !empty($tipoZonaGeografica) && !empty($desagregacionesTematicas) && !empty($fechas) && !empty($zonaGeografica)) {
    ?> 
    <script>
        //Para overlay
        $.LoadingOverlaySetup({
        background: "rgba(255, 255, 255, 0.5)",
        image           : "/views/resources/images/cube_load.gif",
        imageAnimation  : "3.5s fadein",
        imageColor      : "#ffcc00"
    });

    $("#tabsIndicador").LoadingOverlay("show");
        setTimeout(function () {
            $("#tabsIndicador").LoadingOverlay("hide");
        }, 7000);

        // $("#tabsIndicador").LoadingOverlay("show", {
        //     background: "rgba(255, 255, 255, 0.5)",
        //     image: "/views/resources/images/cube_load.gif"
        // });
        // setTimeout(function () {
        //     $("#tabsIndicador").LoadingOverlay("hide");
        // }, 3000);

        //Para consulta
        var idDimension = '<?php echo $idDimension; ?>';
        var idTematica = '<?php echo $idTematica; ?>';
        var idIndicador = '<?php echo $idIndicador; ?>';
        var tipoZonaGeografica = '<?php echo $tipoZonaGeografica; ?>';
        var dsgrgcns = '<?php echo $desagregacionesTematicas; ?>';
        var desagregaciones = dsgrgcns.split(',');
        var fchs = '<?php echo $fechas; ?>';
        var fechas = fchs.split(',');
        var zonaGeografica = '<?php echo $zonaGeografica; ?>';
        var data = new FormData();
        data.append('idDimensionC', idDimension);
        data.append('idTematicaC', idTematica);
        data.append('idIndicadorC', idIndicador);
        data.append('tipoZonaGeograficaC', tipoZonaGeografica);
        data.append('desagregacionesTematicasC', JSON.stringify(desagregaciones));
        data.append('fechasC', JSON.stringify(fechas));
        data.append('zonaGeograficaC', zonaGeografica);
        var url = "/views/modules/consulta-indicadores/exp/consultas.php";
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            async: true,
            contentType: false,
            processData: false,
            success: function (resp) {
                consultarTiposZonasGeograficas(idIndicador);
                console.log(resp);
                $("#tabsIndicador").html(resp);
                $("#tabsIndicador").show();
            }
        });
    </script>
    <script>
        function consultarTiposZonasGeograficas(idIndicador) {
            var data = new FormData();
            var url = "/views/modules/consulta-indicadores/exp/consultas.php";
            data.append("idIndicador1", idIndicador);
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                cache: false,
                async: true,
                contentType: false,
                processData: false,
                success: function (resp) {
                    console.log(resp);
                    var result = eval(resp);
                    $('#tipoZonaGeograficaConsultar').multiselect('dataprovider', result);
                }
            });
        }
    </script>
<?php } else { ?>
    <script>
        var resp = "<div class='alert alert-danger alert-dismissable'>\n\
                        Error al realizar la consulta. Debe seleccionar todos los filtros.<br>\n\
                        Para volver a la página anterior, haga clic <a href='javascript:history.back(-1);' id='btn-accept' class='alert-link'><strong>aquí.</strong></a>\n\
                    </div>";
        $('#tabsIndicador').html(resp);
    </script>
    <?php
}
?>

<script>

    function consultarDesagregacionesTematicas(idIndicador, desagregacionesGeograficas) {
        var data = new FormData();
        var url = "/views/modules/consulta-indicadores/consultas-indicador.php";
        data.append("idIndicador2", idIndicador);
        data.append("desagregacionesGeograficas2", desagregacionesGeograficas);
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
                $('#desagregacionTematicaConsultar').multiselect('dataprovider', result);
            }
        });
    }
    function consultarFechas(idIndicador, fuente, desagregacionesGeograficas, desagregacionesTematicas) {
        console.log(idIndicador, fuente, desagregacionesGeograficas, desagregacionesTematicas);
        var data = new FormData();
        var url = "/views/modules/consulta-indicadores/consultas-indicador.php";
        data.append("idIndicador3", idIndicador);
        data.append("fuente3", fuente);
        data.append("desagregacionesGeograficas3", desagregacionesGeograficas);
        data.append("desagregacionesTematicas3", desagregacionesTematicas);
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            async: true,
            contentType: false,
            processData: false,
            success: function (resp) {
                $("#fechasConsultar").html(resp);
                var button = $("#btnConsultar");
                $(button).prop("disabled", false);
            }
        });
    }

</script>
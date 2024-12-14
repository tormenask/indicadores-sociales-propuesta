<?php include './views/modules/header.php'; ?>
<script src="views/resources/js/ods-script.js"></script>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li class="active"><a href="consulta-indicadores/ods">Objetivos de Desarrollo Sostenible para Santiago de Cali</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-12" id="wrapper">
        <?php include './views/modules/consulta-indicadores/ods/sidebar-ods.php'; ?>
    </div>
</div>
<?php include './views/modules/footer.php'; ?>
<script>
    $("#consulta-indicadores").addClass("active");
    $("#consulta-ods").addClass("active");
</script>
<?php
if (isset($_GET['idDim']) && isset($_GET['idTem']) && isset($_GET['idInd']) && isset($_GET['fte']) && isset($_GET['desTem']) && isset($_GET['fchs']) && isset($_GET['desGeo'])) {
    $idDimension = $_GET['idDim'];
    $idTematica = $_GET['idTem'];
    $idIndicador = $_GET['idInd'];
    $fuente = $_GET['fte'];
    $desagregacionesTematicas = $_GET['desTem'];
    $fechas = $_GET['fchs'];
    $desagregacionesGeograficas = $_GET['desGeo'];
} else {
    //echo '<script> $("#text-index").show(); $("#tabsIndicador").hide(); </script>';
}
if (!empty($idDimension) && !empty($idTematica) && !empty($idIndicador) && !empty($fuente) && !empty($desagregacionesTematicas) && !empty($fechas) && !empty($desagregacionesGeograficas)) {
    $indc = new IndicadoresController();
    $indc->contadorConsultasIndicadores($idIndicador);  
    ?>
    <script>
        //Para overlay
        $.LoadingOverlaySetup({
        background: "rgba(255, 255, 255, 0.5)",
        image           : "/views/resources/images/cube_load.gif",
        imageAnimation  : "3.5s fadein",
        imageColor      : "#ffcc00"
    });

    $("#tabIndicador-"+idIndicador).LoadingOverlay("show");
        setTimeout(function () {
            $("#tabIndicador-"+idIndicador).LoadingOverlay("hide");
        }, 7000);

        $(document).ready(function () {
            $("#tabIndicador-" + idIndicador).css("display", "block");
            $("#containerIndicador-" + idIndicador).removeClass("col-md-6");
            $("#containerIndicador-" + idIndicador).removeClass("col-lg-4");
            $("#containerIndicador-" + idIndicador).addClass("col-md-12");
            $("#containerIndicador-" + idIndicador).addClass("col-lg-12");
            $('#btn-' + idIndicador).attr('href', '/consulta-indicadores/ods')
            $('#btn-' + idIndicador).text('Ver menos')
        })

        //Para consulta
        var tipoConsulta = 'ODS';
        var idDimension = '<?php echo $idDimension; ?>';
        var idTematica = '<?php echo $idTematica; ?>';
        var idIndicador = '<?php echo $idIndicador; ?>';
        var fuente = '<?php echo $fuente; ?>';
        console.log(fuente);
        var dsgrgcns = '<?php echo $desagregacionesTematicas; ?>';
        var desagregaciones = dsgrgcns.split(',');
        var fchs = '<?php echo $fechas; ?>';
        var fechas = fchs.split(',');
        var zns = '<?php echo $desagregacionesGeograficas; ?>';
        var zonas = zns.split(',');
        var data = new FormData();
        data.append('tipoConsulta', tipoConsulta);
        data.append('idDimension', idDimension);
        data.append('idTematica', idTematica);
        data.append('idIndicador', idIndicador);
        data.append('fuente', fuente);
        data.append('desagregaciones', JSON.stringify(desagregaciones));
        data.append('fechas', JSON.stringify(fechas));
        data.append('zonas', JSON.stringify(zonas));
        var url = "/views/modules/consulta-indicadores/consultas-indicador.php";
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            async: true,
            contentType: false,
            processData: false,
            success: function (resp) {
                $("#tabIndicador-"+idIndicador).html(resp);
            }
        });
    </script>
<?php } else { ?>
    <script>
        var resp = "<div class='alert alert-danger alert-dismissable'>\n\
                        Error al realizar la consulta. Debe seleccionar todos los filtros.<br>\n\
                        Para volver a la página anterior, haga clic <a href='javascript:history.back(-1);' id='btn-accept' class='alert-link'><strong>aquí.</strong></a>\n\
                    </div>";
        $('#tabIndicador-'+idIndicador).html(resp);
    </script>
    <?php
}
?>
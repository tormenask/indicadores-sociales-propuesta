<?php include './views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="/" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li class="active"><a href="/consulta-indicadores/igc">Indicadores Globales de Ciudad</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-4" id="wrapper">
        <?php include './views/modules/consulta-indicadores/igc/sidebar-igc.php'; ?>
    </div>
    <div class="col-xs-12 col-sm-8">
        <div id="page-content-wrapper">
            <div id="text-index" hidden>
                <h1>Consulta de Indicadores Globales de Ciudad</h1>
                <p>Para comenzar, selecciona la dimensión, temática e indicador a consultar, en el panel lateral.</p>
            </div>
            <div id="tabsIndicador" style="min-height: 720px; margin-bottom: 15px;"></div>
        </div>
    </div>
</div>
<?php include './views/modules/footer.php'; ?>
<script>
    $("#consultaIndicadores").addClass("active");
    $("#consultaIGC").addClass("active");
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
    echo '<script> $("#text-index").show(); $("#tabsIndicador").hide(); </script>';
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
        var tipoConsulta = 'IGC';
        var idDimension = '<?php echo $idDimension; ?>';
        var idTematica = '<?php echo $idTematica; ?>';
        var idIndicador = '<?php echo $idIndicador; ?>';
        var fuente = '<?php echo $fuente; ?>';
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
                consultarDesagregacionesGeograficas(idIndicador);
                $("#tabsIndicador").html(resp);
            }
        });
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
    function consultarDesagregacionesGeograficas(idIndicador) {
        var data = new FormData();
        var url = "/views/modules/consulta-indicadores/consultas-indicador.php";
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
                var result = eval(resp);
                $('#desagregacionGeograficaConsultar').multiselect('dataprovider', result);
            }
        });
    }
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
    function redirect() {
        var brands = $('#desagregacionTematicaConsultar option:selected');
        var desagregaciones = [];
        $(brands).each(function (index, brand) {
            desagregaciones.push([$(this).val()]);
        });
        var brands2 = $('#desagregacionGeograficaConsultar option:selected');
        var desagregaciones2 = [];
        $(brands2).each(function (index2, brand2) {
            desagregaciones2.push([$(this).val()]);
        });
        var min = $("#from").val();
        var max = $("#to").val();
        var str = $("#range_hidden").val();
        var link = $("#link").val();
        var res = str.split(",");
        var rango = new Array();
        for (var i = 0; i < res.length; i++) {
            if (res[i] >= min && res[i] <= max) {
                rango.push(res[i]);
            }
        }

        link = link + '/' + desagregaciones.toString() + '/' + rango.toString() + '/' + desagregaciones2;
        window.location.href = link;
    }
</script>
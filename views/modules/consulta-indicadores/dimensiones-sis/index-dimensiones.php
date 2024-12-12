<?php include 'views/modules/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-treemap@0.2.2"></script>
<script src="/views/resources/js/ods-script.js"></script>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="/" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li class="active"><a href="/consulta-indicadores/dimensiones-sis">Indicadores para la medición del Desarrollo
                Social</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-4 col-md-12 col-lg-12"
        style="display:flex; align-items:center; justify-content: center; margin-top:3rem;">
        <article style="display: flex; justify-content:center; align-items:center;">
            <a href="/consulta-indicadores/dimensiones-sis-comunas" style="text-decoration-color: #FFFFFF; display: flex; justify-content:center; align-items:center; flex-direction:column">
                <img src="/views/resources/images/home/dimensiones_sis.png"
                    alt="Imagen de presentación de los Indicadores para la Medición del Desarrollo Social, por comunas"
                    style=" border-radius: 150px; width: 50%; margin-top: -65px;" />
                <h6 style="font-weight: 700;font-size: 2.0rem;">Indicadores para la Medición del Desarrollo
                    Social</h6>
            </a>
        </article>

    </div>
</div>
<div class="row">
    <div class="" id="wrapper">
        <?php include 'views/modules/consulta-indicadores/dimensiones-sis/sobre-desarrollo-sis.php' ?>
        <?php include 'views/modules/consulta-indicadores/dimensiones-sis/sidebar-dimensiones-sis.php'; ?>
    </div>

</div>
<?php include 'views/modules/footer.php'; ?>
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
    //echo '<script> $("#text-index").show(); $("#tabIndicador-' + $idIndicador + '").hide(); </script>';
}
if (!empty($idDimension) && !empty($idTematica) && !empty($idIndicador) && !empty($fuente) && !empty($desagregacionesTematicas) && !empty($fechas) && !empty($desagregacionesGeograficas)) {
    $ser = new SeriesDatosController();
    $indc = new IndicadoresController();
    $indc->contadorConsultasIndicadores($idIndicador);
    $noFuentes = count($ser->consultarFuentesPorIdIndicadorDiferenteComunasController($idIndicador));
    ?>
    <script>

        //Para overlay
        var noFuentes = '<?php echo $noFuentes; ?>';

        //Para consulta
        var tipoConsulta = 'General';
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
        var estado = true

        $.LoadingOverlaySetup({
            background: "rgba(255, 255, 255, 0.5)",
            image: "/views/resources/images/cube_load.gif",
            imageAnimation: "3.5s fadein",
            imageColor: "#ffcc00"
        });


        $("#tabIndicador-" + idIndicador).LoadingOverlay("show");
        setTimeout(function () {
            $("#tabIndicador-" + idIndicador).LoadingOverlay("hide");
        }, 7000);

        $(document).ready(function () {
            $("#tabIndicador-" + idIndicador).css("display", "block");
            $("#containerIndicador-" + idIndicador).removeClass("col-md-6");
            $("#containerIndicador-" + idIndicador).removeClass("col-lg-4");
            $("#containerIndicador-" + idIndicador).addClass("col-md-12");
            $("#containerIndicador-" + idIndicador).addClass("col-lg-12");
            $('#btn-' + idIndicador).attr('href', '/consulta-indicadores/dimensiones-sis')
            $('#btn-' + idIndicador).text('Ver menos')
        })

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
                if (noFuentes > 1) {
                    consultarFuentes(idIndicador);
                } else {
                    consultarDesagregacionesGeograficas(idIndicador);
                }
                $("#tabIndicador-" + idIndicador).html(resp);
            }
        });
    </script>
<?php } else { ?>
    <script>
        var resp = "<div class='alert alert-danger alert-dismissable'>\n\
                                                                                    Error al realizar la consulta. Debe seleccionar todos los filtros.<br>\n\
                                                                                    Para volver a la página anterior, haga clic <a href='javascript:history.back(-1);' id='btn-accept' class='alert-link'><strong>aquí.</strong></a>\n\
                                                                                </div>";
        $("#tabIndicador-" + idIndicador).html(resp);
    </script>
    <?php
}
?>

<script>
    function consultarFuentes(idIndicador) {
        var data = new FormData();
        var url = "/views/modules/consulta-indicadores/consultas-indicador.php";
        data.append("idIndicadorFte", idIndicador);
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
                $('#fuenteDatosConsultar').multiselect('dataprovider', result);
            }
        });
    }
    function consultarDesagregacionesGeograficasFuente(idIndicador, fuenteDatos) {
        var data = new FormData();
        var url = "/views/modules/consulta-indicadores/consultas-indicador.php";
        data.append("idIndicador4", idIndicador);
        data.append("fuente4", fuenteDatos);
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
                console.log(resp);
                $('#desagregacionGeograficaConsultar').multiselect('dataprovider', result);
            }
        });
    }
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
                console.log(resp);
                var result = eval(resp);
                $('#desagregacionGeograficaConsultar').multiselect('dataprovider', result);
            }
        });
    }

    function consultarDesagregacionesTematicasFuente(idIndicador, desagregacionesGeograficas, fuenteDatos) {
        var data = new FormData();
        var url = "/views/modules/consulta-indicadores/consultas-indicador.php";
        data.append("idIndicador5", idIndicador);
        data.append("desagregacionesGeograficas5", desagregacionesGeograficas);
        data.append("fuente5", fuenteDatos);
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
        var fuenteDatos = '';
        if ($("#fuenteDatosConsultar").val() === null || $("#fuenteDatosConsultar").val() === undefined) {
            fuenteDatos = fuente;
        } else {
            fuenteDatos = $("#fuenteDatosConsultar").val();
        }
        var brands = $('#desagregacionTematicaConsultar option:selected');
        var desagregacionesTematicas = [];
        $(brands).each(function (index, brand) {
            desagregacionesTematicas.push([$(this).val()]);
        });
        var brands2 = $('#desagregacionGeograficaConsultar option:selected');
        var desagregacionesGeograficas = [];
        $(brands2).each(function (index2, brand2) {
            desagregacionesGeograficas.push([$(this).val()]);
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
        link = link + '/' + fuenteDatos + '/' + desagregacionesTematicas.toString() + '/' + rango.toString() + '/' + desagregacionesGeograficas;
        window.location.href = link;
    }
</script>
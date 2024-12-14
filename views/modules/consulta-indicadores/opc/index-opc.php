<link rel="stylesheet" type="text/css" href="views/resources/opc/lib/css/keen-dashboards.css">
<link rel="stylesheet" type="text/css" href="views/resources/opc/lib/css/dc.min.css">
<link rel="stylesheet" type="text/css" href="views/resources/opc/lib/css/leaflet.css">

<?php include './views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li>Otros indicadores</li>
        <li class="active"><a href="consulta-indicadores/opc">Visualizador de datos del Observatorio de Paz y Convivencia</a></li>
    </ul>
</div>
<div id="wrapper" class="active row">
    <div id="sidebar-wrapper" class="col-sm-2">
        <?php include './views/modules/consulta-indicadores/opc/sidebar-opc.php'; ?>
    </div>
    <div id="page-content-wrapper">
        <div class="page-content">
            <?php include './views/modules/consulta-indicadores/opc/graphs.php'; ?>
        </div>
    </div>
</div>
<style>
    #wrapper {transition: all .4s ease 0s;height: 100%;}
    #sidebar-wrapper {margin-left: -150px;height: 100%;transition: all .4s ease 0s;}
    .sidebar-nav {display: block;list-style: none;margin: 0;padding: 0;}
    #page-content-wrapper {margin-left: 16%; width: 84%;}
    #wrapper.active #sidebar-wrapper {left: 150px;}
    .chart-stage {padding: 5px !important;}
    @media (max-width:767px) {
        #wrapper {padding-left: 70px;transition: all .4s ease 0s;}
        #sidebar-wrapper {left: 70px;}
        #wrapper.active {padding-left: 150px;}
        #wrapper.active #sidebar-wrapper {left: 150px;width: 150px;transition: all .4s ease 0s;}
    }
</style>
<script>
    $("#page-content-wrapper").LoadingOverlay("show", {
        background: "rgba(255, 255, 255, 0.5)",
        image: "/views/resources/images/cube_load.gif"
    });
    setTimeout(function () {
        $("#page-content-wrapper").LoadingOverlay("hide");
    }, 30000);
</script>
<?php include './views/modules/footer.php'; ?>
<script>
    $("#consultaIndicadores").addClass("active");
    $("#consultaOPC").addClass("active");
</script>

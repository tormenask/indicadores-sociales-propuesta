<?php include 'views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li><a href="/" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li><?php echo $categoria; ?></li>
        <li class="active"><a href="/<?php echo $url; ?>"><?php echo $titulo; ?></a></li>
    </ul>
</div>
<div class="row">
    <?php
    if ($titulo == 'Visualizador de datos del Observatorio de Paz y Cultura Ciudadana | Presentación') {
        echo '<div id="sidebar-wrapper" class="col-sm-2">';
        include 'views/modules/consulta-indicadores/opc/sidebar-opc.php';
    } else {
        echo '<div class="col-sm-3" id="wrapper">';
        include 'views/menus/' . $ruta_categoria . '.php';
    }
    ?>
</div>
<div class="col-sm-9">
    <div id="page-content-wrapper">
        <div id="text-index">
            <?php echo $contenido; ?>
        </div>
    </div>
</div>
<?php include 'views/modules/footer.php'; ?>
<script>
    if ('<?php echo $titulo ?>' !== 'Visualizador de datos del Observatorio de Paz y Cultura Ciudadana | Presentación') {
        $("#<?php echo $ruta_categoria; ?>").addClass("active");
        $("#<?php echo $ruta_categoria; ?>-<?php echo $ruta_titulo; ?>").addClass("active");
        $("#menu-<?php echo $ruta_categoria; ?>-<?php echo $ruta_titulo; ?>").addClass("back-item-menu");
    }
</script>
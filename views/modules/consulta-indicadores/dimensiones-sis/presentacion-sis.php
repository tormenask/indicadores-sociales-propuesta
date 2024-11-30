<?php include './views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="/" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li><a href="/consulta-indicadores/dimensiones-sis">Indicadores para la medición del Desarrollo Social</a></li>
        <li class="active"><a href="/consulta-indicadores/dimensiones-sis/presentacion">Presentación</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-4" id="wrapper">
        <?php include './views/modules/consulta-indicadores/dimensiones-sis/sidebar-dimensiones-sis.php'; ?>
    </div>
    <div class="col-xs-12 col-sm-8">
        <div id="page-content-wrapper">
            <div id="text-index">
                <h1>Presentación de los Indicadores para la Medición del Desarrollo Social </h1>
                <hr>
                <p>
                Medir el desarrollo social resulta importante para comprender su composición, evaluar su progreso y
                establecer los retos que debe enfrentar la ciudad. Los indicadores de desarrollo social proporciona una
                medida amplia del bienestar, permitiendo identificar las áreas específicas de fortalezas y debilidades
                que presenta Santiago de Cali. También, permite evaluar comparativamente su situación actual con años atrás,
                tanto a nivel de indicadores individuales, como en términos de una medida
                más amplia: el desarrollo social.  
                </p>
                <br>
                <p>
                    
                </p>
                <br>
                <!-- <p>
                    Los indicadores del programa se encuentran organizados alrededor de dos grandes categorías y de varias temáticas. Las categorías son los Servicios de Ciudad y Calidad de Vida, donde los servicios de ciudad incluyen los servicios típicamente provistos por los gobiernos y otras entidades de las ciudades. En cuanto a la Calidad de vida, se incluyen los contribuyentes críticos a la calidad de vida general, aunque el gobierno pueda tener poco control directo sobre ellos.
                </p>
                <br> -->
            </div>
        </div>
    </div>
</div>
<?php include './views/modules/footer.php';?>
<script>
    $("#consultaIndicadores").addClass("active");
    $("#consultaIGC").addClass("active");
</script>
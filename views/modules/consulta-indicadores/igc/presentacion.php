<?php include './views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="/" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li><a href="/consulta-indicadores/igc">Indicadores Globales de Ciudad</a></li>
        <li class="active"><a href="/consulta-indicadores/igc/presentacion">Presentación</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-4" id="wrapper">
        <?php include './views/modules/consulta-indicadores/igc/sidebar-igc.php'; ?>
    </div>
    <div class="col-xs-12 col-sm-8">
        <div id="page-content-wrapper">
            <div id="text-index">
                <h1>Presentación de los Indicadores Globales de Ciudad</h1>
                <hr>
                <p>
                    Indicadores Globales de Ciudad, IGC, es un programa creado por el Banco Mundial en colaboración con el Fondo Fiduciario Japonés, para ayudar a las ciudades del mundo con el monitoreo del desarrollo y de la calidad de vida urbana. El programa tiene como objetivo permitir a las autoridades electas, los administradores de las ciudades y la población en general, a monitorear el desempeño de estas en el tiempo. Además, pretende, crear en todo el mundo sistemas de indicadores suficientemente simples y fáciles de obtener, con el propósito de estandarizarlos y que permitan realizar comparaciones entre ciudades, de tal modo que se creen espacios de cohesión para compartir información sobre sus prácticas y generación de un aprendizaje mutuo.
                </p>
                <br>
                <p>
                    El proyecto se enfocó en ciudades con más de 100.000 habitantes e inicia en 4 países (Canadá, Colombia, Brasil y EE. UU) y 8 ciudades piloto entre las que se encuentran: Belo Horizonte, Bogotá, Cali, Montreal, Puerto Alegre, Sao Pablo, Toronto, Vancouver y King County. 
                </p>
                <br>
                <p>
                    Los indicadores del programa se encuentran organizados alrededor de dos grandes categorías y de varias temáticas. Las categorías son los Servicios de Ciudad y Calidad de Vida, donde los servicios de ciudad incluyen los servicios típicamente provistos por los gobiernos y otras entidades de las ciudades. En cuanto a la Calidad de vida, se incluyen los contribuyentes críticos a la calidad de vida general, aunque el gobierno pueda tener poco control directo sobre ellos.
                </p>
                <br>
            </div>
        </div>
    </div>
</div>
<?php include './views/modules/footer.php';?>
<script>
    $("#consultaIndicadores").addClass("active");
    $("#consultaIGC").addClass("active");
</script>
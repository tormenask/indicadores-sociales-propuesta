<?php include './views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="/index.php" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li><a href="/consulta-indicadores/ods">Objetivos de Desarrollo Sostenible para Santiago de Cali</a></li>
        <li class="active"><a href="/consulta-indicadores/ods/seguimiento">Seguimiento y reporte de los ODS para Santiago de Cali</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-4" id="wrapper">
        <?php include './views/modules/consulta-indicadores/ods/sidebar-ods.php'; ?>
    </div>
    <div class="col-xs-12 col-sm-8">
        <div id="page-content-wrapper">
            <div id="text-index">
                <h1>Seguimiento y reporte de los ODS para Santiago de Cali</h1>
                <hr>
                <p>
                    Desde la implementación de los Objetivos de Desarrollo del Milenio (ODM),  y una vez adoptado para Colombia el documento CONPES número 91 de 2005, Cali ha estado comprometida en diseñar estrategias  para evaluar el cumplimiento y seguimiento de los ODM.
                </p>
                <p>
                    Es por ello, que con el fin de continuar y dar cumplimiento a la nueva agenda de Objetivos de Desarrollo Sostenible (ODS) 2030, la Administración  establece un tablero de control de indicadores con la información disponible y establecer nuevas estrategias de fortalecimiento estadístico para su monitoreo.
                </p>
                <hr>
                <h3>Objetivos</h3>
                <h4>Objetivo general</h4>
                <p>
                    Definir para la Santiago de Cali, Indicadores que permitan hacer una medición al cumplimiento de las metas de los Objetivos de Desarrollo Sostenible (ODS) 2030.
                </p>
                <h4>Objetivos específicos</h4>
                <ul>
                    <li>Establecer un tablero de control de indicadores asociados a metas de los Objetivos de Desarrollo Sostenible para la Santiago de Cali.</li>
                    <li>Calcular y determinar la línea base de los indicadores, sus series históricas , las fuentes de los datos y las metas para los cuatrienios: 2016-2019, 2020-2023, 2024-2027 y 2028-2030.</li>
                    <li>Hacer seguimiento a los resultados de las metas identificando las fortalezas y debilidades.</li>
                    <li>Evaluar el cumplimiento de las metas  generando acciones y medidas correctivas.</li>
                </ul>
                <hr>
            </div>
        </div>
    </div>
</div>
<?php include './views/modules/footer.php'; ?>
<script>
    $("#consulta-indicadores").addClass("active");
    $("#consulta-ods").addClass("active");
    $("#ods-seguimiento").addClass("back-item-menu");
</script>
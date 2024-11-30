<?php include './views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="/index.php" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li><a href="/consulta-indicadores/dadii">Visualizador de indicadores del Departamento Administrativo de Desarrollo e Innovación Institucional</a></li>
        <li class="active"><a href="/consulta-indicadores/dadii/presentacion">Presentación</a></li>
    </ul>
</div>
<div class="col-xs-12 col-sm-3" id="wrapper">
    <?php include './views/modules/consulta-indicadores/dadii/sidebar-dadii.php'; ?>
</div>
<div class="col-xs-12 col-sm-9">
    <div id="page-content-wrapper">
        <div id="text-index">

            <h1>Presentación de los Indicadores del Departamento Administrativo de Desarrollo e Innovación Institucional</h1>
            <hr>
            <p> Se conoce como indicador de gestión a aquel dato que refleja el estado de un objetivo en
                una organización. El propósito de estos indicadores de gestión que se miden en la
                Alcaldía de Cali, es que sean la base para la toma de decisiones basadas en datos reales.
                Lo que permite un indicador de gestión es determinar si un proyecto está siendo exitoso o
                si está cumpliendo con los objetivos. El líder de cada proceso es quien suele establecer
                los indicadores de gestión, que son utilizados de manera frecuente para evaluar
                desempeño y resultados. Si no se mide lo que se hace, no se puede controlar y si no se
                puede controlar, no se puede dirigir y si no se puede dirigir no se puede mejorar. La
                medición del desempeño puede ser definida generalmente, como una serie de acciones
                orientadas a medir, evaluar, ajustar y regular las actividades de la entidad.
                <br>
                <br>
                El seguimiento a los indicadores corresponde a la consolidación de las bases de datos de
                los resultados de los procesos en los periodos determinados que permiten revisar la
                trazabilidad de las actividades, facilitando el control, la toma de decisiones y la mejora
                continua de la Entidad.</p>
            <br>
<!--            <img src= "/views/resources/images/exp/presentacion.jpg"
                 alt="Presentación de los Indicadores del Expediente Municipal." style="width: 100%;">
            <hr>-->

        </div>
    </div>
</div>
<?php include './views/modules/footer.php'; ?>
<script>
    $("#consultaIndicadores").addClass("active");
    $("#consultaDADII").addClass("active");
</script>
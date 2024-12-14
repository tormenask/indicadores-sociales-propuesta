<?php include './views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li><a href="" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li><a href="consulta-indicadores/odraf">Indicadores del Observatorio del Deporte, la Recreación y la Actividad Física</a></li>
        <li class="active"><a href="consulta-indicadores/odraf/indicadores">Sobre los indicadores</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-4" id="wrapper">
        <?php include './views/modules/consulta-indicadores/odraf/sidebar-odraf.php'; ?>
    </div>
    <div class="col-xs-12 col-sm-8">
        <div id="page-content-wrapper">
            <div id="text-index">
                <h1>Sobre los indicadores del Observatorio del Deporte, la Recreación y la Actividad Física</h1>
                <hr>
                <p>
                    Los indicadores publicados por el Observatorio del Deporte, la Recreación y la Actividad Física (ODRAF) buscan identificar las prácticas, los medios y las estrategias que, desde el deporte, la recreación y la actividad física posibilitan el desarrollo integral de los diferentes grupos poblacionales que habitan en el área urbana y rural del Municipio de Santiago de Cali.
                </p>
                <br>
                <p>
                    Estos indicadores serán publicados periódicamente, de acuerdo con las características de cada indicador y agrupados de acuerdo a las diferentes temáticas identificadas en el Plan de Ordenamiento Territorial correspondientes a:
                </p>
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    Infraestructura
                                </h3>
                            </div>
                            <div class="panel-body">
                                <ul>
                                    <li>
                                        Equipamientos Alto rendimiento.</li>
                                    <li>
                                        Equipamientos Barriales.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="panel panel-green" style="border: solid 1px #388E3C;">
                            <div class="panel-heading" style="background-color: #388E3C;">
                                <h3 class="panel-title">
                                    Inversión en deporte, recreación y actividad física
                                </h3>
                            </div>
                            <div class="panel-body">
                                <ul>
                                    <li>
                                        Presupuesto inicial en deporte, recreación y actividad física.
                                    </li>
                                    <li>
                                        Presupuesto final en deporte, recreación y actividad física.
                                    </li>
                                    <li>
                                        Ejecución presupuestal en deporte, recreación y actividad física.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-green" style="border: solid 1px #F44336;">
                            <div class="panel-heading" style="background-color: #F44336;">
                                <h3 class="panel-title">
                                    Acceso y permanencia-prácticas
                                </h3>
                            </div>
                            <div class="panel-body">
                                <ul>
                                    <div class="col-sm-6">
                                        <li>
                                            Población atendida por la SDR en Deporte.
                                        </li>
                                        <li>
                                            Población atendida por la SDR en Recreación.
                                        </li>
                                        <li>
                                            Población atendida por la SDR en Actividad Física.
                                        </li>
                                        <li>
                                            Población atendida por la SDR en Educación.
                                        </li>
                                        <li>
                                            Número de clubes registrados.
                                        </li>
                                    </div>
                                    <div class="col-sm-6">
                                        <li>
                                            Porcentaje de habitantes que practican o no practican deporte, recreación y actividad física.
                                        </li>
                                        <li>
                                            Porcentaje de habitantes que practican deporte.
                                        </li>
                                        <li>
                                            Porcentaje de habitantes que practican recreación.
                                        </li>
                                        <li>
                                            Porcentaje de habitantes que practican actividad física.
                                        </li>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include './views/modules/footer.php'; ?>
<script>
    $("#consultaIndicadores").addClass("active");
    $("#consultaODRAF").addClass("active");
</script>
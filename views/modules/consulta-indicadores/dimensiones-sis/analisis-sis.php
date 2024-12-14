<?php include './views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="index.php" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li><a href="consulta-indicadores/dimensiones-sis">Indicadores para la medición del Desarrollo Social</a></li>
        <li class="active"><a href="consulta-indicadores/dimensiones-sis/analisis">Análisis descriptivo de indicadores sociales</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-4" id="wrapper">
        <?php include './views/modules/consulta-indicadores/dimensiones-sis/sidebar-dimensiones-sis.php'; ?>
    </div>
    <div class="col-xs-12 col-sm-8">
        <div id="page-content-wrapper">
            <div id="text-index">
                <h1>Análisis descriptivo de indicadores sociales para Santiago de Cali</h1>
                <hr>
                <p>
                    A continuación se presenta el documento sobre el análisis descriptivo de los indicadores del desarrollo social para Santiago de Cali
                </p>
                <hr>
                <table class="table table-striped table-bordered table-hover table-responsive">
                    <thead style="text-align:center">
                        <tr>
                            <td style="width:70% ;text-align:center; background-color:#215a9a; color:#fff;">Nombre</td>
                            <td style="width:15% ;text-align:center; background-color:#215a9a; color:#fff;">Año</td>
                            <td style="width:15% ;text-align:center; background-color:#215a9a; color:#fff;">Descargar</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Análisis descriptivo de los indicadores del desarrollo social para Santiago de Cali - 2022</td>
                            <td style="text-align:center">2022</td>
                            <td style="text-align:center">
                                <a href="public/SIS/Analisis-descriptivo-indicadores-sociales-2022.pdf" target="_blank">
                                    <i class="fa fa-file-pdf-o" style="font-size:48px;color:red;  "></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Análisis descriptivo de los indicadores del desarrollo social para Santiago de Cali - 2019</td>
                            <td style="text-align:center">2019</td>
                            <td style="text-align:center">
                                <a href="public/SIS/Analisis-descriptivo-indicadores-sociales-2019.pdf" target="_blank">
                                    <i class="fa fa-file-pdf-o" style="font-size:48px;color:red;  "></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr>
            </div>
        </div>
    </div>
</div>
<?php include './views/modules/footer.php'; ?>
<script>
    $("#consulta-indicadores").addClass("active");
    $("#consulta-sis").addClass("active");
    $("#sis-analisis").addClass("back-item-menu");
</script>

<?php include './views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="/index.php" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li><a href="/consulta-indicadores/ods">Objetivos de Desarrollo Sostenible para Santiago de Cali</a></li>
        <li class="active"><a href="/consulta-indicadores/ods/metodologia">Metodología para el seguimiento a indicadores de los ODS para Santiago de Cali</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-4" id="wrapper">
        <?php include './views/modules/consulta-indicadores/ods/sidebar-ods.php'; ?>
    </div>
    <div class="col-xs-12 col-sm-8">
        <div id="page-content-wrapper">
            <div id="text-index">
                <h1>Metodología para el seguimiento a indicadores de los ODS para Santiago de Cali</h1>
                <hr>
                <p>
                    A continuación se presenta el documento sobre la Metodología para el seguimiento a indicadores de los Objetivos de Desarrollo Sostenible - ODS para Santiago de Cali.
                </p>
                <hr>
                <table class="table table-striped table-bordered table-hover table-responsive">
                    <thead style="text-align:center">
                        <tr>
                            <td style="width:80% ;text-align:center; background-color:#3a70ba; color:#fff;">Nombre</td>
                            <td style="width:20% ;text-align:center; background-color:#3a70ba; color:#fff;">Descargar</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Metodología para el seguimiento a indicadores de los Objetivos de Desarrollo Sostenible - ODS para Santiago de Cali</td>
                            <td style="text-align:center">
                                <a href="/public/ODS/Metodologia-seguimiento-ODS-Cali.pdf" target="_blank">
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
    $("#consulta-ods").addClass("active");
    $("#ods-metodologia").addClass("back-item-menu");
</script>
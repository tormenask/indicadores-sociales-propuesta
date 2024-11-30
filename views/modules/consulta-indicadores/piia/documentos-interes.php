<?php include './views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="/" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li><a href="/consulta-indicadores/piia">Indicadores de la Política de Primera Infancia, Infancia y Adolescencia</a></li>
        <li class="active"><a href="/consulta-indicadores/piia/presentacion">Presentación</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-4" id="wrapper">
        <?php include './views/modules/consulta-indicadores/piia/sidebar-piia.php'; ?>
    </div>
    <div class="col-xs-12 col-sm-8">
        <div id="page-content-wrapper">
            <div id="text-index">
                <h1>Documentos de interés, de los Indicadores de la Política de Primera Infancia, Infancia y Adolescencia</h1>
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
                            <td>Ley 1804 del 02 de agosto de 2016, "por la cual se establece la política de Estado para el desarrollo integral de la primera infancia de cero a siempre y se dictan otras disposiciones"</td>
                            <td style="text-align:center">
                                <a href="/public/ODRAF/Ley-1804-del-02-de-agosto-de-2016.pdf" target="_blank">
                                    <i class="fa fa-file-pdf-o" style="font-size:48px;color:red;  "></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Convención sobre los derechos del niño</td>
                            <td style="text-align:center">
                                <a href="/public/ODRAF/Convencion-sobre-derechos-del-niño.pdf" target="_blank">
                                    <i class="fa fa-file-pdf-o" style="font-size:48px;color:red"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Ley 1098 de 2006, por la cual se expide el Código de la Infancia y la Adolescencia.</td>
                            <td style="text-align:center">
                                <a href="/public/ODRAF/Ley-1098-de-2006.pdf" target="_blank">
                                    <i class="fa fa-file-pdf-o" style="font-size:48px;color:red"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Ley 12 de 1991 - Convención Internacional de los Derechos del Niño, "Por medio de la cual se aprueba la Convención sobre los Derechos Del Niño adoptada por la Asamblea General de las Naciones Unidas el 20 de noviembre de 1989</td>
                            <td style="text-align:center">
                                <a href="/public/ODRAF/Ley-12-de-1991-Convencion-Internacional-de-los-Derechos-del-Niño-Colombia.pdf" target="_blank">
                                    <i class="fa fa-file-pdf-o" style="font-size:48px;color:red"></i>
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
    $("#consulta-piia").addClass("active");
    $("#consulta-indicadores").addClass("active");
</script>
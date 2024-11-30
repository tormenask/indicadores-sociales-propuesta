<?php
session_start();
include_once 'model/documento.php';
include_once 'controller/documento.php';
include_once 'model/conjuntoIndicadores.php';
include_once 'controller/conjuntoIndicadores.php';
include_once 'model/rol.php';
include_once 'controller/rol.php';
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$conjunto = new ConjuntoIndicadores();
$idConj = "";
if (isset($_GET['conj'])) {
    $idConj = $_GET['conj'];
}
$conjuntoAct = $conjunto->consultarConjuntoIndicadores($idConj);
$permiso = $rol->consultarPermisoRol("documentos" . $idConj, $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$crear && ($modificar || $eliminar)) {
    header("Location: index.php?action=admin/documentos/gestionDocumentos&conj=" . $idConj);
}
?>
<html>
    <?php include 'view/modules/head.php'; ?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'view/modules/header.php'; ?>
            <?php include 'view/modules/side.php'; ?>
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
                        <div class="btn-group">
                            <a href="index.php?action=admin/documentos/gestionDocumentos&conj=<?php echo $idConj; ?>" class="btn btn-primary" role="button">
                                <i class="fa fa-arrow-left"></i>
                                Volver a Gestión de documentos
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top: 20px;">
                    <div class="col-sm-10 col-sm-offset-1">
                        <form class="form-horizontal" id="formCrearDocumento" enctype="multipart/form-data">
                            <fieldset>
                                <legend class="font-color">Creación de documentos</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="tituloDocumento">Título</label>  
                                    <div class="col-md-6">
                                        <input id="tituloDocumento" name="tituloDocumento" type="text" placeholder="Título del documento" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="descripcionDocumento">Descripción</label>
                                    <div class="col-md-6">
                                        <textarea rows="4" cols="50" id="descripcionDocumento" name="descripcionDocumento" type="text" placeholder="Descripción del documento" class="form-control input-md" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="archivoDocumento">Seleccione un archivo</label>  
                                    <div class="col-md-6">
                                        <input id="archivoDocumento" name="archivoDocumento" type="file" 
                                               accept = ".doc, .docx, .pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/msword, application/pdf, .DOC, .DOCX, .PDF"
                                               placeholder="Seleccione un archivo" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="conjuntoDocumento">Conjunto de indicadores</label>
                                    <div class="col-md-6">
                                        <select id="conjuntoDocumento" name="conjuntoDocumento" class="form-control">
                                            <?php
                                            echo '<option value="' . $conjuntoAct["idConjuntoIndicadores"] . '">' . $conjuntoAct["nombreConjuntoIndicadores"] . '</option>';
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"></label>
                                    <div class="col-md-8">
                                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Registrar</button>
                                        <button type="button" id="btnCancelar" name="btnCancelar" class="btn btn-danger">Limpiar</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-confirm">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header active">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Confirmación</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-content-create"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="modal-btn-si">Si</button>
                                    <button type="button" class="btn btn-default" id="modal-btn-no">No</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-documento-created">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header active">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Creación exitosa</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-content-documento-created"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" id="modal-btn-documento-created-ok">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-form-error">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header active" style="color: #fff !important;background-color: #dd4b39;border-color: #d73925; text-align: center;">
                                    <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" style="color: #fff !important;background-color: #dd4b39;border-color: #d73925; text-align: center;">Error</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-content-error">
                                        Todos los campos son obligatorios.<br>
                                        Verifica la información e intenta nuevamente.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" id="modal-btn-form-error-ok">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'view/modules/footer.php'; ?>
        <script>
            $('#modal-confirm').on('shown.bs.modal', function (e) {
                var tituloDocumentoModal = $("#tituloDocumento").val();
                document.getElementById("modal-content-create").innerHTML = "Confirma la creación del documento <b>" + tituloDocumentoModal + "</b>";
            });
        </script>
        <script>
            $("#btn-confirm").on("click", function () {
                var tituloDocumento = $("#tituloDocumento").val();
                var descripcionDocumento = $("#descripcionDocumento").val();
                var archivoDocumento = $("#archivoDocumento").val();
                var conjuntoDocumento = $("#conjuntoDocumento").val();
                if (tituloDocumento === "" || descripcionDocumento === "" || archivoDocumento === "" || conjuntoDocumento === "") {
                    $("#modal-form-error").modal('show');
                } else {
                    $("#modal-confirm").modal('show');
                }
            });

            $("#modal-btn-form-error-ok").on("click", function () {
                $("#modal-form-error").modal('hide');
            });

            $("#modal-btn-si").on("click", function () {
                crearDocumento();
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-no").on("click", function () {
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-documento-created-ok").on("click", function () {
                $("#modal-documento-created").modal('hide');
                window.location.replace("index.php?action=admin/documentos/gestionDocumentos&conj=<?php echo $idConj; ?>");
            });
        </script>
        <script>
            var conjunto = "#documentos" + "<?php echo $idConj; ?>";
            $(conjunto).addClass("active");
            $("#documentos").addClass("active");
        </script>
        <script>
            function crearDocumento() {
                var tituloDocumento = $("#tituloDocumento").val();
                var descripcionDocumento = $("#descripcionDocumento").val();
                var archivoDocumento = $("#archivoDocumento").files;
                var conjuntoDocumento = $("#conjuntoDocumento").val();

                if (tituloDocumento === "" || descripcionDocumento === "" || archivoDocumento === "" || conjuntoDocumento === "") {
                    $("#modal-form-error").modal('show');
                } else {
                    var url = "view/modules/admin/documentos/funcionesDocumentos.php";
                    var data = new FormData();
                    data.append("tituloDocumento", tituloDocumento);
                    data.append("descripcionDocumento", descripcionDocumento);
                    jQuery.each($('input[type=file]')[0].files, function (i, file) {
                        if (file["size"] > 2000000) {
                            document.getElementById("modal-content-error").innerHTML = "Error al crear el documento <b>" + tituloDocumento + "</b>.<br> El archivo excede el peso máximo de 2 Mb.<br>Intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        } else {
                            data.append('archivoDocumento', file);
                        }
                    });

                    data.append("conjuntoDocumento", conjuntoDocumento);
                    $.ajax({
                        url: url,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function (resp) {
                            $("#formCrearDocumento")[0].reset();
                            if (resp === "Creado") {
                                document.getElementById("modal-content-documento-created").innerHTML = "El documento <b>" + tituloDocumento + "</b> ha sido creado correctamente.";
                                $("#modal-documento-created").modal('show');
                            } else if (resp === "Error al crear") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear el documento <b>" + tituloDocumento + "</b>.<br>Intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Extension invalida") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear el documento <b>" + tituloDocumento + "</b>.<br> El archivo debe tener la extensión .DOC, .DOCX o .PDF. Otros archivos no son permitidos.<br>Intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Excede tamaño") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear el documento <b>" + tituloDocumento + "</b>.<br> El archivo excede el peso máximo de 2 Mb.<br>Intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Id conjunto no existe") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear el documento <b>" + tituloDocumento + "</b>.<br>\n\
                                    No existe el id del conjunto seleccionado.<br> Verifique la información e intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            }
                            console.log(resp);
                        }
                    });
                }
            }
        </script>
        <script>
            $("#btnCancelar").click(function (event) {
                $("#formCrearDimension")[0].reset();
            });
        </script>
        <script>
            $(function () {
                $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
            });
        </script>
    </body>
</html>

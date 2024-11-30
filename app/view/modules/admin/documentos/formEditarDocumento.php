<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/documentos/gestionDocumentos&conj=<?php echo $idConjuntoDocumento; ?>" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de documentos
            </a>
        </div>
    </div>
</div>

<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEditarDocumento" enctype="multipart/form-data">
            <fieldset>
                <legend class="font-color">Editar documento</legend>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="idDocumento">Id</label>  
                    <div class="col-md-6">
                        <input id="idDocumento" name="idDocumento" type="text" placeholder="Id del documento" class="form-control input-md" required="" disabled
                               value="<?php echo $respEditarDocumento["idDocumento"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="archivoDocumentoActual">Archivo actual</label>  
                    <div class="col-md-6">
                        <?php
                        $spl = explode("controller/documentos/" . $idConjuntoDocumento . "/", $respEditarDocumento["archivoDocumento"]);
                        ?>
                        <input id="archivoDocumentoActual" name="archivoDocumentoActual" type="text" placeholder="Archivo actual" class="form-control input-md" required="" disabled
                               value="<?php echo $spl[1]; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="tituloDocumento">Título</label>  
                    <div class="col-md-6">
                        <input id="tituloDocumento" name="tituloDocumento" type="text" placeholder="Título del documento" class="form-control input-md" required=""
                               value="<?php echo $respEditarDocumento["tituloDocumento"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="descripcionDocumento">Descripción</label>
                    <div class="col-md-6">
                        <textarea rows="4" cols="50" id="descripcionDocumento" name="descripcionDocumento" type="text" placeholder="Descripción del documento" class="form-control input-md" required=""><?php echo $respEditarDocumento["descripcionDocumento"] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="archivoDocumentoNuevo">Seleccione un archivo</label>  
                    <div class="col-md-6">
                        <input id="archivoDocumentoNuevo" name="archivoDocumentoNuevo" type="file" placeholder="Seleccione un archivo" class="form-control input-md" 
                               >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="conjuntoDocumento">Conjunto de indicadores</label>
                    <div class="col-md-6">
                        <select id="conjuntoDocumento" name="conjuntoDocumento" class="form-control" disabled>
                            <?php
                            $conjuntoEd = new ConjuntoIndicadoresController();
                            $conjuntoEd->listarConjuntosEditar($respEditarDocumento["idConjuntoIndicadores"]);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Editar</button>
                        <button type="button" id="btnCancelar" name="btnCancelar" class="btn btn-danger">Cancelar</button>
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
                    <p id="modal-content-edited"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="modal-btn-si">Si</button>
                    <button type="button" class="btn btn-default" id="modal-btn-no">No</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-documento-edited">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >Edición exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-documento-edited"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-documento-edited-ok">Aceptar</button>
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
<script>
    $('#modal-confirm').on('shown.bs.modal', function (e) {
        var tituloDocumentoModal = $("#tituloDocumento").val();
        document.getElementById("modal-content-edited").innerHTML = "Confirma la edición del documento <b>" + tituloDocumentoModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idDocumento = $("#idDocumento").val();
        var tituloDocumento = $("#tituloDocumento").val();
        var descripcionDocumento = $("#descripcionDocumento").val();
        var archivoDocumento = $("#archivoDocumentoActual").val();
        var conjuntoDocumento = $("#conjuntoDocumento").val();
        var cumpleTam = "";
        jQuery.each($('input[type=file]')[0].files, function (i, file) {
            if (file["size"] > 0 && file["size"] > 2000000) {
                cumpleTam = false;
            } else {
                cumpleTam = true;
            }
            console.log(file["size"]);
        });
        if (idDocumento === "" || tituloDocumento === "" || descripcionDocumento === "" || archivoDocumento === "" || conjuntoDocumento === "") {
            $("#modal-form-error").modal('show');
        }
        if (cumpleTam === false) {
            document.getElementById("modal-content-error").innerHTML = "Error al editar el documento <b>" + tituloDocumento + "</b>.<br> El archivo excede el peso máximo de 2 Mb.<br>Intente nuevamente.";
            $("#modal-form-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });
    $("#modal-btn-form-error-ok").on("click", function () {
        $("#modal-form-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        editarDocumento();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-documento-edited-ok").on("click", function () {
        $("#modal-documento-edited").modal('hide');
        window.location.replace("index.php?action=admin/documentos/gestionDocumentos&conj=<?php echo $idConjuntoDocumento; ?>");
    });</script>
<script>
    function editarDocumento() {
        var idDocumento = $("#idDocumento").val();
        var tituloDocumento = $("#tituloDocumento").val();
        var descripcionDocumento = $("#descripcionDocumento").val();
//        var archivoDocumento = $("#archivoDocumentoActual").val();
//        var archivoDocumentoNuevo = $("#archivoDocumento").files;
        var conjuntoDocumento = $("#conjuntoDocumento").val();
        if (idDocumento === "" || tituloDocumento === "" || descripcionDocumento === "" || conjuntoDocumento === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/documentos/funcionesDocumentos.php";
            var data = new FormData();
            data.append("idDocumentoEd", idDocumento);
            data.append("tituloDocumentoEd", tituloDocumento);
            data.append("descripcionDocumentoEd", descripcionDocumento);
//            data.append('archivoDocumentoEd', archivoDocumento);
//            console.log(archivoDocumentoNuevo);
//            if (archivoDocumentoNuevo !== "" || archivoDocumentoNuevo !== "undefined" || archivoDocumentoNuevo !== undefined) {
//                console.log("file true");
            var archivoDocumentoNuevo = document.getElementById('archivoDocumentoNuevo');
            var uploadFile = archivoDocumentoNuevo.files[0];
            if (archivoDocumentoNuevo.files.length !== 0) {
                jQuery.each($('input[type=file]')[0].files, function (i, file) {
                    data.append('file', true);
                    data.append('archivoDocumentoNuevoEd', uploadFile);
                });
            } else {
                console.log("file false");
                data.append('file', false);
            }
            data.append("conjuntoDocumentoEd", conjuntoDocumento);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Editado") {
                        document.getElementById("modal-content-documento-edited").innerHTML = "El documento <b>" + tituloDocumento + "</b> ha sido editado correctamente.";
                        $("#modal-documento-edited").modal('show');
                    } else if (resp === "Error al editar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar el documento <b>" + tituloDocumento + "</b>.<br>Intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Extension invalida") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar el documento <b>" + tituloDocumento + "</b>.<br> El archivo debe tener la extensión .DOC, .DOCX o .PDF. Otros archivos no son permitidos.<br>Intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Excede tamaño") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar el documento <b>" + tituloDocumento + "</b>.<br> El archivo excede el peso máximo de 2 Mb.<br>Intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id conjunto no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar el documento <b>" + tit + "</b>.<br>\n\
                                    No existe un conjunto de indicadores con el Id ingresado.<br> Verifique la información e intente nuevamente.";
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
        window.location.replace("index.php?action=admin/documentos/gestionDocumentos&conj=" + "<?php echo $idConjuntoDocumento; ?>");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });</script>
<script>
    $("#documentos").addClass("active");
    var conjunto = "#documentos" + "<?php echo $idConjuntoDocumento; ?>";
    $(conjunto).addClass("active");
</script>


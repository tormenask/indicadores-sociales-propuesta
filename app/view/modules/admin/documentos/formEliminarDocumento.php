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
        <form class="form-horizontal" id="formEliminarDocumento">
            <fieldset>
                <legend class="font-color">Eliminar documento</legend>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="idDocumento">Id</label>  
                    <div class="col-md-6">
                        <input id="idDocumento" name="idDocumento" type="text" placeholder="Id del documento" class="form-control input-md" required="" disabled
                               value="<?php echo $respEliminarDocumento["idDocumento"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="archivoDocumentoActual">Archivo actual</label>  
                    <div class="col-md-6">
                        <?php
                        $spl = explode("controller/documentos/" . $idConjuntoDocumento . "/", $respEliminarDocumento["archivoDocumento"]);
                        ?>
                        <input id="archivoDocumentoActual" name="archivoDocumentoActual" type="text" placeholder="Archivo actual" class="form-control input-md" required="" disabled
                               value="<?php echo $spl[1]; ?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="tituloDocumento">Título</label>  
                    <div class="col-md-6">
                        <input id="tituloDocumento" name="tituloDocumento" type="text" placeholder="Título del documento" class="form-control input-md" required=""
                               value="<?php echo $respEliminarDocumento["tituloDocumento"] ?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="descripcionDocumento">Descripción</label>
                    <div class="col-md-6">
                        <textarea rows="4" cols="50" id="descripcionDocumento" name="descripcionDocumento" type="text" placeholder="Descripción del documento" class="form-control input-md" required="" disabled><?php echo $respEliminarDocumento["descripcionDocumento"] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="conjuntoDocumento">Conjunto de indicadores</label>
                    <div class="col-md-6">
                        <select id="conjuntoDocumento" name="conjuntoDocumento" class="form-control" disabled>
                            <?php
                            $conjuntoEd = new ConjuntoIndicadoresController();
                            $conjuntoEd->listarConjuntosEditar($respEliminarDocumento["idConjuntoIndicadores"]);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Eliminar documento</button>
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
                    <p id="modal-content-confirm"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="modal-btn-si">Si</button>
                    <button type="button" class="btn btn-default" id="modal-btn-no">No</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-documento-deleted">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminación exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-documento-deleted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-documento-deleted-ok">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-error">
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
                    <button type="button" class="btn btn-default" id="modal-btn-error-ok">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#modal-confirm').on('shown.bs.modal', function (e) {
        var tituloDocumentoModal = $("#tituloDocumento").val();
        document.getElementById("modal-content-confirm").innerHTML = "Realmente desea eliminar el documento <b>" + tituloDocumentoModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idDocumento = $("#idDocumento").val();
        if (idDocumento === "") {
            $("#modal-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });
    $("#modal-btn-error-ok").on("click", function () {
        $("#modal-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        eliminarDocumento();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-documento-deleted-ok").on("click", function () {
        $("#modal-documento-deleted").modal('hide');
        window.location.replace("index.php?action=admin/documentos/gestionDocumentos&conj=<?php echo $idConjuntoDocumento; ?>");
    });
</script>
<script>
    function eliminarDocumento() {
        var tituloDocumento = $("#tituloDocumento").val();
        var idDocumento = $("#idDocumento").val();
        if (idDocumento === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/documentos/funcionesDocumentos.php";
            var data = new FormData();
            data.append("idDocumentoEl", idDocumento);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Eliminado") {
                        document.getElementById("modal-content-documento-deleted").innerHTML = "El documento <b>" + tituloDocumento + "</b> ha sido eliminado correctamente.";
                        $("#modal-documento-deleted").modal('show');
                    } else if (resp === "1451") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el documento <b>" + tituloDocumento + "</b>.<br>Existe al menos un elemento asociado a este documento. <br>Verifique la información e intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Error al eliminar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el documento <b>" + tituloDocumento + "</b>.<br>Intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Id documento no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el documento <b>" + tituloDocumento + "</b>.<br>\n\
                                    No existe un documento con el id <b>" + idDocumento + "</b>.<br> Verifique la información e intente nuevamente.";
                        $("#modal-error").modal('show');
                    }
                    console.log(resp);
                }
            });
        }
    }
</script>
<script>
    $("#btnCancelar").click(function (event) {
        window.location.replace("index.php?action=admin/documentos/gestionDocumentos&conj=<?php echo $idConjuntoDocumento; ?>");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#documentos").addClass("active");
    var conjunto = "#documentos" + "<?php echo $idConjuntoDocumento; ?>";
    $(conjunto).addClass("active");
</script>


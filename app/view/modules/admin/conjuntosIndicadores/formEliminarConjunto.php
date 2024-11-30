<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/conjuntosIndicadores/gestionConjuntosIndicadores" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de Conjuntos de Indicadores
            </a>
        </div>
    </div>
</div>

<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEliminarConjunto">
            <fieldset>
                <legend class="font-color">Eliminar conjunto de indicadores</legend>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="idConjunto">Id</label>  
                    <div class="col-md-6">
                        <input id="idConjunto" name="idConjunto" type="text" placeholder="Id del conjunto de indicadores" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarConjunto["idConjuntoIndicadores"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nombreConjunto">Nombre</label>  
                    <div class="col-md-6">
                        <input id="nombreConjunto" name="nombreConjunto" type="text" placeholder="Nombre del conjunto" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarConjunto["nombreConjuntoIndicadores"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="descripcionConjunto">Descripción</label>  
                    <div class="col-md-6">
                        <textarea id="descripcionConjunto" readonly name="descripcionConjunto" placeholder="Descripción del conjunto" class="form-control" required><?php echo $respEliminarConjunto["descripcionConjuntoIndicadores"] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="organismoConjunto">Organismo</label>
                    <div class="col-md-6">
                        <select id="organismoConjunto" name="organismoConjunto" class="form-control" readonly disabled>
                            <?php
                            $organismoEd = new OrganismoController();
                            $organismoEd->listarOrganismosEditar($respEliminarConjunto["idOrganismoConjuntoIndicadores"]);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Eliminar conjunto</button>
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-set-deleted">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Eliminación exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-set-deleted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-set-deleted-ok">Aceptar</button>
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
        var nombreConjuntoModal = $("#nombreConjunto").val();
        document.getElementById("modal-content-confirm").innerHTML = "Realmente desea eliminar el conjunto <b>" + nombreConjuntoModal +"</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idConjunto = $("#idConjunto");
        if (idConjunto === "") {
            $("#modal-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });
    $("#modal-btn-error-ok").on("click", function () {
        $("#modal-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        eliminarConjunto();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-set-deleted-ok").on("click", function () {
        $("#modal-set-deleted").modal('hide');
        window.location.replace("index.php?action=admin/conjuntosIndicadores/gestionConjuntosIndicadores");
    });
</script>
<script>
    function eliminarConjunto() {
        var nombreConjunto = $("#nombreConjunto").val();
        var idConjunto = "<?php echo $respEliminarConjunto["idConjuntoIndicadores"] ?>";
        var idConjunto2 = $("#idConjunto").val();
        if (idConjunto === "" || idConjunto2 === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/conjuntosIndicadores/funcionesConjuntos.php";
            var data = new FormData();
            data.append("idConjuntoEl", idConjunto2);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Eliminado") {
                        document.getElementById("modal-content-set-deleted").innerHTML = "El conjunto <b>" + nombreConjunto + "</b> ha sido eliminado correctamente.";
                        $("#modal-set-deleted").modal('show');
                    } else if (resp === "1451") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el conjunto <b>" + nombreConjunto + "</b>.<br>Existe al menos una dimensión con este conjunto asignado. <br>Verifique la información e intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Error al eliminar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el conjunto <b>" + nombreConjunto + "</b>.<br>Intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Id no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el conjunto <b>" + nombreConjunto + "<b>.<br>\n\
                                    No existe un conjunto con el id <b>" + idConjunto + "<b>.<br> Verifique la información e intente nuevamente.";
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
        window.location.replace("index.php?action=admin/conjuntosIndicadores/gestionConjuntosIndicadores");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#conjuntosIndicadores").addClass("active");
</script>
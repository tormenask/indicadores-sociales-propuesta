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
        <form class="form-horizontal" id="formCrearConjunto">
            <fieldset>
                <legend class="font-color">Editar conjunto de indicadores</legend>
                <div class="form-group control-group">
                    <label class="col-md-4 control-label" for="idConjunto">Id</label>  
                    <div class="col-md-6">
                        <div class="controls">
                            <input id="idConjunto" name="idConjunto" type="text" 
                                   placeholder="Id del conjunto de indicadores" class="form-control input-md" 
                                   data-validation-minlength-message="Id inválido. Debe tener mínimo 3 caracteres." 
                                   minlength="3" required readonly value="<?php echo $respEditarConjunto["idConjuntoIndicadores"] ?>">
                            <p class="help-block" id="error-id" style="color: #a94442;"></p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nombreConjunto">Nombre</label>
                    <div class="col-md-6">
                        <input id="nombreConjunto" name="nombreConjunto" type="text" placeholder="Nombre del conjunto de indicadores" class="form-control input-md" required
                               value="<?php echo $respEditarConjunto["nombreConjuntoIndicadores"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="descripcionConjunto">Descripción</label>  
                    <div class="col-md-6">
                        <textarea id="descripcionConjunto" name="descripcionConjunto" placeholder="Descripción del conjunto de indicadores" class="form-control" required><?php echo $respEditarConjunto["descripcionConjuntoIndicadores"] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="organismoConjunto">Organismo</label>
                    <div class="col-md-6">
                        <select id="organismoConjunto" name="organismoConjunto" class="form-control">
                            <?php
                            $organismo = new OrganismoController();
                            $organismo->listarOrganismosEditar($respEditarConjunto["idOrganismoConjuntoIndicadores"]);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Guardar cambios</button>
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
                    <p id="modal-content-create"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="modal-btn-si">Si</button>
                    <button type="button" class="btn btn-default" id="modal-btn-no">No</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-set-created">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edición exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-set-created"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-set-created-ok">Aceptar</button>
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-form-error-validation">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active" style="color: #fff !important;background-color: #dd4b39;border-color: #d73925; text-align: center;">
                    <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="color: #fff !important;background-color: #dd4b39;border-color: #d73925; text-align: center;">Error</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-error-validation"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-form-error-validation-ok">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#modal-confirm').on('shown.bs.modal', function (e) {
        var nombreConjuntoModal = $("#nombreConjunto").val();
        document.getElementById("modal-content-create").innerHTML = "Confirma la edición del conjunto <b>" + nombreConjuntoModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idConjunto = $("#idConjunto").val();
        var nombreConjunto = $("#nombreConjunto").val();
        var descripcionConjunto = $("#descripcionConjunto").val();
        var organismoConjunto = $("#organismoConjunto").val();
        var errorId = $("#error-id").text();
        if (idConjunto === "" || nombreConjunto === "" || descripcionConjunto === "" || organismoConjunto === "") {
            $("#modal-form-error").modal('show');
        } else if (errorId !== "") {
            var mensaje = "Existen campos con errores:<br>";
            mensaje = mensaje + errorId;
            document.getElementById("modal-content-error").innerHTML = mensaje;
            $("#modal-form-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });

    $("#modal-btn-form-error-ok").on("click", function () {
        $("#modal-form-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        editarConjunto();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-set-created-ok").on("click", function () {
        $("#modal-set-created").modal('hide');
        window.location.replace("index.php?action=admin/conjuntosIndicadores/gestionConjuntosIndicadores");
    });
</script>
<script>
    function editarConjunto() {
        var idConjunto = $("#idConjunto").val();
        var nombreConjunto = $("#nombreConjunto").val();
        var descripcionConjunto = $("#descripcionConjunto").val();
        var organismoConjunto = $("#organismoConjunto").val();
        var errorId = $("#error-id").text();
        if (idConjunto === "" || nombreConjunto === "" || descripcionConjunto === "" || organismoConjunto === "") {
            $("#modal-form-error").modal('show');
        } else if (errorId !== "") {
            var mensaje = "Existen campos con errores:<br>";
            mensaje = mensaje + errorId;
            document.getElementById("modal-content-error").innerHTML = mensaje;
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/conjuntosIndicadores/funcionesConjuntos.php";
            var data = new FormData();
            data.append("idConjuntoEd", idConjunto);
            data.append("nombreConjuntoEd", nombreConjunto);
            data.append("descripcionConjuntoEd", descripcionConjunto);
            data.append("idOrganismoConjuntoEd", organismoConjunto);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Editado") {
                        document.getElementById("modal-content-set-created").innerHTML = "El conjunto <b>" + nombreConjunto + "</b> ha sido editado correctamente.";
                        $("#modal-set-created").modal('show');
                    } else if (resp === "Error al editar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar el conjunto <b>" + nombreConjunto + "</b>.<br>Intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar el conjunto <b>" + nombreConjunto + "</b>.<br>\n\
                                    El id </b>" + idConjunto + "</b> no existe.<br> Verifique la información e intente nuevamente.";
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


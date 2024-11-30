<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/organismos/gestionOrganismos" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de Organismos
            </a>
        </div>
    </div>
</div>
<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEditarOrganismo">
            <fieldset>
                <legend class="font-color">Editar organismo</legend>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="idOrganismo">Id</label>
                    <div class="col-md-6">
                        <input id="idOrganismo" name="idOrganismo" type="text" placeholder="Id del organismo" class="form-control input-md" required
                               value="<?php echo $respEditarOrganismo["idOrganismo"] ?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nombreOrganismo">Nombre</label>
                    <div class="col-md-6">
                        <input id="nombreOrganismo" name="nombreOrganismo" type="text" placeholder="Nombre del organismo" class="form-control input-md" required
                               value="<?php echo $respEditarOrganismo["nombreOrganismo"] ?>">
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
                    <p id="modal-content-edited"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="modal-btn-si">Si</button>
                    <button type="button" class="btn btn-default" id="modal-btn-no">No</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-organismo-edited">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edición exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-organismo-edited"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-organismo-edited-ok">Aceptar</button>
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
        var nombreOrganismoModal = $("#nombreOrganismo").val();
        document.getElementById("modal-content-edited").innerHTML = "Confirma la edición del organismo <b>" + nombreOrganismoModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idOrganismo = $("#idOrganismo").val();
        var nombreOrganismo = $("#nombreOrganismo").val();
        if (idOrganismo === "" || nombreOrganismo === "" ) {
            $("#modal-form-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });

    $("#modal-btn-form-error-ok").on("click", function () {
        $("#modal-form-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        editarOrganismo();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-organismo-edited-ok").on("click", function () {
        $("#modal-organismo-edited").modal('hide');
        window.location.replace("index.php?action=admin/organismos/gestionOrganismos");
    });
</script>
<script>
    function editarOrganismo() {
        var idOrganismo = $("#idOrganismo").val();
        var nombreOrganismo = $("#nombreOrganismo").val();
        var descripcionEstado = $("#descripcionEstado").val();
        if (idOrganismo === "" || nombreOrganismo === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/organismos/funcionesOrganismos.php";
            var data = new FormData();
            data.append("idOrganismoEd", idOrganismo);
            data.append("nombreOrganismoEd", nombreOrganismo);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Editado") {
                        document.getElementById("modal-content-organismo-edited").innerHTML = "El organismo <b>" + nombreOrganismo + "</b> ha sido editado correctamente.";
                        $("#modal-organismo-edited").modal('show');
                    } else if (resp === "Error al editar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar el organismo <b>" + nombreOrganismo + "</b>.<br>Intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Nombre en uso") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar el organismo <b>" + nombreOrganismo + "</b>.<br>\n\
                                    Ya existe un organismo con el nombre ingresado.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar el organismo <b>" + nombreOrganismo + "</b>.<br>\n\
                                    El id </b>" + idOrganismo + "</b> no existe.<br> Verifique la información e intente nuevamente.";
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
        window.location.replace("index.php?action=admin/organismos/gestionOrganismos");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#organismos").addClass("active");
</script>


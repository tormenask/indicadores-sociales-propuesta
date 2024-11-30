<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/roles/gestionRoles" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de Roles
            </a>
        </div>
    </div>
</div>

<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEliminarRol">
            <fieldset>
                <legend class="font-color">Eliminar rol</legend>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="idRol">Id</label>  
                    <div class="col-md-6">
                        <input id="idRol" name="idRol" type="text" placeholder="Id del rol" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarRol["idRol"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nombreRol">Nombre</label>  
                    <div class="col-md-6">
                        <input id="nombreRol" name="nombreRol" type="text" placeholder="Nombre del rol" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarRol["nombreRol"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="descripcionRol">Descripción</label>  
                    <div class="col-md-6">
                        <textarea id="descripcionRol" readonly name="descripcionRol" placeholder="Descripción del rol" class="form-control" required><?php echo $respEliminarRol["descripcionRol"] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Eliminar rol</button>
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-role-deleted">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Eliminación exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-role-deleted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-role-deleted-ok">Aceptar</button>
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
        var nombreRolModal = $("#nombreRol").val();
        document.getElementById("modal-content-confirm").innerHTML = "Realmente desea eliminar el rol <b>" + nombreRolModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idRol = $("#idRol");
        if (idRol === "") {
            $("#modal-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });
    $("#modal-btn-error-ok").on("click", function () {
        $("#modal-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        eliminarRol();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-role-deleted-ok").on("click", function () {
        $("#modal-role-deleted").modal('hide');
        window.location.replace("index.php?action=admin/roles/gestionRoles");
    });
</script>
<script>
    function eliminarRol() {
        var nombreRol = $("#nombreRol").val();
        var idRol = "<?php echo $respEliminarRol["idRol"] ?>";
        var idRol2 = $("#idRol").val();
        if (idRol === "" || idRol2 === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/roles/funcionesRoles.php";
            var data = new FormData();
            data.append("idRolEl", idRol2);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Eliminado") {
                        document.getElementById("modal-content-role-deleted").innerHTML = "El rol <b>" + nombreRol + "</b> ha sido eliminado correctamente.";
                        $("#modal-role-deleted").modal('show');
                    } else if (resp === "1451") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el rol <b>" + nombreRol + "</b>.<br>Existe un usuario con este rol asignado. <br>Verifique la información e intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Error al eliminar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el rol <b>" + nombreRol + "</b>.<br>Intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Id no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el rol <b>" + nombreRol + "</b>.<br>\n\
                                    No existe un rol con el id <b>" + idRol2 + "</b>.<br> Verifique la información e intente nuevamente.";
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
        window.location.replace("index.php?action=admin/roles/gestionRoles");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#roles").addClass("active");
</script>


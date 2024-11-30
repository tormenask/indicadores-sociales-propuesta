<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/usuarios/gestionUsuarios" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de Usuarios
            </a>
        </div>
    </div>
</div>

<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEliminarUsuario">
            <fieldset>
                <legend class="font-color">Eliminar usuario</legend>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nombreUsuario">Nombre</label>  
                    <div class="col-md-6">
                        <input id="nombreUsuario" name="nombreUsuario" type="text" placeholder="Nombre del usuario" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarUsuario["nombre"] ?>">
                    </div>
                </div>
                <div class="form-group control-group">
                    <label class="col-md-4 control-label" for="identificacionUsuario">Número de identificación</label>  
                    <div class="col-md-6">
                        <div class="controls">
                            <input id="identificacionUsuario" name="identificacionUsuario" type="text" 
                                   data-validation-number-message="Número de identificación inválido."
                                   placeholder="Número de identificación" class="form-control input-md" required value="<?php echo $respEliminarUsuario["numeroIdentificacion"] ?>" readonly>
                            <p class="help-block" id="error-identificacion" style="color: #a94442;"></p>
                        </div>
                    </div>
                </div>
                <div class="form-group control-group">
                    <label class="col-md-4 control-label" for="correoUsuario">Correo electrónico</label>  
                    <div class="col-md-6">
                        <div class="controls">
                            <input id="correoUsuario" name="correoUsuario" type="email" readonly
                                   placeholder="Correo electrónico" class="form-control input-md" 
                                   data-validation-email-message="Dirección de correo electrónico inválida." required value="<?php echo $respEliminarUsuario["correoElectronico"] ?>">
                            <p class="help-block" id="error-correo" style="color: #a94442;"></p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="organismoUsuario">Organismo</label>
                    <div class="col-md-6">
                        <select id="organismoUsuario" name="organismoUsuario" class="form-control" readonly disabled>
                            <?php
                            $organismoEd = new OrganismoController();
                            $organismoEd->listarOrganismosEditar($respEliminarUsuario["idOrganismo"]);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="vinculacionUsuario">Tipo de vinculación</label>
                    <div class="col-md-6">
                        <select id="vinculacionUsuario" name="vinculacionUsuario" class="form-control" readonly disabled>
                            <option value="Servidor público" 
                            <?php
                            if ($respEliminarUsuario["tipoVinculacion"] == "Servidor público") {
                                echo 'selected';
                            }
                            ?>
                                    >Servidor público</option>
                            <option value="Contratista" 
                            <?php
                            if ($respEliminarUsuario["tipoVinculacion"] == "Contratista") {
                                echo 'selected';
                            }
                            ?>
                                    >Contratista</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="rolUsuario">Rol</label>
                    <div class="col-md-6">
                        <select id="rolUsuario" name="rolUsuario" class="form-control"readonly disabled>
                            <?php
                            $rol = new RolController();
                            $rol->listarRolesEditarUsuario($respEliminarUsuario["idRol"]);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="estadoUsuario">Estado</label>
                    <div class="col-md-6">
                        <select id="estadoUsuario" name="estadoUsuario" class="form-control" readonly disabled>
                            <?php
                            $estado = new EstadoController();
                            $estado->listarEstadosEditarUsuario($respEliminarUsuario["idEstado"]);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Eliminar usuario</button>
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-user-deleted">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Eliminación exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-user-deleted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-user-deleted-ok">Aceptar</button>
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
        var nombreUsuarioModal = $("#nombreUsuario").val();
        document.getElementById("modal-content-confirm").innerHTML = "Realmente desea eliminar el usuario <b>" + nombreUsuarioModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var identificacionUsuario = $("#identificacionUsuario").val();
        if (identificacionUsuario === "") {
            $("#modal-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });
    $("#modal-btn-error-ok").on("click", function () {
        $("#modal-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        eliminarUsuario();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-user-deleted-ok").on("click", function () {
        $("#modal-user-deleted").modal('hide');
        window.location.replace("index.php?action=admin/usuarios/gestionUsuarios");
    });
</script>
<script>
    function eliminarUsuario() {
        var nombreUsuario = $("#nombreUsuario").val();
        var identificacionUsuario = $("#identificacionUsuario").val();
        if (identificacionUsuario === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/usuarios/funcionesUsuarios.php";
            var data = new FormData();
            data.append("identificacionUsuarioEl", identificacionUsuario);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Eliminado") {
                        document.getElementById("modal-content-user-deleted").innerHTML = "El usuario <b>" + nombreUsuario + "</b> ha sido eliminado correctamente.";
                        $("#modal-user-deleted").modal('show');
                    } else if (resp === "Error al eliminar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el usuario <b>" + nombreUsuario + "</b>.<br>Intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Identificación no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el usuario <b>" + nombreUsuario + "</b>.<br>\n\
                                    No existe un usuario con el número de identificación <b>" + identificacionUsuario + "</b>.<br> Verifique la información e intente nuevamente.";
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
        window.location.replace("index.php?action=admin/usuarios/gestionUsuarios");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#usuarios").addClass("active");
    $("#gestionarUsuarios").addClass("active");
</script>


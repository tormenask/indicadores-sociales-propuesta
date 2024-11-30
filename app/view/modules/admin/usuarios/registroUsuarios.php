<?php
session_start();
include_once 'model/crud_usuario.php';
include_once 'controller/usuario.php';
include_once 'model/rol.php';
include_once 'controller/rol.php';
include_once 'model/organismo.php';
include_once 'controller/organismo.php';
include_once 'model/estado.php';
include_once 'controller/estado.php';
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$permiso = $rol->consultarPermisoRol("usuarios", $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$crear && ($modificar || $eliminar)) {
    header("Location: index.php?action=admin/usuarios/gestionUsuarios");
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
                            <a href="index.php?action=admin/usuarios/gestionUsuarios" class="btn btn-primary" role="button">
                                <i class="fa fa-arrow-left"></i>
                                Volver a Gestión de Usuarios
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top: 20px;">
                    <div class="col-sm-10 col-sm-offset-1">
                        <form class="form-horizontal" id="formRegistroUsuario">
                            <fieldset>
                                <legend class="font-color">Registro de usuarios</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="nombreUsuario">Nombre</label>  
                                    <div class="col-md-6">
                                        <input id="nombreUsuario" name="nombreUsuario" type="text" placeholder="Nombre del usuario" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group control-group">
                                    <label class="col-md-4 control-label" for="identificacionUsuario">Número de identificación</label>  
                                    <div class="col-md-6">
                                        <div class="controls">
                                            <input id="identificacionUsuario" name="identificacionUsuario" type="text" 
                                                   data-validation-number-message="Número de identificación inválido."
                                                   placeholder="Número de identificación (no mayor a 11 digitos)" class="form-control input-md" required>
                                            <p class="help-block" id="error-identificacion" style="color: #a94442;"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="generoUsuario">Género</label>
                                    <div class="col-md-6">
                                        <select id="generoUsuario" name="generoUsuario" class="form-control">
                                            <option value="Femenino">Femenino</option>
                                            <option value="Masculino">Masculino</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group control-group">
                                    <label class="col-md-4 control-label" for="correoUsuario">Correo electrónico</label>  
                                    <div class="col-md-6">
                                        <div class="controls">
                                            <input id="correoUsuario" name="correoUsuario" type="email" 
                                                   placeholder="Correo electrónico" class="form-control input-md" 
                                                   data-validation-email-message="Dirección de correo electrónico inválida." required >
                                            <p class="help-block" id="error-correo" style="color: #a94442;"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="organismoUsuario">Organismo</label>
                                    <div class="col-md-6">
                                        <select id="organismoUsuario" name="organismoUsuario" class="form-control">
                                            <?php
                                            $organismo = new OrganismoController();
                                            $organismo->listarOrganismosCrear();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="vinculacionUsuario">Tipo de vinculación</label>
                                    <div class="col-md-6">
                                        <select id="vinculacionUsuario" name="vinculacionUsuario" class="form-control">
                                            <option value="Servidor público">Servidor público</option>
                                            <option value="Contratista">Contratista</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group control-group">
                                    <label class="col-md-4 control-label" for="contrasenaUsuario">Contraseña</label>  
                                    <div class="col-md-6">
                                        <div class="controls">
                                            <input id="contrasenaUsuario" name="contrasenaUsuario" type="password" placeholder="Contraseña" class="form-control input-md" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="rolUsuario">Rol</label>
                                    <div class="col-md-6">
                                        <select id="rolUsuario" name="rolUsuario" class="form-control">
                                            <?php
                                            $rolC = new RolController();
                                            $rolC->listarRolesCrearUsuario();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="estadoUsuario">Estado</label>
                                    <div class="col-md-6">
                                        <select id="estadoUsuario" name="estadoUsuario" class="form-control">
                                            <?php
                                            $estado = new EstadoController();
                                            $estado->listarEstadosCrearUsuario();
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
                                <div id="mensajeCrearUsuario" hidden></div>

                                <div id="errorCamposFormCrearUsuario" hidden>
                                    <div class='alert alert-danger alert-dismissible'>
                                        <strong>Error.</strong> <br>
                                        Todos los campos son obligatorios. <br>
                                        Verifique los datos e intente nuevamente.
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-confirm">
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
                    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-user-created">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header active">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Creación exitosa</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-content-user-created"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" id="modal-btn-user-created-ok">Aceptar</button>
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
            </div>
        </div>
        <?php include 'view/modules/footer.php'; ?>
        <script>
            $('#modal-confirm').on('shown.bs.modal', function (e) {
                var nombreUsuarioModal = $("#nombreUsuario").val();
                document.getElementById("modal-content-create").innerHTML = "Confirma la creación del usuario <b>" + nombreUsuarioModal + "</b>";
            });
        </script>
        <script>
            $("#btn-confirm").on("click", function () {
                var errorIdentificacion = $("#error-identificacion").text();
                var errorCorreo = $("#error-correo").text();
                var nombreUsuario = $("#nombreUsuario").val();
                var generoUsuario = $("#generoUsuario").val();
                var correoUsuario = $("#correoUsuario").val();
                var organismoUsuario = $("#organismoUsuario").val();
                var vinculacionUsuario = $("#vinculacionUsuario").val();
                var identificacionUsuario = $("#identificacionUsuario").val();
                var contrasenaUsuario = $("#contrasenaUsuario").val();
                var idRolUsuario = $("#rolUsuario").val();
                var estadoUsuario = $("#estadoUsuario").val();
                if (nombreUsuario === "" || correoUsuario === "" || generoUsuario === "" ||
                        organismoUsuario === "" || vinculacionUsuario === "" ||
                        identificacionUsuario === "" || contrasenaUsuario === "" || idRolUsuario === "" || estadoUsuario === "") {
                    $("#modal-form-error").modal('show');
                } else if (errorIdentificacion !== "" || errorCorreo !== "") {
                    var mensaje = "Existen campos con errores:<br>";
                    if (errorIdentificacion !== "") {
                        mensaje = mensaje + errorIdentificacion + "<br>";
                    }
                    if (errorCorreo !== "") {
                        mensaje = mensaje + errorCorreo + "<br>";
                    }
                    document.getElementById("modal-content-error-validation").innerHTML = mensaje;
                    $("#modal-form-error-validation").modal('show');
                } else {
                    $("#modal-confirm").modal('show');
                }
            });

            $("#modal-btn-form-error-ok").on("click", function () {
                $("#modal-form-error").modal('hide');
            });
            $("#modal-btn-form-error-validation-ok").on("click", function () {
                $("#modal-form-error-validation").modal('hide');
            });
            $("#modal-btn-si").on("click", function () {
                registrarUsuario();
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-no").on("click", function () {
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-user-created-ok").on("click", function () {
                $("#modal-user-created").modal('hide');
                window.location.replace("index.php?action=admin/usuarios/gestionUsuarios");
            });
        </script>
        <script>
            $("#usuarios").addClass("active");
        </script>
        <script>
            function registrarUsuario() {
                var nombreUsuario = $("#nombreUsuario").val();
                var generoUsuario = $("#generoUsuario").val();
                var correoUsuario = $("#correoUsuario").val();
                var organismoUsuario = $("#organismoUsuario").val();
                var vinculacionUsuario = $("#vinculacionUsuario").val();
                var identificacionUsuario = $("#identificacionUsuario").val();
                var contrasenaUsuario = $("#contrasenaUsuario").val();
                var idRolUsuario = $("#rolUsuario").val();
                var estadoUsuario = $("#estadoUsuario").val();
                if (nombreUsuario === "" || generoUsuario === "" || correoUsuario === "" ||
                        organismoUsuario === "" || vinculacionUsuario === "" ||
                        identificacionUsuario === "" || contrasenaUsuario === "" || idRolUsuario === "" || estadoUsuario === "") {
                    $("#modal-form-error").modal('show');
                } else {
                    var url = "view/modules/admin/usuarios/funcionesUsuarios.php";
                    var data = new FormData();
                    data.append("nombreUsuario", nombreUsuario);
                    data.append("generoUsuario", generoUsuario);
                    data.append("correoUsuario", correoUsuario);
                    data.append("organismoUsuario", organismoUsuario);
                    data.append("vinculacionUsuario", vinculacionUsuario);
                    data.append("identificacionUsuario", identificacionUsuario);
                    data.append("contrasenaUsuario", contrasenaUsuario);
                    data.append("idRolUsuario", idRolUsuario);
                    data.append("estadoUsuario", estadoUsuario);
                    $.ajax({
                        url: url,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function (resp) {
                            $("#formRegistroUsuario")[0].reset();
                            if (resp === "Creado") {
                                document.getElementById("modal-content-user-created").innerHTML = "El usuario <b>" + nombreUsuario + "</b> ha sido creado correctamente.";
                                $("#modal-user-created").modal('show');
                            } else if (resp === "Error al crear") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear el usuario <b>" + nombreUsuario + "</b>.<br>Intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Identificación existe") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear el usuario <b>" + nombreUsuario + "</b>.<br>\n\
                                    Ya existe un usuario con el número de identificación <b>" + identificacionUsuario + "</b>.<br> Verifique la información e intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Correo electrónico existe") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear el usuario <b>" + nombreUsuario + "<b>.<br>\n\
                                    Ya existe un usuario con el correo electrónico <b>" + correoUsuario + "</b>.<br> Verifique la información e intente nuevamente.";
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
                $("#formRegistroUsuario")[0].reset();
            });
        </script>
        <script>
            $(function () {
                $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
            });
        </script>
    </body>
</html>

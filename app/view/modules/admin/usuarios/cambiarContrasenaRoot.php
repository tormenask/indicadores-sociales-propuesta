<?php
include_once 'model/crud_usuario.php';
include_once 'controller/usuario.php';
include_once 'model/rol.php';
include_once 'model/organismo.php';
include_once 'model/estado.php';
include_once 'controller/rol.php';
session_start();
$correoElectronico = $_SESSION['userData']['correoElectronico'];
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$permiso = $rol->consultarPermisoRol("usuarios", $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
}
?>
<html>
    <?php include 'view/modules/head.php'; ?>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script> 
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script> 
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script>
    <style type="text/css">
        td#prewrap {
            white-space: pre-wrap;
        }
    </style>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'view/modules/header.php'; ?>
            <?php include 'view/modules/side.php'; ?>
            <div class="content-wrapper" style="padding: 20px; background-color: #fff;">
                <!-- PANEL PARA CAMBIO -->
                <div class="row">
                    <div class="row" style="padding-top: 20px;">
                        <div class="col-sm-10 col-sm-offset-1">
                            <form class="form-horizontal" id="formEditarUsuario">
                                <fieldset>
                                    <legend class="font-color">Cambio Contraseña</legend>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="correoElectronico">Correo Electronico</label>  
                                        <div class="col-md-6">
                                            <input id="correoElectronico" name="correoElectronico" type=text placeholder="Correo electronico" class="form-control input-md" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="contrasenaNuev">Contraseña nueva</label>  
                                        <div class="col-md-6">
                                            <input id="contrasenaNuev" name="contrasenaNuev" type=password placeholder="Contraseña nueva" class="form-control input-md" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="contrasenaNuevR">Repita la contraseña</label>  
                                        <div class="col-md-6">
                                            <input id="contrasenaNuevR" name="contrasenaNuevR" type=password placeholder="Repita la contraseña" class="form-control input-md" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"></label>
                                        <div class="col-md-8">
                                            <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Guardar cambios</button>
                                            <button type="button" id="btnCancelar" name="btnCancelar" class="btn btn-danger">Cancelar</button>
                                        </div>
                                    </div>
                                    <div id="mensajeCambiarContrasena" hidden></div>
                                    <div id="errorCamposFormCambiarContrasena" hidden>
                                        <div class='alert alert-danger alert-dismissible'>
                                            <strong>Error.</strong> <br>
                                            Las contraseñas deben cioncidir. <br>
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
                        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-cambiar-contrasena">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header active">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Edición exitosa</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p id="modal-content-cambiar-contrasena"></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" id="modal-btn-cambiar-contrasena-ok">Aceptar</button>
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
                                            Las contraseñas deben cioncidir.<br>
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

                            document.getElementById("modal-content-create").innerHTML = "Confirme el cambio de la contraseña.";
                        });
                    </script>
                    <script>
                        $("#btn-confirm").on("click", function () {
                            var errorContrasena = $("#error-contrasena").text();
                            var correoElectronico = $("#correoElectronico").val();
                            var contrasenaNuev = $("#contrasenaNuev").val();
                            var contrasenaNuevR = $("#contrasenaNuevR").val();
                            if (correoElectronico === "" || contrasenaNuev === "" || contrasenaNuevR === "" || contrasenaNuevR !== contrasenaNuev || contrasenaNuevR === null || correoElectronico === null || contrasenaNuev === null) {
                                $("#modal-form-error").modal('show');
                            } else if (contrasenaNuevR !== contrasenaNuev) {
                                var mensaje = "Existen campos con errores<br>";
                                if (errorContrasena !== "") {
                                    mensaje = mensaje + errorContrasena + "<br>";
                                }
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
                            cambiarContrasena();
                            $("#modal-confirm").modal('hide');
                            $("#modal-cambiar-contrasena").modal('hide');
//                            window.location.replace("index.php?action=admin/home");
                        });
                        $("#modal-btn-no").on("click", function () {
                            $("#modal-confirm").modal('hide');
                        });
                        $("#modal-btn-cambiar-contrasena-ok").on("click", function () {
                            $("#modal-cambiar-contrasena").modal('hide');
                            window.location.replace("index.php?action=admin/usuarios/gestionUsuarios");
                        });
                    </script>
                    <script>
                        function cambiarContrasena() {
                            var correoElectronico = $("#correoElectronico").val();
                            var contrasenaNuev = $("#contrasenaNuev").val();
                            var contrasenaNuevR = $("#contrasenaNuevR").val();
                            if (correoElectronico === "" || contrasenaNuev === "" || contrasenaNuevR === "" || contrasenaNuevR !== contrasenaNuev || contrasenaNuevR === null || correoElectronico === null || contrasenaNuev === null) {
                                $('#errorCamposFormCambiarContrasena').show();
                            } else {
                                var url = "view/modules/admin/usuarios/funcionesUsuarios.php";
                                var data = new FormData();
                                data.append("correoElectronico", correoElectronico);
                                data.append("contrasenaNuev", contrasenaNuev);
                                data.append("contrasenaNuevR", contrasenaNuevR);
                                $.ajax({
                                    url: url,
                                    data: data,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    type: 'POST',
                                    success: function (resp) {
                                        if (resp === "Editado") {
                                            document.getElementById("modal-content-cambiar-contrasena").innerHTML = "La contraseña ha sido cambiada.";
                                            $("#modal-cambiar-contrasena").modal('show');
                                        } else if (resp === "Error al editar") {
                                            document.getElementById("modal-content-error").innerHTML = "Error al cambiar la contraseña.";
                                            $("#modal-form-error").modal('show');
                                        } else {
                                            console.log(resp);
                                        }
                                        console.log(resp);
                                    }
                                });
                            }
                        }
                    </script>
                    <script>
                        $("#btnCancelar").click(function (event) {
                            window.location.replace("index.php?action=admin/profile");
                        });
                    </script>
                    <script>
                        $(function () {
                            $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
                        });
                    </script>
                    <script>
                        $("#usuarios").addClass("active");
                    </script>
                </div>
            </div>
            <?php include 'view/modules/footer.php'; ?>
            <script>
                $("#usuarios").addClass("active");
            </script>
    </body>
</html>
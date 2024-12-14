<?php
session_start();
include_once 'model/modulo.php';
include_once 'controller/modulo.php';
include_once 'model/rol.php';
include_once 'controller/rol.php';

$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$permiso = $rol->consultarPermisoRol("modulos", $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$crear && ($modificar || $eliminar)) {
    header("Location: index.php?action=admin/modulos/gestionModulos");
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
                            <a href="index.php?action=admin/modulos/gestionModulos" class="btn btn-primary" role="button">
                                <i class="fa fa-arrow-left"></i>
                                Volver a Gestión de Módulos
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top: 20px;">
                    <div class="col-sm-10 col-sm-offset-1">
                        <form class="form-horizontal" id="formCrearModulo">
                            <fieldset>
                                <legend class="font-color">Creación de módulos</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="nombreModulo">Nombre</label>
                                    <div class="col-md-6">
                                        <input id="nombreModulo" name="nombreModulo" type="text" placeholder="Nombre del módulo" class="form-control input-md" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="disponibleConjuntos">Disponible para conjuntos de indicadores</label>  
                                    <div class="col-md-6">
                                        <select id="disponibleConjuntos" name="disponibleConjuntos" class="form-control">
                                            <option value="1">Si</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="iconoModulo">Icono</label>  
                                    <div class="col-md-6">
                                        <div class="picker">
                                            <input type="text" readonly class="inputpicker" 
                                                   placeholder="Selecciona un icono"
                                                   id="iconoModulo" name="iconoModulo">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="abreviatura">Abreviatura</label>
                                    <div class="col-md-6">
                                        <input id="abreviatura" name="abreviatura" type="text" placeholder="Abreviatura del módulo" class="form-control input-md" required>
                                    </div>
                                </div>
                                <style>
                                    .picker {position:relative;width:100%;margin:0 auto}
                                    .inputpicker {width:100%;padding:10px;background:#f2f2f2}
                                    .oculto-icon {width:100%;background:#f2f2f2;border-radius:0 0 10px 10px;padding:10px;overflow:auto;max-height:200px;display:none}
                                    .oculto-icon ul {display:inline;float:left;width:100%;margin:0;padding:0}
                                    .oculto-icon ul li {margin:0;padding:0;display:block;width:30px;height:30px;text-align:center;font-size:15px;font-family:"fontawesome";float:left;cursor:pointer;color:#666;line-height:30px;transition:0.2s all}
                                    .oculto-icon ul li:hover {background:#FFF;color:#000}
                                    .oculto-icon input[type=text] { font-size:13px;padding:5px;margin:0 0 10px 0;border:1px solid #ddd; }
                                </style>
                                <script src="sis/app/view/resources/js/icos.js"></script>
                                <script>
                                    $(document).ready(function () {
                                        $(".picker").each(function () {
                                            div = $(this);
                                            if (icos) {
                                                var iconos = "<ul>";
                                                for (var i = 0; i < icos.length; i++) {
                                                    iconos += "<li><i data-valor='fa " + icos[i] + "' rel='" + icos[i] + "' class='fa " + icos[i] + "'></i></li>";
                                                }
                                                iconos += "</ul>";
                                            }
                                            div.append("<div class='oculto-icon'><input type='text' placeholder='Selecciona un icono'>" + iconos + "</div>");
                                            $(".inputpicker").click(function () {
                                                $(".oculto-icon").fadeToggle("fast");
                                            });
                                            $(document).on("click", ".oculto-icon ul li", function () {
                                                $(".inputpicker").val($(this).find("i").data("valor"));
                                                $(".oculto-icon").fadeToggle("fast");
                                            });
                                            $(document).on("keyup", ".oculto-icon input[type=text]", function () {
                                                var value = $(this).val();
                                                $(".oculto-icon ul li i").each(function () {
                                                    if ($(this).attr("rel").search(value) > -1)
                                                        $(this).closest("li").show();
                                                    else
                                                        $(this).closest("li").hide();
                                                });
                                            });
                                        });
                                    });
                                </script>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"></label>
                                    <div class="col-md-8">
                                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Crear módulo</button>
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
                                    <h4 class="modal-title">Confirmación</h4>
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
                    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-modulo-created">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header active">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Creación exitosa</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-content-modulo-created"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" id="modal-btn-modulo-created-ok">Aceptar</button>
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
                var nombreModuloModal = $("#nombreModulo").val();
                document.getElementById("modal-content-create").innerHTML = "Confirma la creación del módulo <b>" + nombreModuloModal + "</b>";
            });
        </script>
        <script>
            $("#btn-confirm").on("click", function () {
                var nombreModulo = $("#nombreModulo").val();
                var disponibleConjuntos = $("#disponibleConjuntos").val();
                var iconoModulo = $("#iconoModulo").val();
                var abreviatura = $("#abreviatura").val();
                if (nombreModulo === "" || disponibleConjuntos === "" || iconoModulo === "" || abreviatura === "") {
                    $("#modal-form-error").modal('show');
                } else {
                    $("#modal-confirm").modal('show');
                }
            });
            $("#modal-btn-form-error-ok").on("click", function () {
                $("#modal-form-error").modal('hide');
            });
            $("#modal-btn-si").on("click", function () {
                crearModulo();
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-no").on("click", function () {
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-modulo-created-ok").on("click", function () {
                $("#modal-modulo-created").modal('hide');
                window.location.replace("index.php?action=admin/modulos/gestionModulos");
            });
        </script>
        <script>
            $("#modulos").addClass("active");
        </script>
        <script>
            function crearModulo() {
                var nombreModulo = $("#nombreModulo").val();
                var disponibleConjuntos = $("#disponibleConjuntos").val();
                var iconoModulo = $("#iconoModulo").val();
                var abreviatura = $("#abreviatura").val();
                if (nombreModulo === "" || disponibleConjuntos === "" || iconoModulo === "" || abreviatura === "") {
                    $("#modal-form-error").modal('show');
                } else {
                    var url = "view/modules/admin/modulos/funcionesModulos.php";
                    var data = new FormData();
                    data.append("nombreModulo", nombreModulo);
                    data.append("disponibleConjuntos", disponibleConjuntos);
                    data.append("iconoModulo", iconoModulo);
                    data.append("abreviatura", abreviatura);
                    $.ajax({
                        url: url,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function (resp) {
                            $("#formCrearModulo")[0].reset();
                            if (resp === "Creado") {
                                document.getElementById("modal-content-modulo-created").innerHTML = "El módulo <b>" + nombreModulo + "</b> ha sido creado correctamente.";
                                $("#modal-modulo-created").modal('show');
                            } else if (resp === "Error al crear") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear el módulo <b>" + nombreModulo + "</b>.<br>Intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Nombre modulo existe") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear el módulo <b>" + nombreModulo + "</b>.<br>\n\
                                            Ya existe un módulo con el nombre ingresado.<br>Verifique la información e intente nuevamente.";
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
                $("#formCrearModulo")[0].reset();
            });
        </script>
        <script>
            $(function () {
                $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
            });
        </script>
    </body>
</html>
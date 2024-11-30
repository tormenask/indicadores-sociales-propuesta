<?php
session_start();
include_once 'model/noticias.php';
include_once 'controller/noticias.php';
include_once 'model/rol.php';
include_once 'controller/rol.php';
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$permiso = $rol->consultarPermisoRol("noticias", $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$crear && ($modificar || $eliminar)) {
    header("Location: index.php?action=admin/noticias/gestionNoticias");
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
                            <a href="index.php?action=admin/noticias/gestionNoticias" class="btn btn-primary" role="button">
                                <i class="fa fa-arrow-left"></i>
                                Volver a Gestión de Noticias
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top: 20px;">
                    <div class="col-sm-10 col-sm-offset-1">
                        <form class="form-horizontal" id="formCrearNoticias" enctype="multipart/form-data" method="post">
                            <fieldset>
                                <legend class="font-color">Creación de noticias</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="tituloNoticia">Título</label>
                                    <div class="col-md-6">
                                        <input id="tituloNoticia" name="tituloNoticia" type="text" placeholder="Título de la noticia" class="form-control input-md" required>
                                    </div>
                                </div>
                                <div class='form-group'>
                                    <label class='col-md-4 control-label' for='anhoNoticia'>Año de la noticia</label>
                                    <div class="col-md-6">
                                        <select name='anhoNoticia' id='anhoNoticia' class='form-control'>
                                            <script>
                                                select = document.getElementById('anhoNoticia');
                                                for (i = 1999; i <= 2030; i++) {
                                                    option = document.createElement('option');
                                                    option.value = i;
                                                    option.text = i;
                                                    select.appendChild(option);
                                                }
                                            </script>
                                        </select>
                                    </div>        
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="fechaNoticia">Fecha de la noticia</label>  
                                    <div class="col-md-6">
                                        <input type="date" id="fechaNoticia" name="fechaNoticia" placeholder="Fecha de la noticia" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="textoNoticia">Texto</label>
                                    <div class="col-md-6">
                                        <textarea id="textoNoticia" rows="8" name="textoNoticia" type="text" placeholder="Texto de la noticia" class="form-control input-md" required></textarea>
                                    </div>
                                </div>
                                <!--min="" max="20" multiple="-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="imagen">Carpeta de las imagenes</label>  
                                    <div class="col-md-6">
                                        <input id="imagen[]" name="imagen[]" type="file" accept = ".png, .jpeg,.jpg,.gif"  multiple=""
                                               placeholder="Seleccione una imagen" class="form-control input-md" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"></label>
                                    <div class="col-md-8">
                                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Crear noticia</button>
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
                    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-noticia-created">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header active">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Creación exitosa</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-content-noticia-created"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" id="modal-btn-noticia-created-ok">Aceptar</button>
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
                var tituloNoticiaModal = $("#tituloNoticia").val();
                document.getElementById("modal-content-create").innerHTML = "Confirma la creación de la noticia <b>" + tituloNoticiaModal + "</b>";

            });
        </script>
        <script>
            $("#btn-confirm").on("click", function () {
                var tituloNoticia = $("#tituloNoticia").val();
                var anhoNoticia = $("#anhoNoticia").val();
                var fechaNoticia = $("#fechaNoticia").val();
                var textoNoticia = $("#textoNoticia").val();

                if (tituloNoticia === "" || anhoNoticia === "" || fechaNoticia === "" || textoNoticia === "") {
                    $("#modal-form-error").modal('show');
                } else {
                    $("#modal-confirm").modal('show');
                }
            });
            $("#modal-btn-form-error-ok").on("click", function () {
                $("#modal-form-error").modal('hide');
            });
            $("#modal-btn-si").on("click", function () {
                crearNoticias();
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-no").on("click", function () {
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-noticia-created-ok").on("click", function () {
                $("#modal-noticia-created").modal('hide');
                window.location.replace("index.php?action=admin/noticias/gestionNoticias");
            });
        </script>
        <script>
            $("#noticias").addClass("active");
        </script>
        <script>
            function crearNoticias() {
                var tituloNoticia = $("#tituloNoticia").val();
                var anhoNoticia = $("#anhoNoticia").val();
                var fechaNoticia = $("#fechaNoticia").val();
                var textoNoticia = $("#textoNoticia").val();
                if (tituloNoticia === "" || anhoNoticia === "" || fechaNoticia === "" || textoNoticia === "") {
                    $("#modal-form-error").modal('show');
                } else {
                    var url = "view/modules/admin/noticias/funcionesNoticias.php";
//                    ENVIO DE TODO EL FORMULARIO
//                    var form = $("#formCrearNoticias");
//                    var data = new FormData(form[0]);
                    var imagen = document.getElementById('imagen[]');
                    var uploadFile = imagen.files;
                    if (uploadFile.length > 0) {
                        var error = false;
                        for (i = 0; i < uploadFile.length; i++) {
                            if (uploadFile[i]["size"] > 3700000) {
                                error = true;
                            } 
                        }
                        if (error === true) {
                            document.getElementById("modal-content-error").innerHTML = "Error al cargar la imagen. <br> El archivo excede el peso máximo de 1 Mb.<br>Intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        } else {
                            var form = $("#formCrearNoticias");
                            var data = new FormData(form[0]);
                        }
                    } else {
                        var form = $("#formCrearNoticias");
                        var data = new FormData(form[0]);
                    }
                    $.ajax({
                        url: url,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function (resp) {
                            $("#formCrearNoticias")[0].reset();
                            if (resp === "Creada") {
                                document.getElementById("modal-content-noticia-created").innerHTML = "La noticia <b>" + tituloNoticia + "</b> ha sido creada correctamente.";
                                $("#modal-noticia-created").modal('show');
                            } else if (resp === "Error al crear") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la noticia <b>" + tituloNoticia + "</b>.<br>Intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Excede tamaño") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la noticia <b>" + tituloNoticia + "</b>.<br>Excede el tamaño limite permitido por imagen de <b>999Kb</b>.";
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
                $("#formCrearNoticias")[0].reset();
            });
        </script>
        <script>
            $(function () {
                $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
            });
        </script>
    </body>
</html>

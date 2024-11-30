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
        <form class="form-horizontal" id="formEditarNoticias" enctype="multipart/form-data" method="post">
            <fieldset>
                <legend class="font-color">Editar noticias</legend>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="idNoticiaEd">Id</label>
                    <div class="col-md-6">
                        <input id="idNoticiaEd" name="idNoticiaEd" type="text" placeholder="Id de la noticia" class="form-control input-md" required
                               value="<?php echo $respEditarNoticias["idNoticia"] ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="tituloNoticiaEd">Título</label>
                    <div class="col-md-6">
                        <input id="tituloNoticiaEd" name="tituloNoticiaEd" type="text" placeholder="Título de la noticia" class="form-control input-md" required 
                               value="<?php echo $respEditarNoticias["tituloNoticia"] ?>">
                    </div>
                </div>
                <div class='form-group'>
                    <label class='col-md-4 control-label' for='anhoNoticiaEd'>Año de la noticia</label>
                    <div class="col-md-6">
                        <select name='anhoNoticiaEd' id='anhoNoticiaEd' class='form-control' value="">
                            <?php
                            $noticiaEd = new NoticiasController();
                            $noticiaEd->listarNoticiasEditar($respEditarNoticias["idNoticia"]);
                            ?>
                            <script>
                                select = document.getElementById('anhoNoticiaEd');
                                for (i = 1999; i <= 2020; i++) {
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
                    <label class="col-md-4 control-label" for="fechaNoticiaEd">Fecha de la noticia</label>  
                    <div class="col-md-6">
                        <input type="date" id="fechaNoticiaEd" name="fechaNoticiaEd" placeholder="Fecha de la noticia" class="form-control" 
                               value="<?php echo $respEditarNoticias["fechaNoticia"] ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textoNoticiaEd">Texto</label>
                    <div class="col-md-6">
                        <textarea id="textoNoticiaEd" name="textoNoticiaEd" rows="8" type="text" placeholder="Texto de la noticia" class="form-control input-md"
                                  value="<?php echo $respEditarNoticias["textoNoticia"] ?>" required><?php echo $respEditarNoticias["textoNoticia"] ?></textarea>                 
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="imagenEd">Carpeta de las imagenes</label>  
                    <div class="col-md-6">
                        <input id="imagenEd[]" name="imagenEd[]" type="file" accept = ".png, .jpeg,.jpg,.gif"  multiple=""
                               placeholder="Seleccione una imagen" class="form-control input-md" >
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-noticia-edited">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edición exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-noticia-edited"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-noticia-edited-ok">Aceptar</button>
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
        var tituloNoticiaModal = $("#tituloNoticiaEd").val();
        document.getElementById("modal-content-edited").innerHTML = "Confirma la edición de la noticia <b>" + tituloNoticiaModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idNoticiaEd = $("#idNoticiaEd").val();
        var tituloNoticiaEd = $("#tituloNoticiaEd").val();
        var anhoNoticiaEd = $("#anhoNoticiaEd").val();
        var fechaNoticiaEd = $("#fechaNoticiaEd").val();
        var textoNoticiaEd = $("#textoNoticiaEd").val();
        if (idNoticiaEd === "" || tituloNoticiaEd === "" || anhoNoticiaEd === "" || fechaNoticiaEd === "" || textoNoticiaEd === "") {
            $("#modal-form-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });

    $("#modal-btn-form-error-ok").on("click", function () {
        $("#modal-form-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        editarNoticia();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-noticia-edited-ok").on("click", function () {
        $("#modal-noticia-edited").modal('hide');
        window.location.replace("index.php?action=admin/noticias/gestionNoticias");
    });
</script>
<script>
    function editarNoticia() {
        var idNoticiaEd = $("#idNoticiaEd").val();
        var tituloNoticiaEd = $("#tituloNoticiaEd").val();
        var anhoNoticiaEd = $("#anhoNoticiaEd").val();
        var fechaNoticiaEd = $("#fechaNoticiaEd").val();
        var textoNoticiaEd = $("#textoNoticiaEd").val();
        if (idNoticiaEd === "" || tituloNoticiaEd === "" || anhoNoticiaEd === "" || fechaNoticiaEd === "" || textoNoticiaEd === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/noticias/funcionesNoticias.php";
            var imagenEd = document.getElementById('imagenEd[]');
            var uploadFile = imagenEd.files;
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
                    var formEd = $("#formEditarNoticias");
                    var data = new FormData(formEd[0]);
                }
            } else {
                var formEd = $("#formEditarNoticias");
                var data = new FormData(formEd[0]);
            }
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Editada") {
                        document.getElementById("modal-content-noticia-edited").innerHTML = "La noticia <b>" + tituloNoticiaEd + "</b> ha sido editado correctamente.";
                        $("#modal-noticia-edited").modal('show');
                    } else if (resp === "Error al editar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la noticia <b>" + tituloNoticiaEd + "</b>.<br>Intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Excede tamaño") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la noticia <b>" + tituloNoticiaEd + "</b>.<br>Excede el tamaño limite permitido por imagen de <b>999Kb</b>.";
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
        window.location.replace("index.php?action=admin/noticias/gestionNoticias");
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


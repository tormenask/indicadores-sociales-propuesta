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
        <form class="form-horizontal" id="formEliminarNoticias">
            <fieldset>
                <legend class="font-color">Eliminar noticias</legend>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="idNoticia">Id</label>
                    <div class="col-md-6">
                        <input id="idNoticia" name="idNoticia" type="text" placeholder="Id de la noticia" class="form-control input-md" required
                               value="<?php echo $respEliminarNoticias["idNoticia"] ?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="tituloNoticia">Título</label>
                    <div class="col-md-6">
                        <input id="tituloNoticia" name="tituloNoticia" type="text" placeholder="Título de la noticia" class="form-control input-md" required 
                               value="<?php echo $respEliminarNoticias["tituloNoticia"] ?>" disabled>
                    </div>
                </div>
                <div class='form-group'>
                    <label class='col-md-4 control-label' for='anhoNoticia'>Año de la noticia</label>
                    <div class="col-md-6">
                        <select name='anhoNoticia' id='anhoNoticia' class='form-control' value="" disabled>
                            <?php
                            $noticiaEd = new NoticiasController();
                            $noticiaEd->listarNoticiasEditar($respEliminarNoticias["idNoticia"]);
                            ?>
                        </select>
                    </div>        
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="fechaNoticia">Fecha de la noticia</label>  
                    <div class="col-md-6">
                        <input type="date" id="fechaNoticia" name="fechaNoticia" placeholder="Fecha de la noticia" class="form-control" 
                               value="<?php echo $respEliminarNoticias["fechaNoticia"] ?>" required disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textoNoticia">Texto</label>
                    <div class="col-md-6">
                        <textarea id="textoNoticia" name="textoNoticia" type="text" placeholder="Texto de la noticia" class="form-control input-md" rows="8"
                                  value="<?php echo $respEliminarNoticias["textoNoticia"] ?>" required disabled><?php echo $respEliminarNoticias["textoNoticia"]?></textarea>                       
                    </div>
                </div>
                <!--min="" max="20" multiple="-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="imagen">Carpeta de las imagenes</label>  
                    <div class="col-md-6">
                        <input id="imagen" name="imagen" min="" max="20" type="text"  
                               accept = ".png, .jpeg,.jpg"
                               placeholder="Seleccione una imagen" class="form-control input-md" value="<?php echo $respEliminarNoticias["carpetaImagenesNoticia"] ?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Eliminar</button>
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
                    <p id="modal-content-deleted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="modal-btn-si">Si</button>
                    <button type="button" class="btn btn-default" id="modal-btn-no">No</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-noticia-deleted">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Eliminación exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-noticia-deleted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-noticia-deleted-ok">Aceptar</button>
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
        var tituloNoticiaModal = $("#tituloNoticia").val();
        document.getElementById("modal-content-deleted").innerHTML = "Confirma la eliminación de la noticia <b>" + tituloNoticiaModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idNoticia = $("#idNoticia").val();
        
        if (idNoticia === "" ) {
            $("#modal-form-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });

    $("#modal-btn-form-error-ok").on("click", function () {
        $("#modal-form-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        eliminarNoticia();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-noticia-deleted-ok").on("click", function () {
        $("#modal-noticia-deleted").modal('hide');
        window.location.replace("index.php?action=admin/noticias/gestionNoticias");
    });
</script>
<script>
    function eliminarNoticia() {
        var idNoticia = $("#idNoticia").val();
        var tituloNoticia = $("#tituloNoticia").val();
        
        if (idNoticia === "" ) {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/noticias/funcionesNoticias.php";
            var data = new FormData();
            data.append("idNoticiaEl", idNoticia);
//            data.append("tituloNoticiaEl", tituloNoticia);
                      
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Eliminada") {
                        document.getElementById("modal-content-noticia-deleted").innerHTML = "La noticia <b>" + tituloNoticia + "</b> ha sido eliminada correctamente.";
                        $("#modal-noticia-deleted").modal('show');
                    } else if (resp === "Error al eliminar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar la noticia <b>" + tituloNoticia + "</b>.<br>Intente nuevamente.";
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




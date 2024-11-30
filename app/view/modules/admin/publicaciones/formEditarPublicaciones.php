<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/publicaciones/gestionPublicaciones&conj=<?php echo $idConjuntoPublicaciones; ?>" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de publicaciones
            </a>
        </div>
    </div>
</div>

<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEditarPublicaciones">
            <fieldset>
                <legend class="font-color">Editar Publicaciones</legend>
                <div class="form-group control-group">
                    <label class="col-md-4 control-label" for="idUrl">Id url</label>
                    <div class="col-md-6">
                        <div class="controls">
                            <input id="idUrl" name="idUrl" type="number" 
                                   placeholder="Id de la publicación" 
                                   class="form-control input-md" required 
                                   value="<?php echo $respEditarPublicaciones["idUrl"] ?>" readonly="" >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="urlPublicacionesEd">Url</label>  
                    <div class="col-md-6">
                        <input id="urlPublicacionesEd" name="urlPublicacionesEd" type="text" placeholder="Url de la publicación" class="form-control input-md" 
                               value="<?php echo $respEditarPublicaciones["url"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="categoriaPublicacionesEd">Categoria</label>
                    <div class="col-md-6">
                        <input id="categoriaPublicacionesEd"  name="categoriaPublicacionesEd" class="form-control" value="<?php echo $respEditarPublicaciones["categoria"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="tituloPublicacionesEd">Título</label>  
                    <div class="col-md-6">
                        <input id="tituloPublicacionesEd" name="tituloPublicacionesEd" type="text" placeholder="Título de la publicación" class="form-control input-md"  value="<?php echo $respEditarPublicaciones["titulo"] ?>">
                    </div>
                </div>               
                <div class="form-group">
                    <label class="col-md-4 control-label" for="descripcionPublicacionesEd">Descripción</label>  
                    <div class="col-md-6">
                        <input id="descripcionPublicacionesEd" name="descripcionPublicacionesEd" type="text" placeholder="Descripción de la publicación" class="form-control input-md"  value="<?php echo $respEditarPublicaciones["descripcion"] ?>">
                    </div>
                </div>               
                <div class="form-group">
                    <label class="col-md-4 control-label" for="palabrasClavePublicacionesEd">Palabras clave</label>  
                    <div class="col-md-6">
                        <textarea id="palabrasClavePublicacionesEd" rows="4" name="palabrasClavePublicacionesEd" type="text" placeholder="Palabras clave" class="form-control input-md"  value="<?php echo $respEditarPublicaciones["palabras_claves"] ?>"><?php echo $respEditarPublicaciones["palabras_claves"] ?></textarea>
                    </div>
                </div>   
                <div class="form-group">
                    <label class="col-md-4 control-label" for="contenidoPublicacionesEd">Contenido</label>  
                    <div class="col-md-6">
                        <textarea id="contenidoPublicacionesEd"><?php echo $respEditarPublicaciones["contenido"] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="conjuntoPublicacionesEd">Conjunto de indicadores</label>  
                    <div class="col-md-6">
                        <input id="conjuntoPublicacionesEd" name="conjuntoPublicacionesEd" type="text" placeholder="Conjunto de indicadores de la publicación" class="form-control input-md"  value="<?php echo $idConjuntoPublicaciones ?>" readonly="">
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-publicaciones-edited">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >Edición exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-publicaciones-edited"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-publicaciones-edited-ok">Aceptar</button>
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
                        El campo Url es obligatorio<br>
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
        var idUrl = $("#idUrl").val();
        document.getElementById("modal-content-edited").innerHTML = "Confirma la edición de la publicación <b>" + idUrl + "</b>";
    });
</script>
<script>
    $('#contenidoPublicacionesEd').summernote({
        placeholder: 'Contenido de la publicación',
        tabsize: 2,
        height: 100
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idUrl = $("#idUrl").val();
        var conjuntoPublicacionesEd = $("#conjuntoPublicacionesEd").val();
        var urlPublicacionesEd = $("#urlPublicacionesEd").val();
        if (idUrl === "" || conjuntoPublicacionesEd === "" || urlPublicacionesEd === "") {
            $("#modal-form-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });

    $("#modal-btn-form-error-ok").on("click", function () {
        $("#modal-form-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        editarPublicaciones();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-publicaciones-edited-ok").on("click", function () {
        $("#modal-publicaciones-edited").modal('hide');
        window.location.replace("index.php?action=admin/publicaciones/gestionPublicaciones&conj=" + "<?php echo $idConjuntoPublicaciones; ?>");
    });
</script>
<script>
    function editarPublicaciones() {
        var idUrl = $("#idUrl").val();
        var urlPublicacionesEd = $("#urlPublicacionesEd").val();
        var categoriaPublicacionesEd = $("#categoriaPublicacionesEd").val();
        var tituloPublicacionesEd = $("#tituloPublicacionesEd").val();
        var descripcionPublicacionesEd = $("#descripcionPublicacionesEd").val();
        var palabrasClavePublicacionesEd = $("#palabrasClavePublicacionesEd").val();
        var contenidoPublicacionesEd = $("#contenidoPublicacionesEd").val();
        var conjuntoPublicacionesEd = $("#conjuntoPublicacionesEd").val();
        if (idUrl === "" || conjuntoPublicacionesEd === "" || urlPublicacionesEd === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/publicaciones/funcionesPublicaciones.php";
            var data = new FormData();
            data.append("idUrl", idUrl);
            data.append("urlPublicacionesEd", urlPublicacionesEd);
            data.append("categoriaPublicacionesEd", categoriaPublicacionesEd);
            data.append("tituloPublicacionesEd", tituloPublicacionesEd);
            data.append("descripcionPublicacionesEd", descripcionPublicacionesEd);
            data.append("palabrasClavePublicacionesEd", palabrasClavePublicacionesEd);
            data.append("contenidoPublicacionesEd", contenidoPublicacionesEd);
            data.append("conjuntoPublicacionesEd", conjuntoPublicacionesEd);

            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Editada") {
                        document.getElementById("modal-content-publicaciones-edited").innerHTML = "La publicación <b>" + idUrl + "</b> ha sido editada correctamente.";
                        $("#modal-publicaciones-edited").modal('show');
                    } else if (resp === "Error al editar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la publicación <b>" + idUrl + "</b>.<br>Intente nuevamente.";
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
        window.location.replace("index.php?action=admin/publicaciones/gestionPublicaciones&conj=" + "<?php echo $idConjuntoPublicaciones; ?>");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#publicaciones").addClass("active");
    var conjunto = "#publicaciones" + "<?php echo $idConjuntoPublicaciones; ?>";
    $(conjunto).addClass("active");
</script>


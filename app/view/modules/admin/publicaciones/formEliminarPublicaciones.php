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
        <form class="form-horizontal" id="formEliminarPublicaciones">
            <fieldset>
                <legend class="font-color">Eliminar Publicaciones</legend>
                <div class="form-group control-group">
                    <label class="col-md-4 control-label" for="idUrlEl">Id url</label>
                    <div class="col-md-6">
                        <div class="controls">
                            <input id="idUrlEl" name="idUrlEl" type="number" 
                                   placeholder="Id de la publicación" 
                                   class="form-control input-md" required 
                                   value="<?php echo $respEliminarPublicaciones["idUrl"] ?>" readonly="" >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="urlPublicacionesEl">Url</label>  
                    <div class="col-md-6">
                        <input id="urlPublicacionesEl" name="urlPublicacionesEl" type="text" placeholder="Url de la publicación" class="form-control input-md" 
                               value="<?php echo $respEliminarPublicaciones["url"] ?>" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="categoriaPublicacionesEl">Categoria</label>
                    <div class="col-md-6">
                        <input id="categoriaPublicacionesEl"  name="categoriaPublicacionesEl" class="form-control" value="<?php echo $respEliminarPublicaciones["categoria"] ?>" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="tituloPublicacionesEl">Título</label>  
                    <div class="col-md-6">
                        <input id="tituloPublicacionesEl" name="tituloPublicacionesEl" type="text" placeholder="Título de la publicación" class="form-control input-md"  value="<?php echo $respEliminarPublicaciones["titulo"] ?>" readonly="">
                    </div>
                </div>               
                <div class="form-group">
                    <label class="col-md-4 control-label" for="descripcionPublicacionesEl">Descripción</label>  
                    <div class="col-md-6">
                        <input id="descripcionPublicacionesEl" name="descripcionPublicacionesEl" type="text" placeholder="Descripción de la publicación" class="form-control input-md"  value="<?php echo $respEliminarPublicaciones["descripcion"] ?>" readonly="">
                    </div>
                </div>               
                <div class="form-group">
                    <label class="col-md-4 control-label" for="palabrasClavePublicacionesEl">Palabras clave</label>  
                    <div class="col-md-6">
                        <textarea id="palabrasClavePublicacionesEl" rows="4" name="palabrasClavePublicacionesEl" type="text" placeholder="Palabras clave" class="form-control input-md"  value="<?php echo $respEliminarPublicaciones["palabras_claves"] ?>" readonly=""><?php echo $respEliminarPublicaciones["palabras_claves"] ?></textarea>
                    </div>
                </div>               
                <div class="form-group">
                    <label class="col-md-4 control-label" for="contenidoPublicacionesEl">Contenido</label>  
                    <div class="col-md-6">
                        <textarea id="contenidoPublicacionesEl" rows="17" name="contenidoPublicacionesEl" type="text" placeholder="Contenido de la publicación" class="form-control input-md"  value="<?php echo $respEliminarPublicaciones["contenido"] ?>" readonly=""><?php echo $respEliminarPublicaciones["contenido"] ?></textarea>
                    </div>
                </div>               
                <div class="form-group">
                    <label class="col-md-4 control-label" for="conjuntoPublicacionesEl">Conjunto de indicadores</label>  
                    <div class="col-md-6">
                        <input id="conjuntoPublicacionesEl" name="conjuntoPublicacionesEl" type="text" placeholder="Conjunto de indicadores de la publicación" class="form-control input-md"  value="<?php echo $idConjuntoPublicaciones ?>" readonly="">
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Eliminar Publicación</button>
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
                    <p id="modal-content-delete"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="modal-btn-si">Si</button>
                    <button type="button" class="btn btn-default" id="modal-btn-no">No</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-publicaciones-delete">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >Eliminación exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-publicaciones-delete"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-publicaciones-delete-ok">Aceptar</button>
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
                        Verifica la información e intenta nuevamente.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-form-error-ok">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div><br><br></div>

<script>
    $('#modal-confirm').on('shown.bs.modal', function (e) {
        var idUrlEl = $("#idUrlEl").val();
        document.getElementById("modal-content-delete").innerHTML = "Confirma la eliminación de la publicación <b>" + idUrlEl + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idUrlEl = $("#idUrlEl").val();
        var conjuntoPublicacionesEd = $("#conjuntoPublicacionesEd").val();
        if (idUrlEl === "" || conjuntoPublicacionesEd === "" ) {
            $("#modal-form-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });
    $("#modal-btn-form-error-ok").on("click", function () {
        $("#modal-form-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        eliminarPublicaciones();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-publicaciones-delete-ok").on("click", function () {
        $("#modal-publicaciones-delete").modal('hide');
        window.location.replace("index.php?action=admin/publicaciones/gestionPublicaciones&conj=" + "<?php echo $idConjuntoPublicaciones; ?>");
    });
</script>
<script>
    function eliminarPublicaciones() {
        var idUrlEl = $("#idUrlEl").val();
        var conjuntoPublicacionesEd = $("#conjuntoPublicacionesEd").val();
        if (idUrlEl === "" || conjuntoPublicacionesEd === "" ) {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/publicaciones/funcionesPublicaciones.php";
            var data = new FormData();
            data.append("idUrlEl", idUrlEl);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Eliminada") {
                        document.getElementById("modal-content-publicaciones-delete").innerHTML = "La publicación <b>" + idUrlEl + "</b> ha sido eliminada correctamente.";
                        $("#modal-publicaciones-delete").modal('show');
                    } else if (resp === "Error al eliminar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar la publicación <b>" + idUrlEl + "</b>.<br>Intente nuevamente.";
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


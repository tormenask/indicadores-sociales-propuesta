<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/tematicas/gestionTematicas&conj=<?php echo $respIdConjuntoTematica; ?>" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de temáticas
            </a>
        </div>
    </div>
</div>

<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEliminarTematica">
            <fieldset>
                <legend class="font-color">Eliminar temática</legend>
                <div class="form-group control-group">
                    <label class="col-md-4 control-label" for="idTematica">Id</label>  
                    <div class="col-md-6">
                        <div class="controls">
                            <input id="idTematica" name="idTematica" type="text" 
                                   placeholder="Id de la temática" class="form-control input-md" required value="<?php echo $respEliminarTematica["idTematica"] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nombreTematica">Nombre</label>  
                    <div class="col-md-6">
                        <input id="nombreTematica" name="nombreTematica" type="text" 
                               placeholder="Nombre de la temática" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarTematica["nombreTematica"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="descripcionTematica">Descripción</label>  
                    <div class="col-md-6">
                        <input id="descripcionTematica" name="descripcionTematica" type="text" 
                               placeholder="Descripción de la temática" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarTematica["descripcionTematica"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="conjuntoTematica">Conjunto de indicadores</label>
                    <div class="col-md-6">
                        <select id="conjuntoTematica" name="conjuntoTematica" class="form-control" disabled>
                            <option value="Seleccione">Seleccione un conjunto de indicadores</option>
                            <?php
                            $conjuntoEd = new ConjuntoIndicadoresController();
                            $conjuntoEd->listarConjuntosEditar($respIdConjuntoTematica);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="dimensionTematica">Dimensión</label>
                    <div class="col-md-6">
                        <select class="form-control" id="dimensionTematica" name="dimensionTematica" disabled>
                            <?php
                            $dimensionEd = new DimensionController();
                            $dimensionEd->listarDimensionesEditar($respIdDimensionTematica);
                            ?>
                        </select>
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-md-4 control-label" for="posicion">Posición</label>  
                    <div class="col-md-6">
                        <input id="posicion" name="posicion" type="number" 
                               placeholder="posicion" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarTematica["posicion"] ?>">
                    </div>
                </div>                
                
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button type="button" id="btn-confirm" name="btn-confirm" 
                                class="btn btn-primary">Eliminar temática</button>
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-tematica-deleted">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminación exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-tematica-deleted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-tematica-deleted-ok">Aceptar</button>
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
        var nombreTematicaModal = $("#nombreTematica").val();
        document.getElementById("modal-content-confirm").innerHTML = "Realmente desea eliminar la temática <b>" + nombreTematicaModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idTematica = $("#idTematica").val();
        if (idTematica === "") {
            $("#modal-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });
    $("#modal-btn-error-ok").on("click", function () {
        $("#modal-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        eliminarTematica();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-tematica-deleted-ok").on("click", function () {
        $("#modal-tematica-deleted").modal('hide');
        window.location.replace("index.php?action=admin/tematicas/gestionTematicas&conj=<?php echo $respIdConjuntoTematica; ?>");
    });
</script>
<script>
    function eliminarTematica() {
        var nombreTematica = $("#nombreTematica").val();
        var idTematica = $("#idTematica").val();
        if (idTematica === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/tematicas/funcionesTematicas.php";
            var data = new FormData();
            data.append("idTematicaEl", idTematica);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Eliminada") {
                        document.getElementById("modal-content-tematica-deleted").innerHTML = "La temática <b>" + nombreTematica + "</b> ha sido eliminada correctamente.";
                        $("#modal-tematica-deleted").modal('show');
                    } else if (resp === "1451") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar la temática <b>" + nombreTematica + "</b>.<br>Existe al menos un indicador con esta temática asignada. <br>Verifique la información e intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Error al eliminar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar la temática <b>" + nombreTematica + "</b>.<br>Intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Id tematica no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar la temática <b>" + nombreTematica + "</b>.<br>\n\
                                    No existe una temática con el id <b>" + idTematica + "</b>.<br> Verifique la información e intente nuevamente.";
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
        window.location.replace("index.php?action=admin/tematicas/gestionTematicas&conj=<?php echo $respIdConjuntoTematica; ?>");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#tematicas").addClass("active");
    var conjunto = "#tematicas" + "<?php echo $respIdConjuntoTematica; ?>";
    $(conjunto).addClass("active");
</script>
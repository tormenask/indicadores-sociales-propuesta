<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/dimensiones/gestionDimensiones&conj=<?php echo $idConjuntoDimension; ?>" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de dimensiones
            </a>
        </div>
    </div>
</div>

<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEliminarDimension">
            <fieldset>
                <legend class="font-color">Eliminar dimensión</legend>
                <div class="form-group control-group">
                    <label class="col-md-4 control-label" for="idDimension">Id</label>  
                    <div class="col-md-6">
                        <div class="controls">
                            <input id="idDimension" name="idDimension" type="text" 
                                   placeholder="Id de la dimensión" class="form-control input-md" required value="<?php echo $respEliminarDimension["idDimension"] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nombreDimension">Nombre</label>  
                    <div class="col-md-6">
                        <input id="nombreDimension" name="nombreDimension" type="text" placeholder="Nombre de la dimensión" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarDimension["nombreDimension"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="descripcionDimension">Descripción</label>  
                    <div class="col-md-6">
                        <input id="descripcionDimension" name="descripcionDimension" type="text" placeholder="Descripción de la dimensión" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarDimension["descripcionDimension"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="conjuntoDimension">Conjunto de indicadores</label>
                    <div class="col-md-6">
                        <select id="conjuntoDimension" name="conjuntoDimension" class="form-control" readonly disabled>
                            <?php
                            $conjuntoEl = new ConjuntoIndicadoresController();
                            $conjuntoEl->listarConjuntosEditar($respEliminarDimension["idConjuntoIndicadores"]);
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-4 control-label" for="posicion">Posición</label>  
                    <div class="col-md-6">
                        <input id="posicion" name="posicion" type="number" placeholder="posicion" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarDimension["posicion"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="icono">Icono</label>  
                    <div class="col-md-6">
                        <input id="icono" name="icono" type="text" placeholder="icono" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarDimension["icono"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="color">Color</label>  
                    <div class="col-md-6">
                        <input id="color" name="color" type="text" placeholder="color" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarDimension["color"] ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Eliminar dimensión</button>
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-dimension-deleted">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminación exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-dimension-deleted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-dimension-deleted-ok">Aceptar</button>
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
        var nombreDimensionModal = $("#nombreDimension").val();
        document.getElementById("modal-content-confirm").innerHTML = "Realmente desea eliminar la dimensión <b>" + nombreDimensionModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idDimension = $("#idDimension").val();
        if (idDimension === "") {
            $("#modal-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });
    $("#modal-btn-error-ok").on("click", function () {
        $("#modal-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        eliminarDimension();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-dimension-deleted-ok").on("click", function () {
        $("#modal-dimension-deleted").modal('hide');
        window.location.replace("index.php?action=admin/dimensiones/gestionDimensiones&conj=<?php echo $idConjuntoDimension; ?>");
    });
</script>
<script>
    function eliminarDimension() {
        var nombreDimension = $("#nombreDimension").val();
        var idDimension = $("#idDimension").val();
        if (idDimension === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/dimensiones/funcionesDimensiones.php";
            var data = new FormData();
            data.append("idDimensionEl", idDimension);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Eliminada") {
                        document.getElementById("modal-content-dimension-deleted").innerHTML = "La dimensión <b>" + nombreDimension + "</b> ha sido eliminada correctamente.";
                        $("#modal-dimension-deleted").modal('show');
                    } else if (resp === "1451") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar la dimensión <b>" + nombreDimension + "</b>.<br>Existe al menos una temática con esta dimensión asignada. <br>Verifique la información e intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Error al eliminar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar la dimensión <b>" + nombreDimension + "</b>.<br>Intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Id dimension no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar la dimensión <b>" + nombreDimension + "</b>.<br>\n\
                                    No existe una dimensión con el id <b>" + idDimension + "</b>.<br> Verifique la información e intente nuevamente.";
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
        window.location.replace("index.php?action=admin/dimensiones/gestionDimensiones&conj=<?php echo $idConjuntoDimension; ?>");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#dimensiones").addClass("active");
    var conjunto = "#dimensiones" + "<?php echo $idConjuntoDimension; ?>";
    $(conjunto).addClass("active");
</script>


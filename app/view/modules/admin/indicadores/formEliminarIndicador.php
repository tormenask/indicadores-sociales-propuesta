<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/indicadores/gestionIndicadores&conj=<?php echo $respIdConjuntoIndicador; ?>" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de indicadores
            </a>
        </div>
    </div>
</div>

<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEliminarIndicador">
            <fieldset>
                <legend class="font-color">Eliminar indicador</legend>
                <div class="form-group control-group">
                    <label class="col-md-4 control-label" for="idIndicador">Id</label>  
                    <div class="col-md-6">
                        <div class="controls">
                            <input id="idIndicador" name="idIndicador" type="text" 
                                   placeholder="Id del indicador" class="form-control input-md" required value="<?php echo $respEliminarIndicador["idIndicador"] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nombreIndicador">Nombre</label>  
                    <div class="col-md-6">
                        <input id="nombreIndicador" name="nombreIndicador" type="text" 
                               placeholder="Nombre del indicador" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarIndicador["nombreIndicador"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="descripcionIndicador">Nombre</label>  
                    <div class="col-md-6">
                        <input id="nombreIndicador" name="descripcionIndicador" type="text" 
                               placeholder="Descripción del indicador" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarIndicador["descripcionIndicador"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="conjuntoIndicador">Conjunto de indicadores</label>
                    <div class="col-md-6">
                        <select id="conjuntoIndicador" name="conjuntoIndicador" class="form-control" disabled>
                            <?php
                            $conjuntoEd = new ConjuntoIndicadoresController();
                            $conjuntoEd->listarConjuntosEditar($respIdConjuntoIndicador);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="dimensionIndicador">Dimensión</label>
                    <div class="col-md-6">
                        <select class="form-control" id="dimensionIndicador" name="dimensionIndicador" disabled>
                            <?php
                            $dimensionEd = new DimensionController();
                            $dimensionEd->listarDimensionesEditar($respIdDimensionIndicador);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="tematicaIndicador">Temática</label>
                    <div class="col-md-6">
                        <select class="form-control" id="tematicaIndicador" name="tematicaIndicador" disabled>
                            <?php
                            $tematicaEd = new TematicaController();
                            $tematicaEd->listarTematicasEditar($respIdDimensionIndicador, $respEditarIndicador["idTematica"]);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="posicion">Posición</label>  
                    <div class="col-md-6">
                        <input id="posicion" name="posicion" type="number" 
                               placeholder="Posición del indicador" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarIndicador["posicion"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="mapa">Mapa</label>  
                    <div class="col-md-6">
                        <input id="mapa" name="mapa" type="text" 
                               placeholder="Mapa del indicador" class="form-control input-md" 
                               readonly value="<?php
                               $map = $respEliminarIndicador["mapa"];
                               $mapa = htmlentities($map);
                               echo $mapa
                               ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button type="button" id="btn-confirm" name="btn-confirm" 
                                class="btn btn-primary">Eliminar indicador</button>
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-indicador-deleted">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminación exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-indicador-deleted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-indicador-deleted-ok">Aceptar</button>
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
        var nombreIndicadorModal = $("#nombreIndicador").val();
        document.getElementById("modal-content-confirm").innerHTML = "Realmente desea eliminar el indicador <b>" + nombreIndicadorModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idIndicador = $("#idIndicador").val();
        if (idIndicador === "") {
            $("#modal-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });
    $("#modal-btn-error-ok").on("click", function () {
        $("#modal-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        eliminarIndicador();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-indicador-deleted-ok").on("click", function () {
        $("#modal-indicador-deleted").modal('hide');
        window.location.replace("index.php?action=admin/indicadores/gestionIndicadores&conj=<?php echo $respIdConjuntoIndicador; ?>");
    });
</script>
<script>
    function eliminarIndicador() {
        var nombreIndicador = $("#nombreIndicador").val();
        var idIndicador = $("#idIndicador").val();

        if (idIndicador === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/indicadores/funcionesIndicadores.php";
            var data = new FormData();
            data.append("idIndicadorEl", idIndicador);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Eliminado") {
                        document.getElementById("modal-content-indicador-deleted").innerHTML = "El indicador <b>" + nombreIndicador + "</b> ha sido eliminado correctamente.";
                        $("#modal-indicador-deleted").modal('show');
                    } else if (resp === "1451") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el indicador <b>" + nombreIndicador + "</b>.<br>Existe al menos un elemento con este indicador asignado. <br>Verifique la información e intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Error al eliminar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el indicador <b>" + nombreIndicador + "</b>.<br>Intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Id indicador no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el indicador <b>" + nombreIndicador + "</b>.<br>\n\
                                    No existe un indicador con el id <b>" + idIndicador + "</b>.<br> Verifique la información e intente nuevamente.";
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
        window.location.replace("index.php?action=admin/indicadores/gestionIndicadores&conj=<?php echo $respIdConjuntoIndicador; ?>");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#indicadores").addClass("active");
    var conjunto = "#indicadores" + "<?php echo $respIdConjuntoIndicador; ?>";
    $(conjunto).addClass("active");
</script>
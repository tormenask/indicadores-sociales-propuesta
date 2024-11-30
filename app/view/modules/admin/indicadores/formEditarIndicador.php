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
        <form class="form-horizontal" id="formEditarIndicador">
            <fieldset>
                <legend class="font-color">Editar indicador</legend>
                <div class="form-group control-group">
                    <label class="col-md-4 control-label" for="idIndicador">Id</label>
                    <div class="col-md-6">
                        <div class="controls">
                            <input id="idIndicador" name="idIndicador" type="text" 
                                   placeholder="Id del indicador"
                                   class="form-control input-md" required 
                                   value="<?php echo $respEditarIndicador["idIndicador"] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nombreIndicador">Nombre</label>  
                    <div class="col-md-6">
                        <input id="nombreIndicador" name="nombreIndicador" type="text" 
                               placeholder="Nombre del indicador" class="form-control input-md" required
                               value="<?php echo $respEditarIndicador["nombreIndicador"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="descripcionIndicador">Descripción</label>
                    <div class="col-md-6">
                        <input id="descripcionIndicador" name="descripcionIndicador" type="text" 
                               placeholder="Descripción del indicador" class="form-control input-md"
                               value="<?php echo $respEditarIndicador["descripcionIndicador"] ?>">
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
                               value="<?php echo $respEditarIndicador["posicion"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="mapa">Mapa</label>  
                    <div class="col-md-6">
                        <textarea id="mapa" name="mapa" type="text" style="resize: vertical;"
                                  placeholder="Mapa del indicador" class="form-control input-md" 
                                  value="<?php
                                  $map = $respEditarIndicador["mapa"];
                                  $mapa = htmlentities($map);
                                  echo $mapa
                                  ?>"><?php
                                      $map = $respEditarIndicador["mapa"];
                                      $mapa = htmlentities($map);
                                      echo $mapa
                                      ?></textarea>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Confirmación</h4>
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-indicador-edited">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >Edición exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-indicador-edited"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-indicador-edited-ok">Aceptar</button>
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
        var nombreIndicadorModal = $("#nombreIndicador").val();
        document.getElementById("modal-content-edited").innerHTML = "Confirma la edición del indicador <b>" + nombreIndicadorModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idIndicador = $("#idIndicador").val();
        var nombreIndicador = $("#nombreIndicador").val();
        var idTematica = $("#tematicaIndicador").val();
        if (idIndicador === "" || nombreIndicador === "" || idTematica === "" ||
                idIndicador === null || nombreIndicador === null || idTematica === null) {
            $("#modal-form-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });

    $("#modal-btn-form-error-ok").on("click", function () {
        $("#modal-form-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        editarIndicador();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-indicador-edited-ok").on("click", function () {
        $("#modal-indicador-edited").modal('hide');
        window.location.replace("index.php?action=admin/indicadores/gestionIndicadores&conj=<?php echo $respIdConjuntoIndicador; ?>");
    });
</script>
<script>
    function editarIndicador() {
        var idIndicador = $("#idIndicador").val();
        var nombreIndicador = $("#nombreIndicador").val();
        var descripcionIndicador = $("#descripcionIndicador").val();
        var posicion = $("#posicion").val();
        var mapa = $("#mapa").val();
        var idTematica = $("#tematicaIndicador").val();
        if (idIndicador === "" || nombreIndicador === "" || idTematica === "" ||
                idIndicador === null || nombreIndicador === null || idTematica === null) {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/indicadores/funcionesIndicadores.php";
            var data = new FormData();
            data.append("idIndicadorEd", idIndicador);
            data.append("nombreIndicadorEd", nombreIndicador);
            data.append("descripcionIndicadorEd", descripcionIndicador);
            data.append("posicionEd", posicion);
            data.append("mapaEd", mapa);
            data.append("idTematicaEd", idTematica);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Editado") {
                        document.getElementById("modal-content-indicador-edited").innerHTML = "El indicador <b>" + nombreIndicador + "</b> ha sido editado correctamente.";
                        $("#modal-indicador-edited").modal('show');
                    } else if (resp === "Error al editar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar el indicador <b>" + nombreIndicador + "</b>.<br>Intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Nombre indicador en uso") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar el indicador <b>" + nombreIndicador + "</b>.<br>\n\
                                    Ya existe un indicador con este nombre, en la temática seleccionada.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id tematica no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar el indicador <b>" + nombreIndicador + "</b>.<br>\n\
                                    No existe una temática con el Id ingresado.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id indicador no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar el indicador <b>" + nombreIndicador + "</b>.<br>\n\
                                    No existe un indicador con el Id ingresado.<br> Verifique la información e intente nuevamente.";
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
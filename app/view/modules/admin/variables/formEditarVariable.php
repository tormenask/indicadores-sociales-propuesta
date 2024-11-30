<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/variables/gestionVariables&conj=<?php echo $respEditarVariable["idConjuntoIndicadores"]; ?>" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de variables
            </a>
        </div>
    </div>
</div>

<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEditarVariable">
            <fieldset>
                <legend class="font-color">Editar variable</legend>
                <div class="form-group control-group">
                    <label class="col-md-3 control-label" for="idVariable">Id</label>
                    <div class="col-md-7">
                        <div class="controls">
                            <input name="idVariable" id="idVariable" type="text" 
                                   placeholder="Id de la variable"
                                   class="form-control input-md" required 
                                   value="<?php echo $respEditarVariable["idVariable"] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="nombreVariable">Nombre de la variable</label>
                    <div class="col-md-7">
                        <input id="nombreVariable" name="nombreVariable" type="text" placeholder="Nombre de la variable" class="form-control input-md" 
                               value="<?php echo $respEditarVariable["nombreVariable"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="conjuntoVariable">Conjunto de indicadores</label>
                    <div class="col-md-7">
                        <select id="conjuntoVariable" name="conjuntoVariable" class="form-control" disabled>
                            <?php
                            $conjuntoEd = new ConjuntoIndicadoresController();
                            $conjuntoEd->listarConjuntosEditar($respEditarVariable["idConjuntoIndicadores"]);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="tipoDatoVariable">Numerador o denominador</label>
                    <div class="col-md-7">
                        <select id="tipoDatoVariable" name="tipoDatoVariable" class="form-control">
                            <?php
                            if ($respEditarVariable["tipoDato"] == "Numerador") {
                                echo '                            
                                    <option value="Numerador" selected>Numerador</option>
                                    <option value="Denominador">Denominador</option>';
                            } else {
                                echo '                            
                                    <option value="Numerador">Numerador</option>
                                    <option value="Denominador" selected>Denominador</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="tipoZonaGeograficaVariable">Tipo de zona geográfica</label>
                    <div class="col-md-7">
                        <input id="tipoZonaGeograficaVariable" name="tipoZonaGeograficaVariable" type="text" placeholder="Tipo de zona geográfica de la variable" class="form-control input-md" 
                               value="<?php echo $respEditarVariable["tipoZonaGeografica"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="zonaGeograficaVariable">Zona geográfica</label>
                    <div class="col-md-7">
                        <input id="zonaGeograficaVariable" name="zonaGeograficaVariable" type="text" placeholder="Zona geográfica de la variable" class="form-control input-md" 
                               value="<?php echo $respEditarVariable["zonaGeografica"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="periodicidadVariable">Periodicidad</label>
                    <div class="col-md-7">
                        <input id="periodicidadVariable" name="periodicidadVariable" type="text" placeholder="Periodicidad de la variable" class="form-control input-md" 
                               value="<?php echo $respEditarVariable["periodicidad"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="entidadCompiladoraVariable">Entidad compiladora</label>
                    <div class="col-md-7">
                        <input id="entidadCompiladoraVariable" name="entidadCompiladoraVariable" type="text" placeholder="Entidad compiladora de los datos de la variable" class="form-control input-md" 
                               value="<?php echo $respEditarVariable["entidadCompiladora"] ?>" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="fuenteDatosVariable">Fuente de datos</label>
                    <div class="col-md-7">
                        <input id="fuenteDatosVariable" name="fuenteDatosVariable" type="text" placeholder="Fuente de datos de la variable" class="form-control input-md" 
                               value="<?php echo $respEditarVariable["fuenteDatos"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="urlFuenteDatosVariable">URL de la fuente de datos</label>
                    <div class="col-md-7">
                        <input id="urlFuenteDatosVariable" name="urlFuenteDatosVariable" type="text" placeholder="URL de la fuente de datos de la variable" class="form-control input-md" 
                               value="<?php echo $respEditarVariable["urlFuenteDatos"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="desagregacionTematicaVariable">Desagregación temática</label>
                    <div class="col-md-7">
                        <input id="desagregacionTematicaVariable" name="desagregacionTematicaVariable" type="text" placeholder="Desagregación temática de la variable" class="form-control input-md" 
                               value="<?php echo $respEditarVariable["desagregacionTematica"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="notasVariable">Notas</label>
                    <div class="col-md-7">
                        <textarea rows="4" cols="50" id="notasVariable" name="notasVariable" type="text" placeholder="Notas sobre la variable" class="form-control input-md" required=""><?php echo $respEditarVariable["notas"] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="unidadMedidaVariable">Unidad de medida</label>
                    <div class="col-md-7">
                        <input id="unidadMedidaVariable" name="unidadMedidaVariable" type="text" placeholder="Unidad de medida de la variable" class="form-control input-md" 
                               value="<?php echo $respEditarVariable["unidadMedida"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-7">
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-variable-edited">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >Edición exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-variable-edited"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-variable-edited-ok">Aceptar</button>
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
        var nombreVariableModal = $("#nombreVariable").val();
        document.getElementById("modal-content-edited").innerHTML = "Confirma la edición de la variable <b>" + nombreVariableModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idVariable = $("#idVariable").val();
        var conjuntoVariable = $("#conjuntoVariable").val();
        var nombreVariable = $("#nombreVariable").val();
        var tipoDatoVariable = $("#tipoDatoVariable").val();
        var tipoZonaGeograficaVariable = $("#tipoZonaGeograficaVariable").val();
        var zonaGeograficaVariable = $("#zonaGeograficaVariable").val();
        var periodicidadVariable = $("#periodicidadVariable").val();
        var entidadCompiladoraVariable = $("#entidadCompiladoraVariable").val();
        var fuenteDatosVariable = $("#fuenteDatosVariable").val();
        var urlFuenteDatosVariable = $("#urlFuenteDatosVariable").val();
        var desagregacionTematicaVariable = $("#desagregacionTematicaVariable").val();
        var notasVariable = $("#notasVariable").val();
        var unidadMedidaVariable = $("#unidadMedidaVariable").val();
        if (
                idVariable === "" || conjuntoVariable === "" || nombreVariable === "" ||
                tipoDatoVariable === "" || tipoZonaGeograficaVariable === "" ||
                zonaGeograficaVariable === "" || periodicidadVariable === "" ||
                entidadCompiladoraVariable === "" || fuenteDatosVariable === "" ||
                urlFuenteDatosVariable === "" || desagregacionTematicaVariable === "" ||
                notasVariable === "" || unidadMedidaVariable === ""
                ) {
            document.getElementById("modal-content-error").innerHTML = "Todos los campos son obligatorios.<br>Verfique la información e intente nuevamente.";
            $("#modal-form-error").modal('show');
        } else if (conjuntoVariable === "Seleccione") {
            document.getElementById("modal-content-error").innerHTML = "Debe seleccionar un conjunto de indicadores. Verifique la información e intente nuevamente.";
            $("#modal-form-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });

    $("#modal-btn-form-error-ok").on("click", function () {
        $("#modal-form-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        editarVariable();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-variable-edited-ok").on("click", function () {
        $("#modal-variable-edited").modal('hide');
        window.location.replace("index.php?action=admin/variables/gestionVariables&conj=<?php echo $respEditarVariable["idConjuntoIndicadores"]; ?>");
    });
</script>
<script>
    function editarVariable() {
        var idVariable = $("#idVariable").val();
        var conjuntoVariable = $("#conjuntoVariable").val();
        var nombreVariable = $("#nombreVariable").val();
        var tipoDatoVariable = $("#tipoDatoVariable").val();
        var tipoZonaGeograficaVariable = $("#tipoZonaGeograficaVariable").val();
        var zonaGeograficaVariable = $("#zonaGeograficaVariable").val();
        var periodicidadVariable = $("#periodicidadVariable").val();
        var entidadCompiladoraVariable = $("#entidadCompiladoraVariable").val();
        var fuenteDatosVariable = $("#fuenteDatosVariable").val();
        var urlFuenteDatosVariable = $("#urlFuenteDatosVariable").val();
        var desagregacionTematicaVariable = $("#desagregacionTematicaVariable").val();
        var notasVariable = $("#notasVariable").val();
        var unidadMedidaVariable = $("#unidadMedidaVariable").val();
        if (
                idVariable === "" || conjuntoVariable === "" || nombreVariable === "" ||
                tipoDatoVariable === "" || tipoZonaGeograficaVariable === "" ||
                zonaGeograficaVariable === "" || periodicidadVariable === "" ||
                entidadCompiladoraVariable === "" || fuenteDatosVariable === "" ||
                urlFuenteDatosVariable === "" || desagregacionTematicaVariable === "" ||
                notasVariable === "" || unidadMedidaVariable === ""
                ) {
            document.getElementById("modal-content-error").innerHTML = "Todos los campos son obligatorios.<br>Verfique la información e intente nuevamente.";
            $("#modal-form-error").modal('show');
        } else if (conjuntoVariable === "Seleccione") {
            document.getElementById("modal-content-error").innerHTML = "Debe seleccionar un conjunto de indicadores. Verifique la información e intente nuevamente.";
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/variables/funcionesVariables.php";
            var data = new FormData();
            data.append("idVariableEd", idVariable);
            data.append("nombreVariableEd", nombreVariable);
            data.append("conjuntoVariableEd", conjuntoVariable);
            data.append("tipoDatoVariableEd", tipoDatoVariable);
            data.append("tipoZonaGeograficaVariableEd", tipoZonaGeograficaVariable);
            data.append("zonaGeograficaVariableEd", zonaGeograficaVariable);
            data.append("periodicidadVariableEd", periodicidadVariable);
            data.append("entidadCompiladoraVariableEd", entidadCompiladoraVariable);
            data.append("fuenteDatosVariableEd", fuenteDatosVariable);
            data.append("urlFuenteDatosVariableEd", urlFuenteDatosVariable);
            data.append("desagregacionTematicaVariableEd", desagregacionTematicaVariable);
            data.append("notasVariableEd", notasVariable);
            data.append("unidadMedidaVariableEd", unidadMedidaVariable);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Editada") {
                        document.getElementById("modal-content-variable-edited").innerHTML = "La variable <b>" + nombreVariable + "</b> ha sido editada correctamente.";
                        $("#modal-variable-edited").modal('show');
                    } else if (resp === "Error al editar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la variable <b>" + nombreVariable + "</b>.<br>Intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id variable no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la variable <b>" + nombreVariable + "</b>.<br>\n\
                                    No existe una variable con el Id ingresado.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Nombre variable existe en conjunto") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la variable <b>" + nombreVariable + "</b>.<br>\n\
                                    Ya existe una variable con el nombre ingresado en el conjunto seleccionado.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la variable <b>" + nombreVariable + "</b>.<br>Intente nuevamente.";
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
        window.location.replace("index.php?action=admin/variables/gestionVariables&conj=<?php echo $respEditarVariable["idConjuntoIndicadores"]; ?>");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#variables").addClass("active");
    var conjunto = "#variables" + "<?php echo $respEditarVariable["idConjuntoIndicadores"]; ?>";
    $(conjunto).addClass("active");
</script>
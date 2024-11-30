<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/variables/gestionVariables&conj=<?php echo $respEliminarVariable["idConjuntoIndicadores"]; ?>" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de variables
            </a>
        </div>
    </div>
</div>

<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEliminarVariable">
            <fieldset>
                <legend class="font-color">Eliminar variables</legend>
                <div class="form-group control-group">
                    <label class="col-md-3 control-label" for="idVariable">Id</label>  
                    <div class="col-md-7">
                        <div class="controls">
                            <input id="idVariable" name="idVariable" type="text" 
                                   placeholder="Id de la variable" class="form-control input-md" required 
                                   value="<?php echo $respEliminarVariable["idVariable"] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="nombreVariable">Nombre de la variable</label>
                    <div class="col-md-7">
                        <input id="nombreVariable" name="nombreVariable" type="text" placeholder="Nombre de la variable" class="form-control input-md" 
                               value="<?php echo $respEliminarVariable["nombreVariable"] ?>"
                               readonly required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="conjuntoVariable">Conjunto de indicadores</label>
                    <div class="col-md-7">
                        <select id="conjuntoVariable" name="conjuntoVariable" class="form-control" disabled>
                            <?php
                            $conjuntoEd = new ConjuntoIndicadoresController();
                            $conjuntoEd->listarConjuntosEditar($respEliminarVariable["idConjuntoIndicadores"]);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="tipoDatoVariable">Numerador o denominador</label>
                    <div class="col-md-7">
                        <select id="tipoDatoVariable" name="tipoDatoVariable" class="form-control" disabled>
                            <?php
                            if ($respEliminarVariable["tipoDato"] == "Numerador") {
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
                        <input id="tipoZonaGeograficaVariable" name="tipoZonaGeograficaVariable" disabled
                               type="text" placeholder="Tipo de zona geográfica de la variable" class="form-control input-md" 
                               value="<?php echo $respEliminarVariable["tipoZonaGeografica"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="zonaGeograficaVariable">Zona geográfica</label>
                    <div class="col-md-7">
                        <input id="zonaGeograficaVariable" name="zonaGeograficaVariable" disabled
                               type="text" placeholder="Zona geográfica de la variable" class="form-control input-md" 
                               value="<?php echo $respEliminarVariable["zonaGeografica"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="periodicidadVariable">Periodicidad</label>
                    <div class="col-md-7">
                        <input id="periodicidadVariable" name="periodicidadVariable" disabled 
                               type="text" placeholder="Periodicidad de la variable" class="form-control input-md" 
                               value="<?php echo $respEliminarVariable["periodicidad"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="entidadCompiladoraVariable">Entidad compiladora</label>
                    <div class="col-md-7">
                        <input id="entidadCompiladoraVariable" name="entidadCompiladoraVariable" disabled 
                               type="text" placeholder="Entidad compiladora de los datos de la variable" class="form-control input-md" 
                               value="<?php echo $respEliminarVariable["entidadCompiladora"] ?>" 
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="fuenteDatosVariable">Fuente de datos</label>
                    <div class="col-md-7">
                        <input id="fuenteDatosVariable" name="fuenteDatosVariable" disabled 
                               type="text" placeholder="Fuente de datos de la variable" class="form-control input-md" 
                               value="<?php echo $respEliminarVariable["fuenteDatos"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="urlFuenteDatosVariable">URL de la fuente de datos</label>
                    <div class="col-md-7">
                        <input id="urlFuenteDatosVariable" name="urlFuenteDatosVariable" disabled 
                               type="text" placeholder="URL de la fuente de datos de la variable" class="form-control input-md" 
                               value="<?php echo $respEliminarVariable["urlFuenteDatos"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="desagregacionTematicaVariable">Desagregación temática</label>
                    <div class="col-md-7">
                        <input id="desagregacionTematicaVariable" name="desagregacionTematicaVariable" disabled 
                               type="text" placeholder="Desagregación temática de la variable" class="form-control input-md" 
                               value="<?php echo $respEliminarVariable["desagregacionTematica"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="notasVariable">Notas</label>
                    <div class="col-md-7">
                        <textarea rows="4" cols="50" id="notasVariable" name="notasVariable" disabled 
                                  type="text" placeholder="Notas sobre la variable" class="form-control input-md" required=""><?php echo $respEliminarVariable["notas"] ?>
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="unidadMedidaVariable">Unidad de medida</label>
                    <div class="col-md-7">
                        <input id="unidadMedidaVariable" name="unidadMedidaVariable" disabled 
                               type="text" placeholder="Unidad de medida de la variable" class="form-control input-md" 
                               value="<?php echo $respEliminarVariable["unidadMedida"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button type="button" id="btn-confirm" name="btn-confirm" 
                                class="btn btn-primary">Eliminar variable</button>
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-variable-deleted">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminación exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-variable-deleted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-variable-deleted-ok">Aceptar</button>
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
        var nombreVariableModal = $("#nombreVariable").val();
        document.getElementById("modal-content-confirm").innerHTML = "¿Realmente desea eliminar la variable<b>" + nombreVariableModal + "</b>?";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idVariable = $("#idVariable").val();
        if (idVariable === "") {
            $("#modal-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });
    $("#modal-btn-error-ok").on("click", function () {
        $("#modal-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        eliminarVariable();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-variable-deleted-ok").on("click", function () {
        $("#modal-variable-deleted").modal('hide');
        window.location.replace("index.php?action=admin/variables/gestionVariables&conj=<?php echo $respEliminarVariable["idConjuntoIndicadores"]; ?>");
    });
</script>
<script>
    function eliminarVariable() {
        var idVariable = $("#idVariable").val();
        var nombreVariable = $("#nombreVariable").val();
        if (idVariable === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/variables/funcionesVariables.php";
            var data = new FormData();
            data.append("idVariableEl", idVariable);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Eliminada") {
                        document.getElementById("modal-content-variable-deleted").innerHTML = "La variable <b>" + nombreVariable + "</b> ha sido eliminada correctamente.";
                        $("#modal-variable-deleted").modal('show');
                    } else if (resp === "1451") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar la variable <b>" + nombreVariable + "</b>.<br>Existe al menos un elemento asociado a esta variable. <br>Verifique la información e intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Error al eliminar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar la variable <b>" + nombreVariable + "</b>.<br>Intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Id variable no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar la variable <b>" + nombreVariable + "</b>.<br>\n\
                                    No existe una variable con el id <b>" + idVariable + "</b>.<br> Verifique la información e intente nuevamente.";
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
        window.location.replace("index.php?action=admin/variables/gestionVariables&conj=<?php echo $respEliminarVariable["idConjuntoIndicadores"]; ?>");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#variables").addClass("active");
    var conjunto = "#variables" + "<?php echo $respEliminarVariable["idConjuntoIndicadores"]; ?>";
    $(conjunto).addClass("active");
</script>
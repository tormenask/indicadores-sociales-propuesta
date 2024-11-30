<script type="text/javascript" src="view/resources/js/datepicker-es.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css">
<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/fichasTecnicas/gestionFichasTecnicas&conj=<?php echo $respIdConjuntoFicha; ?>" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de fichas técnicas
            </a>
        </div>
    </div>
</div>
<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEliminarFicha">
            <fieldset>
                <legend class="font-color">Eliminar ficha técnica</legend>
                <div class="form-group control-group">
                    <label class="col-md-3 control-label" for="idFicha">Id</label>  
                    <div class="col-md-7">
                        <div class="controls">
                            <input name="idFicha" id="idFicha" type="text" 
                                   placeholder="Id de la ficha técnica"
                                   class="form-control input-md" required 
                                   value="<?php
                                   if ($respIdConjuntoFicha == "IGC") {
                                       echo $respEliminarFicha["idFichaTecnicaIGC"];
                                   } else {
                                       echo $respEliminarFicha["idFichaTecnica"];
                                   }
                                   ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="conjuntoFicha">Conjunto de indicadores</label>
                    <div class="col-md-7">
                        <select id="conjuntoFicha" name="conjuntoFicha" class="form-control" disabled>
                            <?php
                            $conjuntoEd = new ConjuntoIndicadoresController();
                            $conjuntoEd->listarConjuntosEditar($respIdConjuntoFicha);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="dimensionFicha">Dimensión</label>
                    <div class="col-md-7">
                        <select class="form-control" id="dimensionFicha" name="dimensionFicha" disabled>
                            <?php
                            $dimensionEd = new DimensionController();
                            $dimensionEd->listarDimensionesEditar($respIdDimensionFicha);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="tematicaFicha">Temática</label>
                    <div class="col-md-7">
                        <select class="form-control" id="tematicaFicha" name="tematicaFicha" disabled>
                            <?php
                            $tematicaEd = new TematicaController();
                            $tematicaEd->listarTematicasEditar($respIdDimensionFicha, $respIdTematicaFicha);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="indicadorFicha">Indicador</label>
                    <div class="col-md-7">
                        <select class="form-control" id="indicadorFicha" name="indicadorFicha" disabled>
                            <?php
                            $indicadorEd = new IndicadorController();
                            $indicadorEd->listarIndicadoresEditar($respIdTematicaFicha, $respIdIndicadorFicha);
                            ?>
                        </select>
                    </div>
                </div>
                <?php
                if ($respIdConjuntoFicha == "IGC") {
                    echo '
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="justificacionFicha">Justificación</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="justificacionFicha" name="justificacionFicha" type="text" placeholder="Justificación" class="form-control input-md" required="" readonly>' . $respEliminarFicha["justificacion"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="definicionFicha">Definición</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="definicionFicha" name="definicionFicha" type="text" placeholder="Definición" class="form-control input-md" required="" readonly>' . $respEliminarFicha["definicion"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="metodologiaFicha">Metodología</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="metodologiaFicha" name="metodologiaFicha" type="text" placeholder="Metodología" class="form-control input-md" required="" readonly>' . $respEliminarFicha["metodologia"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="referenciaFicha">Referencia</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="referenciaFicha" name="referenciaFicha" type="text" placeholder="Referencia" class="form-control input-md" required="" readonly>' . $respEliminarFicha["referencia"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="observacionesLimitacionesFicha">Observaciones y limitaciones</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="observacionesLimitacionesFicha" name="observacionesLimitacionesFicha" type="text" placeholder="Observaciones y limitaciones" class="form-control input-md" required="" readonly>' . $respEliminarFicha["observacionesLimitaciones"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="otrasOrganizacionesFicha">Otras organizaciones que usan el indicador</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="otrasOrganizacionesFicha" name="otrasOrganizacionesFicha" type="text" placeholder="Otras organizaciones que usan el indicador" class="form-control input-md" required="" readonly>' . $respEliminarFicha["otrasOrganizaciones"] . '</textarea>
                        </div>
                    </div>';
                } else {
                    echo '
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="siglaFicha">Sigla</label>
                        <div class="col-md-7">
                            <input id="siglaFicha" name="siglaFicha" type="text" placeholder="Sigla" class="form-control input-md" required=""
                                value=' . $respEliminarFicha["sigla"] . ' disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="justificacionFicha">Justificación</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="justificacionFicha" name="justificacionFicha" type="text" placeholder="Justificación" class="form-control input-md" required="" readonly>' . $respEliminarFicha["justificacion"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="definicionFicha">Definición</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="definicionFicha" name="definicionFicha" type="text" placeholder="Definición" class="form-control input-md" required="" readonly>' . $respEliminarFicha["definicion"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="metodosMedicionFicha">Métodos de medición</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="metodosMedicionFicha" name="metodosMedicionFicha" type="text" placeholder="Métodos de medición" class="form-control input-md" required="" readonly>' . $respEliminarFicha["metodosMedicion"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="formulasFicha">Fórmulas</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="formulasFicha" name="formulasFicha" type="text" placeholder="Fórmulas" class="form-control input-md" required="" readonly>' . $respEliminarFicha["formulas"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="variablesFicha">Variables</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="variablesFicha" name="variablesFicha" type="text" placeholder="Variables" class="form-control input-md" required="" readonly>' . $respEliminarFicha["variables"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="valoresReferenciaFicha">Valores de referencia</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="valoresReferenciaFicha" name="valoresReferenciaFicha" type="text" placeholder="Valores de referencia" class="form-control input-md" required="" readonly>' . $respEliminarFicha["valoresReferencia"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="naturalezaFicha">Naturaleza</label>
                        <div class="col-md-7">
                            <input id="naturalezaFicha" name="naturalezaFicha" type="text" placeholder="Naturaleza" class="form-control input-md" required="" readonly
                                value=' . $respEliminarFicha["naturaleza"] . '>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="desagregacionTematicaFicha">Desagregación temática</label>
                        <div class="col-md-7">
                            <input id="desagregacionTematicaFicha" name="desagregacionTematicaFicha" type="text" placeholder="Desagregación temática" class="form-control input-md" required="" readonly
                                value=' . $respEliminarFicha["desagregacionTematica"] . '>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="desagregacionGeograficaFicha">Desagregación geográfica</label>
                        <div class="col-md-7">
                            <input id="desagregacionGeograficaFicha" name="desagregacionGeograficaFicha" type="text" placeholder="Desagregación geográfica" class="form-control input-md" required="" readonly
                                value=' . $respEliminarFicha["desagregacionGeografica"] . '>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="lineaBaseFicha">Línea base</label>
                        <div class="col-md-7">
                            <input id="lineaBaseFicha" name="lineaBaseFicha" type="text" placeholder="Línea base" class="form-control input-md" required="" readonly
                                value=' . $respEliminarFicha["lineaBase"] . '>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="responsableFicha">Responsable</label>
                        <div class="col-md-7">
                            <input id="responsableFicha" name="responsableFicha" type="text" placeholder="Responsable" class="form-control input-md" required="" readonly
                                value=' . $respEliminarFicha["responsable"] . '>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="observacionesFicha">Observaciones</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="observacionesFicha" name="observacionesFicha" type="text" placeholder="Observaciones" class="form-control input-md" required="" readonly>' . $respEliminarFicha["observaciones"] . '</textarea>
                        </div>
                    </div>
                   <div class="form-group">
                        <label class="col-md-3 control-label" for="responsableFicha">Responsable</label>
                        <div class="col-md-7">
                            <input id="responsableFicha" name="responsableFicha" type="text" placeholder="Responsable" class="form-control input-md" required="" readonly
                                value=' . $respEliminarFicha["fechaElaboracion"] . '>
                        </div>
                    </div>
                   ';
                }
                ?>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="tipoGraficoFicha">Tipo de gráfico</label>
                    <div class="col-md-7">
                        <select class="form-control" id="tipoGraficoFicha" name="tipoGraficoFicha" readonly>
                            <?php
                             if ($respEliminarFicha["tipoGrafico"] == "-") {
                                echo'
                                <option selected>-</option>
                                <option>_____</option>
                                <option>Área</option>
                                <option>Barras</option>
                                <option>Barras apiladas</option>
                                <option>Lineal</option>
                                <option>Piramidal</option>';
                            } elseif ($respEliminarFicha["tipoGrafico"] == "_____") {
                                echo'
                                <option>-</option>
                                <option selected>_____</option>
                                <option>Área</option>
                                <option>Barras</option>
                                <option>Barras apiladas</option>
                                <option>Lineal</option>
                                <option>Piramidal</option>';
                            } elseif ($respEliminarFicha["tipoGrafico"] == "Área") {
                                echo'
                                <option>-</option>
                                <option>_____</option>
                                <option selected>Área</option>
                                <option>Barras</option>
                                <option>Barras apiladas</option>
                                <option>Lineal</option>
                                <option>Piramidal</option>';
                            } elseif ($respEliminarFicha["tipoGrafico"] == "Barras") {
                                echo'
                                <option>-</option>
                                <option>_____</option>
                                <option>Área</option>
                                <option selected>Barras</option>
                                <option>Barras apiladas</option>
                                <option>Lineal</option>
                                <option>Piramidal</option>';
                            } elseif ($respEliminarFicha["tipoGrafico"] == "Barras apiladas") {
                                echo'
                                <option>-</option>
                                <option>_____</option>
                                <option>Área</option>
                                <option>Barras</option>
                                <option selected>Barras apiladas</option>
                                <option>Lineal</option>
                                <option>Piramidal</option>';
                            } elseif ($respEliminarFicha["tipoGrafico"] == "Lineal") {
                                echo'
                                <option>-</option>
                                <option>_____</option>
                                <option>Área</option>
                                <option>Barras</option>
                                <option>Barras apiladas</option>
                                <option selected>Lineal</option>
                                <option>Piramidal</option>';
                            } elseif ($respEliminarFicha["tipoGrafico"] == "Piramidal") {
                                echo'
                                <option>-</option>
                                <option>_____</option>
                                <option>Área</option>
                                <option>Barras</option>
                                <option>Barras apiladas</option>
                                <option selected>Lineal</option>
                                <option>Piramidal</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button type="button" id="btn-confirm" name="btn-confirm" 
                                class="btn btn-primary">Eliminar ficha técnica</button>
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-ficha-deleted">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminación exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-ficha-deleted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-ficha-deleted-ok">Aceptar</button>
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
        var indicador = document.getElementById("indicadorFicha");
        var indicadorModal = indicador.options[indicador.selectedIndex].text;
        document.getElementById("modal-content-confirm").innerHTML = "¿Realmente desea eliminar la ficha técnica para el indicador <b>" + indicadorModal + "?</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idFicha = $("#idFicha").val();
        var conjunto = document.getElementById("conjuntoFicha");
        var valConjunto = conjunto.options[conjunto.selectedIndex].value;
        if (idFicha === "" || valConjunto === "") {
            $("#modal-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });
    $("#modal-btn-error-ok").on("click", function () {
        $("#modal-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        eliminarFicha();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-ficha-deleted-ok").on("click", function () {
        $("#modal-ficha-deleted").modal('hide');
        window.location.replace("index.php?action=admin/fichasTecnicas/gestionFichasTecnicas&conj=<?php echo $respIdConjuntoFicha; ?>");
    });
</script>
<script>
    function eliminarFicha() {
        var idFicha = $("#idFicha").val();
        var conjunto = document.getElementById("conjuntoFicha");
        var valConjunto = conjunto.options[conjunto.selectedIndex].value;
        var indicador = document.getElementById("indicadorFicha");
        var valIndicador = indicador.options[indicador.selectedIndex].text;
        if (idFicha === "" || valConjunto === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/fichasTecnicas/funcionesFichasTecnicas.php";
            var data = new FormData();
            data.append("conjuntoIndicadoresFichaEl", valConjunto);
            data.append("idFichaEl", idFicha);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Eliminada") {
                        document.getElementById("modal-content-ficha-deleted").innerHTML = "La ficha técnica para el indicador <b>" + valIndicador + "</b> ha sido eliminada correctamente.";
                        $("#modal-ficha-deleted").modal('show');
                    } else if (resp === "Error al eliminar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar la ficha técnica para el indicador <b>" + valIndicador + "</b> .<br>Intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Id ficha no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar la ficha técnica para el indicador <b>" + valIndicador + "</b> .<br>\n\
                                    No existe una ficha técnica con el id <b>" + idFicha  + "</b>.<br> Verifique la información e intente nuevamente.";
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
        window.location.replace("index.php?action=admin/fichasTecnicas/gestionFichasTecnicas&conj=<?php echo $respIdConjuntoFicha; ?>");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#fichasTecnicas").addClass("active");
    var conjunto = "#fichasTecnicas" + "<?php echo $respIdConjuntoFicha; ?>";
    $(conjunto).addClass("active");
</script>

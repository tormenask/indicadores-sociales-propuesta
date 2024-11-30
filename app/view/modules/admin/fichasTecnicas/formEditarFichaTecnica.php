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
        <form class="form-horizontal" id="formEditarFicha">
            <fieldset>
                <legend class="font-color">Editar ficha técnica</legend>
                <div class="form-group control-group">
                    <label class="col-md-3 control-label" for="idFicha">Id</label>
                    <div class="col-md-7">
                        <div class="controls">
                            <input name="idFicha" id="idFicha" type="text" 
                                   placeholder="Id de la ficha técnica"
                                   class="form-control input-md" required 
                                   value="<?php
                                   if ($respIdConjuntoFicha == "IGC") {
                                       echo $respEditarFicha["idFichaTecnicaIGC"];
                                   } else {
                                       echo $respEditarFicha["idFichaTecnica"];
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
                            <textarea rows="4" cols="50" id="justificacionFicha" name="justificacionFicha" type="text" placeholder="Justificación" class="form-control input-md" required="">' . $respEditarFicha["justificacion"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="definicionFicha">Definición</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="definicionFicha" name="definicionFicha" type="text" placeholder="Definición" class="form-control input-md" required="">' . $respEditarFicha["definicion"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="metodologiaFicha">Metodología</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="metodologiaFicha" name="metodologiaFicha" type="text" placeholder="Metodología" class="form-control input-md" required="">' . $respEditarFicha["metodologia"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="referenciaFicha">Referencia</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="referenciaFicha" name="referenciaFicha" type="text" placeholder="Referencia" class="form-control input-md" required="">' . $respEditarFicha["referencia"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="observacionesLimitacionesFicha">Observaciones y limitaciones</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="observacionesLimitacionesFicha" name="observacionesLimitacionesFicha" type="text" placeholder="Observaciones y limitaciones" class="form-control input-md" required="">' . $respEditarFicha["observacionesLimitaciones"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="otrasOrganizacionesFicha">Otras organizaciones que usan el indicador</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="otrasOrganizacionesFicha" name="otrasOrganizacionesFicha" type="text" placeholder="Otras organizaciones que usan el indicador" class="form-control input-md" required="">' . $respEditarFicha["otrasOrganizaciones"] . '</textarea>
                        </div>
                    </div>';
                } else {
                    echo '
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="siglaFicha">Sigla</label>
                        <div class="col-md-7">
                            <input id="siglaFicha" name="siglaFicha" type="text" placeholder="Sigla" class="form-control input-md" required=""
                                value=' . $respEditarFicha["sigla"] . '>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="justificacionFicha">Justificación</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="justificacionFicha" name="justificacionFicha" type="text" placeholder="Justificación" class="form-control input-md" required="">' . $respEditarFicha["justificacion"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="definicionFicha">Definición</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="definicionFicha" name="definicionFicha" type="text" placeholder="Definición" class="form-control input-md" required="">' . $respEditarFicha["definicion"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="metodosMedicionFicha">Métodos de medición</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="metodosMedicionFicha" name="metodosMedicionFicha" type="text" placeholder="Métodos de medición" class="form-control input-md" required="">' . $respEditarFicha["metodosMedicion"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="formulasFicha">Fórmulas</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="formulasFicha" name="formulasFicha" type="text" placeholder="Fórmulas" class="form-control input-md" required="">' . $respEditarFicha["formulas"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="variablesFicha">Variables</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="variablesFicha" name="variablesFicha" type="text" placeholder="Variables" class="form-control input-md" required="">' . $respEditarFicha["variables"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="valoresReferenciaFicha">Valores de referencia</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="valoresReferenciaFicha" name="valoresReferenciaFicha" type="text" placeholder="Valores de referencia" class="form-control input-md" required="">' . $respEditarFicha["valoresReferencia"] . '</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="naturalezaFicha">Naturaleza</label>
                        <div class="col-md-7">
                            <input id="naturalezaFicha" name="naturalezaFicha" type="text" placeholder="Naturaleza" class="form-control input-md" required=""
                                value=' . $respEditarFicha["naturaleza"] . '>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="desagregacionTematicaFicha">Desagregación temática</label>
                        <div class="col-md-7">
                            <input id="desagregacionTematicaFicha" name="desagregacionTematicaFicha" type="text" placeholder="Desagregación temática" class="form-control input-md" required=""
                                value=' . $respEditarFicha["desagregacionTematica"] . '>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="desagregacionGeograficaFicha">Desagregación geográfica</label>
                        <div class="col-md-7">
                            <input id="desagregacionGeograficaFicha" name="desagregacionGeograficaFicha" type="text" placeholder="Desagregación geográfica" class="form-control input-md" required=""
                                value=' . $respEditarFicha["desagregacionGeografica"] . '>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="lineaBaseFicha">Línea base</label>
                        <div class="col-md-7">
                            <input id="lineaBaseFicha" name="lineaBaseFicha" type="text" placeholder="Línea base" class="form-control input-md" required=""
                                value=' . $respEditarFicha["lineaBase"] . '>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="responsableFicha">Responsable</label>
                        <div class="col-md-7">
                            <input id="responsableFicha" name="responsableFicha" type="text" placeholder="Responsable" class="form-control input-md" required=""
                                value=' . $respEditarFicha["responsable"] . '>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="observacionesFicha">Observaciones</label>
                        <div class="col-md-7">
                            <textarea rows="4" cols="50" id="observacionesFicha" name="observacionesFicha" type="text" placeholder="Observaciones" class="form-control input-md" required="">' . $respEditarFicha["observaciones"] . '</textarea>
                        </div>
                    </div>
                    <div class="date form-group" id="datepicker" data-provide="datepicker">
                        <label class="col-md-3 control-label" for="fechaElaboracionFicha">Fecha de elaboración</label>
                        <div class="col-md-7">
                            <div class="col-md-10" style="margin-left: -15px;">
                                <input type="text" class="form-control input-md" 
                                id="fechaElaboracionFicha" name="fechaElaboracionFicha">
                            </div>
                            <div class="col-md-2 col-calendar">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(function () {
                            $("#datepicker").datepicker({}).datepicker("update", "' . $respEditarFicha["fechaElaboracion"] . '");
                        });
                    </script>';
                }
                ?>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="tipoGraficoFicha">Tipo de gráfico</label>
                    <div class="col-md-7">
                        <select class="form-control" id="tipoGraficoFicha" name="tipoGraficoFicha">
                            <?php
                            if ($respEditarFicha["tipoGrafico"] == "-") {
                                echo'
                                <option selected>-</option>
                                <option>_____</option>
                                <option>Área</option>
                                <option>Barras</option>
                                <option>Barras apiladas</option>
                                <option>Lineal</option>
                                <option>Piramidal</option>';
                            } elseif ($respEditarFicha["tipoGrafico"] == "_____") {
                                echo'
                                <option>-</option>
                                <option selected>_____</option>
                                <option>Área</option>
                                <option>Barras</option>
                                <option>Barras apiladas</option>
                                <option>Lineal</option>
                                <option>Piramidal</option>';
                            } elseif ($respEditarFicha["tipoGrafico"] == "Área") {
                                echo'
                                <option>-</option>
                                <option>_____</option>
                                <option selected>Área</option>
                                <option>Barras</option>
                                <option>Barras apiladas</option>
                                <option>Lineal</option>
                                <option>Piramidal</option>';
                            } elseif ($respEditarFicha["tipoGrafico"] == "Barras") {
                                echo'
                                <option>-</option>
                                <option>_____</option>
                                <option>Área</option>
                                <option selected>Barras</option>
                                <option>Barras apiladas</option>
                                <option>Lineal</option>
                                <option>Piramidal</option>';
                            } elseif ($respEditarFicha["tipoGrafico"] == "Barras apiladas") {
                                echo'
                                <option>-</option>
                                <option>_____</option>
                                <option>Área</option>
                                <option>Barras</option>
                                <option selected>Barras apiladas</option>
                                <option>Lineal</option>
                                <option>Piramidal</option>';
                            } elseif ($respEditarFicha["tipoGrafico"] == "Lineal") {
                                echo'
                                <option>-</option>
                                <option>_____</option>
                                <option>Área</option>
                                <option>Barras</option>
                                <option>Barras apiladas</option>
                                <option selected>Lineal</option>
                                <option>Piramidal</option>';
                            } elseif ($respEditarFicha["tipoGrafico"] == "Piramidal") {
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-ficha-edited">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edición exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-ficha-edited"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-ficha-edited-ok">Aceptar</button>
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
        var indicador = document.getElementById("indicadorFicha");
        var indicadorModal = indicador.options[indicador.selectedIndex].text;
        document.getElementById("modal-content-edited").innerHTML = "Confirma la edición de la ficha técnica para el indicador <b>" + indicadorModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var conjunto = document.getElementById("conjuntoFicha");
        var valConjunto = conjunto.options[conjunto.selectedIndex].value;
        var indicadorFicha = $("#indicadorFicha").val();
        var tipoGraficoFicha = $("#tipoGraficoFicha").val();
        var datosIncompletos = "";
        if (valConjunto === "IGC") {
            var justificacionFicha = $("#justificacionFicha").val();
            var definicionFicha = $("#definicionFicha").val();
            var metodologiaFicha = $("#metodologiaFicha").val();
            var referenciaFicha = $("#referenciaFicha").val();
            var observacionesLimitacionesFicha = $("#observacionesLimitacionesFicha").val();
            var otrasOrganizacionesFicha = $("#otrasOrganizacionesFicha").val();
            if (indicadorFicha === "" || tipoGraficoFicha === "" ||
                    justificacionFicha === "" || definicionFicha === "" ||
                    metodologiaFicha === "" || referenciaFicha === "" ||
                    observacionesLimitacionesFicha === "" || otrasOrganizacionesFicha === "") {
                datosIncompletos = true;
            } else {
                datosIncompletos = false;
            }
        } else {
            var siglaFicha = $("#siglaFicha").val();
            var justificacionFicha = $("#justificacionFicha").val();
            var definicionFicha = $("#definicionFicha").val();
            var metodosMedicionFicha = $("#metodosMedicionFicha").val();
            var formulasFicha = $("#formulasFicha").val();
            var variablesFicha = $("#variablesFicha").val();
            var valoresReferenciaFicha = $("#valoresReferenciaFicha").val();
            var naturalezaFicha = $("#naturalezaFicha").val();
            var desagregacionTematicaFicha = $("#desagregacionTematicaFicha").val();
            var desagregacionGeograficaFicha = $("#desagregacionGeograficaFicha").val();
            var lineaBaseFicha = $("#lineaBaseFicha").val();
            var responsableFicha = $("#responsableFicha").val();
            var observacionesFicha = $("#observacionesFicha").val();
            var fechaElaboracionFicha = $("#fechaElaboracionFicha").val();
            var otrasOrganizacionesFicha = $("#otrasOrganizacionesFicha").val();
            if (indicadorFicha === "" || tipoGraficoFicha === "" ||
                    siglaFicha === "" || justificacionFicha === "" ||
                    definicionFicha === "" || metodosMedicionFicha === "" ||
                    formulasFicha === "" || variablesFicha === "" ||
                    valoresReferenciaFicha === "" || naturalezaFicha === "" ||
                    desagregacionTematicaFicha === "" || desagregacionGeograficaFicha === "" ||
                    lineaBaseFicha === "" || responsableFicha === "" ||
                    observacionesFicha === "" || fechaElaboracionFicha === "" ||
                    otrasOrganizacionesFicha === "") {
                datosIncompletos = true;
            } else {
                datosIncompletos = false;
            }
        }
        if (datosIncompletos === true) {
            document.getElementById("modal-content-error").innerHTML = "Todos los campos son obligatorios.<br>Verfique la información e intente nuevamente.";
            $("#modal-form-error").modal('show');
        } else if (indicadorFicha === "Seleccione") {
            document.getElementById("modal-content-error").innerHTML = "Debe seleccionar un indicador. Verifique la información e intente nuevamente.";
            $("#modal-form-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });

    $("#modal-btn-form-error-ok").on("click", function () {
        $("#modal-form-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        editarFicha();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-ficha-edited-ok").on("click", function () {
        $("#modal-ficha-edited").modal('hide');
        window.location.replace("index.php?action=admin/fichasTecnicas/gestionFichasTecnicas&conj=<?php echo $respIdConjuntoFicha; ?>");
    });
</script>
<script>
    function editarFicha() {
        var idFicha = $("#idFicha").val();
        var conjunto = document.getElementById("conjuntoFicha");
        var valConjunto = conjunto.options[conjunto.selectedIndex].value;
        var indicador = document.getElementById("indicadorFicha");
        var valIndicador = indicador.options[indicador.selectedIndex].text;
        var indicadorFicha = $("#indicadorFicha").val();
        var tipoGraficoFicha = $("#tipoGraficoFicha").val();
        var datosIncompletos = "";
        if (valConjunto === "IGC") {
            var justificacionFichaIGC = $("#justificacionFicha").val();
            var definicionFichaIGC = $("#definicionFicha").val();
            var metodologiaFicha = $("#metodologiaFicha").val();
            var referenciaFicha = $("#referenciaFicha").val();
            var observacionesLimitacionesFicha = $("#observacionesLimitacionesFicha").val();
            var otrasOrganizacionesFicha = $("#otrasOrganizacionesFicha").val();
            if (idFicha === "" || indicadorFicha === "" || tipoGraficoFicha === "" ||
                    justificacionFichaIGC === "" || definicionFichaIGC === "" ||
                    metodologiaFicha === "" || referenciaFicha === "" ||
                    observacionesLimitacionesFicha === "" || otrasOrganizacionesFicha === "") {
                datosIncompletos = true;
            } else {
                datosIncompletos = false;
            }
        } else {
            var siglaFicha = $("#siglaFicha").val();
            var justificacionFicha = $("#justificacionFicha").val();
            var definicionFicha = $("#definicionFicha").val();
            var metodosMedicionFicha = $("#metodosMedicionFicha").val();
            var formulasFicha = $("#formulasFicha").val();
            var variablesFicha = $("#variablesFicha").val();
            var valoresReferenciaFicha = $("#valoresReferenciaFicha").val();
            var naturalezaFicha = $("#naturalezaFicha").val();
            var desagregacionTematicaFicha = $("#desagregacionTematicaFicha").val();
            var desagregacionGeograficaFicha = $("#desagregacionGeograficaFicha").val();
            var lineaBaseFicha = $("#lineaBaseFicha").val();
            var responsableFicha = $("#responsableFicha").val();
            var observacionesFicha = $("#observacionesFicha").val();
            var fechaElaboracionFicha = $("#fechaElaboracionFicha").val();
            var otrasOrganizacionesFicha = $("#otrasOrganizacionesFicha").val();
            if (idFicha === "" || indicadorFicha === "" || tipoGraficoFicha === "" ||
                    siglaFicha === "" || justificacionFicha === "" ||
                    definicionFicha === "" || metodosMedicionFicha === "" ||
                    formulasFicha === "" || variablesFicha === "" ||
                    valoresReferenciaFicha === "" || naturalezaFicha === "" ||
                    desagregacionTematicaFicha === "" || desagregacionGeograficaFicha === "" ||
                    lineaBaseFicha === "" || responsableFicha === "" ||
                    observacionesFicha === "" || fechaElaboracionFicha === "" ||
                    otrasOrganizacionesFicha === "") {
                datosIncompletos = true;
            } else {
                datosIncompletos = false;
            }
        }
        if (datosIncompletos === true) {
            document.getElementById("modal-content-error").innerHTML = "Todos los campos son obligatorios.<br>Verfique la información e intente nuevamente.";
            $("#modal-form-error").modal('show');
        } else if (indicadorFicha === "Seleccione") {
            document.getElementById("modal-content-error").innerHTML = "Debe seleccionar un indicador. Verifique la información e intente nuevamente.";
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/fichasTecnicas/funcionesFichasTecnicas.php";
            var data = new FormData();
            if (valConjunto === "IGC") {
                data.append("idFichaIGCEd", idFicha);
                data.append("justificacionFichaIGCEd", justificacionFichaIGC);
                data.append("definicionFichaIGCEd", definicionFichaIGC);
                data.append("metodologiaFichaIGCEd", metodologiaFicha);
                data.append("referenciaFichaIGCEd", referenciaFicha);
                data.append("observacionesLimitacionesFichaIGCEd", observacionesLimitacionesFicha);
                data.append("otrasOrganizacionesFichaIGCEd", otrasOrganizacionesFicha);
                data.append("indicadorFichaIGCEd", indicadorFicha);
                data.append("tipoGraficoFichaIGCEd", tipoGraficoFicha);
            } else {
                data.append("idFichaEd", idFicha);
                data.append("conjuntoIndicadoresFichaEd", valConjunto);
                data.append("siglaFichaEd", siglaFicha);
                data.append("justificacionFichaEd", justificacionFicha);
                data.append("definicionFichaEd", definicionFicha);
                data.append("metodosMedicionFichaEd", metodosMedicionFicha);
                data.append("formulasFichaEd", formulasFicha);
                data.append("variablesFichaEd", variablesFicha);
                data.append("valoresReferenciaFichaEd", valoresReferenciaFicha);
                data.append("naturalezaFichaEd", naturalezaFicha);
                data.append("desagregacionTematicaFichaEd", desagregacionTematicaFicha);
                data.append("desagregacionGeograficaFichaEd", desagregacionGeograficaFicha);
                data.append("lineaBaseFichaEd", lineaBaseFicha);
                data.append("responsableFichaEd", responsableFicha);
                data.append("observacionesFichaEd", observacionesFicha);
                data.append("fechaElaboracionFichaEd", fechaElaboracionFicha);
                data.append("indicadorFichaEd", indicadorFicha);
                data.append("tipoGraficoFichaEd", tipoGraficoFicha);
            }
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    $("#formEditarFicha")[0].reset();
                    $('#dimensionFicha').prop('disabled', 'disabled');
                    $('#tematicaFicha').prop('disabled', 'disabled');
                    $('#indicadorFicha').prop('disabled', 'disabled');
                    if (resp === "Editada") {
                        document.getElementById("modal-content-ficha-edited").innerHTML = "La ficha técnica para el indicador <b>" + valIndicador + "</b> ha sido editada correctamente.";
                        $("#modal-ficha-edited").modal('show');
                    } else if (resp === "Error al editar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la ficha técnica para el indicador <b>" + valIndicador + "</b>.<br>Intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id indicador no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la ficha técnica para el indicador <b>" + valIndicador + "</b>.<br>\n\
                                    No existe el id del indicador seleccionado.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id ficha no pertenece indicador") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la ficha técnica para el indicador <b>" + valIndicador + "</b>. El id de la ficha no se encuentra asociada al indicador seleccionado.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id ficha no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la ficha técnica para el indicador <b>" + valIndicador + "</b>. El id de la ficha no existe.<br> Verifique la información e intente nuevamente.";
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
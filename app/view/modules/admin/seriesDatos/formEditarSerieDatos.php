<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/seriesDatos/gestionSeriesDatos&conj=<?php echo $respIdConjuntoSerie; ?>" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de series de datos
            </a>
        </div>
    </div>
</div>

<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEditarSerie">
            <fieldset>
                <legend class="font-color">Editar serie de datos</legend>
                <div class="form-group control-group">
                    <label class="col-md-3 control-label" for="idSerie">Id</label>
                    <div class="col-md-7">
                        <div class="controls">
                            <input name="idSerie" id="idSerie" type="text" 
                                   placeholder="Id de la serie de datos"
                                   class="form-control input-md" required 
                                   value="<?php echo $respEditarSerie["idSerieDatos"] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="conjuntoSerie">Conjunto de indicadores</label>
                    <div class="col-md-7">
                        <select id="conjuntoSerie" name="conjuntoSerie" class="form-control" disabled>
                            <?php
                            $conjuntoEd = new ConjuntoIndicadoresController();
                            $conjuntoEd->listarConjuntosEditar($respIdConjuntoSerie);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="dimensionSerie">Dimensión</label>
                    <div class="col-md-7">
                        <select class="form-control" id="dimensionSerie" name="dimensionSerie" disabled>
                            <?php
                            $dimensionEd = new DimensionController();
                            $dimensionEd->listarDimensionesEditar($respIdDimensionSerie);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="tematicaSerie">Temática</label>
                    <div class="col-md-7">
                        <select class="form-control" id="tematicaSerie" name="tematicaSerie" disabled>
                            <?php
                            $tematicaEd = new TematicaController();
                            $tematicaEd->listarTematicasEditar($respIdDimensionSerie, $respIdTematicaSerie);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="indicadorSerie">Indicador</label>
                    <div class="col-md-7">
                        <select class="form-control" id="indicadorSerie" name="indicadorSerie" disabled>
                            <?php
                            $indicadorEd = new IndicadorController();
                            $indicadorEd->listarIndicadoresEditar($respIdTematicaSerie, $respIdIndicadorSerie);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="tipoDatoSerie">Tipo de datos</label>
                    <div class="col-md-7">
                        <input id="tipoDatoSerie" name="tipoDatoSerie" 
                               type="text" placeholder="Tipo de datos de la serie" class="form-control input-md" 
                               value="<?php echo $respEditarSerie["tipoDato"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="geografiaSerie">Tipo de zona geográfica</label>
                    <div class="col-md-7">
                        <input id="geografiaSerie" name="geografiaSerie" type="text" placeholder="Tipo de zona geográfica de la serie" class="form-control input-md" 
                               value="<?php echo $respEditarSerie["tipoZonaGeografica"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="zonaActualSerie">Zona geográfica</label>
                    <div class="col-md-7">
                        <input id="zonaActualSerie" name="zonaActualSerie" type="text" placeholder="Zona geográfica de la serie" class="form-control input-md" 
                               value="<?php echo $respEditarSerie["zonaGeografica"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="periodicidadSerie">Periodicidad</label>
                    <div class="col-md-7">
                        <input id="periodicidadSerie" name="periodicidadSerie" type="text" placeholder="Periodicidad de la serie" class="form-control input-md" 
                               value="<?php echo $respEditarSerie["periodicidad"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="entidadGeneradoraSerie">Entidad compiladora</label>
                    <div class="col-md-7">
                        <input id="entidadGeneradoraSerie" name="entidadGeneradoraSerie" type="text" placeholder="Entidad compiladora de los datos de la serie" class="form-control input-md" 
                               value="<?php echo $respEditarSerie["entidadCompiladora"] ?>" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="fuenteDatosSerie">Fuente de datos</label>
                    <div class="col-md-7">
                        <input id="fuenteDatosSerie" name="fuenteDatosSerie" type="text" placeholder="Fuente de datos de la serie" class="form-control input-md" 
                               value="<?php echo $respEditarSerie["fuenteDatos"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="urlDatosSerie">URL de la fuente datos</label>
                    <div class="col-md-7">
                        <input id="urlDatosSerie" name="urlDatosSerie" type="text" placeholder="URL de la fuente de datos de la serie" class="form-control input-md" 
                               value="<?php echo $respEditarSerie["urlFuenteDatos"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="desagregacionTematicaSerie">Desagregación temática</label>
                    <div class="col-md-7">
                        <input id="desagregacionTematicaSerie" name="desagregacionTematicaSerie" type="text" placeholder="Desagregación temática de la serie" class="form-control input-md" 
                               value="<?php echo $respEditarSerie["desagregacionTematica"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="notasSerie">Notas</label>
                    <div class="col-md-7">
                        <textarea rows="4" cols="50" id="notasSerie" name="notasSerie" type="text" placeholder="Notas sobre la serie" class="form-control input-md" required=""><?php echo $respEditarSerie["notas"] ?>
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="unidadMedicionSerie">Unidad de medida</label>
                    <div class="col-md-7">
                        <input id="unidadMedicionSerie" name="unidadMedicionSerie" type="text" placeholder="Unidad de medida de la serie" class="form-control input-md" 
                               value="<?php echo $respEditarSerie["unidadMedida"] ?>"
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-serie-edited">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >Edición exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-serie-edited"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-serie-edited-ok">Aceptar</button>
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
        var desagregacionTematicaModal = $("#desagregacionTematicaSerie").val();
        document.getElementById("modal-content-edited").innerHTML = "Confirma la edición de la serie de datos para la desagregación temática <b>" + desagregacionTematicaModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idSerie = $("#idSerie").val();
        var indicadorSerie = $("#indicadorSerie").val();
        var tipoDatosSerie = $("#tipoDatoSerie").val();
        var geografiaSerie = $("#geografiaSerie").val();
        var zonaActualSerie = $("#zonaActualSerie").val();
        var periodicidadSerie = $("#periodicidadSerie").val();
        var entidadGeneradoraSerie = $("#entidadGeneradoraSerie").val();
        var fuenteDatosSerie = $("#fuenteDatosSerie").val();
        var urlDatosSerie = $("#urlDatosSerie").val();
        var desagregacionTematicaSerie = $("#desagregacionTematicaSerie").val();
        var notasSerie = $("#notasSerie").val();
        var unidadMedicionSerie = $("#unidadMedicionSerie").val();
        if (
                idSerie === "" || indicadorSerie === "" ||
                tipoDatosSerie === "" || geografiaSerie === "" ||
                zonaActualSerie === "" || periodicidadSerie === "" ||
                entidadGeneradoraSerie === "" || fuenteDatosSerie === "" ||
                urlDatosSerie === "" || desagregacionTematicaSerie === "" ||
                notasSerie === "" || unidadMedicionSerie === ""
                ) {
            document.getElementById("modal-content-error").innerHTML = "Todos los campos son obligatorios.<br>Verfique la información e intente nuevamente.";
            $("#modal-form-error").modal('show');
        } else if (indicadorSerie === "Seleccione") {
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
        editarSerie();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-serie-edited-ok").on("click", function () {
        $("#modal-serie-edited").modal('hide');
        window.location.replace("index.php?action=admin/seriesDatos/gestionSeriesDatos&conj=<?php echo $respIdConjuntoSerie; ?>");
    });
</script>
<script>
    function editarSerie() {
        var idSerie = $("#idSerie").val();
        var indicadorSerie = $("#indicadorSerie").val();
        var tipoDatosSerie = $("#tipoDatoSerie").val();
        var geografiaSerie = $("#geografiaSerie").val();
        var zonaActualSerie = $("#zonaActualSerie").val();
        var periodicidadSerie = $("#periodicidadSerie").val();
        var entidadGeneradoraSerie = $("#entidadGeneradoraSerie").val();
        var fuenteDatosSerie = $("#fuenteDatosSerie").val();
        var urlDatosSerie = $("#urlDatosSerie").val();
        var desagregacionTematicaSerie = $("#desagregacionTematicaSerie").val();
        var notasSerie = $("#notasSerie").val();
        var unidadMedicionSerie = $("#unidadMedicionSerie").val();
        if (
                idSerie === "" || idSerie === null ||
                indicadorSerie === "" || indicadorSerie === null ||
                tipoDatosSerie === "" || tipoDatosSerie === null ||
                geografiaSerie === "" || geografiaSerie === null ||
                zonaActualSerie === "" || zonaActualSerie === null ||
                periodicidadSerie === "" || periodicidadSerie === null ||
                entidadGeneradoraSerie === "" || entidadGeneradoraSerie === null ||
                fuenteDatosSerie === "" || fuenteDatosSerie === null ||
                urlDatosSerie === "" || urlDatosSerie === null ||
                desagregacionTematicaSerie === "" || desagregacionTematicaSerie === null ||
                notasSerie === "" || notasSerie === null ||
                unidadMedicionSerie === "" || unidadMedicionSerie === null
                ) {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/seriesDatos/funcionesSeriesDatos.php";
            var data = new FormData();
            data.append("idSerieEd", idSerie);
            data.append("indicadorSerieEd", indicadorSerie);
            data.append("tipoDatosSerieEd", tipoDatosSerie);
            data.append("geografiaSerieEd", geografiaSerie);
            data.append("zonaActualSerieEd", zonaActualSerie);
            data.append("periodicidadSerieEd", periodicidadSerie);
            data.append("entidadGeneradoraSerieEd", entidadGeneradoraSerie);
            data.append("fuenteDatosSerieEd", fuenteDatosSerie);
            data.append("urlDatosSerieEd", urlDatosSerie);
            data.append("desagregacionTematicaSerieEd", desagregacionTematicaSerie);
            data.append("notasSerieEd", notasSerie);
            data.append("unidadMedicionSerieEd", unidadMedicionSerie);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Editada") {
                        document.getElementById("modal-content-serie-edited").innerHTML = "La serie ha sido editada correctamente.";
                        $("#modal-serie-edited").modal('show');
                    } else if (resp === "Error al editar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la serie.<br>Intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id indicador no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la serie.<br>\n\
                                    No existe un indicador con el Id ingresado.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id serie no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la serie.<br>\n\
                                    No existe una serie con el Id ingresado.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Serie existe en indicador") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la serie.<br>\n\
                                    Una serie con los datos suministrados ya existe para el indicador.<br> Verifique la información: Zona geográfica, Fuente de dato, Desagregación temática e intente nuevamente.";
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
        window.location.replace("index.php?action=admin/seriesDatos/gestionSeriesDatos&conj=<?php echo $respIdConjuntoSerie; ?>");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#seriesDatos").addClass("active");
    var conjunto = "#seriesDatos" + "<?php echo $respIdConjuntoSerie; ?>";
    $(conjunto).addClass("active");
</script>
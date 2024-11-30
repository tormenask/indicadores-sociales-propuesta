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
        <form class="form-horizontal" id="formEliminarSerie">
            <fieldset>
                <legend class="font-color">Eliminar serie de datos</legend>
                <div class="form-group control-group">
                    <label class="col-md-3 control-label" for="idSerie">Id</label>  
                    <div class="col-md-7">
                        <div class="controls">
                            <input id="idSerie" name="idSerie" type="text" 
                                   placeholder="Id de la serie" class="form-control input-md" required 
                                   value="<?php echo $respEliminarSerie["idSerieDatos"] ?>" readonly>
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
                        <input id="tipoDatoSerie" name="tipoDatoSerie" disabled
                               type="text" placeholder="Tipo de datos de la serie" class="form-control input-md" 
                               value="<?php echo $respEliminarSerie["tipoDato"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="geografiaSerie">Tipo de zona geográfica</label>
                    <div class="col-md-7">
                        <input id="geografiaSerie" name="geografiaSerie" disabled
                               type="text" placeholder="Tipo de zona geográfica de la serie" class="form-control input-md" 
                               value="<?php echo $respEliminarSerie["tipoZonaGeografica"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="zonaActualSerie">Zona geográfica</label>
                    <div class="col-md-7">
                        <input id="zonaActualSerie" name="zonaActualSerie" disabled
                               type="text" placeholder="Zona geográfica de la serie" class="form-control input-md" 
                               value="<?php echo $respEliminarSerie["zonaGeografica"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="periodicidadSerie">Periodicidad</label>
                    <div class="col-md-7">
                        <input id="periodicidadSerie" name="periodicidadSerie" disabled 
                               type="text" placeholder="Periodicidad de la serie" class="form-control input-md" 
                               value="<?php echo $respEliminarSerie["periodicidad"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="entidadGeneradoraSerie">Entidad compiladora</label>
                    <div class="col-md-7">
                        <input id="entidadGeneradoraSerie" name="entidadGeneradoraSerie" disabled 
                               type="text" placeholder="Entidad compiladora de los datos de la serie" class="form-control input-md" 
                               value="<?php echo $respEliminarSerie["entidadCompiladora"] ?>"                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="fuenteDatosSerie">Fuente de datos</label>
                    <div class="col-md-7">
                        <input id="fuenteDatosSerie" name="fuenteDatosSerie" disabled 
                               type="text" placeholder="Fuente de datos de la serie" class="form-control input-md" 
                               value="<?php echo $respEliminarSerie["fuenteDatos"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="urlDatosSerie">URL de la fuente de datos</label>
                    <div class="col-md-7">
                        <input id="urlDatosSerie" name="urlDatosSerie" disabled 
                               type="text" placeholder="URL de la fuente de datos de la serie" class="form-control input-md" 
                               value="<?php echo $respEliminarSerie["urlFuenteDatos"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="desagregacionTematicaSerie">Desagregación temática</label>
                    <div class="col-md-7">
                        <input id="desagregacionTematicaSerie" name="desagregacionTematicaSerie" disabled 
                               type="text" placeholder="Desagregación temática de la serie" class="form-control input-md" 
                               value="<?php echo $respEliminarSerie["desagregacionTematica"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="notasSerie">Notas</label>
                    <div class="col-md-7">
                        <textarea rows="4" cols="50" id="notasSerie" name="notasSerie" disabled 
                                  type="text" placeholder="Notas sobre la serie" class="form-control input-md" required=""><?php echo $respEliminarSerie["notas"] ?>
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="unidadMedicionSerie">Unidad de medida</label>
                    <div class="col-md-7">
                        <input id="unidadMedicionSerie" name="unidadMedicionSerie" disabled 
                               type="text" placeholder="Unidad de medida de la serie" class="form-control input-md" 
                               value="<?php echo $respEliminarSerie["unidadMedida"] ?>"
                               required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button type="button" id="btn-confirm" name="btn-confirm" 
                                class="btn btn-primary">Eliminar serie de datos</button>
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-serie-deleted">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminación exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-serie-deleted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-serie-deleted-ok">Aceptar</button>
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
        document.getElementById("modal-content-confirm").innerHTML = "¿Realmente desea eliminar la serie de datos?";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idSerie = $("#idSerie").val();
        if (idSerie === "") {
            $("#modal-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });
    $("#modal-btn-error-ok").on("click", function () {
        $("#modal-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        eliminarSerie();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-serie-deleted-ok").on("click", function () {
        $("#modal-serie-deleted").modal('hide');
        window.location.replace("index.php?action=admin/seriesDatos/gestionSeriesDatos&conj=<?php echo $respIdConjuntoSerie; ?>");
    });
</script>
<script>
    function eliminarSerie() {
        var idSerie = $("#idSerie").val();
        if (idSerie === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/seriesDatos/funcionesSeriesDatos.php";
            var data = new FormData();
            data.append("idSerieDatosEl", idSerie);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Eliminada") {
                        document.getElementById("modal-content-serie-deleted").innerHTML = "La serie de datos ha sido eliminada correctamente.";
                        $("#modal-serie-deleted").modal('show');
                    } else if (resp === "1451") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar la serie de datos.<br>Existe al menos un dato asociado a esta serie. <br>Verifique la información e intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Error al eliminar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar la serie de datos.<br>Intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Id serie no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar la serie de datos.<br>\n\
                                    No existe una serie de datos con el id <b>" + idSerie + "</b>.<br> Verifique la información e intente nuevamente.";
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
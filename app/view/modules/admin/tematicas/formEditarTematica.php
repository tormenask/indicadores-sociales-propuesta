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
        <form class="form-horizontal" id="formEditarTematica">
            <fieldset>
                <legend class="font-color">Editar temática</legend>
                <div class="form-group control-group">
                    <label class="col-md-4 control-label" for="idTematica">Id</label>
                    <div class="col-md-6">
                        <div class="controls">
                            <input id="idTematica" name="idTematica" type="text" 
                                   placeholder="Id de la temática" 
                                   class="form-control input-md" required 
                                   value="<?php echo $respEditarTematica["idTematica"] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nombreTematica">Nombre</label>  
                    <div class="col-md-6">
                        <input id="nombreTematica" name="nombreTematica" type="text" 
                               placeholder="Nombre de la temática" class="form-control input-md" required
                               value="<?php echo $respEditarTematica["nombreTematica"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="descripcionTematica">Descripción</label>  
                    <div class="col-md-6">
                        <input id="descripcionTematica" name="descripcionTematica" type="text" 
                               placeholder="Descripción de la temática" class="form-control input-md" 
                               value="<?php echo $respEditarTematica["descripcionTematica"] ?>">
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
                            $dimensionEd->listarDimensionesEditar($respEditarTematica["idDimension"]);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="posicion">Posición</label>  
                    <div class="col-md-6">
                        <input id="posicion" name="posicion" type="number" 
                               placeholder="Posición de la temática" class="form-control input-md" required
                               value="<?php echo $respEditarTematica["posicion"] ?>">
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-tematica-edited">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >Edición exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-tematica-edited"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-tematica-edited-ok">Aceptar</button>
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
    $(document).ready(function () {
        $('#conjuntoTematica').on('change', function () {
            var conjunto = document.getElementById("conjuntoTematica");
            var valConjunto = conjunto.options[conjunto.selectedIndex].value;
            if (valConjunto !== "Seleccione") {
                var url = "view/modules/admin/dimensiones/funcionesDimensiones.php";
                var data = new FormData();
                data.append("conjuntoTem", valConjunto);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (resp) {
                        $('#dimensionTematica').html(resp);
                        $('#dimensionTematica').prop('disabled', false);
                    }
                });
            } else {
                $('#dimensionTematica').empty();
                $('#dimensionTematica').prop('disabled', 'disabled');
            }
        });
    });
</script>
<script>
    $('#modal-confirm').on('shown.bs.modal', function (e) {
        var nombreTematicaModal = $("#nombreTematica").val();
        document.getElementById("modal-content-edited").innerHTML = "Confirma la edición de la temática <b>" + nombreTematicaModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idTematica = $("#idTematica").val();
        var nombreTematica = $("#nombreTematica").val();
        var idDimension = $("#dimensionTematica").val();
        if (idTematica === "" || nombreTematica === "" || idDimension === "" ||
                idTematica === null || nombreTematica === null || idDimension === null) {
            $("#modal-form-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });

    $("#modal-btn-form-error-ok").on("click", function () {
        $("#modal-form-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        editarTematica();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-tematica-edited-ok").on("click", function () {
        $("#modal-tematica-edited").modal('hide');
        window.location.replace("index.php?action=admin/tematicas/gestionTematicas&conj=<?php echo $respIdConjuntoTematica; ?>");
    });
</script>
<script>
    function editarTematica() {
        var idTematica = $("#idTematica").val();
        var nombreTematica = $("#nombreTematica").val();
        var descripcionTematica = $("#descripcionTematica").val();
        var idDimension = $("#dimensionTematica").val();
        var posicion = $("#posicion").val();
        if (idTematica === "" || nombreTematica === "" || idDimension === "" ||
                idTematica === null || nombreTematica === null || idDimension === null) {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/tematicas/funcionesTematicas.php";
            var data = new FormData();
            data.append("idTematicaEd", idTematica);
            data.append("nombreTematicaEd", nombreTematica);
            data.append("descripcionTematicaEd", descripcionTematica);
            data.append("idDimensionEd", idDimension);
            data.append("posicionEd", posicion);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Editada") {
                        document.getElementById("modal-content-tematica-edited").innerHTML = "La temática <b>" + nombreTematica + "</b> ha sido editada correctamente.";
                        $("#modal-tematica-edited").modal('show');
                    } else if (resp === "Error al editar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la temática <b>" + nombreTematica + "</b>.<br>Intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Nombre tematica en uso") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la temática <b>" + nombreTematica + "</b>.<br>\n\
                                    Ya existe una temática con este nombre, en la dimensión seleccionada.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id dimension no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la temática <b>" + nombreTematica + "</b>.<br>\n\
                                    No existe una dimensión con el Id ingresado.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id tematica no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la temática <b>" + nombreTematica + "</b>.<br>\n\
                                    No existe una temática con el Id ingresado.<br> Verifique la información e intente nuevamente.";
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


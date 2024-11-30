<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/indicadoresvariables/gestionIndicadoresvariables&conj=<?php echo $respConjuntoIndV; ?>" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de relaciones Indicador - Variable
            </a>
        </div>
    </div>
</div>
<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEditarRelacion">
            <fieldset>
                <legend class="font-color">Editar relación Indicador - Variable</legend>
                <div class="form-group control-group">
                    <label class="col-md-4 control-label" for="idIndV">Id</label>
                    <div class="col-md-6">
                        <input id="idIndV" name="idIndV" type="text" 
                               placeholder="Id de la relación" 
                               class="form-control input-md" required 
                               value="<?php echo $respEditarIndV["id"] ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="indicadorIndV">Indicador</label>
                    <div class="col-md-6">
                        <select id="indicadorIndV" name="indicadorIndV" class="form-control" disabled>
                            <?php
                            $indicador = new IndicadorController();
                            $indicador->listarIndicadoresEditarVariable($respConjuntoIndV, $respEditarIndV['idIndicador']);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="variableIndV">Variable</label>
                    <div class="col-md-6">
                        <select id="variableIndV" name="variableIndV" class="form-control">
                            <?php
                            $variable = new VariableController();
                            $variable->listarVariablesEditar($respConjuntoIndV, $respEditarIndV['idVariable']);
                            ?>
                        </select>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Confirmación</h4>
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-indV-edited">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >Edición exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-indV-edited"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-indV-edited-ok">Aceptar</button>
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
        var indicadorModal = $("#indicadorIndV option:selected").text();
        document.getElementById("modal-content-edited").innerHTML = "Confirma la edición de la relación para el indicador <b>" + indicadorModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idIndV = $("#idIndV").val();
        var idIndicador = $("#indicadorIndV").val();
        var idVariable = $("#variableIndV").val();
        if (idIndV === "" || idIndicador === "" || idVariable === "") {
            $("#modal-form-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });

    $("#modal-btn-form-error-ok").on("click", function () {
        $("#modal-form-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        editarRelacion();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-indV-edited-ok").on("click", function () {
        $("#modal-indV-edited").modal('hide');
        window.location.replace("index.php?action=admin/indicadoresvariables/gestionIndicadoresvariables&conj=" + "<?php echo $respConjuntoIndV; ?>");
    });
</script>
<script>
    function editarRelacion() {
        var idIndV = $("#idIndV").val();
        var idIndicador = $("#indicadorIndV").val();
        var idVariable = $("#variableIndV").val();
        var nombreIndicador = $("#indicadorIndV option:selected").text();
        if (idIndV === "" || idIndicador === "" || idVariable === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/indicadoresVariables/funcionesIndicadoresVariables.php";
            var data = new FormData();
            data.append("idIndVEd", idIndV);
            data.append("indicadorIndVEd", idIndicador);
            data.append("variableIndVEd", idVariable);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Editada") {
                        document.getElementById("modal-content-indV-edited").innerHTML = "La relación para el indicador <b>" + nombreIndicador + "</b> ha sido editada correctamente.";
                        $("#modal-indV-edited").modal('show');
                    } else if (resp === "Error al editar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la relación para el indicador <b>" + nombreIndicador + "</b>.<br>Intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id relacion no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la relación para el indicador <b>" + nombreIndicador + "</b>.<br>\n\
                                    No existe una relación para este indicador, con el id ingresado.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id variable no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la relación para el indicador <b>" + nombreIndicador + "</b>.<br>\n\
                                    No existe una variable con el Id ingresado.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id indicador no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la relación para el indicador <b>" + nombreIndicador + "</b>.<br>\n\
                                    No existe un indicador con el Id ingresado.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Relacion existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la relación para el indicador <b>" + nombreIndicador + "</b>. Ya existe la relación.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Tipo dato existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la relación para el indicador <b>" + nombreIndicador + "</b>. Ya existe una relación creada con una variable de este tipo (numerador o denominador).<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la relación para el indicador <b>" + nombreIndicador + "</b>.<br>Intente nuevamente.";
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
        window.location.replace("index.php?action=admin/indicadoresvariables/gestionIndicadoresvariables&conj=" + "<?php echo $respConjuntoIndV; ?>");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#indicadoresvariables").addClass("active");
    var conjunto = "#indicadoresvariables" + "<?php echo $respConjuntoIndV; ?>";
    $(conjunto).addClass("active");
</script>


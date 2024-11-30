<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/dimensiones/gestionDimensiones&conj=<?php echo $idConjuntoDimension; ?>" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de dimensiones
            </a>
        </div>
    </div>
</div>

<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEditarDimension">
            <fieldset>
                <legend class="font-color">Editar dimensión</legend>
                <div class="form-group control-group">
                    <label class="col-md-4 control-label" for="idDimension">Id</label>
                    <div class="col-md-6">
                        <div class="controls">
                            <input id="idDimension" name="idDimension" type="text" 
                                   placeholder="Id de la dimensión" 
                                   class="form-control input-md" required 
                                   value="<?php echo $respEditarDimension["idDimension"] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nombreDimension">Nombre</label>  
                    <div class="col-md-6">
                        <input id="nombreDimension" name="nombreDimension" type="text" placeholder="Nombre de la dimensión" class="form-control input-md" required
                               value="<?php echo $respEditarDimension["nombreDimension"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="descripcionDimension">Nombre</label>  
                    <div class="col-md-6">
                        <input id="descripcionDimension" name="descripcionDimension" type="text" placeholder="Descripción de la dimensión" class="form-control input-md"
                               value="<?php echo $respEditarDimension["descripcionDimension"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="conjuntoDimension">Conjunto de indicadores</label>
                    <div class="col-md-6">
                        <select id="conjuntoDimension" disabled name="conjuntoDimension" class="form-control">
                            <?php
                            $conjuntoEd = new ConjuntoIndicadoresController();
                            $conjuntoEd->listarConjuntosEditar($respEditarDimension["idConjuntoIndicadores"]);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="posicion">Posición</label>  
                    <div class="col-md-6">
                        <input id="posicion" name="posicion" type="number" placeholder="Posición de la dimensión" class="form-control input-md"  value="<?php echo $respEditarDimension["posicion"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="icono">Icono</label>  
                    <div class="col-md-6">
                        <input id="icono" name="Icono" type="file" 
                               accept = ".png, .jpeg,.jpg"
                               placeholder="Seleccione un icono" class="form-control input-md"  value="">
                    </div>
                </div>
                <div class="form-group" >
                    <label class="col-md-4 control-label" for="color">Color</label>  
                    <div class="col-md-2">
                        <input type="color" value="<?php echo $respEditarDimension["color"] ?>" class="form-control" id="color" />
                    </div>
                    <div class="col-md-2">
                        <input type="text" value="<?php echo $respEditarDimension["color"] ?>" class="form-control" id="color1" />
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-dimension-edited">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >Edición exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-dimension-edited"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-dimension-edited-ok">Aceptar</button>
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
    $('#color').on('change', function () {
        $('#color1').val(this.value);
    });
    $('#color1').on('change', function () {
        $('#color').val(this.value);
    });
</script>
<script>
    $('#modal-confirm').on('shown.bs.modal', function (e) {
        var nombreDimensionModal = $("#nombreDimension").val();
        document.getElementById("modal-content-edited").innerHTML = "Confirma la edición de la dimensión <b>" + nombreDimensionModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idDimension = $("#idDimension").val();
        var nombreDimension = $("#nombreDimension").val();
        var descripcionDimension = $("#descripcionDimension").val();
        var idConjunto = $("#conjuntoDimension").val();
        if (idDimension === "" || nombreDimension === "" || idConjunto === "") {
            $("#modal-form-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });

    $("#modal-btn-form-error-ok").on("click", function () {
        $("#modal-form-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        editarDimension();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-dimension-edited-ok").on("click", function () {
        $("#modal-dimension-edited").modal('hide');
        window.location.replace("index.php?action=admin/dimensiones/gestionDimensiones&conj=" + "<?php echo $idConjuntoDimension; ?>");
    });
</script>
<script>
    function editarDimension() {
        var idDimension = $("#idDimension").val();
        var nombreDimension = $("#nombreDimension").val();
        var descripcionDimension = $("#descripcionDimension").val();
       console.log(descripcionDimension);
        var idConjunto = $("#conjuntoDimension").val();
        var posicion = $("#posicion").val();
        var color = $("#color").val();
        if (idDimension === "" || nombreDimension === "" || idConjunto === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/dimensiones/funcionesDimensiones.php";
            var data = new FormData();
            data.append("idDimensionEd", idDimension);
            data.append("nombreDimensionEd", nombreDimension);
            data.append("descripcionDimensionEd", descripcionDimension);
            data.append("idConjuntoEd", idConjunto);
            data.append("posicionEd", posicion);
            var icono = document.getElementById('icono');
            var uploadFile = icono.files[0];
            console.log(icono);
            if (icono.files.length !== 0) {
                jQuery.each($('input[type=file]')[0].files, function (i, file) {
                    console.log(file["size"]);
                    if (file["size"] > 1000000) {
                        document.getElementById("modal-content-error").innerHTML = "Error al crear el icono. <br> El archivo excede el peso máximo de 1 Mb.<br>Intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else {
                        data.append('file', true);
                        data.append('iconoEd', uploadFile);
                    }
                });
            } else {
                data.append('file', false);
            }
            data.append("colorEd", color);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Editada") {
                        document.getElementById("modal-content-dimension-edited").innerHTML = "La dimensión <b>" + nombreDimension + "</b> ha sido editada correctamente.";
                        $("#modal-dimension-edited").modal('show');
                    } else if (resp === "Error al editar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la dimensión <b>" + nombreDimension + "</b>.<br>Intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Nombre dimension en uso") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la dimensión <b>" + nombreDimension + "</b>.<br>\n\
                                    Ya existe una dimensión con este nombre, en el conjunto de indicadores seleccionado.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id dimension no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la dimensión <b>" + nombreDimension + "</b>.<br>\n\
                                    No existe una dimensión con el Id ingresado.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id conjunto no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar la dimensión <b>" + nombreDimension + "</b>.<br>\n\
                                    No existe un conjunto de indicadores con el Id ingresado.<br> Verifique la información e intente nuevamente.";
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
        window.location.replace("index.php?action=admin/dimensiones/gestionDimensiones&conj=" + "<?php echo $idConjuntoDimension; ?>");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#dimensiones").addClass("active");
    var conjunto = "#dimensiones" + "<?php echo $idConjuntoDimension; ?>";
    $(conjunto).addClass("active");
</script>


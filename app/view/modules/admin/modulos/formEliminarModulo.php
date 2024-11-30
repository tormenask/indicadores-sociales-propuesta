<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/modulos/gestionModulos" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de Módulos
            </a>
        </div>
    </div>
</div>

<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEliminarModulo">
            <fieldset>
                <legend class="font-color">Eliminar módulo</legend>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="idModulo">Id</label>  
                    <div class="col-md-6">
                        <input id="idModulo" name="idModulo" type="text" placeholder="Id del módulo" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarModulo["idModulo"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nombreModulo">Nombre</label>  
                    <div class="col-md-6">
                        <input id="nombreModulo" name="nombreModulo" type="text" placeholder="Nombre del módulo" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarModulo["nombreModulo"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="disponibleConjuntos">Disponible para conjuntos de indicadores</label>  
                    <div class="col-md-6">
                        <select id="disponibleConjuntos" name="disponibleConjuntos" class="form-control" disabled>
                            <?php
                            if ($respEliminarModulo["disponibleConjuntos"] == '1') {
                                echo '<option value="1" selected>Si</option>
                                      <option value="2">No</option>';
                            } else {
                                echo '<option value="1">Si</option>
                                      <option value="2" selected>No</option>';
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="iconoModulo">Icono</label>  
                    <div class="col-md-6">
                        <!--<div class="picker">-->
                        <input type="text" readonly placeholder="Icono del módulo" disabled
                               value="<?php echo $respEliminarModulo["iconoModulo"] ?>"
                               id="iconoModulo" name="iconoModulo">
                        <!--</div>-->
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="abreviatura">Abreviatura</label>
                    <div class="col-md-6">
                        <input id="abreviatura" name="abreviatura" type="text" readonly disabled
                               placeholder="Abreviatura del módulo" class="form-control input-md" required
                               value="<?php echo $respEliminarModulo["abreviatura"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Eliminar módulo</button>
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-modulo-deleted">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Eliminación exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-modulo-deleted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-modulo-deleted-ok">Aceptar</button>
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
        var nombreModuloModal = $("#nombreModulo").val();
        document.getElementById("modal-content-confirm").innerHTML = "Realmente desea eliminar el módulo <b>" + nombreModuloModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idModulo = $("#idModulo");
        if (idModulo === "") {
            $("#modal-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });
    $("#modal-btn-error-ok").on("click", function () {
        $("#modal-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        eliminarModulo();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-modulo-deleted-ok").on("click", function () {
        $("#modal-modulo-deleted").modal('hide');
        window.location.replace("index.php?action=admin/modulos/gestionModulos");
    });
</script>
<script>
    function eliminarModulo() {
        var nombreModulo = $("#nombreModulo").val();
        var idModulo = "<?php echo $respEliminarModulo["idModulo"] ?>";
        if (idModulo === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/modulos/funcionesModulos.php";
            var data = new FormData();
            data.append("idModuloEl", idModulo);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Eliminado") {
                        document.getElementById("modal-content-modulo-deleted").innerHTML = "El módulo <b>" + nombreModulo + "</b> ha sido eliminado correctamente.";
                        $("#modal-modulo-deleted").modal('show');
                    } else if (resp === "1451") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el módulo <b>" + nombreModulo + "</b>.<br>Existe al menos un elemento con este módulo asociado. <br>Verifique la información e intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Error al eliminar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el módulo <b>" + nombreModulo + "</b>.<br>Intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Id no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el módulo <b>" + nombreModulo + "<b>.<br>\n\
                                    No existe un módulo con el id <b>" + idModulo + "<b>.<br> Verifique la información e intente nuevamente.";
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
        window.location.replace("index.php?action=admin/modulos/gestionModulos");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#modulos").addClass("active");
</script>
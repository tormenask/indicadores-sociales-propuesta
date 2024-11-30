<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/estados/gestionEstados" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de Estados
            </a>
        </div>
    </div>
</div>

<div class="row" style="padding-top: 20px;">
    <div class="col-sm-10 col-sm-offset-1">
        <form class="form-horizontal" id="formEliminarEstado">
            <fieldset>
                <legend class="font-color">Eliminar estado</legend>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="idEstado">Id</label>  
                    <div class="col-md-6">
                        <input id="idEstado" name="idEstado" type="text" placeholder="Id del estado" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarEstado["idEstado"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nombreEstado">Nombre</label>  
                    <div class="col-md-6">
                        <input id="nombreEstado" name="nombreEstado" type="text" placeholder="Nombre del estado" class="form-control input-md" required
                               readonly value="<?php echo $respEliminarEstado["nombreEstado"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="descripcionEstado">Descripción</label>  
                    <div class="col-md-6">
                        <textarea id="descripcionEstado" readonly name="descripcionEstado" placeholder="Descripción del estado" class="form-control" required><?php echo $respEliminarEstado["descripcionEstado"] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Eliminar estado</button>
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-estado-deleted">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Eliminación exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-estado-deleted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-estado-deleted-ok">Aceptar</button>
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
        var nombreEstadoModal = $("#nombreEstado").val();
        document.getElementById("modal-content-confirm").innerHTML = "Realmente desea eliminar el estado <b>" + nombreEstadoModal +"</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idEstado = $("#idEstado");
        if (idEstado === "") {
            $("#modal-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });
    $("#modal-btn-error-ok").on("click", function () {
        $("#modal-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        eliminarEstado();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-estado-deleted-ok").on("click", function () {
        $("#modal-estado-deleted").modal('hide');
        window.location.replace("index.php?action=admin/estados/gestionEstados");
    });
</script>
<script>
    function eliminarEstado() {
        var nombreEstado = $("#nombreEstado").val();
        var idEstado = "<?php echo $respEliminarEstado["idEstado"] ?>";
        if (idEstado === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/estados/funcionesEstados.php";
            var data = new FormData();
            data.append("idEstadoEl", idEstado);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Eliminado") {
                        document.getElementById("modal-content-estado-deleted").innerHTML = "El estado <b>" + nombreEstado + "</b> ha sido eliminado correctamente.";
                        $("#modal-estado-deleted").modal('show');
                    } else if (resp === "1451") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el estado <b>" + nombreEstado + "</b>.<br>Existe al menos un usuario con este estado asignado. <br>Verifique la información e intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Error al eliminar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el estado <b>" + nombreEstado + "</b>.<br>Intente nuevamente.";
                        $("#modal-error").modal('show');
                    } else if (resp === "Id no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar el estado <b>" + nombreEstado + "<b>.<br>\n\
                                    No existe un estado con el id <b>" + idEstado + "<b>.<br> Verifique la información e intente nuevamente.";
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
        window.location.replace("index.php?action=admin/estados/gestionEstados");
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
<script>
    $("#estados").addClass("active");
</script>
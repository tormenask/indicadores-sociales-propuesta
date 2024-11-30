<div class="row">
    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
        <div class="btn-group">
            <a href="index.php?action=admin/roles/gestionRoles" class="btn btn-primary" role="button">
                <i class="fa fa-arrow-left"></i>
                Volver a Gestión de Roles
            </a>
        </div>
    </div>
</div>
<div class="row" style="padding: 20px;">
    <div class="col-sm-12">
        <legend class="font-color">Gestión de permisos</legend>
    </div>
</div>
<style>
    .img-right {margin-right: 1em;font-size: 1.5em;color: #999;}
    .text-center.text-margin {margin: 20px 0px 20px 0px;}
    .container {background-color: #F5F5F5;margin-top: 1em;margin-bottom: 1em;}
    .btn-primary {float: right;}
</style>
<?php
$modulo = new ModuloController();
$modulo->crearPanelModulo($idRol);
?>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-confirm">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header active">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirmación</h4>
            </div>
            <div class="modal-body">
                <p id="modal-content-create" name="modal-content-create"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modal-btn-si">Si</button>
                <button type="button" class="btn btn-default" id="modal-btn-no">No</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-edited">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header active">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edición exitosa</h4>
            </div>
            <div class="modal-body">
                <p id="modal-content-edited"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="modal-btn-edited-ok">Aceptar</button>
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
                <p id="modal-content-error"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="modal-btn-form-error-ok">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="nombreModulo" name="nombreModulo" value="" />
<script>
    $("#modal-btn-si").on("click", function () {
        var nombreModulo = $("#nombreModulo").val();
        cambiarPermisos(nombreModulo);
        $("#modal-confirm").modal("hide");
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-edited-ok").on("click", function () {
        $("#modal-edited").modal('hide');
        location.reload();
    });
</script>
<script>
    function cambiarPermisos(nombreModulo) {
        var idRol = "<?php echo $idRol; ?>";
        var crear = $("#crear_" + nombreModulo).is(":checked") ? "1" : "0";
        var modificar = $("#modificar_" + nombreModulo).is(":checked") ? "1" : "0";
        var eliminar = $("#eliminar_" + nombreModulo).is(":checked") ? "1" : "0";
        var url = "view/modules/admin/roles/funcionesRoles.php";
        var data = new FormData();
        data.append("idRolPerm", idRol);
        data.append("nombreModuloPerm", nombreModulo);
        data.append("crearPerm", crear);
        data.append("modificarPerm", modificar);
        data.append("eliminarPerm", eliminar);
        $.ajax({
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (resp) {
                if (resp === "Editado") {
                    document.getElementById("modal-content-edited").innerHTML = "Los permisos para el módulo <b>" + nombreModulo + "</b> han sido editados correctamente.";
                    $("#modal-edited").modal('show');
                } else if (resp === "Error al editar") {
                    document.getElementById("modal-content-error").innerHTML = "Error al editar los permisos para el módulo <b>" + nombreModulo + "</b>.<br>Intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else if (resp === "Id no existe") {
                    document.getElementById("modal-content-error").innerHTML = "Error al editar los permisos para el módulo <b>" + nombreModulo + "</b>.<br>\n\
                                    El id <b>" + idRol + "</b> no existe.<br> Verifique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                }
                console.log(resp);
            }
        });
    }
</script>
<script>
    $("#roles").addClass("active");
</script>
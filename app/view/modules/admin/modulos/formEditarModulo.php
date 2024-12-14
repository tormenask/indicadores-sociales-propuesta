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
        <form class="form-horizontal" id="formEditarModulo">
            <fieldset>
                <legend class="font-color">Editar módulo</legend>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="idModulo">Id</label>
                    <div class="col-md-6">
                        <input id="idModulo" name="idModulo" type="text" placeholder="Id del módulo" class="form-control input-md" required
                               value="<?php echo $respEditarModulo["idModulo"] ?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nombreModulo">Nombre</label>
                    <div class="col-md-6">
                        <input id="nombreModulo" name="nombreModulo" type="text" placeholder="Nombre del módulo" class="form-control input-md" required
                               value="<?php echo $respEditarModulo["nombreModulo"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="disponibleConjuntos">Disponible para conjuntos de indicadores</label>  
                    <div class="col-md-6">
                        <select id="disponibleConjuntos" name="disponibleConjuntos" class="form-control" disabled>
                            <?php
                            if ($respEditarModulo["disponibleConjuntos"] == '1') {
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
                        <div class="picker">
                            <input type="text" readonly class="inputpicker" placeholder="Selecciona un icono"
                                   value="<?php echo $respEditarModulo["iconoModulo"] ?>"
                                   id="iconoModulo" name="iconoModulo">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="abreviatura">Abreviatura</label>
                    <div class="col-md-6">
                        <input id="abreviatura" name="abreviatura" type="text" 
                               placeholder="Abreviatura del módulo" class="form-control input-md" required
                               value="<?php echo $respEditarModulo["abreviatura"] ?>">
                    </div>
                </div>
                <style>
                    .picker {position:relative;width:100%;margin:0 auto}
                    .inputpicker {width:100%;padding:10px;background:#f2f2f2}
                    .oculto-icon {width:100%;background:#f2f2f2;border-radius:0 0 10px 10px;padding:10px;overflow:auto;max-height:200px;display:none}
                    .oculto-icon ul {display:inline;float:left;width:100%;margin:0;padding:0}
                    .oculto-icon ul li {margin:0;padding:0;display:block;width:30px;height:30px;text-align:center;font-size:15px;font-family:"fontawesome";float:left;cursor:pointer;color:#666;line-height:30px;transition:0.2s all}
                    .oculto-icon ul li:hover {background:#FFF;color:#000}
                    .oculto-icon input[type=text] { font-size:13px;padding:5px;margin:0 0 10px 0;border:1px solid #ddd; }
                </style>
                <script src="sis/app/view/resources/js/icos.js"></script>
                <script>
                    $(document).ready(function () {
                        $(".picker").each(function () {
                            div = $(this);
                            if (icos) {
                                var iconos = "<ul>";
                                for (var i = 0; i < icos.length; i++) {
                                    iconos += "<li><i data-valor='fa " + icos[i] + "' rel='" + icos[i] + "' class='fa " + icos[i] + "'></i></li>";
                                }
                                iconos += "</ul>";
                            }
                            div.append("<div class='oculto-icon'><input type='text' placeholder='Selecciona un icono'>" + iconos + "</div>");
                            $(".inputpicker").click(function () {
                                $(".oculto-icon").fadeToggle("fast");
                            });
                            $(document).on("click", ".oculto-icon ul li", function () {
                                $(".inputpicker").val($(this).find("i").data("valor"));
                                $(".oculto-icon").fadeToggle("fast");
                            });
                            $(document).on("keyup", ".oculto-icon input[type=text]", function () {
                                var value = $(this).val();
                                $(".oculto-icon ul li i").each(function () {
                                    if ($(this).attr("rel").search(value) > -1)
                                        $(this).closest("li").show();
                                    else
                                        $(this).closest("li").hide();
                                });
                            });
                        });
                    });
                </script>
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-modulo-edited">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header active">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edición exitosa</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-content-modulo-edited"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-modulo-edited-ok">Aceptar</button>
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
        var nombreModuloModal = $("#nombreModulo").val();
        document.getElementById("modal-content-edited").innerHTML = "Confirma la edición del módulo <b>" + nombreModuloModal + "</b>";
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var idModulo = $("#idModulo").val();
        var nombreModulo = $("#nombreModulo").val();
        var disponibleConjuntos = $("#disponibleConjuntos").val();
        var iconoModulo = $("#iconoModulo").val();
        var abreviatura = $("#abreviatura").val();
        if (idModulo === "" || nombreModulo === "" || disponibleConjuntos === "" || iconoModulo === "" || abreviatura === "") {
            $("#modal-form-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });
    $("#modal-btn-form-error-ok").on("click", function () {
        $("#modal-form-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        editarModulo();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-modulo-edited-ok").on("click", function () {
        $("#modal-modulo-edited").modal('hide');
        window.location.replace("index.php?action=admin/modulos/gestionModulos");
    });
</script>
<script>
    function editarModulo() {
        var idModulo = $("#idModulo").val();
        var nombreModulo = $("#nombreModulo").val();
        var disponibleConjuntos = $("#disponibleConjuntos").val();
        var iconoModulo = $("#iconoModulo").val();
        var abreviatura = $("#abreviatura").val();
        if (idModulo === "" || nombreModulo === "" || disponibleConjuntos === "" || iconoModulo === "" || abreviatura === "") {
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/modulos/funcionesModulos.php";
            var data = new FormData();
            data.append("idModuloEd", idModulo);
            data.append("nombreModuloEd", nombreModulo);
            data.append("disponibleConjuntosEd", disponibleConjuntos);
            data.append("iconoModuloEd", iconoModulo);
            data.append("abreviaturaEd", abreviatura);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    if (resp === "Editado") {
                        document.getElementById("modal-content-modulo-edited").innerHTML = "El módulo <b>" + nombreModulo + "</b> ha sido editado correctamente.";
                        $("#modal-modulo-edited").modal('show');
                    } else if (resp === "Error al editar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar el módulo <b>" + nombreModulo + "</b>.<br>Intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Nombre en uso") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar el módulo <b>" + nombreModulo + "</b>.<br>\n\
                                    Ya existe un módulo con el nombre ingresado.<br> Verifique la información e intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    } else if (resp === "Id no existe") {
                        document.getElementById("modal-content-error").innerHTML = "Error al editar el módulo <b>" + nombreModulo + "</b>.<br>\n\
                                    El id </b>" + idModulo + "</b> no existe.<br> Verifique la información e intente nuevamente.";
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


<?php
session_start();
include_once 'model/indicadorVariable.php';
include_once 'controller/indicadorVariable.php';
include_once 'model/indicador.php';
include_once 'controller/indicador.php';
include_once 'model/variable.php';
include_once 'controller/variable.php';
include_once 'model/rol.php';
include_once 'controller/rol.php';
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$idConj = "";
if (isset($_GET['conj'])) {
    $idConj = $_GET['conj'];
}
$permiso = $rol->consultarPermisoRol("indicadoresvariables" . $idConj, $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$crear && ($modificar || $eliminar)) {
    header("Location: index.php?action=admin/indicadoresVariables/gestionIndicadoresVariables&conj=" . $idConj);
}
$indicador = new IndicadorController();
$variable = new VariableController();
?>
<html>
    <?php include 'view/modules/head.php'; ?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'view/modules/header.php'; ?>
            <?php include 'view/modules/side.php'; ?>
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
                        <div class="btn-group">
                            <a href="index.php?action=admin/indicadoresvariables/gestionIndicadoresvariables&conj=<?php echo $idConj; ?>" class="btn btn-primary" role="button">
                                <i class="fa fa-arrow-left"></i>
                                Volver a Gestión de relaciones Indicadores - Variables
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top: 20px;">
                    <div class="col-sm-10 col-sm-offset-1">
                        <form class="form-horizontal" id="formCrearIndV">
                            <fieldset>
                                <legend class="font-color">Creación de relación Indicador - Variable</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="indicadorIndV">Indicador</label>
                                    <div class="col-md-6">
                                        <select id="indicadorIndV" name="indicadorIndV" class="form-control">
                                            <?php
                                            $indicador->listarIndicadoresCrear($idConj);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="variableIndV">Variable</label>
                                    <div class="col-md-6">
                                        <select id="variableIndV" name="variableIndV" class="form-control">
                                            <?php
                                            $variable->listarVariablesCrear($idConj);
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label"></label>
                                    <div class="col-md-8">
                                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Registrar</button>
                                        <button type="button" id="btnCancelar" name="btnCancelar" class="btn btn-danger">Limpiar</button>
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
                                    <p id="modal-content-create"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="modal-btn-si">Si</button>
                                    <button type="button" class="btn btn-default" id="modal-btn-no">No</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-indv-created">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header active">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Creación exitosa</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-content-indv-created"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" id="modal-btn-indv-created-ok">Aceptar</button>
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
            </div>
        </div>
        <?php include 'view/modules/footer.php'; ?>
        <script>
            $('#modal-confirm').on('shown.bs.modal', function (e) {
                var indicadorModal = $("#indicadorIndV option:selected").text();
                var variableModal = $("#variableIndV option:selected").text();
                document.getElementById("modal-content-create").innerHTML = "Confirma la creación de la relación <b>" + indicadorModal + " - " + variableModal + "</b>";
            });
        </script>
        <script>
            $("#btn-confirm").on("click", function () {
                var idIndicador = $("#indicadorIndV").val();
                var idVariable = $("#variableIndV").val();
                if (idIndicador === "" || idVariable === "") {
                    $("#modal-form-error").modal('show');
                } else {
                    $("#modal-confirm").modal('show');
                }
            });
            $("#modal-btn-form-error-ok").on("click", function () {
                $("#modal-form-error").modal('hide');
            });
            $("#modal-btn-si").on("click", function () {
                crearRelacion();
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-no").on("click", function () {
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-indv-created-ok").on("click", function () {
                $("#modal-indv-created").modal('hide');
                window.location.replace("index.php?action=admin/indicadoresvariables/gestionIndicadoresvariables&conj=<?php echo $idConj; ?>");
            });
        </script>
        <script>
            var conjunto = "#indicadoresvariables" + "<?php echo $idConj; ?>";
            $(conjunto).addClass("active");
            $("#indicadoresvariables").addClass("active");
        </script>
        <script>
            function crearRelacion() {
                var idIndicador = $("#indicadorIndV").val();
                var idVariable = $("#variableIndV").val();
                var nombreIndicador = $("#indicadorIndV option:selected").text();
                var nombreVariable = $("#variableIndV option:selected").text();
                if (idIndicador === "" || idVariable === "") {
                    $("#modal-form-error").modal('show');
                } else {
                    var url = "view/modules/admin/indicadoresVariables/funcionesIndicadoresVariables.php";
                    var data = new FormData();
                    data.append("indicadorIndV", idIndicador);
                    data.append("variableIndV", idVariable);
                    $.ajax({
                        url: url,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function (resp) {
                            $("#formCrearIndV")[0].reset();
                            if (resp === "Creada") {
                                document.getElementById("modal-content-indv-created").innerHTML = "La relación <b>" + nombreIndicador + " - " + nombreVariable + "</b> ha sido creada correctamente.";
                                $("#modal-indv-created").modal('show');
                            } else if (resp === "Error al crear") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la relación <b>" + nombreIndicador + " - " + nombreVariable + "</b>.<br>Intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Id variable no existe") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la relación <b>" + nombreIndicador + " - " + nombreVariable + "</b>.<br>\n\
                                    No existe el id de la variable seleccionada.<br> Verifique la información e intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Id indicador no existe") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la relación <b>" + nombreIndicador + " - " + nombreVariable + "</b>.<br>\n\
                                    No existe el id del indicador seleccionado.<br> Verifique la información e intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Tipo dato existe") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la relación <b>" + nombreIndicador + " - " + nombreVariable + "</b>. Ya existe una relación creada con una variable de este tipo (numerador o denominador).<br> Verifique la información e intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Relacion existe") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la relación <b>" + nombreIndicador + " - " + nombreVariable + "</b>. Ya existe la relación.<br> Verifique la información e intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la relación <b>" + nombreIndicador + " - " + nombreVariable + "</b>.<br>Intente nuevamente.";
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
                $("#formCrearIndV")[0].reset();
            });
        </script>
        <script>
            $(function () {
                $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
            });
        </script>
    </body>
</html>

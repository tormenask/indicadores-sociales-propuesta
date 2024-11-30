<?php
session_start();
include_once 'model/variable.php';
include_once 'controller/variable.php';
include_once 'model/indicador.php';
include_once 'controller/indicador.php';
include_once 'model/conjuntoIndicadores.php';
include_once 'controller/conjuntoIndicadores.php';
include_once 'model/rol.php';
include_once 'controller/rol.php';
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$conjunto = new ConjuntoIndicadores();
$idConj = "";
if (isset($_GET['conj'])) {
    $idConj = $_GET['conj'];
}
$conjuntoAct = $conjunto->consultarConjuntoIndicadores($idConj);
$permiso = $rol->consultarPermisoRol("variables" . $idConj, $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$crear && ($modificar || $eliminar)) {
    header("Location: index.php?action=admin/variables/gestionVariables&conj=" . $idConj);
}
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
                            <a href="index.php?action=admin/variables/gestionVariables&conj=<?php echo $idConj; ?>" class="btn btn-primary" role="button">
                                <i class="fa fa-arrow-left"></i>
                                Volver a Gestión de variables
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top: 20px;">
                    <div class="col-sm-10 col-sm-offset-1">
                        <form class="form-horizontal" id="formCrearVariable">
                            <fieldset>
                                <legend class="font-color">Creación de variables</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="conjuntoVariable">Conjunto de indicadores</label>
                                    <div class="col-md-6">
                                        <select id="conjuntoVariable" name="conjuntoVariable" class="form-control">
                                            <option value="Seleccione">Seleccione un conjunto de indicadores</option>
                                            <?php
                                            echo '<option value="' . $conjuntoAct["idConjuntoIndicadores"] . '">' . $conjuntoAct["nombreConjuntoIndicadores"] . '</option>';
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="nombreVariable">Nombre de la variable</label>
                                    <div class="col-md-6">
                                        <input id="nombreVariable" name="nombreVariable" type="text" placeholder="Nombre de la variable" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="tipoDatoVariable">Numerador o denominador</label>
                                    <div class="col-md-6">
                                        <select id="tipoDatoVariable" name="tipoDatoVariable" class="form-control">
                                            <option value="Numerador">Numerador</option>
                                            <option value="Denominador">Denominador</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="tipoZonaGeograficaVariable">Tipo de zona geográfica</label>
                                    <div class="col-md-6">
                                        <input id="tipoZonaGeograficaVariable" name="tipoZonaGeograficaVariable" type="text" placeholder="Tipo de zona geográfica de la variable" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="zonaGeograficaVariable">Zona geográfica</label>
                                    <div class="col-md-6">
                                        <input id="zonaGeograficaVariable" name="zonaGeograficaVariable" type="text" placeholder="Zona geográfica de la variable" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="periodicidadVariable">Periodicidad</label>
                                    <div class="col-md-6">
                                        <input id="periodicidadVariable" name="periodicidadVariable" type="text" placeholder="Periodicidad de la variable" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="entidadCompiladoraVariable">Entidad compiladora</label>
                                    <div class="col-md-6">
                                        <input id="entidadCompiladoraVariable" name="entidadCompiladoraVariable" type="text" placeholder="Entidad compiladora de la variable" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="fuenteDatosVariable">Fuente de datos</label>
                                    <div class="col-md-6">
                                        <input id="fuenteDatosVariable" name="fuenteDatosVariable" type="text" placeholder="Fuente de datos de la variable" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="urlFuenteDatosVariable">URL de la fuente de la variable</label>
                                    <div class="col-md-6">
                                        <input id="urlFuenteDatosVariable" name="urlFuenteDatosVariable" type="text" placeholder="URL de la fuente de la variable" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="desagregacionTematicaVariable">Desagregación temática</label>
                                    <div class="col-md-6">
                                        <input id="desagregacionTematicaVariable" name="desagregacionTematicaVariable" type="text" placeholder="Desagregación temática de la variable" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="notasVariable">Notas</label>
                                    <div class="col-md-6">
                                        <textarea rows="4" cols="50" id="notasVariable" name="notasVariable" type="text" placeholder="Notas sobre la variable" class="form-control input-md" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="unidadMedidaVariable">Unidad de medida</label>
                                    <div class="col-md-6">
                                        <input id="unidadMedidaVariable" name="unidadMedidaVariable" type="text" placeholder="Unidad de medida de la variable" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"></label>
                                    <div class="col-md-8">
                                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Crear variable</button>
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
                                    <h4 class="modal-title" >Confirmación</h4>
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
                    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-variable-created">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header active">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Creación exitosa</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-content-variable-created"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" 
                                            id="modal-btn-variable-created-ok">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" 
                         id="modal-form-error">
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
                var nombreVariableModal = $("#nombreVariable").val();
                document.getElementById("modal-content-create").innerHTML = "Confirma la creación de la variable <b>" + nombreVariableModal + "</b>";
            });
        </script>
        <script>
            $("#btn-confirm").on("click", function () {
                var conjuntoVariable = $("#conjuntoVariable").val();
                var nombreVariable = $("#nombreVariable").val();
                var tipoDatoVariable = $("#tipoDatoVariable").val();
                var tipoZonaGeograficaVariable = $("#tipoZonaGeograficaVariable").val();
                var zonaGeograficaVariable = $("#zonaGeograficaVariable").val();
                var periodicidadVariable = $("#periodicidadVariable").val();
                var entidadCompiladoraVariable = $("#entidadCompiladoraVariable").val();
                var fuenteDatosVariable = $("#fuenteDatosVariable").val();
                var urlFuenteDatosVariable = $("#urlFuenteDatosVariable").val();
                var desagregacionTematicaVariable = $("#desagregacionTematicaVariable").val();
                var notasVariable = $("#notasVariable").val();
                var unidadMedidaVariable = $("#unidadMedidaVariable").val();
                if (
                        conjuntoVariable === "" || nombreVariable === "" ||
                        tipoDatoVariable === "" || tipoZonaGeograficaVariable === "" ||
                        zonaGeograficaVariable === "" || periodicidadVariable === "" ||
                        entidadCompiladoraVariable === "" || fuenteDatosVariable === "" ||
                        urlFuenteDatosVariable === "" || desagregacionTematicaVariable === "" ||
                        notasVariable === "" || unidadMedidaVariable === ""
                        ) {
                    document.getElementById("modal-content-error").innerHTML = "Todos los campos son obligatorios.<br>Verfique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else if (conjuntoVariable === "Seleccione") {
                    document.getElementById("modal-content-error").innerHTML = "Debe seleccionar un conjunto de indicadores. Verifique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else {
                    $("#modal-confirm").modal('show');
                }
            });
            $("#modal-btn-form-error-ok").on("click", function () {
                $("#modal-form-error").modal('hide');
            });
            $("#modal-btn-si").on("click", function () {
                crearVariable();
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-no").on("click", function () {
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-variable-created-ok").on("click", function () {
                $("#modal-variable-created").modal('hide');
                window.location.replace("index.php?action=admin/variables/gestionVariables&conj=<?php echo $idConj; ?>");
            });
        </script>
        <script>
            var conjunto = "#variables" + "<?php echo $idConj; ?>";
            $(conjunto).addClass("active");
            $("#variables").addClass("active");
        </script>
        <script>
            function crearVariable() {
                var conjuntoVariable = $("#conjuntoVariable").val();
                var nombreVariable = $("#nombreVariable").val();
                var tipoDatoVariable = $("#tipoDatoVariable").val();
                var tipoZonaGeograficaVariable = $("#tipoZonaGeograficaVariable").val();
                var zonaGeograficaVariable = $("#zonaGeograficaVariable").val();
                var periodicidadVariable = $("#periodicidadVariable").val();
                var entidadCompiladoraVariable = $("#entidadCompiladoraVariable").val();
                var fuenteDatosVariable = $("#fuenteDatosVariable").val();
                var urlFuenteDatosVariable = $("#urlFuenteDatosVariable").val();
                var desagregacionTematicaVariable = $("#desagregacionTematicaVariable").val();
                var notasVariable = $("#notasVariable").val();
                var unidadMedidaVariable = $("#unidadMedidaVariable").val();
                if (
                        conjuntoVariable === "" || nombreVariable === "" ||
                        tipoDatoVariable === "" || tipoZonaGeograficaVariable === "" ||
                        zonaGeograficaVariable === "" || periodicidadVariable === "" ||
                        entidadCompiladoraVariable === "" || fuenteDatosVariable === "" ||
                        urlFuenteDatosVariable === "" || desagregacionTematicaVariable === "" ||
                        notasVariable === "" || unidadMedidaVariable === ""
                        ) {
                    document.getElementById("modal-content-error").innerHTML = "Todos los campos son obligatorios.<br>Verfique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else if (conjuntoVariable === "Seleccione") {
                    document.getElementById("modal-content-error").innerHTML = "Debe seleccionar un conjunto de indicadores. Verifique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else {
                    var url = "view/modules/admin/variables/funcionesVariables.php";
                    var data = new FormData();
                    data.append("conjuntoVariable", conjuntoVariable);
                    data.append("nombreVariable", nombreVariable);
                    data.append("tipoDatoVariable", tipoDatoVariable);
                    data.append("tipoZonaGeograficaVariable", tipoZonaGeograficaVariable);
                    data.append("zonaGeograficaVariable", zonaGeograficaVariable);
                    data.append("periodicidadVariable", periodicidadVariable);
                    data.append("entidadCompiladoraVariable", entidadCompiladoraVariable);
                    data.append("fuenteDatosVariable", fuenteDatosVariable);
                    data.append("urlFuenteDatosVariable", urlFuenteDatosVariable);
                    data.append("desagregacionTematicaVariable", desagregacionTematicaVariable);
                    data.append("notasVariable", notasVariable);
                    data.append("unidadMedidaVariable", unidadMedidaVariable);
                    $.ajax({
                        url: url,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function (resp) {
                            $("#formCrearVariable")[0].reset();
                            if (resp === "Creada") {
                                document.getElementById("modal-content-variable-created").innerHTML = "La variable <b>" + nombreVariable + "</b> ha sido creada correctamente.";
                                $("#modal-variable-created").modal('show');
                            } else if (resp === "Error al crear") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la variable <b>" + nombreVariable + "</b>.<br>Intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Id conjunto no existe") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la variable <b>" + nombreVariable + "</b>.<br>\n\
                                    No existe el id del conjunto seleccionado.<br> Verifique la información e intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Variable existe en conjunto") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la variable <b>" + nombreVariable + "</b>. Ya existe esta variable para el conjunto de indicadores seleccionado.<br> Verifique la información e intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la variable <b>" + nombreVariable + "</b>.<br>Intente nuevamente.";
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
                $("#formCrearVariable")[0].reset();
            });
        </script>
        <script>
            $(function () {
                $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
            });
        </script>
    </body>
</html>

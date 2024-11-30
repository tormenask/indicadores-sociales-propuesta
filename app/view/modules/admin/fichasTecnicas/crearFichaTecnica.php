<?php
session_start();
include_once 'model/fichaTecnica.php';
include_once 'controller/fichaTecnica.php';
include_once 'model/indicador.php';
include_once 'controller/indicador.php';
include_once 'model/tematica.php';
include_once 'controller/tematica.php';
include_once 'model/dimension.php';
include_once 'controller/dimension.php';
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
$permiso = $rol->consultarPermisoRol("fichasTecnicas" . $idConj, $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$crear && ($modificar || $eliminar)) {
    header("Location: index.php?action=admin/fichasTecnicas/gestionFichasTecnicas&conj=" . $idConj);
}
?>
<html>
    <?php include 'view/modules/head.php'; ?>
    <script type="text/javascript" src="view/resources/js/datepicker-es.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css">
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'view/modules/header.php'; ?>
            <?php include 'view/modules/side.php'; ?>
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
                        <div class="btn-group">
                            <a href="index.php?action=admin/fichasTecnicas/gestionFichasTecnicas&conj=<?php echo $idConj; ?>" class="btn btn-primary" role="button">
                                <i class="fa fa-arrow-left"></i>
                                Volver a Gestión de fichas técnicas
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top: 20px;">
                    <div class="col-sm-10 col-sm-offset-1">
                        <form class="form-horizontal" id="formCrearFicha">
                            <fieldset>
                                <legend class="font-color">Creación de fichas técnicas</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="conjuntoFicha">Conjunto de indicadores</label>
                                    <div class="col-md-6">
                                        <select id="conjuntoFicha" name="conjuntoFicha" class="form-control">
                                            <option value="Seleccione">Seleccione un conjunto de indicadores</option>
                                            <?php
                                            echo '<option value="' . $conjuntoAct["idConjuntoIndicadores"] . '">' . $conjuntoAct["nombreConjuntoIndicadores"] . '</option>';
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="dimensionFicha">Dimensión</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="dimensionFicha" name="dimensionFicha" disabled>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="tematicaFicha">Temática</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="tematicaFicha" name="tematicaFicha" disabled>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="indicadorFicha">Indicador</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="indicadorFicha" name="indicadorFicha" disabled>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                if ($idConj == "IGC") {
                                    echo '
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="justificacionFicha">Justificación</label>
                                    <div class="col-md-6">
                                        <textarea rows="4" cols="50" id="justificacionFicha" name="justificacionFicha" type="text" placeholder="Justificación" class="form-control input-md" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="definicionFicha">Definición</label>
                                    <div class="col-md-6">
                                        <textarea rows="4" cols="50" id="definicionFicha" name="definicionFicha" type="text" placeholder="Definición" class="form-control input-md" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="metodologiaFicha">Metodología</label>
                                    <div class="col-md-6">
                                        <textarea rows="4" cols="50" id="metodologiaFicha" name="metodologiaFicha" type="text" placeholder="Metodología" class="form-control input-md" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="referenciaFicha">Referencia</label>
                                    <div class="col-md-6">
                                        <textarea rows="4" cols="50" id="referenciaFicha" name="referenciaFicha" type="text" placeholder="Referencia" class="form-control input-md" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="observacionesLimitacionesFicha">Observaciones y limitaciones</label>
                                    <div class="col-md-6">
                                        <textarea rows="4" cols="50" id="observacionesLimitacionesFicha" name="observacionesLimitacionesFicha" type="text" placeholder="Observaciones y limitaciones" class="form-control input-md" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="otrasOrganizacionesFicha">Otras organizaciones que usan el indicador</label>
                                    <div class="col-md-6">
                                        <textarea rows="4" cols="50" id="otrasOrganizacionesFicha" name="otrasOrganizacionesFicha" type="text" placeholder="Otras organizaciones que usan el indicador" class="form-control input-md" required=""></textarea>
                                    </div>
                                </div>';
                                } else {
                                    echo '
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="siglaFicha">Sigla</label>
                                    <div class="col-md-6">
                                        <input id="siglaFicha" name="siglaFicha" type="text" placeholder="Sigla" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="justificacionFicha">Justificación</label>
                                    <div class="col-md-6">
                                        <textarea rows="4" cols="50" id="justificacionFicha" name="justificacionFicha" type="text" placeholder="Justificación" class="form-control input-md" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="definicionFicha">Definición</label>
                                    <div class="col-md-6">
                                        <textarea rows="4" cols="50" id="definicionFicha" name="definicionFicha" type="text" placeholder="Definición" class="form-control input-md" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="metodosMedicionFicha">Métodos de medición</label>
                                    <div class="col-md-6">
                                        <textarea rows="4" cols="50" id="metodosMedicionFicha" name="metodosMedicionFicha" type="text" placeholder="Métodos de medición" class="form-control input-md" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="formulasFicha">Fórmulas</label>
                                    <div class="col-md-6">
                                        <textarea rows="4" cols="50" id="formulasFicha" name="formulasFicha" type="text" placeholder="Fórmulas" class="form-control input-md" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="variablesFicha">Variables</label>
                                    <div class="col-md-6">
                                        <textarea rows="4" cols="50" id="variablesFicha" name="variablesFicha" type="text" placeholder="Variables" class="form-control input-md" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="valoresReferenciaFicha">Valores de referencia</label>
                                    <div class="col-md-6">
                                        <textarea rows="4" cols="50" id="valoresReferenciaFicha" name="valoresReferenciaFicha" type="text" placeholder="Valores de referencia" class="form-control input-md" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="naturalezaFicha">Naturaleza</label>
                                    <div class="col-md-6">
                                        <input id="naturalezaFicha" name="naturalezaFicha" type="text" placeholder="Naturaleza" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="desagregacionTematicaFicha">Desagregación temática</label>
                                    <div class="col-md-6">
                                        <input id="desagregacionTematicaFicha" name="desagregacionTematicaFicha" type="text" placeholder="Desagregación temática" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="desagregacionGeograficaFicha">Desagregación geográfica</label>
                                    <div class="col-md-6">
                                        <input id="desagregacionGeograficaFicha" name="desagregacionGeograficaFicha" type="text" placeholder="Desagregación geográfica" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="lineaBaseFicha">Línea base</label>
                                    <div class="col-md-6">
                                        <input id="lineaBaseFicha" name="lineaBaseFicha" type="text" placeholder="Línea base" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="responsableFicha">Responsable</label>
                                    <div class="col-md-6">
                                        <input id="responsableFicha" name="responsableFicha" type="text" placeholder="Responsable" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="observacionesFicha">Observaciones</label>
                                    <div class="col-md-6">
                                        <textarea rows="4" cols="50" id="observacionesFicha" name="observacionesFicha" type="text" placeholder="Observaciones" class="form-control input-md" required=""></textarea>
                                    </div>
                                </div>
                                <div class="date form-group" id="datepicker" data-provide="datepicker">
                                    <label class="col-md-4 control-label" for="fechaElaboracionFicha">Fecha de elaboración</label>
                                    <div class="col-md-6">
                                        <div class="col-md-10" style="margin-left: -15px;">
                                            <input id="fechaElaboracionFicha" name="fechaElaboracionFicha" type="text" class="form-control input-md">
                                        </div>
                                        <div class="col-md-2 col-calendar">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                ';
                                }
                                ?>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="tipoGraficoFicha">Tipo de gráfico</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="tipoGraficoFicha" name="tipoGraficoFicha">
                                            <option>-</option>
                                            <option>_____</option>
                                            <option>Área</option>
                                            <option>Barras</option>
                                            <option>Barras apiladas</option>
                                            <option>Lineal</option> 
                                            <option>Piramidal</option> 
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
                    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-ficha-created">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header active">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Creación exitosa</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-content-ficha-created"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" 
                                            id="modal-btn-ficha-created-ok">Aceptar</button>
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
            $(document).ready(function () {
                $('#conjuntoFicha').on('change', function () {
                    var conjunto = document.getElementById("conjuntoFicha");
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
                                $('#dimensionFicha').html(resp);
                                $('#dimensionFicha').prop('disabled', false);
                            }
                        });
                    } else {
                        $('#dimensionFicha').empty();
                        $('#dimensionFicha').prop('disabled', 'disabled');
                        $('#tematicaFicha').empty();
                        $('#tematicaFicha').prop('disabled', 'disabled');
                        $('#indicadorFicha').empty();
                        $('#indicadorFicha').prop('disabled', 'disabled');
                    }
                });
                $('#dimensionFicha').on('change', function () {
                    var dimension = document.getElementById("dimensionFicha");
                    var valDimension = dimension.options[dimension.selectedIndex].value;
                    if (valDimension !== "Seleccione") {
                        var url = "view/modules/admin/tematicas/funcionesTematicas.php";
                        var data = new FormData();
                        data.append("dimensionInd", valDimension);
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (resp) {
                                $('#tematicaFicha').html(resp);
                                $('#tematicaFicha').prop('disabled', false);
                            }
                        });
                    } else {
                        $('#tematicaFicha').empty();
                        $('#tematicaFicha').prop('disabled', 'disabled');
                        $('#indicadorFicha').empty();
                        $('#indicadorFicha').prop('disabled', 'disabled');
                    }
                });
                $('#tematicaFicha').on('change', function () {
                    var tematica = document.getElementById("tematicaFicha");
                    var valTematica = tematica.options[tematica.selectedIndex].value;
                    if (valTematica !== "Seleccione") {
                        var url = "view/modules/admin/indicadores/funcionesIndicadores.php";
                        var data = new FormData();
                        data.append("tematicaSer", valTematica);
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (resp) {
                                $('#indicadorFicha').html(resp);
                                $('#indicadorFicha').prop('disabled', false);
                            }
                        });
                    } else {
                        $('#indicadorFicha').empty();
                        $('#indicadorFicha').prop('disabled', 'disabled');
                    }
                });
            });
        </script>
        <script>
            $('#modal-confirm').on('shown.bs.modal', function (e) {
                var indicador = document.getElementById("indicadorFicha");
                var indicadorModal = indicador.options[indicador.selectedIndex].text;
                document.getElementById("modal-content-create").innerHTML = "Confirma la creación de la ficha técnica para el indicador <b>" + indicadorModal + "</b>";
            });
        </script>
        <script>
            $("#btn-confirm").on("click", function () {
                var conjunto = document.getElementById("conjuntoFicha");
                var valConjunto = conjunto.options[conjunto.selectedIndex].value;
                var indicadorFicha = $("#indicadorFicha").val();
                var tipoGraficoFicha = $("#tipoGraficoFicha").val();
                var datosIncompletos = "";
                if (valConjunto === "IGC") {
                    var justificacionFicha = $("#justificacionFicha").val();
                    var definicionFicha = $("#definicionFicha").val();
                    var metodologiaFicha = $("#metodologiaFicha").val();
                    var referenciaFicha = $("#referenciaFicha").val();
                    var observacionesLimitacionesFicha = $("#observacionesLimitacionesFicha").val();
                    var otrasOrganizacionesFicha = $("#otrasOrganizacionesFicha").val();
                    if (indicadorFicha === "" || tipoGraficoFicha === "" ||
                            justificacionFicha === "" || definicionFicha === "" ||
                            metodologiaFicha === "" || referenciaFicha === "" ||
                            observacionesLimitacionesFicha === "" || otrasOrganizacionesFicha === "") {
                        datosIncompletos = true;
                    } else {
                        datosIncompletos = false;
                    }
                } else {
                    var siglaFicha = $("#siglaFicha").val();
                    var justificacionFicha = $("#justificacionFicha").val();
                    var definicionFicha = $("#definicionFicha").val();
                    var metodosMedicionFicha = $("#metodosMedicionFicha").val();
                    var formulasFicha = $("#formulasFicha").val();
                    var variablesFicha = $("#variablesFicha").val();
                    var valoresReferenciaFicha = $("#valoresReferenciaFicha").val();
                    var naturalezaFicha = $("#naturalezaFicha").val();
                    var desagregacionTematicaFicha = $("#desagregacionTematicaFicha").val();
                    var desagregacionGeograficaFicha = $("#desagregacionGeograficaFicha").val();
                    var lineaBaseFicha = $("#lineaBaseFicha").val();
                    var responsableFicha = $("#responsableFicha").val();
                    var observacionesFicha = $("#observacionesFicha").val();
                    var fechaElaboracionFicha = $("#fechaElaboracionFicha").val();
                    var otrasOrganizacionesFicha = $("#otrasOrganizacionesFicha").val();
                    if (indicadorFicha === "" || tipoGraficoFicha === "" ||
                            siglaFicha === "" || justificacionFicha === "" ||
                            definicionFicha === "" || metodosMedicionFicha === "" ||
                            formulasFicha === "" || variablesFicha === "" ||
                            valoresReferenciaFicha === "" || naturalezaFicha === "" ||
                            desagregacionTematicaFicha === "" || desagregacionGeograficaFicha === "" ||
                            lineaBaseFicha === "" || responsableFicha === "" ||
                            observacionesFicha === "" || fechaElaboracionFicha === "" ||
                            otrasOrganizacionesFicha === "") {
                        datosIncompletos = true;
                    } else {
                        datosIncompletos = false;
                    }
                }
                if (datosIncompletos === true) {
                    document.getElementById("modal-content-error").innerHTML = "Todos los campos son obligatorios.<br>Verfique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else if (indicadorFicha === "Seleccione") {
                    document.getElementById("modal-content-error").innerHTML = "Debe seleccionar un indicador. Verifique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else {
                    $("#modal-confirm").modal('show');
                }
            });
            $("#modal-btn-form-error-ok").on("click", function () {
                $("#modal-form-error").modal('hide');
            });
            $("#modal-btn-si").on("click", function () {
                crearFicha();
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-no").on("click", function () {
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-ficha-created-ok").on("click", function () {
                $("#modal-ficha-created").modal('hide');
                window.location.replace("index.php?action=admin/fichasTecnicas/gestionFichasTecnicas&conj=<?php echo $idConj; ?>");
            });
        </script>
        <script>
            var conjunto = "#fichasTecnicas" + "<?php echo $idConj; ?>";
            $(conjunto).addClass("active");
            $("#fichasTecnicas").addClass("active");
        </script>
        <script>
            function crearFicha() {
                var conjunto = document.getElementById("conjuntoFicha");
                var valConjunto = conjunto.options[conjunto.selectedIndex].value;
                var indicador = document.getElementById("indicadorFicha");
                var valIndicador = indicador.options[indicador.selectedIndex].text;
                var indicadorFicha = $("#indicadorFicha").val();
                var tipoGraficoFicha = $("#tipoGraficoFicha").val();
                var datosIncompletos = "";
                if (valConjunto === "IGC") {
                    var justificacionFichaIGC = $("#justificacionFicha").val();
                    var definicionFichaIGC = $("#definicionFicha").val();
                    var metodologiaFicha = $("#metodologiaFicha").val();
                    var referenciaFicha = $("#referenciaFicha").val();
                    var observacionesLimitacionesFicha = $("#observacionesLimitacionesFicha").val();
                    var otrasOrganizacionesFicha = $("#otrasOrganizacionesFicha").val();
                    if (indicadorFicha === "" || tipoGraficoFicha === "" ||
                            justificacionFichaIGC === "" || definicionFichaIGC === "" ||
                            metodologiaFicha === "" || referenciaFicha === "" ||
                            observacionesLimitacionesFicha === "" || otrasOrganizacionesFicha === "") {
                        datosIncompletos = true;
                    } else {
                        datosIncompletos = false;
                    }
                } else {
                    var siglaFicha = $("#siglaFicha").val();
                    var justificacionFicha = $("#justificacionFicha").val();
                    var definicionFicha = $("#definicionFicha").val();
                    var metodosMedicionFicha = $("#metodosMedicionFicha").val();
                    var formulasFicha = $("#formulasFicha").val();
                    var variablesFicha = $("#variablesFicha").val();
                    var valoresReferenciaFicha = $("#valoresReferenciaFicha").val();
                    var naturalezaFicha = $("#naturalezaFicha").val();
                    var desagregacionTematicaFicha = $("#desagregacionTematicaFicha").val();
                    var desagregacionGeograficaFicha = $("#desagregacionGeograficaFicha").val();
                    var lineaBaseFicha = $("#lineaBaseFicha").val();
                    var responsableFicha = $("#responsableFicha").val();
                    var observacionesFicha = $("#observacionesFicha").val();
                    var fechaElaboracionFicha = $("#fechaElaboracionFicha").val();
                    var otrasOrganizacionesFicha = $("#otrasOrganizacionesFicha").val();
                    if (indicadorFicha === "" || tipoGraficoFicha === "" ||
                            siglaFicha === "" || justificacionFicha === "" ||
                            definicionFicha === "" || metodosMedicionFicha === "" ||
                            formulasFicha === "" || variablesFicha === "" ||
                            valoresReferenciaFicha === "" || naturalezaFicha === "" ||
                            desagregacionTematicaFicha === "" || desagregacionGeograficaFicha === "" ||
                            lineaBaseFicha === "" || responsableFicha === "" ||
                            observacionesFicha === "" || fechaElaboracionFicha === "" ||
                            otrasOrganizacionesFicha === "") {
                        datosIncompletos = true;
                    } else {
                        datosIncompletos = false;
                    }
                }
                if (datosIncompletos === true) {
                    document.getElementById("modal-content-error").innerHTML = "Todos los campos son obligatorios.<br>Verfique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else if (indicadorFicha === "Seleccione") {
                    document.getElementById("modal-content-error").innerHTML = "Debe seleccionar un indicador. Verifique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else {
                    var url = "view/modules/admin/fichasTecnicas/funcionesFichasTecnicas.php";
                    var data = new FormData();
                    if (valConjunto === "IGC") {
                        data.append("justificacionFichaIGC", justificacionFichaIGC);
                        data.append("definicionFichaIGC", definicionFichaIGC);
                        data.append("metodologiaFichaIGC", metodologiaFicha);
                        data.append("referenciaFichaIGC", referenciaFicha);
                        data.append("observacionesLimitacionesFichaIGC", observacionesLimitacionesFicha);
                        data.append("otrasOrganizacionesFichaIGC", otrasOrganizacionesFicha);
                        data.append("indicadorFichaIGC", indicadorFicha);
                        data.append("tipoGraficoFichaIGC", tipoGraficoFicha);
                    } else {
                        data.append("conjuntoIndicadoresFicha", valConjunto);
                        data.append("siglaFicha", siglaFicha);
                        data.append("justificacionFicha", justificacionFicha);
                        data.append("definicionFicha", definicionFicha);
                        data.append("metodosMedicionFicha", metodosMedicionFicha);
                        data.append("formulasFicha", formulasFicha);
                        data.append("variablesFicha", variablesFicha);
                        data.append("valoresReferenciaFicha", valoresReferenciaFicha);
                        data.append("naturalezaFicha", naturalezaFicha);
                        data.append("desagregacionTematicaFicha", desagregacionTematicaFicha);
                        data.append("desagregacionGeograficaFicha", desagregacionGeograficaFicha);
                        data.append("lineaBaseFicha", lineaBaseFicha);
                        data.append("responsableFicha", responsableFicha);
                        data.append("observacionesFicha", observacionesFicha);
                        data.append("fechaElaboracionFicha", fechaElaboracionFicha);
                        data.append("indicadorFicha", indicadorFicha);
                        data.append("tipoGraficoFicha", tipoGraficoFicha);
                    }
                    $.ajax({
                        url: url,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function (resp) {
                            $("#formCrearFicha")[0].reset();
                            $('#dimensionFicha').empty();
                            $('#dimensionFicha').prop('disabled', 'disabled');
                            $('#tematicaFicha').empty();
                            $('#tematicaFicha').prop('disabled', 'disabled');
                            $('#indicadorFicha').empty();
                            $('#indicadorFicha').prop('disabled', 'disabled');
                            if (resp === "Creada") {
                                document.getElementById("modal-content-ficha-created").innerHTML = "La ficha técnica para el indicador <b>" + valIndicador + "</b> ha sido creada correctamente.";
                                $("#modal-ficha-created").modal('show');
                            } else if (resp === "Error al crear") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la ficha técnica para el indicador <b>" + valIndicador + "</b>.<br>Intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Id indicador no existe") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la ficha técnica para el indicador <b>" + valIndicador + "</b>.<br>\n\
                                    No existe el id del indicador seleccionado.<br> Verifique la información e intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Ficha para indicador existe") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la ficha técnica para el indicador <b>" + valIndicador + "</b>. Ya existe la ficha para el indicador seleccionado.<br> Verifique la información e intente nuevamente.";
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
                $("#formCrearFicha")[0].reset();
                $('#dimensionFicha').empty();
                $('#dimensionFicha').prop('disabled', 'disabled');
                $('#tematicaFicha').empty();
                $('#tematicaFicha').prop('disabled', 'disabled');
                $('#indicadorFicha').empty();
                $('#indicadorFicha').prop('disabled', 'disabled');
            });
        </script>
    </body>
</html>

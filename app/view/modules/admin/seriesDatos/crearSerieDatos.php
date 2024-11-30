<?php
session_start();
include_once 'model/serieDatos.php';
include_once 'controller/serieDatos.php';
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
$permiso = $rol->consultarPermisoRol("seriesDatos" . $idConj, $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$crear && ($modificar || $eliminar)) {
    header("Location: index.php?action=admin/seriesDatos/gestionSeriesDatos&conj=" . $idConj);
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
                            <a href="index.php?action=admin/seriesDatos/gestionSeriesDatos&conj=<?php echo $idConj; ?>" class="btn btn-primary" role="button">
                                <i class="fa fa-arrow-left"></i>
                                Volver a Gestión de series de datos
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top: 20px;">
                    <div class="col-sm-10 col-sm-offset-1">
                        <form class="form-horizontal" id="formCrearSerie">
                            <fieldset>
                                <legend class="font-color">Creación de series de datos</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="conjuntoSerie">Conjunto de indicadores</label>
                                    <div class="col-md-6">
                                        <select id="conjuntoSerie" name="conjuntoSerie" class="form-control">
                                            <option value="Seleccione">Seleccione un conjunto de indicadores</option>
                                            <?php
                                            echo '<option value="' . $conjuntoAct["idConjuntoIndicadores"] . '">' . $conjuntoAct["nombreConjuntoIndicadores"] . '</option>';
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="dimensionSerie">Dimensión</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="dimensionSerie" name="dimensionSerie" disabled>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="tematicaSerie">Temática</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="tematicaSerie" name="tematicaSerie" disabled>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="indicadorSerie">Indicador</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="indicadorSerie" name="indicadorSerie" disabled>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                if ($conjuntoAct['idConjuntoIndicadores'] == "SIS") {
                                    echo '
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="tipoDatoSerie">Tipo de datos</label>
                                            <div class="col-md-6">
                                                <input id="tipoDatoSerie" name="tipoDatoSerie" type="text" placeholder="Tipo de datos de la serie" class="form-control input-md" required="">
                                            </div>
                                        </div>';
                                }
                                ?>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="geografiaSerie">Tipo de zona geográfica</label>
                                    <div class="col-md-6">
                                        <select id="geografiaSerie" name="geografiaSerie" type="text" placeholder="Tipo de zona geográfica de la serie" class="form-control input-md" required="">                                                                   
                                            <option value="Seleccione">Seleccione el tipo de zona geográfica de la serie</option>
                                            <?php echo '<option value="Área Metropolitana">Área metropolitana</option>
                                                    <option value="Cabecera Municipal">Cabecera municipal</option>
                                                    <option value="Centralidad">Centralidad</option>
                                                    <option value ="Comuna">Comuna</option>
                                                    <option value="Corregimiento">Corregimiento</option>
                                                    <option value="Departamental">Departamental</option>
                                                    <option value="Municipal">Municipal</option>
                                                    <option value="Nacional">Nacional</option>
                                                    <option value="Resto Municipal">Resto municipal</option>
                                                    <option value="Rural">Rural</option>
                                                    <option value="Rural-PNNF">Rural-PNNF</option>
                                                    <option value="Rural-Sin PNNF">Rural-Sin PNNF</option>
                                                    <option value="Sector Centro">Sector Centro</option>
                                                    <option value="Sector Ladera">Sector Ladera</option>
                                                    <option value="Sector Occidente">Sector Occidente</option>
                                                    <option value="Sector Oriente">Sector Oriente</option>
                                                    <option value="Total">Total</option>
                                                    <option value="Urbana">Urbana</option>
                                                    
                                            '; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="zonaActualSerie">Zona geográfica</label>
                                    <div class="col-md-6">
                                        <input id="zonaActualSerie" name="zonaActualSerie" type="text" placeholder="Zona geográfica de la serie" class="form-control input-md" required="">                                           
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="periodicidadSerie">Periodicidad</label>
                                    <div class="col-md-6">
                                        <select id="periodicidadSerie" name="periodicidadSerie" type="text" placeholder="Periodicidad de la serie" class="form-control input-md" required="">
                                            <option value="Seleccione">Seleccione la periodicidad de la serie</option>
                                            <?php echo '<option value="Anual">Anual</option>
                                                  <option value="Semestral">Semestral</option>
                                                  <option value="Trimestral">Trimestral</option>
                                                  <option value="Mensual">Mensual</option>                                                  
                                            '; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="entidadGeneradoraSerie">Entidad compiladora</label>
                                    <div class="col-md-6">
                                        <input id="entidadGeneradoraSerie" name="entidadGeneradoraSerie" type="text" placeholder="Entidad compiladora de los datos de la serie" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="fuenteDatosSerie">Fuente de datos</label>
                                    <div class="col-md-6">
                                        <input id="fuenteDatosSerie" name="fuenteDatosSerie" type="text" placeholder="Fuente de datos de la serie" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <?php
                                if ($conjuntoAct['idConjuntoIndicadores'] == "SIS") {
                                    echo '
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="urlDatosSerie">URL de la fuente de datos</label>
                                            <div class="col-md-6">
                                                <input id="urlDatosSerie" name="urlDatosSerie" type="text" placeholder="URL de la fuente de datos de la serie" class="form-control input-md" required="">
                                            </div>
                                        </div>';
                                }
                                ?>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="desagregacionTematicaSerie">Desagregación temática</label>
                                    <div class="col-md-6">
                                        <input id="desagregacionTematicaSerie" name="desagregacionTematicaSerie" type="text" placeholder="Desagregación temática de la serie" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="notasSerie">Notas</label>
                                    <div class="col-md-6">
                                        <textarea rows="4" cols="50" id="notasSerie" name="notasSerie" type="text" placeholder="Notas sobre la serie" class="form-control input-md" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="unidadMedicionSerie">Unidad de medida</label>
                                    <div class="col-md-6">
                                        <input id="unidadMedicionSerie" name="unidadMedicionSerie" type="text" placeholder="Unidad de medida de la serie" class="form-control input-md" required="">
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
                    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-serie-created">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header active">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Creación exitosa</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-content-serie-created"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" 
                                            id="modal-btn-serie-created-ok">Aceptar</button>
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
                $('#conjuntoSerie').on('change', function () {
                    var conjunto = document.getElementById("conjuntoSerie");
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
                                $('#dimensionSerie').html(resp);
                                $('#dimensionSerie').prop('disabled', false);
                            }
                        });
                    } else {
                        $('#dimensionSerie').empty();
                        $('#dimensionSerie').prop('disabled', 'disabled');
                        $('#tematicaSerie').empty();
                        $('#tematicaSerie').prop('disabled', 'disabled');
                        $('#indicadorSerie').empty();
                        $('#indicadorSerie').prop('disabled', 'disabled');
                    }
                });
                $('#dimensionSerie').on('change', function () {
                    var dimension = document.getElementById("dimensionSerie");
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
                                $('#tematicaSerie').html(resp);
                                $('#tematicaSerie').prop('disabled', false);
                            }
                        });
                    } else {
                        $('#tematicaSerie').empty();
                        $('#tematicaSerie').prop('disabled', 'disabled');
                        $('#indicadorSerie').empty();
                        $('#indicadorSerie').prop('disabled', 'disabled');
                    }
                });
                $('#tematicaSerie').on('change', function () {
                    var tematica = document.getElementById("tematicaSerie");
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
                                $('#indicadorSerie').html(resp);
                                $('#indicadorSerie').prop('disabled', false);
                            }
                        });
                    } else {
                        $('#indicadorSerie').empty();
                        $('#indicadorSerie').prop('disabled', 'disabled');
                    }
                });
            });
        </script>
        <script>
            $('#modal-confirm').on('shown.bs.modal', function (e) {
                var desagregacionTematicaModal = $("#desagregacionTematicaSerie").val();
                document.getElementById("modal-content-create").innerHTML = "Confirma la creación de la serie de datos para la desagregación temática <b>" + desagregacionTematicaModal + "</b>";
            });
        </script>
        <script>
            $("#btn-confirm").on("click", function () {
                var indicadorSerie = $("#indicadorSerie").val();
                var tipoDatosSerie = $("#tipoDatoSerie").val();
                var geografiaSerie = $("#geografiaSerie").val();
                var zonaActualSerie = $("#zonaActualSerie").val();
                var periodicidadSerie = $("#periodicidadSerie").val();
                var entidadGeneradoraSerie = $("#entidadGeneradoraSerie").val();
                var fuenteDatosSerie = $("#fuenteDatosSerie").val();
                var urlDatosSerie = $("#urlDatosSerie").val();
                var desagregacionTematicaSerie = $("#desagregacionTematicaSerie").val();
                var notasSerie = $("#notasSerie").val();
                var unidadMedicionSerie = $("#unidadMedicionSerie").val();
                if (tipoDatosSerie === "undefined") {
                    tipoDatosSerie = "N/A";
                }
                if (urlDatosSerie === "undefined") {
                    urlDatosSerie = "N/A";
                }
                if (
                        indicadorSerie === "" || tipoDatosSerie === "" ||
                        geografiaSerie === "" || zonaActualSerie === "" ||
                        periodicidadSerie === "" || entidadGeneradoraSerie === "" ||
                        fuenteDatosSerie === "" || urlDatosSerie === "" ||
                        desagregacionTematicaSerie === "" || notasSerie === "" ||
                        unidadMedicionSerie === ""
                        ) {
                    document.getElementById("modal-content-error").innerHTML = "Todos los campos son obligatorios.<br>Verfique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else if (indicadorSerie === "Seleccione") {
                    document.getElementById("modal-content-error").innerHTML = "Debe seleccionar un indicador. Verifique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else if (geografiaSerie === "Seleccione") {
                    document.getElementById("modal-content-error").innerHTML = "Debe seleccionar un tipo de zona geográfica. Verifique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else if (periodicidadSerie === "Seleccione") {
                    document.getElementById("modal-content-error").innerHTML = "Debe seleccionar una periodicidad. Verifique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else {
                    $("#modal-confirm").modal('show');
                }
            });
            $("#modal-btn-form-error-ok").on("click", function () {
                $("#modal-form-error").modal('hide');
            });
            $("#modal-btn-si").on("click", function () {
                crearSerie();
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-no").on("click", function () {
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-serie-created-ok").on("click", function () {
                $("#modal-serie-created").modal('hide');
                window.location.replace("index.php?action=admin/seriesDatos/gestionSeriesDatos&conj=<?php echo $idConj; ?>");
            });
        </script>
        <script>
            var conjunto = "#seriesDatos" + "<?php echo $idConj; ?>";
            $(conjunto).addClass("active");
            $("#seriesDatos").addClass("active");
        </script>
        <script>
            function crearSerie() {
                var indicadorSerie = $("#indicadorSerie").val();
                var tipoDatosSerie = $("#tipoDatoSerie").val();
                var geografiaSerie = $("#geografiaSerie").val();
                var zonaActualSerie = $("#zonaActualSerie").val();
                var periodicidadSerie = $("#periodicidadSerie").val();
                var entidadGeneradoraSerie = $("#entidadGeneradoraSerie").val();
                var fuenteDatosSerie = $("#fuenteDatosSerie").val();
                var urlDatosSerie = $("#urlDatosSerie").val();
                var desagregacionTematicaSerie = $("#desagregacionTematicaSerie").val();
                var notasSerie = $("#notasSerie").val();
                var unidadMedicionSerie = $("#unidadMedicionSerie").val();
                if (tipoDatosSerie == "undefined" || tipoDatosSerie == '' || tipoDatosSerie == null) {
                    tipoDatosSerie = "N/A";
                }
                if (urlDatosSerie == "undefined" || urlDatosSerie == '' || urlDatosSerie == null) {
                    urlDatosSerie = "N/A";
                }
                if (
                        indicadorSerie === "" || tipoDatosSerie === "" ||
                        geografiaSerie === "" || zonaActualSerie === "" ||
                        periodicidadSerie === "" || entidadGeneradoraSerie === "" ||
                        fuenteDatosSerie === "" || urlDatosSerie === "" ||
                        desagregacionTematicaSerie === "" || notasSerie === "" ||
                        unidadMedicionSerie === ""
                        ) {
                    document.getElementById("modal-content-error").innerHTML = "Todos los campos son obligatorios.<br>Verfique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else if (indicadorSerie === "Seleccione") {
                    document.getElementById("modal-content-error").innerHTML = "Debe seleccionar un indicador. Verifique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else if (geografiaSerie === "Seleccione") {
                    document.getElementById("modal-content-error").innerHTML = "Debe seleccionar un tipo de zona geográfica. Verifique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else if (periodicidadSerie === "Seleccione") {
                    document.getElementById("modal-content-error").innerHTML = "Debe seleccionar una periodicidad. Verifique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else {
                    var url = "view/modules/admin/seriesDatos/funcionesSeriesDatos.php";
                    var data = new FormData();
                    data.append("indicadorSerie", indicadorSerie);
                    data.append("tipoDatosSerie", tipoDatosSerie);
                    data.append("geografiaSerie", geografiaSerie);
                    data.append("zonaActualSerie", zonaActualSerie);
                    data.append("periodicidadSerie", periodicidadSerie);
                    data.append("entidadGeneradoraSerie", entidadGeneradoraSerie);
                    data.append("fuenteDatosSerie", fuenteDatosSerie);
                    data.append("urlDatosSerie", urlDatosSerie);
                    data.append("desagregacionTematicaSerie", desagregacionTematicaSerie);
                    data.append("notasSerie", notasSerie);
                    data.append("unidadMedicionSerie", unidadMedicionSerie);
                    $.ajax({
                        url: url,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function (resp) {
                            $("#formCrearSerie")[0].reset();
                            $('#dimensionSerie').empty();
                            $('#dimensionSerie').prop('disabled', 'disabled');
                            $('#tematicaSerie').empty();
                            $('#tematicaSerie').prop('disabled', 'disabled');
                            $('#indicadorSerie').empty();
                            $('#indicadorSerie').prop('disabled', 'disabled');
                            if (resp === "Creada") {
                                document.getElementById("modal-content-serie-created").innerHTML = "La serie ha sido creada correctamente.";
                                $("#modal-serie-created").modal('show');
                            } else if (resp === "Error al crear") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la serie.<br>Intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Id indicador no existe") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la serie.<br>\n\
                                    No existe el id del indicador seleccionado.<br> Verifique la información e intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Serie existe en indicador") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la serie. Ya existe esta serie para el indicador seleccionado.<br> Verifique la información e intente nuevamente.";
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
                $("#formCrearSerie")[0].reset();
                $('#dimensionSerie').empty();
                $('#dimensionSerie').prop('disabled', 'disabled');
                $('#tematicaSerie').empty();
                $('#tematicaSerie').prop('disabled', 'disabled');
                $('#indicadorSerie').empty();
                $('#indicadorSerie').prop('disabled', 'disabled');
            });
        </script>
        <script>
            $(function () {
                $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
            });
        </script>
    </body>
</html>

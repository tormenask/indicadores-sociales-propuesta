<?php
session_start();
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
$permiso = $rol->consultarPermisoRol("indicadores" . $idConj, $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$crear && ($modificar || $eliminar)) {
    header("Location: index.php?action=admin/indicadores/gestionIndicadores&conj=" . $idConj);
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
                            <a href="index.php?action=admin/indicadores/gestionIndicadores&conj=<?php echo $idConj; ?>" class="btn btn-primary" role="button">
                                <i class="fa fa-arrow-left"></i>
                                Volver a Gestión de indicadores
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top: 20px;">
                    <div class="col-sm-10 col-sm-offset-1">
                        <form class="form-horizontal" id="formCrearIndicador">
                            <fieldset>
                                <legend class="font-color">Creación de indicadores</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="nombreIndicador">Nombre</label>
                                    <div class="col-md-6">
                                        <input id="nombreIndicador" name="nombreIndicador" type="text" placeholder="Nombre del indicador" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="descripcionIndicador">Descripción</label>
                                    <div class="col-md-6">
                                        <input id="descripcionIndicador" name="descripcionIndicador" type="text" placeholder="Descripción del indicador" class="form-control input-md">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="conjuntoIndicador">Conjunto de indicadores</label>
                                    <div class="col-md-6">
                                        <select id="conjuntoIndicador" name="conjuntoIndicador" class="form-control">
                                            <option value="Seleccione">Seleccione un conjunto de indicadores</option>
                                            <?php
                                            echo '<option value="' . $conjuntoAct["idConjuntoIndicadores"] . '">' . $conjuntoAct["nombreConjuntoIndicadores"] . '</option>';
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="dimensionIndicador">Dimensión</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="dimensionIndicador" name="dimensionIndicador" disabled>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="tematicaIndicador">Temática</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="tematicaIndicador" name="tematicaIndicador" disabled>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="posicion">Posición</label>
                                    <div class="col-md-6">
                                        <input id="posicion" name="posicion" type="number" placeholder="Posición del indicador" class="form-control input-md" required=""> <?php $valorIni=200 ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="mapa">Mapa</label>
                                    <div class="col-md-6">
                                        <textarea id="mapa" name="mapa" rows="5" type="text" style="resize: vertical;" placeholder="Mapa del indicador" class="form-control input-md" ></textarea>
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
                    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-indicador-created">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header active">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Creación exitosa</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-content-indicador-created"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" 
                                            id="modal-btn-indicador-created-ok">Aceptar</button>
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
                $('#conjuntoIndicador').on('change', function () {
                    var conjunto = document.getElementById("conjuntoIndicador");
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
                                $('#dimensionIndicador').html(resp);
                                $('#dimensionIndicador').prop('disabled', false);
                            }
                        });
                    } else {
                        $('#dimensionIndicador').empty();
                        $('#dimensionIndicador').prop('disabled', 'disabled');
                        $('#tematicaIndicador').empty();
                        $('#tematicaIndicador').prop('disabled', 'disabled');
                    }
                });
                $('#dimensionIndicador').on('change', function () {
                    var dimension = document.getElementById("dimensionIndicador");
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
                                $('#tematicaIndicador').html(resp);
                                $('#tematicaIndicador').prop('disabled', false);
                            }
                        });
                    } else {
                        $('#tematicaIndicador').empty();
                        $('#tematicaIndicador').prop('disabled', 'disabled');
                    }
                });
            });
        </script>
        <script>
            $('#modal-confirm').on('shown.bs.modal', function (e) {
                var nombreIndicadorModal = $("#nombreIndicador").val();
                document.getElementById("modal-content-create").innerHTML = "Confirma la creación del indicador <b>" + nombreIndicadorModal + "</b>";
            });
        </script>
        <script>
            $("#btn-confirm").on("click", function () {
                var nombreIndicador = $("#nombreIndicador").val();
                var tematicaIndicador = $("#tematicaIndicador").val();
                if (nombreIndicador === "" || tematicaIndicador === "") {
                    document.getElementById("modal-content-error").innerHTML = "Todos los campos son obligatorios.<br>Verfique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else if (tematicaIndicador === "Seleccione") {
                    document.getElementById("modal-content-error").innerHTML = "Debe seleccionar una temática. Verifique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else {
                    $("#modal-confirm").modal('show');
                }
            });
            $("#modal-btn-form-error-ok").on("click", function () {
                $("#modal-form-error").modal('hide');
            });
            $("#modal-btn-si").on("click", function () {
                crearIndicador();
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-no").on("click", function () {
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-indicador-created-ok").on("click", function () {
                $("#modal-indicador-created").modal('hide');
                window.location.replace("index.php?action=admin/indicadores/gestionIndicadores&conj=<?php echo $idConj; ?>");
            });
        </script>
        <script>
            var conjunto = "#indicadores" + "<?php echo $idConj; ?>";
            $(conjunto).addClass("active");
            $("#indicadores").addClass("active");
        </script>
        <script>
            function crearIndicador() {
                var nombreIndicador = $("#nombreIndicador").val();
                var descripcionIndicador = $("#descripcionIndicador").val();
                var posicion = $("#posicion").val();
                var tematicaIndicador = $("#tematicaIndicador").val();
                var mapa = $("#mapa").val();
                if (nombreIndicador === "" || tematicaIndicador === "") {
                    document.getElementById("modal-content-error").innerHTML = "Todos los campos son obligatorios.<br>Verfique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else if (tematicaIndicador === "Seleccione") {
                    document.getElementById("modal-content-error").innerHTML = "Debe seleccionar una temática. Verifique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else {
                    var url = "view/modules/admin/indicadores/funcionesIndicadores.php";
                    var data = new FormData();
                    data.append("nombreIndicador", nombreIndicador);
                    data.append("descripcionIndicador", descripcionIndicador);
                    data.append("posicion", posicion);
                    data.append("tematicaIndicador", tematicaIndicador);
                    data.append("mapa", mapa);
                    $.ajax({
                        url: url,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function (resp) {
                            $("#formCrearIndicador")[0].reset();
                            $('#dimensionTematica').empty();
                            $('#dimensionTematica').prop('disabled', 'disabled');
                            $('#tematicaIndicador').empty();
                            $('#tematicaIndicador').prop('disabled', 'disabled');
                            if (resp === "Creado") {
                                document.getElementById("modal-content-indicador-created").innerHTML = "El indicador <b>" + nombreIndicador + "</b> ha sido creado correctamente.";
                                $("#modal-indicador-created").modal('show');
                            } else if (resp === "Error al crear") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear el indicador <b>" + nombreIndicador + "</b>.<br>Intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Id tematica no existe") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear el indicador <b>" + nombreIndicador + "</b>.<br>\n\
                                    No existe el id de la temática seleccionada.<br> Verifique la información e intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Nombre indicador en uso") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear el indicador <b>" + nombreIndicador + "</b>. Ya existe un indicador en la temática seleccionada, con el nombre ingresado.<br> Verifique la información e intente nuevamente.";
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
                $("#formCrearIndicador")[0].reset();
                $('#dimensionIndicador').empty();
                $('#dimensionIndicador').prop('disabled', 'disabled');
                $('#tematicaIndicador').empty();
                $('#tematicaIndicador').prop('disabled', 'disabled');
            });
        </script>
        <script>
            $(function () {
                $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
            });
        </script>
    </body>
</html>

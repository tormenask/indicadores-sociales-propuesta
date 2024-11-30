<?php
session_start();
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
$permiso = $rol->consultarPermisoRol("tematicas" . $idConj, $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$crear && ($modificar || $eliminar)) {
    header("Location: index.php?action=admin/tematicas/gestionTematicas&conj=" . $idConj);
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
                            <a href="index.php?action=admin/tematicas/gestionTematicas&conj=<?php echo $idConj; ?>" class="btn btn-primary" role="button">
                                <i class="fa fa-arrow-left"></i>
                                Volver a Gestión de temáticas
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top: 20px;">
                    <div class="col-sm-10 col-sm-offset-1">
                        <form class="form-horizontal" id="formCrearTematica">
                            <fieldset>
                                <legend class="font-color">Creación de temáticas</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="nombreTematica">Nombre</label>
                                    <div class="col-md-6">
                                        <input id="nombreTematica" name="nombreTematica" type="text" placeholder="Nombre de la temática" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="descripcionTematica">Descripción</label>
                                    <div class="col-md-6">
                                        <input id="descripcionTematica" name="descripcionTematica" type="text" placeholder="Descripción de la temática" class="form-control input-md">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="conjuntoTematica">Conjunto de indicadores</label>
                                    <div class="col-md-6">
                                        <select id="conjuntoTematica" name="conjuntoTematica" class="form-control">
                                            <option value="Seleccione">Seleccione un conjunto de indicadores</option>
                                            <?php
                                            echo '<option value="' . $conjuntoAct["idConjuntoIndicadores"] . '">' . $conjuntoAct["nombreConjuntoIndicadores"] . '</option>';
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="dimensionTematica">Dimensión</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="dimensionTematica" name="dimensionTematica" disabled>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="posicion">Posición</label>  
                                    <div class="col-md-6">
                                        <input id="posicion" name="posicion" type="number" placeholder="Posición de la temática" class="form-control input-md" >
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
                    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-tematica-created">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header active">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Creación exitosa</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-content-tematica-created"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" id="modal-btn-tematica-created-ok">Aceptar</button>
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
                </div>
            </div>
        </div>
        <?php include 'view/modules/footer.php'; ?>
        <script>
            $(document).ready(function () {
                $('#conjuntoTematica').on('change', function () {
                    var conjunto = document.getElementById("conjuntoTematica");
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
                                $('#dimensionTematica').html(resp);
                                $('#dimensionTematica').prop('disabled', false);
                            }
                        });
                    } else {
                        $('#dimensionTematica').empty();
                        $('#dimensionTematica').prop('disabled', 'disabled');
                    }
                });
            });
        </script>
        <script>
            $('#modal-confirm').on('shown.bs.modal', function (e) {
                var nombreTematicaModal = $("#nombreTematica").val();
                document.getElementById("modal-content-create").innerHTML = "Confirma la creación de la temática <b>" + nombreTematicaModal + "</b>";
            });
        </script>
        <script>
            $("#btn-confirm").on("click", function () {
                var nombreTematica = $("#nombreTematica").val();
                var dimensionTematica = $("#dimensionTematica").val();
                if (nombreTematica === "" || dimensionTematica === "") {
                    document.getElementById("modal-content-error").innerHTML = "Todos los campos son obligatorios.<br>Verfique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else if (dimensionTematica === "Seleccione") {
                    document.getElementById("modal-content-error").innerHTML = "Debe seleccionar una dimensión. Verifique la información e intente nuevamente.";
                    $("#modal-form-error").modal('show');
                } else {
                    $("#modal-confirm").modal('show');
                }
            });
            $("#modal-btn-form-error-ok").on("click", function () {
                $("#modal-form-error").modal('hide');
            });
            $("#modal-btn-si").on("click", function () {
                crearTematica();
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-no").on("click", function () {
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-tematica-created-ok").on("click", function () {
                $("#modal-tematica-created").modal('hide');
                window.location.replace("index.php?action=admin/tematicas/gestionTematicas&conj=<?php echo $idConj; ?>");
            });
        </script>
        <script>
            var conjunto = "#tematicas" + "<?php echo $idConj; ?>";
            $(conjunto).addClass("active");
            $("#tematicas").addClass("active");
        </script>
        <script>
            function crearTematica() {
                var nombreTematica = $("#nombreTematica").val();
                var descripcionTematica = $("#descripcionTematica").val();
                var dimensionTematica = $("#dimensionTematica").val();
                var posicion = $("#posicion").val();                
                if (nombreTematica === "" || dimensionTematica === "") {
                    $("#modal-form-error").modal('show');
                } else {
                    var url = "view/modules/admin/tematicas/funcionesTematicas.php";
                    var data = new FormData();
                    data.append("nombreTematica", nombreTematica);
                    data.append("descripcionTematica", descripcionTematica);
                    data.append("dimensionTematica", dimensionTematica);
                    data.append("posicion", posicion);
                    $.ajax({
                        url: url,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function (resp) {
                            $("#formCrearTematica")[0].reset();
                            $('#dimensionTematica').empty();
                            $('#dimensionTematica').prop('disabled', 'disabled');
                            if (resp === "Creada") {
                                document.getElementById("modal-content-tematica-created").innerHTML = "La temática <b>" + nombreTematica + "</b> ha sido creada correctamente.";
                                $("#modal-tematica-created").modal('show');
                            } else if (resp === "Error al crear") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la temática <b>" + nombreTematica + "</b>.<br>Intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Id dimension no existe") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la temática <b>" + nombreTematica + "</b>.<br>\n\
                                    No existe el id de la dimensión seleccionada.<br> Verifique la información e intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Nombre tematica en uso") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la temática <b>" + nombreTematica + "</b>. Ya existe una temática en la dimensión seleccionada, con el nombre ingresado.<br> Verifique la información e intente nuevamente.";
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
                $("#formCrearTematica")[0].reset();
                $('#dimensionTematica').empty();
                $('#dimensionTematica').prop('disabled', 'disabled');
            });
        </script>
        <script>
            $(function () {
                $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
            });
        </script>
    </body>
</html>

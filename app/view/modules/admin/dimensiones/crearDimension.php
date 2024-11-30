<?php
session_start();
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
$permiso = $rol->consultarPermisoRol("dimensiones" . $idConj, $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$crear && ($modificar || $eliminar)) {
    header("Location: index.php?action=admin/dimensiones/gestionDimensiones&conj=" . $idConj);
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
                            <a href="index.php?action=admin/dimensiones/gestionDimensiones&conj=<?php echo $idConj; ?>" class="btn btn-primary" role="button">
                                <i class="fa fa-arrow-left"></i>
                                Volver a Gestión de dimensiones
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top: 20px;">
                    <div class="col-sm-10 col-sm-offset-1">
                        <form class="form-horizontal" id="formCrearDimension">
                            <fieldset>
                                <legend class="font-color">Creación de dimensiones</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="nombreDimension">Nombre</label>  
                                    <div class="col-md-6">
                                        <input id="nombreDimension" name="nombreDimension" type="text" placeholder="Nombre de la dimensión" class="form-control input-md" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="descripcionDimension">Descripción</label>  
                                    <div class="col-md-6">
                                        <input id="descripcionDimension" name="descripcionDimension" type="text" placeholder="Descripción de la dimensión" class="form-control input-md">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="conjuntoDimension">Conjunto de indicadores</label>
                                    <div class="col-md-6">
                                        <select id="conjuntoDimension" name="conjuntoDimension" class="form-control">
                                            <?php
                                            echo '<option value="' . $conjuntoAct["idConjuntoIndicadores"] . '">' . $conjuntoAct["nombreConjuntoIndicadores"] . '</option>';
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="posicion">Posición</label>  
                                    <div class="col-md-6">
                                        <input id="posicion" name="posicion" type="number" placeholder="Posición de la dimensión" class="form-control input-md" value="0">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="icono">Icono</label>  
                                    <div class="col-md-6">
                                        <input id="icono" name="Icono" type="file" 
                                               accept = ".png, .jpeg,.jpg"
                                               placeholder="Seleccione un icono" class="form-control input-md" >
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <label class="col-md-4 control-label" for="color">Color</label>  
                                    <div class="col-md-2">
                                        <input type="color" value="#2fb56a" class="form-control" id="color" />
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" value="#2fb56a" class="form-control" id="color1" />
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
                    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-dimension-created">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header active">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Creación exitosa</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-content-dimension-created"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" id="modal-btn-dimension-created-ok">Aceptar</button>
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
            $('#color').on('change', function () {
                $('#color1').val(this.value);
            });
            $('#color1').on('change', function () {
                $('#color').val(this.value);
            });
        </script>
        <script>
            $('#modal-confirm').on('shown.bs.modal', function (e) {
                var nombreDimensionModal = $("#nombreDimension").val();
                document.getElementById("modal-content-create").innerHTML = "Confirma la creación de la dimension <b>" + nombreDimensionModal + "</b>";
            });
        </script>
        <script>
            $("#btn-confirm").on("click", function () {
                var nombreDimension = $("#nombreDimension").val();
                var descripcionDimension = $("#descripcionDimension").val();
                var conjuntoDimension = $("#conjuntoDimension").val();
                if (nombreDimension === "" || conjuntoDimension === "") {
                    $("#modal-form-error").modal('show');
                } else {
                    $("#modal-confirm").modal('show');
                }
            });
            $("#modal-btn-form-error-ok").on("click", function () {
                $("#modal-form-error").modal('hide');
            });
            $("#modal-btn-si").on("click", function () {
                crearDimension();
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-no").on("click", function () {
                $("#modal-confirm").modal('hide');
            });
            $("#modal-btn-dimension-created-ok").on("click", function () {
                $("#modal-dimension-created").modal('hide');
                window.location.replace("index.php?action=admin/dimensiones/gestionDimensiones&conj=<?php echo $idConj; ?>");
            });
        </script>
        <script>
            var conjunto = "#dimensiones" + "<?php echo $idConj; ?>";
            $(conjunto).addClass("active");
            $("#dimensiones").addClass("active");
        </script>
        <script>
            function crearDimension() {
                var nombreDimension = $("#nombreDimension").val();
                var descripcionDimension = $("#descripcionDimension").val();
                var conjuntoDimension = $("#conjuntoDimension").val();
                var posicion = $("#posicion").val();
                var color = $("#color").val();
                if (nombreDimension === "" || conjuntoDimension === "") {
                    $("#modal-form-error").modal('show');
                } else {
                    var url = "view/modules/admin/dimensiones/funcionesDimensiones.php";
                    var data = new FormData();
                    data.append("nombreDimension", nombreDimension);
                    data.append("descripcionDimension", descripcionDimension);
                    data.append("conjuntoDimension", conjuntoDimension);
                    data.append("posicion", posicion);
                    var icono = document.getElementById('icono');
                    var uploadFile = icono.files[0];
                    if (icono.files.length !== 0) {
                        jQuery.each($('input[type=file]')[0].files, function (i, file) {
                            if (file["size"] > 1000000) {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear el icono. <br> El archivo excede el peso máximo de 1 Mb.<br>Intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else {
                                data.append('file', true);
                                data.append('icono', uploadFile);
                            }
                        });
                    } else {
                        data.append('file', false);
                    }
                    data.append("color", color);
                    $.ajax({
                        url: url,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function (resp) {
                            $("#formCrearDimension")[0].reset();
                            if (resp === "Creada") {
                                document.getElementById("modal-content-dimension-created").innerHTML = "La dimensión <b>" + nombreDimension + "</b> ha sido creada correctamente.";
                                $("#modal-dimension-created").modal('show');
                            } else if (resp === "Error al crear") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la dimensión <b>" + nombreDimension + "</b>.<br>Intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Id conjunto no existe") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la dimensión <b>" + nombreDimension + "</b>.<br>\n\
                                    No existe el id del conjunto seleccionado.<br> Verifique la información e intente nuevamente.";
                                $("#modal-form-error").modal('show');
                            } else if (resp === "Nombre dimension en uso") {
                                document.getElementById("modal-content-error").innerHTML = "Error al crear la dimensión <b>" + nombreDimension + "</b>. Ya existe una dimensión en este conjunto, con el nombre ingresado.<br> Verifique la información e intente nuevamente.";
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
                $("#formCrearDimension")[0].reset();
            });
        </script>
        <script>
            $(function () {
                $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
            });
        </script>
    </body>
</html>

<?php
session_start();
include_once 'model/publicaciones.php';
include_once 'controller/publicaciones.php';
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
$permiso = $rol->consultarPermisoRol("publicaciones" . $idConj, $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
} elseif (!$crear && ($modificar || $eliminar)) {
    header("Location: index.php?action=admin/publicaciones/gestionPublicaciones&conj=" . $idConj);
}
?>
<html>   
    <?php include 'view/modules/head.php'; ?>
    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'view/modules/header.php'; ?>
            <?php include 'view/modules/side.php'; ?>
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-sm-12" style="margin-top:20px; margin-left: 20px;">
                        <div class="btn-group">
                            <a href="index.php?action=admin/publicaciones/gestionPublicaciones&conj=<?php echo $idConj; ?>" class="btn btn-primary" role="button">
                                <i class="fa fa-arrow-left"></i>
                                Volver a Gestión de Publicaciones
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top: 20px;">
                    <div class="col-sm-10 col-sm-offset-1">
                        <form class="form-horizontal" id="formCrearPublicaciones" >
                            <fieldset>
                                <legend class="font-color">Creación de publicaciones</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="urlPublicaciones">Url</label>
                                    <div class="col-md-6">
                                        <input id="urlPublicaciones" name="urlPublicaciones" type="text" placeholder="Url de la publicación" class="form-control input-md" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="categoriaPublicaciones">Categoría</label>  
                                    <div class="col-md-6">
                                        <input type="text" id="categoriaPublicaciones" name="categoriaPublicaciones" placeholder="Categoría de la publicación" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="tituloPublicaciones">Titulo</label>  
                                    <div class="col-md-6">
                                        <input type="text" id="tituloPublicaciones" name="tituloPublicaciones" placeholder="Título de la publicación" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="descripcionPublicaciones">Descripción</label>
                                    <div class="col-md-6">
                                        <input id="descripcionPublicaciones" name="descripcionPublicaciones" type="text" placeholder="Descripción de la publicación" class="form-control input-md" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="palabrasClavePublicaciones">Palabras clave</label>  
                                    <div class="col-md-6">
                                        <textarea id="palabrasClavePublicaciones" rows="4" name="palabrasClavePublicaciones" type="text" placeholder="Palabras clave" class="form-control input-md" ></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="contenidoPublicaciones">Contenido</label>  
                                    <div class="col-md-6">
                                        <textarea id="contenidoPublicaciones"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="conjuntoPublicaciones">Conjunto de indicadores</label>
                                    <div class="col-md-6">
                                        <select id="conjuntoPublicaciones" name="conjuntoPublicaciones" class="form-control">
                                            <?php
                                            echo '<option value="' . $conjuntoAct["idConjuntoIndicadores"] . '">' . $conjuntoAct["idConjuntoIndicadores"] . '</option>';
                                            ?>
                                        </select>
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label"></label>
                                    <div class="col-md-8">
                                        <button type="button" id="btn-confirm" name="btn-confirm" class="btn btn-primary">Crear publicación</button>
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
                                    <h4 class="modal-title">Confirmación</h4>
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
                    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-publicaciones-created">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header active">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Creación exitosa</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-content-publicaciones-created"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" id="modal-btn-publicaciones-created-ok">Aceptar</button>
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
                                        El campo Url y Conjunto de Indicadores es obligatorio.<br>
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
        var urlPublicacionesModal = $("#urlPublicaciones").val();
        document.getElementById("modal-content-create").innerHTML = "Confirma la creación de la publicación <b>" + urlPublicacionesModal + "</b>";

    });
</script>
<script>
    $('#contenidoPublicaciones').summernote({
        placeholder: 'Contenido de la publicación',
        tabsize: 2,
        height: 100
    });
</script>
<script>
    $("#btn-confirm").on("click", function () {
        var urlPublicaciones = $("#urlPublicaciones").val();
        var conjuntoPublicaciones = $("#conjuntoPublicaciones").val();

        if (urlPublicaciones === "" || conjuntoPublicaciones === "") {
            $("#modal-form-error").modal('show');
        } else {
            $("#modal-confirm").modal('show');
        }
    });
    $("#modal-btn-form-error-ok").on("click", function () {
        $("#modal-form-error").modal('hide');
    });
    $("#modal-btn-si").on("click", function () {
        crearPublicaciones();
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-no").on("click", function () {
        $("#modal-confirm").modal('hide');
    });
    $("#modal-btn-publicaciones-created-ok").on("click", function () {
        $("#modal-publicaciones-created").modal('hide');
        window.location.replace("index.php?action=admin/publicaciones/gestionPublicaciones&conj=<?php echo $idConj; ?>");
    });
</script>
<script>
    var conjunto = "#publicaciones" + "<?php echo $idConj; ?>";
    $(conjunto).addClass("active");
    $("#publicaciones").addClass("active");
</script>
<script>
    function crearPublicaciones() {
        var urlPublicaciones = $("#urlPublicaciones").val();
        var categoriaPublicaciones = $("#categoriaPublicaciones").val();
        var tituloPublicaciones = $("#tituloPublicaciones").val();
        var descripcionPublicaciones = $("#descripcionPublicaciones").val();
        var palabrasClavePublicaciones = $("#palabrasClavePublicaciones").val();
        var contenidoPublicaciones = $("#contenidoPublicaciones").val();
        var conjuntoPublicaciones = $("#conjuntoPublicaciones").val();
        if (urlPublicaciones === "" || conjuntoPublicaciones === "") {
            document.getElementById("modal-content-error").innerHTML = "El campo <b>Url</b> y <b>Conjunto de indicadores</b> es obligatorio.<br>Verfique la información e intente nuevamente.";
            $("#modal-form-error").modal('show');
        } else {
            var url = "view/modules/admin/publicaciones/funcionesPublicaciones.php";
            var data = new FormData();
            data.append("urlPublicaciones", urlPublicaciones);
            data.append("categoriaPublicaciones", categoriaPublicaciones);
            data.append("tituloPublicaciones", tituloPublicaciones);
            data.append("descripcionPublicaciones", descripcionPublicaciones);
            data.append("palabrasClavePublicaciones", palabrasClavePublicaciones);
            data.append("contenidoPublicaciones", contenidoPublicaciones);
            data.append("conjuntoPublicaciones", conjuntoPublicaciones);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    $("#formCrearPublicaciones")[0].reset();
                    if (resp === "Creada") {
                        document.getElementById("modal-content-publicaciones-created").innerHTML = "La publicación <b>" + urlPublicaciones + "</b> ha sido creada correctamente.";
                        $("#modal-publicaciones-created").modal('show');
                    } else if (resp === "Error al crear") {
                        document.getElementById("modal-content-error").innerHTML = "Error al crear la publicación <b>" + urlPublicaciones + "</b>.<br>Intente nuevamente.";
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
        $("#formCrearPublicaciones")[0].reset();
    });
</script>
<script>
    $(function () {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>
</body>
</html>

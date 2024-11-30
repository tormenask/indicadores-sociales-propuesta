<?php
include_once 'model/variable.php';
include_once 'controller/variable.php';
include_once 'model/log.php';
include_once 'controller/log.php';
include_once 'model/modulo.php';
include_once 'controller/modulo.php';
include_once 'model/rol.php';
include_once 'controller/rol.php';
session_start();
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$idConj = "";
if (isset($_GET['conj'])) {
    $idConj = $_GET['conj'];
}
$permiso = $rol->consultarPermisoRol("variables" . $idConj, $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
}
?>
<html>
    <?php include 'view/modules/head.php'; ?>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script> 
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script> 
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

    <!----->
    <script src="/app/view/resources/js/altEditor/dataTables.altEditor.free.js "></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css"/> 
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.1.2/css/select.dataTables.min.css"/>
    <script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
    <!----->

    <style type="text/css">
        td#prewrap {
            white-space: pre-wrap;
        }
    </style>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'view/modules/header.php'; ?>
            <?php include 'view/modules/side.php'; ?>
            <div class="content-wrapper" style="padding: 20px; background-color: #fff;">
                <?php
                if (isset($_GET['var'])) {
                    $idVar = $_GET['var'];
                }
                if (!empty($idVar)) {
                    $modulo = new Modulo();
                    $nombreModulo = "variables";
                    $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
                    $log = new LogController();
                    $log->crearLog($idModulo, "Ingreso a módulo de gestión de datos de la variable " . $idVar);
                    $var = new VariableController();
                    $resp = $var->mostrarConsultarDatosVariable($idConj);
                }
                ?>
            </div>
        </div>
    </div>
    <?php include 'view/modules/footer.php'; ?>
    <script>
        var conjunto = "#variables" + "<?php echo $idConj; ?>";
        $(conjunto).addClass("active");
        $("#variables").addClass("active");

        $("#modal-btn-form-error-ok").on("click", function () {
            $("#modal-form-error").modal('hide');
        });
        $("#modal-btn-dato-created-ok").on("click", function () {
            $("#modal-dato-created").modal('hide');
        });
        $("#modal-btn-dato-edited-ok").on("click", function () {
            $("#modal-dato-edited").modal('hide');
        });
        $("#modal-btn-dato-deleted-ok").on("click", function () {
            $("#modal-dato-deleted").modal('hide');
        });

        consultarDatosVariable("<?php echo $idVar; ?>");
        function consultarDatosVariable(idVariable) {
            var idVariableDat = idVariable;
            var data = new FormData();
            var url = "view/modules/admin/variables/funcionesVariables.php";
            data.append("idVariableDat", idVariableDat);
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                cache: false,
                async: true,
                contentType: false,
                processData: false,
                success: function (resp) {
                    console.log(resp);
                    $("#tabla-datos").html(resp);
                    $("#tabla-datos").show();
                }
            });
        }
        function agregarDato() {
            idVariable = $("#idVariableDat").text();
            $("#modal-create").modal('show');
        }
        function agregar() {
            var idVariable = $("#idVariable").val();
            var fechaDato = $("#fechaDato").val();
            var valorDato = $("#valorDato").val();
            var estadoObservacionDato = $("#estadoObservacion").val();
            if (fechaDato === "" || valorDato === "" || estadoObservacionDato === "" || idVariable === "" || estadoObservacionDato === "Selecciona") {
                $("#modal-create").modal('hide');
                document.getElementById('modal-content-error').innerHTML = 'Todos los datos son obligatorios. <br>Verifique la información e intente nuevamente.';
                $("#modal-form-error").modal('show');
            } else {
                var data = new FormData();
                var url = "view/modules/admin/variables/funcionesDatosVariable.php";
                data.append("fechaDato", fechaDato);
                data.append("valorDato", valorDato);
                data.append("estadoObservacionDato", estadoObservacionDato);
                data.append("idVariableDat", idVariable);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    cache: false,
                    async: true,
                    contentType: false,
                    processData: false,
                    success: function (resp) {
                        console.log(resp);
                        $("#modal-create").modal('hide');
                        if (resp === "Creado") {
                            document.getElementById("modal-content-dato-created").innerHTML = "El dato para el año <b>" + fechaDato + "</b> ha sido creado correctamente.";
                            $("#modal-dato-created").modal('show');
                        } else if (resp === "Error al crear") {
                            document.getElementById("modal-content-error").innerHTML = "Error al crear el dato para el año <b>" + fechaDato + "</b>.<br>Intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        } else if (resp === "Id variable no existe") {
                            document.getElementById("modal-content-error").innerHTML = "Error al crear el dato para el año <b>" + fechaDato + "</b>.<br>\n\
                                    No existe una variable con el id ingresado.<br> Verifique la información e intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        } else if (resp === "Dato existe") {
                            document.getElementById("modal-content-error").innerHTML = "Error al crear el dato para el año <b>" + fechaDato + "</b>. Ya existe un dato en esta variable, para el año seleccionado.<br> Verifique la información e intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        } else {
                            document.getElementById("modal-content-error").innerHTML = "Error al crear el dato para el año <b>" + fechaDato + "</b>.<br>Intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        }
                        consultarDatosVariable("<?php echo $idVar; ?>");
                    }
                });
            }
        }
        function editarDato(row) {
            var fields = row.split('","');
            var idDato = fields[1];
            var fechaDato = fields[2];
            var valorDatoPrev = fields[3];
            var valorDato = valorDatoPrev.replace(/,/g, '');
            var estadoObservacionDatoPrev = fields[4];
            var estadoObservacionDato = estadoObservacionDatoPrev.split('"]]')[0];
            $("#id-dato-edit").val(idDato);
            $("#fecha-dato-edit").val(fechaDato);
            $("#valor-dato-edit").val(valorDato);
            $("#estado-dato-edit").val(estadoObservacionDato);
            $("#modal-edit").modal('show');
        }
        function editar() {
            var idVariable = $("#id-variable-edit").val();
            var idDato = $("#id-dato-edit").val();
            var fechaDato = $("#fecha-dato-edit").val();
            var valorDato = $("#valor-dato-edit").val();
            var estadoObservacionDato = $("#estado-dato-edit").val();
            if (fechaDato === "" || valorDato === "" || estadoObservacionDato === "" || idVariable === "" || estadoObservacionDato === "Selecciona") {
                $("#modal-edit").modal('hide');
                document.getElementById('modal-content-error').innerHTML = 'Todos los datos son obligatorios. <br>Verifique la información e intente nuevamente.';
                $("#modal-form-error").modal('show');
            } else {
                var data = new FormData();
                var url = "view/modules/admin/variables/funcionesDatosVariable.php";
                data.append("idDatoEdit", idDato);
                data.append("fechaDatoEdit", fechaDato);
                data.append("valorDatoEdit", valorDato);
                data.append("estadoObservacionDatoEdit", estadoObservacionDato);
                data.append("idVariableDatEdit", idVariable);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    cache: false,
                    async: true,
                    contentType: false,
                    processData: false,
                    success: function (resp) {
                        console.log(resp);
                        $("#modal-edit").modal('hide');
                        if (resp === "Editado") {
                            document.getElementById("modal-content-dato-edited").innerHTML = "El dato para el año <b>" + fechaDato + "</b> ha sido editado correctamente.";
                            $("#modal-dato-edited").modal('show');
                        } else if (resp === "Error al editar") {
                            document.getElementById("modal-content-error").innerHTML = "Error al editar el dato para el año <b>" + fechaDato + "</b>.<br>Intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        } else if (resp === "Id variable no existe") {
                            document.getElementById("modal-content-error").innerHTML = "Error al editar el dato para el año <b>" + fechaDato + "</b>.<br>\n\
                                    No existe una variable con el id ingresado.<br> Verifique la información e intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        } else if (resp === "Dato no existe") {
                            document.getElementById("modal-content-error").innerHTML = "Error al editar el dato para el año <b>" + fechaDato + "</b>. No existe un dato en esta variable, para el año seleccionado.<br> Verifique la información e intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        } else {
                            document.getElementById("modal-content-error").innerHTML = "Error al editar el dato para el año <b>" + fechaDato + "</b>.<br>Intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        }
                        consultarDatosVariable("<?php echo $idVar; ?>");
                    }
                });
            }
        }
        function eliminarDato(row) {
            var fields = row.split('","');
            var idDato = fields[1];
            var fechaDato = fields[2];
            var valorDatoPrev = fields[3];
            var valorDato = valorDatoPrev.replace(/,/g, '');
            var estadoObservacionDatoPrev = fields[4];
            var estadoObservacionDato = estadoObservacionDatoPrev.split('"]]')[0];
            $("#id-dato-delete").val(idDato);
            $("#fecha-dato-delete").val(fechaDato);
            $("#valor-dato-delete").val(valorDato);
            $("#estado-dato-delete").val(estadoObservacionDato);
            $("#modal-delete").modal('show');
        }
        function eliminar() {
            var idVariable = $("#id-variable-delete").val();
            var idDato = $("#id-dato-delete").val();
            var fechaDato = $("#fecha-dato-delete").val();
            var valorDato = $("#valor-dato-delete").val();
            var estadoObservacionDato = $("#estado-dato-delete").val();
            if (fechaDato === "" || valorDato === "" || estadoObservacionDato === "" || idVariable === "" || estadoObservacionDato === "Selecciona") {
                $("#modal-delete").modal('hide');
                document.getElementById('modal-content-error').innerHTML = 'Todos los datos son obligatorios. <br>Verifique la información e intente nuevamente.';
                $("#modal-form-error").modal('show');
            } else {
                var data = new FormData();
                var url = "view/modules/admin/variables/funcionesDatosVariable.php";
                data.append("idDatoDelete", idDato);
                data.append("fechaDatoDelete", fechaDato);
                data.append("idVariableDatDelete", idVariable);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    cache: false,
                    async: true,
                    contentType: false,
                    processData: false,
                    success: function (resp) {
                        console.log(resp);
                        $("#modal-delete").modal('hide');
                        if (resp === "Eliminado") {
                            document.getElementById("modal-content-dato-deleted").innerHTML = "El dato para el año <b>" + fechaDato + "</b> ha sido eliminado correctamente.";
                            $("#modal-dato-deleted").modal('show');
                        } else if (resp === "Error al eliminar") {
                            document.getElementById("modal-content-error").innerHTML = "Error al eliminar el dato para el año <b>" + fechaDato + "</b>.<br>Intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        } else if (resp === "Id variable no existe") {
                            document.getElementById("modal-content-error").innerHTML = "Error al eliminar el dato para el año <b>" + fechaDato + "</b>.<br>\n\
                                    No existe una variable con el id ingresado.<br> Verifique la información e intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        } else if (resp === "Dato no existe") {
                            document.getElementById("modal-content-error").innerHTML = "Error al eliminar el dato para el año <b>" + fechaDato + "</b>. No existe un dato en esta variable, para el año seleccionado.<br> Verifique la información e intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        } else {
                            document.getElementById("modal-content-error").innerHTML = "Error al eliminar el dato para el año <b>" + fechaDato + "</b>.<br>Intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        }
                        consultarDatosVariable("<?php echo $idVar; ?>");
                    }
                });
            }
        }
    </script>
</body>
</html>
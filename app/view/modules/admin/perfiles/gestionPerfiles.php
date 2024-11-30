<?php
include_once 'model/rol.php';
include_once 'controller/rol.php';
include_once 'model/perfil.php';
include_once 'controller/perfil.php';
session_start();
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$permiso = $rol->consultarPermisoRol("perfiles", $idRol);
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
                $dat = new PerfilController();
                $dat->mostrarConsultarDatosPerfiles();
                ?>
            </div>
        </div>
    </div>
    <?php include 'view/modules/footer.php'; ?>
    <script>
        var conjunto = "#perfiles";
        $("#perfiles").addClass("active");

        $("#tipoZonaGeograficaConsultaPerfiles").multiselect({
            nonSelectedText: "Seleccione un tipo de zona geográfica",
            buttonWidth: "100%",
            disableIfEmpty: true,
            enableCaseInsensitiveFiltering: true,
            onChange: function (option, checked) {
                var tipoZonaGeografica = $("#tipoZonaGeograficaConsultaPerfiles").val();
                
                var selectedOptions = $("#tipoZonaGeograficaConsultaPerfiles option:selected");
                if (selectedOptions.length >= 1) {
                    activarBotonConsulta(true);
                    var nonSelectedOptions = $('#tipoZonaGeograficaConsultaPerfiles option').filter(function () {
                        return !$(this).is(':selected');
                    });
                    nonSelectedOptions.each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', true);
                        input.parent('li').addClass('disabled');
                    });
                } else {
                    activarBotonConsulta(false);
                    $('#tipoZonaGeograficaConsultaPerfiles option').each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', false);
                        input.parent('li').addClass('disabled');
                    });
                }
            }
        });

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
        $("#modal-btn-cancel").on("click", function () {
            $("#modal-edit").modal('hide');
        });

        function activarBotonConsulta(valor) {
            var button = $('#btnConsultar');
            if (valor === false) {
                $(button).prop('disabled', true);
            } else {
                $(button).prop('disabled', false);
            }
        }
        function consultarDatos() {
            var tipoZonaGeografica = $("#tipoZonaGeograficaConsultaPerfiles").val();
            var data = new FormData();
            var url = "view/modules/admin/perfiles/funcionesPerfiles.php";
            data.append("tipoZonaGeografica", tipoZonaGeografica);
            data.append("idRol", <?php echo $idRol; ?>);
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                cache: false,
                async: true,
                contentType: false,
                processData: false,
                success: function (resp) {
//                    console.log(resp);
                    $("#tabla-datos").html(resp);
                    $("#tabla-datos").show();
                }
            });
        }
        function agregarDato() {
            $("#modal-create").modal('show');
        }
        function agregar() {
            var tipoZonaGeografica = $("#tipo-zona-perfil").val();
            var zonaGeografica = "Cali";
            if (tipoZonaGeografica === "Comunas") {
                zonaGeografica = $("#comuna-dato-perfil").val();
            } else if (tipoZonaGeografica === "Corregimientos") {
                zonaGeografica = $("#corregimiento-dato-perfil").val();
            }
            var fechaDato = $("#fecha-dato-perfil").val();
            var valorDato = $("#valor-dato-perfil").val();
            var posicion = $("#posicion-dato-perfil").val();
            var dimension = $("#dimension-dato-perfil").val();
            var indicador = $("#indicador-dato-perfil").val();
            var unidadMedicion = $("#unidad-dato-perfil").val();
            var fuenteDatos = $("#fuente-dato-perfil").val();
            if (tipoZonaGeografica === "" || zonaGeografica === "" || fechaDato === "" || valorDato === "" || posicion === "" || dimension === "" || indicador === "" || unidadMedicion === "" || fuenteDatos === "") {
                $("#modal-create").modal('hide');
                $("#modal-form-error").modal('show');
            } else {
                var data = new FormData();
                var url = "view/modules/admin/perfiles/funcionesPerfiles.php";
                data.append("zonaGeografica", zonaGeografica);
                data.append("fechaDato", fechaDato);
                data.append("valorDato", valorDato);
                data.append("posicion", posicion);
                data.append("dimension", dimension);
                data.append("indicador", indicador);
                data.append("unidadMedicion", unidadMedicion);
                data.append("fuenteDatos", fuenteDatos);
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
                        } else if (resp === "Dato existe") {
                            document.getElementById("modal-content-error").innerHTML = "Error al crear el dato para el año <b>" + fechaDato + "</b>. Ya existe un dato en este indicador, para el año y zona geográfica seleccionados.<br> Verifique la información e intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        }
                        consultarDatos();
                    }
                });
            }
        }
        function editarDato(row) {
            var fields = row.split('","');
            var idDato = fields[1];
            var dimension = fields[2];
            var indicador = fields[3];
            var posicion = fields[4];
            var zonaGeografica = fields[5];
            var fechaDato = fields[6];
            var valorDatoPrev = fields[7];
            var valorDato = valorDatoPrev.replace(/,/g, '');
            var unidadMedida = fields[8];
            var fuenteDatosPrev = fields[9];
            var fuenteDatos = fuenteDatosPrev.split('"]]')[0];
            $("#id-dato-perfil-edit").val(idDato);
            $("#dimension-dato-perfil-edit").val(dimension);
            $("#indicador-dato-perfil-edit").val(indicador);
            $("#posicion-dato-perfil-edit").val(posicion);
            var tipoZonaGeografica = $("#tipo-zona-perfil-edit").val();
            if (tipoZonaGeografica === "Comunas") {
                $("#comuna-dato-perfil-edit").val(zonaGeografica);
            } else if (tipoZonaGeografica === "Corregimientos") {
                $("#corregimiento-dato-perfil-edit").val(zonaGeografica);
            }
            $("#fecha-dato-perfil-edit").val(fechaDato);
            $("#valor-dato-perfil-edit").val(valorDato);
            $("#unidad-dato-perfil-edit").val(unidadMedida);
            $("#fuente-dato-perfil-edit").val(fuenteDatos);
            $("#modal-edit").modal('show');
        }
        function editar() {
            var tipoZonaGeografica = $("#tipo-zona-perfil-edit").val();
            var zonaGeografica = "Cali";
            if (tipoZonaGeografica === "Comunas") {
                zonaGeografica = $("#comuna-dato-perfil-edit").val();
            } else if (tipoZonaGeografica === "Corregimientos") {
                zonaGeografica = $("#corregimiento-dato-perfil-edit").val();
            }
            var idDato = $("#id-dato-perfil-edit").val();
            var fechaDato = $("#fecha-dato-perfil-edit").val();
            var valorDato = $("#valor-dato-perfil-edit").val();
            var posicion = $("#posicion-dato-perfil-edit").val();
            var dimension = $("#dimension-dato-perfil-edit").val();
            var indicador = $("#indicador-dato-perfil-edit").val();
            var unidadMedicion = $("#unidad-dato-perfil-edit").val();
            var fuenteDatos = $("#fuente-dato-perfil-edit").val();
            if (tipoZonaGeografica === "" || zonaGeografica === "" || idDato === "" || fechaDato === "" || valorDato === "" || posicion === "" || dimension === "" || indicador === "" || unidadMedicion === "" || fuenteDatos === "") {
                $("#modal-edit").modal('hide');
                $("#modal-form-error").modal('show');
            } else {
                var data = new FormData();
                var url = "view/modules/admin/perfiles/funcionesPerfiles.php";
                data.append("idDatoEdit", idDato);
                data.append("zonaGeograficaEdit", zonaGeografica);
                data.append("fechaDatoEdit", fechaDato);
                data.append("valorDatoEdit", valorDato);
                data.append("posicionEdit", posicion);
                data.append("dimensionEdit", dimension);
                data.append("indicadorEdit", indicador);
                data.append("unidadMedicionEdit", unidadMedicion);
                data.append("fuenteDatosEdit", fuenteDatos);
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
                        } else if (resp === "Id serie no existe") {
                            document.getElementById("modal-content-error").innerHTML = "Error al editar el dato para el año <b>" + fechaDato + "</b>.<br>\n\
                                    No existe una serie con el id ingresado.<br> Verifique la información e intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        } else if (resp === "Dato no existe") {
                            document.getElementById("modal-content-error").innerHTML = "Error al editar el dato para el año <b>" + fechaDato + "</b>. No existe un dato en esta serie, para el año seleccionado.<br> Verifique la información e intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        }
                        consultarDatos();
                    }
                });
            }
        }
        function eliminarDato(row) {
            var fields = row.split('","');
            var idDato = fields[1];
            var dimension = fields[2];
            var indicador = fields[3];
            var posicion = fields[4];
            var zonaGeografica = fields[5];
            var fechaDato = fields[6];
            var valorDatoPrev = fields[7];
            var valorDato = valorDatoPrev.replace(/,/g, '');
            var unidadMedida = fields[8];
            var fuenteDatosPrev = fields[9];
            var fuenteDatos = fuenteDatosPrev.split('"]]')[0];
            $("#id-dato-perfil-delete").val(idDato);
            $("#dimension-dato-perfil-delete").val(dimension);
            $("#indicador-dato-perfil-delete").val(indicador);
            $("#posicion-dato-perfil-delete").val(posicion);
            var tipoZonaGeografica = $("#tipo-zona-perfil-delete").val();
            if (tipoZonaGeografica === "Comunas") {
                $("#comuna-dato-perfil-delete").val(zonaGeografica);
            } else if (tipoZonaGeografica === "Corregimientos") {
                $("#corregimiento-dato-perfil-delete").val(zonaGeografica);
            }
            $("#fecha-dato-perfil-delete").val(fechaDato);
            $("#valor-dato-perfil-delete").val(valorDato);
            $("#unidad-dato-perfil-delete").val(unidadMedida);
            $("#fuente-dato-perfil-delete").val(fuenteDatos);
            $("#modal-delete").modal('show');
        }
        function eliminar() {
            var tipoZonaGeografica = $("#tipo-zona-perfil-delete").val();
            var zonaGeografica = "Cali";
            if (tipoZonaGeografica === "Comunas") {
                zonaGeografica = $("#comuna-dato-perfil-delete").val();
            } else if (tipoZonaGeografica === "Corregimientos") {
                zonaGeografica = $("#corregimiento-dato-perfil-delete").val();
            }
            var idDato = $("#id-dato-perfil-delete").val();
            var fechaDato = $("#fecha-dato-perfil-delete").val();
            var valorDato = $("#valor-dato-perfil-delete").val();
            var posicion = $("#posicion-dato-perfil-delete").val();
            var dimension = $("#dimension-dato-perfil-delete").val();
            var indicador = $("#indicador-dato-perfil-delete").val();
            var unidadMedicion = $("#unidad-dato-perfil-delete").val();
            var fuenteDatos = $("#fuente-dato-perfil-delete").val();
            if (tipoZonaGeografica === "" || zonaGeografica === "" || idDato === "" || fechaDato === "" || valorDato === "" || posicion === "" || dimension === "" || indicador === "" || unidadMedicion === "" || fuenteDatos === "") {
                $("#modal-delete").modal('hide');
                $("#modal-form-error").modal('show');
            } else {
                var data = new FormData();
                var url = "view/modules/admin/perfiles/funcionesPerfiles.php";
                data.append("idDatoDelete", idDato);
                data.append("zonaGeograficaDelete", zonaGeografica);
                data.append("fechaDatoDelete", fechaDato);
                data.append("dimensionDelete", dimension);
                data.append("indicadorDelete", indicador);
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
                        } else if (resp === "Id serie no existe") {
                            document.getElementById("modal-content-error").innerHTML = "Error al eliminar el dato para el año <b>" + fechaDato + "</b>.<br>\n\
                                    No existe una serie con el id ingresado.<br> Verifique la información e intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        } else if (resp === "Dato no existe") {
                            document.getElementById("modal-content-error").innerHTML = "Error al eliminar el dato para el año <b>" + fechaDato + "</b>. No existe un dato en esta serie, para el año seleccionado.<br> Verifique la información e intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        }
                        consultarDatos();
                    }
                });
            }
        }
        function sleep(ms) {
            console.log("Start sleep");
            return new Promise(resolve => setTimeout(resolve, ms));
        }
        
    </script>
</body>
</html>
<?php
include_once 'model/dato.php';
include_once 'controller/dato.php';
include_once 'model/serieDatos.php';
include_once 'controller/serieDatos.php';
include_once 'model/indicador.php';
include_once 'controller/indicador.php';
include_once 'model/tematica.php';
include_once 'controller/tematica.php';
include_once 'model/dimension.php';
include_once 'controller/dimension.php';
include_once 'model/log.php';
include_once 'controller/log.php';
include_once 'model/rol.php';
include_once 'controller/rol.php';
session_start();
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$idConj = "";
if (isset($_GET['conj'])) {
    $idConj = $_GET['conj'];
}
$permiso = $rol->consultarPermisoRol("datos" . $idConj, $idRol);
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
                if (!empty($idConj)) {
                    $modulo = new Modulo();
                    $nombreModulo = "datos";
                    $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
                    $log = new LogController();
                    $log->crearLog($idModulo, "Ingreso a módulo de gestión de datos del conjunto " . $idConj);
                    $dat = new DatoController();
                    $dat->mostrarConsultarDatos($idConj);
                }
                ?>
            </div>
        </div>
    </div>
    <?php include 'view/modules/footer.php'; ?>
    <script>
        var conjunto = "#datos" + "<?php echo $idConj; ?>";
        $(conjunto).addClass("active");
        $("#datos").addClass("active");

        $("#dimensionConsultaDatos").multiselect({
            nonSelectedText: "Seleccione una dimensión",
            buttonWidth: "100%",
            disableIfEmpty: true,
            enableCaseInsensitiveFiltering: true,
            onChange: function (option, checked) {
                var dimension = $("#dimensionConsultaDatos").val();
                var selectedOptions = $("#dimensionConsultaDatos option:selected");
                if (selectedOptions.length >= 1) {
                    consultarTematicas(dimension);
                    var nonSelectedOptions = $('#dimensionConsultaDatos option').filter(function () {
                        return !$(this).is(':selected');
                    });
                    nonSelectedOptions.each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', true);
                        input.parent('li').addClass('disabled');
                    });
                } else {
                    $('#tematicaConsultaDatos').empty().multiselect('refresh');
                    $("#tematicaConsultaDatos").multiselect("disable");
                    $('#indicadorConsultaDatos').empty().multiselect('refresh');
                    $("#indicadorConsultaDatos").multiselect("disable");
                    $('#tipoZonaGeograficaConsultaDatos').empty().multiselect('refresh');
                    $("#tipoZonaGeograficaConsultaDatos").multiselect("disable");
                    $('#zonaGeograficaConsultaDatos').empty().multiselect('refresh');
                    $("#zonaGeograficaConsultaDatos").multiselect("disable");
                    $('#desagregacionTematicaConsultaDatos').empty().multiselect('refresh');
                    $("#desagregacionTematicaConsultaDatos").multiselect("disable");
                    activarBotonConsulta(false);
                    $('#dimensionConsultaDatos option').each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', false);
                        input.parent('li').addClass('disabled');
                    });
                }
            }
        });
        $("#tematicaConsultaDatos").multiselect({
            nonSelectedText: "Seleccione una temática",
            buttonWidth: "100%",
            disableIfEmpty: true,
            enableCaseInsensitiveFiltering: true,
            onChange: function (option, checked) {
                var tematica = $("#tematicaConsultaDatos").val();
                var selectedOptions = $("#tematicaConsultaDatos option:selected");
                if (selectedOptions.length >= 1) {
                    consultarIndicadores(tematica);
                    var nonSelectedOptions = $('#tematicaConsultaDatos option').filter(function () {
                        return !$(this).is(':selected');
                    });
                    nonSelectedOptions.each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', true);
                        input.parent('li').addClass('disabled');
                    });
                } else {
                    $('#indicadorConsultaDatos').empty().multiselect('refresh');
                    $("#indicadorConsultaDatos").multiselect("disable");
                    $('#tipoZonaGeograficaConsultaDatos').empty().multiselect('refresh');
                    $("#tipoZonaGeograficaConsultaDatos").multiselect("disable");
                    $('#zonaGeograficaConsultaDatos').empty().multiselect('refresh');
                    $("#zonaGeograficaConsultaDatos").multiselect("disable");
                    $('#desagregacionTematicaConsultaDatos').empty().multiselect('refresh');
                    $("#desagregacionTematicaConsultaDatos").multiselect("disable");
                    activarBotonConsulta(false);
                    $('#tematicaConsultaDatos option').each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', false);
                        input.parent('li').addClass('disabled');
                    });
                }
            }
        });
        $("#indicadorConsultaDatos").multiselect({
            nonSelectedText: "Seleccione un indicador",
            buttonWidth: "100%",
            disableIfEmpty: true,
            enableCaseInsensitiveFiltering: true,
            onChange: function (option, checked) {
                var indicador = $("#indicadorConsultaDatos").val();
                var selectedOptions = $("#indicadorConsultaDatos option:selected");
                if (selectedOptions.length >= 1) {
                    consultarTipoZonas(indicador);
                    var nonSelectedOptions = $('#indicadorConsultaDatos option').filter(function () {
                        return !$(this).is(':selected');
                    });
                    nonSelectedOptions.each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', true);
                        input.parent('li').addClass('disabled');
                    });
                } else {
                    $('#tipoZonaGeograficaConsultaDatos').empty().multiselect('refresh');
                    $("#tipoZonaGeograficaConsultaDatos").multiselect("disable");
                    $('#zonaGeograficaConsultaDatos').empty().multiselect('refresh');
                    $("#zonaGeograficaConsultaDatos").multiselect("disable");
                    $('#desagregacionTematicaConsultaDatos').empty().multiselect('refresh');
                    $("#desagregacionTematicaConsultaDatos").multiselect("disable");
                    activarBotonConsulta(false);
                    $('#indicadorConsultaDatos option').each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', false);
                        input.parent('li').addClass('disabled');
                    });
                }
            }
        });
        $("#tipoZonaGeograficaConsultaDatos").multiselect({
            nonSelectedText: "Seleccione un tipo de zona geográfica",
            buttonWidth: "100%",
            disableIfEmpty: true,
            enableCaseInsensitiveFiltering: true,
            onChange: function (option, checked) {
                var indicador = $("#indicadorConsultaDatos").val();
                var tipoZonaGeografica = $("#tipoZonaGeograficaConsultaDatos").val();
                var selectedOptions = $("#tipoZonaGeograficaConsultaDatos option:selected");
                if (selectedOptions.length >= 1) {
                    consultarZonas(indicador, tipoZonaGeografica);
                    var nonSelectedOptions = $('#tipoZonaGeograficaConsultaDatos option').filter(function () {
                        return !$(this).is(':selected');
                    });
                    nonSelectedOptions.each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', true);
                        input.parent('li').addClass('disabled');
                    });
                } else {
                    $('#zonaGeograficaConsultaDatos').empty().multiselect('refresh');
                    $("#zonaGeograficaConsultaDatos").multiselect("disable");
                    $('#desagregacionTematicaConsultaDatos').empty().multiselect('refresh');
                    $("#desagregacionTematicaConsultaDatos").multiselect("disable");
                    activarBotonConsulta(false);
                    $('#tipoZonaGeograficaConsultaDatos option').each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', false);
                        input.parent('li').addClass('disabled');
                    });
                }
            }
        });
        $("#zonaGeograficaConsultaDatos").multiselect({
            nonSelectedText: "Seleccione una zona geográfica",
            buttonWidth: "100%",
            disableIfEmpty: true,
            enableCaseInsensitiveFiltering: true,
            onChange: function (option, checked) {
                var indicador = $("#indicadorConsultaDatos").val();
                var tipoZonaGeografica = $("#tipoZonaGeograficaConsultaDatos").val();
                var zonaGeografica = $("#zonaGeograficaConsultaDatos").val();
                var selectedOptions = $("#zonaGeograficaConsultaDatos option:selected");
                if (selectedOptions.length >= 1) {
                    consultarDesagregacionesTematicas(indicador, tipoZonaGeografica, zonaGeografica);
                    var nonSelectedOptions = $('#zonaGeograficaConsultaDatos option').filter(function () {
                        return !$(this).is(':selected');
                    });
                    nonSelectedOptions.each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', true);
                        input.parent('li').addClass('disabled');
                    });
                } else {
                    $('#desagregacionTematicaConsultaDatos').empty().multiselect('refresh');
                    $("#desagregacionTematicaConsultaDatos").multiselect("disable");
                    activarBotonConsulta(false);
                    $('#zonaGeograficaConsultaDatos option').each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', false);
                        input.parent('li').addClass('disabled');
                    });
                }
            }
        });
        $("#desagregacionTematicaConsultaDatos").multiselect({
            nonSelectedText: "Seleccione una desagregación temática",
            buttonWidth: "100%",
            disableIfEmpty: true,
            enableCaseInsensitiveFiltering: true,
            onChange: function (option, checked) {
                var desagregacionTematica = $("#desagregacionTematicaConsultaDatos").val();
                var selectedOptions = $("#desagregacionTematicaConsultaDatos option:selected");
                if (selectedOptions.length >= 1) {
                    activarBotonConsulta(true);
                    var nonSelectedOptions = $('#desagregacionTematicaConsultaDatos option').filter(function () {
                        return !$(this).is(':selected');
                    });
                    nonSelectedOptions.each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', true);
                        input.parent('li').addClass('disabled');
                    });
                } else {
                    activarBotonConsulta(false);
                    $('#desagregacionTematicaConsultaDatos option').each(function () {
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

        consultarDimensiones("<?php echo $idConj; ?>");

        function consultarDimensiones(idConjuntoIndicadores) {
            var data = new FormData();
            var url = "view/modules/admin/datos/funcionesDatos.php";
            data.append("idConjuntoIndicadoresDim", idConjuntoIndicadores);
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                cache: false,
                async: true,
                contentType: false,
                processData: false,
                success: function (resp) {
                    var result = eval(resp);
                    $('#dimensionConsultaDatos').multiselect('dataprovider', result);
                }
            });
        }
        function consultarTematicas(idDimension) {
            var data = new FormData();
            var url = "view/modules/admin/datos/funcionesDatos.php";
            data.append("idDimensionTem", idDimension);
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
                    var result = eval(resp);
                    $('#tematicaConsultaDatos').multiselect('dataprovider', result);

                }
            });
        }
        function consultarIndicadores(idTematica) {
            var data = new FormData();
            var url = "view/modules/admin/datos/funcionesDatos.php";
            data.append("idTematicaInd", idTematica);
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
                    var result = eval(resp);
                    $('#indicadorConsultaDatos').multiselect('dataprovider', result);
                }
            });
        }
        function consultarTipoZonas(idIndicador) {
            var data = new FormData();
            var url = "view/modules/admin/datos/funcionesDatos.php";
            data.append("idIndicadorDat", idIndicador);
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
                    var result = eval(resp);
                    $('#tipoZonaGeograficaConsultaDatos').multiselect('dataprovider', result);
                }
            });
        }
        function consultarZonas(idIndicador, tipoZonas) {
            var data = new FormData();
            var url = "view/modules/admin/datos/funcionesDatos.php";
            data.append("idIndicadorDat2", idIndicador);
            data.append("tipoZonaDat", tipoZonas);
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
                    var result = eval(resp);
                    $('#zonaGeograficaConsultaDatos').multiselect('dataprovider', result);
                }
            });
        }
        function consultarDesagregacionesTematicas(idIndicador, tipoZonas, zona) {
            var data = new FormData();
            var url = "view/modules/admin/datos/funcionesDatos.php";
            data.append("idIndicadorDat3", idIndicador);
            data.append("tipoZonaDat3", tipoZonas);
            data.append("zonaDat3", zona);
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
                    var result = eval(resp);
                    $('#desagregacionTematicaConsultaDatos').multiselect('dataprovider', result);
                }
            });
        }
        function activarBotonConsulta(valor) {
            var button = $('#btnConsultar');
            if (valor === false) {
                $(button).prop('disabled', true);
            } else {
                $(button).prop('disabled', false);
            }
        }
        function consultarDatos() {
            var idIndicador = $("#indicadorConsultaDatos").val();
            var tipoZonaGeografica = $("#tipoZonaGeograficaConsultaDatos").val();
            var zonaGeografica = $("#zonaGeograficaConsultaDatos").val();
            var desagregacionTematica = $("#desagregacionTematicaConsultaDatos").val();
            var data = new FormData();
            var url = "view/modules/admin/datos/funcionesDatos.php";
            data.append("idIndicadorDat4", idIndicador);
            data.append("tipoZonaDat4", tipoZonaGeografica);
            data.append("zonaDat4", zonaGeografica);
            data.append("desagregacionTematicaDat4", desagregacionTematica);
            data.append("idRolDat4", <?php echo $idRol; ?>);
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
            idSerieDatos = $("#idSerieDat").text();
            $("#modal-create").modal('show');
        }
        function agregar() {
            var idSerieDatos = $("#idSerieDatos").val();
            var fechaDato = $("#fechaDato").val();
            var valorDato = $("#valorDato").val();
            var estadoObservacionDato = $("#estadoObservacion").val();
            if (fechaDato === "" || valorDato === "" || estadoObservacionDato === "" || idSerieDatos === "" || estadoObservacionDato === "Selecciona") {
                $("#modal-create").modal('hide');
                $("#modal-form-error").modal('show');
            } else {
                var data = new FormData();
                var url = "view/modules/admin/datos/funcionesDatos.php";
                data.append("fechaDato", fechaDato);
                data.append("valorDato", valorDato);
                data.append("estadoObservacionDato", estadoObservacionDato);
                data.append("idSerieDatos", idSerieDatos);
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
                        } else if (resp === "Id serie no existe") {
                            document.getElementById("modal-content-error").innerHTML = "Error al crear el dato para el año <b>" + fechaDato + "</b>.<br>\n\
                                    No existe una serie con el id ingresado.<br> Verifique la información e intente nuevamente.";
                            $("#modal-form-error").modal('show');
                        } else if (resp === "Dato existe") {
                            document.getElementById("modal-content-error").innerHTML = "Error al crear el dato para el año <b>" + fechaDato + "</b>. Ya existe un dato en esta serie, para el año seleccionado.<br> Verifique la información e intente nuevamente.";
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
            var idSerieDatos = $("#id-serie-edit").val();
            var idDato = $("#id-dato-edit").val();
            var fechaDato = $("#fecha-dato-edit").val();
            var valorDato = $("#valor-dato-edit").val();
            var estadoObservacionDato = $("#estado-dato-edit").val();
            if (fechaDato === "" || valorDato === "" || estadoObservacionDato === "" || idSerieDatos === "" || estadoObservacionDato === "Selecciona") {
                $("#modal-edit").modal('hide');
                $("#modal-form-error").modal('show');
            } else {
                var data = new FormData();
                var url = "view/modules/admin/datos/funcionesDatos.php";
                data.append("idDatoEdit", idDato);
                data.append("fechaDatoEdit", fechaDato);
                data.append("valorDatoEdit", valorDato);
                data.append("estadoObservacionDatoEdit", estadoObservacionDato);
                data.append("idSerieDatosEdit", idSerieDatos);
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
            var idSerieDatos = $("#id-serie-delete").val();
            var idDato = $("#id-dato-delete").val();
            var fechaDato = $("#fecha-dato-delete").val();
            var valorDato = $("#valor-dato-delete").val();
            var estadoObservacionDato = $("#estado-dato-delete").val();
            if (fechaDato === "" || valorDato === "" || estadoObservacionDato === "" || idSerieDatos === "" || estadoObservacionDato === "Selecciona") {
                $("#modal-delete").modal('hide');
                $("#modal-form-error").modal('show');
            } else {
                var data = new FormData();
                var url = "view/modules/admin/datos/funcionesDatos.php";
                data.append("idDatoDelete", idDato);
                data.append("fechaDatoDelete", fechaDato);
                data.append("idSerieDatosDelete", idSerieDatos);
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
    </script>
</body>
</html>
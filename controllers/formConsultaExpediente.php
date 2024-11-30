<!--Formulario para modificar la consulta de los indicadores del Expediente Municipal-->
<div class="row" id="form-consulta-indicador">
    <div class="col-xs-12 col-sm-12">
        <h6 style="color:#215a9a;"><b>Modificar la consulta:</b></h6>
        <hr style="border-color: #ddd; margin-top: 0px; margin-bottom: 10px;">
    </div>
    <form class="form-inline" style="text-align: left;">
        <div class="form-group col-xs-12 col-sm-2">
            <label class="control-label" style="margin-bottom: 10px; color:#215a9a;">
                Tipo de zona<br>geográfica
            </label>
            <select class="form-control" id="tipoZonaGeograficaConsultar" 
                    name="tipoZonaGeograficaConsultar" multiple="multiple">
            </select>
        </div>
        <div class="form-group col-xs-12 col-sm-3">
            <label class="control-label" style="margin-bottom: 10px; color:#215a9a;">
                Zona<br>geográfica
            </label>
            <select class="form-control" id="zonaGeograficaConsultar" 
                    name="zonaGeograficaConsultar" multiple="multiple">
            </select>
        </div>
        <div class="form-group col-xs-12 col-sm-3">
            <label class="control-label" style="margin-bottom: 10px; color:#215a9a;">
                Desagregaciones<br>temáticas
            </label>
            <select class="form-control" id="desagregacionTematicaConsultar" 
                    name="desagregacionTematicaConsultar" multiple="multiple">
            </select>
        </div>
        <div class="form-group col-xs-12 col-sm-2">
            <div id="fechasConsultar">
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-2" style="text-align: center;">
            <button type="button" class="btn btn-primary" id="btnConsultar" disabled onclick=redirect() style="margin-top: 40px;">
                Consultar
            </button>
        </div>
    </form>
</div>
<script>
    $("#tipoZonaGeograficaConsultar").multiselect({
        nonSelectedText: "Seleccione el tipo de zona geográfica",
        buttonWidth: "100%",
        disableIfEmpty: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Buscar tipo de zona geográfica',
        onChange: function (option, checked) {
            var tipoZonaGeografica = $("#tipoZonaGeograficaConsultar").val();
            var selectedOptions = $("#tipoZonaGeograficaConsultar option:selected");
            consultarZonasGeograficas(tipoZonaGeografica);
            if (selectedOptions.length >= 1) {
                var nonSelectedOptions = $('#tipoZonaGeograficaConsultar option').filter(function () {
                    return !$(this).is(':selected');
                });
                nonSelectedOptions.each(function () {
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', true);
                    input.parent('li').addClass('disabled');
                });
            } else {
                $('#tipoZonaGeograficaConsultar option').each(function () {
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', false);
                    input.parent('li').addClass('disabled');
                });
            }
        }
    });
    function consultarZonasGeograficas(tipoZonaGeografica) {
        var data = new FormData();
        var url = "/views/modules/consulta-indicadores/exp/consultas.php";
        data.append("idIndicador2", idIndicador);
        data.append("geografia2", tipoZonaGeografica);
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
                $('#zonaGeograficaConsultar').multiselect('dataprovider', result);
            }
        });
    }
    $("#zonaGeograficaConsultar").multiselect({
        nonSelectedText: "Seleccione la zona geográfica",
        buttonWidth: "100%",
        disableIfEmpty: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Buscar zona geográfica',
        onChange: function (element, checked) {
            var tipoZonaGeografica = $("#tipoZonaGeograficaConsultar").val();
            var zona = $("#zonaGeograficaConsultar").val();
            var selectedOptions = $("#zonaGeograficaConsultar option:selected");
            consultarDesagregacionesTematicas(tipoZonaGeografica, zona);
            if (selectedOptions.length >= 1) {
                var nonSelectedOptions = $('#zonaGeograficaConsultar option').filter(function () {
                    return !$(this).is(':selected');
                });
                nonSelectedOptions.each(function () {
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', true);
                    input.parent('li').addClass('disabled');
                });
            } else {
                $('#zonaGeograficaConsultar option').each(function () {
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', false);
                    input.parent('li').addClass('disabled');
                });
            }
        }
    });

    function consultarDesagregacionesTematicas(tipoZonaGeografica, zonaGeografica) {
        var data = new FormData();
        var url = "/views/modules/consulta-indicadores/exp/consultas.php";
        data.append("idIndicador3", idIndicador);
        data.append("geografia3", tipoZonaGeografica);
        data.append("zona3", zonaGeografica);
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
                $('#desagregacionTematicaConsultar').multiselect('dataprovider', result);
            }
        });
    }

    $("#desagregacionTematicaConsultar").multiselect({
        nonSelectedText: "Seleccione las desagregaciones",
        allSelectedText: "Todas seleccionadas",
        nSelectedText: ' desagregaciones seleccionadas',
        buttonWidth: "100%",
        disableIfEmpty: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Buscar desagregación',
        includeSelectAllOption: true,
        selectAllText: "Seleccionar todas",
        onChange: function (element, checked) {
            var tipoZonaGeografica = $("#tipoZonaGeograficaConsultar").val();
            var zonaGeografica = $("#zonaGeograficaConsultar").val();
            var selectedOptions = $('#desagregacionTematicaConsultar option:selected');
            if (selectedOptions.length >= 1) {
                var desagregacionesTematicas = [];
                $(selectedOptions).each(function (index, brand) {
                    desagregacionesTematicas.push([$(this).val()]);
                });
                consultarFechas(idIndicador, tipoZonaGeografica, zonaGeografica, desagregacionesTematicas);
            } else {
//                var button = $('#btnConsultar');
//                $(button).prop("disabled", true);
                $("#fechasConsultar").hide();
            }
        },
        onSelectAll: function (element, checked) {
            var tipoZonaGeografica = $("#tipoZonaGeograficaConsultar").val();
            var zonaGeografica = $("#zonaGeograficaConsultar").val();
            var brands2 = $('#desagregacionTematicaConsultar option:selected');
            var desagregacionesTematicas = [];
            $(brands2).each(function (index, brand) {
                desagregacionesTematicas.push([$(this).val()]);
            });
            consultarFechas(idIndicador, tipoZonaGeografica, zonaGeografica, desagregacionesTematicas);
        }
    });
    function consultarFechas(idIndicador, tipoZonaGeografica, zonaGeografica, desagregacionesTematicas) {
        if (desagregacionesTematicas.length >= 1) {
            var data = new FormData();
            var url = "/views/modules/consulta-indicadores/exp/consultas.php";
            data.append("idIndicador4", idIndicador);
            data.append("geografia4", tipoZonaGeografica);
            data.append("zona4", zonaGeografica);
            data.append("desagregaciones4", desagregacionesTematicas);
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                cache: false,
                async: true,
                contentType: false,
                processData: false,
                success: function (resp) {
                    $("#fechasConsultar").html(resp);
                    $("#fechasConsultar").show();
//                    var button = $("#btnConsultar");
//                    $(button).prop("disabled", false);
                }
            });
        } else {
            var button = $('#btnConsultar');
            $(button).prop("disabled", true);
            $("#fechasConsultar").hide();
        }
    }
    $("#fechasConsultar").change(function () {
        var button = $('#btnConsultar');
        $(button).prop('disabled', false);
    });
    function redirect() {
        var tipoZonaGeografica = $("#tipoZonaGeograficaConsultar").val();
        var zonaGeografica = $("#zonaGeograficaConsultar").val();
        var brands2 = $('#desagregacionTematicaConsultar option:selected');
        var desagregacionesTematicas = [];
        $(brands2).each(function (index, brand) {
            desagregacionesTematicas.push([$(this).val()]);
        });
        var min = $("#from").val();
        var max = $("#to").val();
        var str = $("#range_hidden").val();
        var link = $("#link").val();
        var res = str.split(",");
        var rango = new Array();
        for (var i = 0; i < res.length; i++) {
            if (res[i] >= min && res[i] <= max) {
                rango.push(res[i]);
            }
        }
        console.log(link);
        link = link + '/' + tipoZonaGeografica + '/' + encodeURIComponent(desagregacionesTematicas.toString())+ '/' + rango.toString() + '/' + zonaGeografica;
        console.log(link);
        window.location.href = link;
    }
</script>
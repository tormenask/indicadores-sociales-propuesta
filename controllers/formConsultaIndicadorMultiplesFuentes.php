<!--Formulario para modificar la consulta de los indicadores cuando tienen múltiples fuentes-->
<div class="row" id="form-consulta-indicador">
    <div class="col-xs-12 col-sm-12">
        <h6 style="color:#215a9a;"><b>Modificar la consulta:</b></h6>
        <hr style="border-color: #ddd; margin-top: 0px; margin-bottom: 10px;">
    </div>
    <form class="form-inline" style="text-align: left;">
        <div class="row">
            <div class="form-group col-xs-12 col-sm-6">
                <label class="control-label" style="margin-bottom: 10px; color:#215a9a;">Fuente de datos</label>
                <select class="form-control" id="fuenteDatosConsultar" 
                        name="fuenteDatosConsultar" multiple="multiple">
                </select>
            </div>
            <div class="form-group col-xs-12 col-sm-6">
                <?php
                if ($tipoConsulta == "Comunas") {
                    echo '<label class="control-label" style="margin-bottom: 10px; color:#215a9a;">Comunas</label>';
                } else {
                    echo '<label class="control-label" style="margin-bottom: 10px; color:#215a9a;">Desagregaciones geográficas</label>';
                }
                ?>
                <select class="form-control" id="desagregacionGeograficaConsultar" 
                        name="desagregacionGeograficaConsultar" multiple="multiple">
                </select>
            </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="form-group col-xs-12 col-sm-6">
                <label class="control-label" style="margin-bottom: 10px; color:#215a9a;">Desagregaciones<br>temáticas</label>
                <select class="form-control" id="desagregacionTematicaConsultar" 
                        name="desagregacionTematicaConsultar" multiple="multiple">
                </select>
            </div>
            <div class="form-group col-xs-12 col-sm-3">
                <div id="fechasConsultar">
                </div>
            </div>
            <div class="form-group col-xs-12 col-sm-3" style="text-align: center;">
                <button type="button" class="btn btn-primary" id="btnConsultar" style="margin-top: 30px;" 
                        disabled onclick=redirect()>
                    Consultar
                </button>
            </div>
        </div>
    </form>
</div>
<script>
    $("#fuenteDatosConsultar").multiselect({
        nonSelectedText: "Seleccione la fuente de datos",
        buttonWidth: "100%",
        disableIfEmpty: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Buscar fuente de datos',
        onChange: function (option, checked) {
            var fuenteDatos = $("#fuenteDatosConsultar").val();
            var selectedOptions = $("#fuenteDatosConsultar option:selected");
            if (selectedOptions.length >= 1) {
                var nonSelectedOptions = $('#fuenteDatosConsultar option').filter(function () {
                    return !$(this).is(':selected');
                });
                nonSelectedOptions.each(function () {
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', true);
                    input.parent('li').addClass('disabled');
                });
                var selected = selectedOptions.val();
                consultarDesagregacionesGeograficasFuente(idIndicador, fuenteDatos);
            } else {
                $('#fuenteDatosConsultar option').each(function () {
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', false);
                    input.parent('li').addClass('disabled');
                });
                $("#desagregacionGeograficaConsultar option:selected").prop("selected", false);
                $("#desagregacionGeograficaConsultar").multiselect('disable');
                $("#desagregacionGeograficaConsultar").multiselect('refresh');
            }
            $("#desagregacionTematicaConsultar option:selected").prop("selected", false);
            $('#desagregacionTematicaConsultar').multiselect('disable');
            $("#desagregacionTematicaConsultar").multiselect('refresh');
            $('#fechasConsultar').hide();
        }
    });
    $("#desagregacionGeograficaConsultar").multiselect({
        nonSelectedText: "Seleccione las desagregaciones geográficas",
        allSelectedText: 'Todas las desagregaciones seleccionadas',
        nSelectedText: ' desagregaciones seleccionadas',
        buttonWidth: "100%",
        disableIfEmpty: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Buscar desagregación',
        onChange: function (element, checked) {
            var fuenteDatos = $("#fuenteDatosConsultar").val();
            var brands = $('#desagregacionGeograficaConsultar option:selected');
            var desagregacionesGeograficas = [];
            $(brands).each(function (index, brand) {
                desagregacionesGeograficas.push([$(this).val()]);
            });
            $('#fechasConsultar').hide();
            consultarDesagregacionesTematicasFuente(idIndicador, desagregacionesGeograficas, fuenteDatos);
        }
    });
    $('#desagregacionTematicaConsultar').multiselect({
        nonSelectedText: 'Seleccione las desagregaciones temáticas',
        allSelectedText: 'Todas las desagregaciones seleccionadas',
        nSelectedText: ' desagregaciones seleccionadas',
        buttonWidth: '100%',
        disableIfEmpty: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Buscar desagregación',
        onChange: function (element, checked) {

            var fuenteDatos = $("#fuenteDatosConsultar").val();
            var brands1 = $('#desagregacionGeograficaConsultar option:selected');
            var desagregacionesGeograficas = [];
            $(brands1).each(function (index1, brand1) {
                desagregacionesGeograficas.push([$(this).val()]);
            });
            var brands2 = $('#desagregacionTematicaConsultar option:selected');
            var desagregacionesTematicas = [];
            $(brands2).each(function (index2, brand2) {
                desagregacionesTematicas.push([$(this).val()]);
            });
            if (desagregacionesTematicas.length > 0) {
                consultarFechas(idIndicador, fuenteDatos, desagregacionesGeograficas, desagregacionesTematicas);
                $('#fechasConsultar').show();
            } else {
                $('#fechasConsultar').hide();
            }
        }
    });
</script>
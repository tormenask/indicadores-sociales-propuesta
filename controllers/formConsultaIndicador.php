<!--Formulario para modificar la consulta de los indicadores 
para la medición del Desarrollo Social, IGC y ODRAF-->
<div class="row" id="form-consulta-indicador">
    <div class="col-xs-12 col-sm-12">
        <h6 style="color:#215a9a;"><b>Modificar la consulta:</b></h6>
        <hr style="border-color: #ddd; margin-top: 0px; margin-bottom: 10px;">
    </div>
    <form class="form-inline" style="text-align: left;">
        <div class="form-group col-xs-12 col-sm-3">
            <?php
            if ($tipoConsulta == "Comunas") {
                echo '<label class="control-label" style="margin-bottom: 10px; color:#215a9a;">Comunas</label>';
            } else {
                echo '<label class="control-label" style="margin-bottom: 10px; color:#215a9a;">Desagregaciones<br>geográficas</label>';
            }
            ?>
            <select class="form-control" id="desagregacionGeograficaConsultar" 
                    name="desagregacionGeograficaConsultar" multiple="multiple">
            </select>
        </div>
        <div class="form-group col-xs-12 col-sm-3">
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
    </form>
</div>
<script>
    $("#desagregacionGeograficaConsultar").multiselect({
        nonSelectedText: "Seleccione las desagregaciones geográficas",
        allSelectedText: 'Todas las desagregaciones seleccionadas',
        nSelectedText: ' desagregaciones seleccionadas',
        buttonWidth: "100%",
        disableIfEmpty: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Buscar desagregación',
        onChange: function (element, checked) {
            var brands = $('#desagregacionGeograficaConsultar option:selected');
            var desagregacionesGeograficas = [];
            $(brands).each(function (index, brand) {
                desagregacionesGeograficas.push([$(this).val()]);
            });
            $('#fechasConsultar').hide();
            consultarDesagregacionesTematicas(idIndicador, desagregacionesGeograficas);
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
                consultarFechas(idIndicador, fuente, desagregacionesGeograficas, desagregacionesTematicas);
                $('#fechasConsultar').show();
            } else {
                $('#fechasConsultar').hide();
            }
        }
    });
</script>
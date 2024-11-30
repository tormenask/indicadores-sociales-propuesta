<!--Formulario para modificar la consulta de los indicadores de la 
Política de Primera Infancia, Infancia y Adolescencia-->
<div class="row" id="form-consulta-indicador">
    <div class="col-xs-12 col-sm-12">
        <h6 style="color:#215a9a;"><b>Modificar la consulta:</b></h6>
        <hr style="border-color: #ddd; margin-top: 0px; margin-bottom: 10px;">
    </div>
    <form class="form-inline" style="text-align: left;">
        <div class="form-group col-xs-12 col-sm-4">
            <label class="control-label" style="margin-bottom: 10px; color:#215a9a;">Desagregaciones temáticas</label>
            <select class="form-control" id="desagregacionTematicaConsultar" 
                    name="desagregacionTematicaConsultar" multiple="multiple">
            </select>
        </div>
        <div class="form-group col-xs-12 col-sm-4">
            <div id="fechasConsultar">
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-4" style="text-align: center;">
            <button type="button" class="btn btn-primary" id="btnConsultar" style="margin-top: 30px;" 
                    disabled onclick=redirect()>
                Consultar
            </button>
        </div>
    </form>
</div>
<script>
    $('#desagregacionTematicaConsultar').multiselect({
        nonSelectedText: 'Seleccione las desagregaciones temáticas',
        allSelectedText: 'Todas las desagregaciones seleccionadas',
        nSelectedText: ' desagregaciones seleccionadas',
        buttonWidth: '100%',
        disableIfEmpty: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Buscar desagregación',
        onChange: function (element, checked) {
            var desagregacionesGeograficas = ["Cali"];
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
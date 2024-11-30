<!--Formulario para modificar la consulta de los indicadores de desempeño institucional-->
<div class="row" id="form-consulta-indicador">
    <div class="col-xs-12 col-sm-12">
        <h6 style="color:#215a9a;"><b>Modificar la consulta:</b></h6>
        <hr style="border-color: #ddd; margin-top: 0px; margin-bottom: 10px;">
    </div>
    <form class="form-inline" style="text-align: left;">
        <div class="form-group col-xs-12 col-sm-3">
            <label class="control-label" style="margin-bottom: 10px; color:#215a9a;">Indicadores<br> del Proceso</label>
            <select class="form-control" id="desagregacionIndicador" 
                    name="desagregacionIndicador" multiple="multiple">
            </select>
        </div>
        <div class="form-group col-xs-12 col-sm-3">
            <label class="control-label" style="margin-bottom: 10px; color:#215a9a;">Periodicidad<br> del Indicador</label>
            <select class="form-control" id="desagregacionPeriodicidad" 
                    name="desagregacionPeriodicidad" multiple="multiple">
                <!--name="desagregacionTematicaConsultar" multiple="multiple">-->
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
    $("#desagregacionIndicador").multiselect({
        nonSelectedText: "Seleccione el indicador del proceso",
        allSelectedText: 'Todas las desagregaciones seleccionadas',
        nSelectedText: 'Indicador seleccionado',
        buttonWidth: "100%",
        disableIfEmpty: false,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Buscar indicador',
        onChange: function (element, checked) {
            var brands = $('#desagregacionIndicador option:selected');
            var desagregacionesIndicador = [];
            $(brands).each(function (index, brand) {
                desagregacionesIndicador.push([$(this).val()]);
            });            
            consultarPeriodicidad(idTematica,desagregacionesIndicador);            
        }
    });
    $('#desagregacionPeriodicidad').multiselect({
        nonSelectedText: 'Seleccione la periodicidad',
        allSelectedText: 'Todas las desagregaciones seleccionadas',
        nSelectedText: ' Periodicidad seleccionada',
        buttonWidth: '100%',
        disableIfEmpty: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Buscar periodicidad',
        onChange: function (element, checked) {
            var brands1 = $('#desagregacionIndicador option:selected');
            var desagregacionesIndicador = [];
            $(brands1).each(function (index1, brand1) {
                desagregacionesIndicador.push([$(this).val()]);
            });
            var brands2 = $('#desagregacionPeriodicidad option:selected');
            var desagregacionesPeriodicidad = [];
            $(brands2).each(function (index2, brand2) {
                desagregacionesPeriodicidad.push([$(this).val()]);
            });

        }
    });
</script>


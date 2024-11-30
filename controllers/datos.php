<?php

/**
 * <b>DatosController</b>
 * Se encuentran las consultas necesarias para visualizar toda la información
 * asociada a los datos de las series de datos de los indicadores
 */
class DatosController {

    /**
     * <b>consultarFechasPorDesagregacionesIndicadorYFuenteComunasCorregimientosController</b>
     * <br>
     * Permite consultar las fechas disponibles para los datos de un indicador, 
     * para la consulta por comunas y corregimientos
     * @param string $idIndicador ID del indicador
     * @param string $fuente Fuente de datos del indicador
     * @param string $desagregacion Desagregación temática del indicador
     * @param string $comunasCorregimientos Desagregaciones geográficas del indicador
     */
    public function consultarFechasPorDesagregacionesIndicadorYFuenteComunasCorregimientosController($idIndicador, $fuente, $desagregacion, $comunasCorregimientos) {
        $comunasCorr = explode(",", $comunasCorregimientos);
        $idSeries = array();
        for ($index = 0; $index < count($comunasCorr); $index++) {
            $zonaGeografica = $comunasCorr[$index];
            $ser = new SeriesDatos();
            $resp1 = $ser->consultarIdSeriePorIndicadorFuenteYDesagregacionComunasCorregimientos($idIndicador, $fuente, $desagregacion, $zonaGeografica);
            foreach ($resp1 as $row => $item) {
                $idSeries[] = $item["idSerieDatos"];
            }
        }
        $options = array();

        for ($i = 0; $i < count($idSeries); $i++) {
            $idSerie = $idSeries[$i];
            $dat = new Datos();
            $resp = $dat->consultarFechasPorIdSerie($idSerie);
            foreach ($resp as $row => $item) {
                $option = $item['fechaDato'];
                if (!in_array($option, $options)) {
                    $options[] = (string) $option;
                }
            }
        }

        echo'
        <div class="row" style="margin-top:20px;">
            <div class="col-sm-12">
                <label class="control-label" style="margin-bottom: 10px; color:#215a9a;">Periodo</label>
                <div id="slider"></div>
            </div>
        </div>
        <div class="row" style="margin-top:20px;">
            <div class="col-sm-12" style="text-align:center;">
                <div class="col-sm-6" style="text-align:justify;">
                    <label class="control-label" style="margin-bottom: 10px;">Inicio: </label>
                </div>
                <div class="col-sm-6">
                    <input type="text" name="from" id="from" readonly value="' . min($options) . '" 
                        style="border:0; font-weight:bold; text-align:left;">
                </div>
            </div>
             <div class="col-sm-12" style="text-align:center; margin-top: -10px;">
                <div class="col-sm-6" style="text-align:justify;">
                    <label class="control-label" style="margin-bottom: 10px;">Fin: </label>
                </div>
                <div class="col-sm-6">
                    <input type="text" name="to" id="to" readonly value="' . max($options) . '" 
                        style="border:0; font-weight:bold; text-align:left;">
                </div>
            </div>
        </div>
        <input type="text" id="range_hidden" hidden readonly value="' . (implode(",", $options)) . '" 
                        style="border:0; font-weight:bold; text-align:left;">
        <script>
            myData = [' . implode(",", $options) . '];
            slider_config = {
                range: true,
                min: 0,
                max: myData.length - 1,
                step: 1,
                slide: function( event, ui ) {
                    $("#from").val(myData[ui.values[0]]);
                    $("#to").val(myData[ui.values[1]]);
                },
                create: function() {
                    $(this).slider("values",0,0);
                    $(this).slider("values",1,myData.length - 1);
                }
            };
            $("#slider").slider(slider_config);
        </script>';
    }

    /**
     * <b>consultarFechasPorDesagregacionesIndicadorYFuenteComparativosController</b>
     * <br>
     * Permite consultar las fechas disponibles para los datos de un indicador, 
     * para la consulta para comparativos regionales
     * @param string $idIndicador ID del indicador
     * @param string $fuente Fuente de datos del indicador
     * @param string $desagregacion Desagregación temática del indicador
     * @param string $zonas Desagregaciones geográficas del indicador
     */
    public function consultarFechasPorDesagregacionesIndicadorYFuenteComparativosController($idIndicador, $fuente, $desagregacion, $zonas) {
        $zonasCR = explode(",", $zonas);
        $idSeries = array();
        for ($index = 0; $index < count($zonasCR); $index++) {
            $zonaGeografica = $zonasCR[$index];
            $ser = new SeriesDatos();
            $resp1 = $ser->consultarIdSeriePorIndicadorFuenteYDesagregacionComparativos($idIndicador, $fuente, $desagregacion, $zonaGeografica);
            foreach ($resp1 as $row => $item) {
                $idSeries[] = $item["idSerieDatos"];
            }
        }
        $options = array();

        for ($i = 0; $i < count($idSeries); $i++) {
            $idSerie = $idSeries[$i];
            $dat = new Datos();
            $resp = $dat->consultarFechasPorIdSerie($idSerie);
            foreach ($resp as $row => $item) {
                $option = $item['fechaDato'];
                if (!in_array($option, $options)) {
                    $options[] = (string) $option;
                }
            }
        }

        echo'
        <div class="row" style="margin-top:20px;">
            <div class="col-sm-12">
                <label class="control-label" style="margin-bottom: 10px; color:#215a9a;">Periodo</label>
                <div id="slider"></div>
            </div>
        </div>
        <div class="row" style="margin-top:20px;">
            <div class="col-sm-12" style="text-align:center;">
                <div class="col-sm-6" style="text-align:justify;">
                    <label class="control-label" style="margin-bottom: 10px;">Inicio: </label>
                </div>
                <div class="col-sm-6">
                    <input type="text" name="from" id="from" readonly value="' . min($options) . '" 
                        style="border:0; font-weight:bold; text-align:left;">
                </div>
            </div>
             <div class="col-sm-12" style="text-align:center; margin-top: -10px;">
                <div class="col-sm-6" style="text-align:justify;">
                    <label class="control-label" style="margin-bottom: 10px;">Fin: </label>
                </div>
                <div class="col-sm-6">
                    <input type="text" name="to" id="to" readonly value="' . max($options) . '" 
                        style="border:0; font-weight:bold; text-align:left;">
                </div>
            </div>
        </div>
        <input type="text" id="range_hidden" hidden readonly value="' . (implode(",", $options)) . '" 
                        style="border:0; font-weight:bold; text-align:left;">
        <script>
            myData = [' . implode(",", $options) . '];
            slider_config = {
                range: true,
                min: 0,
                max: myData.length - 1,
                step: 1,
                slide: function( event, ui ) {
                    $("#from").val(myData[ui.values[0]]);
                    $("#to").val(myData[ui.values[1]]);
                },
                create: function() {
                    $(this).slider("values",0,0);
                    $(this).slider("values",1,myData.length - 1);
                }
            };
            $("#slider").slider(slider_config);
        </script>';
    }

    /**
     * <b>consultarFechasPorDesagregacionesIndicadorYFuenteController</b>
     * <br>
     * Permite consultar las fechas disponibles para los datos de un indicador
     * @param string $idIndicador ID del indicador
     * @param string $fuente Fuente de datos del indicador
     * @param string $desagregacionesGeograficas Desagregaciones geográficas del indicador
     * @param string $desagregacionesTematicas Desagregaciones temáticas del indicador
     */
    public function consultarFechasPorDesagregacionesIndicadorYFuenteController($idIndicador, $fuente, $desagregacionesGeograficas, $desagregacionesTematicas) {
        $desagregacionesGeograficasC = explode(",", $desagregacionesGeograficas);
        $desagregacionesTematicasC = explode(",", $desagregacionesTematicas);
        $idSeries = array();
        $ser = new SeriesDatos();

        for ($i = 0; $i < count($desagregacionesGeograficasC); $i++) {
            $desagregacionGeografica = $desagregacionesGeograficasC[$i];
            for ($j = 0; $j < count($desagregacionesTematicasC); $j++) {
                $desagregacionTematica = $desagregacionesTematicasC[$j];
                $resp1 = $ser->consultarIdSeriePorIndicadorFuenteYDesagregaciones($idIndicador, $fuente, $desagregacionTematica, $desagregacionGeografica);
                $idSeries[] = $resp1['idSerieDatos'];
            }
        }


        $options = array();

        for ($k = 0; $k < count($idSeries); $k++) {
            $idSerie = $idSeries[$k];
            $dat = new Datos();
            $temp = array();
            $resp = $dat->consultarFechasPorIdSerie($idSerie);
            foreach ($resp as $row => $item) {
                $option = $item['fechaDato'];
                $temp[] = $option;
            }
            if ($k == 0) {
                $options = $temp;
            }
            $options = array_intersect($options, $temp);
        }

        sort($options);

        echo'
            <div class="row">
                <div class="col-xs-12">
                    <label class="control-label" style="margin-bottom: 10px; color:#215a9a;">Periodo</label>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div id="slider"></div>
                </div>
            </div>
            <div class="row" style="margin-top:15px;">
                <div class="col-xs-12">
                    <label class="control-label">Inicio: </label>
                    <input type="text" name="from" id="from" readonly value="' . min($options) . '"
                        style="border:0; font-weight:bold; text-align:left;">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <label class="control-label">Fin: </label>
                    <input type="text" name="to" id="to" readonly value="' . max($options) . '" 
                        style="border:0; font-weight:bold; text-align:left;">
                    <input type="text" id="range_hidden" hidden readonly value="' . (implode(",", $options)) . '" 
                        style="border:0; font-weight:bold; text-align:left;">
                </div>
            </div>
        <script>
            myData = [' . implode(",", $options) . '];
            slider_config = {
                range: true,
                min: 0,
                max: myData.length - 1,
                step: 1,
                slide: function( event, ui ) {
                    $("#from").val(myData[ui.values[0]]);
                    $("#to").val(myData[ui.values[1]]);
                },
                create: function() {
                    $(this).slider("values",0,0);
                    $(this).slider("values",1,myData.length - 1);
                }
            };
            $("#slider").slider(slider_config);
        </script>';
    }

    /**
     * <b>consultarFechasPorDesagregacionesIndicadorYDesagregacionGeograficaExpedienteController</b>
     * <br>
     * Permite consultar las fechas disponibles para los datos de un indicador
     * del Expediente Municipal
     * @param string $idIndicador ID del indicador
     * @param string $tipoZonaGeografica Tipo de zona geográfica del indicador
     * @param string $zonaGeografica Desagregación geográfica del indicador
     * @param string $desagregacionesTem Desagregaciones temáticas del indicador
     */
    public function consultarFechasPorDesagregacionesIndicadorYDesagregacionGeograficaExpedienteController($idIndicador, $tipoZonaGeografica, $zonaGeografica, $desagregacionesTem) {
        $desagregacionesTematicas = explode(",", $desagregacionesTem);
        $idSeries = array();
        $ser = new SeriesDatos();

        for ($j = 0; $j < count($desagregacionesTematicas); $j++) {
            $desTem = $desagregacionesTematicas[$j];
            $resp1 = $ser->consultarIdSeriePorIndicadorGeografiaZonaActualDesagregacionTematicaExpediente($idIndicador, $tipoZonaGeografica, $zonaGeografica, $desTem);
            foreach ($resp1 as $row => $item) {
                $idSeries[] = $item["idSerieDatos"];
            }
        }

        $options = array();

        for ($i = 0; $i < count($idSeries); $i++) {
            $idSerie = $idSeries[$i];
            $dat = new Datos();
            $temp = array();
            $resp = $dat->consultarFechasPorIdSerie($idSerie);
            foreach ($resp as $row => $item) {
                $option = $item['fechaDato'];
                $temp[] = $option;
            }
            if ($i == 0) {
                $options = $temp;
            }
            $options = array_intersect($options, $temp);
        }

        sort($options);

        if (!empty($options)) {
            echo'
        <div class="row" style="margin-top:20px;">
            <div class="col-sm-12">
                <label class="control-label" style="margin-bottom: 10px; color:#215a9a;">Periodo</label>
                <div id="slider"></div>
            </div>
        </div>
        <div class="row" style="margin-top:20px;">
            <div class="col-sm-12" style="text-align:center;">
                <div class="col-sm-6" style="text-align:justify;">
                    <label class="control-label" style="margin-bottom: 10px;">Inicio: </label>
                </div>
                <div class="col-sm-6">
                    <input type="text" name="from" id="from" readonly value="' . min($options) . '" 
                        style="border:0; font-weight:bold; text-align:left;">
                </div>
            </div>
             <div class="col-sm-12" style="text-align:center; margin-top: -10px;">
                <div class="col-sm-6" style="text-align:justify;">
                    <label class="control-label" style="margin-bottom: 10px;">Fin: </label>
                </div>
                <div class="col-sm-6">
                    <input type="text" name="to" id="to" readonly value="' . max($options) . '" 
                        style="border:0; font-weight:bold; text-align:left;">
                </div>
            </div>
        </div>
        <input type="text" id="range_hidden" hidden readonly value="' . (implode(",", $options)) . '" 
                        style="border:0; font-weight:bold; text-align:left;">
        <script>
            myData = [' . implode(",", $options) . '];
            slider_config = {
                range: true,
                min: 0,
                max: myData.length - 1,
                step: 1,
                slide: function( event, ui ) {
                    $("#from").val(myData[ui.values[0]]);
                    $("#to").val(myData[ui.values[1]]);
                },
                create: function() {
                    $(this).slider("values",0,0);
                    $(this).slider("values",1,myData.length - 1);
                }
            };
            $("#slider").slider(slider_config);
             var button = $("#btnConsultar");
                $(button).prop("disabled", false);
        </script>';
        } else {
            echo'
        <div class="row" style="margin-top:20px;">
            <div class="col-sm-12">
                <label class="control-label" style="margin-bottom: 10px; color:#215a9a;">Periodo</label>
                <p>No se encuentran fechas disponibles para la combinaciónn de desagregaciones seleccionadas.</p>
            </div>
        </div>
        <script>
            var button = $("#btnConsultar");
            $(button).prop("disabled", true);
        </script>';
        }
    }

}

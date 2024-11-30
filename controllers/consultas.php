<?php

/**
 * <b>ConsultasController</b>
 * Se encuentran las consultas necesarias para formar las visualizaciones de
 * los indicadores: gráfico, tabla, ficha técnica, menú lateral con listado de 
 * indicadores.
 */
class ConsultasController
{

    /**
     * <b>consultarListadoIndicadoresPorConjunto</b>
     * <br>
     * Permite consultar el listado de indicadores para un conjunto de indicadores
     * @param string $idConjuntoIndicadores ID del conjunto de indicadores
     * @param string $tipoConsulta Categoría de la consulta a realizar.
     */
    public function consultarListadoIndicadoresPorConjunto($idConjuntoIndicadores, $tipoConsulta)
    {
        $dimension = new Dimensiones();
        $dimensiones = array();
        if ($idConjuntoIndicadores == 'SIS' && $tipoConsulta == "Comunas") {
            $dimensiones = $dimension->consultarDimensionesParaComunasCorregimientosPorConjuntoIndicadores($idConjuntoIndicadores);
        } else {
            $dimensiones = $dimension->consultarDimensionesPorConjuntoIndicadores($idConjuntoIndicadores);
        }
        if ($tipoConsulta == '') {
            $tipoConsulta = $idConjuntoIndicadores;
        }
        if ($tipoConsulta == 'ODS') {
            foreach ($dimensiones as $dim) {
                $nombreDimension = trim($dim['nombreDimension']);
                $idDimension = $dim['idDimension'];
                if ($idDimension !== 'ODS_14' && $idDimension !== 'ODS_15') {
                    $icono = $dim['icono'];
                    $color = $dim['color'];
                    echo 
                    "<div class='panel panel-default' style='margin:5rem;''>
                        <div class='panel-heading' style='font-size:2rem; background-color='{$color};'>{$nombreDimension}</div>
                        <div class='panel-body'>
                            <div class='row'>";
                                // Llama a la función y concatena el resultado
                                echo $this->consultarListadoIndicadoresActivosPorDimensionController($idDimension, $color, $tipoConsulta);
                            // Cierra el panel
                            echo "</div>
                        </div>
                    </div>";
                }
            }
        } else {
            foreach ($dimensiones as $dim) {
                $nombreDimension = trim($dim['nombreDimension']);
                $idDimension = $dim['idDimension'];
                $icono = $dim['icono'];
                $color = $dim['color'];
                // Inicia el panel
                echo "<div class='panel panel-default' style='margin:5rem'>
                    <div class='panel-heading' style='font-size:2rem;'>{$nombreDimension}</div>
                    <div class='panel-body'>
                        <div class='row'>";
                // Llama a la función y concatena el resultado
                echo $this->consultarListadoIndicadoresActivosPorDimensionController($idDimension, $color, $tipoConsulta);
                // Cierra el panel
                echo "</div>
                    </div>
                </div>";
            }

        }
    }

    /**
     * <b>consultarListadoIndicadoresDadii</b>
     * <br>
     * Permite consultar el listado de indicadores para el conjunto de 
     * indicadores de desempeño institucional
     * @param string $idConjuntoIndicadores ID del conjunto de indicadores
     * @param string $tipoConsulta Categoría de la consulta a realizar.
     */
    public function consultarListadoIndicadoresDadii($idConjuntoIndicadores, $tipoConsulta)
    {
        $dimension = new Dimensiones();
        $dimensiones = $dimension->consultarDimensionesPorConjuntoIndicadores($idConjuntoIndicadores);
        if ($tipoConsulta == '') {
            $tipoConsulta = $idConjuntoIndicadores;
        }
        foreach ($dimensiones as $dim) {
            $nombreDimension = trim($dim['nombreDimension']);
            $idDim = $dim['idDimension'];
            $idDimension = $idDim;
            $icono = $dim['icono'];
            $color = $dim['color'];
            echo '  <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="' . "#$idDimension" . '_" >';
            if ($icono !== NULL && $icono !== "") {
                echo '              <img alt="Dimension - ' . $nombreDimension . '" style="width: 50px; margin-right:8px; border-radius: 100px;" 
                                        src="' . $icono . '">
                                    ' . $nombreDimension;
            } else {
                echo $nombreDimension;
            }
            echo '              </a>
                            </div>
                        </div>';
            echo '      <div id="' . $idDimension . '_" class="panel-collapse collapse">';
            $this->consultarListadoIndicadoresActivosPorDimensionDadiiController($idDimension, $color, $tipoConsulta);
            echo '          
                </div>
                </div>
            ';
        }
        echo '</div>';
    }

    /**
     * <b>consultarListadoIndicadoresActivosPorDimensionDadiiController</b>
     * <br>
     * Permite consultar el listado de indicadores activos para dimensiones 
     * del conjunto de indicadores de desempeño institucional
     * @param string $idDimension ID de la dimensión de los indicadores a consultar
     * @param string $color Color de la dimensión a consultar
     * @param string $tipoConsulta Categoría de la consulta a realizar
     */
    public function consultarListadoIndicadoresActivosPorDimensionDadiiController($idDimension, $color, $tipoConsulta)
    {
        $consultasMod = new ConsultasModel();
        $resp = '';
        $resp = $consultasMod->consultarListadoTematicasPorDimension($idDimension);
        if ($resp == 'error') {
            echo "  <div class='alert alert-danger alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        <li>Error al realizar la consulta</li>
                    </div>";
        } else {
            $tematicas = $resp[0];
            if ($color == NULL || $color == "") {
                $color = "#215a9a";
            }
            foreach ($tematicas as $row => $item) {
                $enlace = $this->crearEnlaceDadii($idDimension, $item, $tipoConsulta);
                echo '      <a href="' . $enlace . '" class="list-group-item indicadores-titulos">' . $item[1] . '</a>';
            }
        }
    }

    /**
     * <b>consultarListadoIndicadoresActivosPorDimensionController</b>
     * <br>
     * Permite consultar el listado de indicadores activos para una dimensión
     * @param string $idDimension ID de la dimensión de los indicadores a consultar
     * @param string $color Color de la dimensión a consultar
     * @param string $tipoConsulta Categoría de la consulta a realizar
     */
    public function consultarListadoIndicadoresActivosPorDimensionController($idDimension, $color, $tipoConsulta)
    {
        $consultasMod = new ConsultasModel();
        $resp = '';
        if ($tipoConsulta == "Comunas") {
            $resp = $consultasMod->consultarListadoIndicadoresActivosPorDimensionComunasCorregimientos($idDimension);
        } elseif ($tipoConsulta == "ODRAF") {
            $resp = $consultasMod->consultarListadoIndicadoresActivosPorDimensionTotal($idDimension);
        } else {
            $resp = $consultasMod->consultarListadoIndicadoresActivosPorDimension($idDimension);
        }

        if ($resp == 'error') {
            echo "  <div class='alert alert-info alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        <li>Error al realizar la consulta</li>
                    </div>";
        } else {
            $tematicas = $resp[0];
            $indicadores = $resp[1];
            if ($color == NULL || $color == "") {
                $color = "#215a9a";
            }
            foreach ($tematicas as $row => $item) {
                for ($i = 0; $i < count($indicadores); $i++) {
                    if ($indicadores[$i][0] == $item[0]) {
                        $enlace = $this->crearEnlace($indicadores[$i][3], $tipoConsulta);
                        echo "
                            <div class='col-lg-4 col-md-6 col-sm-12 col-xs-12' id='containerIndicador-{$indicadores[$i][1]}' style='margin-bottom:1rem'>
                                <div class='panel panel-default' id='{$indicadores[$i][1]}'>
                                    <div class='panel-body'>
                                        <div class='row'>
                                            <div class='col-xs-3'>
                                                <img src='...' alt='Imagen de ejemplo' class='img-responsive'>
                                            </div>
                                            <div class='col-xs-9' >
                                                <h4 class='panel-title tituloIndicador' id='title-{$indicadores[$i][1]}' style='font-weight:bold'>{$indicadores[$i][2]}</h4>
                                                <a href={$enlace} id='btn-{$indicadores[$i][1]}' class='btn btn-md' style='margin-top:2rem; background-color:{$color};'>Ver más</a>
                                            </div>
                                            <div class='col-12' id='tabIndicador-{$indicadores[$i][1]}' style='min-height: 120px; margin-bottom: 15px; margin-top:9rem; display:none;'></div>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                    }
                }
            }
        }
    }

    /**
     * <b>consultaIndicadorController</b>
     * <br>
     * Realiza la consulta de un indicador para su visualización en la página.
     * Si el tipo de gráfico no es diferencial, continuará al método consultaIndicador.
     * @param string $tipoConsulta Categoría de la consulta a realizar
     * @param string $idDimension ID de la dimensión a la que pertenece el indicador a consultar
     * @param string $idTematica ID de la temática a la que pertenece el indicador a consultar
     * @param string $idIndicador ID del indicador a consultar
     * @param string $fuenteC Fuente de datos del indicador a consultar
     * @param string $desagregaciones Desagregaciones temáticas del indicador a consultar
     * @param string $fechas Años del indicador a consultar
     * @param string $zonas Desagregaciones geográficas del indicador a consultar
     */
    public function consultaIndicadorController($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, $desagregaciones, $fechas, $zonas)
    {
        $desagregacionesC = json_decode($desagregaciones);
        $zonasC = json_decode($zonas);
        $fechasC = json_decode($fechas);
        $fich = new FichaTecnica();
        $tipoGrafico = $fich->consultarFichaTecnicaPorIndicador($idIndicador)['tipoGrafico'];
        $tipoGraficoArr = explode(',', $tipoGrafico);
        if (count($tipoGraficoArr) == 1) {
            $this->consultaIndicador($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, $desagregaciones, $fechas, $zonas);
        } else {
            $cons = new ConsultasModel();
            $resp = $cons->consultaIndicador($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, $desagregacionesC, $fechasC, $zonasC);
            if ($resp == 'error') {
                echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <li>Debe seleccionar todos los filtros</li></div>";
            } else {
                $nombreDimension = $resp[0];
                $nombreTematica = $resp[1];
                $nombreIndicador = $resp[2];
                $labels = $resp[3];
                $series = $resp[4];
                $desagregacionesGeograficas = $resp[5];
                $totalDatos = $resp[6];
                $tipoGrafico = $resp[7];
                $data = $resp[8];
                $entidadGeneradora = $resp[9];
                $notas = $resp[10];
                $rango = $resp[11];
                $unidadMedicion = $resp[12];
                $sigla = $resp[13];
                $justificacion = $resp[14];
                $definicion = $resp[15];
                $metodosMedicion = $resp[16];
                $formulas = $resp[17];
                $variables = $resp[18];
                $valoresReferencia = $resp[19];
                $naturaleza = $resp[20];
                $desagregacionTematica = $resp[21];
                $desagregacionGeografica = $resp[22];
                $lineaBase = $resp[23];
                $responsable = $resp[24];
                $observaciones = $resp[25];
                $fechaElaboracion = $resp[26];
                $periodicidad = $resp[27];
                $maxValue = $this->setMaxValue($resp[28]);
                $mapa = $resp[29];
                $fuente = $resp[30];
                echo '
            <div class="row border-consulta">
                <div class="col-xs-12">
                    <h6 style="color:#215a9a;"><b>Resultado de la consulta:</b></h6>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <p style="font-family:Source Sans Pro, sans-serif; font-size:15px;">
                        Dimensión: ' . $nombreDimension . ' <br>
                        Temática: ' . $nombreTematica . ' <br>
                    </p>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <p style="font-family:Source Sans Pro, sans-serif; font-size:15px;">
                        Indicador: ' . $nombreIndicador . ' <br>
                        Desagregaciones geográficas: ' . implode(' - ', $desagregacionesGeograficas) . ' <br>
                    </p>
                </div>
            </div>
            <script>
            	  $("#' . $idDimension . '").addClass("in");            
            	  $("#' . $idTematica . '_cali").addClass("in");            
            	  $("#' . $idIndicador . '").addClass("back-item-menu");            
            </script>';
                if ($tipoConsulta == "PIIA") {
                    include 'formConsultaPiia.php';
                } else {
                    include 'formConsultaIndicador.php';
                }

                echo '<ul class = "nav nav-tabs">';
                if ($mapa !== "" && $mapa !== NULL) {
                    echo '
                    <li class = "active"><a data-toggle = "tab" href = "#mapa">Mapa</a></li>
                    <li><a data-toggle = "tab" href = "#grafico">Gráfico</a></li>';
                } else {
                    echo '
                    <li class = "active"><a data-toggle = "tab" href = "#grafico">Gráfico</a></li>';
                }

                if ($tipoConsulta == "ODRAF" && $fuente == "Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali - Secretaría del Deporte y la Recreación") {
                    echo '
                <li><a data-toggle="tab" href="#tabla">Tabla</a></li>
                <li><a data-toggle="tab" href="#ficha">Ficha técnica del indicador</a></li>
                <li><a data-toggle="tab" href="#fichaEncuesta">Ficha técnica de la Encuesta</a></li>
            </ul>';
                } else {
                    echo '
                <li><a data-toggle="tab" href="#tabla">Tabla</a></li>
                <li><a data-toggle="tab" href="#ficha">Ficha técnica</a></li>
            </ul>';
                }
                echo '
            <div class="tab-content" id="tab-consulta">';
                if ($mapa !== "" && $mapa !== NULL) {
                    echo ' 
                <div id="mapa" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12" style="text-align:center; padding-top: 15px;">
                            ' . $mapa . '
                        </div>
                    </div>
                </div>
                <div id="grafico" class="tab-pane fade in">';
                } else {
                    echo '
                <div id="grafico" class="tab-pane fade in active">';
                }
                echo '  
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <h3 id="nombreIndicador" style="text-align:center">' . $nombreIndicador . '</h3>
                            <h4 style="text-align:center">' . $rango . '</h4>';
                for ($i = 1; $i < count($tipoGraficoArr); $i++) {
                    $diff = strtolower(trim($tipoGraficoArr[$i]));
                    $desagregacionesGeo = array();
                    $desagregacionesTem = array();
                    if ($diff == "sexo") {
                        $nombreGrafico = $nombreIndicador . ', por sexo';
                        for ($m = 0; $m < count($desagregacionesC); $m++) {
                            $desagregacionTem = $desagregacionesC[$m];
                            if ($desagregacionTem == "Hombres" || $desagregacionTem == "Mujeres" || $desagregacionTem == "Total") {
                                $desagregacionesTem[] = $desagregacionTem;
                            }
                            for ($k = 0; $k < count($zonasC); $k++) {
                                $desagregacionGeo = $zonasC[$k];
                                if (!in_array($desagregacionGeo, $desagregacionesGeo)) {
                                    $desagregacionesGeo[] = $desagregacionGeo;
                                }
                            }
                        }
                        if (count($desagregacionesTem) > 0) {
                            echo '  <div class="col-xs-12 col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body" style="padding:0px;">';
                            $this->generarGrafico($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, json_encode($desagregacionesTem), $fechas, json_encode($desagregacionesGeo), $i, $nombreGrafico);
                            echo '          </div>
                                    </div>
                                </div>';
                        }
                    } elseif ($diff == 'ciclo vital') {
                        $nombreGrafico = $nombreIndicador . ', por ciclo vital';
                        $desagregacionesGeo = array();
                        $desagregacionesTem = array();
                        for ($m = 0; $m < count($desagregacionesC); $m++) {
                            $desagregacionTem = $desagregacionesC[$m];
                            if ($desagregacionTem == "Primera Infancia" || $desagregacionTem == "Infancia" || $desagregacionTem == "Adolescencia" || $desagregacionTem == "Juventud" || $desagregacionTem == "Adultez" || $desagregacionTem == "Adulto Mayor") {
                                $desagregacionesTem[] = $desagregacionTem;
                            }
                            for ($k = 0; $k < count($zonasC); $k++) {
                                $desagregacionGeo = $zonasC[$k];
                                if (!in_array($desagregacionGeo, $desagregacionesGeo)) {
                                    $desagregacionesGeo[] = $desagregacionGeo;
                                }
                            }
                        }
                        if (count($desagregacionesTem) > 0) {
                            echo '  <div class="col-xs-12 col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body" style="padding:0px;">';
                            $this->generarGrafico($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, json_encode($desagregacionesTem), $fechas, json_encode($desagregacionesGeo), $i, $nombreGrafico);
                            echo '          </div>
                                    </div>
                                </div>';
                        }
                    } elseif ($diff == 'estrato') {
                        $nombreGrafico = $nombreIndicador . ', por estrato';
                        $desagregacionesGeo = array();
                        $desagregacionesTem = array();
                        for ($m = 0; $m < count($desagregacionesC); $m++) {
                            $desagregacionTem = $desagregacionesC[$m];
                            if (strpos($desagregacionTem, "Estrato", 0) !== false) {
                                $desagregacionesTem[] = $desagregacionTem;
                            }
                            for ($k = 0; $k < count($zonasC); $k++) {
                                $desagregacionGeo = $zonasC[$k];
                                if (!in_array($desagregacionGeo, $desagregacionesGeo)) {
                                    $desagregacionesGeo[] = $desagregacionGeo;
                                }
                            }
                        }
                        if (count($desagregacionesTem) > 0) {
                            echo '  <div class="col-xs-12 col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body" style="padding:0px;">';
                            $this->generarGrafico($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, json_encode($desagregacionesTem), $fechas, json_encode($desagregacionesGeo), $i, $nombreGrafico);
                            echo '          </div>
                                    </div>
                                </div>';
                        }
                    } elseif ($diff == 'cabecera') {
                        $nombreGrafico = $nombreIndicador . ' - Cabeceras';
                        $desagregacionesGeo = array();
                        $desagregacionesTem = array();
                        for ($m = 0; $m < count($desagregacionesC); $m++) {
                            $desagregacionTem = $desagregacionesC[$m];
                            if (strpos($desagregacionTem, "Cabecera", 0) !== false) {
                                $desagregacionesTem[] = $desagregacionTem;
                            }
                            for ($k = 0; $k < count($zonasC); $k++) {
                                $desagregacionGeo = $zonasC[$k];
                                if (!in_array($desagregacionGeo, $desagregacionesGeo)) {
                                    $desagregacionesGeo[] = $desagregacionGeo;
                                }
                            }
                        }
                        if (count($desagregacionesTem) > 0) {
                            echo '  <div class="col-xs-12 col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body" style="padding:0px;">';
                            $this->generarGrafico($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, json_encode($desagregacionesTem), $fechas, json_encode($desagregacionesGeo), $i, $nombreGrafico);
                            echo '          </div>
                                    </div>
                                </div>';
                        }
                    } elseif ($diff == 'resto') {
                        $nombreGrafico = $nombreIndicador . ' - Resto';
                        $desagregacionesGeo = array();
                        $desagregacionesTem = array();
                        for ($m = 0; $m < count($desagregacionesC); $m++) {
                            $desagregacionTem = $desagregacionesC[$m];
                            if (strpos($desagregacionTem, "Resto", 0) !== false) {
                                $desagregacionesTem[] = $desagregacionTem;
                            }
                            for ($k = 0; $k < count($zonasC); $k++) {
                                $desagregacionGeo = $zonasC[$k];
                                if (!in_array($desagregacionGeo, $desagregacionesGeo)) {
                                    $desagregacionesGeo[] = $desagregacionGeo;
                                }
                            }
                        }
                        if (count($desagregacionesTem) > 0) {
                            echo '  <div class="col-xs-12 col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body" style="padding:0px;">';
                            $this->generarGrafico($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, json_encode($desagregacionesTem), $fechas, json_encode($desagregacionesGeo), $i, $nombreGrafico);
                            echo '          </div>
                                    </div>
                                </div>';
                        }
                    } elseif ($diff == 'total') {
                        $nombreGrafico = $nombreIndicador . ' - Total';
                        $desagregacionesGeo = array();
                        $desagregacionesTem = array();
                        for ($m = 0; $m < count($desagregacionesC); $m++) {
                            $desagregacionTem = $desagregacionesC[$m];
                            if (strpos($desagregacionTem, "Total", 0) !== false) {
                                $desagregacionesTem[] = $desagregacionTem;
                            }
                            for ($k = 0; $k < count($zonasC); $k++) {
                                $desagregacionGeo = $zonasC[$k];
                                if (!in_array($desagregacionGeo, $desagregacionesGeo)) {
                                    $desagregacionesGeo[] = $desagregacionGeo;
                                }
                            }
                        }
                        if (count($desagregacionesTem) > 0) {
                            echo '  <div class="col-xs-12 col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body" style="padding:0px;">';
                            $this->generarGrafico($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, json_encode($desagregacionesTem), $fechas, json_encode($desagregacionesGeo), $i, $nombreGrafico);
                            echo '          </div>
                                    </div>
                                </div>';
                        }
                    } elseif ($diff == 'personas declaradas') {
                        $nombreGrafico = $nombreIndicador . ' - Personas declaradas';
                        $desagregacionesGeo = array();
                        $desagregacionesTem = array();
                        for ($m = 0; $m < count($desagregacionesC); $m++) {
                            $desagregacionTem = $desagregacionesC[$m];
                            if (strpos($desagregacionTem, "Personas declaradas", 0) !== false) {
                                $desagregacionesTem[] = $desagregacionTem;
                            }
                            for ($k = 0; $k < count($zonasC); $k++) {
                                $desagregacionGeo = $zonasC[$k];
                                if (!in_array($desagregacionGeo, $desagregacionesGeo)) {
                                    $desagregacionesGeo[] = $desagregacionGeo;
                                }
                            }
                        }
                        if (count($desagregacionesTem) > 0) {
                            echo '  <div class="col-xs-12 col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body" style="padding:0px;">';
                            $this->generarGrafico($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, json_encode($desagregacionesTem), $fechas, json_encode($desagregacionesGeo), $i, $nombreGrafico);
                            echo '          </div>
                                    </div>
                                </div>';
                        }
                    } elseif ($diff == 'personas recibidas') {
                        $nombreGrafico = $nombreIndicador . ' - Personas recibidas';
                        $desagregacionesGeo = array();
                        $desagregacionesTem = array();
                        for ($m = 0; $m < count($desagregacionesC); $m++) {
                            $desagregacionTem = $desagregacionesC[$m];
                            if (strpos($desagregacionTem, "Personas recibidas", 0) !== false) {
                                $desagregacionesTem[] = $desagregacionTem;
                            }
                            for ($k = 0; $k < count($zonasC); $k++) {
                                $desagregacionGeo = $zonasC[$k];
                                if (!in_array($desagregacionGeo, $desagregacionesGeo)) {
                                    $desagregacionesGeo[] = $desagregacionGeo;
                                }
                            }
                        }
                        if (count($desagregacionesTem) > 0) {
                            echo '  <div class="col-xs-12 col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body" style="padding:0px;">';
                            $this->generarGrafico($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, json_encode($desagregacionesTem), $fechas, json_encode($desagregacionesGeo), $i, $nombreGrafico);
                            echo '          </div>
                                    </div>
                                </div>';
                        }
                    } elseif ($diff == 'personas expulsadas') {
                        $nombreGrafico = $nombreIndicador . ' - Personas expulsadas';
                        $desagregacionesGeo = array();
                        $desagregacionesTem = array();
                        for ($m = 0; $m < count($desagregacionesC); $m++) {
                            $desagregacionTem = $desagregacionesC[$m];
                            if (strpos($desagregacionTem, "Personas expulsadas", 0) !== false) {
                                $desagregacionesTem[] = $desagregacionTem;
                            }
                            for ($k = 0; $k < count($zonasC); $k++) {
                                $desagregacionGeo = $zonasC[$k];
                                if (!in_array($desagregacionGeo, $desagregacionesGeo)) {
                                    $desagregacionesGeo[] = $desagregacionGeo;
                                }
                            }
                        }
                        if (count($desagregacionesTem) > 0) {
                            echo '  <div class="col-xs-12 col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body" style="padding:0px;">';
                            $this->generarGrafico($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, json_encode($desagregacionesTem), $fechas, json_encode($desagregacionesGeo), $i, $nombreGrafico);
                            echo '          </div>
                                    </div>
                                </div>';
                        }
                    }
                }

                $link = "";
                if ($tipoConsulta == 'General') {
                    $link = '/consulta-indicadores/dimensiones-sis/' . $idDimension . '/' . $idTematica .
                        '/' . $idIndicador;
                } elseif ($tipoConsulta == 'Comunas') {
                    $link = '/consulta-indicadores/dimensiones-sis-comunas/' . $idDimension . '/' . $idTematica .
                        '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
                } elseif ($tipoConsulta == 'IGC') {
                    $link = '/consulta-indicadores/otros-indicadores/igc/=' . $idDimension . '/' . $idTematica .
                        '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
                } elseif ($tipoConsulta == 'PIIA') {
                    $link = '/consulta-indicadores/piia/' . $idDimension . '/' . $idTematica .
                        '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
                } elseif ($tipoConsulta == 'ODRAF') {
                    $link = '/consulta-indicadores/odraf/' . $idDimension . '/' . $idTematica .
                        '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
                }
                echo '      <input type="text" id="link" hidden readonly value="' . $link . '" style="border:0; font-weight:bold; text-align:left;">';
                echo '  </div>
                    </div>
                </div>';
                echo '
                <div id="tabla" class="tab-pane fade in">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <h3 id="nombreIndicador" style="text-align:center">' . $nombreIndicador . '</h3>
                            <h4 style="text-align:center">' . $rango . '</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="centerTable">
                                <table id="tablaDatos" class="table table-striped table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <td colspan="4" style="background-color:#215a9a; color:#fff; text-align:center; visibility:hidden;">' . $nombreIndicador . '</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style = "background-color:#215a9a; color:#fff; text-align:center;">Desagregación geográfica</td>
                                            <td style = "background-color:#215a9a; color:#fff; text-align:center;">Desagregación temática</td>
                                            <td style = "background-color:#215a9a; color:#fff; text-align:center;">Fecha</td>
                                            <td style = "background-color:#215a9a; color:#fff; text-align:center;">' . ucfirst($unidadMedicion) . '</td>
                                        </tr>';
                for ($l = 0; $l < count($series); $l++) {
                    $serie2 = $series[$l][0];
                    $desTematica = $series[$l][1];
                    $desGeografica = $series[$l][2];
                    foreach ($labels as $row => $fecha) {
                        $dat = new Datos();
                        $dato = $dat->consultarInfoDatoPorIdSerieFecha($serie2, $fecha);
                        echo '
                                        <tr>
                                            <td style="text-align:center;">' . $desGeografica . '</td>
                                            <td style="text-align:center;">' . $desTematica . '</td>
                                            <td style="text-align:center;">' . $fecha . '</td>
                                            <td style="text-align:right;">';

                        $value = $dato[2];
                        $countDecimals = strlen(substr(strrchr($value, "."), 1));

                        if ($countDecimals > 0) {
                            settype($value, "Float");
                        } else {
                            settype($value, "Int");
                        }

                        if (strpos($nombreIndicador, "PIB Per cápita") !== false) {
                            echo '$' . number_format($dato[2], 2, ".", ",");
                        } elseif (
                            strpos($nombreIndicador, "GINI") !== false ||
                            strpos($nombreIndicador, "Toneladas de residuos sólidos") !== false ||
                            strpos($nombreIndicador, "Tasa de crecimiento de la población") !== false
                        ) {
                            echo number_format($dato[2], 2, ".", ",");
                        } elseif (strpos($nombreIndicador, "PIB Per cápita") !== false) {
                            echo '$' . number_format($dato[2], 2, ".", ",");
                        } else {
                            if (is_float($value)) {
                                echo number_format($value, 2, ".", ",");
                            } else {
                                echo number_format($value, 0, ".", ",");
                            }
                        }
                        echo '                  </td>
                                        </tr>';
                    }
                }
                echo '                  </tbody>
                                </table>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <p><strong>Tabla:</strong> Sistema de Indicadores Sociales</p>
                            <p><strong>Fuente de datos:</strong> ' . $fuente . '</p>';
                if (sizeof($notas) > 0) {
                    echo '      <p style="font-size: smaller;"><strong>Notas:</strong> ' . implode(" - ", $notas) . ' </p>';
                }
                if ($tipoConsulta == "ODRAF") {
                    echo '          <p style="margin:0px;">Para descargar la <strong>Ficha técnica de la Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali</strong>, haz clic <a href="/public/ODRAF/Ficha-técnica-Encuesta-ODRAF-2017.pdf" target="_blank"> aquí</a>.</p>';
                }

                echo "          <hr>
                            <h4 style='text-align:left'>Descargar datos</h4>
                            <div class='btn-group' role='group' style='width:100%; margin-bottom: 15px;'>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#2ECC71; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'csv', fileName: '$nombreIndicador'});" . '"' . ">
                                    <i class='fa fa-file-archive-o' aria-hidden='true' style='margin-right:10px;'></i>
                                    <b>CSV</b>                                                           
                                </button>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#1E8449; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'excel', fileName: '$nombreIndicador', excelFileFormat: 'xlsx', worksheetName: '.$nombreIndicador.'});" . '"' . ">
                                    <i class='fa fa-file-excel-o' aria-hidden='true' style='margin-right:10px;'></i>                                                
                                    <b>XLS</b>
                                </button>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#9777a8; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'json', fileName: '$nombreIndicador'});" . '"' . ">
                                    <i class='fa fa-file-text-o' aria-hidden='true' style='margin-right:10px;'></i>
                                    <b>JSON</b>                                                           
                                </button>
                            </div>
                        </div>
                    </div>";
                echo '
                </div>
                <div id="ficha" class="tab-pane fade in">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <h3 style="text-align:center">' . $nombreIndicador . '</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="centerTable">
                                <table id="tablaFicha" class="table table-striped" style="text-align:center">
                                    <tbody style="width:100%;">
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Dimensión</td>
                                            <td style="text-align:left;">' . $nombreDimension . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Temática</td>
                                            <td style="text-align:left;">' . $nombreTematica . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Indicador</td>
                                            <td style="text-align:left;">' . $nombreIndicador . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Sigla</td>
                                            <td style="text-align:left;">' . $sigla . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Justificación</td>
                                            <td style="text-align:left;">' . $justificacion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Definiciones y conceptos</td>
                                            <td style="text-align:left;">' . $definicion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Método de medición</td>
                                            <td style="text-align:left;">' . $metodosMedicion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Unidad de medida</td>
                                            <td style="text-align:left;">' . $unidadMedicion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Fórmulas</td>
                                            <td style="text-align:left;">' . $formulas . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Variables</td>
                                            <td style="text-align:left;">' . $variables . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Valores de referencia</td>
                                            <td style="text-align:left;">' . $valoresReferencia . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Naturaleza</td>
                                            <td style="text-align:left;">' . $naturaleza . '</td>
                                        </tr>                                            
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Desagregación temática</td>
                                            <td style="text-align:left;">' . $desagregacionTematica . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Desagregación geográfica</td>
                                            <td style="text-align:left;">' . $desagregacionGeografica . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Línea base</td>
                                            <td style="text-align:left;">' . $lineaBase . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Periodicidad</td>
                                            <td style="text-align:left;">' . $periodicidad . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Fuente de datos</td>
                                            <td style="text-align:left;">' . $fuente . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Observaciones</td>
                                            <td style="text-align:left;">' . $observaciones . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Fecha de elaboración</td>
                                            <td style="text-align:left;">' . $fechaElaboracion . '</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <p><strong>Ficha técnica:</strong> Sistema de Indicadores Sociales</p>
                            <hr>
                            <h4 style="text-align:left">Descargar ficha técnica</h4>';
                echo "          <div class='btn-group' role='group' style='width:100%; margin-bottom: 15px;'>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#1E8449; color:#fff;' onClick =" . '"' . "$('#tablaFicha').tableExport({type: 'excel', fileName: '.$nombreIndicador.', excelFileFormat: 'xlsx', worksheetName: '.$nombreIndicador.'});" . '"' . ">
                                    <i class='fa fa-file-excel-o' aria-hidden='true' style='margin-right:10px;'></i>                                                
                                    <b>XLS</b>
                                </button>";
                if ($formulas == "") {
                    $formulas = "_____";
                }
                if ($variables == "") {
                    $variables = "_____";
                }
                if ($valoresReferencia == "") {
                    $valoresReferencia = "_____";
                }
                if ($desagregacionTematica == "") {
                    $desagregacionTematica = "_____";
                }
                if ($desagregacionGeografica == "") {
                    $desagregacionGeografica = "_____";
                }
                if ($observaciones == "") {
                    $observaciones = "_____";
                }
                $nombreDim = preg_replace("/(\n|\r|\n\r)/", ' ', $nombreDimension);
                $nombreTem = preg_replace("/(\n|\r|\n\r)/", ' ', $nombreTematica);
                $nombreInd = preg_replace("/(\n|\r|\n\r)/", ' ', $nombreIndicador);
                $sig = preg_replace("/(\n|\r|\n\r)/", ' ', $sigla);
                $just = preg_replace("/(\n|\r|\n\r)/", ' ', $justificacion);
                $defi = preg_replace("/(\n|\r|\n\r)/", ' ', $definicion);
                $metodosMed = preg_replace("/(\n|\r|\n\r)/", ' ', $metodosMedicion);
                $nat = preg_replace("/(\n|\r|\n\r)/", ' ', $naturaleza);
                $form = preg_replace("/(\n|\r|\n\r)/", ' ', $formulas);
                $vari = preg_replace("/(\n|\r|\n\r)/", ' ', $variables);
                $valRef = preg_replace("/(\n|\r|\n\r)/", ' ', $valoresReferencia);
                $desGeografica = preg_replace("/(\n|\r|\n\r)/", ' ', $desagregacionTematica);
                $desTematica = preg_replace("/(\n|\r|\n\r)/", ' ', $desagregacionGeografica);
                $obs = preg_replace("/(\n|\r|\n\r)/", ' ', $observaciones);

                echo '              <script>
                                    document.formFicha.dimensionForm.value = "' . $nombreDim . '";
                                    document.formFicha.tematicaForm.value = "' . $nombreTem . '";
                                    document.formFicha.indicadorForm.value = "' . $nombreInd . '";
                                    document.formFicha.siglaForm.value = "' . $sig . '";
                                    document.formFicha.justificacionForm.value = "' . $just . '";
                                    document.formFicha.definicionForm.value = "' . $defi . '";
                                    document.formFicha.metodosMedicionForm.value = "' . $metodosMed . '";
                                    document.formFicha.unidadMedicionForm.value = "' . $unidadMedicion . '";
                                    document.formFicha.formulasForm.value = "' . $form . '";
                                    document.formFicha.variablesForm.value = "' . $vari . '";
                                    document.formFicha.valoresReferenciaForm.value = "' . $valRef . '";
                                    document.formFicha.naturalezaForm.value = "' . $nat . '";
                                    document.formFicha.desagregacionTematicaForm.value = "' . $desGeografica . '";
                                    document.formFicha.desagregacionGeograficaForm.value = "' . $desTematica . '";
                                    document.formFicha.lineaBaseForm.value = "' . $lineaBase . '";
                                    document.formFicha.periodicidadForm.value = "' . $periodicidad . '";
                                    document.formFicha.fuenteDatosForm.value = "' . $fuente . '";
                                    document.formFicha.observacionesForm.value = "' . $obs . '";
                                    document.formFicha.fechaElaboracionForm.value = "' . $fechaElaboracion . '";
                                </script>
                                <form id="formFicha" name="formFicha" action="/views/generar/sis.php" target="_blank" method="post">
                                    <input type="hidden" name="dimensionForm" id="dimensionForm"/>
                                    <input type="hidden" name="tematicaForm" id="tematicaForm"/>
                                    <input type="hidden" name="indicadorForm" id="indicadorForm"/>
                                    <input type="hidden" name="siglaForm" id="siglaForm"/>
                                    <input type="hidden" name="justificacionForm" id="justificacionForm"/>
                                    <input type="hidden" name="definicionForm" id="definicionForm"/>
                                    <input type="hidden" name="metodosMedicionForm" id="metodosMedicionForm"/>
                                    <input type="hidden" name="unidadMedicionForm" id="unidadMedicionForm"/>
                                    <input type="hidden" name="formulasForm" id="formulasForm"/>
                                    <input type="hidden" name="variablesForm" id="variablesForm"/>
                                    <input type="hidden" name="valoresReferenciaForm" id="valoresReferenciaForm"/>
                                    <input type="hidden" name="naturalezaForm" id="naturalezaForm"/>
                                    <input type="hidden" name="desagregacionTematicaForm" id="desagregacionTematicaForm"/>
                                    <input type="hidden" name="desagregacionGeograficaForm" id="desagregacionGeograficaForm"/>
                                    <input type="hidden" name="lineaBaseForm" id="lineaBaseForm"/>
                                    <input type="hidden" name="periodicidadForm" id="periodicidadForm"/>
                                    <input type="hidden" name="fuenteDatosForm" id="fuenteDatosForm"/>
                                    <input type="hidden" name="observacionesForm" id="observacionesForm"/>
                                    <input type="hidden" name="fechaElaboracionForm" id="fechaElaboracionForm"/>
                                    <button type="submit" class="btn bt bt-ripple pdf-buttom" style="background-color:#aa0501; color:#fff;">
                                        <i class="fa fa-file-pdf-o" aria-hidden="true" style="margin-right:10px;"></i>
                                        <b>PDF</b>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';
                if ($tipoConsulta == "ODRAF") {
                    echo '
                <div id="fichaEncuesta" class="tab-pane fade in">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <h3 style="text-align:center">' . $nombreIndicador . '</h3>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <embed src="/public/ODRAF/Ficha-técnica-Encuesta-ODRAF-2017.pdf" type="application/pdf" width="100%" height="800px" />
                        </div>
                    </div> 
                </div> 
            </div> 
                    ';
                } else {
                    echo '</div>';
                }
            }
        }
    }

    /**
     * <b>generarGrafico</b>
     * <br>
     * Genera el gráfico de un indicador, para los casos que el tipo de gráfico es diferencial
     * @param string $tipoConsulta Categoría de la consulta a realizar
     * @param string $idDimension ID de la dimensión a la que pertenece el indicador a consultar
     * @param string $idTematica ID de la temática a la que pertenece el indicador a consultar
     * @param string $idIndicador ID del indicador a consultar
     * @param string $fuenteC Fuente de datos del indicador a consultar
     * @param string $desagregaciones Desagregaciones temáticas del indicador a consultar
     * @param string $fechas Años del indicador a consultar
     * @param string $zonas Desagregaciones geográficas del indicador a consultar
     * @param string $numeroGrafico Número consecutivo del gráfico a generar
     * @param string $nombreGrafico Título del gráfico a consultar
     */
    public function generarGrafico($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, $desagregaciones, $fechas, $zonas, $numeroGrafico, $nombreGrafico)
    {
        $desagregacionesC = json_decode($desagregaciones);
        sort($desagregacionesC);
        $fechasC = json_decode($fechas);
        $zonasC = json_decode($zonas);
        $cons = new ConsultasModel();
        $resp = $cons->consultaIndicador($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, $desagregacionesC, $fechasC, $zonasC);
        if ($resp == 'error') {
            echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <li>Error al generar gráfico</li></div>";
        } else {
            $totalDatos = $resp[6];
            $tipoGrafico = $resp[7];
            $data = $resp[8];
            $notas = $resp[10];
            $rango = $resp[11];
            $unidadMedicion = ucfirst($resp[12]);
            $maxValue = $this->setMaxValue($resp[28]);
            $fuente = $resp[30];

            echo '  <div id="graf' . $numeroGrafico . '" style="background-color:#fff; padding: 0px 15px 10px;">
                        <h4 id="nombreIndicador" style="text-align:center">' . $nombreGrafico . '</h4>
                        <h5 style="text-align:center">' . $rango . '</h5>
                        <div class="canvas-holder">
                            <canvas id="myChart' . $numeroGrafico . '" style="height:200px; width: 100%;"></canvas>
                        </div>';
            if ($totalDatos == 1 && $tipoGrafico !== "Piramidal" && strpos($tipoGrafico, "Diferencial") !== FALSE) {
                $tipoGrafico = "Barras";
            }
            if ($tipoGrafico == "Barras") {
                echo '
                        <script>
                            var ctx = document.getElementById("myChart' . $numeroGrafico . '").getContext("2d");';
                echo $this->drawBarChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                echo '  </script>';
            } elseif ($tipoGrafico == "Lineal") {
                echo '  <script>
                            var ctx = document.getElementById("myChart' . $numeroGrafico . '").getContext("2d");';
                echo $this->drawLineChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                echo '  </script>';
            } elseif ($totalDatos > 10 && $tipoGrafico == "Área") {
                echo '
                        <script>
                            var ctx = document.getElementById("myChart' . $numeroGrafico . '").getContext("2d");';
                echo $this->drawAreaChart(json_encode($data), $unidadMedicion);
                echo '  </script>';
            } elseif ($tipoGrafico == "Treemap") {
                echo $this->drawTreemap(($data), $unidadMedicion);
            } elseif ($tipoGrafico == "Barras apiladas") {
                echo '  <script>
                            var ctx = document.getElementById("myChart' . $numeroGrafico . '").getContext("2d");';
                echo $this->drawStackedBarChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                echo '  </script>';
            } elseif ($tipoGrafico == "Piramidal") {
                echo '  <script> $("#myChart").hide(); $("#form-consulta-indicador").hide(); </script>';
                echo $this->drawPyramid($data, $unidadMedicion, $idIndicador);
            } else {
                if ($totalDatos <= 10) {
                    echo '
                        <script>
                            var ctx = document.getElementById("myChart' . $numeroGrafico . '").getContext("2d");';
                    echo $this->drawBarChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                    echo '</script>';
                } else {
                    echo '
                <script>
                    var ctx = document.getElementById("myChart' . $numeroGrafico . '").getContext("2d");';
                    echo $this->drawLineChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                    echo '</script>';
                }
            }
            echo '              <hr>
                                <p style="font-size:smaller;"><strong>Gráfico:</strong> Sistema de Indicadores Sociales</p>
                                <p style="font-size:smaller;"><strong>Fuente de datos:</strong> ' . $fuente . ' </p>';
            if (sizeof($notas) > 0) {
                echo '          <p style="margin:0px; font-size:smaller;"><strong>Notas:</strong> ' . implode(" - ", $notas) . ' </p>';
            }
            if ($tipoConsulta == "ODRAF" && $fuente == "Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali - Secretaría del Deporte y la Recreación") {
                echo '          <p style="margin:0px; font-size:smaller;">Este indicador fue calculado con los resultados de la <strong>Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali</strong>, realizada por el Observatorio del Deporte, la Recreación y la Actividad Física.</p>';
                echo '          <p style="margin:0px; font-size:smaller;">Para descargar la <strong>Ficha técnica de la Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali</strong>, haz clic <a href="/public/ODRAF/Ficha-técnica-Encuesta-ODRAF-2017.pdf" target="_blank"> aquí</a>.</p>';
            }

            echo '   </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <hr>
                            <h4 style="text-align:left">Descargar gráfico</h4>
                            <div id="copyDiv"></div>
                            <script>
                                $("#imagenPng' . $numeroGrafico . '").click(function () {
                                    var nombreIndicador = ($("#nombreIndicador").text()).trim();
                                    $("#loadingPng' . $numeroGrafico . '").show();
                                    var container = document.getElementById("graf' . $numeroGrafico . '");
                                    $("#loadingPng' . $numeroGrafico . '").css("display", "inline");
                                    html2canvas(container).then(function (canvas) {
                                        var link = document.createElement("a");
                                        document.body.appendChild(link);
                                        link.download = "" + nombreIndicador + ".png";
                                        link.href = canvas.toDataURL();
                                        link.target = "_blank";
                                        $("#loadingPng' . $numeroGrafico . '").hide();
                                        link.click();
                                    });
                                });
                            </script>
                            <div class="btn-group" role="group" style="width:100%; margin-bottom: 15px;">
                                <button type="button" id="imagenPng' . $numeroGrafico . '" class="btn bt bt-ripple" style="background-color:#52b1fe; color:#fff;">
                                    <i class="fa fa-file-image-o" aria-hidden="true" style="margin-right:10px;"></i>
                                    <b>PNG</b>
                                </button>
                                <img src="/views/resources/images/loading3.gif" id="loadingPng' . $numeroGrafico . '" style="display: none; margin-left: 10px;"/>
                            </div>
                        </div>
                    </div>';
        }
    }

    /**
     * <b>consultaIndicador</b>
     * <br>
     * Realiza la consulta de un indicador para su visualización en la página, 
     * en los casos que el tipo de gráfico no es diferencial
     * @param string $tipoConsulta Categoría de la consulta a realizar
     * @param string $idDimension ID de la dimensión a la que pertenece el indicador a consultar
     * @param string $idTematica ID de la temática a la que pertenece el indicador a consultar
     * @param string $idIndicador ID del indicador a consultar
     * @param string $fuenteC Fuente de datos del indicador a consultar
     * @param string $desagregaciones Desagregaciones temáticas del indicador a consultar
     * @param string $fechas Años del indicador a consultar
     * @param string $zonas Desagregaciones geográficas del indicador a consultar
     */
    public function consultaIndicador($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, $desagregaciones, $fechas, $zonas)
    {
        $desagregacionesC = json_decode($desagregaciones);
        $fechasC = json_decode($fechas);
        $zonasC = json_decode($zonas);
        $cons = new ConsultasModel();
        $resp = $cons->consultaIndicador($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, $desagregacionesC, $fechasC, $zonasC);
        if ($resp == 'error') {
            echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <li>Debe seleccionar todos los filtros</li></div>";
        } else {
            $nombreDimension = $resp[0];
            $nombreTematica = $resp[1];
            $nombreIndicador = $resp[2];
            $labels = $resp[3];
            $series = $resp[4];
            $desagregacionesGeograficas = $resp[5];
            $totalDatos = $resp[6];
            $tipoGrafico = $resp[7];
            $data = $resp[8];
            $entidadGeneradora = $resp[9];
            $notas = $resp[10];
            $rango = $resp[11];
            $unidadMedicion = $resp[12];
            $sigla = $resp[13];
            $justificacion = $resp[14];
            $definicion = $resp[15];
            $metodosMedicion = $resp[16];
            $formulas = $resp[17];
            $variables = $resp[18];
            $valoresReferencia = $resp[19];
            $naturaleza = $resp[20];
            $desagregacionTematica = $resp[21];
            $desagregacionGeografica = $resp[22];
            $lineaBase = $resp[23];
            $responsable = $resp[24];
            $observaciones = $resp[25];
            $fechaElaboracion = $resp[26];
            $periodicidad = $resp[27];
            $maxValue = $this->setMaxValue($resp[28]);
            $mapa = $resp[29];
            $fuente = $resp[30];

            echo '
            <div class="row border-consulta">
                <div class="col-xs-12">
                    <h6 style="color:#215a9a;"><b>Resultado de la consulta:</b></h6>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <p style="font-family:Source Sans Pro, sans-serif; font-size:15px;">
                        Dimensión: ' . $nombreDimension . ' <br>
                        Temática: ' . $nombreTematica . ' <br>
                    </p>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <p style="font-family:Source Sans Pro, sans-serif; font-size:15px;">
                        Indicador: ' . $nombreIndicador . ' <br>
                        Desagregaciones geográficas: ' . implode(' - ', $desagregacionesGeograficas) . ' <br>
                    </p>
                </div>
            </div>
            <script>
            	  $("#' . $idDimension . '").addClass("in");            
            	  $("#' . $idTematica . '_cali").addClass("in");            
            	             
            </script>';

            $ser = new SeriesDatosController();
            $noFuentes = count($ser->consultarFuentesPorIdIndicadorDiferenteComunasController($idIndicador));

            if ($nombreIndicador !== 'Quince primeras causas de muerte') {
                if ($tipoConsulta == "PIIA") {
                    include 'formConsultaPiia.php';
                } elseif ($noFuentes > 1 && $tipoConsulta == 'General') {
                    include 'formConsultaIndicadorMultiplesFuentes.php';
                } elseif ($tipoGrafico == 'Piramide') {

                } else {
                    include 'formConsultaIndicador.php';
                }
            }
            echo '<ul class = "nav nav-tabs">';

            if ($tipoConsulta == "ODRAF" && $fuente == "Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali - Secretaría del Deporte y la Recreación" && count($desagregacionesC) == 1 && count($zonasC) == 1 && count($fechasC) == 1) {
                echo '
                <li class = "active"><a data-toggle = "tab" href = "#grafico">Gráfico y tabla</a></li>
                <li><a data-toggle="tab" href="#ficha">Ficha técnica del indicador</a></li>
                <li><a data-toggle="tab" href="#fichaEncuesta">Ficha técnica de la Encuesta</a></li>
            </ul>';
            } elseif ($tipoConsulta == "ODRAF" && count($desagregacionesC) == 1 && count($zonasC) == 1 && count($fechasC) == 1) {
                echo '
                <li class = "active"><a data-toggle = "tab" href = "#grafico">Gráfico y tabla</a></li>
                <li><a data-toggle="tab" href="#ficha">Ficha técnica del indicador</a></li>
            </ul>';
            } elseif ($tipoConsulta == "ODRAF" && $fuente == "Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali - Secretaría del Deporte y la Recreación" && count($desagregacionesC) > 1) {
                echo '
                <li class = "active"><a data-toggle = "tab" href = "#grafico">Gráfico</a></li>
                <li><a data-toggle="tab" href="#tabla">Tabla</a></li>
                <li><a data-toggle="tab" href="#ficha">Ficha técnica del indicador</a></li>
                <li><a data-toggle="tab" href="#fichaEncuesta">Ficha técnica de la Encuesta</a></li>
            </ul>';
            } else {
                if ($mapa !== "" && $mapa !== NULL) {
                    echo '
                <li class = "active"><a data-toggle = "tab" href = "#mapa">Mapa</a></li>
                <li><a data-toggle = "tab" href = "#grafico">Gráfico</a></li>
                <li><a data-toggle="tab" href="#tabla">Tabla</a></li>
                <li><a data-toggle="tab" href="#ficha">Ficha técnica</a></li>';
                } else {
                    echo '
                <li class = "active"><a data-toggle = "tab" href = "#grafico">Gráfico</a></li>
                <li><a data-toggle="tab" href="#tabla">Tabla</a></li>
                <li><a data-toggle="tab" href="#ficha">Ficha técnica</a></li>
            </ul>';
                }
            }
            echo '
            <div class="tab-content" id="tab-consulta">';

            if ($mapa !== "" && $mapa !== NULL) {
                echo ' 
                <div id="mapa" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12" style="text-align:center; padding-top: 15px;">
                            ' . $mapa . '
                        </div>
                    </div>
                </div>
                <div id="grafico" class="tab-pane fade in">';
            } else {
                echo ' <div id="grafico" class="tab-pane fade in active">';
            }

            if ($tipoConsulta == "ODRAF" && count($desagregacionesC) == 1 && count($zonasC) == 1 && count($fechasC) == 1) {
                echo '  
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <h3 id="nombreIndicador" style="text-align:center">' . $nombreIndicador . '</h3>
                            <h4 style="text-align:center">' . $rango . '</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="graf" style="background-color:#fff;">
                                        <div class="canvas-holder">
                                            <canvas id="myChart" style="width: 100%;"></canvas>
                                        </div>';
                $cons = new ConsultasController();
                $unidadMedicion = ucfirst($unidadMedicion);

                if ($totalDatos == 1 && $tipoGrafico !== "Piramidal" && strpos($tipoGrafico, "Diferencial") !== FALSE) {
                    $tipoGrafico = "Barras";
                }
                if ($tipoGrafico == "Barras") {
                    echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                    echo $cons->drawBarChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                    echo '</script>';
                } elseif ($tipoGrafico == "Lineal") {
                    echo '
                             <script>
                              var ctx = document.getElementById("myChart").getContext("2d");';
                    echo $cons->drawLineChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                    echo '</script>';
                } elseif ($tipoGrafico == "Burbuja") {
                    echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                    echo $cons->drawBubbleChart(json_encode($data), $unidadMedicion);
                    echo '</script>';
                } elseif ($totalDatos > 10 && $tipoGrafico == "Área") {
                    echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                    echo $cons->drawAreaChart(json_encode($data), $unidadMedicion);
                    echo '</script>';
                } elseif ($tipoGrafico == "Treemap") {
                    echo $cons->drawTreemap(($data), $unidadMedicion);
                } elseif ($tipoGrafico == "Barras apiladas") {
                    echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                    echo $cons->drawStackedBarChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                    echo '</script>';
                } elseif ($tipoGrafico == "Piramidal") {
                    echo '<script> $("#myChart").hide(); $("#form-consulta-indicador").hide(); </script>';
                    echo $cons->drawPyramid($data, $unidadMedicion, $idIndicador);
                } else {
                    if ($totalDatos <= 10) {
                        echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                        echo $cons->drawBarChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                        echo '</script>';
                    } else {
                        echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                        echo $cons->drawLineChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                        echo '</script>';
                    }
                }
                echo '              </div>';
                $link = "";
                if ($tipoConsulta == 'General') {
                    $link = '/consulta-indicadores/dimensiones-sis/' . $idDimension . '/' . $idTematica .
                        '/' . $idIndicador;
                } elseif ($tipoConsulta == 'Comunas') {
                    $link = '/consulta-indicadores/dimensiones-sis-comunas/' . $idDimension . '/' . $idTematica .
                        '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
                } elseif ($tipoConsulta == 'IGC') {
                    $link = '/consulta-indicadores/otros-indicadores/igc/=' . $idDimension . '/' . $idTematica .
                        '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
                } elseif ($tipoConsulta == 'PIIA') {
                    $link = '/consulta-indicadores/piia/' . $idDimension . '/' . $idTematica .
                        '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
                } elseif ($tipoConsulta == 'ODRAF') {
                    $link = '/consulta-indicadores/odraf/' . $idDimension . '/' . $idTematica .
                        '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
                }
                echo '      <input type="text" id="link" hidden readonly value="' . $link . '" style="border:0; font-weight:bold; text-align:left;">';
                echo '       
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <hr>
                                    <h4 style="text-align:left">Descargar gráfico</h4>
                                    <script>
                                        var url = "/views/resources/js/descargarGrafico.js";
                                        $.getScript(url);
                                    </script>
                                    <div class="btn-group" role="group" style="width:100%; margin-bottom: 15px;">
                                        <button type="button" id="imagenPng" class="btn bt bt-ripple" style="background-color:#52b1fe; color:#fff;">
                                            <i class="fa fa-file-image-o" aria-hidden="true" style="margin-right:10px;"></i>
                                            <b>PNG</b>
                                        </button>
                                        <img src="/views/resources/images/loading3.gif" id="loadingPng" style="display: none; margin-left: 10px;"/>
                                    </div>
                                </div>
                            </div>
                        </div>';
                //                Termina gráfico
                echo '  <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <div class="centerTable">
                                        <table id="tablaDatos" class="table table-striped table-bordered table-hover table-responsive">
                                            <thead>
                                                <tr>
                                                    <td colspan="4" style="background-color:#215a9a; color:#fff; text-align:center; visibility:hidden;">' . $nombreIndicador . '</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style = "background-color:#215a9a; color:#fff; text-align:center;">Desagregación geográfica</td>
                                                    <td style = "background-color:#215a9a; color:#fff; text-align:center;">Desagregación temática</td>
                                                    <td style = "background-color:#215a9a; color:#fff; text-align:center;">Fecha</td>
                                                    <td style = "background-color:#215a9a; color:#fff; text-align:center;">' . ucfirst($unidadMedicion) . '</td>
                                                </tr>';
                for ($l = 0; $l < count($series); $l++) {
                    $serie2 = $series[$l][0];
                    $desTematica = $series[$l][1];
                    $desGeografica = $series[$l][2];
                    foreach ($labels as $row => $fecha) {
                        $dat = new Datos();
                        $dato = $dat->consultarInfoDatoPorIdSerieFecha($serie2, $fecha);
                        echo '
                                                <tr>
                                                    <td style="text-align:center;">' . $desGeografica . '</td>
                                                    <td style="text-align:center;">' . $desTematica . '</td>
                                                    <td style="text-align:center;">' . $fecha . '</td>
                                                    <td style="text-align:right;">';
                        $value = $dato[2];
                        $countDecimals = strlen(substr(strrchr($value, "."), 1));
                        if ($countDecimals > 0) {
                            settype($value, "Float");
                        } else {
                            settype($value, "Int");
                        }
                        if (strpos($nombreIndicador, "PIB Per cápita") !== false) {
                            echo '$' . number_format($dato[2], 2, ".", ",");
                        } elseif (
                            strpos($nombreIndicador, "GINI") !== false ||
                            strpos($nombreIndicador, "Toneladas de residuos sólidos") !== false ||
                            strpos($nombreIndicador, "Tasa de crecimiento de la población") !== false
                        ) {
                            echo number_format($dato[2], 2, ".", ",");
                        } elseif (strpos($nombreIndicador, "PIB Per cápita") !== false) {
                            echo '$' . number_format($dato[2], 2, ".", ",");
                        } else {
                            if (is_float($value)) {
                                echo number_format($value, 2, ".", ",");
                            } else {
                                echo number_format($value, 0, ".", ",");
                            }
                        }
                        echo '                      </td>
                                                </tr>';
                    }
                }
                echo '                      </tbody>
                                        </table>
                                    </div>';

                echo "              <hr>
                                    <h4 style='text-align:left'>Descargar datos</h4>
                                    <div class='btn-group' role='group' style='width:100%; margin-bottom: 15px;'>
                                        <button type='button' class='btn bt bt-ripple' style='background-color:#2ECC71; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'csv', fileName: '$nombreIndicador'});" . '"' . ">
                                            <i class='fa fa-file-archive-o' aria-hidden='true' style='margin-right:10px;'></i>
                                            <b>CSV</b>                                                           
                                        </button>
                                        <button type='button' class='btn bt bt-ripple' style='background-color:#1E8449; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'excel', fileName: '$nombreIndicador', excelFileFormat: 'xlsx', worksheetName: '.$nombreIndicador.'});" . '"' . ">
                                            <i class='fa fa-file-excel-o' aria-hidden='true' style='margin-right:10px;'></i>                                                
                                            <b>XLS</b>
                                        </button>
                                        <button type='button' class='btn bt bt-ripple' style='background-color:#9777a8; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'json', fileName: '$nombreIndicador'});" . '"' . ">
                                            <i class='fa fa-file-text-o' aria-hidden='true' style='margin-right:10px;'></i>
                                            <b>JSON</b>                                                           
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
                echo "
                    <div class='row' style='margin-bottom:15px;'>
                        <div class='col-xs-12 col-sm-12'>
                            <hr>
                            <p><strong>Gráfico y tabla:</strong> Sistema de Indicadores Sociales</p>
                            <p><strong>Fuente de datos:</strong> $fuente</p>";
                if (sizeof($notas) > 0) {
                    echo '  <p style="font-size: smaller;" ><strong>Notas:</strong> ' . implode(" - ", $notas) . ' </p>';
                }
                if ($tipoConsulta == "ODRAF" && $fuente == "Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali - Secretaría del Deporte y la Recreación") {
                    echo '  <p style="margin:0px;">Este indicador fue calculado con los resultados de la <strong>Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali</strong>, realizada por el Observatorio del Deporte, la Recreación y la Actividad Física.</p>';
                    echo '  <p style="margin:0px;">Para descargar la <strong>Ficha técnica de la Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali</strong>, haz clic <a href="/public/ODRAF/Ficha-técnica-Encuesta-ODRAF-2017.pdf" target="_blank"> aquí</a>.</p>';
                }
                echo "  </div>
                    </div>    
                </div>";
            } else {
                echo '  <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div id="graf" style="background-color:#fff; padding: 0px 15px 10px;">
                                <h3 id="nombreIndicador" style="text-align:center">' . $nombreIndicador . '</h3>
                                <h4 style="text-align:center">' . $rango . '</h4>
                                <div class="canvas-holder" >
                                    <canvas id="myChart" style="heigth: 10000px !important;"></canvas>
                                </div>';

                $cons = new ConsultasController();
                $unidadMedicion = ucfirst($unidadMedicion);

                if ($totalDatos == 1 && $tipoGrafico !== "Piramidal" && strpos($tipoGrafico, "Diferencial") !== FALSE) {
                    $tipoGrafico = "Barras";
                }
                if ($tipoGrafico == "Barras") {
                    echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                    echo $cons->drawBarChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                    echo '</script>';
                } elseif ($tipoGrafico == "Barras horizontales") {
                    echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                    echo $cons->drawHorizontalBarChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                    echo '</script>';
                } elseif ($tipoGrafico == "Circular") {
                    var_dump($tipoGrafico);
                    echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                    echo $cons->drawDoughnutChart(json_encode($data), $unidadMedicion);
                    echo '</script>';
                } elseif ($tipoGrafico == "Burbuja") {
                    echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                    echo $cons->drawBubbleChart(json_encode($data), $unidadMedicion);
                    echo '</script>';
                } elseif ($tipoGrafico == "Lineal") {
                    if ($nombreIndicador == "Víctimas del conflicto por desplazamiento") {
                        $bottom = "Victimas";
                        echo '
                             <script>
                                      var ctx = document.getElementById("myChart").getContext("2d");';
                        echo $cons->drawLineChartMaxValue(json_encode($data), $unidadMedicion, $bottom);
                        echo '</script>';
                    } else {
                        echo '
                              <script>
                                 var ctx = document.getElementById("myChart").getContext("2d");';
                        echo $cons->drawLineChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                        echo '</script>';
                    }
                } elseif ($tipoGrafico == "Círculo") {
                    echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                    echo $cons->drawLineChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                    echo '</script>';
                } elseif ($tipoGrafico == "Mapa") {
                    echo $cons->drawMap(($data), $unidadMedicion);
                } elseif ($totalDatos > 10 && $tipoGrafico == "Área") {
                    echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                    echo $cons->drawAreaChart(json_encode($data), $unidadMedicion);
                    echo '</script>';
                } elseif ($tipoGrafico == "Treemap") {
                    echo $cons->drawTreemap(($data), $unidadMedicion);
                } elseif ($tipoGrafico == "Barras apiladas") {
                    echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                    echo $cons->drawStackedBarChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                    echo '</script>';
                } elseif ($tipoGrafico == "Piramidal") {
                    echo '<script> $("#myChart").hide(); $("#form-consulta-indicador").hide(); </script>';
                    echo $cons->drawPyramid($data, $unidadMedicion, $idIndicador);
                } elseif ($tipoGrafico == "Piramide") {
                    echo '<script> $("#myChart").hide(); $("#form-consulta-indicador").hide(); </script>';
                    echo $cons->drawPyramidPrueba($data, $unidadMedicion, $series);
                } elseif ($tipoGrafico == "Radar") {
                    echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                    echo $cons->drawRadar(json_encode($data), $unidadMedicion, $maxValue);
                    echo '</script>';
                } else {
                    if ($totalDatos <= 10) {
                        echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                        echo $cons->drawBarChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                        echo '</script>';
                    } else {
                        echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                        echo $cons->drawLineChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                        echo '</script>';
                    }
                }
                echo '              <hr>
                                <p><strong>Gráfico:</strong> Sistema de Indicadores Sociales</p>
                                <p><strong>Fuente de datos:</strong> ' . $fuente . ' </p>';
                if (sizeof($notas) > 0) {
                    echo '          <p style="font-size: smaller;margin:0px;"><strong>Notas:</strong> ' . implode(" - ", $notas) . ' </p>';
                }
                if ($tipoConsulta == "ODRAF" && $fuente == "Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali - Secretaría del Deporte y la Recreación") {
                    echo '          <p style="margin:0px;">Este indicador fue calculado con los resultados de la <strong>Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali</strong>, realizada por el Observatorio del Deporte, la Recreación y la Actividad Física.</p>';
                    echo '          <p style="margin:0px;">Para descargar la <strong>Ficha técnica de la Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali</strong>, haz clic <a href="/public/ODRAF/Ficha-técnica-Encuesta-ODRAF-2017.pdf" target="_blank"> aquí</a>.</p>';
                }
                echo '          </div>
                        </div>';
                $link = "";
                if ($tipoConsulta == 'General') {
                    $link = '/consulta-indicadores/dimensiones-sis/' . $idDimension . '/' . $idTematica .
                        '/' . $idIndicador;
                } elseif ($tipoConsulta == 'Comunas') {
                    $link = '/consulta-indicadores/dimensiones-sis-comunas/' . $idDimension . '/' . $idTematica .
                        '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
                } elseif ($tipoConsulta == 'IGC') {
                    $link = '/consulta-indicadores/otros-indicadores/igc/=' . $idDimension . '/' . $idTematica .
                        '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
                } elseif ($tipoConsulta == 'PIIA') {
                    $link = '/consulta-indicadores/piia/' . $idDimension . '/' . $idTematica .
                        '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
                } elseif ($tipoConsulta == 'ODRAF') {
                    $link = '/consulta-indicadores/odraf/' . $idDimension . '/' . $idTematica .
                        '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
                }
                echo '      <input type="text" id="link" hidden readonly value="' . $link . '" style="border:0; font-weight:bold; text-align:left;">';
                echo '   </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <hr>
                            <h4 style="text-align:left">Descargar gráfico</h4>
                            <script>
                                var url = "/views/resources/js/descargarGrafico.js";
                                $.getScript(url);
                            </script>
                            <div class="btn-group" role="group" style="width:100%; margin-bottom: 15px;">
                                <button type="button" id="imagenPng" class="btn bt bt-ripple" style="background-color:#52b1fe; color:#fff;">
                                    <i class="fa fa-file-image-o" aria-hidden="true" style="margin-right:10px;"></i>
                                    <b>PNG</b>
                                </button>
                                <img src="/views/resources/images/loading3.gif" id="loadingPng" style="display: none; margin-left: 10px;"/>
                            </div>
                        </div>
                    </div>
                </div>';
                echo '
                <div id="tabla" class="tab-pane fade in">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <h3 id="nombreIndicador" style="text-align:center">' . $nombreIndicador . '</h3>
                            <h4 style="text-align:center">' . $rango . '</h4>
                        </div>
                    </div>';
                if ($nombreIndicador !== 'Quince primeras causas de muerte') {
                    echo '
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="centerTable">
                                <table id="tablaDatos" class="table table-striped table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <td colspan="4" style="background-color:#215a9a; color:#fff; text-align:center; visibility:hidden;">' . $nombreIndicador . '</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style = "background-color:#215a9a; color:#fff; text-align:center;">Desagregación geográfica</td>
                                            <td style = "background-color:#215a9a; color:#fff; text-align:center;">Desagregación temática</td>
                                            <td style = "background-color:#215a9a; color:#fff; text-align:center;">Fechaaa</td>
                                            <td style = "background-color:#215a9a; color:#fff; text-align:center;">' . ucfirst($unidadMedicion) . '</td>
                                        </tr>';
                    for ($l = 0; $l < count($series); $l++) {
                        $serie2 = $series[$l][0];
                        $desTematica = $series[$l][1];
                        $desGeografica = $series[$l][2];
                        foreach ($labels as $row => $fecha) {
                            $dat = new Datos();
                            $dato = $dat->consultarInfoDatoPorIdSerieFecha($serie2, $fecha);
                            echo '
                                        <tr>
                                            <td style="text-align:center;">' . $desGeografica . '</td>
                                            <td style="text-align:center;">' . $desTematica . '</td>
                                            <td style="text-align:center;">' . $fecha . '</td>
                                            <td style="text-align:right;">';

                            $value = $dato[2];
                            $countDecimals = strlen(substr(strrchr($value, "."), 1));

                            if ($value === "-") {
                                echo $value;
                            } else {
                                if ($countDecimals > 0) {
                                    settype($value, "Float");
                                } else {
                                    settype($value, "Int");
                                }

                                if (strpos($nombreIndicador, "PIB Per cápita") !== false) {
                                    echo '$' . number_format($dato[2], 2, ".", ",");
                                } elseif (
                                    strpos($nombreIndicador, "GINI") !== false ||
                                    strpos($nombreIndicador, "Toneladas de residuos sólidos") !== false ||
                                    strpos($nombreIndicador, "Tasa de crecimiento de la población") !== false
                                ) {
                                    echo number_format($dato[2], 2, ".", ",");
                                } elseif (strpos($nombreIndicador, "PIB Per cápita") !== false) {
                                    echo '$' . number_format($dato[2], 2, ".", ",");
                                } else {
                                    if (is_float($value)) {
                                        echo number_format($value, 2, ".", ",");
                                    } else {
                                        echo number_format($value, 0, ".", ",");
                                    }
                                }
                            }
                            echo '</td>
                                        </tr>';
                        }
                    }
                    echo '          </tbody>
                                </table>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <p><strong>Tabla:</strong> Sistema de Indicadores Sociales</p>
                            <p><strong>Fuente de datos:</strong> ' . $fuente . '</p>';
                    if (sizeof($notas) > 0) {
                        echo '      <p style="font-size: smaller;"><strong>Notas:</strong> ' . implode(" - ", $notas) . ' </p>';
                    }
                    if ($tipoConsulta == "ODRAF" && $fuente == "Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali - Secretaría del Deporte y la Recreación") {
                        echo '      <p style="margin:0px;">Este indicador fue calculado con los resultados de la <strong>Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali</strong>, realizada por el Observatorio del Deporte, la Recreación y la Actividad Física.</p>';
                        echo '      <p style="margin:0px;">Para descargar la <strong>Ficha técnica de la Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali</strong>, haz clic <a href="/public/ODRAF/Ficha-técnica-Encuesta-ODRAF-2017.pdf" target="_blank"> aquí</a>.</p>';
                    }

                    echo "          <hr>
                            <h4 style='text-align:left'>Descargar datos</h4>
                            <div class='btn-group' role='group' style='width:100%; margin-bottom: 15px;'>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#2ECC71; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'csv', fileName: '$nombreIndicador'});" . '"' . ">
                                    <i class='fa fa-file-archive-o' aria-hidden='true' style='margin-right:10px;'></i>
                                    <b>CSV</b>                                                           
                                </button>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#1E8449; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'excel', fileName: '$nombreIndicador', excelFileFormat: 'xlsx', worksheetName: '.$nombreIndicador.'});" . '"' . ">
                                    <i class='fa fa-file-excel-o' aria-hidden='true' style='margin-right:10px;'></i>                                                
                                    <b>XLS</b>
                                </button>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#9777a8; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'json', fileName: '$nombreIndicador'});" . '"' . ">
                                    <i class='fa fa-file-text-o' aria-hidden='true' style='margin-right:10px;'></i>
                                    <b>JSON</b>                                                           
                                </button>
                            </div>
                        </div>
                    </div>";
                    echo '
                    </div>';
                } else {
                    $noColumnas = count($labels) + 1;
                    echo '
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="centerTable">
                                <table id="tablaDatos" class="table table-striped table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <td colspan="' . $noColumnas . '" style="background-color:#215a9a; color:#fff; text-align:center; visibility:hidden;">' . $nombreIndicador . '</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center; padding:1px;font-size:12px;">Causas \ Años</td>';
                    for ($k = 0; $k < count($labels); $k++) {
                        echo '              <td style="background-color:#215a9a; color:#fff; text-align:center; padding:1px;font-size:12px;">' . $labels[$k] . '</td>';
                    }
                    echo '              </tr>';
                    usort($series, function ($a, $b) {
                        return strnatcasecmp($a[1], $b[1]);
                    });
                    for ($l = 0; $l < count($series); $l++) {
                        $serie2 = $series[$l][0];
                        $desTem = $series[$l][1];
                        echo '          <tr>
                                            <td style="text-align:center; padding:1px;font-size:12px;">' . $desTem . '</td>';
                        for ($m = 0; $m < count($labels); $m++) {
                            $fecha = $labels[$m];
                            $dat = new Datos();
                            $dato = $dat->consultarInfoDatoPorIdSerieFecha($serie2, $fecha);
                            echo '          <td style="text-align:right; padding:1px;font-size:12px;">';
                            $value = $dato[2];
                            $countDecimals = strlen(substr(strrchr($value, "."), 1));
                            if ($countDecimals > 0) {
                                settype($value, "Float");
                            } else {
                                settype($value, "Int");
                            }

                            if (strpos($nombreIndicador, "PIB Per cápita") !== false) {
                                echo '$' . number_format($dato[2], 2, ".", ",");
                            } elseif (
                                strpos($nombreIndicador, "GINI") !== false ||
                                strpos($nombreIndicador, "Toneladas de residuos sólidos") !== false ||
                                strpos($nombreIndicador, "Tasa de crecimiento de la población") !== false
                            ) {
                                echo number_format($dato[2], 2, ".", ",");
                            } elseif (strpos($nombreIndicador, "PIB Per cápita") !== false) {
                                echo '$' . number_format($dato[2], 2, ".", ",");
                            } else {
                                if (is_float($value)) {
                                    echo number_format($value, 2, ".", ",");
                                } else {
                                    echo number_format($value, 0, ".", ",");
                                }
                            }
                            echo '          </td>';
                        }
                        echo '           </tr>';
                    }
                    echo '          </tbody>
                                </table>
                            </div>
                            <hr>
                        </div>
                    </div>';

                    echo '
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <p><strong>Tabla:</strong> Sistema de Indicadores Sociales</p>
                            <p><strong>Fuente de datos:</strong> ' . $fuente . '</p>';
                    if (sizeof($notas) > 0) {
                        echo '      <p style="font-size: smaller;margin:0px;"><strong>Notas:</strong> ' . implode(" - ", $notas) . ' </p>';
                    }
                    if ($tipoConsulta == "ODRAF" && $fuente == "Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali - Secretaría del Deporte y la Recreación") {
                        echo '      <p style="margin:0px;">Este indicador fue calculado con los resultados de la <strong>Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali</strong>, realizada por el Observatorio del Deporte, la Recreación y la Actividad Física.</p>';
                        echo '      <p style="margin:0px;">Para descargar la <strong>Ficha técnica de la Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali</strong>, haz clic <a href="/public/ODRAF/Ficha-técnica-Encuesta-ODRAF-2017.pdf" target="_blank"> aquí</a>.</p>';
                    }

                    echo "          <hr>
                            <h4 style='text-align:left'>Descargar datos</h4>
                            <div class='btn-group' role='group' style='width:100%; margin-bottom: 15px;'>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#2ECC71; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'csv', fileName: '$nombreIndicador'});" . '"' . ">
                                    <i class='fa fa-file-archive-o' aria-hidden='true' style='margin-right:10px;'></i>
                                    <b>CSV</b>                                                           
                                </button>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#1E8449; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'excel', fileName: '$nombreIndicador', excelFileFormat: 'xlsx', worksheetName: '.$nombreIndicador.'});" . '"' . ">
                                    <i class='fa fa-file-excel-o' aria-hidden='true' style='margin-right:10px;'></i>                                                
                                    <b>XLS</b>
                                </button>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#9777a8; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'json', fileName: '$nombreIndicador'});" . '"' . ">
                                    <i class='fa fa-file-text-o' aria-hidden='true' style='margin-right:10px;'></i>
                                    <b>JSON</b>                                                           
                                </button>
                            </div>
                        </div>
                    </div>";
                    echo '
                </div>';
                }
            }

            echo '
                <div id="ficha" class="tab-pane fade in">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <h3 style="text-align:center">' . $nombreIndicador . '</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="centerTable">
                                <table id="tablaFicha" class="table table-striped" style="text-align:center">
                                    <tbody style="width:100%;">
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Dimensión</td>
                                            <td style="text-align:left;">' . $nombreDimension . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Temática</td>
                                            <td style="text-align:left;">' . $nombreTematica . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Indicador</td>
                                            <td style="text-align:left;">' . $nombreIndicador . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Sigla</td>
                                            <td style="text-align:left;">' . $sigla . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Justificación</td>
                                            <td style="text-align:left;">' . $justificacion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Definiciones y conceptos</td>
                                            <td style="text-align:left;">' . $definicion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Método de medición</td>
                                            <td style="text-align:left;">' . $metodosMedicion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Unidad de medida</td>
                                            <td style="text-align:left;">' . $unidadMedicion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Fórmulas</td>
                                            <td style="text-align:left;">' . $formulas . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Variables</td>
                                            <td style="text-align:left;">' . $variables . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Valores de referencia</td>
                                            <td style="text-align:left;">' . $valoresReferencia . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Naturaleza</td>
                                            <td style="text-align:left;">' . $naturaleza . '</td>
                                        </tr>                                            
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Desagregación temática</td>
                                            <td style="text-align:left;">' . $desagregacionTematica . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Desagregación geográfica</td>
                                            <td style="text-align:left;">' . $desagregacionGeografica . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Línea base</td>
                                            <td style="text-align:left;">' . $lineaBase . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Periodicidad</td>
                                            <td style="text-align:left;">' . $periodicidad . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Fuente de datos</td>
                                            <td style="text-align:left;">' . $fuente . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Observaciones</td>
                                            <td style="text-align:left;">' . $observaciones . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Fecha de elaboración</td>
                                            <td style="text-align:left;">' . $fechaElaboracion . '</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <p><strong>Ficha técnica:</strong> Sistema de Indicadores Sociales</p>
                            <hr>
                            <h4 style="text-align:left">Descargar ficha técnica</h4>';
            echo "          <div class='btn-group' role='group' style='width:100%; margin-bottom: 15px;'>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#1E8449; color:#fff;' onClick =" . '"' . "$('#tablaFicha').tableExport({type: 'excel', fileName: '.$nombreIndicador.', excelFileFormat: 'xlsx', worksheetName: '.$nombreIndicador.'});" . '"' . ">
                                    <i class='fa fa-file-excel-o' aria-hidden='true' style='margin-right:10px;'></i>                                                
                                    <b>XLS</b>
                                </button>";
            if ($formulas == "") {
                $formulas = "_____";
            }
            if ($variables == "") {
                $variables = "_____";
            }
            if ($valoresReferencia == "") {
                $valoresReferencia = "_____";
            }
            if ($desagregacionTematica == "") {
                $desagregacionTematica = "_____";
            }
            if ($desagregacionGeografica == "") {
                $desagregacionGeografica = "_____";
            }
            if ($observaciones == "") {
                $observaciones = "_____";
            }
            $nombreDim = preg_replace("/(\n|\r|\n\r)/", ' ', $nombreDimension);
            $nombreTem = preg_replace("/(\n|\r|\n\r)/", ' ', $nombreTematica);
            $nombreInd = preg_replace("/(\n|\r|\n\r)/", ' ', $nombreIndicador);
            $sig = preg_replace("/(\n|\r|\n\r)/", ' ', $sigla);
            $just = preg_replace("/(\n|\r|\n\r)/", ' ', $justificacion);
            $defi = preg_replace("/(\n|\r|\n\r)/", ' ', $definicion);
            $metodosMed = preg_replace("/(\n|\r|\n\r)/", ' ', $metodosMedicion);
            $nat = preg_replace("/(\n|\r|\n\r)/", ' ', $naturaleza);
            $form = preg_replace("/(\n|\r|\n\r)/", ' ', $formulas);
            $vari = preg_replace("/(\n|\r|\n\r)/", ' ', $variables);
            $valRef = preg_replace("/(\n|\r|\n\r)/", ' ', $valoresReferencia);
            $desGeografica = preg_replace("/(\n|\r|\n\r)/", ' ', $desagregacionTematica);
            $desTematica = preg_replace("/(\n|\r|\n\r)/", ' ', $desagregacionGeografica);
            $obs = preg_replace("/(\n|\r|\n\r)/", ' ', $observaciones);

            echo '              <script>
                                    document.formFicha.dimensionForm.value = "' . $nombreDim . '";
                                    document.formFicha.tematicaForm.value = "' . $nombreTem . '";
                                    document.formFicha.indicadorForm.value = "' . $nombreInd . '";
                                    document.formFicha.siglaForm.value = "' . $sig . '";
                                    document.formFicha.justificacionForm.value = "' . $just . '";
                                    document.formFicha.definicionForm.value = "' . $defi . '";
                                    document.formFicha.metodosMedicionForm.value = "' . $metodosMed . '";
                                    document.formFicha.unidadMedicionForm.value = "' . $unidadMedicion . '";
                                    document.formFicha.formulasForm.value = "' . $form . '";
                                    document.formFicha.variablesForm.value = "' . $vari . '";
                                    document.formFicha.valoresReferenciaForm.value = "' . $valRef . '";
                                    document.formFicha.naturalezaForm.value = "' . $nat . '";
                                    document.formFicha.desagregacionTematicaForm.value = "' . $desGeografica . '";
                                    document.formFicha.desagregacionGeograficaForm.value = "' . $desTematica . '";
                                    document.formFicha.lineaBaseForm.value = "' . $lineaBase . '";
                                    document.formFicha.periodicidadForm.value = "' . $periodicidad . '";
                                    document.formFicha.fuenteDatosForm.value = "' . $fuente . '";
                                    document.formFicha.observacionesForm.value = "' . $obs . '";
                                    document.formFicha.fechaElaboracionForm.value = "' . $fechaElaboracion . '";
                                </script>
                                <form id="formFicha" name="formFicha" action="/views/generar/sis.php" target="_blank" method="post">
                                    <input type="hidden" name="dimensionForm" id="dimensionForm"/>
                                    <input type="hidden" name="tematicaForm" id="tematicaForm"/>
                                    <input type="hidden" name="indicadorForm" id="indicadorForm"/>
                                    <input type="hidden" name="siglaForm" id="siglaForm"/>
                                    <input type="hidden" name="justificacionForm" id="justificacionForm"/>
                                    <input type="hidden" name="definicionForm" id="definicionForm"/>
                                    <input type="hidden" name="metodosMedicionForm" id="metodosMedicionForm"/>
                                    <input type="hidden" name="unidadMedicionForm" id="unidadMedicionForm"/>
                                    <input type="hidden" name="formulasForm" id="formulasForm"/>
                                    <input type="hidden" name="variablesForm" id="variablesForm"/>
                                    <input type="hidden" name="valoresReferenciaForm" id="valoresReferenciaForm"/>
                                    <input type="hidden" name="naturalezaForm" id="naturalezaForm"/>
                                    <input type="hidden" name="desagregacionTematicaForm" id="desagregacionTematicaForm"/>
                                    <input type="hidden" name="desagregacionGeograficaForm" id="desagregacionGeograficaForm"/>
                                    <input type="hidden" name="lineaBaseForm" id="lineaBaseForm"/>
                                    <input type="hidden" name="periodicidadForm" id="periodicidadForm"/>
                                    <input type="hidden" name="fuenteDatosForm" id="fuenteDatosForm"/>
                                    <input type="hidden" name="observacionesForm" id="observacionesForm"/>
                                    <input type="hidden" name="fechaElaboracionForm" id="fechaElaboracionForm"/>
                                    <button type="submit" class="btn bt bt-ripple pdf-buttom" style="background-color:#aa0501; color:#fff;">
                                        <i class="fa fa-file-pdf-o" aria-hidden="true" style="margin-right:10px;"></i>
                                        <b>PDF</b>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';
            if ($tipoConsulta == "ODRAF") {
                echo '
                <div id="fichaEncuesta" class="tab-pane fade in">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <h3 style="text-align:center">' . $nombreIndicador . '</h3>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <embed src="/public/ODRAF/Ficha-técnica-Encuesta-ODRAF-2017.pdf" type="application/pdf" width="100%" height="800px" />
                        </div>
                    </div> 
                </div> 
            </div> 
                    ';
            } else {
                echo '</div>';
            }
        }
    }

    /**
     * <b>consultaIndicadorMultiple</b>
     * <br>
     * Realiza la consulta de un indicador para su visualización en la página, 
     * en los casos que el tipo de gráfico es diferencial
     * @param string $tipoConsulta Categoría de la consulta a realizar
     * @param string $idDimension ID de la dimensión a la que pertenece el indicador a consultar
     * @param string $idTematica ID de la temática a la que pertenece el indicador a consultar
     * @param string $idIndicador ID del indicador a consultar
     * @param string $fuenteC Fuente de datos del indicador a consultar
     * @param string $desagregaciones Desagregaciones temáticas del indicador a consultar
     * @param string $fechas Años del indicador a consultar
     * @param string $zonas Desagregaciones geográficas del indicador a consultar
     */
    public function consultaIndicadorMultiple($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, $desagregaciones, $fechas, $zonas)
    {
        $desagregacionesC = json_decode($desagregaciones);
        $fechasC = json_decode($fechas);
        $zonasC = json_decode($zonas);
        $cons = new ConsultasModel();
        $resp = $cons->consultaIndicador($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, $desagregacionesC, $fechasC, $zonasC);
        if ($resp == 'error') {
            echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <li>Debe seleccionar todos los filtros</li></div>";
        } else {
            $nombreDimension = $resp[0];
            $nombreTematica = $resp[1];
            $nombreIndicador = $resp[2];
            $labels = $resp[3];
            $series = $resp[4];
            $desagregacionesGeograficas = $resp[5];
            $totalDatos = $resp[6];
            $tipoGrafico = $resp[7];
            $data = $resp[8];
            $entidadGeneradora = $resp[9];
            $notas = $resp[10];
            $rango = $resp[11];
            $unidadMedicion = $resp[12];
            $sigla = $resp[13];
            $justificacion = $resp[14];
            $definicion = $resp[15];
            $metodosMedicion = $resp[16];
            $formulas = $resp[17];
            $variables = $resp[18];
            $valoresReferencia = $resp[19];
            $naturaleza = $resp[20];
            $desagregacionTematica = $resp[21];
            $desagregacionGeografica = $resp[22];
            $lineaBase = $resp[23];
            $responsable = $resp[24];
            $observaciones = $resp[25];
            $fechaElaboracion = $resp[26];
            $periodicidad = $resp[27];
            $maxValue = $this->setMaxValue($resp[28]);
            $mapa = $resp[29];
            $fuente = $resp[30];
            echo '
            <div class="row border-consulta">
                <div class="col-xs-12">
                    <h6 style="color:#215a9a;"><b>Resultado de la consulta:</b></h6>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <p style="font-family:Source Sans Pro, sans-serif; font-size:15px;">
                        Dimensión: ' . $nombreDimension . ' <br>
                        Temática: ' . $nombreTematica . ' <br>
                    </p>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <p style="font-family:Source Sans Pro, sans-serif; font-size:15px;">
                        Indicador: ' . $nombreIndicador . ' <br>
                        Desagregaciones geográficas: ' . implode(' - ', $desagregacionesGeograficas) . ' <br>
                    </p>
                </div>
            </div>
            <script>
            	  $("#' . $idDimension . '").addClass("in");            
            	  $("#' . $idTematica . '_cali").addClass("in");            
            	  $("#' . $idIndicador . '").addClass("back-item-menu");            
            </script>';
            if ($tipoConsulta == "PIIA") {
                include 'formConsultaPiia.php';
            } else {
                include 'formConsultaIndicador.php';
            }

            echo '<ul class = "nav nav-tabs">';

            if ($mapa !== "" && $mapa !== NULL) {
                echo '
                    <li class = "active"><a data-toggle = "tab" href = "#mapa">Mapa</a></li>
                    <li><a data-toggle = "tab" href = "#grafico">Gráfico</a></li>';
            } else {
                echo '
                    <li class = "active"><a data-toggle = "tab" href = "#grafico">Gráfico</a></li>';
            }

            if ($tipoConsulta == "ODRAF" && $fuente == "Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali - Secretaría del Deporte y la Recreación") {
                echo '
                <li><a data-toggle="tab" href="#tabla">Tabla</a></li>
                <li><a data-toggle="tab" href="#ficha">Ficha técnica del indicador</a></li>
                <li><a data-toggle="tab" href="#fichaEncuesta">Ficha técnica de la Encuesta</a></li>
            </ul>';
            } else {
                echo '
                <li><a data-toggle="tab" href="#tabla">Tabla</a></li>
                <li><a data-toggle="tab" href="#ficha">Ficha técnica</a></li>
            </ul>';
            }
            echo '
            <div class="tab-content" id="tab-consulta">';

            if ($mapa !== "" && $mapa !== NULL) {
                echo ' 
                <div id="mapa" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12" style="text-align:center; padding-top: 15px;">
                            ' . $mapa . '
                        </div>
                    </div>
                </div>
                 <div id="grafico" class="tab-pane fade in">';
            } else {
                echo ' <div id="grafico" class="tab-pane fade in active">';
            }
            echo '  <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div id="graf" style="background-color:#fff; padding: 0px 15px 10px;">
                                <h3 id="nombreIndicador" style="text-align:center">' . $nombreIndicador . '</h3>
                                <h4 style="text-align:center">' . $rango . '</h4>
                                <div class="canvas-holder">
                                <canvas id="myChart" style="width: 100%;"></canvas>
                                </div>';


            $cons = new ConsultasController();
            $unidadMedicion = ucfirst($unidadMedicion);

            if ($totalDatos == 1 && $tipoGrafico !== "Piramidal" && strpos($tipoGrafico, "Diferencial") !== FALSE) {
                $tipoGrafico = "Barras";
            }
            if ($tipoGrafico == "Barras") {
                echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                echo $cons->drawBarChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                echo '</script>';
            } elseif ($tipoGrafico == "Lineal") {
                echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                echo $cons->drawLineChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                echo '</script>';
            } elseif ($totalDatos > 10 && $tipoGrafico == "Área") {
                echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                echo $cons->drawAreaChart(json_encode($data), $unidadMedicion);
                echo '</script>';
            } elseif ($tipoGrafico == "Treemap") {
                echo $cons->drawTreemap(($data), $unidadMedicion);
            } elseif ($tipoGrafico == "Barras apiladas") {
                echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                echo $cons->drawStackedBarChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                echo '</script>';
            } elseif ($tipoGrafico == "Piramidal") {
                echo '<script> $("#myChart").hide(); $("#form-consulta-indicador").hide(); </script>';
                echo $cons->drawPyramid($data, $unidadMedicion, $idIndicador);
            } else {
                if ($totalDatos <= 10) {
                    echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                    echo $cons->drawBarChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                    echo '</script>';
                } else {
                    echo '
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
                    echo $cons->drawLineChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                    echo '</script>';
                }
            }
            echo '              <hr>
                                <p><strong>Gráfico:</strong> Sistema de Indicadores Sociales</p>
                                <p><strong>Fuente de datos:</strong> ' . $fuente . ' </p>';
            if (sizeof($notas) > 0) {
                echo '          <p style="font-size: smaller;margin:0px;"><strong>Notas:</strong> ' . implode(" - ", $notas) . ' </p>';
            }
            if ($tipoConsulta == "ODRAF" && $fuente == "Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali - Secretaría del Deporte y la Recreación") {
                echo '          <p style="margin:0px;">Este indicador fue calculado con los resultados de la <strong>Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali</strong>, realizada por el Observatorio del Deporte, la Recreación y la Actividad Física.</p>';
                echo '          <p style="margin:0px;">Para descargar la <strong>Ficha técnica de la Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali</strong>, haz clic <a href="/public/ODRAF/Ficha-técnica-Encuesta-ODRAF-2017.pdf" target="_blank"> aquí</a>.</p>';
            }
            echo '          </div>
                        </div>';
            $link = "";
            if ($tipoConsulta == 'General') {
                $link = '/consulta-indicadores/dimensiones-sis/' . $idDimension . '/' . $idTematica . '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
            } elseif ($tipoConsulta == 'Comunas') {
                $link = '/consulta-indicadores/dimensiones-sis-comunas/' . $idDimension . '/' . $idTematica .
                    '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
            } elseif ($tipoConsulta == 'IGC') {
                $link = '/consulta-indicadores/otros-indicadores/igc/=' . $idDimension . '/' . $idTematica .
                    '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
            } elseif ($tipoConsulta == 'PIIA') {
                $link = '/consulta-indicadores/piia/' . $idDimension . '/' . $idTematica .
                    '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
            } elseif ($tipoConsulta == 'ODRAF') {
                $link = '/consulta-indicadores/odraf/' . $idDimension . '/' . $idTematica .
                    '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
            }
            echo '      <input type="text" id="link" hidden readonly value="' . $link . '" style="border:0; font-weight:bold; text-align:left;">';
            echo '   </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <hr>
                            <h4 style="text-align:left">Descargar gráfico</h4>
                            <script>
                                var url = "/views/resources/js/descargarGrafico.js";
                                $.getScript(url);
                            </script>
                            <div class="btn-group" role="group" style="width:100%; margin-bottom: 15px;">
                                <button type="button" id="imagenPng" class="btn bt bt-ripple" style="background-color:#52b1fe; color:#fff;">
                                    <i class="fa fa-file-image-o" aria-hidden="true" style="margin-right:10px;"></i>
                                    <b>PNG</b>
                                </button>
                                <img src="/views/resources/images/loading3.gif" id="loadingPng" style="display: none; margin-left: 10px;"/>
                            </div>
                        </div>
                    </div>
                </div>';
            echo '
                <div id="tabla" class="tab-pane fade in">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <h3 id="nombreIndicador" style="text-align:center">' . $nombreIndicador . '</h3>
                            <h4 style="text-align:center">' . $rango . '</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="centerTable">
                                <table id="tablaDatos" class="table table-striped table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <td colspan="4" style="background-color:#215a9a; color:#fff; text-align:center; visibility:hidden;">' . $nombreIndicador . '</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style = "background-color:#215a9a; color:#fff; text-align:center;">Desagregación geográfica</td>
                                            <td style = "background-color:#215a9a; color:#fff; text-align:center;">Desagregación temática</td>
                                            <td style = "background-color:#215a9a; color:#fff; text-align:center;">Fecha</td>
                                            <td style = "background-color:#215a9a; color:#fff; text-align:center;">' . ucfirst($unidadMedicion) . '</td>
                                        </tr>';
            for ($l = 0; $l < count($series); $l++) {
                $serie2 = $series[$l][0];
                $desTematica = $series[$l][1];
                $desGeografica = $series[$l][2];
                foreach ($labels as $row => $fecha) {
                    $dat = new Datos();
                    $dato = $dat->consultarInfoDatoPorIdSerieFecha($serie2, $fecha);
                    echo '
                                        <tr>
                                            <td style="text-align:center;">' . $desGeografica . '</td>
                                            <td style="text-align:center;">' . $desTematica . '</td>
                                            <td style="text-align:center;">' . $fecha . '</td>
                                            <td style="text-align:right;">';

                    $value = $dato[2];
                    $countDecimals = strlen(substr(strrchr($value, "."), 1));

                    if ($countDecimals > 0) {
                        settype($value, "Float");
                    } else {
                        settype($value, "Int");
                    }

                    if (strpos($nombreIndicador, "PIB Per cápita") !== false) {
                        echo '$' . number_format($dato[2], 2, ".", ",");
                    } elseif (
                        strpos($nombreIndicador, "GINI") !== false ||
                        strpos($nombreIndicador, "Toneladas de residuos sólidos") !== false ||
                        strpos($nombreIndicador, "Tasa de crecimiento de la población") !== false
                    ) {
                        echo number_format($dato[2], 2, ".", ",");
                    } elseif (strpos($nombreIndicador, "PIB Per cápita") !== false) {
                        echo '$' . number_format($dato[2], 2, ".", ",");
                    } else {
                        if (is_float($value)) {
                            echo number_format($value, 2, ".", ",");
                        } else {
                            echo number_format($value, 0, ".", ",");
                        }
                    }
                    echo '                  </td>
                                        </tr>';
                }
            }
            echo '                  </tbody>
                                </table>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <p><strong>Tabla:</strong> Sistema de Indicadores Sociales</p>
                            <p><strong>Fuente de datos:</strong> ' . $fuente . '</p>';
            if (sizeof($notas) > 0) {
                echo '      <p style="font-size: smaller;"><strong>Notas:</strong> ' . implode(" - ", $notas) . ' </p>';
            }
            if ($tipoConsulta == "ODRAF") {
                echo '          <p style="margin:0px;">Para descargar la <strong>Ficha técnica de la Encuesta municipal de deporte, recreación y actividad física de Santiago de Cali</strong>, haz clic <a href="/public/ODRAF/Ficha-técnica-Encuesta-ODRAF-2017.pdf" target="_blank"> aquí</a>.</p>';
            }

            echo "          <hr>
                            <h4 style='text-align:left'>Descargar datos</h4>
                            <div class='btn-group' role='group' style='width:100%; margin-bottom: 15px;'>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#2ECC71; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'csv', fileName: '$nombreIndicador'});" . '"' . ">
                                    <i class='fa fa-file-archive-o' aria-hidden='true' style='margin-right:10px;'></i>
                                    <b>CSV</b>                                                           
                                </button>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#1E8449; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'excel', fileName: '$nombreIndicador', excelFileFormat: 'xlsx', worksheetName: '.$nombreIndicador.'});" . '"' . ">
                                    <i class='fa fa-file-excel-o' aria-hidden='true' style='margin-right:10px;'></i>                                                
                                    <b>XLS</b>
                                </button>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#9777a8; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'json', fileName: '$nombreIndicador'});" . '"' . ">
                                    <i class='fa fa-file-text-o' aria-hidden='true' style='margin-right:10px;'></i>
                                    <b>JSON</b>                                                           
                                </button>
                            </div>
                        </div>
                    </div>";
            echo '
                </div>
                <div id="ficha" class="tab-pane fade in">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <h3 style="text-align:center">' . $nombreIndicador . '</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="centerTable">
                                <table id="tablaFicha" class="table table-striped" style="text-align:center">
                                    <tbody style="width:100%;">
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Dimensión</td>
                                            <td style="text-align:left;">' . $nombreDimension . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Temática</td>
                                            <td style="text-align:left;">' . $nombreTematica . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Indicador</td>
                                            <td style="text-align:left;">' . $nombreIndicador . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Sigla</td>
                                            <td style="text-align:left;">' . $sigla . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Justificación</td>
                                            <td style="text-align:left;">' . $justificacion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Definiciones y conceptos</td>
                                            <td style="text-align:left;">' . $definicion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Método de medición</td>
                                            <td style="text-align:left;">' . $metodosMedicion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Unidad de medida</td>
                                            <td style="text-align:left;">' . $unidadMedicion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Fórmulas</td>
                                            <td style="text-align:left;">' . $formulas . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Variables</td>
                                            <td style="text-align:left;">' . $variables . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Valores de referencia</td>
                                            <td style="text-align:left;">' . $valoresReferencia . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Naturaleza</td>
                                            <td style="text-align:left;">' . $naturaleza . '</td>
                                        </tr>                                            
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Desagregación temática</td>
                                            <td style="text-align:left;">' . $desagregacionTematica . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Desagregación geográfica</td>
                                            <td style="text-align:left;">' . $desagregacionGeografica . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Línea base</td>
                                            <td style="text-align:left;">' . $lineaBase . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Periodicidad</td>
                                            <td style="text-align:left;">' . $periodicidad . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Fuente de datos</td>
                                            <td style="text-align:left;">' . $fuente . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Observaciones</td>
                                            <td style="text-align:left;">' . $observaciones . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Fecha de elaboración</td>
                                            <td style="text-align:left;">' . $fechaElaboracion . '</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <p><strong>Ficha técnica:</strong> Sistema de Indicadores Sociales</p>
                            <hr>
                            <h4 style="text-align:left">Descargar ficha técnica</h4>';
            echo "          <div class='btn-group' role='group' style='width:100%; margin-bottom: 15px;'>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#1E8449; color:#fff;' onClick =" . '"' . "$('#tablaFicha').tableExport({type: 'excel', fileName: '.$nombreIndicador.', excelFileFormat: 'xlsx', worksheetName: '.$nombreIndicador.'});" . '"' . ">
                                    <i class='fa fa-file-excel-o' aria-hidden='true' style='margin-right:10px;'></i>                                                
                                    <b>XLS</b>
                                </button>";
            if ($formulas == "") {
                $formulas = "_____";
            }
            if ($variables == "") {
                $variables = "_____";
            }
            if ($valoresReferencia == "") {
                $valoresReferencia = "_____";
            }
            if ($desagregacionTematica == "") {
                $desagregacionTematica = "_____";
            }
            if ($desagregacionGeografica == "") {
                $desagregacionGeografica = "_____";
            }
            if ($observaciones == "") {
                $observaciones = "_____";
            }
            $nombreDim = preg_replace("/(\n|\r|\n\r)/", ' ', $nombreDimension);
            $nombreTem = preg_replace("/(\n|\r|\n\r)/", ' ', $nombreTematica);
            $nombreInd = preg_replace("/(\n|\r|\n\r)/", ' ', $nombreIndicador);
            $sig = preg_replace("/(\n|\r|\n\r)/", ' ', $sigla);
            $just = preg_replace("/(\n|\r|\n\r)/", ' ', $justificacion);
            $defi = preg_replace("/(\n|\r|\n\r)/", ' ', $definicion);
            $metodosMed = preg_replace("/(\n|\r|\n\r)/", ' ', $metodosMedicion);
            $nat = preg_replace("/(\n|\r|\n\r)/", ' ', $naturaleza);
            $form = preg_replace("/(\n|\r|\n\r)/", ' ', $formulas);
            $vari = preg_replace("/(\n|\r|\n\r)/", ' ', $variables);
            $valRef = preg_replace("/(\n|\r|\n\r)/", ' ', $valoresReferencia);
            $desGeografica = preg_replace("/(\n|\r|\n\r)/", ' ', $desagregacionTematica);
            $desTematica = preg_replace("/(\n|\r|\n\r)/", ' ', $desagregacionGeografica);
            $obs = preg_replace("/(\n|\r|\n\r)/", ' ', $observaciones);

            echo '              <script>
                                    document.formFicha.dimensionForm.value = "' . $nombreDim . '";
                                    document.formFicha.tematicaForm.value = "' . $nombreTem . '";
                                    document.formFicha.indicadorForm.value = "' . $nombreInd . '";
                                    document.formFicha.siglaForm.value = "' . $sig . '";
                                    document.formFicha.justificacionForm.value = "' . $just . '";
                                    document.formFicha.definicionForm.value = "' . $defi . '";
                                    document.formFicha.metodosMedicionForm.value = "' . $metodosMed . '";
                                    document.formFicha.unidadMedicionForm.value = "' . $unidadMedicion . '";
                                    document.formFicha.formulasForm.value = "' . $form . '";
                                    document.formFicha.variablesForm.value = "' . $vari . '";
                                    document.formFicha.valoresReferenciaForm.value = "' . $valRef . '";
                                    document.formFicha.naturalezaForm.value = "' . $nat . '";
                                    document.formFicha.desagregacionTematicaForm.value = "' . $desGeografica . '";
                                    document.formFicha.desagregacionGeograficaForm.value = "' . $desTematica . '";
                                    document.formFicha.lineaBaseForm.value = "' . $lineaBase . '";
                                    document.formFicha.periodicidadForm.value = "' . $periodicidad . '";
                                    document.formFicha.fuenteDatosForm.value = "' . $fuente . '";
                                    document.formFicha.observacionesForm.value = "' . $obs . '";
                                    document.formFicha.fechaElaboracionForm.value = "' . $fechaElaboracion . '";
                                </script>
                                <form id="formFicha" name="formFicha" action="/views/generar/sis.php" target="_blank" method="post">
                                    <input type="hidden" name="dimensionForm" id="dimensionForm"/>
                                    <input type="hidden" name="tematicaForm" id="tematicaForm"/>
                                    <input type="hidden" name="indicadorForm" id="indicadorForm"/>
                                    <input type="hidden" name="siglaForm" id="siglaForm"/>
                                    <input type="hidden" name="justificacionForm" id="justificacionForm"/>
                                    <input type="hidden" name="definicionForm" id="definicionForm"/>
                                    <input type="hidden" name="metodosMedicionForm" id="metodosMedicionForm"/>
                                    <input type="hidden" name="unidadMedicionForm" id="unidadMedicionForm"/>
                                    <input type="hidden" name="formulasForm" id="formulasForm"/>
                                    <input type="hidden" name="variablesForm" id="variablesForm"/>
                                    <input type="hidden" name="valoresReferenciaForm" id="valoresReferenciaForm"/>
                                    <input type="hidden" name="naturalezaForm" id="naturalezaForm"/>
                                    <input type="hidden" name="desagregacionTematicaForm" id="desagregacionTematicaForm"/>
                                    <input type="hidden" name="desagregacionGeograficaForm" id="desagregacionGeograficaForm"/>
                                    <input type="hidden" name="lineaBaseForm" id="lineaBaseForm"/>
                                    <input type="hidden" name="periodicidadForm" id="periodicidadForm"/>
                                    <input type="hidden" name="fuenteDatosForm" id="fuenteDatosForm"/>
                                    <input type="hidden" name="observacionesForm" id="observacionesForm"/>
                                    <input type="hidden" name="fechaElaboracionForm" id="fechaElaboracionForm"/>
                                    <button type="submit" class="btn bt bt-ripple pdf-buttom" style="background-color:#aa0501; color:#fff;">
                                        <i class="fa fa-file-pdf-o" aria-hidden="true" style="margin-right:10px;"></i>
                                        <b>PDF</b>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';
            if ($tipoConsulta == "ODRAF") {
                echo '
                <div id="fichaEncuesta" class="tab-pane fade in">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <h3 style="text-align:center">' . $nombreIndicador . '</h3>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <embed src="/public/ODRAF/Ficha-técnica-Encuesta-ODRAF-2017.pdf" type="application/pdf" width="100%" height="800px" />
                        </div>
                    </div> 
                </div> 
            </div> 
                    ';
            } else {
                echo '</div>';
            }
        }
    }

    /**
     * <b>consultaIndicadorODSController</b>
     * <br>
     * Realiza la consulta de un indicador de los Objetivos de Desarrollo Sostenible, 
     * para su visualización en la página.
     * @param string $tipoConsulta Categoría de la consulta a realizar
     * @param string $idDimension ID de la dimensión a la que pertenece el indicador a consultar
     * @param string $idTematica ID de la temática a la que pertenece el indicador a consultar
     * @param string $idIndicador ID del indicador a consultar
     * @param string $fuenteC Fuente de datos del indicador a consultar
     * @param string $desagregaciones Desagregaciones temáticas del indicador a consultar
     * @param string $fechas Años del indicador a consultar
     * @param string $zonas Desagregaciones geográficas del indicador a consultar
     */
    public function consultaIndicadorODSController($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, $desagregaciones, $fechas, $zonas)
    {
        $desagregacionesC = json_decode($desagregaciones);
        $fechasC = json_decode($fechas);
        $zonasC = json_decode($zonas);
        $consM = new ConsultasModel();
        $resp = $consM->consultaIndicadorODS($tipoConsulta, $idDimension, $idTematica, $idIndicador, $fuenteC, $desagregacionesC, $fechasC, $zonasC);
        if ($resp == 'error') {
            echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <li>Debe seleccionar todos los filtros</li></div>";
        } else {
            $nombreDimension = $resp[0];
            $nombreTematica = $resp[1];
            $nombreIndicador = $resp[2];
            $labels = $resp[3];
            $series = $resp[4];
            $desagregacionesGeograficas = $resp[5];
            $totalDatos = $resp[6];
            $tipoGrafico = $resp[7];
            $data = $resp[8];
            $entidadGeneradora = $resp[9];
            $notas = $resp[10];
            $rango = $resp[11];
            $unidadMedicion = $resp[12];
            $sigla = $resp[13];
            $justificacion = $resp[14];
            $definicion = $resp[15];
            $metodosMedicion = $resp[16];
            $formulas = $resp[17];
            $variables = $resp[18];
            $valoresReferencia = $resp[19];
            $naturaleza = $resp[20];
            $desagregacionTematica = $resp[21];
            $desagregacionGeografica = $resp[22];
            $lineaBase = $resp[23];
            $responsable = $resp[24];
            $observaciones = $resp[25];
            $fechaElaboracion = $resp[26];
            $periodicidad = $resp[27];
            $maxValue = $this->setMaxValue($resp[28]);
            $mapa = $resp[29];
            $fuente = $resp[30];
            $datasets = $resp[31];

            $dim = new Dimensiones();
            $tem = new Tematicas();
            $ind = new Indicadores();
            $ser = new SeriesDatos();
            $vis = new ConsultasVisualizadoresModel();
            $dimension = $dim->consultarDimensionPorId($idDimension);
            $tematica = $tem->consultarTematicaPorId($idTematica);
            $indicador = $ind->consultarIndicadorPorId($idIndicador);
            $idProveniencia = $vis->consultarIdAtributoPorNombreYConjunto('Proveniencia del Indicador', $tipoConsulta)['idAtributo'];
            $idComportamiento = $vis->consultarIdAtributoPorNombreYConjunto('Comportamiento esperado del Indicador', $tipoConsulta)['idAtributo'];
            $proveniencia = $vis->consultarElementoPorIdElementoPadreYIAdAtributo($idIndicador, $idProveniencia)['valorElemento'];
            $comportamiento = $vis->consultarElementoPorIdElementoPadreYIAdAtributo($idIndicador, $idComportamiento)['valorElemento'];
            $descripcionTematica = $tematica["descripcionTematica"];
            $descripcionIndicador = $indicador["descripcionIndicador"];
            echo '
            <div class="row border-consulta" style="padding-bottom:0px !important;">
                <div class = "col-xs-12 col-sm-3">
                    <img alt="' . $nombreDimension . '" style="width: 100%;margin: 15px 0px;"
                    src="' . $dimension["icono"] . '">
                </div>
                <div class="col-xs-12 col-sm-9">
                    <h4 style="font-weight:bold;">' . $nombreDimension . '</h4>
                    <h5 style="font-weight:bold;">' . $nombreTematica . ':</h5>
                    <p style="font-family:Source Sans Pro, sans-serif; font-size:15px;">
                    ' . $descripcionTematica . '
                    </p>
                    <h5 style="font-weight:bold;">Indicador:</h5>
                    <p style="font-family:Source Sans Pro, sans-serif; font-size:15px;">
                    ' . $nombreIndicador . '
                    </p>
                </div>
            </div>
            <script>
             $("#' . $idDimension . '").addClass("in");            
             $("#' . $idTematica . '_cali").addClass("in");            
             $("#' . $idIndicador . '").addClass("back-item-menu");            
            </script>';
            echo '
            <div class="row">
                <div class="col-xs-12 col-sm-8" style="padding:10px;margin-left:-10px;">
                    <ul class = "nav nav-tabs">';
            if ($mapa !== "" && $mapa !== NULL) {
                echo '
                        <li class = "active"><a data-toggle = "tab" href = "#mapa">Mapa</a></li>
                        <li><a data-toggle = "tab" href = "#grafico">Gráfico</a></li>';
            } else {
                echo '
                        <li class = "active"><a data-toggle = "tab" href = "#grafico">Gráfico</a></li>';
            }
            echo '
                        <li><a data-toggle = "tab" href = "#tabla">Tabla</a></li>
                        <li><a data-toggle = "tab" href = "#ficha">Ficha técnica</a></li>
                    </ul>
                    <div class="tab-content" id="tab-consulta">';
            if ($mapa !== "" && $mapa !== NULL) {
                echo '
                        <div id="mapa" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12" style="text-align:center; padding-top: 15px;">
                                    ' . $mapa . '
                                </div>
                            </div>
                        </div>
                        <div id="grafico" class="tab-pane fade in">';
            } else {
                echo '  <div id="grafico" class="tab-pane fade in active">';
            }
            echo '          <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <div id="graf" style="background-color:#fff; padding: 0px 15px 10px;">
                                        <h3 id="nombreIndicador" style="text-align:center">' . $nombreIndicador . '</h3>
                                        <h4 style="text-align:center">' . $rango . '</h4>
                                        <canvas id="myChart"></canvas>';
            $cons = new ConsultasController();

            $this->drawLineChartODSMaxValue($datasets, $labels, $unidadMedicion, $maxValue);

            echo '              <hr>
                                        <p style="font-size: 13px;"><strong>Gráfico:</strong> Sistema de Indicadores Sociales</p>
                                        <p style="font-size: 13px;"><strong>Fuente de datos:</strong> ' . $fuente . ' </p>';
            if (sizeof($notas) > 0) {
                echo '                  <p style="margin:0px; font-size: 13px";><strong>Nota:</strong> ' . implode(" - ", $notas) . ' </p>';
            }
            echo '                  </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <hr>
                                    <h4 style="text-align:left">Descargar gráfico</h4>
                                    <script>
                                        var url = "/views/resources/js/descargarGrafico.js";
                                        $.getScript(url);
                                    </script>
                                    <div class="btn-group" role="group" style="width:100%; margin-bottom: 15px;">
                                        <button type="button" id="imagenPng" class="btn bt bt-ripple" style="background-color:#52b1fe; color:#fff;">
                                            <i class="fa fa-file-image-o" aria-hidden="true" style="margin-right:10px;"></i>
                                            <b>PNG</b>
                                        </button>
                                        <img src="/views/resources/images/loading.gif" id="loadingPng" style="display: none; margin-left: 10px;"/>
                                    </div>
                                </div>
                            </div>
                        </div>';
            echo '
                        <div id="tabla" class="tab-pane fade in">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <h3 id="nombreIndicador" style="text-align:center">' . $nombreIndicador . '</h3>
                                    <h4 style="text-align:center">' . $rango . '</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <div class="centerTable">
                                        <table id="tablaDatos" class="table table-striped table-bordered table-hover table-responsive">
                                            <thead>
                                                <tr>
                                                    <td colspan="4" style="background-color:#215a9a; color:#fff; text-align:center; visibility:hidden;">' . $nombreIndicador . '</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style = "background-color:#215a9a; color:#fff; text-align:center;">Desagregación geográfica</td>
                                                    <td style = "background-color:#215a9a; color:#fff; text-align:center;">Desagregación temática</td>
                                                    <td style = "background-color:#215a9a; color:#fff; text-align:center;">Fecha</td>
                                                    <td style = "background-color:#215a9a; color:#fff; text-align:center;">' . ucfirst($unidadMedicion) . '</td>
                                                </tr>';
            for ($l = 0; $l < count($series); $l++) {
                $serie2 = $series[$l][0];
                $desTematica = $series[$l][1];
                $desGeografica = $series[$l][2];
                foreach ($labels as $row => $fecha) {
                    $dat = new Datos();
                    $dato = $dat->consultarInfoDatoPorIdSerieFecha($serie2, $fecha);
                    if ($dato != false) {


                        echo '
                                                <tr>
                                                    <td style="text-align:center;">' . $desGeografica . '</td>
                                                    <td style="text-align:center;">' . $desTematica . '</td>
                                                    <td style="text-align:center;">' . $fecha . '</td>
                                                    <td style="text-align:right;">';
                        if (strpos($nombreIndicador, "PIB Per cápita") !== false) {
                            echo '$' . number_format($dato[2], 2, ".", ",");
                        } else if (ctype_digit(strval($dato[2]))) {
                            echo number_format($dato[2], 2, ".", ",");
                        } else {
                            if (
                                strpos($nombreIndicador, "GINI") !== false ||
                                strpos($nombreIndicador, "Toneladas de residuos sólidos") !== false ||
                                strpos($nombreIndicador, "Tasa de crecimiento de la población") !== false
                            ) {
                                echo number_format($dato[2], 2, ".", ",");
                            } elseif (strpos($nombreIndicador, "PIB Per cápita") !== false) {
                                echo '$' . number_format($dato[2], 2, ".", ",");
                            } else {
                                echo number_format($dato[2], 2, ".", ",");
                            }
                        }
                        echo '                          </td>
                                                </tr>';
                    }
                }
            }
            echo '                          </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <p style="font-size: 13px;"><strong>Tabla:</strong> Sistema de Indicadores Sociales</p>
                                    <p style="font-size: 13px;"><strong>Fuente de datos:</strong> ' . $fuente . '</p>';
            if (sizeof($notas) > 0) {
                echo '              <p style="font-size: 13px;"><strong>Nota:</strong> ' . implode(" - ", $notas) . ' </p>';
            }
            echo "                  <hr>
                                    <h4 style='text-align:left'>Descargar datos</h4>
                                    <div class='btn-group' role='group' style='width:100%; margin-bottom: 15px;'>
                                        <button type='button' class='btn bt bt-ripple' style='background-color:#2ECC71; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'csv', fileName: '$nombreIndicador'});" . '"' . ">
                                            <i class='fa fa-file-archive-o' aria-hidden='true' style='margin-right:10px;'></i>
                                            <b>CSV</b>                                                          
                                        </button>
                                        <button type='button' class='btn bt bt-ripple' style='background-color:#1E8449; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'excel', fileName: '$nombreIndicador', excelFileFormat: 'xlsx', worksheetName: '.$nombreIndicador.'});" . '"' . ">
                                            <i class='fa fa-file-excel-o' aria-hidden='true' style='margin-right:10px;'></i>                                                
                                            <b>XLS</b>
                                        </button>
                                        <button type='button' class='btn bt bt-ripple' style='background-color:#9777a8; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'json', fileName: '$nombreIndicador'});" . '"' . ">
                                            <i class='fa fa-file-text-o' aria-hidden='true' style='margin-right:10px;'></i>
                                            <b>JSON</b>                                                          
                                        </button>
                                    </div>
                                </div>
                            </div>";
            $nombreTematica = $nombreTematica . '<br>' . $descripcionTematica;
            $nombreIndicador2 = $nombreIndicador;
            $nombreIndicador = $nombreIndicador . '<br>' . $descripcionIndicador;
            $informacionFicha = [
                'nombreDimension',
                'nombreTematica',
                'nombreIndicador',
                'sigla',
                'justificacion'
                ,
                'definicion',
                'metodosMedicion',
                'unidadMedicion',
                'formulas',
                'variables',
                'valoresReferencia'
                ,
                'naturaleza',
                'desagregacionTematica',
                'desagregacionGeografica',
                'lineaBase',
                'periodicidad'
                ,
                'fuente',
                'observaciones',
                'fechaElaboracion'
            ];

            for ($i = 0; $i < count($informacionFicha); $i++) {
                $valor = $informacionFicha[$i];
                if (${$valor} == "") {
                    ${$valor} = "_____";
                } else {
                    ${$valor} = preg_replace("/(\n|\r|\n\r)/", ' ', ${$valor});
                }
            }
            echo '
                        </div>
                        <div id="ficha" class="tab-pane fade in">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <h3 style="text-align:center">' . $nombreIndicador2 . '</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <div class="centerTable">
                                        <table id="tablaFicha" class="table table-striped" style="text-align:center">
                                            <tbody style="width:100%;">
                                                <tr>
                                                    <td style="background-color:#215a9a; color:#fff; text-align:center;">Objetivo</td>
                                                    <td style="text-align:left;">' . $nombreDimension . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color:#215a9a; color:#fff; text-align:center;">Meta</td>
                                                    <td style="text-align:left;">' . $nombreTematica . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color:#215a9a; color:#fff; text-align:center;">Indicador</td>
                                                    <td style="text-align:left;">' . $nombreIndicador . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color:#215a9a; color:#fff; text-align:center;">Descripción del indicador</td>
                                                    <td style="text-align:left;">' . $definicion . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color:#215a9a; color:#fff; text-align:center;">Unidad de medición</td>
                                                    <td style="text-align:left;">' . $unidadMedicion . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color:#215a9a; color:#fff; text-align:center;">Método de cálculo</td>
                                                    <td style="text-align:left;">' . $metodosMedicion . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color:#215a9a; color:#fff; text-align:center;">Línea base</td>
                                                    <td style="text-align:left;">' . $lineaBase . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color:#215a9a; color:#fff; text-align:center;">Periodicidad</td>
                                                    <td style="text-align:left;">' . $periodicidad . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color:#215a9a; color:#fff; text-align:center;">Fuente de datos</td>
                                                    <td style="text-align:left;">' . $fuente . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color:#215a9a; color:#fff; text-align:center;">Fecha de elaboración</td>
                                                    <td style="text-align:left;">' . $fechaElaboracion . '</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <p style="font-size: 13px;"><strong>Ficha técnica:</strong> Sistema de Indicadores Sociales</p>
                                    <hr>
                                    <h4 style="text-align:left">Descargar ficha técnica</h4>';
            echo "                  <div class='btn-group' role='group' style='width:100%; margin-bottom: 15px;'>
                                        <button type='button' class='btn bt bt-ripple' style='background-color:#1E8449; color:#fff;' onClick =" . '"' . "$('#tablaFicha').tableExport({type: 'excel', fileName: '.$nombreIndicador.', excelFileFormat: 'xlsx', worksheetName: '.$nombreIndicador.'});" . '"' . ">
                                            <i class='fa fa-file-excel-o' aria-hidden='true' style='margin-right:10px;'></i>                                                
                                            <b>XLS</b>
                                        </button>";
            echo '          
                                        <form id="formFicha" name="formFicha" action="/views/generar/ods.php" target="_blank" method="post">
                                           ';
            for ($j = 0; $j < count($informacionFicha); $j++) {
                $valor = $informacionFicha[$j];
                echo "<input hidden type='text' name='" . $valor . "' id='" . $valor . "' value='" . ${$valor} . "'/>";
            }
            $cptmto = explode(',', $comportamiento);
            echo '<button type="submit" class="btn bt bt-ripple pdf-buttom" style="background-color:#aa0501; color:#fff;">
                                                <i class="fa fa-file-pdf-o" aria-hidden="true" style="margin-right:10px;"></i>
                                                <b>PDF</b>                                                          
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 border-consulta" style="margin-left: 10px;">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <h6 style="color:#215a9a;font-weight:bold;">Proveniencia del indicador:</h6>
                            <p>' . $proveniencia . '</p>
                            <h6 style="color:#215a9a;font-weight:bold;">Comportamiento esperado:</h6>
                            <p>' . $cptmto[0] . '</p>
                        </div>
                    </div>';

            $idSerieTotal = $ser->consultarIdSeriePorIdIndicadorDesagregacionTematica($idIndicador, "Total")['idSerieDatos'];
            $idSerieLineaBase = $ser->consultarIdSeriePorIdIndicadorDesagregacionTematica($idIndicador, "Línea Base")['idSerieDatos'];
            $vigenciasCumplimiento = ['2019', '2023', '2027', '2030'];
            $vlr2015 = $dat->consultarDatoPorIdSerieFecha($idSerieTotal, 2015)['valorDato'];
            $valor2015 = number_format($vlr2015, 2, ".", ",");
            // $vlr2021 = $dat->consultarDatoPorIdSerieFecha($idSerieTotal, 2021)['valorDato'];
            $vlr2021 = (isset($dat->consultarDatoPorIdSerieFecha($idSerieTotal, 2021)['valorDato'])) ? $dat->consultarDatoPorIdSerieFecha($idSerieTotal, 2021)['valorDato'] : "nd";
            $vlr2019 = $dat->consultarDatoPorIdSerieFecha($idSerieTotal, 2019)['valorDato'];
            if ($vlr2021 == "" || $vlr2021 == NULL || $vlr2021 == "nd") {
                $valor2021 = "nd";
            } else {
                $valor2021 = number_format($vlr2021, 2, ".", ",");
            }
            if ($vlr2019 == "" || $vlr2019 == NULL) {
                $valor2019 = "nd";
            } else {
                $valor2019 = number_format($vlr2019, 2, ".", ",");
            }
            $vlr2030 = $dat->consultarDatoPorIdSerieFecha($idSerieLineaBase, 2030)['valorDato'];
            $valor2030 = number_format($vlr2030, 2, ".", ",");
            if (count($cptmto) > 1) {
                if ($cptmto[1] == ' Operador logico') {
                    $valor2030 = '<' . $valor2030;
                }
            }
            echo '
                    <div class="row" style="margin-top: 15px;">
                        <div class="col-xs-12 col-sm-12">
                            <div class="centerTable">
                                <table id="tablaDatos" class="table table-striped table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">
                                                Línea base 2015
                                            </td>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">
                                                Meta a 2030
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style = "text-align:center;">' . $valor2015 . '</td>
                                            <td style = "text-align:center;">' . $valor2030 . '</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 15px;">
                        <div class="col-xs-12 col-sm-12">
                            <div class="centerTable">
                                <table id="tablaDatos" class="table table-striped table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">
                                                Valor logrado a 2019
                                            </td>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">
                                                Valor logrado a 2021
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style = "text-align:center;">' . $valor2019 . '</td>
                                            <td style = "text-align:center;">' . $valor2021 . '</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    ';

            if ($valor2021 !== 'nd') {

                echo '
                    <style>
                        .verticalText {writing-mode: vertical-lr;transform: rotate(180deg);}
                    </style>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="centerTable">
                                <table id="tablaDatos" class="table table-striped table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <td>
                                            </td>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">
                                                Meta esperada
                                            </td>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;vertical-align: middle;">
                                                Cumplimiento %
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     ';
                for ($m = 0; $m < count($vigenciasCumplimiento); $m++) {
                    $anhoVigencia = $vigenciasCumplimiento[$m];
                    $metaVigencia = $dat->consultarDatoPorIdSerieFecha($idSerieLineaBase, $anhoVigencia)['valorDato'];
                    if ($anhoVigencia === "2019") {
                        $cumplimiento = $this->calcularCumplimientoIndicador($valor2015, $valor2019, $metaVigencia, $comportamiento);

                        $graf = [
                            "datasets" => [
                                [
                                    "label" => "2019",
                                    "backgroundColor" => $consM->selectColor(),
                                    "fill" => TRUE,
                                    "data" => ["$cumplimiento"]
                                ]
                            ]
                        ];

                    } else {
                        $cumplimiento = $this->calcularCumplimientoIndicador($valor2015, $valor2021, $metaVigencia, $comportamiento);

                        $graf = [
                            "datasets" => [
                                [
                                    "label" => "2021",
                                    "backgroundColor" => $consM->selectColor(),
                                    "fill" => TRUE,
                                    "data" => ["$cumplimiento"]
                                ]
                            ]
                        ];
                    }
                    $mtVigencia = number_format($metaVigencia, 2, ".", ",");
                    if (count($cptmto) > 1) {
                        if ($cptmto[1] == ' Operador logico') {
                            $mtVigencia = '<' . number_format($metaVigencia, 2, ".", ",");
                        }
                    }
                    echo '                  <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;"><p class="verticalText">' . $anhoVigencia . '</p></td>
                                            <td style = "text-align:center;">' . $mtVigencia . '</td>
                                            <td style = "text-align:center;">
                                                <canvas id="grafico_cumplimiento_' . $anhoVigencia . '" style="width:150px;"></canvas>
                                                <script>
                                                    var ctx = document.getElementById("grafico_cumplimiento_' . $anhoVigencia . '").getContext("2d");';
                    echo $cons->drawBarChartMaxValueODS(json_encode($graf));
                    echo '                          </script>
                                                <BR>
                                            </td>                              
                                        </tr>';
                }
                echo '                  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
            }
        }
    }

    /**
     * <b>calcularCumplimientoIndicador</b>
     * <br>
     * Realiza el cálculo del porcentaje de cumplimiento de un indicador, a partir 
     * de la línea base y los valores logrados y programados para la vigencia
     * @param float $lineaBase Valor del indicador para el 2015
     * @param float $valorLogradoVigencia Valor logrado en la vigencia a la 
     * que se le medirá el cumplimiento
     * @param float $valorProgramadoVigencia Valor programado en la vigencia 
     * a la que se le medirá el cumplimiento
     * @param string $comportamiento Comportamiento esperado del indicador. 
     * Puede ser creciente o decreciente
     * @return float Porcentaje de cumplimiento de un indicador
     */
    public function calcularCumplimientoIndicador($lineaBase, $valorLogradoVigencia, $valorProgramadoVigencia, $comportamiento)
    {

        $cptmto = explode(",", $comportamiento);
        if (count($cptmto) > 1) {
            if ($cptmto[1] == ' Operador lógico') {
                $comportamiento = 'Operador lógico';
            }
        }
        $cumplimiento = 0;
        if ($comportamiento == "Decreciente") {

            // if($lineaBase > 1){ 
            //     $valorProgramadoVigencia=intval($valorProgramadoVigencia);
            //     $lineaBase =intval($lineaBase);
            //     $valorLogradoVigencia =intval($valorLogradoVigencia);
            // }

            if (($lineaBase - $valorProgramadoVigencia) === 0) {
                $cumplimiento = 0;
            } else {
                $cumplimiento = (($lineaBase - $valorLogradoVigencia) / ($lineaBase - $valorProgramadoVigencia)) * 100;
                // var_dump($lineaBase,$valorLogradoVigencia,$valorProgramadoVigencia);
            }
        } elseif ($comportamiento == "Creciente") {
            // if ($valorProgramadoVigencia < $lineaBase) {
            //     $cumplimiento = 0;
            // } else {
            if (($valorProgramadoVigencia - $lineaBase) == 0) {
                $cumplimiento = 100;
            } else {
                $cumplimiento = (($valorLogradoVigencia - $lineaBase) / ($valorProgramadoVigencia - $lineaBase)) * 100;
            }
            // }
        } elseif ($comportamiento == "Operador lógico") {
            if ($valorLogradoVigencia < $valorProgramadoVigencia) {
                $cumplimiento = 100;
            } else {
                $cumplimiento = 0;
            }
        } elseif ($comportamiento == "Mantenimiento") {
            $cumplimiento = ($valorLogradoVigencia / $valorProgramadoVigencia) * 100;
        }
        if ($cumplimiento < 0 && $comportamiento != 'Creciente') {
            $cumplimiento = 0;
        } elseif ($cumplimiento === 100 || $cumplimiento > 100) {
            $cumplimiento = 100;
        }
        if ($cumplimiento === 0) {
            $cumplimiento = 1.543210123456;
        }
        return $cumplimiento;
    }

    /**
     * <b>consultarEjecucionPresupuestalODS</b>
     * <br>
     * Realiza la consulta de la ejecución presupuestal en cada uno de los
     * Objetivos de Desarrollo Sostenible, para el cuatrenio 2016 - 2019
     */
    public function consultarEjecucionPresupuestalODS()
    {
        $idConjuntoIndicadores = 'ODS';
        $dim = new Dimensiones();
        $vis = new ConsultasVisualizadoresModel();
        $idAtributo = $vis->consultarIdAtributoPorNombreYConjunto('Ejecución presupuestal del cuatrenio 2016 - 2019', $idConjuntoIndicadores)['idAtributo'];
        $ejecuciones = array();
        $infoObjetivos = array();
        $colores = array();
        $nombres = array();
        $objetivos = $dim->consultarDimensionesPorConjuntoIndicadores($idConjuntoIndicadores);
        for ($i = 0; $i < count($objetivos); $i++) {
            $objetivo = $objetivos[$i];
            $idObjetivo = $objetivo['idDimension'];
            $nombreObjetivo = $objetivo['nombreDimension'];
            $colorObjetivo = $objetivo['color'];
            // var_dump($idObjetivo, $idAtributo);
            $valorEjecucion = ($vis->consultarElementoPorIdElementoPadreYIAdAtributo($idObjetivo, $idAtributo)['valorElemento']);
            // var_dump($valorEjecucion);
            $ejecuciones[] = $valorEjecucion;
            $idObjetivo2 = str_replace('_', ' ', $idObjetivo);
            $infoObjetivos[] = ['ejecucion' => $valorEjecucion, 'nombre' => $nombreObjetivo, 'color' => $colorObjetivo, 'id' => $idObjetivo2];
            $nombres[] = $nombreObjetivo;
            $colores[] = $colorObjetivo;
        }
        usort($infoObjetivos, function ($a, $b) {
            return ($a['ejecucion'] < $b['ejecucion']) ? 1 : -1;
        });
        echo '
        <div class="row">
            <div class="col-sm-12">
                <script>
                    var infoObjetivos = ' . json_encode($infoObjetivos) . ';
                    var ctx = document.getElementById("chart-area").getContext("2d");
                    window.chart1 = new Chart(ctx, {
                        type: "treemap",
                        data:{
                            datasets: [{
                                tree: ' . json_encode($infoObjetivos) . ',
                                key: "ejecucion",
                                groups: ["id"],
                                backgroundColor: function(ctx) {
                                    var value = ctx.dataIndex;
                                    var color = infoObjetivos[value]["color"];
                                    return color;
                                },
                                spacing: 1,
                                borderWidth: 2,
                                fontColor: "white",
                                fontSize: 12,
                                borderColor: "rgba(255,255,255, 1)"
                            }]
                        },
                        options: {   
                            legend: {display:false},
                            maintainAspectRatio: false,
                            tooltips: {
                                callbacks: {
                                    title: function (item, data) {
                                        return "";
                                    },
                                    label: function (item, data) {
                                        var dataset = data.datasets[item.datasetIndex];
                                        var dataItem = dataset.data[item.index];
                                        var value = item.index;
                                        var nombre = infoObjetivos[value]["nombre"];
                                        return (nombre +": "+ formatNumber((dataItem.v).toFixed(1))).toLocaleString();
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>';
        usort($infoObjetivos, function ($a, $b) {
            return strnatcasecmp($a['nombre'], $b['nombre']);
        });
        echo '
        <style>
            .convencion-ods{width: 40px; height:40px;}
        </style>
        <div class="row" style="margin-top:25px;">
            <div class="col-xs-12 col-sm-12">
                <div class="centerTable">
                    <table id="tabla-ods" class="table table-striped table-bordered dt-responsive nowrap display" style="width:100%">
                        <thead>
                            <tr>
                                <th colspan="2" style="background-color:#215a9a; color:#fff; text-align:center;vertical-align:middle;">Objetivo</th>
                                <th style="background-color:#215a9a; color:#fff; text-align:center;">Ejecución presupuestal</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($infoObjetivos as $row => $item) {
            echo '          <tr>
                                <td>
                                    <div class="convencion-ods" style="background-color:' . $item['color'] . '"></div>
                                </td>
                                <td style="text-align:center;">' . $item['nombre'] . '</td>
                                <td style="text-align:right;"> $' . number_format($item['ejecucion'], 1, ".", ",") . '</td>
                            </tr>';
        }
        echo '           </tbody>
                    </table>
                </div>
            </div>
        </div>';
    }

    /**
     * <b>consultaIGCController</b>
     * <br>
     * Realiza la consulta de un Indicador Global de Ciudad, para su 
     * visualización en la página
     * @param string $idDimension ID de la dimensión a la que pertenece el indicador a consultar
     * @param string $idTematica ID de la temática a la que pertenece el indicador a consultar
     * @param string $idIndicador ID del indicador a consultar
     * @param string $fuenteC Fuente de datos del indicador a consultar
     * @param string $desagregacionesTematicas Desagregaciones temáticas del indicador a consultar
     * @param string $fechas Años del indicador a consultar
     * @param string $desagregacionesGeograficas Desagregaciones geográficas del indicador a consultar
     * @param string $tipoConsulta Categoría de la consulta a realizar
     */
    public function consultaIGCController($idDimension, $idTematica, $idIndicador, $fuenteC, $desagregacionesTematicas, $fechas, $desagregacionesGeograficas, $tipoConsulta)
    {
        $desagregacionesTematicasC = json_decode($desagregacionesTematicas);
        $fechasC = json_decode($fechas);
        $desagregacionesGeograficasC = json_decode($desagregacionesGeograficas);
        $cons = new ConsultasModel();
        $resp = $cons->consultaGlobalesCiudad($idDimension, $idTematica, $idIndicador, $fuenteC, $desagregacionesTematicasC, $fechasC, $desagregacionesGeograficasC);

        if ($resp == 'error') {
            echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <li>Debe seleccionar todos los filtros</li></div>";
        } else {
            $nombreDimension = $resp[0];
            $nombreTematica = $resp[1];
            $nombreIndicador = $resp[2];
            $labels = $resp[3];
            $series = $resp[4];
            $desagregacionesGeograficas2 = $resp[5];
            $totalDatos = $resp[6];
            $tipoGrafico = $resp[7];
            $data = $resp[8];
            $entidadGeneradora = $resp[9];
            $notas = $resp[10];
            $rango = $resp[11];
            $unidadMedicion = $resp[12];
            $justificacion = $resp[13];
            $definicion = $resp[14];
            $metodologia = $resp[15];
            $referencia = $resp[16];
            $observacionesLimitaciones = $resp[17];
            $otrasOrganizaciones = $resp[18];
            $periodicidad = $resp[19];
            $maxValue = $this->setMaxValue($resp[20]);
            $fuente = $resp[21];
            echo '
            <div class="row border-consulta">
                <div class="col-xs-12 col-sm-12">
                    <h6 style="color:#215a9a;"><b>Resultado de la consulta:</b></h6>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <p style="font-family:Source Sans Pro, sans-serif; font-size:15px;">
                        Dimensión: ' . $nombreDimension . ' <br>
                        Temática: ' . $nombreTematica . ' <br>
                    </p>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <p style="font-family:Source Sans Pro, sans-serif; font-size:15px;">
                        Indicador: ' . $nombreIndicador . ' <br>
                        Desagregaciones geográficas: ' . implode(' - ', $desagregacionesGeograficas2) . ' <br>
                    </p>
                </div>
            </div>
            <script>
            	  $("#' . $idDimension . '").addClass("in");            
            	  $("#' . $idTematica . '_cali").addClass("in");            
            	  $("#' . $idIndicador . '").addClass("back-item-menu");            
            </script>';
            include 'formConsultaIndicador.php';
            echo '
            <ul class = "nav nav-tabs">
                <li class = "active"><a data-toggle = "tab" href = "#grafico">Gráfico</a></li>
                <li><a data-toggle = "tab" href = "#tabla">Tabla</a></li>
                <li><a data-toggle = "tab" href = "#ficha">Ficha técnica</a></li>
            </ul>
            <div class="tab-content" id="tab-consulta">
                <div id="grafico" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div id="graf" style="background-color:#fff; padding: 0px 15px 10px;">
                                <h3 id="nombreIndicador" style="text-align:center">' . $nombreIndicador . '</h3>
                                <h4 style="text-align:center">' . $rango . '</h4>
                                <canvas id="myChart"></canvas>
                                <hr>
                                <p><strong>Gráfico:</strong> Sistema de Indicadores Sociales</p>
                                <p><strong>Fuente de datos:</strong> ' . $fuente . ' </p>';
            if (sizeof($notas) > 0) {
                echo '          <p style="font-size: smaller;margin:0px;"><strong>Notas:</strong> ' . implode(" - ", $notas) . ' </p>';
            }
            echo '          </div>
                        </div>';

            $link = "";
            if ($tipoConsulta == 'General') {
                $link = '/consulta-indicadores/dimensiones-sis/' . $idDimension . '/' . $idTematica .
                    '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
            } elseif ($tipoConsulta == 'Comunas') {
                $link = '/consulta-indicadores/dimensiones-sis-comunas/' . $idDimension . '/' . $idTematica .
                    '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
            } elseif ($tipoConsulta == 'IGC') {
                $link = '/consulta-indicadores/igc/' . $idDimension . '/' . $idTematica .
                    '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
            } elseif ($tipoConsulta == 'EXP') {
                $link = '/consulta-indicadores/exp/' . $idDimension . '/' . $idTematica .
                    '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente));
            }

            echo '      <input type="text" id="link" hidden readonly value="' . $link . '" style="border:0; font-weight:bold; text-align:left;">';
            echo '   </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <hr>
                            <h4 style="text-align:left">Descargar gráfico</h4>
                            <script>
                                var url = "/views/resources/js/descargarGrafico.js";
                                $.getScript(url);
                            </script>
                            <div class="btn-group" role="group" style="width:100%; margin-bottom: 15px;">
                                <button type="button" id="imagenPng" class="btn bt bt-ripple" style="background-color:#52b1fe; color:#fff;">
                                    <i class="fa fa-file-image-o" aria-hidden="true" style="margin-right:10px;"></i>
                                    <b>PNG</b>
                                </button>
                                <img src="/views/resources/images/loading3.gif" id="loadingPng" style="display: none; margin-left: 10px;"/>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    var ctx = document.getElementById("myChart").getContext("2d");';
            $cons = new ConsultasController();
            if ($tipoGrafico == "Barras") {
                echo $cons->drawBarChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
            } elseif ($tipoGrafico == "Lineal") {
                echo $cons->drawLineChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
            } else {
                if ($totalDatos <= 10) {
                    echo $cons->drawBarChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                } else {
                    echo $cons->drawLineChartMaxValue(json_encode($data), $unidadMedicion, $maxValue);
                }
            }
            echo '
                </script>
                <div id="tabla" class="tab-pane fade in">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <h3 style="text-align:center">' . $nombreIndicador . '</h3>
                            <h4 style="text-align:center">' . $rango . '<br></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="centerTable">
                                <table id="tablaDatos" class="table table-striped table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <td colspan="4" style="background-color:#215a9a; color:#fff; text-align:center; visibility:hidden;">' . $nombreIndicador . '</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Desagregación temática</td>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Desagregación geográfica</td>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Fecha</td>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">' . ucfirst($unidadMedicion) . '</td>
                                        </tr>';
            for ($l = 0; $l < count($series); $l++) {
                $serie2 = $series[$l][0];
                $desGeo = $series[$l][1];
                $desTem = $series[$l][2];
                foreach ($labels as $row => $fecha) {
                    $dat = new Datos();
                    $dato = $dat->consultarInfoDatoPorIdSerieFecha($serie2, $fecha);
                    echo '          <tr>
                                            <td style="text-align:center;">' . $desGeo . '</td>
                                            <td style="text-align:center;">' . $desTem . '</td>
                                            <td style="text-align:center;">' . $fecha . '</td>
                                            <td style="text-align:right;">';
                    $value = $dato[2];
                    $countDecimals = strlen(substr(strrchr($value, "."), 1));

                    if ($countDecimals > 0) {
                        settype($value, "Float");
                    } else {
                        settype($value, "Int");
                    }

                    if (strpos($nombreIndicador, "PIB Per cápita") !== false) {
                        echo '$' . number_format($dato[2], 2, ".", ",");
                    } elseif (
                        strpos($nombreIndicador, "GINI") !== false ||
                        strpos($nombreIndicador, "Toneladas de residuos sólidos") !== false ||
                        strpos($nombreIndicador, "Tasa de crecimiento de la población") !== false
                    ) {
                        echo number_format($dato[2], 2, ".", ",");
                    } elseif (strpos($nombreIndicador, "PIB Per cápita") !== false) {
                        echo '$' . number_format($dato[2], 2, ".", ",");
                    } else {
                        if (is_float($value)) {
                            echo number_format($value, 2, ".", ",");
                        } else {
                            echo number_format($value, 0, ".", ",");
                        }
                    }
                    echo '                  </td>
                                        </tr>';
                }
            }
            echo '                  </tbody>
                                </table>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <p><strong>Tabla:</strong> Sistema de Indicadores Sociales</p>
                            <p><strong>Fuente de datos:</strong> ' . $fuente . '</p>';
            if (sizeof($notas) > 0) {
                echo '      <p style="font-size: smaller;"><strong>Notas:</strong> ' . implode(" - ", $notas) . ' </p>';
            }
            echo "
                            <hr>
                            <h4 style='text-align:left'>Descargar datos</h4>
                            <div class='btn-group' role='group' style='width:100%; margin-bottom: 15px;'>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#2ECC71; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'csv', fileName: '$nombreIndicador'});" . '"' . ">
                                    <i class='fa fa-file-archive-o' aria-hidden='true' style='margin-right:10px;'></i>
                                    <b>CSV</b>                                                           
                                </button>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#1E8449; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'excel', fileName: '$nombreIndicador', excelFileFormat: 'xlsx', worksheetName: '.$nombreIndicador.'});" . '"' . ">
                                    <i class='fa fa-file-excel-o' aria-hidden='true' style='margin-right:10px;'></i>                                                
                                    <b>XLS</b>
                                </button>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#9777a8; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'json', fileName: '$nombreIndicador'});" . '"' . ">
                                    <i class='fa fa-file-text-o' aria-hidden='true' style='margin-right:10px;'></i>
                                    <b>JSON</b>                                                           
                                </button>
                            </div>
                        </div>      
                    </div>";
            echo '
                </div>      
                <div id="ficha" class="tab-pane fade in">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <h3 style="text-align:center">' . $nombreIndicador . '</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="centerTable">
                                <table id="tablaFicha" class="table table-striped" style="text-align:center">
                                    <tbody>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Dimensión</td>
                                            <td style="text-align:left;">' . $nombreDimension . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Temática</td>
                                            <td style="text-align:left;">' . $nombreTematica . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Indicador</td>
                                            <td style="text-align:left;">' . $nombreIndicador . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Justificación</td>
                                            <td style="text-align:left;">' . $justificacion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Definiciones</td>
                                            <td style="text-align:left;">' . $definicion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Metodología</td>
                                            <td style="text-align:left;">' . $metodologia . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Referencia</td>
                                            <td style="text-align:left;">' . $referencia . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Observaciones y limitaciones</td>
                                            <td style="text-align:left;">' . $observacionesLimitaciones . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Otras organizaciones que usan el indicador</td>
                                            <td style="text-align:left;">' . $otrasOrganizaciones . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Unidad de medida</td>
                                            <td style="text-align:left;">' . $unidadMedicion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Fuente de datos</td>
                                            <td style="text-align:left;">' . $fuente . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Periodicidad</td>
                                            <td style="text-align:left;">' . $periodicidad . '</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">                
                        <div class="col-xs-12 col-sm-12">                
                            <p><strong>Ficha técnica:</strong> Sistema de Indicadores Sociales</p>
                            <hr>
                            <h4 style="text-align:left">Descargar ficha técnica</h4>';
            echo "          <div class='btn-group' role='group' style='width:100%; margin-bottom: 15px;'>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#1E8449; color:#fff;' onClick =" . '"' . "$('#tablaFicha').tableExport({type: 'excel', fileName: '.$nombreIndicador.', excelFileFormat: 'xlsx', worksheetName: '.$nombreIndicador.'});" . '"' . ">
                                    <i class='fa fa-file-excel-o' aria-hidden='true' style='margin-right:10px;'></i>                                                
                                    <b>XLS</b>
                                </button>";

            if ($nombreDimension == "") {
                $nombreDimension = "_____";
            }
            if ($nombreTematica == "") {
                $nombreTematica = "_____";
            }
            if ($nombreIndicador == "") {
                $nombreIndicador = "_____";
            }
            if ($justificacion == "") {
                $justificacion = "_____";
            }
            if ($definicion == "") {
                $definicion = "_____";
            }
            if ($metodologia == "") {
                $metodologia = "_____";
            }
            if ($referencia == "") {
                $referencia = "_____";
            }
            if ($observacionesLimitaciones == "") {
                $observacionesLimitaciones = "_____";
            }
            if ($otrasOrganizaciones == "") {
                $otrasOrganizaciones = "_____";
            }
            if ($unidadMedicion == "") {
                $unidadMedicion = "_____";
            }
            if ($fuente == "") {
                $fuente = "_____";
            }
            if ($periodicidad == "") {
                $periodicidad = "_____";
            }

            $nombreDim = preg_replace("/(\n|\r|\n\r)/", ' ', $nombreDimension);
            $nombreTem = preg_replace("/(\n|\r|\n\r)/", ' ', $nombreTematica);
            $nombreInd = preg_replace("/(\n|\r|\n\r)/", ' ', $nombreIndicador);
            $just = preg_replace("/(\n|\r|\n\r)/", ' ', $justificacion);
            $defi = preg_replace("/(\n|\r|\n\r)/", ' ', $definicion);
            $mtdlg = preg_replace("/(\n|\r|\n\r)/", ' ', $metodologia);
            $ref = preg_replace("/(\n|\r|\n\r)/", ' ', $referencia);
            $obs = preg_replace("/(\n|\r|\n\r)/", ' ', $observacionesLimitaciones);
            $otrasOrg = preg_replace("/(\n|\r|\n\r)/", ' ', $otrasOrganizaciones);
            $undMed = preg_replace("/(\n|\r|\n\r)/", ' ', $unidadMedicion);
            $fte = preg_replace("/(\n|\r|\n\r)/", ' ', $fuente);
            $period = preg_replace("/(\n|\r|\n\r)/", ' ', $periodicidad);

            echo '              <script>
                                    document.formFicha.dimensionForm.value = "' . $nombreDim . '";
                                    document.formFicha.tematicaForm.value = "' . $nombreTem . '";
                                    document.formFicha.indicadorForm.value = "' . $nombreInd . '";
                                    document.formFicha.justificacionForm.value = "' . $just . '";
                                    document.formFicha.definicionForm.value = "' . $defi . '";
                                    document.formFicha.metodologiaForm.value = "' . $mtdlg . '";
                                    document.formFicha.referenciaForm.value = "' . $ref . '";
                                    document.formFicha.observacionesForm.value = "' . $obs . '";
                                    document.formFicha.otrasOrganizacionesForm.value = "' . $otrasOrg . '";
                                    document.formFicha.unidadMedidaForm.value = "' . $undMed . '";
                                    document.formFicha.fuenteForm.value = "' . $fte . '";
                                    document.formFicha.periodicidadForm.value = "' . $period . '";
                                </script>
                                <form id="formFicha" name="formFicha" action="/views/generar/igc.php" target="_blank" method="post">
                                    <input type="hidden" name="dimensionForm" id="dimensionForm"/>
                                    <input type="hidden" name="tematicaForm" id="tematicaForm"/>
                                    <input type="hidden" name="indicadorForm" id="indicadorForm"/>
                                    <input type="hidden" name="justificacionForm" id="justificacionForm"/>
                                    <input type="hidden" name="definicionForm" id="definicionForm"/>
                                    <input type="hidden" name="metodologiaForm" id="metodologiaForm"/>
                                    <input type="hidden" name="referenciaForm" id="referenciaForm"/>
                                    <input type="hidden" name="observacionesForm" id="observacionesForm"/>
                                    <input type="hidden" name="otrasOrganizacionesForm" id="otrasOrganizacionesForm"/>
                                    <input type="hidden" name="unidadMedidaForm" id="unidadMedidaForm"/>
                                    <input type="hidden" name="fuenteForm" id="fuenteForm"/>
                                    <input type="hidden" name="periodicidadForm" id="periodicidadForm"/>
                                    <button type="submit" class="btn bt bt-ripple pdf-buttom" style="background-color:#aa0501; color:#fff;">
                                        <i class="fa fa-file-pdf-o" aria-hidden="true" style="margin-right:10px;"></i>
                                        <b>PDF</b>                                                           
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }

    /**
     * <b>consultaExpedienteController</b>
     * <br>
     * Realiza la consulta de un Indicador del Expediente Municipal, para su 
     * visualización en la página
     * @param string $idDimension ID de la dimensión a la que pertenece el indicador a consultar
     * @param string $idTematica ID de la temática a la que pertenece el indicador a consultar
     * @param string $idIndicador ID del indicador a consultar
     * @param string $desagregacionesTem Desagregaciones temáticas del indicador a consultar
     * @param string $fechas Años del indicador a consultar
     * @param string $tipoZonaGeografica Tipo de zona geográfica a la que pertenecen 
     * las desagregaciones geográficas del indicador
     * @param string $zonaGeografica Desagregación geográfica del indicador a consultar
     */
    public function consultaExpedienteController($idDimension, $idTematica, $idIndicador, $desagregacionesTem, $fechas, $tipoZonaGeografica, $zonaGeografica)
    {
        $desagregacionesTematicas = json_decode($desagregacionesTem);
        $fechasC = json_decode($fechas);
        $consultasMod = new ConsultasModel();
        $resp = $consultasMod->consultaExpediente($idDimension, $idTematica, $idIndicador, $tipoZonaGeografica, $zonaGeografica, $desagregacionesTematicas, $fechasC);
        if ($resp == 'error') {
            echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <li>Debe seleccionar todos los filtros</li></div>";
        } else {
            $nombreDimension = $resp[0];
            $nombreTematica = $resp[1];
            $nombreIndicador = $resp[2];
            $labels = $resp[3];
            $fechas2 = $resp[4];
            $series = $resp[5];
            $desagregaciones2 = $resp[6];
            $tipoGrafico = $resp[7];
            $totalDatos = $resp[8];
            $data = $resp[9];
            $fuente = $resp[10];
            $entidadGeneradora = $resp[11];
            $notas = $resp[12];
            $rango = $resp[13];
            $unidadMedicion = $resp[14];
            $sigla = $resp[15];
            $justificacion = $resp[16];
            $definicion = $resp[17];
            $metodosMedicion = $resp[18];
            $formulas = $resp[19];
            $variables = $resp[20];
            $valoresReferencia = $resp[21];
            $naturaleza = $resp[22];
            $desagregacionTematica = $resp[23];
            $desagregacionGeografica = $resp[24];
            $lineaBase = $resp[25];
            $responsable = $resp[26];
            $observaciones = $resp[27];
            $fechaElaboracion = $resp[28];
            $periodicidad = $resp[29];

            echo '
            <div class="row border-consulta">
                <div class="col-xs-12 col-sm-12">
                    <h6 style="color:#215a9a;"><b>Resultado de la consulta:</b></h6>
                </div>
                <div class="col-sm-8">
                    <p style="font-family:Source Sans Pro, sans-serif; font-size:15px;">
                        Dimensión: ' . $nombreDimension . ' <br>
                        Temática: ' . $nombreTematica . ' <br>
                        Indicador: ' . $nombreIndicador . ' <br>
                    </p>
                </div>
                <div class="col-sm-4">
                    <p style="font-family:Source Sans Pro, sans-serif; font-size:15px;">
                        Geografía: ' . $tipoZonaGeografica . ' <br>
                        Zona geográfica: ' . $zonaGeografica . ' <br>
                    </p>
                </div>
            </div>
            <script>
            	  $("#' . $idDimension . '").addClass("in");            
            	  $("#' . $idTematica . '_cali").addClass("in");            
            	  $("#' . $idIndicador . '").addClass("back-item-menu");            
            </script>';
            include 'formConsultaExpediente.php';
            echo '
                
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#grafico">Gráfico</a></li>
                <li><a data-toggle="tab" href="#tabla">Tabla</a></li>        
                <li><a data-toggle="tab" href="#ficha">Ficha técnica</a></li>
            </ul>
            <div class="tab-content" id="tab-consulta">
                <div id="grafico" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div id="graf" style="background-color:#fff; padding: 0px 15px 10px;">
                                <h3 id="nombreIndicador" style="text-align:center">' . $nombreIndicador . '</h3>
                                <h6 style="text-align:center"><strong>Geografía:</strong> ' . $tipoZonaGeografica . ' - <strong>Zona actual:</strong> ' . $zonaGeografica . '</h6>
                                <h4 style="text-align:center">' . $rango . '</h4>
                                <canvas id="myChart"></canvas>
                                <hr>
                                <p><strong>Gráfico:</strong> Sistema de Indicadores Sociales</p>
                                <p><strong>Fuente de datos:</strong> ' . $fuente[0] . ' </p>';
            if (sizeof($notas) > 0) {
                echo '      <p style="font-size: smaller;"><strong>Notas:</strong> ' . implode(" - ", $notas) . ' </p>';
            }
            echo '          </div>
                        </div>';

            $link = '/consulta-indicadores/exp/' . $idDimension . '/' . $idTematica . '/' . $idIndicador;
            echo '      <input type="text" id="link" hidden readonly value="' . $link . '" style="border:0; font-weight:bold; text-align:left;">';
            echo '
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <hr>
                            <h4 style="text-align:left">Descargar gráfico</h4>
                            <script>
                                var url = "/views/resources/js/descargarGrafico.js";
                                $.getScript(url);
                            </script>
                            <div class="btn-group" role="group" style="width:100%; margin-bottom: 15px;">
                                <button type="button" id="imagenPng" class="btn bt bt-ripple" style="background-color:#52b1fe; color:#fff;">
                                    <i class="fa fa-file-image-o" aria-hidden="true" style="margin-right:10px;"></i>
                                    <b>PNG</b>
                                </button>
                                <img src="/views/resources/images/loading3.gif" id="loadingPng" style="display: none; margin-left: 10px;"/>
                            </div>
                        </div>
                    </div>
                </div>';
            echo "
                <script>
                    var ctx = document.getElementById('myChart').getContext('2d');";
            $cons = new ConsultasController();

            if ($totalDatos == 1 && $tipoGrafico !== "Piramidal") {
                $tipoGrafico = "Barras";
            }

            if ($tipoGrafico == "Barras") {
                echo $cons->drawBarChart(json_encode($data), $unidadMedicion);
            } elseif ($tipoGrafico == "Lineal") {
                echo $cons->drawLineChart(json_encode($data), $unidadMedicion);
            } elseif ($tipoGrafico == "Área") {
                echo $cons->drawAreaChart(json_encode($data), $unidadMedicion);
            } else {
                if ($totalDatos <= 10) {
                    echo $cons->drawBarChart(json_encode($data), $unidadMedicion);
                } else {
                    echo $cons->drawLineChart(json_encode($data), $unidadMedicion);
                }
            }


            echo '
                </script>
                <div id="tabla" class="tab-pane fade in">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <h3 style="text-align:center">' . $nombreIndicador . '</h3>
                            <h6 style="text-align:center"><strong>Geografía:</strong> ' . $tipoZonaGeografica . '</h6>
                            <h6 style="text-align:center"><strong>Zona actual:</strong> ' . $zonaGeografica . '</h6>
                            <h4 style="text-align:center">' . $rango . '<br></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="centerTable">
                                <table id="tablaDatos" class="table table-striped table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <td colspan="4" style="background-color:#215a9a; color:#fff; text-align:center; visibility:hidden;">' . $nombreIndicador . '</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Zona geográfica</td>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Desagregación temática</td>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Fecha</td>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">' . ucfirst($unidadMedicion) . '</td>
                                        </tr>';
            for ($l = 0; $l < count($series); $l++) {
                $serie2 = $series[$l];
                foreach ($labels as $row => $fecha) {
                    $dat = new Datos();
                    $dato = $dat->consultarInfoDatoPorIdSerieFecha($serie2, $fecha);
                    echo '
                                        <tr>
                                            <td style="text-align:center;">' . $zonaGeografica . '</td>
                                            <td style="text-align:center;">' . $desagregacionesTematicas[$l] . '</td>
                                            <td style="text-align:center;">' . $fecha . '</td>
                                            <td style="text-align:right;">';
                    if (strpos($nombreIndicador, "PIB Per cápita") !== false) {
                        echo '$' . number_format($dato[2], 2, ".", ",");
                    } else if (ctype_digit(strval($dato[2]))) {
                        echo number_format($dato[2], 2, ".", ",");
                    } else {
                        if (
                            strpos($nombreIndicador, "GINI") !== false ||
                            strpos($nombreIndicador, "Toneladas de residuos sólidos") !== false ||
                            strpos($nombreIndicador, "Tasa de crecimiento de la población") !== false
                        ) {
                            echo number_format($dato[2], 2, ".", ",");
                        } elseif (strpos($nombreIndicador, "PIB Per cápita") !== false) {
                            echo '$' . number_format($dato[2], 2, ".", ",");
                        } else {
                            echo number_format($dato[2], 2, ".", ",");
                        }
                    }
                    echo '                  </td>
                                        </tr>';
                }
            }
            echo '                  </tbody>
                                </table>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <p><strong>Tabla:</strong> Sistema de Indicadores Sociales</p>
                            <p><strong>Fuente de datos:</strong> ' . $fuente[0] . '</p>';
            if (sizeof($notas) > 0) {
                echo '      <p style="font-size: smaller;"><strong>Notas:</strong> ' . implode(" - ", $notas) . ' </p>';
            }
            echo "          <hr>
                            <h4 style='text-align:left'>Descargar datos</h4>
                            <div class='btn-group' role='group' style='width:100%; margin-bottom: 15px;'>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#2ECC71; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'csv', fileName: '$nombreIndicador'});" . '"' . ">
                                    <i class='fa fa-file-archive-o' aria-hidden='true' style='margin-right:10px;'></i>
                                    <b>CSV</b>                                                           
                                </button>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#1E8449; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'excel', fileName: '$nombreIndicador', excelFileFormat: 'xlsx', worksheetName: '.$nombreIndicador.'});" . '"' . ">
                                    <i class='fa fa-file-excel-o' aria-hidden='true' style='margin-right:10px;'></i>                                                
                                    <b>XLS</b>
                                </button>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#9777a8; color:#fff;' onClick =" . '"' . "$('#tablaDatos').tableExport({type: 'json', fileName: '$nombreIndicador'});" . '"' . ">
                                    <i class='fa fa-file-text-o' aria-hidden='true' style='margin-right:10px;'></i>
                                    <b>JSON</b>                                                           
                                </button>
                            </div>
                        </div>
                    </div>";
            echo '
                </div>
                    <div id="ficha" class="tab-pane fade in">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <h3 style="text-align:center">' . $nombreIndicador . '</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="centerTable">
                                <table id="tablaFicha" class="table table-striped" style="text-align:center">
                                    <tbody style="width:100%;">
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Dimensión</td>
                                            <td style="text-align:left;">' . $nombreDimension . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Temática</td>
                                            <td style="text-align:left;">' . $nombreTematica . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Indicador</td>
                                            <td style="text-align:left;">' . $nombreIndicador . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Sigla</td>
                                            <td style="text-align:left;">' . $sigla . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Justificación</td>
                                            <td style="text-align:left;">' . $justificacion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Definiciones y conceptos</td>
                                            <td style="text-align:left;">' . $definicion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Método de medición</td>
                                            <td style="text-align:left;">' . $metodosMedicion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Unidad de medida</td>
                                            <td style="text-align:left;">' . $unidadMedicion . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Fórmulas</td>
                                            <td style="text-align:left;">' . $formulas . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Variables</td>
                                            <td style="text-align:left;">' . $variables . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Valores de referencia</td>
                                            <td style="text-align:left;">' . $valoresReferencia . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Naturaleza</td>
                                            <td style="text-align:left;">' . $naturaleza . '</td>
                                        </tr>                                            
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Desagregación temática</td>
                                            <td style="text-align:left;">' . $desagregacionTematica . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Desagregación geográfica</td>
                                            <td style="text-align:left;">' . $desagregacionGeografica . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Línea base</td>
                                            <td style="text-align:left;">' . $lineaBase . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Periodicidad</td>
                                            <td style="text-align:left;">' . $periodicidad . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Fuente de datos</td>
                                            <td style="text-align:left;">' . $fuente[0] . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Observaciones</td>
                                            <td style="text-align:left;">' . $observaciones . '</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#215a9a; color:#fff; text-align:center;">Fecha de elaboración</td>
                                            <td style="text-align:left;">' . $fechaElaboracion . '</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <p><strong>Ficha técnica:</strong> Expediente Municipal</p>
                            <hr>
                            <h4 style="text-align:left">Descargar ficha técnica</h4>';
            echo "          <div class='btn-group' role='group' style='width:100%; margin-bottom: 15px;'>
                                <button type='button' class='btn bt bt-ripple' style='background-color:#1E8449; color:#fff;' onClick =" . '"' . "$('#tablaFicha').tableExport({type: 'excel', fileName: '.$nombreIndicador.', excelFileFormat: 'xlsx', worksheetName: '.$nombreIndicador.'});" . '"' . ">
                                    <i class='fa fa-file-excel-o' aria-hidden='true' style='margin-right:10px;'></i>                                                
                                    <b>XLS</b>
                                </button>";
            if ($formulas == "") {
                $formulas = "_____";
            }
            if ($variables == "") {
                $variables = "_____";
            }
            if ($valoresReferencia == "") {
                $valoresReferencia = "_____";
            }
            if ($desagregacionTematica == "") {
                $desagregacionTematica = "_____";
            }
            if ($desagregacionGeografica == "") {
                $desagregacionGeografica = "_____";
            }
            if ($observaciones == "") {
                $observaciones = "_____";
            }
            $nombreDim = preg_replace("/(\n|\r|\n\r)/", ' ', $nombreDimension);
            $nombreTem = preg_replace("/(\n|\r|\n\r)/", ' ', $nombreTematica);
            $nombreInd = preg_replace("/(\n|\r|\n\r)/", ' ', $nombreIndicador);
            $sig = preg_replace("/(\n|\r|\n\r)/", ' ', $sigla);
            $just = preg_replace("/(\n|\r|\n\r)/", ' ', $justificacion);
            $defi = preg_replace("/(\n|\r|\n\r)/", ' ', $definicion);
            $metodosMed = preg_replace("/(\n|\r|\n\r)/", ' ', $metodosMedicion);
            $nat = preg_replace("/(\n|\r|\n\r)/", ' ', $naturaleza);
            $form = preg_replace("/(\n|\r|\n\r)/", ' ', $formulas);
            $vari = preg_replace("/(\n|\r|\n\r)/", ' ', $variables);
            $valRef = preg_replace("/(\n|\r|\n\r)/", ' ', $valoresReferencia);
            $desTem = preg_replace("/(\n|\r|\n\r)/", ' ', $desagregacionTematica);
            $desGeo = preg_replace("/(\n|\r|\n\r)/", ' ', $desagregacionGeografica);
            $obs = preg_replace("/(\n|\r|\n\r)/", ' ', $observaciones);

            echo '              <script>
                                    document.formFicha.dimensionForm.value = "' . $nombreDim . '";
                                    document.formFicha.tematicaForm.value = "' . $nombreTem . '";
                                    document.formFicha.indicadorForm.value = "' . $nombreInd . '";
                                    document.formFicha.siglaForm.value = "' . $sig . '";
                                    document.formFicha.justificacionForm.value = "' . $just . '";
                                    document.formFicha.definicionForm.value = "' . $defi . '";
                                    document.formFicha.metodosMedicionForm.value = "' . $metodosMed . '";
                                    document.formFicha.unidadMedicionForm.value = "' . $unidadMedicion . '";
                                    document.formFicha.formulasForm.value = "' . $form . '";
                                    document.formFicha.variablesForm.value = "' . $vari . '";
                                    document.formFicha.valoresReferenciaForm.value = "' . $valRef . '";
                                    document.formFicha.naturalezaForm.value = "' . $nat . '";
                                    document.formFicha.desagregacionTematicaForm.value = "' . $desTem . '";
                                    document.formFicha.desagregacionGeograficaForm.value = "' . $desGeo . '";
                                    document.formFicha.lineaBaseForm.value = "' . $lineaBase . '";
                                    document.formFicha.periodicidadForm.value = "' . $periodicidad . '";
                                    document.formFicha.fuenteDatosForm.value = "' . $fuente[0] . '";
                                    document.formFicha.observacionesForm.value = "' . $obs . '";
                                    document.formFicha.fechaElaboracionForm.value = "' . $fechaElaboracion . '";
                                </script>
                                <form id="formFicha" name="formFicha" action="/views/generar/sis.php" target="_blank" method="post">
                                    <input type="hidden" name="dimensionForm" id="dimensionForm"/>
                                    <input type="hidden" name="tematicaForm" id="tematicaForm"/>
                                    <input type="hidden" name="indicadorForm" id="indicadorForm"/>
                                    <input type="hidden" name="siglaForm" id="siglaForm"/>
                                    <input type="hidden" name="justificacionForm" id="justificacionForm"/>
                                    <input type="hidden" name="definicionForm" id="definicionForm"/>
                                    <input type="hidden" name="metodosMedicionForm" id="metodosMedicionForm"/>
                                    <input type="hidden" name="unidadMedicionForm" id="unidadMedicionForm"/>
                                    <input type="hidden" name="formulasForm" id="formulasForm"/>
                                    <input type="hidden" name="variablesForm" id="variablesForm"/>
                                    <input type="hidden" name="valoresReferenciaForm" id="valoresReferenciaForm"/>
                                    <input type="hidden" name="naturalezaForm" id="naturalezaForm"/>
                                    <input type="hidden" name="desagregacionTematicaForm" id="desagregacionTematicaForm"/>
                                    <input type="hidden" name="desagregacionGeograficaForm" id="desagregacionGeograficaForm"/>
                                    <input type="hidden" name="lineaBaseForm" id="lineaBaseForm"/>
                                    <input type="hidden" name="periodicidadForm" id="periodicidadForm"/>
                                    <input type="hidden" name="fuenteDatosForm" id="fuenteDatosForm"/>
                                    <input type="hidden" name="observacionesForm" id="observacionesForm"/>
                                    <input type="hidden" name="fechaElaboracionForm" id="fechaElaboracionForm"/>
                                    <button type="submit" class="btn bt bt-ripple pdf-buttom" style="background-color:#aa0501; color:#fff;">
                                        <i class="fa fa-file-pdf-o" aria-hidden="true" style="margin-right:10px;"></i>
                                        <b>PDF</b>                                                           
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }

    /**
     * <b>consultarMacroprocesoPorProceso</b>
     * <br>
     * Realiza la consulta del proceso por el buscador del DADII
     * @param string $idProceso Codigo del proceso
     */
    public function consultarMacroprocesoPorProceso($idProceso)
    {
        $idConjunto = "m";
        $tem = new Tematicas();
        $ind = new Indicadores();
        $resp = $tem->consultarDimensionPorIdTematica($idProceso);
        if ($resp == true) {
            $link = '/consulta-indicadores/dadii/' . $resp . '/' . $idProceso;
            echo $link;
        } else {
            echo "<div class='alert alert-danger alert-dismissable'>
            Error al realizar la búsqueda.<br>
            Verifique el código del proceso ingresado.<br>
            </div>";
        }
    }

    /**
     * <b>consultaDadiiControllerConIndicador</b>
     * <br>
     * Consulta todos los indicadores pertenecientes a un proceso y visualiza la información de cada indicador
     * @param string $idDimension Recibe el macroproceso al que pertenecen los indicadores
     * @param string $idTematica Recibe el proceso al que pertenecen los indicadores
     */
    public function consultaDadiiControllerConIndicador($idDimension, $idTematica)
    {
        $dim = new Dimensiones();
        $nomDim = $dim->consultarNombreDimensionPorId($idDimension);
        $tem = new Tematicas();
        $nomTem = $tem->consultarNombreTematicaPorId($idTematica);
        $ind = new Indicadores();
        $respIn = $ind->consultarIndicadoresActivosPorIdTematica($idTematica);
        echo '<div class="row" id="form-consulta-indicador">
        <div class="col-xs-12 col-sm-12">
        <h6 style="text-align:center; color:#215a9a;"><b>Información de la consulta:</b></h6>
        <hr style="border-color: #ddd; margin-top: 0px; margin-bottom: 10px;">
    </div>
    <form class="form-inline" style="text-align: left;">
        <div class="form-group col-xs-12 col-sm-3">
                  <label class="label-dadii" style="margin-bottom: 6px;">Nombre del Macroproceso :</label>
                  <br>
                  <li><h7>' . $nomDim . '</h7></li>
                  <br>
            <label class="label-dadii" style="margin-bottom: 6px;">Código del Macroproceso :</label>
                  <br>           
            <li><h7>' . $idDimension . '</h7></li>                 
        </div>
        <div class="form-group col-xs-12 col-sm-3">
            <label class="label-dadii" style="margin-bottom: 6px;">Nombre del Proceso :</label>
                 <br>
             <li><h7>' . $nomTem . '</h7></li>
                 <br>                 
            <label class="label-dadii" style="margin-bottom: 6px;">Código del Proceso :</label>
                  <br>
             <li><h7>' . $idTematica . '</h7></li>
        </div>
        <div class="form-group col-xs-12 col-sm-5">
            <label class="label-dadii" style="margin-bottom: 6px;">Valores de Referencia:</label>
               <div class="tab-informacion col-xs-12 col-sm-12" id="tab-informacion" style="text-align:center;">
                <h7> Rangos de cumplimiento </h7>
                  <div class="tab-informacion col-xs-12 col-sm-6" id="tab-informacion">
                  <h7> Desempeño</h7>
                   </div>
               </div>
               <div class="tab-informacion col-xs-12 col-sm-12" id="tab-informacion" style="text-align:center;">
                <h7><40%<h7>
                   <div class="tab-informacion col-xs-12 col-sm-6" id="tab-informacion" style="background:rgba(255,0,0,0.5); border-color:rgba(255,0,0,0.8)">
                   Critico
                   </div>
              </div>
               <div class="tab-informacion col-xs-12 col-sm-12" id="tab-informacion" style="text-align:center;">
                <h7>40% - 59%<h7>
                   <div class="tab-informacion col-xs-12 col-sm-6" id="tab-informacion" style="background:rgba(226,107,10,0.5); border-color:rgba(226,107,10,0.8)">
                   Bajo
                   </div>
              </div>
               <div class="tab-informacion col-xs-12 col-sm-12" id="tab-informacion" style="text-align:center;">
                <h7>60% - 69%<h7>
                   <div class="tab-informacion col-xs-12 col-sm-6" id="tab-informacion" style="background:rgba(255,255,0,0.5); border-color:rgba(255,255,0,0.8)">
                   Medio
                   </div>
              </div>
               <div class="tab-informacion col-xs-12 col-sm-12" id="tab-informacion" style="text-align:center;">
                <h7>70% - 79%<h7>
                   <div class="tab-informacion col-xs-12 col-sm-6" id="tab-informacion" style="background:rgba(146,208,80,0.5); border-color:rgba(146,208,80,0.8)">
                   Satisfactorio
                   </div>
              </div>   
               <div class="tab-informacion col-xs-12 col-sm-12" id="tab-informacion" style="text-align:center;">
                <h7>>=80%<h7>
                   <div class="tab-informacion col-xs-12 col-sm-6" id="tab-informacion" style="background:rgba(0,176,80,0.5); border-color:rgba(0,176,80,0.8)">
                   Sobresaliente
                   </div>
              </div>              
        </div>
        </div>
    </form>
</div>
';
        echo '
            <div class=" col-xs-12 col-sm-12" id="tab-con" >';
        echo '<div  class="tab-con col-xs-12 col-sm-12" id="tab-con">
                        <div id="grafico" class="tab-pane fade in active"> 
                          <div class="row">
                           <div>
                            <h6 id="nombreIndicador" style="text-align:center ; height: 100px;">Promedio de indicadores por proceso</h6> 
                               <div id="graf" class="col-xs-12 col-sm-6" style="background-color:#fff; padding: 0px 15px 10px;">
                                <canvas id="chart2_' . $idTematica . '" ></canvas>';
        $cons = new ConsultasController();   //ACA SE REALIZA EL GRAFICO      
        $model = new ConsultasModel();
        $resp = $model->promedioIndicadoresDadii($idTematica);
        $data = $resp[0];
        $cantidadDatos = $resp[1];
        echo '
                <script>
                    var ctx = document.getElementById("chart2_' . $idTematica . '").getContext("2d");';
        echo $cons->ColorBarraDadii(json_encode($data));
        echo '</script>';
        echo '                   </div>
                                <div id="graf" class="label-dadii col-xs-12 col-sm-6" style="text-align:center; background-color:#fff;">
                                Cálculo por trimestre
                                </div>
                                <h7>Este promedio se realiza teniendo en cuenta el cumplimiento de cada indicador representado en los cuatro trimestres del año,
                                cada trimestre puede variar según la frecuencia de medición para cada uno de los indicadores.</h7>
                                <div style="margin-left:10px;">
                                <li><h7>El cálculo para el primer trimestre se realizó con <b>' . $cantidadDatos[0] . '</b> indicadores. </h7></li>
                                <li><h7>El cálculo para el segundo trimestre se realizó con <b>' . $cantidadDatos[1] . '</b> indicadores. </h7></li>
                                <li><h7>El cálculo para el tercer trimestre se realizó con <b>' . $cantidadDatos[2] . '</b> indicadores. </h7></li>
                                <li><h7>El cálculo para el cuarto trimestre se realizó con <b>' . $cantidadDatos[3] . '</b> indicadores. </h7></li>
                                    </div>
                           </div>';
        echo '            </div>
                         </div>
                      </div>';
        echo '<div  class="tab-con col-xs-12 col-sm-8" id="tab-con" style="margin-left:0px;padding-block-end: 15px; ">';
        echo '
<div class=" col-xs-12 col-sm-12" id="tab-con" >
	<div class="row">
        <div class="col-xs-12 col-sm-12 bhoechie-tab-container">        
            <div class="col-xs-12 col-sm-2 bhoechie-tab-menu">
              <div class="list-group">
                <a class="list-group-item active text-center">
                  <h4 ></h4><br>
                </a>
                <div class="list-group-item  text-center">
                  <h4 class="glyphicon glyphicon-signal"></h4><br/>Indicadores
                </div>               
              </div>
            </div>
            <div class="col-xs-12 col-sm-10 bhoechie-tab">
            <h6 id="nombreIndicador" style="text-align:center ; height: 20px;">Indicadores de desempeño para el proceso ' . $idTematica . ' :</h6>
            <hr style="margin-top: 0px;">
<!-- Primer SLIDER -->
                <div class="bhoechie-tab-content active" style="padding-left: 5px;padding-top: 10px;padding-block-end: 10px;">
                    <center>';
        $cont = 0;
        $somb2 = true;
        foreach ($respIn as $row => $item) {
            $color = ($somb2) ? "#eee" : "#fff";
            $idIndicadorC = $item[0];
            $posicionInd = $item[3];
            $cons = new ConsultasModel();
            $resp = $cons->consultaDadiiConIndicador($idDimension, $idTematica, $idIndicadorC);
            if ($resp == 'error') {
                echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <li>Debe seleccionar todos los filtros</li></div>";
            } else {
                $nombreDimension = $resp[0];
                $nombreTematica = $resp[1];
                $nombreIndicador = $resp[2];
                $labels = $resp[3];
                $fecha2 = $resp[4];
                $series = $resp[5];
                $desagregacionTematicaFicha = $resp[6];
                $tipoGrafico = $resp[7];
                $totalDatos = $resp[8];
                $data = $resp[9];
                $rango = $resp[10];
                $unidadMedicion = $resp[11];
                $periodicidad = $resp[12];
                $maxValue = $this->setMaxValue($resp[13]);
            }
            echo '<div class = "row" style = "background-color:' . $color . '; 
                                border-radius: 5px; border: 1px solid ' . $color . '; padding-left:0px;">
                                <div class = "col-sm-12" style = "padding-left:0px;padding-right: 0px;">
                                       <h7 class = "col-sm-12" style="font-weight: 600;">' . $idIndicadorC . ' <br></h7>
                                       <h7 style = "text-align:justify; font-size: 13px;font-weight: 600; ">Periodicidad:</h7><h7 style = "text-align:justify;font-size: 13px; font-weight: 400; ">' . $periodicidad . '</h7>
                                    <div class = "col-sm-9" style = "padding-left:0px;padding-right: 8px;">
                                        <a href="/views/resources/fichasDadii/' . $idIndicadorC . '.xlsx" download  title="Descargue la ficha técnica del indicador"> <h7 style = "text-align:justify; font-weight: 590; line-height: 1.4 !important;">' . $nombreIndicador . '
                                        </h7>
                                        </a> 
                                    </div>
                                    <div class = "col-sm-3" style = "padding-left:0px;padding-right: 0px;">
                                        <h7 style = "text-align:left;line-height: 1.0 !important;">';
            $label = $data["labels"];
            $dato = $data["datasets"][0]["data"];
            for ($k = 0; $k < count($dato); $k++) {
                if (isset($label[$k]) && isset($dato[$k])) {
                    echo '<li style="font-size: 13px;">' . $label[$k] . ': ' . $dato[$k] . '%</li>';
                }
            }
            echo '</h7>
                                    </div>
                                    <div class = "col-sm-8"><br></div>
                                    </div>                                   
                </div>';

            $cont++;
            $somb2 = !$somb2;
        }
        echo '</center>
                </div>
            </div>
        </div>
  </div>
</div>
</div>
<script>
$(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings("a.active").removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});
</script>
';
        echo '<div  class="tab-con col-xs-12 col-sm-4" id="tab-con" style="margin-left:0px; padding-block-end: 15px;">            
                        <div id="grafico" class="tab-pane fade in active"> 
                          <div class="row">                           
                            <h6 id="nombreIndicador" style="text-align:center ; height: 70px;">Promedio de cumplimiento en la escala de desempeño:</h6> 
                               <div id="graf" class="col-xs-12 col-sm-12" style="background-color:#fff; padding: 0px 15px 10px;">
                                <canvas id="chart_' . $idTematica . '" ></canvas>';
        $cons = new ConsultasController();
        $model = new ConsultasModel();
        $resp = $model->IndicadoresPorProceso($idTematica);
        echo '  <script>
                    var ctx = document.getElementById("chart_' . $idTematica . '").getContext("2d");';
        echo $cons->DonaDadii(json_encode($resp));
        echo '  </script>';
        echo '   </div>
            </div>
            </div>
             </div>';
        echo "</div>";
    }

    /**
     * <b>consultaDadiiGeneralIndicadores</b>
     * <br>
     * Trae todos los indicadores del DADII y visualiza todos los indicadores
     * @param string $idConjunto Consulta todos los indicadores pertenecientes al conjunto
     */
    public function consultaDadiiGeneralIndicadores($idConjunto)
    {
        $dim = new Dimensiones();
        $nomDim = $dim->listarDimensionesPorConjunto($idConjunto);
        $nomMacro = $dim->listarDimensionesPorMacroproceso($idConjunto);
        $tem = new Tematicas();
        $nomTem = $tem->listarTematicasPorConjunto($idConjunto);
        //        $nomProc = $tem->listarTematicasPorProceso($idConjunto);
        $ind = new Indicadores();
        $respIn = $ind->contarIndicadoresDadii($idConjunto);
        $estrategico = $nomMacro[0];
        $misional = $nomMacro[1];
        $apoyo = $nomMacro[2];
        $control = $nomMacro[3];

        echo '
            <div class=" col-xs-12 col-sm-12" id="tab-con" >';
        echo '<div  class="tab-con col-xs-12 col-sm-12" id="tab-con">
                        <div id="grafico" class="tab-pane fade in active"> 
                          <div class="row">
                           <div>
                            <h6 id="nombreIndicador" style="text-align:center ; height: 70px;">Promedio general para todos los indicadores de desempeño</h6> 
                               <div id="graf" class="col-xs-12 col-sm-6" style="background-color:#fff; padding: 0px 15px 10px;">
                                <canvas id="chart_" ></canvas>';
        $cons = new ConsultasController();
        $model = new ConsultasModel();
        $resp = $model->promedioIndicadoresGeneralDadii();
        $data = $resp[0];
        $cantidadDatos = $resp[1];
        echo '
                <script>
                    var ctx = document.getElementById("chart_").getContext("2d");';
        echo $cons->ColorBarraDadii(json_encode($data));
        echo '  </script>';
        echo '   
                                </div>
                                <div id="graf" class="label-dadii col-xs-12 col-sm-6" style="text-align:center; background-color:#fff;">
                                Cálculo por trimestre
                                </div>
                                <h7>Este promedio se realiza teniendo en cuenta el cumplimiento de todos los indicadores de desempeño (<b>' . $respIn[0] . '</b>) representados en los cuatro trimestres del año,
                                cada trimestre puede variar según la frecuencia de medición para cada uno de los indicadores.</h7>
                                <div style="margin-left:10px;">
                                <li><h7>El cálculo para el primer trimestre se realizó con <b>' . $cantidadDatos[0] . '</b> indicadores. </h7></li>
                                <li><h7>El cálculo para el segundo trimestre se realizó con <b>' . $cantidadDatos[1] . '</b> indicadores. </h7></li>
                                <li><h7>El cálculo para el tercer trimestre se realizó con <b>' . $cantidadDatos[2] . '</b> indicadores. </h7></li>
                                <li><h7>El cálculo para el cuarto trimestre se realizó con <b>' . $cantidadDatos[3] . '</b> indicadores. </h7></li><br>
                                </div>
                           </div>';
        echo '                                                
                          </div>
                         </div>
                      </div>';
        //        INFORMACIÓN        
        echo '
<div class=" col-xs-12 col-sm-12" id="tab-con" >
	<div class="row">
        <div class="col-xs-12 col-sm-12 bhoechie-tab-container">        
            <div class="col-xs-12 col-sm-2 bhoechie-tab-menu">
              <div class="list-group">
                <a href="#" class="list-group-item active text-center">
                  <h4 class="glyphicon glyphicon-tasks"></h4><br/>Valores de referencia
                </a>
                <a href="#" class="list-group-item text-center">
                <img src="/app/controller/documentos/DADII/Estratégico.png" style="border-radius: 100px;width: 50px; margin-right:8px;">
                  <h4 class="glyphicon"></h4><br/>Macroprocesos Estratégicos
                </a>
                <a href="#" class="list-group-item text-center">
                <img src="/app/controller/documentos/DADII/Misional.png" style="border-radius: 100px;width: 50px; margin-right:8px;">
                  <h4 class="glyphicon"></h4><br/>Macroprocesos Misionales
                </a>
                <a href="#" class="list-group-item text-center">
                <img src="/app/controller/documentos/DADII/Apoyo.png" style="border-radius: 100px;width: 50px; margin-right:8px;">
                  <h4 class="glyphicon"></h4><br/>Macroprocesos de Apoyo
                </a>
                <a href="#" class="list-group-item text-center">
                <img src="/app/controller/documentos/DADII/Control Seguimiento.png" style="border-radius: 100px;width: 50px; margin-right:8px;">
                  <h4 class="glyphicon"></h4><br/>Macroprocesos de Seguimiento y Evaluación
                </a>
              </div>
            </div>
            

            <div class="col-xs-12 col-sm-10 bhoechie-tab">
            <h6 id="nombreIndicador" style="text-align:center ; height: 20px;">Información general de los indicadores de desempeño:</h6>
            <hr>
<!-- Primer SLIDER -->
                <div class="bhoechie-tab-content active">
                    <center>
                    <div class="col-xs-12 col-sm-2"></div>
                    <div class="col-xs-12 col-sm-8" style="text-align: justify;">
                    <h7>Los valores cualitativos que se toman como referencia para determinar si el
                    avance y cumplimiento de las metas obtenidas en el periodo es Sobresaliente, Satisfactorio, Medio, Bajo y Crítico.
                    </h7>
                        <div class="form-group col-xs-12 col-sm-12">
                          <label class="label-dadii" style="margin-bottom: 6px;">Valores de Referencia:</label>
                          <div class="tab-informacion col-xs-12 col-sm-12" id="tab-informacion" style="text-align:center;">
                          <h7> Rangos de cumplimiento </h7>
                          <div class="tab-informacion col-xs-12 col-sm-6" id="tab-informacion">
                          <h7> Desempeño</h7>
                         </div>
               </div>
               <div class="tab-informacion col-xs-12 col-sm-12" id="tab-informacion" style="text-align:center;">
                          <h7><40%<h7>
                          <div class="tab-informacion col-xs-12 col-sm-6" id="tab-informacion" style="background:rgba(255,0,0,0.5); border-color:rgba(255,0,0,0.8)">
                          Critico
                          </div>
              </div>
               <div class="tab-informacion col-xs-12 col-sm-12" id="tab-informacion" style="text-align:center;">
                <h7>40% - 59%<h7>
                   <div class="tab-informacion col-xs-12 col-sm-6" id="tab-informacion" style="background:rgba(226,107,10,0.5); border-color:rgba(226,107,10,0.8)">
                   Bajo
                   </div>
              </div>
               <div class="tab-informacion col-xs-12 col-sm-12" id="tab-informacion" style="text-align:center;">
                <h7>60% - 69%<h7>
                   <div class="tab-informacion col-xs-12 col-sm-6" id="tab-informacion" style="background:rgba(255,255,0,0.5); border-color:rgba(255,255,0,0.8)">
                   Medio
                   </div>
              </div>
               <div class="tab-informacion col-xs-12 col-sm-12" id="tab-informacion" style="text-align:center;">
                <h7>70% - 79%<h7>
                   <div class="tab-informacion col-xs-12 col-sm-6" id="tab-informacion" style="background:rgba(146,208,80,0.5); border-color:rgba(146,208,80,0.8)">
                   Satisfactorio
                   </div>
              </div>   
               <div class="tab-informacion col-xs-12 col-sm-12" id="tab-informacion" style="text-align:center;">
                <h7>>=80%<h7>
                   <div class="tab-informacion col-xs-12 col-sm-6" id="tab-informacion" style="background:rgba(0,176,80,0.5); border-color:rgba(0,176,80,0.8)">
                   Sobresaliente
                   </div>
              </div>              
            </div>
       </form>
             </center>
       </div>
       
<!-- Segundo SLIDER-->
                <div class="bhoechie-tab-content">
                    <center>';
        foreach ($estrategico as $row => $nomD) {
            echo '       <div  class="col-xs-12 col-sm-6" style="margin-left:0px; ">
                        <div class="panel with-nav-tabs panel-primary">
                            <div class="panel-heading-dadii">
                                <ul class="nav nav-tabs">
                                    <li class = "active">
                                        <a href = "#tab" data-toggle = "tab"><b>';
            echo $nomD[1];
            echo '</b> </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="panel-body-dadii">
                                <div class="tab-content">
                                        <div class="panel panel-default" style="margin-bottom: 0px;">
                                            <div class="panel-body" style="padding: 0px;">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <div class="checkbox checbox-switch switch-info">
                                                        <label style="padding-left: 1px;">
                                                        <div class="label-dadii" >Procesos</div>
                                                        ';
            $nomProc = $tem->listarTematicasPorProceso($idConjunto, $nomD[0]);
            $P_estrategico = $nomProc[0];
            foreach ($P_estrategico as $row => $nomT) {
                echo '  <a title="Consulte los indicadores."  href="/consulta-indicadores/dadii/' . $nomD[0] . '/' . $nomT[0] . '"> <li><h7>' . $nomT[1] . '</h7></li> </a>';
            }
            echo '
                                                        </label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        }
        echo '           </center>
                </div>
<!-- Tercer SLIDER -->
                <!-- hotel search -->
                <div class="bhoechie-tab-content">
                    <center>';
        foreach ($misional as $row => $nomD) {
            echo '       <div  class="col-xs-12 col-sm-6" style="margin-left:0px; ">
                        <div class="panel with-nav-tabs panel-primary">
                            <div class="panel-heading-dadii">
                                <ul class="nav nav-tabs">
                                    <li class = "active">
                                        <a href = "#tab" data-toggle = "tab"><b>';
            echo $nomD[1];
            echo '</b> </a>
                                    </li>
                                </ul>
                            </div>
                             <div class="panel-body-dadii">
                                <div class="tab-content">
                                        <div class="panel panel-default" style="margin-bottom: 0px;">
                                            <div class="panel-body" style="padding: 0px;">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <div class="checkbox checbox-switch switch-info">
                                                        <label style="padding-left: 1px;"><div class="label-dadii" >Procesos</div>';
            $nomProc = $tem->listarTematicasPorProceso($idConjunto, $nomD[0]);
            $P_misional = $nomProc[1];
            foreach ($P_misional as $row => $nomT) {
                echo '  <a title="Consulte los indicadores." href="/consulta-indicadores/dadii/' . $nomD[0] . '/' . $nomT[0] . '"> <li><h7>' . $nomT[1] . '</h7></li> </a>';
            }
            echo '
                                                   </label>
                                               </div>
                                            </div>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        }
        echo '          </center>
                </div>
<!--Cuarto SLIDER -->
                <div class="bhoechie-tab-content">
                    <center>';
        foreach ($apoyo as $row => $nomD) {
            echo '       <div  class="col-xs-12 col-sm-6" style="margin-left:0px; ">
                        <div class="panel with-nav-tabs panel-primary">
                            <div class="panel-heading-dadii">
                                <ul class="nav nav-tabs">
                                    <li class = "active">
                                        <a href = "#tab" data-toggle = "tab"><b>';
            echo $nomD[1];
            echo '</b> </a>
                                    </li>
                                </ul>
                            </div>
                             <div class="panel-body-dadii">
                                <div class="tab-content">
                                        <div class="panel panel-default" style="margin-bottom: 0px;">
                                            <div class="panel-body" style="padding: 0px;">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <div class="checkbox checbox-switch switch-info">
                                                        <label style="padding-left: 1px;"><div class="label-dadii" >Procesos</div>';
            $nomProc = $tem->listarTematicasPorProceso($idConjunto, $nomD[0]);
            $P_apoyo = $nomProc[2];
            foreach ($P_apoyo as $row => $nomT) {
                echo '  <a title="Consulte los indicadores." href="/consulta-indicadores/dadii/' . $nomD[0] . '/' . $nomT[0] . '"> <li><h7>' . $nomT[1] . '</h7></li> </a>';
            }
            echo '
                                                        </label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        }
        echo '
                    </center>
                </div>
       <!-- Quinto SLIDER -->
                <div class="bhoechie-tab-content">
                    <center>';
        foreach ($control as $row => $nomD) {

            echo '       <div  class="col-xs-12 col-sm-6" style="margin-left:0px; ">
                        <div class="panel with-nav-tabs panel-primary">
                            <div class="panel-heading-dadii">
                                <ul class="nav nav-tabs">
                                    <li class = "active">
                                        <a href = "#tab" data-toggle = "tab"><b>';
            echo $nomD[1];
            echo '</b> </a>
                                    </li>
                                </ul>
                            </div>
                             <div class="panel-body-dadii">
                                <div class="tab-content">
                                        <div class="panel panel-default" style="margin-bottom: 0px;">
                                            <div class="panel-body" style="padding: 0px;">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <div class="checkbox checbox-switch switch-info">
                                                        <label style="padding-left: 1px;"><div class="label-dadii" >Procesos</div>';
            $nomProc = $tem->listarTematicasPorProceso($idConjunto, $nomD[0]);
            $P_control = $nomProc[3];
            foreach ($P_control as $row => $nomT) {
                echo ' <a title="Consulte los indicadores." href="/consulta-indicadores/dadii/' . $nomD[0] . '/' . $nomT[0] . '"> <li><h7>' . $nomT[1] . '</h7></li> </a>';
            }
            echo '</label>
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        }
        echo '
                    </center>
                </div>
            </div>
        </div>
  </div>
</div>
</div>
<script>
$(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings("a.active").removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});
</script>
';
    }

    /**
     * <b>ColorBarraDadii</b>
     * <br>
     * Genera un grafico de tipo barras con lineas coloreadas por la escala de cumplimiento del DADII, partiendo de 0 hasta 100
     * @param string $data Información para graficar el indicador
     */
    public function ColorBarraDadii($data)
    {
        return " 
            var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: $data,
            options: {responsive: true,	
                       legend: {display:false,},
		       scales: {yAxes: [{gridLines: {drawBorder: false,
				                   color: ['rgba(0,176,80,0.3)', 'rgba(146,208,80,0.3)', 'rgba(255,255,0,0.5)', 'rgba(226,107,10,0.3)', 'rgba(255,0,0,0.3)']
						     },
				         ticks: {min: 0,
						 max: 100,
						 stepSize: 20                                                
						},
					scaleLabel: {display: true,
                                                     labelString: 'Porcentaje'}
                                      }]
				}
		     }  
            });";
    }

    /**
     * <b>DonaDadii</b>
     * <br>
     * Genera un grafico de tipo dona 
     * @param string $data Información para graficar el indicador
     */
    public function DonaDadii($data)
    {
        return " 
                var chart = new Chart(ctx, {
                                        type: 'doughnut',
                                        data:$data,
                                        options: {responsive: true,
                                                  legend: { display: false,}}
                                        });";
    }

    /**
     * <b>drawBarChartMaxValue</b>
     * <br>
     * Genera el gráfico de barras de un indicador, teniendo un valor máximo definido
     * @param array $data Información para graficar el indicador
     * @param string $unidadMedicion Unidad de medición del indicador
     * @param float $maxValue Valor máximo para el gráfico
     */
    public function drawBarChartMaxValue($data, $unidadMedicion, $maxValue)
    {
        return " 
            var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: $data,
            options: {
                barValueSpacing: 200,
                responsive: true,
                maintainAspectRatio: true,
                scaleBeginAtZero: false,
                barBeginAtOrigin: true,
                legend: {
                    position: 'right',
                    labels: {
                       usePointStyle: false
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                            suggestedMax: $maxValue
                        },
                        scaleLabel: {
                            display: true,
                            labelString: '" . $unidadMedicion . "'
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Periodo'
                        },
                    }],
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (Number.isInteger(tooltipItem.yLabel)) {
                                label += tooltipItem.yLabel;
                            }else{
                                label += tooltipItem.yLabel.toFixed(2);
                            }                            
                            label = label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            return label;
                        }
                    }
                }
              }
            });";
    }

    /**
     * <b>drawHorizontalBarChartMaxValue</b>
     * <br>
     * Genera el gráfico de barras horizontales de un indicador, 
     * teniendo un valor máximo definido
     * @param array $data Información para graficar el indicador
     * @param string $unidadMedicion Unidad de medición del indicador
     * @param float $maxValue Valor máximo para el gráfico
     */
    public function drawHorizontalBarChartMaxValue($data, $unidadMedicion, $maxValue)
    {
        return " 
            var myBarChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: $data,
            options: {
                responsive: true,
                barValueSpacing: 200,
                scaleBeginAtZero:false,
                barBeginAtOrigin:true,
                scales: {
                    xAxes: [{
                        ticks: {
                            display: false
                        },
                        scaleLabel: {
                            display: true,
                            labelString: '" . $unidadMedicion . "'
                        },
                        gridLines: {
                            display: false
                        }, 
                        stacked: true
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        },
                        gridLines: {
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Periodo'
                        },
                        stacked: true
                    }]
                },
                legend: {
                    position: 'right',
                    labels: {
                        usePointStyle: false
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (Number.isInteger(tooltipItem.xLabel)) {
                                label += tooltipItem.xLabel;
                            }else{
                                label += tooltipItem.xLabel.toFixed(2);
                            }                            
                            label = label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            return label;
                        }
                    }
                }
              }
            });";
    }

    /**
     * <b>drawBarChartMaxValueODS</b>
     * <br>
     * Genera el gráfico de barras para un indicador de los
     * Objetivos de Desarrollo Sostenible
     * @param array $data Información para graficar el indicador
     */
    public function drawBarChartMaxValueODS($data)
    {
        return " 
            var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: $data,
            options: {
                borderWidth: 4,
                barValueSpacing: 20,
                responsive: true,
                maintainAspectRatio: true,
                scaleBeginAtZero:true,
                barBeginAtOrigin:true,
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                            suggestedMax: 100
                        }
                    }],
                    xAxes: [{
                        display: false
                    }]
                },
                tooltips: {
                    bodyFontSize: 11,
                    position: 'average',
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var value = data.datasets[0].data[tooltipItem.datasetIndex];
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (value == 1.543210123456) {
                                value = 0;
                            }
                            if (label) {
                                label += ': ';
                            }
                            label += (Number(value)).toFixed(2);
                            return label;
                        }
                    }
                }
              }
            });";
    }

    /**
     * <b>drawStackedBarChartMaxValue</b>
     * <br>
     * Genera el gráfico de barras apiladas de un indicador, 
     * teniendo un valor máximo definido
     * @param array $data Información para graficar el indicador
     * @param string $unidadMedicion Unidad de medición del indicador
     * @param float $maxValue Valor máximo para el gráfico
     */
    public function drawStackedBarChartMaxValue($data, $unidadMedicion, $maxValue)
    {
        return " 
            var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: $data,
            options: {
                barValueSpacing: 200,
                responsive:true,
                scaleBeginAtZero:false,
                barBeginAtOrigin:true,
                legend: {
                    position: 'right',
                    labels: {
                       usePointStyle: false
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                            suggestedMax: $maxValue
                        },
                        scaleLabel: {
                            display: true,
                            labelString: '" . $unidadMedicion . "'
                        }
                    }],
                    xAxes: [{
                        stacked: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Periodo'
                        },
                    }],
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (Number.isInteger(tooltipItem.yLabel)) {
                                label += tooltipItem.yLabel;
                            }else{
                                label += tooltipItem.yLabel.toFixed(2);
                            }
                            label = label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            return label;
                        }
                    }
                }
              }
            });";
    }

    /**
     * <b>drawBarChartComunaMaxValue</b>
     * <br>
     * Genera el gráfico de barras apiladas de un indicador, 
     * para las consultas por comunas
     * @param array $data Información para graficar el indicador
     * @param string $unidadMedicion Unidad de medición del indicador
     * @param float $maxValue Valor máximo para el gráfico
     */
    public function drawBarChartComunaMaxValue($data, $unidadMedicion, $maxValue)
    {
        return " 
            var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: $data,
            options: {
                barValueSpacing: 200,
                responsive:true,
                scaleBeginAtZero:false,
                barBeginAtOrigin:true,
                legend: {
                    position: 'bottom',
                    labels: {
                       usePointStyle: false
                    }
                },
                scales: {
                    yAxes: [{
                    stacked:true,
                        ticks: {
                            min: 0,
                            suggestedMax: $maxValue
                        },
                        scaleLabel: {
                            display: true,
                            labelString: '" . $unidadMedicion . "'
                        }
                    }],
                    xAxes: [{
                    stacked:true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Periodo'
                        },
                    }],
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (Number.isInteger(tooltipItem.yLabel)) {
                                label += tooltipItem.yLabel;
                            }else{
                                label += tooltipItem.yLabel.toFixed(2);
                            }
                            label = label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            return label;
                        }
                    }
                }
              }
            });";
    }

    /**
     * <b>drawBarChart</b>
     * <br>
     * Genera el gráfico de barras de un indicador
     * @param array $data Información para graficar el indicador
     * @param string $unidadMedicion Unidad de medición del indicador
     */
    public function drawBarChart($data, $unidadMedicion)
    {
        return " 
            var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: $data,
            options: {
                barValueSpacing: 200,
                responsive:true,
                maintainAspectRatio: true,
                scaleBeginAtZero:false,
                barBeginAtOrigin:true,
                legend: {
                    position: 'right',
                    labels: {
                       usePointStyle: false
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0
                        },
                        scaleLabel: {
                            display: true,
                            labelString: '" . $unidadMedicion . "'
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Periodo'
                        },
                    }],
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (Number.isInteger(tooltipItem.yLabel)) {
                                label += tooltipItem.yLabel;
                            }else{
                                label += tooltipItem.yLabel.toFixed(2);
                            }
                            label = label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            return label;
                        }
                    }
                }
              }
            });";
    }

    /**
     * <b>drawBarChartCalidadEducativa</b>
     * <br>
     * Genera el gráfico de barras de un indicador, para el 
     * visualizador de datos de Calidad Educativa
     * @param array $data Información para graficar el indicador
     * @param string $unidadMedicion Unidad de medición del indicador
     */
    public function drawBarChartCalidadEducativa($data, $unidadMedicion)
    {
        return " 
            var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: $data,
            options: {
                barValueSpacing: 200,
                responsive:true,
                maintainAspectRatio: true,
                scaleBeginAtZero:false,
                barBeginAtOrigin:true,
                legend: {
                    position: 'bottom',
                    labels: {
                       usePointStyle: false
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0
                        },
                        scaleLabel: {
                            display: true,
                            labelString: '" . $unidadMedicion . "'
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Periodo'
                        },
                    }],
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.yLabel.toFixed(4);
                            label = label.toString().replace(/\B(?=(\d{5})+(?!\d))/g, ',');
                            return label;
                        }
                    }
                }
              }
            });";
    }

    /**
     * <b>drawLineChartCalidadEducativa</b>
     * <br>
     * Genera el gráfico de lineas de un indicador, para el 
     * visualizador de datos de Calidad Educativa
     * @param array $data Información para graficar el indicador
     * @param string $unidadMedicion Unidad de medición del indicador
     */
    public function drawLineChartCalidadEducativa($data, $unidadMedicion)
    {
        return " var myLineChart = new Chart(ctx, {
              type: 'line',
              data: $data,
              options: {
                barValueSpacing: 20,
                responsive:true,
                scaleBeginAtZero:false,
                barBeginAtOrigin:true,
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true
                    }
                },
                scales: {
                  yAxes: [{
                    ticks: {
                    },
                    scaleLabel: {
                        display: true,
                        labelString: '" . $unidadMedicion . "'
                    }
                  }],
                  xAxes: [{
                      scaleLabel: {
                        display: true,
                        labelString: 'Periodo'
                      }
                    }],
                },
              }
            }); ";
    }

    /**
     * <b>drawDoughnutChart</b>
     * <br>
     * Genera el gráfico de dona de un indicador
     * @param array $data Información para graficar el indicador
     * @param string $unidadMedicion Unidad de medición del indicador
     */
    public function drawDoughnutChart($data, $unidadMedicion)
    {
        return " 
            
            var myBarChart = new Chart(ctx, {
            type: 'pie',
            data: $data,
            options: {
                barValueSpacing: 200,
                responsive:true,
                scaleBeginAtZero:false,
                barBeginAtOrigin:true,
                legend: {
                    position: 'bottom',
                    labels: {
                       usePointStyle: false
                    }
                }
            }
            });";
    }

    /**
     * <b>drawLineChartODSMaxValue</b>
     * <br>
     * Genera el gráfico de lineas de un indicador de los Objetivos de 
     * Desarrollo Sostenible, teniendo un valor máximo definido
     * @param array $datasets Información para graficar el indicador
     * @param array $labels Labels a incluir en el gráfico
     * @param string $unidadMedicion Unidad de medición del indicador
     * @param float $maxValue Valor máximo para el gráfico
     */
    public function drawLineChartODSMaxValue($datasets, $labels, $unidadMedicion, $maxValue)
    {
        echo "
            <script>
                var ctx = document.getElementById('myChart').getContext('2d');
                var datasets_js = [];
            </script>
         ";

        for ($i = 0; $i < count($datasets); $i++) {
            $dataset = $datasets[$i];
            echo "
                <script>
                    var eventCounts_" . $i . " = " . json_encode($dataset['data']) . ";
                    datasets_js.push(
                        {   
                            'label': '" . $dataset['label'] . "',
                            'data': factorData(eventCounts_" . $i . "),
                            'backgroundColor': '" . $dataset['backgroundColor'] . "',
                            'borderColor': '" . $dataset['borderColor'] . "',
                            'lineTension': 0,
                            'spanGaps': true,
                            'fill': '" . $dataset['fill'] . "',
                            'radius': '" . $dataset['radius'] . "',
                            'borderDash': " . ($dataset['borderDash']) . ",
                            'pointStyle': '" . $dataset['pointStyle'] . "'
                        }
                    );
                    console.log(datasets_js);
                </script>";
        }

        echo "  <script>
                    var chart = new Chart(ctx, 
                        {
                            type: 'line',
                            data: {
                                'labels': " . json_encode($labels) . ",
                                'datasets': datasets_js
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true,
                                            suggestedMin: 0,
                                            suggestedMax:'" . $maxValue . "'
                                        },
                                        scaleLabel: {
                                            display: true,
                                            labelString: '" . $unidadMedicion . "'
                                        }
                                    }],
                                    xAxes: [{
                                        scaleLabel: {
                                            display: true,
                                            labelString: 'Periodo'
                                        }
                                    }],
                                },
                                barValueSpacing: 20,
                                responsive:true,
                                scaleBeginAtZero:false,
                                barBeginAtOrigin:true,
                                legend: {
                                    display: false,
                                    labels: {
                                        usePointStyle: true
                                    }
                                },
                                tooltips: {
                                    callbacks: {
                                        label: function(tooltipItem, data) {
                                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            label += tooltipItem.yLabel.toFixed(1);
                                            label = label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    );
                </script>";
    }

    /**
     * <b>drawMap</b>
     * <br>
     * Genera un mapa para un indicador
     * @param array $data Información para graficar el indicador
     * @param string $unidadMedicion Unidad de medición del indicador
     */
    public function drawMap($data, $unidadMedicion)
    {
        $years = $data['labels'];
        $datasets = $data['datasets'];
        $dataAll = array();
        $values = array();

        for ($i = 0; $i < count($datasets); $i++) {
            $dataset = $datasets[$i];
            for ($j = 0; $j < count($years); $j++) {
                $value = $dataset['data'][$j];
                $values[] = $value;
            }
        }

        $maxValue = max($values);
        $step = ceil($maxValue / 15);

        $colors = ["#dd8125", "#ef8b28", "#ffa02e", "#ffc939", "#ffff51", "#7499e2", "#6889cb", "#5c79b4", "#506a9d", "#445a85", "#384a6e", "#2d3b57", "#2d3bfa", "#a3bd31", "#617700"];
        $ranges = array();

        $min = 0;
        $max = 0;

        for ($k = 0; $k < 15; $k++) {
            if ($k === 0) {
                $min = 0;
                $max = $step;
            } else {
                $min = ($step * $k) + $k;
                $max = $min + $step;
            }
            $ranges[] = $min . ' - ' . $max;
            for ($l = 0; $l < count($datasets); $l++) {
                $dataset = $datasets[$l];
                for ($m = 0; $m < count($years); $m++) {
                    $year = $years[$m];
                    $label = explode(" - Total", $dataset['label'])[0];
                    $value = $dataset['data'][$m];
                    $color = $colors[$k];
                    if (($min <= $value) && ($value <= $max)) {
                        $dataAll[$label][$year][] = [$value, $color];
                    }
                }
            }
        }

        $year = $years[0];

        echo '<link href="/views/resources/css/perfiles-comunas.css" rel="stylesheet" media="all">';
        echo "
            <script>
                var allData = " . json_encode($dataAll, JSON_FORCE_OBJECT) . ";
                var years = " . json_encode($years, JSON_FORCE_OBJECT) . ";
                console.log(allData);
                var year = '$year';
                console.log(year);
            </script>";
        echo '
            <div class="row">
                <div id="mapa_container" class="col-xs-12 col-sm-8">
                    <div class="col-sm-9">
                        <div id="mapa"></div>
                        <script>
                            var initX;
                            var mouseClicked = false;
                            var s = 1;
                            var width = 400;
                            var height = 450;
                            var rotated = 90;
                            var projection = d3.geo.mercator()
                                .center([-76.50, 3.43])
                                .translate([height / 2, width / 2])
                                .scale(140000);
                            var svg = d3.select("div#mapa").append("svg")
                                .attr("width", width)
                                .attr("height", height)
                                .on("mousedown", function () {
                                    d3.event.preventDefault();
                                    initX = d3.mouse(this)[0];
                                    mouseClicked = true;
                                })
                                .on("mouseup", function () {
                                    if (s !== 1)
                                        return;
                                    rotated = rotated + ((d3.mouse(this)[0] - initX) * 360 / (s * width));
                                    mouseClicked = false;
                                });
                            var offsetL = document.getElementById("mapa").offsetLeft + 10;
                            var offsetT = document.getElementById("mapa").offsetTop + 10;
                            var path = d3.geo.path().projection(projection);
                            var tooltip = d3.select("div#mapa")
                                .append("div")
                                .attr("class", "tooltip hidden");
                            var g = svg.append("g");
                            d3.json("/views/resources/geojson/comunas.geojson", function (json) {
                                g.append("g")
                                    .attr("class", "boundary")
                                    .selectAll("boundary")
                                    .data(json.features)
                                    .enter().append("path")
                                    .attr("name", function (d) {
                                        return d.properties["NOMBRE"];
                                    })
                                    .attr("id", function (d) {
                                        return d.properties["COMUNA"];
                                    })
                                    .style("stroke-width","1px")
                                    .style("stroke","#000")
                                    .style("fill", function(d){
                                        nombreComuna = d.properties["NOMBRE"];
                                        dataYear = allData[nombreComuna][year];
                                        console.log(dataYear);
                                        color = allData[nombreComuna][year][0][1];
                                        console.log(nombreComuna +"-"+ color);
                                        return color;  
                                    })
                                    .on("click", showTooltip)
                                    .on("mousemove", showTooltip)
                                    .on("mouseout", function (d, i) {
                                        tooltip.classed("hidden", true);
                                    })
                                    .attr("d", path);
                            });
                            function showTooltip(d) {
                                nombreComuna = d.properties["NOMBRE"];
                                valor = allData[nombreComuna][year][0][0];
                                label = nombreComuna + " - " + valor;
                                var mouse = d3.mouse(svg.node())
                                    .map(function (d) {
                                        return parseInt(d);
                                    });
                                tooltip.classed("hidden", false)
                                    .attr("style", "left:" + (mouse[0] + offsetL) + "px;top:" + (mouse[1] + offsetT) + "px")
                                    .html(label);
                            }
                        </script>
                    </div>
                    <div class="col-sm-3">
                        <style>
                            .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active{border: 2px solid #215a9a; background: #215a9a;padding: 10px 0px;}
                            .ui-slider-horizontal .ui-slider-range-max{right: 0;background: #d6d6d6;}
                            .ui-slider-pips [class*=ui-slider-pip-selected]{font-weight: bold;color: #215a9a;}
                            .ui-slider-pips .ui-slider-pip-inrange{ color: black; font-weight: bold;}
                            .convencion{width: 15px; height:15px;}
                        </style>
                        <table class= "table table-striped table-bordered table-responsive ajustar-table" style="margin-top: 30px;">
                            <tbody>';
        for ($i = 0; $i < count($colors); $i++) {
            $color = $colors[$i];
            echo '          <tr>
                                    <td class="convencion" style="background-color:' . $color . '; border-color: ' . $color . '; text-align: center;"></td>
                                    <td style="border-color: ' . $color . '; text-align: center; font-size:smaller; padding:0px;">' . $ranges[$i] . '</td>
                                </tr>';
        }
        echo '           </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12" style="margin-top: -10px;">
                    <div class="panel panel-default" style="margin-bottom: 10px; margin-top: 10px; border-color:#ccc;">
                        <div class="panel-body">
                            <p style="text-align:center;">Año: <span id="year-tot">' . $year . ' </span></p>
                            <table class="table table-striped table-bordered table-hover table-responsive" style="font-size: 13px; margin-bottom: 10px;">
                                <tr>
                                    <td>
                                        <div style="margin: 10px 15px 20px 10px; padding: 7px 0px; border: solid 2px #215a9a;" 
                                                id="slider-range-max" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all ui-slider-pips"></div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <script>
                    $(function () {
                        $("#slider-range-max")
                            .slider({
                                range: "max", min: ' . $years[0] . ', max: ' . $years[count($years) - 1] . ', value: ' . $years[0] . ',
                                slide: function (event, ui) {                    
                                    var year = ui.value;
                                    $("#year-tot").text(ui.value);
                                    updateMap(allData, ui.value);
                                }
                            })
                            .slider("pips")
                            .slider("float");
                    });
                    function formatNumber(num) {
                        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
                    }
                    function updateMap(newData, year) {
                        console.log("--------------------------------------------------------------------------------");
                        console.log(year);
                        var svg = d3.select("div#mapa");
                        var g = svg.select("g");
                        console.log(g);
                        d3.json("/views/resources/geojson/comunas.geojson", function (json) {
                                g.select("g")
                                    .attr("class", "boundary")
                                    .selectAll("boundary")
                                    .data(json.features)
                                    .enter().append("path")
                                    .attr("name", function (d) {
                                        return d.properties["NOMBRE"];
                                    })
                                    .attr("id", function (d) {
                                        return d.properties["COMUNA"];
                                    })
                                    .style("stroke-width","1px")
                                    .style("stroke","#000")
                                    .style("fill", function(d){
                                        nombreComuna = d.properties["NOMBRE"];
                                        dataYear = allData[nombreComuna][year];
                                        console.log(dataYear);
                                        color = allData[nombreComuna][year][0][1];
                                        console.log(nombreComuna +"-"+ color);
                                        return color;  
                                    })
                                    .on("click", showTooltip)
                                    .on("mousemove", showTooltip)
                                    .on("mouseout", function (d, i) {
                                        tooltip.classed("hidden", true);
                                    })
                                    .attr("d", path);
                            });                        
                            function showTooltip(d) {
                                nombreComuna = d.properties["NOMBRE"];
                                valor = allData[nombreComuna][year][0][0];
                                label = nombreComuna + " - " + valor;
                                var mouse = d3.mouse(svg.node())
                                    .map(function (d) {
                                        return parseInt(d);
                                    });
                                tooltip.classed("hidden", false)
                                    .attr("style", "left:" + (mouse[0] + offsetL) + "px;top:" + (mouse[1] + offsetT) + "px")
                                    .html(label);
                            }

                    }
                    $(".canvas-holder").hide();
                </script>
            </div>';
    }

    /**
     * <b>drawLineChartMaxValue</b>
     * <br>
     * Genera el gráfico de lineas de un indicador,
     * teniendo un valor máximo definido
     * @param array $data Información para graficar el indicador
     * @param string $unidadMedicion Unidad de medición del indicador
     * @param float $maxValue Valor máximo para el gráfico
     */
    public function drawLineChartMaxValue($data, $unidadMedicion, $maxValue)
    {
        if ($maxValue == "Victimas") {
            return " var myLineChart = new Chart(ctx, {
              type: 'line',
              data: $data,
              options: {
                barValueSpacing: 20,
                responsive:true,
                scaleBeginAtZero:false,
                barBeginAtOrigin:true,
                legend: {
                    position: 'right',
                    labels: {
                        usePointStyle: true
                    }
                },
                scales: {
                  yAxes: [{
                    ticks: {
                        suggestedMin: 0,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: '" . $unidadMedicion . "'
                    }
                  }],
                  xAxes: [{
                      scaleLabel: {
                        display: true,
                        labelString: 'Periodo'
                      }
                    }],
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (Number.isInteger(tooltipItem.yLabel)) {
                                label += tooltipItem.yLabel;
                            }else{
                                label += tooltipItem.yLabel.toFixed(2);
                            }
                            label = label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            return label;
                        }
                    }
                }
              }
            }); ";
        } else {
            return " var myLineChart = new Chart(ctx, {
              type: 'line',
              data: $data,
              options: {
                barValueSpacing: 20,
                responsive:true,
                scaleBeginAtZero:false,
                barBeginAtOrigin:true,
                legend: {
                    position: 'right',
                    labels: {
                        usePointStyle: true
                    }
                },
                scales: {
                  yAxes: [{
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax:'" . $maxValue . "'
                    },
                    scaleLabel: {
                        display: true,
                        labelString: '" . $unidadMedicion . "'
                    }
                  }],
                  xAxes: [{
                      scaleLabel: {
                        display: true,
                        labelString: 'Periodo'
                      }
                    }],
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (Number.isInteger(tooltipItem.yLabel)) {
                                label += tooltipItem.yLabel;
                            }else{
                                label += tooltipItem.yLabel.toFixed(2);
                            }
                            label = label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            return label;
                        }
                    }
                }
              }
            }); ";
        }
    }

    /**
     * <b>drawLineChartMaxValue</b>
     * <br>
     * Genera el gráfico de lineas de un indicador
     * @param array $data Información para graficar el indicador
     * @param string $unidadMedicion Unidad de medición del indicador
     */
    public function drawLineChart($data, $unidadMedicion)
    {
        return " var myLineChart = new Chart(ctx, {
              type: 'line',
              data: $data,
              options: {
                barValueSpacing: 20,
                responsive:true,
                scaleBeginAtZero:false,
                barBeginAtOrigin:true,
                legend: {
                    position: 'right',
                    labels: {
                        usePointStyle: true
                    }
                },
                scales: {
                  yAxes: [{
                    ticks: {
                    },
                    scaleLabel: {
                        display: true,
                        labelString: '" . $unidadMedicion . "'
                    }
                  }],
                  xAxes: [{
                      scaleLabel: {
                        display: true,
                        labelString: 'Periodo'
                      }
                    }],
                },
              }
            }); ";
    }

    /**
     * <b>drawLineChartMaxValue</b>
     * <br>
     * Genera el gráfico de área de un indicador
     * @param array $data Información para graficar el indicador
     * @param string $unidadMedicion Unidad de medición del indicador
     */
    public function drawAreaChart($data, $unidadMedicion)
    {
        return " var myAreaChart = new Chart(ctx, {
              type: 'line',
              data: $data,
              options: {
                barValueSpacing: 20,
                responsive:true,
                scaleBeginAtZero:false,
                barBeginAtOrigin:true,
                legend: {
                    position: 'right',
                    labels: {
                    fill: true,
                        usePointStyle: true
                    }
                },
                scales: {
                  yAxes: [{
                    ticks: { 
                    },
                    scaleLabel: {
                        display: true,
                        labelString: '" . $unidadMedicion . "'
                    }
                  }],
                  xAxes: [{
                      scaleLabel: {
                        display: true,
                        labelString: 'Periodo'
                      }
                    }],
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (Number.isInteger(tooltipItem.yLabel)) {
                                label += tooltipItem.yLabel;
                            }else{
                                label += tooltipItem.yLabel.toFixed(2);
                            }
                            label = label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            return label;
                        }
                    }
                }
              }
            }); ";
    }

    /**
     * <b>drawBubbleChart</b>
     * <br>
     * Genera un gráfico de burbuja de prueba para un indicador
     * @param array $data Información para graficar el indicador
     * @param string $unidadMedicion Unidad de medición del indicador
     */
    public function drawBubbleChart($data, $unidadMedicion)
    {

        echo '
            var myAreaChart = new Chart(ctx, {
              type: "bubble",
    data: {
      datasets: [
        {
          label: ["Comuna 1"],
          backgroundColor: "rgba(255,221,50,0.2)",
          borderColor: "yellow",
          data: [{
            x: 2017,
            y: 94334.92,
            r: 115
          }]
        }, {
          label: ["Comuna 2"],
          backgroundColor: "blue",
          borderColor: "blue",
          data: [{
            x: 2017,
            y: 118560.86,
            r: 188
          }]
        }
      ]
    },
    options: {
      title: {
        display: false
        }, 
        scales: {
        yAxes: [{ 
          scaleLabel: {
            display: true,
            labelString: "Población"
          }
        }],
        xAxes: [{ 
          scaleLabel: {
            display: true,
            labelString: "Periodo"
          }
        }]
      }
    }
            }); ';
    }

    /**
     * <b>drawTreemap</b>
     * <br>
     * Genera un gráfico Treemap para un indicador
     * @param array $data Información para graficar el indicador
     * @param int $year Año para la consulta del indicador
     */
    public function drawTreemap($data, $year)
    {
        $position = 0;
        $years = $data['labels'];
        $datasets = $data['datasets'];
        $omitirTotal = $datasets[0]['omitirTotal'];
        $valorTotal = array();
        $allData = array();
        $values = array();
        $colors = array();
        $labels = array();

        if ($year !== $years[0]) {
            $year = $years[0];
        }

        for ($i = 0; $i < count($years); $i++) {
            $year2 = $years[$i];
            $dataChart = array();
            for ($j = 0; $j < count($datasets); $j++) {
                $dataset = $datasets[$j];
                $labelDataset = $dataset['label'];
                if ($omitirTotal && $labelDataset !== 'Total') {
                    $colorDataset = $dataset['borderColor'];
                    $value = $dataset['data'][$position];
                    $values[] = $value;
                    $dataChart[] = ['value' => $value, 'label' => $labelDataset, 'color' => $colorDataset];
                    $labels[] = $labelDataset;
                    $colors[] = $colorDataset;
                } else {
                    $valorTotal[$year2] = $dataset['data'][$position];
                }
            }
            $position++;
            $allData[$year2] = $dataChart;
        }

        usort($dataChart, function ($a, $b) {
            return ($a['value'] < $b['value']) ? 1 : -1;
        });

        echo '
        <div class="row">
            <div class="col-sm-12">
                <script>
                    var allData = ' . json_encode($allData) . ';
                    var valorTotal = ' . json_encode($valorTotal) . ';
                    var dataChart = ' . json_encode($allData[$year]) . ';
                    var ctx = document.getElementById("myChart").getContext("2d");
                    window.chart1 = new Chart(ctx, {
                        type: "treemap",
                        data:{
                            datasets: [{
                                tree: ' . json_encode($allData[$year]) . ',
                                key: "value",
                                groups: ["label"],
                                backgroundColor: function(ctx) {
                                    var value = ctx.dataIndex;
                                    var color = dataChart[value]["color"];
                                    return color;
                                },
                                spacing: 1,
                                borderWidth: 2,
                                fontColor: "white",
                                fontSize: 12,
                                borderColor: "rgba(255,255,255, 1)",
                                rotation:45
                            }]
                        },
                        options: {   
                            title: {
                                display: true,
                                text: "' . $year . '"
                                },
                            legend: {
                                display: false
                            },
                            maintainAspectRatio: false,
                            tooltips: {
                                callbacks: {
                                    title: function (item, data) {
                                        return "";
                                    },
                                    label: function (item, data) {
                                        var dataset = data.datasets[item.datasetIndex];
                                        var dataItem = dataset.data[item.index];
                                        var value = item.index;
                                        var label = dataItem.g;
                                        return (label +": "+ formatNumber((dataItem.v).toFixed(1))).toLocaleString();
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12" style = "padding-left: 0px; padding-right:0px;">
                <div class="panel panel-default" style = "margin-bottom: 10px; margin-top: 10px;">
                    <div class="panel-body">
                        <p>El valor total para el año <span id="year-tot">' . $year . ' </span> es: <span id="year-tot-value" style="color:#215a9a;">' . number_format($valorTotal[$year], 0, ".", ",") . '</span></p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function () {
                $("#slider-range-max")
                    .slider({
                        range: "max", min: ' . $years[0] . ', max: ' . $years[count($years) - 1] . ', value: ' . $years[0] . ',
                        slide: function (event, ui) {                    
                            var anho = ui.value;
                            $("#year").text(ui.value);
                            $("#year-tot").text(ui.value);
                            $("#year-tot-value").text(formatNumber(valorTotal[ui.value]));
                            updateChart(allData[ui.value], ui.value);
                        }
                    })
                    .slider("pips")
                    .slider("float");
            });
            function formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
            }
            function updateChart(newData, year) {
                var chart = window.chart1;
                chart.options.title.text = year;
                chart.data.datasets[0].tree = newData;
                chart.update();
            }
        </script>
        <table class="table table-striped table-bordered table-hover table-responsive" style="font-size: 13px; margin-bottom: 10px;">
            <tr>
                <td>
                    <div style="margin: 10px 15px 20px 10px; padding: 7px 0px; border: solid 2px #215a9a;" 
                            id="slider-range-max" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all ui-slider-pips"></div>
                    </div>
                </td>
            </tr>
        </table>
        <style>
            .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active{border: 2px solid #215a9a; background: #215a9a;padding: 10px 0px;}
            .ui-slider-horizontal .ui-slider-range-max{right: 0;background: #d6d6d6;}
            .ui-slider-pips [class*=ui-slider-pip-selected]{font-weight: bold;color: #215a9a;}
            .ui-slider-pips .ui-slider-pip-inrange{ color: black; font-weight: bold;}
        </style>';
    }

    /**
     * <b>drawPyramid</b>
     * <br>
     * Genera un gráfico de pirámide, para el indicador 
     * Población total por sexo y grupos quinquenales
     * @param array $data Información para graficar el indicador
     * @param string $unidadMedicion Unidad de medición del indicador
     */
    public function drawPyramid($data, $unidadMedicion, $idIndicador)
    {
        $serieDato = new SeriesDatos();
        $indicado = new Indicadores();
        $dato = new Datos();



        $respSerie = $serieDato->consultarSeriePorIndicador($idIndicador);
        $respTotPobla = $indicado->indicadorTieneNombreYId("SIS", "Población total");
        $respTotCali = $serieDato->consultarDesagregacionesTematicasPorIndicadorYDesagregacionGeografica($respTotPobla['idIndicador'], "Cali");
        $respDatoTot = $dato->consultarDatosPorIdSerie($respTotCali[0]['idSerieDatos']);

        $ticks = array();
        $ticksGirl = array();
        $ticksMen = array();
        // $tickAnhos = array();
        $ticksTotPobl[$respTotCali[0]['desagregacionTematica']] = array();
        for ($i = 0; $i < count($respDatoTot); $i++) {

            $ticksTotPobl[] = array_push($ticksTotPobl[$respTotCali[0]['desagregacionTematica']], number_format($respDatoTot[$i]['valorDato'], 0, " ", "."));
            // $tickAnhos[] = array_push($tickAnhos, $respDatoTot[$i]['fechaDato']);
        }

        foreach ($respSerie as $item) {
            $respDato = $dato->consultarDatosPorIdSerie($item['idSerieDatos']);
            $totMen = strpos($item['desagregacionTematica'], "Total Hombres");
            $totGirl = strpos($item['desagregacionTematica'], "Total Mujeres");
            $men = strpos($item['desagregacionTematica'], "Hombres");
            $girl = strpos($item['desagregacionTematica'], "Mujeres");
            if ($totMen !== false) {
                $serieTotalMen[$item['desagregacionTematica']] = array();
                $serieTotalMen2[$item['desagregacionTematica']] = array();
            } elseif ($totGirl !== false) {
                $serieTotalGirl[$item['desagregacionTematica']] = array();
                $serieTotalGirl2[$item['desagregacionTematica']] = array();
            } elseif ($girl === false && $men === false) {
                ($item['desagregacionTematica'] === "80 y más") ? $item['desagregacionTematica'] = "80+" : $item['desagregacionTematica'] = $item['desagregacionTematica'];
                array_push($ticks, $item['desagregacionTematica']);
                $serieTotal[$item['desagregacionTematica']] = array();
            } else if ($girl !== false) {
                array_push($ticksGirl, $item['desagregacionTematica']);
                $serieGirl[$item['desagregacionTematica']] = array();
            } else if ($men !== false) {
                array_push($ticksMen, $item['desagregacionTematica']);
                $serieMen[$item['desagregacionTematica']] = array();
            }

            for ($i = 0; $i < count($respDato); $i++) {
                if ($totMen !== false) {
                    $nameA = $item['desagregacionTematica'];
                    $serieTotalMen[] = array_push($serieTotalMen[$item['desagregacionTematica']], $respDato[$i]['valorDato']);
                    $serieTotalMen2[] = array_push($serieTotalMen2[$item['desagregacionTematica']], number_format($respDato[$i]['valorDato'], 0, " ", "."));
                } else if ($totGirl !== false) {
                    $nameB = $item['desagregacionTematica'];
                    $serieTotalGirl[] = array_push($serieTotalGirl[$item['desagregacionTematica']], $respDato[$i]['valorDato']);
                    $serieTotalGirl2[] = array_push($serieTotalGirl2[$item['desagregacionTematica']], number_format($respDato[$i]['valorDato'], 0, " ", "."));
                } else if ($men === false && $girl === false) {
                    $serieTotal[] = array_push($serieTotal[$item['desagregacionTematica']], $respDato[$i]['valorDato']);
                } else if ($girl !== false) {
                    $serieGirl[] = array_push($serieGirl[$item['desagregacionTematica']], $respDato[$i]['valorDato']);
                } else if ($men !== false) {
                    $serieMen[] = array_push($serieMen[$item['desagregacionTematica']], $respDato[$i]['valorDato']);
                }
            }
        }

        $anhoss = 51;
        for ($y = 0; $y < $anhoss; $y++) {
            $datosDesaGirl[$y] = array();
            $datosDesaMen[$y] = array();
            for ($i = 0; $i < count($ticksMen); $i++) {
                $xxx = ($serieMen[$ticksMen[$i]][$y] / $serieTotalMen["Total Hombres"][$y]) * 100;
                $datosDesaMen[] = array_push($datosDesaMen[$y], $xxx);

                $xxxx = ($serieGirl[$ticksGirl[$i]][$y] / $serieTotalGirl["Total Mujeres"][$y]) * 100;
                $datosDesaGirl[] = array_push($datosDesaGirl[$y], $xxxx);
            }
        }
        echo '
<script>
    $(document).ready(function () {
        var ticks = ' . json_encode($ticks) . ';
        var male = ' . json_encode($datosDesaMen[0]) . ';
        var female = ' . json_encode($datosDesaGirl[0]) . ';
        var colors = ["#085586", "#f2665e", "#C57225", "#C57225"];
        var plotOptions = {title: "<div style=' . "'" . 'float:left; width:50%; text-align:center;' . "'" . '>Hombres</div>\n\
                        <div style=' . "'" . 'float:right; width:50%; text-align:center;' . "'" . '>Mujeres</div>",
            seriesColors: colors,
            grid: {drawBorder: false, shadow: false, background: "white",
                rendererOptions: {plotBands: {show: false, interval: 2}}
            },
            defaultAxisStart: 0,
            seriesDefaults: {
                renderer: $.jqplot.PyramidRenderer,
                rendererOptions: {barPadding: 4},
                showMinorTicks: true, yaxis: "yaxis", shadow: false
            },
            series: [
                {rendererOptions: {side: "left", synchronizeHighlight: 1}},
                {yaxis: "y2axis", rendererOptions: {synchronizeHighlight: 0}},
                {rendererOptions: {fill: false, side: "left"}},
                {yaxis: "y2axis", rendererOptions: {fill: false}}
            ],
            axes: {
                xaxis: {
                    ticks: [[-14, 14], [-12, 12], [-10, 10], [-8, 8], [-6, 6], [-4, 4], [-2, 2], [0, 0],
                        [2, 2], [4, 4], [6, 6], [8, 8], [10, 10], [12, 12], [14, 14]],
                    tickOptions: {showGridline: true},
                    rendererOptions: {baselineWidth: 2}
                },
                yaxis: {
                    label: "Grupos de edad",
                    labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                    tickOptions: {showGridline: true},
                    showMinorTicks: true,
                    ticks: ticks,
                    rendererOptions: {category: true, baselineWidth: 2}
                },
                yMidAxis: {
                    label: "Grupos de edad",
                    tickOptions: {showGridline: true},
                    showMinorTicks: true,
                    ticks: ticks,
                    rendererOptions: {category: true, baselineWidth: 2}
                },
                y2axis: {
                    label: "Grupos de edad",
                    labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                    tickOptions: {showGridline: true},
                    showMinorTicks: true,
                    ticks: ticks,
                    rendererOptions: {category: true, baselineWidth: 2}
                }
            }
        };
        plotOptions.series[0].yaxis = "yaxis";
        plotOptions.series[1].yaxis = "yaxis";
        plot1 = $.jqplot("chartPyramid", [male, female], plotOptions);
        $(".jqplot-target").bind("jqplotDataHighlight", function (evt, seriesIndex, pointIndex, data) {
            var malePopulation = Math.abs(plot1.series[0].data[pointIndex][1]);
            var femalePopulation = Math.abs(plot1.series[1].data[pointIndex][1]);
            var ratio = malePopulation / femalePopulation;
            $("#tooltipMale").stop(true, true).fadeIn(250).html($.jqplot.sprintf("%.2f", malePopulation));
            $("#tooltipFemale").stop(true, true).fadeIn(250).html($.jqplot.sprintf("%.2f", femalePopulation));
            $("#tooltipRatio").stop(true, true).fadeIn(350).html($.jqplot.sprintf("%.4f", ratio));
            $("#tooltipAge").stop(true, true).fadeIn(250).html(ticks[pointIndex]);
        });
        $(".jqplot-target").bind("jqplotDataUnhighlight", function (evt, seriesIndex, pointIndex, data) {
            $(".tooltip-item").stop(true, true).fadeOut(200).html("");
        });
    });
</script>
<script>
    $(function () {
        $("#slider-range-max").slider({
            range: "max", min: 1985, max: 2035, value: 1985,
            slide: function (event, ui) {
                var anho = ui.value;
                var position = 38;
                switch (anho) {
                    case 1985:
                        position = 0;
                        break;
                    case 1986:
                        position = 1;
                        break;
                    case 1987:
                        position = 2;
                        break;
                    case 1988:
                        position = 3;
                        break;
                    case 1989:
                        position = 4;
                        break;
                    case 1990:
                        position = 5;
                        break;
                    case 1991:
                        position = 6;
                        break;
                    case 1992:
                        position = 7;
                        break;
                    case 1993:
                        position = 8;
                        break;
                    case 1994:
                        position = 9;
                        break;
                    case 1995:
                        position = 10;
                        break;
                    case 1996:
                        position = 11;
                        break;
                    case 1997:
                        position = 12;
                        break;
                    case 1998:
                        position = 13;
                        break;
                    case 1999:
                        position = 14;
                        break;
                    case 2000:
                        position = 15;
                        break;
                    case 2001:
                        position = 16;
                        break;
                    case 2002:
                        position = 17;
                        break;
                    case 2003:
                        position = 18;
                        break;
                    case 2004:
                        position = 19;
                        break;
                    case 2005:
                        position = 20;
                        break;
                    case 2006:
                        position = 21;
                        break;
                    case 2007:
                        position = 22;
                        break;
                    case 2008:
                        position = 23;
                        break;
                    case 2009:
                        position = 24;
                        break;
                    case 2010:
                        position = 25;
                        break;
                    case 2011:
                        position = 26;
                        break;
                    case 2012:
                        position = 27;
                        break;
                    case 2013:
                        position = 28;
                        break;
                    case 2014:
                        position = 29;
                        break;
                    case 2015:
                        position = 30;
                        break;
                    case 2016:
                        position = 31;
                        break;
                    case 2017:
                        position = 32;
                        break;
                    case 2018:
                        position = 33;
                        break;
                    case 2019:
                        position = 34;
                        break;
                    case 2020:
                        position = 35;
                        break;
                    case 2021:
                        position = 36;
                        break;
                    case 2022:
                        position = 37;
                        break;
                    case 2023:
                        position = 38;
                        break;
                    case 2024:
                        position = 39;
                        break;
                    case 2025:
                        position = 40;
                        break;
                    case 2026:
                        position = 41;
                        break;
                    case 2027:
                        position = 42;
                        break;
                    case 2028:
                        position = 43;
                        break;
                    case 2029:
                        position = 44;
                        break;
                    case 2030:
                        position = 45;
                        break;
                    case 2031:
                        position = 46;
                        break;
                    case 2032:
                        position = 47;
                        break;
                    case 2033:
                        position = 48;
                        break;
                    case 2034:
                        position = 49;
                        break;
                    case 2035:
                        position = 50;
                        break;
                    default:
                        position = 0;
                }
                var ticks = ' . json_encode($ticks) . ';
                var maleTot = ' . json_encode($datosDesaMen) . ';
                var femaleTot = ' . json_encode($datosDesaGirl) . ';

                var popTot = ' . json_encode($ticksTotPobl['Total']) . ';
                var popFemaleTot = ' . json_encode($serieTotalGirl2[$nameB]) . ';
                var popMaleTot = ' . json_encode($serieTotalMen2[$nameA]) . ';
                var popFemaleTot2 = ' . json_encode($serieTotalGirl[$nameB]) . ';
                var popMaleTot2 = ' . json_encode($serieTotalMen[$nameA]) . ';
                $("#amount").text(ui.value);
                $("#year").text(ui.value);
                $("#totalPopulation").html(popTot[position]);
                $("#totalFemalePopulation").html(popFemaleTot[position]);
                $("#totalMalePopulation").html(popMaleTot[position]);
                $("#ratioTotal").number(popMaleTot2[position] / popFemaleTot2[position], 4);
                var colors = ["#085586", "#f2665e", "#C57225", "#C57225"];
                var male = maleTot[position];
                var female = femaleTot[position];
                var plotOptions = {title: "<div style=' . "'" . 'float:left; width:50%; text-align:center;' . "'" . '>Hombres</div>\n\
                    <div style=' . "'" . 'float:right; width:50%; text-align:center;' . "'" . '>Mujeres</div>",
                    seriesColors: colors,
                    grid: {drawBorder: false, shadow: false, background: "white",
                        rendererOptions: {plotBands: {show: false, interval: 2}}},
                    defaultAxisStart: 0,
                    seriesDefaults: {renderer: $.jqplot.PyramidRenderer, rendererOptions: {barPadding: 4},
                        showMinorTicks: true, yaxis: "yaxis", shadow: false},
                    series: [
                        {rendererOptions: {side: "left", synchronizeHighlight: 1}},
                        {yaxis: "y2axis", rendererOptions: {synchronizeHighlight: 0}},
                        {rendererOptions: {fill: false, side: "left"}},
                        {yaxis: "y2axis", rendererOptions: {fill: false}}
                    ],
                    axes: {
                        xaxis: {
                            ticks: [[-14, 14], [-12, 12], [-10, 10], [-8, 8], [-6, 6], [-4, 4], [-2, 2], [0, 0],
                                [2, 2], [4, 4], [6, 6], [8, 8], [10, 10], [12, 12], [14, 14]],
                            tickOptions: {showGridline: true},
                            rendererOptions: {baselineWidth: 2}
                        },
                        yaxis: {
                            label: "Grupos de edad", labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                            tickOptions: {showGridline: true},
                            showMinorTicks: true, ticks: ticks, rendererOptions: {category: true, baselineWidth: 2}
                        },
                        yMidAxis: {label: "Grupos de edad", tickOptions: {showGridline: true},
                            showMinorTicks: true, ticks: ticks, rendererOptions: {category: true, baselineWidth: 2}
                        },
                        y2axis: {label: "Grupos de edad", labelRenderer: $.jqplot.CanvasAxisLabelRenderer, tickOptions: {showGridline: true},
                            showMinorTicks: true, ticks: ticks, rendererOptions: {category: true, baselineWidth: 2}
                        }
                    }
                };
                plot1.destroy();
                plotOptions.series[0].yaxis = "yaxis";
                plotOptions.series[1].yaxis = "yaxis";
                plot1 = $.jqplot("chartPyramid", [male, female], plotOptions);
                $(".jqplot-target").bind("jqplotDataHighlight", function (evt, seriesIndex, pointIndex, data) {
                    var malePopulation = Math.abs(plot1.series[0].data[pointIndex][1]);
                    var femalePopulation = Math.abs(plot1.series[1].data[pointIndex][1]);
                    var ratio = malePopulation / femalePopulation;
                    $("#tooltipMale").stop(true, true).fadeIn(250).html($.jqplot.sprintf("%.2f", malePopulation));
                    $("#tooltipFemale").stop(true, true).fadeIn(250).html($.jqplot.sprintf("%.2f", femalePopulation));
                    $("#tooltipRatio").stop(true, true).fadeIn(350).html($.jqplot.sprintf("%.4f", ratio));
                    $("#tooltipAge").stop(true, true).fadeIn(250).html(ticks[pointIndex]);
                });
                $(".jqplot-target").bind("jqplotDataUnhighlight", function (evt, seriesIndex, pointIndex, data) {
                    $(".tooltip-item").stop(true, true).fadeOut(200).html("");
                });
            }
        });
        $("#amount").val($("#slider-range-max").slider("value"));
    });
</script>
<style>
    .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active{border: 2px solid #215a9a;background: #215a9a;padding: 10px 0px;}
    .ui-slider-horizontal .ui-slider-range-max {right: 0;background: #d6d6d6;}
</style>
';
        $resp = '
    <div class="row">
        <div class="col-sm-3" style="text-align: center; margin-left: -30px;">
            <table class="table table-striped table-bordered table-hover table-responsive" 
                style="font-size: 12px; margin-bottom: 10px;">
                <tr>
                    <td style="background-color:#215a9a; color:#fff; text-align:center; width: 50%">
                        Año
                    </td>
                    <td style="background-color:#215a9a; color:#fff; text-align:center">
                        <p style="margin: 0px;" id="year">1985</p>
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#215a9a; color:#fff; text-align:center">
                        Población total
                    </td>
                    <td style="text-align:center">
                        <p style="margin: 0px;" id="totalPopulation"></p>
                        <script> $("#totalPopulation").html("1.591.869"); </script>
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#215a9a; color:#fff; text-align:center">
                        Total mujeres
                    </td>
                    <td style="text-align:center">
                        <p style="margin: 0px;" id="totalFemalePopulation"></p>
                        <script>$("#totalFemalePopulation").html(726.155);</script>
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#215a9a; color:#fff; text-align:center">
                        Total hombres
                    </td>
                    <td style="text-align:center">
                        <p style="margin: 0px;" id="totalMalePopulation"></p>
                        <script>$("#totalMalePopulation").html(789.562);</script>
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#215a9a; color:#fff; text-align:center">
                        Proporción H/M
                    </td>
                    <td style="text-align:center;">
                        <p style="margin: 0px;" id="ratioTotal"></p>
                        <script>$("#ratioTotal").number(1.0873, 4);</script>
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#215a9a; color:#fff; text-align:center; width: 50%;">
                        Tipo de datos
                    </td>
                    <td style="text-align: center;">
                        Proyecciones DANE
                    </td>
                </tr>
            </table>
            <table class="table table-striped table-bordered table-hover table-responsive" style="font-size: 13px; margin-bottom: 10px;">
                <tr>
                    <td colspan="2">
                        <div id="amount" style="color:#215a9a; font-weight:bold; text-align: center">1985</div>
                        <div style="margin: 5px 10px 5px 10px; padding: 8px 0px; border: solid 2px #215a9a;" id="slider-range-max"></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-sm-6" style="padding-left: 5px; margin-right:30px;">
        <div class="chart-pyramid">
            <div id="chartPyramid"></div>
        </div>
        </div>
        <div class="col-md-3" style="margin-left: 0px;">
            <table class="table table-striped table-bordered table-hover table-responsive" 
                style="font-size: 12px; margin-bottom: 10px;">
                <tr>
                    <td style="background-color:#215a9a; color:#fff; text-align:center; width: 50%;">
                        Rango de edad
                    </td>
                    <td style="text-align: center; width: 50%">
                        <div class="tooltip-item" id="tooltipAge">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#215a9a; color:#fff; text-align:center; width: 50%;">
                        Porcentaje de hombres
                    </td>
                    <td style="text-align: center;">
                        <div class="tooltip-item" id="tooltipMale">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#215a9a; color:#fff; text-align:center; width: 50%;">
                        Porcentaje de mujeres
                    </td>
                    <td style="text-align: center;">
                        <div class="tooltip-item" id="tooltipFemale">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#215a9a; color:#fff; text-align:center; width: 50%;">
                        Tipo de datos
                    </td>
                    <td style="text-align: center;">
                        Proyecciones DANE
                    </td>
                </tr>
            </table>
            <div class="panel" style="background-color: #d6d6d6; margin-bottom: 10px; border: 1px #215a9a solid;">
                <p style="font-size: 12px; text-align: justify; margin: 10px;">
                    Para consultar la información de un rango de edad, pase con el mouse sobre el rango de interés.
                </p>
            </div>
        </div>
    </div>';
        echo $resp;
    }

    /**
     * <b>drawPyramidPrueba</b>
     * <br>
     * Genera un gráfico de pirámide para un indicador 
     * @param array $data Información para graficar el indicador
     * @param string $unidadMedicion Unidad de medición del indicador
     * @param array $series Serie de los datos
     */
    public function drawPyramidPrueba($data, $unidadMedicion, $series)
    {
        $fechaMax = max($data["labels"]);
        $fechaMin = min($data["labels"]);
        $label = $data["labels"];
        $dato = $data["datasets"];
        $male = "Hombre";
        $female = "Mujer";
        $dataMale = array();
        $dataFemale = array();
        $dataEdades = array();
        $rango = array();
        for ($j = 0; $j < count($label); $j++) {
            $anho = $label[$j];
            for ($k = 0; $k < count($dato); $k++) {
                $sexo = $data["datasets"][$k]["label"];
                if (strpos($sexo, $male) == true) {
                    $dataMale[$anho][] = $data["datasets"][$k]["data"][$j];
                } elseif (strpos($sexo, $female) == true) {
                    $dataFemale[$anho][] = $data["datasets"][$k]["data"][$j];
                }
            }
        }
        //         echo '<pre>';
        //        var_dump($mal);
        //        echo '</pre>';
        //        for ($o = 0; $o < count($series); $o++) {
        //            if (strpos($series[$o][1], $male)) {
        //                $ran = explode(" ", $series[$o][1]);
        //                $rango[] = $ran[0];
        //            }
        //        }
        echo '
        <script>
            $(document).ready(function () {
                var ticks = ["<1años","1-4","5-9","10-14","15-19","20-24","25-29","30-34","35-39","40-44","45-49","50-54","55-59","60-64","65-69","70-74","75-79","80"];
                var male = ' . json_encode($dataMale[$fechaMax]) . ';
                var female = ' . json_encode($dataFemale[$fechaMax]) . ';
                var colors = ["#085586", "#f2665e", "#C57225", "#C57225"];
                var plotOptions = {title: "<div style=' . "'" . 'float:left; width:50%; text-align:center;' . "'" . '>Hombres</div>\n\
                                <div style=' . "'" . 'float:right; width:50%; text-align:center;' . "'" . '>Mujeres</div>",
                    seriesColors: colors,
                    grid: {drawBorder: false, shadow: false, background: "white",
                        rendererOptions: {plotBands: {show: false, interval: 2}}
                    },
                    defaultAxisStart: 0,
                    seriesDefaults: {
                        renderer: $.jqplot.PyramidRenderer,
                        rendererOptions: {barPadding: 3},
                        showMinorTicks: true, yaxis: "yaxis", shadow: false
                    },
                    series: [
                        {rendererOptions: {side: "left", synchronizeHighlight: 1}},
                        {yaxis: "y2axis", rendererOptions: {synchronizeHighlight: 0}},
                        {rendererOptions: {fill: false, side: "left"}},
                        {yaxis: "y2axis", rendererOptions: {fill: false}}
                    ],
                    axes: {
                        xaxis: {
                            ticks: [[-24, 24],[-21, 21], [-18, 18], [-15, 15], [-12, 12], [-9, 9], [-6, 6], [-3, 3], [0, 0],
                                        [3, 3], [6, 6], [9, 9], [12, 12], [15, 15], [18, 18], [21, 21], [24, 24]],
                            tickOptions: {showGridline: true},
                            rendererOptions: {baselineWidth: 2}
                        },
                        yaxis: {
                            label: "Grupos de edad",
                            labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                            tickOptions: {showGridline: true},
                            showMinorTicks: true,
                            ticks: ticks,
                            rendererOptions: {category: true, baselineWidth: 2}
                        },
                        yMidAxis: {
                            label: "Grupos de edad",
                            tickOptions: {showGridline: true},
                            showMinorTicks: true,
                            ticks: ticks,
                            rendererOptions: {category: true, baselineWidth: 2}
                        },
                        y2axis: {
                            label: "Grupos de edad",
                            labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                            tickOptions: {showGridline: true},
                            showMinorTicks: true,
                            ticks: ticks,
                            rendererOptions: {category: true, baselineWidth: 2}
                        }
                    }
                };
                plotOptions.series[0].yaxis = "yaxis";
                plotOptions.series[1].yaxis = "yaxis";
                plot1 = $.jqplot("chartPyramid", [male, female], plotOptions);
                $(".jqplot-target").bind("jqplotDataHighlight", function (evt, seriesIndex, pointIndex, data) {
                    var malePopulation = Math.abs(plot1.series[0].data[pointIndex][1]);
                    var femalePopulation = Math.abs(plot1.series[1].data[pointIndex][1]);
                    var ratio = malePopulation / femalePopulation;
                    $("#tooltipMale").stop(true, true).fadeIn(250).html($.jqplot.sprintf("%.2f", malePopulation));
                    $("#tooltipFemale").stop(true, true).fadeIn(250).html($.jqplot.sprintf("%.2f", femalePopulation));
                    $("#tooltipRatio").stop(true, true).fadeIn(350).html($.jqplot.sprintf("%.4f", ratio));
                    $("#tooltipAge").stop(true, true).fadeIn(250).html(ticks[pointIndex]);
                });
                $(".jqplot-target").bind("jqplotDataUnhighlight", function (evt, seriesIndex, pointIndex, data) {
                    $(".tooltip-item").stop(true, true).fadeOut(200).html("");
                });
            });
        </script>
        <script>
                                //ACA SE REALIZA EL SLIDER PARA LOS AÑOS      
            $(function () {
                $("#slider-range-max").slider({
                    range: "max", min: ' . $fechaMin . ', max: ' . $fechaMax . ', value: ' . $fechaMax . ',
                    slide: function (event, ui) {
                        var anho = ui.value;
                        var ticks = ["<1años","1-4","5-9","10-14","15-19","20-24","25-29","30-34","35-39","40-44","45-49","50-54","55-59","60-64","65-69","70-74","75-79","80"];
                        var maleTot = ' . json_encode($dataMale) . '; 
                        var femaleTot = ' . json_encode($dataFemale) . ';
                        $("#amount").text(ui.value);
                        $("#year").text(ui.value);
                        var colors = ["#085586", "#f2665e", "#C57225", "#C57225"];
                        var male = maleTot[anho];
                        var female = femaleTot[anho];
                        var plotOptions = {title: "<div style=' . "'" . 'float:left; width:50%; text-align:center;' . "'" . '>Hombres</div>\n\
                            <div style=' . "'" . 'float:right; width:50%; text-align:center;' . "'" . '>Mujeres</div>",
                            seriesColors: colors,
                            grid: {drawBorder: false, shadow: false, background: "white",
                                rendererOptions: {plotBands: {show: false, interval: 2}}},
                            defaultAxisStart: 0,
                            seriesDefaults: {renderer: $.jqplot.PyramidRenderer, rendererOptions: {barPadding: 3},
                                showMinorTicks: true, yaxis: "yaxis", shadow: false},
                            series: [
                                {rendererOptions: {side: "left", synchronizeHighlight: 1}},
                                {yaxis: "y2axis", rendererOptions: {synchronizeHighlight: 0}},
                                {rendererOptions: {fill: false, side: "left"}},
                                {yaxis: "y2axis", rendererOptions: {fill: false}}
                            ],
                            axes: {
                                xaxis: {
                                    ticks: [[-24, 24],[-21, 21], [-18, 18], [-15, 15], [-12, 12], [-9, 9], [-6, 6], [-3, 3], [0, 0],
                                        [3, 3], [6, 6], [9, 9], [12, 12], [15, 15], [18, 18], [21, 21], [24, 24]],
                                    tickOptions: {showGridline: true},
                                    rendererOptions: {baselineWidth: 2}
                                },
                                yaxis: {
                                    label: "Grupos de edad", labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                                    tickOptions: {showGridline: true},
                                    showMinorTicks: true, ticks: ticks, rendererOptions: {category: true, baselineWidth: 2}
                                },
                                yMidAxis: {label: "Grupos de edad", tickOptions: {showGridline: true},
                                    showMinorTicks: true, ticks: ticks, rendererOptions: {category: true, baselineWidth: 2}
                                },
                                y2axis: {label: "Grupos de edad", labelRenderer: $.jqplot.CanvasAxisLabelRenderer, tickOptions: {showGridline: true},
                                    showMinorTicks: true, ticks: ticks, rendererOptions: {category: true, baselineWidth: 2}
                                }
                            }
                        };
                        plot1.destroy();
                        plotOptions.series[0].yaxis = "yaxis";
                        plotOptions.series[1].yaxis = "yaxis";
                        plot1 = $.jqplot("chartPyramid", [male, female], plotOptions);
                        $(".jqplot-target").bind("jqplotDataHighlight", function (evt, seriesIndex, pointIndex, data) {
                            var malePopulation = Math.abs(plot1.series[0].data[pointIndex][1]);
                            var femalePopulation = Math.abs(plot1.series[1].data[pointIndex][1]);
                            var ratio = malePopulation / femalePopulation;
                            $("#tooltipMale").stop(true, true).fadeIn(250).html($.jqplot.sprintf("%.2f", malePopulation));
                            $("#tooltipFemale").stop(true, true).fadeIn(250).html($.jqplot.sprintf("%.2f", femalePopulation));
                            $("#tooltipRatio").stop(true, true).fadeIn(350).html($.jqplot.sprintf("%.4f", ratio));
                            $("#tooltipAge").stop(true, true).fadeIn(250).html(ticks[pointIndex]);
                        });
                        $(".jqplot-target").bind("jqplotDataUnhighlight", function (evt, seriesIndex, pointIndex, data) {
                            $(".tooltip-item").stop(true, true).fadeOut(200).html("");
                        });
                    }
                });
                $("#amount").val($("#slider-range-max").slider("value"));
            });
        </script>
        <style>
            .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active{border: 2px solid #215a9a;background: #215a9a;padding: 10px 0px;}
            .ui-slider-horizontal .ui-slider-range-max {right: 0;background: #d6d6d6;}
        </style>
        ';
        $resp = '
            <div class="row">
                <div class="col-sm-3" style="text-align: center; margin-left: -30px;">
        <!--INFORMACIÓN DE LOS DATOS CUANDO SE PASA SOBRE ELLOS
                        <table class="table table-striped table-bordered table-hover table-responsive" 
                        style="font-size: 12px; margin-bottom: 10px;">
                        <tr>
                            <td style="background-color:#215a9a; color:#fff; text-align:center; width: 50%">
                                Año
                            </td>
                            <td style="background-color:#215a9a; color:#fff; text-align:center">
                                <p style="margin: 0px;" id="year">2018</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color:#215a9a; color:#fff; text-align:center">
                                Población total
                            </td>
                            <td style="text-align:center">
                                <p style="margin: 0px;" id="totalPopulation"></p>
                                <script> $("#totalPopulation").number(2420114); </script>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color:#215a9a; color:#fff; text-align:center">
                                Total mujeres
                            </td>
                            <td style="text-align:center">
                                <p style="margin: 0px;" id="totalFemalePopulation"></p>
                                <script>$("#totalFemalePopulation").number(1263275);</script>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color:#215a9a; color:#fff; text-align:center">
                                Total hombres
                            </td>
                            <td style="text-align:center">
                                <p style="margin: 0px;" id="totalMalePopulation"></p>
                                <script>$("#totalMalePopulation").number(1156839);</script>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color:#215a9a; color:#fff; text-align:center">
                                Proporción H/M
                            </td>
                            <td style="text-align:center;">
                                <p style="margin: 0px;" id="ratioTotal"></p>
                                <script>$("#ratioTotal").number(0.9157, 4);</script>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color:#215a9a; color:#fff; text-align:center; width: 50%;">
                                Tipo de datos
                            </td>
                            <td style="text-align: center;">
                                Proyecciones DANE
                            </td>
                        </tr>
                    </table>
        -->
            <table class="table table-striped table-bordered table-hover table-responsive" style="font-size: 13px; margin-bottom: 10px;">
                <tr>
                    <td colspan="2">
                        <div id="amount" style="color:#215a9a; font-weight:bold; text-align: center">2018</div>
                        <div style="margin: 5px 10px 5px 10px; padding: 8px 0px; border: solid 2px #215a9a;" id="slider-range-max"></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-sm-6" style="padding-left: 5px; margin-right:30px;">
        <div class="chart-pyramid">
            <div id="chartPyramid"></div>
        </div>
        </div>
        <div class="col-md-3" style="margin-left: 0px;">
            <table class="table table-striped table-bordered table-hover table-responsive" 
                style="font-size: 12px; margin-bottom: 10px;">
                <tr>
                    <td style="background-color:#215a9a; color:#fff; text-align:center; width: 50%;">
                        Rango de edad
                    </td>
                    <td style="text-align: center; width: 50%">
                        <div class="tooltip-item" id="tooltipAge">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#215a9a; color:#fff; text-align:center; width: 50%;">
                        Porcentaje de hombres
                    </td>
                    <td style="text-align: center;">
                        <div class="tooltip-item" id="tooltipMale">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#215a9a; color:#fff; text-align:center; width: 50%;">
                        Porcentaje de mujeres
                    </td>
                    <td style="text-align: center;">
                        <div class="tooltip-item" id="tooltipFemale">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#215a9a; color:#fff; text-align:center; width: 50%;">
                        Tipo de datos
                    </td>
                    <td style="text-align: center;">
                        Proyecciones DANE
                    </td>
                </tr>
            </table>
            <div class="panel" style="background-color: #d6d6d6; margin-bottom: 10px; border: 1px #215a9a solid;">
                <p style="font-size: 12px; text-align: justify; margin: 10px;">
                    Para consultar la información de un rango de edad, pase con el mouse sobre el rango de interés.
                </p>
            </div>
        </div>
    </div>';
        echo $resp;
    }

    /**
     * <b>drawRadar</b>
     * <br>
     * Genera un gráfico de radar para un indicador, 
     * teniendo un valor máximo definido
     * @param array $data Información para graficar el indicador
     * @param string $unidadMedicion Unidad de medición del indicador
     * @param float $maxValue Valor máximo para el gráfico
     */
    public function drawRadar($data, $unidadMedicion, $maxValue)
    {
        return " 
            var chartOptions = {scale: {ticks: {beginAtZero: true, },
                                        pointLabels: {fontSize: 12}},
                                legend: {position: 'left',display:true},
                                         labels: {usePointStyle: true},};
                                
            var myBarChart = new Chart(ctx, {
            type: 'radar',
            data: $data,
            options: chartOptions                                         
            });";
    }

    /**
     * <b>crearEnlace</b>
     * <br>
     * Genera el enlace con todos los parámetros necesarios para la consulta
     * de un indicador
     * @param array $informacionEnlace Parámetros a incluir en el enlace
     * @param string $tipoConsulta Categoría de la consulta a realizar.
     */
    public function crearEnlace($informacionEnlace, $tipoConsulta)
    {
        $idDimension = $informacionEnlace[0];
        $idTematica = $informacionEnlace[1];
        $idIndicador = $informacionEnlace[2];
        $fuente = "";
        $tipoZonaGeografica = "";
        $zonaGeografica = "";
        if ($tipoConsulta == 'EXP') {
            $tipoZonaGeografica = $informacionEnlace['tipoZonaGeografica'];
            $zonaGeografica = $informacionEnlace['zonaGeografica'];
        } else {
            $fuente = $informacionEnlace[3];
        }

        $ser = new SeriesDatos();
        $serController = new SeriesDatosController();
        $desagregacionesTematicas = array();
        $series = array();
        $desagregacionesGeograficas = array();
        if ($tipoConsulta == "Comunas") {
            $consultaGeograficas = $ser->consultarComunasCorregimientosPorIndicadorLimit($idIndicador);
            foreach ($consultaGeograficas as $row => $item) {
                $desagregacionesGeograficas[] = $item['zonaGeografica'];
            }
            $desagregacionesTematicas = $serController->consultarDesagregacionesTematicasPorIndicadorYListadoDesagregacionesGeograficasController($idIndicador, $desagregacionesGeograficas);
            for ($i = 0; $i < count($desagregacionesGeograficas); $i++) {
                $desagregacionGeografica = $desagregacionesGeograficas[$i];
                foreach ($desagregacionesTematicas as $desagregacionTematica) {
                    $serie = $ser->consultarIdSeriePorIndicadorFuenteYDesagregaciones($idIndicador, $fuente, $desagregacionTematica, $desagregacionGeografica);
                    $series[] = $serie['idSerieDatos'];
                }
            }
        } elseif ($tipoConsulta == "EXP") {
            $desTems = $serController->consultarDesagregacionesTematicasPorIndicadorYZonaGeograficaExpController($idIndicador, $zonaGeografica);
            for ($j = 0; $j < count($desTems); $j++) {
                $desTem = $desTems[$j];
                $desagregacionesTematicas[] = $desTem;
                $resp1 = $ser->consultarIdSeriePorIndicadorGeografiaZonaActualDesagregacionTematicaExpediente($idIndicador, $tipoZonaGeografica, $zonaGeografica, $desTem);
                foreach ($resp1 as $row => $item) {
                    $series[] = $item["idSerieDatos"];
                }
            }
        } elseif ($tipoConsulta == "ODS") {
            $consultaGeograficas = $ser->consultarDesagregacionesGeograficasPorIndicador($idIndicador);
            foreach ($consultaGeograficas as $row => $item) {
                $desagregacionesGeograficas[] = $item['zonaGeografica'];
            }
            $desagregacionesTematicas = ['Total'];
            for ($i = 0; $i < count($desagregacionesGeograficas); $i++) {
                $desagregacionGeografica = $desagregacionesGeograficas[$i];
                foreach ($desagregacionesTematicas as $desagregacionTematica) {
                    $serie = $ser->consultarIdSeriePorIndicadorFuenteYDesagregaciones($idIndicador, $fuente, $desagregacionTematica, $desagregacionGeografica);
                    if ($serie != NULL && $serie !== "") {
                        $series[] = $serie['idSerieDatos'];
                    }
                }
            }
        } elseif ($tipoConsulta == "ODRAF") {
            $consultaGeograficas = $ser->consultarDesagregacionesGeograficasPorIndicadorTotal($idIndicador);
            foreach ($consultaGeograficas as $row => $item) {
                $desagregacionesGeograficas[] = $item['zonaGeografica'];
            }
            $desagregacionesTematicas = $serController->consultarDesagregacionesTematicasPorIndicadorYListadoDesagregacionesGeograficasController($idIndicador, $desagregacionesGeograficas);
            for ($i = 0; $i < count($desagregacionesGeograficas); $i++) {
                $desagregacionGeografica = $desagregacionesGeograficas[$i];
                foreach ($desagregacionesTematicas as $desagregacionTematica) {
                    $serie = $ser->consultarIdSeriePorIndicadorFuenteYDesagregaciones($idIndicador, $fuente, $desagregacionTematica, $desagregacionGeografica);
                    if ($serie != NULL && $serie !== "") {
                        $series[] = $serie['idSerieDatos'];
                    }
                }
            }
        } else {
            $consultaGeograficas = $ser->consultarDesagregacionesGeograficasPorIndicador($idIndicador);
            foreach ($consultaGeograficas as $row => $item) {
                $desagregacionesGeograficas[] = $item['zonaGeografica'];
            }
            if ($idIndicador === "SIS_4_T3_I3") {
                $desagregacionesTematicas = $serController->consultarDesagregacionesTematicasPorIndicadorYListadoDesagregacionesGeograficasController($idIndicador, $desagregacionesGeograficas);
                if (($clave = array_search("Total Mujeres", $desagregacionesTematicas)) !== false) {
                    unset($desagregacionesTematicas[$clave]);
                }
                if (($clave = array_search("Total Hombres", $desagregacionesTematicas)) !== false) {
                    unset($desagregacionesTematicas[$clave]);
                }
            } else {
                $desagregacionesTematicas = $serController->consultarDesagregacionesTematicasPorIndicadorYListadoDesagregacionesGeograficasController($idIndicador, $desagregacionesGeograficas);
            }
            for ($i = 0; $i < count($desagregacionesGeograficas); $i++) {
                $desagregacionGeografica = $desagregacionesGeograficas[$i];
                foreach ($desagregacionesTematicas as $desagregacionTematica) {
                    $serie = $ser->consultarIdSeriePorIndicadorFuenteYDesagregaciones($idIndicador, $fuente, $desagregacionTematica, $desagregacionGeografica);
                    if ($serie != NULL && $serie !== "") {
                        $series[] = $serie['idSerieDatos'];
                    }
                }
            }
        }

        $dat = new Datos();
        $fchs = array();
        $temp = array();

        for ($k = 0; $k < count($series); $k++) {
            $idSerie = $series[$k];
            $temp = array();
            $resp = $dat->consultarFechasPorIdSerie($idSerie);

            foreach ($resp as $row => $item) {
                $option = $item['fechaDato'];
                $temp[] = $option;
            }
            if ($k == 0) {
                $fchs = $temp;
            }
            $fchs = array_intersect($fchs, $temp);
            if (empty($fchs)) {
                $fchs = $temp;
            }
        }

        sort($fchs);

        $link = "";

        switch ($tipoConsulta) {
            case 'Comunas':
                $link = '/consulta-indicadores/dimensiones-sis-comunas/' . $idDimension . '/' . $idTematica . '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente)) . '/' . implode(",", $desagregacionesTematicas) . '/' . implode(",", $fchs) . '/' . implode(",", $desagregacionesGeograficas);
                break;
            case 'SIS':
                $link = '/consulta-indicadores/dimensiones-sis/' . $idDimension . '/' . $idTematica .
                    '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente)) . '/' . implode(",", $desagregacionesTematicas) . '/' . implode(",", $fchs) . '/' . implode(",", $desagregacionesGeograficas);
                break;
            case 'IGC':
                $link = '/consulta-indicadores/igc/' . $idDimension . '/' . $idTematica .
                    '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente)) . '/' . implode(",", $desagregacionesTematicas) . '/' . implode(",", $fchs) . '/' . implode(",", $desagregacionesGeograficas);
                break;
            case 'EXP':
                $link = '/consulta-indicadores/exp/' . $idDimension . '/' . $idTematica .
                    '/' . $idIndicador . '/' . $tipoZonaGeografica . '/' . urlencode(implode(",", $desagregacionesTematicas)) . '/' . implode(",", $fchs) . '/' . $zonaGeografica;
                break;
            case 'PIIA':
                $link = '/consulta-indicadores/piia/' . $idDimension . '/' . $idTematica .
                    '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente)) . '/' . implode(",", $desagregacionesTematicas) . '/' . implode(",", $fchs) . '/' . implode(",", $desagregacionesGeograficas);
                break;
            case 'ODRAF':
                $link = '/consulta-indicadores/odraf/' . $idDimension . '/' . $idTematica .
                    '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente)) . '/' . implode(",", $desagregacionesTematicas) . '/' . implode(",", $fchs) . '/' . implode(",", $desagregacionesGeograficas);
                break;
            default:
                $link = '/consulta-indicadores/' . strtolower($tipoConsulta) . '/' . $idDimension . '/' . $idTematica .
                    '/' . $idIndicador . '/' . str_replace(' ', '_', $this->sanearCadena($fuente)) . '/' . implode(",", $desagregacionesTematicas) . '/' . implode(",", $fchs) . '/' . implode(",", $desagregacionesGeograficas);
                break;
        }

        return $link;
    }

    /**
     * <b>crearEnlaceDadii</b>
     * <br>
     * Genera el enlace con todos los parámetros necesarios para la consulta
     * de un indicador de desempeño institucional
     * @param array $idDimension ID de la dimensión a la que pertenece el indicador
     * @param array $informacionEnlace Parámetros a incluir en el enlace
     * @param string $tipoConsulta Categoría de la consulta a realizar.
     */
    public function crearEnlaceDadii($idDimension, $informacionEnlace, $tipoConsulta)
    {
        $idDimension = $idDimension;
        $idTematica = $informacionEnlace[0];
        $link = "";
        switch ($tipoConsulta) {
            case 'DADII':
                $link = '/consulta-indicadores/dadii/' . $idDimension . '/' . $idTematica;
                break;
        }
        return $link;
    }

    /**
     * <b>crearRutaBuscadorDadii</b>
     * <br>
     * Realiza la busqueda del identificador unico del indicador consultado por el nombre
     * @param string $indicadorSelect Nombre del indicador seleccionado
     */
    public function crearRutaBuscadorDadii($indicadorSelect)
    {
        $idIndicador = explode(".", $indicadorSelect);
        $idDimension = $idIndicador[0];
        $idTematica = $idIndicador[0] . "." . $idIndicador[1];
        $link = '/consulta-indicadores/dadii/' . $idDimension . '/' . $idTematica;
        echo $link;
    }

    /**
     * <b>buscarIndicadoresActivosPorNombreController</b>
     * <br>
     * Realiza la búsqueda de los indicadores activos, a partir de un nombre
     * @param string $nombreIndicador Es el nombre del indicador a buscar
     */
    public function buscarIndicadoresActivosPorNombreController($nombreIndicador)
    {
        $resp = array();
        $serie = new SeriesDatos();
        $ind = new Indicadores();
        $tem = new Tematicas();
        $dim = new Dimensiones();
        $sis = new ConjuntosIndicadores();
        $resp1 = $ind->consultarIndicadoresActivosPorNombre($nombreIndicador);
        if ($resp1 == "empty") {
            $resp = "empty";
        } else {
            foreach ($resp1 as $row1 => $item1) {
                $nombreInd = $item1["nombreIndicador"];

                $idIndicador = $item1["idIndicador"];
                $row = array();
                $informacionEnlace = "";
                $enlace = "";

                $idTematica = $item1["idTematica"];
                $resp2 = $tem->consultarTematicaPorId($idTematica);
                $nombreTematica = $resp2["nombreTematica"];
                $idDimension = $resp2["idDimension"];
                $resp3 = $dim->consultarDimensionPorId($idDimension);
                $idConjuntoIndicadores = $resp3["idConjuntoIndicadores"];
                $nombreDimension = $resp3["nombreDimension"];
                $resp4 = $sis->consultarConjuntoIndicadoresPorId($idConjuntoIndicadores);
                $nombreConjuntoIndicadores = $resp4["nombreConjuntoIndicadores"];

                if ($idConjuntoIndicadores == "SIS") {
                    $tipoConsulta = "";
                    $resp0 = $serie->consultarGeografiaZonaActualPorIndicador($idIndicador);
                    foreach ($resp0 as $row0 => $item0) {
                        $geografia = trim($item0["tipoZonaGeografica"]);
                        if ($geografia === "Comuna" || $geografia === "Corregimiento") {
                            $informacionEnlace = $ind->consultarInformacionEnlacePorIdIndicadorYGeografia($idIndicador, "Comuna");
                            $enlace = $this->crearEnlace($informacionEnlace, "Comunas");
                        } else {
                            $informacionEnlace = $ind->consultarInformacionEnlacePorIdIndicadorYGeografia($idIndicador, "Municipal");
                            $enlace = $this->crearEnlace($informacionEnlace, $idConjuntoIndicadores);
                        }
                    }
                } elseif ($idConjuntoIndicadores == "IGC") {
                    $informacionEnlace = $ind->consultarInformacionEnlacePorIdIndicadorYGeografia($idIndicador, "Municipal");
                    $enlace = $this->crearEnlace($informacionEnlace, $idConjuntoIndicadores);
                } elseif ($idConjuntoIndicadores == "EXP") {
                    $informacionEnlace = $ind->consultarInformacionEnlacePorIdIndicadorYGeografia($idIndicador, "Exp");
                    $enlace = $this->crearEnlace($informacionEnlace, $idConjuntoIndicadores);
                }

                $row[] = $nombreConjuntoIndicadores;
                $row[] = $nombreDimension;
                $row[] = $nombreTematica;
                $row[] = $nombreInd;
                $row[] = $enlace;
                $resp[] = $row;
            }
        }
        return $resp;
    }

    /**
     * <b>consultaIndicadoresMasBuscadosController</b>
     * <br>
     * Realiza la consulta de los indicadores más consultados en la página
     */
    public function consultaIndicadoresMasBuscadosController()
    {
        $consultas = new ConsultasModel();
        $indicador = new Indicadores();
        $serieDatos = new SeriesDatos();
        $resp = $indicador->consultar5ndicadoresMasBuscados();
        $cont = 0;
        foreach ($resp as $row => $item) {
            $informacionEnlace = array();
            $resp0 = $serieDatos->consultarSeriePorIndicador($item['idIndicador']);
            $porciones = explode("_", $item['idTematica']);
            $dimension = $porciones[0] . '_' . $porciones[1];
            $tipoConsulta = $porciones[0];

            $informacionEnlace[] = $dimension;
            $informacionEnlace[] = $item['idTematica'];
            $informacionEnlace[] = $item['idIndicador'];
            if ($resp0[0]['tipoZonaGeografica'] == "Comuna") {
                $tipoConsulta = 'Comunas';
            }
            if ($tipoConsulta == 'Comunas') {
                $icono = "4";
            } else if ($tipoConsulta == 'SIS') {
                $icono = "1";
            } else if ($tipoConsulta == 'ODS') {
                $icono = "2";
            } else if ($tipoConsulta == 'IGC') {
                $icono = "3";
            } else if ($tipoConsulta == 'PIIA') {
                $icono = "5";

            }

            if ($tipoConsulta == 'EXP') {
                // $tipoZonaGeografica = $informacionEnlace['tipoZonaGeografica'];
                // $zonaGeografica = $informacionEnlace['zonaGeografica'];
            } else {
                $informacionEnlace[] = $resp0[0]['fuenteDatos'];
            }
            $link = $this->crearEnlace($informacionEnlace, $tipoConsulta);
            $valor = number_format($item['numeroConsultas']);

            if ($cont >= 4) {
                echo '<div class="m-widget4__item diferent_visibility">
                        <div class="m-widget4__img m-widget4__img--pic">
                            <img src="/views/resources/images/home/logos/' . $icono . '.png" alt="">
                        </div>
                        <div class="m-widget4__info">
                            <span class="m-widget4__title">
                            <a href="' . $link . '" style="color:#000000">' . $item['nombreIndicador'] . '</a>
                            </span>
                            <br>
                            <span class="m-widget4__sub">                            
                            </span>
                        </div>
                        <div class="m-widget4__ext" style="color: #7E8299;background-color: #F5F8FA; text-align: center;">
                            <span class="m-widget4__sub">                            
                                <a class="color:#cd1118"><b>' . $valor . '</b><br>Visitas</a>                                
                            </span>
                        </div>
                    </div>';

            } else {
                echo '<div class="m-widget4__item">
                        <div class="m-widget4__img m-widget4__img--pic">
                            <img src="/views/resources/images/home/logos/' . $icono . '.png" alt="">
                        </div>
                        <div class="m-widget4__info">
                            <span class="m-widget4__title">
                            <a href="' . $link . '" style="color:#000000">' . $item['nombreIndicador'] . '</a>
                            </span>
                            <br>
                            <span class="m-widget4__sub">                            
                            </span>
                        </div>
                        <div class="m-widget4__ext" style="color: #7E8299;background-color: #F5F8FA; text-align: center;">
                            <span class="m-widget4__sub">                            
                                <a class="color:#cd1118"><b>' . $valor . '</b><br>Visitas</a>                                
                            </span>
                        </div>
                    </div>';
            }
            $cont++;
        }
    }

    // public function consultaIndicadoresMasBuscadosController() {
    //     $consultas = new ConsultasModel();
    //     $cons = new ConsultasController();
    //     // $resp = $consultas->consultaMasBuscados();
    //    echo' <canvas id="myChart" width="100%"  height="100%"></canvas>
    //    <script>
    //     var ctx = document.getElementById("myChart");
    //     var myChart = new Chart(ctx, {
    //         type: "bar",
    //         data: {
    //             labels: ["Población - Comuna", "Población - Total", "Educación", "Seguridad", "Salud"],
    //             labels2: ["Población total por comunas", "Población total", "Desempeño estudiantes pruebas Saber 11", "Hurtos por cada 100 mil habitantes", "Médicos por cada 100 mil habitantes"],
    //             datasets: [{
    //                 label: "Mas Buscados",
    //                 data: [500, 376, 369, 339, 322, 306],
    //                 backgroundColor: [
    //                 "rgba(14,68,169, 0.6)",
    //                 "rgba(201,17,24, 0.6)",
    //                 "rgba(221,221,221, 0.6)",
    //                 "rgba(201,17,24, 0.6)",
    //                 "rgba(7,132,46, 0.6)"
    //                 ],
    //                 borderColor: [
    //                 "rgba(14,68,169, 1)",
    //                 "rgba(201,17,24, 1)",
    //                 "rgba(189,195,199, 5)",
    //                 "rgba(201,17,24, 1)",
    //                 "rgba(7,132,46, 1)"
    //                 ],
    //                 borderWidth: 1    
    //             }]
    //         },
    //         options: {
    //             // legend: {
    //             //     display: false
    //             //     },
    //             "onClick" : function (evt, item) {
    //                 console.log ("Enlace a pestaña más buscados");
    //             },
    //             scales: {
    //                 yAxes: [{
    //                         ticks: {
    //                             beginAtZero: true
    //                             },
    //                         display: true,

    //                         }],
    //                 xAxes: [{ 
    //                         ticks: {
    //                             fontSize: 11

    //                             }
    //                         }]
    //             },
    //             tooltips: {
    //                 titleSpacing:1,
    //                 inGraphDataShow : true,
    //                 datasetFill : true,
    //                 titleFontSize : 11,
    //                 callbacks: {
    //                     title: function(tooltipItem, data) {

    //                         var index = tooltipItem[0].index;
    //                         var label = data.labels2[index];
    //                         console.log(tooltipItem);                          
    //                         return  label;
    //                     },
    //                     label: function(tooltipItem, data) {
    //                         // var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || "Other";                            
    //                         // var label = data.labels2[tooltipItem.index];
    //                         var data1 = tooltipItem.xLabel;
    //                         var data2 = tooltipItem.yLabel;
    //                         return   data1;
    //                     },
    //                     titleAlign: function(tooltipItem, data) {
    //                         return   "center";
    //                     }
    //                 }
    //             }
    //         }
    //     });

    //    </script>';
    // }

    /**
     * <b>setMaxValue</b>
     * <br>
     * Calcula el valor máximo para un gráfico, a partir del valor máximo 
     * definido en la consulta del indicador
     */
    public function setMaxValue($maxValue)
    {
        $resp = $maxValue;
        $r = fmod($maxValue, 0.5);
        if ($r == 0 && $maxValue >= 1000) {
            $resp = $maxValue + 300;
        } elseif ($r == 0 && $maxValue < 10) {
            $resp = $maxValue + 0.1;
        } elseif ($r == 0 && $maxValue >= 10) {
            $resp = $maxValue + 1;
        } elseif ($r >= 0.1 && $maxValue < 9) {
            $resp = $maxValue + 0.05;
        } elseif ($r >= 0.1 && $maxValue >= 10000) {
            $resp = $maxValue + 1000;
        } elseif ($r >= 0.1 && $maxValue >= 100) {
            $resp = $maxValue + 10;
        } elseif ($r >= 0.1 && $maxValue >= 9 && $maxValue <= 10) {
            $resp = $maxValue + 2;
        } elseif ($r >= 0.1 && $maxValue >= 9) {
            $resp = $maxValue + 3;
        } elseif ($r >= 0.01 && $r <= 0.25 && $maxValue < 10) {
            $resp = $maxValue + 0.01;
        } elseif ($r >= 0.01 && $maxValue > 100) {
            $resp = $maxValue + 10;
        }

        return $resp;
    }

    /**
     * <b>sanearCadena</b>
     * <br>
     * Realiza el saneamiento de un texto, reemplazando caracteres especiales
     * y dejando todo el texto en minúscula
     * @param $cadena Texto a sanear
     * @return $texto Texto sin caracteres especiales ni mayúsculas
     */
    public function sanearCadena($cadena)
    {
        $texto = $cadena;
        $texto = str_replace(array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $texto);
        $texto = str_replace(array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $texto);
        $texto = str_replace(array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $texto);
        $texto = str_replace(array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $texto);
        $texto = str_replace(array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $texto);
        $texto = str_replace(array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C', ), $texto);
        $texto = str_replace(array('.'), array('!'), $texto);
        $texto = trim(strtolower($texto));
        return $texto;
    }

    /**
     * <b>sanearCadenainLowerCase</b>
     * <br>
     * Realiza el saneamiento de un texto, reemplazando caracteres especiales
     * y dejando mayúsculas y minúsculas tal como se reciben en el parámetro
     * @param $cadena Texto a sanear
     * @return $texto Texto sin caracteres especiales
     */
    public function sanearCadenaSinLowerCase($cadena)
    {
        $texto = $cadena;
        $texto = str_replace(array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $texto);
        $texto = str_replace(array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $texto);
        $texto = str_replace(array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $texto);
        $texto = str_replace(array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $texto);
        $texto = str_replace(array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $texto);
        $texto = str_replace(array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C', ), $texto);
        return $texto;
    }

    /**
     * <b>console_log</b>
     * <br>
     * Imprime valores en la consola del navegador
     * @param $output Texto a imprimir en la consola
     */
    public function console_log($output)
    {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
            ');';
        echo $js_code;
    }

    /**
     * <b>consultarRegistrosOPC</b>
     * <br>
     * Realiza la consulta de todos los registros a presentar en el 
     * Visualizador de datos del Observatorio de Paz y Cultura Ciudadana
     * @param $output Texto a imprimir en la consola
     */
    public function consultarRegistrosOPC()
    {
        $resp = array();
        $opc = new ConsultasOPCModel();
        $registros = $opc->consultarRegistrosOPC();
        if ($registros == "empty") {
            $resp = "empty";
        } else {
            $resp = json_encode($registros, JSON_UNESCAPED_UNICODE);
            echo $resp;
        }
    }

}

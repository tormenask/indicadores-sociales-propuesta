<?php

/**
 * <b>ConsultasVisualizadoresController</b>
 * Se encuentran los métodos necesarios para atender las consultas de los 
 * visualizadores de datos.
 */
class ConsultasVisualizadoresController {

    /**
     * <b>consultarEstablecimientosComunaController</b>
     * <br>
     * Realiza la consulta de los establecimientos educativos por comuna
     * @param string $nombreComuna Nombre de la comuna a consultar
     */
    public function consultarEstablecimientosComunaController($nombreComuna) {
        $idConjuntoIndicadores = 'CED';
        $consultas = new ConsultasVisualizadoresModel();
        $atributos = $consultas->consultarAtributosPorConjunto($idConjuntoIndicadores);
        $idAtributoComuna = $consultas->consultarIdAtributoPorNombreYConjunto('Comuna del establecimiento educativo', $idConjuntoIndicadores)['idAtributo'];
        $idAtributoCodigoDane = $consultas->consultarIdAtributoPorNombreYConjunto("Código DANE del establecimiento educativo", $idConjuntoIndicadores)['idAtributo'];
        $idAtributoNombre = $consultas->consultarIdAtributoPorNombreYConjunto("Nombre del establecimiento educativo", $idConjuntoIndicadores)['idAtributo'];
        $idAtributoTipo = $consultas->consultarIdAtributoPorNombreYConjunto("Tipo del establecimiento educativo", $idConjuntoIndicadores)['idAtributo'];
        $idAtributoSector = $consultas->consultarIdAtributoPorNombreYConjunto("Sector del establecimiento educativo", $idConjuntoIndicadores)['idAtributo'];
        $establecimientosEducativosComuna = $consultas->consultarIdEstablecimientosEducativosPorComunaYAtributo($nombreComuna, $idAtributoComuna);

        echo '
                <div class="panel panel-default">
                    <div class="panel-body" style="padding: 10px; border: 1px #215a9a solid;">
                        <div class="col-xs-12" style="text-align: left;">
                            <h3 class="ajustar-titulo" id="nombre_comuna" style="font-weight: bold; margin-top: 15px;">
                                Establecimientos educativos para la ' . $nombreComuna . '
                            </h3>
                            <p>Seleccione los establecimientos educativos a comparar:</p>
                            <br>
                        </div>
                        <div class="col-xs-12 col-sm-12" style="text-align: right;">
                            <div class="centerTable">
                                <table id="tablaDatos" class="table table-striped table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <td style="background-color:#0e6e37; color:#fff; text-align:center;">Consultar</td>
                                            <td style="background-color:#0e6e37; color:#fff; text-align:center;">Código DANE</td>
                                            <td style="background-color:#0e6e37; color:#fff; text-align:center;">Nombre</td>
                                            <td style="background-color:#0e6e37; color:#fff; text-align:center;">Tipo</td>
                                            <td style="background-color:#0e6e37; color:#fff; text-align:center;">Sector</td>
                                        </tr>                           
                                    </thead>
                                    <tbody>';
        foreach ($establecimientosEducativosComuna as $row => $item) {
            $idEstablecimiento = $item['idElementoPadre'];
            $codigoDane = $consultas->consultarElementoPorIdElementoPadreYIAdAtributo($idEstablecimiento, $idAtributoCodigoDane)['valorElemento'];
            $nombreEstablecimiento = $consultas->consultarElementoPorIdElementoPadreYIAdAtributo($idEstablecimiento, $idAtributoNombre)['valorElemento'];
            $tipoEstablecimiento = $consultas->consultarElementoPorIdElementoPadreYIAdAtributo($idEstablecimiento, $idAtributoTipo)['valorElemento'];
            $sectorEstablecimiento = $consultas->consultarElementoPorIdElementoPadreYIAdAtributo($idEstablecimiento, $idAtributoSector)['valorElemento'];
            echo '                      <tr>
                                            <td style="text-align:center;">
                                                <input type="checkbox" value="' . $idEstablecimiento . '">
                                            </td>
                                            <td style="text-align:center;">' . $codigoDane . '</td>
                                            <td style="text-align:center;">' . $nombreEstablecimiento . '</td>
                                            <td style="text-align:center;">' . $tipoEstablecimiento . '</td>
                                            <td style="text-align:center;">' . $sectorEstablecimiento . '</td>
                                        </tr>';
        }
        echo '                      </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12" style="text-align: left;">
                            <button type="button" id="btn-consultarEstablecimientos" class="btn btn-primary">
                                <i class="fa fa-search" aria-hidden="true" style="margin-right:10px;"></i>
                                <b>Consultar</b>
                           </button>
                        </div>
                    </div>
                </div>
                
                <script>
                    $("#btn-consultarEstablecimientos").on("click", function () {
                        consultarSeleccionados();
                    });
                </script>';
    }

    /**
     * <b>consultarGraficosEstablecimientosController</b>
     * <br>
     * Consulta los gráficos y tablas para los establecimientos educativos 
     * seleccionados
     * @param string $selected Nombres de los establecimientos educativos 
     * seleccionados
     */
    public function consultarGraficosEstablecimientosController($selected) {
        $idConjuntoIndicadores = 'CED';
        $establecimientos = explode(',', $selected);
        $consultasCEd = new ConsultasVisualizadoresModel();
        $idAtributoCodigoDane = $consultasCEd->consultarIdAtributoPorNombreYConjunto("Código DANE del establecimiento educativo", $idConjuntoIndicadores)['idAtributo'];
        $idAtributoNombre = $consultasCEd->consultarIdAtributoPorNombreYConjunto("Nombre del establecimiento educativo", $idConjuntoIndicadores)['idAtributo'];
        echo '
            <div class="panel panel-default">
                <div class="panel-body" style="padding: 10px; border: 1px #215a9a solid;">
                    <div class="col-xs-12" style="text-align: left;">
                        <h3 class="ajustar-titulo" id="nombre_comuna" style="font-weight: bold; margin-top: 15px;">
                            Resultado de la consulta
                        </h3>
                    </div>';
        $this->crearTablas($establecimientos, $idAtributoCodigoDane, $idAtributoNombre, 'Matriculados (últimos 3 años)');
        $this->crearTablas($establecimientos, $idAtributoCodigoDane, $idAtributoNombre, 'Evaluados (últimos 3 años)');
        $this->crearGraficos($establecimientos, $idAtributoCodigoDane, $idAtributoNombre, 'Índice de matemática');
        $this->crearGraficos($establecimientos, $idAtributoCodigoDane, $idAtributoNombre, 'Índice de ciencias naturales');
        $this->crearGraficos($establecimientos, $idAtributoCodigoDane, $idAtributoNombre, 'Índice de sociales y ciudadanas');
        $this->crearGraficos($establecimientos, $idAtributoCodigoDane, $idAtributoNombre, 'Índice de lectura crítica');
        $this->crearGraficos($establecimientos, $idAtributoCodigoDane, $idAtributoNombre, 'Índice de inglés');
        $this->crearGraficos($establecimientos, $idAtributoCodigoDane, $idAtributoNombre, 'Índice total');
        echo '  </div>
            </div>';
    }

    /**
     * <b>crearTablas</b>
     * <br>
     * Genera las tablas para el visualizador de datos de Calidad Educativa
     * @param string $establecimientos Nombres de los establecimientos educativos seleccionados
     * @param string $idAtributoCodigoDane ID del atributo correspondiente al
     * código DANE del establecimiento educativo
     * @param string $idAtributoNombre ID del atributo correspondiente al
     * nombre del establecimiento educativo
     * @param string $nombreSerie Nombre de la asignatura a consultar para el
     * establecimiento educativo.
     */
    public function crearTablas($establecimientos, $idAtributoCodigoDane, $idAtributoNombre, $nombreSerie) {

        $consultasCEd = new ConsultasVisualizadoresModel();
        $ser = new SeriesDatos();
        $dat = new Datos();
        $data = array();
        $fechas = array();
        foreach ($establecimientos as $establecimiento) {
            $idSerie = $ser->consultarIdSeriePorIdIndicadorDesagregacionTematica($establecimiento, $nombreSerie)['idSerieDatos'];
            $codigoEstablecimiento = $consultasCEd->consultarElementoPorIdElementoPadreYIAdAtributo($establecimiento, $idAtributoCodigoDane)['valorElemento'];
            $nombreEstablecimiento = $consultasCEd->consultarElementoPorIdElementoPadreYIAdAtributo($establecimiento, $idAtributoNombre)['valorElemento'];
            $datos = $dat->consultarDatosPorIdSerie($idSerie);
            $data[$establecimiento] = ["codigoEstablecimiento" => $codigoEstablecimiento, "nombreEstablecimiento" => $nombreEstablecimiento];
            foreach ($datos as $dato) {
                $data[$establecimiento][$dato['fechaDato']] = $dato['valorDato'];
                if (!in_array($dato['fechaDato'], $fechas)) {
                    array_push($fechas, $dato['fechaDato']);
                }
            }
        }
        echo '
                    <div class="col-xs-12 col-sm-12" style="text-align: left;">
                        <h4 style="text-align:center; font-weight: bold; margin-top: 15px;color:#0e6e37;">
                            ' . $nombreSerie . '
                        </h4>
                        <div class="centerTable">
                            <table id="tabla_' . str_replace(" ", "_", $nombreSerie) . '" class ="table table-striped table-bordered table-hover table-responsive">
                                <thead>
                                    <tr>
                                        <td style = "background-color:#0e6e37; color:#fff; text-align:center;">Código DANE</td>
                                        <td style = "background-color:#0e6e37; color:#fff; text-align:center;">Nombre</td>';
        foreach ($fechas as $fecha) {
            echo '                      <td style = "background-color:#0e6e37; color:#fff; text-align:center;">' . $fecha . '</td>';
        }
        echo '                      </tr>
                                </thead>
                                <tbody>
                                    ';
        foreach ($data as $row) {
            echo '<tr>';
            echo '                      <td style="text-align:center;">' . $row['codigoEstablecimiento'] . '</td>
                                        <td style="text-align:center;">' . $row['nombreEstablecimiento'] . '</td>';
            foreach ($fechas as $fecha) {
                echo '                  <td style="text-align:center;">' . $row[$fecha] . '</td>';
            }
            echo ' </tr>';
        }
        echo'                      
                                </tbody>
                            </table>
                        </div>
                    </div>';
    }

    /**
     * <b>crearTablas</b>
     * <br>
     * Genera los gráficos para el visualizador de datos de Calidad Educativa
     * @param string $establecimientos Nombres de los establecimientos educativos seleccionados
     * @param string $idAtributoCodigoDane ID del atributo correspondiente al
     * código DANE del establecimiento educativo
     * @param string $idAtributoNombre ID del atributo correspondiente al
     * nombre del establecimiento educativo
     * @param string $nombreSerie Nombre de la asignatura a consultar para el
     * establecimiento educativo.
     */
    public function crearGraficos($establecimientos, $idAtributoCodigoDane, $idAtributoNombre, $nombreSerie) {
        $consultasCEd = new ConsultasVisualizadoresModel();
        $ser = new SeriesDatos();
        $dat = new Datos();
        $fechas = array();
        $series = array();
        $nombresEstablecimientos = array();
        foreach ($establecimientos as $establecimiento) {
            $idSerie = $ser->consultarIdSeriePorIdIndicadorDesagregacionTematica($establecimiento, $nombreSerie)['idSerieDatos'];
            $series[] = $idSerie;
            $nombresEstablecimientos[] = $consultasCEd->consultarElementoPorIdElementoPadreYIAdAtributo($establecimiento, $idAtributoNombre)['valorElemento'];
            $fch = $dat->consultarFechasPorIdSerie($idSerie);
            foreach ($fch as $fecha) {
                if (!in_array($fecha['fechaDato'], $fechas)) {
                    array_push($fechas, $fecha['fechaDato']);
                }
            }
        }

        $totalDatos = sizeof($establecimientos) * sizeof($fechas);
        if (count($series) == 1) {
            $tipoGrafico = "Dona";
        } else {
            $tipoGrafico = "Barras";
        }
        $datasets = array();
        for ($k = 0; $k < count($series); $k++) {
            $serie = $series[$k];
            $datos = array();
            for ($l = 0; $l < count($fechas); $l++) {
                $fecha = $fechas[$l];
                $dato = $dat->consultarDatoPorIdSerieFecha($serie, $fecha);
                if (is_int($dato['valorDato'])) {
                    $datos[] = $dato['valorDato'];
                } else {
                    $datos[] = number_format($dato['valorDato'], 4, ".", ", ");
                }
            }
            $cons = new ConsultasModel();
            $colorAleatorio = $cons->selectColor();

            $countFechas = count($fechas);
            $backgroundColor = array();
            $counter = 0;
            while ($counter <= $countFechas) {
                array_push($backgroundColor, $cons->selectColor());
                $counter++;
            }
            if ($tipoGrafico == "Barras") {
                $datasets[] = [
                    "label" => $nombresEstablecimientos[$k],
                    "backgroundColor" => $colorAleatorio,
                    "data" => $datos];
            } elseif ($tipoGrafico == "Lineal") {
                $datasets[] = [
                    "label" => $nombresEstablecimientos[$k],
                    "borderColor" => $colorAleatorio,
                    "fill" => false,
                    "data" => $datos,
                    "pointStyle" => 'line'];
            } elseif ($tipoGrafico == "Dona") {
                $datasets[] = ["label" => $fechas[$k],
                    "backgroundColor" => $backgroundColor,
                    "data" => $datos];
            }
        }
        //Armar data
        $data = array("labels" => $fechas, "datasets" => $datasets);

        $fuentes = array();
        for ($p = 0; $p < count($series); $p++) {
            $serie = $series[$p];
            $resp3 = $ser->consultarFuentePorIdSerie($serie);
            if (!in_array($resp3["fuenteDatos"], $fuentes)) {
                $fuentes[] = $resp3["fuenteDatos"];
            }
        }
        //Rango
        $fechaInicio = $fechas[0];
        $fechaFin = end($fechas);
        $rango = "";
        if ($fechaFin == $fechaInicio) {
            $rango = $fechaInicio;
        } else {
            $rango = $fechaInicio . " - " . $fechaFin;
        }

        $unidadMedicion = "Índice";

        echo '
            <div class="col-xs-6">
                <div class="panel" style="border: solid 1px #215a9a;">
                    <div class="panel-body" style="padding: 0 0 10px;">
                        <div id="graf_' . str_replace(" ", "-", $nombreSerie) . '" style="background-color:#fff; padding: 4px 15px 5px;">
                            <h3 id="nombre_grafico_' . str_replace(" ", "-", $nombreSerie) . '" style="text-align:center;">' . $nombreSerie . '</h3>
                            <h4 style="text-align:center">' . $rango . '<br></h4>
                            <canvas id="grafico_' . str_replace(" ", "-", $nombreSerie) . '"></canvas>
                            <hr>
                            <p style="font-size:12px;"><strong>Gráfico:</strong> Sistema de Indicadores Sociales</p>
                            <p style="font-size:12px;"><strong>Fuente de datos:</strong> ' . implode("-", $fuentes) . ' </p>
                        </div>
                        <script>
                            var ctx = document.getElementById("grafico_' . str_replace(" ", "-", $nombreSerie) . '").getContext("2d"); ';
        $cons = new ConsultasController();

        if ($tipoGrafico == "Barras") {
            echo $cons->drawBarChartCalidadEducativa(json_encode($data), $unidadMedicion);
        } elseif ($tipoGrafico == "Lineal") {
            echo $cons->drawLineChartCalidadEducativa(json_encode($data), $unidadMedicion);
        } elseif ($tipoGrafico == "Dona") {
            echo $cons->drawDoughnutChart(json_encode($data), $unidadMedicion);
        }
        echo '          </script>
                        <div class"row" style="margin-top: 5px;">
                            <div class"col-sm-12">                         
                                <button type="button" id="btn_grafico_' . str_replace(" ", "-", $nombreSerie) . '" class="btn bt bt-ripple" style="width:200px; background-color:#52b1fe; color:#fff; margin-left: 15px;">
                                    <i class="fa fa-file-image-o" aria-hidden="true" style="margin-right:10px;"></i>
                                    <b>Descargar gráfico</b>
                                </button>
                                <script>
                                    $("#btn_grafico_' . str_replace(" ", "-", $nombreSerie) . '").click(function () {
                                        var nombreIndicador = ($("#nombre_grafico_' . str_replace(" ", "-", $nombreSerie) . '").text()).trim();
                                        var container = document.getElementById("graf_' . str_replace(" ", "-", $nombreSerie) . '");
                                        html2canvas(container).then(function (canvas) {
                                            var link = document.createElement("a");
                                            document.body.appendChild(link);
                                            link.download = "" + nombreIndicador + ".png";
                                            link.href = canvas.toDataURL();
                                            link.target = "_blank";
                                            link.click();
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
    }

}

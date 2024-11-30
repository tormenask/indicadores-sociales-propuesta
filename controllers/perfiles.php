<?php

/**
 * <b>PerfilesController</b>
 * Se encuentran las consultas necesarias para visualizar las secciones de
 * perfiles por comunas y perfil para Cali
 */
class PerfilesController {

    /**
     * <b>consultarIndicadoresPerfilCaliController</b>
     * <br>
     * Construye la visualización de la publicación Perfil para Cali
     */
    public function consultarIndicadoresPerfilCaliController() {
        $generalidades = $this->seccionPerfilCali("Generalidades");
        $pobrezaDesigualdad = $this->seccionPerfilCali("Pobreza y desigualdad");
        $entornoEconomico = $this->seccionPerfilCali("Entorno Económico y Buen Gobierno");
        $salud = $this->seccionPerfilCali("Salud");
        $educacion = $this->seccionPerfilCali("Educación");
        $cultura = $this->seccionPerfilCali("Cultura");
        $sostenibilidad = $this->seccionPerfilCali("Sostenibilidad");
        $pazSeguridad = $this->seccionPerfilCali("Paz y Seguridad ciudadana");
        $ciudadDigital = $this->seccionPerfilCali("Ciudad Digital");

        echo $generalidades;
        echo $pobrezaDesigualdad;
        echo $entornoEconomico;
        echo $salud;
        echo $educacion;
        echo $cultura;
        echo $sostenibilidad;
        echo $pazSeguridad;
        echo $ciudadDigital;
        echo '
            <div class="row" style="padding-bottom:20px;">
                <div class="col-sm-12">
                <h5><b>Fecha de actualización:</b> 18 de septiembre de 2018</h5>
                </div>
            </div>
        ';
    }

    /**
     * <b>seccionPerfilCali</b>
     * <br>
     * Construye la visualización de una sección para la publicación Perfil para Cali
     * @param string $nombreSeccion Nombre de la sección a construir
     */
    public function seccionPerfilCali($nombreSeccion) {
        $consultas = new PerfilesModel();
        $nombreImagen = $nombreSeccion;
        if ($nombreSeccion === "Pobreza y desigualdad") {
            $nombreImagen = "pobreza-desigualdad";
        } elseif ($nombreSeccion === "Entorno Económico y Buen Gobierno") {
            $nombreImagen = "entorno-economico";
        } elseif ($nombreSeccion === "Educación") {
            $nombreImagen = "educacion";
        } elseif ($nombreSeccion === "Paz y Seguridad ciudadana") {
            $nombreImagen = "paz-seguridad";
        }
        $seccion = '  
            <div class="row">
                <div class="col-sm-12">
                    <h4 style="color:#2fb56a; font-weight: bold;">
                        ' . $nombreSeccion . '
                    </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <img class="img-responsive" src="/views/resources/images/perfiles/' . $nombreImagen . '-cali.png" 
                        style="padding-left: 10px; float: right;" 
                        alt="Imagen para la sección ' . $nombreSeccion . '">
                </div>
                <div class="col-sm-9">';

        $resp1 = $consultas->consultarIndicadoresPorDimensionYZonaActual($nombreSeccion, "Cali");
        $respGen = "";
        $somb1 = true;
        foreach ($resp1 as $row => $item) {
            $nombreIndicador = $item[2];
            $fechaDato = $item[3];
            $valorDato = $item[4];
            $fuenteDatos = $item[6];
            $unidadMedicion = $item[7];

            if ($unidadMedicion === "Porcentaje" || $unidadMedicion === "Variación porcentual") {
                $unidadMedicion = "%";
            }
            if ($valorDato != "" && $valorDato != "-" && $valorDato != NULL) {
                $valor = "";

                if ($nombreIndicador === "GINI") {
                    $valor = number_format($valorDato, 3);
                } elseif (strpos($nombreIndicador, "Población") !== FALSE ||
                        strpos($nombreIndicador, "Producto Interno Bruto") !== FALSE ||
                        strpos($nombreIndicador, "Importaciones") !== FALSE ||
                        strpos($nombreIndicador, "Exportaciones") !== FALSE ||
                        strpos($nombreIndicador, "Ingresos") !== FALSE ||
                        strpos($nombreIndicador, "Gastos") !== FALSE ||
                        strpos($nombreIndicador, "Servicios de deuda pública") !== FALSE ||
                        strpos($nombreIndicador, "Superávit/Déficit") !== FALSE
                ) {
                    $valor = number_format($valorDato) . ' ' . $unidadMedicion;
                } elseif ($unidadMedicion === "Número") {
                    $valor = number_format($valorDato);
                } elseif ($unidadMedicion === "Razón" ||
                        $unidadMedicion === "Proporción" ||
                        $unidadMedicion === "Puntuación" ||
                        $unidadMedicion === "Puntaje") {
                    $valor = number_format($valorDato, 1);
                } elseif ($unidadMedicion === "Pesos") {
                    $valor = '$' . number_format($valorDato);
                } else {
                    $valor = number_format($valorDato, 1) . ' ' . $unidadMedicion;
                }
                $color = ($somb1) ? "#eee" : "#fff";
                $seccion = $seccion
                        . ' <div class = "row" style = "background-color:' . $color . '; 
                                border-radius: 5px; border: 1px solid ' . $color . '; padding-left:15px;">
                                <div class = "col-sm-12" style = "padding-left:0px;">
                                    <div class = "col-sm-6" style = "padding-left:0px;">
                                        <h5 style = "text-align:left; font-weight: bold; line-height: 1.4 !important;">
                                            ' . $nombreIndicador . ':
                                        </h5>
                                    </div>
                                    <div class = "col-sm-6">
                                        <h5 style = "text-align:left; color: #2fb56a; font-weight: bold; line-height: 0.4 !important;">
                                            ' . $valor . '
                                        </h5>
                                        <p style = "text-align:left;  font-size: 11px; margin:0px;">
                                            (' . $fechaDato . ' - ' . $fuenteDatos . ')' . '
                                        </p>
                                    </div>';
                if ($nombreSeccion !== "Generalidades") {

                    $indicador = new Indicadores();
                    $nombreIndicadorConsulta = $nombreIndicador;
                    if ($nombreSeccion === "Cultura") {
                        $nombreIndicadorConsulta = "Establecimientos para la cultura y la recreación";
                    }
                    if ($nombreIndicador === "Hurtos a personas por cada 100 mil habitantes") {
                        $nombreIndicadorConsulta = "Hurtos por cada 100 mil habitantes";
                    }
                    $informacionIndicador = $indicador->consultarIndicadoresPorNombreExacto($nombreIndicadorConsulta);

                    if (!empty($informacionIndicador)) {
                        $idIndicador = $informacionIndicador[0];
                        $informacionEnlace = $indicador->consultarInformacionEnlacePorIdIndicadorYGeografia($idIndicador, "Cali");
                        $consulta = new ConsultasController();
                        $enlace = $consulta->crearEnlace($informacionEnlace, "Cali");
                        $seccion = $seccion . ' 
                                    <div class = "col-sm-1">
                                        <a class="consultarIndicadorBuscador" href="' . $enlace . '">
                                            <h5 style = "text-align:left; font-weight: bold; line-height: 1.4 !important;">
                                               <i class="fa fa-search fa-lg"></i>
                                           </h5>
                                        </a>
                                    </div>';
                    }
                }
                $seccion = $seccion . '</div>
                            </div>';
                $somb1 = !$somb1;
                $respGen = $respGen . $nombreIndicador . "*" . $fechaDato . "*" . $valor . "*" . $fuenteDatos . "++";
            }
        }
        $seccion = $seccion . '
                </div>
            </div>
            <hr>';
        return $seccion;
    }

    /**
     * <b>consultarIndicadoresPerfilesController</b>
     * <br>
     * Construye la visualización de la publicación Perfil para Comuna
     * @param string $nombreComuna Nombre de la comuna a consultar
     */
    public function consultarIndicadoresPerfilesController($nombreComuna) {
        $consultas = new PerfilesModel();
        // Generalidades
        $generalidades = '  <div>
                                <h4 style="color:#275f9d; font-weight: bold; text-align:center;">Generalidades</h4>
                                <hr style="margin-top: 0px;">';

        $resp1 = $consultas->consultarIndicadoresPorDimensionYZonaActual("Generalidades", $nombreComuna);
        $respGen = "";
        $somb1 = true;
        foreach ($resp1 as $row => $item) {
            $nombreIndicador = $item[2];
            $fechaDato = $item[3];
            $valorDato = $item[4];
            $fuenteDatos = $item[6];
            $unidadMedicion = $item[7];

            if ($unidadMedicion == "Porcentaje") {
                $unidadMedicion = "%";
            }
            if ($valorDato != "" && $valorDato != "-" && $valorDato != NULL) {
                $valor = "";
                if ($nombreIndicador === "Area bruta" || $nombreIndicador === "Densidad bruta (Viviendas/ha)" ||
                        $nombreIndicador === "Densidad bruta (Habitante/ha)") {
                    $valor = number_format($valorDato, 1) . ' ' . $unidadMedicion;
                } else {
                    $valor = number_format($valorDato);
                }
                $color = ($somb1) ? "#eee" : "#fff";
                $generalidades = $generalidades
                        . ' <div class = "row" style = "background-color:' . $color . '; 
                                border-radius: 5px; border: 1px solid ' . $color . '; padding:5px;">
                                <div class = "col-xs-12 col-sm-12" style = "padding-left:0px;">
                                    <div class = "col-xs-12 col-sm-6" style = "padding-left:0px;">
                                        <h5 style = "text-align:left; font-weight: bold; line-height: 1.4 !important;">
                                            ' . $nombreIndicador . ':
                                        </h5>
                                    </div>
                                    <div class = "col-xs-12 col-sm-6">
                                        <h5 style = "text-align:left; color: #275f9d; font-weight: bold;">
                                            ' . $valor . '
                                        </h5>
                                        <p style = "text-align:left;  font-size: 11px; margin:0px;">
                                            (' . $fechaDato . ' - ' . $fuenteDatos . ')' . '
                                        </p>
                                    </div>
                                </div>
                            </div>';
                $somb1 = !$somb1;
                $respGen = $respGen . $nombreIndicador . "*" . $fechaDato . "*" . $valor . "*" . $fuenteDatos . "++";
            }
        }
        $generalidades = $generalidades . '</div>';
        // Salud
        $salud = '  <div>
                        <h4 style="color:#275f9d; font-weight: bold; text-align:center;">Salud</h4>
                        <hr style="margin-top: 0px;">';
        $respSalud = "";
        $resp2 = $consultas->consultarIndicadoresPorDimensionYZonaActual("Salud", $nombreComuna);
        $somb2 = true;
        foreach ($resp2 as $row => $item) {
            $nombreIndicador = $item[2];
            // var_dump($nombreIndicador);
            $fechaDato = $item[3];
            $valorDato = $item[4];
            $fuenteDatos = $item[6];
            $unidadMedicion = $item[7];
            if ($unidadMedicion == "Porcentaje") {
                $unidadMedicion = "%";
            }

            if ($valorDato != "" && $valorDato != "-" && $valorDato != NULL) {
                $valor = "";
                if ($nombreIndicador === "Tasa de fecundidad en madres en edad Fertil (15 - 49 años)" || $nombreIndicador === "Tasa de Mortalidad General") {
                    $valor = number_format($valorDato, 1, ".", ",");
                } else {
                    $valor = number_format($valorDato);
                }
                $color = ($somb2) ? "#eee" : "#fff";
                $salud = $salud
                        . ' <div class = "row" style = "background-color:' . $color . '; 
                                border-radius: 5px; border: 1px solid ' . $color . '; padding:5px;">
                                <div class = "col-xs-12 col-sm-12" style = "padding-left:0px;">
                                    <div class = "col-xs-12 col-sm-6" style = "padding-left:0px;">
                                        <h5 style = "text-align:left; font-weight: bold; line-height: 1.4 !important;">
                                            ' . $nombreIndicador . ':
                                        </h5>
                                    </div>
                                    <div class = "col-xs-12 col-sm-6">
                                        <h5 style = "text-align:left; color: #275f9d; font-weight: bold;">
                                            ' . $valor . '
                                        </h5>
                                        <p style = "text-align:left;  font-size: 11px; margin:0px;">
                                            (' . $fechaDato . ' - ' . $fuenteDatos . ')' . '
                                        </p>
                                    </div>
                                </div>
                            </div>';
                $somb2 = !$somb2;
                $respSalud = $respSalud . $nombreIndicador . "*" . $fechaDato . "*" . $valor . "*" . $fuenteDatos . "++";
            }
        }
        $salud = $salud . '</div>';
        // Educación
        $educación = '  <div>
                        <h4 style="color:#275f9d; font-weight: bold; text-align:center;">Educación</h4>
                        <hr style="margin-top: 0px;">';
        $somb3 = true;
        $respEducacion = "";
        $resp3 = $consultas->consultarIndicadoresPorDimensionYZonaActual("Educación", $nombreComuna);
        foreach ($resp3 as $row => $item) {
            $nombreIndicador = $item[2];
            $fechaDato = $item[3];
            $valorDato = $item[4];
            $fuenteDatos = $item[6];
            $unidadMedicion = $item[7];
            if ($unidadMedicion == "Porcentaje") {
                $unidadMedicion = "%";
            }

            if ($valorDato != "" && $valorDato != "-" && $valorDato != NULL) {
                $valor = number_format($valorDato);
                $color = ($somb3) ? "#eee" : "#fff";
                $educación = $educación
                        . ' <div class = "row" style = "background-color:' . $color . '; 
                                border-radius: 5px; border: 1px solid ' . $color . '; padding:5px;">
                                <div class = "col-xs-12 col-sm-12" style = "padding-left:0px;">
                                    <div class = "col-xs-12 col-sm-6" style = "padding-left:0px;">
                                        <h5 style = "text-align:left; font-weight: bold; line-height: 1.4 !important;">
                                            ' . $nombreIndicador . ':
                                        </h5>
                                    </div>
                                    <div class = "col-xs-12 col-sm-6">
                                        <h5 style = "text-align:left; color: #275f9d; font-weight: bold;">
                                            ' . $valor . '
                                        </h5>
                                        <p style = "text-align:left;  font-size: 11px; margin:0px;">
                                            (' . $fechaDato . ' - ' . $fuenteDatos . ')' . '
                                        </p>
                                    </div>
                                </div>
                            </div>';
                $somb3 = !$somb3;
                $respEducacion = $respEducacion . $nombreIndicador . "*" . $fechaDato . "*" . $valor . "*" . $fuenteDatos . "++";
            }
        }
        $educación = $educación . '</div>';

        // Cultura
        $cultura = '  <div>
                        <h4 style="color:#275f9d; font-weight: bold; text-align:center;">Cultura</h4>
                        <hr style="margin-top: 0px;">';
        $somb4 = true;
        $respCultura = "";
        $resp4 = $consultas->consultarIndicadoresPorDimensionYZonaActual("Cultura", $nombreComuna);
        foreach ($resp4 as $row => $item) {
            $nombreIndicador = $item[2];
            $fechaDato = $item[3];
            $valorDato = $item[4];
            $fuenteDatos = $item[6];
            $unidadMedicion = $item[7];
            if ($unidadMedicion == "Porcentaje") {
                $unidadMedicion = "%";
            }

            if ($valorDato != "" && $valorDato != "-" && $valorDato != NULL) {
                $valor = number_format($valorDato);
                $color = ($somb4) ? "#eee" : "#fff";
                $cultura = $cultura
                        . ' <div class = "row" style = "background-color:' . $color . '; 
                                border-radius: 5px; border: 1px solid ' . $color . '; padding:5px;">
                                <div class = "col-xs-12 col-sm-12" style = "padding-left:0px;">
                                    <div class = "col-xs-12 col-sm-6" style = "padding-left:0px;">
                                        <h5 style = "text-align:left; font-weight: bold; line-height: 1.4 !important;">
                                            ' . $nombreIndicador . ':
                                        </h5>
                                    </div>
                                    <div class = "col-xs-12 col-sm-6">
                                        <h5 style = "text-align:left; color: #275f9d; font-weight: bold;">
                                            ' . $valor . '
                                        </h5>
                                        <p style = "text-align:left;  font-size: 11px; margin:0px;">
                                            (' . $fechaDato . ' - ' . $fuenteDatos . ')' . '
                                        </p>
                                    </div>
                                </div>
                            </div>';
                $somb4 = !$somb4;
                $respCultura = $respCultura . $nombreIndicador . "*" . $fechaDato . "*" . $valor . "*" . $fuenteDatos . "++";
            }
        }
        $cultura = $cultura . '</div>';

        // Paz y seguridad ciudadana
        $pazSeguridad = '  <div>
                        <h4 style="color:#275f9d; font-weight: bold; text-align:center;">Paz y seguridad ciudadana</h4>
                        <hr style="margin-top: 0px;">';
        $somb5 = true;
        $respPazSeguridad = "";
        $resp5 = $consultas->consultarIndicadoresPorDimensionYZonaActual("Paz y Seguridad ciudadana", $nombreComuna);
        foreach ($resp5 as $row => $item) {
            $nombreIndicador = $item[2];
            $fechaDato = $item[3];
            $valorDato = $item[4];
            $fuenteDatos = $item[6];
            $unidadMedicion = $item[7];
            if ($unidadMedicion == "Porcentaje") {
                $unidadMedicion = "%";
            }

            if ($valorDato != "" && $valorDato != "-" && $valorDato != NULL) {
                if ($nombreIndicador === "Tasa de homicidios por cada 100 mil habitantes" || $nombreIndicador === "Hurtos a personas por cada 100 mil habitantes" || $nombreIndicador === "Tasa de homicidios en accidentes de tránsito por cada 100 mil habitantes" || $nombreIndicador === "Tasa de homicidios en accidentes tránsito" || $nombreIndicador === "Tasa de suicidios por cada 100 mil habitantes" || $nombreIndicador === "Tasa de violencia familiar por cada 100 mil habitantes" || $nombreIndicador === "Tasa de violencia sexual por cada 100 mil habitantes") {
                    $valor = number_format($valorDato, 1, ".", ",");
                } else {
                    $valor = number_format($valorDato);
                }
                $color = ($somb5) ? "#eee" : "#fff";
                $pazSeguridad = $pazSeguridad
                        . ' <div class = "row" style = "background-color:' . $color . '; 
                                border-radius: 5px; border: 1px solid ' . $color . '; padding:5px;">
                                <div class = "col-xs-12 col-sm-12" style = "padding-left:0px;">
                                    <div class = "col-xs-12 col-sm-6" style = "padding-left:0px;">
                                        <h5 style = "text-align:left; font-weight: bold; line-height: 1.4 !important;">
                                            ' . $nombreIndicador . ':
                                        </h5>
                                    </div>
                                    <div class = "col-xs-12 col-sm-6">
                                        <h5 style = "text-align:left; color: #275f9d; font-weight: bold;">
                                            ' . $valor . '
                                        </h5>
                                        <p style = "text-align:left;  font-size: 11px; margin:0px;">
                                            (' . $fechaDato . ' - ' . $fuenteDatos . ')' . '
                                        </p>
                                    </div>
                                </div>
                            </div>';
                $somb5 = !$somb5;
                $respPazSeguridad = $respPazSeguridad . $nombreIndicador . "*" . $fechaDato . "*" . $valor . "*" . $fuenteDatos . "++";
            }
        }
        $pazSeguridad = $pazSeguridad . '</div>';


        if ($nombreComuna != "Cali") {
            
        }
        // Encuesta de Empleo y Calidad de Vida
        $encuestaEmpleoCalidad = '  
            <div>
                <h4 style="color:#275f9d; font-weight: bold; text-align:center;">Encuesta de Empleo y Calidad de Vida</h4>
                <hr style="margin-top: 0px;">';

        $somb6 = true;
        $encuestaEmpleoCalidad = $encuestaEmpleoCalidad . '
                <div class="row"
                    <div class="col-xs-12 col-md-12">
                        <h5 style="text-align:center; font-weight:bold; border: 1px solid black; border-radius:5px;">
                            Dependencia
                        </h5>
                    </div>
                </div>';
        $respEncuestaDependencia = "";
        $resp6 = $consultas->consultarIndicadoresPorDimensionComunaCategoriaEncuesta("Encuesta de Empleo y Calidad de vida", $nombreComuna, "Dependencia");
        foreach ($resp6 as $row => $item) {
            $nombreIndicador = $item[2];
            $fechaDato = $item[3];
            $valorDato = $item[4];
            $fuenteDatos = $item[6];
            $unidadMedicion = $item[7];
            if ($unidadMedicion == "Porcentaje") {
                $unidadMedicion = "%";
            } elseif ($unidadMedicion == "Número por cada 100 personas") {
                $unidadMedicion = "por cada 100 personas";
            }

            if ($valorDato != "" && $valorDato != "-" && $valorDato != NULL) {
                $valor = number_format($valorDato, 1, ".", ",");
                $color = ($somb6) ? "#eee" : "#fff";
                $encuestaEmpleoCalidad = $encuestaEmpleoCalidad .
                        ' <div class = "row" style = "background-color:' . $color . '; 
                            border-radius: 5px; border: 1px solid ' . $color . '; padding:5px;">
                            <div class = "col-xs-12 col-sm-12" style = "padding-left:0px;">
                                <div class = "col-xs-12 col-sm-6" style = "padding-left:0px;">
                                    <h5 style = "text-align:left; font-weight: bold; line-height: 1.4 !important;">
                                        ' . $nombreIndicador . ':
                                    </h5>
                                </div>
                                <div class = "col-xs-12 col-sm-6">
                                    <h5 style = "text-align:left; color: #275f9d; font-weight: bold;">
                                        ' . $valor . ' ' . $unidadMedicion . '
                                    </h5>
                                    <p style = "text-align:left;  font-size: 11px; margin:0px;">
                                        (' . $fechaDato . ' - ' . $fuenteDatos . ')' . '
                                    </p>
                                </div>
                            </div>
                    </div>';
                $somb6 = !$somb6;
                $respEncuestaDependencia = $respEncuestaDependencia . $nombreIndicador . "*" . $fechaDato . "*" . $valor . "*" . $fuenteDatos . "++";
            }
        }

        $somb7 = true;
        $encuestaEmpleoCalidad = $encuestaEmpleoCalidad . '
                <div class="row"
                    <div class="col-xs-12 col-md-12">
                        <h5 style="text-align:center; font-weight:bold; border: 1px solid black; border-radius:5px;">
                            Educación
                        </h5>
                    </div>
               ';
        $respEncuestaEducacion = "";
        $resp7 = $consultas->consultarIndicadoresPorDimensionComunaCategoriaEncuesta("Encuesta de Empleo y Calidad de vida", $nombreComuna, "Educación");
        foreach ($resp7 as $row => $item) {
            $nombreIndicador = $item[2];
            $fechaDato = $item[3];
            $valorDato = $item[4];
            $fuenteDatos = $item[6];
            $unidadMedicion = $item[7];
            if ($unidadMedicion == "Porcentaje") {
                $unidadMedicion = "%";
            }

            if ($valorDato != "" && $valorDato != "-" && $valorDato != NULL) {
                $valor = number_format($valorDato, 1, ".", ",");
                $color = ($somb7) ? "#eee" : "#fff";
                $encuestaEmpleoCalidad = $encuestaEmpleoCalidad .
                        ' <div class = "row" style = "background-color:' . $color . '; 
                            border-radius: 5px; border: 1px solid ' . $color . '; padding:5px;">
                            <div class = "col-xs-12 col-sm-12" style = "padding-left:0px;">
                                <div class = "col-xs-12 col-sm-6" style = "padding-left:0px;">
                                    <h5 style = "text-align:left; font-weight: bold; line-height: 1.4 !important;">
                                        ' . $nombreIndicador . ':
                                    </h5>
                                </div>
                                <div class = "col-xs-12 col-sm-6">
                                    <h5 style = "text-align:left; color: #275f9d; font-weight: bold;">
                                        ' . $valor . ' ' . $unidadMedicion . '
                                    </h5>
                                    <p style = "text-align:left;  font-size: 11px; margin:0px;">
                                        (' . $fechaDato . ' - ' . $fuenteDatos . ')' . '
                                    </p>
                                </div>
                            </div>
                    </div>';
                $somb7 = !$somb7;
                $respEncuestaEducacion = $respEncuestaEducacion . $nombreIndicador . "*" . $fechaDato . "*" . $valor . "*" . $fuenteDatos . "++";
            }
        }

        $somb8 = true;
        $encuestaEmpleoCalidad = $encuestaEmpleoCalidad . '
                <div class="row"
                    <div class="col-xs-12 col-md-12">
                        <h5 style="text-align:center; font-weight:bold; border: 1px solid black; border-radius:5px;">
                            Mercado laboral
                        </h5>
                    </div>
               ';
        $respEncuestaMercadoLaboral = "";
        $resp8 = $consultas->consultarIndicadoresPorDimensionComunaCategoriaEncuesta("Encuesta de Empleo y Calidad de vida", $nombreComuna, "Mercado laboral");
        foreach ($resp8 as $row => $item) {
            $nombreIndicador = $item[2];
            $fechaDato = $item[3];
            $valorDato = $item[4];
            $fuenteDatos = $item[6];
            $unidadMedicion = $item[7];
            if ($unidadMedicion == "Porcentaje") {
                $unidadMedicion = "%";
            }

            if ($valorDato != "" && $valorDato != "-" && $valorDato != NULL) {
                $valor = number_format($valorDato, 1, ".", ",");
                $color = ($somb8) ? "#eee" : "#fff";
                $encuestaEmpleoCalidad = $encuestaEmpleoCalidad .
                        ' <div class = "row" style = "background-color:' . $color . '; 
                            border-radius: 5px; border: 1px solid ' . $color . '; padding:5px;">
                            <div class = "col-xs-12 col-sm-12" style = "padding-left:0px;">
                                <div class = "col-xs-12 col-sm-6" style = "padding-left:0px;">
                                    <h5 style = "text-align:left; font-weight: bold; line-height: 1.4 !important;">
                                        ' . $nombreIndicador . ':
                                    </h5>
                                </div>
                                <div class = "col-xs-12 col-sm-6">
                                    <h5 style = "text-align:left; color: #275f9d; font-weight: bold;">
                                        ' . $valor . ' ' . $unidadMedicion . '
                                    </h5>
                                    <p style = "text-align:left;  font-size: 11px; margin:0px;">
                                        (' . $fechaDato . ' - ' . $fuenteDatos . ')' . '
                                    </p>
                                </div>
                            </div>
                    </div>';
                $somb8 = !$somb8;
                $respEncuestaMercadoLaboral = $respEncuestaMercadoLaboral . $nombreIndicador . "*" . $fechaDato . "*" . $valor . "*" . $fuenteDatos . "++";
            }
        }

        $somb9 = true;
        $encuestaEmpleoCalidad = $encuestaEmpleoCalidad . '
                <div class="row"
                    <div class="col-xs-12 col-md-12">
                        <h5 style="text-align:center; font-weight:bold; border: 1px solid black; border-radius:5px;">
                            Salud
                        </h5>
                    </div>
               ';
        $respEncuestaSalud = "";
        $resp9 = $consultas->consultarIndicadoresPorDimensionComunaCategoriaEncuesta("Encuesta de Empleo y Calidad de vida", $nombreComuna, "Salud");
        foreach ($resp9 as $row => $item) {
            $nombreIndicador = $item[2];
            $fechaDato = $item[3];
            $valorDato = $item[4];
            $fuenteDatos = $item[6];
            $unidadMedicion = $item[7];
            if ($unidadMedicion == "Porcentaje") {
                $unidadMedicion = "%";
            }

            if ($valorDato != "" && $valorDato != "-" && $valorDato != NULL) {
                $valor = number_format($valorDato, 1, ".", ",");
                $color = ($somb9) ? "#eee" : "#fff";
                $encuestaEmpleoCalidad = $encuestaEmpleoCalidad .
                        ' <div class = "row" style = "background-color:' . $color . '; 
                            border-radius: 5px; border: 1px solid ' . $color . '; padding:5px;">
                            <div class = "col-xs-12 col-sm-12" style = "padding-left:0px;">
                                <div class = "col-xs-12 col-sm-6" style = "padding-left:0px;">
                                    <h5 style = "text-align:left; font-weight: bold; line-height: 1.4 !important;">
                                        ' . $nombreIndicador . ':
                                    </h5>
                                </div>
                                <div class = "col-xs-12 col-sm-6">
                                    <h5 style = "text-align:left; color: #275f9d; font-weight: bold;">
                                        ' . $valor . ' ' . $unidadMedicion . '
                                    </h5>
                                    <p style = "text-align:left;  font-size: 11px; margin:0px;">
                                        (' . $fechaDato . ' - ' . $fuenteDatos . ')' . '
                                    </p>
                                </div>
                            </div>
                    </div>';
                $somb9 = !$somb9;
                $respEncuestaSalud = $respEncuestaSalud . $nombreIndicador . "*" . $fechaDato . "*" . $valor . "*" . $fuenteDatos . "++";
            }
        }

        $somb10 = true;
        $encuestaEmpleoCalidad = $encuestaEmpleoCalidad . '
                <div class="row"
                    <div class="col-xs-12 col-md-12">
                        <h5 style="text-align:center; font-weight:bold; border: 1px solid black; border-radius:5px;">
                            Servicios públicos
                        </h5>
                    </div>
               ';
        $respEncuestaServiciosPublicos = "";
        $resp10 = $consultas->consultarIndicadoresPorDimensionComunaCategoriaEncuesta("Encuesta de Empleo y Calidad de vida", $nombreComuna, "Servicios públicos");
        foreach ($resp10 as $row => $item) {
            $nombreIndicador = $item[2];
            $fechaDato = $item[3];
            $valorDato = $item[4];
            $fuenteDatos = $item[6];
            $unidadMedicion = $item[7];
            if ($unidadMedicion == "Porcentaje") {
                $unidadMedicion = "%";
            }

            if ($valorDato != "" && $valorDato != "-" && $valorDato != NULL) {
                $valor = number_format($valorDato, 1, ".", ",");
                $color = ($somb10) ? "#eee" : "#fff";
                $encuestaEmpleoCalidad = $encuestaEmpleoCalidad .
                        ' <div class = "row" style = "background-color:' . $color . '; 
                            border-radius: 5px; border: 1px solid ' . $color . '; padding:5px;">
                            <div class = "col-xs-12 col-sm-12" style = "padding-left:0px;">
                                <div class = "col-xs-12 col-sm-6" style = "padding-left:0px;">
                                    <h5 style = "text-align:left; font-weight: bold; line-height: 1.4 !important;">
                                        ' . $nombreIndicador . ':
                                    </h5>
                                </div>
                                <div class = "col-xs-12 col-sm-6">
                                    <h5 style = "text-align:left; color: #275f9d; font-weight: bold;">
                                        ' . $valor . ' ' . $unidadMedicion . '
                                    </h5>
                                    <p style = "text-align:left;  font-size: 11px; margin:0px;">
                                        (' . $fechaDato . ' - ' . $fuenteDatos . ')' . '
                                    </p>
                                </div>
                            </div>
                    </div>';
                $somb10 = !$somb10;
                $respEncuestaServiciosPublicos = $respEncuestaServiciosPublicos . $nombreIndicador . "*" . $fechaDato . "*" . $valor . "*" . $fuenteDatos . "++";
            }
        }

        $somb11 = true;
        $encuestaEmpleoCalidad = $encuestaEmpleoCalidad . '
                <div class="row"
                    <div class="col-xs-12 col-md-12">
                        <h5 style="text-align:center; font-weight:bold; border: 1px solid black; border-radius:5px;">
                            Uso de TICS                        
                        </h5>
                    </div>
               ';
        $respEncuestaTics = "";
        $resp11 = $consultas->consultarIndicadoresPorDimensionComunaCategoriaEncuesta("Encuesta de Empleo y Calidad de vida", $nombreComuna, "Uso de TICS");
        foreach ($resp11 as $row => $item) {
            $nombreIndicador = $item[2];
            $fechaDato = $item[3];
            $valorDato = $item[4];
            $fuenteDatos = $item[6];
            $unidadMedicion = $item[7];
            if ($unidadMedicion == "Porcentaje") {
                $unidadMedicion = "%";
            }

            if ($valorDato != "" && $valorDato != "-" && $valorDato != NULL) {
                $valor = number_format($valorDato, 1, ".", ",");
                $color = ($somb11) ? "#eee" : "#fff";
                $encuestaEmpleoCalidad = $encuestaEmpleoCalidad .
                        ' <div class = "row" style = "background-color:' . $color . '; 
                            border-radius: 5px; border: 1px solid ' . $color . '; padding:5px;">
                            <div class = "col-xs-12 col-sm-12" style = "padding-left:0px;">
                                <div class = "col-xs-12 col-sm-6" style = "padding-left:0px;">
                                    <h5 style = "text-align:left; font-weight: bold; line-height: 1.4 !important;">
                                        ' . $nombreIndicador . ':
                                    </h5>
                                </div>
                                <div class = "col-xs-12 col-sm-6">
                                    <h5 style = "text-align:left; color: #275f9d; font-weight: bold;">
                                        ' . $valor . ' ' . $unidadMedicion . '
                                    </h5>
                                    <p style = "text-align:left;  font-size: 11px; margin:0px;">
                                        (' . $fechaDato . ' - ' . $fuenteDatos . ')' . '
                                    </p>
                                </div>
                            </div>
                    </div>';
                $somb11 = !$somb11;
                $respEncuestaTics = $respEncuestaTics . $nombreIndicador . "*" . $fechaDato . "*" . $valor . "*" . $fuenteDatos . "++";
            }
        }

        $encuestaEmpleoCalidad = $encuestaEmpleoCalidad . '</div>';

        echo '
            <div class="col-sm-12">
                <div class="panel panel-default" style="margin-bottom: -15px;">
                    <div class="panel-body" style="padding: 10px; border: 1px #275f9d solid;">
                        <div class="col-xs-12 col-sm-6" style="text-align: left;">
                           <h3 class="ajustar-titulo" id="nombre_comuna" style="font-weight: bold; line-height: 0.2 !important; margin-top: 15px;">' . $nombreComuna . '</h3>
                        </div>
                        <div class="col-xs-12 col-sm-6" style="text-align: right;">';

        if ($nombreComuna == "") {
            $nombreComuna = "_____";
        }

        $nombreComunaCorr = preg_replace("/(\n|\r|\n\r)/", ' ', $nombreComuna);
        echo '
                        <script>
                            document.formFicha.nombreComunaForm.value = "' . $nombreComunaCorr . '";
                            document.formFicha.generalidadesForm.value = "' . $respGen . '";
                            document.formFicha.saludForm.value = "' . $respSalud . '";
                            document.formFicha.educacionForm.value = "' . $respEducacion . '";
                            document.formFicha.culturaForm.value = "' . $respCultura . '";
                            document.formFicha.pazSeguridadForm.value = "' . $respPazSeguridad . '";
                            document.formFicha.encuestaDependenciaForm.value = "' . $respEncuestaDependencia . '";
                            document.formFicha.encuestaEducacionForm.value = "' . $respEncuestaEducacion . '";
                            document.formFicha.encuestaMercadoLaboralForm.value = "' . $respEncuestaMercadoLaboral . '";
                            document.formFicha.encuestaSaludForm.value = "' . $respEncuestaSalud . '";
                            document.formFicha.encuestaServiciosPublicosForm.value = "' . $respEncuestaServiciosPublicos . '";
                            document.formFicha.encuestaTicsForm.value = "' . $respEncuestaTics . '";
                        </script>
                        <div class="row">
                            <form id="formFicha" name="formFicha" action="/views/generar/perfiles_comunas.php" target="_blank" method="post">
                                <input type="hidden" name="nombreComunaForm" id="nombreComunaForm"/>
                                <input type="hidden" name="generalidadesForm" id="generalidadesForm"/>
                                <input type="hidden" name="saludForm" id="saludForm"/>
                                <input type="hidden" name="educacionForm" id="educacionForm"/>
                                <input type="hidden" name="culturaForm" id="culturaForm"/>
                                <input type="hidden" name="pazSeguridadForm" id="pazSeguridadForm"/>
                                <input type="hidden" name="encuestaDependenciaForm" id="encuestaDependenciaForm"/>
                                <input type="hidden" name="encuestaEducacionForm" id="encuestaEducacionForm"/>
                                <input type="hidden" name="encuestaMercadoLaboralForm" id="encuestaMercadoLaboralForm"/>
                                <input type="hidden" name="encuestaSaludForm" id="encuestaSaludForm"/>
                                <input type="hidden" name="encuestaServiciosPublicosForm" id="encuestaServiciosPublicosForm"/>
                                <input type="hidden" name="encuestaTicsForm" id="encuestaTicsForm"/>
                                    <button type="submit" class="btn bt bt-ripple" 
                                    style="width:100%; border-radius: 5px;margin-right: 5px;background-color:#aa0501; color:#fff;">
                                    <i class="fa fa-file-pdf-o" aria-hidden="true" style="margin-right:10px;"></i>
                                    <b>Descargar PDF</b>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-12 bhoechie-tab-container" style="border: 1px #275f9d solid;">
                <div class="col-sm-2 bhoechie-tab-menu">
                    <div class="list-group">
                        <a class="list-group-item active text-center" href="#">
                            <i class="fa fa-info" style="font-size: 30px;" aria-hidden="true"></i>
                            <div class="mostrar-tittle">Generalidades</div>
                        </a>
                        <a class="list-group-item text-center" href="#">
                            <i class="fa fa-medkit" style="font-size: 30px;" aria-hidden="true"></i>
                            <div class="mostrar-tittle">Salud</div>
                        </a>
                        <a class="list-group-item text-center" href="#">
                            <i class="fa fa-graduation-cap" style="font-size: 30px;" aria-hidden="true"></i>
                            <div class="mostrar-tittle">Educación</div>
                        </a>
                        <a class="list-group-item text-center" href="#">
                            <i class="fa fa-film" style="font-size: 30px;" aria-hidden="true"></i>
                            <div class="mostrar-tittle">Cultura</div>
                        </a>
                        <a class="list-group-item text-center " href="#">
                            <i class="fa fa-lock" style="font-size: 30px;" aria-hidden="true"></i>
                            <div class="mostrar-tittle">Paz y seguridad ciudadana</div>
                        </a>
                        <a class="list-group-item text-center" href="#">
                            <i class="fa fa-check-square" style="font-size: 30px;" aria-hidden="true"></i>
                            <div class="mostrar-tittle">
                                <p>Encuesta de empleo</p>
                                <p>y calidad de vida</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-10 bhoechie-tab" style="margin-bottom: 15px;">
                    <div class="bhoechie-tab-content active " >
                        ' . $generalidades . '
                    </div>            
                    <div class="bhoechie-tab-content">
                        ' . $salud . '
                    </div>
                    <div class="bhoechie-tab-content">
                        ' . $educación . '
                    </div>
                    <div class="bhoechie-tab-content">
                        ' . $cultura . '                                
                    </div>
                    <div class="bhoechie-tab-content">
                        ' . $pazSeguridad . '
                    </div>
                    <div class="bhoechie-tab-content">
                        ' . $encuestaEmpleoCalidad . '                                    
                    </div>
                </div>
            </div>
            
            <script>
                $(document).ready(function () {
                    $("div.bhoechie-tab-menu>div.list-group>a").click(function (e) {
                        e.preventDefault();
                        $(this).siblings("a.active").removeClass("active");
                        $(this).addClass("active");
                        var index = $(this).index();
                        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
                        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
                    });
                });
            </script>';
    }

    /**
     * <b>consultarIndicadoresPerfilesController</b>
     * <br>
     * Construye los gráficos para la visualización del perfil para una comuna
     * @param string $nombreComuna Nombre de la comuna a consultar
     */
    public function consultarGraficosComunaController($nombreComuna) {
        echo '<div class="row">';
        echo '
                <div class="col-sm-6" id="graficoComunasHomicidios">';
        $consultas = new ConsultasModel();
        $resp0 = $consultas->consultarInformacionIndicadorPorNombre("Homicidios por cada 100 mil habitantes", $nombreComuna);
        $idIndicador1 = $resp0["idIndicador"];
        $fuente1 = "Observatorio de Seguridad, DANE, Cálculos DAPM";
        $desagregacionTematica1 = "Total";
        $fechas1 = [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017];
        $zonas1 = [$nombreComuna, "Cali"];
        $resp1 = $consultas->consultaPerfilesComunas($idIndicador1, $fuente1, $desagregacionTematica1, $fechas1, $zonas1);

        if ($resp1 == 'error') {
            echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <li>Error al realizar la consulta</li></div>";
        } else {

            $nombreIndicador = $resp1[0];
            $totalDatos = $resp1[1];
            $data = $resp1[2];
            $notas = $resp1[3];
            $rango = $resp1[4];
            $unidadMedicion = $resp1[5];

            echo '
                    <div class="panel" style="border: solid 1px #2fb56a;">
                        <div class="panel-body" style="padding: 0 0 10px;">
                            <div id="grafHomicidios" style="background-color:#fff; padding: 4px 15px 5px;">
                                <h3 id="nombreIndicadorHomicidios" style="text-align:center;">' . $nombreIndicador . '</h3>
                                <h4 style="text-align:center">' . $rango . '<br></h4>
                                <canvas id="graficoHomicidios"></canvas>
                                <hr>
                                <p style="font-size:12px;"><strong>Gráfico:</strong> Sistema de Indicadores Sociales</p>
                                <p style="font-size:12px;"><strong>Fuente de datos:</strong> ' . $fuente1 . ' </p>';
            if (sizeof($notas) > 0) {
                echo '          <p style="font-size:12px;"><strong>Notas:</strong> ' . implode(" - ", $notas) . ' </p>';
            }
            echo '          </div>
                            <script>
                                var ctx = document.getElementById("graficoHomicidios").getContext("2d");';
            $cons = new ConsultasController();
            if ($totalDatos <= 10) {
                echo $cons->drawBarChart(json_encode($data), $unidadMedicion);
            } else {
                echo $cons->drawLineChart(json_encode($data), $unidadMedicion);
            }
            echo '                  </script>';
        }
        echo '
                            <div class"row" style="margin-top: 5px;">
                                <div class"col-sm-12">                         
                                    <button type="button" id="imagenPngHomicidios" class="btn bt bt-ripple" style="width:200px; background-color:#52b1fe; color:#fff; margin-left: 15px;">
                                        <i class="fa fa-file-image-o" aria-hidden="true" style="margin-right:10px;"></i>
                                        <b>Descargar gráfico</b>
                                    </button>
                                    <img src="/views/resources/images/loading3.gif" id="loadingPngHomicidios" style="margin-left: 10px; display:none;"/>
                                    <script>
                                        $("#imagenPngHomicidios").click(function () {
                                            var nombreIndicador = ($("#nombreIndicadorHomicidios").text()).trim();
                                            var container = document.getElementById("grafHomicidios");
                                            $("#loadingPngHomicidios").css("display","inline");
                                            html2canvas(container).then(function (canvas) {
                                                var link = document.createElement("a");
                                                document.body.appendChild(link);
                                                link.download = "" + nombreIndicador + ".png";
                                                link.href = canvas.toDataURL();
                                                link.target = "_blank";
                                                link.click();
                                                $("#loadingPngHomicidios").css("display","none");
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
//                -------
        echo '
                <div class = "col-sm-6" id = "graficoComunasHurtos">';
        $consultas2 = new ConsultasModel();
        $resp2 = $consultas2->consultarInformacionIndicadorPorNombre("Hurtos por cada 100 mil habitantes", $nombreComuna);
        $idIndicador2 = $resp2["idIndicador"];
        $fuente2 = "Policía Metropolitana, DANE, Cálculos DAPM";
        $desagregacionTematica2 = "Personas";
        $fechas2 = [2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016];
        $zonas2 = [$nombreComuna, "Cali"];
        $resp3 = $consultas2->consultaPerfilesComunas($idIndicador2, $fuente2, $desagregacionTematica2, $fechas2, $zonas2);
        if ($resp3 == 'error') {
            echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <li>Error al realizar la consulta</li></div>";
        } else {

            $nombreIndicador2 = $resp3[0];
            $totalDatos2 = $resp3[1];
            $data2 = $resp3[2];
            $notas2 = $resp3[3];
            $rango2 = $resp3[4];
            $unidadMedicion2 = $resp3[5];

            echo '
                    <div class="panel" style="border: solid 1px #2fb56a;">
                        <div class="panel-body" style="padding: 0 0 10px;">
                            <div id="grafHurtos" style="background-color:#fff; padding: 4px 15px 5px;">
                                <h3 id="nombreIndicadorHurtos" style="text-align:center;">' . $nombreIndicador2 . '</h3>
                                <h4 style="text-align:center">' . $rango2 . '<br></h4>
                                <canvas id="graficoHurtos"></canvas>
                                <hr>
                                <p style="font-size:12px;"><strong>Gráfico:</strong> Sistema de Indicadores Sociales</p>
                                <p style="font-size:12px;"><strong>Fuente de datos:</strong> ' . $fuente2 . ' </p>';
            if (sizeof($notas2) > 0) {
                echo '          <p style="font-size:12px;"><strong>Notas:</strong> ' . implode(" - ", $notas2) . ' </p>';
            }
            echo '          </div>
                            <script>
                                var ctx = document.getElementById("graficoHurtos").getContext("2d");';
            $cons2 = new ConsultasController();

            if ($totalDatos2 <= 10) {
                echo $cons2->drawBarChart(json_encode($data2), $unidadMedicion2);
            } else {
                echo $cons2->drawLineChart(json_encode($data2), $unidadMedicion2);
            }

            echo '</script>';
        }
        echo '              <div class"row" style="margin-top: 5px;">
                                <div class"col-sm-12">                         
                                    <button type="button" id="imagenPngHurtos" class="btn bt bt-ripple" style="width:200px; background-color:#52b1fe; color:#fff; margin-left: 15px;">
                                        <i class="fa fa-file-image-o" aria-hidden="true" style="margin-right:10px;"></i>
                                        <b>Descargar gráfico</b>
                                    </button>
                                    <img src="/views/resources/images/loading3.gif" id="loadingPngHurtos" style="margin-left: 10px; display:none;"/>
                                    <script>
                                        $("#imagenPngHurtos").click(function () {
                                            var nombreIndicador = ($("#nombreIndicadorHurtos").text()).trim();
                                            var container = document.getElementById("grafHurtos");
                                            $("#loadingPngHurtos").css("display","inline");
                                            html2canvas(container).then(function (canvas) {
                                                var link = document.createElement("a");
                                                document.body.appendChild(link);
                                                link.download = "" + nombreIndicador + ".png";
                                                link.href = canvas.toDataURL();
                                                link.target = "_blank";
                                                link.click();
                                                $("#loadingPngHurtos").css("display","none");
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
// ----
        echo '<div class="row">';
        echo '
                <div class="col-sm-6" id="graficoComunasMortalidad">';
        $consultas3 = new ConsultasModel();
        $resp4 = $consultas3->consultarInformacionIndicadorPorNombre("Tasa de Mortalidad General", $nombreComuna);
        $idIndicador3 = $resp4["idIndicador"];
        $fuente3 = "Secretaría de Salud Pública Municipal";
        $desagregacionTematica3 = "Total";
        $fechas3 = [2010, 2011, 2012, 2013, 2014];
        $zonas3 = ["Cali", $nombreComuna];

        $resp5 = $consultas3->consultaPerfilesComunas($idIndicador3, $fuente3, $desagregacionTematica3, $fechas3, $zonas3);


        if ($resp5 == 'error') {
            echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <li>Error al realizar la consulta</li></div>";
        } else {

            $nombreIndicador3 = $resp5[0];
            $totalDatos3 = $resp5[1];
            $data3 = $resp5[2];
            $notas3 = $resp5[3];
            $rango3 = $resp5[4];
            $unidadMedicion3 = $resp5[5];

            echo '
                    <div class="panel" style="border: solid 1px #2fb56a;">
                        <div class="panel-body" style="padding: 0 0 10px;">
                            <div id="grafMortalidad" style="background-color:#fff; padding: 4px 10px 10px;">
                                <h3 id="nombreIndicadorMortalidad" style="text-align:center;">' . $nombreIndicador3 . '</h3>
                                <h4 style="text-align:center">' . $rango3 . '<br></h4>
                                <canvas id="graficoMortalidad"></canvas>
                                <hr>
                                <p style="font-size:12px;"><strong>Gráfico:</strong> Sistema de Indicadores Sociales</p>
                                <p style="font-size:12px;"><strong>Fuente de datos:</strong> ' . $fuente3 . ' </p>';
            if (sizeof($notas3) > 0) {
                echo '          <p style="font-size:12px;"><strong>Notas:</strong> ' . implode(" - ", $notas3) . ' </p>';
            }
            echo '          </div>
                            <script>
                                var ctx = document.getElementById("graficoMortalidad").getContext("2d");';
            $cons3 = new ConsultasController();

            if ($totalDatos3 <= 10) {
                echo $cons3->drawBarChart(json_encode($data3), $unidadMedicion3);
            } else {
                echo $cons3->drawLineChart(json_encode($data3), $unidadMedicion3);
            }

            echo '</script>';
        }
        echo '          <div class"row" style="margin-top: 5px;">
                                <div class"col-sm-12">                         
                                    <button type="button" id="imagenPngMortalidad" class="btn bt bt-ripple" style="width:200px; background-color:#52b1fe; color:#fff; margin-left: 15px;">
                                        <i class="fa fa-file-image-o" aria-hidden="true" style="margin-right:10px;"></i>
                                        <b>Descargar gráfico</b>
                                    </button>
                                    <img src="/views/resources/images/loading3.gif" id="loadingPngMortalidad" style="margin-left: 10px; display:none;"/>
                                    <script>
                                        $("#imagenPngMortalidad").click(function () {
                                            var nombreIndicador = ($("#nombreIndicadorMortalidad").text()).trim();
                                            var container = document.getElementById("grafMortalidad");
                                            $("#loadingPngMortalidad").css("display","inline");
                                            html2canvas(container).then(function (canvas) {
                                                var link = document.createElement("a");
                                                document.body.appendChild(link);
                                                link.download = "" + nombreIndicador + ".png";
                                                link.href = canvas.toDataURL();
                                                link.target = "_blank";
                                                link.click();
                                                $("#loadingPngMortalidad").css("display","none");
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
//                -------
        echo '
                <div class = "col-sm-6" id = "graficoComunasFecundidad">';
        $consultas4 = new ConsultasModel();
        $resp5 = $consultas4->consultarInformacionIndicadorPorNombre("Tasa de fecundidad en madres en edad Fertil (15 - 49 años)", $nombreComuna);
        $idIndicador4 = $resp5["idIndicador"];
        $fuente4 = "Secretaría de Salud Pública Municipal";
        $desagregacionTematica4 = "Total";
        $fechas4 = [2010, 2011, 2012, 2013, 2014];
        $zonas4 = [$nombreComuna];

        $resp6 = $consultas4->consultaPerfilesComunas($idIndicador4, $fuente4, $desagregacionTematica4, $fechas4, $zonas4);

        if ($resp6 == 'error') {
            echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <li>Error al realizar la consulta</li></div>";
        } else {

            $nombreIndicador4 = $resp6[0];
            $totalDatos4 = $resp6[1];
            $data4 = $resp6[2];
            $notas4 = $resp6[3];
            $rango4 = $resp6[4];
            $unidadMedicion4 = $resp6[5];

            echo '
                    <div class="panel" style="border: solid 1px #2fb56a;">
                        <div class="panel-body" style="padding: 0 0 10px;">
                            <div id="grafFecundidad" style="background-color:#fff; padding: 4px 15px 5px;">
                                <h3 id="nombreIndicadorFecundidad" style="text-align:center;">' . $nombreIndicador4 . '</h3>
                                <h4 style="text-align:center">' . $rango4 . '<br></h4>
                                <canvas id="graficoFecundidad"></canvas>
                                <hr>
                                <p style="font-size:12px;"><strong>Gráfico:</strong> Sistema de Indicadores Sociales</p>
                                <p style="font-size:12px;"><strong>Fuente de datos:</strong> ' . $fuente4 . ' </p>';
            if (sizeof($notas4) > 0) {
                echo '          <p style="font-size:12px;"><strong>Notas:</strong> ' . implode(" - ", $notas4) . ' </p>';
            }
            echo '          </div>
                            <script>
                                var ctx = document.getElementById("graficoFecundidad").getContext("2d");';
            $cons4 = new ConsultasController();

            if ($totalDatos4 <= 10) {
                echo $cons4->drawBarChart(json_encode($data4), $unidadMedicion4);
            } else {
                echo $cons4->drawLineChart(json_encode($data4), $unidadMedicion4);
            }

            echo '</script>';
        }
        echo '
                        <div class"row" style="margin-top: 5px;">
                                <div class"col-sm-12">                         
                                    <button type="button" id="imagenPngFecundidad" class="btn bt bt-ripple" style="width:200px; background-color:#52b1fe; color:#fff; margin-left: 15px;">
                                        <i class="fa fa-file-image-o" aria-hidden="true" style="margin-right:10px;"></i>
                                        <b>Descargar gráfico</b>
                                    </button>
                                    <img src="/views/resources/images/loading3.gif" id="loadingPngFecundidad" style="margin-left: 10px; display:none;"/>
                                    <script>
                                        $("#imagenPngFecundidad").click(function () {
                                            var nombreIndicador = ($("#nombreIndicadorFecundidad").text()).trim();
                                            var container = document.getElementById("grafFecundidad");
                                            $("#loadingPngFecundidad").css("display","inline");
                                            html2canvas(container).then(function (canvas) {
                                                var link = document.createElement("a");
                                                document.body.appendChild(link);
                                                link.download = "" + nombreIndicador + ".png";
                                                link.href = canvas.toDataURL();
                                                link.target = "_blank";
                                                link.click();
                                                $("#loadingPngFecundidad").css("display","none");
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';

        // ----
        echo '<div class="row">';
        echo '
                <div class="col-sm-6" id="graficoComunasViolenciaSexual">';
        $consultas5 = new ConsultasModel();
        $resp7 = $consultas5->consultarInformacionIndicadorPorNombre("Tasa de violencia sexual por cada 100 mil habitantes", $nombreComuna);
        $idIndicador5 = $resp7["idIndicador"];
        $fuente5 = "Observatorio de Violencia Familiar, DANE, Cálculos DAPM";
        $desagregacionTematica5 = "Total";
        $fechas5 = [2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015];
        $zonas5 = [$nombreComuna, "Cali"];

        $resp8 = $consultas5->consultaPerfilesComunas($idIndicador5, $fuente5, $desagregacionTematica5, $fechas5, $zonas5);


        if ($resp8 == 'error') {
            echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <li>Error al realizar la consulta</li></div>";
        } else {

            $nombreIndicador5 = $resp8[0];
            $totalDatos5 = $resp8[1];
            $data5 = $resp8[2];
            $notas5 = $resp8[3];
            $rango5 = $resp8[4];
            $unidadMedicion5 = $resp8[5];

            echo '
                    <div class="panel" style="border: solid 1px #2fb56a;">
                        <div class="panel-body" style="padding: 0 0 10px;">
                            <div id="grafViolenciaSexual" style="background-color:#fff; padding: 4px 15px 5px;">
                                <h3 id="nombreIndicadorViolenciaSexual" style="text-align:center;">' . $nombreIndicador5 . '</h3>
                                <h4 style="text-align:center">' . $rango5 . '<br></h4>
                                <canvas id="graficoViolenciaSexual"></canvas>
                                <hr>
                                <p style="font-size:12px;"><strong>Gráfico:</strong> Sistema de Indicadores Sociales</p>
                                <p style="font-size:12px;"><strong>Fuente de datos:</strong> ' . $fuente5 . ' </p>';
            if (sizeof($notas5) > 0) {
                echo '          <p style="font-size:12px;"><strong>Notas:</strong> ' . implode(" - ", $notas5) . ' </p>';
            }
            echo '          </div>
                            <script>
                                var ctx = document.getElementById("graficoViolenciaSexual").getContext("2d");';
            $cons5 = new ConsultasController();
            if ($totalDatos5 <= 10) {
                echo $cons5->drawBarChart(json_encode($data5), $unidadMedicion5);
            } else {
                echo $cons5->drawLineChart(json_encode($data5), $unidadMedicion5);
            }

            echo '</script>';
        }
        echo '              <div class"row" style="margin-top: 5px;">
                                <div class"col-sm-12">                         
                                    <button type="button" id="imagenPngViolenciaSexual" class="btn bt bt-ripple" style="width:200px; background-color:#52b1fe; color:#fff; margin-left: 15px;">
                                        <i class="fa fa-file-image-o" aria-hidden="true" style="margin-right:10px;"></i>
                                        <b>Descargar gráfico</b>
                                    </button>
                                    <img src="/views/resources/images/loading3.gif" id="loadingPngViolenciaSexual" style="margin-left: 10px; display:none;"/>
                                    <script>
                                        $("#imagenPngViolenciaSexual").click(function () {
                                            var nombreIndicador = ($("#nombreIndicadorViolenciaSexual").text()).trim();
                                            var container = document.getElementById("grafViolenciaSexual");
                                            $("#loadingPngViolenciaSexual").css("display","inline");
                                            html2canvas(container).then(function (canvas) {
                                                var link = document.createElement("a");
                                                document.body.appendChild(link);
                                                link.download = "" + nombreIndicador + ".png";
                                                link.href = canvas.toDataURL();
                                                link.target = "_blank";
                                                link.click();
                                                $("#loadingPngViolenciaSexual").css("display","none");
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
//                -------
        echo '
                <div class = "col-sm-6" id = "graficoComunasViolenciaIntrafamiliar">';
        $consultas6 = new ConsultasModel();
        $resp9 = $consultas6->consultarInformacionIndicadorPorNombre("Tasa de violencia intrafamiliar por cada 100 mil habitantes", $nombreComuna);
        $idIndicador6 = $resp9["idIndicador"];
        $fuente6 = "Observatorio de Violencia Familiar, DANE, Cálculos DAPM";
        $desagregacionTematica6 = "Total";
        $fechas6 = [2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015];
        $zonas6 = [$nombreComuna, "Cali"];

        $resp10 = $consultas6->consultaPerfilesComunas($idIndicador6, $fuente6, $desagregacionTematica6, $fechas6, $zonas6);

        if ($resp10 == 'error') {
            echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <li>Error al realizar la consulta</li></div>";
        } else {

            $nombreIndicador6 = $resp10[0];
            $totalDatos6 = $resp10[1];
            $data6 = $resp10[2];
            $notas6 = $resp10[3];
            $rango6 = $resp10[4];
            $unidadMedicion6 = $resp10[5];

            echo '
                    <div class="panel" style="border: solid 1px #2fb56a;">
                        <div class="panel-body" style="padding: 0 0 10px;">
                            <div id="grafViolenciaIntrafamiliar" style="background-color:#fff; padding: 4px 15px 5px;">
                                <h3 id="nombreIndicadorViolenciaIntrafamiliar" style="text-align:center;">' . $nombreIndicador6 . '</h3>
                                <h4 style="text-align:center">' . $rango6 . '<br></h4>
                                <canvas id="graficoViolenciaIntrafamiliar"></canvas>
                                <hr>
                                <p style="font-size:12px;"><strong>Gráfico:</strong> Sistema de Indicadores Sociales</p>
                                <p style="font-size:12px;"><strong>Fuente de datos:</strong> ' . $fuente6 . ' </p>';
            if (sizeof($notas6) > 0) {
                echo '          <p style="font-size:12px;"><strong>Notas:</strong> ' . implode(" - ", $notas6) . ' </p>';
            }
            echo '          </div>
                            <script>
                                var ctx = document.getElementById("graficoViolenciaIntrafamiliar").getContext("2d");';
            $cons6 = new ConsultasController();

            if ($totalDatos6 <= 10) {
                echo $cons6->drawBarChart(json_encode($data6), $unidadMedicion6);
            } else {
                echo $cons6->drawLineChart(json_encode($data6), $unidadMedicion6);
            }

            echo '</script>';
        }
        echo '
            <div class"row" style="margin-top: 5px;">
                                <div class"col-sm-12">                         
                                    <button type="button" id="imagenPngViolenciaIntrafamiliar" class="btn bt bt-ripple" style="width:200px; background-color:#52b1fe; color:#fff; margin-left: 15px;">
                                        <i class="fa fa-file-image-o" aria-hidden="true" style="margin-right:10px;"></i>
                                        <b>Descargar gráfico</b>
                                    </button>
                                    <img src="/views/resources/images/loading3.gif" id="loadingPngViolenciaIntrafamiliar" style="margin-left: 10px; display:none;"/>
                                    <script>
                                        $("#imagenPngViolenciaIntrafamiliar").click(function () {
                                            var nombreIndicador = ($("#nombreIndicadorViolenciaIntrafamiliar").text()).trim();
                                            var container = document.getElementById("grafViolenciaIntrafamiliar");
                                            $("#loadingPngViolenciaIntrafamiliar").css("display","inline");
                                            html2canvas(container).then(function (canvas) {
                                                var link = document.createElement("a");
                                                document.body.appendChild(link);
                                                link.download = "" + nombreIndicador + ".png";
                                                link.href = canvas.toDataURL();
                                                link.target = "_blank";
                                                link.click();
                                                $("#loadingPngViolenciaIntrafamiliar").css("display","none");
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
    }

}

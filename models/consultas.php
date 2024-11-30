<?php

require_once 'dimensiones.php';
require_once 'connection.php';

class ConsultasModel extends Connection {

    public function consultarListadoIndicadoresActivosPorDimension($idDimension) {
        $resp = array();
        $tem = new Tematicas();
        $ind = new Indicadores();
        $tematicas = array();
        $indicadores = array();
        $resp1 = $tem->consultarTematicasPorDimension($idDimension);
        if (empty($resp1)) {
            return 'error';
        } else {
            foreach ($resp1 as $row => $item) {
                $nombreTematica = $item["nombreTematica"];
                $idTematica = $item["idTematica"];
                $numeroIndicadores = $ind->contarIndicadoresActivosPorIdTematica($idTematica, "Municipal")[0];
                $tematicas[] = array($idTematica, $nombreTematica, $numeroIndicadores);
                $resp2 = $ind->consultarIndicadoresActivosPorTematica($idTematica);
                foreach ($resp2 as $row2 => $item2) {
                    $nombreIndicador = $item2["nombreIndicador"];
                    $idIndicador = $item2["idIndicador"];
                    $informacionEnlace = $ind->consultarInformacionEnlacePorIdIndicadorYGeografia($idIndicador, "Municipal");
                    $indicadores[] = array($idTematica, $idIndicador, $nombreIndicador, $informacionEnlace);
                }
            }
            $resp[] = $tematicas;
            $resp[] = $indicadores;
            return $resp;
        }
    }

    public function consultarListadoTematicasPorDimension($idDimension) {
        $resp = array();
        $tem = new Tematicas();
        $ind = new Indicadores();
        $tematicas = array();
        $indicadores = array();
        $resp1 = $tem->consultarTematicasPorDimensionDadii($idDimension);
        if (empty($resp1)) {
            return 'error';
        } else {
            foreach ($resp1 as $row => $item) {
                $nombreTematica = $item["nombreTematica"];
                $idTematica = $item["idTematica"];
                $tematicas[] = array($idTematica, $nombreTematica);
            }
            $resp[] = $tematicas;
            return $resp;
        }
    }

    public function consultarListadoIndicadoresActivosPorDimensionTotal($idDimension) {
        $resp = array();
        $tem = new Tematicas();
        $ind = new Indicadores();
        $tematicas = array();
        $indicadores = array();
        $resp1 = $tem->consultarTematicasPorDimension($idDimension);
        if (empty($resp1)) {
            return 'error';
        } else {
            foreach ($resp1 as $row => $item) {
                $nombreTematica = $item["nombreTematica"];
                $idTematica = $item["idTematica"];
                $numeroIndicadores = $ind->contarIndicadoresActivosPorIdTematica($idTematica, "Total")[0];
                $tematicas[] = array($idTematica, $nombreTematica, $numeroIndicadores);
                $resp2 = $ind->consultarIndicadoresActivosPorTematicaTotal($idTematica);
                foreach ($resp2 as $row2 => $item2) {
                    $nombreIndicador = $item2["nombreIndicador"];
                    $idIndicador = $item2["idIndicador"];
                    $informacionEnlace = $ind->consultarInformacionEnlacePorIdIndicadorYGeografia($idIndicador, "Total");
                    $indicadores[] = array($idTematica, $idIndicador, $nombreIndicador, $informacionEnlace);
                }
            }
            $resp[] = $tematicas;
            $resp[] = $indicadores;
            return $resp;
        }
    }

    public function consultarListadoIndicadoresActivosPorDimensionComunasCorregimientos($idDimension) {
        $resp = array();
        $tem = new Tematicas();
        $ind = new Indicadores();
        $tematicas = array();
        $indicadores = array();
        $resp1 = $tem->consultarTematicasPorDimensionComunasCorregimientos($idDimension);
        if (empty($resp1)) {
            return 'error';
        } else {
            foreach ($resp1 as $row => $item) {
                $nombreTematica = $item["nombreTematica"];
                $idTematica = $item["idTematica"];
                $numeroIndicadores = $ind->contarIndicadoresActivosPorIdTematica($idTematica, "Comuna")[0];
                $tematicas[] = array($idTematica, $nombreTematica, $numeroIndicadores);
                $resp2 = $ind->consultarIndicadoresActivosPorTematicaComunasCorregimientos($idTematica);
                foreach ($resp2 as $row2 => $item2) {
                    $nombreIndicador = $item2["nombreIndicador"];
                    $idIndicador = $item2["idIndicador"];
                    $informacionEnlace = $ind->consultarInformacionEnlacePorIdIndicadorYGeografia($idIndicador, "Comuna");
                    $indicadores[] = array($idTematica, $idIndicador, $nombreIndicador, $informacionEnlace);
                }
            }
            $resp[] = $tematicas;
            $resp[] = $indicadores;
            return $resp;
        }
    }

    public function consultarIndicadoresIgcPorNombreDimension($nombreDimension) {
        if (strlen(trim($nombreDimension)) < 1) {
            return 'error';
        } else {
            $resp = array();
            $stmt1 = Connection::connect()->prepare(""
                    . "SELECT idDimension "
                    . "FROM dimensiones "
                    . "WHERE nombreDimension = :nombreDimension "
                    . "AND idConjuntoIndicadores LIKE '%IGC%'");
            $stmt1->bindParam(":nombreDimension", $nombreDimension, PDO::PARAM_STR);
            $stmt1->execute();
            $idDimension = $stmt1->fetch()['idDimension'];
            $resp[] = $idDimension;
            $tem = new Tematicas();
            $ind = new Indicadores();
            $tematicas = array();
            $indicadores = array();
            $resp1 = $tem->consultarTematicasIgcPorDimensionCali($idDimension);
            foreach ($resp1 as $row => $item) {
                $nombreTematica = $item["nombreTematica"];
                $idTematica = $item["idTematica"];
                $numeroIndicadores = $ind->contarIndicadoresActivosPorIdTematica($idTematica, "Cali")[0];
                $tematicas[] = array($idTematica, $nombreTematica, $numeroIndicadores);
                $resp2 = $ind->consultarIndicadoresIGCPorTematica($idTematica);
                foreach ($resp2 as $row2 => $item2) {
                    $nombreIndicador = $item2["nombreIndicador"];
                    $idIndicador = $item2["idIndicador"];
                    $enl1 = $ind->consultarInformacionEnlacePorIdIndicadorYGeografia($idIndicador, "Cali");
                    $indicadores[] = array($idTematica, $idIndicador, $nombreIndicador, $enl1);
                }
            }
            $resp[] = $tematicas;
            $resp[] = $indicadores;
            return $resp;
        }
    }

    public function promedioIndicadoresDadii($idTematica) {
        $stmt1 = Connection::connect()->prepare("SELECT fechaDato,COUNT(valorDato) as cantidadDatos,avg(valorDato) as valorDato "
                . "FROM datos "
                . "WHERE idSerieDatos LIKE '$idTematica%' "
                . "AND  fechaDato LIKE 'Trimestre 1'");
        $stmt1->execute();
        $vars = $stmt1->fetch();
        if (isset($vars)) {
            $fehcaDato = $vars[0];
            $cantidadDatos = $vars[1];
            $valorDato = round($vars[2]);
            $color1 = "";
            $border1 = "";
            if ($valorDato <= 39) {
                $color1 = "rgba(255,0,0,0.5)";
                $border1 = "rgba(255,0,0,0.8)";
            } elseif ($valorDato <= 59 && $valorDato >= 40) {
                $color1 = "rgba(226,107,10,0.5)";
                $border1 = "rgba(226,107,10,0.8)";
            } elseif ($valorDato <= 69 && $valorDato >= 60) {
                $color1 = "rgba(255,255,0,0.5)";
                $border1 = "rgba(255,255,0,0.8)";
            } elseif ($valorDato <= 79 && $valorDato >= 70) {
                $color1 = "rgba(146,208,80,0.5)";
                $border1 = "rgba(146,208,80,0.8)";
            } elseif ($valorDato >= 80) {
                $color1 = "rgba(0,176,80,0.5)";
                $border1 = "rgba(0,176,80,0.8)";
            }
        }
//        
        $stmt1 = Connection::connect()->prepare("SELECT fechaDato,COUNT(valorDato) as cantidadDatos,avg(valorDato) as valorDato "
                . "FROM datos "
                . "WHERE idSerieDatos LIKE '$idTematica%' "
                . "AND fechaDato LIKE 'Trimestre 2'");
        $stmt1->execute();
        $vars2 = $stmt1->fetch();
        if (isset($vars)) {
            $fehcaDato2 = $vars2[0];
            $cantidadDatos2 = $vars2[1];
            $valorDato2 = round($vars2[2]);
            $color2 = "";
            $border2 = "";
            if ($valorDato2 <= 39) {
                $color2 = "rgba(255,0,0,0.5)";
                $border2 = "rgba(255,0,0,0.8)";
            } elseif ($valorDato2 <= 59 && $valorDato2 >= 40) {
                $color2 = "rgba(226,107,10,0.5)";
                $border2 = "rgba(226,107,10,0.8)";
            } elseif ($valorDato2 <= 69 && $valorDato2 >= 60) {
                $color2 = "rgba(255,255,0,0.5)";
                $border2 = "rgba(255,255,0,0.8)";
            } elseif ($valorDato2 <= 79 && $valorDato2 >= 70) {
                $color2 = "rgba(146,208,80,0.5)";
                $border2 = "rgba(146,208,80,0.8)";
            } elseif ($valorDato2 >= 80) {
                $color2 = "rgba(0,176,80,0.5)";
                $border2 = "rgba(0,176,80,0.8)";
            }
        }
//        
        $stmt1 = Connection::connect()->prepare("SELECT fechaDato,COUNT(valorDato) as cantidadDatos,avg(valorDato) as valorDato "
                . "FROM datos "
                . "WHERE idSerieDatos LIKE '$idTematica%' "
                . "AND fechaDato LIKE 'Trimestre 3'");
        $stmt1->execute();
        $vars3 = $stmt1->fetch();
        if (isset($vars3)) {
            $fehcaDato3 = $vars3[0];
            $cantidadDatos3 = $vars3[1];
            $valorDato3 = round($vars3[2]);
            $color3 = "";
            $border3 = "";
            if ($valorDato3 <= 39) {
                $color3 = "rgba(255,0,0,0.5)";
                $border3 = "rgba(255,0,0,0.8)";
            } elseif ($valorDato3 <= 59 && $valorDato3 >= 40) {
                $color3 = "rgba(226,107,10,0.5)";
                $border3 = "rgba(226,107,10,0.8)";
            } elseif ($valorDato3 <= 69 && $valorDato3 >= 60) {
                $color3 = "rgba(255,255,0,0.5)";
                $border3 = "rgba(255,255,0,0.8)";
            } elseif ($valorDato3 <= 79 && $valorDato3 >= 70) {
                $color3 = "rgba(146,208,80,0.5)";
                $border3 = "rgba(146,208,80,0.8)";
            } elseif ($valorDato3 >= 80) {
                $color3 = "rgba(0,176,80,0.5)";
                $border3 = "rgba(0,176,80,0.8)";
            }
        }
//                
        $stmt1 = Connection::connect()->prepare("SELECT fechaDato,COUNT(valorDato) as cantidadDatos,avg(valorDato) as valorDato "
                . "FROM datos "
                . "WHERE idSerieDatos LIKE '$idTematica%' "
                . "AND fechaDato LIKE 'Trimestre 4'");
        $stmt1->execute();
        $vars4 = $stmt1->fetch();
        if (isset($vars4)) {
            $fehcaDato4 = $vars4[0];
            $cantidadDatos4 = $vars4[1];
            $valorDato4 = round($vars4[2]);
//        var_dump($valorDato4);
            $color4 = "";
            $border4 = "";
            if ($valorDato4 <= 39) {
                $color4 = "rgba(255,0,0,0.5)";
                $border4 = "rgba(255,0,0,0.8)";
            } elseif ($valorDato4 <= 59 && $valorDato4 >= 40) {
                $color4 = "rgba(226,107,10,0.5)";
                $border4 = "rgba(226,107,10,0.8)";
            } elseif ($valorDato4 <= 69 && $valorDato4 >= 60) {
                $color4 = "rgba(255,255,0,0.5)";
                $border4 = "rgba(255,255,0,0.8)";
            } elseif ($valorDato4 <= 79 && $valorDato4 >= 70) {
                $color4 = "rgba(146,208,80,0.5)";
                $border4 = "rgba(146,208,80,0.8)";
            } elseif ($valorDato4 >= 80) {
                $color4 = "rgba(0,176,80,0.5)";
                $border4 = "rgba(0,176,80,0.8)";
            }
        }
        $datos = array();
        $datos[] = $valorDato;
        $datos[] = $valorDato2;
        $datos[] = $valorDato3;
        $datos[] = $valorDato4;
        $datasets[] = array(
            "backgroundColor" => [$color1, $color2, $color3, $color4],
            "borderColor" => [$border1, $border2, $border3, $border4],
            "data" => $datos,
            "borderWidth" => 2,
            "pointRotation" => 0,
            "fill" => false);
        $data = array("labels" => ['Trimestre 1', 'Trimestre 2', 'Trimestre 3', 'Trimestre 4'],
            "datasets" => $datasets);

        $cantidadDat = array();
        $cantidadDat[] = $cantidadDatos;
        $cantidadDat[] = $cantidadDatos2;
        $cantidadDat[] = $cantidadDatos3;
        $cantidadDat[] = $cantidadDatos4;
        $resp = array();
        $resp[] = $data;
        $resp[] = $cantidadDat;

        return $resp;
    }

    public function promedioIndicadoresGeneralDadii() {
        $stmt1 = Connection::connect()->prepare("SELECT fechaDato,COUNT(valorDato) as cantidadDatos,avg(valorDato) as valorDato "
                . "FROM datos "
                . "WHERE  fechaDato LIKE 'Trimestre 1'");
        $stmt1->execute();
        $vars = $stmt1->fetch();
        if (isset($vars)) {
            $fehcaDato = $vars[0];
            $cantidadDatos = $vars[1];
            $valorDato = round($vars[2]);
            $color1 = "";
            $border1 = "";
            if ($valorDato <= 39) {
                $color1 = "rgba(255,0,0,0.5)";
                $border1 = "rgba(255,0,0,0.8)";
            } elseif ($valorDato <= 59 && $valorDato >= 40) {
                $color1 = "rgba(226,107,10,0.5)";
                $border1 = "rgba(226,107,10,0.8)";
            } elseif ($valorDato <= 69 && $valorDato >= 60) {
                $color1 = "rgba(255,255,0,0.5)";
                $border1 = "rgba(255,255,0,0.8)";
            } elseif ($valorDato <= 79 && $valorDato >= 70) {
                $color1 = "rgba(146,208,80,0.5)";
                $border1 = "rgba(146,208,80,0.8)";
            } elseif ($valorDato >= 80) {
                $color1 = "rgba(0,176,80,0.5)";
                $border1 = "rgba(0,176,80,0.8)";
            }
        }
        $stmt1 = Connection::connect()->prepare("SELECT fechaDato,COUNT(valorDato) as cantidadDatos,avg(valorDato) as valorDato "
                . "FROM datos "
                . "WHERE fechaDato LIKE 'Trimestre 2'");
        $stmt1->execute();
        $vars2 = $stmt1->fetch();
        if (isset($vars2)) {
            $fehcaDato2 = $vars2[0];
            $cantidadDatos2 = $vars2[1];
            $valorDato2 = round($vars2[2]);
            $color2 = "";
            $border2 = "";
            if ($valorDato2 <= 39) {
                $color2 = "rgba(255,0,0,0.5)";
                $border2 = "rgba(255,0,0,0.8)";
            } elseif ($valorDato2 <= 59 && $valorDato2 >= 40) {
                $color2 = "rgba(226,107,10,0.5)";
                $border2 = "rgba(226,107,10,0.8)";
            } elseif ($valorDato2 <= 69 && $valorDato2 >= 60) {
                $color2 = "rgba(255,255,0,0.5)";
                $border2 = "rgba(255,255,0,0.8)";
            } elseif ($valorDato2 <= 79 && $valorDato2 >= 70) {
                $color2 = "rgba(146,208,80,0.5)";
                $border2 = "rgba(146,208,80,0.8)";
            } elseif ($valorDato2 >= 80) {
                $color2 = "rgba(0,176,80,0.5)";
                $border2 = "rgba(0,176,80,0.8)";
            }
        }
        $stmt1 = Connection::connect()->prepare("SELECT fechaDato,COUNT(valorDato) as cantidadDatos,avg(valorDato) as valorDato "
                . "FROM datos "
                . "WHERE fechaDato LIKE 'Trimestre 3'");
        $stmt1->execute();
        $vars3 = $stmt1->fetch();
        if (isset($vars3)) {
            $fehcaDato3 = $vars3[0];
            $cantidadDatos3 = $vars3[1];
            $valorDato3 = round($vars3[2]);
            $color3 = "";
            $border3 = "";
            if ($valorDato3 <= 39) {
                $color3 = "rgba(255,0,0,0.5)";
                $border3 = "rgba(255,0,0,0.8)";
            } elseif ($valorDato3 <= 59 && $valorDato3 >= 40) {
                $color3 = "rgba(226,107,10,0.5)";
                $border3 = "rgba(226,107,10,0.8)";
            } elseif ($valorDato3 <= 69 && $valorDato3 >= 60) {
                $color3 = "rgba(255,255,0,0.5)";
                $border3 = "rgba(255,255,0,0.8)";
            } elseif ($valorDato3 <= 79 && $valorDato3 >= 70) {
                $color3 = "rgba(146,208,80,0.5)";
                $border3 = "rgba(146,208,80,0.8)";
            } elseif ($valorDato3 >= 80) {
                $color3 = "rgba(0,176,80,0.5)";
                $border3 = "rgba(0,176,80,0.8)";
            }
        }
        $stmt1 = Connection::connect()->prepare("SELECT fechaDato,COUNT(valorDato) as cantidadDatos,avg(valorDato) as valorDato "
                . "FROM datos "
                . "WHERE fechaDato LIKE 'Trimestre 4'");
        $stmt1->execute();
        $vars4 = $stmt1->fetch();
        if (isset($vars4)) {
            $fehcaDato4 = $vars4[0];
            $cantidadDatos4 = $vars4[1];
            $valorDato4 = round($vars4[2]);
            $color4 = "";
            $border4 = "";
            if ($valorDato4 <= 39) {
                $color4 = "rgba(255,0,0,0.5)";
                $border4 = "rgba(255,0,0,0.8)";
            } elseif ($valorDato4 <= 59 && $valorDato4 >= 40) {
                $color4 = "rgba(226,107,10,0.5)";
                $border4 = "rgba(226,107,10,0.8)";
            } elseif ($valorDato4 <= 69 && $valorDato4 >= 60) {
                $color4 = "rgba(255,255,0,0.5)";
                $border4 = "rgba(255,255,0,0.8)";
            } elseif ($valorDato4 <= 79 && $valorDato4 >= 70) {
                $color4 = "rgba(146,208,80,0.5)";
                $border4 = "rgba(146,208,80,0.8)";
            } elseif ($valorDato4 >= 80) {
                $color4 = "rgba(0,176,80,0.5)";
                $border4 = "rgba(0,176,80,0.8)";
            }
        }
        $datos = array();
        $datos[] = $valorDato;
        $datos[] = $valorDato2;
        $datos[] = $valorDato3;
        $datos[] = $valorDato4;
        $datasets[] = array(
            "backgroundColor" => [$color1, $color2, $color3, $color4],
            "borderColor" => [$border1, $border2, $border3, $border4],
            "data" => $datos,
            "borderWidth" => 2,
            "pointRotation" => 0,
            "fill" => TRUE);
        $data = array("labels" => ['Trimestre 1', 'Trimestre 2', 'Trimestre 3', 'Trimestre 4'],
            "datasets" => $datasets);
        $cantidadDat = array();
        $cantidadDat[] = $cantidadDatos;
        $cantidadDat[] = $cantidadDatos2;
        $cantidadDat[] = $cantidadDatos3;
        $cantidadDat[] = $cantidadDatos4;
        $resp = array();
        $resp[] = $data;
        $resp[] = $cantidadDat;
        return $resp;
    }

    public function IndicadoresPorProceso($idTematica) {
        $stmt1 = Connection::connect()->prepare("SELECT idIndicador, nombreIndicador "
                . "FROM indicadores "
                . "WHERE  idIndicador LIKE '$idTematica%' "
                . "AND activado = 1 ");
        $stmt1->execute();
        $vars = $stmt1->fetchAll();
        if (isset($vars)) {
            $idIndicador = array();
            $nombre = array();
            $contador = array();
            $color = array();
            foreach ($vars as $row => $item) {
                $stmt1 = Connection::connect()->prepare("SELECT avg(valorDato) as promedio "
                        . "FROM datos "
                        . "WHERE idSerieDatos LIKE '$item[0]%' ");
                $stmt1->execute();
                $vars1 = $stmt1->fetch()["promedio"];
                $idIndicador[] = $item[0];
                $nombre[] = $item[1];
                $contador[] = round($vars1);
                $color[] = $this->selectColor();
            }
        }
        $datasets[] = array(
            "backgroundColor" => $color,
            "borderColor" => "#333",
            "data" => $contador,
            "fill" => TRUE);
        $data = array("labels" => $idIndicador,
            "datasets" => $datasets);

        return $data;
    }

    public function consultaDadiiConIndicador($idDimensionC, $idTematicaC, $idIndicadorC) {
        if (strlen(trim($idDimensionC)) < 1 ||
                strlen(trim($idTematicaC)) < 1 ||
                strlen(trim($idIndicadorC)) < 1) {
            return 'error';
        } else {
            $resp = array();
            $dim = new Dimensiones();
            $tem = new Tematicas();
            $ind = new Indicadores();
            $nombreDimension = $dim->consultarNombreDimensionPorId($idDimensionC);
            $resp[] = $nombreDimension;
            $nombreTematica = $tem->consultarNombreTematicaPorId($idTematicaC);
            $resp[] = $nombreTematica;
            $nombreIndicador = $ind->consultarNombreIndicadorPorId($idIndicadorC);
            $resp[] = $nombreIndicador;
            $ser = new seriesDatos();
            $dat = new Datos();
            $series = $ser->consultarSeriePorIndicador($idIndicadorC);
            $labels = array();
            $fechas = array();
            foreach ($series as $row => $item) {
                $idSerieDatos = $item["idSerieDatos"];
                $nombreUnicoSerie = $item["nombreUnicoSerie"];
                $tipoDato = $item["tipoDato"];
                $tipoZonaGeografica = $item["tipoZonaGeografica"];
                $zonaGeografica = $item["zonaGeografica"];
                $periodicidad = $item["periodicidad"];
                $entidadCompiladora = $item["entidadCompiladora"];
                $fuenteDatos = $item["fuenteDatos"];
                $urlFuenteDatos = $item["urlFuenteDatos"];
                $desagregacionTematica = $item["desagregacionTematica"];
                $notas = $item["notas"];
                $unidadMedida = $item["unidadMedida"];
//                $da = $dat->consultarInfoDatoPorIdSerie($idSerieDatos);
                $da = $dat->consultarFechasPorIdSerie($idSerieDatos);
                foreach ($da as $row => $item) {
//                    $idDato[] = $item["idDato"];
                    $fechaDato = $item["fechaDato"];
//                    $valorDato[] = $item["valorDato"];
//                    $estadoObservacionDato[] = $item["estadoObservacionDato"];
                    if (!in_array($fechaDato, $fechas)) {
                        $fechas[] = $fechaDato;
                    }
                    if (!in_array($fechaDato, $labels)) {
                        $labels[] = $fechaDato;
                    }
                }
            }
            //Para labels y fechas
            $resp[] = $labels;
            $resp[] = $fechas;
            //Para ids series y desagregaciones
            $desagregaciones = array();
            foreach ($series as $row => $item) {
                $desagregacionTematica = $item["desagregacionTematica"];
                for ($j = 0; $j < $desagregacionTematica; $j++) {
                    $desagregacion = $desagregacionTematica;
                    $desagregaciones[] = $desagregacion;
                }
            }
            $resp[] = $series;
            $resp[] = $desagregaciones;
            //Total datos
            $totalDatos = sizeof($desagregaciones) * sizeof($labels);
            //Para datasets
            $datasets = array();
            $datoMax = "";
            for ($k = 0; $k < count($series); $k++) {
                $serie = $series[$k];
                $idSerie = $serie["idSerieDatos"];
                $Umedida = $serie["unidadMedida"];
                $datos = array();
                for ($l = 0; $l < count($fechas); $l++) {
                    $fecha = $fechas[$l];
                    $dat = new Datos();
                    $resp2 = $dat->consultarDatoPorIdSerieFecha($idSerie, $fecha);
                    if (is_int($resp2['valorDato'])) {
                        $datos[] = $resp2['valorDato'];
                    } else {
                        $datos[] = $resp2['valorDato'];
                    }
                }
                $color1 = "";
                $border1 = "";
                if (isset($datos[0])) {

                    if ($datos[0] <= 40) {
                        $color1 = "rgba(255,0,0,0.5)";
                        $border1 = "rgba(255,0,0,0.8)";
                    } elseif ($datos[0] <= 60 && $datos[0] >= 41) {
                        $color1 = "rgba(226,107,10,0.5)";
                        $border1 = "rgba(226,107,10,0.8)";
                    } elseif ($datos[0] <= 70 && $datos[0] >= 61) {
                        $color1 = "rgba(255,255,0,0.5)";
                        $border1 = "rgba(255,255,0,0.8)";
                    } elseif ($datos[0] <= 80 && $datos[0] >= 71) {
                        $color1 = "rgba(146,208,80,0.5)";
                        $border1 = "rgba(146,208,80,0.8)";
                    } elseif ($datos[0] >= 81) {
                        $color1 = "rgba(0,176,80,0.5)";
                        $border1 = "rgba(0,176,80,0.8)";
                    }
                }
                $color2 = "";
                $border2 = "";
                if (isset($datos[1])) {

                    if ($datos[1] <= 40) {
                        $color2 = "rgba(255,0,0,0.5)";
                        $border2 = "rgba(255,0,0,0.8)";
                    } elseif ($datos[1] <= 60 && $datos[1] >= 41) {
                        $color2 = "rgba(226,107,10,0.5)";
                        $border2 = "rgba(226,107,10,0.8)";
                    } elseif ($datos[1] <= 70 && $datos[1] >= 61) {
                        $color2 = "rgba(255,255,0,0.5)";
                        $border2 = "rgba(255,255,0,0.8)";
                    } elseif ($datos[1] <= 80 && $datos[1] >= 71) {
                        $color2 = "rgba(146,208,80,0.5)";
                        $border2 = "rgba(146,208,80,0.8)";
                    } elseif ($datos[1] >= 81) {
                        $color2 = "rgba(0,176,80,0.5)";
                        $border2 = "rgba(0,176,80,0.8)";
                    }
                }
                $color3 = "";
                $border3 = "";
                if (isset($datos[2])) {

                    if ($datos[2] <= 40) {
                        $color3 = "rgba(255,0,0,0.5)";
                        $border3 = "rgba(255,0,0,0.8)";
                    } elseif ($datos[2] <= 60 && $datos[2] >= 41) {
                        $color3 = "rgba(226,107,10,0.5)";
                        $border3 = "rgba(226,107,10,0.8)";
                    } elseif ($datos[2] <= 70 && $datos[2] >= 61) {
                        $color3 = "rgba(255,255,0,0.5)";
                        $border3 = "rgba(255,255,0,0.8)";
                    } elseif ($datos[2] <= 80 && $datos[2] >= 71) {
                        $color3 = "rgba(146,208,80,0.5)";
                        $border3 = "rgba(146,208,80,0.8)";
                    } elseif ($datos[2] >= 81) {
                        $color3 = "rgba(0,176,80,0.5)";
                        $border3 = "rgba(0,176,80,0.8)";
                    }
                }
                $color4 = "";
                $border4 = "";
                if (isset($datos[3])) {

                    if ($datos[3] <= 40) {
                        $color4 = "rgba(255,0,0,0.5)";
                        $border4 = "rgba(255,0,0,0.8)";
                    } elseif ($datos[3] <= 60 && $datos[3] >= 41) {
                        $color4 = "rgba(226,107,10,0.5)";
                        $border4 = "rgba(226,107,10,0.8)";
                    } elseif ($datos[3] <= 70 && $datos[3] >= 61) {
                        $color4 = "rgba(255,255,0,0.5)";
                        $border4 = "rgba(255,255,0,0.8)";
                    } elseif ($datos[3] <= 80 && $datos[3] >= 71) {
                        $color4 = "rgba(146,208,80,0.5)";
                        $border4 = "rgba(146,208,80,0.8)";
                    } elseif ($datos[3] >= 81) {
                        $color4 = "rgba(0,176,80,0.5)";
                        $border4 = "rgba(0,176,80,0.8)";
                    }
                }

//                if ($Umedida == "Porcentaje") {
                $cons = new ConsultasModel();
                $colorAleatorio = $cons->selectColor();
                $datasets[] = array("label" => $desagregaciones,
                    "backgroundColor" => [$color1, $color2, $color3, $color4],
                    "borderColor" => [$border1, $border2, $border3, $border4],
                    "data" => $datos,
                    "borderWidth" => 2,
                    "pointRotation" => 0,
                    "fill" => True);
                $datoMax = max($datos);
            }

//            var_dump($tipoGrafico);
            $tipoGrafico = "Barras";
            $resp[] = $tipoGrafico;
            $resp[] = $totalDatos;
//            Armar data
            $data = array("labels" => $labels,
                "datasets" => $datasets);
            $resp[] = $data;
            $fechaInicio = $fechas[0];
            $fechaFin = end($fechas);
            $rango = "";
            if ($fechaFin == $fechaInicio) {
                $rango = $fechaInicio;
            } else {
                $rango = $fechaInicio . " - " . $fechaFin;
            }
            $resp[] = $rango;

            $resp5 = $ser->consultarUnidadMedidaSeriePorIdIndicador($idIndicadorC);
            $resp[] = $unidadMedida;
            $resp7 = $ser->consultarPeriodicidadSeriePorIdIndicador($idIndicadorC);
            $periodicidad = $resp7["periodicidad"];
            $resp[] = $periodicidad;
            $resp[] = $datoMax;

            return $resp;
        }
    }

    public function consultarIndicadoresExpPorNombreDimension($nombreDimension) {
        if (strlen(trim($nombreDimension)) < 1) {
            return 'error';
        } else {
            $resp = array();
            $stmt1 = Connection::connect()->prepare(""
                    . "SELECT idDimension "
                    . "FROM dimensiones "
                    . "WHERE nombreDimension = :nombreDimension "
                    . "AND idConjuntoIndicadores LIKE '%EXP%'");
            $stmt1->bindParam(":nombreDimension", $nombreDimension, PDO::PARAM_STR);
            $stmt1->execute();
            $idDimension = $stmt1->fetch()['idDimension'];
            $resp[] = $idDimension;
            $tem = new Tematicas();
            $ind = new Indicadores();
            $tematicas = array();
            $indicadores = array();
            $resp1 = $tem->consultarTematicasExpPorDimension($idDimension);
            foreach ($resp1 as $row => $item) {
                $nombreTematica = $item["nombreTematica"];
                $idTematica = $item["idTematica"];
                $numeroIndicadores = $ind->contarIndicadoresActivosPorIdTematica($idTematica, "Exp")[0];
                $tematicas[] = array($idTematica, $nombreTematica, $numeroIndicadores);
                $resp2 = $ind->consultarIndicadoresExpPorTematica($idTematica);
                foreach ($resp2 as $row2 => $item2) {
                    $nombreIndicador = $item2["nombreIndicador"];
                    $idIndicador = $item2["idIndicador"];
                    $enl1 = $ind->consultarInformacionEnlacePorIdIndicadorYGeografia($idIndicador, "Exp");
                    $indicadores[] = array($idTematica, $idIndicador, $nombreIndicador, $enl1);
                }
            }
            $resp[] = $tematicas;
            $resp[] = $indicadores;
            return $resp;
        }
    }

    public function consultaIndicador($tipoConsulta, $idDimensionC, $idTematicaC, $idIndicadorC, $fuenteC, $desagregacionesTematicasC, $fechasC, $desagregacionesGeograficasC) {
        if (strlen(trim($idIndicadorC)) < 1 || sizeof($desagregacionesTematicasC) < 1 ||
                strlen(trim($fuenteC)) < 1 || sizeof($fechasC) < 1 || sizeof($desagregacionesGeograficasC) < 1) {
            return 'error';
        } else {
            $resp = array();
            $dim = new Dimensiones();
            $tem = new Tematicas();
            $ind = new Indicadores();
            $fich = new FichaTecnica();
            $ser = new SeriesDatos();
            $nombreDimension = $dim->consultarNombreDimensionPorId($idDimensionC);
            $nombreTematica = $tem->consultarNombreTematicaPorId($idTematicaC);
            $nombreIndicador = $ind->consultarNombreIndicadorPorId($idIndicadorC);

            //Para labels y fechas
            $labels = array();
            for ($i = 0; $i < count($fechasC); $i++) {
                $fecha = $fechasC[$i];
                $labels[] = $fecha;
            }

            //Para ids series y desagregaciones
            $series = array();
            $desagregacionesGeograficas = array();
            for ($j = 0; $j < count($desagregacionesTematicasC); $j++) {
                $desagregacionTematica = $desagregacionesTematicasC[$j];
                for ($k = 0; $k < count($desagregacionesGeograficasC); $k++) {
                    $desagregacionGeografica = $desagregacionesGeograficasC[$k];
                    if (!in_array($desagregacionGeografica, $desagregacionesGeograficas)) {
                        $desagregacionesGeograficas[] = $desagregacionGeografica;
                    }
                    $resp1 = $ser->consultarIdSeriePorIndicadorFuenteYDesagregaciones($idIndicadorC, $fuenteC, $desagregacionTematica, $desagregacionGeografica);
                    $series[] = [$resp1['idSerieDatos'], $desagregacionTematica, $desagregacionGeografica];
                }
            }

            //Total datos
            $cantidadDatos = sizeof($desagregacionesGeograficasC) * sizeof($labels);
            $totalDatos = (sizeof($labels) <= 2) ? sizeof($labels) : $cantidadDatos;

            //Para datasets
            $resp6 = "";
            if ($tipoConsulta == 'SIS') {
                $resp6 = $fich->consultarFichaTecnicaPorIndicadorYFuenteDatos($idIndicadorC, $fuenteC);
            } else {
                $resp6 = $fich->consultarFichaTecnicaPorIndicador($idIndicadorC);
            }
            
            //Para tipo de gráfico
            $datasets = array();
            $entidadGeneradora = array();
            $notas = array();
            $tipoGraficoArr = explode(',', $resp6['tipoGrafico']);
            $tipoGrafico = $tipoGraficoArr[0];

            if ($tipoGrafico == null || $tipoGrafico == "") {
                $tipoGrafico = "-";
            }
            for ($l = 0; $l < count($series); $l++) {
                $serie = $series[$l][0];
                $datos = array();
                for ($m = 0; $m < count($fechasC); $m++) {
                    $fecha = $fechasC[$m];
                    $dat = new Datos();
                    $resp2 = $dat->consultarDatoPorIdSerieFecha($serie, $fecha);
                    $datos[] = $resp2['valorDato'];
                }
                //Para color de gráfico 
                $colorAleatorio = $this->selectColor();
                $label = $series[$l][2] . ' - ' . $series[$l][1];
                if ($tipoConsulta == 'PIIA') {
                    $label = $series[$l][1];
                } elseif ($tipoConsulta == 'General' && count($desagregacionesGeograficas) == 1) {
                    $label = $series[$l][1];
                }
                if (($totalDatos == 1 && $tipoGrafico !== "Treemap") || $tipoGrafico == "Barras" || $tipoGrafico == "Barras apiladas" || $tipoGrafico == "Barras horizontales") {
                    $datasets[] = array("label" => $label,
                        "backgroundColor" => $colorAleatorio,
                        "data" => $datos);
                } elseif ($tipoGrafico == "Lineal") {
                    $datasets[] = array("label" => $label,
                        "borderColor" => $colorAleatorio,
                        "fill" => false,
                        "data" => $datos,
                        "pointStyle" => 'line');
                } elseif ($tipoGrafico == "Círculo") {
                    $datasets[] = array("label" => $label,
                        "backgroundColor" => $colorAleatorio,
                        "borderColor" => $colorAleatorio,
                        "fill" => false,
                        "pointRadius" => 8,
                        "pointHoverRadius" => 10,
                        "showLine" => false,
                        "data" => $datos,
                        "pointStyle" => 'circle');
                } elseif ($tipoGrafico == "Línea - círculo") {
                    $datasets[] = array("label" => $label,
                        "backgroundColor" => $colorAleatorio,
                        "borderColor" => $colorAleatorio,
                        "fill" => false,
                        "pointRadius" => 2,
                        "pointHoverRadius" => 4,
                        "showLine" => false,
                        "data" => $datos,
                        "pointStyle" => 'circle');
                } elseif ($tipoGrafico == "Treemap") {
                    if ($nombreIndicador == 'Quince primeras causas de muerte') {
                        $datasets[] = array("label" => $label,
                            "borderColor" => $colorAleatorio,
                            "data" => $datos,
                            "omitirTotal" => TRUE);
                    } else {
                        $datasets[] = array("label" => $label,
                            "borderColor" => $colorAleatorio,
                            "data" => $datos,
                            "omitirTotal" => FALSE);
                    }
                } elseif ($totalDatos > 10 && $tipoGrafico == "Área") {
                    $datasets[] = array("label" => $label,
                        "borderColor" => $colorAleatorio,
                        "fill" => true,
                        "data" => $datos,
                        "pointStyle" => 'line');
                } elseif ($tipoGrafico == "Piramide") {
                    $datasets[] = array("label" => $series[$l][2] . ' - ' . $series[$l][1],
                        "fill" => false,
                        "data" => $datos);
                } else {
                    if ($totalDatos <= 10) {
                        $datasets[] = array("label" => $label,
                            "backgroundColor" => $colorAleatorio,
                            "data" => $datos);
                    } else {
                        $datasets[] = array("label" => $label,
                            "borderColor" => $colorAleatorio,
                            "fill" => false,
                            "data" => $datos,
                            "pointStyle" => 'line');
                    }
                }
            }
            $resp3 = $ser->consultarEntidadGeneradoraSeriePorIdSerie($serie);
            foreach ($resp3 as $row => $item) {
                if (!in_array($item["entidadCompiladora"], $entidadGeneradora)) {
                    $entidadGeneradora[] = $item["entidadCompiladora"];
                }
            }
            $resp4 = $ser->consultarNotasSeriePorIdSerie($serie);
            foreach ($resp4 as $row => $item) {
                if ($item["notas"] != "" && $item["notas"] != "0" && $item["notas"] != "-") {
                    if (!in_array($item["notas"], $notas)) {
                        $notas[] = $item["notas"];
                    }
                }
            }

            //Para armar data
            $data = array("labels" => $labels, "datasets" => $datasets);

            //Rango
            $fechaInicio = $labels[0];
            $fechaFin = end($labels);
            $rango = "";
            if ($fechaFin == $fechaInicio) {
                $rango = $fechaInicio;
            } else {
                $rango = $fechaInicio . " - " . $fechaFin;
            }

            //Unidad de medida
            $resp5 = $ser->consultarUnidadMedidaSeriePorIdIndicador($idIndicadorC);
            $unidadMedicion = $resp5["unidadMedida"];

            //Información Ficha técnica
            $sigla = $resp6['sigla'];
            $justificacion = ucfirst($resp6['justificacion']);
            $definicion = ucfirst($resp6['definicion']);
            $metodosMedicion = ucfirst($resp6['metodosMedicion']);
            $formulas = $resp6['formulas'];
            $variables = $resp6['variables'];
            $valoresReferencia = ucfirst($resp6['valoresReferencia']);
            $naturaleza = ucfirst($resp6['naturaleza']);
            $desagregacionTematica = ucfirst($resp6['desagregacionTematica']);
            $desagregacionGeografica = ucfirst($resp6['desagregacionGeografica']);
            $lineaBase = ucfirst($resp6['lineaBase']);
            $responsable = ucfirst($resp6['responsable']);
            $observaciones = ucfirst($resp6['observaciones']);
            $fechaElaboracion = ucfirst($resp6['fechaElaboracion']);

            $resp7 = $ser->consultarPeriodicidadSeriePorIdIndicador($idIndicadorC);
            $periodicidad = $resp7["periodicidad"];

            $mapa = $ind->consultarMapaIndicadorPorId($idIndicadorC);

            $fuente = '';
            if ($tipoConsulta == 'General') {
                $fuente = $ser->consultarFuentePorIdIndicadorZonaGeograficaYFuenteInicial($idIndicadorC, $desagregacionesGeograficasC[0], $fuenteC)['fuenteDatos'];
            } else {
                $fuente = $ser->consultarFuenteSeriePorIdIndicadorZonaGeografica($idIndicadorC, $tipoConsulta)['fuenteDatos'];
            }

            $resp[] = $nombreDimension;
            $resp[] = $nombreTematica;
            $resp[] = $nombreIndicador;
            $resp[] = $labels;
            $resp[] = $series;
            $resp[] = $desagregacionesGeograficas;
            $resp[] = $totalDatos;
            $resp[] = $tipoGrafico;
            $resp[] = $data;
            $resp[] = $entidadGeneradora;
            $resp[] = $notas;
            $resp[] = $rango;
            $resp[] = $unidadMedicion;
            $resp[] = $sigla;
            $resp[] = $justificacion;
            $resp[] = $definicion;
            $resp[] = $metodosMedicion;
            $resp[] = $formulas;
            $resp[] = $variables;
            $resp[] = $valoresReferencia;
            $resp[] = $naturaleza;
            $resp[] = $desagregacionTematica;
            $resp[] = $desagregacionGeografica;
            $resp[] = $lineaBase;
            $resp[] = $responsable;
            $resp[] = $observaciones;
            $resp[] = $fechaElaboracion;
            $resp[] = $periodicidad;
            $resp[] = max($datos);
            $resp[] = $mapa;
            $resp[] = $fuente;

            return $resp;
        }
    }

    public function consultaIndicadorODS($tipoConsulta, $idDimensionC, $idTematicaC, $idIndicadorC, $fuenteC, $desagregacionesTematicasC, $fechasC, $desagregacionesGeograficasC) {
        if (strlen(trim($idIndicadorC)) < 1 || sizeof($desagregacionesTematicasC) < 1 ||
                strlen(trim($fuenteC)) < 1 || sizeof($fechasC) < 1 || sizeof($desagregacionesGeograficasC) < 1) {
            return 'error';
        } else {
            $resp = array();
            $dim = new Dimensiones();
            $tem = new Tematicas();
            $ind = new Indicadores();
            $fich = new FichaTecnica();
            $ser = new SeriesDatos();
            $dat = new Datos();

            $dimension = $dim->consultarDimensionPorId($idDimensionC);
            $nombreDimension = $dim->consultarNombreDimensionPorId($idDimensionC);
            $nombreTematica = $tem->consultarNombreTematicaPorId($idTematicaC);
            $nombreIndicador = $ind->consultarNombreIndicadorPorId($idIndicadorC);

//Para labels y fechas
            $labels = array();
            for ($i = 0; $i < count($fechasC); $i++) {
                $fecha = $fechasC[$i];
                $labels[] = $fecha;
            }

//Para ids series y desagregaciones
            $series = array();
            $desagregacionesGeograficas = array();

            for ($j = 0; $j < count($desagregacionesTematicasC); $j++) {
                $desagregacionTematica = $desagregacionesTematicasC[$j];
                for ($k = 0; $k < count($desagregacionesGeograficasC); $k++) {
                    $desagregacionGeografica = $desagregacionesGeograficasC[$k];
                    if (!in_array($desagregacionGeografica, $desagregacionesGeograficas)) {
                        $desagregacionesGeograficas[] = $desagregacionGeografica;
                    }
                    $resp1 = $ser->consultarIdSeriePorIndicadorFuenteYDesagregaciones($idIndicadorC, $fuenteC, $desagregacionTematica, $desagregacionGeografica);
                    $series[] = [$resp1['idSerieDatos'], $desagregacionTematica, $desagregacionGeografica];
                }
            }

//Total datos
            $cantidadDatos = sizeof($desagregacionesGeograficasC) * sizeof($labels);
            $totalDatos = (sizeof($labels) <= 2) ? sizeof($labels) : $cantidadDatos;

//Para datasets
            $resp6 = $fich->consultarFichaTecnicaPorIndicador($idIndicadorC);

//Para tipo de gráfico
            $tipoGrafico = $resp6['tipoGrafico'];
            if ($tipoGrafico == null || $tipoGrafico == "") {
                $tipoGrafico = "-";
            }
            if (count($labels) == 1) {
                $tipoGrafico = "Barras";
            }

            $entidadGeneradora = array();
            $notas = array();
            $datasets = array();
            $proyeccion = array();
            $endODSLabel = end($labels);

            for ($l = 0; $l < count($series); $l++) {
                $serie = $series[$l][0];
                $datos = array();
                for ($m = 0; $m < count($fechasC); $m++) {
                    $fecha = $fechasC[$m];
                    $resp2 = $dat->consultarDatoPorIdSerieFecha($serie, $fecha);
                    $datos[] = floatval($resp2['valorDato']);
                    if ($fecha != end($labels)) {
                        $proyeccion[] = null;
                    } else {
                        $proyeccion[] = floatval($resp2['valorDato']);
                    }
                }

                //Para color de gráfico 
                $colorAleatorio = $this->selectColor();

                $datasets[] = array(
                    "label" => $series[$l][2],
                    "borderColor" => $colorAleatorio,
                    "fill" => false,
                    "backgroundColor" => $colorAleatorio,
                    "borderDash" => "[0, 0]",
                    "radius" => 3,
                    "data" => $datos,
                    "pointStyle" => 'circle');

                $resp3 = $ser->consultarEntidadGeneradoraSeriePorIdSerie($serie);
                foreach ($resp3 as $row => $item) {
                    if (!in_array($item["entidadCompiladora"], $entidadGeneradora)) {
                        $entidadGeneradora[] = $item["entidadCompiladora"];
                    }
                }
                $resp4 = $ser->consultarNotasSeriePorIdSerie($serie);
                foreach ($resp4 as $row => $item) {
                    if ($item["notas"] != "" && $item["notas"] != "0" && $item["notas"] != "-" && $item["notas"] != "_____") {
                        if (!in_array($item["notas"], $notas)) {
                            $notas[] = $item["notas"];
                        }
                    }
                }
            }

            for ($p = end($labels) + 1; $p <= 2030; $p++) {
                $labels[] = "$p";
                if ($p !== 2030) {
                    $proyeccion[] = null;
                }
            }

            $idSerieProyeccion = $ser->consultarIdSeriePorIdIndicadorDesagregacionTematica($idIndicadorC, "Línea Base")['idSerieDatos'];
            $dato_2030 = $dat->consultarDatoPorIdSerieFecha($idSerieProyeccion, 2030)['valorDato'];
            $proyeccion[] = floatval($dato_2030);

            $datasets[] = array("label" => 'Proyección',
                "borderColor" => $dimension['color'],
                "backgroundColor" => $dimension['color'],
                "fill" => false,
                "borderDash" => "[5, 5]",
                "data" => $proyeccion,
                "radius" => 3,
                "pointStyle" => 'circle');

//Para armar data
            $data = array("labels" => $labels, "datasets" => $datasets);

//Rango
            $fechaInicio = $labels[0];
            $fechaFin = end($labels);
            $rango = "";
            if ($fechaFin == $fechaInicio) {
                $rango = $fechaInicio;
            } else {
                $rango = $fechaInicio . " - " . $endODSLabel;
            }

//Unidad de medida
            $resp5 = $ser->consultarUnidadMedidaSeriePorIdIndicador($idIndicadorC);
            $unidadMedicion = $resp5["unidadMedida"];

//Información Ficha técnica
            $sigla = $resp6['sigla'];
            $justificacion = ucfirst($resp6['justificacion']);
            $definicion = ucfirst($resp6['definicion']);
            $metodosMedicion = ucfirst($resp6['metodosMedicion']);
            $formulas = $resp6['formulas'];
            $variables = $resp6['variables'];
            $valoresReferencia = ucfirst($resp6['valoresReferencia']);
            $naturaleza = ucfirst($resp6['naturaleza']);
            $desagregacionTematica = ucfirst($resp6['desagregacionTematica']);
            $desagregacionGeografica = ucfirst($resp6['desagregacionGeografica']);
            $lineaBase = ucfirst($resp6['lineaBase']);
            $responsable = ucfirst($resp6['responsable']);
            $observaciones = ucfirst($resp6['observaciones']);
            $fechaElaboracion = ucfirst($resp6['fechaElaboracion']);

            $resp7 = $ser->consultarPeriodicidadSeriePorIdIndicador($idIndicadorC);
            $periodicidad = $resp7["periodicidad"];

            $mapa = $ind->consultarMapaIndicadorPorId($idIndicadorC);

            $fuente = $ser->consultarFuenteSeriePorIdIndicadorZonaGeografica($idIndicadorC, $tipoConsulta)['fuenteDatos'];

            $resp[] = $nombreDimension;
            $resp[] = $nombreTematica;
            $resp[] = $nombreIndicador;
            $resp[] = $labels;
            $resp[] = $series;
            $resp[] = $desagregacionesGeograficas;
            $resp[] = $totalDatos;
            $resp[] = $tipoGrafico;
            $resp[] = $data;
            $resp[] = $entidadGeneradora;
            $resp[] = $notas;
            $resp[] = $rango;
            $resp[] = $unidadMedicion;
            $resp[] = $sigla;
            $resp[] = $justificacion;
            $resp[] = $definicion;
            $resp[] = $metodosMedicion;
            $resp[] = $formulas;
            $resp[] = $variables;
            $resp[] = $valoresReferencia;
            $resp[] = $naturaleza;
            $resp[] = $desagregacionTematica;
            $resp[] = $desagregacionGeografica;
            $resp[] = $lineaBase;
            $resp[] = $responsable;
            $resp[] = $observaciones;
            $resp[] = $fechaElaboracion;
            $resp[] = $periodicidad;
            $resp[] = max($datos);
            $resp[] = $mapa;
            $resp[] = $fuente;
            $resp[] = $datasets;

            return $resp;
        }
    }

    public function consultaGlobalesCiudad($idDimensionC, $idTematicaC, $idIndicadorC, $fuenteC, $desagregacionesTematicasC, $fechasC, $desagregacionesGeograficasC) {
        if (strlen(trim($idIndicadorC)) < 1 || sizeof($desagregacionesTematicasC) < 1 ||
                strlen(trim($fuenteC)) < 1 || sizeof($fechasC) < 1 || sizeof($desagregacionesGeograficasC) < 1) {
            return 'error';
        } else {
            $resp = array();

            $dim = new Dimensiones();
            $tem = new Tematicas();
            $ind = new Indicadores();
            $fich = new FichaTecnica();
            $ser = new SeriesDatos();
            $nombreDimension = $dim->consultarNombreDimensionPorId($idDimensionC);
            $nombreTematica = $tem->consultarNombreTematicaPorId($idTematicaC);
            $nombreIndicador = $ind->consultarNombreIndicadorPorId($idIndicadorC);

//Para labels y fechas
            $labels = array();
            for ($i = 0; $i < count($fechasC); $i++) {
                $fecha = $fechasC[$i];
                $labels[] = $fecha;
            }

//Para ids series y desagregaciones
            $series = array();
            $desagregacionesGeograficas = array();

            for ($j = 0; $j < count($desagregacionesTematicasC); $j++) {
                $desagregacionTematica = $desagregacionesTematicasC[$j];
                for ($k = 0; $k < count($desagregacionesGeograficasC); $k++) {
                    $desagregacionGeografica = $desagregacionesGeograficasC[$k];
                    if (!in_array($desagregacionGeografica, $desagregacionesGeograficas)) {
                        $desagregacionesGeograficas[] = $desagregacionGeografica;
                    }
                    $resp1 = $ser->consultarIdSeriePorIndicadorFuenteYDesagregaciones($idIndicadorC, $fuenteC, $desagregacionTematica, $desagregacionGeografica);
                    $series[] = [$resp1['idSerieDatos'], $desagregacionTematica, $desagregacionGeografica];
                }
            }

//Total datos
            $cantidadDatos = sizeof($desagregacionesGeograficasC) * sizeof($labels);
            $totalDatos = (sizeof($labels) <= 2) ? sizeof($labels) : $cantidadDatos;

//Para datasets
            $resp6 = $fich->consultarFichaTecnicaPorIndicadorGlobalesCiudad($idIndicadorC);

//Para tipo de gráfico
            $tipoGrafico = $resp6['tipoGrafico'];
            if ($tipoGrafico == null || $tipoGrafico == "") {
                $tipoGrafico = "-";
            }
            if (count($labels) == 1) {
                $tipoGrafico = "Barras";
            }

            $entidadGeneradora = array();
            $notas = array();
            $datasets = array();
            for ($l = 0; $l < count($series); $l++) {
                $serie = $series[$l][0];
                $datos = array();
                for ($m = 0; $m < count($fechasC); $m++) {
                    $fecha = $fechasC[$m];
                    $dat = new Datos();
                    $resp2 = $dat->consultarDatoPorIdSerieFecha($serie, $fecha);
                    $datos[] = $resp2['valorDato'];
                }
                //Para color de gráfico
                $colorAleatorio = $this->selectColor();

                if ($tipoGrafico == "Barras") {
                    $datasets[] = array("label" => $series[$l][2] . ' - ' . $series[$l][1],
                        "backgroundColor" => $colorAleatorio,
                        "data" => $datos);
                } elseif ($tipoGrafico == "Lineal") {
                    $datasets[] = array("label" => $series[$l][2] . ' - ' . $series[$l][1],
                        "borderColor" => $colorAleatorio,
                        "fill" => false,
                        "data" => $datos,
                        "pointStyle" => 'line');
                } elseif ($tipoGrafico == "Área") {
                    $datasets[] = array("label" => $series[$l][2] . ' - ' . $series[$l][1],
                        "borderColor" => $colorAleatorio,
                        "fill" => true,
                        "data" => $datos,
                        "pointStyle" => 'line');
                } else {
                    if ($totalDatos <= 10) {
                        $datasets[] = array("label" => $series[$l][2] . ' - ' . $series[$l][1],
                            "backgroundColor" => $colorAleatorio,
                            "data" => $datos);
                    } else {
                        $datasets[] = array("label" => $series[$l][2] . ' - ' . $series[$l][1],
                            "borderColor" => $colorAleatorio,
                            "fill" => false,
                            "data" => $datos,
                            "pointStyle" => 'line');
                    }
                }

                $resp3 = $ser->consultarEntidadGeneradoraSeriePorIdSerie($serie);
                foreach ($resp3 as $row => $item) {
                    if (!in_array($item["entidadCompiladora"], $entidadGeneradora)) {
                        $entidadGeneradora[] = $item["entidadCompiladora"];
                    }
                }
                $resp4 = $ser->consultarNotasSeriePorIdSerie($serie);
                foreach ($resp4 as $row => $item) {
                    if ($item["notas"] != "" && $item["notas"] != "0") {
                        if (!in_array($item["notas"], $notas)) {
                            $notas[] = $item["notas"];
                        }
                    }
                }
            }

//Para armar data
            $data = array("labels" => $labels, "datasets" => $datasets);

//Rango
            $fechaInicio = $labels[0];
            $fechaFin = end($labels);
            $rango = "";
            if ($fechaFin == $fechaInicio) {
                $rango = $fechaInicio;
            } else {
                $rango = $fechaInicio . " - " . $fechaFin;
            }

//Unidad de medida
            $resp5 = $ser->consultarUnidadMedidaSeriePorIdIndicador($idIndicadorC);
            $unidadMedicion = $resp5["unidadMedida"];

            $justificacion = ucfirst($resp6['justificacion']);
            $definicion = ucfirst($resp6['definicion']);
            $metodologia = ucfirst($resp6['metodologia']);
            $referencia = ucfirst($resp6['referencia']);
            $observacionesLimitaciones = ucfirst($resp6['observacionesLimitaciones']);
            $otrasOrganizaciones = ucfirst($resp6['otrasOrganizaciones']);

            $resp7 = $ser->consultarPeriodicidadSeriePorIdIndicador($idIndicadorC);
            $periodicidad = $resp7["periodicidad"];

            $fuente = $ser->consultarFuenteSeriePorIdIndicadorZonaGeografica($idIndicadorC, 'IGC')['fuenteDatos'];


            $resp[] = $nombreDimension;
            $resp[] = $nombreTematica;
            $resp[] = $nombreIndicador;
            $resp[] = $labels;
            $resp[] = $series;
            $resp[] = $desagregacionesGeograficas;
            $resp[] = $totalDatos;
            $resp[] = $tipoGrafico;
            $resp[] = $data;
            $resp[] = $entidadGeneradora;
            $resp[] = $notas;
            $resp[] = $rango;
            $resp[] = $unidadMedicion;
            $resp[] = $justificacion;
            $resp[] = $definicion;
            $resp[] = $metodologia;
            $resp[] = $referencia;
            $resp[] = $observacionesLimitaciones;
            $resp[] = $otrasOrganizaciones;
            $resp[] = $periodicidad;
            $resp[] = max($datos);
            $resp[] = $fuente;

            return $resp;
        }
    }

    public function consultaExpediente($idDimensionC, $idTematicaC, $idIndicadorC, $tipoZonaGeograficaC, $zonaGeograficaC, $desagregacionesTemC, $fechasC) {
        if (strlen(trim($idIndicadorC)) < 1 || sizeof($desagregacionesTemC) < 1 ||
                strlen(trim($tipoZonaGeograficaC)) < 1 || strlen(trim($zonaGeograficaC)) < 1 ||
                sizeof($fechasC) < 1) {
            return 'error';
        } else {
            $resp = array();
            $dim = new Dimensiones();
            $tem = new Tematicas();
            $ind = new Indicadores();
            $nombreDimension = $dim->consultarNombreDimensionPorId($idDimensionC);
            $resp[] = $nombreDimension;
            $nombreTematica = $tem->consultarNombreTematicaPorId($idTematicaC);
            $resp[] = $nombreTematica;
            $nombreIndicador = $ind->consultarNombreIndicadorPorId($idIndicadorC);
            $resp[] = $nombreIndicador;
//Para labels y fechas
            $labels = array();
            $fechas = array();
            for ($i = 0; $i < count($fechasC); $i++) {
                $fecha = $fechasC[$i];
                if (!in_array($fecha, $fechas)) {
                    $fechas[] = $fecha;
                }
                if (!in_array($fecha, $labels)) {
                    $labels[] = $fecha;
                }
            }
            $resp[] = $labels;
            $resp[] = $fechas;
//Para ids series y desagregaciones
            $series = array();
            $ser = new SeriesDatos();
            $desagregaciones = array();
            for ($j = 0; $j < count($desagregacionesTemC); $j++) {
                $desagregacion = $desagregacionesTemC[$j];
                $desagregaciones[] = $desagregacion;
                $resp1 = $ser->consultarIdSeriePorIndicadorGeografiaZonaActualDesagregacionTematicaExpediente($idIndicadorC, $tipoZonaGeograficaC, $zonaGeograficaC, $desagregacion);
                foreach ($resp1 as $row => $item) {
                    $series[] = $item["idSerieDatos"];
                }
            }
            $resp[] = $series;
            $resp[] = $desagregaciones;

//Total datos
            $totalDatos = sizeof($desagregacionesTemC) * sizeof($labels);
//Para datasets
            $datasets = array();
            $fich = new FichaTecnica();
            $resp6 = $fich->consultarFichaTecnicaPorIndicador($idIndicadorC);

//Para tipo de gráfico
            $tipoGrafico = $resp6['tipoGrafico'];
            if ($tipoGrafico == null || $tipoGrafico == "") {
                $tipoGrafico = "-";
            }
            if (count($labels) == 1) {
                $tipoGrafico = "Barras";
            }
            for ($k = 0; $k < count($series); $k++) {
                $serie = $series[$k];
                $datos = array();
                for ($l = 0; $l < count($fechasC); $l++) {
                    $fecha = $fechasC[$l];
                    $dat = new Datos();
                    $resp2 = $dat->consultarDatoPorIdSerieFecha($serie, $fecha);

                    if (is_int($resp2['valorDato'])) {
                        $datos[] = $resp2['valorDato'];
                    } else {
                        $datos[] = $resp2['valorDato'];
                    }
                }

                $cons = new ConsultasModel();
                $colorAleatorio = $cons->selectColor();

                if ($totalDatos == 1 || $tipoGrafico == "Barras" || $tipoGrafico == "Barras apiladas") {
                    $datasets[] = array("label" => $desagregaciones[$k],
                        "backgroundColor" => $colorAleatorio,
                        "data" => $datos);
                } elseif ($tipoGrafico == "Lineal") {
                    $datasets[] = array("label" => $desagregaciones[$k],
                        "borderColor" => $colorAleatorio,
                        "fill" => false,
                        "data" => $datos,
                        "pointStyle" => 'line');
                } elseif ($totalDatos > 10 && $tipoGrafico == "Área") {
                    $datasets[] = array("label" => $desagregaciones[$k],
                        "borderColor" => $colorAleatorio,
                        "fill" => true,
                        "data" => $datos,
                        "pointStyle" => 'line');
                } else {
                    if ($totalDatos <= 10) {
                        $datasets[] = array("label" => $desagregaciones[$k],
                            "backgroundColor" => $colorAleatorio,
                            "data" => $datos);
                    } else {
                        $datasets[] = array("label" => $desagregaciones[$k],
                            "borderColor" => $colorAleatorio,
                            "fill" => false,
                            "data" => $datos,
                            "pointStyle" => 'line');
                    }
                }
            }
            $resp[] = $tipoGrafico;
            $resp[] = $totalDatos;

//Armar data
            $data = array("labels" => $labels, "datasets" => $datasets);
            $resp[] = $data;

            $entidadGeneradora = array();
            $fuente = "";
            $notas = array();
            for ($p = 0; $p < count($series); $p++) {
                $serie = $series[$p];
                $stmtF = Connection::connect()->prepare(""
                        . "SELECT fuenteDatos "
                        . "FROM seriedatos "
                        . "WHERE idSerieDatos=:idSerie");
                $stmtF->bindParam(":idSerie", $serie, PDO::PARAM_STR);
                $stmtF->execute();
                $fnt = $stmtF->fetchAll();
                foreach ($fnt as $row => $item) {
                    if ($fuente !== $item) {
                        $fuente = $item;
                    }
                }
                $resp3 = $ser->consultarEntidadGeneradoraSeriePorIdSerie($serie);
                foreach ($resp3 as $row => $item) {
                    $entidadGeneradora[] = $item["entidadCompiladora"];
                }
                $resp4 = $ser->consultarNotasSeriePorIdSerie($serie);
                foreach ($resp4 as $row => $item) {
                    if ($item["notas"] != "" && $item["notas"] != "0") {
                        if (!in_array($item["notas"], $notas)) {
                            $notas[] = $item["notas"];
                        }
                    }
                }
            }
            $resp[] = $fuente;
            $resp[] = $entidadGeneradora;
            $resp[] = $notas;
            $fechaInicio = $fechas[0];
            $fechaFin = end($fechas);
            $rango = "";
            if ($fechaFin == $fechaInicio) {
                $rango = $fechaInicio;
            } else {
                $rango = $fechaInicio . " - " . $fechaFin;
            }
            $resp[] = $rango;

            $resp5 = $ser->consultarUnidadMedidaSeriePorIdIndicador($idIndicadorC);
            $unidadMedicion = $resp5["unidadMedida"];
            $resp[] = $unidadMedicion;

            $sigla = $resp6['sigla'];
            $justificacion = ucfirst($resp6['justificacion']);
            $definicion = ucfirst($resp6['definicion']);
            $metodosMedicion = ucfirst($resp6['metodosMedicion']);
            $formulas = $resp6['formulas'];
            $variables = $resp6['variables'];
            $valoresReferencia = ucfirst($resp6['valoresReferencia']);
            $naturaleza = ucfirst($resp6['naturaleza']);
            $desagregacionTematica = ucfirst($resp6['desagregacionTematica']);
            $desagregacionGeografica = ucfirst($resp6['desagregacionGeografica']);
            $lineaBase = ucfirst($resp6['lineaBase']);
            $responsable = ucfirst($resp6['responsable']);
            $observaciones = ucfirst($resp6['observaciones']);
            $fechaElaboracion = ucfirst($resp6['fechaElaboracion']);

            $resp[] = $sigla;
            $resp[] = $justificacion;
            $resp[] = $definicion;
            $resp[] = $metodosMedicion;
            $resp[] = $formulas;
            $resp[] = $variables;
            $resp[] = $valoresReferencia;
            $resp[] = $naturaleza;
            $resp[] = $desagregacionTematica;
            $resp[] = $desagregacionGeografica;
            $resp[] = $lineaBase;
            $resp[] = $responsable;
            $resp[] = $observaciones;
            $resp[] = $fechaElaboracion;

            $resp7 = $ser->consultarPeriodicidadSeriePorIdIndicador($idIndicadorC);
            $periodicidad = $resp7["periodicidad"];
            $resp[] = $periodicidad;
            return $resp;
        }
    }

    public function consultaMasBuscados() {
        $stmt1 = Connection::connect()->prepare(""
                . "SELECT dimensiones.idDimension, tematicas.idTematica, "
                . "indicadores.idIndicador, indicadores.nombreIndicador, "
                . "seriedatos.idSerieDatos, seriedatos.fuenteDatos, "
                . "seriedatos.desagregacionTematica, seriedatos.zonaGeografica, "
                . "indicadores.numeroConsultas "
                . "FROM dimensiones, tematicas, indicadores, seriedatos "
                . "WHERE dimensiones.idDimension = tematicas.idDimension "
                . "AND tematicas.idTematica = indicadores.idTematica "
                . "AND indicadores.idIndicador = seriedatos.idIndicador "
                . "AND seriedatos.idSerieDatos LIKE '%sis%' "
                . "ORDER BY numeroConsultas DESC LIMIT 5");
        $stmt1->execute();
        $series = $stmt1->fetchAll();
        for ($i = 0; $i < count($series); $i++) {
            $idIndicador = $series[$i][1];
            $ind = new Indicadores();
            $nombreIndicador = $ind->consultarNombreIndicadorPorId($idIndicador);
            $series[$i][] = $nombreIndicador[0];
        }
        return $series;
    }

    public function selectColor() {
        $colors = ["#00008B", "#0000FF", "#006400", "#008000", "#082567", "#008B8B", "#00BFFF", "#00FA9A", "#00FF00", "#00FF7F", "#00FFFF", "#1E90FF", "#20B2AA", "#2E8B57", "#2F4F4F", "#32CD32", "#40E0D0", "#4169E1", "#4682B4", "#483D8B", "#4B0082", "#556B2F", "#5F9EA0", "#6495ED", "#66CDAA", "#6A5ACD", "#6B8E23", "#708090", "#7B68EE", "#7CFC00", "#7FDD4C", "#7FFFD4", "#800000", "#800080", "#808000", "#87CEEB", "#8A2BE2", "#8B0000", "#8B4513", "#8FBC8F", "#90EE90", "#9370DB", "#98FB98", "#9966CC", "#9ACD32", "#A0522D", "#A52A2A", "#A76726", "#ADFF2F", "#B0C4DE", "#B22222", "#B8860B", "#BA55D3", "#BC8F8F", "#BDB76B", "#C71585", "#CD5C5C", "#CD853F", "#D2691E", "#D2B48C", "#D8BFD8", "#DA70D6", "#DAA520", "#DB7093", "#DC143C", "#DEB887", "#E52B50", "#E9967A", "#ED9121", "#EE82EE", "#F0E68C", "#F4A460", "#FA8072", "#FF0000", "#FF00FF", "#FF1493", "#FF4500", "#FF4D00", "#FF6347", "#FF69B4", "#FF7F50", "#FF8C00", "#FFA07A", "#FFBF00", "#FFA500", "#FFB6C1", "#FFD700", "#FFDEAD", "#FFFF00"];
        $position = array_rand($colors);
        $color = $colors[$position];
        return $color;
    }

    public function consultarInformacionIndicadorPorNombre($nombreIndicador, $nombreComuna) {
        $stmt1 = Connection::connect()->prepare(""
                . "SELECT dimensiones.idDimension, tematicas.idTematica, indicadores.idIndicador "
                . "FROM dimensiones, tematicas, indicadores, seriedatos "
                . "WHERE dimensiones.idDimension = tematicas.idDimension "
                . "AND tematicas.idTematica = indicadores.idTematica "
                . "AND indicadores.idIndicador = seriedatos.idIndicador "
                . "AND indicadores.nombreIndicador = :nombreIndicador "
                . "AND seriedatos.zonaGeografica = :zonaGeografica");
        $stmt1->bindParam(":nombreIndicador", $nombreIndicador, PDO::PARAM_STR);
        $stmt1->bindParam(":zonaGeografica", $nombreComuna, PDO::PARAM_STR);
        $stmt1->execute();
        $vars = $stmt1->fetch();
        return $vars;
    }

    public function consultaPerfilesComunas($idIndicadorC, $fuenteC, $desagregacionC, $fechasC, $comunasCorregimientosC) {

        if (strlen(trim($idIndicadorC)) < 1 || strlen(trim($desagregacionC)) < 1 ||
                strlen(trim($fuenteC)) < 1 || sizeof($fechasC) < 1 ||
                sizeof($comunasCorregimientosC) < 1) {
            return 'error';
        } else {
            $resp = array();
            $stmt3 = Connection::connect()->prepare(""
                    . "SELECT * "
                    . "FROM indicadores "
                    . "WHERE idIndicador = :idIndicador");
            $stmt3->bindParam(":idIndicador", $idIndicadorC, PDO::PARAM_STR);
            $stmt3->execute();
            $nombreIndicador = $stmt3->fetch()['nombreIndicador'];
            $resp[] = $nombreIndicador;

//Para labels y fechas
            $labels = array();
            $fechas = array();
            for ($i = 0; $i < count($fechasC); $i++) {
                $fecha = $fechasC[$i];
                $labels[] = $fecha;
                $fechas[] = $fecha;
            }

//Para ids series y desagregaciones
            $series = array();
            $comunas = array();
            for ($j = 0; $j < count($comunasCorregimientosC); $j++) {
                $comuna = $comunasCorregimientosC[$j];
                $comunas[] = $comuna;

                $ser = new SeriesDatos();
                $resp1 = $ser->consultarIdSeriePorIndicadorFuenteYDesagregacionComunasPerfiles($idIndicadorC, $fuenteC, $desagregacionC, $comuna);
                foreach ($resp1 as $row => $item) {
                    $series[] = $item["idSerieDatos"];
                }
            }

//Total datos
            $totalDatos = sizeof($comunasCorregimientosC) * sizeof($labels);

//Para datasets
            $datasets = array();
            for ($k = 0; $k < count($series); $k++) {
                $serie = $series[$k];
                $datos = array();
                for ($l = 0; $l < count($fechasC); $l++) {
                    $fecha = $fechasC[$l];
                    $dat = new Datos();
                    $resp2 = $dat->consultarDatoPorIdSerieFecha($serie, $fecha);
                    foreach ($resp2 as $row => $item) {
                        if (is_int($item['valorDato'])) {
                            $datos[] = $item['valorDato'];
                        } else {
                            if (strpos($nombreIndicador, "GINI") !== false ||
                                    strpos($nombreIndicador, "Toneladas de residuos sólidos") !== false ||
                                    strpos($nombreIndicador, "Tasa de crecimiento de la población") !== false) {
                                $datos[] = number_format($item['valorDato'], 2, ".", ",");
                            } else {
                                $datos[] = number_format($item['valorDato'], 2, ".", ",");
                            }
                        }
                    }
                }
                $cons = new ConsultasModel();
                $colorAleatorio = $cons->selectColor();
                if ($totalDatos <= 10) {
                    $datasets[] = array("label" => $comunasCorregimientosC[$k],
                        "backgroundColor" => $colorAleatorio,
                        "data" => $datos);
                } else {
                    $datasets[] = array("label" => $comunasCorregimientosC[$k],
                        "borderColor" => $colorAleatorio,
                        "fill" => false,
                        "data" => $datos,
                        "pointStyle" => 'line');
                }
            }
            $resp[] = $totalDatos;

//Armar data
            $data = array("labels" => $labels, "datasets" => $datasets);
            $resp[] = $data;
            $entidadGeneradora = array();
            $notas = array();
            for ($p = 0; $p < count($series); $p++) {
                $serie = $series[$p];
                $resp3 = $ser->consultarEntidadGeneradoraSeriePorIdSerie($serie);
                foreach ($resp3 as $row => $item) {
                    if (!in_array($item["entidadCompiladora"], $entidadGeneradora)) {
                        $entidadGeneradora[] = $item["entidadCompiladora"];
                    }
                }
                $resp4 = $ser->consultarNotasSeriePorIdSerie($serie);
                foreach ($resp4 as $row => $item) {
                    if ($item["notas"] != "" && $item["notas"] != "0") {
                        if (!in_array($item["notas"], $notas)) {
                            $notas[] = $item["notas"];
                        }
                    }
                }
            }
            $resp[] = $notas;

//Rango
            $fechaInicio = $fechas[0];
            $fechaFin = end($fechas);
            $rango = "";
            if ($fechaFin == $fechaInicio) {
                $rango = $fechaInicio;
            } else {
                $rango = $fechaInicio . " - " . $fechaFin;
            }
            $resp[] = $rango;

            $unidadMedicion = "";
            $resp5 = $ser->consultarUnidadMedidaSeriePorIdIndicador($idIndicadorC);
            foreach ($resp5 as $row => $item) {
                $unidadMedicion = $item["unidadMedida"];
            }
            $resp[] = $unidadMedicion;
            return $resp;
        }
    }

    public function consultaComunas($idIndicadorC, $fuenteC, $desagregacionC, $fechasC, $comunasCorregimientosC) {
        if (strlen(trim($idIndicadorC)) < 1 || strlen(trim($desagregacionC)) < 1 ||
                strlen(trim($fuenteC)) < 1 || sizeof($fechasC) < 1 ||
                sizeof($comunasCorregimientosC) < 1) {
            return 'error';
        } else {
            $resp = array();
            $dim = new Dimensiones();
            $idDimension = explode("_", $idIndicadorC)[0];
            $nombreDimension = $dim->consultarNombreDimensionPorId($idDimension);
            $resp[] = $nombreDimension;
            $tem = new Tematicas();
            $idTematica = $idDimension . '_' . explode("I", explode("_", $idIndicadorC)[1])[0];
            $nombreTematica = $tem->consultarNombreTematicaPorId($idTematica);
            $resp[] = $nombreTematica;
            $stmt3 = Connection::connect()->prepare(""
                    . "SELECT * "
                    . "FROM indicadores "
                    . "WHERE idIndicador = :idIndicador");
            $stmt3->bindParam(":idIndicador", $idIndicadorC, PDO::PARAM_STR);
            $stmt3->execute();
            $nombreIndicador = $stmt3->fetch()['nombreIndicador'];
            $resp[] = $nombreIndicador;
//Para labels y fechas
            $labels = array();
            $fechas = array();
            for ($i = 0; $i < count($fechasC); $i++) {
                $fecha = $fechasC[$i];
                $labels[] = $fecha;
                $fechas[] = $fecha;
            }
//Para ids series y desagregaciones
            $series = array();
            $comunas = array();
            for ($j = 0; $j < count($comunasCorregimientosC); $j++) {
                $comuna = $comunasCorregimientosC[$j];
                $comunas[] = $comuna;
                $ser = new SeriesDatos();

                if ($comuna == 'Cali') {
                    $fuenteC = "DANE";
                }
                $resp1 = $ser->consultarIdSeriePorIndicadorFuenteYDesagregacionComunasPerfiles($idIndicadorC, $fuenteC, $desagregacionC, $comuna);
                foreach ($resp1 as $row => $item) {
                    $series[] = $item["idSerieDatos"];
                }
            }
//Total datos
            $totalDatos = sizeof($comunasCorregimientosC) * sizeof($labels);
//Para datasets
            $datasets = array();
            for ($k = 0; $k < count($series); $k++) {
                $serie = $series[$k];
                $datos = array();
                for ($l = 0; $l < count($fechasC); $l++) {
                    $fecha = $fechasC[$l];
                    $dat = new Datos();
                    $resp2 = $dat->consultarDatoPorIdSerieFecha($serie, $fecha);
                    foreach ($resp2 as $row => $item) {
                        $datos[] = $item['valorDato'];
                    }
                }

                $cons = new ConsultasModel();
                $colorAleatorio = $cons->selectColor();
                $datasets[] = array("label" => $comunasCorregimientosC[$k],
                    "backgroundColor" => $colorAleatorio,
                    "data" => $datos);
            }
            $resp[] = $totalDatos;
//Armar data
            $data = array("labels" => $labels, "datasets" => $datasets);
            $resp[] = $data;
            $entidadGeneradora = array();
            $notas = array();
            for ($p = 0; $p < count($series); $p++) {
                $serie = $series[$p];
                $resp3 = $ser->consultarEntidadGeneradoraSeriePorIdSerie($serie);
                foreach ($resp3 as $row => $item) {
                    if (!in_array($item["entidadCompiladora"], $entidadGeneradora)) {
                        $entidadGeneradora[] = $item["entidadCompiladora"];
                    }
                }
                $resp4 = $ser->consultarNotasSeriePorIdSerie($serie);
                foreach ($resp4 as $row => $item) {
                    if ($item["notas"] != "" && $item["notas"] != "0") {
                        if (!in_array($item["notas"], $notas)) {
                            $notas[] = $item["notas"];
                        }
                    }
                }
            }
            $resp[] = $notas;
//Rango
            $fechaInicio = $fechas[0];
            $fechaFin = end($fechas);
            $rango = "";
            if ($fechaFin == $fechaInicio) {
                $rango = $fechaInicio;
            } else {
                $rango = $fechaInicio . " - " . $fechaFin;
            }
            $resp[] = $rango;
            $unidadMedicion = "";
            $resp5 = $ser->consultarUnidadMedidaSeriePorIdIndicador($idIndicadorC);
            foreach ($resp5 as $row => $item) {
                $unidadMedicion = $item["unidadMedida"];
            }
            $resp[] = $unidadMedicion;
            return $resp;
        }
    }

    public function buscarIndicadorPorNombre($idDimensionP, $idTematicaP, $idIndicadorP, $fuenteP, $desagregacionesP, $fechasP) {
        if (strlen(trim($idIndicadorP)) < 1 || sizeof($desagregacionesP) < 1 ||
                strlen(trim($fuenteP)) < 1 || sizeof($fechasP) < 1) {
            return 'error';
        } else {
            $resp = array();

            $stmt1 = Connection::connect()->prepare(""
                    . "SELECT * "
                    . "FROM dimensiones "
                    . "WHERE idDimension = :idDimension");
            $stmt1->bindParam(":idDimension", $idDimensionP, PDO::PARAM_STR);
            $stmt1->execute();
            $nombreDimension = $stmt1->fetch()['nombreDimension'];
            $resp[] = $nombreDimension;

            $stmt2 = Connection::connect()->prepare(""
                    . "SELECT * "
                    . "FROM tematicas "
                    . "WHERE idTematica = :idTematica");
            $stmt2->bindParam(":idTematica", $idTematicaP, PDO::PARAM_STR);
            $stmt2->execute();
            $nombreTematica = $stmt2->fetch()['nombreTematica'];
            $resp[] = $nombreTematica;

            $stmt3 = Connection::connect()->prepare(""
                    . "SELECT * "
                    . "FROM indicadores "
                    . "WHERE idIndicador = :idIndicador");
            $stmt3->bindParam(":idIndicador", $idIndicadorP, PDO::PARAM_STR);
            $stmt3->execute();
            $nombreIndicador = $stmt3->fetch()['nombreIndicador'];
            $resp[] = $nombreIndicador;

//Para labels y fechas
            $labels = array();
            $fechas = array();
            for ($i = 0; $i < count($fechasP); $i++) {
                $fecha = $fechasP[$i];
                $labels[] = $fecha;
                $fechas[] = $fecha;
            }
            $resp[] = $labels;
            $resp[] = $fechas;

//Para ids series y desagregaciones
            $series = array();
            $desagregaciones = array();
            $ser = new SeriesDatos();
            for ($j = 0; $j < count($desagregacionesP); $j++) {
                $desagregacion = $desagregacionesP[$j];
                $desagregaciones[] = $desagregacion;
                $resp1 = $ser->consultarIdSeriePorIndicadorFuenteYDesagregacionCali($idIndicadorP, $fuenteP, $desagregacion);
                foreach ($resp1 as $row => $item) {
                    $series[] = $item["idSerieDatos"];
                }
            }
            $resp[] = $series;
            $resp[] = $desagregaciones;

//Total datos
            $totalDatos = sizeof($desagregacionesP) * sizeof($labels);

//Para datasets
            $datasets = array();
            for ($k = 0; $k < count($series); $k++) {
                $serie = $series[$k];
                $datos = array();
                for ($l = 0; $l < count($fechasP); $l++) {
                    $fecha = $fechasP[$l];
                    $dat = new Datos();
                    $resp2 = $dat->consultarDatoPorIdSerieFecha($serie, $fecha);
                    foreach ($resp2 as $row => $item) {
                        $datos[] = $item['valorDato'];
                    }
                }
                $tipoGrafico = "-";
                $fich = new FichaTecnica();
                $resp6 = $fich->consultarFichaTecnicaPorIndicador($idIndicadorP);

                foreach ($resp6 as $row => $item) {
                    $tipoGrafico = $item['tipoGrafico'];
                }
                $cons = new ConsultasModel();
                $colorAleatorio = $cons->selectColor();
                if ($tipoGrafico == "Barras") {
                    $datasets[] = array("label" => $desagregaciones[$k],
                        "backgroundColor" => $colorAleatorio,
                        "data" => $datos);
                } elseif ($tipoGrafico == "Lineal") {
                    $datasets[] = array("label" => $desagregaciones[$k],
                        "borderColor" => $colorAleatorio,
                        "fill" => false,
                        "data" => $datos,
                        "pointStyle" => 'line');
                } elseif ($tipoGrafico == "Área") {
                    $datasets[] = array("label" => $desagregaciones[$k],
                        "borderColor" => $colorAleatorio,
                        "fill" => true,
                        "data" => $datos,
                        "pointStyle" => 'line');
                } else {
                    if ($totalDatos <= 10) {
                        $datasets[] = array("label" => $desagregaciones[$k],
                            "backgroundColor" => $colorAleatorio,
                            "data" => $datos);
                    } else {
                        $datasets[] = array("label" => $desagregaciones[$k],
                            "borderColor" => $colorAleatorio,
                            "fill" => false,
                            "data" => $datos,
                            "pointStyle" => 'line');
                    }
                }
            }
            $resp[] = $datos;
            $resp[] = $totalDatos;

//Armar data
            $data = array("labels" => $labels, "datasets" => $datasets);
            $resp[] = $data;

            $entidadGeneradora = array();
            $notas = array();
            for ($p = 0; $p < count($series); $p++) {
                $serie = $series[$p];
                $resp3 = $ser->consultarEntidadGeneradoraSeriePorIdSerie($serie);
                foreach ($resp3 as $row => $item) {
                    $entidadGeneradora[] = $item["entidadCompiladora"];
                }
                $resp4 = $ser->consultarNotasSeriePorIdSerie($serie);
                foreach ($resp4 as $row => $item) {
                    if ($item["notas"] != "" && $item["notas"] != "0") {
                        if (!in_array($item["notas"], $notas)) {
                            $notas[] = $item["notas"];
                        }
                    }
                }
            }
            $resp[] = $entidadGeneradora;
            $resp[] = $notas;

//Rango
            $fechaInicio = $fechas[0];
            $fechaFin = end($fechas);
            $rango = "";
            if ($fechaFin == $fechaInicio) {
                $rango = $fechaInicio;
            } else {
                $rango = $fechaInicio . " - " . $fechaFin;
            }
            $resp[] = $rango;

            $unidadMedicion = "";
            $resp5 = $ser->consultarUnidadMedidaSeriePorIdIndicador($idIndicadorP);
            foreach ($resp5 as $row => $item) {
                $unidadMedicion = $item["unidadMedida"];
            }
            $resp[] = $unidadMedicion;
            $sigla = "";
            $justificacion = "";
            $definicion = "";
            $metodosMedicion = "";
            $formulas = "";
            $variables = "";
            $valoresReferencia = "";
            $naturaleza = "";
            $desagregacionTematica = "";
            $desagregacionGeografica = "";
            $lineaBase = "";
            $responsable = "";
            $observaciones = "";
            $fechaElaboracion = "";
            foreach ($resp6 as $row => $item) {
                $sigla = $item['sigla'];
                $justificacion = ucfirst($item['justificacion']);
                $definicion = ucfirst($item['definicion']);
                $metodosMedicion = ucfirst($item['metodosMedicion']);
                $formulas = $item['formulas'];
                $variables = $item['variables'];
                $valoresReferencia = ucfirst($item['valoresReferencia']);
                $naturaleza = ucfirst($item['naturaleza']);
                $desagregacionTematica = ucfirst($item['desagregacionTematica']);
                $desagregacionGeografica = ucfirst($item['desagregacionGeografica']);
                $lineaBase = ucfirst($item['lineaBase']);
                $responsable = ucfirst($item['responsable']);
                $observaciones = ucfirst($item['observaciones']);
                $fechaElaboracion = ucfirst($item['fechaElaboracion']);
            }
            $resp[] = $sigla;
            $resp[] = $justificacion;
            $resp[] = $definicion;
            $resp[] = $metodosMedicion;
            $resp[] = $formulas;
            $resp[] = $variables;
            $resp[] = $valoresReferencia;
            $resp[] = $naturaleza;
            $resp[] = $desagregacionTematica;
            $resp[] = $desagregacionGeografica;
            $resp[] = $lineaBase;
            $resp[] = $responsable;
            $resp[] = $observaciones;
            $resp[] = $fechaElaboracion;
            $periodicidad = "";
            $resp7 = $ser->consultarPeriodicidadSeriePorIdIndicador($idIndicadorP);
            foreach ($resp7 as $row => $item) {
                $periodicidad = $item["periodicidad"];
            }
            $resp[] = $periodicidad;

//Tiene variables
            $tieneVariables = false;
            $stmt4 = Connection::connect()->prepare(""
                    . "SELECT idIndicador "
                    . "FROM indicadoresvariables "
                    . "WHERE idIndicador = :idIndicador");
            $stmt4->bindParam(":idIndicador", $idIndicadorP, PDO::PARAM_STR);
            $stmt4->execute();
            $num = $stmt4->fetch();
            if ($num > 0) {
                $tieneVariables = true;
            }
            $resp[] = $tieneVariables;
            $numerador = "";
            $denominador = "";
            if ($tieneVariables) {
                $stmt5 = Connection::connect()->prepare(""
                        . "SELECT * "
                        . "FROM variables, indicadoresvariables "
                        . "WHERE indicadoresvariables.idIndicador = :idIndicador "
                        . "AND variables.idVariable = indicadoresvariables.idVariable");
                $stmt5->bindParam(":idIndicador", $idIndicadorP, PDO::PARAM_STR);
                $stmt5->execute();
                $tipoDatoVariable = $stmt5->fetch()['tipoDato'];
                if ($tipoDatoVariable == 'Numerador') {
                    $numerador = $stmt5->fetch()['nombreVariable'];
                }
                if ($tipoDatoVariable == 'Denominador') {
                    $denominador = $stmt5->fetch()['nombreVariable'];
                }
            }

//            $resp[] = $numerador;
//            $resp[] = $denominador;
            $resp[] = max($datos);
            return $resp;
        }
    }

}

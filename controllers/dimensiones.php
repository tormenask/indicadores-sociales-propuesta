<?php

/**
 * <b>DimensionesController</b>
 * Se encuentran las consultas necesarias para visualizar toda la información
 * asociada a las dimensiones de cada uno de los conjuntos de indicadores
 */
class DimensionesController {

    /**
     * <b>consultarDimensionesParaComunasCorregimientosConjuntoIndicadoresController</b>
     * <br>
     * Permite consultar las dimensiones disponibles para un conjunto de 
     * indicadores, para las desagregaciones geográficas de comunas y corregimientos
     * @param string $idConjuntoIndicadores ID del conjunto de indicadores
     * @param string $comunasCorregimientos Desagregaciones geográficas del indicador
     */
    public function consultarDimensionesParaComunasCorregimientosConjuntoIndicadoresController($idConjuntoIndicadores, $comunasCorregimientos) {
        $comunasCorr = json_decode($comunasCorregimientos);
        $options = array();
        for ($index = 0; $index < count($comunasCorr); $index++) {
            $zonaGeografica = $comunasCorr[$index][0];
            $dim = new Dimensiones();
            $resp = $dim->consultarDimensionesParaComunasCorregimientosPorConjuntoIndicadores($idConjuntoIndicadores, $zonaGeografica);
            foreach ($resp as $row => $item) {
                if (!in_array(array("label" => $item['nombreDimension'],
                            "title" => $item['nombreDimension'],
                            "value" => $item['idDimension'],
                            "selected" => false), $options)) {
                    $options[] = array("label" => $item['nombreDimension'],
                        "title" => $item['nombreDimension'],
                        "value" => $item['idDimension'],
                        "selected" => false);
                }
            }
        }
        echo json_encode($options);
    }

    /**
     * <b>consultarDimensionesParaComparativosConjuntoIndicadoresController</b>
     * <br>
     * Permite consultar las dimensiones disponibles para un conjunto de 
     * indicadores, para las desagregaciones geográficas de comparativos regionales
     * @param string $idConjuntoIndicadores ID del conjunto de indicadores
     */
    public function consultarDimensionesParaComparativosConjuntoIndicadoresController($idConjuntoIndicadores) {
        $options = array();
        $dim = new Dimensiones();
        $resp = $dim->consultarDimensionesParaComparativosPorConjuntoIndicadores($idConjuntoIndicadores);
        foreach ($resp as $row => $item) {
            if (!in_array(array("label" => $item['nombreDimension'],
                        "title" => $item['nombreDimension'],
                        "value" => $item['idDimension'],
                        "selected" => false), $options)) {
                $options[] = array("label" => $item['nombreDimension'],
                    "title" => $item['nombreDimension'],
                    "value" => $item['idDimension'],
                    "selected" => false);
            }
        }
        echo json_encode($options);
    }

    /**
     * <b>consultarDimensionesPorIdConjuntoIndicadores</b>
     * <br>
     * Permite consultar las dimensiones disponibles para un conjunto de indicadores
     * @param string $idConjuntoIndicadores ID del conjunto de indicadores
     */
    public function consultarDimensionesPorIdConjuntoIndicadores($idConjuntoIndicadores) {
        $dim = new Dimensiones();
        $resp = $dim->consultarDimensionesPorConjuntoIndicadores($idConjuntoIndicadores);
        return $resp;
    }

    /**
     * <b>consultarDimensionPorID</b>
     * <br>
     * Permite consultar toda la información de una dimensión, a partir de su ID
     * @param string $idDimension ID de la dimensión a consultar
     */
    public function consultarDimensionPorID($idDimension) {
        $dim = new Dimensiones();
        $resp = $dim->consultarDimensionPorId($idDimension);
        return $resp;
    }

}

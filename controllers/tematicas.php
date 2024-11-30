<?php

class TematicasController {

    public function consultarTematicasPorDimensionCaliController($idDimension) {
        $tem = new Tematicas();
        $resp = $tem->consultarTematicasSisPorDimensionCali($idDimension);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['nombreTematica'],
                "title" => $item['nombreTematica'],
                "value" => $item['idTematica'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function consultarTematicasPorDimensionComunasCorregimientosController($idDimension, $comunasCorregimientos) {
        $comunasCorr = json_decode($comunasCorregimientos);
        $options = array();
        for ($index = 0; $index < count($comunasCorr); $index++) {
            $zonaActual = $comunasCorr[$index][0];
            $tem = new Tematicas();
            $resp = $tem->consultarTematicasSisPorDimensionComunasCorregimientos($idDimension, $zonaActual);
            foreach ($resp as $row => $item) {
                if (!in_array(array("label" => $item['nombreTematica'],
                            "title" => $item['nombreTematica'],
                            "value" => $item['idTematica'],
                            "selected" => false), $options)) {
                    $options[] = array("label" => $item['nombreTematica'],
                        "title" => $item['nombreTematica'],
                        "value" => $item['idTematica'],
                        "selected" => false);
                }
            }
        }
        echo json_encode($options);
    }

    public function consultarTematicasPorDimensionComparativosController($idDimension) {
        $options = array();
        $tem = new Tematicas();
        $resp = $tem->consultarTematicasSisPorDimensionComparativos($idDimension);
        foreach ($resp as $row => $item) {
            if (!in_array(array("label" => $item['nombreTematica'],
                        "title" => $item['nombreTematica'],
                        "value" => $item['idTematica'],
                        "selected" => false), $options)) {
                $options[] = array("label" => $item['nombreTematica'],
                    "title" => $item['nombreTematica'],
                    "value" => $item['idTematica'],
                    "selected" => false);
            }
        }
        echo json_encode($options);
    }

    public function consultarTematicasPorDimensionGlobalesCiudadController($idDimension) {
        $tem = new Tematicas();
        $resp = $tem->consultarTematicasPorDimensionGlobalesCiudad($idDimension);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['nombreTematica'],
                "title" => $item['nombreTematica'],
                "value" => $item['idTematica'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function consultarTematicasPorDimensionExpedienteController($idDimension) {
        $tem = new Tematicas();
        $resp = $tem->consultarTematicasPorDimensionExpediente($idDimension);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['nombreTematica'],
                "title" => $item['nombreTematica'],
                "value" => $item['idTematica'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function consultarTematicasPorIdDimension($idDimension) {
        $tem = new Tematicas();
        $resp = $tem->consultarTematicasPorIdDimension($idDimension);
        return $resp;
    }

}

<?php

class SeriesDatosController {

    public function consultarDesagregacionesTematicasPorIndicadorYListadoDesagregacionesGeograficasController($idIndicador, $desagregacionesGeograficas) {
        $ser = new SeriesDatos();
        $desagregacionesGeograficasC = $desagregacionesGeograficas;
        $results = array();
        $count = sizeof($desagregacionesGeograficasC);
        $i = 0;
        while ($i < $count) {
            ${'array_' . $i} = array();
            foreach ($desagregacionesGeograficasC as $row => $item) {
                $resp = $ser->consultarDesagregacionesTematicasPorIndicadorYDesagregacionesGeograficas($idIndicador, $item);
                foreach ($resp as $row => $item) {
                    ${'array_' . $i}[] = trim($item['desagregacionTematica']);
                }
                $results[] = ${'array_' . $i};
                $i++;
            }
        }

        $desagregacionesTematicas = $results[0];
        for ($j = 0; $j < count($results); $j++) {
            $desagregacionesTematicas = array_intersect($desagregacionesTematicas, $results[$j]);
        }
        if (count($desagregacionesTematicas) < 1) {
            $desagregacionesTematicas = $results[0];
        }
        return $desagregacionesTematicas;
    }

    public function consultarDesagregacionesTematicasPorIndicadorYZonaGeograficaExpController($idIndicador, $zonaGeografica) {
        $ser = new SeriesDatos();
        $desagregacionesTematicas = array();
        $resp = $ser->consultarDesagregacionesTematicasPorIndicadorZonaGeografica($idIndicador, $zonaGeografica);
        foreach ($resp as $row => $item) {
            $desagregacionesTematicas[] = $item['desagregacionTematica'];
        }

        return $desagregacionesTematicas;
    }

    public function consultarDesagregacionesTematicasPorIndicadorDesagregacionesGeograficasYFuenteController($idIndicador, $desagregacionesGeograficas, $fuenteDatos) {
        $ser = new SeriesDatos();
        $desagregacionesGeograficasC = explode(",", $desagregacionesGeograficas);
        $results = array();
        $desagregacionesTematicas = array();
        $count = sizeof($desagregacionesGeograficasC);
        $i = 0;
        while ($i < $count) {
            ${'array_' . $i} = array();
            foreach ($desagregacionesGeograficasC as $row => $item) {
                $resp = $ser->consultarDesagregacionesTematicasPorIndicadorDesagregacionesGeograficasYFuente($idIndicador, $item, $fuenteDatos);
                foreach ($resp as $row => $item) {
                    ${'array_' . $i}[] = $item['desagregacionTematica'];
                }
                $results[] = ${'array_' . $i};
                $i++;
            }
        }
        $desagregacionesTematicas = $results[0];
        for ($j = 0; $j < count($results); $j++) {
            $desagregacionesTematicas = array_intersect($desagregacionesTematicas, $results[$j]);
        }

        $options = array();
        foreach ($desagregacionesTematicas as $row => $item) {
            $options[] = array("label" => $item,
                "title" => $item,
                "value" => $item,
                "selected" => false);
        }
        echo json_encode($options);
    }
    public function consultarDesagregacionesTematicasPorIndicadorYDesagregacionesGeograficasController($idIndicador, $desagregacionesGeograficas) {
        $ser = new SeriesDatos();
        $desagregacionesGeograficasC = explode(",", $desagregacionesGeograficas);
        $results = array();
        $desagregacionesTematicas = array();
        $count = sizeof($desagregacionesGeograficasC);
        $i = 0;
        while ($i < $count) {
            ${'array_' . $i} = array();
            foreach ($desagregacionesGeograficasC as $row => $item) {
                $resp = $ser->consultarDesagregacionesTematicasPorIndicadorYDesagregacionesGeograficas($idIndicador, $item);
                foreach ($resp as $row => $item) {
                    ${'array_' . $i}[] = $item['desagregacionTematica'];
                }
                $results[] = ${'array_' . $i};
                $i++;
            }
        }
        $desagregacionesTematicas = $results[0];
        for ($j = 0; $j < count($results); $j++) {
            $desagregacionesTematicas = array_intersect($desagregacionesTematicas, $results[$j]);
        }

        $options = array();
        foreach ($desagregacionesTematicas as $row => $item) {
            $options[] = array("label" => $item,
                "title" => $item,
                "value" => $item,
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function consultarDesagregacionesTematicasPorIndicadorYFuenteComunasCorregimientosController($idIndicador, $fuente) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarDesagregacionesTematicasPorIndicadorYFuenteComunasCorregimientos($idIndicador, $fuente);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['desagregacionTematica'],
                "title" => $item['desagregacionTematica'],
                "value" => $item['desagregacionTematica'],
                "selected" => true);
        }
        echo json_encode($options);
    }

    public function consultarDesagregacionesTematicasPorIndicadorYFuenteComparativosController($idIndicador, $fuente) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarDesagregacionesTematicasPorIndicadorYDesagregacionesGeograficas($idIndicador, $fuente);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['desagregacionTematica'],
                "title" => $item['desagregacionTematica'],
                "value" => $item['desagregacionTematica'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function consultarComunasCorregimientosPorSistemaIndicadoresController($idConjuntoIndicadores) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarComunasCorregimientosPorSistemaIndicadores($idConjuntoIndicadores);
        $options = array();
        $resp2 = array();
        foreach ($resp as $row => $item) {
            $resp2[] = $item['zonaGeografica'];
        }
        natcasesort($resp2);

        foreach ($resp2 as $row) {
            $options[] = array("label" => $row,
                "title" => $row,
                "value" => $row,
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function consultarDesagregacionesGeograficasIndicadorFuenteDesagregacionTematicaController($idIndicador, $fuente, $desagregacion) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarDesagregacionesGeograficasPorFuenteYDesagregacionComparativos($idIndicador, $fuente, $desagregacion);
        $options = array();
        $resp2 = array();
        foreach ($resp as $row => $item) {
            $resp2[] = $item['zonaGeografica'];
        }
        natcasesort($resp2);

        foreach ($resp2 as $row) {
            $options[] = array("label" => $row,
                "title" => $row,
                "value" => $row,
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function consultarDesagregacionesTematicasPorIndicadorYFuenteGlobalesCiudadController($idIndicador, $fuente) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarDesagregacionesTematicasPorIndicadorYFuenteGlobalesCiudad($idIndicador, $fuente);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['desagregacionTematica'],
                "title" => $item['desagregacionTematica'],
                "value" => $item['desagregacionTematica'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function consultarComunasCorregimientosPorIndicadorController($idIndicador) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarComunasCorregimientosPorIndicador($idIndicador);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['zonaGeografica'],
                "title" => $item['zonaGeografica'],
                "value" => $item['zonaGeografica'],
                "selected" => FALSE);
        }
        echo json_encode($options);
    }

    public function consultarDesagregacionesGeograficasPorIndicadorController($idIndicador) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarDesagregacionesGeograficasPorIndicador($idIndicador);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['zonaGeografica'],
                "title" => $item['zonaGeografica'],
                "value" => $item['zonaGeografica'],
                "selected" => false);
        }
        echo json_encode($options);
    }
  
    public function consultarDesagregacionesGeograficasPorIndicadorYFuenteController($idIndicador, $fuenteDatos) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarDesagregacionesGeograficasPorIndicadorYFuente($idIndicador, $fuenteDatos);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['zonaGeografica'],
                "title" => $item['zonaGeografica'],
                "value" => $item['zonaGeografica'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function consultarDesagregacionesGeograficasPorIndicadorTotalController($idIndicador) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarDesagregacionesGeograficasPorIndicadorTotal($idIndicador);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['zonaGeografica'],
                "title" => $item['zonaGeografica'],
                "value" => $item['zonaGeografica'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function consultarZonasComparativosPorIndicadorController($idIndicador) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarDesagregacionesGeograficasPorIndicador($idIndicador);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['zonaGeografica'],
                "title" => $item['zonaGeografica'],
                "value" => $item['zonaGeografica'],
                "selected" => true);
        }
        echo json_encode($options);
    }

    public function consultarGeografiasPorIndicadorExpedienteController($idIndicador) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarGeografiasPorIndicadorExpediente($idIndicador);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['tipoZonaGeografica'],
                "title" => $item['tipoZonaGeografica'],
                "value" => $item['tipoZonaGeografica'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function consultarZonaActualPorIndicadorExpedienteController($idIndicador, $tipoZonaGeografica) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarZonaActualPorIndicadorGeografiaExpediente($idIndicador, $tipoZonaGeografica);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['zonaGeografica'],
                "title" => $item['zonaGeografica'],
                "value" => $item['zonaGeografica'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function consultarDesagregacionesTematicasPorIndicadorTipoZonaGeograficaZonaGeograficaExpedienteController($idIndicador, $tipoZonaGeografica, $zonaGeografica) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarDesagregacionesTematicasPorIndicadorTipoZonaZonaExp($idIndicador, $tipoZonaGeografica, $zonaGeografica);
        return $resp;
    }

    public function consultarDesagregacionesTematicasPorIndicadorExpedienteController($idIndicador, $tipoZonaGeografica, $zonaGeografica) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarDesagregacionesTematicasPorIndicadorTipoZonaZonaExp($idIndicador, $tipoZonaGeografica, $zonaGeografica);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['desagregacionTematica'],
                "title" => $item['desagregacionTematica'],
                "value" => $item['desagregacionTematica'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function consultarDesagregacionesTematicasPorIndicadorYDesagregacionGeograficaExpedienteController($idIndicador, $desagregacionGeografica) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarDesagregacionesTematicasPorIndicadorYDesagregacionGeograficaExpediente($idIndicador, $desagregacionGeografica);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['desagregacionTematica'],
                "title" => $item['desagregacionTematica'],
                "value" => $item['desagregacionTematica'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function consultarFuentesPorIndicadorGlobalesCiudadController($idIndicador) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarFuentesPorIndicadorGlobalesCiudad($idIndicador);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['fuenteDatos'],
                "title" => $item['fuenteDatos'],
                "value" => $item['fuenteDatos'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function consultarDesagregacionesGeograficasPorIdIndicadorController($idIndicador) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarDesagregacionesGeograficasPorIndicador($idIndicador);
        return $resp;
    }
    
    public function consultarFuentesPorIdIndicadorDiferenteComunasFiltroController($idIndicador) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarFuentesPorIndicadorDiferenteComunas($idIndicador);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['fuenteDatos'],
                "title" => $item['fuenteDatos'],
                "value" => $item['fuenteDatos'],
                "selected" => false);
        }
        echo json_encode($options);
    }
    
    public function consultarFuentesPorIdIndicadorDiferenteComunasController($idIndicador) {
        $ser = new SeriesDatos();
        $resp = $ser->consultarFuentesPorIndicadorDiferenteComunas($idIndicador);
        return $resp;
    }

}

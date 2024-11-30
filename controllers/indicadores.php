<?php

/**
 * <b>IndicadoresController</b>
 * Se encuentran las consultas necesarias para visualizar toda la información
 * asociada a los indicadores de cada uno de los conjuntos de indicadores
 */
class IndicadoresController {

    /**
     * <b>contadorConsultasIndicadores</b>
     * <br>
     * Permite almacenar el numero de consulta para cada indicador
     * @param string $idTematica ID de la temática a consultar
     */
    public function contadorConsultasIndicadores($idIndicador) {
        $ind = new Indicadores();
        $resp = $ind->consultarIndicadorPorId($idIndicador);
        $contador = $resp['numeroConsultas']+1;
        $ind->adicionarNumeroDeVisita($idIndicador,$contador);
    }

    /**
     * <b>consultarIndicadoresActivosPorIdTematicaController</b>
     * <br>
     * Permite consultar los indicadores que pertenecen a una temática
     * @param string $idTematica ID de la temática a consultar
     */
    public function consultarIndicadoresActivosPorIdTematicaController($idTematica) {
        $ind = new Indicadores();
        $resp = $ind->consultarIndicadoresActivosPorIdTematica($idTematica);
        return $resp;
    }

    /**
     * <b>consultarInformacionEnlacePorIdIndicadorCategoriaController</b>
     * <br>
     * Permite consultar los parámetros para construir en enlace de 
     * consulta de un indicador
     * @param string $idIndicador ID del indicador a consultar
     * @param string $categoria Categoría de la consulta a realizar
     */
    public function consultarInformacionEnlacePorIdIndicadorCategoriaController($idIndicador, $categoria) {
        $ind = new Indicadores();
        $resp = $ind->consultarInformacionEnlacePorIdIndicadorYGeografia($idIndicador, $categoria);
        return $resp;
    }

    /**
     * <b>listarIndicadoresDadii</b>
     * <br>
     * Permite consultar los indicadores disponibles dentro del conjunto de
     * indicadores de desempeño institucional
     * @param string $idConjunto ID del conjunto de indicadores a consultar
     */
    public function listarIndicadoresDadii($idConjunto) {
        $ind = new Indicadores();
        $resp = $ind->listarIndicadoresDadii($idConjunto);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['nombreIndicador'],
                "title" => $item['nombreIndicador'],
                "value" => $item['idIndicador'],
                "selected" => false);
        }
        echo json_encode($options);
    }

}

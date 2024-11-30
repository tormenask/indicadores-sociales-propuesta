<?php

require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/fichaTecnica.php';
require_once '../../../../model/fichaTecnica.php';
require_once '../../../../controller/indicador.php';
require_once '../../../../model/indicador.php';
require_once '../../../../controller/tematica.php';
require_once '../../../../model/tematica.php';
require_once '../../../../controller/dimension.php';
require_once '../../../../model/dimension.php';

class FuncionesFichas {

    public $idConjuntoIndicadores, $idIndicador, $sigla, $justificacion, $definicion, $metodosMedicion, $formulas, $variables, $valoresReferencia, $naturaleza, $desagregacionTematica, $desagregacionGeografica, $lineaBase, $responsable, $observaciones, $fechaElaboracion, $tipoGrafico;
    public $idFichaEd, $idConjuntoIndicadoresEd, $idIndicadorEd, $siglaEd, $justificacionEd, $definicionEd, $metodosMedicionEd, $formulasEd, $variablesEd, $valoresReferenciaEd, $naturalezaEd, $desagregacionTematicaEd, $desagregacionGeograficaEd, $lineaBaseEd, $responsableEd, $observacionesEd, $fechaElaboracionEd, $tipoGraficoEd;
    public $idFichaIGCEd, $idIndicadorIGC, $justificacionIGC, $definicionIGC, $metodologiaIGC, $referenciaIGC, $observacionesLimitacionesIGC, $otrasOrganizacionesIGC, $tipoGraficoIGC;
    public $idIndicadorIGCEd, $justificacionIGCEd, $definicionIGCEd, $metodologiaIGCEd, $referenciaIGCEd, $observacionesLimitacionesIGCEd, $otrasOrganizacionesIGCEd, $tipoGraficoIGCEd;
    public $idConjuntoIndicadoresEl, $idFichaEl;

    public function crearFichaIGC() {
        $resp = new FichaTecnicaController();
        $ret = $resp->crearFichaIGC("IGC", $this->justificacionIGC, $this->definicionIGC, $this->metodologiaIGC, $this->referenciaIGC, $this->observacionesLimitacionesIGC, $this->otrasOrganizacionesIGC, $this->idIndicadorIGC, $this->tipoGraficoIGC);
        echo $ret;
    }

    public function crearFicha() {
        $resp = new FichaTecnicaController();
        $ret = $resp->crearFicha($this->idConjuntoIndicadores, $this->sigla, $this->justificacion, $this->definicion, $this->metodosMedicion, $this->formulas, $this->variables, $this->valoresReferencia, $this->naturaleza, $this->desagregacionTematica, $this->desagregacionGeografica, $this->lineaBase, $this->responsable, $this->observaciones, $this->fechaElaboracion, $this->idIndicador, $this->tipoGrafico);
        echo $ret;
    }

    public function editarFichaIGC() {
        $resp = new FichaTecnicaController();
        $ret = $resp->editarFichaIGC($this->idFichaIGCEd, 'IGC', $this->justificacionIGCEd, $this->definicionIGCEd, $this->metodologiaIGCEd, $this->referenciaIGCEd, $this->observacionesLimitacionesIGCEd, $this->otrasOrganizacionesIGCEd, $this->idIndicadorIGCEd);
        echo $ret;
    }

    public function editarFicha() {
        $resp = new FichaTecnicaController();
        $ret = $resp->editarFicha($this->idFichaEd, $this->idConjuntoIndicadoresEd, $this->siglaEd, $this->justificacionEd, $this->definicionEd, $this->metodosMedicionEd, $this->formulasEd, $this->variablesEd, $this->valoresReferenciaEd, $this->naturalezaEd, $this->desagregacionTematicaEd, $this->desagregacionGeograficaEd, $this->lineaBaseEd, $this->responsableEd, $this->observacionesEd, $this->fechaElaboracionEd, $this->idIndicadorEd, $this->tipoGraficoEd);
        echo $ret;
    }

    public function eliminarFicha() {
        $resp = new FichaTecnicaController();
        $ret = $resp->eliminarFicha($this->idConjuntoIndicadoresEl, $this->idFichaEl);
        echo $ret;
    }

}

if (isset($_POST['justificacionFichaIGC']) && isset($_POST['definicionFichaIGC']) &&
        isset($_POST['metodologiaFichaIGC']) && isset($_POST['referenciaFichaIGC']) &&
        isset($_POST['observacionesLimitacionesFichaIGC']) && isset($_POST['otrasOrganizacionesFichaIGC']) &&
        isset($_POST['indicadorFichaIGC']) && isset($_POST['tipoGraficoFichaIGC'])) {
    $fichaIGC = new FuncionesFichas();
    $fichaIGC->justificacionIGC = $_POST['justificacionFichaIGC'];
    $fichaIGC->definicionIGC = $_POST['definicionFichaIGC'];
    $fichaIGC->metodologiaIGC = $_POST['metodologiaFichaIGC'];
    $fichaIGC->referenciaIGC = $_POST['referenciaFichaIGC'];
    $fichaIGC->observacionesLimitacionesIGC = $_POST['observacionesLimitacionesFichaIGC'];
    $fichaIGC->otrasOrganizacionesIGC = $_POST['otrasOrganizacionesFichaIGC'];
    $fichaIGC->idIndicadorIGC = $_POST['indicadorFichaIGC'];
    $fichaIGC->tipoGraficoIGC = $_POST['tipoGraficoFichaIGC'];
    $fichaIGC->crearFichaIGC();
}
if (isset($_POST['idFichaIGCEd']) &&
        isset($_POST['justificacionFichaIGCEd']) && isset($_POST['definicionFichaIGCEd']) &&
        isset($_POST['metodologiaFichaIGCEd']) && isset($_POST['referenciaFichaIGCEd']) &&
        isset($_POST['observacionesLimitacionesFichaIGCEd']) && isset($_POST['otrasOrganizacionesFichaIGCEd']) &&
        isset($_POST['indicadorFichaIGCEd']) && isset($_POST['tipoGraficoFichaIGCEd'])) {
    $fichaIGCEd = new FuncionesFichas();
    $fichaIGCEd->idFichaIGCEd = $_POST['idFichaIGCEd'];
    $fichaIGCEd->justificacionIGCEd = $_POST['justificacionFichaIGCEd'];
    $fichaIGCEd->definicionIGCEd = $_POST['definicionFichaIGCEd'];
    $fichaIGCEd->metodologiaIGCEd = $_POST['metodologiaFichaIGCEd'];
    $fichaIGCEd->referenciaIGCEd = $_POST['referenciaFichaIGCEd'];
    $fichaIGCEd->observacionesLimitacionesIGCEd = $_POST['observacionesLimitacionesFichaIGCEd'];
    $fichaIGCEd->otrasOrganizacionesIGCEd = $_POST['otrasOrganizacionesFichaIGCEd'];
    $fichaIGCEd->idIndicadorIGCEd = $_POST['indicadorFichaIGCEd'];
    $fichaIGCEd->tipoGraficoIGCEd = $_POST['tipoGraficoFichaIGCEd'];
    $fichaIGCEd->editarFichaIGC();
}
if (
        isset($_POST['conjuntoIndicadoresFicha']) &&
        isset($_POST['siglaFicha']) && isset($_POST['justificacionFicha']) &&
        isset($_POST['definicionFicha']) && isset($_POST['metodosMedicionFicha']) &&
        isset($_POST['formulasFicha']) && isset($_POST['variablesFicha']) &&
        isset($_POST['valoresReferenciaFicha']) && isset($_POST['naturalezaFicha']) &&
        isset($_POST['desagregacionTematicaFicha']) && isset($_POST['desagregacionGeograficaFicha']) &&
        isset($_POST['lineaBaseFicha']) && isset($_POST['responsableFicha']) &&
        isset($_POST['observacionesFicha']) && isset($_POST['fechaElaboracionFicha']) &&
        isset($_POST['indicadorFicha']) && isset($_POST['tipoGraficoFicha'])
) {

    $ficha = new FuncionesFichas();
    $ficha->idConjuntoIndicadores = $_POST['conjuntoIndicadoresFicha'];
    $ficha->sigla = $_POST['siglaFicha'];
    $ficha->justificacion = $_POST['justificacionFicha'];
    $ficha->definicion = $_POST['definicionFicha'];
    $ficha->metodosMedicion = $_POST['metodosMedicionFicha'];
    $ficha->formulas = $_POST['formulasFicha'];
    $ficha->variables = $_POST['variablesFicha'];
    $ficha->valoresReferencia = $_POST['valoresReferenciaFicha'];
    $ficha->naturaleza = $_POST['naturalezaFicha'];
    $ficha->desagregacionTematica = $_POST['desagregacionTematicaFicha'];
    $ficha->desagregacionGeografica = $_POST['desagregacionGeograficaFicha'];
    $ficha->lineaBase = $_POST['lineaBaseFicha'];
    $ficha->responsable = $_POST['responsableFicha'];
    $ficha->observaciones = $_POST['observacionesFicha'];
    $ficha->fechaElaboracion = $_POST['fechaElaboracionFicha'];
    $ficha->idIndicador = $_POST['indicadorFicha'];
    $ficha->tipoGrafico = $_POST['tipoGraficoFicha'];
    $ficha->crearFicha();
}
if (isset($_POST["idFichaEd"]) && isset($_POST['conjuntoIndicadoresFichaEd']) &&
        isset($_POST['siglaFichaEd']) && isset($_POST['justificacionFichaEd']) &&
        isset($_POST['definicionFichaEd']) && isset($_POST['metodosMedicionFichaEd']) &&
        isset($_POST['formulasFichaEd']) && isset($_POST['variablesFichaEd']) &&
        isset($_POST['valoresReferenciaFichaEd']) && isset($_POST['naturalezaFichaEd']) &&
        isset($_POST['desagregacionTematicaFichaEd']) && isset($_POST['desagregacionGeograficaFichaEd']) &&
        isset($_POST['lineaBaseFichaEd']) && isset($_POST['responsableFichaEd']) &&
        isset($_POST['observacionesFichaEd']) && isset($_POST['fechaElaboracionFichaEd']) &&
        isset($_POST['indicadorFichaEd']) && isset($_POST['tipoGraficoFichaEd'])) {
    $fichaEd = new FuncionesFichas();
    $fichaEd->idFichaEd = $_POST['idFichaEd'];
    $fichaEd->idConjuntoIndicadoresEd = $_POST['conjuntoIndicadoresFichaEd'];
    $fichaEd->siglaEd = $_POST['siglaFichaEd'];
    $fichaEd->justificacionEd = $_POST['justificacionFichaEd'];
    $fichaEd->definicionEd = $_POST['definicionFichaEd'];
    $fichaEd->metodosMedicionEd = $_POST['metodosMedicionFichaEd'];
    $fichaEd->formulasEd = $_POST['formulasFichaEd'];
    $fichaEd->variablesEd = $_POST['variablesFichaEd'];
    $fichaEd->valoresReferenciaEd = $_POST['valoresReferenciaFichaEd'];
    $fichaEd->naturalezaEd = $_POST['naturalezaFichaEd'];
    $fichaEd->desagregacionTematicaEd = $_POST['desagregacionTematicaFichaEd'];
    $fichaEd->desagregacionGeograficaEd = $_POST['desagregacionGeograficaFichaEd'];
    $fichaEd->lineaBaseEd = $_POST['lineaBaseFichaEd'];
    $fichaEd->responsableEd = $_POST['responsableFichaEd'];
    $fichaEd->observacionesEd = $_POST['observacionesFichaEd'];
    $fichaEd->fechaElaboracionEd = $_POST['fechaElaboracionFichaEd'];
    $fichaEd->idIndicadorEd = $_POST['indicadorFichaEd'];
    $fichaEd->tipoGraficoEd = $_POST['tipoGraficoFichaEd'];
    $fichaEd->editarFicha();
}

if (isset($_POST['idFichaEl']) && isset($_POST['conjuntoIndicadoresFichaEl'])) {
    $fichaEl = new FuncionesFichas();
    $fichaEl->idFichaEl = $_POST['idFichaEl'];
    $fichaEl->idConjuntoIndicadoresEl = $_POST['conjuntoIndicadoresFichaEl'];
    $fichaEl->eliminarFicha();
}



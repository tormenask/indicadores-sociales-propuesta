<?php

require_once 'connection.php';

class FichaTecnica extends Connection {

    public function crearFicha($idFichaTecnica, $sigla, $justificacion, $definicion, $metodosMedicion, $formulas, $variables, $valoresReferencia, $naturaleza, $desagregacionTematica, $desagregacionGeografica, $lineaBase, $responsable, $observaciones, $fechaElaboracion, $idIndicador, $tipoGrafico, $fuenteDatos) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO fichatecnica '
                . 'VALUES(:idFichaTecnica, :sigla,:justificacion, '
                . ':definicion, :metodosMedicion, :formulas, :variables,'
                . ':valoresReferencia, :naturaleza, :desagregacionTematica, '
                . ':desagregacionGeografica, :lineaBase, :responsable, '
                . ':observaciones, :fechaElaboracion, :idIndicador, '
                . ':tipoGrafico, :fuenteDatos)');
        $stmt->bindValue(':idFichaTecnica', $idFichaTecnica);
        $stmt->bindValue(':sigla', $sigla);
        $stmt->bindValue(':justificacion', $justificacion);
        $stmt->bindValue(':definicion', $definicion);
        $stmt->bindValue(':metodosMedicion', $metodosMedicion);
        $stmt->bindValue(':formulas', $formulas);
        $stmt->bindValue(':variables', $variables);
        $stmt->bindValue(':valoresReferencia', $valoresReferencia);
        $stmt->bindValue(':naturaleza', $naturaleza);
        $stmt->bindValue(':desagregacionTematica', $desagregacionTematica);
        $stmt->bindValue(':desagregacionGeografica', $desagregacionGeografica);
        $stmt->bindValue(':lineaBase', $lineaBase);
        $stmt->bindValue(':responsable', $responsable);
        $stmt->bindValue(':observaciones', $observaciones);
        $stmt->bindValue(':fechaElaboracion', $fechaElaboracion);
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->bindValue(':tipoGrafico', $tipoGrafico);
        $stmt->bindValue(':fuenteDatos', $fuenteDatos);
        if ($stmt->execute()) {
            return "Creada";
        } else {
            return "Error al crear la ficha";
        }
    }

    public function crearFichaIGC($idFichaTecnica, $justificacion, $definicion, $metodologia, $referencia, $observacionesLimitaciones, $otrasOrganizaciones, $idIndicador, $tipoGrafico) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO fichatecnicaigc '
                . 'VALUES(:idFichaTecnicaIGC, :justificacion, '
                . ':definicion, :metodologia, :referencia, :observacionesLimitaciones, '
                . ':otrasOrganizaciones, :idIndicador, :tipoGrafico)');
        $stmt->bindValue(':idFichaTecnicaIGC', $idFichaTecnica);
        $stmt->bindValue(':justificacion', $justificacion);
        $stmt->bindValue(':definicion', $definicion);
        $stmt->bindValue(':metodologia', $metodologia);
        $stmt->bindValue(':referencia', $referencia);
        $stmt->bindValue(':observacionesLimitaciones', $observacionesLimitaciones);
        $stmt->bindValue(':otrasOrganizaciones', $otrasOrganizaciones);
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->bindValue(':tipoGrafico', $tipoGrafico);
        if ($stmt->execute()) {
            return "Creada";
        } else {
            return "Error al crear la ficha";
        }
    }

    public function listarFichas() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM fichatecnica");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarFichasPorConjunto($idConjuntoIndicadores) {
        $stmt = "";
        if ($idConjuntoIndicadores == "IGC") {
            $stmt = Connection::connect()->prepare(""
                    . "SELECT * FROM fichatecnicaigc, indicadores, tematicas, dimensiones "
                    . "WHERE fichatecnicaigc.idIndicador = indicadores.idIndicador "
                    . "AND indicadores.idTematica = tematicas.idTematica "
                    . "AND tematicas.idDimension = dimensiones.idDimension "
                    . "AND dimensiones.idConjuntoIndicadores = 'IGC'");
            $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        } else {
            $stmt = Connection::connect()->prepare(""
                    . "SELECT * FROM fichatecnica, indicadores, tematicas, dimensiones "
                    . "WHERE fichatecnica.idIndicador = indicadores.idIndicador "
                    . "AND indicadores.idTematica = tematicas.idTematica "
                    . "AND tematicas.idDimension = dimensiones.idDimension "
                    . "AND dimensiones.idConjuntoIndicadores = :idConjuntoIndicadores");
            $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarFicha($idConjuntoIndicadores, $idFichaTecnica) {
        $conj = "fichatecnica";
        if ($idConjuntoIndicadores === "IGC") {
            $conj = "fichatecnicaigc";
        }
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM " . $conj . " "
                . "WHERE id" . $conj . " = :idFichaTecnica");
        $stmt->bindParam(":idFichaTecnica", $idFichaTecnica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function idFichaExiste($idConjuntoIndicadores, $idFichaTecnica) {
        $conj = "fichatecnica";
        if ($idConjuntoIndicadores === "IGC") {
            $conj = "fichatecnicaigc";
        }
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM " . $conj . " "
                . "WHERE id" . $conj . " = :idFichaTecnica");
        $stmt->bindParam(":idFichaTecnica", $idFichaTecnica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function fichaExisteIndicador($idConjuntoIndicadores, $idIndicador) {
        $conj = "fichatecnica";
        if ($idConjuntoIndicadores === "IGC") {
            $conj = "fichatecnicaigc";
        }
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM " . $conj . " "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function fichaExisteIndicadorFuente($idConjuntoIndicadores, $idIndicador, $fuenteDatos) {
        $conj = "fichatecnica";
        if ($idConjuntoIndicadores === "IGC") {
            $conj = "fichatecnicaigc";
        }
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM " . $conj . " "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuenteDatos, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function fichaTecnicaExisParaIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM fichatecnica "
                . "WHERE idIndicador = :idIndicador ");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function editarFicha($idFichaTecnica, $sigla, $justificacion, $definicion, $metodosMedicion, $formulas, $variables, $valoresReferencia, $naturaleza, $desagregacionTematica, $desagregacionGeografica, $lineaBase, $responsable, $observaciones, $fechaElaboracion, $idIndicador, $tipoGrafico) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE fichatecnica '
                . 'SET sigla = :sigla , '
                . 'justificacion = :justificacion, '
                . 'definicion = :definicion, '
                . 'metodosMedicion = :metodosMedicion, '
                . 'formulas = :formulas, '
                . 'variables = :variables, '
                . 'valoresReferencia = :valoresReferencia, '
                . 'naturaleza = :naturaleza, '
                . 'desagregacionTematica = :desagregacionTematica, '
                . 'desagregacionGeografica = :desagregacionGeografica, '
                . 'lineaBase = :lineaBase, '
                . 'responsable = :responsable, '
                . 'observaciones= :observaciones, '
                . 'fechaElaboracion = :fechaElaboracion, '
                . 'tipoGrafico = :tipoGrafico '
                . 'WHERE idFichaTecnica = :idFichaTecnica');
        $stmt->bindValue(':sigla', $sigla);
        $stmt->bindValue(':justificacion', $justificacion);
        $stmt->bindValue(':definicion', $definicion);
        $stmt->bindValue(':metodosMedicion', $metodosMedicion);
        $stmt->bindValue(':formulas', $formulas);
        $stmt->bindValue(':variables', $variables);
        $stmt->bindValue(':valoresReferencia', $valoresReferencia);
        $stmt->bindValue(':naturaleza', $naturaleza);
        $stmt->bindValue(':desagregacionTematica', $desagregacionTematica);
        $stmt->bindValue(':desagregacionGeografica', $desagregacionGeografica);
        $stmt->bindValue(':lineaBase', $lineaBase);
        $stmt->bindValue(':responsable', $responsable);
        $stmt->bindValue(':observaciones', $observaciones);
        $stmt->bindValue(':fechaElaboracion', $fechaElaboracion);
        $stmt->bindValue(':tipoGrafico', $tipoGrafico);
        $stmt->bindValue(':idFichaTecnica', $idFichaTecnica);
        if ($stmt->execute()) {
            return "Editada";
        } else {
            return "Error al editar la ficha";
        }
    }

    public function editarFichaIGC($idFichaTecnica, $justificacion, $definicion, $metodologia, $referencia, $observacionesLimitaciones, $otrasOrganizaciones) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE fichatecnicaigc '
                . 'SET justificacion = :justificacion, '
                . 'definicion = :definicion, '
                . 'metodologia = :metodologia, '
                . 'referencia = :referencia, '
                . 'observacionesLimitaciones = :observacionesLimitaciones, '
                . 'otrasOrganizaciones = :otrasOrganizaciones '
                . 'WHERE idFichaTecnicaIGC = :idFichaTecnicaIGC');
        $stmt->bindValue(':justificacion', $justificacion);
        $stmt->bindValue(':definicion', $definicion);
        $stmt->bindValue(':metodologia', $metodologia);
        $stmt->bindValue(':referencia', $referencia);
        $stmt->bindValue(':observacionesLimitaciones', $observacionesLimitaciones);
        $stmt->bindValue(':otrasOrganizaciones', $otrasOrganizaciones);
        $stmt->bindValue(':idFichaTecnicaIGC', $idFichaTecnica);
        if ($stmt->execute()) {
            return "Editada";
        } else {
            return "Error al editar la ficha";
        }
    }

    public function eliminarFicha($idConjuntoIndicadores, $idFichaTecnica) {
        $conj = "fichatecnica";
        if ($idConjuntoIndicadores === "IGC") {
            $conj = "fichatecnicaigc";
        }
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM ' . $conj . ' '
                . 'WHERE id' . $conj . ' = :idFichaTecnica');
        $stmt->bindValue(':idFichaTecnica', $idFichaTecnica);
        if ($stmt->execute()) {
            return "Eliminada";
        } else {
            return $stmt->errorInfo()[1];
        }
    }

}

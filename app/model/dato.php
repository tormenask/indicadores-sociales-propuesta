<?php

require_once 'connection.php';

class Dato extends Connection {

    public function crearDato($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idSerieDatos) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO datos '
                . 'VALUES(:idDato, :fechaDato, :valorDato, :idSerieDatos, :estadoObservacionDato)');
        $stmt->bindValue(':idDato', $idDato);
        $stmt->bindValue(':fechaDato', $fechaDato);
        $stmt->bindValue(':valorDato', $valorDato);
        $stmt->bindValue(':idSerieDatos', $idSerieDatos);
        $stmt->bindValue(':estadoObservacionDato', $estadoObservacionDato);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear el dato";
        }
    }

    public function listarDatos() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM datos");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarDatosPorConjunto($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM datos, seriedatos, indicadores, tematicas, dimensiones "
                . "WHERE datos.idSerieDatos = seriedatos.idSerieDatos "
                . "AND seriedatos.idIndicador = indicadores.idIndicador "
                . "AND indicadores.idTematica = tematicas.idTematica "
                . "AND tematicas.idDimension = dimensiones.idDimension "
                . "AND dimensiones.idConjuntoIndicadores = :idConjuntoIndicadores");
        $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarDatosPorIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT datos.idDato, datos.fechaDato, datos.valorDato, datos.estadoObservacionDato, seriedatos.tipoZonaGeografica, seriedatos.zonaGeografica "
                . "FROM datos, seriedatos "
                . "WHERE datos.idSerieDatos = seriedatos.idSerieDatos "
                . "AND seriedatos.idIndicador = :idIndicador");
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarDatosPorIdSerie($idSerieDatos) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM datos "
                . "WHERE idSerieDatos = :idSerieDatos "
                . "ORDER BY fechaDato ASC");
        $stmt->bindValue(':idSerieDatos', $idSerieDatos);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function existeDato($idSerieDatos, $fechaDato) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM datos "
                . "WHERE idSerieDatos = :idSerieDatos "
                . "AND fechaDato = :fechaDato");
        $stmt->bindParam(":idSerieDatos", $idSerieDatos, PDO::PARAM_STR);
        $stmt->bindParam(":fechaDato", $fechaDato, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function editarDato($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idSerieDatos) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE datos '
                . 'SET valorDato = :valorDato, '
                . 'estadoObservacionDato = :estadoObservacionDato '
                . 'WHERE datos.idDato = :idDato '
                . 'AND datos.fechaDato = :fechaDato '
                . 'AND datos.idSerieDatos = :idSerieDatos');
        $stmt->bindValue(':valorDato', $valorDato);
        $stmt->bindValue(':estadoObservacionDato', $estadoObservacionDato);
        $stmt->bindValue(':idDato', $idDato);
        $stmt->bindValue(':fechaDato', $fechaDato);
        $stmt->bindValue(':idSerieDatos', $idSerieDatos);
        if ($stmt->execute()) {
            return "Editado";
        } else {
            return "Error al editar el dato";
        }
    }

    public function eliminarDato($idDato, $fechaDato, $idSerieDatos) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM datos '
                . 'WHERE datos.idDato = :idDato '
                . 'AND datos.fechaDato = :fechaDato '
                . 'AND datos.idSerieDatos = :idSerieDatos');
        $stmt->bindValue(':idDato', $idDato);
        $stmt->bindValue(':fechaDato', $fechaDato);
        $stmt->bindValue(':idSerieDatos', $idSerieDatos);
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return "Error al eliminar el dato";
        }
    }
}
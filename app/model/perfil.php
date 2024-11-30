<?php

require_once 'connection.php';

class Perfil extends Connection {

    public function estadoDeGuardado($idIndicadorGuardar,$tipoZonaGeograficaGuardar) {
        var_dump($idIndicadorGuardar,$idIndicadorGuardar);
        if($tipoZonaGeograficaGuardar == "Cali"){
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE indicadores '
                . 'SET cali = 1 '
                . 'WHERE idIndicador = :idIndicador'
        );
        $stmt->bindValue(':idIndicador', $idIndicadorGuardar);}
        elseif($tipoZonaGeograficaGuardar =="Comunas"){
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE indicadores '
                . 'SET comuna = :comuna '
                . 'WHERE idIndicador = :idIndicador'
        );
        $stmt->bindValue(':comuna', '1');
        $stmt->bindValue(':idIndicador', $idIndicadorGuardar);}
        elseif($tipoZonaGeograficaGuardar=="Corregimientos"){
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE indicadores '
                . 'SET corregimiento = :corregimiento '
                . 'WHERE idIndicador = :idIndicador'
        );
        $stmt->bindValue(':corregimiento', '1');
        $stmt->bindValue(':idIndicador', $idIndicadorGuardar);}
        var_dump($stmt);
        if ($stmt->execute()) {
            return "Editada";
        } else {
            var_dump($stmt->errorInfo());
            return "Error al actualizar el estado";
        }
    }

      public function volverEstado($idIndicadorDesguardar,$tipoZonaGeograficaDesguardar) {
        if($tipoZonaGeograficaDesguardar=="Cali"){
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE indicadores '
                . 'SET cali = :cali '
                . 'WHERE idIndicador = :idIndicador'
        );
        $stmt->bindValue(':cali', '0');
        $stmt->bindValue(':idIndicador', $idIndicadorDesguardar);}
        elseif($tipoZonaGeograficaDesguardar=="Comunas"){
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE indicadores '
                . 'SET comuna = :comuna '
                . 'WHERE idIndicador = :idIndicador'
        );
        $stmt->bindValue(':comuna', '0');
        $stmt->bindValue(':idIndicador', $idIndicadorDesguardar);}
        elseif($tipoZonaGeograficaDesguardar=="Corregimientos"){
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE indicadores '
                . 'SET corregimiento = :corregimiento '
                . 'WHERE idIndicador = :idIndicador'
        );
        $stmt->bindValue(':corregimiento', '0');
        $stmt->bindValue(':idIndicador', $idIndicadorDesguardar);}
        var_dump($stmt);
        if ($stmt->execute()) {
            return "Editada";
        } else {
            var_dump($stmt->errorInfo());
            return "Error al actualizar el estado";
        }
    }
    
    public function listarDatosPorZonaGeograficaCali($tipoZonaGeograficaCali) {

        if ($tipoZonaGeograficaCali == "Cali") {
            $stmt = Connection::connect()->prepare(""
                    . "SELECT * "
                    . "FROM "
                    . "(SELECT indicadores.cali, indicadores.comuna,indicadores.corregimiento,  seriedatos.unidadMedida, seriedatos.fuenteDatos,tematicas.nombreTematica, indicadores.nombreIndicador, dimensiones.nombreDimension, datos.fechaDato, datos.valorDato, seriedatos.zonaGeografica, dimensiones.idDimension, tematicas.idTematica, indicadores.idIndicador, seriedatos.idSerieDatos, datos.idDato  "
                    . "FROM  datos as datos, seriedatos as seriedatos, indicadores as indicadores, tematicas as tematicas, dimensiones as dimensiones "
                    . "WHERE seriedatos.tipoZonaGeografica = 'Municipal' "
                    . "AND seriedatos.zonaGeografica = 'Cali' "
                    . "AND datos.idSerieDatos = seriedatos.idSerieDatos "
                    . "AND seriedatos.idIndicador = indicadores.idIndicador "
                    . "AND indicadores.idTematica = tematicas.idTematica "
                    . "AND tematicas.idDimension = dimensiones.idDimension "
                    . "ORDER by datos.idDato desc) "
                    . "AS maintable "
                    . "GROUP BY idSerieDatos "
                    . "ORDER BY `maintable`.`idIndicador` DESC"
            );
        } elseif ($tipoZonaGeograficaCali == "Comunas") {
            $stmt = Connection::connect()->prepare(""
                    . "SELECT * "
                    . "FROM "
                    . "(SELECT indicadores.cali, indicadores.comuna,indicadores.corregimiento, seriedatos.unidadMedida, seriedatos.fuenteDatos, indicadores.nombreIndicador, dimensiones.nombreDimension, datos.fechaDato,tematicas.nombreTematica, datos.valorDato, seriedatos.zonaGeografica, dimensiones.idDimension, tematicas.idTematica, indicadores.idIndicador, seriedatos.idSerieDatos, datos.idDato "
                    . "FROM datos as datos, seriedatos as seriedatos, indicadores as indicadores, tematicas as tematicas, dimensiones as dimensiones "
                    . "WHERE seriedatos.tipoZonaGeografica = 'Comuna' AND datos.idSerieDatos = seriedatos.idSerieDatos "
                    . "AND seriedatos.idIndicador = indicadores.idIndicador "
                    . "AND indicadores.idTematica = tematicas.idTematica "
                    . "AND tematicas.idDimension = dimensiones.idDimension "
                    . "ORDER by datos.idDato DESC) "
                    . "AS maintable "
                    . "GROUP BY idSerieDatos "
                    . "ORDER BY `maintable`.`idIndicador` DESC"
            );
        } elseif ($tipoZonaGeograficaCali == "Corregimientos") {
            $stmt = Connection::connect()->prepare(""
                    . "SELECT * "
                    . "FROM "
                    . "(SELECT indicadores.cali, indicadores.comuna,indicadores.corregimiento, seriedatos.unidadMedida, seriedatos.fuenteDatos, indicadores.nombreIndicador, dimensiones.nombreDimension, datos.fechaDato,tematicas.nombreTematica, datos.valorDato, seriedatos.zonaGeografica, dimensiones.idDimension, tematicas.idTematica, indicadores.idIndicador, seriedatos.idSerieDatos, datos.idDato "
                    . "FROM datos as datos, seriedatos as seriedatos, indicadores as indicadores, tematicas as tematicas, dimensiones as dimensiones "
                    . "WHERE seriedatos.tipoZonaGeografica = 'Corregimiento' "
                    . "AND datos.idSerieDatos = seriedatos.idSerieDatos "
                    . "AND seriedatos.idIndicador = indicadores.idIndicador "
                    . "AND indicadores.idTematica = tematicas.idTematica "
                    . "AND tematicas.idDimension = dimensiones.idDimension "
                    . "ORDER by datos.idDato DESC) "
                    . "AS maintable "
                    . "GROUP BY idSerieDatos "
                    . "ORDER BY `maintable`.`idIndicador` DESC"
            );
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function crearDatoPerfil($idDato, $zonaGeografica, $fechaDato, $valorDato, $posicion, $dimension, $indicador, $unidadMedicion, $fuenteDatos) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO perfilescomunas '
                . 'VALUES(:idDato, :nombreDimension, :nombreIndicador, :fechaDato, '
                . ':valorDato, :zonaActual, :fuenteDatos, :unidadMedicion, :posicion)');
        $stmt->bindValue(':idDato', $idDato);
        $stmt->bindValue(':nombreDimension', $dimension);
        $stmt->bindValue(':nombreIndicador', $indicador);
        $stmt->bindValue(':fechaDato', $fechaDato);
        $stmt->bindValue(':valorDato', $valorDato);
        $stmt->bindValue(':zonaActual', $zonaGeografica);
        $stmt->bindValue(':fuenteDatos', $fuenteDatos);
        $stmt->bindValue(':unidadMedicion', $unidadMedicion);
        $stmt->bindValue(':posicion', $posicion);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear el dato";
        }
    }

    public function existeDato($zonaGeografica, $fechaDato, $dimension, $indicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM perfilescomunas "
                . "WHERE zonaActual = :zonaActual "
                . "AND fechaDato = :fechaDato "
                . "AND nombreDimension = :dimension "
                . "AND nombreIndicador = :indicador");
        $stmt->bindParam(":zonaActual", $zonaGeografica, PDO::PARAM_STR);
        $stmt->bindParam(":fechaDato", $fechaDato, PDO::PARAM_STR);
        $stmt->bindParam(":dimension", $dimension, PDO::PARAM_STR);
        $stmt->bindParam(":indicador", $indicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function editarDatoPerfil($idDato, $zonaGeografica, $fechaDato, $valorDato, $posicion, $dimension, $indicador, $unidadMedicion, $fuenteDatos) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE perfilescomunas '
                . 'SET valorDato = :valorDato, '
                . 'fuenteDatos = :fuenteDatos, '
                . 'unidadMedicion = :unidadMedicion, '
                . 'posicion = :posicion '
                . 'WHERE perfilescomunas.id = :idDato '
                . 'AND perfilescomunas.fechaDato = :fechaDato '
                . 'AND perfilescomunas.zonaActual = :zonaGeografica '
                . 'AND perfilescomunas.nombredimension = :dimension '
                . 'AND perfilescomunas.nombreindicador = :indicador');
        $stmt->bindValue(':valorDato', $valorDato);
        $stmt->bindValue(':posicion', $posicion);
        $stmt->bindValue(':unidadMedicion', $unidadMedicion);
        $stmt->bindValue(':fuenteDatos', $fuenteDatos);
        $stmt->bindValue(':idDato', $idDato);
        $stmt->bindValue(':fechaDato', $fechaDato);
        $stmt->bindValue(':zonaGeografica', $zonaGeografica);
        $stmt->bindValue(':dimension', $dimension);
        $stmt->bindValue(':indicador', $indicador);
        if ($stmt->execute()) {
            return "Editado";
        } else {
            return "Error al editar el dato";
        }
    }

    public function eliminarDatoPerfil($idDato, $zonaGeografica, $fechaDato, $dimension, $indicador) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM perfilescomunas '
                . 'WHERE perfilescomunas.id = :idDato '
                . 'AND perfilescomunas.zonaActual = :zonaGeografica '
                . 'AND perfilescomunas.fechaDato = :fechaDato '
                . 'AND perfilescomunas.nombreDimension = :dimension '
                . 'AND perfilescomunas.nombreindicador = :indicador');
        $stmt->bindValue(':idDato', $idDato);
        $stmt->bindValue(':zonaGeografica', $zonaGeografica);
        $stmt->bindValue(':fechaDato', $fechaDato);
        $stmt->bindValue(':dimension', $dimension);
        $stmt->bindValue(':indicador', $indicador);
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return "Error al eliminar el dato";
        }
    }

}

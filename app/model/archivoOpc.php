<?php

require_once 'connection.php';

class archivoOpc extends Connection {

    public function crearOpcDelito($id_delito, $conflictividad_delito, $estacion_delito, $sitio_delito, $arma_delito, $movil_agresor_delito, $movil_victima_delito, $cantidad_victima_delito) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO opc_delito '
                . 'VALUES(:id_delito, :conflictividad_delito, :estacion_delito,:sitio_delito,:arma_delito, :movil_agresor_delito, :movil_victima_delito, :cantidad_victima_delito)');
        $stmt->bindValue(':id_delito', $id_delito);
        $stmt->bindValue(':conflictividad_delito', $conflictividad_delito);
        $stmt->bindValue(':estacion_delito', $estacion_delito);
        $stmt->bindValue(':sitio_delito', $sitio_delito);
        $stmt->bindValue(':arma_delito', $arma_delito);
        $stmt->bindValue(':movil_agresor_delito', $movil_agresor_delito);
        $stmt->bindValue(':movil_victima_delito', $movil_victima_delito);
        $stmt->bindValue(':cantidad_victima_delito', $cantidad_victima_delito);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear el delito";
        }
    }
    
     public function eliminarOpcDelito(){
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM opc_delito ' );
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return $stmt->errorInfo()[1];
        }
      }

    public function traeUltimoIdDelito() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT id_delito "
                . "FROM opc_delito "
                . "ORDER by id_delito DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch()["id_delito"];
    }

    public function crearOpcMarcaTemporal($idMarcaTemporal, $fecha_marca_temporal, $anho_marca_temporal, $mes_marca_temporal, $semana_marca_temporal, $dia_numero_marca_temporal, $dia_marca_temporal, $fecha_especial_marca_temporal, $hora_24h_marca_temporal, $hora_24x_marca_temporal, $idDelito) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO opc_marca_temporal '
                . 'VALUES(:idMarcaTemporal, :fecha_marca_temporal, :anho_marca_temporal,:mes_marca_temporal, :semana_marca_temporal, :dia_numero_marca_temporal, :dia_marca_temporal, :fecha_especial_marca_temporal, :hora_24h_marca_temporal,:hora_24x_marca_temporal,:idDelito)');
        $stmt->bindValue(':idMarcaTemporal', $idMarcaTemporal);
        $stmt->bindValue(':fecha_marca_temporal', $fecha_marca_temporal);
        $stmt->bindValue(':anho_marca_temporal', $anho_marca_temporal);
        $stmt->bindValue(':mes_marca_temporal', $mes_marca_temporal);
        $stmt->bindValue(':semana_marca_temporal', $semana_marca_temporal);
        $stmt->bindValue(':dia_numero_marca_temporal', $dia_numero_marca_temporal);
        $stmt->bindValue(':dia_marca_temporal', $dia_marca_temporal);
        $stmt->bindValue(':fecha_especial_marca_temporal', $fecha_especial_marca_temporal);
        $stmt->bindValue(':hora_24h_marca_temporal', $hora_24h_marca_temporal);
        $stmt->bindValue(':hora_24x_marca_temporal', $hora_24x_marca_temporal);
        $stmt->bindValue(':idDelito', $idDelito);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear la marca temporal";
        }
    }
    
    public function eliminarOpcMarcaTemporal(){
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM opc_marca_temporal ' );
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return $stmt->errorInfo()[1];
        }
      }
  
    public function crearOpcZonaGeografica($idZonaGeografica, $tipoZonaGeografica, $zonaMetropolitana, $idUnidadGeografica, $nombreInvasion, $nombreZoi, $idDelito) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO opc_zona_geografica '
                . 'VALUES(:idZonaGeografica, :tipoZonaGeografica, :zonaMetropolitana,:idUnidadGeografica,:nombreInvasion, :nombreZoi, :idDelito)');
        $stmt->bindValue(':idZonaGeografica', $idZonaGeografica);
        $stmt->bindValue(':tipoZonaGeografica', $tipoZonaGeografica);
        $stmt->bindValue(':zonaMetropolitana', $zonaMetropolitana);
        $stmt->bindValue(':idUnidadGeografica', $idUnidadGeografica);
        $stmt->bindValue(':nombreInvasion', $nombreInvasion);
        $stmt->bindValue(':nombreZoi', $nombreZoi);
        $stmt->bindValue(':idDelito', $idDelito);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear la zona geografica";
        }
    }
    
    public function eliminarOpcZonaGeografica(){
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM opc_zona_geografica ' );
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return $stmt->errorInfo()[1];
        }
      }
    
    public function crearOpcVictima($idVictima, $sexoVictima, $edadVictima, $edad5QVictima, $edadNNAJVictima, $estadoCivilVictima, $paisNacimientoVictima, $claseEmpleoVictima, $profesionVictima, $escolaridadVictima, $idDelito) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO opc_victima '
                . 'VALUES(:idVictima, :sexoVictima, :edadVictima,:edad5QVictima,:edadNNAJVictima, :estadoCivilVictima, :paisNacimientoVictima, :claseEmpleoVictima,:profesionVictima,:escolaridadVictima,:idDelito)');
        $stmt->bindValue(':idVictima', $idVictima);
        $stmt->bindValue(':sexoVictima', $sexoVictima);
        $stmt->bindValue(':edadVictima', $edadVictima);
        $stmt->bindValue(':edad5QVictima', $edad5QVictima);
        $stmt->bindValue(':edadNNAJVictima', $edadNNAJVictima);
        $stmt->bindValue(':estadoCivilVictima', $estadoCivilVictima);
        $stmt->bindValue(':paisNacimientoVictima', $paisNacimientoVictima);
        $stmt->bindValue(':claseEmpleoVictima', $claseEmpleoVictima);
        $stmt->bindValue(':profesionVictima', $profesionVictima);
        $stmt->bindValue(':escolaridadVictima', $escolaridadVictima);
        $stmt->bindValue(':idDelito', $idDelito);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear la victima";
        }
    }
    
    public function eliminarOpcVictima(){
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM opc_victima ' );
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return $stmt->errorInfo()[1];
        }
      }

    public function ListarUnidadesGeograficas($codigoUnico) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM unidadesgeograficas "
                . "WHERE codigoUnico=:codigoUnico");
        $stmt->bindParam(":codigoUnico", $codigoUnico, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}

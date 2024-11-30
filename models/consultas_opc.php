<?php

require_once 'connection.php';

class ConsultasOPCModel extends Connection {

    public function consultarRegistrosOPC() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT opc_delito.id_delito, "
                . "opc_marca_temporal.anho_marca_temporal, "
                . "opc_victima.sexoVictima, opc_victima.edadNNAJVictima, "
                . "opc_delito.conflictividad_delito, opc_zona_geografica.idUnidadGeografica, "
                . "(SELECT UPPER(unidadesgeograficas.nombre) "
                . "FROM unidadesgeograficas "
                . "WHERE unidadesgeograficas.codigoUnico = opc_zona_geografica.idUnidadGeografica) "
                . "AS 'nombre_barrio', "
                . "(SELECT unidadesgeograficas.comunaCorregimiento "
                . "FROM unidadesgeograficas "
                . "WHERE unidadesgeograficas.codigoUnico = opc_zona_geografica.idUnidadGeografica) "
                . "AS 'comuna' "
                . "FROM opc_delito "
                . "INNER JOIN opc_marca_temporal ON opc_delito.id_delito=opc_marca_temporal.idDelito "
                . "INNER JOIN opc_victima on opc_delito.id_delito=opc_victima.idDelito "
                . "INNER JOIN opc_zona_geografica on opc_delito.id_delito=opc_zona_geografica.idDelito "
                . "");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

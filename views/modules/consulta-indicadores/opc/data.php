<?php

require_once '../../../../models/consultas_opc.php';
require_once '../../../../controllers/consultas_opc.php';
$consultas = new ConsultasController();
$resp = $consultas->consultarRegistrosOPC();
?>
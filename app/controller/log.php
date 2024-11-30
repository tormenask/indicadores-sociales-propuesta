<?php

class LogController {

    public function listarLogs() {
        $log = new Log();
        $resp = $log->listarLogs();
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $permiso = $rol->consultarPermisoRol("logs", $idRol);
        $crear = $permiso["crear"];
        $modificar = $permiso["modificar"];
        $eliminar = $permiso["eliminar"];
        if (!$crear && !$modificar && !$eliminar) {
            header("Location: index.php?action=admin/home");
        }
        echo ' 
        <script>
            $(document).ready(function() {
                $("#tablaConsulta").DataTable({
                    "order": [[ 0, "desc" ]],
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                    }
                });
            });
        </script>
        <style>
            td#prewrap {white-space: pre-wrap;}
        </style>
       <div class="row">
            <div class="col-sm-12">
                <h3>Registro de acciones - Logs</h3><br>
            </div>
        </div>';
        echo'
        <div class="row">
            <div class="col-sm-12">
                <table id="tablaConsulta" class="table table-striped table-bordered dt-responsive nowrap display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Id</th>
                            <th style="text-align:center;">Identificación usuario</th>
                            <th style="text-align:center;">Fecha</th>
                            <th style="text-align:center;">Hora</th>
                            <th style="text-align:center;">Módulo</th>
                            <th style="text-align:center;">Acción</th>
                            <th style="text-align:center;">Dirección IP</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($resp as $row => $item) {
            $mod = new Modulo();
            $nombreModulo = $mod->consultarModulo($item["idModuloLog"]);
            echo '
                        <tr>
                            <td id="prewrap">' . $item["idLog"] . '</td>
                            <td id="prewrap">' . $item["numeroIdentificacionUsuario"] . '</td>
                            <td id="prewrap">' . $item["fechaLog"] . '</td>
                            <td id="prewrap">' . $item["horaLog"] . '</td>
                            <td id="prewrap">' . $nombreModulo['nombreModulo'] . '</td>
                            <td id="prewrap">' . $item["accionLog"] . '</td>
                            <td id="prewrap">' . $item["direccionIpLog"] . '</td>
                        </tr>';
        }
        echo'       </tbody>
                </table>
            </div>
        </div>';
    }

    public function crearLog($idModuloLog, $accionLog) {
        $log = new Log();
        $time = time();
        $numeroIdentificacionUsuario = $_SESSION['userData']['identificacion'];
        date_default_timezone_set("America/Bogota");
        $fechaLog = date("Y-m-d", $time);
        $horaLog = date("H:i:s A");
        $direccionIpLog = $this->get_client_ip_env();
        $log->crearLog($numeroIdentificacionUsuario, $fechaLog, $horaLog, $idModuloLog, $accionLog, $direccionIpLog);
    }

    function get_client_ip_env() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } else if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } else if (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } else if (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } else if (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        } else {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }

}

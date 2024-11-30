<?php

class NotificacionController {

    public function listarNotificaciones() {
        $notificacion = new Notificacion();
        $resp = $notificacion->listarNotificaciones();
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $permiso = $rol->consultarPermisoRol("notificaciones", $idRol);
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
                <h3>Notificaciones</h3><br>
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
                            <th style="text-align:center;">Acción</th>
                            <th style="text-align:center;">Fecha/Hora</th>
                            <th style="text-align:center;">Estado</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($resp as $row => $item) {
            $estado = "";
            if ($item["estadoNotificacion"] == 1) {
                $estado = "Revisado";
            } else {
                $estado = ' <button type="button" onClick="dataUser(' . "'" . $item['idNotificacion'] . "'" . ');" id="btn-confirm" name="btn-confirm" class="btn btn-primary">  Marcar como revisado</button>';
            }
            echo '
                        <tr>
                            <td id="prewrap">' . $item["idNotificacion"] . '</td>
                            <td id="prewrap">' . $item["numeroIdentificacionUsuario"] . '</td>
                            <td id="prewrap">' . $item["accionNotificacion"] . '</td>
                            <td id="prewrap">' . $item["fechaNotificacion"] . '</td>
                            <td id="prewrap">' . $estado . '</td>
                        </tr>';
        }
        echo'       </tbody>
                </table>
            </div>
        </div>
        <script>
            function dataUser(idNotif) {
                var url = "view/modules/admin/notificaciones/funcionesNotificaciones.php";
                var data = new FormData();
                data.append("idNotificacion", idNotif);
                $.ajax({
                    url: url,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: "POST",
                    success: function (resp) {
                        location.reload();
                        console.log(resp);
                    }
                });
            }
        </script>';
    }

    public function crearNotificacion($accionNotificacion) {
        $modulo = new Modulo();
        $nombreModuloLog = "conjuntosIndicadores";
        $idModuloLog = $modulo->consultarIdModuloPorNombre($nombreModuloLog);
        $log = new LogController();
        $notificacion = new Notificacion();
        $time = time();
        $numeroIdentificacionUsuario = $_SESSION['userData']['identificacion'];
        date_default_timezone_set("America/Bogota");
        $fechaNotificacion = date("Y-m-d H:i:s A", $time);
        $resp = $notificacion->crearNotificacion($numeroIdentificacionUsuario, $accionNotificacion, $fechaNotificacion);
        if ($resp == "Creada") {
            $log->crearLog($idModuloLog, "Notificación: <i>" . $accionNotificacion . '</i> del usuario ' . $numeroIdentificacionUsuario . ' creada correctamente.');
            return "Editada";
        } else {
            $log->crearLog($idModuloLog, 'Error al crear notificación <i>' . $accionNotificacion . '</i> del usuario ' . $numeroIdentificacionUsuario . '.');
            return "Error al editar";
        }
    }

    public function cambiarEstadoNotificacion($idNotificacion) {
        session_start();
        $modulo = new Modulo();
        $nombreModuloLog = "notificaciones";
        $idModuloLog = $modulo->consultarIdModuloPorNombre($nombreModuloLog);
        $log = new LogController();
        $notificacion = new Notificacion();
        $resp = $notificacion->cambiarEstadoNotificacion($idNotificacion);
        if ($resp == "Editada") {
            $log->crearLog($idModuloLog, "Notificación " . $idNotificacion . ' editada. Su estado ahora es 1.');
            return "Editada";
        } else {
            $log->crearLog($idModuloLog, "Error al editar notificación " . $idNotificacion);
            return "Error al editar";
        }
    }

    public function listarNotificacionesSinLeer() {
        $output = "";
        $notificacion = new Notificacion();
        $resp = $notificacion->listarNotificacionesSinLeer();
        $count = $notificacion->contarNotificacionesSinLeer()['Count'];
        

        if ($count > 0) {
            foreach ($resp as $row => $notification) {
                $output .=
                        '  
                        <li>
                            <a href="index.php?action=admin/notificaciones/gestionNotificaciones">
                                <strong> Id usuario: ' . $notification["numeroIdentificacionUsuario"] . '</strong><br>
                                <small><em> Acción: ' . $notification["accionNotificacion"] . '</em></small><br>
                                <small><em> Fecha/Hora: ' . $notification["fechaNotificacion"] . '</em></small>
                            </a>
                        </li>';
            }
            $output .=
                        '  
                        <li class="text-center">
                            <a href="index.php?action=admin/notificaciones/gestionNotificaciones">
                                <strong>Ver todas las notificaciones</strong><br>
                            </a>
                        </li>';
        } else {
            $output .= '<li><a href="#" class="text-bold text-italic">No hay notificaciones pendientes</a></li>';
        }

        $data = array(
            'notification' => $output,
            'unseen_notification' => $count
        );

        echo json_encode($data);
    }

}

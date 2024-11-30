<?php

class EstadoController {

    public function listarEstados() {
        $estado = new Estado();
        $resp = $estado->listarEstados();
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $permiso = $rol->consultarPermisoRol("estados", $idRol);
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
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                    }';
        if ($modificar && $eliminar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 3, 4 ] , 
                        "bSearchable": false, "aTargets": [ 3, 4 ]
                    }]';
        } elseif ($modificar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 3 ] , 
                        "bSearchable": false, "aTargets": [ 3 ]
                    }]';
        } elseif ($eliminar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 3 ] , 
                        "bSearchable": false, "aTargets": [ 3 ]
                    }]';
        }
        echo '   
                });
            });
        </script>
        <style>
            td#prewrap {white-space: pre-wrap;}
        </style>
       <div class="row">
            <div class="col-sm-12">
                <h3>Gestión de estados</h3><br>
            </div>
        </div>';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/estados/crearEstado" 
                            class="btn btn-primary" role="button">Crear estado</a>
                        </div>
                    </div>
                </div>';
        }
        echo'
        <div class="row">
            <div class="col-sm-12">
                <table id="tablaConsulta" class="table table-striped table-bordered dt-responsive nowrap display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Id</th>
                            <th style="text-align:center;">Nombre</th>
                            <th style="text-align:center;">Descripción</th>';
        if ($modificar) {
            echo '          <th style="padding:0px 5px;vertical-align:middle;text-align:center;">Editar</th>';
        }
        if ($eliminar) {
            echo '          <th style="padding:0px 5px;vertical-align:middle;text-align:center;">Eliminar</th>';
        }
        echo'           </tr>
                    </thead>
                    <tbody>';
        foreach ($resp as $row => $item) {
            echo '
                        <tr>
                            <td id="prewrap" style="text-align:center;">' . $item["idEstado"] . '</td>
                            <td id="prewrap">' . $item["nombreEstado"] . '</td>
                            <td id="prewrap">' . $item["descripcionEstado"] . '</td>';
            if ($modificar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/estados/editarEstado&est=' . $item["idEstado"] . '">
                                    <i class="fa fa-pencil fa-lg"></i>
                                </a>
                            </td>';
            }
            if ($eliminar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/estados/eliminarEstado&est=' . $item["idEstado"] . '">
                                    <i class="fa fa-trash fa-lg"></i>
                                </a>
                            </td>';
            }
            echo'       </tr>';
        }
        echo'
                    </tbody>
                </table>
            </div>
        </div>';
    }

    public function listarEstadosCrearUsuario() {
        $estado = new Estado();
        $resp = $estado->listarEstados();
        foreach ($resp as $row => $item) {
            echo '<option value="' . $item["idEstado"] . '">' . $item["nombreEstado"] . '</option>';
        }
    }

    public function listarEstadosEditarUsuario($idEstado) {
        $estado = new Estado();
        $resp = $estado->listarEstados();
        foreach ($resp as $row => $item) {
            if ($idEstado == $item["idEstado"]) {
                echo '<option value="' . $item["idEstado"] . '" selected>' . $item["nombreEstado"] . '</option>';
            } else {
                echo '<option value="' . $item["idEstado"] . '">' . $item["nombreEstado"] . '</option>';
            }
        }
    }

    public function crearEstado($nombreEstado, $descripcionEstado) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "estados";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $estado = new Estado();
        $existeNombreEstado = $this->nombreEstadoExiste($nombreEstado);
        if ($existeNombreEstado == FALSE) {
            $idEstado = NULL;
            $resp = $estado->crearEstado($idEstado, $nombreEstado, $descripcionEstado);
            if ($resp == "Creado") {
                $log->crearLog($idModulo, "Estado " . $nombreEstado . ' creado correctamente.');
                return "Creado";
            } else {
                $log->crearLog($idModulo, "Error al crear estado " . $nombreEstado);
                return "Error al crear";
            }
        } else {
            $log->crearLog($idModulo, "Error al crear el estado " . $nombreEstado . '. Ya existe un estado con este nombre.');
            return "Nombre estado existe";
        }
    }

    public function nombreEstadoExiste($nombreEstado) {
        $estado = new Estado();
        $existe = $estado->nombreEstadoExiste($nombreEstado);
        if ($existe["idEstado"] !== NULL && $existe["idEstado"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function idEstadoExiste($idEstado) {
        $estado = new Estado();
        $existe = $estado->idEstadoExiste($idEstado);
        if ($existe["idEstado"] !== NULL && $existe["idEstado"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function editarEstadoForm($idEstado) {
        $estado = new Estado();
        $respEditarEstado = $estado->consultarEstado($idEstado);
        include 'view/modules/admin/estados/formEditarEstado.php';
    }

    public function editarEstado($idEstado, $nombreEstado, $descripcionEstado) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "estados";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $estado = new Estado();
        $existeIdEstado = $this->idEstadoExiste($idEstado);
        $existeNombreEstado = $this->nombreEstadoExiste($nombreEstado);
        $nombrePerteneceEstado = FALSE;
        $informacionEstado = $estado->consultarEstado($idEstado);
        if (strcmp($informacionEstado["nombreEstado"], $nombreEstado) == 0) {
            $nombrePerteneceEstado = TRUE;
        }
        if ($existeIdEstado == TRUE) {
            if ($existeNombreEstado == TRUE) {
                if ($nombrePerteneceEstado == TRUE) {
                    $resp = $estado->editarEstado($idEstado, $nombreEstado, $descripcionEstado);
                    if ($resp == "Editado") {
                        $log->crearLog($idModulo, "Estado " . $idEstado . ' editado correctamente.');
                        return "Editado";
                    } else {
                        $log->crearLog($idModulo, "Error al editar estado " . $idEstado);
                        return "Error al editar";
                    }
                } else {
                    $log->crearLog($idModulo, "Error al editar el estado " . $idEstado . '. Ya existe un estado con este nombre.');
                    return "Nombre en uso";
                }
            } else {
                $resp = $estado->editarEstado($idEstado, $nombreEstado, $descripcionEstado);
                if ($resp == "Editado") {
                    $log->crearLog($idModulo, "Estado " . $idEstado . ' editado correctamente.');
                    return "Editado";
                } else {
                    $log->crearLog($idModulo, "Error al editar estado " . $idEstado);
                    return "Error al editar";
                }
            }
        } else {
            $log->crearLog($idModulo, "Error al editar estado " . $idEstado . '. Id no existe.');
            return "Id no existe";
        }
    }

    public function eliminarEstadoForm($idEstado) {
        $estado = new Estado();
        $respEliminarEstado = $estado->consultarEstado($idEstado);
        include 'view/modules/admin/estados/formEliminarEstado.php';
    }

    public function eliminarEstado($idEstado) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "estados";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $estado = new Estado();
        $existeId = $this->idEstadoExiste($idEstado);
        if ($existeId !== FALSE) {
            $resp = $estado->eliminarEstado($idEstado);
            if ($resp == "Eliminado") {
                $log->crearLog($idModulo, "Estado " . $idEstado . ' eliminado correctamente.');
                return "Eliminado";
            } elseif ($resp == "1451") {
                $log->crearLog($idModulo, "Error 1451 al eliminar estado " . $idEstado);
                return "1451";
            } else {
                $log->crearLog($idModulo, "Error al eliminar estado " . $idEstado);
                return "Error al eliminar";
            }
        } else {
            $log->crearLog($idModulo, "Error al eliminar estado " . $idEstado . '. Id no existe.');

            return "Id no existe";
        }
    }

}

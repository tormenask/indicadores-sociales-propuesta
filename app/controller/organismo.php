<?php

class OrganismoController {

    public function listarOrganismos() {
        $organismo = new Organismo();
        $resp = $organismo->listarOrganismos();
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $permiso = $rol->consultarPermisoRol("organismos", $idRol);
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
                        "bSortable": false, "aTargets": [ 2, 3 ] , 
                        "bSearchable": false, "aTargets": [ 2, 3 ]
                    }]';
        } elseif ($modificar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 2 ] , 
                        "bSearchable": false, "aTargets": [ 2 ]
                    }]';
        } elseif ($eliminar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 2 ] , 
                        "bSearchable": false, "aTargets": [ 2 ]
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
                <h3>Gestión de organismos</h3><br>
            </div>
        </div>';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/organismos/crearOrganismo" 
                            class="btn btn-primary" role="button">Crear organismo</a>
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
                            <th style="text-align:center;">Nombre</th>';
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
                            <td id="prewrap" style="text-align:center;">' . $item["idOrganismo"] . '</td>
                            <td id="prewrap">' . $item["nombreOrganismo"] . '</td>';
            if ($modificar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/organismos/editarOrganismo&org=' . $item["idOrganismo"] . '">
                                    <i class="fa fa-pencil fa-lg"></i>
                                </a>
                            </td>';
            }
            if ($eliminar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/organismos/eliminarOrganismo&org=' . $item["idOrganismo"] . '">
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

    public function listarOrganismosCrear() {
        $organismo = new Organismo();
        $resp = $organismo->listarOrganismos();
        foreach ($resp as $row => $item) {
            echo '<option value="' . $item["idOrganismo"] . '">' . $item["nombreOrganismo"] . '</option>';
        }
    }

    public function listarOrganismosEditar($idOrganismo) {
        $organismo = new Organismo();
        $resp = $organismo->listarOrganismos();
        foreach ($resp as $row => $item) {
            if ($idOrganismo == $item["idOrganismo"]) {
                echo '<option value="' . $item["idOrganismo"] . '" selected>' . $item["nombreOrganismo"] . '</option>';
            } else {
                echo '<option value="' . $item["idOrganismo"] . '">' . $item["nombreOrganismo"] . '</option>';
            }
        }
    }

    public function crearOrganismo($nombreOrganismo) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "organismos";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $organismo = new Organismo();
        $existeNombreOrganismo = $this->nombreOrganismoExiste($nombreOrganismo);
        if ($existeNombreOrganismo == FALSE) {
            $idOrganismo = NULL;
            $resp = $organismo->crearOrganismo($idOrganismo, $nombreOrganismo);
            if ($resp == "Creado") {
                $log->crearLog($idModulo, "Organismo " . $nombreOrganismo . ' creado correctamente.');
                return "Creado";
            } else {
                $log->crearLog($idModulo, "Error al crear organismo " . $nombreOrganismo . '.');
                return "Error al crear";
            }
        } else {
            $log->crearLog($idModulo, "Error al crear organismo " . $nombreOrganismo . '. Ya existe un organismo con este nombre.');
            return "Nombre organismo existe";
        }
    }

    public function nombreOrganismoExiste($nombreOrganismo) {
        $organismo = new Organismo();
        $existe = $organismo->nombreOrganismoExiste($nombreOrganismo);
        if ($existe["idOrganismo"] !== NULL && $existe["idOrganismo"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function idOrganismoExiste($idOrganismo) {
        $organismo = new Organismo();
        $existe = $organismo->idOrganismoExiste($idOrganismo);
        if ($existe["idOrganismo"] !== NULL && $existe["idOrganismo"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function editarOrganismoForm($idOrganismo) {
        $organismo = new Organismo();
        $respEditarOrganismo = $organismo->consultarOrganismo($idOrganismo);
        include 'view/modules/admin/organismos/formEditarOrganismo.php';
    }

    public function editarOrganismo($idOrganismo, $nombreOrganismo) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "organismos";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $organismo = new Organismo();
        $existeIdOrganismo = $this->idOrganismoExiste($idOrganismo);
        $existeNombreOrganismo = $this->nombreOrganismoExiste($nombreOrganismo);
        $nombrePerteneceOrganismo = FALSE;
        $informacionOrganismo = $organismo->consultarOrganismo($idOrganismo);
        if (strcmp($informacionOrganismo["nombreOrganismo"], $nombreOrganismo) == 0) {
            $nombrePerteneceOrganismo = TRUE;
        }
        if ($existeIdOrganismo == TRUE) {
            if ($existeNombreOrganismo == TRUE) {
                if ($nombrePerteneceOrganismo == TRUE) {
                    $resp = $organismo->editarOrganismo($idOrganismo, $nombreOrganismo);
                    if ($resp == "Editado") {
                        $log->crearLog($idModulo, "Organismo " . $idOrganismo . ' editado correctamente.');
                        return "Editado";
                    } else {
                        $log->crearLog($idModulo, "Error al editar organismo " . $idOrganismo . '.');
                        return "Error al editar";
                    }
                } else {
                    $log->crearLog($idModulo, "Error al editar organismo " . $idOrganismo . '. Ya existe un organismo con este nombre.');
                    return "Nombre en uso";
                }
            } else {
                $resp = $organismo->editarOrganismo($idOrganismo, $nombreOrganismo);
                if ($resp == "Editado") {
                    $log->crearLog($idModulo, "Organismo " . $idOrganismo . ' editado correctamente.');
                    return "Editado";
                } else {
                    $log->crearLog($idModulo, "Error al editar organismo " . $idOrganismo . '.');
                    return "Error al editar";
                }
            }
        } else {
            $log->crearLog($idModulo, "Error al editar organismo " . $idOrganismo . '. Id organismo no existe.');
            return "Id no existe";
        }
    }

    public function eliminarOrganismoForm($idOrganismo) {
        $organismo = new Organismo();
        $respEliminarOrganismo = $organismo->consultarOrganismo($idOrganismo);
        include 'view/modules/admin/organismos/formEliminarOrganismo.php';
    }

    public function idOrganismoExisteEnUsuario($idOrganismo) {
        $usuario = new CrudUsuario();
        $existe = $usuario->idOrganismoExisteEnUsuario($idOrganismo);
        if ($existe["idOrganismo"] !== NULL && $existe["idOrganismo"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function eliminarOrganismo($idOrganismo) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "organismos";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $organismo = new Organismo();
        $existeId = $this->idOrganismoExiste($idOrganismo);
        $existeIdEnUsuario = $this->idOrganismoExisteEnUsuario($idOrganismo);
        if ($existeId !== FALSE) {
            if ($existeIdEnUsuario == FALSE) {
                $resp = $organismo->eliminarOrganismo($idOrganismo);
                if ($resp == "Eliminado") {
                    $log->crearLog($idModulo, "Organismo " . $idOrganismo . ' eliminado correctamente.');
                    return "Eliminado";
                } elseif ($resp == "1451") {
                    $log->crearLog($idModulo, "Error 1451 al eliminar organismo " . $idOrganismo . '.');
                    return "1451";
                } else {
                    $log->crearLog($idModulo, "Error al eliminar organismo " . $idOrganismo . '.');
                    return "Error al eliminar";
                }
            } else {
                $log->crearLog($idModulo, "Error al eliminar organismo " . $idOrganismo . '. El organismo esta asociado a un usuario.');
                return "Id asociado";
            }
        } else {
            $log->crearLog($idModulo, "Error al eliminar organismo " . $idOrganismo . '. El Id no existe.');
            return "Id no existe";
        }
    }

}

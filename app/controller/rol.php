<?php

class RolController {

    public function listarRoles() {
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $resp = $rol->listarRoles();
        $permiso = $rol->consultarPermisoRol("roles", $idRol);
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
                        "bSortable": false, "aTargets": [ 3, 4, 5 ] , 
                        "bSearchable": false, "aTargets": [ 3, 4, 5 ]
                    }]';
        } elseif ($modificar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 3, 4 ] , 
                        "bSearchable": false, "aTargets": [ 3, 4]
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
                <h3>Gestión de roles</h3><br>
            </div>
        </div>';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/roles/crearRol" 
                            class="btn btn-primary" role="button">Crear rol</a>
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
            echo '
                            <th style="padding:0px 5px;vertical-align:middle;text-align:center;">Editar</th>
                            <th style="padding:0px 5px;vertical-align:middle;text-align:center;">Cambiar permisos</th>';
        }
        if ($eliminar) {
            echo '          <th style="padding:0px 5px;vertical-align:middle;text-align:center;">Eliminar</th>';
        }
        echo '
                            
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($resp as $row => $item) {
            echo '
                        <tr>
                            <td>' . $item["idRol"] . '</td>
                            <td>' . $item["nombreRol"] . '</td>
                            <td>' . $item["descripcionRol"] . '</td>';
            if ($modificar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/roles/editarRol&rol=' . $item["idRol"] . '">
                                    <i class="fa fa-pencil fa-lg"></i>
                                </a>
                            </td>
                            <td style="text-align:center;">
                                <a href="index.php?action=admin/roles/cambiarPermisos&rol=' . $item["idRol"] . '">
                                    <i class="fa fa-lock fa-lg"></i>
                                </a>
                            </td>';
            }
            if ($eliminar) {
                echo'
                            <td style="text-align:center;">
                                <a href="index.php?action=admin/roles/eliminarRol&rol=' . $item["idRol"] . '">
                                    <i class="fa fa-trash fa-lg"></i>
                                </a>
                            </td>';
            }
            echo '      </tr>';
        }
        echo'
                    </tbody>
                </table>
            </div>
        </div>';
    }

    public function listarRolesCrearUsuario() {
        $role = new Rol();
        $resp = $role->listarRoles();
        foreach ($resp as $row => $item) {
            echo '<option value="' . $item["idRol"] . '">' . $item["nombreRol"] . '</option>';
        }
    }

    public function listarRolesEditarUsuario($idRol) {
        $role = new Rol();
        $resp = $role->listarRoles();
        foreach ($resp as $row => $item) {
            if ($idRol == $item["idRol"]) {
                echo '<option value="' . $item["idRol"] . '" selected>' . $item["nombreRol"] . '</option>';
            } else {
                echo '<option value="' . $item["idRol"] . '">' . $item["nombreRol"] . '</option>';
            }
        }
    }

    public function crearRol($nombreRol, $descripcionRol) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "roles";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $rol = new Rol();
        $existeNombreRol = $this->existeNombreRol($nombreRol);
        if ($existeNombreRol == FALSE) {
            $resp = $rol->crearRol($nombreRol, $descripcionRol);
            if ($resp == "Creado") {
                $log->crearLog($idModulo, "Rol " . $nombreRol . ' creado correctamente.');
                $idRol = $this->consultarIdRol($nombreRol);
                $resp2 = $this->crearPermisos($idRol);
                if ($resp2 == "Creado") {
                    $log->crearLog($idModulo, "Permisos del Rol " . $nombreRol . ' creados correctamente.');
                    return "Creado";
                } else {
                    $log->crearLog($idModulo, "Error al crear permisos del Rol " . $nombreRol . '.');
                    return "Error al crear";
                }
            } else {
                $log->crearLog($idModulo, "Error al crear el Rol " . $nombreRol . '.');
                return "Error al crear";
            }
        } else {
            $log->crearLog($idModulo, "Error al crear el Rol " . $nombreRol . '. Ya existe un rol con este nombre.');
            return "Nombre rol existe";
        }
    }

    public function crearPermisos($idRol) {
        $modulo = new Modulo();
        $rol = new Rol();
        $conjunto = new ConjuntoIndicadores();
        $modulos = $modulo->listarModulos();
        $conjuntos = $conjunto->consultarIdConjuntosIndicadores();
        $resp = "";
        foreach ($modulos as $row => $item) {
            $nombreModulo = $item["nombreModulo"];
            $idMod = $item["idModulo"];
            $disponibleConjuntos = $item["disponibleConjuntos"];
            if (!$disponibleConjuntos) {
                $resp = $rol->crearPermisos($nombreModulo, $idRol, $idMod);
            } else {
                for ($i = 0; $i < count($conjuntos); $i++) {
                    $idConjunto = $conjuntos[$i]["idConjuntoIndicadores"];
                    $mod = $nombreModulo . $idConjunto;
                    $resp = $rol->crearPermisos($mod, $idRol, $idMod);
                }
            }
        }
        if ($resp == "Creado") {
            return "Creado";
        } else {
            return "Error al crear";
        }
    }

    public function editarRol($idRol, $nombreRol, $descripcionRol) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "roles";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $rol = new Rol();
        $existeId = $this->existeIdRol($idRol);
        $nombrePerteneceUsuario = FALSE;
        $informacionRol = $rol->consultarRol($idRol);
        if ($informacionRol["nombreRol"] === $nombreRol) {
            $nombrePerteneceUsuario = TRUE;
        }
        $existeNombre = $this->existeNombreRol($nombreRol);
        if ($existeId) {
            if ($existeNombre) {
                if ($nombrePerteneceUsuario) {
                    $resp = $rol->editarRol($idRol, $nombreRol, $descripcionRol);
                    if ($resp == "Editado") {
                        $log->crearLog($idModulo, "Rol " . $idRol . ' editado correctamente.');
                        return "Editado";
                    } else {
                        $log->crearLog($idModulo, "Error al editar el Rol " . $idRol . '.');
                        return "Error al editar";
                    }
                } else {
                    $log->crearLog($idModulo, "Error al editar el Rol " . $idRol . '. Ya existe otro rol con este nombre.');
                    return "Nombre en uso";
                }
            } else {
                $resp = $rol->editarRol($idRol, $nombreRol, $descripcionRol);
                if ($resp == "Editado") {
                    $log->crearLog($idModulo, "Rol " . $idRol . ' editado correctamente.');
                    return "Editado";
                } else {
                    $log->crearLog($idModulo, "Error al editar el Rol " . $idRol . '.');
                    return "Error al editar";
                }
            }
        } else {
            $log->crearLog($idModulo, "Error al editar el Rol " . $idRol . '. El Id no existe.');
            return "Id no existe";
        }
    }

    public function consultarIdRol($nombreRol) {
        $rol = new Rol();
        $resp = $rol->consultarIdRol($nombreRol);
        return $resp["idRol"];
    }

    public function consultarPermisos($modulo, $idRol) {
        $rol = new Rol();
        $resp = $rol->consultarPermisoRol($modulo, $idRol);
        return $resp;
    }

    public function existeNombreRol($nombreRol) {
        $rol = new Rol();
        $existe = $rol->nombreRolExiste($nombreRol);
        if ($existe["nombreRol"] !== NULL && $existe["nombreRol"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function existeIdRol($idRol) {
        $rol = new Rol();
        $existe = $rol->idRolExiste($idRol);
        if ($existe["idRol"] !== NULL && $existe["idRol"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function editarRolForm($idRol) {
        $rol = new Rol();
        $respEditarRol = $rol->consultarRol($idRol);
        include 'view/modules/admin/roles/formEditarRol.php';
    }

    public function eliminarRol($idRol) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "roles";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $rol = new Rol();
        $existeId = $this->existeIdRol($idRol);
        $existeUsuario = $this->existeUsuarioConRol($idRol);
        if ($existeUsuario == FALSE) {
        if ($existeId !== FALSE) {
            $resp1 = $this->eliminarPermisos($idRol);
            if ($resp1 == "Eliminado") {
                $log->crearLog($idModulo, "Permisos para el rol " . $idRol . ' eliminados correctamente.');
                $resp = $rol->eliminarRol($idRol);
                if ($resp == "Eliminado") {
                    $log->crearLog($idModulo, "Rol " . $idRol . ' eliminado correctamente.');
                    return "Eliminado";
                } elseif ($resp == "1451") {
                    $log->crearLog($idModulo, "Error 1451 al eliminar el Rol " . $idRol . '.');
                    return "1451";
                } else {
                    $log->crearLog($idModulo, "Error al eliminar el rol " . $idRol . '.');
                    return "Error al eliminar";
                }
            } else {
                $log->crearLog($idModulo, "Error al eliminar permisos del rol " . $idRol . '.');
                return "Error al eliminar";
            }
        } else {
            $log->crearLog($idModulo, "Error al eliminar el rol " . $idRol . '. El Id no existe.');
            return "Id no existe";
        }
    } else {
          $log->crearLog($idModulo, "Error 1451 al eliminar el Rol " . $idRol . '.');
                    return "1451";
    } }
    
    public function existeUsuarioConRol($idRol) {
        $rol = new Rol();
        $existe = $rol->rolTieneUsuario($idRol);
        $totalExiste = sizeof($existe);
        if ($totalExiste > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function eliminarPermisos($idRol) {
        $rol = new Rol();
        $resp = $rol->eliminarPermisos($idRol);
        if ($resp == "Eliminado") {
            return "Eliminado";
        } elseif ($resp == "1451") {
            return "1451";
        } else {
            return "Error al eliminar";
        }
    }

    public function eliminarRolForm($idRol) {
        $rol = new Rol();
        $respEliminarRol = $rol->consultarRol($idRol);
        include 'view/modules/admin/roles/formEliminarRol.php';
    }

    public function cambiarPermisosForm($idRol) {
        include 'view/modules/admin/roles/formCambiarPermisos.php';
    }

    public function cambiarPermisosRol($idRol, $nombreModulo, $crear, $modificar, $eliminar) {
        session_start();
        $modulo = new Modulo();
        $nombreMod = "roles";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreMod);
        $log = new LogController();
        $rol = new Rol();
        $existeId = $this->existeIdRol($idRol);
        if ($existeId) {
            $idPermiso = $idRol . '_' . $nombreModulo;
            $resp = $rol->cambiarPermisosRol($idPermiso, $crear, $modificar, $eliminar);
            if ($resp == "Editado") {
                $log->crearLog($idModulo, 'Permisos para el rol ' . $idRol . ' - Módulo ' . $nombreModulo . '  cambiados correctamente. Crear: ' . $crear . ' - Modificar: ' . $modificar . ' - Eliminar: ' . $eliminar . ' - ');
                return "Editado";
            } else {
                $log->crearLog($idModulo, 'Error al cambiar los permisos para el rol ' . $idRol . ' - Módulo ' . $nombreModulo . '.');
                return "Error al editar";
            }
        } else {
            $log->crearLog($idModulo, 'Error al cambiar los permisos para el rol ' . $idRol . ' - Módulo ' . $nombreModulo . '. Id no existe.');
            return "Id no existe";
        }
    }

    public function consultarPermisosModuloConjuntos($modulo, $idRol) {
        $rol = new Rol();
        $resp = $rol->consultarPermisoModuloConjuntos($modulo, $idRol);
        return $resp;
    }

}

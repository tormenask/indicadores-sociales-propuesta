<?php

class DimensionController {

    public function listarDimensiones($idConjunto) {
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $dim = new Dimension();
        $resp = $dim->listarDimensionesConjunto($idConjunto);
        $permiso = $rol->consultarPermisoRol("dimensiones" . $idConjunto, $idRol);
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
                        "bSortable": false, "aTargets": [ 7, 8 ] , 
                        "bSearchable": false, "aTargets": [ 7, 8 ]
                    }]';
        } elseif ($modificar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 7 ] , 
                        "bSearchable": false, "aTargets": [ 7 ]
                    }]';
        } elseif ($eliminar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 7 ] , 
                        "bSearchable": false, "aTargets": [ 7 ]
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
                <h3>Gestión de dimensiones</h3><br>
            </div>
        </div>';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/dimensiones/crearDimension&conj=' . $idConjunto . '" 
                            class="btn btn-primary" role="button" type="submit">Crear dimensión </a>
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
                            <th style="text-align:center;">Descripción</th>
                            <th style="text-align:center;">Conjunto de indicadores</th>
                            <th style="text-align:center;">Posición</th>
                            <th style="text-align:center;">Icono</th>
                            <th style="text-align:center;">Color</th>';
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
            $conjuntoIndicadores = new ConjuntoIndicadores();
            $nombreConjunto = $conjuntoIndicadores->consultarNombreConjuntoIndicadores($item["idConjuntoIndicadores"]);
            echo '
                        <tr>
                            <td id="prewrap">' . $item["idDimension"] . '</td>
                            <td id="prewrap">' . $item["nombreDimension"] . '</td>
                            <td id="prewrap">' . $item["descripcionDimension"] . '</td>
                            <td id="prewrap">' . $nombreConjunto . '</td>
                            <td id="prewrap">' . $item["posicion"] . '</td>
                            <td id="prewrap"><a href ="' . $item["icono"] . '" download>' . $item["icono"] . '</a></td>
                            <td id="prewrap">' . $item["color"] . '</td>';
            if ($modificar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/dimensiones/editarDimension&dim=' . $item["idDimension"] . '&conj=' . $idConjunto . '">
                                    <i class="fa fa-pencil fa-lg"></i>
                                </a>
                            </td>';
            }
            if ($eliminar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/dimensiones/eliminarDimension&dim=' . $item["idDimension"] . '&conj=' . $idConjunto . '">
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

    public function crearDimension($nombreDimension, $descripcionDimension, $idConjuntoDimension, $posicion, $icono, $color) {
        session_start();
        $notificacion = new NotificacionController();
        $modulo = new Modulo();
        $nombreModulo = "dimensiones";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $dimension = new Dimension();
        $existeConjunto = $this->existeConjunto($idConjuntoDimension);
        $existeDimensionConjunto = $this->existeDimensionConjunto($nombreDimension, $idConjuntoDimension);
        if ($icono !== "noIcono") {
            $uploadedfile_size = $_FILES['icono']['size'];
            if ($uploadedfile_size > 1000000) {
                $log->crearLog($idModulo, "Error al crear documento . Excede tamaño permitido.");
                return "Excede tamaño";
            }
            $filename = $_FILES['icono']['name'];
            $add = $_SERVER['DOCUMENT_ROOT'] . "/app/controller/documentos/$idConjuntoDimension/$filename";
            $path = "/app/controller/documentos/$idConjuntoDimension/$filename";
        }
        if ($existeConjunto == TRUE) {
            if ($existeDimensionConjunto == FALSE) {
                $cantidadDim = $dimension->consultarUltimoId($idConjuntoDimension);
                if (!empty($cantidadDim)) {
                    $consulta = explode('_', $cantidadDim[0]);
                    $idDimension = $idConjuntoDimension . "_" . ($consulta[1] + 1);
                } else {
                    $idDimension = $idConjuntoDimension . "_" . "1";
                }
                if ($icono !== "noIcono") {
                    if (move_uploaded_file($_FILES['icono']['tmp_name'], $add)) {
                        $resp = $dimension->crearDimension($idDimension, $nombreDimension, $descripcionDimension, $idConjuntoDimension, $posicion, $path, $color);
                    } else {
                        $log->crearLog($idModulo, "Error al crear el icono");
                        return "Error al crear";
                    }
                } else {
                    $path = '';
                    $resp = $dimension->crearDimension($idDimension, $nombreDimension, $descripcionDimension, $idConjuntoDimension, $posicion, $path, $color);
                }
                if ($resp == "Creada") {
                    $log->crearLog($idModulo, "Dimensión " . $idDimension . ' - ' . $nombreDimension . ' del conjunto ' . $idConjuntoDimension . ' creada correctamente.');
                    $notificacion->crearNotificacion("Dimensión " . $idDimension . ' - ' . $nombreDimension . ' del conjunto ' . $idConjuntoDimension . ' creada');
                    return "Creada";
                } else {
                    $log->crearLog($idModulo, "Error al crear dimensión " . $idDimension . ' - ' . $nombreDimension . 'del conjunto ' . $idConjuntoDimension);
                    return "Error al crear";
                }
            } else {
                $log->crearLog($idModulo, "Error al crear dimensión " . $nombreDimension . ' del conjunto ' . $idConjuntoDimension . '. Nombre de dimensión ya existe en el conjunto.');
                return "Nombre dimension en uso";
            }
        } else {
            $log->crearLog($idModulo, "Error al crear dimensión " . $nombreDimension . ' del conjunto ' . $idConjuntoDimension . '. El Id del conjunto no existe.');
            return "Id conjunto no existe";
        }
    }

    public function editarDimension($idDimension, $nombreDimension, $descripcionDimension, $idConjuntoIndicadores, $posicion, $icono, $color) {
        session_start();
        $notificacion = new NotificacionController();
        $modulo = new Modulo();
        $nombreModulo = "dimensiones";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $dimension = new Dimension();
        $existeConjunto = $this->existeConjunto($idConjuntoIndicadores);
        $existeIdDimension = $this->existeIdDimension($idDimension);
        $nombrePerteneceUsuario = FALSE;
        $informacionDimension = $dimension->consultarDimension($idDimension);
        if (strcmp($informacionDimension["nombreDimension"], $nombreDimension) == 0) {
            $nombrePerteneceUsuario = TRUE;
        }
        if ($icono !== "noIcono") {
            if ($icono !== "" && $icono !== NULL) {
                $uploadedfile_size = $_FILES['iconoEd']['size'];
                if ($uploadedfile_size > 1000000) {
                    $log->crearLog($idModulo, "Error al crear documento . Excede tamaño permitido.");
                    return "Excede tamaño";
                }
                $filename = $_FILES['iconoEd']['name'];
                $add = $_SERVER['DOCUMENT_ROOT'] . "/app/controller/documentos/$idConjuntoIndicadores/$filename";
                $path = "/app/controller/documentos/$idConjuntoIndicadores/$filename";
            }
        }
        if ($existeConjunto == TRUE) {
            if ($existeIdDimension == TRUE) {
                if ($nombrePerteneceUsuario == TRUE) {
                    //si el nombre es el mismo
                    if ($icono !== "noIcono") {
                        $doc = $dimension->consultarIcono($idDimension);
                        move_uploaded_file($_FILES['iconoEd']['tmp_name'], $add);
                        $resp = $dimension->editarDimension($idDimension, $nombreDimension, $descripcionDimension, $posicion, $path, $color);
                        if ($resp == "Editada") {
                            $path = $_SERVER['DOCUMENT_ROOT'] . $doc['icono'];
                            if ($doc['icono'] !== "") {
                                unlink($path);
                            }
                        }
                    } else {
                        $resp = $dimension->editarDimensionSinIcono($idDimension, $nombreDimension, $descripcionDimension, $posicion, $color);
                    }
                    if ($resp == "Editada") {

                        $log->crearLog($idModulo, "Dimensión " . $idDimension . ' editada correctamente.');
                        $notificacion->crearNotificacion("Dimensión " . $idDimension . ' del conjunto ' . $idConjuntoIndicadores . ' ha sido editada.');
                        return "Editada";
                    } else {
                        $log->crearLog($idModulo, "Error al editar dimensión " . $idDimension);
                        return "Error al editar";
                    }
                } else { //si el nombre es diferente
                    if ($this->existeDimensionConjunto($nombreDimension, $idConjuntoIndicadores) == FALSE) {
                        if ($icono !== "noIcono") {
                            move_uploaded_file($_FILES['iconoEd']['tmp_name'], $add);
                            $resp = $dimension->editarDimension($idDimension, $nombreDimension, $descripcionDimension, $posicion, $path, $color);
                        } else {
                            $resp = $dimension->editarDimensionSinIcono($idDimension, $nombreDimension, $descripcionDimension, $posicion, $color);
                        }
                        if ($resp == "Editada") {
                            $log->crearLog($idModulo, "Dimensión " . $idDimension . ' editada correctamente.');
                            $notificacion->crearNotificacion("Dimensión " . $idDimension . ' - ' . $nombreDimension . ' del conjunto ' . $idConjuntoIndicadores . ' editada');
                            return "Editada";
                        } else {
                            $log->crearLog($idModulo, "Error al editar dimensión " . $idDimension);
                            return "Error al editar";
                        }
                    } else {
                        $log->crearLog($idModulo, "Error al editar dimensión " . $idDimension . '. Nombre de la dimensión ya existe en conjunto.');
                        return "Nombre dimension en uso";
                    }
                }
            } else {
                $log->crearLog($idModulo, "Error al editar dimensión " . $idDimension . '. Id de la dimensión no existe.');
                return "Id dimension no existe";
            }
        } else {
            $log->crearLog($idModulo, "Error al editar dimensión " . $idDimension . '. Id del conjunto no existe.');
            return "Id conjunto no existe";
        }
    }

    public function eliminarDimension($idDimension) {
        session_start();
        $notificacion = new NotificacionController();
        $modulo = new Modulo();
        $nombreModulo = "dimensiones";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $dimension = new Dimension();
        $existeId = $this->existeIdDimension($idDimension);
        $existeTematica = $this->existeTematicaEnDimension($idDimension);
        if ($existeTematica == FALSE) {
            if ($existeId !== FALSE) {
                $doc = $dimension->consultarIcono($idDimension);
                $resp = $dimension->eliminarDimension($idDimension);
                if ($resp == "Eliminada") {
                    if ($doc["icono"] !== "No tiene icono") {
                        $path = $_SERVER['DOCUMENT_ROOT'] . $doc['icono'];
                        unlink($path);
                    }
                    $log->crearLog($idModulo, "Dimensión " . $idDimension . ' eliminada correctamente.');
                    $notificacion->crearNotificacion("Dimensión " . $idDimension . ' eliminada');
                    return "Eliminada";
                } elseif ($resp == "1451") {
                    $log->crearLog($idModulo, "Error 1451 al eliminar dimensión " . $idDimension);
                    return "1451";
                } else {
                    $log->crearLog($idModulo, "Error al eliminar dimensión " . $idDimension);
                    return "Error al eliminar";
                }
            } else {
                $log->crearLog($idModulo, "Error al eliminar dimensión " . $idDimension . '. El Id de la dimensión no existe.');
                return "Id dimension no existe";
            }
        } else {
            $log->crearLog($idModulo, "Error 1451 al eliminar dimensión " . $idDimension);
            return "1451";
        }
    }

    public function existeConjunto($idConjuntoIndicadores) {
        $conjunto = new ConjuntoIndicadores();
        $existe = $conjunto->idConjuntoExiste($idConjuntoIndicadores);
        if ($existe["idConjuntoIndicadores"] !== NULL && $existe["idConjuntoIndicadores"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function existeTematicaEnDimension($idDimension) {
        $dimension = new Dimension();
        $existe = $dimension->dimensionTieneTematica($idDimension);
        $totalExiste = sizeof($existe);
        if ($totalExiste > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function existeDimensionConjunto($nombreDimension, $idConjuntoIndicadores) {
        $dimension = new Dimension();
        $existe = $dimension->nombreDimensionExisteConjunto($nombreDimension, $idConjuntoIndicadores);
        if ($existe["idDimension"] !== NULL && $existe["idDimension"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function existeIdDimension($idDimension) {

        $dimension = new Dimension();
        $existe = $dimension->idDimensionExiste($idDimension);
        if ($existe["idDimension"] !== NULL && $existe["idDimension"] !== "") {

            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function editarDimensionForm($idDimension) {
        $dimension = new Dimension();
        $respEditarDimension = $dimension->consultarDimension($idDimension);
        $idConjuntoDimension = $respEditarDimension["idConjuntoIndicadores"];
        include 'view/modules/admin/dimensiones/formEditarDimension.php';
    }

    public function eliminarDimensionForm($idDimension) {
        $dimension = new Dimension();
        $respEliminarDimension = $dimension->consultarDimension($idDimension);
        $idConjuntoDimension = $respEliminarDimension["idConjuntoIndicadores"];
        include 'view/modules/admin/dimensiones/formEliminarDimension.php';
    }

    public function listarDimensionesCrear() {
        $dimension = new Dimension();
        $resp = $dimension->listarDimensiones();
        foreach ($resp as $row => $item) {
            echo '<option value="' . $item["idDimension"] . '">' . $item["nombreDimension"] . '</option>';
        }
    }

    public function listarDimensionesConjunto($idConjuntoIndicadores) {
        $dimension = new Dimension();
        $resp = $dimension->listarDimensionesConjunto($idConjuntoIndicadores);
        echo '<option value="Seleccione">Seleccione una dimensión</option>';
        foreach ($resp as $row => $item) {
            echo '<option value="' . $item["idDimension"] . '">' . $item["nombreDimension"] . '</option>';
        }
    }

    public function listarDimensionesConjuntoDatos($idConjuntoIndicadores) {
        $dimension = new Dimension();
        $resp = $dimension->listarDimensionesConjunto($idConjuntoIndicadores);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['nombreDimension'],
                "title" => $item['nombreDimension'],
                "value" => $item['idDimension'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function listarDimensionesEditar($idDimension) {
        $dimension = new Dimension();
        $resp = $dimension->listarDimensiones();
        foreach ($resp as $row => $item) {
            if ($idDimension == $item["idDimension"]) {
                echo '<option value="' . $item["idDimension"] . '" selected>' . $item["nombreDimension"] . '</option>';
            } else {
                echo '<option value="' . $item["idDimension"] . '">' . $item["nombreDimension"] . '</option>';
            }
        }
    }

}

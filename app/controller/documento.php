<?php

class DocumentoController {

    public function listarDocumentos($idConjunto) {
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $doc = new Documento();
        $resp = $doc->listarDocumentosConjunto($idConjunto);
        $permiso = $rol->consultarPermisoRol("documentos" . $idConjunto, $idRol);
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
                        "bSortable": false, "aTargets": [ 6, 7 ] , 
                        "bSearchable": false, "aTargets": [ 6, 7 ]
                    }]';
        } elseif ($modificar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 6 ] , 
                        "bSearchable": false, "aTargets": [ 6 ]
                    }]';
        } elseif ($eliminar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 6 ] , 
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
                <h3>Gestión de documentos</h3><br>
            </div>
        </div>';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/documentos/crearDocumento&conj=' . $idConjunto . '" 
                            class="btn btn-primary" role="button">Crear documento</a>
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
                            <th style="text-align:center;">Titulo</th>
                            <th style="text-align:center;">Descripción</th>
                            <th style="text-align:center;">Tipo</th>
                            <th style="text-align:center;">Descargar archivo</th>
                            <th style="text-align:center;">Conjunto de indicadores</th>';
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
                            <td id="prewrap">' . $item["idDocumento"] . '</td>
                            <td id="prewrap">' . $item["tituloDocumento"] . '</td>
                            <td id="prewrap">' . $item["descripcionDocumento"] . '</td>
                            <td id="prewrap">' . $item["tipoDocumento"] . '</td>
                            <td id="prewrap"><a href ="' . $item["archivoDocumento"] . '" download>' . $item["tituloDocumento"] . '</a></td>
                            <td id="prewrap">' . $nombreConjunto . '</td>';
            if ($modificar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/documentos/editarDocumento&doc=' . $item["idDocumento"] . '&conj=' . $idConjunto . '">
                                    <i class="fa fa-pencil fa-lg"></i>
                                </a>
                            </td>';
            }
            if ($eliminar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/documentos/eliminarDocumento&doc=' . $item["idDocumento"] . '&conj=' . $idConjunto . '">
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

    public function crearDocumento($tituloDocumento, $descripcionDocumento, $archivoDocumento, $idConjuntoDocumento) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "documentos";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $doc = new Documento();
        $uploadedfileload = "true";
        $uploadedfile_size = $_FILES['archivoDocumento']['size'];
        if ($uploadedfile_size > 2000000) {
            $log->crearLog($idModulo, "Error al crear documento " . $tituloDocumento . ' del conjunto ' . $idConjuntoDocumento . '. Excede tamaño permitido.');
            return "Excede tamaño";
        }
        if (!($_FILES['archivoDocumento']['type'] == "application/msword"
                OR $_FILES['archivoDocumento']['type'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                OR $_FILES['archivoDocumento']['type'] == "application/zip"
                OR $_FILES['archivoDocumento']['type'] == "application/x-zip"
                OR $_FILES['archivoDocumento']['type'] == "application/vnd.oasis.opendocument.text"
                OR $_FILES['archivoDocumento']['type'] == "application/octet-stream"
                OR $_FILES['archivoDocumento']['type'] == "application/pdf")) {
            $log->crearLog($idModulo, "Error al crear documento " . $tituloDocumento . ' del conjunto ' . $idConjuntoDocumento . '. Extensión inválida: ' . $_FILES['archivoDocumento']['type'] . '.');
            return "Extension invalida";
        }
        $filename = $_FILES['archivoDocumento']['name'];
        $numeroDocumento = $doc->siguienteIdDocumento()[0];
        $firstName = $numeroDocumento . '_' . $idConjuntoDocumento;
        $finalName = $firstName . '_' . $filename;
        $add = $_SERVER['DOCUMENT_ROOT'] . "/sis/app/controller/documentos/$idConjuntoDocumento/$finalName";
        $path = "/sis/app/controller/documentos/$idConjuntoDocumento/$finalName";

        $existeConjunto = $this->existeConjunto($idConjuntoDocumento);
        if ($uploadedfileload == "true") {
            if ($existeConjunto == TRUE) {
                $idDocumento = NULL;
                $tipoDocumento = $_FILES['archivoDocumento']['type'];
                if (move_uploaded_file($_FILES['archivoDocumento']['tmp_name'], $add)) {
                    $resp = $doc->crearDocumento($idDocumento, $tituloDocumento, $tipoDocumento, $descripcionDocumento, $path, $idConjuntoDocumento);
                    if ($resp == "Creado") {
                        $log->crearLog($idModulo, "Documento " . $finalName . ' del conjunto ' . $idConjuntoDocumento . ' creado correctamente.');
                        return "Creado";
                    } else {
                        $log->crearLog($idModulo, "Error al crear documento " . $finalName . ' del conjunto ' . $idConjuntoDocumento);
                        return "Error al crear";
                    }
                } else {
                    $log->crearLog($idModulo, "Error al crear documento " . $finalName . ' del conjunto ' . $idConjuntoDocumento . '. Error al cargar los documentos.');
                    return "Error al crear";
                }
            } else {
                $log->crearLog($idModulo, "Error al crear documento " . $finalName . ' del conjunto ' . $idConjuntoDocumento . '. Id conjunto no existe.');
                return "Id conjunto no existe";
            }
        } else {
            $log->crearLog($idModulo, "Error al crear documento " . $finalName . ' del conjunto ' . $idConjuntoDocumento);
            return "Error al crear";
        }
    }

    public function editarDocumento($idDocumento, $tituloDocumento, $descripcionDocumento, $archivoDocumentoNuevo, $idConjuntoDocumento) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "documentos";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $doc = new Documento();
        $existeConjunto = $this->existeConjunto($idConjuntoDocumento);
        $existeIdDocumento = $this->existeDocumento($idDocumento);
        if ($existeConjunto == TRUE) {
            if ($existeIdDocumento == TRUE) {
//                if ($archivoDocumentoNuevo !== "" && $archivoDocumentoNuevo !== NULL) {
                if ($archivoDocumentoNuevo !== "noDocumento") {
                    $uploadedfileload = "true";
                    $uploadedfile_size = $_FILES['archivoDocumentoNuevoEd']['size'];
                    if ($uploadedfile_size > 2000000) {
                        $log->crearLog($idModulo, "Error al editar documento " . $tituloDocumento . ' del conjunto ' . $idConjuntoDocumento . '. Excede tamaño permitido.');
                        return "Excede tamaño";
                    }
                    if (!($_FILES['archivoDocumentoNuevoEd']['type'] == "application/msword"
                            OR $_FILES['archivoDocumentoNuevoEd']['type'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            OR $_FILES['archivoDocumentoNuevoEd']['type'] == "application/zip"
                            OR $_FILES['archivoDocumentoNuevoEd']['type'] == "application/x-zip"
                            OR $_FILES['archivoDocumentoNuevoEd']['type'] == "application/vnd.oasis.opendocument.text"
                            OR $_FILES['archivoDocumentoNuevoEd']['type'] == "application/octet-stream"
                            OR $_FILES['archivoDocumentoNuevoEd']['type'] == "application/pdf")) {
                        $log->crearLog($idModulo, "Error al editar documento " . $tituloDocumento . ' del conjunto ' . $idConjuntoDocumento . '. Extensión inválida: ' . $_FILES['archivoDocumento']['type'] . '.');
                        return "Extension invalida";
                    }
                    $filename = $_FILES['archivoDocumentoNuevoEd']['name'];
                    $firstName = $idDocumento . '_' . $idConjuntoDocumento;
                    $finalName = $firstName . '_' . $filename;

                    $add = $_SERVER['DOCUMENT_ROOT'] . "/sis/app/controller/documentos/$idConjuntoDocumento/$finalName";
                    $path = "/sis/app/controller/documentos/$idConjuntoDocumento/$finalName";
                    $tipoDocumento = $_FILES['archivoDocumentoNuevoEd']['type'];
                    if (move_uploaded_file($_FILES['archivoDocumentoNuevoEd']['tmp_name'], $add)) {
                         $delet = $doc->consultarDocumento($idDocumento);
                        $resp = $doc->editarDocumento($idDocumento, $tituloDocumento, $tipoDocumento, $descripcionDocumento, $path);
                        $path = $_SERVER['DOCUMENT_ROOT'] . $delet['archivoDocumento'];
                            unlink($path);
                        if ($resp == "Editado") {
                            $log->crearLog($idModulo, "Documento " . $finalName . ' del conjunto ' . $idConjuntoDocumento . ' editado correctamente.');
                            return "Editado";
                        } else {
                            $log->crearLog($idModulo, "Error al editar documento " . $finalName . ' del conjunto ' . $idConjuntoDocumento);
                            return "Error al editar";
                        }
                    } else {
                        return "Error al editar";
                    }
                } else {
                    $resp = $doc->editarDocumentoSinArchivo($idDocumento, $tituloDocumento, $descripcionDocumento);
                    if ($resp == "Editado") {
                        $log->crearLog($idModulo, 'Documento del conjunto ' . $idConjuntoDocumento . ' editado correctamente.');
                        return "Editado";
                    } else {
                        $log->crearLog($idModulo, "Error al editar documento del conjunto " . $idConjuntoDocumento);
                        return "Error al editar";
                    }
                }
            }
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

    public function eliminarDocumento($idDocumento) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "documentos";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $documento = new Documento();
        $existeId = $this->existeDocumento($idDocumento);
        if ($existeId !== FALSE) {
            $doc = $documento->consultarDocumento($idDocumento);
            $resp = $documento->eliminarDocumento($idDocumento);
            if ($resp == "Eliminado") {
                $path = $_SERVER['DOCUMENT_ROOT'] . $doc['archivoDocumento'];
                unlink($path);
                $log->crearLog($idModulo, "Documento " . $idDocumento . ' eliminado correctamente.');
                return "Eliminado";
            } elseif ($resp == "1451") {
                $log->crearLog($idModulo, "Error 1451 al eliminar documento " . $idDocumento);
                return "1451";
            } else {
                $log->crearLog($idModulo, "Error al eliminar documento " . $idDocumento);
                return "Error al eliminar";
            }
        } else {
            $log->crearLog($idModulo, "Error al eliminar documento " . $idDocumento . '. Id del documento no existe.');
            return "Id documento no existe";
        }
    }

    public function existeDocumento($idDocumento) {
        $documento = new Documento();
        $existe = $documento->idDocumentoExiste($idDocumento);
        if ($existe["idDocumento"] !== NULL && $existe["idDocumento"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function editarDocumentoForm($idDocumento) {
        $documento = new Documento();
        $respEditarDocumento = $documento->consultarDocumento($idDocumento);
        $idConjuntoDocumento = $respEditarDocumento["idConjuntoIndicadores"];
        include 'view/modules/admin/documentos/formEditarDocumento.php';
    }

    public function eliminarDocumentoForm($idDocumento) {
        $documento = new Documento();
        $respEliminarDocumento = $documento->consultarDocumento($idDocumento);
        $idConjuntoDocumento = $respEliminarDocumento["idConjuntoIndicadores"];
        include 'view/modules/admin/documentos/formEliminarDocumento.php';
    }

}

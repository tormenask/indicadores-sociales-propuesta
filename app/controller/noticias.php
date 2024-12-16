<?php

class NoticiasController {

    public function listarNoticias() {
        $noticias = new Noticias();
        $resp = $noticias->listarNoticias();
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $permiso = $rol->consultarPermisoRol("noticias", $idRol);
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
                <h3>Gestión de noticias</h3><br>
            </div>
        </div>';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/noticias/crearNoticias" 
                            class="btn btn-primary" role="button">Crear Noticia</a>
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
                            <th style="text-align:center;">Título</th>
                            <th style="text-align:center;">Año</th>
                            <th style="text-align:center;">Fecha</th>
                            <th style="text-align:center;">Texto</th>
                            <th style="text-align:center;">Imagenes</th>';
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
                            <td id="prewrap" style="text-align:center;">' . $item["idNoticia"] . '</td>
                                <td id="prewrap" style="text-align:center;">' . $item["tituloNoticia"] . '</td>
                                    <td id="prewrap" style="text-align:center;">' . $item["anhoNoticia"] . '</td>
                                        <td id="prewrap" style="text-align:center;">' . $item["fechaNoticia"] . '</td>
                                            <td id="prewrap">' . $item["textoNoticia"] . '</td>
                                                <td id="prewrap">' . $item["carpetaImagenesNoticia"] . '</td>';
            if ($modificar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/noticias/editarNoticias&not=' . $item["idNoticia"] . '">
                                    <i class="fa fa-pencil fa-lg"></i>
                                </a>
                            </td>';
            }
            if ($eliminar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/noticias/eliminarNoticias&not=' . $item["idNoticia"] . '">
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

    public function crearCarpeta($idNoticia) {
        $carpeta = $_SERVER['DOCUMENT_ROOT'] . "/app/view/resources/noticias/" . $idNoticia;
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777);
            return "Creado";
        } else {
            return "Error al crear";
        }
    }

    public function editarNoticiasForm($idNoticia) {
        $noticias = new Noticias();
        $respEditarNoticias = $noticias->consultarNoticias($idNoticia);
        include 'view/modules/admin/noticias/formEditarNoticias.php';
    }

    public function crearNoticias($tituloNoticia, $anhoNoticia, $fechaNoticia, $textoNoticia, $imagen) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "noticias";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $noticias = new Noticias();
        $idNoticia = $noticias->ultimoIdNoticias();
        $this->crearCarpeta($idNoticia);
        if ($imagen !== "noImagen") {
            $pesoImagen = $imagen["size"];
            $longitud = count($pesoImagen);
            for ($i = 0; $i < $longitud; $i++) {
                if ($pesoImagen[$i] > 3700000) {
                    $log->crearLog($idModulo, "Error al cargar la imagen . Excede tamaño permitido.");
                    return "Excede tamaño";
                }
            }
            $nombreImagen = $imagen["name"];
            $longitud1 = count($nombreImagen);
            $nombreNoticias ="";
            for ($j = 0; $j < $longitud1; $j++) {
                $filename = $nombreImagen[$j];
                $nombreNoticias = (($longitud1-1) === $j)? $nombreNoticias . $nombreImagen[$j] : $nombreNoticias . $nombreImagen[$j].";";                
                $add = $_SERVER['DOCUMENT_ROOT'] . "/siscali/app/view/resources/noticias/$idNoticia/$filename";
                if (move_uploaded_file($imagen['tmp_name'][$j], $add)) {
                    $imagenMovida = True;
                } else {
                    $imagenMovida = False;
                }
            }
            $path = "/siscali/app/view/resources/noticias/$idNoticia";
            if ($imagenMovida == True) {
                $idNoticia = NULL;
                $resp = $noticias->crearNoticia($idNoticia, $tituloNoticia, $anhoNoticia, $fechaNoticia, $textoNoticia, $path,$nombreNoticias);
            } else {
                $log->crearLog($idModulo, "Error al crargar la imagen");
                return "Error al crear";
            }
        } else {
            $path = "/siscali/app/view/resources/noticias/$idNoticia";
            $idNoticia = NULL;
            $resp = $noticias->crearNoticia($idNoticia, $tituloNoticia, $anhoNoticia, $fechaNoticia, $textoNoticia, $path, NULL);
        }
        if ($resp == "Creada") {
            $log->crearLog($idModulo, "Noticia " . $tituloNoticia . ' creada correctamente.');
            return "Creada";
        } else {
            $log->crearLog($idModulo, "Error al crear la noticia " . $idNoticia . ' - ' . $tituloNoticia);
            return "Error al crear";
        }
    }

    public function editarNoticias($idNoticia, $tituloNoticia, $anhoNoticia, $fechaNoticia, $textoNoticia, $imagen) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "noticias";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $noticias = new Noticias();
        if ($imagen !== "noImagen") {
            $pesoImagen = $imagen["size"];
            $longitud = count($pesoImagen);
            for ($i = 0; $i < $longitud; $i++) {
                if ($pesoImagen[$i] > 3700000) {
                    $log->crearLog($idModulo, "Error al cargar la imagen . Excede tamaño permitido.");
                    return "Excede tamaño";
                }
            }
            $nombreImagen = $imagen["name"];
            $longitud1 = count($nombreImagen);
            $nombreNoticias ="";
            for ($j = 0; $j < $longitud1; $j++) {
                $filename = $nombreImagen[$j];
                $nombreNoticias = (($longitud1-1) === $j)? $nombreNoticias . $nombreImagen[$j] : $nombreNoticias . $nombreImagen[$j].";";                
                $add = $_SERVER['DOCUMENT_ROOT'] . "/siscali/app/view/resources/noticias/$idNoticia/$filename";
                if (move_uploaded_file($imagen['tmp_name'][$j], $add)) {
                    $imagenMovida = True;
                } else {
                    $imagenMovida = False;
                }
            }
            $path = "/siscali/app/view/resources/noticias/$idNoticia";
            if ($imagenMovida == True) {
                $resp = $noticias->editarNoticia($idNoticia, $tituloNoticia, $anhoNoticia, $fechaNoticia, $textoNoticia, $path,$nombreNoticias);
            } else {
                $log->crearLog($idModulo, "Error al crargar la imagen");
                return "Error al editar";
            }
        } else {
            $path = "/siscali/app/view/resources/noticias/$idNoticia";
            $nombreNoticias = $noticias->consultarNoticias($idNoticia);
            $resp = $noticias->editarNoticia($idNoticia, $tituloNoticia, $anhoNoticia, $fechaNoticia, $textoNoticia, $path, $nombreNoticias['imagenesNoticia']);
        }
        if ($resp == "Editada") {
            $log->crearLog($idModulo, "Noticia " . $tituloNoticia . ' editada correctamente.');
            return "Editada";
        } else {
            $log->crearLog($idModulo, "Error al editar la noticia " . $idNoticia . ' - ' . $tituloNoticia);
            return "Error al editar";
        }
    }

    public function eliminarNoticiasForm($idNoticia) {
        $noticias = new Noticias();
        $respEliminarNoticias = $noticias->consultarNoticias($idNoticia);
        include 'view/modules/admin/noticias/formEliminarNoticias.php';
    }

    public function listarNoticiasEditar($idNoticia) {
        $noticias = new Noticias();
        $resp = $noticias->listarNoticiasEditar($idNoticia);
        foreach ($resp as $row => $item) {
            if ($idNoticia == $item["idNoticia"]) {
                echo '<option value="' . $item["anhoNoticia"] . '" selected>' . $item["anhoNoticia"] . '</option>';
            } else {
                echo '<option value="' . $item["anhoNoticia"] . '">' . $item["anhoNoticia"] . '</option>';
            }
        }
    }

    public function eliminarCarpeta($idNoticia) {
        $carpeta = $_SERVER['DOCUMENT_ROOT'] . "/app/view/resources/noticias/" . $idNoticia;

        function rmdir_recursive($carpeta) {
            $files = scandir($carpeta);
            array_shift($files);
            array_shift($files);
            foreach ($files as $file) {
                $file = $carpeta . '/' . $file;
                if (is_dir($file)) {
                    rmdir_recursive($file);
                    rmdir($file);
                } else {
                    unlink($file);
                }
            }
            rmdir($carpeta);
        }

        rmdir_recursive($carpeta);
    }

    public function eliminarNoticias($idNoticia) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "noticias";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $noticias = new Noticias();
        $resp = $noticias->eliminarNoticia($idNoticia);
        if ($resp == "Eliminada") {
            $this->eliminarCarpeta($idNoticia);
            $log->crearLog($idModulo, "Noticias " . $idNoticia . ' eliminada correctamente.');
            return "Eliminada";
        } else {
            $log->crearLog($idModulo, "Error al eliminar la noticia " . $idNoticia);
            return "Error al eliminar";
        }
    }

}

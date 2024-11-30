<?php
include_once 'model/rol.php';
include_once 'controller/rol.php';
include_once 'model/modulo.php';
include_once 'controller/modulo.php';
include_once 'model/conjuntoIndicadores.php';
include_once 'controller/conjuntoIndicadores.php';
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image logo-admin" style="font-size: 2em;padding-top: 3px;margin-bottom: -5px;">
                <a href=""><i class="fa fa-cogs"></i></a>
            </div>
            <div class="pull-left info" style="padding: 5px 20px;left: 25px;">
                <p style="font-size: 18px;font-weight: normal;">Panel de administración</p>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <?php
            $idRol = $_SESSION['userData']['idRol'];
            $rol = new RolController();
            $modulo = new ModuloController();
            $conjunto = new ConjuntoIndicadoresController();
            $modulos = $modulo->consultarModulos();
            $conjuntos = $conjunto->consultarConjuntosIndicadores();
            for ($i = 0; $i < count($modulos); $i++) {
                $nombreModulo = $modulos[$i]["nombreModulo"];
                $iconoModulo = $modulos[$i]["iconoModulo"];
                $disponibleConjuntos = $modulos[$i]["disponibleConjuntos"];
                $nombreModuloTitulo = $nombreModulo;
                if ($nombreModulo == "conjuntosIndicadores") {
                    $nombreModuloTitulo = "Conjuntos de indicadores";
                } elseif ($nombreModulo == "perfiles") {
                    $nombreModuloTitulo = "Perfiles para Santiago de Cali";
                } elseif ($nombreModulo == "fichasTecnicas") {
                    $nombreModuloTitulo = "Fichas técnicas";
                } elseif ($nombreModulo == "seriesDatos") {
                    $nombreModuloTitulo = "Series de datos";
                } elseif ($nombreModulo == "indicadoresvariables") {
                    $nombreModuloTitulo = "Rel Indicadores - Variables";
                } elseif ($nombreModulo == "cargarArchivo") {
                    $nombreModuloTitulo = "Cargar archivos";
                }
                if (!$disponibleConjuntos) {
                    $permiso = $rol->consultarPermisos($nombreModulo, $idRol);
                    $crear = $permiso["crear"];
                    $modificar = $permiso["modificar"];
                    $eliminar = $permiso["eliminar"];
                    if ($crear == 1 || $modificar == 1 || $eliminar == 1) {
                        echo '  <li id="' . $nombreModulo . '">
                                    <a href="index.php?action=admin/' . $nombreModulo . '/gestion' . ucfirst($nombreModulo) . '">
                                        <i class="' . $iconoModulo . '"></i>
                                        ' . ucfirst($nombreModuloTitulo) . '
                                    </a>
                                </li>';
                    }
                } else {
                    $permisosMod = $rol->consultarPermisosModuloConjuntos($nombreModulo, $idRol);
                    if (!empty($permisosMod)) {
                        echo '<li class="treeview" id="' . $nombreModulo . '">
                                <a href="#">
                                    <i class="' . $iconoModulo . '"></i>
                                    <span>' . ucfirst($nombreModuloTitulo) . '</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="list-group nav nav-pills nav-stacked admin-menu treeview-menu">';
                        for ($j = 0; $j < count($conjuntos); $j++) {
                            $idConjunto = $conjuntos[$j]["idConjuntoIndicadores"];
                            $nombreConjunto = $conjuntos[$j]["nombreConjuntoIndicadores"];
                            $permiso = $rol->consultarPermisos($nombreModulo . $idConjunto, $idRol);
                            $crear = $permiso["crear"];
                            $modificar = $permiso["modificar"];
                            $eliminar = $permiso["eliminar"];
                            if ($crear == 1 || $modificar == 1 || $eliminar == 1) {
                                echo '  
                                    <li id="' . $nombreModulo . $idConjunto . '">
                                        <a href="index.php?action=admin/' . $nombreModulo . '/gestion' . ucfirst($nombreModulo) . '&conj=' . $idConjunto . '" 
                                            style="font-size:13px;">
                                            <i class = "fa fa-circle" style="margin-right: -10px;"></i>
                                            ' . wordwrap($nombreConjunto, 33, "<br>", FALSE) . '
                                        </a>
                                    </li>';
                            }
                        }
                        echo '
                                </ul>
                              </li>';
                    }
                }
            }
            ?>
        </ul>
    </section>
</aside>
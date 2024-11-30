<?php
include_once 'model/dimension.php';
include_once 'controller/dimension.php';
include_once 'model/log.php';
include_once 'controller/log.php';
include_once 'model/modulo.php';
include_once 'controller/modulo.php';
include_once 'model/rol.php';
include_once 'controller/rol.php';
include_once 'model/visualizador.php';
include_once 'controller/visualizador.php';
session_start();
$idRol = $_SESSION['userData']['idRol'];
$rol = new Rol();
$idConj = "";
if (isset($_GET['conj'])) {
    $idConj = $_GET['conj'];
}
$permiso = $rol->consultarPermisoRol("cargarArchivo" . $idConj, $idRol);
$crear = $permiso["crear"];
$modificar = $permiso["modificar"];
$eliminar = $permiso["eliminar"];
if (!$crear && !$modificar && !$eliminar) {
    header("Location: index.php?action=admin/home");
}
?>
<html>
    <?php include 'view/modules/head.php'; ?>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script> 
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script> 
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script>
    <style type="text/css">
        td#prewrap {
            white-space: pre-wrap;
        }
    </style>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'view/modules/header.php'; ?>
            <?php include 'view/modules/side.php'; ?>
            <div class="content-wrapper" style="padding: 20px; background-color: #fff;">
                <?php
                if ($idConj == 'SIS') {
                    echo '  
                <div class="row">   
                    <div id="resp"></div>
                    <div class="col-sm-12">
                        <h3> Cargar los indicadores para la medición del desarrollo social</h3>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <label control-label text-left><p>Cargar información básica de Indicadores SIS</p></label>
                                <p>El archivo a cargar, debe cumplir las siguientes características:</p>
                                <ul>
                                    <li>Tener extensión .xls o .xlsx</li>
                                    <li>No tener filas vacías</li>
                                    <li>La primera fila debe contener los nombres de las columnas</li>
                                    <li>A partir de la segunda fila, debe encontrarse la información a cargar</li>
                                    <li>Debe existir una fila por cada dato a agregar</li>
                                    <li>Debe tener 15 columnas, en el siguiente orden:</li>
                                    <br>
                                    <ol>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <li>Nombre de la Dimensión</li>
                                                <li>Nombre de la Temática</li>
                                                <li>Nombre del Indicador</li>
                                                <li>Tipo de dato</li>
                                                <li>Fecha del dato</li>
                                                <li>Valor del dato</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>Geografía</li>
                                                <li>Zona actual</li>
                                                <li>Periodicidad</li>
                                                <li>Entidad generadora / compiladora</li>
                                                <li>Fuente de datos</li>
                                                <li>URL datos</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>Desagregación temática</li>
                                                <li>Notas de la serie</li>
                                                <li>Unidad de medición</li>
                                            </div>
                                        </div>
                                    </ol>
                                </ul>
                                <form id="formCargarInformacion" class="form-horizontal" 
                                      method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 
                                               control-label text-left">Seleccione el archivo a cargar:</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="archivoInformacionC" id="archivoInformacionC" required >
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-offset-1">
                                            <input type="button" name="btn" value="Cargar archivo" 
                                                   id="submitCargarArchivo"
                                                   style="margin:0;" class="btn btn-primary" />
                                            <img src="/views/resources/images/loading.gif" id="loadingIndicadoresSis" style="display: none;" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="row" style="padding-top: 30px;">
                            <div class="col-sm-12">
                                <label control-label text-left><p>Cargar información de ficha técnica de Indicadores SIS</p></label>  
                                <p>El archivo a cargar, debe cumplir las siguientes características:</p> 
                                <ul>
                                    <li>Tener extensión .xls o .xlsx</li>
                                    <li>No tener filas vacías</li>
                                    <li>La primera fila debe contener los nombres de las columnas</li>
                                    <li>A partir de la segunda fila, debe encontrarse la información a cargar</li>
                                    <li>Debe existir una fila por cada indicador</li>
                                    <li>Debe tener 20 columnas, en el siguiente orden:</li>
                                    <br>
                                    <ol>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <li>Nombre de la Dimensión</li>
                                                <li>Nombre de la Temática</li>
                                                <li>Nombre del Indicador</li>
                                                <li>Sigla</li>
                                                <li>Objetivo/Justificación</li>
                                                <li>Definición</li>
                                                <li>Métodos de medición</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>Fórmulas</li>
                                                <li>Variables</li>
                                                <li>Valores de referencia</li>
                                                <li>Naturaleza</li>
                                                <li>Desagregación temática</li>
                                                <li>Desagregación geográfica</li>
                                                <li>Línea base</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>Fuente de datos</li>
                                                <li>Responsable</li>
                                                <li>Observaciones</li>
                                                <li>Fecha de elaboración</li>
                                                <li>Tipo de gráfico</li>
                                                <li>Posición temática</li>
                                                <li>Posición indicador</li>
                                            </div>
                                        </div>
                                    </ol>
                                </ul>
                                <form id="formCargarFichaTecnica" class="form-horizontal" 
                                      method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 
                                               control-label text-left">Seleccione el archivo a cargar:</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="archivoFichaC" id="archivoFichaC" required >
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-offset-1">
                                            <input type="button" name="btn" value="Cargar archivo" 
                                                   id="submitCargarFicha"
                                                   style="margin:0;" class="btn btn-primary" />
                                            <img src="/views/resources/images/loading.gif" id="loadingFichaSis" style="display: none;" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
             </div>';
                } elseif ($idConj == 'EXP') {
                    echo' 
               <div class="row">   
                    <div id="resp"></div>
                    <div class="col-sm-12">
                        <h3> Cargar los Indicadores del Expediente Municipal</h3>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <label control-label text-left><p>Cargar información básica de Indicadores EXMU</p></label>
                                <p>El archivo a cargar, debe cumplir las siguientes características:</p>
                                <ul>
                                    <li>Tener extensión .xls o .xlsx</li>
                                    <li>No tener filas vacías</li>
                                    <li>La primera fila debe contener los nombres de las columnas</li>
                                    <li>A partir de la segunda fila, debe encontrarse la información a cargar</li>
                                    <li>Debe existir una fila por cada dato a agregar</li>
                                    <li>Debe tener 15 columnas, en el siguiente orden:</li>
                                    <br>
                                    <ol>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <li>Nombre de la Dimensión</li>
                                                <li>Nombre de la Temática</li>
                                                <li>Nombre del Indicador</li>
                                                <li>Tipo de dato</li>
                                                <li>Fecha del dato</li>
                                                <li>Valor del dato</li>
                                            </div>
                                            <div class="col-md-4">
                                                
                                                <li>Geografía</li>
                                                <li>Zona actual</li>
                                                <li>Periodicidad</li>
                                                <li>Entidad generadora / compiladora</li>
                                                <li>Fuente de datos</li>
                                                <li>URL datos</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>Desagregación temática</li>
                                                <li>Notas de la serie</li>
                                                <li>Unidad de medición</li>
                                            </div>
                                        </div>
                                    </ol>
                                </ul>
                                <form id="formCargarInformacionExp" class="form-horizontal" 
                                      method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 
                                               control-label text-left">Seleccione el archivo a cargar:</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="archivoInformacionExp" id="archivoInformacionExp" required >
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-offset-1">
                                            <input type="button" name="btn" value="Cargar archivo" 
                                                   id="submitCargarArchivoExp"
                                                   style="margin:0;" class="btn btn-primary" />
                                            <img src="/views/resources/images/loading.gif" id="loadingIndicadoresExp" style="display: none;" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="row" style="padding-top: 30px;">
                            <div class="col-sm-12">
                                <label control-label text-left><p>Cargar información de ficha técnica de Indicadores EXMU</p></label>  
                                <p>El archivo a cargar, debe cumplir las siguientes características:</p> 
                                <ul>
                                    <li>Tener extensión .xls o .xlsx</li>
                                    <li>No tener filas vacías</li>
                                    <li>La primera fila debe contener los nombres de las columnas</li>
                                    <li>A partir de la segunda fila, debe encontrarse la información a cargar</li>
                                    <li>Debe existir una fila por cada indicador</li>
                                    <li>Debe tener 20 columnas, en el siguiente orden:</li>
                                    <br>
                                    <ol>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <li>Nombre de la Dimensión</li>
                                                <li>Nombre de la Temática</li>
                                                <li>Nombre del Indicador</li>
                                                <li>Sigla</li>
                                                <li>Objetivo/Justificación</li>
                                                <li>Definición</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>Métodos de medición</li>
                                                <li>Fórmulas</li>
                                                <li>Variables</li>
                                                <li>Valores de referencia</li>
                                                <li>Naturaleza</li>
                                                <li>Desagregación temática</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>Desagregación geográfica</li>
                                                <li>Línea base</li>
                                                <li>Responsable</li>
                                                <li>Observaciones</li>
                                                <li>Fecha de elaboración</li>
                                                <li>Tipo de gráfico</li>
                                                <li>Posición temática</li>
                                                <li>Posición indicador</li>
                                            </div>
                                        </div>
                                    </ol>
                                </ul>
                                <form id="formCargarFichaTecnicaExp" class="form-horizontal" 
                                      method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 
                                               control-label text-left">Seleccione el archivo a cargar:</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="archivoFichaExp" id="archivoFichaExp" required >
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-offset-1">
                                            <input type="button" name="btn" value="Cargar archivo" 
                                                   id="submitCargarFichaExp"
                                                   style="margin:0;" class="btn btn-primary" />
                                            <img src="/views/resources/images/loading.gif" id="loadingFichaExp" style="display: none;" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
             </div>';
                } elseif ($idConj == 'IGC') {
                    echo' 
                    <div class="row">   
                    <div id="resp"></div>
                    <div class="col-sm-12">
                        <h3> Cargar los indicadores globales de ciudad</h3>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <label control-label text-left><p>Cargar información básica de Indicadores IGC</p></label>
                                <p>El archivo a cargar, debe cumplir las siguientes características:</p>
                                <ul>
                                    <li>Tener extensión .xls o .xlsx</li>
                            <li>No tener filas vacías</li>
                            <li>La primera fila debe contener los nombres de las columnas</li>
                            <li>A partir de la segunda fila, debe encontrarse la información a cargar</li>
                            <li>Debe existir una fila por cada dato a agregar</li>
                            <li>Debe tener 15 columnas, en el siguiente orden:</li>
                            <br>
                                    <ol>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <li>Nombre de la Categoría</li>
                                        <li>Nombre de la Temática</li>
                                        <li>Nombre del Indicador</li>
                                        <li>Tipo de dato</li>
                                        <li>Fecha del dato</li>
                                        <li>Valor del dato</li>
                                    </div>
                                    <div class="col-md-4">
                                        <li>Geografía</li>
                                        <li>Zona actual</li>
                                        <li>Periodicidad</li>
                                        <li>Entidad generadora / compiladora</li>
                                        <li>Fuente de datos</li>
                                        <li>URL datos</li>
                                    </div>
                                    <div class="col-md-4">
                                        <li>Desagregación temática</li>
                                        <li>Notas de la serie</li>
                                        <li>Unidad de medida</li>
                                            </div>
                                        </div>
                                    </ol>
                                </ul>
                                <form id="formCargarInformacionIGC" class="form-horizontal" 
                                      method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 
                                               control-label text-left">Seleccione el archivo a cargar:</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="archivoInformacionIGC" id="archivoInformacionIGC" required >
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-offset-1">
                                            <input type="button" name="btn" value="Cargar archivo" 
                                                   id="submitCargarArchivoIGC"
                                                   style="margin:0;" class="btn btn-primary" />
                                            <img src="/views/resources/images/loading.gif" id="loading" style="display: none;" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="row" style="padding-top: 30px;">
                            <div class="col-sm-12">
                                <label control-label text-left><p>Cargar información de ficha técnica de Indicadores IGC</p></label>  
                                <p>El archivo a cargar, debe cumplir las siguientes características:</p> 
                                <ul>
                                    <li>Tener extensión .xls o .xlsx</li>
                            <li>No tener filas vacías</li>
                            <li>La primera fila debe contener los nombres de las columnas</li>
                            <li>A partir de la segunda fila, debe encontrarse la información a cargar</li>
                            <li>Debe existir una fila por cada indicador</li>
                            <li>Debe tener 9 columnas, en el siguiente orden:</li>
                            <br>
                                    <ol>
                                        <div class="row">
                                            <div class="col-md-6">
                                        <li>Nombre del Indicador</li>
                                        <li>Justificación</li>
                                        <li>Definición</li>
                                    <li>Metodología</li>
                                            </div>
                                    <div class="col-md-6">
                                        <li>Referencia</li>
                                        <li>Observaciones y limitaciones</li>
                                        <li>Otras organizaciones que usan el indicador</li>
                                        <li>Tipo de grafico</li>
                                        <li>Posición del indicador</li>
                                    </div>
                                        </div>
                                    </ol>
                                </ul>
                                <form id="formCargarFichaTecnicaIGC" class="form-horizontal" 
                                      method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 
                                               control-label text-left">Seleccione el archivo a cargar:</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="archivoFichaIGC" id="archivoFichaIGC" required >
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-offset-1">
                                            <input type="button" name="btn" value="Cargar archivo" 
                                                   id="submitCargarFichaIGC"
                                                   style="margin:0;" class="btn btn-primary" />
                                            <img src="/views/resources/images/loading.gif" id="loading" style="display: none;" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>';
                } elseif ($idConj == 'OPC') {
                    echo' 
               <div class="row">   
                    <div id="resp"></div>
                    <div class="col-sm-12">
                        <h3> Cargar los Indicadores del Observatorio de Paz y Convivencia</h3>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <label control-label text-left><p>Cargar información básica de Indicadores OPC</p></label>
                                <p>El archivo a cargar, debe cumplir las siguientes características:</p>
                                <ul>
                                    <li>Tener extensión .xls o .xlsx</li>
                                    <li>No tener filas vacías</li>
                                    <li>La primera fila debe contener los nombres de las columnas</li>
                                    <li>A partir de la segunda fila, debe encontrarse la información a cargar</li>
                                    <li>Debe existir una fila por cada dato a agregar</li>
                                    <li>Debe tener 30 columnas, en el siguiente orden:</li>
                                    <br>
                                    <ol>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <li>Conflictividad delito</li>
                                                <li>Estación delito</li>
                                                <li>Sitio delito</li>
                                                <li>Arma delito</li>
                                                <li>Móvil agresor delito</li>
                                                <li>Móvil víctima delito</li>
                                                <li>Cantidad víctima delito</li>
                                            </div>
                                            <div class="col-md-3">
                                                <li>Fecha marca temporal</li>
                                                <li>Año marca temporal</li>
                                                <li>Mes marca temporal</li>
                                                <li>Semana marca temporal</li>
                                                <li>Dia numero marca temporal</li>
                                                <li>Dia marca temporal</li>
                                                <li>Fecha especial marca temporal</li>
                                                <li>Hora 24h marca temporal</li>
                                                <li>Hora 24x marca temporal</li>
                                            </div>
                                            <div class="col-md-3">
                                                <li>Tipo Zona Geográfica</li>
                                                <li>Zona Metropolitana</li>
                                                <li>Id Unidad Geográfica</li>
                                                <li>Nombre Invasion</li>
                                                <li>Nombre Zoi</li>
                                            </div>
                                            <div class="col-md-3">
                                                <li>Sexo Víctima</li>
                                                <li>Edad Víctima</li>
                                                <li>Edad 5Q Víctima</li>
                                                <li>Edad NNAJ Víctima</li>
                                                <li>Estado Civil Víctima</li>
                                                <li>País Nacimiento Víctima</li>
                                                <li>Clase Empleo Víctima</li>
                                                <li>Profesión Víctima</li>
                                                <li>Escolaridad Víctima</li>
                                            </div>
                                        </div>
                                    </ol>
                                </ul>
                                      <div> 
                                      <br>
                                         <label control-label text-left><p>¡RECORDATORIO!</p></label>
                                      <ul>
                                         <li>Recuerde eliminar la data presionando el botón "Eliminar data", antes de cargar el archivo.</li>
                                         <li>Espere a que cargue correctamente el archivo antes de salirse, de lo contrario deberá eliminar data y volver a cargar el archivo.</li>
                                      </ul>                                  
                                      <br>
                                      </div>
                                <form id="formCargarInformacionOpc" class="form-horizontal" 
                                      method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 
                                               control-label text-left">Seleccione el archivo a cargar:</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="archivoInformacionOpc" id="archivoInformacionOpc" required >
                                        </div>
                                    </div>    
                                    <div class="form-group">                                      
                                        <div class="col-sm-offset-1">
                                            <input type="button" name="btn" value="Cargar archivo" 
                                                   id="submitCargarArchivoOpc"
                                                   style="margin:0;" class="btn btn-primary" />                                                   
                                            <img src="/views/resources/images/loading.gif" id="loadingIndicadoresOpc" style="display: none;" />
                                        </div>
                                    </div>
                                  </form>
                            </div>
                        </div>
                        <form id="formEliminarInformacionOpc" class="form-horizontal" 
                      method="POST" enctype="multipart/form-data">
                    <div class="form-group">                                      
                        <div class="col-sm-offset-1">
                            <input type="button" name="btn" value="Eliminar data" 
                                   id="submitEliminarArchivoOpc"
                                   style="margin:0;" class="btn btn-danger" />
                        </div>
                    </div>
                </form>
                
                <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-confirm">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header active">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Confirmación</h4>
                            </div>
                            <div class="modal-body">
                                <p id="modal-content-create"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="modal-btn-si">Si</button>
                                <button type="button" class="btn btn-default" id="modal-btn-no">No</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-set-created">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header active">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Creación exitosa</h4>
                            </div>
                            <div class="modal-body">
                                <p id="modal-content-set-created"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" id="modal-btn-set-created-ok">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
              </div>';
                } elseif ($idConj == 'PIIA') {
                    echo '  
                <div class="row">   
                    <div id="resp"></div>
                    <div class="col-sm-12">
                        <h3> Cargar los indicadores de la Política de Primera Infancia, Infancia y Adolescencia</h3>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <label control-label text-left><p>Cargar información básica de Indicadores PIIA</p></label>
                                <p>El archivo a cargar, debe cumplir las siguientes características:</p>
                                <ul>
                                    <li>Tener extensión .xls o .xlsx</li>
                                    <li>No tener filas vacías</li>
                                    <li>La primera fila debe contener los nombres de las columnas</li>
                                    <li>A partir de la segunda fila, debe encontrarse la información a cargar</li>
                                    <li>Debe existir una fila por cada dato a agregar</li>
                                    <li>Debe tener 15 columnas, en el siguiente orden:</li>
                                    <br>
                                    <ol>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <li>Nombre de la Dimensión</li>
                                                <li>Nombre de la Temática</li>
                                                <li>Nombre del Indicador</li>
                                                <li>Tipo de dato</li>
                                                <li>Fecha del dato</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>Valor del dato</li>
                                                <li>Geografía</li>
                                                <li>Zona actual</li>
                                                <li>Periodicidad</li>
                                                <li>Entidad generadora / compiladora</li>
                                                <li>Fuente de datos</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>URL datos</li>
                                                <li>Desagregación temática</li>
                                                <li>Notas de la serie</li>
                                                <li>Unidad de medición</li>
                                            </div>
                                        </div>
                                    </ol>
                                </ul>
                                <form id="formCargarInformacionPiia" class="form-horizontal" 
                                      method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 
                                               control-label text-left">Seleccione el archivo a cargar:</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="archivoInformacionPiia" id="archivoInformacionPiia" required >
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-offset-1">
                                            <input type="button" name="btn" value="Cargar archivo" 
                                                   id="submitCargarArchivoPiia"
                                                   style="margin:0;" class="btn btn-primary" />
                                            <img src="/views/resources/images/loading.gif" id="loadingIndicadoresPiia" style="display: none;" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="row" style="padding-top: 30px;">
                            <div class="col-sm-12">
                                <label control-label text-left><p>Cargar información de ficha técnica de Indicadores PIIA</p></label>  
                                <p>El archivo a cargar, debe cumplir las siguientes características:</p> 
                                <ul>
                                    <li>Tener extensión .xls o .xlsx</li>
                                    <li>No tener filas vacías</li>
                                    <li>La primera fila debe contener los nombres de las columnas</li>
                                    <li>A partir de la segunda fila, debe encontrarse la información a cargar</li>
                                    <li>Debe existir una fila por cada indicador</li>
                                    <li>Debe tener 18 columnas, en el siguiente orden:</li>
                                    <br>
                                    <ol>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <li>Nombre de la Dimensión</li>
                                                <li>Nombre de la Temática</li>
                                                <li>Nombre del Indicador</li>
                                                <li>Sigla</li>
                                                <li>Objetivo/Justificación</li>
                                                <li>Definición</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>Métodos de medición</li>
                                                <li>Fórmulas</li>
                                                <li>Variables</li>
                                                <li>Valores de referencia</li>
                                                <li>Naturaleza</li>
                                                <li>Desagregación temática</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>Desagregación geográfica</li>
                                                <li>Línea base</li>
                                                <li>Responsable</li>
                                                <li>Observaciones</li>
                                                <li>Fecha de elaboración</li>
                                                <li>Tipo de gráfico</li>
                                                <li>Posición temática</li>
                                                <li>Posición indicador</li>
                                            </div>
                                        </div>
                                    </ol>
                                </ul>
                                <form id="formCargarFichaTecnicaPiia" class="form-horizontal" 
                                      method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 
                                               control-label text-left">Seleccione el archivo a cargar:</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="archivoFichaPiia" id="archivoFichaPiia" required >
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-offset-1">
                                            <input type="button" name="btn" value="Cargar archivo" 
                                                   id="submitCargarFichaPiia"
                                                   style="margin:0;" class="btn btn-primary" />
                                            <img src="/views/resources/images/loading.gif" id="loadingFichaPiia" style="display: none;" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
             </div>';
                } elseif ($idConj == 'ODRAF') {
                    echo' 
               <div class="row">   
                    <div id="resp"></div>
                    <div class="col-sm-12">
                        <h3> Cargar los Indicadores del Observatorio del deporte, la recreación y la actividad física</h3>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <label control-label text-left><p>Cargar información básica de los Indicadores ODRAF</p></label>
                                <p>El archivo a cargar, debe cumplir las siguientes características:</p>
                                <ul>
                                    <li>Tener extensión .xls o .xlsx</li>
                                    <li>No tener filas vacías</li>
                                    <li>La primera fila debe contener los nombres de las columnas</li>
                                    <li>A partir de la segunda fila, debe encontrarse la información a cargar</li>
                                    <li>Debe existir una fila por cada dato a agregar</li>
                                    <li>Debe tener 15 columnas, en el siguiente orden:</li>
                                    <br>
                                    <ol>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <li>Nombre de la Dimensión</li>
                                                <li>Nombre de la Temática</li>
                                                <li>Nombre del Indicador</li>
                                                <li>Tipo de dato</li>
                                                <li>Fecha del dato</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>Valor del dato</li>
                                                <li>Geografía</li>
                                                <li>Zona actual</li>
                                                <li>Periodicidad</li>
                                                <li>Entidad generadora / compiladora</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>Fuente de datos</li>
                                                <li>URL datos</li>
                                                <li>Desagregación temática</li>
                                                <li>Notas de la serie</li>
                                                <li>Unidad de medición</li>
                                            </div>
                                        </div>
                                    </ol>
                                </ul>
                                <form id="formCargarInformacionOdraf" class="form-horizontal" 
                                      method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 
                                               control-label text-left">Seleccione el archivo a cargar:</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="archivoInformacionOdraf" id="archivoInformacionOdraf" required >
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-offset-1">
                                            <input type="button" name="btn" value="Cargar archivo" 
                                                   id="submitCargarArchivoOdraf"
                                                   style="margin:0;" class="btn btn-primary" />
                                            <img src="/views/resources/images/loading.gif" id="loadingIndicadoresOdraf" style="display: none;" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="row" style="padding-top: 30px;">
                            <div class="col-sm-12">
                                <label control-label text-left><p>Cargar información de ficha técnica de los Indicadores ODRAF</p></label>  
                                <p>El archivo a cargar, debe cumplir las siguientes características:</p> 
                                <ul>
                                    <li>Tener extensión .xls o .xlsx</li>
                                    <li>No tener filas vacías</li>
                                    <li>La primera fila debe contener los nombres de las columnas</li>
                                    <li>A partir de la segunda fila, debe encontrarse la información a cargar</li>
                                    <li>Debe existir una fila por cada indicador</li>
                                    <li>Debe tener 20 columnas, en el siguiente orden:</li>
                                    <br>
                                    <ol>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <li>Nombre de la Dimensión</li>
                                                <li>Nombre de la Temática</li>
                                                <li>Nombre del Indicador</li>
                                                <li>Sigla</li>
                                                <li>Objetivo/Justificación</li>
                                                <li>Definición</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>Métodos de medición</li>
                                                <li>Fórmulas</li>
                                                <li>Variables</li>
                                                <li>Valores de referencia</li>
                                                <li>Naturaleza</li>
                                                <li>Desagregación temática</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>Desagregación geográfica</li>
                                                <li>Línea base</li>
                                                <li>Responsable</li>
                                                <li>Observaciones</li>
                                                <li>Fecha de elaboración</li>
                                                <li>Tipo de gráfico</li>
                                                <li>Posición temática</li>
                                                <li>Posición indicador</li>
                                            </div>
                                        </div>
                                    </ol>
                                </ul>
                                <form id="formCargarFichaTecnicaOdraf" class="form-horizontal" 
                                      method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 
                                               control-label text-left">Seleccione el archivo a cargar:</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="archivoFichaOdraf" id="archivoFichaOdraf" required >
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-offset-1">
                                            <input type="button" name="btn" value="Cargar archivo" 
                                                   id="submitCargarFichaOdraf"
                                                   style="margin:0;" class="btn btn-primary" />
                                            <img src="/views/resources/images/loading.gif" id="loadingFichaOdraf" style="display: none;" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
             </div>';
                } elseif ($idConj == 'ODS') {
                    echo '  
                <div class="row">   
                    <div id="resp"></div>
                    <div class="col-sm-12">
                        <h3> Cargar los indicadores para los Objetivos de Desarrollo Sostenible - ODS</h3>
                        <hr>
                        <div class="row" style="padding-top: 30px;">
                            <div class="col-sm-12">
                                <label control-label text-left><p>Cargar información de las metas por cuatrenio, para los ODS</p></label>  
                                <p>El archivo a cargar, debe cumplir las siguientes características:</p> 
                                <ul>
                                    <li>Tener extensión .xls o .xlsx</li>
                                    <li>No tener filas vacías</li>
                                    <li>La primera fila debe contener los nombres de las columnas</li>
                                    <li>A partir de la segunda fila, debe encontrarse la información a cargar</li>
                                    <li>Debe existir una fila por cada indicador</li>
                                    <li>Debe tener 14 columnas, en el siguiente orden:</li>
                                    <br>
                                    <ol>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <li>Objetivo</li>
                                                <li>Meta</li>
                                                <li>Indicador</li>
                                                <li>Línea base 2015</li>
                                                <li>Meta 2019</li>
                                                <li>Meta 2023</li>
                                            </div>
                                            <div class="col-sm-4">
                                                <li>Meta 2027</li>
                                                <li>Meta 2030</li>
                                                <li>Periodicidad</li>
                                                <li>Entidad compiladora</li>
                                                <li>Fuente</li>
                                                <li>URL Datos</li>
                                            </div>
                                            <div class="col-sm-4">
                                                <li>Notas</li>
                                                <li>Unidad de medición</li>
                                                <li>Proveniencia del Indicador</li>
                                                <li>Comportamiento esperado</li>
                                            </div>
                                        </div>
                                    </ol>
                                </ul>
                                <form id="formCuatrenioODS" class="form-horizontal" 
                                      method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 
                                               control-label text-left">Seleccione el archivo a cargar:</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="archivoCuatrenioODS" id="archivoCuatrenioODS" required >
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-offset-1">
                                            <input type="button" name="btn" value="Cargar archivo" 
                                                   id="submitCuatrenioODS"
                                                   style="margin:0;" class="btn btn-primary" />
                                            <img src="/views/resources/images/loading.gif" id="loadingCuatrenioODS" style="display: none;" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <label control-label text-left>
                                    <p>Cargar información de seguimiento anual de los ODS</p>
                                </label>
                                <p>El archivo a cargar, debe cumplir las siguientes características:</p>
                                <ul>
                                    <li>Tener extensión .xls o .xlsx</li>
                                    <li>No tener filas vacías</li>
                                    <li>La primera fila debe contener los nombres de las columnas</li>
                                    <li>A partir de la segunda fila, debe encontrarse la información a cargar</li>
                                    <li>Debe existir una fila por cada dato a agregar</li>
                                    <li>Debe tener 11 columnas, en el siguiente orden:</li>
                                    <br>
                                    <ol>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <li>Número del Objetivo</li>
                                                <li>Número de la Meta</li>
                                                <li>Nombre del Indicador</li>
                                                <li>Fecha del dato</li>
                                            </div>
                                            <div class="col-sm-4">
                                                <li>Valor del dato</li>
                                                <li>Periodicidad</li>
                                                <li>Entidad generadora / compiladora</li>
                                                <li>Fuente de datos</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>URL datos</li>
                                                <li>Notas de la serie</li>
                                                <li>Unidad de medición</li>
                                            </div>
                                        </div>
                                    </ol>
                                </ul>
                                <form id="formCargarSeguimientoODS" class="form-horizontal" 
                                      method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 
                                               control-label text-left">Seleccione el archivo a cargar:</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="archivoSeguimientoODS" id="archivoSeguimientoODS" required >
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-offset-1">
                                            <input type="button" name="btn" value="Cargar archivo" 
                                                   id="submitSeguimientoODS"
                                                   style="margin:0;" class="btn btn-primary" />
                                            <img src="/views/resources/images/loading.gif" id="loadingSeguimientoODS" style="display: none;" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="row" style="padding-top: 30px;">
                            <div class="col-sm-12">
                                <label control-label text-left><p>Cargar información de ficha técnica de Indicadores ODS</p></label>  
                                <p>El archivo a cargar, debe cumplir las siguientes características:</p> 
                                <ul>
                                    <li>Tener extensión .xls o .xlsx</li>
                                    <li>No tener filas vacías</li>
                                    <li>La primera fila debe contener los nombres de las columnas</li>
                                    <li>A partir de la segunda fila, debe encontrarse la información a cargar</li>
                                    <li>Debe existir una fila por cada indicador</li>
                                    <li>Debe tener 12 columnas, en el siguiente orden:</li>
                                    <br>
                                    <ol>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <li>Número del Objetivo</li>
                                                <li>Nombre del Objetivo</li>
                                                <li>Número de la Meta</li>
                                                <li>Nombre de la Meta</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>Nombre del Indicador</li>
                                                <li>Descripción del Indicador</li>
                                                <li>Unidad de medida</li>
                                                <li>Metodo de cálculo</li>
                                            </div>
                                            <div class="col-md-4">
                                                <li>Línea Base</li>
                                                <li>Periodicidad</li>
                                                <li>Fuente de datos</li>
                                                <li>Fecha de elaboración</li>
                                            </div>
                                        </div>
                                    </ol>
                                </ul>
                                <form id="formCargarFichaODS" class="form-horizontal" 
                                      method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 
                                               control-label text-left">Seleccione el archivo a cargar:</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="archivoFichaODS" id="archivoFichaODS" required>
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-offset-1">
                                            <input type="button" name="btn" value="Cargar archivo" 
                                                   id="submitFichaODS"
                                                   style="margin:0;" class="btn btn-primary" />
                                            <img src="/views/resources/images/loading.gif" id="loadingFichaODS" style="display: none;" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';
                 }elseif ($idConj == 'DADII') {
                    echo' 
               <div class="row">   
                    <div id="resp"></div>
                    <div class="col-sm-12">
                        <h3> Cargar los Indicadores del Departamento Administrativo de Desarrollo e Innovación Institucional</h3>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <label control-label text-left><p>Cargar información básica de los indicadores del DADII</p></label>
                                <p>El archivo a cargar, debe cumplir las siguientes características:</p>
                                <ul>
                                    <li>Tener extensión .xls o .xlsx</li>
                                    <li>No tener filas vacías</li>
                                    <li>La primera fila debe contener los nombres de las columnas</li>
                                    <li>A partir de la segunda fila, debe encontrarse la información a cargar</li>
                                    <li>Debe existir una fila por cada dato a agregar</li>
                                    <li>Debe tener 12 columnas, en el siguiente orden:</li>
                                    <br>
                                    <ol>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <li>Código del macroproceso</li>
                                                <li>Nombre del macroproceso</li>
                                                <li>Código del proceso</li>
                                                <li>Nombre del Proceso</li>
                                                <li>Código del indicador</li>
                                                <li>Nombre del indicador</li>
                                            </div>
                                            <div class="col-md-4">
                                                
                                                <li>Período de tiempo</li>
                                                <li>Valor del dato</li>
                                                <li>Geografía del indicador</li>
                                                <li>Periodicidad</li>
                                                <li>Fuente de datos</li>
                                                <li>Unidad de medida</li>
                                            </div>
                                        </div>
                                    </ol>
                                </ul>
                                <form id="formCargarInformacionDadii" class="form-horizontal" 
                                      method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 
                                               control-label text-left">Seleccione el archivo a cargar:</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="archivoInformacionDadii" id="archivoInformacionDadii" required >
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-offset-1">
                                            <input type="button" name="btn" value="Cargar archivo" 
                                                   id="submitCargarArchivoDadii"
                                                   style="margin:0;" class="btn btn-primary" />
                                            <img src="/views/resources/images/loading.gif" id="loadingIndicadoresDadii" style="display: none;" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>   
             </div>';
                }
                ?>
            </div> </div>
    </div>
    <?php include 'view/modules/footer.php'; ?>
    <script>
        $('#modal-confirm').on('shown.bs.modal', function (e) {
            document.getElementById("modal-content-create").innerHTML = "Realmente desea eliminar los datos de las tablas.";
        });
    </script>

    <script>
        $('#submitCargarArchivo').click(function () {
            var inputFile = document.getElementById("archivoInformacionC");
            var file = inputFile.files[0];
            var data = new FormData();
            data.append("archivoInformacionC", file);
            var url = "/app/view/modules/admin/cargarArchivo/funcionesArchivoOpc.php";
            $('#loadingIndicadoresSis').show();
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    $('#resp').html(data);
                    $("#formCargarInformacion")[0].reset();
                    $("#refrescar").show();
                    $('#loadingIndicadoresSis').hide();
                }
            });
        });
    </script>
    <script>
        $('#submitCargarFicha').click(function () {
            var inputFile = document.getElementById("archivoFichaC");
            var file = inputFile.files[0];
            var data = new FormData();
            data.append("archivoFichaC", file);
            var url = "/app/view/modules/admin/cargarArchivo/funcionesArchivoOpc.php";
            $('#loadingFichaSis').show();
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    $('#resp').html(data);
                    $("#formCargarFichaTecnica")[0].reset();
                    $("#refrescar").show();
                    $('#loadingFichaSis').hide();
                }
            });
        });
    </script>
    <script>
        $('#submitCargarArchivoExp').click(function () {
            var inputFile = document.getElementById("archivoInformacionExp");
            var file = inputFile.files[0];
            var data = new FormData();
            data.append("archivoInformacionExp", file);
            var url = "/app/view/modules/admin/cargarArchivo/funcionesArchivoOpc.php";
            $('#loadingIndicadoresExp').show();
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    $('#resp').html(data);
                    $("#formCargarInformacionExp")[0].reset();
                    $("#refrescar").show();
                    $('#loadingIndicadoresExp').hide();
                }
            });
        });
    </script>
    <script>
        $('#submitCargarFichaExp').click(function () {
            var inputFile = document.getElementById("archivoFichaExp");
            var file = inputFile.files[0];
            var data = new FormData();
            data.append("archivoFichaExp", file);
            var url = "/app/view/modules/admin/cargarArchivo/funcionesArchivoOpc.php";
            $('#loadingFichaExp').show();
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    $('#resp').html(data);
                    $("#formCargarFichaTecnicaExp")[0].reset();
                    $("#refrescar").show();
                    $('#loadingFichaExp').hide();
                }
            });
        });
    </script>
    <script>
        $('#submitCargarArchivoIGC').click(function () {
            var inputFile = document.getElementById("archivoInformacionIGC");
            var file = inputFile.files[0];
            var data = new FormData();
            data.append("archivoInformacionIGC", file);
            var url = "/app/view/modules/admin/cargarArchivo/funcionesArchivoOpc.php";
            $('#loading').show();
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    $('#resp').html(data);
                    $("#formCargarInformacionIGC")[0].reset();
                    $("#refrescar").show();
                    $('#loading').hide();
                }
            });
        });
    </script>
    <script>
        $('#submitCargarFichaIGC').click(function () {
            var inputFile = document.getElementById("archivoFichaIGC");
            var file = inputFile.files[0];
            var data = new FormData();
            data.append("archivoFichaIGC", file);
            var url = "/app/view/modules/admin/cargarArchivo/funcionesArchivoOpc.php";
            $('#loading').show();
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    $('#resp').html(data);
                    $("#formCargarFichaTecnicaIGC")[0].reset();
                    $("#refrescar").show();
                    $('#loading').hide();
                }
            });
        });
    </script>
    <script>
        $('#submitCargarArchivoOpc').click(function () {
            var inputFile = document.getElementById("archivoInformacionOpc");
            var file = inputFile.files[0];
            var data = new FormData();
            data.append("archivoInformacionOpc", file);
            var url = "/app/view/modules/admin/cargarArchivo/funcionesArchivoOpc.php";
            $('#loadingIndicadoresOpc').show();
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    $('#resp').html(data);
                    $("#formCargarInformacionOpc")[0].reset();
                    $("#refrescar").show();
                    $('#loading').hide();
                }
            });
        });
    </script>
    <script>
        $("#submitEliminarArchivoOpc").on("click", function () {
            $("#modal-confirm").modal('show');
        });
        $("#modal-btn-si").on("click", function () {
            eliminarData();
            $("#modal-confirm").modal('hide');
        });
        $("#modal-btn-no").on("click", function () {
            $("#modal-confirm").modal('hide');
        });
        $("#modal-btn-set-created-ok").on("click", function () {
            $("#modal-set-created").modal('hide');
            window.location.replace("index.php?action=admin/cargarArchivo/gestionCargarArchivo&conj=OPC");
        });
    </script>    
    <script>
        function eliminarData() {
            var eliminarData = "eliminarData";
            var data = new FormData();
            data.append("eliminarData", eliminarData);
            var url = "/app/view/modules/admin/cargarArchivo/funcionesArchivoOpc.php";
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    $("#formEliminarInformacionOpc")[0].reset();
                    if (resp === "Eliminado") {
                        document.getElementById("modal-content-set-created").innerHTML = "Los datos para las tablas del Observatorio de Paz y Convivencia han sido eliminados correctamente.";
                        $("#modal-set-created").modal('show');
                    } else if (resp === "Error al eliminar") {
                        document.getElementById("modal-content-error").innerHTML = "Error al eliminar las tablas para el Observatorio de Paz y Convivencia.<br>Intente nuevamente.";
                        $("#modal-form-error").modal('show');
                    }
                    console.log(resp);
                }
            });
        }
    </script>
    <script>
        $('#submitCargarArchivoPiia').click(function () {
            var inputFile = document.getElementById("archivoInformacionPiia");
            var file = inputFile.files[0];
            var data = new FormData();
            data.append("archivoInformacionPiia", file);
            var url = "/app/view/modules/admin/cargarArchivo/funcionesArchivoOpc.php";
            $('#loadingIndicadoresPiia').show();
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    $('#resp').html(data);
                    $("#formCargarInformacionPiia")[0].reset();
                    $("#refrescar").show();
                    $('#loading').hide();
                }
            });
        });
    </script>
    <script>
        $('#submitCargarFichaPiia').click(function () {
            var inputFile = document.getElementById("archivoFichaPiia");
            var file = inputFile.files[0];
            var data = new FormData();
            data.append("archivoFichaPiia", file);
            var url = "/app/view/modules/admin/cargarArchivo/funcionesArchivoOpc.php";
            $('#loadingFichaPiia').show();
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    $('#resp').html(data);
                    $("#formCargarFichaTecnicaPiia")[0].reset();
                    $("#refrescar").show();
                    $('#loading').hide();
                }
            });
        });
    </script>
    <script>
        $('#submitCargarArchivoOdraf').click(function () {
            var inputFile = document.getElementById("archivoInformacionOdraf");
            var file = inputFile.files[0];
            var data = new FormData();
            data.append("archivoInformacionOdraf", file);
            var url = "/app/view/modules/admin/cargarArchivo/funcionesArchivoOpc.php";
            $('#loadingIndicadoresOdraf').show();
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    $('#resp').html(data);
                    $("#formCargarInformacionOdraf")[0].reset();
                    $("#refrescar").show();
                    $('#loadingIndicadoresOdraf').hide();
                }
            });
        });
    </script>
    <script>
        $('#submitCargarFichaOdraf').click(function () {
            var inputFile = document.getElementById("archivoFichaOdraf");
            var file = inputFile.files[0];
            var data = new FormData();
            data.append("archivoFichaOdraf", file);
            var url = "/app/view/modules/admin/cargarArchivo/funcionesArchivoOpc.php";
            $('#loadingFichaOdraf').show();
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    $('#resp').html(data);
                    $("#formCargarFichaTecnicaOdraf")[0].reset();
                    $("#refrescar").show();
                    $('#loadingFichaOdraf').hide();
                }
            });
        });
    </script>
    <script>
        $('#btn-accept').click(function () {
            location.reload();
        });
    </script>
    <!--Para cargar ODS-->
    <script>
        $('#submitCuatrenioODS').click(function () {
            var inputFile = document.getElementById("archivoCuatrenioODS");
            var file = inputFile.files[0];
            var data = new FormData();
            data.append("archivoCuatrenioODS", file);
            var url = "/app/view/modules/admin/cargarArchivo/funcionesArchivoOpc.php";
            $('#loadingCuatrenioODS').show();
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    $('#resp').html(data);
                    $("#formCuatrenioODS")[0].reset();
                    $("#refrescar").show();
                    $('#loadingCuatrenioODS').hide();
                }
            });
        });
    </script>
    <script>
        $('#submitSeguimientoODS').click(function () {
            var inputFile = document.getElementById("archivoSeguimientoODS");
            var file = inputFile.files[0];
            var data = new FormData();
            data.append("archivoSeguimientoODS", file);
            var url = "/app/view/modules/admin/cargarArchivo/funcionesArchivoOpc.php";
            $('#loadingSeguimientoODS').show();
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    $('#resp').html(data);
                    $("#formCargarSeguimientoODS")[0].reset();
                    $("#refrescar").show();
                    $('#loadingSeguimientoODS').hide();
                }
            });
        });
    </script>
    <script>
        $('#submitFichaODS').click(function () {
            var inputFile = document.getElementById("archivoFichaODS");
            var file = inputFile.files[0];
            var data = new FormData();
            data.append("archivoFichaODS", file);
            var url = "/app/view/modules/admin/cargarArchivo/funcionesArchivoOpc.php";
            $('#loadingFichaODS').show();
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    $('#resp').html(data);
                    $("#formCargarFichaODS")[0].reset();
                    $("#refrescar").show();
                    $('#loadingFichaODS').hide();
                }
            });
        });
    </script>
    
    <script>
        $('#submitCargarArchivoDadii').click(function () {
            var inputFile = document.getElementById("archivoInformacionDadii");
            var file = inputFile.files[0];
            var data = new FormData();
            data.append("archivoInformacionDadii", file);
            var url = "/app/view/modules/admin/cargarArchivo/funcionesArchivoOpc.php";
            $('#loadingIndicadoresDadii').show();
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    $('#resp').html(data);
                    $("#formCargarInformacionDadii")[0].reset();
                    $("#refrescar").show();
                    $('#loadingIndicadoresDadii').hide();
                }
            });
        });
    </script>
    <script>
        var conjunto = "#cargarArchivo" + "<?php echo $idConj; ?>";
        $(conjunto).addClass("active");
        $("#cargarArchivo").addClass("active");
    </script>

</html>


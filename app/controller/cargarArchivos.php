<?php

header("Content-Type: text/html;charset=utf-8");

class cargarArchivos {

    public function CargarArchivosSis($archivoSis) {
        set_time_limit(700);
        ini_set('memory_limit', '-1');
        $errors = array();
        $no_errors = 0;
        $no_warning = 0;
        $no_success = 0;
        $msgResult = array();
        $inputFileName = "";
        if (empty($_FILES)) {
            $errors[] = "Debe seleccionar un archivo";
        } else {
            $inputFileName = $_FILES["archivoInformacionC"]["tmp_name"];
        }
        $path = $_FILES['archivoInformacionC']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != "xls" && $ext != "xlsx") {
            $errors[] = "Los tipos de archivos permitidos son .xls y .xlsx";
            $errors[] = $ext;
        }
        if (count($errors) == 0) {
            $tiempo_inicio = microtime(true);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .
                        $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) {
                $fila = array();
                for ($col = "A"; $col <= $highestColumn; $col++) {
                    $contenidoCelda = $sheet->getCell($col . $row)->getFormattedValue();
                    array_push($fila, $contenidoCelda);
                }
                $idConjuntoIndicadores = "SIS";
                // Crear Dimensión
                $nombreDimensionCrear = trim($fila[0]);
                $posicion = "";
                $icono = "";
                $color = "";
                $dimen = new Dimension();
                $nombreDimensionExiste = $dimen->nombreDimensionExisteConjunto($nombreDimensionCrear, $idConjuntoIndicadores);
                $descripcionDimension = NULL;
                if (!$nombreDimensionExiste) {
                    $numeroDimensionesExp = $dimen->consultarUltimoId($idConjuntoIndicadores);
                    if (!empty($numeroDimensionesExp)) {
                        $consulta = explode('_', $numeroDimensionesExp[0]);
                        $idDimensionCrear = $idConjuntoIndicadores . "_" . ($consulta[1] + 1);
                    } else {
                        $idDimensionCrear = $idConjuntoIndicadores . "_" . "1";
                    }
                    $crearDimension = $dimen->crearDimension($idDimensionCrear, $nombreDimensionCrear, $descripcionDimension, $idConjuntoIndicadores, $posicion, $icono, $color);
                    if ($crearDimension == "Creada") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - La dimensión <strong> $nombreDimensionCrear </strong>fue creada satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear la dimensión <strong>$nombreDimensionCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - La dimensión <strong>$nombreDimensionCrear</strong> ya existe.
                                    </p>";
                }
                // Crear temática
                $nombreTematicaCrear = trim($fila[1]);
                $descripcionTematica = NULL;
                $dimension = new Dimension();
                $result = $dimension->nombreDimensionExisteConjunto($nombreDimensionCrear, $idConjuntoIndicadores);
                $idDimensionCrear = $result['idDimension'];
                $tematica = new Tematica();
                $nombreTematicaExiste = $tematica->nombreTematicaExisteDimension($nombreTematicaCrear, $idDimensionCrear);
                if (!$nombreTematicaExiste) {
                    $numeroTematicasPorDimension = $tematica->consultarUltimoId($idDimensionCrear);
                    if (!empty($numeroTematicasPorDimension)) {
                        $consulta = explode('_T', $numeroTematicasPorDimension[0]);
                        $idTematicaCrear = $idDimensionCrear . "_T" . ($consulta[1] + 1);
                    } else {
                        $idTematicaCrear = $idDimensionCrear . "_T" . "1";
                    }
                    $crearTematica = $tematica->crearTematica($idTematicaCrear, $nombreTematicaCrear, $descripcionTematica, $idDimensionCrear, $posicion);
                    if ($crearTematica == "Creada") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - La temática <strong> $nombreTematicaCrear </strong> fue creada satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear la temática <strong> $nombreTematicaCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - La temática <strong>$nombreTematicaCrear</strong> ya existe.
                                    </p>";
                }
                // Crear indicador
                $nombreIndicadorCrear = trim($fila[2]);
                $result2 = $tematica->nombreTematicaExisteDimension($nombreTematicaCrear, $idDimensionCrear);
                $idTematicaCrear = $result2['idTematica'];
                $indicador = new Indicador();
                $descripcionIndicador = NULL;
                $nombreIndicadorExist = $indicador->nombreIndicadorExisteTematica($nombreIndicadorCrear, $idTematicaCrear);
                if (!$nombreIndicadorExist) {
                    $numeroIndicadoresPorTematica = $indicador->consultarUltimoId($idTematicaCrear);
                    if (!empty($numeroIndicadoresPorTematica)) {
                        $consulta = explode('_I', $numeroIndicadoresPorTematica[0]);
                        $idIndicadorCrear = $idTematicaCrear . '_I' . ($consulta[1] + 1);
                    } else {
                        $idIndicadorCrear = $idTematicaCrear . '_I' . '1';
                    }
                    $mapa = NULL;
                    $activado = 1;
                    $crearIndicador = $indicador->crearIndicador($idIndicadorCrear, $nombreIndicadorCrear, $descripcionIndicador, $idTematicaCrear, $posicion, $mapa, $activado);
                    if ($crearIndicador == "Creado") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - El indicador <strong> $nombreIndicadorCrear </strong>fue creado satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear el indicador <strong> $nombreIndicadorCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - El indicador <strong>$nombreIndicadorCrear</strong> ya existe.
                                    </p>";
                }
                // Crear serie de datos
                $tipoDato = trim($fila[3]);
                $geografia = trim($fila[6]);
                $zonaActual = trim($fila[7]);
                $periodicidad = trim($fila[8]);
                $entidadGeneradora = trim($fila[9]);
                $fuenteDatos = trim($fila[10]);
                $urlDatos = trim($fila[11]);
                $desagregacionTematica = trim($fila[12]);
                $notas = trim($fila[13]);
                $unidadMedicion = trim($fila[14]);
                $numeroConsultas = 0;
                $idIndicadorCrear = $indicador->nombreIndicadorExiste($nombreIndicadorCrear, $idTematicaCrear);
                $nombreUnicoSerieCrear = $geografia . "_" . $zonaActual . "_" . $desagregacionTematica . "_" . $fuenteDatos . "_" . $idIndicadorCrear;
                $serieDato = new SerieDatos();
                $nombreSerieExisteIndicador = $serieDato->nombreUnicoSerieExisteIndicador($nombreUnicoSerieCrear, $idIndicadorCrear);
                if (!$nombreSerieExisteIndicador) {
                    $numeroSeriesPorIndicador = $serieDato->consultarUltimoId($idIndicadorCrear);
                    if (!empty($numeroSeriesPorIndicador)) {
                        $consulta = explode('_S', $numeroSeriesPorIndicador[0]);
                        $idSerieDatosCrear = $idIndicadorCrear . '_S' . ($consulta[1] + 1);
                    } else {
                        $idSerieDatosCrear = $idIndicadorCrear . '_S' . '1';
                    }
                    $crearSerie = $serieDato->crearSerieDatos($idSerieDatosCrear, $nombreUnicoSerieCrear, $tipoDato, $geografia, $zonaActual, $periodicidad, $entidadGeneradora, $fuenteDatos, $urlDatos, $desagregacionTematica, $notas, $unidadMedicion, $numeroConsultas, $idIndicadorCrear);
                    if ($crearSerie == "Creada") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - La serie de datos<strong> $nombreUnicoSerieCrear</strong>fue creada satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear la serie de datos<strong> $nombreUnicoSerieCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - La serie de datos <strong>$nombreUnicoSerieCrear</strong> ya existe.
                                    </p>";
                }
                // Agregar datos a serie
                $fechaDato = trim($fila[4]);
                settype($fechaDato, "string");
                $valorDato = trim($fila[5]);
                $result4 = $serieDato->nombreUnicoSerieExiste($nombreUnicoSerieCrear);
                $idSerieDatosCrear = $result4['idSerieDatos'];
                $dato = new Dato();
                $existeDato = $dato->existeDato($idSerieDatosCrear, $fechaDato);
                if (!$existeDato) {
                    $idDato = NULL;
                    $estadoObservacionDato = 'Provisional';
                    $agregarDato = $dato->crearDato($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idSerieDatosCrear);
                    if ($agregarDato == "Creado") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - El dato con fecha<strong> $fechaDato </strong>fue agregado satisfactoriamente a la serie $nombreUnicoSerieCrear.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al agregar el dato con fecha<strong> $fechaDato </strong>Serie $nombreUnicoSerieCrear.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - El dato con fecha <strong>$fechaDato</strong> ya existe.
                                    </p>";
                }
            }
            $tiempo_fin = microtime(true);
        }
        $tot = $no_success + $no_warning - + $no_errors;
        echo "  <div class='alert alert-dismissable' style='background-color:#d9edf7; color:#31708f;'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                    <strong>Carga finalizada</strong><br>
                    Aciertos: $no_success - Errores: $no_errors<br>
                    Mensajes informativos: $no_warning<br>
                    Total de mensajes: $tot<br>
                    Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.
                </div>";
        echo " <div class='alert alert-dismissable' style='background-color:#fff;border: 2px solid #aaa;'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>";
        foreach ($msgResult as $result) {
            echo $result;
        }
        echo "  </div>";
    }

    public function CargarFichaSis($archivoFichaSis) {
        set_time_limit(700);
        ini_set('memory_limit', '-1');
        $errors = array();
        $no_errors = 0;
        $no_warning = 0;
        $no_success = 0;
        $msgResult = array();
        $inputFileName = "";
        if (empty($_FILES)) {
            $errors[] = "Debe seleccionar un archivo";
        } else {
            $inputFileName = $_FILES["archivoFichaC"]["tmp_name"];
        }
        $path = $_FILES['archivoFichaC']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != "xls" && $ext != "xlsx") {
            $errors[] = "Los tipos de archivos permitidos son .xls y .xlsx";
            $errors[] = $ext;
        }
        if (count($errors) == 0) {
            $tiempo_inicio = microtime(true);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .
                        $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) {
                $fila = array();
                for ($col = "A"; $col <= $highestColumn; $col++) {
                    $contenidoCelda = $sheet->getCell($col . $row)->getFormattedValue();
                    array_push($fila, $contenidoCelda);
                }
                $idConjuntoIndicadores = "SIS";
                $nombreDimension = trim($fila[0]);
                $nombreTematica = trim($fila[1]);
                $nombreIndicador = trim($fila[2]);
                $sigla = trim($fila[3]);
                $justificacion = trim($fila[4]);
                $definicion = trim($fila[5]);
                $metodosMedicion = trim($fila[6]);
                $formulas = trim($fila[7]);
                $variables = trim($fila[8]);
                $valoresReferencia = trim($fila[9]);
                $naturaleza = trim($fila[10]);
                $desagregacionTematica = trim($fila[11]);
                $desagregacionGeografica = trim($fila[12]);
                $lineaBase = trim($fila[13]);
                $fuenteDatos = trim($fila[14]);
                $responsable = trim($fila[15]);
                $observaciones = trim($fila[16]);
                $fechaElaboracion = trim($fila[17]);
                $tipoGrafico = trim($fila[18]);
                $posicionTem = trim($fila[19]);
                $posicionInd = trim($fila[20]);
                $indicador = new Indicador;
                $tematica = new Tematica;
                $dimension = new Dimension();
                $result1 = $dimension->nombreDimensionExisteConjunto($nombreDimension, $idConjuntoIndicadores);
                $idDimensionCrear = $result1['idDimension'];
                $result2 = $tematica->nombreTematicaExisteDimension($nombreTematica, $idDimensionCrear);
                $idTematicaCrear = $result2['idTematica'];
                $idIndicador = $indicador->nombreIndicadorExiste($nombreIndicador, $idTematicaCrear);
                $fichaTecnica = new FichaTecnica;
                $fichaTecnicaExisParaIndicador = $fichaTecnica->fichaExisteIndicadorFuente($idConjuntoIndicadores, $idIndicador, $fuenteDatos);
                if (!$fichaTecnicaExisParaIndicador) {
                    $idFichaTecnica = NULL;
                    $crearFicha = $fichaTecnica->crearFicha($idFichaTecnica, $sigla, $justificacion, $definicion, $metodosMedicion, $formulas, $variables, $valoresReferencia, $naturaleza, $desagregacionTematica, $desagregacionGeografica, $lineaBase, $responsable, $observaciones, $fechaElaboracion, $idIndicador, $tipoGrafico, $fuenteDatos);
                    if ($crearFicha == "Creada") {
                        $tematica->editarPosicion($nombreTematica, $posicionTem);
                        $indicador->editarPosicion($idIndicador, $posicionInd);
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - La información de la ficha del indicador<strong> $nombreIndicador - $fuenteDatos </strong>fue agregada satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al cargar la información de la ficha del indicador<strong> $nombreIndicador - $fuenteDatos </strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - Ya existe la ficha del indicador<strong> $nombreIndicador - $fuenteDatos</strong>.
                                    </p>";
                }
            }
            $tiempo_fin = microtime(true);
        }
        $msgConfirm[] = "Los elementos ya existentes han sido omitidos. Carga finalizada.";
        $msgConfirm[] = "Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.";
        $tot = $no_success + $no_warning - + $no_errors;
        echo "  <div class='alert alert-dismissable' style='background-color:#d9edf7; color:#31708f;'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                    <strong>Carga finalizada</strong><br>
                    Aciertos: $no_success - Errores: $no_errors<br>
                    Mensajes informativos: $no_warning<br>
                    Total de mensajes: $tot<br>
                    Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.
                </div>";
        echo " <div class='alert alert-dismissable' style='background-color:#fff;border: 2px solid #aaa;'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>";
        foreach ($msgResult as $result) {
            echo $result;
        }
        echo "  </div>";
    }

    public function CargarArchivosIgc($archivoInformacionIGC) {
        set_time_limit(700);
        ini_set('memory_limit', '-1');
        $errors = array();
        $no_errors = 0;
        $no_warning = 0;
        $no_success = 0;
        $msgResult = array();
        $inputFileName = "";
        if (empty($_FILES)) {
            $errors[] = "Debe seleccionar un archivo";
        } else {
            $inputFileName = $_FILES["archivoInformacionIGC"]["tmp_name"];
        }
        $path = $_FILES['archivoInformacionIGC']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        if ($ext != "xls" && $ext != "xlsx") {
            $errors[] = "Los tipos de archivos permitidos son .xls y .xlsx";
            $errors[] = $ext;
        }
        if (count($errors) == 0) {
            $tiempo_inicio = microtime(true);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .
                        $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) {
                $fila = array();
                for ($col = "A"; $col <= $highestColumn; $col++) {
                    $contenidoCelda = $sheet->getCell($col . $row)->getFormattedValue();
                    array_push($fila, $contenidoCelda);
                }
                $idConjuntoIndicadores = "IGC";
                // Crear Dimensión
                $nombreDimensionCrear = $fila[0];
                $posicion = "";
                $icono = "";
                $color = "";
                $dimen = new Dimension();
                $nombreDimensionExiste = $dimen->nombreDimensionExisteConjunto($nombreDimensionCrear, $idConjuntoIndicadores);
                $descripcionDimension = NULL;
                if (!$nombreDimensionExiste) {
                    $numeroDimensionesExp = $dimen->consultarUltimoId($idConjuntoIndicadores);
                    if (!empty($numeroDimensionesExp)) {
                        $consulta = explode('_', $numeroDimensionesExp[0]);
                        $idDimensionCrear = $idConjuntoIndicadores . "_" . ($consulta[1] + 1);
                    } else {
                        $idDimensionCrear = $idConjuntoIndicadores . "_" . "1";
                    }
                    $crearDimension = $dimen->crearDimension($idDimensionCrear, $nombreDimensionCrear, $descripcionDimension, $idConjuntoIndicadores, $posicion, $icono, $color);
                    if ($crearDimension == "Creada") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - La dimensión <strong> $nombreDimensionCrear </strong>fue creada satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear la dimensión <strong> $nombreDimensionCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - La dimensión <strong> $nombreDimensionCrear </strong>ya existe.
                                    </p>";
                }
                // Crear temática
                $nombreTematicaCrear = $fila[1];
                $dimension = new Dimension();
                $result = $dimension->nombreDimensionExisteConjunto($nombreDimensionCrear, $idConjuntoIndicadores);
                $idDimensionCrear = $result['idDimension'];
                $tematica = new Tematica();
                $descripcionTematica = NULL;
                $nombreTematicaExiste = $tematica->nombreTematicaExisteDimension($nombreTematicaCrear, $idDimensionCrear);
                if (!$nombreTematicaExiste) {
                    $numeroTematicasPorDimension = $tematica->consultarUltimoId($idDimensionCrear);
                    if (!empty($numeroTematicasPorDimension)) {
                        $consulta = explode('_T', $numeroTematicasPorDimension[0]);
                        $idTematicaCrear = $idDimensionCrear . "_T" . ($consulta[1] + 1);
                    } else {
                        $idTematicaCrear = $idDimensionCrear . "_T" . "1";
                    }
                    $crearTematica = $tematica->crearTematica($idTematicaCrear, $nombreTematicaCrear, $descripcionTematica, $idDimensionCrear, $posicion);
                    if ($crearTematica == "Creada") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - La temática <strong> $nombreTematicaCrear </strong>fue creada satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear la temática <strong> $nombreTematicaCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - La temática <strong> $nombreTematicaCrear </strong>ya existe.
                                    </p>";
                }
                // Crear indicador
                $nombreIndicadorCrear = $fila[2];
                $result2 = $tematica->nombreTematicaExisteDimension($nombreTematicaCrear, $idDimensionCrear);
                $idTematicaCrear = $result2['idTematica'];
                $indicador = new Indicador();
                $descripcionIndicador = NULL;
                $nombreIndicadorExist = $indicador->nombreIndicadorExisteTematica($nombreIndicadorCrear, $idTematicaCrear);
                if (!$nombreIndicadorExist) {
                    $numeroIndicadoresPorTematica = $indicador->consultarUltimoId($idTematicaCrear);
                    if (!empty($numeroIndicadoresPorTematica)) {
                        $consulta = explode('_I', $numeroIndicadoresPorTematica[0]);
                        $idIndicadorCrear = $idTematicaCrear . "_I" . ($consulta[1] + 1);
                    } else {
                        $idIndicadorCrear = $idTematicaCrear . "_I" . "1";
                    }
                    $mapa = NULL;
                    $activado = 1;
                    $crearIndicador = $indicador->crearIndicador($idIndicadorCrear, $nombreIndicadorCrear, $descripcionIndicador, $idTematicaCrear, $posicion, $mapa, $activado);
                    if ($crearIndicador == "Creado") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - El indicador <strong> $nombreIndicadorCrear </strong>fue creado satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear el indicador <strong> $nombreIndicadorCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - El indicador <strong> $nombreIndicadorCrear </strong>ya existe.
                                    </p>";
                }
                // Crear serie de datos
                $tipoDato = $fila[3];
                $geografia = $fila[6];
                $zonaActual = $fila[7];
                $periodicidad = $fila[8];
                $entidadGeneradora = $fila[9];
                $fuenteDatos = $fila[10];
                $urlDatos = $fila[11];
                $desagregacionTematica = $fila[12];
                $notas = $fila[13];
                $unidadMedicion = $fila[14];
                $numeroConsultas = 0;
                $idIndicadorCrear = $indicador->nombreIndicadorExiste($nombreIndicadorCrear, $idTematicaCrear);
                $nombreUnicoSerieCrear = $geografia . "_" . $zonaActual . "_" . $desagregacionTematica . "_" . $idIndicadorCrear;
                $serieDato = new SerieDatos();
                $nombreExisteIndicador = $serieDato->nombreUnicoSerieExisteIndicador($nombreUnicoSerieCrear, $idIndicadorCrear);
                if (!$nombreExisteIndicador) {
                    $numeroSeriesPorIndicador = $serieDato->consultarUltimoId($idIndicadorCrear);
                    if (!empty($numeroSeriesPorIndicador)) {
                        $consulta = explode('_S', $numeroSeriesPorIndicador[0]);
                        $idSerieDatosCrear = $idIndicadorCrear . "_S" . ($consulta[1] + 1);
                    } else {
                        $idSerieDatosCrear = $idIndicadorCrear . "_S" . "1";
                    }
                    $crearSerie = $serieDato->crearSerieDatos($idSerieDatosCrear, $nombreUnicoSerieCrear, $tipoDato, $geografia, $zonaActual, $periodicidad, $entidadGeneradora, $fuenteDatos, $urlDatos, $desagregacionTematica, $notas, $unidadMedicion, $numeroConsultas, $idIndicadorCrear);
                    if ($crearSerie == "Creada") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - La serie de datos<strong> $nombreUnicoSerieCrear</strong>fue creada satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear la serie de datos<strong> $nombreUnicoSerieCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - La serie de datos<strong> $nombreUnicoSerieCrear </strong>ya existe.
                                    </p>";
                }
                // Agregar datos a serie
                $fechaDato = $fila[4];
                settype($fechaDato, "string");
                $valorDato = $fila[5];
                $result4 = $serieDato->nombreUnicoSerieExiste($nombreUnicoSerieCrear);
                $idSerieDatosCrear = $result4['idSerieDatos'];
                $dato = new Dato();
                $existeDato = $dato->existeDato($idSerieDatosCrear, $fechaDato);
                if (!$existeDato) {
                    $idDato = NULL;
                    $estadoObservacionDato = 'Provisional';
                    $agregarDato = $dato->crearDato($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idSerieDatosCrear);
                    if ($agregarDato == "Creado") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - El dato con fecha<strong> $fechaDato </strong>fue agregado satisfactoriamente a la serie $nombreUnicoSerieCrear.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al agregar el dato con fecha<strong> $fechaDato </strong>Serie $nombreUnicoSerieCrear.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - El dato con fecha<strong> $fechaDato </strong>ya existe.
                                    </p>";
                }
            }
            $tiempo_fin = microtime(true);
        }
        $tot = $no_success + $no_warning - + $no_errors;
        echo "  <div class='alert alert-dismissable' style='background-color:#d9edf7; color:#31708f;'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                    <strong>Carga finalizada</strong><br>
                    Aciertos: $no_success - Errores: $no_errors<br>
                    Mensajes informativos: $no_warning<br>
                    Total de mensajes: $tot<br>
                    Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.
                </div>";
        echo " <div class='alert alert-dismissable' style='background-color:#fff;border: 2px solid #aaa;'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>";
        foreach ($msgResult as $result) {
            echo $result;
        }
        echo "  </div>";
    }

    public function CargarFichaIgc($archivoFichaIGC) {
        set_time_limit(700);
        ini_set('memory_limit', '-1');
        $errors = array();
        $no_errors = 0;
        $no_warning = 0;
        $no_success = 0;
        $msgResult = array();
        $inputFileName = "";
        if (empty($_FILES)) {
            $errors[] = "Debe seleccionar un archivo";
        } else {
            $inputFileName = $_FILES["archivoFichaIGC"]["tmp_name"];
        }
        $path = $_FILES['archivoFichaIGC']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != "xls" && $ext != "xlsx") {
            $errors[] = "Los tipos de archivos permitidos son .xls y .xlsx";
            $errors[] = $ext;
        }
        if (count($errors) == 0) {
            $tiempo_inicio = microtime(true);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .
                        $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) {
                $fila = array();
                for ($col = "A"; $col <= $highestColumn; $col++) {
                    $contenidoCelda = $sheet->getCell($col . $row)->getFormattedValue();
                    array_push($fila, $contenidoCelda);
                }
                $idConjuntoIndicadores = "IGC";
                $nombreIndicador = $fila[0];
                $justificacion = $fila[1];
                $definicion = $fila[2];
                $metodologia = $fila[3];
                $referencia = $fila[4];
                $observacionesLimitaciones = $fila[5];
                $otrasOrganizaciones = $fila[6];
                $tipoGrafico = $fila[7];
                $posicionInd = $fila[8];
                $indicador = new Indicador;

                $idTematicaIndicador = $indicador->nombreIndicadorIgcExiste($nombreIndicador);
                $idIndicador = $indicador->nombreIndicadorExiste($nombreIndicador, $idTematicaIndicador);
                $fichaTecnica = new FichaTecnica;
                $fichaTecnicaExisParaIndicador = $fichaTecnica->fichaExisteIndicador($idConjuntoIndicadores, $idIndicador);
                if (!$fichaTecnicaExisParaIndicador) {
                    $idFichaTecnica = NULL;
                    $crearFicha = $fichaTecnica->crearFichaIGC($idFichaTecnica, $justificacion, $definicion, $metodologia, $referencia, $observacionesLimitaciones, $otrasOrganizaciones, $idIndicador, $tipoGrafico);
                    if ($crearFicha == "Creada") {
                        $indicador->editarPosicion($idIndicador, $posicionInd);
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - La información de la ficha del indicador<strong> $nombreIndicador </strong>fue agregada satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al cargar la información de la ficha del indicador<strong> $nombreIndicador </strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - La ficha del indicador<strong> $nombreIndicador </strong>ya existe.
                                    </p>";
                }
            }
            $tiempo_fin = microtime(true);
        }
        $tot = $no_success + $no_warning - + $no_errors;
        echo "  <div class='alert alert-dismissable' style='background-color:#d9edf7; color:#31708f;'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                    <strong>Carga finalizada</strong><br>
                    Aciertos: $no_success - Errores: $no_errors<br>
                    Mensajes informativos: $no_warning<br>
                    Total de mensajes: $tot<br>
                    Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.
                </div>";
        echo " <div class='alert alert-dismissable' style='background-color:#fff;border: 2px solid #aaa;'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>";
        foreach ($msgResult as $result) {
            echo $result;
        }
        echo "  </div>";
    }

    public function CargarArchivosExp($archivoInformacionExp) {
        set_time_limit(700);
        ini_set('memory_limit', '-1');
        $errors = array();
        $msgConfirm = array();
        $inputFileName = "";
        if (empty($_FILES)) {
            $errors[] = "Debe seleccionar un archivo";
        } else {
            $inputFileName = $_FILES["archivoInformacionExp"]["tmp_name"];
        }
        $path = $_FILES['archivoInformacionExp']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != "xls" && $ext != "xlsx") {
            $errors[] = "Los tipos de archivos permitidos son .xls y .xlsx";
            $errors[] = $ext;
        }
        if (count($errors) == 0) {
            $tiempo_inicio = microtime(true);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .
                        $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) {
                $fila = array();
                for ($col = "A"; $col <= $highestColumn; $col++) {
                    $contenidoCelda = $sheet->getCell($col . $row)->getFormattedValue();
                    array_push($fila, $contenidoCelda);
                }
                $idConjuntoIndicadores = "EXP";
                // Crear Dimensión
                $nombreDimensionCrear = $fila[0];
                $posicion = "";
                $icono = "";
                $color = "";
                $dimen = new Dimension();
                $nombreDimensionExiste = $dimen->nombreDimensionExisteConjunto($nombreDimensionCrear, $idConjuntoIndicadores);
                $descripcionDimension = NULL;
                if (!$nombreDimensionExiste) {
                    $numeroDimensionesExp = $dimen->consultarUltimoId($idConjuntoIndicadores);
                    if (!empty($numeroDimensionesExp)) {
                        $consulta = explode('_', $numeroDimensionesExp[0]);
                        $idDimensionCrear = $idConjuntoIndicadores . "_" . ($consulta[1] + 1);
                    } else {
                        $idDimensionCrear = $idConjuntoIndicadores . "_" . "1";
                    }
                    $crearDimension = $dimen->crearDimension($idDimensionCrear, $nombreDimensionCrear, $descripcionDimension, $idConjuntoIndicadores, $posicion, $icono, $color);
                    if ($crearDimension == "Creada") {
                        $msgConfirm[] = "La dimensión <strong> $nombreDimensionCrear </strong>fue creada satisfactoriamente.";
                    } else {
                        $errors[] = "Error al crear la dimensión <strong> $nombreDimensionCrear</strong>.";
                    }
                }
                // Crear temática
                $nombreTematicaCrear = $fila[1];
                $dimension = new Dimension();
                $result = $dimension->nombreDimensionExisteConjunto($nombreDimensionCrear, $idConjuntoIndicadores);
                $idDimensionCrear = $result['idDimension'];
                $tematica = new Tematica();
                $descripcionTematica = NULL;
                $nombreTematicaExiste = $tematica->nombreTematicaExisteDimension($nombreTematicaCrear, $idDimensionCrear);
                if (!$nombreTematicaExiste) {
                    $numeroTematicasPorDimension = $tematica->consultarUltimoId($idDimensionCrear);
                    if (!empty($numeroTematicasPorDimension)) {
                        $consulta = explode('_T', $numeroTematicasPorDimension[0]);
                        $idTematicaCrear = $idDimensionCrear . "_T" . ($consulta[1] + 1);
                    } else {
                        $idTematicaCrear = $idDimensionCrear . "_T" . "1";
                    }
                    $crearTematica = $tematica->crearTematica($idTematicaCrear, $nombreTematicaCrear, $descripcionTematica, $idDimensionCrear, $posicion);
                    if ($crearTematica == "Creada") {
                        $msgConfirm[] = "La temática <strong> $nombreTematicaCrear </strong>fue creada satisfactoriamente.";
                    } else {
                        $errors[] = "Error al crear la temática <strong> $nombreTematicaCrear</strong>.";
                    }
                }
                // Crear indicador
                $nombreIndicadorCrear = $fila[2];
                $result2 = $tematica->nombreTematicaExisteDimension($nombreTematicaCrear, $idDimensionCrear);
                $idTematicaCrear = $result2['idTematica'];
                $indicador = new Indicador();
                $descripcionIndicador = NULL;
                $nombreIndicadorExist = $indicador->nombreIndicadorExisteTematica($nombreIndicadorCrear, $idTematicaCrear);
                if (!$nombreIndicadorExist) {
                    $numeroIndicadoresPorTematica = $indicador->consultarUltimoId($idTematicaCrear);
                    if (!empty($numeroIndicadoresPorTematica)) {
                        $consulta = explode('_I', $numeroIndicadoresPorTematica[0]);
                        $idIndicadorCrear = $idTematicaCrear . "_I" . ($consulta[1] + 1);
                    } else {
                        $idIndicadorCrear = $idTematicaCrear . "_I" . "1";
                    }
                    $mapa = NULL;
                    $activado = 1;
                    $crearIndicador = $indicador->crearIndicador($idIndicadorCrear, $nombreIndicadorCrear, $descripcionIndicador, $idTematicaCrear, $posicion, $mapa, $activado);
                    if ($crearIndicador == "Creado") {
                        $msgConfirm[] = "El indicador <strong> $nombreIndicadorCrear </strong>fue creado satisfactoriamente.";
                    } else {
                        $errors[] = "Error al crear el indicador <strong> $nombreIndicadorCrear</strong>.";
                    }
                }
                // Crear serie de datos
                $tipoDato = $fila[3];
                $geografia = $fila[6];
                $zonaActual = $fila[7];
                $periodicidad = $fila[8];
                $entidadGeneradora = $fila[9];
                $fuenteDatos = $fila[10];
                $urlDatos = $fila[11];
                $desagregacionTematica = $fila[12];
                $notas = $fila[13];
                $unidadMedicion = $fila[14];
                $numeroConsultas = 0;
                $idIndicadorCrear = $indicador->nombreIndicadorExiste($nombreIndicadorCrear, $idTematicaCrear);
                $nombreUnicoSerieCrear = $geografia . "_" . $zonaActual . "_" . $desagregacionTematica . "_" . $idIndicadorCrear;
                $serieDato = new SerieDatos();
                $nombreExisteIndicador = $serieDato->nombreUnicoSerieExisteIndicador($nombreUnicoSerieCrear, $idIndicadorCrear);
                if (!$nombreExisteIndicador) {
//            $numeroSeriesPorIndicador = $serieDato->contarSeriesPorIndicador($idIndicadorCrear);
//            $idSerieDatosCrear = $idIndicadorCrear . "S" . ($numeroSeriesPorIndicador + 1);
                    $numeroSeriesPorIndicador = $serieDato->consultarUltimoId($idIndicadorCrear);
                    if (!empty($numeroSeriesPorIndicador)) {
                        $consulta = explode('_S', $numeroSeriesPorIndicador[0]);
                        $idSerieDatosCrear = $idIndicadorCrear . "_S" . ($consulta[1] + 1);
                    } else {
                        $idSerieDatosCrear = $idIndicadorCrear . "_S" . "1";
                    }
                    // AUMENTAR ID INDICADOR A 15 EN LA BD
                    $crearSerie = $serieDato->crearSerieDatos($idSerieDatosCrear, $nombreUnicoSerieCrear, $tipoDato, $geografia, $zonaActual, $periodicidad, $entidadGeneradora, $fuenteDatos, $urlDatos, $desagregacionTematica, $notas, $unidadMedicion, $numeroConsultas, $idIndicadorCrear);
                    if ($crearSerie == "Creada") {
                        $msgConfirm[] = "La serie de datos<strong> $nombreUnicoSerieCrear</strong>fue creada satisfactoriamente.";
                    } else {
                        $errors[] = "Error al crear la serie de datos<strong> $nombreUnicoSerieCrear</strong>.";
                    }
                }
                // Agregar datos a serie
                $fechaDato = $fila[4];
                settype($fechaDato, "string");
                $valorDato = $fila[5];
                $result4 = $serieDato->nombreUnicoSerieExiste($nombreUnicoSerieCrear);
                $idSerieDatosCrear = $result4['idSerieDatos'];
                $dato = new Dato();
                $existeDato = $dato->existeDato($idSerieDatosCrear, $fechaDato);
                if (!$existeDato) {
                    $idDato = NULL;
                    $estadoObservacionDato = 'Provisional';
                    $agregarDato = $dato->crearDato($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idSerieDatosCrear);
                    if ($agregarDato == "Creado") {
                        $msgConfirm[] = "El dato con fecha<strong> $fechaDato </strong>fue agregado satisfactoriamente a la serie $nombreUnicoSerieCrear.";
                    } else {
                        $errors[] = "Error al agregar el dato con fecha<strong> $fechaDato </strong>Serie $nombreUnicoSerieCrear.";
                    }
                }
            }
            $tiempo_fin = microtime(true);
            $msgConfirm[] = "Los elementos ya existentes han sido omitidos. Carga finalizada.";
            $msgConfirm[] = "Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.";
        }
        echo resultBlock($errors);
        echo resultConfirm($msgConfirm);
    }

    public function CargarFichaExp($archivoFichaExp) {
        set_time_limit(700);
        ini_set('memory_limit', '-1');
        $errors = array();
        $msgConfirm = array();
        $inputFileName = "";
        if (empty($_FILES)) {
            $errors[] = "Debe seleccionar un archivo";
        } else {
            $inputFileName = $_FILES["archivoFichaExp"]["tmp_name"];
        }
        $path = $_FILES['archivoFichaExp']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != "xls" && $ext != "xlsx") {
            $errors[] = "Los tipos de archivos permitidos son .xls y .xlsx";
            $errors[] = $ext;
        }
        if (count($errors) == 0) {
            $tiempo_inicio = microtime(true);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .
                        $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) {
                $fila = array();
                for ($col = "A"; $col <= $highestColumn; $col++) {
                    $contenidoCelda = $sheet->getCell($col . $row)->getFormattedValue();
                    array_push($fila, $contenidoCelda);
                }
                $idConjuntoIndicadores = "EXP";
                $nombreDimension = trim($fila[0]);
                $nombreTematica = trim($fila[1]);
                $nombreIndicador = trim($fila[2]);
                $sigla = trim($fila[3]);
                $justificacion = trim($fila[4]);
                $definicion = trim($fila[5]);
                $metodosMedicion = trim($fila[6]);
                $formulas = trim($fila[7]);
                $variables = trim($fila[8]);
                $valoresReferencia = trim($fila[9]);
                $naturaleza = trim($fila[10]);
                $desagregacionTematica = trim($fila[11]);
                $desagregacionGeografica = trim($fila[12]);
                $lineaBase = trim($fila[13]);
                $fuenteDatos = trim($fila[14]);
                $responsable = trim($fila[15]);
                $observaciones = trim($fila[16]);
                $fechaElaboracion = trim($fila[17]);
                $tipoGrafico = trim($fila[18]);
                $posicionTem = trim($fila[19]);
                $posicionInd = trim($fila[20]);
                $indicador = new Indicador;
                $tematica = new Tematica;
                $dimension = new Dimension();
                $result1 = $dimension->nombreDimensionExisteConjunto($nombreDimension, $idConjuntoIndicadores);
                $idDimensionCrear = $result1['idDimension'];
                $result2 = $tematica->nombreTematicaExisteDimension($nombreTematica, $idDimensionCrear);
                $idTematicaCrear = $result2['idTematica'];
                $idIndicador = $indicador->nombreIndicadorExiste($nombreIndicador, $idTematicaCrear);
                $fichaTecnica = new FichaTecnica;
//        $fichaTecnicaExisParaIndicador = $fichaTecnica->fichaTecnicaExisParaIndicador($idIndicador);
                $fichaTecnicaExisParaIndicador = $fichaTecnica->fichaExisteIndicador($idConjuntoIndicadores, $idIndicador);
                if (!$fichaTecnicaExisParaIndicador) {
                    $idFichaTecnica = NULL;
                    $crearFicha = $fichaTecnica->crearFicha($idFichaTecnica, $sigla, $justificacion, $definicion, $metodosMedicion, $formulas, $variables, $valoresReferencia, $naturaleza, $desagregacionTematica, $desagregacionGeografica, $lineaBase, $responsable, $observaciones, $fechaElaboracion, $idIndicador, $tipoGrafico, $fuenteDatos);
                    if ($crearFicha == "Creada") {
                        $msgConfirm[] = "La información de la ficha del indicador<strong> $nombreIndicador </strong>fue agregada satisfactoriamente.";
                        $tematica->editarPosicion($nombreTematica, $posicionTem);
                        $indicador->editarPosicion($idIndicador, $posicionInd);
                    } else {
                        $errors[] = "Error al cargar la información de la ficha del indicador<strong> $nombreIndicador </strong>.";
                    }
                }
            }
            $tiempo_fin = microtime(true);
            $msgConfirm[] = "Los elementos ya existentes han sido omitidos. Carga finalizada.";
            $msgConfirm[] = "Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.";
        }
        echo resultBlock($errors);
        echo resultConfirm($msgConfirm);
    }

    public function CargarArchivosPiia($archivoInformacionPiia) {
        session_start();
        set_time_limit(700);
        ini_set('memory_limit', '-1');
        $errors = array();
        $msgConfirm = array();
        $inputFileName = "";
        if (empty($_FILES)) {
            $errors[] = "Debe seleccionar un archivo";
        } else {
            $inputFileName = $_FILES["archivoInformacionPiia"]["tmp_name"];
        }
        $path = $_FILES["archivoInformacionPiia"]['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != "xls" && $ext != "xlsx") {
            $errors[] = "Los tipos de archivos permitidos son .xls y .xlsx";
            $errors[] = $ext;
        }

        if (count($errors) == 0) {
            $tiempo_inicio = microtime(true);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .
                        $e->getMessage());
            }

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            for ($row = 2; $row <= $highestRow; $row++) {
                $fila = array();
                for ($col = "A"; $col <= $highestColumn; $col++) {
                    $contenidoCelda = $sheet->getCell($col . $row)->getFormattedValue();
                    array_push($fila, $contenidoCelda);
                }

                $idConjuntoIndicadores = "PIIA";
                // Crear Dimensión
                $nombreDimensionCrear = trim($fila[0]);
                $posicion = "";
                $icono = "";
                $color = "";
                $dimen = new Dimension();
                $nombreDimensionExiste = $dimen->nombreDimensionExisteConjunto($nombreDimensionCrear, $idConjuntoIndicadores);
                $descripcionDimension = NULL;
                if (!$nombreDimensionExiste) {
                    $numeroDimensionesPiia = $dimen->consultarUltimoId($idConjuntoIndicadores);
                    if (!empty($numeroDimensionesPiia)) {
                        $consulta = explode('_', $numeroDimensionesPiia[0]);
                        $idDimensionCrear = $idConjuntoIndicadores . "_" . ($consulta[1] + 1);
                    } else {
                        $idDimensionCrear = $idConjuntoIndicadores . "_" . "1";
                    }
                    $crearDimension = $dimen->crearDimension($idDimensionCrear, $nombreDimensionCrear, $descripcionDimension, $idConjuntoIndicadores, $posicion, $icono, $color);
                    if ($crearDimension == "Creada") {
                        $msgConfirm[] = "La dimensión <strong> $nombreDimensionCrear </strong>fue creada satisfactoriamente.";
                    } else {
                        $errors[] = "Error al crear la dimensión <strong> $nombreDimensionCrear</strong>.";
                    }
                }

                // Crear temática
                $nombreTematicaCrear = trim($fila[1]);
                $dimension = new Dimension();
                $result = $dimension->nombreDimensionExisteConjunto($nombreDimensionCrear, $idConjuntoIndicadores);
                $idDimensionCrear = $result['idDimension'];
                $tematica = new Tematica();
                $descripcionTematica = NULL;
                $nombreTematicaExiste = $tematica->nombreTematicaExisteDimension($nombreTematicaCrear, $idDimensionCrear);
                if (!$nombreTematicaExiste) {
                    $numeroTematicasPorDimension = $tematica->consultarUltimoId($idDimensionCrear);
                    if (!empty($numeroTematicasPorDimension)) {
                        $consulta = explode('_T', $numeroTematicasPorDimension[0]);
                        $idTematicaCrear = $idDimensionCrear . "_T" . ($consulta[1] + 1);
                    } else {
                        $idTematicaCrear = $idDimensionCrear . "_T" . "1";
                    }
                    $crearTematica = $tematica->crearTematica($idTematicaCrear, $nombreTematicaCrear, $descripcionTematica, $idDimensionCrear, $posicion);
                    if ($crearTematica == "Creada") {
                        $msgConfirm[] = "La temática <strong> $nombreTematicaCrear </strong>fue creada satisfactoriamente.";
                    } else {
                        $errors[] = "Error al crear la temática <strong> $nombreTematicaCrear</strong>.";
                    }
                }

                // Crear indicador
                $nombreIndicadorCrear = trim($fila[2]);
                $result2 = $tematica->nombreTematicaExisteDimension($nombreTematicaCrear, $idDimensionCrear);
                $idTematicaCrear = $result2['idTematica'];
                $indicador = new Indicador();
                $descripcionIndicador = NULL;
                $nombreIndicadorExist = $indicador->nombreIndicadorExisteTematica($nombreIndicadorCrear, $idTematicaCrear);
                if (!$nombreIndicadorExist) {
                    $numeroIndicadoresPorTematica = $indicador->consultarUltimoId($idTematicaCrear);
                    if (!empty($numeroIndicadoresPorTematica)) {
                        $consulta = explode('_I', $numeroIndicadoresPorTematica[0]);
                        $idIndicadorCrear = $idTematicaCrear . '_I' . ($consulta[1] + 1);
                    } else {
                        $idIndicadorCrear = $idTematicaCrear . '_I' . '1';
                    }
                    $mapa = NULL;
                    $activado = 1;
                    $crearIndicador = $indicador->crearIndicador($idIndicadorCrear, $nombreIndicadorCrear, $descripcionIndicador, $idTematicaCrear, $posicion, $mapa, $activado);
                    if ($crearIndicador == "Creado") {
                        $msgConfirm[] = "El indicador <strong> $nombreIndicadorCrear </strong>fue creado satisfactoriamente.";
                    } else {
                        $errors[] = "Error al crear el indicador <strong> $nombreIndicadorCrear</strong>.";
                    }
                }

                // Crear serie de datos
                $tipoDato = trim($fila[3]);
                $geografia = trim($fila[6]);
                $zonaActual = trim($fila[7]);
                $periodicidad = trim($fila[8]);
                $entidadGeneradora = trim($fila[9]);
                $fuenteDatos = trim($fila[10]);
                $urlDatos = trim($fila[11]);
                $desagregacionTematica = trim($fila[12]);
                $notas = trim($fila[13]);
                $unidadMedicion = trim($fila[14]);
                $numeroConsultas = 0;

                $idIndicadorCrear = $indicador->nombreIndicadorExiste($nombreIndicadorCrear, $idTematicaCrear);
                $nombreUnicoSerieCrear = $geografia . "_" . $zonaActual . "_" . $desagregacionTematica . "_" . $idIndicadorCrear;
                $serieDato = new SerieDatos();
                $nombreExisteIndicador = $serieDato->nombreUnicoSerieExisteIndicador($nombreUnicoSerieCrear, $idIndicadorCrear);
                if (!$nombreExisteIndicador) {
                    $numeroSeriesPorIndicador = $serieDato->consultarUltimoId($idIndicadorCrear);
                    if (!empty($numeroSeriesPorIndicador)) {
                        $consulta = explode('_S', $numeroSeriesPorIndicador[0]);
                        $idSerieDatosCrear = $idIndicadorCrear . '_S' . ($consulta[1] + 1);
                    } else {
                        $idSerieDatosCrear = $idIndicadorCrear . '_S' . '1';
                    }
                    // AUMENTAR ID INDICADOR A 15 EN LA BD
                    $crearSerie = $serieDato->crearSerieDatos($idSerieDatosCrear, $nombreUnicoSerieCrear, $tipoDato, $geografia, $zonaActual, $periodicidad, $entidadGeneradora, $fuenteDatos, $urlDatos, $desagregacionTematica, $notas, $unidadMedicion, $numeroConsultas, $idIndicadorCrear);
                    if ($crearSerie == "Creada") {
                        $msgConfirm[] = "La serie de datos<strong> $nombreUnicoSerieCrear</strong>fue creada satisfactoriamente.";
                    } else {
                        $errors[] = "Error al crear la serie de datos<strong> $nombreUnicoSerieCrear</strong>.";
                    }
                }
                // Agregar datos a serie
                $fechaDato = trim($fila[4]);
                settype($fechaDato, "string");
                $valorDato = trim($fila[5]);

                $result4 = $serieDato->nombreUnicoSerieExiste($nombreUnicoSerieCrear);
                $idSerieDatosCrear = $result4['idSerieDatos'];
                $dato = new Dato();
                $existeDato = $dato->existeDato($idSerieDatosCrear, $fechaDato);
                if (!$existeDato) {
                    $idDato = NULL;
                    $estadoObservacionDato = 'Provisional';
                    $agregarDato = $dato->crearDato($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idSerieDatosCrear);
                    if ($agregarDato == "Creado") {
                        $msgConfirm[] = "El dato con fecha<strong> $fechaDato </strong>fue agregado satisfactoriamente a la serie $nombreUnicoSerieCrear.";
                    } else {
                        $errors[] = "Error al agregar el dato con fecha<strong> $fechaDato </strong>Serie $nombreUnicoSerieCrear.";
                    }
                }
            }
            $tiempo_fin = microtime(true);
            $msgConfirm[] = "Los elementos ya existentes han sido omitidos. Carga finalizada.";
            $msgConfirm[] = "Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.";
        }
        echo resultBlock($errors);
        echo resultConfirm($msgConfirm);
    }

    public function CargarFichaPiia($archivoFichaPiia) {
        set_time_limit(700);
        ini_set('memory_limit', '-1');
        $errors = array();
        $msgConfirm = array();
        $inputFileName = "";
        if (empty($_FILES)) {
            $errors[] = "Debe seleccionar un archivo";
        } else {
            $inputFileName = $_FILES["archivoFichaPiia"]["tmp_name"];
        }
        $path = $_FILES['archivoFichaPiia']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != "xls" && $ext != "xlsx") {
            $errors[] = "Los tipos de archivos permitidos son .xls y .xlsx";
            $errors[] = $ext;
        }
        if (count($errors) == 0) {
            $tiempo_inicio = microtime(true);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .
                        $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) {
                $fila = array();
                for ($col = "A"; $col <= $highestColumn; $col++) {
                    $contenidoCelda = $sheet->getCell($col . $row)->getFormattedValue();
                    array_push($fila, $contenidoCelda);
                }
                $idConjuntoIndicadores = "PIIA";
                $nombreDimension = trim($fila[0]);
                $nombreTematica = trim($fila[1]);
                $nombreIndicador = trim($fila[2]);
                $sigla = trim($fila[3]);
                $justificacion = trim($fila[4]);
                $definicion = trim($fila[5]);
                $metodosMedicion = trim($fila[6]);
                $formulas = trim($fila[7]);
                $variables = trim($fila[8]);
                $valoresReferencia = trim($fila[9]);
                $naturaleza = trim($fila[10]);
                $desagregacionTematica = trim($fila[11]);
                $desagregacionGeografica = trim($fila[12]);
                $lineaBase = trim($fila[13]);
                $responsable = trim($fila[14]);
                $observaciones = trim($fila[15]);
                $fechaElaboracion = trim($fila[16]);
                $tipoGrafico = trim($fila[17]);
                $posicionTem = trim($fila[18]);
                $posicionInd = trim($fila[19]);
                $indicador = new Indicador;
                $tematica = new Tematica;
                $dimension = new Dimension();
                $result1 = $dimension->nombreDimensionExisteConjunto($nombreDimension, $idConjuntoIndicadores);
                $idDimensionCrear = $result1['idDimension'];
                $result2 = $tematica->nombreTematicaExisteDimension($nombreTematica, $idDimensionCrear);
                $idTematicaCrear = $result2['idTematica'];
                $idIndicador = $indicador->nombreIndicadorExiste($nombreIndicador, $idTematicaCrear);

                $fichaTecnica = new FichaTecnica;
//        $fichaTecnicaExisParaIndicador = $fichaTecnica->fichaTecnicaExisParaIndicador($idIndicador);
                $fichaTecnicaExisParaIndicador = $fichaTecnica->fichaExisteIndicador($idConjuntoIndicadores, $idIndicador);
                if (!$fichaTecnicaExisParaIndicador) {
                    $idFichaTecnica = NULL;
                    $crearFicha = $fichaTecnica->crearFicha($idFichaTecnica, $sigla, $justificacion, $definicion, $metodosMedicion, $formulas, $variables, $valoresReferencia, $naturaleza, $desagregacionTematica, $desagregacionGeografica, $lineaBase, $responsable, $observaciones, $fechaElaboracion, $idIndicador, $tipoGrafico);
                    if ($crearFicha == "Creada") {
                        $msgConfirm[] = "La información de la ficha del indicador<strong> $nombreIndicador </strong>fue agregada satisfactoriamente.";
                        $tematica->editarPosicion($nombreTematica, $posicionTem);
                        $indicador->editarPosicion($idIndicador, $posicionInd);
                    } else {
                        $errors[] = "Error al cargar la información de la ficha del indicador<strong> $nombreIndicador </strong>.";
                    }
                }
            }
            $tiempo_fin = microtime(true);
            $msgConfirm[] = "Los elementos ya existentes han sido omitidos. Carga finalizada.";
            $msgConfirm[] = "Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.";
        }
        echo resultBlock($errors);
        echo resultConfirm($msgConfirm);
    }

    public function CargarArchivoOpc($archivoOpc) {
        set_time_limit(10000);
        ini_set('memory_limit', '-1');
        $errors = array();
        $msgConfirm = array();
        $inputFileName = "";
        if (empty($_FILES)) {
            $errors[] = "Debe seleccionar un archivo";
        } else {
            $inputFileName = $_FILES["archivoInformacionOpc"]["tmp_name"];
        }
        $path = $_FILES['archivoInformacionOpc']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != "xls" && $ext != "xlsx" && $ext != "csv") {
            $errors[] = "Los tipos de archivos permitidos son .xls y .xlsx";
            $errors[] = $ext;
        }
        if (count($errors) == 0) {
            $tiempo_inicio = microtime(true);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .
                        $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD'];
            $count = sizeof($letters);
            for ($row = 2; $row <= $highestRow; $row++) {
                $fila = array();
                for ($i = 0; $i < $count; $i++) {
                    $col = $letters[$i];
                    $contenidoCelda = $sheet->getCell($col . $row)->getFormattedValue();

                    if ($contenidoCelda == "") {
                        $contenidoCelda = "-";
                    }
                    array_push($fila, $contenidoCelda);
                }
                $id_delito = "";
                $conflictividad_delito = $fila[0];
                $estacion_delito = $fila[1];
                $sitio_delito = $fila[2];
                $arma_delito = $fila[3];
                $movil_agresor_delito = $fila[4];
                $movil_victima_delito = $fila[5];
                $cantidad_victima_delito = $fila[6];
                $archivoOpc = new archivoOpc();
                $crearDelitoOpc = $archivoOpc->crearOpcDelito($id_delito, $conflictividad_delito, $estacion_delito, $sitio_delito, $arma_delito, $movil_agresor_delito, $movil_victima_delito, $cantidad_victima_delito);
                if ($crearDelitoOpc == "Creado") {
                    $idDelito = $archivoOpc->traeUltimoIdDelito();
                    $msgConfirm[] = "El delito <strong> $idDelito </strong>fue creado satisfactoriamente.";
                } else {
                    $errors[] = "Error al crear el delito <strong> $conflictividad_delito ." - ". $estacion_delito." - ".$sitio_delito." - ".$arma_delito</strong>.";
                }
                $idMarcaTemporal = "";
                $fecha_marca = $fila[7];
                $fecha_marca_temporal = PHPExcel_Style_NumberFormat :: toFormattedString($fecha_marca, "YYYY-MM-DD");
                $anho_marca_temporal = $fila[8];
                $mes_marca_temporal = $fila[9];
                $semana_marca_temporal = $fila[10];
                $dia_numero_marca_temporal = $fila[11];
                $dia_marca_temporal = $fila[12];
                $fecha_especial_marca_temporal = $fila[13];
                $hora_24h = $fila[14];
                $hora_24h_marca_temporal = PHPExcel_Style_NumberFormat :: toFormattedString($hora_24h, "h:i:s");
                $hora_24x_marca_temporal = $fila[15];
                $idDelito;
                $crearMarcaTemporalOpc = $archivoOpc->crearOpcMarcaTemporal($idMarcaTemporal, $fecha_marca_temporal, $anho_marca_temporal, $mes_marca_temporal, $semana_marca_temporal, $dia_numero_marca_temporal, $dia_marca_temporal, $fecha_especial_marca_temporal, $hora_24h_marca_temporal, $hora_24x_marca_temporal, $idDelito);
                if ($crearMarcaTemporalOpc !== "Creado") {
                    $errors[] = "Error al crear la marca temporal para el delito  <strong> $idDelito</strong>.";
                }
//        if ($crearMarcaTemporalOpc == "Creado") {
//            $msgConfirm[] = "La marca temporal para el delito <strong> $idDelito </strong>fue creada satisfactoriamente.";
//        } else {
//            $errors[] = "Error al crear la marca temporal para el delito  <strong> $idDelito</strong>.";
//        }
                $idZonaGeografica = "";
                $tipoZonaGeografica = $fila[16];
                $zonaMetropolitana = $fila[17];
                $idUnidadGeografica = $fila[18];
                $nombreInvasion = $fila[19];
                $nombreZoi = $fila[20];
                $idDelito;
                $crearZonaGeograficaOpc = $archivoOpc->crearOpcZonaGeografica($idZonaGeografica, $tipoZonaGeografica, $zonaMetropolitana, $idUnidadGeografica, $nombreInvasion, $nombreZoi, $idDelito);
                if ($crearZonaGeograficaOpc !== "Creado") {
                    $errors[] = "Error al crear la zona geografica para el delito  <strong> $idDelito</strong>.";
                }
//        if ($crearZonaGeograficaOpc == "Creado") {
//            $msgConfirm[] = "La zona geografica para el delito <strong> $idDelito </strong>fue creada satisfactoriamente.";
//        } else {
//            $errors[] = "Error al crear la zona geografica para el delito  <strong> $idDelito</strong>.";
//        }
                $idVictima = "";
                $sexoVictima = $fila[21];
                $edadVictima = $fila[22];
                $edad5QVictima = $fila[23];
                $edadNNAJVictima = $fila[24];
                $estadoCivilVictima = $fila[25];
                $paisNacimientoVictima = $fila[26];
                $claseEmpleoVictima = $fila[27];
                $profesionVictima = $fila[28];
                $escolaridadVictima = $fila[29];
                $idDelito;
                $crearVictimaOpc = $archivoOpc->crearOpcVictima($idVictima, $sexoVictima, $edadVictima, $edad5QVictima, $edadNNAJVictima, $estadoCivilVictima, $paisNacimientoVictima, $claseEmpleoVictima, $profesionVictima, $escolaridadVictima, $idDelito);
                if ($crearVictimaOpc !== "Creado") {
                    $errors[] = "Error al crear la victima para el delito  <strong> $idDelito</strong>.";
                }
//        if ($crearVictimaOpc == "Creado") {
//            $msgConfirm[] = "La victima para el delito <strong> $idDelito </strong>fue creada satisfactoriamente.";
//        } else {
//            $errors[] = "Error al crear la victima para el delito  <strong> $idDelito</strong>.";
//        }
            }
            $tiempo_fin = microtime(true);
            $msgConfirm[] = "Los elementos ya existentes han sido omitidos. Carga finalizada.";
            $msgConfirm[] = "Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.";
        }
        echo resultBlock($errors);
        echo resultConfirm($msgConfirm);
    }

    public function eliminarData($inputFileName) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "dimensiones";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $archivoOpc = new archivoOpc();
        if ($inputFileName == "eliminarData") {
            $delito = $archivoOpc->eliminarOpcDelito();
            $marcaTemporal = $archivoOpc->eliminarOpcMarcaTemporal();
            $zonaGeografica = $archivoOpc->eliminarOpcZonaGeografica();
            $victima = $archivoOpc->eliminarOpcVictima();
            if (($delito && $marcaTemporal && $zonaGeografica && $victima ) == "Eliminado") {
                $resp = "Eliminado";
                $log->crearLog($idModulo, "Data eliminada para las tablas de: Delito, Marca Temporal, Zona Geografica, Victima. Correctamente");
                return "Eliminado";
            } else {
                $resp = "Error al eliminar";
                $log->crearLog($idModulo, "Error al eliminar la data para  " . $delito . $marcaTemporal . $zonaGeografica . $victima);
                return "Error al eliminar";
            }
        }
    }

    public function CargarArchivosOdraf($archivoInformacionOdraf) {
        set_time_limit(700);
        ini_set('memory_limit', '-1');
        $errors = array();
        $msgConfirm = array();
        $inputFileName = "";
        if (empty($_FILES)) {
            $errors[] = "Debe seleccionar un archivo";
        } else {
            $inputFileName = $_FILES["archivoInformacionOdraf"]["tmp_name"];
        }
        $path = $_FILES['archivoInformacionOdraf']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != "xls" && $ext != "xlsx") {
            $errors[] = "Los tipos de archivos permitidos son .xls y .xlsx";
            $errors[] = $ext;
        }
        if (count($errors) == 0) {
            $tiempo_inicio = microtime(true);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .
                        $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) {
                $fila = array();
                for ($col = "A"; $col <= $highestColumn; $col++) {
                    $contenidoCelda = $sheet->getCell($col . $row)->getFormattedValue();
                    array_push($fila, $contenidoCelda);
                }
                $idConjuntoIndicadores = "ODRAF";
                // Crear Dimensión
                $nombreDimensionCrear = trim($fila[0]);
                $posicion = "";
                $icono = "";
                $color = "";
                $dimen = new Dimension();
                $nombreDimensionExiste = $dimen->nombreDimensionExisteConjunto($nombreDimensionCrear, $idConjuntoIndicadores);
                $descripcionDimension = NULL;
                if (!$nombreDimensionExiste) {
                    $numeroDimensionesOdraf = $dimen->consultarUltimoId($idConjuntoIndicadores);
                    if (!empty($numeroDimensionesOdraf)) {
                        $consulta = explode('_', $numeroDimensionesOdraf[0]);
                        $idDimensionCrear = $idConjuntoIndicadores . "_" . ($consulta[1] + 1);
                    } else {
                        $idDimensionCrear = $idConjuntoIndicadores . "_" . "1";
                    }
                    $crearDimension = $dimen->crearDimension($idDimensionCrear, $nombreDimensionCrear, $descripcionDimension, $idConjuntoIndicadores, $posicion, $icono, $color);
                    if ($crearDimension == "Creada") {
                        $msgConfirm[] = "La dimensión <strong> $nombreDimensionCrear </strong>fue creada satisfactoriamente.";
                    } else {
                        $errors[] = "Error al crear la dimensión <strong> $nombreDimensionCrear</strong>.";
                    }
                }
                // Crear temática
                $nombreTematicaCrear = trim($fila[1]);
                $dimension = new Dimension();
                $result = $dimension->nombreDimensionExisteConjunto($nombreDimensionCrear, $idConjuntoIndicadores);
                $idDimensionCrear = $result['idDimension'];
                $tematica = new Tematica();
                $descripcionTematica = NULL;
                $nombreTematicaExiste = $tematica->nombreTematicaExisteDimension($nombreTematicaCrear, $idDimensionCrear);
                if (!$nombreTematicaExiste) {
                    $numeroTematicasPorDimension = $tematica->consultarUltimoId($idDimensionCrear);
                    if (!empty($numeroTematicasPorDimension)) {
                        $consulta = explode('_T', $numeroTematicasPorDimension[0]);
                        $idTematicaCrear = $idDimensionCrear . "_T" . ($consulta[1] + 1);
                    } else {
                        $idTematicaCrear = $idDimensionCrear . "_T" . "1";
                    }
                    $crearTematica = $tematica->crearTematica($idTematicaCrear, $nombreTematicaCrear, $descripcionTematica, $idDimensionCrear, $posicion);
                    if ($crearTematica == "Creada") {
                        $msgConfirm[] = "La temática <strong> $nombreTematicaCrear </strong>fue creada satisfactoriamente.";
                    } else {
                        $errors[] = "Error al crear la temática <strong> $nombreTematicaCrear</strong>.";
                    }
                }
                // Crear indicador
                $nombreIndicadorCrear = trim($fila[2]);
                $result2 = $tematica->nombreTematicaExisteDimension($nombreTematicaCrear, $idDimensionCrear);
                $idTematicaCrear = $result2['idTematica'];
                $indicador = new Indicador();
                $descripcionIndicador = NULL;
                $nombreIndicadorExist = $indicador->nombreIndicadorExisteTematica($nombreIndicadorCrear, $idTematicaCrear);
                if (!$nombreIndicadorExist) {
                    $numeroIndicadoresPorTematica = $indicador->consultarUltimoId($idTematicaCrear);
                    if (!empty($numeroIndicadoresPorTematica)) {
                        $consulta = explode('_I', $numeroIndicadoresPorTematica[0]);
                        $idIndicadorCrear = $idTematicaCrear . "_I" . ($consulta[1] + 1);
                    } else {
                        $idIndicadorCrear = $idTematicaCrear . "_I" . "1";
                    }
                    $mapa = NULL;
                    $activado = 1;
                    $crearIndicador = $indicador->crearIndicador($idIndicadorCrear, $nombreIndicadorCrear, $descripcionIndicador, $idTematicaCrear, $posicion, $mapa, $activado);
                    if ($crearIndicador == "Creado") {
                        $msgConfirm[] = "El indicador <strong> $nombreIndicadorCrear </strong>fue creado satisfactoriamente.";
                    } else {
                        $errors[] = "Error al crear el indicador <strong> $nombreIndicadorCrear</strong>.";
                    }
                }
                // Crear serie de datos
                $tipoDato = trim($fila[3]);
                $geografia = trim($fila[6]);
                $zonaActual = trim($fila[7]);
                $periodicidad = trim($fila[8]);
                $entidadGeneradora = trim($fila[9]);
                $fuenteDatos = trim($fila[10]);
                $urlDatos = trim($fila[11]);
                $desagregacionTematica = trim($fila[12]);
                $notas = trim($fila[13]);
                $unidadMedicion = trim($fila[14]);
                $numeroConsultas = 0;
                $idIndicadorCrear = $indicador->nombreIndicadorExiste($nombreIndicadorCrear, $idTematicaCrear);
                $nombreUnicoSerieCrear = $geografia . "_" . $zonaActual . "_" . $desagregacionTematica . "_" . $idIndicadorCrear;
                $serieDato = new SerieDatos();
                $nombreExisteIndicador = $serieDato->nombreUnicoSerieExisteIndicador($nombreUnicoSerieCrear, $idIndicadorCrear);
                if (!$nombreExisteIndicador) {
                    $numeroSeriesPorIndicador = $serieDato->consultarUltimoId($idIndicadorCrear);
                    if (!empty($numeroSeriesPorIndicador)) {
                        $consulta = explode('_S', $numeroSeriesPorIndicador[0]);
                        $idSerieDatosCrear = $idIndicadorCrear . "_S" . ($consulta[1] + 1);
                    } else {
                        $idSerieDatosCrear = $idIndicadorCrear . "_S" . "1";
                    }
                    $crearSerie = $serieDato->crearSerieDatos($idSerieDatosCrear, $nombreUnicoSerieCrear, $tipoDato, $geografia, $zonaActual, $periodicidad, $entidadGeneradora, $fuenteDatos, $urlDatos, $desagregacionTematica, $notas, $unidadMedicion, $numeroConsultas, $idIndicadorCrear);
                    if ($crearSerie == "Creada") {
                        $msgConfirm[] = "La serie de datos<strong> $nombreUnicoSerieCrear</strong>fue creada satisfactoriamente.";
                    } else {
                        $errors[] = "Error al crear la serie de datos<strong> $nombreUnicoSerieCrear</strong>.";
                    }
                }
                $fechaDato = trim($fila[4]);
                settype($fechaDato, "string");
                $valorDato = trim($fila[5]);
                $result4 = $serieDato->nombreUnicoSerieExiste($nombreUnicoSerieCrear);
                $idSerieDatosCrear = $result4['idSerieDatos'];
                $dato = new Dato();
                $existeDato = $dato->existeDato($idSerieDatosCrear, $fechaDato);
                if (!$existeDato) {
                    $idDato = NULL;
                    $estadoObservacionDato = 'Provisional';
                    $agregarDato = $dato->crearDato($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idSerieDatosCrear);
                    if ($agregarDato == "Creado") {
                        $msgConfirm[] = "El dato con fecha<strong> $fechaDato </strong>fue agregado satisfactoriamente a la serie $nombreUnicoSerieCrear.";
                    } else {
                        $errors[] = "Error al agregar el dato con fecha<strong> $fechaDato </strong>Serie $nombreUnicoSerieCrear.";
                    }
                }
            }
            $tiempo_fin = microtime(true);
            $msgConfirm[] = "Los elementos ya existentes han sido omitidos. Carga finalizada.";
            $msgConfirm[] = "Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.";
        }
        echo resultBlock($errors);
        echo resultConfirm($msgConfirm);
    }

    public function CargarFichaOdraf($archivoFichaOdraf) {
        set_time_limit(700);
        ini_set('memory_limit', '-1');
        $errors = array();
        $msgConfirm = array();
        $inputFileName = "";
        if (empty($_FILES)) {
            $errors[] = "Debe seleccionar un archivo";
        } else {
            $inputFileName = $_FILES["archivoFichaOdraf"]["tmp_name"];
        }
        $path = $_FILES['archivoFichaOdraf']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != "xls" && $ext != "xlsx") {
            $errors[] = "Los tipos de archivos permitidos son .xls y .xlsx";
            $errors[] = $ext;
        }
        if (count($errors) == 0) {
            $tiempo_inicio = microtime(true);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .
                        $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) {
                $fila = array();
                for ($col = "A"; $col <= $highestColumn; $col++) {
                    $contenidoCelda = $sheet->getCell($col . $row)->getFormattedValue();
                    array_push($fila, $contenidoCelda);
                }
                $idConjuntoIndicadores = "ODRAF";
                $nombreDimension = trim($fila[0]);
                $nombreTematica = trim($fila[1]);
                $nombreIndicador = trim($fila[2]);
                $sigla = trim($fila[3]);
                $justificacion = trim($fila[4]);
                $definicion = trim($fila[5]);
                $metodosMedicion = trim($fila[6]);
                $formulas = trim($fila[7]);
                $variables = trim($fila[8]);
                $valoresReferencia = trim($fila[9]);
                $naturaleza = trim($fila[10]);
                $desagregacionTematica = trim($fila[11]);
                $desagregacionGeografica = trim($fila[12]);
                $lineaBase = trim($fila[13]);
                $responsable = trim($fila[14]);
                $observaciones = trim($fila[15]);
                $fechaElaboracion = trim($fila[16]);
                $tipoGrafico = trim($fila[17]);
                $posicionTem = trim($fila[18]);
                $posicionInd = trim($fila[19]);
                $indicador = new Indicador;
                $tematica = new Tematica;
                $dimension = new Dimension();
                $result1 = $dimension->nombreDimensionExisteConjunto($nombreDimension, $idConjuntoIndicadores);
                $idDimensionCrear = $result1['idDimension'];
                $result2 = $tematica->nombreTematicaExisteDimension($nombreTematica, $idDimensionCrear);
                $idTematicaCrear = $result2['idTematica'];
                $idIndicador = $indicador->nombreIndicadorExiste($nombreIndicador, $idTematicaCrear);
                $fichaTecnica = new FichaTecnica;
                $fichaTecnicaExisParaIndicador = $fichaTecnica->fichaExisteIndicador($idConjuntoIndicadores, $idIndicador);
                if (!$fichaTecnicaExisParaIndicador) {
                    $idFichaTecnica = NULL;
                    $crearFicha = $fichaTecnica->crearFicha($idFichaTecnica, $sigla, $justificacion, $definicion, $metodosMedicion, $formulas, $variables, $valoresReferencia, $naturaleza, $desagregacionTematica, $desagregacionGeografica, $lineaBase, $responsable, $observaciones, $fechaElaboracion, $idIndicador, $tipoGrafico);
                    if ($crearFicha == "Creada") {
                        $msgConfirm[] = "La información de la ficha del indicador<strong> $nombreIndicador </strong>fue agregada satisfactoriamente.";
                        $tematica->editarPosicion($nombreTematica, $posicionTem);
                        $indicador->editarPosicion($idIndicador, $posicionInd);
                    } else {
                        $errors[] = "Error al cargar la información de la ficha del indicador<strong> $nombreIndicador </strong>.";
                    }
                }
            }
            $tiempo_fin = microtime(true);
            $msgConfirm[] = "Los elementos ya existentes han sido omitidos. Carga finalizada.";
            $msgConfirm[] = "Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.";
        }
        echo resultBlock($errors);
        echo resultConfirm($msgConfirm);
    }

    public function CargarCuatrienioODS($archivoCuatrienioODS) {
//        session_start();
        set_time_limit(700);
        ini_set('memory_limit', '-1');
        $errors = array();
        $no_errors = 0;
        $no_warning = 0;
        $no_success = 0;
        $msgResult = array();
        $inputFileName = "";
        if (empty($_FILES)) {
            $errors[] = "Debe seleccionar un archivo";
        } else {
            $inputFileName = $_FILES["archivoCuatrenioODS"]["tmp_name"];
        }
        $path = $_FILES['archivoCuatrenioODS']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != "xls" && $ext != "xlsx") {
            $errors[] = "Los tipos de archivos permitidos son .xls y .xlsx";
            $errors[] = $ext;
        }
        if (count($errors) == 0) {
            $tiempo_inicio = microtime(true);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .
                        $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) {
                $fila = array();
                for ($col = "A"; $col <= $highestColumn; $col++) {
                    $contenidoCelda = $sheet->getCell($col . $row)->getFormattedValue();
                    array_push($fila, $contenidoCelda);
                }
                $idConjuntoIndicadores = "ODS";
                $dimension = new Dimension();
                $nombreObjetivo = trim($fila[0]);
                $nombreTematicaCrear = "Meta " . trim($fila[1]);
                $nombreIndicadorCrear = trim($fila[2]);
                $tipoDato = "Oficial";
                $geografia = "Municipal";
                $zonaActual = "Cali";
                $periodicidad = trim($fila[8]);
                $entidadCompiladora = trim($fila[9]);
                $fuenteDatos = trim($fila[10]);
                $urlDatos = trim($fila[11]);
                $desagregacionTematica = "Línea Base";
                $notas = trim($fila[12]);
                $unidadMedicion = trim($fila[13]);
                $provenienciaIndicador = trim($fila[14]);
                $comportamientoIndicador = trim($fila[15]);
                $numeroConsultas = 0;

                $idDimension = "";
                switch ($nombreObjetivo) {
                    case 1:
                        $idDimension = "ODS_1";
                        break;
                    case 2:
                        $idDimension = "ODS_2";
                        break;
                    case 3:
                        $idDimension = "ODS_3";
                        break;
                    case 4:
                        $idDimension = "ODS_4";
                        break;
                    case 5:
                        $idDimension = "ODS_5";
                        break;
                    case 6:
                        $idDimension = "ODS_6";
                        break;
                    case 7:
                        $idDimension = "ODS_7";
                        break;
                    case 8:
                        $idDimension = "ODS_8";
                        break;
                    case 9:
                        $idDimension = "ODS_9";
                        break;
                    case 10:
                        $idDimension = "ODS_10";
                        break;
                    case 11:
                        $idDimension = "ODS_11";
                        break;
                    case 12:
                        $idDimension = "ODS_12";
                        break;
                    case 13:
                        $idDimension = "ODS_13";
                        break;
                    case 14:
                        $idDimension = "ODS_14";
                        break;
                    case 15:
                        $idDimension = "ODS_15";
                        break;
                    case 16:
                        $idDimension = "ODS_16";
                        break;
                    case 17:
                        $idDimension = "ODS_17";
                        break;
                    default:
                        break;
                }
                $nombreObjetivoCrear = $dimension->consultarNombreDimension($idDimension);
                $posicion = "";
                $icono = "";
                $color = "";
                $nombreDimensionExiste = $dimension->nombreDimensionExisteConjunto($nombreObjetivoCrear, $idConjuntoIndicadores);
                $descripcionDimension = NULL;
                if (!$nombreDimensionExiste) {
                    $crearDimension = $dimension->crearDimension($idDimension, $nombreObjetivoCrear, $descripcionDimension, $idConjuntoIndicadores, $posicion, $icono, $color);
                    if ($crearDimension == "Creada") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - El objetivo <strong> $nombreObjetivoCrear </strong>fue creado satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear el objetivo <strong> $nombreObjetivoCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - El objetivo <strong> $nombreObjetivoCrear </strong> ya existe.
                                    </p>";
                }

                $result = $dimension->nombreDimensionExisteConjunto($nombreObjetivoCrear, $idConjuntoIndicadores);
                $idDimensionCrear = $result['idDimension'];
                $tematica = new Tematica();
                $descripcionTematica = NULL;
                $nombreTematicaExiste = $tematica->nombreTematicaExisteDimension($nombreTematicaCrear, $idDimensionCrear);
                if (!$nombreTematicaExiste) {
                    $numeroTematicasPorDimension = $tematica->consultarUltimoId($idDimensionCrear);
                    if (!empty($numeroTematicasPorDimension)) {
                        $consulta = explode('_T', $numeroTematicasPorDimension[0]);
                        $idTematicaCrear = $idDimensionCrear . "_T" . ($consulta[1] + 1);
                    } else {
                        $idTematicaCrear = $idDimensionCrear . "_T" . "1";
                    }
                    $crearTematica = $tematica->crearTematica($idTematicaCrear, $nombreTematicaCrear, $descripcionTematica, $idDimensionCrear, $posicion);
                    if ($crearTematica == "Creada") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - La meta  <strong> $nombreTematicaCrear </strong>fue creada satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear la meta <strong> $nombreTematicaCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - La meta <strong> $nombreTematicaCrear </strong> ya existe.
                                    </p>";
                }
//                // Crear indicador

                $result2 = $tematica->nombreTematicaExisteDimension($nombreTematicaCrear, $idDimensionCrear);
                $idTematicaCrear = $result2['idTematica'];
                $indicador = new Indicador();
                $descripcionIndicador = NULL;
                $nombreIndicadorExiste = $indicador->nombreIndicadorExisteTematica($nombreIndicadorCrear, $idTematicaCrear);
                if (!$nombreIndicadorExiste) {
                    $numeroIndicadoresPorTematica = $indicador->consultarUltimoId($idTematicaCrear);
                    if (!empty($numeroIndicadoresPorTematica)) {
                        $consulta = explode('_I', $numeroIndicadoresPorTematica[0]);
                        $idIndicadorCrear = $idTematicaCrear . "_I" . ($consulta[1] + 1);
                    } else {
                        $idIndicadorCrear = $idTematicaCrear . "_I" . "1";
                    }
                    $mapa = NULL;
                    $activado = 1;
                    $crearIndicador = $indicador->crearIndicador($idIndicadorCrear, $nombreIndicadorCrear, $descripcionIndicador, $idTematicaCrear, $posicion, $mapa, $activado);
                    if ($crearIndicador == "Creado") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - El indicador <strong> $nombreIndicadorCrear </strong>fue creado satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear el indicador <strong> $nombreIndicadorCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - El indicador <strong> $nombreIndicadorCrear </strong> ya existe.
                                    </p>";
                }

                $idIndicadorCrear = $indicador->nombreIndicadorExiste($nombreIndicadorCrear, $idTematicaCrear);
                $nombreUnicoSerieCrear = $geografia . "_" . $zonaActual . "_" . $desagregacionTematica . "_" . $idIndicadorCrear;
                $serieDato = new SerieDatos();
                $nombreExisteIndicador = $serieDato->nombreUnicoSerieExisteIndicador($nombreUnicoSerieCrear, $idIndicadorCrear);
                if (!$nombreExisteIndicador) {
                    $numeroSeriesPorIndicador = $serieDato->consultarUltimoId($idIndicadorCrear);
                    if (!empty($numeroSeriesPorIndicador)) {
                        $consulta = explode('_S', $numeroSeriesPorIndicador[0]);
                        $idSerieDatosCrear = $idIndicadorCrear . "_S" . ($consulta[1] + 1);
                    } else {
                        $idSerieDatosCrear = $idIndicadorCrear . "_S" . "1";
                    }
                    $crearSerie = $serieDato->crearSerieDatos($idSerieDatosCrear, $nombreUnicoSerieCrear, $tipoDato, $geografia, $zonaActual, $periodicidad, $entidadCompiladora, $fuenteDatos, $urlDatos, $desagregacionTematica, $notas, $unidadMedicion, $numeroConsultas, $idIndicadorCrear);
                    if ($crearSerie == "Creada") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - La serie de datos<strong> $nombreUnicoSerieCrear</strong>fue creada satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear la serie de datos<strong> $nombreUnicoSerieCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - La serie de datos <strong> $nombreUnicoSerieCrear </strong> ya existe.
                                    </p>";
                }
                $dato2015 = trim($fila[3]);
                $dato2019 = trim($fila[4]);
                $dato2023 = trim($fila[5]);
                $dato2027 = trim($fila[6]);
                $dato2030 = trim($fila[7]);
                settype($dato2015, "string");
                settype($dato2019, "string");
                settype($dato2023, "string");
                settype($dato2027, "string");
                settype($dato2030, "string");
                $result4 = $serieDato->nombreUnicoSerieExiste($nombreUnicoSerieCrear);
                $idSerieDatosCrear = $result4['idSerieDatos'];
                $dato = new Dato();
                $anhos = [2015, 2019, 2023, 2027, 2030];
                $datos = [$dato2015, $dato2019, $dato2023, $dato2027, $dato2030];

                for ($i = 0; $i < count($anhos); $i++) {
                    $fechaDato = $anhos[$i];
                    $valorDato = $datos[$i];

                    if (strpos($valorDato, '<') !== false) {
                        $vrDt = explode("<", $valorDato);
                        $valorDato = $vrDt[1];
                        if (strpos($comportamientoIndicador, 'Operador lógico') == false) {
                            $comportamientoIndicador = $comportamientoIndicador . ', Operador logico';
                        }
                    }

                    $existeDato = $dato->existeDato($idSerieDatosCrear, $fechaDato);
                    if (!$existeDato) {
                        $idDato = NULL;
                        $estadoObservacionDato = 'Provisional';
                        $agregarDato = $dato->crearDato($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idSerieDatosCrear);
                        if ($agregarDato == "Creado") {
                            $no_success++;
                            $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - El dato con fecha<strong> $fechaDato </strong>fue agregado satisfactoriamente a la serie $nombreUnicoSerieCrear.
                                        </p>";
                        } else {
                            $no_errors++;
                            $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al agregar el dato con fecha<strong> $fechaDato </strong>Serie $nombreUnicoSerieCrear.
                                        </p>";
                        }
                    } else {
                        $no_warning++;
                        $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - El dato con fecha <strong> $fechaDato </strong> ya existe.
                                    </p>";
                    }
                }

                $visualizador = new VisualizadorController();

                $idAtributoProveniencia = $visualizador->consultarIdAtributoPorNombreYConjunto("Proveniencia del indicador", $idConjuntoIndicadores);
                $idAtributoComportamiento = $visualizador->consultarIdAtributoPorNombreYConjunto("Comportamiento esperado del indicador", $idConjuntoIndicadores);

                $idElementoProveniencia = $idIndicadorCrear . '_01';
                $idElementoComportamiento = $idIndicadorCrear . '_02';

                $idElementoProvenienciaExiste = $visualizador->existeIdElemento($idElementoProveniencia);
                $idElementoComportamientoExiste = $visualizador->existeIdElemento($idElementoComportamiento);

                if (!$idElementoProvenienciaExiste) {
                    $crearElementoProveniencia = $visualizador->crearRegistro($idElementoProveniencia, $provenienciaIndicador, $idIndicadorCrear, $idAtributoProveniencia);
                    if ($crearElementoProveniencia == "Creado") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - El registro <strong>$idElementoProveniencia - $idIndicadorCrear</strong> fue creado satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear el registro <strong>$idElementoProveniencia - $idIndicadorCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - El registro <strong>$idElementoProveniencia - $idIndicadorCrear</strong> ya existe.
                                    </p>";
                }
                if (!$idElementoComportamientoExiste) {
                    $crearElementoComportamiento = $visualizador->crearRegistro($idElementoComportamiento, $comportamientoIndicador, $idIndicadorCrear, $idAtributoComportamiento);
                    if ($crearElementoComportamiento == "Creado") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - El registro <strong>$idElementoComportamiento - $idIndicadorCrear</strong> fue creado satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear el registro <strong>$idElementoComportamiento - $idIndicadorCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - El registro <strong>$idElementoComportamiento - $idIndicadorCrear</strong> ya existe.
                                    </p>";
                }
            }
            $tiempo_fin = microtime(true);
        }
        $msgConfirm[] = "Los elementos ya existentes han sido omitidos. Carga finalizada.";
        $msgConfirm[] = "Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.";
        $tot = $no_success + $no_warning - + $no_errors;
        echo "  <div class='alert alert-dismissable' style='background-color:#d9edf7; color:#31708f;'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                    <strong>Carga finalizada</strong><br>
                    Aciertos: $no_success - Errores: $no_errors<br>
                    Mensajes informativos: $no_warning<br>
                    Total de mensajes: $tot<br>
                    Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.
                </div>";
        echo " <div class='alert alert-dismissable' style='background-color:#fff;border: 2px solid #aaa;'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>";
        foreach ($msgResult as $result) {
            echo $result;
        }
        echo "  </div>";
    }

    public function CargarArchivoSeguimientoODS($archivoSeguimientoODS) {
        set_time_limit(700);
        ini_set('memory_limit', '-1');
        $errors = array();
        $no_errors = 0;
        $no_warning = 0;
        $no_success = 0;
        $msgResult = array();
        $inputFileName = "";
        if (empty($_FILES)) {
            $errors[] = "Debe seleccionar un archivo";
        } else {
            $inputFileName = $_FILES["archivoSeguimientoODS"]["tmp_name"];
        }
        $path = $_FILES['archivoSeguimientoODS']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != "xls" && $ext != "xlsx") {
            $errors[] = "Los tipos de archivos permitidos son .xls y .xlsx";
            $errors[] = $ext;
        }
        if (count($errors) == 0) {
            $tiempo_inicio = microtime(true);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .
                        $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) {
                $fila = array();
                for ($col = "A"; $col <= $highestColumn; $col++) {
                    $contenidoCelda = $sheet->getCell($col . $row)->getFormattedValue();
                    array_push($fila, $contenidoCelda);
                }
                $idConjuntoIndicadores = "ODS";
                $dimen = new Dimension();
                // Crear Dimensión
                $nombreObjetivo = trim($fila[0]);
                $nombreObjetivoCrear = "";
                $idDimension = "";
                switch ($nombreObjetivo) {
                    case 1:
                        $idDimension = "ODS_1";
                        break;
                    case 2:
                        $idDimension = "ODS_2";
                        break;
                    case 3:
                        $idDimension = "ODS_3";
                        break;
                    case 4:
                        $idDimension = "ODS_4";
                        break;
                    case 5:
                        $idDimension = "ODS_5";
                        break;
                    case 6:
                        $idDimension = "ODS_6";
                        break;
                    case 7:
                        $idDimension = "ODS_7";
                        break;
                    case 8:
                        $idDimension = "ODS_8";
                        break;
                    case 9:
                        $idDimension = "ODS_9";
                        break;
                    case 10:
                        $idDimension = "ODS_10";
                        break;
                    case 11:
                        $idDimension = "ODS_11";
                        break;
                    case 12:
                        $idDimension = "ODS_12";
                        break;
                    case 13:
                        $idDimension = "ODS_13";
                        break;
                    case 14:
                        $idDimension = "ODS_14";
                        break;
                    case 15:
                        $idDimension = "ODS_15";
                        break;
                    case 16:
                        $idDimension = "ODS_16";
                        break;
                    case 17:
                        $idDimension = "ODS_17";
                        break;
                    default:
                        break;
                }
                $nombreObjetivoCrear = $dimen->consultarNombreDimension($idDimension);
                $posicion = "";
                $icono = "";
                $color = "";
                $nombreDimensionExiste = $dimen->nombreDimensionExisteConjunto($nombreObjetivoCrear, $idConjuntoIndicadores);
                $descripcionDimension = NULL;
                if (!$nombreDimensionExiste) {
                    $numeroObjetivos = $dimen->consultarUltimoId($idConjuntoIndicadores);
                    if (!empty($numeroObjetivos)) {
                        $consulta = explode('_', $numeroObjetivos[0]);
                        $idDimensionCrear = $idConjuntoIndicadores . "_" . ($consulta[1] + 1);
                    } else {
                        $idDimensionCrear = $idConjuntoIndicadores . "_" . "1";
                    }
                    $crearDimension = $dimen->crearDimension($idDimensionCrear, $nombreObjetivoCrear, $descripcionDimension, $idConjuntoIndicadores, $posicion, $icono, $color);
                    if ($crearDimension == "Creada") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - El objetivo <strong> $nombreObjetivoCrear </strong>fue creado satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear el objetivo <strong> $nombreObjetivoCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - El objetivo <strong> $nombreObjetivoCrear </strong> ya existe.
                                    </p>";
                }
//                // Crear temática
                $nombreTematicaCrear = "Meta " . trim($fila[1]);
                $result = $dimen->nombreDimensionExisteConjunto($nombreObjetivoCrear, $idConjuntoIndicadores);
                $idDimensionCrear = $result['idDimension'];
                $tematica = new Tematica();
                $descripcionTematica = NULL;
                $nombreTematicaExiste = $tematica->nombreTematicaExisteDimension($nombreTematicaCrear, $idDimensionCrear);
                if (!$nombreTematicaExiste) {
                    $numeroTematicasPorDimension = $tematica->consultarUltimoId($idDimensionCrear);
                    if (!empty($numeroTematicasPorDimension)) {
                        $consulta = explode('_T', $numeroTematicasPorDimension[0]);
                        $idTematicaCrear = $idDimensionCrear . "_T" . ($consulta[1] + 1);
                    } else {
                        $idTematicaCrear = $idDimensionCrear . "_T" . "1";
                    }
                    $crearTematica = $tematica->crearTematica($idTematicaCrear, $nombreTematicaCrear, $descripcionTematica, $idDimensionCrear, $posicion);
                    if ($crearTematica == "Creada") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - La meta  <strong> $nombreTematicaCrear </strong>fue creada satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear la meta <strong> $nombreTematicaCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - La meta <strong> $nombreTematicaCrear </strong> ya existe.
                                    </p>";
                }
                // Crear indicador
                $nombreIndicadorCrear = trim($fila[2]);
                $result2 = $tematica->nombreTematicaExisteDimension($nombreTematicaCrear, $idDimensionCrear);
                $idTematicaCrear = $result2['idTematica'];
                $indicador = new Indicador();
                $descripcionIndicador = NULL;
                $nombreIndicadorExiste = $indicador->nombreIndicadorExisteTematica($nombreIndicadorCrear, $idTematicaCrear);
                if (!$nombreIndicadorExiste) {
                    $numeroIndicadoresPorTematica = $indicador->consultarUltimoId($idTematicaCrear);
                    if (!empty($numeroIndicadoresPorTematica)) {
                        $consulta = explode('_I', $numeroIndicadoresPorTematica[0]);
                        $idIndicadorCrear = $idTematicaCrear . "_I" . ($consulta[1] + 1);
                    } else {
                        $idIndicadorCrear = $idTematicaCrear . "_I" . "1";
                    }
                    $mapa = NULL;
                    $activado = 1;
                    $crearIndicador = $indicador->crearIndicador($idIndicadorCrear, $nombreIndicadorCrear, $descripcionIndicador, $idTematicaCrear, $posicion, $mapa, $activado);
                    if ($crearIndicador == "Creado") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - El indicador <strong> $nombreIndicadorCrear </strong>fue creado satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear el indicador <strong> $nombreIndicadorCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - El indicador <strong> $nombreIndicadorCrear </strong> ya existe.
                                    </p>";
                }
//                // Crear serie de datos
                $tipoDato = "Oficial";
                $geografia = "Municipal";
                $zonaActual = "Cali";
                $periodicidad = trim($fila[5]);
                $entidadGeneradora = trim($fila[6]);
                $fuenteDatos = trim($fila[7]);
                $urlDatos = trim($fila[8]);
                $desagregacionTematica = "Total";
                $notas = trim($fila[9]);
                $unidadMedicion = trim($fila[10]);
                $numeroConsultas = 0;
                $idIndicadorCrear = $indicador->nombreIndicadorExiste($nombreIndicadorCrear, $idTematicaCrear);
                $nombreUnicoSerieCrear = $geografia . "_" . $zonaActual . "_" . $desagregacionTematica . "_" . $idIndicadorCrear;
                $serieDato = new SerieDatos();
                $nombreExisteIndicador = $serieDato->nombreUnicoSerieExisteIndicador($nombreUnicoSerieCrear, $idIndicadorCrear);
                if (!$nombreExisteIndicador) {
                    $numeroSeriesPorIndicador = $serieDato->consultarUltimoId($idIndicadorCrear);
                    if (!empty($numeroSeriesPorIndicador)) {
                        $consulta = explode('_S', $numeroSeriesPorIndicador[0]);
                        $idSerieDatosCrear = $idIndicadorCrear . "_S" . ($consulta[1] + 1);
                    } else {
                        $idSerieDatosCrear = $idIndicadorCrear . "_S" . "1";
                    }
                    $crearSerie = $serieDato->crearSerieDatos($idSerieDatosCrear, $nombreUnicoSerieCrear, $tipoDato, $geografia, $zonaActual, $periodicidad, $entidadGeneradora, $fuenteDatos, $urlDatos, $desagregacionTematica, $notas, $unidadMedicion, $numeroConsultas, $idIndicadorCrear);
                    if ($crearSerie == "Creada") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - La serie de datos<strong> $nombreUnicoSerieCrear</strong> fue creada satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al crear la serie de datos<strong> $nombreUnicoSerieCrear</strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - La serie de datos<strong> $nombreUnicoSerieCrear</strong> ya existe.
                                    </p>";
                }
                $fechaDato = trim($fila[3]);
                settype($fechaDato, "string");
                $valorDato = trim($fila[4]);
                $result4 = $serieDato->nombreUnicoSerieExiste($nombreUnicoSerieCrear);
                $idSerieDatosCrear = $result4['idSerieDatos'];
                $dato = new Dato();
                $existeDato = $dato->existeDato($idSerieDatosCrear, $fechaDato);
                if (!$existeDato) {
                    $idDato = NULL;
                    $estadoObservacionDato = 'Provisional';
                    $agregarDato = $dato->crearDato($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idSerieDatosCrear);
                    if ($agregarDato == "Creado") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - El dato con fecha<strong> $fechaDato </strong>fue agregado satisfactoriamente a la serie $nombreUnicoSerieCrear.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al agregar el dato con fecha<strong> $fechaDato </strong>Serie $nombreUnicoSerieCrear.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - El dato con fecha<strong> $fechaDato </strong>ya existe.
                                    </p>";
                }
            }
            $tiempo_fin = microtime(true);
        }
        $msgConfirm[] = "Los elementos ya existentes han sido omitidos. Carga finalizada.";
        $msgConfirm[] = "Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.";
        $tot = $no_success + $no_warning - + $no_errors;
        echo "  <div class='alert alert-dismissable' style='background-color:#d9edf7; color:#31708f;'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                    <strong>Carga finalizada</strong><br>
                    Aciertos: $no_success - Errores: $no_errors<br>
                    Mensajes informativos: $no_warning<br>
                    Total de mensajes: $tot<br>
                    Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.
                </div>";
        echo " <div class='alert alert-dismissable' style='background-color:#fff;border: 2px solid #aaa;'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>";
        foreach ($msgResult as $result) {
            echo $result;
        }
        echo "  </div>";
    }

    public function CargarFichaOds($archivoFichaOds) {
        set_time_limit(700);
        ini_set('memory_limit', '-1');
        $errors = array();
        $no_errors = 0;
        $no_warning = 0;
        $no_success = 0;
        $msgResult = array();
        $inputFileName = "";
        if (empty($_FILES)) {
            $errors[] = "Debe seleccionar un archivo";
        } else {
            $inputFileName = $_FILES["archivoFichaODS"]["tmp_name"];
        }
        $path = $_FILES['archivoFichaODS']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != "xls" && $ext != "xlsx") {
            $errors[] = "Los tipos de archivos permitidos son .xls y .xlsx";
            $errors[] = $ext;
        }
        if (count($errors) == 0) {
            $tiempo_inicio = microtime(true);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .
                        $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) {
                $fila = array();
                for ($col = "A"; $col <= $highestColumn; $col++) {
                    $contenidoCelda = $sheet->getCell($col . $row)->getFormattedValue();
                    array_push($fila, $contenidoCelda);
                }
                $idConjuntoIndicadores = "ODS";
                $noObjetivo = trim($fila[0]);
                $nombreObjetivo = trim($fila[1]);
                $noMeta = trim($fila[2]);
                $nombreMeta = trim($fila[3]);
                $nombreIndicador = trim($fila[4]);
                $descripcionIndicador = trim($fila[5]);
                $unidadMedicion = trim($fila[6]);
                $metodoCalculo = trim($fila[7]);
                $lineaBase = trim($fila[8]);
                $periodicidad = trim($fila[9]);
                $fuenteDatos = trim($fila[10]);
                $fechaElaboracion = trim($fila[11]);

                $nombreObjetivoCompleto = "Objetivo " . $noObjetivo . ". " . $nombreObjetivo;
                $nombreMetaCompleto = "Meta " . $noMeta;
                $dimension = new Dimension();
                $tematica = new Tematica();
                $indicador = new Indicador();
                $result1 = $dimension->nombreDimensionExisteConjunto($nombreObjetivoCompleto, $idConjuntoIndicadores);
                $idDimensionCrear = $result1['idDimension'];

                $result2 = $tematica->nombreTematicaExisteDimension($nombreMetaCompleto, $idDimensionCrear);
                $idTematicaCrear = $result2['idTematica'];

                $tematica->editarTematica($idTematicaCrear, $nombreMetaCompleto, $nombreMeta, 0);

                $idIndicador = $indicador->nombreIndicadorExiste($nombreIndicador, $idTematicaCrear);
                $fichaTecnica = new FichaTecnica;
                $fichaTecnicaExisParaIndicador = $fichaTecnica->fichaExisteIndicadorFuente($idConjuntoIndicadores, $idIndicador, $fuenteDatos);
                if (!$fichaTecnicaExisParaIndicador) {
                    $idFichaTecnica = NULL;
                    $crearFicha = $fichaTecnica->crearFicha($idFichaTecnica, "", "", $descripcionIndicador, $metodoCalculo, "", "", "", "", "", "", $lineaBase, "", "", $fechaElaboracion, $idIndicador, "", $fuenteDatos);
                    if ($crearFicha == "Creada") {
                        $no_success++;
                        $msgResult[] = "<p class='text-success' style='background-color:#dff0d8;'>
                                            Fila $row - La información de la ficha del indicador<strong> $nombreIndicador - $fuenteDatos </strong>fue agregada satisfactoriamente.
                                        </p>";
                    } else {
                        $no_errors++;
                        $msgResult[] = "<p class='text-danger' style='background-color:#f2dede;'>
                                            Fila $row - Error al cargar la información de la ficha del indicador<strong> $nombreIndicador - $fuenteDatos </strong>.
                                        </p>";
                    }
                } else {
                    $no_warning++;
                    $msgResult[] = "<p class='text-warning' style='background-color:#fff3cd; color:#93751c;'>
                                        Fila $row - Ya existe la ficha del indicador<strong> $nombreIndicador - $fuenteDatos</strong>.
                                    </p>";
                }
            }
            $tiempo_fin = microtime(true);
        }
        $msgConfirm[] = "Los elementos ya existentes han sido omitidos. Carga finalizada.";
        $msgConfirm[] = "Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.";
        $tot = $no_success + $no_warning - + $no_errors;
        echo "  <div class='alert alert-dismissable' style='background-color:#d9edf7; color:#31708f;'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                    <strong>Carga finalizada</strong><br>
                    Aciertos: $no_success - Errores: $no_errors<br>
                    Mensajes informativos: $no_warning<br>
                    Total de mensajes: $tot<br>
                    Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.
                </div>";
        echo " <div class='alert alert-dismissable' style='background-color:#fff;border: 2px solid #aaa;'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>";
        foreach ($msgResult as $result) {
            echo $result;
        }
        echo "  </div>";
    }

    public function CargarArchivosDadii($archivoInformacionDadii) {
        set_time_limit(700);
        ini_set('memory_limit', '-1');
        $errors = array();
        $msgConfirm = array();
        $inputFileName = "";
        if (empty($_FILES)) {
            $errors[] = "Debe seleccionar un archivo";
        } else {
            $inputFileName = $_FILES["archivoInformacionDadii"]["tmp_name"];
        }
        $path = $_FILES['archivoInformacionDadii']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != "xls" && $ext != "xlsx") {
            $errors[] = "Los tipos de archivos permitidos son .xls y .xlsx";
            $errors[] = $ext;
        }
        if (count($errors) == 0) {
            $tiempo_inicio = microtime(true);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .
                        $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) {
                $fila = array();
                for ($col = "A"; $col <= $highestColumn; $col++) {
                    $contenidoCelda = $sheet->getCell($col . $row)->getFormattedValue();
                    array_push($fila, $contenidoCelda);
                }
                $idConjuntoIndicadores = "DADII";
                // Crear Dimensión
                $codigoDimensionCrear = trim($fila[0]);
                $nombreDimensionCrear = trim($fila[1]);
                $posicion = "";
                $icono = "";
                $color = "";
                $descripcionDimension = NULL;
                $dimen = new Dimension();
                $nombreDimensionExiste = $dimen->nombreDimensionExisteConjunto($nombreDimensionCrear, $idConjuntoIndicadores);
                if (!$nombreDimensionExiste) {
                    $crearDimension = $dimen->crearDimension($codigoDimensionCrear, $nombreDimensionCrear, $descripcionDimension, $idConjuntoIndicadores, $posicion, $icono, $color);
                    if ($crearDimension == "Creada") {
                        $msgConfirm[] = "La dimensión <strong> $nombreDimensionCrear </strong>fue creada satisfactoriamente.";
                    } else {
                        $errors[] = "Error al crear la dimensión <strong> $nombreDimensionCrear</strong>.";
                    }
                }
                // Crear temática
                $codigoTematicaCrear = trim($fila[2]);
                $nombreTematicaCrear = trim($fila[3]);
                $descripcionTematica = NULL;
                $posicion = "";
                $dimension = new Dimension();
                $tematica = new Tematica();
                $result = $dimension->nombreDimensionExisteConjunto($nombreDimensionCrear, $idConjuntoIndicadores);
                $idDimensionCrear = $result['idDimension'];
                $nombreTematicaExiste = $tematica->nombreTematicaExisteDimension($nombreTematicaCrear, $idDimensionCrear);
                if (!$nombreTematicaExiste) {
                    $crearTematica = $tematica->crearTematica($codigoTematicaCrear, $nombreTematicaCrear, $descripcionTematica, $idDimensionCrear, $posicion);
                    if ($crearTematica == "Creada") {
                        $msgConfirm[] = "La temática <strong> $nombreTematicaCrear </strong>fue creada satisfactoriamente.";
                    } else {
                        $errors[] = "Error al crear la temática <strong> $nombreTematicaCrear</strong>.";
                    }
                }
                // Crear indicador
                $codigoIndicadorCrear = trim($fila[4]);
                $nombreIndicadorCrear = trim($fila[5]);
                $descripcionIndicador = NULL;
                $posicion = "";
                $mapa = NULL;
                $activado = 1;
                $indicador = new Indicador();
                $result2 = $tematica->nombreTematicaExisteDimension($nombreTematicaCrear, $idDimensionCrear);
                $idTematicaCrear = $result2['idTematica'];
                $nombreIndicadorExist = $indicador->nombreIndicadorExisteTematica($nombreIndicadorCrear, $idTematicaCrear);
                if (!$nombreIndicadorExist) {
                    $crearIndicador = $indicador->crearIndicador($codigoIndicadorCrear, $nombreIndicadorCrear, $descripcionIndicador, $idTematicaCrear, $posicion, $mapa, $activado);
                    if ($crearIndicador == "Creado") {
                        $msgConfirm[] = "El indicador <strong> $nombreIndicadorCrear </strong>fue creado satisfactoriamente.";
                    } else {
                        $errors[] = "Error al crear el indicador <strong> $nombreIndicadorCrear</strong>.";
                    }
                }
                // Crear serie de datos
                $tipoDato = "Dato oficial";
                $geografia = $fila[8];
                $zonaActual = "Cali";
                $periodicidad = $fila[9];
                $entidadGeneradora = "Departamento Administrativo de Desarrollo e Innovación Institucional";
                $fuenteDatos = $fila[10];
                $urlDatos = "";
                $desagregacionTematica = "Total";
                $notas = "";
                $unidadMedicion = $fila[11];
                $numeroConsultas = 0;
                $idIndicadorCrear = $indicador->nombreIndicadorExiste($nombreIndicadorCrear, $idTematicaCrear);
                $nombreUnicoSerieCrear = $idIndicadorCrear;
                $serieDato = new SerieDatos();
                $nombreExisteIndicador = $serieDato->nombreUnicoSerieExisteIndicador($nombreUnicoSerieCrear, $idIndicadorCrear);
                if (!$nombreExisteIndicador) {
//            $numeroSeriesPorIndicador = $serieDato->contarSeriesPorIndicador($idIndicadorCrear);
//            $idSerieDatosCrear = $idIndicadorCrear . "S" . ($numeroSeriesPorIndicador + 1);
                    $numeroSeriesPorIndicador = $serieDato->consultarUltimoId($idIndicadorCrear);
                    if (!empty($numeroSeriesPorIndicador)) {
                        $consulta = explode('_S', $numeroSeriesPorIndicador[0]);
                        $idSerieDatosCrear = $idIndicadorCrear . "_S" . ($consulta[1] + 1);
                    } else {
                        $idSerieDatosCrear = $idIndicadorCrear . "_S" . "1";
                    }
                    // AUMENTAR ID INDICADOR A 15 EN LA BD
                    $crearSerie = $serieDato->crearSerieDatos($idSerieDatosCrear, $nombreUnicoSerieCrear, $tipoDato, $geografia, $zonaActual, $periodicidad, $entidadGeneradora, $fuenteDatos, $urlDatos, $desagregacionTematica, $notas, $unidadMedicion, $numeroConsultas, $idIndicadorCrear);
                    if ($crearSerie == "Creada") {
                        $msgConfirm[] = "La serie de datos<strong> $nombreUnicoSerieCrear</strong>fue creada satisfactoriamente.";
                    } else {
                        $errors[] = "Error al crear la serie de datos<strong> $nombreUnicoSerieCrear</strong>.";
                    }
                }
                // Agregar datos a serie
                $fechaDato = $fila[6];
                settype($fechaDato, "string");
                $valorDato = $fila[7];
                $estadoObservacionDato = 'Provisional';
                $idDato = NULL;
                $dato = new Dato();
                $result4 = $serieDato->nombreUnicoSerieExiste($nombreUnicoSerieCrear);
                $idSerieDatosCrear = $result4['idSerieDatos'];
                $existeDato = $dato->existeDato($idSerieDatosCrear, $fechaDato);
                if (!$existeDato) {
                    $agregarDato = $dato->crearDato($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idSerieDatosCrear);
                    if ($agregarDato == "Creado") {
                        $msgConfirm[] = "El dato con fecha<strong> $fechaDato </strong>fue agregado satisfactoriamente a la serie $nombreUnicoSerieCrear.";
                    } else {
                        $errors[] = "Error al agregar el dato con fecha<strong> $fechaDato </strong>Serie $nombreUnicoSerieCrear.";
                    }
                }
            }
            $tiempo_fin = microtime(true);
            $msgConfirm[] = "Los elementos ya existentes han sido omitidos. Carga finalizada.";
            $msgConfirm[] = "Tiempo empleado: <strong>" . round($tiempo_fin - $tiempo_inicio, 2) . "</strong> segundos.";
        }
        echo resultBlock($errors);
        echo resultConfirm($msgConfirm);
    }

}

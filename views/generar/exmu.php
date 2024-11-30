<?php

set_include_path(dirname(__FILE__) . "/../");

require('../resources/lib/tfpdf/tfpdf.php');

class PDFExmu extends tFPDF {

    function Header() {
        $this->Image('logo-dapm.png', 8, 10, 37);
        $this->SetFont('Arial', 'B', 9.3);
        $this->Ln(3);
        $this->Cell(0, 10, utf8_decode('DEPARTAMENTO ADMINISTRATIVO DE PLANEACIÓN'), 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(0, 10, utf8_decode('SUBDIRECCIÓN DE DESARROLLO INTEGRAL'), 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(0, 10, utf8_decode('SISTEMA DE INDICADORES SOCIALES'), 0, 0, 'C');
        $this->Image('logo.png', 158, 16, 51);
        $this->Ln(16);
    }

    function Footer() {
        $this->SetY(-20);
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 10, utf8_decode('Elaborado por: Expediente Municipal - Sistema de Indicadores Sociales de Santiago de Cali'), 0, 0, 'L');
        $this->Ln(5);
        $this->Cell(0, 10, utf8_decode('Departamento Administrativo de Planeación'), 0, 0, 'L');
        $this->Ln(5);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'r');
    }

    function WordWrap($text, $maxwidth) {
        $text = trim($text);
        if ($text === '')
            return 0;
        $space = $this->GetStringWidth(' ');
        $lines = explode("\n", $text);
        $text = '';
        $count = 0;

        foreach ($lines as $line) {
            $words = preg_split('/ +/', $line);
            $width = 0;

            foreach ($words as $word) {
                $wordwidth = $this->GetStringWidth($word);
                if ($wordwidth > $maxwidth) {
                    // Word is too long, we cut it
                    for ($i = 0; $i < strlen($word); $i++) {
                        $wordwidth = $this->GetStringWidth(substr($word, $i, 1));
                        if ($width + $wordwidth <= $maxwidth) {
                            $width += $wordwidth;
                            $text .= substr($word, $i, 1);
                        } else {
                            $width = $wordwidth;
                            $text = rtrim($text) . "\n" . substr($word, $i, 1);
                            $count++;
                        }
                    }
                } elseif ($width + $wordwidth <= $maxwidth) {
                    $width += $wordwidth + $space;
                    $text .= $word . ' ';
                } else {
                    $width = $wordwidth + $space;
                    $text = rtrim($text) . "\n" . $word . ' ';
                    $count++;
                }
            }
            $text = rtrim($text) . "\n";
            $count++;
        }
        $text = rtrim($text);
        return $count;
    }

    function replaceBR($content) {
        $return0 = str_replace(" <br/>   ", "\r\n", $content);
        $return1 = str_replace(" <br/>  ", "\r\n", $return0);
        $return2 = str_replace("<br/>  ", "\r\n", $return1);
        $return3 = str_replace("<br/>", "\r\n", $return2);
        $return4 = str_replace("<br>   ", "\r\n", $return3);
        $return5 = str_replace("<br>  ", "\r\n", $return4);
        $return6 = str_replace("<br> ", "\r\n", $return5);
        $return7 = str_replace("<br>", "\r\n", $return6);
        $return8 = str_replace("•", "-", $return7);
        $return9 = str_replace("</br>", "\r\n", $return8);
        return $return9;
    }

    function titleSection($title) {
        $this->SetFillColor(33,90,154);
        $this->SetTextColor(255);
        $this->SetDrawColor(33,90,154);
        $this->SetLineWidth(.09);
        $this->SetFontSize(11);
        $this->Cell(0, 10, $title, 1, 0, 'C', 1);
        $this->Ln(12);
    }

    function rowCellSection($title, $content, $fill) {
        $cont = $this->replaceBR($content);
        $this->SetFillColor(200, 200, 200);
        $this->SetTextColor(0);
        $nb = $this->WordWrap($cont, 147);
        $this->SetFontSize(9.8);
        $this->Cell(41, 6 * $nb, $title, 1, 0, 'C', $fill);
        $this->Multicell(0, 6, $cont, 1, 'J', $fill);
    }

    function TablaExmu($nombreDimension, $nombreTematica, $nombreIndicador, $sigla, $justificacion, $definicion, $metodosMedicion, $unidadMedicion, $formula, $variables, $valoresReferencia, $naturaleza, $desagregacionTematica, $desagregacionGeografica, $lineaBase, $periodicidad, $fuenteDatos, $observaciones, $fechaElaboracion) {
        $fill = true;
        $this->SetFillColor(33,90,154);
        $this->SetTextColor(255);
        $this->SetDrawColor(33,90,154);
        $this->SetLineWidth(.08);
        $this->SetFont('Arial', 'B', 10);
        $this->titleSection(utf8_decode("Ficha técnica"));
        $this->AddFont('DejaVu', '', 'FreeSans.ttf', true);
        $this->SetFont('DejaVu', '', 10);
        $this->rowCellSection("Dimensión", $nombreDimension, $fill);
        $this->rowCellSection("Temática", $nombreTematica, !$fill);
        $this->rowCellSection("Indicador", $nombreIndicador, $fill);
        $this->rowCellSection("Sigla", $sigla, !$fill);
        $this->rowCellSection("Justificación", $justificacion, $fill);
        $this->rowCellSection("Definiciones y conceptos", $definicion, !$fill);
        $this->rowCellSection("Método de medición", $metodosMedicion, $fill);
        $this->rowCellSection("Unidad de medición", $unidadMedicion, !$fill);
        $this->rowCellSection("Fórmula", $formula, $fill);
        $this->rowCellSection("Variables", $variables, !$fill);
        $this->rowCellSection("Valores de referencia", $valoresReferencia, $fill);
        $this->rowCellSection("Naturaleza", $naturaleza, !$fill);
        $this->rowCellSection("Desagregación temática", $desagregacionTematica, $fill);
        $this->rowCellSection("Desagregación geográfica", $desagregacionGeografica, !$fill);
        $this->rowCellSection("Línea base", $lineaBase, $fill);
        $this->rowCellSection("Periodicidad", $periodicidad, !$fill);
        $this->rowCellSection("Fuente de datos", $fuenteDatos, $fill);
        $this->rowCellSection("Observaciones", $observaciones, !$fill);
        $this->rowCellSection("Fecha de elaboración", $fechaElaboracion, $fill);
    }

}

// Creación del objeto de la clase heredada
$pdf = new PDFExmu();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetY(40);

$nombreDimension = "";
$nombreTematica = "";
$nombreIndicador = "";
$sigla = "";
$justificacion = "";
$definicion = "";
$metodosMedicion = "";
$unidadMedicion = "";
$formula = "";
$variables = "";
$valoresReferencia = "";
$naturaleza = "";
$desagregacionTematica = "";
$desagregacionGeografica = "";
$lineaBase = "";
$periodicidad = "";
$fuenteDatos = "";
$observaciones = "";
$fechaElaboracion = "";
if (isset($_POST['dimensionForm']) && isset($_POST['tematicaForm']) && isset($_POST['indicadorForm']) && isset($_POST['siglaForm']) && isset($_POST['justificacionForm']) && isset($_POST['definicionForm']) && isset($_POST['metodosMedicionForm']) && isset($_POST['unidadMedicionForm']) && isset($_POST['formulasForm']) && isset($_POST['variablesForm']) && isset($_POST['valoresReferenciaForm']) && isset($_POST['naturalezaForm']) && isset($_POST['desagregacionTematicaForm']) && isset($_POST['desagregacionGeograficaForm']) && isset($_POST['lineaBaseForm']) && isset($_POST['periodicidadForm']) && isset($_POST['fuenteDatosForm']) && isset($_POST['observacionesForm']) && isset($_POST['fechaElaboracionForm'])) {
    $nombreDimension = $_POST['dimensionForm'];
    $nombreTematica = $_POST['tematicaForm'];
    $nombreIndicador = $_POST['indicadorForm'];
    $sigla = $_POST['siglaForm'];
    $justificacion = $_POST['justificacionForm'];
    $definicion = $_POST['definicionForm'];
    $metodosMedicion = $_POST['metodosMedicionForm'];
    $unidadMedicion = $_POST['unidadMedicionForm'];
    $formula = $_POST['formulasForm'];
    $variables = $_POST['variablesForm'];
    $valoresReferencia = $_POST['valoresReferenciaForm'];
    $naturaleza = $_POST['naturalezaForm'];
    $desagregacionTematica = $_POST['desagregacionTematicaForm'];
    $desagregacionGeografica = $_POST['desagregacionGeograficaForm'];
    $lineaBase = $_POST['lineaBaseForm'];
    $periodicidad = $_POST['periodicidadForm'];
    $fuenteDatos = $_POST['fuenteDatosForm'];
    $observaciones = $_POST['observacionesForm'];
    $fechaElaboracion = $_POST['fechaElaboracionForm'];
}

$pdf->TablaExmu($nombreDimension, $nombreTematica, $nombreIndicador, $sigla, $justificacion, $definicion, $metodosMedicion, $unidadMedicion, $formula, $variables, $valoresReferencia, $naturaleza, $desagregacionTematica, $desagregacionGeografica, $lineaBase, $periodicidad, $fuenteDatos, $observaciones, $fechaElaboracion);
$pdf->Output();



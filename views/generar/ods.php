<?php

//set_include_path(dirname(__FILE__) . "/../");

require('../resources/lib/tfpdf/tfpdf.php');

class PDFSis extends tFPDF {

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
        $this->Cell(0, 10, utf8_decode('Elaborado por: Sistema de Indicadores Sociales de Santiago de Cali / Departamento Administrativo de Planeación'), 0, 0, 'L');
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
        $return0 = str_replace("<br>   ", "\r\n", $content);
        $return1 = str_replace("<br>  ", "\r\n", $return0);
        $return2 = str_replace("<br> ", "\r\n", $return1);
        $return3 = str_replace("<br>", "\r\n", $return2);
        $return4 = str_replace("•", "-", $return3);
        return $return4;
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

    function TablaSIS($nombreDimension, $nombreTematica, $nombreIndicador, $sigla, $justificacion, $definicion, $metodosMedicion, $unidadMedicion, $formula, $variables, $valoresReferencia, $naturaleza, $desagregacionTematica, $desagregacionGeografica, $lineaBase, $periodicidad, $fuenteDatos, $observaciones, $fechaElaboracion) {
        $fill = true;
        $this->SetFillColor(33,90,154);
        $this->SetTextColor(255);
        $this->SetDrawColor(33,90,154);
        $this->SetLineWidth(.08);
        $this->SetFont('Arial', 'B', 10);
        $this->titleSection(utf8_decode("Ficha técnica"));
        $this->AddFont('DejaVu', '', 'FreeSans.ttf', true);
        $this->SetFont('DejaVu', '', 10);
        $this->rowCellSection("Objetivo", $nombreDimension, $fill);
        $this->rowCellSection("Meta", $nombreTematica, !$fill);
        $this->rowCellSection("Indicador", $nombreIndicador, $fill);
        $this->rowCellSection("Unidad de medición", $unidadMedicion, !$fill);
        $this->rowCellSection("Método de cálculo", $metodosMedicion, $fill);
        $this->rowCellSection("Línea base", $lineaBase, !$fill);
        $this->rowCellSection("Periodicidad", $periodicidad, $fill);
        $this->rowCellSection("Fuente de datos", $fuenteDatos, !$fill);
        $this->rowCellSection("Fecha de elaboración", $fechaElaboracion, $fill);
    }

}

// Creación del objeto de la clase heredada
$pdf = new PDFSis();
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
if (isset($_POST['nombreDimension']) && isset($_POST['nombreTematica']) && isset($_POST['nombreIndicador']) && isset($_POST['sigla']) && isset($_POST['justificacion']) && isset($_POST['definicion']) && isset($_POST['metodosMedicion']) && isset($_POST['unidadMedicion']) && isset($_POST['formulas']) && isset($_POST['variables']) && isset($_POST['valoresReferencia']) && isset($_POST['naturaleza']) && isset($_POST['desagregacionTematica']) && isset($_POST['desagregacionGeografica']) && isset($_POST['lineaBase']) && isset($_POST['periodicidad']) && isset($_POST['fuente']) && isset($_POST['observaciones']) && isset($_POST['fechaElaboracion'])) {
    $nombreDimension = $_POST['nombreDimension'];
    $nombreTematica = $_POST['nombreTematica'];
    $nombreIndicador = $_POST['nombreIndicador'];
    $sigla = $_POST['sigla'];
    $justificacion = $_POST['justificacion'];
    $definicion = $_POST['definicion'];
    $metodosMedicion = $_POST['metodosMedicion'];
    $unidadMedicion = $_POST['unidadMedicion'];
    $formula = $_POST['formulas'];
    $variables = $_POST['variables'];
    $valoresReferencia = $_POST['valoresReferencia'];
    $naturaleza = $_POST['naturaleza'];
    $desagregacionTematica = $_POST['desagregacionTematica'];
    $desagregacionGeografica = $_POST['desagregacionGeografica'];
    $lineaBase = $_POST['lineaBase'];
    $periodicidad = $_POST['periodicidad'];
    $fuenteDatos = $_POST['fuente'];
    $observaciones = $_POST['observaciones'];
    $fechaElaboracion = $_POST['fechaElaboracion'];
}

$pdf->TablaSIS($nombreDimension, $nombreTematica, $nombreIndicador, $sigla, $justificacion, $definicion, $metodosMedicion, $unidadMedicion, $formula, $variables, $valoresReferencia, $naturaleza, $desagregacionTematica, $desagregacionGeografica, $lineaBase, $periodicidad, $fuenteDatos, $observaciones, $fechaElaboracion);
$pdf->Output();
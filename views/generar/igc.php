<?php

set_include_path(dirname(__FILE__) . "/../");
require('../resources/lib/tfpdf/tfpdf.php');

class PDFIgc extends tFPDF {

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
        $this->Ln(14);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 8);
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
        $this->SetFillColor(200, 200, 200);
        $this->SetTextColor(0);
        $cont = $this->replaceBR($content);
        $nb = $this->WordWrap($cont, 147);
        $this->SetFontSize(9.8);
        $this->Cell(41, 6 * $nb, $title, 1, 0, 'C', $fill);
        $this->Multicell(0, 6, $cont, 1, 'J', $fill);
    }

    function rowMulticellSection($title, $content, $fill) {
        $this->SetFillColor(200, 200, 200);
        $this->SetTextColor(0);
        $cont = $this->replaceBR($content);
        $nb = $this->WordWrap($cont, 147);
        $this->SetFontSize(9.8);
        $this->Multicell(41, 7 * $nb / 2, $title, 1, 'C', $fill);
        $this->SetXY(51, $this->GetY() - ($nb * 7));
        $this->Multicell(0, 7, $cont, 1, 'J', $fill);
    }

    function TablaIGC($nombreDimension, $nombreTematica, $nombreIndicador, $justificacion, $definicion, $metodologia, $referencia, $observaciones, $otrasOrganizaciones, $unidadMedida, $fuenteDatos, $periodicidad) {
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
        $this->rowCellSection("Justificación", $justificacion, !$fill);
        $this->rowCellSection("Definición", $definicion, $fill);
        $this->rowCellSection("Metodología", $metodologia, !$fill);
        $this->rowCellSection("Referencia", $referencia, $fill);
        if (strpos($nombreIndicador, "roducto Interno Bruto de la ciudad por habitante (corrientes)") != FALSE
                || strpos($nombreIndicador, "elación alumno / docente")!=FALSE 
                || strpos($nombreIndicador, "ortalidad de menores de cinco años por 1.000 nacidos vivos")!=FALSE 
                || strpos($nombreIndicador, "onsumo de agua residencial (litros-día) per cápita")!=FALSE ) {
            $this->Ln(20);
        }
        if (strpos($nombreIndicador, "onsumo total de agua (litros-día) per cápita") != FALSE){
            $this->Ln(50);
        }
        $this->rowMulticellSection("Observaciones y limitaciones", $observaciones, !$fill);
        if (strpos($nombreIndicador, "elación empleo / vivienda") != FALSE) {
            $this->Ln();
        }
        if (strpos($nombreIndicador, "orcentaje de viviendas con servicio de recolección de residuos sólidos") != FALSE) {
            $this->Ln(20);
        }
        $this->rowMulticellSection("Otras organizaciones que usan el indicador", $otrasOrganizaciones, $fill);
        $this->rowCellSection("Unidad de medida", $unidadMedida, !$fill);
        $this->rowCellSection("Fuente de datos", $fuenteDatos, $fill);
        $this->rowCellSection("Periodicidad", $periodicidad, !$fill);
    }

}

$pdf = new PDFIgc();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetY(40);

$nombreDimension = "";
$nombreTematica = "";
$nombreIndicador = "";
$justificacion = "";
$definicion = "";
$metodologia = "";
$referencia = "";
$observaciones = "";
$otrasOrganizaciones = "";
$unidadMedida = "";
$fuenteDatos = "";
$periodicidad = "";

if (isset($_POST['dimensionForm']) && isset($_POST['tematicaForm']) && isset($_POST['indicadorForm']) && isset($_POST['justificacionForm']) && isset($_POST['definicionForm']) && isset($_POST['metodologiaForm']) && isset($_POST['referenciaForm']) && isset($_POST['observacionesForm']) && isset($_POST['otrasOrganizacionesForm']) && isset($_POST['unidadMedidaForm']) && isset($_POST['fuenteForm']) &&
        isset($_POST['periodicidadForm'])) {

    $nombreDimension = $_POST['dimensionForm'];
    $nombreTematica = $_POST['tematicaForm'];
    $nombreIndicador = $_POST['indicadorForm'];
    $justificacion = $_POST['justificacionForm'];
    $definicion = $_POST['definicionForm'];
    $metodologia = $_POST['metodologiaForm'];
    $referencia = $_POST['referenciaForm'];
    $observaciones = $_POST['observacionesForm'];
    $otrasOrganizaciones = $_POST['otrasOrganizacionesForm'];
    $unidadMedida = $_POST['unidadMedidaForm'];
    $fuenteDatos = $_POST['fuenteForm'];
    $periodicidad = $_POST['periodicidadForm'];
}
$pdf->TablaIGC($nombreDimension, $nombreTematica, $nombreIndicador, $justificacion, $definicion, $metodologia, $referencia, $observaciones, $otrasOrganizaciones, $unidadMedida, $fuenteDatos, $periodicidad);
$pdf->Output();

<?php

set_include_path(dirname(__FILE__) . "/../");
require('../resources/lib/tfpdf/tfpdf.php');

class PDFPerfiles extends tFPDF {

    function Header() {
        $this->Image('logo-dapm.png', 8, 10, 37);
        $this->SetFont('Arial', 'B', 9.3);
        $this->Ln(3);
        $this->Cell(0, 10, utf8_decode('DEPARTAMENTO ADMINISTRATIVO DE PLANEACIÓN'), 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(0, 10, utf8_decode('SUBDIRECCIÓN DE DESARROLLO INTEGRAL'), 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(0, 10, utf8_decode('SISTEMA DE INDICADORES SOCIALES'), 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(0, 10, utf8_decode('PERFILES POR COMUNAS'), 0, 0, 'C');
        $this->Image('logo.png', 158, 16, 51);
        $this->Ln(12);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 8, utf8_decode('Elaborado por: Sistema de Indicadores Sociales de Santiago de Cali / Departamento Administrativo de Planeación'), 0, 0, 'L');
        $this->Ln(4);
        $this->Cell(0, 8, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'r');
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
        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor(33,90,154);
        $this->SetTextColor(255);
        $this->SetDrawColor(33,90,154);
        $this->SetLineWidth(.09);
        $this->Cell(0, 7, utf8_decode($title), 1, 0, 'C', 1);
        $this->SetFont('Dejavu');
        $this->Ln(7);
    }

    function titleSubSection($subtitle) {
        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor(81,159,215);
        $this->SetTextColor(255);
        $this->SetLineWidth(.09);
        $this->Cell(0, 6, utf8_decode($subtitle), 1, 0, 'C', 1);
        $this->SetFont('DejaVu');
        $this->Ln();
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

    function rowCellColumnsSection($title, $content1, $content2, $content3, $fill, $category) {
        $this->SetFillColor(200, 200, 200);
        $this->SetTextColor(0);
        $cont1 = $this->replaceBR($content1);
        $cont2 = $this->replaceBR($content2);
        $cont3 = $this->replaceBR($content3);
        $this->SetFontSize(9.8);
        if ($category === "Generalidades") {
            $this->Cell(60, 6, $title, 1, 0, 'C', $fill);
            $this->Cell(40, 6, $cont1, 1, 0, 'R', $fill);
            $this->Cell(20, 6, $cont2, 1, 0, 'C', $fill);
            $this->Cell(70, 6, $cont3, 1, 0, 'L', $fill);
        } elseif ($category === "Salud") {
            $this->Cell(95, 6, $title, 1, 0, 'C', $fill);
            $this->Cell(10, 6, $cont1, 1, 0, 'R', $fill);
            $this->Cell(12, 6, $cont2, 1, 0, 'C', $fill);
            $this->Cell(73, 6, $cont3, 1, 0, 'L', $fill);
        } elseif ($category === "Educación") {
            $this->Cell(80, 6, $title, 1, 0, 'C', $fill);
            $this->Cell(15, 6, $cont1, 1, 0, 'R', $fill);
            $this->Cell(12, 6, $cont2, 1, 0, 'C', $fill);
            $this->Cell(83, 6, $cont3, 1, 0, 'L', $fill);
        } elseif ($category === "Cultura") {
            $this->Cell(80, 6, $title, 1, 0, 'C', $fill);
            $this->Cell(20, 6, $cont1, 1, 0, 'R', $fill);
            $this->Cell(20, 6, $cont2, 1, 0, 'C', $fill);
            $this->Cell(70, 6, $cont3, 1, 0, 'L', $fill);
        } elseif ($category === "Paz y seguridad ciudadana") {
            $nb = $this->WordWrap($title, 95);
            if ($nb < 2) {
                $this->Multicell(95, 12, $title, 1, 'C', $fill);
            } else {
                $this->Multicell(95, 6, $title, 1, 'C', $fill);
            }
            $this->SetXY(105, $this->GetY() - 12);
            $this->Multicell(15, 12, $cont1, 1, 'R', $fill);
            $this->SetXY(120, $this->GetY() - 12);
            $this->Multicell(15, 12, $cont2, 1, 'C', $fill);
            $this->SetXY(135, $this->GetY() - 12);
            $this->Multicell(0, 6, $cont3, 1, 'L', $fill);
            $this->Ln(-6);
        } elseif ($category === "Dependencia" || $category === "Educación2" || $category === "Mercado laboral" || $category === "Salud2") {
            $this->Cell(100, 6, $title, 1, 0, 'C', $fill);
            $this->Cell(20, 6, $cont1, 1, 0, 'R', $fill);
            $this->Cell(20, 6, $cont2, 1, 0, 'C', $fill);
            $this->Cell(50, 6, $cont3, 1, 0, 'L', $fill);
        } elseif ($category === "Servicios públicos" || $category === "Uso de TICS") {
            $this->Cell(135, 6, $title, 1, 0, 'C', $fill);
            $this->Cell(13, 6, $cont1, 1, 0, 'R', $fill);
            $this->Cell(12, 6, $cont2, 1, 0, 'C', $fill);
            $this->Cell(30, 6, $cont3, 1, 0, 'L', $fill);
        } else {
            $this->Cell(60, 6, $title, 1, 0, 'C', $fill);
            $this->Cell(30, 6, $cont1, 1, 0, 'R', $fill);
            $this->Cell(10, 6, $cont2, 1, 0, 'C', $fill);
            $this->Cell(90, 6, $cont3, 1, 0, 'L', $fill);
        }
    }

    function rowCellTitlesColumns($title, $content1, $content2, $content3, $fill, $category) {
        $this->SetFillColor(58,112,186);
        $this->SetTextColor(50, 50, 45);
        $this->SetFont('Arial', 'B', 10);
        $cont1 = $this->replaceBR($content1);
        $cont2 = $this->replaceBR($content2);
        $cont3 = $this->replaceBR($content3);
        $this->SetFontSize(9.8);
        if ($category === "Generalidades") {
            $this->Cell(60, 6, $title, 'T', 0, 'C', $fill);
            $this->Cell(40, 6, $cont1, 'TBRL', 0, 'C', $fill);
            $this->Cell(20, 6, $cont2, 'TBRL', 0, 'C', $fill);
            $this->Cell(70, 6, $cont3, 'TB', 0, 'C', $fill);
        } elseif ($category === "Salud") {
            $this->Cell(95, 6, $title, 1, 0, 'C', $fill);
            $this->Cell(10, 6, $cont1, 1, 0, 'C', $fill);
            $this->Cell(12, 6, $cont2, 1, 0, 'C', $fill);
            $this->Cell(73, 6, $cont3, 1, 0, 'C', $fill);
        } elseif ($category === "Educación") {
            $this->Cell(80, 6, $title, 1, 0, 'C', $fill);
            $this->Cell(15, 6, $cont1, 1, 0, 'C', $fill);
            $this->Cell(12, 6, $cont2, 1, 0, 'C', $fill);
            $this->Cell(83, 6, $cont3, 1, 0, 'C', $fill);
        } elseif ($category === "Cultura") {
            $this->Cell(80, 6, $title, 1, 0, 'C', $fill);
            $this->Cell(20, 6, $cont1, 1, 0, 'C', $fill);
            $this->Cell(20, 6, $cont2, 1, 0, 'C', $fill);
            $this->Cell(70, 6, $cont3, 1, 0, 'C', $fill);
        } elseif ($category === "Paz y seguridad ciudadana") {
            $this->Cell(95, 6, $title, 1, 0, 'C', $fill);
            $this->Cell(15, 6, $cont1, 1, 0, 'C', $fill);
            $this->Cell(15, 6, $cont2, 1, 0, 'C', $fill);
            $this->Cell(0, 6, $cont3, 1, 0, 'C', $fill);
        } elseif ($category === "Dependencia" || $category === "Educación2" || $category === "Mercado laboral" || $category === "Salud2") {
            $this->Cell(100, 6, $title, 1, 0, 'C', $fill);
            $this->Cell(20, 6, $cont1, 1, 0, 'C', $fill);
            $this->Cell(20, 6, $cont2, 1, 0, 'C', $fill);
            $this->Cell(50, 6, $cont3, 1, 0, 'C', $fill);
        } elseif ($category === "Servicios públicos" || $category === "Uso de TICS") {
            $this->Cell(135, 6, $title, 1, 0, 'C', $fill);
            $this->Cell(13, 6, $cont1, 1, 0, 'C', $fill);
            $this->Cell(12, 6, $cont2, 1, 0, 'C', $fill);
            $this->Cell(30, 6, $cont3, 1, 0, 'C', $fill);
        } else {
            $this->Cell(60, 6, $title, 1, 0, 'C', $fill);
            $this->Cell(30, 6, $cont1, 1, 0, 'C', $fill);
            $this->Cell(10, 6, $cont2, 1, 0, 'C', $fill);
            $this->Cell(90, 6, $cont3, 1, 0, 'C', $fill);
        }
        $this->SetFont('DejaVu');
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

    function createSection($titleSection, $explode, $fill) {
        $this->titleSection($titleSection);
        $this->rowCellTitlesColumns("Indicador", "Dato", "Fecha", "Fuente", $fill, $titleSection);
        $this->Ln();
        $exp = explode("++", $explode);
        for ($i = 0; $i < count($exp) - 1; $i++) {
            $item = explode("*", $exp[$i]);
            $nombreIndicador = $item[0];
            $fechaDato = $item[1];
            $valorDato = $item[2];
            $fuenteDatos = $item[3];
            $this->rowCellColumnsSection($nombreIndicador, $valorDato, $fechaDato, $fuenteDatos, $fill, $titleSection);
            $this->Ln();
            $fill = !$fill;
        }
        $this->Ln(4);
    }

    function createSubSection($titleSubSection, $explode, $fill) {
        if ($titleSubSection == "Dependencia") {
            $this->Ln(2);
            $this->titleSubSection($titleSubSection);
        } elseif ($titleSubSection == "Educación2") {
            $this->titleSubSection("Educación");
        } elseif ($titleSubSection == "Salud2") {
            $this->titleSubSection("Salud");
        } else {
            $this->titleSubSection($titleSubSection);
        }
        $this->rowCellTitlesColumns("Indicador", "Dato", "Fecha", "Fuente", $fill, $titleSubSection);
        $this->Ln();
        $this->SetDrawColor(33,90,154);
        $exp = explode("++", $explode);
        for ($i = 0; $i < count($exp) - 1; $i++) {
            $item = explode("*", $exp[$i]);
            $nombreIndicador = $item[0];
            $fechaDato = $item[1];
            $valorDato = $item[2];
            $fuenteDatos = $item[3];
            $this->rowCellColumnsSection($nombreIndicador, $valorDato, $fechaDato, $fuenteDatos, $fill, $titleSubSection);
            $this->Ln();
            $fill = !$fill;
        }
        $this->Ln(2);
    }

    function TablaPerfiles($nombreComuna, $generalidades, $salud, $educacion, $cultura, $pazSeguridad, $encuestaDependencia, $encuestaEducacion, $encuestaMercadoLaboral, $encuestaSalud, $encuestaServiciosPublicos, $encuestaTics) {
        $fill = true;

        $this->SetTextColor(0);
        $this->SetFontSize(11);
        $this->Cell(0, 12, utf8_decode($nombreComuna), 0, 0, 'C', 0);
        $this->Ln(15);
        $this->AddFont('DejaVu', '', 'FreeSans.ttf', true);
        $this->SetFont('DejaVu', '', 10);
        $this->createSection("Generalidades", $generalidades, $fill);
        $this->createSection("Salud", $salud, $fill);
        $this->createSection("Educación", $educacion, $fill);
        $this->createSection("Cultura", $cultura, $fill);
        $this->createSection("Paz y seguridad ciudadana", $pazSeguridad, $fill);
        $this->titleSection("Encuesta de Empleo y Calidad de Vida");
        $this->createSubSection("Dependencia", $encuestaDependencia, $fill);
        $this->createSubSection("Educación2", $encuestaEducacion, $fill);
        $this->createSubSection("Mercado laboral", $encuestaMercadoLaboral, $fill);
        $this->createSubSection("Salud2", $encuestaSalud, $fill);
        $this->createSubSection("Servicios públicos", $encuestaServiciosPublicos, $fill);
        $this->createSubSection("Uso de TICS", $encuestaTics, $fill);
    }

}

$pdf = new PDFPerfiles();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(TRUE, 20);
$pdf->AddPage();


$nombreComuna = "";
$generalidades = "";
$salud = "";
$educacion = "";
$cultura = "";
$pazSeguridad = "";
$encuestaDependencia = "";
$encuestaEducacion = "";
$encuestaMercadoLaboral = "";
$encuestaSalud = "";
$encuestaServiciosPublicos = "";
$encuestaTics = "";


if (isset($_POST['nombreComunaForm']) && isset($_POST['generalidadesForm']) && isset($_POST['saludForm']) && isset($_POST['educacionForm']) && isset($_POST['culturaForm']) && isset($_POST['pazSeguridadForm']) && isset($_POST['encuestaDependenciaForm']) && isset($_POST['encuestaEducacionForm']) && isset($_POST['encuestaMercadoLaboralForm']) && isset($_POST['encuestaSaludForm']) && isset($_POST['encuestaServiciosPublicosForm']) && isset($_POST['encuestaTicsForm'])) {

    $nombreComuna = $_POST['nombreComunaForm'];
    $generalidades = $_POST['generalidadesForm'];
    $salud = $_POST['saludForm'];
    $educacion = $_POST['educacionForm'];
    $cultura = $_POST['culturaForm'];
    $pazSeguridad = $_POST['pazSeguridadForm'];
    $encuestaDependencia = $_POST['encuestaDependenciaForm'];
    $encuestaEducacion = $_POST['encuestaEducacionForm'];
    $encuestaMercadoLaboral = $_POST['encuestaMercadoLaboralForm'];
    $encuestaSalud = $_POST['encuestaSaludForm'];
    $encuestaServiciosPublicos = $_POST['encuestaServiciosPublicosForm'];
    $encuestaTics = $_POST['encuestaTicsForm'];
}
$pdf->TablaPerfiles($nombreComuna, $generalidades, $salud, $educacion, $cultura, $pazSeguridad, $encuestaDependencia, $encuestaEducacion, $encuestaMercadoLaboral, $encuestaSalud, $encuestaServiciosPublicos, $encuestaTics);
$pdf->Output();

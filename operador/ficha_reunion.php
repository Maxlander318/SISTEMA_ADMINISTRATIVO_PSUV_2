<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/fpdf/fpdf.php';
check_login();

if (!isset($_GET['id'])) {
    die("ID de reunión no proporcionado.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM REUNIONES WHERE ID_REUNION = ?");
$stmt->execute([$id]);
$reunion = $stmt->fetch();

if (!$reunion) {
    die("Reunión no encontrada.");
}

class FICHA extends FPDF {
    function Header() {
        // Marco decorativo
        $this->Rect(5, 5, 200, 287);
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(30, 58, 138);
        $this->Cell(0, 15, utf8_decode('FICHA DE REUNIÓN PROGRAMADA'), 0, 1, 'C');
        $this->SetDrawColor(30, 58, 138);
        $this->Line(50, 22, 160, 22);
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Sistema Administrativo PSUV - Generado el ') . date('d/m/Y H:i:s'), 0, 0, 'C');
    }
}

$pdf = new FICHA();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Estilo de etiquetas
$pdf->SetFillColor(241, 245, 249);
$pdf->SetTextColor(51, 65, 85);

// Sección 1: Detalles de la Reunión
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(0, 10, utf8_decode('1. DATOS DE LA ACTIVIDAD'), 0, 1, 'L');
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 10, utf8_decode(' Tipo de Reunión:'), 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(150, 10, utf8_decode(' ' . $reunion['TIPO_REUNION']), 1, 1, 'L');

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 10, utf8_decode(' Fecha:'), 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(55, 10, ' ' . date('d/m/Y', strtotime($reunion['FECHA'])), 1, 0, 'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 10, utf8_decode(' Hora:'), 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(55, 10, ' ' . date('h:i A', strtotime($reunion['HORA'])), 1, 1, 'L');

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 10, utf8_decode(' Parroquia:'), 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(150, 10, utf8_decode(' ' . $reunion['PARROQUIA']), 1, 1, 'L');

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 10, utf8_decode(' Lugar:'), 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(150, 10, utf8_decode(' ' . $reunion['LUGAR']), 1, 'L');

$pdf->Ln(10);

// Sección 2: Responsable
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(0, 10, utf8_decode('2. RESPONSABLE DE LA REUNIÓN'), 0, 1, 'L');
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(50, 10, utf8_decode(' Nombre Completo:'), 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(140, 10, utf8_decode(' ' . $reunion['RESPONSABLE_NOMBRE']), 1, 1, 'L');

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(50, 10, utf8_decode(' Cédula de Identidad:'), 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(140, 10, utf8_decode(' ' . $reunion['RESPONSABLE_CEDULA']), 1, 1, 'L');

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(50, 10, utf8_decode(' Teléfono de Contacto:'), 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(140, 10, utf8_decode(' ' . $reunion['RESPONSABLE_TELEFONO']), 1, 1, 'L');

$pdf->Ln(20);

// Área de Firmas
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(95, 10, '__________________________', 0, 0, 'C');
$pdf->Cell(95, 10, '__________________________', 0, 1, 'C');
$pdf->Cell(95, 5, 'Firma del Responsable', 0, 0, 'C');
$pdf->Cell(95, 5, 'Sello / Autorizado', 0, 1, 'C');

$pdf->Output('I', 'Ficha_Reunion_' . $id . '.pdf');
?>

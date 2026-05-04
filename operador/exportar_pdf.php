<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/database.php';
// Asegurarse de que FPDF esté en includes/fpdf/
require_once __DIR__ . '/../includes/fpdf/fpdf.php';
check_login();

$fecha = $_GET['fecha'] ?? '';
$tipo = $_GET['tipo'] ?? '';

$query = "SELECT R.*, P.NOMBRES, P.APELLIDOS, P.CEDULAS, S.TITULO, S.FECHA, S.TIPO 
          FROM REGISTRO_ASISTENCIA R 
          JOIN PERSONAS P ON R.ID_PERSONAS = P.ID_PERSONAS 
          JOIN SESIONES S ON R.ID_SESIONES = S.ID_SESION 
          WHERE 1=1";
$params = [];

if ($fecha) {
    $query .= " AND S.FECHA = ?";
    $params[] = $fecha;
}
if ($tipo) {
    $query .= " AND S.TIPO = ?";
    $params[] = $tipo;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$asistencias = $stmt->fetchAll();

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'Reporte de Asistencia - Sistema PSUV', 0, 1, 'C');
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Generado el: ' . date('d/m/Y h:i A'), 0, 1, 'R');
        $this->Ln(5);
        
        // Cabeceras de tabla
        $this->SetFillColor(30, 58, 138); // Primary Color
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(25, 8, utf8_decode('Cédula'), 1, 0, 'C', true);
        $this->Cell(60, 8, 'Nombre Completo', 1, 0, 'C', true);
        $this->Cell(40, 8, utf8_decode('Sesión'), 1, 0, 'C', true);
        $this->Cell(25, 8, 'Fecha', 1, 0, 'C', true);
        $this->Cell(25, 8, 'Hora', 1, 0, 'C', true);
        $this->Cell(15, 8, 'Estado', 1, 1, 'C', true);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0, 0, 0);

foreach ($asistencias as $a) {
    $pdf->Cell(25, 7, $a['CEDULAS'], 1, 0, 'C');
    $pdf->Cell(60, 7, utf8_decode($a['NOMBRES'] . ' ' . $a['APELLIDOS']), 1, 0, 'L');
    $pdf->Cell(40, 7, utf8_decode($a['TITULO']), 1, 0, 'L');
    $pdf->Cell(25, 7, date('d/m/Y', strtotime($a['FECHA'])), 1, 0, 'C');
    $pdf->Cell(25, 7, date('h:i A', strtotime($a['MARCACION'])), 1, 0, 'C');
    $pdf->Cell(15, 7, $a['ESTADO'], 1, 1, 'C');
}

if (empty($asistencias)) {
    $pdf->Cell(190, 10, 'No hay registros para mostrar.', 1, 1, 'C');
}

$pdf->Output('I', 'reporte_asistencias.pdf');
?>

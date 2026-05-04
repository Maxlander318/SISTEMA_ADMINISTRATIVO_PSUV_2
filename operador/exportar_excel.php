<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/database.php';
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

// Cabeceras para descarga de CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=reporte_asistencias_' . date('Ymd_His') . '.csv');

$output = fopen('php://output', 'w');
// UTF-8 BOM para Excel
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

fputcsv($output, ['Cédula', 'Nombre', 'Apellido', 'Sesión', 'Fecha', 'Tipo', 'Marcación', 'Estado']);

foreach ($asistencias as $a) {
    fputcsv($output, [
        $a['CEDULAS'],
        $a['NOMBRES'],
        $a['APELLIDOS'],
        $a['TITULO'],
        $a['FECHA'],
        $a['TIPO'],
        $a['MARCACION'],
        $a['ESTADO']
    ]);
}

fclose($output);
exit();
?>

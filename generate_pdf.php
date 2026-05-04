<?php
require_once __DIR__ . '/includes/fpdf/fpdf.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, utf8_decode('Guía de Usuario: Sistema Administrativo PSUV 2'), 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function ChapterTitle($title) {
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(0, 10, utf8_decode($title), 0, 1, 'L', true);
        $this->Ln(4);
    }

    function ChapterBody($body) {
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 5, utf8_decode($body));
        $this->Ln();
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->ChapterTitle('1. Introducción');
$pdf->ChapterBody("El Sistema Administrativo PSUV 2 es una plataforma diseñada para centralizar la gestión de actividades políticas, control de asistencia y auditoría de procesos en un entorno seguro y moderno.");

$pdf->ChapterTitle('2. Roles de Usuario y Niveles de Acceso');
$pdf->ChapterBody("- Administrador: Acceso total. Gestiona usuarios, realiza respaldos de base de datos, revisa logs de auditoría y supervisa la agenda.\n- Operador: Gestión del día a día. Crea sesiones de asistencia, registra participantes y programa/finaliza reuniones de la agenda.\n- Visualizador: Rol de consulta. Solo puede ver los dashboards, listas de reuniones y reportes sin realizar cambios.");

$pdf->ChapterTitle('3. Módulo de Agenda (Reuniones)');
$pdf->ChapterBody("- Programación: Registro de reuniones con fecha, hora (12h AM/PM), parroquia y lugar.\n- Gestión de Tiempo: Selector secuencial 1 a 1 para horas y minutos.\n- Finalización: Botón 'Finalizar' que marca la actividad como ejecutada (Verde) y la suma al Dashboard.\n- Ficha PDF: Generación automática de ficha técnica imprimible.");

$pdf->ChapterTitle('4. Control de Asistencia');
$pdf->ChapterBody("- Sesiones: Creación de eventos específicos.\n- Registro: Carga por cédula con captura automática de hora de marcación.\n- Validación: Prevención de registros duplicados.");

$pdf->ChapterTitle('5. Dashboards Estadísticos');
$pdf->ChapterBody("- Estadísticas Administrativas: Conteo de Actividades Realizadas y Asistencias por semana, mes y año.\n- Filtros: Búsqueda dinámica por fecha o tipo de evento.");

$pdf->ChapterTitle('6. Seguridad y Mantenimiento');
$pdf->ChapterBody("- Logs: Registro de cada acción realizada en el sistema.\n- Respaldos: Herramienta de backup y restauración SQL integrada.\n- Gestión de Usuarios: Control de estado (Activo/Suspendido).");

$pdf->ChapterTitle('7. Requerimientos Técnicos');
$pdf->ChapterBody("Servidor: XAMPP (Apache + MariaDB).\nNavegador: Google Chrome, Microsoft Edge, Firefox.\nBase de Datos: sistema_administrativo.");

if (!is_dir(__DIR__ . '/GUIA')) {
    mkdir(__DIR__ . '/GUIA', 0777, true);
}

$pdf->Output('F', __DIR__ . '/GUIA/Manual_Sistema.pdf');
echo "PDF generado exitosamente en GUIA/Manual_Sistema.pdf\n";
?>

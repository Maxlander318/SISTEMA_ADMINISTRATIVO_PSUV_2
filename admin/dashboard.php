<?php
$title = "Dashboard Administrativo";
require_once __DIR__ . '/../includes/layout_header.php';
require_once __DIR__ . '/../config/database.php';
check_admin();

// Estadísticas Generales
$users_count = $pdo->query("SELECT COUNT(*) FROM USUARIOS")->fetchColumn();
$personas_count = $pdo->query("SELECT COUNT(*) FROM PERSONAS")->fetchColumn();

// Usuarios en línea (actividad en los últimos 5 minutos)
$online_count = $pdo->query("SELECT COUNT(*) FROM USUARIOS WHERE ULTIMA_ACTIVIDAD >= DATE_SUB(NOW(), INTERVAL 5 MINUTE)")->fetchColumn();

// Estadísticas de Actividades (Reuniones Finalizadas)
$actividades_semana = $pdo->query("SELECT COUNT(*) FROM REUNIONES WHERE FECHA >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND ESTADO = 'Finalizada'")->fetchColumn();
$actividades_mes = $pdo->query("SELECT COUNT(*) FROM REUNIONES WHERE FECHA >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND ESTADO = 'Finalizada'")->fetchColumn();
$actividades_año = $pdo->query("SELECT COUNT(*) FROM REUNIONES WHERE FECHA >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR) AND ESTADO = 'Finalizada'")->fetchColumn();

// Estadísticas de Asistencias Reportadas
$asistencias_semana = $pdo->query("SELECT COUNT(*) FROM REGISTRO_ASISTENCIA WHERE MARCACION >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn();
$asistencias_mes = $pdo->query("SELECT COUNT(*) FROM REGISTRO_ASISTENCIA WHERE MARCACION >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetchColumn();
$asistencias_año = $pdo->query("SELECT COUNT(*) FROM REGISTRO_ASISTENCIA WHERE MARCACION >= DATE_SUB(NOW(), INTERVAL 1 YEAR)")->fetchColumn();

// Logs recientes
$recent_logs = $pdo->query("SELECT L.*, U.NOMBRE_USUARIO FROM LOGS_SISTEMA L JOIN USUARIOS U ON L.ID_USUARIO = U.ID_USUARIO ORDER BY L.FECHA DESC LIMIT 5")->fetchAll();
?>

<div class="stats-grid">
    <div class="stat-card" style="border-bottom: 4px solid var(--success);">
        <span class="stat-label">En Línea</span>
        <span class="stat-value"><?php echo $online_count; ?></span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Usuarios</span>
        <span class="stat-value"><?php echo $users_count; ?></span>
    </div>
</div>

<h4 style="margin: 2rem 0 1rem; color: var(--primary-color);">Resumen de Actividades Realizadas (Agenda)</h4>
<div class="stats-grid">
    <div class="stat-card" style="border-bottom: 4px solid var(--accent);">
        <span class="stat-label">Actividades (Semana)</span>
        <span class="stat-value"><?php echo $actividades_semana; ?></span>
    </div>
    <div class="stat-card" style="border-bottom: 4px solid var(--accent);">
        <span class="stat-label">Actividades (Mes)</span>
        <span class="stat-value"><?php echo $actividades_mes; ?></span>
    </div>
    <div class="stat-card" style="border-bottom: 4px solid var(--accent);">
        <span class="stat-label">Actividades (Año)</span>
        <span class="stat-value"><?php echo $actividades_año; ?></span>
    </div>
</div>

<h4 style="margin: 2rem 0 1rem; color: var(--primary-color);">Resumen de Asistencias Reportadas</h4>
<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-label">Asistencias (Semana)</span>
        <span class="stat-value"><?php echo $asistencias_semana; ?></span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Asistencias (Mes)</span>
        <span class="stat-value"><?php echo $asistencias_mes; ?></span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Asistencias (Año)</span>
        <span class="stat-value"><?php echo $asistencias_año; ?></span>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/layout_footer.php'; ?>

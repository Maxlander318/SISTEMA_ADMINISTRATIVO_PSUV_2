<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session.php';
check_login();
$current_page = basename($_SERVER['PHP_SELF']);
$user_level = $_SESSION['user_level'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Administrativo</title>
    <link rel="stylesheet" href="../public/assets/css/style.css?v=1.7">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>Sistema Administrativo</h3>
        </div>
        <nav class="sidebar-menu">
            <?php if ($user_level === 'admin'): ?>
                <a href="dashboard.php" class="menu-item <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a href="usuarios.php" class="menu-item <?php echo $current_page == 'usuarios.php' ? 'active' : ''; ?>">
                    <i class="fas fa-users-cog"></i> Gestión de Usuarios
                </a>
                <a href="modulos.php" class="menu-item <?php echo $current_page == 'modulos.php' ? 'active' : ''; ?>">
                    <i class="fas fa-cubes"></i> Control de módulos
                </a>
                <a href="reuniones.php" class="menu-item <?php echo $current_page == 'reuniones.php' ? 'active' : ''; ?>">
                    <i class="fas fa-calendar-check"></i> Agendas semanales
                </a>
                <a href="reportes.php" class="menu-item <?php echo $current_page == 'reportes.php' ? 'active' : ''; ?>">
                    <i class="fas fa-file-invoice"></i> Reportes de asistencia
                </a>
                <a href="backup.php" class="menu-item <?php echo $current_page == 'backup.php' ? 'active' : ''; ?>">
                    <i class="fas fa-database"></i> Respaldar base de datos
                </a>
                <a href="logs.php" class="menu-item <?php echo $current_page == 'logs.php' ? 'active' : ''; ?>">
                    <i class="fas fa-history"></i> Auditoría de acciones
                </a>
            <?php elseif ($user_level === 'operador'): ?>
                <a href="dashboard.php" class="menu-item <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
                    <i class="fas fa-tachometer-alt"></i> Panel Operador
                </a>
                <a href="sesiones.php" class="menu-item <?php echo $current_page == 'sesiones.php' ? 'active' : ''; ?>">
                    <i class="fas fa-list-ul"></i> Gestionar Sesiones
                </a>
                <a href="reuniones.php" class="menu-item <?php echo $current_page == 'reuniones.php' ? 'active' : ''; ?>">
                    <i class="fas fa-calendar-plus"></i> Agendas semanales
                </a>
                <a href="reportes.php" class="menu-item <?php echo $current_page == 'reportes.php' ? 'active' : ''; ?>">
                    <i class="fas fa-file-medical"></i> Reportes de asistencia
                </a>
            <?php elseif ($user_level === 'visualizador'): ?>
                <a href="dashboard.php" class="menu-item <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
                    <i class="fas fa-eye"></i> Vista General
                </a>
                <a href="reuniones.php" class="menu-item <?php echo $current_page == 'reuniones.php' ? 'active' : ''; ?>">
                    <i class="fas fa-calendar-day"></i> Agendas semanales
                </a>
                <a href="reportes.php" class="menu-item <?php echo $current_page == 'reportes.php' ? 'active' : ''; ?>">
                    <i class="fas fa-clipboard-check"></i> Asistencias reportadas
                </a>
            <?php endif; ?>
        </nav>
        <div style="padding: 1rem;">
            <a href="../public/logout.php" class="menu-item" style="color: #000000ff;">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </div>

    <div class="main-wrapper">
        <header>
            <div class="header-left">
                <h2 style="color: var(--primary-color);"><?php echo $title ?? 'Dashboard'; ?></h2>
            </div>
            <div class="header-right">
                <span>Bienvenido, <strong><?php echo $_SESSION['user_name']; ?></strong> | Rol: <strong><?php echo ucfirst($user_level); ?></strong></span>
            </div>
        </header>
        <main class="content-area">
            <?php display_flash_message(); ?>

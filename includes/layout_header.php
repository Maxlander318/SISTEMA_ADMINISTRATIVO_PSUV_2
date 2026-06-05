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
    <link rel="stylesheet" href="../public/assets/css/style.css?v=3.0">
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
            <hr style="border: 0; border-top: 1px solid rgba(0,0,0,0.1); margin: 0.5rem 0;">
            <a href="../public/logout.php" class="menu-item" style="color: #b30000; font-weight: 700;">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </nav>
    </div>
    <div class="sidebar-overlay"></div>

    <div class="main-wrapper">
        <header>
            <div class="header-left" style="display: flex; align-items: center; gap: 1rem;">
                <button id="sidebarToggle" class="btn" style="display: none; padding: 0.5rem; background: var(--primary-color); color: white;">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 style="color: var(--primary-color); margin: 0;"><?php echo $title ?? 'Dashboard'; ?></h2>
            </div>
            <div class="header-right">
                <span>Bienvenido, <strong><?php echo $_SESSION['user_name']; ?></strong> | Rol: <strong><?php echo ucfirst($user_level); ?></strong></span>
            </div>
        </header>

        <style>
            @media (max-width: 1024px) {
                #sidebarToggle {
                    display: flex !important;
                }
            }
        </style>

        <script>
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const toggle = document.getElementById('sidebarToggle');

            toggle?.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
            
            overlay?.addEventListener('click', function() {
                sidebar.classList.remove('active');
            });
            
            // Cerrar al hacer click fuera en móvil
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 1024 && 
                    !sidebar.contains(event.target) && 
                    !toggle.contains(event.target) && 
                    sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                }
            });
        </script>
        <main class="content-area">
            <?php display_flash_message(); ?>

<?php
// Gestión de sesiones
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../public/login.php");
        exit();
    }
    // Actualizar última actividad si hay conexión a BD
    global $pdo;
    if (isset($pdo)) {
        $stmt = $pdo->prepare("UPDATE USUARIOS SET ULTIMA_ACTIVIDAD = NOW() WHERE ID_USUARIO = ?");
        $stmt->execute([$_SESSION['user_id']]);
    }
}

function check_admin() {
    if ($_SESSION['user_level'] !== 'admin') {
        header("Location: ../operador/dashboard.php");
        exit();
    }
}

function set_flash_message($message, $type = 'success') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

function display_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $msg = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'];
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        echo "<div class='alert alert-$type'>$msg</div>";
    }
}
?>

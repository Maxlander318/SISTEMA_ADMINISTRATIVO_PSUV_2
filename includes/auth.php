<?php
require_once __DIR__ . '/../config/database.php';

function login($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM USUARIOS WHERE NOMBRE_USUARIO = ? AND ACTIVO = 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['CONTRASENA'])) {
        $_SESSION['user_id'] = $user['ID_USUARIO'];
        $_SESSION['user_name'] = $user['NOMBRE_COMPLETO'];
        $_SESSION['user_level'] = $user['NIVEL'];
        $_SESSION['username'] = $user['NOMBRE_USUARIO'];
        
        // Registrar conexión inicial
        $stmt_update = $pdo->prepare("UPDATE USUARIOS SET ULTIMA_CONEXION = NOW(), ULTIMA_ACTIVIDAD = NOW() WHERE ID_USUARIO = ?");
        $stmt_update->execute([$user['ID_USUARIO']]);
        
        // Log de inicio de sesión
        log_action($user['ID_USUARIO'], 'Inicio de Sesión', 'USUARIOS', $user['ID_USUARIO']);
        
        return true;
    }
    return false;
}

function log_action($user_id, $action, $table = null, $record_id = null) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO LOGS_SISTEMA (ID_USUARIO, ACCION, TABLA_AFECTADA, REGISTRO_ID) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $action, $table, $record_id]);
}

function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>

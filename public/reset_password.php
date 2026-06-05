<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session.php';

$token = $_GET['token'] ?? '';
$error = '';
$success = '';

if (!$token) {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM USUARIOS WHERE TOKEN_RECUPERACION = ? AND TOKEN_EXPIRA > NOW()");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    $error = "El token es inválido o ha expirado.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user) {
    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($pass === $confirm) {
        $hashed = password_hash($pass, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE USUARIOS SET CONTRASENA = ?, TOKEN_RECUPERACION = NULL, TOKEN_EXPIRA = NULL WHERE ID_USUARIO = ?");
        $stmt->execute([$hashed, $user['ID_USUARIO']]);
        $success = "Contraseña actualizada correctamente. Ya puede iniciar sesión.";
    } else {
        $error = "Las contraseñas no coinciden.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="assets/css/style.css?v=1.2">
</head>
<body class="login-container">
    <div class="login-box">
        <h2 class="login-title">Nueva Contraseña</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <a href="login.php" class="btn btn-primary" style="width: 100%; text-align: center;">Ir al Login</a>
        <?php elseif ($user): ?>
            <form method="POST">
                <div class="form-group">
                    <label>Nueva Contraseña</label>
                    <input type="password" name="password" required minlength="6">
                </div>
                <div class="form-group">
                    <label>Confirmar Contraseña</label>
                    <input type="password" name="confirm_password" required minlength="6">
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Cambiar Contraseña</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>

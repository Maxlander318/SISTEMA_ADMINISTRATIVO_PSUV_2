<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../includes/auth.php';

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_level'] === 'admin') {
        header("Location: ../admin/dashboard.php");
    } elseif ($_SESSION['user_level'] === 'operador') {
        header("Location: ../operador/dashboard.php");
    } else {
        header("Location: ../visualizador/dashboard.php");
    }
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (login($username, $password)) {
        if ($_SESSION['user_level'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } elseif ($_SESSION['user_level'] === 'operador') {
            header("Location: ../operador/dashboard.php");
        } else {
            header("Location: ../visualizador/dashboard.php");
        }
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Administrativo</title>
    <link rel="stylesheet" href="assets/css/style.css?v=3.0">
</head>
<body class="login-container">
    <div class="login-box">
        <h2 class="login-title">PSUV Caroní</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Iniciar Sesión</button>
        </form>
        <div style="margin-top: 1.5rem; text-align: center;">
            <a href="recuperar.php" style="color: var(--secondary-color); text-decoration: none; font-size: 0.9rem;">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</body>
</html>

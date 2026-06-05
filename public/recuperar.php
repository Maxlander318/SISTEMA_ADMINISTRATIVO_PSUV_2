<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session.php';

$message = '';
$token_info = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'];
    $stmt = $pdo->prepare("SELECT * FROM USUARIOS WHERE CEDULA = ?");
    $stmt->execute([$cedula]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(16));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $stmt = $pdo->prepare("UPDATE USUARIOS SET TOKEN_RECUPERACION = ?, TOKEN_EXPIRA = ? WHERE ID_USUARIO = ?");
        $stmt->execute([$token, $expires, $user['ID_USUARIO']]);
        
        $message = "Se ha generado un enlace de recuperación.";
        $token_info = "SIMULACIÓN DE EMAIL:<br>Haga clic aquí para restablecer su contraseña:<br> 
                      <a href='reset_password.php?token=$token'>reset_password.php?token=$token</a><br>
                      (Este token expira en 1 hora)";
    } else {
        $message = "La cédula no está registrada.";
        $type = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="assets/css/style.css?v=1.2">
</head>
<body class="login-container">
    <div class="login-box">
        <h2 class="login-title">Recuperar Acceso</h2>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $type ?? 'success'; ?>">
                <?php echo $message; ?>
            </div>
            <?php if ($token_info): ?>
                <div class="alert alert-success" style="background: #f1f5f9; font-size: 0.8rem; border: 1px dashed #cbd5e1;">
                    <?php echo $token_info; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="cedula">Ingrese su Cédula</label>
                <input type="text" name="cedula" id="cedula" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Generar Enlace</button>
        </form>
        <div style="margin-top: 1.5rem; text-align: center;">
            <a href="login.php" style="color: var(--secondary-color); text-decoration: none; font-size: 0.9rem;">Volver al Login</a>
        </div>
    </div>
</body>
</html>

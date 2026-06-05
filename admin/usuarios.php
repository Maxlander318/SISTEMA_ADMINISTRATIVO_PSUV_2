<?php
$title = "Gestión de Usuarios";
require_once __DIR__ . '/../includes/layout_header.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
check_admin();

$csrf_token = generate_csrf_token();

// Procesar Acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'])) {
        die("Error de validación CSRF.");
    }

    // Crear Usuario
    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        $nombre = $_POST['nombre_completo'];
        $cedula = $_POST['cedula'];
        $telefono = $_POST['telefono'];
        $username = $_POST['nombre_usuario'];
        $password = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
        $nivel = $_POST['nivel'];

        try {
            $stmt = $pdo->prepare("INSERT INTO USUARIOS (NOMBRE_COMPLETO, CEDULA, TELEFONO, NOMBRE_USUARIO, CONTRASENA, NIVEL) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $cedula, $telefono, $username, $password, $nivel]);
            log_action($_SESSION['user_id'], "Creado usuario: $username", "USUARIOS", $pdo->lastInsertId());
            set_flash_message("Usuario creado correctamente.");
        } catch (Exception $e) {
            set_flash_message("Error al crear usuario: " . $e->getMessage(), "danger");
        }
    }

    // Cambiar Estado (Habilitar/Deshabilitar)
    if (isset($_POST['action']) && $_POST['action'] === 'toggle_status') {
        $id = $_POST['id_usuario'];
        $status = $_POST['current_status'] == 1 ? 0 : 1;
        $stmt = $pdo->prepare("UPDATE USUARIOS SET ACTIVO = ? WHERE ID_USUARIO = ?");
        $stmt->execute([$status, $id]);
        log_action($_SESSION['user_id'], "Cambiado estado usuario ID: $id", "USUARIOS", $id);
        set_flash_message("Estado de usuario actualizado.");
    }

    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = $_POST['id_usuario'];
        
        try {
            // Iniciar transacción
            $pdo->beginTransaction();
            
            // Primero eliminar los logs asociados a este usuario
            $stmt = $pdo->prepare("DELETE FROM logs_sistema WHERE ID_USUARIO = ?");
            $stmt->execute([$id]);
            
            // Luego eliminar el usuario
            $stmt = $pdo->prepare("DELETE FROM USUARIOS WHERE ID_USUARIO = ?");
            $stmt->execute([$id]);
            
            // Confirmar transacción
            $pdo->commit();
            
            log_action($_SESSION['user_id'], "Eliminado usuario ID: $id", "USUARIOS", $id);
            set_flash_message("Usuario eliminado del sistema.");
        } catch (Exception $e) {
            // Revertir cambios en caso de error
            $pdo->rollBack();
            set_flash_message("Error al eliminar usuario: " . $e->getMessage(), "danger");
        }
    }
}

// Obtener Usuarios
$usuarios = $pdo->query("SELECT * FROM USUARIOS ORDER BY ID_USUARIO DESC")->fetchAll();
?>

<div class="card">
    <h3>Nuevo Usuario</h3>
    <form method="POST" style="margin-top: 1rem; display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <input type="hidden" name="action" value="create">
        <div class="form-group">
            <label>Nombre Completo</label>
            <input type="text" name="nombre_completo" required>
        </div>
        <div class="form-group">
            <label>Cédula</label>
            <input type="text" name="cedula" required>
        </div>
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono" required>
        </div>
        <div class="form-group">
            <label>Nombre de Usuario</label>
            <input type="text" name="nombre_usuario" required>
        </div>
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="contrasena" required>
        </div>
        <div class="form-group">
            <label>Nivel</label>
            <select name="nivel">
                <option value="operador">Operador</option>
                <option value="admin">Administrador</option>
                <option value="visualizador">Visualizador</option>
            </select>
        </div>
        <div style="grid-column: span 3; text-align: right;">
            <button type="submit" class="btn btn-primary">Registrar Usuario</button>
        </div>
    </form>
</div>

<div class="card">
    <h3>Listado de Usuarios</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Nivel</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td data-label="ID"><?php echo $u['ID_USUARIO']; ?></td>
                <td data-label="Nombre"><?php echo $u['NOMBRE_COMPLETO']; ?></td>
                <td data-label="Usuario"><?php echo $u['NOMBRE_USUARIO']; ?></td>
                <td data-label="Nivel"><span class="badge" style="background: <?php echo $u['NIVEL'] == 'admin' ? '#dcfce7' : '#f1f5f9'; ?>; padding: 4px 8px; border-radius: 4px;"><?php echo ucfirst($u['NIVEL']); ?></span></td>
                <td data-label="Estado">
                    <?php if ($u['ACTIVO']): ?>
                        <span style="color: var(--success);">● Activo</span>
                    <?php else: ?>
                        <span style="color: var(--danger);">● Inactivo</span>
                    <?php endif; ?>
                </td>
                <td data-label="Acciones">
                    <div style="display: flex; gap: 0.5rem;">
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <input type="hidden" name="action" value="toggle_status">
                            <input type="hidden" name="id_usuario" value="<?php echo $u['ID_USUARIO']; ?>">
                            <input type="hidden" name="current_status" value="<?php echo $u['ACTIVO']; ?>">
                            <button type="submit" class="btn <?php echo $u['ACTIVO'] ? 'btn-danger' : 'btn-success'; ?>" style="font-size: 0.8rem;">
                                <?php echo $u['ACTIVO'] ? 'Deshabilitar' : 'Habilitar'; ?>
                            </button>
                        </form>
                        
                        <?php if ($u['ID_USUARIO'] != $_SESSION['user_id']): ?>
                        <form method="POST" style="display: inline;" onsubmit="return confirm('¿Seguro que desea eliminar a este usuario?')">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id_usuario" value="<?php echo $u['ID_USUARIO']; ?>">
                            <button type="submit" class="btn btn-danger" style="font-size: 0.8rem; background: #991b1b;">Eliminar</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="card">
    <h3>Sesiones Activas / Usuarios Online</h3>
    <p style="color: var(--text-light); margin-bottom: 1rem;">Muestra los usuarios que han tenido actividad en los últimos 5 minutos.</p>
    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Inicio de Sesión</th>
                <th>Última Actividad</th>
                <th>Tiempo de Sesión</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $online_users = $pdo->query("SELECT * FROM USUARIOS WHERE ULTIMA_ACTIVIDAD >= DATE_SUB(NOW(), INTERVAL 5 MINUTE) ORDER BY ULTIMA_ACTIVIDAD DESC")->fetchAll();
            foreach ($online_users as $uo): 
                $inicio = new DateTime($uo['ULTIMA_CONEXION']);
                $ahora = new DateTime();
                $diff = $inicio->diff($ahora);
                $duracion = $diff->format('%h h %i m');
            ?>
            <tr>
                <td data-label="Usuario"><strong><?php echo $uo['NOMBRE_COMPLETO']; ?></strong><br><small>@<?php echo $uo['NOMBRE_USUARIO']; ?></small></td>
                <td data-label="Rol"><?php echo ucfirst($uo['NIVEL']); ?></td>
                <td data-label="Inicio"><?php echo date('d/m h:i A', strtotime($uo['ULTIMA_CONEXION'])); ?></td>
                <td data-label="Actividad"><?php echo date('h:i:s A', strtotime($uo['ULTIMA_ACTIVIDAD'])); ?></td>
                <td data-label="Tiempo"><?php echo $duracion; ?></td>
                <td data-label="Estado"><span style="color: var(--success); font-weight: 700;">● Online</span></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($online_users)): ?>
            <tr>
                <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-light);">No hay usuarios activos en este momento.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/layout_footer.php'; ?>

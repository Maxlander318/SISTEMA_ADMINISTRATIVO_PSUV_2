<?php
$title = "Gestión de Asistencias";
require_once __DIR__ . '/../includes/layout_header.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

$csrf_token = generate_csrf_token();

// Procesar Acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'])) {
        die("Error de validación CSRF.");
    }

    // Registrar Asistencia
    if (isset($_POST['action']) && $_POST['action'] === 'register') {
        $cedula = $_POST['cedula'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $id_sesion = $_POST['id_sesion'];
        $estado = $_POST['estado'] ?? 'Presente';

        try {
            $pdo->beginTransaction();
            
            // 1. Buscar o crear persona
            $stmt = $pdo->prepare("SELECT ID_PERSONAS FROM PERSONAS WHERE CEDULAS = ?");
            $stmt->execute([$cedula]);
            $persona = $stmt->fetch();
            
            if ($persona) {
                $id_persona = $persona['ID_PERSONAS'];
            } else {
                $stmt = $pdo->prepare("INSERT INTO PERSONAS (CEDULAS, NOMBRES, APELLIDOS) VALUES (?, ?, ?)");
                $stmt->execute([$cedula, $nombres, $apellidos]);
                $id_persona = $pdo->lastInsertId();
            }
            
            // 2. Verificar si ya está registrado en esa sesión
            $stmt = $pdo->prepare("SELECT ID_REGISTRO FROM REGISTRO_ASISTENCIA WHERE ID_PERSONAS = ? AND ID_SESIONES = ?");
            $stmt->execute([$id_persona, $id_sesion]);
            
            if (!$stmt->fetch()) {
                $stmt = $pdo->prepare("INSERT INTO REGISTRO_ASISTENCIA (ID_PERSONAS, ID_SESIONES, ESTADO) VALUES (?, ?, ?)");
                $stmt->execute([$id_persona, $id_sesion, $estado]);
                log_action($_SESSION['user_id'], "Registrada asistencia de $cedula en sesión ID: $id_sesion", "REGISTRO_ASISTENCIA", $pdo->lastInsertId());
                set_flash_message("Asistencia registrada correctamente.");
            } else {
                set_flash_message("Esta persona ya está registrada en esta sesión.", "warning");
            }
            
            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
            set_flash_message("Error: " . $e->getMessage(), "danger");
        }
    }

    // Eliminar Registro
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = $_POST['id_registro'];
        $stmt = $pdo->prepare("DELETE FROM REGISTRO_ASISTENCIA WHERE ID_REGISTRO = ?");
        $stmt->execute([$id]);
        log_action($_SESSION['user_id'], "Eliminado registro de asistencia ID: $id", "REGISTRO_ASISTENCIA", $id);
        set_flash_message("Registro eliminado.");
    }
}

// Obtener Sesiones para el Select
$sesiones = $pdo->query("SELECT * FROM SESIONES ORDER BY FECHA DESC")->fetchAll();

// Obtener Asistencias Recientes
$query = "SELECT R.*, P.NOMBRES, P.APELLIDOS, P.CEDULAS, S.TITULO, S.FECHA 
          FROM REGISTRO_ASISTENCIA R 
          JOIN PERSONAS P ON R.ID_PERSONAS = P.ID_PERSONAS 
          JOIN SESIONES S ON R.ID_SESIONES = S.ID_SESION 
          ORDER BY R.MARCACION DESC LIMIT 50";
$asistencias = $pdo->query($query)->fetchAll();

// API interna para buscar personas por cédula
if (isset($_GET['buscar_cedula'])) {
    header('Content-Type: application/json');
    $stmt = $pdo->prepare("SELECT NOMBRES, APELLIDOS FROM PERSONAS WHERE CEDULAS = ?");
    $stmt->execute([$_GET['buscar_cedula']]);
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    exit();
}
?>

<div class="card">
    <h3>Registrar Nueva Asistencia</h3>
    <form method="POST" style="margin-top: 1.5rem; display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <input type="hidden" name="action" value="register">
        
        <div class="form-group">
            <label>Sesión / Evento</label>
            <select name="id_sesion" required>
                <option value="">Seleccione una sesión...</option>
                <?php foreach ($sesiones as $s): ?>
                    <option value="<?php echo $s['ID_SESION']; ?>"><?php echo date('d/m/Y', strtotime($s['FECHA'])) . ' - ' . $s['TITULO']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Cédula</label>
            <input type="text" name="cedula" id="cedula_input" placeholder="Ej: 12345678" required autocomplete="off">
            <small id="buscando_label" style="display:none; color: var(--primary-color);">Buscando...</small>
        </div>
        <div class="form-group">
            <label>Estado</label>
            <select name="estado">
                <option value="Presente">Presente</option>
                <option value="Justificado">Justificado</option>
                <option value="Ausente">Ausente</option>
            </select>
        </div>
        <div class="form-group">
            <label>Nombres</label>
            <input type="text" name="nombres" id="nombres_input" required>
        </div>
        <div class="form-group">
            <label>Apellidos</label>
            <input type="text" name="apellidos" id="apellidos_input" required>
        </div>
        <div style="grid-column: span 3; text-align: right;">
            <button type="submit" class="btn btn-primary">Registrar Asistencia</button>
        </div>
    </form>
</div>

<script>
document.getElementById('cedula_input').addEventListener('blur', function() {
    const cedula = this.value;
    if (cedula.length > 4) {
        document.getElementById('buscando_label').style.display = 'block';
        fetch('reportes.php?buscar_cedula=' + cedula)
            .then(response => response.json())
            .then(data => {
                document.getElementById('buscando_label').style.display = 'none';
                if (data) {
                    document.getElementById('nombres_input').value = data.NOMBRES;
                    document.getElementById('apellidos_input').value = data.APELLIDOS;
                    document.getElementById('nombres_input').style.background = '#f0fdf4';
                    document.getElementById('apellidos_input').style.background = '#f0fdf4';
                } else {
                    document.getElementById('nombres_input').style.background = '#fff';
                    document.getElementById('apellidos_input').style.background = '#fff';
                }
            });
    }
});
</script>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3>Registros Recientes</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Persona</th>
                <th>Sesión</th>
                <th>Marcación</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($asistencias as $a): ?>
            <tr>
                <td><?php echo $a['CEDULAS']; ?></td>
                <td><?php echo $a['NOMBRES'] . ' ' . $a['APELLIDOS']; ?></td>
                <td><?php echo $a['TITULO']; ?></td>
                <td><?php echo date('d/m/Y h:i A', strtotime($a['MARCACION'])); ?></td>
                <td><span style="color: var(--success); font-weight: 600;"><?php echo $a['ESTADO']; ?></span></td>
                <td>
                    <form method="POST" onsubmit="return confirm('¿Eliminar este registro?')">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id_registro" value="<?php echo $a['ID_REGISTRO']; ?>">
                        <button type="submit" class="btn btn-danger" style="font-size: 0.8rem; padding: 0.3rem 0.6rem;">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/layout_footer.php'; ?>

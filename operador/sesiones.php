<?php
$title = "Gestión de Sesiones / Eventos";
require_once __DIR__ . '/../includes/layout_header.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

$csrf_token = generate_csrf_token();

// Procesar Acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'])) {
        die("Error de validación CSRF.");
    }

    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        $titulo = $_POST['titulo'];
        $fecha = $_POST['fecha'];
        
        $h_base = (int)$_POST['h_num'];
        $m_base = $_POST['m_num'];
        $periodo = $_POST['periodo'];

        if ($periodo === 'PM' && $h_base < 12) $h_base += 12;
        if ($periodo === 'AM' && $h_base == 12) $h_base = 0;
        $hora = sprintf("%02d:%s:00", $h_base, $m_base);

        $tipo = $_POST['tipo'];

        $stmt = $pdo->prepare("INSERT INTO SESIONES (TITULO, FECHA, HORA_INICIO, TIPO) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $fecha, $hora, $tipo]);
        log_action($_SESSION['user_id'], "Creada sesión: $titulo", "SESIONES", $pdo->lastInsertId());
        set_flash_message("Sesión creada correctamente.");
    }
}

$sesiones = $pdo->query("SELECT * FROM SESIONES ORDER BY FECHA DESC")->fetchAll();
$h_now = '08'; $m_now = '00'; $p_now = 'AM';
?>

<div class="card">
    <h3>Crear Nueva Sesión de Asistencia</h3>
    <form method="POST" style="margin-top: 1rem; display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <input type="hidden" name="action" value="create">
        
        <div class="form-group" style="grid-column: span 2;">
            <label>Título del Evento</label>
            <input type="text" name="titulo" placeholder="Ej: Asamblea Extraordinaria" required>
        </div>
        <div class="form-group">
            <label>Fecha</label>
            <input type="date" name="fecha" required>
        </div>
        <div class="form-group">
            <label>Hora de Inicio (12h)</label>
            <div style="display: flex; gap: 0.5rem;">
                <select name="h_num" required style="flex: 1;">
                    <?php for($i=1;$i<=12;$i++): $val = sprintf("%02d", $i); ?>
                        <option value="<?php echo $val; ?>" <?php echo $h_now == $val ? 'selected' : ''; ?>><?php echo $val; ?></option>
                    <?php endfor; ?>
                </select>
                <select name="m_num" required style="flex: 1;">
                    <?php for($i=0;$i<60;$i++): $val = sprintf("%02d", $i); ?>
                        <option value="<?php echo $val; ?>" <?php echo $m_now == $val ? 'selected' : ''; ?>><?php echo $val; ?></option>
                    <?php endfor; ?>
                </select>
                <select name="periodo" required style="flex: 1;">
                    <option value="AM" <?php echo $p_now == 'AM' ? 'selected' : ''; ?>>AM</option>
                    <option value="PM" <?php echo $p_now == 'PM' ? 'selected' : ''; ?>>PM</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>Tipo de Evento</label>
            <input type="text" name="tipo" placeholder="Ej: Ordinaria, Capacitación" required>
        </div>
        <div style="text-align: right; margin-top: 1rem; grid-column: span 2;">
            <button type="submit" class="btn btn-primary">Crear Sesión</button>
        </div>
    </form>
</div>

<div class="card">
    <h3>Sesiones Registradas</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Evento</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sesiones as $s): ?>
            <tr>
                <td>
                <?php echo $s['ID_SESION']; ?></td>
                <td><strong><?php echo $s['TITULO']; ?></strong></td>
                <td><?php echo date('d/m/Y', strtotime($s['FECHA'])); ?></td>
                <td><?php echo date('h:i A', strtotime($s['HORA_INICIO'])); ?></td>
                <td><?php echo $s['TIPO']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/layout_footer.php'; ?>

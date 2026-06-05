<?php
$title = "Agenda de Reuniones";
require_once __DIR__ . '/../includes/layout_header.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
check_admin();

$csrf_token = generate_csrf_token();
$parroquias = ['Simon Bolivar', 'Once de Abril', 'Vista al Sol', 'Chirica', 'Dalla Costa', 'Cachamay', 'Universidad', 'Unare', 'Yocoima', 'Pozo Verde', '5 de Julio'];

// Procesar Acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'])) {
        die("Error de validación CSRF.");
    }

    // Crear/Editar Reunión
    if (isset($_POST['action']) && ($_POST['action'] === 'create' || $_POST['action'] === 'edit')) {
        $fecha = $_POST['fecha'];
        $h_base = (int)$_POST['h_num'];
        $m_base = $_POST['m_num'];
        $periodo = $_POST['periodo'];

        if ($periodo === 'PM' && $h_base < 12) $h_base += 12;
        if ($periodo === 'AM' && $h_base == 12) $h_base = 0;
        $hora = sprintf("%02d:%s:00", $h_base, $m_base);

        $tipo = $_POST['tipo_reunion'];
        $descripcion =  $_POST['descripcion']; 
        $lugar = $_POST['lugar'];
        $parroquia = $_POST['parroquia'];
        $r_nombre = $_POST['r_nombre'];
        $r_cedula = $_POST['r_cedula'];
        $r_telefono = $_POST['r_telefono'];

        if ($_POST['action'] === 'create') {
            $stmt = $pdo->prepare("INSERT INTO REUNIONES (FECHA, HORA, TIPO_REUNION, DESCRIPCION, LUGAR, PARROQUIA, RESPONSABLE_NOMBRE, RESPONSABLE_CEDULA, RESPONSABLE_TELEFONO) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$fecha, $hora, $tipo, $descripcion, $lugar, $parroquia, $r_nombre, $r_cedula, $r_telefono]);
            log_action($_SESSION['user_id'], "Creada reunión: $tipo", "REUNIONES", $pdo->lastInsertId());
            set_flash_message("Reunión programada correctamente.");
        } else {
            $id = $_POST['id_reunion'];
            $stmt = $pdo->prepare("UPDATE REUNIONES SET FECHA=?, HORA=?, TIPO_REUNION=?, DESCRIPCION=?, LUGAR=?, PARROQUIA=?, RESPONSABLE_NOMBRE=?, RESPONSABLE_CEDULA=?, RESPONSABLE_TELEFONO=? WHERE ID_REUNION=?");
            $stmt->execute([$fecha, $hora, $tipo, $descripcion, $lugar, $parroquia, $r_nombre, $r_cedula, $r_telefono, $id]);
            log_action($_SESSION['user_id'], "Editada reunión ID: $id", "REUNIONES", $id);
            set_flash_message("Reunión actualizada.");
        }
    }

    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = $_POST['id_reunion'];
        $stmt = $pdo->prepare("DELETE FROM REUNIONES WHERE ID_REUNION = ?");
        $stmt->execute([$id]);
        log_action($_SESSION['user_id'], "Eliminada reunión ID: $id", "REUNIONES", $id);
        set_flash_message("Reunión eliminada.");
    }

    if (isset($_POST['action']) && $_POST['action'] === 'finish') {
        $id = $_POST['id_reunion'];
        $stmt = $pdo->prepare("UPDATE REUNIONES SET ESTADO = 'Finalizada' WHERE ID_REUNION = ?");
        $stmt->execute([$id]);
        log_action($_SESSION['user_id'], "Finalizada reunión ID: $id", "REUNIONES", $id);
        set_flash_message("Reunión marcada como finalizada.");
    }
}

$reuniones = $pdo->query("SELECT * FROM REUNIONES ORDER BY FECHA ASC, HORA ASC")->fetchAll();

$edit_data = null;
$h_edit = '08'; $m_edit = '00'; $p_edit = 'AM';
if (isset($_GET['edit_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM REUNIONES WHERE ID_REUNION = ?");
    $stmt->execute([$_GET['edit_id']]);
    $edit_data = $stmt->fetch();
    if ($edit_data) {
        $ts = strtotime($edit_data['HORA']);
        $h_edit = date('h', $ts);
        $m_edit = date('i', $ts);
        $p_edit = date('A', $ts);
    }
}
?>

<div class="card">
    <h3><?php echo $edit_data ? 'Editar Reunión' : 'Programar Nueva Reunión'; ?></h3>
    <form method="POST" style="margin-top: 1rem; display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <input type="hidden" name="action" value="<?php echo $edit_data ? 'edit' : 'create'; ?>">
        <?php if ($edit_data): ?>
            <input type="hidden" name="id_reunion" value="<?php echo $edit_data['ID_REUNION']; ?>">
        <?php endif; ?>

        <div class="form-group">
            <label>Fecha</label>
            <input type="date" name="fecha" value="<?php echo $edit_data['FECHA'] ?? ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Hora (Formato 12h)</label>
            <div style="display: flex; gap: 0.5rem;">
                <select name="h_num" required style="flex: 1;">
                    <?php for($i=1;$i<=12;$i++): $val = sprintf("%02d", $i); ?>
                        <option value="<?php echo $val; ?>" <?php echo $h_edit == $val ? 'selected' : ''; ?>><?php echo $val; ?></option>
                    <?php endfor; ?>
                </select>
                <select name="m_num" required style="flex: 1;">
                    <?php for($i=0;$i<60;$i++): $val = sprintf("%02d", $i); ?>
                        <option value="<?php echo $val; ?>" <?php echo $m_edit == $val ? 'selected' : ''; ?>><?php echo $val; ?></option>
                    <?php endfor; ?>
                </select>
                <select name="periodo" required style="flex: 1;">
                    <option value="AM" <?php echo $p_edit == 'AM' ? 'selected' : ''; ?>>AM</option>
                    <option value="PM" <?php echo $p_edit == 'PM' ? 'selected' : ''; ?>>PM</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>Parroquia</label>
            <select name="parroquia" required>
                <?php foreach ($parroquias as $p): ?>
                    <option value="<?php echo $p; ?>" <?php echo (isset($edit_data['PARROQUIA']) && $edit_data['PARROQUIA'] == $p) ? 'selected' : ''; ?>><?php echo $p; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Tipo de Reunión</label>
            <select id="tipo_reunion" name="tipo_reunion" required>
                <option value="ORDINARIA" <?php echo (isset($edit_data['TIPO_REUNION']) && $edit_data['TIPO_REUNION'] == 'ORDINARIA') ? 'selected' : ''; ?>>ORDINARIA</option>
                <option value="AMPLIADA" <?php echo (isset($edit_data['TIPO_REUNION']) && $edit_data['TIPO_REUNION'] == 'AMPLIADA') ? 'selected' : ''; ?>>AMPLIADA</option>
                <option value="INFORMATIVA" <?php echo (isset($edit_data['TIPO_REUNION']) && $edit_data['TIPO_REUNION'] == 'INFORMATIVA') ? 'selected' : ''; ?>>INFORMATIVA</option>
                <option value="FORMATIVA" <?php echo (isset($edit_data['TIPO_REUNION']) && $edit_data['TIPO_REUNION'] == 'FORMATIVA') ? 'selected' : ''; ?>>FORMATIVA</option>
                <option value="SOCIALES" <?php echo (isset($edit_data['TIPO_REUNION']) && $edit_data['TIPO_REUNION'] == 'SOCIALES') ? 'selected' : ''; ?>>SOCIALES</option>
                <option value="VIDEOCONFERENCIAS" <?php echo (isset($edit_data['TIPO_REUNION']) && $edit_data['TIPO_REUNION'] == 'VIDEOCONFERENCIAS') ? 'selected' : ''; ?>>VIDEOCONFERENCIAS</option>
            </select>
        </div>
        <div class="form-group" style="grid-column: span 2;">
            <label>Lugar exacto</label>
            <input type="text" name="lugar" value="<?php echo $edit_data['LUGAR'] ?? ''; ?>" required>
        </div>

        <div style="position: relative; grid-column: span 3; text-align: center; margin-top: 1rem;">
            <label>Descripción</label>
            <input type="text" 
                name="descripcion"
                id="descripcion"
                value="<?php echo $edit_data['DESCRIPCION'] ?? ''; ?>" 
                maxlength="100"
                style="width: 100%; background: #f1f5f9; color: #475569; padding: 0.5rem; padding-right: 4rem; border-radius: 4px;">

            <div style="position: absolute; bottom: 8px; right: 8px; font-size: 11px; color: #64748b; background: rgba(241, 245, 249, 0.9); padding: 2px 5px; border-radius: 3px;">
                <span id="contador">0</span> / 100
            </div>
        </div>

        <script>
            const input = document.getElementById('descripcion');
            const contador = document.getElementById('contador');
            
            function actualizarContador() {
                contador.textContent = input.value.length;
            }
            
            input.addEventListener('input', actualizarContador);
            actualizarContador();
        </script>
        
        <div style="grid-column: span 3;"><hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 0.5rem 0;"><h4>Datos del Responsable</h4></div>

        <div class="form-group">
            <label>Nombre Completo</label>
            <input type="text" name="r_nombre" value="<?php echo $edit_data['RESPONSABLE_NOMBRE'] ?? ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Cédula</label>
            <input type="text" name="r_cedula" value="<?php echo $edit_data['RESPONSABLE_CEDULA'] ?? ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="r_telefono" value="<?php echo $edit_data['RESPONSABLE_TELEFONO'] ?? ''; ?>" required>
        </div>

        <div style="grid-column: span 3; text-align: right;">
            <?php if ($edit_data): ?>
                <a href="reuniones.php" class="btn btn-secondary" style="background: #e2e8f0; color: #475569;">Cancelar</a>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary"><?php echo $edit_data ? 'Guardar Cambios' : 'Programar Reunión'; ?></button>
        </div>
    </form>
</div>

<div class="card">
    <h3>Listado de Agenda</h3>
    <table>
        <thead>
            <tr>
                <th>Fecha/Hora</th>
                <th>Actividad</th>
                <th>Parroquia</th>
                <th>Responsable</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reuniones as $r): ?>
            <tr>
                <td data-label="Fecha/Hora">
                    <strong><?php echo date('d/m/Y', strtotime($r['FECHA'])); ?></strong><br>
                    <span style="color: var(--secondary-color); font-weight: 600;"><?php echo date('h:i A', strtotime($r['HORA'])); ?></span>
                </td>
                <td data-label="Actividad">
                    <strong><?php echo $r['TIPO_REUNION']; ?></strong><br>
                    <small><?php echo $r['LUGAR']; ?></small><br>
                    <span class="badge" style="background: <?php echo $r['ESTADO'] === 'Finalizada' ? '#10b981' : '#f59e0b'; ?>; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem;">
                        <?php echo $r['ESTADO'] ?? 'Programada'; ?>
                    </span>
                </td>
                <td data-label="Parroquia"><?php echo $r['PARROQUIA']; ?></td>
                <td data-label="Responsable"><?php echo $r['RESPONSABLE_NOMBRE']; ?></td>
                <td data-label="Acciones">
                    <div style="display: flex; gap: 0.3rem; flex-wrap: wrap;">
                        <?php if (($r['ESTADO'] ?? 'Programada') !== 'Finalizada'): ?>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <input type="hidden" name="action" value="finish">
                            <input type="hidden" name="id_reunion" value="<?php echo $r['ID_REUNION']; ?>">
                            <button type="submit" class="btn btn-success" style="font-size: 0.75rem; background: #10b981;">Finalizar</button>
                        </form>
                        <a href="reuniones.php?edit_id=<?php echo $r['ID_REUNION']; ?>" class="btn btn-primary" style="font-size: 0.75rem;">Editar</a>
                        <?php endif; ?>

                        <form method="POST" onsubmit="return confirm('¿Eliminar esta reunión?')">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id_reunion" value="<?php echo $r['ID_REUNION']; ?>">
                            <button type="submit" class="btn btn-danger" style="font-size: 0.75rem;">Eliminar</button>
                        </form>
                        <a href="../operador/ficha_reunion.php?id=<?php echo $r['ID_REUNION']; ?>" class="btn btn-secondary" style="font-size: 0.75rem; background: #64748b; color: white;" target="_blank">PDF</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/layout_footer.php'; ?>

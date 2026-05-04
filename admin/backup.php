<?php
$title = "Gestión de Respaldos";
require_once __DIR__ . '/../includes/layout_header.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/backup.php';
require_once __DIR__ . '/../includes/auth.php';
check_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        $file = create_backup($_SESSION['user_id']);
        log_action($_SESSION['user_id'], "Respaldo creado: $file", "RESPALDOS");
        set_flash_message("Respaldo '$file' creado correctamente.");
    }

    if (isset($_POST['action']) && $_POST['action'] === 'restore') {
        $file = $_POST['filename'];
        if (restore_backup($file)) {
            log_action($_SESSION['user_id'], "Base de datos restaurada: $file", "SISTEMA");
            set_flash_message("Base de datos restaurada exitosamente.");
        } else {
            set_flash_message("Error al restaurar la base de datos.", "danger");
        }
    }
}

$respaldos = $pdo->query("SELECT R.*, U.NOMBRE_USUARIO FROM RESPALDOS R LEFT JOIN USUARIOS U ON R.CREADO_POR = U.ID_USUARIO ORDER BY R.FECHA_CREACION DESC")->fetchAll();
?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Respaldos del Sistema</h3>
        <form method="POST">
            <input type="hidden" name="action" value="create">
            <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Crear Nuevo Respaldo</button>
        </form>
    </div>
    
    <table style="margin-top: 1.5rem;">
        <thead>
            <tr>
                <th>Archivo</th>
                <th>Versión</th>
                <th>Tamaño</th>
                <th>Fecha</th>
                <th>Creado por</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($respaldos as $r): ?>
            <tr>
                <td><?php echo $r['NOMBRE_ARCHIVO']; ?></td>
                <td><?php echo $r['VERSION']; ?></td>
                <td><?php echo round($r['TAMANO'] / 1024, 2); ?> KB</td>
                <td><?php echo $r['FECHA_CREACION']; ?></td>
                <td><?php echo $r['NOMBRE_USUARIO']; ?></td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="../backups/<?php echo $r['NOMBRE_ARCHIVO']; ?>" class="btn btn-primary" style="font-size: 0.8rem;" download>Descargar</a>
                        <form method="POST" onsubmit="return confirm('¿Está seguro de restaurar este respaldo? Se sobrescribirán todos los datos actuales.')">
                            <input type="hidden" name="action" value="restore">
                            <input type="hidden" name="filename" value="<?php echo $r['NOMBRE_ARCHIVO']; ?>">
                            <button type="submit" class="btn btn-warning" style="font-size: 0.8rem;">Restaurar</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/layout_footer.php'; ?>

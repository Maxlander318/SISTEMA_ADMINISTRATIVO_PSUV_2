<?php
$title = "Logs del Sistema";
require_once __DIR__ . '/../includes/layout_header.php';
require_once __DIR__ . '/../config/database.php';
check_admin();

$logs = $pdo->query("SELECT L.*, U.NOMBRE_USUARIO FROM LOGS_SISTEMA L LEFT JOIN USUARIOS U ON L.ID_USUARIO = U.ID_USUARIO ORDER BY L.FECHA DESC LIMIT 100")->fetchAll();
?>

<div class="card">
    <h3>Historial de Actividad</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Tabla</th>
                <th>ID Registro</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $l): ?>
            <tr>
                <td><?php echo $l['ID_LOG']; ?></td>
                <td><?php echo $l['NOMBRE_USUARIO']; ?></td>
                <td><?php echo $l['ACCION']; ?></td>
                <td><?php echo $l['TABLA_AFECTADA']; ?></td>
                <td><?php echo $l['REGISTRO_ID']; ?></td>
                <td><?php echo $l['FECHA']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/layout_footer.php'; ?>

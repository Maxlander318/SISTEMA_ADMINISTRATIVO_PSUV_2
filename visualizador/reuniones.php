<?php
$title = "Agendas semanales";
require_once __DIR__ . '/../includes/layout_header.php';
require_once __DIR__ . '/../config/database.php';

$query = "SELECT * FROM REUNIONES ORDER BY FECHA DESC, HORA DESC";
$stmt = $pdo->query($query);
$reuniones = $stmt->fetchAll();
?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3>Listado de Agendas (Solo Lectura)</h3>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Tipo</th>
                <th>Lugar</th>
                <th>Parroquia</th>
                <th>Responsable</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reuniones as $r): ?>
            <tr>
                <td><?php echo date('d/m/Y', strtotime($r['FECHA'])); ?></td>
                <td><?php echo date('h:i A', strtotime($r['HORA'])); ?></td>
                <td><?php echo $r['TIPO_REUNION']; ?></td>
                <td><?php echo $r['LUGAR']; ?></td>
                <td><?php echo $r['PARROQUIA']; ?></td>
                <td>
                    <strong><?php echo $r['RESPONSABLE_NOMBRE']; ?></strong><br>
                    <small><?php echo $r['RESPONSABLE_CEDULA']; ?></small>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($reuniones)): ?>
            <tr>
                <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-light);">No hay agendas registradas en el sistema.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/layout_footer.php'; ?>

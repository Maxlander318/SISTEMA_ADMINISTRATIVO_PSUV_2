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
                <td data-label="Fecha"><?php echo date('d/m/Y', strtotime($r['FECHA'])); ?></td>
                <td data-label="Hora"><?php echo date('h:i A', strtotime($r['HORA'])); ?></td>
                <td data-label="Tipo"><?php echo $r['TIPO_REUNION']; ?></td>
                <td data-label="Lugar"><?php echo $r['LUGAR']; ?></td>
                <td data-label="Parroquia"><?php echo $r['PARROQUIA']; ?></td>
                <td data-label="Responsable">
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

<?php
$title = "Asistencias Reportadas";
require_once __DIR__ . '/../includes/layout_header.php';
require_once __DIR__ . '/../config/database.php';

// Consulta para obtener un resumen de asistencias por sesión
$query = "SELECT S.TITULO, S.FECHA, S.TIPO, COUNT(R.ID_REGISTRO) as TOTAL_ASISTENCIAS
          FROM SESIONES S
          LEFT JOIN REGISTRO_ASISTENCIA R ON S.ID_SESION = R.ID_SESIONES
          GROUP BY S.ID_SESION
          ORDER BY S.FECHA DESC";
$stmt = $pdo->query($query);
$reportes = $stmt->fetchAll();
?>

<div class="card">
    <h3>Resumen de Asistencias por Sesión</h3>
    <p style="color: var(--text-light); margin-bottom: 1.5rem;">Vista general del total de personas que asistieron a cada evento.</p>
    
    <table>
        <thead>
            <tr>
                <th>Evento / Sesión</th>
                <th>Fecha</th>
                <th>Tipo de Evento</th>
                <th>Total Asistencias</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reportes as $rep): ?>
            <tr>
                <td><strong><?php echo $rep['TITULO']; ?></strong></td>
                <td><?php echo date('d/m/Y', strtotime($rep['FECHA'])); ?></td>
                <td><?php echo $rep['TIPO']; ?></td>
                <td>
                    <span style="background: var(--bg-color); padding: 0.3rem 0.8rem; border-radius: 20px; font-weight: 700; color: var(--primary-color);">
                        <?php echo $rep['TOTAL_ASISTENCIAS']; ?> personas
                    </span>
                </td>
                <td><span class="badge" style="background: #dcfce7; color: #166534; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">Reportado</span></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($reportes)): ?>
            <tr>
                <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-light);">No hay reportes de asistencia disponibles.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/layout_footer.php'; ?>

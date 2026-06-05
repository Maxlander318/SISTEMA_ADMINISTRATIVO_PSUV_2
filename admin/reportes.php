<?php
$title = "Reportes Administrativos";
require_once __DIR__ . '/../includes/layout_header.php';
require_once __DIR__ . '/../config/database.php';
check_admin();

// Resumen por Sesión
$resumen_sesiones = $pdo->query("
    SELECT S.TIPO_REUNION, S.FECHA, COUNT(R.ID_REGISTRO) as TOTAL_ASISTENTES
    FROM REUNIONES S
    LEFT JOIN REGISTRO_ASISTENCIA R ON S.ID_REUNION = R.ID_REUNIONES
    GROUP BY S.ID_REUNION
    ORDER BY S.FECHA DESC
")->fetchAll();

// Actividad de Usuarios
$actividad_usuarios = $pdo->query("
    SELECT U.NOMBRE_USUARIO, U.NIVEL, COUNT(L.ID_LOG) as TOTAL_ACCIONES
    FROM USUARIOS U
    LEFT JOIN LOGS_SISTEMA L ON U.ID_USUARIO = L.ID_USUARIO
    GROUP BY U.ID_USUARIO
")->fetchAll();
?>

<div class="card">
    <h3>Resumen de Asistencia por Sesión</h3>
    <table>
        <thead>
            <tr>
                <th>Título Sesión</th>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Total Asistentes</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resumen_sesiones as $s): ?>
            <tr>
                <td><?php echo $s['TIPO_REUNION']; ?></td>
                <td><?php echo $s['FECHA']; ?></td>
                <td><strong><?php echo $s['TOTAL_ASISTENTES']; ?></strong></td>
                <td>
                    <a href="../operador/exportar_pdf.php?fecha=<?php echo $s['FECHA']; ?>&tipo=<?php echo $s['TIPO_REUNION']; ?>" class="btn btn-primary" style="font-size: 0.8rem;" target="_blank">Ver Detalle PDF</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="card">
    <h3>Actividad Global de Usuarios</h3>
    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Nivel</th>
                <th>Total de Acciones en Logs</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($actividad_usuarios as $u): ?>
            <tr>
                <td><?php echo $u['NOMBRE_USUARIO']; ?></td>
                <td><?php echo ucfirst($u['NIVEL']); ?></td>
                <td><?php echo $u['TOTAL_ACCIONES']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/layout_footer.php'; ?>

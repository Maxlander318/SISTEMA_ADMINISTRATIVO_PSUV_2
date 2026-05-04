<?php
$title = "Dashboard";
require_once __DIR__ . '/../includes/layout_header.php';
require_once __DIR__ . '/../config/database.php';

// Filtros
$fecha = $_GET['fecha'] ?? '';
$tipo = $_GET['tipo'] ?? '';

$query = "SELECT R.*, P.NOMBRES, P.APELLIDOS, P.CEDULAS, S.TITULO, S.FECHA, S.TIPO 
          FROM REGISTRO_ASISTENCIA R 
          JOIN PERSONAS P ON R.ID_PERSONAS = P.ID_PERSONAS 
          JOIN SESIONES S ON R.ID_SESIONES = S.ID_SESION 
          WHERE 1=1";
$params = [];

if ($fecha) {
    $query .= " AND S.FECHA = ?";
    $params[] = $fecha;
}
if ($tipo) {
    $query .= " AND S.TIPO = ?";
    $params[] = $tipo;
}

$query .= " ORDER BY R.MARCACION DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$asistencias = $stmt->fetchAll();

// Tipos de sesión únicos para el filtro
$tipos = $pdo->query("SELECT DISTINCT TIPO FROM SESIONES")->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="card">
    <h3>Filtros de Búsqueda</h3>
    <form method="GET" style="margin-top: 1rem; display: flex; gap: 1rem; align-items: flex-end;">
        <div class="form-group" style="margin-bottom: 0;">
            <label>Fecha de Sesión</label>
            <input type="date" name="fecha" value="<?php echo $fecha; ?>">
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label>Tipo de Sesión</label>
            <select name="tipo">
                <option value="">Todos</option>
                <?php foreach ($tipos as $t): ?>
                    <option value="<?php echo $t; ?>" <?php echo $tipo == $t ? 'selected' : ''; ?>><?php echo $t; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="dashboard.php" class="btn btn-secondary">Limpiar</a>
    </form>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3>Registros de Asistencia</h3>
        <div style="display: flex; gap: 0.5rem;">
            <a href="exportar_excel.php?fecha=<?php echo $fecha; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-success"><i class="fas fa-file-excel"></i> Excel</a>
            <a href="exportar_pdf.php?fecha=<?php echo $fecha; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-danger" target="_blank"><i class="fas fa-file-pdf"></i> PDF</a>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Persona</th>
                <th>Sesión</th>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Hora Marcación</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($asistencias as $a): ?>
            <tr>
                <td><?php echo $a['CEDULAS']; ?></td>
                <td><?php echo $a['NOMBRES'] . ' ' . $a['APELLIDOS']; ?></td>
                <td><?php echo $a['TITULO']; ?></td>
                <td><?php echo date('d/m/Y', strtotime($a['FECHA'])); ?></td>
                <td><?php echo $a['TIPO']; ?></td>
                <td><?php echo date('h:i:s A', strtotime($a['MARCACION'])); ?></td>
                <td><span style="color: var(--success); font-weight: 600;"><?php echo $a['ESTADO']; ?></span></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($asistencias)): ?>
            <tr>
                <td colspan="7" style="text-align: center; padding: 2rem; color: var(--text-light);">No se encontraron registros.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/layout_footer.php'; ?>

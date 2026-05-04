<?php
$title = "Gestión de Permisos y Módulos";
require_once __DIR__ . '/../includes/layout_header.php';
require_once __DIR__ . '/../config/database.php';
check_admin();

// Procesar actualización de permisos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_permisos'])) {
    $id_usuario = $_POST['id_usuario'];
    $modulos_lista = ['Agenda', 'Reportes', 'Usuarios', 'Respaldos', 'Auditoria'];
    
    $pdo->prepare("DELETE FROM PERMISOS WHERE ID_USUARIO = ?")->execute([$id_usuario]);
    
    foreach ($modulos_lista as $mod) {
        $ver = isset($_POST["ver_$mod"]) ? 1 : 0;
        $editar = isset($_POST["editar_$mod"]) ? 1 : 0;
        if ($ver || $editar) {
            $stmt = $pdo->prepare("INSERT INTO PERMISOS (ID_USUARIO, MODULO, PUEDE_VER, PUEDE_EDITAR) VALUES (?, ?, ?, ?)");
            $stmt->execute([$id_usuario, $mod, $ver, $editar]);
        }
    }
    set_flash_message("Permisos de acceso actualizados correctamente.");
}

$usuarios = $pdo->query("SELECT ID_USUARIO, NOMBRE_COMPLETO, NOMBRE_USUARIO, NIVEL, ULTIMA_ACTIVIDAD FROM USUARIOS WHERE NIVEL != 'admin' ORDER BY NOMBRE_COMPLETO ASC")->fetchAll();

$modulo_iconos = [
    'Agenda' => 'fa-calendar-alt',
    'Reportes' => 'fa-file-invoice',
    'Usuarios' => 'fa-users-cog',
    'Respaldos' => 'fa-database',
    'Auditoria' => 'fa-history'
];
?>

<style>
    .user-access-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
        margin-bottom: 1.5rem;
        border: 1px solid #f1f5f9;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .user-access-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    }
    .card-header-access {
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }
    .user-info-box {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .user-avatar-circle {
        width: 45px;
        height: 45px;
        background: var(--primary-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        text-transform: uppercase;
    }
    .module-grid-premium {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        padding: 1.5rem;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        border-bottom-left-radius: 16px;
        border-bottom-right-radius: 16px;
    }
    .module-item-box {
        background: white;
        padding: 1rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        transition: 0.2s;
    }
    .module-item-box:hover {
        border-color: var(--primary-color);
    }
    .module-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        color: var(--text-main);
        font-weight: 600;
    }
    .module-title i {
        color: var(--primary-color);
    }
    .checkbox-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .custom-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        cursor: pointer;
        user-select: none;
    }
    .custom-check input {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }
    .badge-role {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
    }
</style>

<div class="card" style="background: transparent; box-shadow: none; padding: 0;">
    <div style="margin-bottom: 2rem;">
        <h2 style="color: var(--primary-color); margin-bottom: 0.5rem;">Seguridad y Módulos</h2>
        <p style="color: var(--text-light);">Define el alcance de trabajo para cada integrante del equipo administrativo.</p>
    </div>

    <?php foreach ($usuarios as $u): 
        $stmt = $pdo->prepare("SELECT * FROM PERMISOS WHERE ID_USUARIO = ?");
        $stmt->execute([$u['ID_USUARIO']]);
        $p_raw = $stmt->fetchAll();
        $permisos = [];
        foreach ($p_raw as $p) { $permisos[$p['MODULO']] = $p; }
        
        $initials = substr($u['NOMBRE_COMPLETO'], 0, 1);
        $role_color = ($u['NIVEL'] == 'operador') ? '#dcfce7' : '#fef9c3';
        $role_text = ($u['NIVEL'] == 'operador') ? '#166534' : '#854d0e';
    ?>
    <div class="user-access-card">
        <div class="card-header-access" onclick="toggleModuleGrid('grid_<?php echo $u['ID_USUARIO']; ?>')">
            <div class="user-info-box">
                <div class="user-avatar-circle"><?php echo $initials; ?></div>
                <div>
                    <h4 style="margin: 0;"><?php echo $u['NOMBRE_COMPLETO']; ?></h4>
                    <span style="color: var(--text-light); font-size: 0.85rem;">@<?php echo $u['NOMBRE_USUARIO']; ?></span>
                    <span class="badge-role" style="background: <?php echo $role_color; ?>; color: <?php echo $role_text; ?>; margin-left: 0.5rem;">
                        <?php echo $u['NIVEL']; ?>
                    </span>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="text-align: right; display: none;" class="md-only">
                    <small style="color: var(--text-light);">Estado</small><br>
                    <span style="font-size: 0.8rem; color: var(--success); font-weight: 600;">● Online</span>
                </div>
                <i class="fas fa-chevron-down" style="color: var(--text-light);"></i>
            </div>
        </div>
        
        <form id="grid_<?php echo $u['ID_USUARIO']; ?>" method="POST" style="display: none;">
            <input type="hidden" name="id_usuario" value="<?php echo $u['ID_USUARIO']; ?>">
            <input type="hidden" name="update_permisos" value="1">
            
            <div class="module-grid-premium">
                <?php 
                $mods = ['Agenda', 'Reportes', 'Usuarios', 'Respaldos', 'Auditoria'];
                foreach ($mods as $m): 
                    $v = isset($permisos[$m]) && $permisos[$m]['PUEDE_VER'] ? 'checked' : '';
                    $e = isset($permisos[$m]) && $permisos[$m]['PUEDE_EDITAR'] ? 'checked' : '';
                ?>
                <div class="module-item-box">
                    <div class="module-title">
                        <i class="fas <?php echo $modulo_iconos[$m]; ?>"></i>
                        <span><?php echo $m; ?></span>
                    </div>
                    <div class="checkbox-group">
                        <label class="custom-check">
                            <input type="checkbox" name="ver_<?php echo $m; ?>" <?php echo $v; ?>> Ver
                        </label>
                        <label class="custom-check">
                            <input type="checkbox" name="editar_<?php echo $m; ?>" <?php echo $e; ?>> Editar
                        </label>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div style="padding: 1rem 1.5rem; background: #fff; text-align: right; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                <button type="submit" class="btn btn-primary" style="padding: 0.5rem 2rem;">
                    <i class="fas fa-save"></i> Actualizar Accesos
                </button>
            </div>
        </form>
    </div>
    <?php endforeach; ?>
</div>

<script>
function toggleModuleGrid(id) {
    const grid = document.getElementById(id);
    const icon = grid.parentElement.querySelector('.fa-chevron-down');
    
    if (grid.style.display === 'none') {
        grid.style.display = 'block';
        icon.style.transform = 'rotate(180deg)';
        grid.style.animation = 'slideDown 0.3s ease-out';
    } else {
        grid.style.display = 'none';
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>

<style>
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<?php require_once __DIR__ . '/../includes/layout_footer.php'; ?>

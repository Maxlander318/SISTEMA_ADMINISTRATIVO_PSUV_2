<?php
require_once __DIR__ . '/../config/database.php';

function create_backup($user_id) {
    global $pdo;
    $backup_dir = __DIR__ . '/../backups/';
    if (!is_dir($backup_dir)) {
        mkdir($backup_dir, 0777, true);
    }

    $tables = array();
    $result = $pdo->query("SHOW TABLES");
    while ($row = $result->fetch(PDO::FETCH_NUM)) {
        $tables[] = $row[0];
    }

    $sql = "SET FOREIGN_KEY_CHECKS=0;\n\n";

    foreach ($tables as $table) {
        // Create table structure
        $res = $pdo->query("SHOW CREATE TABLE $table");
        $row = $res->fetch(PDO::FETCH_NUM);
        $sql .= "\n\n" . $row[1] . ";\n\n";

        // Table data
        $res = $pdo->query("SELECT * FROM $table");
        while ($row = $res->fetch(PDO::FETCH_NUM)) {
            $sql .= "INSERT INTO $table VALUES(";
            for ($j = 0; $j < count($row); $j++) {
                $row[$j] = addslashes($row[$j]);
                $row[$j] = str_replace("\n", "\\n", $row[$j]);
                if (isset($row[$j])) {
                    $sql .= '"' . $row[$j] . '"';
                } else {
                    $sql .= 'NULL';
                }
                if ($j < (count($row) - 1)) {
                    $sql .= ',';
                }
            }
            $sql .= ");\n";
        }
    }
    $sql .= "\n\nSET FOREIGN_KEY_CHECKS=1;";

    $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    $filepath = $backup_dir . $filename;
    file_put_contents($filepath, $sql);

    // Registrar en BD
    $size = filesize($filepath);
    $version = date('YmdHis');
    $stmt = $pdo->prepare("INSERT INTO RESPALDOS (NOMBRE_ARCHIVO, VERSION, TAMANO, CREADO_POR) VALUES (?, ?, ?, ?)");
    $stmt->execute([$filename, $version, $size, $user_id]);

    return $filename;
}

function restore_backup($filename) {
    global $pdo;
    $filepath = __DIR__ . '/../backups/' . $filename;
    if (!file_exists($filepath)) return false;

    $sql = file_get_contents($filepath);
    
    // Ejecutar SQL
    try {
        $pdo->exec($sql);
        return true;
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
}
?>

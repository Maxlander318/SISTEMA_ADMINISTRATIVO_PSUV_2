# Sistema Administrativo de Asistencia PSUV 2

Este sistema permite el control de asistencia y la gestión administrativa con dos niveles de usuario.

## Requisitos
- Servidor local (XAMPP, WAMP o Laragon) con PHP 7.4 o superior.
- MySQL / MariaDB.

## Instrucciones de Instalación
1. Copie la carpeta `SISTEMA_ADMINISTRATIVO_PSUV_2` en el directorio `htdocs` de su servidor XAMPP.
2. Abra **phpMyAdmin** y cree una base de datos llamada `sistema_administrativo`.
3. Importe el archivo `database.sql` incluido en la raíz del proyecto.
4. Verifique la configuración de conexión en `config/database.php` (por defecto usa root sin contraseña).
5. **Nota sobre PDF:** El sistema utiliza la librería FPDF. Asegúrese de que los archivos de la librería estén en `includes/fpdf/`.
6. Acceda al sistema mediante: `http://localhost/SISTEMA_ADMINISTRATIVO_PSUV_2/public/login.php`

## Credenciales por Defecto
- **Administrador:**
  - Usuario: `admin`
  - Contraseña: `admin123`
- **Operador:**
  - Usuario: `operador`
  - Contraseña: `admin123`

## Funcionalidades Principales
- **Seguridad:** PDO, password_hash, CSRF protection.
- **Admin:** CRUD de usuarios, Respaldos SQL (Crear/Restaurar), Logs de actividad.
- **Operador:** Visualización de asistencias con filtros, exportación a Excel (CSV) y PDF.
- **Respaldos:** Control de versiones automático guardado en la carpeta `/backups/`.

## Estructura de Versiones de Respaldo
Cada respaldo generado incluye la fecha y hora en el nombre del archivo y se registra en la base de datos con una versión única basada en timestamp (`YYYYMMDDHHIISS`). Para restaurar, el sistema utiliza `SET FOREIGN_KEY_CHECKS=0` para asegurar que las relaciones no impidan la sobreescritura de datos.

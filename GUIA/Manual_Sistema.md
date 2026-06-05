# Manual de Usuario: Sistema Administrativo PSUV 2

Este manual de usuario proporciona una guía detallada y paso a paso para el uso y administración del **Sistema Administrativo PSUV 2**. Diseñado para centralizar la gestión de actividades políticas, el control de asistencia a eventos y la auditoría de procesos organizativos en el municipio.

---

## Índice
1. [Introducción y Requisitos del Sistema](#1-introducción-y-requisitos-del-sistema)
2. [Acceso al Sistema y Seguridad](#2-acceso-al-sistema-y-seguridad)
3. [Niveles de Acceso (Roles de Usuario)](#3-niveles-de-acceso-roles-de-usuario)
4. [Módulo de Agenda (Gestión de Reuniones)](#4-módulo-de-agenda-gestión-de-reuniones)
5. [Módulo de Registro de Personas y Control de Asistencia](#5-módulo-de-registro-de-personas-y-control-de-asistencia)
6. [Dashboards y Reportes Estadísticos](#6-dashboards-y-reportes-estadísticos)
7. [Mantenimiento y Auditoría (Exclusivo Administrador)](#7-mantenimiento-y-auditoría-exclusivo-administrador)
8. [Resolución de Problemas Comunes](#8-resolución-de-problemas-comunes)

---

## 1. Introducción y Requisitos del Sistema

El **Sistema Administrativo PSUV 2** es una aplicación web intuitiva y segura creada para optimizar el registro de las actividades políticas, movilizaciones, asambleas y reuniones sectoriales. 

### Requisitos para el uso
*   **Servidor Web Local:** XAMPP (servidor Apache y base de datos MariaDB/MySQL activados).
*   **Base de datos:** Importar el archivo `database.sql` o `sistema_administrativo.sql` en phpMyAdmin con el nombre `sistema_administrativo`.
*   **Navegador Recomendado:** Google Chrome, Mozilla Firefox o Microsoft Edge en sus versiones más recientes.

---

## 2. Acceso al Sistema y Seguridad

El ingreso al sistema se realiza a través de la pantalla de inicio de sesión pública.

### Inicio de Sesión
1. Diríjase a la URL de acceso (por defecto localmente: `http://localhost/SISTEMA_ADMINISTRATIVO_PSUV_2/public/login.php`).
2. Introduzca su **Nombre de Usuario**.
3. Ingrese su **Contraseña**.
4. Haga clic en **"Iniciar Sesión"**.

### Recuperación de Contraseña
Si ha olvidado su contraseña y su cuenta posee los datos correctos registrados:
1. En la pantalla de login, haga clic en **"¿Olvidaste tu contraseña?"** ([recuperar.php](file:///c:/xampp/htdocs/SISTEMA_ADMINISTRATIVO_PSUV_2/public/recuperar.php)).
2. Siga los pasos indicados introduciendo su cédula o correo según lo requiera el sistema para generar un enlace temporal de restablecimiento ([reset_password.php](file:///c:/xampp/htdocs/SISTEMA_ADMINISTRATIVO_PSUV_2/public/reset_password.php)).

> [!WARNING]
> Las contraseñas en la base de datos están encriptadas mediante algoritmos seguros (bcrypt). Ningún usuario, ni siquiera el administrador, puede leer su contraseña original. Si se pierde, deberá restablecerse obligatoriamente.

---

## 3. Niveles de Acceso (Roles de Usuario)

El sistema restringe las opciones visuales y operativas según el rol asignado a cada usuario en la base de datos:

| Rol | Permisos Principales | Vistas Disponibles |
| :--- | :--- | :--- |
| **Administrador** | Control total. Crear/editar/eliminar usuarios, gestionar la agenda, ver historial de auditoría y realizar respaldos de seguridad. | `/admin/*`, `/public/*` |
| **Operador** | Gestión del día a día. Programar y finalizar reuniones, gestionar asistencias y registrar personas. | `/operador/*`, `/public/*` |
| **Visualizador** | Rol de auditoría pasiva. Consultar estadísticas, ver listado de agenda y exportar reportes. No puede editar ni eliminar datos. | `/visualizador/*`, `/public/*` |

---

## 4. Módulo de Agenda (Gestión de Reuniones)

Este módulo permite planificar y realizar seguimiento de todas las actividades partidistas en el territorio.

### Programar una Reunión (Administrador / Operador)
1. Ingrese al panel y seleccione **Agenda de Reuniones** ([admin/reuniones.php](file:///c:/xampp/htdocs/SISTEMA_ADMINISTRATIVO_PSUV_2/admin/reuniones.php) u [operador/reuniones.php](file:///c:/xampp/htdocs/SISTEMA_ADMINISTRATIVO_PSUV_2/operador/reuniones.php)).
2. Complete el formulario de registro:
    *   **Fecha:** Seleccione el día programado.
    *   **Hora:** Selector secuencial en formato de 12 horas indicando Hora, Minutos y Periodo (AM/PM).
    *   **Parroquia:** Elija una de las 11 parroquias correspondientes (ej. *Cachamay, Unare, Simon Bolivar*, etc.).
    *   **Tipo de Reunión:** Seleccione entre *Ordinaria, Ampliada, Informativa, Formativa, Sociales* o *Videoconferencias*.
    *   **Lugar exacto:** Dirección o instalación física donde se ejecutará.
    *   **Descripción:** Resumen corto del objetivo de la reunión (máximo 100 caracteres. El sistema incluye un contador en tiempo real para evitar excederse).
3. **Datos del Responsable:** Ingrese el nombre completo, cédula de identidad y número telefónico del líder de la actividad.
4. Haga clic en **"Programar Reunión"** para guardar.

### Estado de las Actividades
*   🟢 **Finalizada (Verde):** La actividad fue completada con éxito.
*   🟡 **Programada (Amarillo):** La actividad está planificada en el futuro y esperando ejecución.

Para cambiar el estado de una reunión a **Finalizada**, haga clic en el botón verde **"Finalizar"** al lado de la actividad en el listado de agenda. Una vez finalizada, pasará automáticamente a sumar en las estadísticas de gestión del Dashboard.

### Ficha Técnica de la Reunión (PDF)
Al hacer clic en el botón **"PDF"** en la fila de cualquier reunión, el sistema invocará a la librería FPDF para exportar un documento imprimible con los detalles completos del evento, ideal para archivar físicamente o enviar a superiores.

---

## 5. Módulo de Registro de Personas y Control de Asistencia

Permite llevar el registro exacto de las personas que participan en los eventos y asambleas del partido.

### Registro de Nueva Persona (BD del Sistema)
Antes de registrar una asistencia, los ciudadanos deben existir en la base de datos de personas ([PERSONAS](file:///c:/xampp/htdocs/SISTEMA_ADMINISTRATIVO_PSUV_2/database.sql#L24)):
*   Se guardan datos básicos: **Cédula de Identidad**, **Nombres** y **Apellidos**.

### Registrar Asistencia a una Sesión
1. El Operador accede al módulo de Asistencia.
2. Selecciona la **Sesión / Evento activo** del día.
3. En el campo de captura, introduzca el número de **Cédula de Identidad** del participante.
4. Presione la tecla Enter o haga clic en registrar.
    *   El sistema validará si la cédula existe. Si es correcta, registrará la hora exacta de marcación automáticamente.
    *   Si la persona ya fue registrada en esa misma sesión, el sistema emitirá una alerta visual impidiendo el doble registro.

---

## 6. Dashboards y Reportes Estadísticos

El sistema recopila la información para mostrarla de forma organizada:

### Dashboard General
*   Muestra indicadores gráficos y numéricos del volumen de **Reuniones Ejecutadas** y **Asistencias Reportadas**.
*   Los datos están agrupados por intervalos de tiempo (Semanal, Mensual y Anual) y facilitan la toma de decisiones.

### Exportar Datos
*   **Excel:** Permite descargar los listados de asistencia y reuniones en formato `.xlsx` nativo mediante [exportar_excel.php](file:///c:/xampp/htdocs/SISTEMA_ADMINISTRATIVO_PSUV_2/operador/exportar_excel.php) para su análisis en hojas de cálculo.
*   **PDF:** Genera reportes en formato cerrado listos para impresión.

---

## 7. Mantenimiento y Auditoría (Exclusivo Administrador)

Estas opciones solo son accesibles si el usuario logueado posee el rol `admin`.

### Logs de Auditoría ([admin/logs.php](file:///c:/xampp/htdocs/SISTEMA_ADMINISTRATIVO_PSUV_2/admin/logs.php))
Permite inspeccionar cada movimiento que se realiza en el sistema. Cada registro de log muestra:
*   **Usuario:** Quién realizó la acción.
*   **Acción:** Qué operación se ejecutó (ej. *"Creada reunión: ORDINARIA"*).
*   **Tabla Afectada:** Tabla de base de datos modificada (ej. `REUNIONES`, `USUARIOS`).
*   **Fecha/Hora:** Momento exacto de la modificación.

### Copias de Seguridad (Backup & Restore)
Para salvaguardar la integridad de los datos de la organización:
1. Ingrese a **Respaldos de Base de Datos** ([admin/backup.php](file:///c:/xampp/htdocs/SISTEMA_ADMINISTRATIVO_PSUV_2/admin/backup.php)).
2. Para crear un respaldo, haga clic en el botón de generación. El sistema extraerá toda la estructura y datos en un archivo con extensión `.sql` que se almacenará en la carpeta [/backups](file:///c:/xampp/htdocs/SISTEMA_ADMINISTRATIVO_PSUV_2/backups) y se guardará el registro del creador.
3. Para restaurar el sistema, seleccione un archivo de la lista histórica de copias de seguridad y pulse el botón de restauración.

---

## 8. Resolución de Problemas Comunes

### 1. Error de Conexión a la Base de Datos
*   **Síntoma:** El sistema muestra una pantalla en blanco o un mensaje de error PDO.
*   **Solución:** Verifique el archivo de configuración en [config/database.php](file:///c:/xampp/htdocs/SISTEMA_ADMINISTRATIVO_PSUV_2/config/database.php). Asegúrese de que los campos de servidor, usuario y contraseña coincidan con los de su entorno XAMPP local. Además, confirme que el servicio MySQL esté iniciado.

### 2. Registro Automático y Validación de Cédulas en Asistencia
*   **Comportamiento:** Al ingresar una cédula que no existía previamente, el sistema no emite un error; en su lugar, la crea automáticamente en la base de datos de personas con los nombres y apellidos provistos en el formulario de asistencia.
*   **Advertencia por Duplicidad:** Si el participante ya fue registrado en esa misma sesión, el sistema emitirá el mensaje: *"Esta persona ya está registrada en esta sesión."* (Alerta warning en [operador/reportes.php](file:///c:/xampp/htdocs/SISTEMA_ADMINISTRATIVO_PSUV_2/operador/reportes.php#L49)).

### 3. Exceso de Caracteres en Descripción de Reunión
*   **Síntoma:** El botón de programación da error o la descripción se corta.
*   **Solución:** El campo `DESCRIPCION` tiene un límite estricto de **100 caracteres** en base de datos. Utilice el contador visual ubicado debajo del campo para ajustar su texto antes de guardarlo.

---

*Manual de usuario actualizado - Mayo de 2026.*

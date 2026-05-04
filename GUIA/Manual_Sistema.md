# Guía Completa de Usuario: Sistema Administrativo PSUV 2

Esta guía detalla el funcionamiento íntegro del sistema, desde la gestión de usuarios hasta el control operativo de agendas y asistencias.

---

## 1. Introducción
El Sistema Administrativo PSUV 2 es una plataforma diseñada para centralizar la gestión de actividades políticas, control de asistencia y auditoría de procesos en un entorno seguro y moderno.

---

## 2. Roles de Usuario y Niveles de Acceso
El sistema cuenta con tres niveles de seguridad:

*   **Administrador:** Acceso total. Gestiona usuarios, realiza respaldos de base de datos, revisa logs de auditoría y supervisa la agenda.
*   **Operador:** Gestión del día a día. Crea sesiones de asistencia, registra participantes y programa/finaliza reuniones de la agenda.
*   **Visualizador:** Rol de consulta. Solo puede ver los dashboards, listas de reuniones y reportes sin realizar cambios.

---

## 3. Módulo de Agenda (Reuniones)
Es el núcleo de la planificación del sistema.
*   **Programación:** Se registran reuniones indicando fecha, hora (formato 12h con AM/PM), parroquia y lugar.
*   **Gestión de Tiempo:** El selector de hora es secuencial (1 a 1), permitiendo precisión exacta en minutos y horas.
*   **Finalización de Actividades:** Cada reunión tiene un botón **"Finalizar"**. Al pulsarlo, la reunión pasa a estado ejecutado (Verde) y se contabiliza en las estadísticas del Dashboard.
*   **Ficha Técnica (PDF):** Permite generar un documento impreso con todos los datos del responsable y la actividad.

---

## 4. Control de Asistencia
Módulo destinado a capturar la participación en eventos.
*   **Sesiones:** Se crea un "Evento" (ej. Asamblea).
*   **Registro por Cédula:** El operador ingresa la cédula del participante y el sistema registra automáticamente la hora exacta de marcación.
*   **Validación:** El sistema impide que una misma persona se registre dos veces en la misma actividad.

---

## 5. Dashboards Estadísticos
Cada rol tiene una vista personalizada:
*   **Estadísticas Administrativas:** Muestra el conteo de **Actividades Realizadas** (reuniones finalizadas) y **Asistencias Reportadas** por semana, mes y año.
*   **Filtros:** Permite buscar información específica por fecha o tipo de evento.

---

## 6. Seguridad y Mantenimiento (Solo Administrador)
*   **Logs del Sistema:** Registro detallado de cada acción (quién creó una reunión, quién inició sesión, etc.).
*   **Respaldos:** Herramienta para descargar toda la base de datos en un archivo SQL y restaurarla en caso de emergencia.
*   **Gestión de Usuarios:** Activación y suspensión de cuentas para control de personal.

---

## 7. Requerimientos Técnicos
*   **Servidor:** XAMPP (Apache + MariaDB).
*   **Navegador:** Compatible con navegadores modernos (Chrome, Edge, Firefox).
*   **Base de Datos:** `sistema_administrativo`.

---

*Guía generada el 28 de abril de 2026.*

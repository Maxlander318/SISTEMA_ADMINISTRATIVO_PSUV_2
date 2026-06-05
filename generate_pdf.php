<?php
require_once __DIR__ . '/includes/fpdf/fpdf.php';

class PDF extends FPDF {
    // Cabecera de página
    function Header() {
        if ($this->PageNo() == 1) {
            // No mostrar cabecera en la portada
            return;
        }
        $this->SetY(10);
        $this->SetFont('Arial', 'B', 9);
        $this->SetTextColor(128, 128, 128);
        $this->Cell(0, 10, utf8_decode('GUÍA DE USUARIO COMPLETA: SISTEMA ADMINISTRATIVO PSUV 2'), 0, 1, 'L');
        $this->Line(10, 18, 200, 18);
        $this->Ln(5);
    }

    // Pie de página
    function Footer() {
        if ($this->PageNo() == 1) {
            // No mostrar pie de página en la portada
            return;
        }
        $this->SetY(-20);
        $this->Line(10, $this->GetY() - 2, 200, $this->GetY() - 2);
        $this->SetFont('Arial', 'I', 9);
        $this->SetTextColor(128, 128, 128);
        $this->Cell(100, 10, utf8_decode('Confidencial - Uso Político Interno'), 0, 0, 'L');
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'R');
    }

    // Título de Sección
    function SectionTitle($num, $title) {
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(180, 0, 0); // Rojo PSUV
        $this->Cell(0, 12, utf8_decode("$num. $title"), 0, 1, 'L');
        $this->Ln(2);
    }

    // Subtítulo de Sección
    function SectionSubTitle($title) {
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(40, 40, 40);
        $this->Cell(0, 10, utf8_decode($title), 0, 1, 'L');
        $this->Ln(1);
    }

    // Texto de párrafo (Letra Arial 12, Interlineado Doble = 10mm en FPDF)
    function BodyText($text) {
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(50, 50, 50);
        $this->MultiCell(0, 10, utf8_decode($text));
        $this->Ln(3);
    }

    // Caja de captura de pantalla (Placeholder visual)
    function ScreenshotBox($title) {
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(100, 100, 100);
        $this->SetFillColor(245, 245, 245);
        $this->Cell(0, 12, utf8_decode("[ ILUSTRACIÓN: $title ]"), 1, 1, 'C', true);
        $this->Ln(4);
    }
}

$pdf = new PDF('P', 'mm', 'A4'); // Margen por defecto 10mm
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 20);

// ==========================================
// PÁGINA 1: PORTADA
// ==========================================
$pdf->AddPage();
// Dibujar un marco decorativo en la portada
$pdf->Rect(10, 10, 190, 277);

$pdf->SetY(60);
$pdf->SetFont('Arial', 'B', 24);
$pdf->SetTextColor(180, 0, 0);
$pdf->Cell(0, 15, utf8_decode('SISTEMA ADMINISTRATIVO PSUV 2'), 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(60, 60, 60);
$pdf->Cell(0, 10, utf8_decode('GUÍA VISUAL DE USUARIO Y MANUAL OPERATIVO'), 0, 1, 'C');

$pdf->Ln(20);
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(80, 80, 80);
$pdf->MultiCell(0, 8, utf8_decode("Guía completa de usuario detallando las interfaces, roles de acceso, navegación por menús, ejemplos prácticos de casos de uso y resolución de preguntas frecuentes para el personal operativo del partido."), 0, 'C');

$pdf->SetY(200);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(30, 30, 30);
$pdf->Cell(0, 8, utf8_decode('Dirección de Organización y Control Político Electoral'), 0, 1, 'C');
$pdf->Cell(0, 8, utf8_decode('Municipio Caroní, Estado Bolívar'), 0, 1, 'C');

$pdf->SetY(240);
$pdf->SetFont('Arial', 'I', 11);
$pdf->Cell(0, 8, utf8_decode('Manual de Usuario Detallado - Letra Arial 12'), 0, 1, 'C');
$pdf->Cell(0, 8, utf8_decode('Interlineado Doble - Año 2026'), 0, 1, 'C');

// ==========================================
// PÁGINAS DE CONTENIDO (FLUJO CONTINUO)
// ==========================================
$pdf->AddPage();

// SECCIÓN 1: INTRODUCCIÓN Y NAVEGACIÓN
$pdf->SectionTitle('1', 'Introducción y Guía de Navegación del Sistema');
$pdf->BodyText("El Sistema Administrativo PSUV 2 centraliza la gestión de asambleas, agendas y control electoral. El acceso al software se realiza de forma web mediante credenciales autorizadas, permitiendo a los operadores un manejo rápido y dinámico desde cualquier computadora o dispositivo móvil.");

$pdf->ScreenshotBox("Pantalla de Acceso (login.php) con campos de Usuario y Contraseña");

$pdf->SectionSubTitle('1.1. Distribución Visual de la Interfaz (Navegación)');
$pdf->BodyText("Una vez iniciada la sesión, la pantalla se divide en tres áreas principales:\n" .
"1. Barra de Navegación Lateral (Sidebar): Menú de opciones de color gris oscuro ubicado a la izquierda. Contiene los accesos a los distintos módulos (Dashboard, Agenda de Reuniones, Registro de Asistencia, Historial de Logs, Copias de Seguridad y Cerrar Sesión).\n" .
"2. Panel de Contenido Principal: Ocupa el centro y derecha de la pantalla. Allí se cargan los formularios de datos, los gráficos y las tablas.\n" .
"3. Barra Superior (Navbar): Muestra el nombre de usuario activo y su rol actual (Administrador, Operador o Visualizador).");

$pdf->ScreenshotBox("Panel Principal de Control con Barra de Navegación Lateral Activa");

$pdf->BodyText("Para navegar entre los módulos, el usuario simplemente debe hacer clic sobre la opción deseada en la Barra Lateral. Si utiliza un teléfono inteligente, el menú se adapta de forma responsive, pudiendo desplegarse mediante el ícono de menú de tres barras ubicado en la esquina superior izquierda.");

// SECCIÓN 2: MATRIZ DE PERMISOS POR ROLES
$pdf->AddPage();
$pdf->SectionTitle('2', 'Matriz de Permisos y Acceso por Roles');
$pdf->BodyText("El sistema posee un control de privilegios jerárquico. Las acciones disponibles cambian según el rol asignado a su cuenta de usuario.");

$pdf->SectionSubTitle('2.1. Tabla de Matriz de Permisos');
$pdf->Ln(2);

// Encabezado de Tabla de Permisos
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(220, 220, 220);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(65, 8, utf8_decode('Módulo / Acción'), 1, 0, 'C', true);
$pdf->Cell(40, 8, utf8_decode('Administrador'), 1, 0, 'C', true);
$pdf->Cell(40, 8, utf8_decode('Operador'), 1, 0, 'C', true);
$pdf->Cell(40, 8, utf8_decode('Visualizador'), 1, 1, 'C', true);

// Datos de Tabla de Permisos
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(65, 8, utf8_decode('Ver Dashboard Estadístico'), 1, 0, 'L');
$pdf->Cell(40, 8, utf8_decode('PERMITIDO (Total)'), 1, 0, 'C');
$pdf->Cell(40, 8, utf8_decode('PERMITIDO (Propio)'), 1, 0, 'C');
$pdf->Cell(40, 8, utf8_decode('PERMITIDO (Lectura)'), 1, 1, 'C');

$pdf->Cell(65, 8, utf8_decode('Programar Reunión (Agenda)'), 1, 0, 'L');
$pdf->Cell(40, 8, utf8_decode('PERMITIDO'), 1, 0, 'C');
$pdf->Cell(40, 8, utf8_decode('PERMITIDO'), 1, 0, 'C');
$pdf->Cell(40, 8, utf8_decode('DENEGADO'), 1, 1, 'C');

$pdf->Cell(65, 8, utf8_decode('Finalizar / Editar Reunión'), 1, 0, 'L');
$pdf->Cell(40, 8, utf8_decode('PERMITIDO'), 1, 0, 'C');
$pdf->Cell(40, 8, utf8_decode('PERMITIDO'), 1, 0, 'C');
$pdf->Cell(40, 8, utf8_decode('DENEGADO'), 1, 1, 'C');

$pdf->Cell(65, 8, utf8_decode('Eliminar Actividad'), 1, 0, 'L');
$pdf->Cell(40, 8, utf8_decode('PERMITIDO'), 1, 0, 'C');
$pdf->Cell(40, 8, utf8_decode('DENEGADO'), 1, 0, 'C');
$pdf->Cell(40, 8, utf8_decode('DENEGADO'), 1, 1, 'C');

$pdf->Cell(65, 8, utf8_decode('Registrar Asistencias'), 1, 0, 'L');
$pdf->Cell(40, 8, utf8_decode('PERMITIDO'), 1, 0, 'C');
$pdf->Cell(40, 8, utf8_decode('PERMITIDO'), 1, 0, 'C');
$pdf->Cell(40, 8, utf8_decode('DENEGADO'), 1, 1, 'C');

$pdf->Cell(65, 8, utf8_decode('Descargar SQL (Backups)'), 1, 0, 'L');
$pdf->Cell(40, 8, utf8_decode('PERMITIDO'), 1, 0, 'C');
$pdf->Cell(40, 8, utf8_decode('DENEGADO'), 1, 0, 'C');
$pdf->Cell(40, 8, utf8_decode('DENEGADO'), 1, 1, 'C');

$pdf->Cell(65, 8, utf8_decode('Auditar Bitácora (Logs)'), 1, 0, 'L');
$pdf->Cell(40, 8, utf8_decode('PERMITIDO'), 1, 0, 'C');
$pdf->Cell(40, 8, utf8_decode('DENEGADO'), 1, 0, 'C');
$pdf->Cell(40, 8, utf8_decode('DENEGADO'), 1, 1, 'C');

$pdf->Ln(4);

$pdf->BodyText("Si su cuenta posee el rol Visualizador, el sistema inhabilitará y ocultará automáticamente los botones de guardado o eliminación. Si intenta ingresar a una ruta de edición de forma directa manipulando la URL, el sistema validará sus permisos en el backend y lo redireccionará a su dashboard emitiendo un mensaje de error.");

// SECCIÓN 3: CAMPOS, FORMULARIOS Y BOTONES
$pdf->AddPage();
$pdf->SectionTitle('3', 'Detalle de Campos, Formularios y Botones');
$pdf->BodyText("Este apartado especifica la entrada de datos en los formularios y el comportamiento de los botones interactivos.");

$pdf->SectionSubTitle('3.1. Formulario de Creación de Reunión (Agenda)');
$pdf->BodyText("- Fecha: Campo obligatorio. Debe seleccionar el día planificado para la actividad en el calendario.\n" .
"- Hora: Posee tres listas desplegables independientes: Hora (01 al 12), Minutos (00 al 59) y Período (AM o PM). Este diseño secuencial 1 a 1 garantiza que el operador indique la hora exacta sin errores tipográficos. Internamente, el código procesa la combinación para guardarla en formato de 24 horas.\n" .
"- Parroquia: Selector obligatorio para indicar el territorio político en Caroní.\n" .
"- Tipo de Reunión: Menú desplegable para tipificar la actividad.\n" .
"- Lugar: Campo de texto para ingresar la dirección exacta del evento.\n" .
"- Descripción: Campo limitado a un máximo de 100 caracteres. En la parte inferior derecha del campo, se muestra un contador numérico en tiempo real ('X / 100') que alerta si se está aproximando al límite de caracteres.");

$pdf->ScreenshotBox("Formulario de Programación de Reunión con el Contador de Caracteres Activo");

$pdf->SectionSubTitle('3.2. Botones de Acción de la Agenda');
$pdf->BodyText("- Botón 'Programar Reunión': Botón azul que valida los campos e inserta la reunión en estado 'Programada' (mostrando una insignia amarilla).\n" .
"- Botón 'Finalizar' (Verde): Se presiona una vez ejecutada la reunión. Cambia su estado a 'Finalizada' (Insignia verde).\n" .
"- Botón 'PDF' (Gris): Abre en una pestaña nueva la Ficha Técnica para impresión.\n" .
"- Botón 'Eliminar' (Rojo): Borra la actividad tras confirmar la alerta de validación.");

// SECCIÓN 4: CASOS DE USO PRÁCTICOS
$pdf->AddPage();
$pdf->SectionTitle('4', 'Casos de Uso Prácticos y Flujos de Operación');
$pdf->BodyText("Para ilustrar el funcionamiento diario del sistema, a continuación se detallan dos de los casos de uso más recurrentes por los operadores partidistas.");

$pdf->SectionSubTitle('4.1. Caso de Uso 1: Planificación y Cierre de una Asamblea');
$pdf->BodyText("Supongamos que el operador de la Parroquia Unare planifica una asamblea. Los pasos son:\n" .
"1. El operador ingresa a la Agenda, selecciona la fecha, ajusta la hora a '05:30 PM', elige la parroquia 'Unare', define la actividad como 'ORDINARIA' y escribe la dirección del Infocentro.\n" .
"2. En descripción introduce: 'Reunión de coordinación vecinal para estructurar vocerías electorales'. El contador indica 68/100.\n" .
"3. Ingresa los datos del responsable territorial y presiona 'Programar Reunión'. El sistema muestra la alerta: 'Reunión programada correctamente' y se crea el registro con estatus 'Programada'.\n" .
"4. Al terminar el evento, el operador hace clic en el botón verde 'Finalizar'. El estatus cambia a 'Finalizada' y los indicadores estadísticos del Dashboard de la Parroquia Unare se incrementan de inmediato.");

$pdf->SectionSubTitle('4.2. Caso de Uso 2: Control de Asistencia mediante Cédula');
$pdf->BodyText("Durante la realización del evento político:\n" .
"1. El operador ingresa al módulo de asistencia y selecciona la Sesión activa correspondiente a la asamblea creada.\n" .
"2. El participante se acerca a la mesa y suministra su número de Cédula de Identidad, Nombres y Apellidos.\n" .
"3. El operador tipea la cédula en el campo correspondiente. Si la cédula ya existe en la base de datos de Personas, el sistema recupera sus datos. Si no existe, al hacer clic en 'Registrar Asistencia' el sistema crea automáticamente a la persona en la tabla PERSONAS con los nombres y apellidos ingresados, registrando de inmediato su asistencia con la hora exacta del servidor.");

// SECCIÓN 5: ALERTAS Y PREGUNTAS FRECUENTES
$pdf->AddPage();
$pdf->SectionTitle('5', 'Mensajes del Sistema, Alertas y Preguntas Frecuentes');
$pdf->BodyText("Esta sección detalla los mensajes exactos de éxito, error y advertencia generados por el código del sistema y cómo debe actuar el operador ante cada uno de ellos:");

$pdf->SectionSubTitle('5.1. Mensajes de Advertencia y Control de Asistencia');
$pdf->BodyText("- Mensaje: 'Esta persona ya está registrada en esta sesión.' (Tipo: Advertencia/Warning)\n" .
"  *Ubicación:* Módulo de Asistencia ([operador/reportes.php](file:///c:/xampp/htdocs/SISTEMA_ADMINISTRATIVO_PSUV_2/operador/reportes.php#L49)).\n" .
"  *Significado:* La cédula ingresada ya marcó su asistencia para este evento específico. El sistema bloquea el doble registro.\n" .
"- Mensaje: 'Asistencia registrada correctamente.' (Tipo: Confirmación/Success)\n" .
"  *Significado:* El registro de asistencia y la creación automática del ciudadano (en caso de no existir) se ejecutaron con éxito.");

$pdf->SectionSubTitle('5.2. Mensajes de Error de Acceso y Login');
$pdf->BodyText("- Mensaje: 'Usuario o contraseña incorrectos.' (Tipo: Error/Danger)\n" .
"  *Ubicación:* Pantalla de Acceso ([public/login.php](file:///c:/xampp/htdocs/SISTEMA_ADMINISTRATIVO_PSUV_2/public/login.php#L32)).\n" .
"  *Significado:* Nombre de usuario no registrado o clave errónea. Verifique mayúsculas o espacios.\n" .
"- Mensaje: 'La cédula no está registrada.' (Tipo: Error/Danger)\n" .
"  *Ubicación:* Recuperación de clave ([public/recuperar.php](file:///c:/xampp/htdocs/SISTEMA_ADMINISTRATIVO_PSUV_2/public/recuperar.php#L26)).\n" .
"  *Significado:* La cédula ingresada no coincide con ningún usuario del sistema habilitado.");

$pdf->SectionSubTitle('5.3. Mensajes en Restablecimiento de Clave');
$pdf->BodyText("- Mensaje: 'El token es inválido o ha expirado.' (Tipo: Error/Danger)\n" .
"  *Ubicación:* Cambio de clave ([public/reset_password.php](file:///c:/xampp/htdocs/SISTEMA_ADMINISTRATIVO_PSUV_2/public/reset_password.php#L19)).\n" .
"  *Significado:* El enlace de recuperación es incorrecto o superó el tiempo límite de 1 hora. Solicite uno nuevo.\n" .
"- Mensaje: 'Las contraseñas no coinciden.' (Tipo: Error/Danger)\n" .
"  *Significado:* El campo 'Nueva Contraseña' y 'Confirmar' no son idénticos. Vuelva a escribirlos.");

$pdf->SectionSubTitle('5.4. Mensajes de Error de Seguridad y Base de Datos');
$pdf->BodyText("- Mensaje: 'Error de validación CSRF.' (Tipo: Bloqueo de seguridad)\n" .
"  *Significado:* La sesión expiró por seguridad. Recargue la página e ingrese nuevamente.\n" .
"- Mensaje: 'Error al restaurar la base de datos.' (Tipo: Error/Danger)\n" .
"  *Significado:* Ocurre en el panel de respaldos ([admin/backup.php](file:///c:/xampp/htdocs/SISTEMA_ADMINISTRATIVO_PSUV_2/admin/backup.php#L22)) al intentar cargar un archivo SQL corrupto.");

// SECCIÓN 6: PROCESOS ADMINISTRATIVOS
$pdf->AddPage();
$pdf->SectionTitle('6', 'Procesos de Copia de Seguridad y Auditoría');
$pdf->BodyText("El módulo de mantenimiento garantiza que la información se resguarde de manera preventiva ante fallos de hardware o pérdida accidental de datos.");

$pdf->ScreenshotBox("Módulo de Respaldos con Historial de Archivos SQL y creador del Backup");

$pdf->SectionSubTitle('6.1. Flujo para crear una copia de seguridad');
$pdf->BodyText("1. Inicie sesión con la cuenta de Administrador principal.\n" .
"2. Diríjase a la sección 'Respaldos de Base de Datos' en el menú de la izquierda.\n" .
"3. Presione el botón 'Generar Respaldo'. El sistema compilará la base de datos y la guardará en la carpeta '/backups' en un archivo con formato 'backup_AAAA-MM-DD_HH-MM-SS.sql'.\n" .
"4. Descargue el archivo generado a un almacenamiento externo.");

$pdf->SectionSubTitle('6.2. Uso de la Bitácora de Auditoría');
$pdf->BodyText("Para auditar las operaciones, el Administrador puede ingresar a 'Logs del Sistema' en la barra lateral. Allí se muestra una tabla en orden cronológico descendente que registra de forma detallada quién editó una reunión, quién inició sesión, o qué operador eliminó algún registro, mostrando la fecha y la tabla del sistema afectada.");

// Guardar PDF
$pdf->Output('F', __DIR__ . '/GUIA/Manual_Usuario.pdf');
echo "PDF generado exitosamente en GUIA/Manual_Usuario.pdf\n";
?>

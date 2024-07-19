<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para el manejo de datos de administradores.
require_once('../../models/data/administrador_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report('P', 'mm', 'Letter'); // Tamaño del papel Letter (216 x 279 mm)

// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Administradores Registrados');

// Movemos toda la tabla un poco a la izquierda
$pdf->setX(15); // Ajusta el valor según tu necesidad para mover a la izquierda

// Se instancia el modelo AdministradorData para obtener los datos de administradores.
$adminData = new AdministradorData;

// Obtener el nombre del administrador desde la sesión si está iniciada
$nombreAdministrador = isset($_SESSION['nombreAdministrador']) ? $_SESSION['nombreAdministrador'] : '';

// Título con el nombre del administrador
$pdf->setFont('Arial', 'B', 14);
$pdf->cell(0, 10, 'Reporte de Administradores - ' . $nombreAdministrador, 0, 1, 'C');

// Se verifica si existen administradores para mostrar.
if ($dataAdministradores = $adminData->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(193, 218, 243);
    // Encabezados del reporte
    $pdf->setFont('Arial', 'B', 11);

    $pdf->cell(20, 10, 'ID', 1, 0, 'C', 1);
    $pdf->cell(50, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(50, 10, 'Apellido', 1, 0, 'C', 1);
    $pdf->cell(70, 10, 'Correo', 1, 1, 'C', 1);

    $pdf->setFont('Arial', '', 11);
    $pdf->setX(15);

    foreach ($dataAdministradores as $admin) {
        $pdf->cell(20, 10, $admin['id_admin'], 1, 0, 'C');
        $pdf->cell(50, 10, $pdf->encodeString($admin['nombre']), 1, 0, 'C');
        $pdf->cell(50, 10, $pdf->encodeString($admin['apellido']), 1, 0, 'C');
        $pdf->cell(70, 10, $pdf->encodeString($admin['correo_administrador']), 1, 0, 'C');
    }
} else {
    // Mensaje si no hay administradores registrados.
    $pdf->setFont('Arial', '', 11);
    $pdf->cell(0, 10, 'No hay administradores registrados.', 1, 1, 'C');
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'reporte_administradores.pdf');
?>

<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para el manejo de datos de administradores.
require_once('../../models/data/administrador_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Reporte de Administradores');

// Se instancia el modelo AdministradorData para obtener los datos de administradores.
$adminData = new AdministradorData;
// Se verifica si existen administradores para mostrar.
if ($dataAdministradores = $adminData->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(193, 218, 243);
    // Encabezados del reporte
    $pdf->setFont('Arial', 'B', 12);
    $pdf->cell(30, 10, 'ID', 1, 0, 'C');
    $pdf->cell(60, 10, 'Nombre', 1, 0, 'C');
    $pdf->cell(60, 10, 'Apellido', 1, 0, 'C');
    $pdf->cell(80, 10, 'Correo', 1, 1, 'C');

    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(193, 218, 243);
    // Datos de los administradores
    $pdf->setFont('Arial', '', 11);
    foreach ($dataAdministradores as $admin) {
        $pdf->cell(30, 10, $admin['id_admin'], 1, 0, 'C');
        $pdf->cell(60, 10, $pdf->encodeString($admin['nombre']), 1, 0, 'C');
        $pdf->cell(60, 10, $pdf->encodeString($admin['apellido']), 1, 0, 'C');
        $pdf->cell(80, 10, $pdf->encodeString($admin['correo_administrador']), 1, 1, 'C');
    }
} else {
    // Mensaje si no hay administradores registrados.
    $pdf->setFont('Arial', '', 11);
    $pdf->cell(0, 10, 'No hay administradores registrados.', 1, 1, 'C');
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'reporte_administradores.pdf');
?>

<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para el acceso a datos de coloress.
require_once('../../models/data/colores_data.php');
function getUser() {
    return isset($_SESSION['aliasAdministrador']) ? $_SESSION['aliasAdministrador'] : null;
}
// Se instancia la clase para crear el reporte.
$pdf = new Report('P', 'mm', 'Letter'); // Tamaño del papel Letter (216 x 279 mm)

// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Colores Registrados');
// Título con el nombre del administrador
$nombreAdministrador = getUser() ?? 'Administrador Desconocido'; // Obtener el alias del administrador desde la sesión
$pdf->setFont('Arial', 'B', 14);
$pdf->cell(0, 10, 'Reporte de Administrador - ' . $nombreAdministrador, 0, 1, 'C');
// Se instancia el modelo Cliente para obtener los datos.
// Movemos toda la tabla un poco a la izquierda
$pdf->setX(10); // Ajusta el valor según tu necesidad para mover a la izquierda

// Se instancia el modelo colores para obtener los datos.
$coloresmodel = new ColoresData;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($datacolores = $coloresmodel->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(193, 218, 243);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);

    // Encabezados
    $pdf->cell(50, 10, 'ID', 1, 0, 'C', 1);
    $pdf->cell(140, 10, 'Nombre', 1, 1, 'C', 1); // Cambiado a 140 y con salto de línea

    // Se establece la fuente para los datos de los coloress.
    $pdf->setFont('Arial', '', 11);
    // Movemos toda la tabla un poco a la izquierda
    $pdf->setX(10); // Ajusta el valor según tu necesidad para mover a la izquierda
    // Recorremos los datos de los coloress
    foreach ($datacolores as $colores) {
        // Movemos toda la tabla un poco a la izquierda
        $pdf->setX(10); // Ajusta el valor según tu necesidad para mover a la izquierda
        // ID del colores
        $pdf->cell(50, 10, $colores['id_color'], 1, 0, 'C');

        // Nombre
        $pdf->cell(140, 10, $pdf->encodeString($colores['nombre']), 1, 1, 'L'); // Cambiado a 140 y con salto de línea
    }
} else {
    // Si no hay coloress registrados
    $pdf->cell(190, 10, $pdf->encodeString('No hay colores registrados'), 1, 1, 'C'); // Cambiado el ancho y con salto de línea
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'colores.pdf');
?>

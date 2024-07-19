<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para el acceso a datos de marcas.
require_once('../../models/data/marcas_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report('P', 'mm', 'Letter'); // Tamaño del papel Letter (216 x 279 mm)

// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Marcas Registradas');

// Movemos toda la tabla un poco a la izquierda
$pdf->setX(10); // Ajusta el valor según tu necesidad para mover a la izquierda

// Se instancia el modelo marca para obtener los datos.
$marcamodel = new MarcasData;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataMarcas = $marcamodel->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(193, 218, 243);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);

    // Encabezados
    $pdf->cell(50, 10, 'ID', 1, 0, 'C', 1);
    $pdf->cell(140, 10, 'Nombre', 1, 1, 'C', 1); // Cambiado a 140 y con salto de línea

    // Se establece la fuente para los datos de los marcas.
    $pdf->setFont('Arial', '', 11);
    // Movemos toda la tabla un poco a la izquierda
    $pdf->setX(10); // Ajusta el valor según tu necesidad para mover a la izquierda
    // Recorremos los datos de los marcas
    foreach ($dataMarcas as $marca) {
        // Movemos toda la tabla un poco a la izquierda
        $pdf->setX(10); // Ajusta el valor según tu necesidad para mover a la izquierda
        // ID del marca
        $pdf->cell(50, 10, $marca['id_marca'], 1, 0, 'C');

        // Nombre
        $pdf->cell(140, 10, $pdf->encodeString($marca['nombre']), 1, 1, 'L'); // Cambiado a 140 y con salto de línea
    }
} else {
    // Si no hay marcas registrados
    $pdf->cell(190, 10, $pdf->encodeString('No hay marcas registrados'), 1, 1, 'C'); // Cambiado el ancho y con salto de línea
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'marcas.pdf');
?>

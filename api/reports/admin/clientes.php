<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para el acceso a datos de clientes.
require_once('../../models/data/cliente_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Clientes Registrados');
// Se instancia el modelo Cliente para obtener los datos.
$clienteModel = new ClienteData;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataClientes = $clienteModel->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(193, 218, 243);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(40, 10, 'ID', 1, 0, 'C', 1);
    $pdf->cell(50, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(50, 10, 'Apellido', 1, 0, 'C', 1);
    $pdf->cell(50, 10, 'Correo', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'DUI', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar los datos de los clientes.
    $pdf->setFillColor(255, 255, 255);
    // Se establece la fuente para los datos de los clientes.
    $pdf->setFont('Arial', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataClientes as $cliente) {
        // Se imprimen las celdas con los datos de los clientes.
        $pdf->cell(40, 10, $cliente['id_cliente'], 1, 0, 'C', 1);
        $pdf->cell(50, 10, $pdf->encodeString($cliente['nombre_cliente']), 1, 0, 'C', 1);
        $pdf->cell(50, 10, $pdf->encodeString($cliente['apellido_cliente']), 1, 0, 'C', 1);
        $pdf->cell(50, 10, $cliente['correo_cliente'], 1, 0, 'C', 1);
        $pdf->cell(30, 10, $cliente['dui_cliente'], 1, 1, 'C', 1);
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay clientes registrados'), 1, 1);
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'clientes.pdf');

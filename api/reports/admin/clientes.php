<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para el acceso a datos de clientes.
require_once('../../models/data/cliente_data.php');

function getUser() {
    return isset($_SESSION['aliasAdministrador']) ? $_SESSION['aliasAdministrador'] : null;
}

// Se instancia la clase para crear el reporte.
$pdf = new Report('P', 'mm', 'Letter'); // Tamaño del papel Letter (216 x 279 mm)

// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Clientes Registrados');

// Movemos toda la tabla un poco a la izquierda
$pdf->setX(10); // Ajusta el valor según tu necesidad para mover a la izquierda

// Se instancia el modelo Cliente para obtener los datos.
$clienteModel = new ClienteData;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataClientes = $clienteModel->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(193, 218, 243);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);

    // Encabezados
    $pdf->cell(10, 10, 'ID', 1, 0, 'C', 1);
    $pdf->cell(50, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(50, 10, 'Apellido', 1, 0, 'C', 1);
    $pdf->cell(60, 10, 'Correo', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'DUI', 1, 1, 'C', 1);

    // Se establece la fuente para los datos de los clientes.
    $pdf->setFont('Arial', '', 11);
    $pdf->setX(10);

    // Recorremos los datos de los clientes
    foreach ($dataClientes as $cliente) {
        // ID del cliente
        $pdf->cell(10, 10, $cliente['id_cliente'], 1, 0, 'C');

        // Nombre
        $pdf->cell(50, 10, $pdf->encodeString($cliente['nombre_cliente']), 1, 0, 'C');

        // Apellido
        $pdf->cell(50, 10, $pdf->encodeString($cliente['apellido_cliente']), 1, 0, 'C');

        // Correo
        $pdf->cell(60, 10, $cliente['correo_cliente'], 1, 0, 'C');

        // DUI del cliente
        $pdf->cell(30, 10, $cliente['dui_cliente'], 1, 1, 'C');
    }
} else {
    // Si no hay clientes registrados
    $pdf->cell(200, 10, $pdf->encodeString('No hay clientes registrados'), 1, 1, 'C');
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'clientes.pdf');
?>

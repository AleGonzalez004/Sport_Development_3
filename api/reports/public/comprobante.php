<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/comprobante.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/order_data.php');
require_once('../../models/handler/order_handler.php');
require_once('../../models/data/producto_data.php');
require_once('../../models/data/categoria_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Comprobante de compra');

// Se instancia el modelo Pedido para obtener los datos.
$pedido = new PedidoData('localhost', 'sport', 'root', '');
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataPedidos = $pedido->readByClientAndStatus($_SESSION['idCliente'], 'EnCamino')) {
    foreach ($dataPedidos as $rowPedido) {
        // Información del cliente
        $pdf->setFont('Arial', 'B', 10);
        $pdf->cell(0, 20, $pdf->encodeString('ID de Pedido: ' . $rowPedido['id_pedido']), 0, 1);
        $pdf->ln(2);
        
        $pdf->setFont('Arial', '', 11);
        // Primera fila de datos
        $pdf->cell(30, 8, $pdf->encodeString('Nombre:'), 0, 0);
        $pdf->cell(60, 8, $pdf->encodeString($rowPedido['nombre_cliente'] . ' ' . $rowPedido['apellido_cliente']), 0, 0);
        $pdf->cell(30, 8, $pdf->encodeString('Teléfono:'), 0, 0);
        $pdf->cell(70, 8, $pdf->encodeString($rowPedido['telefono_cliente']), 0, 1);
        
        // Segunda fila de datos
        $pdf->cell(30, 8, $pdf->encodeString('Dirección:'), 0, 0);
        $pdf->cell(60, 8, $pdf->encodeString($rowPedido['direccion_cliente']), 0, 0);
        $pdf->cell(30, 8, $pdf->encodeString('DUI:'), 0, 0);
        $pdf->cell(70, 8, $pdf->encodeString($rowPedido['dui_cliente']), 0, 1);
        
        // Tercera fila de datos
        $pdf->cell(90, 8, $pdf->encodeString('Fecha de Registro:'), 0, 0);
        $pdf->cell(60, 8, $pdf->encodeString($rowPedido['fecha_registro']), 0, 1);
        $pdf->ln(5);

        // Se establece la fuente para los encabezados de los productos.
        $pdf->setFont('Arial', 'B', 11);
        $pdf->setFillColor(36, 92, 157);
        $pdf->setTextColor(255, 255, 255);
        $pdf->cell(126, 10, 'Producto', 0, 0, 'C', 1);
        $pdf->cell(30, 10, 'Cantidad', 0, 0, 'C', 1);
        $pdf->cell(30, 10, 'Precio (US$)', 0, 1, 'C', 1);
        
        // Se instancia el modelo DetallePedido para procesar los datos.
        $detallePedido = new DetallePedidoData('localhost', 'sport', 'root', '');
        // Se establece el pedido para obtener sus detalles, de lo contrario se imprime un mensaje de error.
        if ($detallePedido->setPedido($rowPedido['id_pedido'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataDetalles = $detallePedido->readByPedido()) {
                // Se recorren los registros fila por fila.
                $pdf->setFont('Arial', '', 11);
                $pdf->setFillColor(240, 240, 240);
                $pdf->setTextColor(0, 0, 0);
                $fill = false;
                $total = 0; // Inicializamos el total
                foreach ($dataDetalles as $rowDetalle) {
                    $pdf->cell(126, 10, $pdf->encodeString($rowDetalle['nombre_producto']), 0, 0, '', $fill);
                    $pdf->cell(30, 10, $rowDetalle['cantidad_producto'], 0, 0, 'C', $fill);
                    $pdf->cell(30, 10, number_format($rowDetalle['precio_producto'], 2, '.', ''), 0, 1, 'R', $fill);
                    $total += $rowDetalle['cantidad_producto'] * $rowDetalle['precio_producto']; // Calculamos el total
                    $fill = !$fill;
                }
                // Mostrar el total
                $pdf->setFont('Arial', 'B', 11);
                $pdf->cell(156, 10, 'Total', 0, 0, 'R');
                $pdf->cell(30, 10, number_format($total, 2, '.', ''), 0, 1, 'R');
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para el pedido'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Pedido incorrecto o inexistente'), 1, 1);
        }

        // Salto de línea después de cada pedido
        $pdf->ln(10);
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay pedidos en camino para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Comprobante.pdf');
?>

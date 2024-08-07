<?php
// Se incluye la clase del modelo.
require_once ('../../models/data/producto_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se instancia la clase correspondiente.
    $producto = new ProductoData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null);
    // Se compara la acción a realizar según la petición del controlador.
    switch ($_GET['action']) {
        case 'readProductosCategoria':
            if (!$producto->setCategoria($_POST['idCategoria'])) {
                $result['error'] = $producto->getDataError();
            } elseif ($result['dataset'] = $producto->readProductosCategoria()) {
                $result['status'] = 1;
            } else {
                $result['error'] = 'No existen productos para mostrar';
            }
            break;
        case 'readOne':
            if (!$producto->setId($_POST['idProducto'])) {
                $result['error'] = $producto->getDataError();
            } elseif ($result['dataset'] = $producto->readOne()) {
                $result['status'] = 1;
            } else {
                $result['error'] = 'Producto inexistente';
            }
            break;
        case 'readComments':
            // Se encarga de leer los comentarios de un producto específico
            if (!$producto->setId($_POST['idProducto'])) {
                $result['error'] = $producto->getDataError();
            } elseif ($result['dataset'] = $producto->readComments()) {
                $result['status'] = 1;
            } else {
                $result['error'] = 'No se encontraron comentarios para este producto';
            }
            break;
        case 'addComment':
            // Se encarga de agregar un comentario a un producto específico
            if (!isset($_POST['idProducto'], $_POST['calificacion'], $_POST['comentario_producto'])) {
                $result['error'] = 'Faltan datos para agregar el comentario';
            } elseif ($producto->addComments($_POST['idProducto'], $_POST['calificacion'], $_POST['comentario_producto'])) {
                $result['status'] = 1;
                $result['message'] = 'Comentario agregado exitosamente';
            } else {
                $result['error'] = 'No se pudo agregar el comentario';
            }
            break;
        default:
            $result['error'] = 'Acción no disponible';
    }
    // Se obtiene la excepción del servidor de base de datos por si ocurrió un problema.
    $result['exception'] = Database::getException();
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('Content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}

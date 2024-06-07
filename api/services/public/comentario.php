<?php
// Se incluye la clase del handler de comentarios.
require_once('../../handlers/comentario_handler.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $comentario = new ComentarioHandler;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'error' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['idCliente'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$comentario->setIdProducto($_POST['idProducto']) or
                    !$comentario->setComentario($_POST['comentario'])
                ) {
                    $result['error'] = $comentario->getDataError();
                } elseif ($comentario->create()) {
                    $result['status'] = 1;
                    $result['message'] = 'Comentario enviado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al enviar el comentario';
                }
                break;
            case 'read':
                if (!$comentario->setIdProducto($_POST['idProducto'])) {
                    $result['error'] = $comentario->getDataError();
                } elseif ($result['dataset'] = $comentario->read()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'No existen comentarios para este producto';
                }
                break;
            default:
                $result['error'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando un cliente no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'create':
                $result['error'] = 'Debe iniciar sesión para enviar un comentario';
                break;
            default:
                $result['error'] = 'Acción no disponible fuera de la sesión';
        }
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
<?php
// Se incluye la clase para trabajar con la base de datos.
require_once ('../../helpers/database.php');
/*
 *	Clase para manejar el comportamiento de los datos de las tablas PEDIDO y DETALLE_PEDIDO.
 */
class HistorialHandler
{
    /*
     *   Declaración de atributos para el manejo de datos.
     */
    protected $id_pedido = null;
    protected $id_detalle = null;
    protected $cliente = null;
    protected $producto = null;
    protected $cantidad = null;
    protected $estado = null;

    public function getOrder()
{
    // Selecciona todos los pedidos del cliente que estén en estado 'entregado'
    $sql = 'SELECT * FROM tb_pedidos WHERE id_cliente = ? AND estado = ?';
    $params = array($_SESSION['idCliente'], 'entregado');

    // Ejecuta la consulta y obtiene todos los registros
    $data = Database::getRows($sql, $params);

    // Comprobar si se encontraron datos
    if ($data) {
        // Almacena los IDs de todos los pedidos en la sesión
        $_SESSION['idPedidos'] = array_column($data, 'id_pedido');
        return $data; // Retorna todos los datos obtenidos
    } else {
        return false; // Retorna false si no se encontraron pedidos
    }
}


    // Método para obtener los productos que se encuentran en el carrito de compras.
    public function readDetail()
{
    // Asegúrate de que $_SESSION['idPedidos'] sea un array de enteros y que esté definido
    if (!isset($_SESSION['idPedidos']) || !is_array($_SESSION['idPedidos'])) {
        return []; // O maneja el caso de error como corresponda
    }
    
    // Crea una lista de parámetros con todos los IDs de pedidos, asegurándote de que sean números enteros para evitar SQL Injection
    $ids = implode(',', array_map('intval', $_SESSION['idPedidos']));
    
    // Modifica la consulta para manejar múltiples IDs
    $sql = 'SELECT id_detalle, nombre_producto, tb_detalle_pedidos.precio_producto, tb_detalle_pedidos.cantidad_producto
            FROM tb_detalle_pedidos
            INNER JOIN tb_pedidos ON tb_detalle_pedidos.id_pedido = tb_pedidos.id_pedido
            INNER JOIN tb_productos ON tb_detalle_pedidos.id_producto = tb_productos.id_producto
            WHERE tb_detalle_pedidos.id_pedido IN (' . $ids . ')';
    
    return Database::getRows($sql);
}


}

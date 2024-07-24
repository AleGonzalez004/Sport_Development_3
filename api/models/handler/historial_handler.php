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
        $this->estado = 'Entregado';
        $sql = 'SELECT id_pedido
                FROM tb_pedidos
                WHERE estado_pedido = ? AND id_cliente = ?';
        $params = array($this->estado, $_SESSION['idCliente']);
        if ($data = Database::getRow($sql, $params)) {
            $_SESSION['idPedido'] = $data['id_pedido'];
            return true;
        } else {
            return false;
        }
    }

    // Método para iniciar un pedido en proceso.
    public function startOrder()
    {
        if ($this->getOrder()) {
            return true;
        } else {
            $sql = 'INSERT INTO tb_pedidos(direccion_pedido, id_cliente)
                    VALUES((SELECT direccion_cliente FROM tb_clientes WHERE id_cliente = ?), ?)';
            $params = array($_SESSION['idCliente'], $_SESSION['idCliente']);
            // Se obtiene el ultimo valor insertado de la llave primaria en la tabla pedido.
            if ($_SESSION['idPedido'] = Database::getLastRow($sql, $params)) {
                return true;
            } else {
                return false;
            }
        }
    }

    // Método para agregar un producto al carrito de compras.
    public function createDetail()
    {
        // Se realiza una subconsulta para obtener el precio del producto.
        $sql = 'INSERT INTO tb_detalle_pedidos(id_producto, precio_producto, cantidad_producto, id_pedido)
                VALUES(?, (SELECT precio_producto FROM tb_productos WHERE id_producto = ?), ?, ?)';
        $params = array($this->producto, $this->producto, $this->cantidad, $_SESSION['idPedido']);
        return Database::executeRow($sql, $params);
    }

    // Método para obtener los productos que se encuentran en el carrito de compras.
    public function readDetail()
{
    $sql = 'SELECT id_detalle, nombre_producto, tb_detalle_pedidos.precio_producto, tb_detalle_pedidos.cantidad_producto, tb_pedidos.fecha_registro
            FROM tb_detalle_pedidos
            INNER JOIN tb_pedidos USING(id_pedido)
            INNER JOIN tb_productos USING(id_producto)
            WHERE tb_pedidos.id_cliente = ?
            ORDER BY tb_pedidos.fecha_registro DESC';
    $params = array($_SESSION['idCliente']); // Cambia esto según la lógica de tu sesión
    return Database::getRows($sql, $params);
}


    // Método para finalizar un pedido por parte del cliente.
    public function finishOrder()
    {
        $this->estado = 'Entregado';
    $sql = 'UPDATE tb_pedidos
            SET estado_pedido = ?
            WHERE id_pedido = ?';
    $params = array($this->estado, $_SESSION['idPedido']);

    if (Database::executeRow($sql, $params)) {
        // Si la actualización del estado del pedido es exitosa, proceder a actualizar las existencias de los productos.
        
        // Seleccionar todos los detalles de pedidos para el pedido finalizado.
        $sql = 'SELECT id_producto, cantidad_producto
                FROM tb_detalle_pedidos
                WHERE id_pedido = ?';
        $params = array($_SESSION['idPedido']);

        // Obtener todos los detalles del pedido finalizado.
        $result = Database::getRows($sql, $params);

        if ($result) {
            // Recorrer cada detalle de pedido y actualizar las existencias del producto.
            foreach ($result as $row) {
                $sql = 'UPDATE tb_productos
                        SET existencias_producto = existencias_producto - ?
                        WHERE id_producto = ?';
                $params = array($row['cantidad_producto'], $row['id_producto']);
                Database::executeRow($sql, $params);
            }
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
    }

    // Método para actualizar la cantidad de un producto agregado al carrito de compras.
    public function updateDetail()
    {
        $sql = 'UPDATE tb_detalle_pedidos
                SET cantidad_producto = ?
                WHERE id_detalle = ? AND id_pedido = ?';
        $params = array($this->cantidad, $this->id_detalle, $_SESSION['idPedido']);
        return Database::executeRow($sql, $params);
    }

    // Método para eliminar un producto que se encuentra en el carrito de compras.
    public function deleteDetail()
    {
        $sql = 'DELETE FROM tb_detalle_pedidos
                WHERE id_detalle = ? AND id_pedido = ?';
        $params = array($this->id_detalle, $_SESSION['idPedido']);
        return Database::executeRow($sql, $params);
    }
    public function deleteOrder()
{
    $sql = 'UPDATE tb_pedidos
            SET estado_pedido = ?
            WHERE estado_pedido = ?';
    $params = array('Historial', 'Entregado');
    return Database::executeRow($sql, $params);
}

}
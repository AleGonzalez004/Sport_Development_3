<?php
// Se incluye la clase principal.
require_once ('../../models/data/database.php');

class CalificacionData extends Database
{
    private $idProducto;
    private $calificacion;

    public function setIdProducto($value)
    {
        if (Validator::validateId($value)) {
            $this->idProducto = $value;
            return true;
        } else {
            $this->error = 'El id del producto no es válido';
            return false;
        }
    }

    public function setCalificacion($value)
    {
        if (Validator::validateEnum($value, array('1', '2', '3', '4', '5'))) {
            $this->calificacion = $value;
            return true;
        } else {
            $this->error = 'La calificación no cumple con las restricciones';
            return false;
        }
    }

    public function create()
    {
        $sql = 'INSERT INTO tb_detalle_pedidos (id_producto, calificacion_producto) VALUES (?, ?)';
        $params = array($this->idProducto, $this->calificacion);
        return $this->executeQuery($sql, $params);
    }

    public function read()
    {
        $sql = 'SELECT calificacion_producto FROM tb_detalle_pedidos WHERE id_producto = ?';
        $params = array($this->idProducto);
        return $this->getRows($sql, $params);
    }
}
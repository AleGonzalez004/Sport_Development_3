<?php
// Se incluye la clase principal.
require_once('../../models/data/database.php');

class ComentarioData extends Database
{
    private $idProducto;
    private $comentario;

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

    public function setComentario($value)
    {
        if (Validator::validateString($value, 1, 255)) {
            $this->comentario = $value;
            return true;
        } else {
            $this->error = 'El comentario no cumple con las restricciones';
            return false;
        }
    }

    public function create()
    {
        $sql = 'INSERT INTO tb_detalle_pedidos (id_producto, comentario_producto, estado_comentario) VALUES (?, ?, 1)';
        $params = array($this->idProducto, $this->comentario);
        return $this->executeQuery($sql, $params);
    }

    public function read()
    {
        $sql = 'SELECT comentario_producto FROM tb_detalle_pedidos WHERE id_producto = ? AND estado_comentario = 1';
        $params = array($this->idProducto);
        return $this->getRows($sql, $params);
    }
}
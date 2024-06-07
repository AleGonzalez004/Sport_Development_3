<?php
// Se incluye la clase del modelo de datos.
require_once('../../models/data/comentario_data.php');

class ComentarioHandler
{
    private $idProducto;
    private $comentario;

    public function setIdProducto($value)
    {
        if (Validator::validateId($value)) {
            $this->idProducto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setComentario($value)
    {
        if (Validator::validateString($value, 1, 500)) {
            $this->comentario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function create()
    {
        $comentario = new ComentarioData;
        $comentario->setIdProducto($this->idProducto);
        $comentario->setComentario($this->comentario);
        return $comentario->create();
    }

    public function read()
    {
        $comentario = new ComentarioData;
        $comentario->setIdProducto($this->idProducto);
        return $comentario->read();
    }
}
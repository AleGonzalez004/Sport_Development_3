<?php
// Se incluye la clase del modelo de datos.
require_once ('../../models/data/calificacion_data.php');

class CalificacionHandler
{
    private $idProducto;
    private $calificacion;

    public function setIdProducto($value)
    {
        if (Validator::validateId($value)) {
            $this->idProducto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCalificacion($value)
    {
        if (Validator::validateNumeric($value, 1, 5)) {
            $this->calificacion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function create()
    {
        $calificacion = new CalificacionData;
        $calificacion->setIdProducto($this->idProducto);
        $calificacion->setCalificacion($this->calificacion);
        return $calificacion->create();
    }

    public function read()
    {
        $calificacion = new CalificacionData;
        $calificacion->setIdProducto($this->idProducto);
        return $calificacion->read();
    }
}
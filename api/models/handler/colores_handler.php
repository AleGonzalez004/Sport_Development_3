<?php
// Se incluye la clase para trabajar con la base de datos.
require_once ('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla administrador.
 */
class ColoresHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $nombre = null;
    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */

    //Este sirve para buscar los registros por medio del buscador que se encuentra en la parte de arriba de la tabla
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_color, nombre
                FROM tb_colores
                WHERE nombre LIKE ?
                ORDER BY nombre';
        $params = array($value);
        return Database::getRows($sql, $params);
    }


    // Este CreateRow funciona para crear nuevos registros dentro de la base de datos y web
    public function createRow()
    {
        $sql = 'INSERT INTO tb_colores(nombre)
                VALUES(?)';
        $params = array($this->nombre);
        return Database::executeRow($sql, $params);
    }
    //Llamar los datos de la base de datos 
    public function readAll()
    {
        $sql = 'SELECT id_color, nombre
            FROM tb_colores';
        return Database::getRows($sql);
    }

    //Este ReadOne funcióna para cargar los datos dentro de los campos del modal
    public function readOne()
    {
        $sql = 'SELECT id_color, nombre
            FROM tb_colores
            WHERE id_color = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    // Este UpdateRow funciona para actualizar el los campos o el campo dentro de la base de datos y web
    public function updateRow()
    {
        $sql = 'UPDATE tb_colores
                SET nombre = ?
                WHERE id_color = ?';
        $params = array($this->nombre, $this->id);
        return Database::executeRow($sql, $params);
    }


    //Este deleteRow funciona para eliminar el registro dentro de la base de datos y web por medio del id que identifica al registro
    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_colores
                WHERE id_color = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
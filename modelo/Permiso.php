<?php
#incluimos la conexion  a la base de datos
require '../config/conexion.php';

class Permiso
{
    public function __construct()
    {

    }

    #metodo para listar todas la categorias
    public function listar()
    {
        $sql = "SELECT * FROM permiso";
        return ejecutarConsulta($sql);
    }
}
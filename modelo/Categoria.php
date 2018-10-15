<?php
#incluimos la conexion  a la base de datos
require '../config/conexion.php';

class Categoria
{
    public function __construct()
    {

    }

    #insertar
    public function insertar($nombre, $descripcion)
    {
        $sql = "INSERT INTO categoria (nombre, descripcion) VALUES('$nombre', '$descripcion')";
        return ejecutarConsulta($sql);
    }

    #editar
    public function editar($idcategoria, $nombre, $descripcion)
    {
        $sql = "UPDATE categoria SET nombre='$nombre', descripcion='$descripcion' 
                WHERE idcategoria='$idcategoria'";
        return ejecutarConsulta($sql);
    }

    #desactivar
    public function desactivar($idcategoria)
    {
        $sql = "UPDATE categoria SET condicion='0' WHERE idcategoria='$idcategoria'";
        return ejecutarConsulta($sql);
    }

    #activar
    public function activar($idcategoria)
    {
        $sql = "UPDATE categoria SET condicion='1' WHERE idcategoria='$idcategoria'";
        return ejecutarConsulta($sql);
    }

    #metodo para mostrar los datos a modificar
    public function mostrar($idcategoria)
    {
        $sql = "SELECT * FROM categoria WHERE idcategoria = '$idcategoria'";
        return ejecutarConsultaSimpleFila($sql);
    }

    #metodo para listar todas la categorias
    public function listar()
    {
        $sql = "SELECT * FROM categoria";
        return ejecutarConsulta($sql);
    }

    #metodo para select
    public function select()
    {
        $sql = "SELECT * FROM categoria WHERE condicion='1'";
        return ejecutarConsulta($sql);
    }

}
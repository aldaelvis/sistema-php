<?php
#incluimos la conexion  a la base de datos
require '../config/conexion.php';

class Articulo
{
    public function __construct()
    {

    }

    #insertar
    public function insertar($idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen)
    {
        $sql = "INSERT INTO articulo (idcategoria,codigo,nombre,stock, descripcion, imagen) 
        VALUES('$idcategoria','$codigo','$nombre','$stock', '$descripcion','$imagen')";
        return ejecutarConsulta($sql);
    }

    #editar
    public function editar($idarticulo, $idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen)
    {
        $sql = "UPDATE articulo SET idcategoria='$idcategoria', codigo='$codigo',nombre='$nombre', stock='$stock', descripcion='$descripcion', imagen='$imagen' 
                WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);
    }

    #desactivar
    public function desactivar($idarticulo)
    {
        $sql = "UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);
    }

    #activar
    public function activar($idarticulo)
    {
        $sql = "UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);
    }

    #metodo para mostrar los datos a modificar
    public function mostrar($idarticulo)
    {
        $sql = "SELECT * FROM articulo WHERE idarticulo = '$idarticulo'";
        return ejecutarConsultaSimpleFila($sql);
    }

    #metodo para listar todas la articulos
    public function listar()
    {
        $sql = "SELECT a.idarticulo,a.idcategoria,c.nombre as Categoria, a.nombre,  
        a.codigo, a.stock, a.descripcion, a.imagen, a.condicion 
        FROM articulo a INNER JOIN categoria c ON a.idcategoria = c.idcategoria";
        return ejecutarConsulta($sql);
    }

    #metodo para listar todas la articulos Activos
    public function listarActivos()
    {
        $sql = "SELECT a.idarticulo,a.idcategoria,c.nombre as Categoria, a.nombre,  
        a.codigo, a.stock, a.descripcion, a.imagen, a.condicion 
        FROM articulo a INNER JOIN categoria c ON a.idcategoria = c.idcategoria WHERE a.condicion='1' ";
        return ejecutarConsulta($sql);
    }

    #metodo para listar los articulos activos, su ultimo precio y stock(registrados en la tabla ingreso)
    public function listarActivosVenta()
    {
        $sql = "SELECT a.idarticulo, a.idcategoria,c.nombre as Categoria, a.codigo,a.nombre, a.stock,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo ORDER BY iddetalle_ingreso DESC LIMIT 0,1) AS precio_venta,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1' ";
        return ejecutarConsulta($sql);
    }

}
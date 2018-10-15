<?php
#incluimos la conexion  a la base de datos
require '../config/conexion.php';

class Ingreso
{
    public function __construct()
    {

    }

    #insertar
    public function insertar($idproveedor, $idusuario, $tipo_comprobante, $serie_comprobante,
        $num_comprobante, $fecha_hora, $impuesto, $total_compra, $idarticulo, $cantidad,
        $precio_compra, $precio_venta)
    {
        $sql = "INSERT INTO ingreso(idproveedor, idusuario,tipo_comprobante,serie_comprobante,
                num_comprobante,fecha_hora,impuesto,total_compra,estado)
                VALUES('$idproveedor', '$idusuario', '$tipo_comprobante', '$serie_comprobante',
                '$num_comprobante', '$fecha_hora', '$impuesto','$total_compra','Aceptado')";
        //retornar la llave ingresada
        $idingresonew = ejecutarConsulta_retornarId($sql);
        $num_elementos = 0;
        $sw = true;
        while ($num_elementos < count($idarticulo)) {

            $sql_detalle = "INSERT INTO detalle_ingreso(idingreso, idarticulo, cantidad, precio_compra, precio_venta) VALUES('$idingresonew', '$idarticulo[$num_elementos]', '$cantidad[$num_elementos]', '$precio_compra[$num_elementos]', '$precio_venta[$num_elementos]')";

            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos++;
        }

        return $sw;
    }

    #desactivar
    public function anular($idingreso)
    {
        $sql = "UPDATE ingreso SET estado='Anulado' WHERE idingreso='$idingreso'";
        return ejecutarConsulta($sql);
    }

    #metodo para mostrar los datos a modificar
    public function mostrar($idingreso)
    {
        $sql = "SELECT i.idingreso, DATE(i.fecha_hora) as Fecha, i.idproveedor, p.nombre as Proveedor, u.idusuario, u.nombre as Usuario, i.tipo_comprobante, i.serie_comprobante, i.num_comprobante, i.total_compra, i.impuesto, i.estado FROM ingreso as i INNER JOIN persona p ON i.idproveedor = p.idpersona INNER JOIN usuario u ON i.idusuario = u.idusuario WHERE idingreso = '$idingreso' ";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listadoDetalle($idingreso)
    {
        $sql = "SELECT di.idingreso, di.idarticulo, a.nombre, di.cantidad,di.precio_compra,di.precio_venta FROM detalle_ingreso di INNER JOIN articulo a ON di.idarticulo=a.idarticulo WHERE di.idingreso='$idingreso'";
        return ejecutarConsulta($sql);
    }

    #metodo para listar todas la categorias
    public function listar()
    {
        $sql = "SELECT i.idingreso, DATE(i.fecha_hora) as Fecha, i.idproveedor, p.nombre as Proveedor, u.idusuario, u.nombre as Usuario, i.tipo_comprobante, i.serie_comprobante, i.num_comprobante, i.total_compra, i.impuesto, i.estado FROM ingreso as i INNER JOIN persona p ON i.idproveedor = p.idpersona INNER JOIN usuario u ON i.idusuario = u.idusuario";
        return ejecutarConsulta($sql);
    }

}

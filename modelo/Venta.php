<?php
#incluimos la conexion  a la base de datos
require '../config/conexion.php';

class Venta
{
    public function __construct()
    {

    }

    #insertar
    public function insertar($idcliente, $idusuario, $tipo_comprobante, $serie_comprobante,
        $num_comprobante, $fecha_hora, $impuesto, $total_venta, $idarticulo, $cantidad,
        $precio_venta,$descuento)
    {
        $sql = "INSERT INTO venta(idcliente, idusuario,tipo_comprobante,serie_comprobante,
                num_comprobante,fecha_hora,impuesto,total_venta,estado)
                VALUES('$idcliente', '$idusuario', '$tipo_comprobante', '$serie_comprobante',
                '$num_comprobante', '$fecha_hora', '$impuesto','$total_venta','Cancelado')";
        //retornar la llave ingresada
        $idventanew = ejecutarConsulta_retornarId($sql);
        $num_elementos = 0;
        $sw = true;
        while ($num_elementos < count($idarticulo)) {

            $sql_detalle = "INSERT INTO detalle_venta(idventa, idarticulo, cantidad, precio_venta, descuento) VALUES('$idventanew', '$idarticulo[$num_elementos]', '$cantidad[$num_elementos]', '$precio_venta[$num_elementos]', '$descuento[$num_elementos]')";

            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos++;
        }

        return $sw;
    }

    #desactivar
    public function anular($idventa)
    {
        $sql = "UPDATE venta SET estado='Anulado' WHERE idventa='$idventa'";
        return ejecutarConsulta($sql);
    }

    #metodo para mostrar los datos a modificar
    public function mostrar($idventa)
    {
        $sql = "SELECT v.idventa, DATE(v.fecha_hora) as Fecha, v.idcliente, p.nombre as Cliente, u.idusuario, u.nombre as Usuario, v.tipo_comprobante, v.serie_comprobante, v.num_comprobante, v.total_venta, v.impuesto, v.estado FROM venta as v INNER JOIN persona p ON v.idcliente = p.idpersona INNER JOIN usuario u ON v.idusuario = u.idusuario WHERE v.idventa = '$idventa' ";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listadoDetalle($idventa)
    {
        $sql = "SELECT dv.idventa, dv.idarticulo, a.nombre, dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad* dv.precio_venta - dv.descuento) AS Subtotal FROM detalle_Venta dv INNER JOIN articulo a ON dv.idarticulo=a.idarticulo WHERE dv.idventa='$idventa'";
        return ejecutarConsulta($sql);
    }

    #metodo para listar todas la categorias
    public function listar()
    {
        $sql = "SELECT v.idventa, DATE(v.fecha_hora) as Fecha, v.idcliente, p.nombre as Cliente, u.idusuario, u.nombre as Usuario, v.tipo_comprobante, v.serie_comprobante, v.num_comprobante, v.total_venta, v.impuesto, v.estado FROM venta as v INNER JOIN persona p ON v.idcliente = p.idpersona INNER JOIN usuario u ON v.idusuario = u.idusuario";
        return ejecutarConsulta($sql);
    }

}

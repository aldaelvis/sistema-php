<?php
#incluimos la conexion  a la base de datos
require '../config/conexion.php';

class Consultas
{
    public function __construct()
    {

    }

    public function comprasFechas($fecha_inicio, $fecha_fin)
    {
        $sql = "SELECT DATE(i.fecha_hora) as Fecha, u.nombre as Usuario, 
        p.nombre as Proveedor,i.tipo_comprobante,i.serie_comprobante, i.num_comprobante,
        i.total_compra,i.impuesto,
        i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor = p.idpersona 
        INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE DATE(i.fecha_hora) >= 
        '$fecha_inicio' AND DATE(i.fecha_hora)<= '$fecha_fin' ";

        return ejecutarConsulta($sql);
    } 
    
    public function totalCompraHoy()
    {
        $sql = "SELECT IFNULL(SUM(total_compra),0) as total_compra 
        FROM ingreso WHERE DATE(fecha_hora) = curdate()";
        return ejecutarConsulta($sql);
    }

    public function totalVentaHoy()
    {
        $sql = "SELECT IFNULL(SUM(total_venta),0) as total_venta 
        FROM venta WHERE DATE(fecha_hora) = curdate()";
        return ejecutarConsulta($sql);
    }

    public function compraultimos_10dias()
    {
        $sql = "SELECT CONCAT(DAY(fecha_hora),'-',MONTH(fecha_hora)) AS fecha, SUM(total_compra) AS total FROM ingreso GROUP BY fecha_hora ORDER BY fecha_hora DESC LIMIT 0,10 ";
        return ejecutarConsulta($sql);
    }

    public function ventas_12meses()
    {
        $sql = "SELECT DATE_FORMAT(fecha_hora, '%M') AS fecha, SUM(total_venta) AS total FROM
        venta GROUP BY month(fecha_hora) ORDER BY fecha_hora DESC LIMIT 0,12 ";
        return ejecutarConsulta($sql);
    }

}
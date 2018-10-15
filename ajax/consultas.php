<?php
require_once '../modelo/Consultas.php';

$consultas = new Consultas();


switch($_GET['op'])
{
    case 'listar':
        $fecha_inicio = $_REQUEST["fecha_inicio"];
        $fecha_fin = $_REQUEST["fecha_fin"];
        $rpta = $consultas->comprasFechas($fecha_inicio, $fecha_fin);
        $data = Array();
        while ( $reg = $rpta->fetch_object())
        {
            $data[] = array(
                "0" => $reg->Fecha,
                "1" => $reg->Usuario,
                "2" => $reg->Proveedor,
                "3" => $reg->tipo_comprobante,
                "4" => $reg->serie_comprobante . ' ' . $reg->num_comprobante,
                "5" => $reg->total_compra,
                "6" => $reg->impuesto,
                "7" => ($reg->estado == 'Aceptado') ? '<span class="label bg-green">Aceptado</span>'
                    : '<span class="label bg-red">Anulado</span>',
            );
        }
        $result = array(
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data
        );
        echo json_encode($result);
        break;
        
}
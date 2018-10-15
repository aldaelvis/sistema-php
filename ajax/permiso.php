<?php
require_once '../modelo/Permiso.php';

$permiso = new Permiso();

switch($_GET['op'])
{
    case 'listar':
        $rpta = $permiso->listar();
        $data = Array();
        while ( $reg = $rpta->fetch_object())
        {
            $data[] = array(
                "0" => $reg->nombre,
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
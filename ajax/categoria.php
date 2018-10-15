<?php
require_once '../modelo/Categoria.php';

$categoria = new Categoria();

$idcategoria = isset($_POST['idcategoria']) ? limpiarConsulta($_POST['idcategoria']) : "";
$nombre = isset($_POST['nombre']) ? limpiarConsulta($_POST['nombre']) : "";
$descripcion = isset($_POST['descripcion']) ? limpiarConsulta($_POST['descripcion']) : "";

switch($_GET['op'])
{
    case 'guardaryeditar':
        if(empty($idcategoria)) 
        {
            $rpta = $categoria->insertar($nombre, $descripcion);
            echo $rpta ? "Categoria Registrada" : "Categoria no se pudo registrar";
        } else 
        {
            $rpta = $categoria->editar($idcategoria, $nombre, $descripcion);
            echo $rpta ? "Categoria actualizada" : "Categoria no se pudo actualizar";
        }
        break;
    case 'desactivar':
        $rpta = $categoria->desactivar($idcategoria);
        echo $rpta ? "Categoria desactivada" : "Categoria no se pudo desactivar";
        break;
    case 'activar':
        $rpta = $categoria->activar($idcategoria);
        echo $rpta ? "Categoria activada" : "Categoria no se pudo activar";
        break;
    case 'mostrar':
        $rpta = $categoria->mostrar($idcategoria);
        echo json_encode($rpta);
        break;
    case 'listar':
        $rpta = $categoria->listar();
        $data = Array();
        while ( $reg = $rpta->fetch_object())
        {
            $data[] = array(
                "0" => ($reg->condicion) ?
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idcategoria.')">
                            <i class="fa fa-pencil"></i></button>' .
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->idcategoria.')">
                            <i class="fa fa-close"></i></button>' :
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idcategoria.')">
                            <i class="fa fa-pencil"></i></button>' .
                    ' <button class="btn btn-primary" onclick="activar('.$reg->idcategoria.')">
                            <i class="fa fa-check"></i></button>',
                "1" => $reg->nombre,
                "2" => $reg->descripcion,
                "3" => ($reg->condicion) ? '<span class="label bg-green">Activado</span>'
                    : '<span class="label bg-red">Desactivado</span>',
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
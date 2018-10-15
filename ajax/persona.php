<?php
require_once '../modelo/Persona.php';

$persona = new Persona();

$idpersona = isset($_POST['idpersona']) ? limpiarConsulta($_POST['idpersona']) : "";
$tipo_persona = isset($_POST['tipo_persona']) ? limpiarConsulta($_POST['tipo_persona']) : "";
$nombre = isset($_POST['nombre']) ? limpiarConsulta($_POST['nombre']) : "";
$tipo_documento = isset($_POST['tipo_documento']) ? limpiarConsulta($_POST['tipo_documento']) : "";
$num_documento = isset($_POST['num_documento']) ? limpiarConsulta($_POST['num_documento']) : "";
$direccion = isset($_POST['direccion']) ? limpiarConsulta($_POST['direccion']) : "";
$telefono = isset($_POST['telefono']) ? limpiarConsulta($_POST['telefono']) : "";
$email = isset($_POST['email']) ? limpiarConsulta($_POST['email']) : "";

switch($_GET['op'])
{
    case 'guardaryeditar':
        if(empty($idpersona)) 
        {
            $rpta = $persona->insertar($tipo_persona,$nombre,$tipo_documento,
                $num_documento,$direccion,$telefono,$email);
            echo $rpta ? "Persona Registrada" : "Persona no se pudo registrar";
        } else 
        {
            $rpta = $persona->editar($idpersona,$tipo_persona,$nombre,$tipo_documento,
                $num_documento,$direccion,$telefono,$email);
            echo $rpta ? "Persona actualizada" : "Persona no se pudo actualizar";
        }
        break;
    case 'eliminar':
        $rpta = $persona->eliminar($idpersona);
        echo $rpta ? "Persona Eliminada" : "Persona no se pudo eliminar";
        break;
    case 'mostrar':
        $rpta = $persona->mostrar($idpersona);
        echo json_encode($rpta);
        break;
    case 'listarp':
        $rpta = $persona->listarp();
        $data = Array();
        while ( $reg = $rpta->fetch_object())
        {
            $data[] = array(
                "0" => 
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')">
                            <i class="fa fa-pencil"></i></button>' .
                    ' <button class="btn btn-danger" onclick="eliminar('.$reg->idpersona.')">
                            <i class="fa fa-trash"></i></button>',
                "1" => $reg->nombre,
                "2" => $reg->tipo_documento,
                "3" => $reg->num_documento,
                "4" => $reg->telefono,
                "5" => $reg->email,
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
    case 'listarc':
        $rpta = $persona->listarc();
        $data = Array();
        while ( $reg = $rpta->fetch_object())
        {
            $data[] = array(
                "0" => 
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')">
                            <i class="fa fa-pencil"></i></button>' .
                    ' <button class="btn btn-danger" onclick="eliminar('.$reg->idpersona.')">
                            <i class="fa fa-trash"></i></button>',
                "1" => $reg->nombre,
                "2" => $reg->tipo_documento,
                "3" => $reg->num_documento,
                "4" => $reg->telefono,
                "5" => $reg->email,
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
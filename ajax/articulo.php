<?php
require_once '../modelo/Articulo.php';

$articulo = new Articulo();

$idarticulo = isset($_POST['idarticulo']) ? limpiarConsulta($_POST['idarticulo']) : "";
$idcategoria = isset($_POST['idcategoria']) ? limpiarConsulta($_POST['idcategoria']) : "";
$codigo = isset($_POST['codigo']) ? limpiarConsulta($_POST['codigo']) : "";
$nombre = isset($_POST['nombre']) ? limpiarConsulta($_POST['nombre']) : "";
$stock = isset($_POST['stock']) ? limpiarConsulta($_POST['stock']) : "";
$descripcion = isset($_POST['descripcion']) ? limpiarConsulta($_POST['descripcion']) : "";
$imagen = isset($_POST['imagen']) ? limpiarConsulta($_POST['imagen']) : "";

switch($_GET['op'])
{
    case 'guardaryeditar':
        if(!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
        {
            $imagen = $_POST['imagenactual'];
        } else 
        {
            $ext = explode(".", $_FILES['imagen']['name']);
            if($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" ||
            $_FILES['imagen']['type'] == "image/png")
            {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/articulos/" . $imagen);
            }
                
        }
        if(empty($idarticulo)) 
        {
            $rpta = $articulo->insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
            echo $rpta ? "Articulo Registrado" : "Articulo no se pudo registrar";
        } else 
        {
            $rpta = $articulo->editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
            echo $rpta ? "Articulo actualizado" : "Articulo no se pudo actualizar";
        }
        break;
    case 'desactivar':
        $rpta = $articulo->desactivar($idarticulo);
        echo $rpta ? "Articulo desactivado" : "Articulo no se pudo desactivar";
        break;
    case 'activar':
        $rpta = $articulo->activar($idarticulo);
        echo $rpta ? "Articulo activado" : "Articulo no se pudo activar";
        break;
    case 'mostrar':
        $rpta = $articulo->mostrar($idarticulo);
        echo json_encode($rpta);
        break;
    case 'listar':
        $rpta = $articulo->listar();
        $data = Array();
        while ( $reg = $rpta->fetch_object())
        {
            $data[] = array(
                "0" => ($reg->condicion) ?
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')">
                            <i class="fa fa-pencil"></i></button>' .
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->idarticulo.')">
                            <i class="fa fa-close"></i></button>' :
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')">
                            <i class="fa fa-pencil"></i></button>' .
                    ' <button class="btn btn-primary" onclick="activar('.$reg->idarticulo.')">
                            <i class="fa fa-check"></i></button>',
                "1" => $reg->nombre,
                "2" => $reg->Categoria,
                "3" => $reg->codigo,
                "4" => $reg->stock,
                "5" => "<img src='../files/articulos/".$reg->imagen."' height='50PX' width='50px' />",
                "6" => ($reg->condicion) ? '<span class="label bg-green">Activado</span>'
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
    case 'selectCategoria':
        require_once '../modelo/Categoria.php';
        $categoria = new Categoria();
        $rpta = $categoria->select();
        while($reg=$rpta->fetch_object())
        {
            echo '<option value='.$reg->idcategoria.'>'.$reg->nombre.'</option>';
        } 
        break;
}
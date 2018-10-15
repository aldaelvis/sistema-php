<?php
if(strlen(session_id()) < 1) session_start();
require_once '../modelo/Ingreso.php';

$ingreso = new Ingreso();

$idingreso = isset($_POST['idingreso']) ? limpiarConsulta($_POST['idingreso']) : "";
$idproveedor = isset($_POST['idproveedor']) ? limpiarConsulta($_POST['idproveedor']) : "";
$idusuario = $_SESSION['idusuario'];
$tipo_comprobante = isset($_POST['tipo_comprobante']) ? limpiarConsulta($_POST['tipo_comprobante']) : "";
$serie_comprobante = isset($_POST['serie_comprobante']) ? limpiarConsulta($_POST['serie_comprobante']) : "";
$num_comprobante = isset($_POST['num_comprobante']) ? limpiarConsulta($_POST['num_comprobante']) : "";
$fecha_hora = isset($_POST['fecha_hora']) ? limpiarConsulta($_POST['fecha_hora']) : "";
$impuesto = isset($_POST['impuesto']) ? limpiarConsulta($_POST['impuesto']) : "";
$total_compra = isset($_POST['total_compra']) ? limpiarConsulta($_POST['total_compra']) : "";


switch($_GET['op'])
{
    case 'guardaryeditar':
        if(empty($idingreso)) 
        {
            $rpta = $ingreso->insertar($idproveedor, $idusuario, $tipo_comprobante, $serie_comprobante,
            $num_comprobante, $fecha_hora, $impuesto, $total_compra, $_POST['idarticulo'], $_POST['cantidad'], $_POST['precio_compra'], $_POST['precio_venta']);

            echo $rpta ? "Ingreso Registrada" : "Ingreso no se pudo registrar";
        }
        break;
    case 'anular':
        $rpta = $ingreso->anular($idingreso);
        echo $rpta ? "Ingreso anulado" : "Ingreso no se pudo anular";
        break;
    case 'mostrar':
        $rpta = $ingreso->mostrar($idingreso);
        echo json_encode($rpta);
        break;
    case 'listarDetalle':
        $id = $_GET['id']; 
        $rpta = $ingreso->listadoDetalle($id);
        $total = 0;
        echo '<thead style="background-color: #a9d0f5; " >
            <th>Opciones</th>
            <th>Artículo</th>
            <th>Cantidad</th>
            <th>Precio Compra</th>
            <th>Precio Venta</th>
            <th>SubTotal</th>
        </thead>';
        while($reg = $rpta->fetch_object())
        {
            echo '<tr class="filas">
            <td></td>
            <td>'.$reg->nombre.'</td>
            <td>'.$reg->cantidad.'</td>
            <td>'.$reg->precio_compra.'</td>
            <td>'.$reg->precio_venta.'</td>
            <td>'.$reg->precio_compra * $reg->cantidad.'</td>
            </tr>';
            $total = $total+($reg->precio_compra * $reg->cantidad);
        }
        echo '<tfoot>
            <th>Total</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>
                <h4 id="total">S/. '.$total.'</h4>
                <input type="hidden" name="total_compra" id="total_compra">
            </th>
        </tfoot>';
        break;
    case 'listar':
        $rpta = $ingreso->listar();
        $data = Array();
        while ( $reg = $rpta->fetch_object())
        {
            $data[] = array(
                "0" => ($reg->estado=='Aceptado') ?
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idingreso.')">
                            <i class="fa fa-eye"></i></button>' .
                    ' <button class="btn btn-danger" onclick="anular('.$reg->idingreso.')">
                            <i class="fa fa-close"></i></button>' :
                    '<button class="btn btn-eye" onclick="mostrar('.$reg->idingreso.')">
                            <i class="fa fa-pencil"></i></button>',
                "1" => $reg->Fecha,
                "2" => $reg->Proveedor,
                "3" => $reg->Usuario,
                "4" => $reg->tipo_comprobante,
                "5" => $reg->serie_comprobante . '-' . $reg->num_comprobante,
                "6" => $reg->total_compra,
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
    case 'selectProveedor':
        require_once '../modelo/Persona.php';
        $persona = new Persona();

        $rpta = $persona->listarp();
        while($reg = $rpta->fetch_object())
        {
            echo '<option value='.$reg->idpersona.'>'.$reg->nombre.'</option>';
        }
        break;
    case 'listarArticulos':
        require_once "../modelo/Articulo.php";
        $articulo = new Articulo();
        $rpta = $articulo->listarActivos();
        $data = Array();
        while ( $reg = $rpta->fetch_object())
        {
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\' '.$reg->nombre.'\')"><span class="fa fa-plus"></span></button>',
                "1" => $reg->nombre,
                "2" => $reg->Categoria,
                "3" => $reg->codigo,
                "4" => $reg->stock,
                "5" => "<img src='../files/articulos/".$reg->imagen."' height='50PX' width='50px' />",
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
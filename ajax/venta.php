<?php
if(strlen(session_id()) < 1) session_start();
require_once '../modelo/Venta.php';

$venta = new Venta();

$idventa = isset($_POST['idventa']) ? limpiarConsulta($_POST['idventa']) : "";
$idcliente = isset($_POST['idpersona']) ? limpiarConsulta($_POST['idpersona']) : "";
$idusuario = $_SESSION['idusuario'];
$tipo_comprobante = isset($_POST['tipo_comprobante']) ? limpiarConsulta($_POST['tipo_comprobante']) : "";
$serie_comprobante = isset($_POST['serie_comprobante']) ? limpiarConsulta($_POST['serie_comprobante']) : "";
$num_comprobante = isset($_POST['num_comprobante']) ? limpiarConsulta($_POST['num_comprobante']) : "";
$fecha_hora = isset($_POST['fecha_hora']) ? limpiarConsulta($_POST['fecha_hora']) : "";
$impuesto = isset($_POST['impuesto']) ? limpiarConsulta($_POST['impuesto']) : "";
$total_venta = isset($_POST['total_venta']) ? limpiarConsulta($_POST['total_venta']) : "";


switch($_GET['op'])
{
    case 'guardaryeditar':
        if(empty($idventa)) 
        {
            $rpta = $venta->insertar($idcliente, $idusuario, $tipo_comprobante, $serie_comprobante,
            $num_comprobante, $fecha_hora, $impuesto, $total_venta, $_POST['idarticulo'], $_POST['cantidad'], $_POST['precio_venta'], $_POST['descuento']);

            echo $rpta ? "Venta Registrada" : "Venta no se pudo registrar";
        }
        break;
    case 'anular':
        $rpta = $venta->anular($idventa);
        echo $rpta ? "Venta anulado" : "Venta no se pudo anular";
        break;
    case 'mostrar':
        $rpta = $venta->mostrar($idventa);
        echo json_encode($rpta);
        break;
    case 'listarDetalle':
        $id = $_GET['id']; 
        $rpta = $venta->listadoDetalle($id);
        $total = 0;
        echo '<thead style="background-color: #a9d0f5; " >
            <th>Opciones</th>
            <th>Artículo</th>
            <th>Cantidad</th>
            <th>Precio Venta</th>
            <th>Descuento</th>
            <th>SubTotal</th>
        </thead>';
        while($reg = $rpta->fetch_object())
        {
            echo '<tr class="filas">
            <td></td>
            <td>'.$reg->nombre.'</td>
            <td>'.$reg->cantidad.'</td>
            <td>'.$reg->precio_venta.'</td>
            <td>'.$reg->descuento.'</td>
            <td>'.(($reg->precio_venta * $reg->cantidad) - $reg->descuento).'</td>
            </tr>';
            $total = $total+($reg->precio_venta * $reg->cantidad - $reg->descuento);
        }
        echo '<tfoot>
            <th>Total</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>
                <h4 id="total">S/. '.$total.'</h4>
                <input type="hidden" name="total_venta" id="total_venta">
            </th>
        </tfoot>';
        break;
    case 'listar':
        $rpta = $venta->listar();
        $data = Array();
        while ( $reg = $rpta->fetch_object())
        {
            $data[] = array(
                "0" => ($reg->estado=='Cancelado') ?
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idventa.')">
                            <i class="fa fa-eye"></i></button>' .
                    ' <button class="btn btn-danger" onclick="anular('.$reg->idventa.')">
                            <i class="fa fa-close"></i></button>' :
                    '<button class="btn btn-eye" onclick="mostrar('.$reg->idventa.')">
                            <i class="fa fa-pencil"></i></button>',
                "1" => $reg->Fecha,
                "2" => $reg->Cliente,
                "3" => $reg->Usuario,
                "4" => $reg->tipo_comprobante,
                "5" => $reg->serie_comprobante . '-' . $reg->num_comprobante,
                "6" => $reg->total_venta,
                "7" => ($reg->estado == 'Cancelado') ? '<span class="label bg-green">Cancelado</span>'
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
    case 'selectCliente':
        require_once '../modelo/Persona.php';
        $cliente = new Persona();

        $rpta = $cliente->listarc();
        while($reg = $rpta->fetch_object())
        {
            echo '<option value='.$reg->idpersona.'>'.$reg->nombre.'</option>';
        }
        break;
    case 'listarActivosVenta':
        require_once "../modelo/Articulo.php";
        $articulo = new Articulo();
        $rpta = $articulo->listarActivosVenta();
        $data = Array();
        while ( $reg = $rpta->fetch_object())
        {
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\' '.$reg->nombre.'\', '.$reg->precio_venta.')"><span class="fa fa-plus"></span></button>',
                "1" => $reg->nombre,
                "2" => $reg->Categoria,
                "3" => $reg->codigo,
                "4" => $reg->stock,
                "5" => $reg->precio_venta,
                "6" => "<img src='../files/articulos/".$reg->imagen."' height='50PX' width='50px' />",
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
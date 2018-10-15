<?php
session_start();
require_once '../modelo/Usuario.php';

$usuario = new Usuario();

$idusuario = isset($_POST['idusuario']) ? limpiarConsulta($_POST['idusuario']) : "";
$nombre = isset($_POST['nombre']) ? limpiarConsulta($_POST['nombre']) : "";
$tipo_documento = isset($_POST['tipo_documento']) ? limpiarConsulta($_POST['tipo_documento']) : "";
$num_documento = isset($_POST['num_documento']) ? limpiarConsulta($_POST['num_documento']) : "";
$direccion = isset($_POST['direccion']) ? limpiarConsulta($_POST['direccion']) : "";
$telefono = isset($_POST['telefono']) ? limpiarConsulta($_POST['telefono']) : "";
$email = isset($_POST['email']) ? limpiarConsulta($_POST['email']) : "";
$cargo = isset($_POST['cargo']) ? limpiarConsulta($_POST['cargo']) : "";
$login = isset($_POST['login']) ? limpiarConsulta($_POST['login']) : "";
$clave = isset($_POST['clave']) ? limpiarConsulta($_POST['clave']) : "";
$imagen = isset($_POST['imagen']) ? limpiarConsulta($_POST['imagen']) : "";


switch ($_GET['op']) {
    case 'guardaryeditar':
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST['imagenactual'];
        } else {
            $ext = explode(".", $_FILES['imagen']['name']);
            if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" ||
                $_FILES['imagen']['type'] == "image/png") {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/usuarios/" . $imagen);
            }

        }
        $clavehash = hash("SHA256", $clave);

        if (empty($idusuario)) {
            $rpta = $usuario->insertar($nombre, $tipo_documento, $num_documento, $direccion,
                $telefono, $email, $cargo, $login, $clavehash, $imagen,$_POST['permiso']);
            echo $rpta ? "Usuario Registrado" : "No se pudieron registrar todos los datos";
        } else {
            $rpta = $usuario->editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion,
                $telefono, $email, $cargo, $login, $clavehash, $imagen,$_POST['permiso']);
            echo $rpta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
        }
        break;
    case 'desactivar':
        $rpta = $usuario->desactivar($idusuario);
        echo $rpta ? "Usuario desactivado" : "Usuario no se pudo desactivar";
        break;
    case 'activar':
        $rpta = $usuario->activar($idusuario);
        echo $rpta ? "Usuario activado" : "Usuario no se pudo activar";
        break;
    case 'mostrar':
        $rpta = $usuario->mostrar($idusuario);
        echo json_encode($rpta);
        break;
    case 'listar':
        $rpta = $usuario->listar();
        $data = Array();
        while ($reg = $rpta->fetch_object()) {
            $data[] = array(
                "0" => ($reg->condicion) ?
                    '<button class="btn btn-warning" onclick="mostrar(' . $reg->idusuario . ')">
                            <i class="fa fa-pencil"></i></button>' .
                    ' <button class="btn btn-danger" onclick="desactivar(' . $reg->idusuario . ')">
                            <i class="fa fa-close"></i></button>' :
                    '<button class="btn btn-warning" onclick="mostrar(' . $reg->idusuario . ')">
                            <i class="fa fa-pencil"></i></button>' .
                    ' <button class="btn btn-primary" onclick="activar(' . $reg->idusuario . ')">
                            <i class="fa fa-check"></i></button>',
                "1" => $reg->nombre,
                "2" => $reg->tipo_documento,
                "3" => $reg->num_documento,
                "4" => $reg->telefono,
                "5" => $reg->email,
                "6" => $reg->login,
                "7" => "<img src='../files/usuarios/" . $reg->imagen . "' height='50PX' width='50px' />",
                "8" => ($reg->condicion) ? '<span class="label bg-green">Activado</span>'
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
    case 'permisos':
        require_once "../modelo/Permiso.php";
        $permiso = new Permiso();
        $rpta = $permiso->listar();

        //obtener los permisos asignados
        $id = $_GET['id'];
        $marcados = $usuario->listarmarcados($id);
        $valores = array();
        //almacenar todos los permisos marcados
        while($per = $marcados->fetch_object())
        {
            array_push($valores, $per->idpermiso);
        }

        while ($reg = $rpta->fetch_object()) 
        {
            $sw = in_array($reg->idpermiso, $valores) ? 'checked' : '';
            echo "<li> <input type='checkbox' ". $sw . " 
                name='permiso[]' value='" . $reg->idpermiso . "'/>" . $reg->nombre . " </li>";
        }
        break;
    case 'verificar':
        $logina = $_POST['logina'];
        $clavea = $_POST['clavea'];
        $clavehash = hash("SHA256", $clavea);
        $rpta = $usuario->verificar($logina, $clavehash);
        $fetch = $rpta->fetch_object();

        if(isset($fetch))
        {
            $_SESSION['idusuario'] = $fetch->idusuario;
            $_SESSION['nombre'] = $fetch->nombre;
            $_SESSION['imagen'] = $fetch->imagen;
            $_SESSION['login'] = $fetch->login;

            $marcados = $usuario->listarmarcados($fetch->idusuario);
            $valor = array();
            while($per = $marcados->fetch_object())
            {
                array_push($valor, $per->idpermiso);
            } 
            in_array(2, $valor) ? $_SESSION['escritorio'] = 1 : $_SESSION['escritorio'] = 0;
            in_array(3, $valor) ? $_SESSION['almacen'] = 1 : $_SESSION['almacen'] = 0;
            in_array(4, $valor) ? $_SESSION['compras'] = 1 : $_SESSION['compras'] = 0;
            in_array(5, $valor) ? $_SESSION['ventas'] = 1 : $_SESSION['ventas'] = 0;
            in_array(6, $valor) ? $_SESSION['acceso'] = 1 : $_SESSION['acceso'] = 0;
            in_array(7, $valor) ? $_SESSION['consultac'] = 1 : $_SESSION['consultac'] = 0;
            in_array(8, $valor) ? $_SESSION['consultav'] = 1 : $_SESSION['consultav'] = 0;
        }

        echo json_encode($fetch);
        break;
    case 'cerrar':
        session_unset();
        session_destroy();
        header('Location: ../vistas/login.html');
        break;
}
<?php
#incluimos la conexion  a la base de datos
require '../config/conexion.php';

class Usuario
{
    public function __construct()
    {

    }

    #insertar
    public function insertar($nombre, $tipo_documento, $num_documento, $direccion,
                             $telefono, $email, $cargo, $login, $clave, $imagen, $permisos)
    {
        $sql = "INSERT INTO usuario (nombre, tipo_documento,num_documento,
            direccion,telefono,email,cargo,login,clave,imagen) 
            VALUES('$nombre', '$tipo_documento','$num_documento','$direccion',
            '$telefono','$email','$cargo','$login','$clave','$imagen')";
        //return ejecutarConsulta($sql);
        $idusuarionew = ejecutarConsulta_retornarId($sql);
        $num_elementos = 0;
        $sw = true;
        while ($num_elementos < count($permisos)) {
            $sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) 
                VALUES ('$idusuarionew', '$permisos[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos++;
        }

        return $sw;
    }

    #editar
    public function editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion,
                           $telefono, $email, $cargo, $login, $clave, $imagen, $permisos)
    {
        $sql = "UPDATE usuario SET nombre='$nombre', tipo_documento='$tipo_documento' ,
            num_documento='$num_documento', direccion='$direccion', telefono='$telefono',
            email='$email', cargo='$cargo', login='$login', clave='$clave', imagen='$imagen'
            WHERE idusuario='$idusuario'";
        ejecutarConsulta($sql);
        $sqldel = "DELETE FROM usuario_permiso WHERE idusuario='$idusuario'";
        ejecutarConsulta($sqldel);

        $num_elementos = 0;
        $sw = true;
        while ($num_elementos < count($permisos)) {
            $sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) 
                VALUES ('$idusuario', '$permisos[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos++;
        }

        return $sw;
    }

    #desactivar
    public function desactivar($idusuario)
    {
        $sql = "UPDATE usuario SET condicion='0' WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    #activar
    public function activar($idusuario)
    {
        $sql = "UPDATE usuario SET condicion='1' WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    #metodo para mostrar los datos a modificar
    public function mostrar($idusuario)
    {
        $sql = "SELECT * FROM usuario WHERE idusuario = '$idusuario'";
        return ejecutarConsultaSimpleFila($sql);
    }

    #metodo para listar todas la categorias
    public function listar()
    {
        $sql = "SELECT * FROM usuario";
        return ejecutarConsulta($sql);
    }

    #metodo para listar permisos marcados
    public function listarmarcados($idusuario)
    {
        $sql = "SELECT * FROM usuario_permiso WHERE idusuario = '$idusuario'";
        return ejecutarConsulta($sql);
    }

    #acceso al sistema
    public function verificar($login, $clave)
    {
        $sql = "SELECT idusuario, nombre, tipo_documento, num_documento, 
            telefono, email, cargo, imagen, login FROM usuario 
            WHERE login = '$login' AND clave='$clave' AND condicion = '1' ";
        return ejecutarConsulta($sql);
    }

}
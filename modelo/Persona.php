<?php
#incluimos la conexion  a la base de datos
require '../config/conexion.php';

class Persona
{
    public function __construct()
    {

    }

    #insertar
    public function insertar($tipo_persona, $nombre, $tipo_documento, 
        $num_documento, $direccion, $telefono, $email)
    {
        $sql = "INSERT INTO persona (tipo_persona, nombre, tipo_documento, 
            num_documento, direccion, telefono, email) 
            VALUES('$tipo_persona', '$nombre', '$tipo_documento', 
            '$num_documento', '$direccion', '$telefono', '$email')";
        return ejecutarConsulta($sql);
    }

    #editar
    public function editar($idpersona, $tipo_persona, $nombre, $tipo_documento, 
        $num_documento, $direccion, $telefono, $email)
    {
        $sql = "UPDATE persona SET tipo_persona='$tipo_persona', nombre='$nombre', 
            tipo_documento='$tipo_documento', num_documento='$num_documento', direccion='$direccion', 
            telefono='$telefono', email='$email'
            WHERE idpersona='$idpersona'";
        return ejecutarConsulta($sql);
    }

    #eliminar registro
    public function eliminar($idpersona)
    {
        $sql = "DELETE FROM persona WHERE idpersona='$idpersona'";
        return ejecutarConsulta($sql);
    }

    #metodo para mostrar los datos a modificar
    public function mostrar($idpersona)
    {
        $sql = "SELECT * FROM persona WHERE idpersona = '$idpersona'";
        return ejecutarConsultaSimpleFila($sql);
    }

    #metodo para listar todas la categorias
    public function listarp()
    {
        $sql = "SELECT * FROM persona WHERE tipo_persona='Proveedor' ";
        return ejecutarConsulta($sql);
    }

    public function listarc()
    {
        $sql = "SELECT * FROM persona WHERE tipo_persona='Cliente' ";
        return ejecutarConsulta($sql);
    }

}
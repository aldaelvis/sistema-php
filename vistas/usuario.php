<?php 
ob_start();
session_start();
if(!isset($_SESSION["nombre"]))
{
  header('Location: login.html');
} else {
require 'header.php';
if($_SESSION['acceso'] == 1){
?>
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">Usuario
                            <button class="btn btn-success" id="buttonAgregar" onclick="mostrarform(true)">
                                <i class="fa fa-plus-circle"></i> Agregar
                            </button>
                        </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Tipo Documento</th>
                                <th>Numero Documento</th>
                                <th>Telefono</th>
                                <th>E-mail</th>
                                <th>Login</th>
                                <th>Foto</th>
                                <th>Condicion</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Tipo Documento</th>
                                <th>Numero Documento</th>
                                <th>Telefono</th>
                                <th>E-mail</th>
                                <th>Login</th>
                                <th>Foto</th>
                                <th>Condicion</th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form action="" name="formulario" id="formulario" method="post">
                            <div class="form-group col-sm-12">
                                <label for="">Nombre(*): </label>
                                <input type="hidden" name="idusuario" id="idusuario">
                                <input type="text" class="form-control" name="nombre" id="nombre" maxLength="100"
                                       placeholder="Nombre" required>
                            </div>
                            <div class="form-group col-sm-6 col-xs-12">
                                <label for="">Tipo documento(*): </label>
                                <select name="tipo_documento" id="tipo_documento" class="form-control selectpicker"
                                        data-live-search="true" required>
                                    <option value="DNI">DNI</option>
                                    <option value="RUC">RUC</option>
                                    <option value="CEDULA">CEDULA</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6 col-xs-12">
                                <label for="">Numero de documento(*): </label>
                                <input type="text" class="form-control" name="num_documento" maxlength="20" id="num_documento"  required>
                            </div>
                            <div class="form-group col-sm-6 col-xs-12">
                                <label for="">Direccion: </label>
                                <input type="text" class="form-control" name="direccion" id="direccion"
                                       maxLength="70" placeholder="Descripcion" placeholder="Direccion">
                            </div>
                            <div class="form-group col-sm-6 col-xs-12">
                                <label for="">Teléfono: </label>
                                <input type="text" class="form-control" name="telefono" id="telefono"
                                       maxLength="20"  placeholder="Teléfono">
                            </div>
                            <div class="form-group col-sm-6 col-xs-12">
                                <label for="">E-mail: </label>
                                <input type="email" class="form-control" name="email" id="email"
                                       maxLength="50" placeholder="Teléfono" >
                            </div>
                            <div class="form-group col-sm-6 col-xs-12">
                                <label for="">Cargo: </label>
                                <input type="text" class="form-control" name="cargo" id="cargo"
                                       maxLength="20" placeholder="Cargo" >
                            </div>
                            <div class="form-group col-sm-6 col-xs-12">
                                <label for="">Login(*): </label>
                                <input type="text" class="form-control" name="login" id="login"
                                       maxLength="20" placeholder="Login" required >
                            </div>
                            <div class="form-group col-sm-6 col-xs-12">
                                <label for="">Password(*): </label>
                                <input type="password" class="form-control" name="clave" id="clave"
                                       maxLength="64" placeholder="Password" required >
                            </div>
                            <div class="form-group col-sm-6 col-xs-12">
                                <label for="">Permisos</label>
                                <ul style="list-style: none" id="permisos">

                                </ul>

                            </div>
                            <div class="form-group col-sm-6 col-xs-12">
                                <label for="">Imagen: </label>
                                <input type="file" class="form-control" name="imagen" id="imagen">
                                <input type="hidden" name="imagenactual" id="imagenactual">
                                <img src="" alt="" width='150px' height="150px" id="imagenmuestra">
                            </div>
                            <div class="form-group col-sm-6 col-xs-12">
                                <button class="btn btn-primary" type="submit" id="btnGuardar">
                                    <i class="fa fa-save"></i>Guardar
                                </button>
                                <button class="btn btn-danger" type="button" onclick="cancelarform()">
                                    <i class="fa fa-arrow-circle-left"></i>Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->
<?php
}else {
    require 'noacceso.php';
  }
require 'footer.php';
?>
<script type="text/javascript" src="scripts/usuario.js"></script>
<?php
}
ob_end_flush();
?>
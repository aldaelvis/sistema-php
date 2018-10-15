<?php
ob_start();
session_start();
if(!isset($_SESSION["nombre"]))
{
  header('Location: login.html');
} else {
require 'header.php';
if($_SESSION['ventas'] == 1){
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
                          <h1 class="box-title">Cliente
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
                            <th>Email</th>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Tipo Documento</th>
                            <th>Numero Documento</th>
                            <th>Telefono</th>
                            <th>Email</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form action="" name="formulario" id="formulario" method="post">
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="">Nombre: </label>
                            <input type="hidden" name="idpersona" id="idpersona">
                            <input type="hidden" name="tipo_persona" id="tipo_persona" value="Cliente">
                            <input type="text" class="form-control" name="nombre" id="nombre" 
                                maxLength="100" placeholder="Nombre cliente... " required>
                          </div>
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="">Tipo Documento: </label>
                            <select name="tipo_documento" id="tipo_documento" 
                                class="form-control select-picker" required>
                                <option value="DNI">DNI</option>
                                <option value="RUC">RUC</option>
                                <option value="CEDULA">CEDULA</option>
                            </select>
                          </div>
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="">Numero documento: </label>
                            <input type="text" class="form-control" name="num_documento" id="num_documento" 
                                maxLength="20" placeholde="Numero documento" required>
                          </div>
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="">Dirección: </label>
                            <input type="text" class="form-control" name="direccion" id="direccion" 
                                maxLength="70" placeholde="Dirección" >
                          </div>
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="">Teléfono: </label>
                            <input type="text" class="form-control" name="telefono" id="telefono" 
                                maxLength="20" placeholde="Teléfono" >
                          </div>
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="">E-mail: </label>
                            <input type="text" class="form-control" name="email" id="email" 
                                maxLength="50" placeholde="E-mail" >
                          </div>
                          <div class="form-group col-sm-6 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar">
                              <i class="fa fa-save"></i>Guardar
                            </button>
                            <button class="btn btn-danger" type="submit" onclick="cancelarform()">
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
<script type="text/javascript" src="scripts/cliente.js"></script>
<?php
}
ob_end_flush();
?>
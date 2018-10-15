<?php 
ob_start();
session_start();
if(!isset($_SESSION["nombre"]))
{
  header('Location: login.html');
} else {
  require 'header.php';
  if($_SESSION['compras'] == 1 ){
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
                          <h1 class="box-title">Ingresos
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
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Tipo Comprobante</th>
                            <th>Numero documento</th>
                            <th>Total</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Tipo Comprobante</th>
                            <th>Numero documento</th>
                            <th>Total</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form action="" name="formulario" id="formulario" method="post">
                          <div class="form-group col-sm-8">
                            <label for="">Proveedor(*): </label>
                            <input type="hidden" name="idingreso" id="idingreso">
                            <select name="idproveedor" id="idproveedor" class="form-control select-picker" data-live-search="true" required>
                            
                            </select>
                          </div>
                          <div class="form-group col-sm-4">
                            <label for="">Fecha(*): </label>
                            <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" placeholder="Fecha" required>
                          </div>
                          <div class="form-group col-sm-4">
                            <label for="">Tipo Comprobante(*): </label>
                            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control select-picker" data-live-search="true">
                            <option value="Boleta">Boleta</option>
                            <option value="Factura">Factura</option>
                            <option value="Ticket">Ticket</option>
                            </select>
                          </div>
                          <div class="form-group col-sm-6 col-md-2">
                            <label for="">Serie: </label>
                            <input type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Serie">
                          </div>
                          <div class="form-group col-sm-6 col-md-2">
                            <label for="">Número: </label>
                            <input type="text" class="form-control" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Numero">
                          </div>
                          <div class="form-group col-sm-6 col-md-2">
                            <label for="">Impuesto: </label>
                            <input type="text" class="form-control" name="impuesto" id="impuesto">
                          </div>
                          <!-- modal -->
                          <div class="form-group col-xs-12 col-sm-6 col-md-3 ">
                            <a data-toggle="modal" href="#myModal">
                                <button id="btnAgregarArt" type="button" class="btn btn-primary">
                                    <span clas="fa fa-plus"></span>Agregar Artículos
                                </button>
                            </a>
                          </div>
                          <div class="col-sm-12">
                            <table id="detalles" class="table table-striped table-condensed table-bordered table-hover">
                                <thead style="background-color: #a9d0f5; " >
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Venta</th>
                                    <th>SubTotal</th>
                                </thead>
                                <tfoot>
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>
                                        <h4 id="total">S/. 0.00</h4>
                                        <input type="hidden" name="total_compra" id="total_compra">
                                    </th>
                                </tfoot>
                                <tbody></tbody>
                            </table>
                          </div>

                          <div class="form-group col-sm-6 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar">
                              <i class="fa fa-save"></i>Guardar
                            </button>
                            <button id="btnCancelar" class="btn btn-danger" type="button" onclick="cancelarform()">
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

  <!-- modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Artículo</h4>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
              <thead>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Codigo</th>
                <th>Stock</th>
                <th>Imagen</th>
              </thead>
              <tbody></tbody>
              <tfoot>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Codigo</th>
                <th>Stock</th>
                <th>Imagen</th> 
              </tfoot>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
<?php
  }else{
    require 'noacceso.php';
  }
require 'footer.php';
?>
<script type="text/javascript" src="scripts/ingreso.js"></script>
<?php
}
ob_end_flush();
?>
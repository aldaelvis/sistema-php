<?php 
ob_start();
session_start();
if(!isset($_SESSION["nombre"]))
{
  header('Location: login.html');
} else { 
require 'header.php';
if($_SESSION['almacen'] == 1){
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
                          <h1 class="box-title">Artículo
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
                            <th>Categoría</th>
                            <th>Codigo</th>
                            <th>Stock</th>
                            <th>Imagen</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Codigo</th>
                            <th>Stock</th>
                            <th>Imagen</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form action="" name="formulario" id="formulario" method="post">
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="">Nombre(*): </label>
                            <input type="hidden" name="idarticulo" id="idarticulo">
                            <input type="text" class="form-control" name="nombre" id="nombre" maxLength="100" placeholder="Nombre" required>
                          </div>
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="">Categoria(*): </label>
                            <select name="idcategoria" id="idcategoria" class="form-control selectpicker" 
                                data-live-search="true" required>
                                <!-- relleno con ajax -->
                            </select>
                          </div>
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="">Stock(*): </label>
                            <input type="number" class="form-control" name="stock" id="stock"  required>
                          </div>
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="">Descripción: </label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" maxLength="50" placeholder="Descripcion">
                          </div>
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="">Imagen: </label>
                            <input type="file" class="form-control" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" alt="" width='150px' height="150px" id="imagenmuestra">
                          </div>
                          <div class="form-group col-sm-6 col-xs-12">
                            <label for="">Codigo: </label>
                            <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Codigo de barras">
                            <button class="btn btn-success" type="button" onclick="generarbarcode()">Generar</button>
                            <button class="btn btn-info" type="button" onclick="imprimir()">Imprimir</button>
                            <div id="print">
                                <svg id="barcode">
                                    <!-- se genera con javasscript -->
                                </svg>
                            </div>
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
} else {
  require 'noacceso.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="../public/js/JsBarcode.all.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.PrintArea.js"></script>
<script type="text/javascript" src="scripts/articulo.js"></script>
<?php
}
ob_end_flush();
?>
<?php 
ob_start();
session_start();
if(!isset($_SESSION["nombre"]))
{
  header('Location: login.html');
} else {
  require 'header.php';
  if($_SESSION['escritorio'] == 1 ){
      require_once '../modelo/Consultas.php';
      $consulta = new Consultas();
      $rpta = $consulta->totalCompraHoy();
      $regc = $rpta->fetch_object();
      $tc = $regc->total_compra;

      $rptav = $consulta->totalVentaHoy();
      $regv = $rptav->fetch_object();
      $tv = $regv->total_venta;

      //datos para mostrar los graficos estadisticos
      $compras10 = $consulta->compraultimos_10dias();
      $fechasc = '';
      $totalesc='';
      while($reg = $compras10->fetch_object())
      {
          $fechasc = $fechasc.'"'.$reg->fecha.'",';
          $totalesc = $totalesc . $reg->total . ',' ;
      }

      $fechasc = substr($fechasc, 0, -1);
      $totalesc = substr($totalesc, 0, -1);

      //datos para mostrar graficos utimos 12 meses

      $ventas12 = $consulta->ventas_12meses();
      $fechasv = '';
      $totalesv ='';
      while($reg = $ventas12->fetch_object())
      {
          $fechasv = $fechasv.'"'.$reg->fecha.'",';
          $totalesv = $totalesv . $reg->total . ',' ;
      }

      $fechasv = substr($fechasv, 0, -1);
      $totalesv = substr($totalesv, 0, -1);

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
                          <h1 class="box-title">Escritorio</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body">
                        <div class="col-sm-6">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h4 style="font-size: 17px;">
                                        <strong>S/.<?php echo $tc; ?></strong>
                                    </h4>
                                    <p>Compras</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="ingreso.php" class="small-box-footer">Compras
                                <i class="fa fa-arrow-circle-right"></i> </a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h4 style="font-size: 17px;">
                                        <strong>S/.<?php echo $tv; ?></strong>
                                    </h4>
                                    <p>Ventas</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="venta.php" class="small-box-footer">Ventas
                                <i class="fa fa-arrow-circle-right"></i> </a>
                            </div>
                        </div>

                    </div>
                    <div class="panel-body">
                        <div class="col-xs-12 col-md-6">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    Compras en los últimos 10 días
                                </div>
                                <div class="box-body">
                                    <canvas id="compras" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    Ventas de los ultimos 12 meses
                                </div>
                                <div class="box-body">
                                    <canvas id="ventas" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
  }else{
    require 'noacceso.php';
  }
require 'footer.php';
?>
<script src="../public/js/Chart.js"></script>
<script src="../public/js/Chart.bundle.js"></script>
<script>
var ctx = document.getElementById("compras").getContext('2d');
var compras = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['<?php echo $fechasc; ?>'],
        datasets: [{
            label: '# Compras en S/. de los ultimos 10 dias',
            data: ['<?php echo $totalesc; ?>'],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

var ctx1 = document.getElementById("ventas").getContext('2d');
var compras = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['<?php echo $fechasv; ?>'],
        datasets: [{
            label: '# Ventas en S/. de los ultimos 12 meses',
            data: ['<?php echo $totalesv; ?>'],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
<?php
}
ob_end_flush();
?>
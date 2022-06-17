<?php
session_start();
include 'lib/config.php';
include 'lib/socialnetwork-lib.php';

ini_set('error_reporting', 0);

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Inicio | Venus SR</title>
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- Archivos modificar el input file -->
  <link rel="stylesheet" type="text/css" href="css/component.css" />
  <!-- remove this if you use Modernizr -->
  <script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- codigo scroll -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="js/jquery.jscroll.js"></script>
  <!-- codigo scroll -->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php echo Headerb(); ?>

<?php echo Side(); ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

    <!-- Script validar caracteres -->
    <script type="text/javascript">    
    function validarn(e) {
    tecla = (document.all) ? e.keyCode : e.which;
   if (tecla==8) return true;
   if (tecla==9) return true;
   if (tecla==11) return true;
    patron = /[A-Za-zñ!#$%&()=?¿¡*+0-9-_á-úÁ-Ú :;,.]/;
 
    te = String.fromCharCode(tecla);
    return patron.test(te);
} 
    </script>
    <!-- Script validar caracteres -->

      
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <!-- /.box -->
          <div class="row">

            
<div class="col-md-12">              
              <div class="box box-primary direct-chat direct-chat-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">¿Qué estás esperando para quemarte?</h3>

                 
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
              </div>

              <!-- /.box-body -->
                <div class="box-footer">
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="input-group">
                    <!-- END Input file nuevo diseño .-->
                    <center><h3>Espera a la noche para poder publicar uwu<3.<br></h3></center>
                    <center><h3><b>Domingo 12 de Agosto</b><br></h3></center>
                    <hr>
                    <center><h3>Amigos se logro, los nuevos servidores están funcionando perfectos de upload.</h3></center>
                    </div>
                  </form>
                  
                             
                </div>
                <!-- /.box-footer-->
              </div>
              <!--/.direct-chat -->
            </div>
            <!-- /.col -->            
          </div>
          <!-- /.row -->


          <!-- codigo scroll -->
          <div class="scroll">
            <?php require_once 'publicaciones.php'; ?>
          </div>

            <script>
            //Simple codigo para hacer la paginacion scroll
            $(document).ready(function() {
              $('.scroll').jscroll({
                loadingHtml: '<img src="images/invisible.png" alt="Loading" />'
            });
            });
            </script>
          <!-- codigo scroll -->


        </div>

        <div class="col-md-4">          

          <!-- PRODUCT LIST -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Solicitudes de amistad</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">

              <?php $amistade = mysqli_query($connect, "SELECT * FROM amigos WHERE para = '".$_SESSION['id']."' AND estado = '0' order by id_ami desc LIMIT 4");
              while ($am = mysqli_fetch_array($amistade)) {
                  $use = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_use = '".$am['de']."'");
                  $us = mysqli_fetch_array($use); ?>
                <li class="item">
                  <div class="product-img">
                    <img src="avatars/<?php echo $us['avatar']; ?>" alt="Product Image">
                  </div>
                  <div class="product-info">
                  <?php echo $us['usuario']; ?>
                      <a href="solicitud.php?action=aceptar&id=<?php echo $am['id_ami']; ?>"><span class="label label-success pull-right">Aceptar</span></a>
                      <br>
                      <a href="solicitud.php?action=rechazar&id=<?php echo $am['id_ami']; ?>"><span class="label label-danger pull-right">Rechazar</span></a>
                        <span class="product-description">
                          <?php echo $us['sexo']; ?>
                        </span>
                  </div>
                </li>
                <!-- /.item -->

                <?php
              } ?>


              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <?php if (mysqli_num_rows($amistade) > 4) {
                  ?>
              <a href="javascript:void(0)" class="uppercase">Ver todas las solicitudes</a>
              <?php
              } ?>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->


        <div class="col-md-4">
              <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Últimos registrados</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                  <?php $registrados = mysqli_query($connect, 'SELECT avatar, usuario, id_use, DATE_FORMAT(fecha_reg ,"%d-%m-%Y") AS fecha_reg FROM usuarios order by id_use desc limit 8');
                  while ($reg = mysqli_fetch_array($registrados)) {
                      ?>
                    <li>
                      <img src="avatars/<?php echo $reg['avatar']; ?>" alt="User Image" width="100" height="200">
					  <u><span class="users-list-name" onclick="location.href='perfil.php?id=<?php echo $reg['id_use']; ?>';" style="cursor:pointer; color: #fff;"><?php echo $reg['usuario']; ?></span></u>
                      <span class="users-list-date"><?php echo $reg['fecha_reg']; ?></span>
                    </li>
                  <?php
                  }
                  ?>

                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-footer -->
              </div>
              <!--/.box -->
            </div>
            <!-- /.col -->


      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- JS modificar diseño input file -->
<script src="js/custom-file-input.js"></script>
</body>
</html>

<?php
session_start();
include 'lib/config.php';
include 'lib/socialnetwork-lib.php';

ini_set('error_reporting', 0);

if (!isset($connect, $_SESSION['usuario'])) {
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<htmL>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Editar mi perfíl | Venus SR</title>
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php echo Headerb(); ?>

<?php echo Side(); ?>

<?php
if (isset($connect, $_GET['id'])) {
    $id = mysqli_real_escape_string($connect, $_GET['id']);

    $miuser = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_use = '$id'");
    $use = mysqli_fetch_array($miuser);

    if ($_SESSION['id'] != $id) {
        ?>
<script type="text/javascript">window.location="login.php";</script>
<?php
    } ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

      
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <!-- /.box -->



          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Editar mi perfíl</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nombre completo</label>
                  <input type="text" name="nombre" class="form-control" placeholder="Nombre completo" value="<?php echo $use['nombre']; ?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Usuario</label>
                  <input type="text" name="usuario" class="form-control" placeholder="Usuario" value="<?php echo $use['usuario']; ?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $use['email']; ?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Cambiar mi avatar</label>
                  <input type="file" name="avatar" accept="image/*">
                </div>
                <div class="checkbox">
                  <label>
                    <input type="radio" value="H" name="sexo" <?php if ($use['sexo'] == 'H') {
        echo 'checked';
    } ?>> Hombre <br>
                    <input type="radio" value="M" name="sexo" <?php if ($use['sexo'] == 'M') {
        echo 'checked';
    } ?>> Mujer
                  </label>
                </div>

                <!-- Date dd/mm/yyyy -->
              <div class="form-group">
                <label>Fecha de nacimiento</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="nacimiento" placeholder="<?php echo $use['nacimiento']; ?>" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask >
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
              </div>
              <!-- /.box-body -->

              <center><div class="box-footer">
                <button type="submit" name="actualizar" class="btn btn-primary">Actualizar datos</button>
              </div></center>
            </form>
          </div>
          <!-- /.box -->

          <?php
          if(isset($_POST['actualizar']))
          {
            $nombre = mysqli_real_escape_string($connect, $_POST['nombre']);
            $usuario = mysqli_real_escape_string($connect, $_POST['usuario']);
            $email = mysqli_real_escape_string($connect, $_POST['email']);
            $sexo = mysqli_real_escape_string($connect, $_POST['sexo']);
            $nacimiento = mysqli_real_escape_string($connect, $_POST['nacimiento']);
            if($nacimiento != '') {$nac = $nacimiento;} else {$nac = $use['nacimiento'];}
            $comprobar = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM usuarios WHERE usuario = '$usuario' AND id_use != '$id'"));
            if($comprobar == 0){
            $type = 'jpg';
            $rfoto = $_FILES['avatar']['tmp_name'];
            $name = $id.'.'.$type;
            if(is_uploaded_file($rfoto))
            {
              $destino = 'avatars/'.$name;
              $nombrea = $name;
              copy($rfoto, $destino);
            }
            else
            {
              $nombrea = $use['avatar'];
            }
            $sql = mysqli_query($connect, "UPDATE usuarios SET nombre = '$nombre', usuario = '$usuario', email = '$email', sexo = '$sexo', nacimiento = '$nac', avatar = '$nombrea' WHERE id_use = '$id'");
            if($sql) {echo "<script type='text/javascript'>window.location='editarperfil.php?id=$_SESSION[id]';</script>";}
            } else {echo 'El nombre de usuario ya está en uso, escoja otro';}
          }
          ?>


        </div>

        <div class="col-md-4">          

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
                  <?php $registrados = mysqli_query($connect, 'SELECT avatar,usuario,fecha_reg FROM usuarios order by id_use desc limit 8');
    while ($reg = mysqli_fetch_array($registrados)) {
        ?>
                    <li>
                      <img src="avatars/<?php echo $reg['avatar']; ?>" alt="User Image">
                      <a class="users-list-name" href="#"><?php echo $reg['usuario']; ?></a>
                      <span class="users-list-date">Hoy</span>
                    </li>
                  <?php
    } ?>

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

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script>
  $(function () {
    $("[data-mask]").inputmask();
  });
</script>
</body>
</html>
<?php
} ?>
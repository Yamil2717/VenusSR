<?php
session_start();
include 'lib/config.php';
include 'lib/socialnetwork-lib.php';

ini_set('error_reporting', 0);

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
}
?>

<?php
  if (isset($_GET['id'])) {
      $id = mysqli_real_escape_string($connect, $_GET['id']);
      $pag = $_GET['perfil'];

      $infouser = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_use = '$id'");
      $use = mysqli_fetch_array($infouser);

      $amigos = mysqli_query($connect, "SELECT * FROM amigos WHERE de = '$id' AND para = '".$_SESSION['id']."' OR de = '".$_SESSION['id']."' AND para = '$id'");
      $ami = mysqli_fetch_array($amigos); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $use['nombre']; ?> | Venus SR</title>
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

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive" src="avatars/<?php echo $use['avatar']; ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $use['nombre']; ?></h3> 
              <?php if ($use['verificado'] != 0) {
          ?>
              <center><span class="glyphicon glyphicon-ok"></span></center>
              <?php
      } ?>

              <p class="text-muted text-center">Lo hace bien rico</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Followers</b> <a class="pull-right">| Próximamente |</a>
                </li>
                <li class="list-group-item">
                  <b>Following</b> <a class="pull-right">| Próximamente |</a>
                </li>
                <li class="list-group-item">
                  <b>Friends</b> <a class="pull-right">| Próximamente |</a>
                </li>
              </ul>
              
              <?php if ($_SESSION['id'] != $id) {
          ?>
              <form action="" method="post">
              
              <?php if (mysqli_num_rows($amigos) >= 1 and $ami['estado'] == 0) {
              ?>
              <center><h4>Esperando respuesta</h4></center>
              <?php
          } else {
              ?>

              <?php if ($use['privada'] == 1 and $ami['estado'] == 0) {
                  ?>
              <input type="submit" class="btn btn-primary btn-block" name="seguir" value="Enviar solicitud de amistad">
              <?php
              } ?>
              <?php if ($use['privada'] == 1 and $ami['estado'] == 1) {
                  ?>
              <input type="submit" class="btn btn-danger btn-block" name="dejarseguir" value="Dejar de seguir">
              <?php
              } ?>
              <?php if ($use['privada'] == 0 and $ami['estado'] == 0) {
                  ?>
              <input type="submit" class="btn btn-primary btn-block" name="seguirdirecto" value="Seguir">
              <?php
              } ?>
              <?php if ($use['privada'] == 0 and $ami['estado'] == 1) {
                  ?>
              <input type="submit" class="btn btn-danger btn-block" name="dejarseguir" value="Dejar de seguir">
              <?php
              } ?>


              <?php
          } ?>
              </form>
              <?php
      } ?>

              <?php
              if (isset($_POST['seguir'])) {
                  $add = mysqli_query($connect, "INSERT INTO amigos (de,para,fecha,estado) values ('".$_SESSION['id']."','$id',now(),'0')");
                  if ($add) {
                      echo '<script>window.location="perfil.php?id='.$id.'"</script>';
                  }
              } ?>

              <?php
              if (isset($_POST['seguirdirecto'])) {
                  $add = mysqli_query($connect, "INSERT INTO amigos (de,para,fecha,estado) values ('".$_SESSION['id']."','$id',now(),'1')");
                  if ($add) {
                      echo '<script>window.location="perfil.php?id='.$id.'"</script>';
                  }
              } ?>

              <?php
              if (isset($_POST['dejarseguir'])) {
                  $add = mysqli_query($connect, "DELETE FROM amigos WHERE de = '$id' AND para = '".$_SESSION['id']."' OR de = '".$_SESSION['id']."' AND para = '$id'");
                  if ($add) {
                      echo '<script>window.location="perfil.php?id='.$id.'"</script>';
                  }
              } ?>
              

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Sobre mi:</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i>Está persona se describe como:</strong>

              <center><h5><p class="text-muted">
               El amor de tu vida
              </p></h5></center>

              <hr>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="<?php echo $pag == 'miactividad' ? 'active' : ''; ?>"><a href="?id=<?php echo $id; ?>&perfil=miactividad">Actividad</a></li>
              <li class="<?php echo $pag == 'informacion' ? 'active' : ''; ?>"><a href="?id=<?php echo $id; ?>&perfil=informacion">Información</a></li>
              <li class="<?php echo $pag == 'fotos' ? 'active' : ''; ?>"><a href="?id=<?php echo $id; ?>&perfil=fotos">Fotos</a></li>
            </ul>
            <div class="tab-content">

                
          <!-- codigo scroll -->
          <div class="scroll">

          <?php
          if ($use['privada'] != 1) {
              ?>
          
            <?php
            $pagina = isset($_GET['perfil']) ? strtolower($_GET['perfil']) : 'miactividad';
              require_once $pagina.'.php'; ?>

          <?php
          } elseif ($use['privada'] == 1 and $ami['estado'] == 1) {
              ?>
              
            <?php
            $pagina = isset($_GET['perfil']) ? strtolower($_GET['perfil']) : 'miactividad';
              require_once $pagina.'.php'; ?>

          <?php
          } elseif ($use['privada'] == 1 and $_SESSION['id'] == $id) {
              ?>
              
            <?php
            $pagina = isset($_GET['perfil']) ? strtolower($_GET['perfil']) : 'miactividad';
              require_once $pagina.'.php'; ?>


          <?php
          } else {
              ?>

          <center><h2>Este perfil es privado, envia una solicitud</h2></center>

          <?php
          } ?>

          </div>

            
                
              </div>
  
          </div>
          <!-- /.nav-tabs-custom -->
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
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php
  } // finaliza if GET
?>
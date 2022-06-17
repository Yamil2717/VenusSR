<?php
session_start();
include 'lib/config.php';

if (isset($connect, $_SESSION['usuario'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="RATING" content="RTA-5042-1996-1400-1577-RTA" />
  <title>Login | Venus SR</title>
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
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img class="img-circle" src="images/Logotipo.png" width="200" height="200">
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Bienvenido al Sin Reglas de Venus</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuario" name="usuario" pattern="[A-Za-z_-0-9]{1,20}">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Contraseña" name="contrasena" pattern="[A-Za-z_-0-9]{1,20}">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Iniciar Sesión</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <?php
    if (isset($connect, $_POST['login'])) {
        $usuario = mysqli_real_escape_string($connect, $_POST['usuario']);
        $usuario = strip_tags($_POST['usuario']);
        $usuario = trim($_POST['usuario']);

        $contrasena = mysqli_real_escape_string($connect, md5($_POST['contrasena']));
        $contrasena = strip_tags(md5($_POST['contrasena']));
        $contrasena = trim(md5($_POST['contrasena']));

        $query = mysqli_query($connect, "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$contrasena'");
        $contar = mysqli_num_rows($query);

        if ($contar == 1) {
            while ($row = mysqli_fetch_array($query)) {
                if ($usuario = $row['usuario'] && $contrasena = $row['contrasena']) {
                    $_SESSION['usuario'] = $row['usuario'];
                    $_SESSION['id'] = $row['id_use'];
                    $_SESSION['avatar'] = $row['avatar'];

                    header('Location: index.php');
                }
            }
        } else {
            echo '<br>
        <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <center>Los datos ingresados no son correctos.</center>
        </div>';
        }
    }

    ?>
    <center><h4 class="text-center">¿No tienes cuenta aún?</h4></center>
    <center><h5 class="text-center">Contacta a algunos de los <b>administradores.</b></h5></center>
    <center><h4><span onclick="location.href='https://facebook.com/Max.2717';" style="cursor:pointer; color: #ec2d32;">悲しい 少年</span><h4></center>
    <center><h4><span onclick="location.href='https://facebook.com/iTumbster';" style="cursor:pointer; color: #ec2d32;">Alexandra Sánchez</span><h4></center>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>

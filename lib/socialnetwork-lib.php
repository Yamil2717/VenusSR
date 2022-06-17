<?php
include 'lib/config.php';

ini_set('error_reporting', 0);

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
}

$baneo = mysqli_query($connect, "SELECT ban FROM usuarios WHERE id_use = '".$_SESSION['id']."'");
$ban = mysqli_fetch_array($baneo);

if ($ban['ban'] == 1) {
    header('Location: logout.php');
}
?>

<?php

function Headerb()
{
    ?>
<!-- START HEADER -->
<header class="main-header">

    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Venus <b>SR</b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          
          <?php
          $noti = mysqli_query($connect, "SELECT * FROM notificaciones WHERE user2 = '".$_SESSION['id']."' AND leido = '0' ORDER BY id_not desc");
    $cuantas = mysqli_num_rows($noti); ?>

          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?php echo $cuantas; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tu tienes <?php echo $cuantas; ?> notificaciones</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">

                <?php 
                while ($no = mysqli_fetch_array($noti)) {
                    $users = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_use = '".$no['user1']."'");
                    $usa = mysqli_fetch_array($users); ?>

                  <li>
                    <a href="publicacion.php?id=<?php echo $no['id_pub']; ?>">
                      <i class="fa fa-users text-aqua"></i> 
                      El usuario <?php echo $usa['usuario']; ?> <?php echo $no['tipo']; ?> tu publicación
                    </a>
                  </li>

                <?php
                } ?>


                </ul>
              </li>
            </ul>
          </li>

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="avatars/<?php echo $_SESSION['avatar']; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['usuario']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="avatars/<?php echo $_SESSION['avatar']; ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION['usuario']; ?>
                  <small>Miembro desde Hoy</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-6 text-center">
                    <a href="#">Seguidores</a>
                  </div>
                  <div class="col-xs-6 text-center">
                    <a href="#">Seguidos</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="editarperfil.php?id=<?php echo $_SESSION['id']; ?>" class="btn btn-default btn-flat">Editar perfil</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Cerrar sesión</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </nav>
  </header>
<!-- END HEADER -->
<?php
}
?>

<?php
function Side()
{
    ?>
<!-- START LEFT SIDE -->
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left">
          <img src="avatars/<?php echo $_SESSION['avatar']; ?>" width="50" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['usuario']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">Menú de navegación</li>
        <li>
          <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>Inicio</span>
          </a>
        </li>
        <li>
          <a href="perfil.php?id=<?php echo $_SESSION['id']; ?>">
            <i class="fa fa-user"></i> <span>Mis seguidores</span>
          </a>
        </li>
        <li>
          <a href="perfil.php?id=<?php echo $_SESSION['id']; ?>">
            <i class="fa fa-arrow-right"></i> <span>Seguidos</span>
          </a>
        </li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
<!-- END LEFT SIDE -->
<?php
}
?>
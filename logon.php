<?php
if (isset($connect, $_POST['hash'])) {
    $usuario = mysqli_real_escape_string($connect, $_POST['nombreusr']);
    $usuario = strip_tags($_POST['nombreusr']);
    $usuario = trim($_POST['nombreusr']);

    $contrasena = mysqli_real_escape_string($connect, $_POST['hash']);
    $contrasena = strip_tags($_POST['hash']);
    $contrasena = trim($_POST['hash']);

    $query = mysqli_query($connect, "SELECT * FROM archivos WHERE nombre = '$usuario' AND hash = '$contrasena'");
    $contar = mysqli_num_rows($query);

    if ($contar == 1) {
        while ($row = mysqli_fetch_array($query)) {
            if ($usuario = $row['nombre'] && $contrasena = $row['hash']) {
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['id'] = $_POST['ids'];
                $_SESSION['hash'] = $row['hash'];





                //header('Location: true.php');

                //var_dump($_SESSION);

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

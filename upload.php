<?php
// includes
session_start();
require 'db.php';
require 'logon.php';




if (isset($_SESSION['hash'])) {
    //var_dump($_SESSION);
    //header('Location: index.php');

//FORMS PROC
$formatos = array('.jpg', '.png', '.gif', '.mp3', '.mp4', '.avi');


      for($i=0; $i<count($_FILES['archivo']['name']); $i++) {

          if (isset($_POST['publicar'])) {
              $publicacion = mysqli_real_escape_string($connect, $_POST['publicacion']);

              $result = mysqli_query($connect, "SHOW TABLE STATUS WHERE `Name` = 'publicaciones'");
              $data = mysqli_fetch_assoc($result);
              $next_increment = $data['Auto_increment'];



              $hash_md5 = md5($_POST['nombreusr']);

              $numeros = array();
              //gen numeros random
              $n = $hash_md5;
              $n .= 	rand(100000,900000);



          $type = $_FILES['archivo']['name'][$i];
          $ext = substr($type, strrpos($type, '.'));
          $rfoto = $_FILES['archivo']['tmp_name'][$i];
          $name = $n.''.$ext;

          if (in_array($ext, $formatos)) {
              if (is_uploaded_file($rfoto)) {
                  $destino = 'publicaciones/'.$name;
                  $nombre = $name;
                  copy($rfoto, $destino);

                  $llamar = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM albumes WHERE usuario ='".$_SESSION['id']."' AND nombre = 'Publicaciones'"));

                  if ($llamar >= 1) {
                } else {
                    $crearalbum = mysqli_query($connect, "INSERT INTO albumes (usuario,fecha,nombre) values ('".$_SESSION['id']."',now(),'Publicaciones')");
                }

                $idalbum = mysqli_query($connect, "SELECT * FROM albumes WHERE usuario ='".$_SESSION['id']."' AND nombre = 'Publicaciones'");
                $alb = mysqli_fetch_array($idalbum);

                //correcion de https_url
                $url_file = '';
                $Filerserver = 'https://fileserver1.venussr.com/publicaciones/';

                $url_file = $Filerserver.$nombre;

                //echo $url_file;


                $subirimg = mysqli_query($connect, "INSERT INTO fotos (usuario,fecha,ruta,album,publicacion) values ('".$_SESSION['id']."',now(),'$url_file','".$alb['id_alb']."','$next_increment')");

                $llamadoimg = mysqli_query($connect, "SELECT id_fot FROM fotos WHERE usuario = '".$_SESSION['id']."' ORDER BY id_fot desc");
                $llaim = mysqli_fetch_array($llamadoimg);
            } else {
                $nombre = '';
            }

            $subir = mysqli_query($connect, "INSERT INTO publicaciones (usuario,fecha,contenido,imagen,album,comentarios) values ('".$_SESSION['id']."',now(),'$publicacion','".$llaim['id_fot']."','".$alb['id_alb']."','1')");

            if ($subir) {
                //echo '<script>window.location.href = "https://www.venussr.com/index.php";</script>';
                header('Location: https://venussr.com/index.php');
            }
        } else {
                echo '<br>
                    <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <center>Archivo no permitido.</center>
                    </div>';
                    }


            }
 }
}

                  ?>

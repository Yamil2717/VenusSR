<?php
$id = mysqli_real_escape_string($connect, $_GET['id']);
$album = mysqli_real_escape_string($connect, $_GET['album']); ?>


    <center>
        <?php 
        $fotosa = mysqli_query($connect, "SELECT * FROM fotos WHERE usuario = '$id' AND album = '$album' ORDER BY id_fot desc");
        while ($fot = mysqli_fetch_array($fotosa)) {   
              $extfotos = array('.jpg', '.png', '.gif');
              $extaudio = array('.mp3');
              $extf = substr($fot['ruta'], strrpos($fot['ruta'], '.')); 
              if (in_array($extf, $extfotos)) {
                  ?>
                <a href="publicaciones/<?php echo $fot['ruta']; ?>">
				        <img src="publicaciones/<?php echo $fot['ruta']; ?>" width="30%" height="30%">
                </a>
              <?php
              } elseif (in_array($extf, $extaudio)){ ?>
                <br><br>
                <a href="publicaciones/<?php echo $fot['ruta']; ?>">
				        <audio src="publicaciones/<?php echo $fot['ruta']; ?>" preload="metadata" width="30%" height="30%" controls>
                </a>
                <br>
              <?php
              } else { ?>
                <a href="publicaciones/<?php echo $fot['ruta']; ?>">
                <video src="publicaciones/<?php echo $fot['ruta']; ?>" preload="metadata" width="30%" height="30%" controls>
                </a>
              <?php
              } 
        } ?> 
    </center>
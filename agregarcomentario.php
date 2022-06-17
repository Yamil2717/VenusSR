<?php
require 'lib/config.php';
?>

<?php
$usuario = mysqli_real_escape_string($connect, $_POST['usuario']);
$comentario = mysqli_real_escape_string($connect, htmlspecialchars($_POST['comentario'], ENT_QUOTES, 'UTF-8'));
$publicacion = mysqli_real_escape_string($connect, $_POST['publicacion']);

$insert = mysqli_query($connect, "INSERT INTO comentarios (usuario, comentario, fecha, publicacion) VALUES ('$usuario', '$comentario', now(), '$publicacion')");

$llamado = mysqli_query($connect, "SELECT * FROM publicaciones WHERE id_pub = '".$publicacion."'");
$ll = mysqli_fetch_array($llamado);

$usuario2 = mysqli_real_escape_string($connect, $ll['usuario']);

$insert2 = mysqli_query($connect, "INSERT INTO notificaciones (user1, user2, tipo, leido, fecha, id_pub) VALUES ('$usuario', '$usuario2', 'ha comentado', '0', now(), '$publicacion')");
?>

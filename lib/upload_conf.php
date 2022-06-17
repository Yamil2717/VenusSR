<?php
$indicde = rand(1, 2);

switch ($indicde) {
  case '1':
  $uploader1 = 'https://fileserver1.venussr.com/upload.php';
    break;

    case '2':
    $uploader1 = 'https://fileserver2.venussr.com/upload.php';
      break;

  default:
    $uploader1 = 'https://fileserver1.venussr.com/upload.php';
    break;
}
//echo "$uploader1";
$imputs = '
          <form action="'.$uploader1.'" method="post" enctype="multipart/form-data">
          <input type="hidden"  name="hash" value="'.$_SESSION['hash'].'">
          <input type="hidden"  name="nombreusr" value="'.$_SESSION['usuario'].'">
          <input type="hidden"  name="ids" value="'.$_SESSION['id'].'">';



 ?>

<?php

session_start();

unset($connect, $_SESSION['usuario']);
unset($connect, $_SESSION['id']);

session_destroy();

header('Location: login.php');

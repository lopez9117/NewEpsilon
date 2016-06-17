<?php
session_start();
//limpiar variables de sesion
unset($_SESSION['currentuser']);
unset($_SESSION['area']);
unset($_SESSION['user_id']);
unset($_SESSION['username']);
session_destroy();
header('Location: ../index.php');
?>
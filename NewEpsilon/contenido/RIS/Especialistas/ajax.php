<?php
include("../../../dbconexion/conexion.php");
$cn = Conectarse();
include 'especialistas.class.php';
$usuario = new Usuarios();
echo json_encode($usuario->buscarUsuario($_GET['term']));
mysql_close($cn);

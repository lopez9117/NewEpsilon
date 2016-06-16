<?php
include("../../../../../dbconexion/conexion.php");
$cn = Conectarse();
include_once 'especialistas.class.php';
$usuario = new Usuarios();
echo json_encode($usuario->buscarUsuario($_GET['term']));

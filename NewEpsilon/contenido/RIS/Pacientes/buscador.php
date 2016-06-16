<?php
require_once("../../../dbconexion/conexion.php");
$cn= Conectarse();
include_once 'pacientes.class.php';
$usuario = new Pacientes();
echo json_encode($usuario->buscarPacientes($_GET['term']));
mysql_close($cn);

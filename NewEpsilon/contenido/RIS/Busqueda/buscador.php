<?php
include("../../../dbconexion/conexion.php");
$cn = Conectarse();
include 'pacientes.class.php';
$usuario = new Pacientes();
echo json_encode($usuario->buscarPacientes($_GET['term']));
mysql_close($cn);

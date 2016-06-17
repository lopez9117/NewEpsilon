<?php
require_once("../../../../dbconexion/conexion.php");
$cn = Conectarse();
include_once 'cups.class.php';
$estudio = new Estudios();
echo json_encode($estudio->buscarEstudios($_GET['term'],$_GET['servicio']));

<?php
require_once("../../../../dbconexion/conexion.php");
$cn = Conectarse();
include_once 'Extremidad.class.php';
$estudio = new Extremidad();
echo json_encode($estudio->buscarExtremidad($_GET['term']));

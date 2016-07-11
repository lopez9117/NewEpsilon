<?php
require_once("../../../../dbconexion/conexion.php");
$cn = Conectarse();
include_once 'Adicional.class.php';
$estudio = new Adiciones();
echo json_encode($estudio->buscarAdiciones($_GET['term']));
?>

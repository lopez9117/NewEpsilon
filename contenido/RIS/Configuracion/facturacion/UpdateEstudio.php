<?php
//Conexion a la base de datos
require_once('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//variables
$idestudio = $_POST['idestudio'];
$nom_estudio = $_POST['nom_estudio'];
$cod_iss = $_POST['cod_iss'];
$cod_soat = $_POST['cod_soat'];
$servicio = $_POST['servicio'];
$estado = $_POST['estado'];
$val_iss = $_POST['val_iss'];
$val_soat = $_POST['val_soat'];
$cups_iss = $_POST['cups_iss'];
$uvr = $_POST['uvr'];
$sala = $_POST['sala'];
$val_sala = $_POST['val_sala'];
$cod_propio = $_POST['cod_propio'];
$val_propio = $_POST['val_propio'];
$materiales = $_POST['materiales'];
$val_materiales = $_POST['val_materiales'];
$honorario = $_POST['honorario'];
$bo = $_POST['b/o'];
//validar campos obligatorios
if ($nom_estudio == "" || $servicio == "" || $estado == "" || $uvr == "") {
    //respuesta en pantalla
    echo '<font color="#FF0000">Los campos marcados con * son obligatorios</font>';
} else {
    //consulta
    mysql_query("UPDATE r_estudio SET nom_estudio = '$nom_estudio', cod_iss = '$cod_iss', cod_soat = '$cod_soat',
 				idservicio = '$servicio', idestado = '$estado',val_iss='$val_iss',val_soat='$val_soat',cups_iss='$cups_iss',
 				 uvr='$uvr',sala='$sala',val_sala='$val_sala',materiales='$val_materiales',cod_propio='$cod_propio',
 				 val_propio='$val_propio',honorario='$honorario',typebiopsiadrenaje = '$bo' WHERE idestudio = '$idestudio'", $cn);

    echo '<font color="#006600">Guardado con exito!!</font>';
}
?>
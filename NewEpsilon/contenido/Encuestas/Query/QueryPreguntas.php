<?php
//conexion a la bd
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//variables
$encuesta = $_POST['encuesta'];

$sqlQuestion = mysql_query("SELECT * FROM e_pregunta WHERE idencuesta = '$encuesta' AND idestado_actividad = '1'", $cn);

echo '<option value="">.: Por favor seleccione una pregunta de la lista :.</option>';

while($rowQuestion = mysql_fetch_array($sqlQuestion))
{
	echo '<option value="'.$rowQuestion['idpregunta'].'">'.$rowQuestion['desc_pregunta'].'</option>';
}
?>
<?php
//conexion a la bd
require_once('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();

$especialista = $_POST[especialista];
$servicio = $_POST[servicio];

$sqlEstudioEspecialista = mysql_query("SELECT DISTINCT p.idestudio, e.desc_estudio FROM plantilla p INNER JOIN estudio e ON e.idestudio = p.idestudio WHERE p.idfuncionario = $especialista AND p.idservicio = $servicio ", $cn);

echo '<option value="">.: Seleccione :.</option>';

while($rowEstudioEspecialista = mysql_fetch_array($sqlEstudioEspecialista))
{
	echo '<option value="'.$rowEstudioEspecialista[idestudio].'">'.$rowEstudioEspecialista[desc_estudio].'</option>';
}
?>
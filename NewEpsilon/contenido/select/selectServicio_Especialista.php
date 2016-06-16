<?php
//conexion a la bd
require_once('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();

$especialista = $_POST[especialista];

$sql = mysql_query("SELECT DISTINCT p.idservicio, s.descservicio FROM plantilla p INNER JOIN servicio s ON s.idservicio = p.idservicio WHERE p.idfuncionario = $especialista ORDER BY descservicio ASC", $cn);

echo '<option value="">.: Seleccione :.</option>';

while($rowServicioEspecialista = mysql_fetch_array($sql))
{
	echo '<option value="'.$rowServicioEspecialista[idservicio].'">'.$rowServicioEspecialista[descservicio].'</option>';
}
?>
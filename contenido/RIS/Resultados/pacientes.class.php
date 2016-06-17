<?php
class Pacientes
{
	public function buscarPacientes($nombreUsuario){
	$datos = array();
	$sql = "SELECT id_paciente, CONCAT(nom1,' ',nom2,' ',ape1,' ',ape2) AS paciente FROM r_paciente
			WHERE CONCAT(nom1,' ',nom2,' ',ape1,' ',ape2) LIKE '%$nombreUsuario%'
			OR id_paciente LIKE '%$nombreUsuario%' LIMIT 10";
	$resultado = mysql_query($sql);
	while ($row = mysql_fetch_array($resultado, MYSQL_ASSOC))
	{
		$datos[] = array("value" => trim($row['id_paciente']). ' - ' .
		trim($row['paciente']),
		"descripcion" => trim($row['descripcion_usuarios']),
		);
	}
	return $datos;
	}
}
<?php
class eps
{
    public function buscarEPS($nombreEps){
    $datos = array();
	//consultar EPS
	$sql = "SELECT ideps, UPPER(desc_eps) AS desc_eps FROM eps WHERE desc_eps LIKE '%$nombreEps%' AND idestado = '2'";
	$resultado = mysql_query($sql);
	while ($row = mysql_fetch_array($resultado, MYSQL_ASSOC))
	{
		$datos[] = array("value" => trim($row['desc_eps']),
		 "descripcionEps" => trim($row['descripcion_eps']),
		);
	}
return $datos;
    }
}
<?php
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	
	$sql = mysql_query("SELECT idestudio, nom_estudio, idservicio FROM r_estudio ORDER BY idservicio ASC", $cn);
	while($row = mysql_fetch_array($sql))
	{
		$datos[count($datos)] = $row['nom_estudio'];	
	}

	$texto = $_GET["texto"];
	
	// Devuelvo el XML con la palabra que mostramos (con los '_') y si hay éxito o no
	$xml  = '<?xml version="1.0" standalone="yes"?>';
	$xml .= '<datos>';
	foreach ($datos as $dato) {
		if (strpos(strtoupper($dato), strtoupper($texto)) === 0 OR $texto == "") {
			$xml .= '<pais>'.$dato.'</pais>';
		}
	}
	$xml .= '</datos>';
	header('Content-type: text/xml');
	echo $xml;		
?>
<?php 
include("conexion.php");

if($_GET['action'] == 'listar')
{
	// valores recibidos por POST
	$vnm   = $_POST['nombre_email'];
	$vpais = $_POST['pais'];
	$vdel  = ($_POST['del'] != '' ) ? explode("/",$_POST['del']) : '';
	$val   = ($_POST['al']  != '' ) ? explode("/",$_POST['al']) : '';
	
	$sql = "SELECT * FROM personas pe, pais p
				WHERE pe.pais = p.id_pais ";	
										
	// Vericamos si hay algun filtro
	$sql .= ($vnm != '')      ? " AND CONCAT(nombre,' ', email) LIKE '%$vnm%'" : "";
	$sql .= ($vpais > 0)      ? " AND pe.pais = '".$vpais."'" : "";
	$sql .= ($vdel && $val)   ? " AND nacimiento BETWEEN '$vdel[2]-$vdel[1]-$vdel[0]' 
														AND '$val[2]-$val[1]-$val[0]' " : "";
	
	// Ordenar por
	$vorder = $_POST['orderby'];
	
	if($vorder != ''){
		$sql .= " ORDER BY ".$vorder;
	}
	
	$query = mysql_query($sql);
	$datos = array();
	
	while($row = mysql_fetch_array($query))
	{
		$datos[] = array(
			'id'          => $row['id'],
			'nombre'      => $row['nombre'],
			'email'       => $row['email'],
			'nacimiento'  => $row['nacimiento'],
			'pais'        => $row['nombre_pais']
		);
	}
	// convertimos el array de datos a formato json
	echo json_encode($datos);
}

?>
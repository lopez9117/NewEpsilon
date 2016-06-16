<?php 
include("conexion.php");

if($_GET['action'] == 'listar')
{
	// valores recibidos por POST
	$vnm   = $_POST['nombre_apellido_id'];
	$vsede = $_POST['sede'];
//	$vdel  = ($_POST['del'] != '' ) ? explode("/",$_POST['del']) : '';
//	$val   = ($_POST['al']  != '' ) ? explode("/",$_POST['al']) : '';
	$vdel  = $_POST['del'];
	$val   = $_POST['al'];


$RegistrosAMostrar=3;

//estos valores los recibo por GET
if(isset($_GET['pag'])){
	$RegistrosAEmpezar=($_GET['pag']-1)*$RegistrosAMostrar;
	$PagAct=$_GET['pag'];
//caso contrario los iniciamos
}else{
	$RegistrosAEmpezar=0;
	$PagAct=1;
}
	
	$sql = "SELECT tb_informe_header.id_informe, tb_informe_header.n_paciente, tb_informe_header.fecha_agenda, tb_informe_header.id_sede, tb_paciente.n_documento, tb_paciente.nom1, tb_paciente.nom2, tb_paciente.ape1, tb_paciente.ape2, tb_servicio.desc_servicio, tb_sede.desc_sede, tb_estado.desc_estado
FROM tb_servicio
INNER JOIN (
tb_sede
INNER JOIN (
tb_paciente
INNER JOIN (
tb_estado
INNER JOIN tb_informe_header ON tb_estado.id_estado = tb_informe_header.estado
) ON tb_paciente.n_documento = tb_informe_header.n_paciente
) ON tb_sede.id_sede = tb_informe_header.id_sede
) ON tb_servicio.id_servicio = tb_informe_header.id_servicio
WHERE tb_informe_header.n_paciente = tb_paciente.n_documento ";	
										
	// Vericamos si hay algun filtro
	$sql .= ($vnm != '')      ? " AND CONCAT(nom1,' ', nom2,' ', ape1,' ', ape2, ' ', n_paciente) LIKE '%$vnm%'" : "";
	$sql .= ($vsede > 0)      ? " AND tb_informe_header.id_sede = '".$vsede."'" : "";
	$sql .= ($vdel && $val)   ? " AND tb_informe_header.fecha_agenda BETWEEN '".$vdel."' AND '".$val."' " : "";
	
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
			'fechaAgenda' => $row['fecha_agenda'],
			'paciente'    => $row['nom1']."&nbsp;".$row['nom2']."&nbsp;".$row['ape1']."&nbsp;".$row['ape2'],
			'idpaciente'  => $row['n_documento'],
			'servicios'   => $row['desc_servicio'],
			'sedes'       => $row['desc_sede'],
			'estado'      => $row['desc_estado'],
			'variab'	  => $row['id_informe']
		);
	}
	// convertimos el array de datos a formato json
	echo json_encode($datos);
}
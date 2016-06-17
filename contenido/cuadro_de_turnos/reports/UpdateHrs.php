<?php 
	include('../../../dbconexion/conexion.php');
	$cn = Conectarse();
	//declaracion de variables con post
	$Idturno = $_POST['idTurno'];
	//consulta
	$sql = mysql_query("SELECT * FROM turno_funcionario WHERE idturno='$Idturno'", $cn);
	$res = mysql_fetch_array($sql);
	
	$hrAlmuerzo = $res['hralmuerzo'];
	
	if($hrAlmuerzo==2)
	{
		//si al turno ya se le ha sacado la hora de almuerzo
		$diurna = $res['diurna'];
		$diufes = $res['diurnafest'];
		
		if($diurna==0 && $diufes>0)
		{
			$nuevo = ($diufes+1);
			//consulta
			mysql_query("UPDATE turno_funcionario SET diurnafest='$nuevo', hralmuerzo=1 WHERE idturno='$Idturno'", $cn);
		}
		else
		{
			$nuevo = ($diurna+1);
			//consulta
			mysql_query("UPDATE turno_funcionario SET diurna='$nuevo', hralmuerzo=1 WHERE idturno='$Idturno'", $cn);
		}
	}
	else
	{
		//sino se ha sacado la hora de almuerzo
		$diurna = $res['diurna'];
		$diufes = $res['diurnafest'];
		
		if($diurna==0 && $diufes>0)
		{
			$nuevo = ($diufes-1);
			//consulta
			mysql_query("UPDATE turno_funcionario SET diurnafest='$nuevo', hralmuerzo=2 WHERE idturno='$Idturno'", $cn);
		}
		else
		{
			$nuevo = ($diurna-1);
			//consulta
			mysql_query("UPDATE turno_funcionario SET diurna='$nuevo', hralmuerzo=2 WHERE idturno='$Idturno'", $cn);
		}
	}
?>
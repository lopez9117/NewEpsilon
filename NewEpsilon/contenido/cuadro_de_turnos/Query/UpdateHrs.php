<?php 
include('../../../dbconexion/conexion.php');
$cn = Conectarse();
//declaracion de variables con post
$Idturno = $_POST['idTurno'];
$valor = $_POST['valor'];
//consulta
$sql = mysql_query("SELECT diurna, diurnafest, hralmuerzo FROM turno_funcionario WHERE idturno = '$Idturno'", $cn);
$res = mysql_fetch_array($sql);
$diurna = $res['diurna'];
$diufes = $res['diurnafest'];
$hrAlmuerzo = $res['hralmuerzo'];

//si el registro hora de almuerzo equivale a 1 significa que no se aplican restas a las horas
if($hrAlmuerzo==1)
{
	if($valor==2)
	{
		//restar una hora de almuerzo a las horas diurnas
		mysql_query("UPDATE turno_funcionario SET hralmuerzo = '$valor' WHERE idturno = '$Idturno'", $cn);
		//echo 'Se resto una hora de almuerzo';
		if($diurna==0 && $diufes>0)
		{
			//consulta
			mysql_query("UPDATE turno_funcionario SET diurnafest = (diurnafest-'1') WHERE idturno = '$Idturno'", $cn);
		}
		else
		{
			//consulta
			mysql_query("UPDATE turno_funcionario SET diurna = (diurna-'1') WHERE idturno = '$Idturno'", $cn);
		}
	}
	elseif($valor==3)
	{
		//restar media hora (0.5) a la horas diurnas
		mysql_query("UPDATE turno_funcionario SET hralmuerzo = '$valor' WHERE idturno = '$Idturno'", $cn);
		//echo 'Se resto media hora de almuerzo';
		if($diurna==0 && $diufes>0)
		{
			//consulta
			mysql_query("UPDATE turno_funcionario SET diurnafest = (diurnafest-'0.5') WHERE idturno = '$Idturno'", $cn);
		}
		else
		{
			//consulta
			mysql_query("UPDATE turno_funcionario SET diurna = (diurna-'0.5') WHERE idturno = '$Idturno'", $cn);
		}
	}
}
elseif($hrAlmuerzo==2)
{
	//ya se resto una hora de almuerzo
	if($valor==1)
	{
		//sumar una hora a las horas diurnas
		mysql_query("UPDATE turno_funcionario SET hralmuerzo = '$valor' WHERE idturno = '$Idturno'", $cn);
		//echo 'Se sumo una hora de almuerzo';
		if($diurna==0 && $diufes>0)
		{
			//consulta
			mysql_query("UPDATE turno_funcionario SET diurnafest = (diurnafest+'1') WHERE idturno = '$Idturno'", $cn);
		}
		else
		{
			//consulta
			mysql_query("UPDATE turno_funcionario SET diurna = (diurna+'1') WHERE idturno = '$Idturno'", $cn);
		}
	}
	elseif($valor==3)
	{
		//sumar media hora a las horas diurnas (0.5)
		mysql_query("UPDATE turno_funcionario SET hralmuerzo = '$valor' WHERE idturno = '$Idturno'", $cn);
		//echo 'Se sumo media hora de almuerzo';
		if($diurna==0 && $diufes>0)
		{
			//consulta
			mysql_query("UPDATE turno_funcionario SET diurnafest = (diurnafest+'0.5') WHERE idturno = '$Idturno'", $cn);
		}
		else
		{
			//consulta
			mysql_query("UPDATE turno_funcionario SET diurna = (diurna+'0.5') WHERE idturno = '$Idturno'", $cn);
		}
		
	}
}
elseif($hrAlmuerzo==3)
{
	if($valor==1)
	{
		//sumar a las horas diurnas media hora (0.5)
		mysql_query("UPDATE turno_funcionario SET hralmuerzo = '$valor' WHERE idturno = '$Idturno'", $cn);
		//echo 'Se sumo media hora de almuerzo';
		if($diurna==0 && $diufes>0)
		{
			//consulta
			mysql_query("UPDATE turno_funcionario SET diurnafest = (diurnafest+'0.5') WHERE idturno = '$Idturno'", $cn);
		}
		else
		{
			//consulta
			mysql_query("UPDATE turno_funcionario SET diurna = (diurna+'0.5') WHERE idturno = '$Idturno'", $cn);
		}
	}
	elseif($valor==2)
	{
		//restar media hora a las horas diurnas (0.5)
		mysql_query("UPDATE turno_funcionario SET hralmuerzo = '$valor' WHERE idturno = '$Idturno'", $cn);
		//echo 'Se sumo media hora de almuerzo';
		if($diurna==0 && $diufes>0)
		{
			//consulta
			mysql_query("UPDATE turno_funcionario SET diurnafest = (diurnafest-'0.5') WHERE idturno = '$Idturno'", $cn);
		}
		else
		{
			//consulta
			mysql_query("UPDATE turno_funcionario SET diurna = (diurna-'0.5') WHERE idturno = '$Idturno'", $cn);
		}
	}
}
?>
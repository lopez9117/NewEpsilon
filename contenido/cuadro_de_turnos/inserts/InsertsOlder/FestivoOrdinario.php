<?php
	//calcular el total de horas del turno
	$dif = $fin - $ini;
	$difh = floor($dif/3600);
	$difm = floor(($dif-($difh*3600))/60);
	$total_hrs_dia = date("H:i",mktime($difh,$difm));
	$desglose = split(":", $total_hrs_dia);
	$t_horas = $desglose[0]+$desglose[1]/60;
	
if($ini>=$ref_diurna && $ini<$ref_nocturna && $fin>$ref_cambio && $fin<=$ref_diurna)
{
	//calcular horas diurnas y nocturnas en el turno
	$dif_2 = $ref_nocturna - $ini;
	$difh_2 = floor($dif_2/3600);
	$difm_2 = floor(($dif_2-($difh_2*3600))/60);
	$total_hrs_dia_2 = date("H:i",mktime($difh_2,$difm_2));
	$desglose_2 = split(":", $total_hrs_dia_2);
	$t_horas_2 = $desglose_2[0]+$desglose_2[1]/60;
	//echo"total de horas diurnas del primer dia: ".$t_horas_2; echo "<br>";
	//Calcular horas nocturnas antes de las 12 de la noche
	$dif_3 = $ref_cambio - $ref_nocturna;
	$difh_3 = floor($dif_3/3600);
	$difm_3 = floor(($dif_3-($difh_3*3600))/60);
	$total_hrs_dia_3 = date("H:i",mktime($difh_3,$difm_3));
	$desglose_3 = split(":", $total_hrs_dia_3);
	$t_horas_3 = $desglose_3[0]+$desglose_3[1]/60;
	//echo"total de horas nocturnas antes de las 12: ".$t_horas_3; echo "<br>";
	//Calcular horas nocturnas despues de las 12 de la noche y antes de las 6 am
	$dif_4 = $fin - $ref_cambio;
	$difh_4 = floor($dif_4/3600);
	$difm_4 = floor(($dif_4-($difh_4*3600))/60);
	$total_hrs_dia_4 = date("H:i",mktime($difh_4,$difm_4));
	$desglose_4 = split(":", $total_hrs_dia_4);
	$t_horas_4 = $desglose_4[0]+$desglose_4[1]/60;
	//echo"total de horas nocturnas despues de las 12: ".$t_horas_4; echo "<br>";
	$t_horas_diurnas = $t_horas_2;
	$t_horas_nocturnas = $t_horas_3 + $t_horas_4;
	mysql_query("INSERT INTO turno_funcionario (idfuncionario, hr_inicio, hr_fin, fecha, currentuser, idtipo_turno, diurna, diurnafest, nocturna, nocturnafest, idConvencion, idsede, idgrupo_empleado, idservicio, hralmuerzo) VALUES('$funcionario','$hora_ini','$hora_fin','$fecha','$CurrentUser','0','0','$t_horas_2','$t_horas_4','$t_horas_3','$idConvencion','$sede','$grupoEmpleado','$servicio','1')");
}
else
{
	if($ini>=$ref_diurna && $ini<$ref_nocturna && $fin>$ref_cambio && $fin>$ref_diurna)
	{
		//calcular horas diurnas y nocturnas en el turno
		$dif_2 = $ref_nocturna - $ini;
		$difh_2 = floor($dif_2/3600);
		$difm_2 = floor(($dif_2-($difh_2*3600))/60);
		$total_hrs_dia_2 = date("H:i",mktime($difh_2,$difm_2));
		$desglose_2 = split(":", $total_hrs_dia_2);
		$t_horas_2 = $desglose_2[0]+$desglose_2[1]/60;
		//echo"total de horas diurnas del primer dia: ".$t_horas_2; echo "<br>";
		//Calcular horas nocturnas antes de las 12 de la noche
		$dif_3 = $ref_cambio - $ref_nocturna;
		$difh_3 = floor($dif_3/3600);
		$difm_3 = floor(($dif_3-($difh_3*3600))/60);
		$total_hrs_dia_3 = date("H:i",mktime($difh_3,$difm_3));
		$desglose_3 = split(":", $total_hrs_dia_3);
		$t_horas_3 = $desglose_3[0]+$desglose_3[1]/60;
		//echo"total de horas nocturnas antes de las 12: ".$t_horas_3; echo "<br>";
		//Calcular horas nocturnas despues de las 12 de la noche y antes de las 6 am
		$dif_4 = $ref_diurna - $ref_cambio;
		$difh_4 = floor($dif_4/3600);
		$difm_4 = floor(($dif_4-($difh_4*3600))/60);
		$total_hrs_dia_4 = date("H:i",mktime($difh_4,$difm_4));
		$desglose_4 = split(":", $total_hrs_dia_4);
		$t_horas_4 = $desglose_4[0]+$desglose_4[1]/60;
		//echo"total de horas nocturnas despues de las 12: ".$t_horas_4; echo "<br>";
		//Calcular horas diurnas despues de las 6 am
		$dif_5 = $fin - $ref_diurna;
		$difh_5 = floor($dif_5/3600);
		$difm_5 = floor(($dif_5-($difh_5*3600))/60);
		$total_hrs_dia_5 = date("H:i",mktime($difh_5,$difm_5));
		$desglose_5 = split(":", $total_hrs_dia_5);
		$t_horas_5 = $desglose_5[0]+$desglose_5[1]/60;
		//echo"total de horas diurnas despues de las 6 am: ".$t_horas_5; echo "<br>";
		$t_horas_diurnas = $t_horas_2 + $t_horas_5;
		$t_horas_nocturnas = $t_horas_3 + $t_horas_4;
		mysql_query("INSERT INTO turno_funcionario (idfuncionario, hr_inicio, hr_fin, fecha, currentuser, idtipo_turno, diurna, diurnafest, nocturna, nocturnafest, idConvencion, idsede, idgrupo_empleado, idservicio, hralmuerzo) VALUES('$funcionario','$hora_ini','$hora_fin','$fecha','$CurrentUser','0','$t_horas_5','$t_horas_2','$t_horas_4','$t_horas_3','$idConvencion','$sede','$grupoEmpleado','$servicio','1')");
	}
	else
	{
		if($ini>=$ref_nocturna && $fin>$ref_cambio && $fin<=$ref_diurna)
		{
			//Calcular horas nocturnas antes de las 12 de la noche
			$dif_2 = $ref_cambio - $ini;
			$difh_2 = floor($dif_2/3600);
			$difm_2 = floor(($dif_2-($difh_2*3600))/60);
			$total_hrs_dia_2 = date("H:i",mktime($difh_2,$difm_2));
			$desglose_2 = split(":", $total_hrs_dia_2);
			$t_horas_2 = $desglose_2[0]+$desglose_2[1]/60;
			//echo"total de horas nocturnas antes de las 12: ".$t_horas_2; echo "<br>";
			//Calcular horas nocturnas despues de las 12 de la noche y antes de las 6 am
			$dif_3 = $fin - $ref_cambio;
			$difh_3 = floor($dif_3/3600);
			$difm_3 = floor(($dif_3-($difh_3*3600))/60);
			$total_hrs_dia_3 = date("H:i",mktime($difh_3,$difm_3));
			$desglose_3 = split(":", $total_hrs_dia_3);
			$t_horas_3 = $desglose_3[0]+$desglose_3[1]/60;
			//echo"total de horas nocturnas despues de las 12: ".$t_horas_3; echo "<br>";
			$t_horas_nocturnas = $t_horas_2 + $t_horas_3;
			mysql_query("INSERT INTO turno_funcionario (idfuncionario, hr_inicio, hr_fin, fecha, currentuser, idtipo_turno, diurna, diurnafest, nocturna, nocturnafest, idConvencion, idsede, idgrupo_empleado, idservicio, hralmuerzo) VALUES('$funcionario','$hora_ini','$hora_fin','$fecha','$CurrentUser','0','0','0','$t_horas_3','$t_horas_2','$idConvencion','$sede','$grupoEmpleado','$servicio','1')");
		}
		else
		{
			if($ini>=$ref_nocturna && $fin>$ref_cambio && $fin>$ref_diurna && $fin<=$ref_nocturna )
			{
				//Calcular horas nocturnas antes de las 12 de la noche
				$dif_2 = $ref_cambio - $ini;
				$difh_2 = floor($dif_2/3600);
				$difm_2 = floor(($dif_2-($difh_2*3600))/60);
				$total_hrs_dia_2 = date("H:i",mktime($difh_2,$difm_2));
				$desglose_2 = split(":", $total_hrs_dia_2);
				$t_horas_2 = $desglose_2[0]+$desglose_2[1]/60;
				//echo"total de horas nocturnas antes de las 12: ".$t_horas_2; echo "<br>";
				//Calcular horas nocturnas despues de las 12 de la noche y antes de las 6 am
				$dif_3 = $ref_diurna - $ref_cambio;
				$difh_3 = floor($dif_3/3600);
				$difm_3 = floor(($dif_3-($difh_3*3600))/60);
				$total_hrs_dia_3 = date("H:i",mktime($difh_3,$difm_3));
				$desglose_3 = split(":", $total_hrs_dia_3);
				$t_horas_3 = $desglose_3[0]+$desglose_3[1]/60;
				//echo"total de horas nocturnas despues de las 12: ".$t_horas_3; echo "<br>";
				//Calcular horas diurnas despues de las 6 am y hasta las 10 pm
				$dif_4 = $fin - $ref_diurna;
				$difh_4 = floor($dif_4/3600);
				$difm_4 = floor(($dif_4-($difh_4*3600))/60);
				$total_hrs_dia_4 = date("H:i",mktime($difh_4,$difm_4));
				$desglose_4 = split(":", $total_hrs_dia_4);
				$t_horas_4 = $desglose_4[0]+$desglose_4[1]/60;
				//echo"total de horas diurnas despues de las 6 am: ".$t_horas_4; echo "<br>";
				$t_horas_diurnas = $t_horas_4;
				$t_horas_nocturnas = $t_horas_3 + $t_horas_2;
				mysql_query("INSERT INTO turno_funcionario (idfuncionario, hr_inicio, hr_fin, fecha, currentuser, idtipo_turno, diurna, diurnafest, nocturna, nocturnafest, idConvencion, idsede, idgrupo_empleado, idservicio, hralmuerzo) VALUES('$funcionario','$hora_ini','$hora_fin','$fecha','$CurrentUser','0','$t_horas_4','0','$t_horas_3','$t_horas_2','$idConvencion','$sede','$grupoEmpleado','$servicio','1')");
			}
		}
	}
}
?>
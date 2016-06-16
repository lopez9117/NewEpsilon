<?php
//calcular el total de horas del turno
$dif = $fin - $ini;
$difh = floor($dif/3600);
$difm = floor(($dif-($difh*3600))/60);
$total_hrs_dia = date("H:i",mktime($difh,$difm));
$desglose = split(":", $total_hrs_dia);
$t_horas = $desglose[0]+$desglose[1]/60;
//echo 'Horas del turno: '.$t_horas = $desglose[0]+$desglose[1]/60; echo '<br>';
//validar si el horario esta entre las 00:00 y las 06:00
if($ini>=$ref_cambio && $fin<=$ref_diurna && $fin>$ini)
{
	//+++++++++++++++++++ nocturnas entre la hora inicial y las 06:00
	$dif2 = $fin - $ini;
	$difHrs = floor($dif2/3600);
	$difMin = floor(($dif2-($difHrs*3600))/60);	
	$totalHoras = date("H:i",mktime($difHrs,$difMin));	
	$DesgHoras = split(":", $totalHoras);
	$totalNocturnas = $DesgHoras[0]+$DesgHoras[1]/60;	
	//echo 'Horas nocturnas de 00:00 hasta las 06:00: '.$totalNocturnas;
	mysql_query("INSERT INTO turno_funcionario (idfuncionario, hr_inicio, hr_fin, fecha, currentuser, idtipo_turno, diurna, diurnafest, nocturna, nocturnafest, idConvencion, idsede, idgrupo_empleado, idservicio, hralmuerzo) VALUES('$funcionario','$hora_ini','$hora_fin','$fecha','$CurrentUser','0','0','0','0','$totalNocturnas','$idConvencion','$sede','$grupoEmpleado','$servicio','1')");
}
else
{
	//validar si el horario esta entre las 00:00 y las 22:00
	if($ini>=$ref_cambio && $ini<=$ref_diurna && $fin>$ref_diurna && $fin<=$ref_nocturna)
	{
		//+++++++++++++++++++ nocturnas entre la hora inicial y las 06:00
		$dif2 = $ref_diurna - $ini;
		$difHrs2 = floor($dif2/3600);
		$difMin2 = floor(($dif2-($difHrs2*3600))/60);	
		$totalHoras2 = date("H:i",mktime($difHrs2,$difMin2));
		$DesgHoras2 = split(":", $totalHoras2);
		$totalNocturnas = $DesgHoras2[0]+$DesgHoras2[1]/60;	
		//echo 'Horas nocturnas de 00:00 hasta las 06:00: '.$totalNocturnas; echo '<br>';
		//++++++++++++++++++++ diurnas entre las 06:00 y las 22:00
		$dif3 = $fin - $ref_diurna;
		$difHrs3 = floor($dif3/3600);
		$difMin3 = floor(($dif3-($difHrs3*3600))/60);	
		$totalHoras3 = date("H:i",mktime($difHrs3,$difMin3));
		$DesgHoras3 = split(":", $totalHoras3);
		$totalDiurnas = $DesgHoras3[0]+$DesgHoras3[1]/60;	
		//echo 'Horas diurnas de 06:00 hasta las '.$hora_fin.'&nbsp;'.$totalDiurnas; echo '<br>';
		mysql_query("INSERT INTO turno_funcionario (idfuncionario, hr_inicio, hr_fin, fecha, currentuser, idtipo_turno, diurna, diurnafest, nocturna, nocturnafest, idConvencion, idsede, idgrupo_empleado, idservicio, hralmuerzo) VALUES('$funcionario','$hora_ini','$hora_fin','$fecha','$CurrentUser','0','0','$totalDiurnas','0','$totalNocturnas','$idConvencion','$sede','$grupoEmpleado','$servicio','1')");
	}
	else
	{
		//horas diurnas despues de las 06:00 y hasta la hora final
		if($ini>=$ref_diurna && $fin<=$ref_nocturna && $fin!=$ref_cambio && $fin>$ini)
		{
			//++++++++++++++++ Diurnas entre la hora inicial y la hora final
			$dif2 = $fin - $ini;
			$difHrs = floor($dif2/3600);
			$difMin = floor(($dif2-($difHrs*3600))/60);	
			$totalHoras = date("H:i",mktime($difHrs,$difMin));	
			$DesgHoras = split(":", $totalHoras);
			$totalDiurnas = $DesgHoras[0]+$DesgHoras[1]/60;	
			//echo 'Horas Diurnas de '.$hora_ini.' hasta las '.$hora_fin.' '.$totalDiurnas;
			mysql_query("INSERT INTO turno_funcionario (idfuncionario, hr_inicio, hr_fin, fecha, currentuser, idtipo_turno, diurna, diurnafest, nocturna, nocturnafest, idConvencion, idsede, idgrupo_empleado, idservicio, hralmuerzo) VALUES('$funcionario','$hora_ini','$hora_fin','$fecha','$CurrentUser','0','0','$totalDiurnas','0','0','$idConvencion','$sede','$grupoEmpleado','$servicio','1')");
		}
		else
		{
			//validar horas despues de las 06:00 y hasta despues de las 22:00
			if($ini>=$ref_diurna && $fin>=$ref_nocturna || $fin==$ref_cambio)
			{
				//++++++++++++++++ Diurnas entre la hora inicial las 22:00
				$dif2 = $ref_nocturna - $ini;
				$difHrs2 = floor($dif2/3600);
				$difMin2 = floor(($dif2-($difHrs2*3600))/60);	
				$totalHoras2 = date("H:i",mktime($difHrs2,$difMin2));	
				$DesgHoras2 = split(":", $totalHoras2);
				$totalDiurnas = $DesgHoras2[0]+$DesgHoras2[1]/60;
				//echo 'Horas Diurnas de '.$hora_ini.' hasta las 22:00 '.$totalDiurnas; echo '<br>';
				//++++++++++++++++ Nocturnas entre las 22:00 y la hora final
				$dif3 = $fin - $ref_nocturna;
				$difHrs3 = floor($dif3/3600);
				$difMin3 = floor(($dif3-($difHrs3*3600))/60);	
				$totalHoras3 = date("H:i",mktime($difHrs3,$difMin3));	
				$DesgHoras3 = split(":", $totalHoras3);
				$totalNocturnas = $DesgHoras3[0]+$DesgHoras3[1]/60;
				//echo 'Total nocturnas desde las 22:00 hasta '.$hora_fin.'&nbsp;'.$totalNocturnas.' ';echo '<br>';
				mysql_query("INSERT INTO turno_funcionario (idfuncionario, hr_inicio, hr_fin, fecha, currentuser, idtipo_turno, diurna, diurnafest, nocturna, nocturnafest, idConvencion, idsede, idgrupo_empleado, idservicio, hralmuerzo) VALUES('$funcionario','$hora_ini','$hora_fin','$fecha','$CurrentUser','0','0','$totalDiurnas','0','$totalNocturnas','$idConvencion','$sede','$grupoEmpleado','$servicio','1')");
			}
		}
	}
}
?>
<?php
//Conexion a la base de datos
include('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//variables
$servicio = base64_decode($_GET['servicio']);
$fechaInicial = base64_decode($_GET['fechaInicial']);
$fechaLimite = base64_decode($_GET['fechaLimite']);
$sede = base64_decode($_GET['sede']);
//consultar el nombre de la sede
$sqlSede = mysql_query("SELECT descsede FROM sede WHERE idsede = '$sede'",$cn);
$regSede = mysql_fetch_array($sqlSede);
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Costos".$regSede['descsede'].'-'.$fechaInicial.'-'.$fechaLimite.".xls");
?>
<style type="text/css">
	table{font-family:Tahoma, Geneva, sans-serif;
	font-size:12px;
	}
</style>
<table width="100%" border="1" rules="all">
  <tr>
    <td colspan="5"><strong>Sede <?php echo $regSede['descsede']?></strong></td>
  </tr>
<?php
//consultar los servicios prestados en la sede
$sqlServicio = mysql_query("SELECT DISTINCT(t.idservicio), ser.descservicio FROM turno_funcionario t 
INNER JOIN servicio ser ON ser.idservicio = t.idservicio
WHERE idsede = '$sede' AND fecha BETWEEN '$fechaInicial' AND '$fechaLimite'", $cn);
//imprimir los diferentes servicios prestados en una sede
while($rowServicio = mysql_fetch_array($sqlServicio))
{
	$idServicio = $rowServicio['idservicio'];
	echo 
	'<tr>
		<td colspan="5" bgcolor="#00CCFF">Servicio: '.$rowServicio['descservicio'].'</td>
	</tr>';
	//consultar los diferentes grupos de empleados participantes en el servicio seleccionado
    $SqlGrupo = mysql_query("SELECT DISTINCT(t.idgrupo_empleado), g.desc_grupoempleado FROM turno_funcionario t
    INNER JOIN grupo_empleado g ON g.idgrupo_empleado = t.idgrupo_empleado
    WHERE idservicio = '$idServicio' AND fecha BETWEEN '$fechaInicial' AND '$fechaLimite' AND t.idsede = '$sede'", $cn);
	//imprimir la variable de grupos encontrados en la cosulta
    while($rowGrupo = mysql_fetch_array($SqlGrupo))
    {
        $idGrupo = $rowGrupo['idgrupo_empleado'];
        //consultar la cantidad de horas empleadas por cada grupo en el servicio seleccionado
        $SqlContadorHoras = mysql_query("SELECT SUM(diurna) AS diurna, SUM(nocturna) AS nocturna, SUM(diurnafest) AS diurnafest, SUM(nocturnafest) AS nocturnafest, SUM(diurna+nocturna+diurnafest+nocturnafest) AS total
        FROM turno_funcionario WHERE fecha BETWEEN '$fechaInicial' AND '$fechaLimite' AND idsede = '$sede' AND idgrupo_empleado = '$idGrupo' AND idservicio = '$idServicio'", $cn);
        $RegContadorHoras = mysql_fetch_array($SqlContadorHoras);
        echo 
        '<tr>
            <td colspan="5" bgcolor="#00CCFF"><strong>'.$rowGrupo['desc_grupoempleado'].'</strong></td>
        </tr>
		<tr>
            <td><strong>Diurnas</strong></td>
            <td><strong>Nocturnas</strong></td>
            <td><strong>Diurnas Festivas</strong></td>
            <td><strong>Nocturnas Festivas</strong></td>
            <td><strong>Total</strong></td>
        </tr>
        <tr>
            <td>'.$RegContadorHoras['diurna'].'</td>
            <td>'.$RegContadorHoras['nocturna'].'</td>
            <td>'.$RegContadorHoras['diurnafest'].'</td>
            <td>'.$RegContadorHoras['nocturnafest'].'</td>
            <td>'.$RegContadorHoras['total'].'</td>
        </tr>';
    }
}
?>
</table>
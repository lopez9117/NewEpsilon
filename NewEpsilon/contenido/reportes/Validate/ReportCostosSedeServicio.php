<?php 
//declaracion de variables
$mes = $_GET['mes'];
$anio = $_GET['anio'];
$sede = $_GET['sede'];
//desglosar fecha para obtener la cantidad de dias que tiene el mes
$dias = date('t', mktime(0,0,0, $mes, 1, $anio));
//crear variables con fechas para la consulta
$fechaInicial = $anio.'-'.$mes.'-'.'01';
$fechaLimite = $anio.'-'.$mes.'-'.$dias;
?> 
<style type="text/css">
	table{font-family:Tahoma, Geneva, sans-serif; font-size:16px;}
</style>
 <table width="100%">
 	<tr>
    	<td align="center"><a href="ReporteCostosSedeServicioExcel.php?grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&fechaInicial=<?php echo base64_encode($fechaInicial)?>&fechaLimite=<?php echo base64_encode($fechaLimite)?>&sede=<?php echo base64_encode($sede)?>&servicio=<?php echo base64_encode($servicio)?>" alt="Descargar reporte en excel" title="Descargar reporte en excel"><strong>Descargar Excel</strong></font></a></td>
    </tr>
 </table>
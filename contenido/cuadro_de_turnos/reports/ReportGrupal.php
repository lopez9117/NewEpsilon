<?php 
//Conexion a la base de datos
include('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
$GrupoEmpleado = $_GET['GrupoEmpleado'];
$mes = $_GET['mes'];
$anio = $_GET['anio'];
//consultar horas laborables mes
$sqlLab = mysql_query("SELECT cant_horas FROM hora_mensual WHERE mes = '$mes'");
$resLab = mysql_fetch_array($sqlLab);
//desglosar fecha para obtener la cantidad de dias que tiene el mes
$dias = date('t', mktime(0,0,0, $mes, 1, $anio));
//dia finalizacion del mes
$fecha_limite = $anio."-".$mes."-".$dias;
//variable para iniciar la fecha
$fechaInicial = ($anio.'-'.$mes.'-'.'01');
//Verificar si existen registros asociados con la busqueda
$sqlValidacion =  mysql_query("SELECT DISTINCT idfuncionario FROM turno_funcionario WHERE fecha BETWEEN '$fechaInicial' AND '$fecha_limite' AND idgrupo_empleado = '$GrupoEmpleado'", $cn);
$resValidacion = mysql_num_rows($sqlValidacion);

?> 
 <script type="text/javascript">
 $(document).ready(function(){
   $('#ListadoEspecialistas').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers", //DAMOS FORMATO A LA PAGINACION(NUMEROS)
		"aaSorting": [[ 2, "asc" ]],
"aoColumns": [null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]
    } );
})
 </script>
 <title>.: Reporte Prodiagnostico S.A :.</title>
 <table width="100%">
 	<tr>
    	<td align="right"><a href="ReporteGrupoEmpleadosExcel.php?GrupoEmpleado=<?php echo base64_encode($GrupoEmpleado)?>&fechaInicial=<?php echo base64_encode($fechaInicial)?>&fecha_limite=<?php echo base64_encode($fecha_limite)?>&anio=<?php echo base64_encode($anio)?>&mes=<?php echo base64_encode($mes)?>" alt="Descargar reporte en excel" title="Descargar reporte en excel">Descargar Excel</font></a></td>
    </tr>
 </table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListadoEspecialistas">
<thead>
    <tr>
        <th align="left">Documento</th>
        <th align="left">Funcionario</th>
        <th align="left">Ciudad</th>
        <th align="left">D.O</th>
        <th align="left">N.O</th>
        <th align="left">D.F</th>
        <th align="left">N.F</th>
        <th align="left">L.M</th>
        <th align="left">T.T</th>
        <th align="left">D.O<br>Add</th>
        <th align="left">N.O<br>Add</th>
        <th align="left">D.F<br>Add</th>
        <th align="left">N.F<br>Add</th>
        <th align="left">T.N</th>
        <th align="center">Detalles</th>
    </tr>
</thead>
<tfoot>
<tr>
    <th></th>
    <th></th>
    <th></th>  
    <th></th>
    <th></th>
    <th></th> 
    <th></th>
    <th></th>
    <th></th>                   
</tr>
</tfoot>
  <tbody>
    <?php
   while($rowFuncionario = mysql_fetch_array($sqlValidacion))
	{	
		$idFuncionario = $rowFuncionario['idfuncionario'];
		//consultar datos de funcionario
		$sql = mysql_query("SELECT f.nombres, f.apellidos, m.nombre_mun  FROM funcionario f
INNER JOIN r_municipio m ON m.cod_mun = f.cod_mun
WHERE idfuncionario = '$idFuncionario'", $cn);
$res = mysql_fetch_array($sql);
		//consultar cantidad de horas en los turnos
		$sqlHora = mysql_query("SELECT SUM(diurna) AS diurna, SUM(nocturna) AS nocturna, SUM(diurnafest) AS diurnafest, SUM(nocturnafest) AS nocturnafest, SUM(diurna+nocturna+diurnafest+nocturnafest) AS total
		FROM turno_funcionario WHERE fecha BETWEEN '$fechaInicial' AND '$fecha_limite' AND idfuncionario='$idFuncionario'", $cn);
		$resHora = mysql_fetch_array($sqlHora);
		//consultar horas adicionales
		$conAdd = mysql_query("SELECT n.diurnas_adicionales, n.nocturnas_adicionales, n.diurfest_adicionales, n.nocfest_adicionales
FROM novedad_turno n INNER JOIN turno_funcionario t ON t.idturno = n.idturno
WHERE t.idfuncionario = '$idFuncionario' AND t.fecha BETWEEN '$fechaInicial' AND '$fecha_limite'", $cn);
		$rows = mysql_num_rows($conAdd);
		//sumar cantidades dentro de un ciclo
		$diurfest_adicionales = 0;
		$nocfest_adicionales = 0;
		$diurnas_adicionales = 0;
		$nocturnas_adicionales = 0;
	
		for($i=0; $i<$rows; $i++)
		{
			$ver = mysql_fetch_array($conAdd);
			$diurfest_adicionales = $diurfest_adicionales + $ver['diurfest_adicionales'];
			$nocfest_adicionales = $nocfest_adicionales + $ver['nocfest_adicionales'];
			$diurnas_adicionales = $diurnas_adicionales + $ver['diurnas_adicionales'];
			$nocturnas_adicionales = $nocturnas_adicionales + $ver['nocturnas_adicionales'];
		}
		//imprimir resultados
		echo '<tr>
				<td align="left">'.$idFuncionario.'</td>
				<td align="left">'.$res['nombres'].'<br>'.$res['apellidos'].'</td>
				<td align="left">'.$res['nombre_mun'].'</td>
				<td align="left">'.round($resHora['diurna'], 2).'</td>
				<td align="left">'.round($resHora['nocturna'], 2).'</td>
				<td align="left">'.round($resHora['diurnafest'], 2).'</td>
				<td align="left">'.round($resHora['nocturnafest'], 2).'</td>
				<td align="left">'.round($resLab['cant_horas'], 2).'</td>
				<td align="left">'.round($resHora['total'], 2).'</td>
				<td>'.round($diurnas_adicionales, 2).'</td>
				<td>'.round($nocturnas_adicionales, 2).'</td>
				<td>'.round($diurfest_adicionales, 2).'</td>
				<td>'.round($nocfest_adicionales, 2).'</td>
				<td>'.round($totalNovedad = $diurfest_adicionales + $nocfest_adicionales + $diurnas_adicionales + $nocturnas_adicionales, 2).'</td>
				<td align="center"><a target="_blank" href="ReporteIndividual.php?document='.base64_encode($idFuncionario).'&fchstart='.base64_encode($fechaInicial).'&fchstop='.base64_encode($fecha_limite).'&nomb='.base64_encode($res['nombres']).'&nbsp;'.base64_encode($res['apellidos']).'"><img src="../../../images/viewmag+.png" width="20" height="20" alt="Ver Detalles del informe" title="Ver Detalles del informe"/></a></td>
			  </tr>';
	}
    ?>
<tbody>
</table>
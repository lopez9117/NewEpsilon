<?php 
//Conexion a la base de datos
include('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
$mes = $_GET['mes'];
$anio = $_GET['anio'];
//desglosar fecha para obtener la cantidad de dias que tiene el mes
$dias = date('t', mktime(0,0,0, $mes, 1, $anio));
//dia finalizacion del mes
$fecha_limite = $anio."-".$mes."-".$dias;
//variable para iniciar la fecha
$fechaInicial = ($anio.'-'.$mes.'-'.'01');
//Verificar si existen registros asociados con la busqueda
$sqlDisponibilidad = mysql_query("SELECT DISTINCT(d.idfuncionario) AS idfuncionario, CONCAT(f.nombres,' ',f.apellidos) AS nombre
FROM ct_disponibilidad_funcionario d
INNER JOIN funcionario f ON f.idfuncionario = d.idfuncionario WHERE fecha BETWEEN '$fechaInicial' AND '$fecha_limite'", $cn);
?> 
 <script type="text/javascript">
 $(document).ready(function(){
   $('#ListadoEspecialistas').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers", //DAMOS FORMATO A LA PAGINACION(NUMEROS)
		"aaSorting": [[ 0, "asc" ]],
"aoColumns": [null, null, null, null, null]
    } );
})
 </script>
 <title>.: Reporte Prodiagnostico S.A :.</title>
 <table width="100%">
 	<tr>
    	<td align="right"><a href="ReporteDisponibilidadExcel.php?fechaInicial=<?php echo base64_encode($fechaInicial)?>&fecha_limite=<?php echo base64_encode($fecha_limite)?>&anio=<?php echo base64_encode($anio)?>&mes=<?php echo base64_encode($mes)?>" alt="Descargar reporte en excel" title="Descargar reporte en excel">Descargar Excel</font></a></td>
    </tr>
 </table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListadoEspecialistas">
<thead>
    <tr>
        <th align="left">Documento</th>
        <th align="left">Funcionario</th>
        <th align="left">Dias disponible</th>
        <th align="left">Cantidad de disponibilidades</th>
        <th align="center">Detalles</th>
    </tr>
</thead>
<tfoot>
<tr>
    <th></th>
    <th></th>
    <th></th>                   
</tr>
</tfoot>
  <tbody>
    <?php
  		while($rowDisponibilidad = mysql_fetch_array($sqlDisponibilidad))
		{
			$funcionario = $rowDisponibilidad['idfuncionario'];
			$nombre = $rowDisponibilidad['nombre'];
			//consultar los detalles de cada funcionario
			$cons = mysql_query("SELECT COUNT(fecha) AS cantidadDisponibilidad FROM ct_disponibilidad_funcionario
			WHERE idfuncionario = '$funcionario' AND fecha BETWEEN '$fechaInicial' AND '$fecha_limite'", $cn);
			$regs = mysql_fetch_array($cons);
			echo 
			'<tr>
				<td>'.$funcionario.'</td>
				<td>'.$nombre.'</td>
				<td>'.$regs['cantidadDisponibilidad'].'</td>
				<td>'.round(($regs['cantidadDisponibilidad']/7), 1).'</td>
				<td><a target="_blank" href="ReporteIndividual.php?document='.base64_encode($funcionario).'&fchstart='.base64_encode($fechaInicial).'&fchstop='.base64_encode($fecha_limite).'&nomb='.base64_encode($nombre).'"><img src="../../../images/viewmag+.png" width="20" height="20" alt="Ver Detalles del informe" title="Ver Detalles del informe"/></a></td>
			</tr>';
		}
    ?>
<tbody>
</table>
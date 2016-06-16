<?php 
//Conexion a la base de datos
require_once('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
$desde = $_POST[FechaDesde];
$hasta = $_POST[FechaHasta];
//consulta
//consultar las sedes que registraron estudios
$conSede = mysql_query("SELECT DISTINCT i.idsede, se.descsede FROM r_informe_header i 
INNER JOIN sede se ON se.idsede = i.idsede", $cn);
?>
 <script type="text/javascript">
 $(document).ready(function(){
   $('#Listad').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
    } );
})
 </script>
 <title>.: Sedes Prodiagnostico S.A :.</title>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="Listad">
<thead>
    <tr>
       <th align="center" width="33%">Sede</th>
        <th align="center" width="33%">Estudios / Procedimientos Realizados</th>
        <th align="center" width="33%">Descargar Informe</th>
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
		while ($regSede = mysql_fetch_array($conSede))
	   {
		   $idSede = $regSede[idsede];
		   //consultar la cantidad de estudios realizados en cada sede
		   $conCantidad1 = mysql_query("SELECT COUNT(l.id_informe) AS cantidad, i.idsede FROM r_log_informe l
			INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
			WHERE l.fecha BETWEEN '$desde' AND '$hasta' AND i.idsede = '$idSede' AND l.id_estadoinforme = '6' AND i.id_estadoinforme = '6' GROUP BY i.idsede");
			//
			$conCantidad2 = mysql_query("SELECT COUNT(l.id_informe) AS cantidad, i.idsede FROM r_log_informe l
			INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
			WHERE l.fecha BETWEEN '$desde' AND '$hasta' AND i.idsede = '$idSede' AND l.id_estadoinforme = '7' AND i.id_estadoinforme = '7' GROUP BY i.idsede");
			
			//mostrar la cantidad de estudios realizados en cada sede
	  		$regCantidad1 = mysql_fetch_array($conCantidad1);
			$regCantidad2 = mysql_fetch_array($conCantidad2);
			
			$total = ($regCantidad1[cantidad]+$regCantidad2[cantidad]);
			echo '<tr>';
		  	echo '<td align="center">'.mb_convert_encoding($regSede['descsede'], "UTF-8").'</td>';
		  	echo '<td align="center">'.$total.'</td>
        <td align="left" width="33%"><a href="reporteeventosadversos.php?sede='.$idSede.'&FchDesde='.$desde.'&FchHasta='.$hasta.'"><img src="../../images/excel.png" width="20" height="20" alt="Descargar informe Excel" title="Descargar informe Excel" /></a></th>
        <!--<th align="left" width="30%">Estadisticas</td>-->
    </tr>';
   }
    ?>
<tbody>
</table>
</body>
</html>
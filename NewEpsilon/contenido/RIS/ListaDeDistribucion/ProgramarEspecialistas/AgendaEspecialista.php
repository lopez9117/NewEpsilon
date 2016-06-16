<?php 
//Conexion a la base de datos
include('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$fechaDesde = $_GET['fechaDesde'];
$idEspecialista = $_GET['idEspecialista'];
$fechaDesde = date("Y-m-d",strtotime($fechaDesde));
//consultar la cantidad de estudios que estan agendados para la fecha especificada
$sqlagenda = mysql_query("SELECT he.idAut, he.idfuncionario, he.fecha, he.hr_desde, he.hr_hasta, CONCAT(f.nombres,' ',f.apellidos) AS especialista,
se.descsede, ser.descservicio FROM r_horario_especialista he
INNER JOIN funcionario f ON f.idfuncionario = he.idfuncionario
INNER JOIN sede se ON se.idsede = he.idsede
INNER JOIN servicio ser ON ser.idservicio = he.idservicio
WHERE he.fecha = '$fechaDesde' AND he.idfuncionario='$idEspecialista'", $cn);
?>
<script type="text/javascript">
 $(document).ready(function(){
   $('#Listado').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers",
		"aaSorting": [[ 5, "desc" ]],
"aoColumns": [ null, null, null, null, null, null, null, null ]
} );
} );
 </script>
 <table width="100%">
  <tr bgcolor="#E1DFE3">
    	<td width="50%"><strong>Especialistas agendados</strong></td>
        <td width="50%" align="right"></td>
    </tr>
 </table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="Listado">
<thead>
    <tr>
        <th align="left" width="10%">Id</th>
        <th align="left" width="20%">Especialista</th>
        <th align="left" width="15%">Sede</th>
        <th align="left" width="10%">Servicio</th>
        <th align="left" width="10%">Fecha</th>
        <th align="center" width="10%">Desde</th>
        <th align="center" width="10%">Hasta</th>
        <th align="center" width="15%">Tareas</th>
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
   while($reg =  mysql_fetch_array($sqlagenda))
   {
	   //Codificar variables para pasar por URL
	   $idInforme = base64_encode($reg['id_informe']);
	   $user = base64_encode($usuario);
	   $Fecha = $reg['fecha'];
	   list($año, $mes, $dia) = explode("-",$Fecha);
	   $Fecha=$dia.'/'.$mes.'/'.$año;
	   echo '<tr>';
	   echo '<td align="left">'.$reg['idfuncionario'].'</td>';
	   echo '<td align="left">'.$reg['especialista'].'</td>';
	   echo '<td align="left">'.$reg['descsede'].'</td>';
	   echo '<td align="left">'.$reg['descservicio'].'</td>';
	   echo '<td align="left">'.$reg['fecha'].'</td>';
	   echo '<td align="center">'.date("H:i", $reg['hr_desde']).'</td>';
	   echo '<td align="center">'.date("H:i", $reg['hr_hasta']).'</td>';
	   echo '<td align="center">';
	   echo '<table>';
	   ?>
	<td></td>
   	<td></td>
   	<td><a href="#" onClick="BorrarHorario('<?php echo $reg['idAut'] ?>')"><img src="../../../../images/button_cancel.png" width="15" height="15" title="Eliminar" alt="Eliminar" /></a></td>
   	<td></td>
	</tr>
	</table>
	   </tr>
       <?php
   }
    ?>
<tbody>
</table>
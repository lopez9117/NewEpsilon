<?php 
//Conexion a la base de datos
include('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$fechaDesde = $_GET['fechaDesde'];
$fechaHasta = $_GET['fechaHasta'];
$sede = $_GET['sede'];
$servicio = $_GET['servicio'];
$fechaDesde = date("Y-m-d",strtotime($fechaDesde));
//consultar la cantidad de estudios que estan agendados para la fecha especificada
$sqlagenda = mysql_query("SELECT DISTINCT(h.idfuncionario_esp) AS idfuncionario, CONCAT(f.nombres,' ',f.apellidos) AS especialista, se.descsede, ser.descservicio FROM r_informe_header h
INNER JOIN funcionario f ON f.idfuncionario = h.idfuncionario_esp
INNER JOIN sede se ON se.idsede = h.idsede
INNER JOIN servicio ser ON ser.idservicio = h.idservicio
LEFT JOIN r_log_informe l ON l.id_informe = h.id_informe
WHERE l.fecha BETWEEN '$fechaDesde' AND '$fechaHasta' AND h.idsede = '$sede' AND h.idservicio = '$servicio' GROUP BY h.idfuncionario_esp ASC", $cn);
?>
<script type="text/javascript">
 $(document).ready(function(){
   $('#distribucionDeEstudios').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers",
		"aaSorting": [[ 0, "asc" ]],
"aoColumns": [ null, null, null, null, null, null, null, null, null ]} );
} );
 </script>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="distribucionDeEstudios">
<thead>
<tr>
    <th align="left" width="20%">Especialista</th>
    <th align="left" width="15%">Sede</th>
    <th align="left" width="10%">Servicio</th>
    <?php
    //consultar los tipos de tecnicas activos
	$consTecnica = mysql_query("SELECT id_tecnica, desc_tecnica FROM r_tecnica WHERE idestado = '1' ORDER BY id_tecnica ASC", $cn);
	while($rowTecnica = mysql_fetch_array($consTecnica))
	{
		echo '<th align="center" width="10%">'.ucwords(strtolower($rowTecnica['desc_tecnica'])).'</th>';
	}
	?>
</tr>
</thead>
<tfoot>
<tr>
    <th></th>
    <th></th>
    <th></th>
    <th></th>                     
</tr>
</tfoot>
  <tbody>
<?php
while($reg =  mysql_fetch_array($sqlagenda))
{
	$idEspecialista = $reg['idfuncionario'];
	//consultar la cantidad de estudios asignados a cada especialista
	echo '<tr>';
	echo '<td align="left">'.ucwords(strtolower($reg['especialista'])).'</td>';
	echo '<td align="left">'.$reg['descsede'].'</td>';
	echo '<td align="left">'.$reg['descservicio'].'</td>';
	//consultar los tipos de tecnica
	$consTecnica = mysql_query("SELECT id_tecnica FROM r_tecnica WHERE idestado = '1' ORDER BY id_tecnica ASC", $cn);
	while($rowTecnica = mysql_fetch_array($consTecnica))
	{
		$idTecnica = $rowTecnica['id_tecnica'];
		$consulta = mysql_query("SELECT DISTINCT(h.id_informe) FROM r_informe_header h
		LEFT JOIN r_log_informe l ON l.id_informe = h.id_informe
		WHERE h.idfuncionario_esp = '$idEspecialista' AND l.fecha BETWEEN '$fechaDesde' AND '$fechaHasta' AND h.idsede = '$sede' AND h.idservicio = '$servicio' AND h.id_tecnica = '$idTecnica' GROUP BY h.id_informe", $cn);
		$registro = mysql_num_rows($consulta);
		echo '<td align="center">'.$registro.'</td>';
	}
   ?>
   </tr>
   <?php
}
?>
<tbody>
</table>
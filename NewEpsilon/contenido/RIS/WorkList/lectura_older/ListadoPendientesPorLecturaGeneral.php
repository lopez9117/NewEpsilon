<body onLoad="CargarAgenda()" onBlur="CargarAgenda()" onFocus="CargarAgenda()">
<?php 
//Conexion a la base de datos
require_once('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$fechaDesde = $_GET['fechaDesde'];
$fechaHasta = $_GET['fechaHasta'];
$usuario = $_GET['usuario'];
$fechaDesde = date("Y-m-d",strtotime($fechaDesde));
$fechaHasta = date("Y-m-d",strtotime($fechaHasta));
//consultar la cantidad de estudios que estan agendados para la fecha especificada
$sqlagenda = mysql_query("SELECT DISTINCT(i.id_informe) AS id_informe, i.id_paciente,CONCAT(p.nom1,' ', p.nom2,' ',
p.ape1,' ', p.ape2) AS nombre ,e.nom_estudio, pr.desc_prioridad, tp.desctipo_paciente, tec.desc_tecnica,
se.descsede, ser.descservicio, l.fecha, l.hora
FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
INNER JOIN sede se ON se.idsede = i.idsede
INNER JOIN servicio ser ON ser.idservicio = i.idservicio
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
WHERE i.idfuncionario_esp = '$usuario' AND i.id_estadoinforme = '2' AND l.fecha BETWEEN '$fechaDesde' AND '$fechaHasta' GROUP BY id_informe", $cn);
?>
<script type="text/javascript">
 $(document).ready(function(){
   $('#ListadoPendientesPorLecturaGeneral').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers",
		"aaSorting": [[ 6, "asc" ]],
"aoColumns": [ null, null, null, null, null, null, null, null, null, null ]
} );
} );
 </script>
 <table width="100%">
  <tr bgcolor="#E1DFE3">
    	<td><strong>Estudios pendientes por lectura <?php echo $regServicio['descservicio'] ?> en <?php echo $regSede['descsede'] ?></strong></td>
    </tr>
 </table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListadoPendientesPorLecturaGeneral">
<thead>
    <tr>
        <th align="left" width="8%">Id</th><!--Estado-->
        <th align="left" width="15%">Paciente</th>
        <th align="left" width="20%">Estudio</th>
        <th align="left" width="10%">Tecnica</th>
        <th align="left" width="10%">T.Paciente</th>
        <th align="center" width="5%">Prioridad</th>
        <th align="center" width="5%">Realización</th>
        <th align="center" width="10%">Sede</th>
        <th align="center" width="5%">Servicio</th>
        <th align="center" width="8%">Tareas</th>
    </tr>
</thead>
<tfoot>
<tr>
    <th></th>
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
	   //Codificar variables para pasar por URL
		$idInforme = base64_encode($reg['id_informe']);
		$user = base64_encode($usuario);
		$Fecha = $reg['fecha'];
		list($año, $mes, $dia) = explode("-",$Fecha);
		$Fecha=$dia.'/'.$mes.'/'.$año;
		echo '<tr>';
		echo '<td align="left">'.ucwords(strtolower($reg['id_paciente'])).'</td>';
		echo '<td align="left">'.ucwords(strtolower($reg['nombre'])).'</td>';
		echo '<td align="left">'.ucwords(strtolower($reg['nom_estudio'])).'</td>';
		echo '<td align="left">'.ucwords(strtolower($reg['desc_tecnica'])).'</td>';
		echo '<td align="left">'.ucwords(strtolower($reg['desctipo_paciente'])).'</td>';
		echo '<td align="center">'.ucwords(strtolower($reg['desc_prioridad'])).'</td>';
		echo '<td align="center">'.$Fecha.'<br>'.$reg['hora'].'</td>';
		echo '<td align="center">'.ucwords(strtolower($reg['descsede'])).'</td>';
		echo '<td align="center">'.ucwords(strtolower($reg['descservicio'])).'</td>';
		echo '<td align="center">';
		echo '<table>
	   	<tr>';
		$sqlAdjunto = mysql_query("SELECT ad.id_informe,ad.adjunto,ad.id_adjunto,i.id_informe FROM r_adjuntos ad
INNER JOIN r_informe_header i ON i.id_informe = ad.id_informe where i.id_informe='$reg[id_informe]'", $cn);
		$count = mysql_num_rows($sqlAdjunto);
		//Validar si se tienen archivos adjuntos.
		if ($count>=1)
		{
			echo '<td>';
			while($regAdjunto = mysql_fetch_array($sqlAdjunto))
   			{
				?>
			<a href="../ViewAttached.php?Attached=<?php echo base64_encode($regAdjunto['id_adjunto'])?>" target="orden" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../../images/pdf grande.png" width="15" height="15" title="Ver adjunto" alt="Ver adjunto" /></a>
			<?php
			}
		echo '</td>';
    	}
		else
		{
			echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
		}?>
	<td>   
   <a href="TranscribirAprobar.php?informe=<?php echo $idInforme?>&especialista=<?php echo $user ?>" target="transcripcion" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../../images/kate.png" width="15" height="15" title="Transcribir/Aprobar Estudios" alt="Transcribir/Aprobar Estudios" /></a>
   </td>
   <td><a href="DevolverEstudio.php?idInforme=<?php echo $idInforme?>&usuario=<?php echo $user ?>"  target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/reload.png" width="15" height="15" title="Regresar Estudio" alt="Regresar Estudio" /></a></td>
   <td><a href="../notes/NotaMedica.php?idInforme=<?php echo $idInforme?>&usuario=<?php echo $user ?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/dokter.png" width="15" height="15" title="Nota Medica" alt="Nota Medica" /></a></td>
   <td>
			<a href="../notes/EventosAdversos.php?idInforme=<?php echo base64_encode($reg['id_informe'])?>&amp;usuario=<?php echo base64_encode($_GET['usuario'])?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/adblock.png" width="15" height="15" title="Registrar Evento Adverso" alt="Registrar Evento Adverso" /></a>
        </td>
		</tr>
	   </table>
	   </tr>
       <?php
   }
    ?>
<tbody>
</table>
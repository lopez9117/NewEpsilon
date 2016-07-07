<?php
//archivo de conexion a la BD
	require_once("../../../dbconexion/conexion.php");
	$cn = conectarse();	
	//Variables por GET
	$fecha = $_GET['fecha'];
	$horaIni = $_GET['HoraIni'];
	$horaFin = $_GET['HoraFin'];
	$sede = $_GET['sede'];
	$servicio = $_GET['servicio'];
	$usuario = $_GET['usuario'];
	//convertir formato de fecha
	$fecha = date("Y-m-d",strtotime($fecha));
	$sql = mysql_query("SELECT i.id_informe, i.id_paciente, i.ubicacion, i.id_tecnica,
	l.fecha, l.hora, CONCAT(p.nom1,' ',p.nom2,' ',p.ape1,' ',p.ape2) AS paciente, e.nom_estudio,
	tp.desctipo_paciente, tec.desc_tecnica FROM r_informe_header i
	INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
	INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
	INNER JOIN r_estudio e ON e.idestudio = i.idestudio
	INNER JOIN servicio ser ON ser.idservicio = i.idservicio
	INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
	INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
	WHERE l.fecha = '$fecha' AND l.hora BETWEEN '$horaIni' AND '$horaFin' AND i.idsede = '$sede' AND i.idservicio = '$servicio'
	AND l.id_estadoinforme = '1' GROUP BY i.id_informe", $cn);
?>
<script type="text/javascript">
 $(document).ready(function(){
   $('#Resultados').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
    } );
})
 </script>
 <table width="100%">
  <tr bgcolor="#E1DFE3">
        <a href="ImprimirAgenda.php?fecha=<?php echo base64_encode($fecha)?>&HoraIni=<?php echo base64_encode($horaIni)?>&HoraFin=<?php echo base64_encode($horaFin)?>&sede=<?php echo base64_encode($sede) ?>&servicio=<?php echo base64_encode($servicio)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;" class="boton">Imprimir Agenda</a>
    </tr>
 </table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="Resultados">
<thead>
    <tr>
    	<th align="left" width="5%">Hrs</th>
        <th align="left" width="10%">N° Documento</th>
        <th align="left" width="12%">Nombres y Apellidos</th>
        <th align="left" width="25%">Estudio</th>
        <th align="left" width="10%">Tecnica</th>
        <th align="left" width="10%">Ubicacion</th>
        <th align="left" width="10%">T. Paciente</th>
		<th align="left" width="10%" colspan="2">Tareas</th>
    </tr>
  <tbody>
    <?php
   while($reg =  mysql_fetch_array($sql))
   {
	   //Codificar variables para pasar por URL
	   $idInforme = $reg['id_informe'];
	   $idInforme = base64_encode ($idInforme);
	   $user = base64_encode($usuario);
	   $informe = $reg['id_informe'];  
       echo '<tr>';
	   echo '<td align="left">'.$reg['hora'].'</td>';
       echo '<td align="left">'.$reg['id_paciente'].'</td>';
       echo '<td align="left">'.$reg['paciente'].'</td>';
	   echo '<td align="left">'.$reg['nom_estudio'].'</td>';
	   echo '<td align="left">'.$reg['desc_tecnica'].'</td>';
	   echo '<td align="left">'.$reg['ubicacion'].'</td>';
	   echo '<td align="left">'.$reg['desctipo_paciente'].'</td>';
	   $sqlAdjunto = mysql_query("SELECT id_adjunto FROM r_adjuntos WHERE id_informe = '$reg[id_informe]'", $cn);
	   $count = mysql_num_rows($sqlAdjunto);
		//Validar si se tienen archivos adjuntos.
		if ($count>=1)
		{
	   echo '<td>';
	   while($regAdjunto = mysql_fetch_array($sqlAdjunto))
       	{
	   ?>
       <a href="../WorkList/ViewAttached.php?Attached=<?php echo base64_encode($regAdjunto['id_adjunto'])?> " target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../images/pdf grande.png" width="15" height="15" title="Ver adjunto" alt="Ver adjunto" /></a>
       <?php
	   }
       echo '</td>';
	   }
	   else
	   {
	   echo '<td align="right">&nbsp;&nbsp;&nbsp;&nbsp;</td>';
	   }?>
       <td><a href="AccionesAgenda/VerDetalles.php?idInforme=<?php echo base64_encode($reg['id_informe'])?>&usuario=<?php echo base64_encode($usuario)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../images/viewmag+.png" width="15" height="15" title="Ver Detalles" alt="Ver Detalles" /></a>
      <?php
       echo '</td>
	   </tr>';
   }
    ?>
<tbody>
</table>
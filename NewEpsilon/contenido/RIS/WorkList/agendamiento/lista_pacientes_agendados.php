<?php 
ini_set('max_execution_time', 1000);
//Conexion a la base de datos
require_once('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables por GET
$fecha = $_GET['fecha'];
$sede = $_GET['sede'];
$servicio = $_GET['servicio'];
$usuario = $_GET['usuario'];
$estado = $_GET['estado'];
//convertir la variable para hacer la consulta en la base de datos
$fecha = date("Y-m-d",strtotime($fecha));
//consulta
$listado = mysql_query("SELECT i.id_informe, l.hora, l.fecha, i.id_paciente, i.ubicacion, i.id_estadoinforme,
CONCAT(p.nom1,' ',p.nom2,'<br>',p.ape1,' ',p.ape2) AS nombre, es.nom_estudio, pr.desc_prioridad, t.desc_tecnica FROM r_log_informe l
INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio es ON es.idestudio = i.idestudio
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
WHERE l.fecha = '$fecha' AND i.idsede = '$sede' AND i.idservicio = '$servicio' AND l.id_estadoinforme = '$estado' GROUP BY i.id_informe", $cn);
?>
 <script type="text/javascript">
 $(document).ready(function(){
   $('#Lista_Pacientes').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
    } );
})
</script>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="Lista_Pacientes">
<thead>
<tr>
    <th align="left" width="5%">Hora</th>
    <th align="left" width="10%">N°Documento</th>
    <th align="left" width="15%">Paciente</th>
    <th align="left" width="15%">Ubicacion</th>
    <th align="left" width="25%">Estudio</th>
    <th align="left" width="10%">Tecnica</th>
    <th align="left" width="10%">Prioridad</th>
    <th align="center" width="10%" colspan="1">Tareas</th>
</tr>
</thead>
<tbody>
<?php
while($reg=  mysql_fetch_array($listado))
{
	echo '<tr>';
	echo '<td align="left">'.$reg['hora'].'</td>';
	echo '<td align="left">'.$reg['id_paciente'].'</td>';
	echo '<td align="left">'.$reg['nombre'].'</td>';
	echo '<td align="left">'.$reg['ubicacion'].'</td>';
	echo '<td align="left"">'.$reg['nom_estudio'].'</td>';
	echo '<td align="left">'.$reg['desc_tecnica'].'</td>';
	echo '<td align="left">'.$reg['desc_prioridad'].'</td>';
	echo '<td align="center">
	<table><tr>';
	//mostrar las tareas de acuerdo al estado de la cita
	if($estado==1 || $estado==6)
	{
		if ($reg['id_estadoinforme']>1 || $reg['id_estadoinforme']==6)
		{
			echo '<td><img src="" width="15" height="15"></td>';
			echo '<td><img src="" width="15" height="15"></td>';
		}
		else
		{
			?>
            <td><a href="../../formularios/CancelarCita.php?idInforme=<?php echo base64_encode($reg['id_informe'])?>&amp;usuario=<?php echo base64_encode($_GET['usuario'])?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1500, height=550, top=100, left=100'); return false;"><img src="../../../../images/button_cancel.png" width="15" height="15" title="Cancelar Cita" alt="Cancelar Cita" /></a></td>
			<?php
		}
	}
	elseif($estado==7)
	{
		?>
		<td><a href="../../formularios/CancelarCita.php?idInforme=<?php echo base64_encode($reg['id_informe'])?>&amp;usuario=<?php echo base64_encode($_GET['usuario'])?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/button_cancel.png" width="15" height="15" title="Cancelar Cita" alt="Cancelar Cita" /></a></td>
        <?php
	}
	?>
    <td align="center">
		<a href="../../formularios/AccionesAgenda/VerDetalles.php?idInforme=<?php echo base64_encode($reg['id_informe'])?>&amp;usuario=<?php echo base64_encode($usuario)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/viewmag+.png" width="15" height="15" title="Ver Detalles" alt="Ver Detalles" /></a>
	</td>
    <?php
$sqlAdjunto = mysql_query("SELECT ad.id_informe,ad.adjunto,ad.id_adjunto,i.id_informe FROM r_adjuntos ad
INNER JOIN r_informe_header i ON i.id_informe = ad.id_informe where i.id_informe='$reg[id_informe]'", $cn);
	echo '<td>';
	while($regAdjunto = mysql_fetch_array($sqlAdjunto))
   {
	?>
    <a href="../ViewAttached.php?Attached=<?php echo base64_encode($regAdjunto['id_adjunto'])?> " target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../../images/pdf grande.png" width="15" height="15" title="Ver adjunto" alt="Ver adjunto" /></a>
    <?php   
   }
   '</td>';
	'</tr>'; 
	echo'</table>'; 
}
mysql_close($cn);
	?>
<tbody>
</table> 
<script>
$(function() {
    $( ".boton" )
      .button()
      .click(function( event ) {
        event.preventDefault();
      });
  });
</script>
<br>
<a href="../../formularios/GestionCitas.php?fecha=<?php echo base64_encode($fecha)?>&amp;sede=<?php echo base64_encode($sede)?>&amp;servicio=<?php echo base64_encode($servicio)?>&amp;usuario=<?php echo base64_encode($usuario)
?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;" class="boton">Agendar Paciente</a>

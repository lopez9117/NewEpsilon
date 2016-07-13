<?php 
//Conexion a la base de datos
require_once('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$rol = $_GET['rol'];
$fecha = $_GET['fecha'];
$sede = $_GET['sede'];
$servicio = $_GET['servicio'];
$usuario = $_GET['usuario'];
$fecha = date("Y-m-d",strtotime($fecha));
//consultar la cantidad de estudios que estan agendados para la fecha especificada
$sqlagenda = mysql_query("SELECT MAX(l.id_estadoinforme) AS id_estadoinforme, l.hora, l.id_informe, l.fecha, i.id_paciente, i.ubicacion,k.reconstruccion,
CONCAT(p.nom1,' ', p.nom2,' ', p.ape1,' ', p.ape2) AS nombre,i.idsede,i.idservicio, es.nom_estudio, pr.desc_prioridad, t.desc_tecnica, tp.desctipo_paciente FROM r_log_informe l
INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio es ON es.idestudio = i.idestudio
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
INNER JOIN r_informe_facturacion k ON k.id_informe = i.id_informe
WHERE l.fecha BETWEEN '2014-03-01' AND '$fecha' AND i.idsede = '$sede' AND i.idservicio = '$servicio'
AND l.id_estadoinforme = '1' AND i.id_estadoinforme='1' OR i.id_estadoinforme = '9' AND l.id_estadoinforme = '9' GROUP BY l.id_informe HAVING i.idsede = '$sede' AND i.idservicio = '$servicio' AND l.fecha BETWEEN '2014-03-01' AND '$fecha'", $cn);
$sqlSede = mysql_query("SELECT descsede FROM sede WHERE idsede='$sede'", $cn);
$regSede = mysql_fetch_array($sqlSede);
$sqlServicio = mysql_query("SELECT descservicio FROM servicio WHERE idservicio = '$servicio'", $cn);
$regServicio = mysql_fetch_array($sqlServicio);
?>
<script type="text/javascript">
 $(document).ready(function(){
   $('#tabla_listado_pacientes').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers",
		"aaSorting": [[ 0, "asc" ]],
"aoColumns": [ null, null, null, null, null, null, null, null, null ]
} );
} );
 </script>
 <table width="100%">
  <tr bgcolor="#E1DFE3">
    	<td><strong>Agenda para <?php echo $regServicio['descservicio'] ?> en <?php echo $regSede['descsede'] ?></strong></td>
    </tr>
 </table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_listado_pacientes">
<thead>
<tr>
    <th align="left" width="5%">Fecha/Hora</th>
    <th align="left" width="10%">Id</th>
    <th align="left" width="20%">Nombres y Apellidos</th>
    <th align="left" width="30%">Estudio</th>
    <th align="left" width="10%">Tecnica</th>
    <th align="left" width="10%">T.Paciente</th>
    <th align="left" width="10%">Prioridad</th>
    <th align="left" width="5%">3D</th>
    <th align="center" width="10%">Tareas</th>
</tr>
</thead>
<tfoot>
<tr>
    <th></th><th></th><th></th><th></th>                  
</tr>
</tfoot>
<tbody>
<?php
while($reg =  mysql_fetch_array($sqlagenda))
{
   //Codificar variables para pasar por URL
   $idInforme = $reg['id_informe'];
   $fechacita=$reg['fecha'];
   list($año, $mes, $dia) = explode("-",$fechacita);
   $fechaCitaPaciente=$dia.'/'.$mes.'/'.$año;	   
   echo '<tr>';
   echo '<td align="left">'.$fechaCitaPaciente.'<br>'.$reg['hora'].'</td>';
   //si el estudio fue devuelto por el especialista pintamos el fondo de otro color
   if($reg['id_estadoinforme']==9)
   {
		echo '<td align="left" bgcolor="#FF0000">'.$reg['id_paciente'].'</td>';
		echo '<td align="left" bgcolor="#FF0000">'.ucwords(strtolower($reg['nombre'])).'</td>';
		echo '<td align="left" bgcolor="#FF0000">'.ucwords(strtolower($reg['nom_estudio'])).'</td>';
		echo '<td align="left" bgcolor="#FF0000">'.ucwords(strtolower($reg['desc_tecnica'])).'</td>';
		echo '<td align="left" bgcolor="#FF0000">'.ucwords(strtolower($reg['desctipo_paciente'])).'</td>';
		echo '<td align="left" bgcolor="#FF0000">'.ucwords(strtolower($reg['desc_prioridad'])).'</td>';
		echo '<td align="left" bgcolor="#FF0000">'.ucwords(strtolower($reg['reconstruccion'])).'</td>';
		//consultar la cantidad de adjuntos que se registraron
		$sqlAdjunto = mysql_query("SELECT ad.id_informe,ad.adjunto,ad.id_adjunto,i.id_informe FROM r_adjuntos ad
		INNER JOIN r_informe_header i ON i.id_informe = ad.id_informe where i.id_informe='$reg[id_informe]'", $cn);
		$count = mysql_num_rows($sqlAdjunto);
		echo '<td align="center" bgcolor="#FF0000">';
		?>
        <table>
		<tr>
			<td>
            <?php
			if ($count>=1)
			{
				while($regAdjunto = mysql_fetch_array($sqlAdjunto))
				{
				?>
				<a href="../ViewAttached.php?Attached=<?php echo base64_encode($regAdjunto['id_adjunto'])?> " target="pop-up" onClick=		"window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../../images/pdf grande.png" width="15" height="15" title="Ver adjunto" alt="Ver adjunto" /></a>
				<?php
				}
			}
			else
			{
				echo '&nbsp;';
			}
			?>
            </td>
			<td>
            	<?php
                	//validar el rol y mostrar notas de enfermeria u observaciones generales
					if($rol==8)
					{
					?>
                    <a href="../Notes/NotaEnfermeria.php?usuario=<?php echo base64_encode($usuario)?>&idInforme=<?php echo base64_encode($idInforme)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/icono_enfermera.png" width="15" height="15" title="Ver todas las observaciones" alt="Ver todas las observaciones" /></a>
					<?php
					}
					else
					{
					?>
                    	<a href="../../formularios/AccionesAgenda/VerDetalles.php?usuario=<?php echo base64_encode($usuario)?>&idInforme=<?php echo base64_encode($idInforme)?>" target="popup" onClick="window.open(this.href, this.target, width=800,height=800); return false;"><img src="../../../../images/viewmag+.png" width="15" height="15" title="Ver todas las observaciones" alt="Ver todas las observaciones" /></a>
                    <?php	
					}
				?>
            </td>
			<td>
            <?php
            	//validar los estudios con radiaciones ionizantes.
				if ($servicio==4 || $servicio==5 || $servicio==20 || $servicio==1 || $servicio==10 || $servicio==2)
				{
					echo '<a href="estadistica.php?usuario='.base64_encode($usuario).'&idInforme='.base64_encode($idInforme).'&sede='.base64_encode($sede).'&servicio='.base64_encode($servicio).'" target="popup" onClick="window.open(this.href, this.target, width=800,height=800); return false;"><img src="../../../../images/apply.png" width="15" height="15" title="Realizar Estudio" alt="Realizar Estudio" />';

				}
				else
				{
						echo '<input type="checkbox" id="'.$reg['id_informe'].'" name="'.$reg['id_informe'].'" onClick = "CambiarEstado('.$reg['id_informe'].','.$usuario.')" alt="Marcar como Realizado Con Lectura" title="Marcar como Realizado Con Lectura">';	

				}
			?>
            </td>
			<td>
            	<a href="../../formularios/CancelarCita.php?idInforme=<?php echo base64_encode($reg['id_informe'])?>&amp;usuario=<?php echo base64_encode($_GET['usuario'])?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/button_cancel.png" width="15" height="15" title="Cancelar Cita" alt="Cancelar Cita" /></a>

            </td>
			<td>
            	<a href="../notes/EventosAdversos.php?idInforme=<?php echo base64_encode($reg['id_informe'])?>&amp;usuario=<?php echo base64_encode($_GET['usuario'])?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/adblock.png" width="15" height="15" title="Registrar Evento Adverso" alt="Registrar Evento Adverso" /></a>
			</td>  
		</tr>
		</table>
        <?php
		echo '</td>';
   }
   else
   {
	   
		//imprimir registros de manera normal
		echo '<td align="left">'.$reg['id_paciente'].'</td>';
		echo '<td align="left">'.ucwords(strtolower($reg['nombre'])).'</td>';
		echo '<td align="left">'.ucwords(strtolower($reg['nom_estudio'])).'</td>';
		echo '<td align="left">'.ucwords(strtolower($reg['desc_tecnica'])).'</td>';
		echo '<td align="left">'.ucwords(strtolower($reg['desctipo_paciente'])).'</td>';
		echo '<td align="left">'.ucwords(strtolower($reg['desc_prioridad'])).'</td>';
		echo '<td align="left">'.ucwords(strtolower($reg['reconstruccion'])).'</td>';
		//consultar la cantidad de adjuntos que se registraron
		$sqlAdjunto = mysql_query("SELECT ad.id_informe,ad.adjunto,ad.id_adjunto,i.id_informe FROM r_adjuntos ad
		INNER JOIN r_informe_header i ON i.id_informe = ad.id_informe where i.id_informe='$reg[id_informe]'", $cn);
		$count = mysql_num_rows($sqlAdjunto);
		echo '<td align="center">'; ?>
		<table>
		<tr>
			<td>
            <?php
			if ($count>=1)
			{
				while($regAdjunto = mysql_fetch_array($sqlAdjunto))
				{
				?>
				<a href="../ViewAttached.php?Attached=<?php echo base64_encode($regAdjunto['id_adjunto'])?> " target="pop-up" onClick=		"window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../../images/pdf grande.png" width="15" height="15" title="Ver adjunto" alt="Ver adjunto" /></a>
				<?php
				}
			}
			else
			{
				echo '&nbsp;';
			}
			?>
            </td>
			<td>
            	<?php
                	//validar el rol y mostrar notas de enfermeria u observaciones generales
					if($rol==8)
					{
					?>
                    <a href="../Notes/NotaEnfermeria.php?usuario=<?php echo base64_encode($usuario)?>&idInforme=<?php echo base64_encode($idInforme)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/icono_enfermera.png" width="15" height="15" title="Ver todas las observaciones" alt="Ver todas las observaciones" /></a>
					<?php
					}
					else
					{
					?>
                    	<a href="../../formularios/AccionesAgenda/VerDetalles.php?usuario=<?php echo base64_encode($usuario)?>&idInforme=<?php echo base64_encode($idInforme)?>" target="popup" onClick="window.open(this.href, this.target, width=800,height=800); return false;"><img src="../../../../images/viewmag+.png" width="15" height="15" title="Ver todas las observaciones" alt="Ver todas las observaciones" /></a>
                    <?php	
					}
				?>
            </td>
			<td>
            	<?php
            	//validar los estudios con radiaciones ionizantes.
				if ($servicio==4 || $servicio==5 || $servicio==20 || $servicio==1 || $servicio==10 || $servicio==2)
				{
					echo '<a href="estadistica.php?usuario='.base64_encode($usuario).'&idInforme='.base64_encode($idInforme).'&sede='.base64_encode($sede).'&servicio='.base64_encode($servicio).'" target="popup" onClick="window.open(this.href, this.target, width=800,height=800); return false;"><img src="../../../../images/apply.png" width="15" height="15" title="Realizar Estudio" alt="Realizar Estudio" />';

				}
				else
				{
						echo '<input type="checkbox" id="'.$reg['id_informe'].'" name="'.$reg['id_informe'].'" onClick = "CambiarEstado('.$reg['id_informe'].','.$usuario.')" alt="Marcar como Realizado Con Lectura" title="Marcar como Realizado Con Lectura">';	

				}
			?>
            </td>
			<td>
            <a href="../../formularios/CancelarCita.php?idInforme=<?php echo base64_encode($reg['id_informe'])?>&amp;usuario=<?php echo base64_encode($_GET['usuario'])?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1000, height=6000, top=85, left=140'); return false;"><img src="../../../../images/button_cancel.png" width="15" height="15" title="Cancelar Cita" alt="Cancelar Cita" /></a>
			</td>
			<td><a href="../notes/EventosAdversos.php?idInforme=<?php echo base64_encode($reg['id_informe'])?>&amp;usuario=<?php echo base64_encode($_GET['usuario'])?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/adblock.png" width="15" height="15" title="Registrar Evento Adverso" alt="Registrar Evento Adverso" /></a>
			</td>  
		</tr>
		</table>
        <?php
		echo '</td>';
   }
}
?>
<tbody>
</table>
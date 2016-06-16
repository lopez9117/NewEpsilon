<?php 
//Conexion a la base de datos
require_once('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$fecha = $_GET['fecha'];
$sede = $_GET['sede'];
$servicio = $_GET['servicio'];
$usuario = $_GET['usuario'];
$fecha = date("Y-m-d",strtotime($fecha));
//consultar la cantidad de estudios que estan agendados para la fecha especificada
$sqlagenda = mysql_query("SELECT DISTINCT(l.id_informe), l.hora, l.fecha, i.id_paciente,
CONCAT(p.nom1,' ', p.nom2,' ',p.ape1,' ',p.ape2) AS paciente,
es.nom_estudio, t.desc_tecnica, CONCAT(f.nombres,' ',f.apellidos) AS especialista
FROM r_log_informe l
INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio es ON es.idestudio = i.idestudio
INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
INNER JOIN funcionario f ON f.idfuncionario = i.idfuncionario_esp
WHERE l.id_estadoinforme = '5' AND i.id_estadoinforme='5'
AND i.idsede = '$sede' AND i.idservicio = '$servicio' AND l.fecha BETWEEN '2013-11-01' AND '$fecha'", $cn);
$sqlSede = mysql_query("SELECT descsede FROM sede WHERE idsede='$sede'", $cn);
$regSede = mysql_fetch_array($sqlSede);
$sqlServicio = mysql_query("SELECT descservicio FROM servicio WHERE idservicio = '$servicio'", $cn);
$regServicio = mysql_fetch_array($sqlServicio);
?>
<script type="text/javascript">
 $(document).ready(function(){
   $('#Resultados').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers", //DAMOS FORMATO A LA PAGINACION(NUMEROS)
    "aaSorting": [[ 5, "asc" ]],
"aoColumns": [
null,
null,
null,
null,
null,
null,
null
]
} );
} );
 </script>
 <script language="javascript">
$( document ).ready( function() {
	$("a[rel='pop-up']").click(function () {
      	var caracteristicas = "height=700,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
      	nueva=window.open(this.href, 'Popup', caracteristicas);
      	return false;
 });
});
</script>
 <table width="100%">
  <tr bgcolor="#E1DFE3">
    	<td><strong>Pendientes para publicar <?php echo $regServicio['descservicio'] ?> en <?php echo $regSede['descsede'] ?></strong></td>
    </tr>
 </table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="Resultados">
<thead>
    <tr>
        <th align="left" width="5%">Documento</th><!--Estado-->
        <th align="left" width="20%">Nombres y Apellidos</th>
        <th align="left" width="25%">Estudio</th>
         <th align="left" width="10%">Tecnica</th>
        <th align="left" width="20%">Especialista</th>
        <th align="center" width="15%">Fecha / Hora<br>de aprobacion</th>
        <th align="center" width="10%">Tareas</th>
    </tr>
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
	   //Codificar variables para pasar por URL
	   $idInforme = $reg['id_informe'];
	   $informe = $reg['id_informe'];  
       echo '<tr>';
       echo '<td align="left">'.$reg['id_paciente'].'</td>';
       echo '<td align="left">'.$reg['paciente'].'</td>';
	   echo '<td align="left">'.$reg['nom_estudio'].'</td>';
	   echo '<td align="left">'.$reg['desc_tecnica'].'</td>';
	   echo '<td align="left">'.$reg['especialista'].'</td>';
	   echo '<td align="center">'.$reg['fecha'].' / '.$reg['hora'].'</td>';
	   echo '<td align="center">
	   <table>
	   	<tr>';
		?>
        <a href="../WorkList/Transcripcion/SubirResultado.php?informe=<?php echo base64_encode($idInforme)?>&usuario= <?php echo base64_encode($usuario) ?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../images/apply.png" width="15" height="15" title="Ver adjunto" alt="Ver adjunto" /></a>
   </td>
		<td>
		<a href="../../formularios/VistaPrevia1.php?informe=<?php echo base64_encode($idInforme)?>" target="popup" onClick="window.open(this.href, this.target, 'toolbar=no,scrollbars=no,width=800,height=700'); return false;"><img src="../../../../images/fileprint.png" width="14" height="14" alt="Vista de impresión" title="Vista de impresión"></a>
		<?php
        echo'</td>
		<td>
		<a href="AccionesAgenda/VerDetalles.php?idInforme='.base64_encode($idInforme).'&usuario='.base64_encode($usuario).'" rel="pop-up"><img src="../../../images/kfind.png" width="14" height="14" alt="Observaciones" title="Observaciones"></a>
		</td>
		</tr>
	   </table>
	   </td>';
       echo '</tr>';
   }
        mysql_close($cn);
    ?>
<tbody>
</table>
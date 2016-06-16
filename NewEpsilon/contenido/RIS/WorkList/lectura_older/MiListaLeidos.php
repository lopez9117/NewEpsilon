<?php 
//Conexion a la base de datos
require_once('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$fecha = $_GET['fecha'];
$user = $_GET['usuario'];
$fecha = date("Y-m-d",strtotime($fecha));
//consultar la cantidad de estudios que estan agendados para la fecha especificada
$sqlagenda = mysql_query("SELECT i.id_informe, i.id_paciente,CONCAT(p.nom1,' ', p.nom2,'<br>',
p.ape1,' ', p.ape2) AS nombres ,e.nom_estudio, l.hora, pr.desc_prioridad, ser.descservicio, tec.desc_tecnica
FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN servicio ser ON ser.idservicio = i.idservicio
INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
WHERE i.idfuncionario_esp = '$usuario' AND l.id_estadoinforme = '4' AND i.id_estadoinforme = '4' GROUP BY i.id_informe", $cn);
//obtener datos del funcionario
$sqlFuncionario = mysql_query("SELECT CONCAT(nombres,' ', apellidos) AS nombre FROM funcionario WHERE idfuncionario = '$user'", $cn);
$regFuncionario = mysql_fetch_array($sqlFuncionario);
?>
<script type="text/javascript">
 $(document).ready(function(){
   $('#misLecturas').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
    } );
})
 </script>
 <table width="100%">
  <tr bgcolor="#E1DFE3">
    	<td><strong>Lectura de estudios realizada por : <?php echo $regFuncionario['nombre'] ?></strong></td>
    </tr>
 </table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="misLecturas">
<thead>
    <tr>
        <th align="left" width="10%">N° Documento</th><!--Estado-->
        <th align="left" width="20%">Nombres y Apellidos</th>
        <th align="left" width="10%">Servicio</th>
        <th align="left" width="30%">Estudio</th>
        <th align="left" width="10%">Tecnica</th>
        <th align="left" width="10%">Hora Lectura</th>
        <th align="left" width="10%">Prioridad</th>
        <th align="center" width="10%">Tareas</th>
    </tr>
</thead>
  <tbody>
<?php
while($reg =  mysql_fetch_array($sqlagenda))
{
   //Codificar variables para pasar por URL
   $idInforme = $reg['id_informe'];
   $idInforme = base64_encode($idInforme);
   $especialista = base64_encode($user); 
   $nombres = $reg['nombres'];
   echo '<tr>';
   echo '<td align="left">'.$reg['id_paciente'].'</td>';
   echo '<td align="left">'.$nombres.'</td>';
   echo '<td align="left">'.$reg['descservicio'].'</td>';
   echo '<td align="left">'.$reg['nom_estudio'].'</td>';
   echo '<td align="left">'.$reg['desc_tecnica'].'</td>';
   echo '<td align="left">'.$reg['hora'].'</td>';
   echo '<td align="left">'.$reg['desc_prioridad'].'</td>';
   echo '<td align="center">
	<table>
		<tr>
			<td>';
			?>
			<a href="RevisarAprobar.php?informe=<?php echo $idInforme?>&especialista= <?php echo $especialista ?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../../images/kate.png" width="15" height="15" title="Ver adjunto" alt="Ver adjunto" /></a>
            <?php
			echo '</td>';?>
            <td><a href="DevolverEstudio.php?idInforme=<?php echo $idInforme?>&usuario=<?php echo $especialista ?>"  target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/reload.png" width="15" height="15" title="Regresar Estudio" alt="Regresar Estudio" /></a></td>
		<?php  echo '</tr>
	</table>
   </td>';
   echo '</tr>';
}
?>
<tbody>
</table>

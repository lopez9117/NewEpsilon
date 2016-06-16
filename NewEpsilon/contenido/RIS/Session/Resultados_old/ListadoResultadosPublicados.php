<?php 
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$paciente = $_POST['paciente'];
if($paciente=="")
{
	echo '<font color="#FF0000">Por favor ingrese un paciente</font>';
}
else
{
list($idPaciente, $nombres) = explode("-", $paciente);
//consultar la cantidad de estudios que estan agendados para la fecha especificada
$sqlagenda = mysql_query("SELECT DISTINCT(i.id_informe), i.id_paciente, concat(p.nom1,' ', p.nom2,
' ',p.ape1,' ', p.ape2) as nombre,e.nom_estudio, l.fecha, l.hora, pr.desc_prioridad, f.nombres, f.apellidos,
tec.desc_tecnica, se.descsede
FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN funcionario f ON f.idfuncionario = i.idfuncionario_esp
INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
INNER JOIN sede se ON se.idsede = i.idsede
WHERE i.id_estadoinforme = '8' AND l.id_estadoinforme = '8' AND i.id_paciente = '$idPaciente'", $cn);
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
    	<td><strong>Resultados definitivos para <?php echo $nombres ?></strong></td>
    </tr>
 </table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="Resultados">
<thead>
    <tr>
        <th align="left" width="10%">N° Documento</th><!--Estado-->
        <th align="left" width="20%">Nombres y Apellidos</th>
        <th align="left" width="25%">Estudio</th>
        <th align="left" width="10%">Tecnica</th>
        <th align="left" width="10%">Sede</th>
         <th align="center" width="15%">Fecha del estudio</th>
        <th align="center" width="10%">Tareas</th>
    </tr>
  <tbody>
    <?php
   while($reg =  mysql_fetch_array($sqlagenda))
   {
	   //Codificar variables para pasar por URL
	   $idInforme = $reg['id_informe'];
	   //consultar fecha de realizacion del estudio
		$con = mysql_query("SELECT fecha FROM r_log_informe WHERE id_informe = '$idInforme' AND id_estadoinforme = '1'", $cn);
		$regcon = mysql_fetch_array($con);
		$fecha = $regcon['fecha'];
	   $idInforme = base64_encode ($idInforme);
	   $user = base64_encode($usuario);
	   $informe = $reg['id_informe'];  
	   $nombres = $reg['nombre'];
       echo '<tr>';
       echo '<td align="left">'.$reg['id_paciente'].'</td>';
       echo '<td align="left">'.$nombres.'</td>';
	   echo '<td align="left">'.$reg['nom_estudio'].'</td>';
	   echo '<td align="left">'.$reg['desc_tecnica'].'</td>';
	   echo '<td align="left">'.$reg['descsede'].'</td>';
	   echo '<td align="center">'.$fecha.'</td>';
	   echo '<td align="center">';
	   ?><a href="Vistaimpresion.php?informe=<?php echo $idInforme ?>" target="Ventana" onClick="window.open(this.href, this.target, 'toolbar=no,scrollbars=no,width=800,height=700'); return false;"><img src="../../../images/fileprint.png" width="14" height="14" alt="Imprimir Informe" title="Transcribir Imprimir"></a>&nbsp;&nbsp;
	   <!--<a href="VistaPrevia.php?informe=<?php echo $idInforme ?>" target="Ventana" onClick="window.open(this.href, this.target, 'toolbar=no,scrollbars=no,width=800,height=700'); return false;"><img src="../../../images/kfind.png" width="14" height="14" alt="Vista Previa" title="Vista Previa"></a>&nbsp;&nbsp;-->
	   <!--<a href="AccionesAgenda/VerDetalles.php?idInforme='.$idInforme.'&usuario='.$user.'" rel="pop-up"><img src="../../../images/kfind.png" width="14" height="14" alt="Observaciones" title="Observaciones"></a>-->
	   <?php
       echo '</td>';
       echo '</tr>';
   }
    ?>
<tbody>
</table>
<br>
<?php
}
?>
<?php 
//Conexion a la base de datos
require_once('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();

$fecha = $_GET['fecha'];
$usuario = $_GET['usuario'];

$fecha = date("Y-m-d",strtotime($fecha));

//consultar la cantidad de estudios que estan agendados para la fecha especificada
$sqlagenda = mysql_query("SELECT i.id_informe, i.id_paciente, i.idservicio, i.idsede, p.nom1, p.nom2,
p.ape1, p.ape2,e.nom_estudio, l.fecha, l.hora, pr.desc_prioridad, ser.descservicio,
s.descsede
FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN servicio ser ON ser.idservicio = i.idservicio
INNER JOIN sede s ON s.idsede = i.idsede
WHERE l.fecha = '$fecha' AND i.idfuncionario_trans = '$usuario' AND l.id_estadoinforme = '4'", $cn);

//obtener datos del funcionario
$sqlFuncionario = mysql_query("SELECT nombres, apellidos FROM funcionario WHERE idfuncionario = '$usuario'", $cn);
$regFuncionario = mysql_fetch_array($sqlFuncionario);
?>
<script type="text/javascript">
 $(document).ready(function(){
   $('#MilistaTranscripcion').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
    } );
})
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
    	<td><strong>Lectura de estudios realizada por : <?php echo $regFuncionario['nombres'].'&nbsp;'.$regFuncionario['apellidos'] ?></strong></td>
    </tr>
 </table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="MilistaTranscripcion">
<thead>
    <tr>
        <th align="left" width="10%">N° Documento</th><!--Estado-->
        <th align="left" width="20%">Nombres y Apellidos</th>
        <th align="left" width="10%">Servicio</th>
        <th align="left" width="30%">Estudio</th>
        <th align="left" width="10%">Hora Transcripcion</th>
        <th align="left" width="10%">Prioridad</th>
        <th align="center" width="10%">Detalles</th>
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
	   $idInforme = $reg['id_informe'];
	   $idInforme = base64_encode ($idInforme);
	   
	   $nombres = $reg['nom1'].'&nbsp;'.$reg['nom2'].'&nbsp;'.$reg['ape1'].'&nbsp;'.$reg['ape2'];
       echo '<tr>';
       echo '<td align="left">'.$reg['id_paciente'].'</td>';
       echo '<td align="left">'.$nombres.'</td>';
       echo '<td align="left">'.$reg['descservicio'].'</td>';
	   echo '<td align="left">'.$reg['nom_estudio'].'</td>';
	   echo '<td align="left">'.$reg['hora'].'</td>';
	   echo '<td align="left">'.$reg['desc_prioridad'].'</td>';
	   echo '<td align="center"><img src="../../../../images/viewmag+.png" width="14" height="14" alt="Ver observaciones" title="Ver observaciones" /></td>';
       echo '</tr>';
   }
    ?>
<tbody>
</table>

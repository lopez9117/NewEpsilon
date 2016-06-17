<?php 
//Conexion a la base de datos
require_once('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$fecha = $_GET['fecha'];
$usuario = $_GET['usuario'];
$fecha = date("Y-m-d",strtotime($fecha));
//consultar la cantidad de estudios que estan agendados para la fecha especificada
$sqlagenda = mysql_query("SELECT l.id_informe ,i.id_paciente,CONCAT(p.nom1,' ', p.nom2,' ',
p.ape1,' ', p.ape2) AS nombre, e.nom_estudio, l.hora, pr.desc_prioridad, ser.descservicio FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN servicio ser ON ser.idservicio = i.idservicio
WHERE l.fecha = '$fecha' AND l.idfuncionario = '$usuario' AND l.id_estadoinforme = '2' GROUP BY l.id_informe", $cn);
//obtener datos del funcionario
$sqlFuncionario = mysql_query("SELECT CONCAT(nombres, apellidos) AS funcionario FROM funcionario WHERE idfuncionario = '$usuario'", $cn);
$regFuncionario = mysql_fetch_array($sqlFuncionario);
?>
<script type="text/javascript">
$(document).ready(function(){
$('#MisEstudiosTomados').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
	"sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
} );
})
</script>
<table width="100%">
<tr bgcolor="#E1DFE3">
	<td><strong>Estudios realizados por : <?php echo $regFuncionario['funcionario'] ?></strong></td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="MisEstudiosTomados">
<thead>
<tr>
    <th align="left" width="10%">N° Documento</th>
    <th align="left" width="20%">Nombres y Apellidos</th>
    <th align="left" width="10%">Servicio</th>
    <th align="left" width="30%">Estudio</th>
    <th align="left" width="10%">Hora Estudio</th>
    <th align="left" width="10%">Prioridad</th>
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
   $nombres = $reg['nombre'];
   echo '<tr>';
   echo '<td align="left">'.$reg['id_paciente'].'</td>';
   echo '<td align="left">'.$nombres.'</td>';
   echo '<td align="left">'.$reg['descservicio'].'</td>';
   echo '<td align="left">'.$reg['nom_estudio'].'</td>';
   echo '<td align="left">'.$reg['hora'].'</td>';
   echo '<td align="left">'.$reg['desc_prioridad'].'</td>';
   echo '</tr>';
}
?>
<tbody>
</table>
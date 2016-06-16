<?php 
//Conexion a la base de datos
ini_set('max_execution_time', 1000);
require_once('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$fecha = $_GET['fecha'];
$fechahasta = $_GET['fechahasta'];
$usuario = $_GET['usuario'];
$fecha = date("Y-m-d",strtotime($fecha));
$fechahasta = date("Y-m-d",strtotime($fechahasta));
//consultar la cantidad de estudios que estan agendados para la fecha especificada
$sqlagenda = mysql_query("SELECT i.id_informe, i.id_paciente, CONCAT(p.nom1,' ', p.nom2,'<br>',
p.ape1,' ', p.ape2) AS nombres ,e.nom_estudio, l.fecha, l.hora, ser.descservicio,
s.descsede
FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
INNER JOIN servicio ser ON ser.idservicio = i.idservicio
INNER JOIN sede s ON s.idsede = i.idsede
WHERE l.fecha BETWEEN '$fecha' AND '$fechahasta' AND l.idfuncionario = '$usuario' AND l.id_estadoinforme = '3' GROUP BY i.id_informe", $cn);
//obtener datos del funcionario
$sqlFuncionario = mysql_query("SELECT CONCAT(nombres,' ', apellidos) FROM funcionario WHERE idfuncionario = '$usuario'", $cn);
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
    	<td><strong>Estudios realizados por : <?php echo $regFuncionario['nombre'] ?></strong></td>
    </tr>
 </table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="MisEstudiosTomados">
<thead>
    <tr>
        <th align="left" width="10%">N° Documento</th><!--Estado-->
        <th align="left" width="20%">Nombres y Apellidos</th>
        <th align="left" width="10%">Servicio</th>
        <th align="left" width="30%">Estudio</th>
        <th align="left" width="10%">Hora Estudio</th>
        <th align="left" width="10%">Sede</th>
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
	   
	   $nombres = $reg['nombres'];
       echo '<tr>';
       echo '<td align="left">'.$reg['id_paciente'].'</td>';
       echo '<td align="left">'.$nombres.'</td>';
       echo '<td align="left">'.$reg['descservicio'].'</td>';
	   echo '<td align="left">'.$reg['nom_estudio'].'</td>';
	   echo '<td align="left">'.$reg['fecha'].'<br>'.$reg['hora'].'</td>';
	   echo '<td align="left">'.$reg['descsede'].'</td>';
	   echo '<td align="center">'; ?>
	   <a href="../../Resultados/VistaPrevia.php?informe=<?php echo $idInforme?>" target="popup" onClick="window.open(this.href, this.target, 'toolbar=no,scrollbars=no,width=800,height=700'); return false;"><img src="../../../../images/fileprint.png" width="14" height="14" alt="Vista de impresión" title="Vista de impresión"></a></td>
      <?php 
       echo '</tr>';
   }
    ?>
<tbody>
</table>

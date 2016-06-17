<?php 
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$paciente = $_POST['paciente'];
$usuario = $_POST['usuario'];
//separar identificacion y nomber del paciente
list($idPaciente, $nombres) = explode("-", $paciente);
//consultar la cantidad de estudios que estan agendados para la fecha especificada
$sqlagenda = mysql_query("SELECT DISTINCT(i.id_informe), i.id_paciente, CONCAT(p.nom1,' ',p.nom2,' ', p.ape1,' ', p.ape2) AS paciente, e.nom_estudio, l.fecha, l.hora, pr.desc_prioridad, CONCAT(f.nombres,' ',f.apellidos) AS especialista,
tec.desc_tecnica, se.descsede
FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN funcionario f ON f.idfuncionario = i.idfuncionario_esp
INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
INNER JOIN sede se ON se.idsede = i.idsede
WHERE i.id_estadoinforme = '8' AND l.id_estadoinforme = '8' AND i.id_paciente = '$idPaciente' GROUP BY i.id_informe", $cn);
?>
<script type="text/javascript">
 $(document).ready(function(){
   $('#ResultadosAdendum').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
    } );
})
</script>
<table width="100%">
<tr bgcolor="#E1DFE3">
    <td><strong>Resultados para <?php echo ucwords(strtolower($nombres)) ?></strong></td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="ResultadosAdendum">
<thead>
<tr>
    <th align="left" width="10%">Id Paciente</th>
    <th align="left" width="20%">Nombres y Apellidos</th>
    <th align="left" width="20%">Estudio</th>
    <th align="left" width="10%">Tecnica</th>
    <th align="left" width="20%">Especialista</th>
    <th align="center" width="10%">Fecha</th>
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
	//consultar fecha de realizacion del estudio
	$con = mysql_query("SELECT fecha FROM r_log_informe WHERE id_informe = '$idInforme' AND id_estadoinforme = '2'", $cn);
	$regcon = mysql_fetch_array($con);
	$fecha = $regcon['fecha'];
	echo '<tr>';
	echo '<td align="center">'.$reg['id_paciente'].'</td>';
	echo '<td align="left">'.ucwords(strtolower($reg['paciente'])).'</td>';
	echo '<td align="left">'.ucwords(strtolower($reg['nom_estudio'])).'</td>';
	echo '<td align="left">'.ucwords(strtolower($reg['desc_tecnica'])).'</td>';
	echo '<td align="left">'.ucwords(strtolower($reg['especialista'])).'</td>';
	echo '<td align="center">'.$reg['fecha'].'</td>';
	?>
	<td align="center">
    <table>
        <tr>
        	<td><a href="CrearNuevaNotaAclaratoria.php?informe=<?php echo base64_encode($idInforme)?>&usuario=<?php echo base64_encode($usuario) ?>" target="nota-aclaratoria" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../images/edit_add.png" width="15" height="15" title="Nota Aclaratoria" alt="Nota Aclaratoria" /></a></td>
        	<td><a href="../Resultados/Vistaimpresion.php?informe=<?php echo base64_encode($idInforme)?>" rel="VistaImpresion" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../images/kfind.png" width="14" height="14" alt="Vista Previa" title="Vista Previa"></a></td>
        </tr>
    </table>
	</td>
    </tr>
    <?php
}
?>
<tbody>
</table>
<br/><br/>
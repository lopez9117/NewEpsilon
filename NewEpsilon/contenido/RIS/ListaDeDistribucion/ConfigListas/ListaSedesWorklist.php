<?php 
//Conexion a la base de datos
include('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$sede = $_GET['sede'];
//consultar todos los servicios habilitados
$listaServicio = mysql_query("SELECT * FROM servicio WHERE idestado_actividad='1' AND alias!='' ORDER BY descservicio ASC", $cn);
?>
<script type="text/javascript">
$(document).ready(function(){
$('#tabla_listado_pacientes').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
	"sPaginationType": "full_numbers",
	"aaSorting": [[ 0, "asc" ]],
"aoColumns": [ null, null, null, null ]
} );
} );
 </script>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_listado_pacientes">
<thead>
<tr>
    <th align="left" width="25%">Sede</th>
    <th align="left" width="25%">Estado</th>
    <th align="center" width="25%">Abrir</th>
    <th align="center" width="25%">Cerrar</th>
</tr>
</thead>
<tbody>
<?php
//ciclo para imprimir todos los servicios activos
while($rowServicio = mysql_fetch_array($listaServicio))
{
	$Servicio = $rowServicio['idservicio'];
	//consultar el estado de la lista de trabajo en cada sede
	$consLista = mysql_query("SELECT * FROM r_conf_lista_lectura WHERE idsede = '$sede' AND idservicio = '$Servicio'", $cn);
	$regsLista = mysql_fetch_array($consLista);
	if($regsLista['idestado_actividad']==1)
	{
		$Estado = 'Abierta';
	}
	else
	{
		$Estado = 'Restringida';
	}
	echo 
	'<tr>
		<td>'.$rowServicio['descservicio'].'</td>
		<td>'.$Estado.'</td>'; ?>
		<td align="center"><input type="radio" name="<?php echo $rowServicio['idservicio'];?>" id="<?php echo $rowServicio['idservicio'];?>" onclick="activarLista('<?php echo $rowServicio['idservicio'] ?>','<?php echo $sede ?>', 1)" value="1" <?php if($regsLista['idestado_actividad']==1){ echo 'checked="checked"';}?>/></td>
		<td align="center"><input type="radio" name="<?php echo $rowServicio['idservicio'];?>" id="<?php echo $rowServicio['idservicio'];?>" onclick="activarLista('<?php echo $rowServicio['idservicio'] ?>','<?php echo $sede ?>', 2)" value="2" <?php if($regsLista['idestado_actividad']==2){ echo 'checked="checked"';}?>/></td>
	<?php echo'</tr>';
}
?>
<tbody>
<tfoot>
    <tr>
        <th></th>                  
    </tr>
</tfoot>
</table>
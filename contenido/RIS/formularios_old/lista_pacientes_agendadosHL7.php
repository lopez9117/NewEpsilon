<?php
ini_set('max_execution_time', 1000);
//Conexion a la base de datos
include('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables por GET
$fechadesde = $_GET['fechadesde'];
$fechahasta = $_GET['fechahasta'];
$sede = $_GET['sede'];
$servicio = $_GET['servicio'];
$usuario = $_GET['usuario'];
$estado = $_GET['estado'];
//convertir la variable para hacer la consulta en la base de datos
$fechadesde = date("Y-m-d",strtotime($fechadesde));
$fechahasta = date("Y-m-d",strtotime($fechahasta));
list($AñO,$MES,$DIA)=explode("-",$fechadesde);
$DESDE= $AñO.''.$MES.''.$DIA.'000000';
list($Anio,$Mes,$Dia)=explode("-",$fechahasta);
$HASTA= $Anio.''.$Mes.''.$Dia.'235959';
//Consulta de pacientes enviados por el GHIPS
//$eliminar_listado = mysql_query("DELETE FROM _temp WHERE asignada='1'");
$listado = mysql_query("SELECT idorden, fch_solicitud,fch_cita, idpaciente, CONCAT(nombre1,' ',nombre2,'<br>',apellido1,' ',apellido2) AS nombre, ubicacion, codservicio, descservicio, id_tecnica, tecnica, id_servicio, id_sede, clasificacion, asignada FROM _temp WHERE asignada = '0' AND id_sede = $sede AND id_servicio = $servicio AND fch_cita BETWEEN '$DESDE' AND '$HASTA' ORDER BY fch_solicitud ASC");
?>
 <script type="text/javascript">
 $(document).ready(function(){
   $('#Lista_Pacientes').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
    } );
})
 function CancelarCita(idorden) {
	 opcion = confirm("¿Desea Cancelar la orden generada desde el GHIPS?")
	 if (opcion == true) {
		 ajax = nuevoAjax();
		 //llamado al archivo que va a ejecutar la consulta ajax
		 ajax.open("POST", "AccionesAgenda/CancelarHL7.php", true);
		 ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 ajax.send("idorden=" + idorden + "&tiempo=" + new Date().getTime());
		 return mostrarAgenda();
	 }
 }
</script>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="Lista_Pacientes">
<thead>
<tr>
	<th align="left" width="10%">Fecha/Hora cita</th>
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
while($reg = mysql_fetch_array($listado))
{
	$conver2 = substr($reg['fch_cita'], -0, 8);
	$fch_cita = date("d/m/Y", strtotime($conver2));
	$lugar = 2;
	$solo_hora = substr($reg['fch_cita'], 8,4);
	$insertar = ":";
	$hora_creada = $resultado = substr($solo_hora, 0, $lugar) . $insertar . substr($solo_hora, $lugar);
	if($hora_creada==":"){
		$hora_creada="";
		}
	$sqltecnica = mysql_query("SELECT desc_tecnica FROM r_tecnica WHERE id_tecnica='".$reg['id_tecnica']."'");
	while($regtecnica = mysql_fetch_array($sqltecnica)){
	$descripcion_tecnica = $regtecnica['desc_tecnica'];	
	}

	// substr($texto,0,10);
//	$standard = strtotime($solo_hora);
	echo '<tr>';
	echo '<td align="left">'.$fch_cita.' <br>     '.$hora_creada.'</td>';
	echo '<td align="left">'.$reg['idpaciente'].'</td>';
	echo '<td align="left">'.$reg['nombre'].'</td>';
	echo '<td align="left">'.$reg['ubicacion'].'</td>';
	echo '<td align="left"">'.$reg['descservicio'].'</td>';
	echo '<td align="left">'.$descripcion_tecnica.'</td>';
	echo '<td align="left">'.$reg['clasificacion'].'</td>';
	//mostrar las tareas de acuerdo al estado de la cita
	?>
    <td align="center">
		<a href="GestionCitasHL7.php?idorden=<?php echo base64_encode($reg['idorden'])?>&usuario=<?php echo base64_encode($usuario)
?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../images/viewmag+.png" width="15" height="15" title="Ver Detalles" alt="Ver Detalles" /></a>
	<a href="#" onclick="CancelarCita(<?php echo $reg['idorden']; ?>)"><img src="../../../images/button_cancel.png" width="15" height="15" title="Cancelar Cita" alt="Cancelar Cita"/></a>
	</td>
    </tr>
    <?php
    }
	?>
</tbody>
</table>
<br>
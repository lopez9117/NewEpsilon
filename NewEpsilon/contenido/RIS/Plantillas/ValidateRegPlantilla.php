<?php 
	//conexion a la BD
	require_once("../../../dbconexion/conexion.php");
	$cn = conectarse();	
	//variables POST
	$especialista = $_GET['especialista'];
	list($funcionario, $nombres) = explode("-", $especialista);
	//consultar si el funcionario es valido
	$sql = mysql_query("SELECT * FROM funcionario WHERE idfuncionario = '$funcionario'", $cn);
	$res = mysql_num_rows($sql);
	//validar si el funcionario tiene plantillas registradas
	$conPlantillas = mysql_query("SELECT * FROM r_plantilla WHERE idfuncionario_esp = '$funcionario'", $cn);
	$resPlantillas = mysql_num_rows($conPlantillas);
?>
<script type="text/javascript">
 $(document).ready(function(){
   $('#TableListadoPlantillas').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
    } );
})
 </script>
 <table width="100%">
  <tr bgcolor="#E1DFE3">
    	<td align="left"><strong>Plantillas para <?php echo $nombres ?></strong></td>
        <td align="right"><strong><span style="margin-right:2%;"><a href="Tareas/CrearNuevaPlantilla.php?Especialista=<?php echo base64_encode($funcionario)?>" target="popup" onClick="window.open(this.href, this.target, width=800,height=800); return false;">Crear nueva plantilla</a></span></strong></td>
    </tr>
 </table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="TableListadoPlantillas">
<thead>
    <tr>
        <th align="left" width="20%">Servicio</th><!--Estado-->
        <th align="left" width="45%">Estudio</th>
      <th align="left" width="15%">Tecnica</th>
   	  <th align="center" width="20%">Tareas</th>
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
   while($registro =  mysql_fetch_array($conPlantillas))
   {	
   		$idPlantilla = $registro['idplantilla'];  
   		$consulta = mysql_query("SELECT p.idplantilla, e.nom_estudio, t.desc_tecnica, ser.descservicio FROM r_plantilla p
INNER JOIN r_estudio e ON e.idestudio = p.idestudio
INNER JOIN r_tecnica t ON t.id_tecnica = p.id_tecnica
INNER JOIN servicio ser ON ser.idservicio = p.idservicio WHERE idplantilla = '$idPlantilla'", $cn); 
   		$reg = mysql_fetch_array($consulta);
       echo '<tr>';
	   echo '<td align="left">'.$reg['descservicio'].'</td>';
       echo '<td align="left">'.$reg['nom_estudio'].'</td>';
       echo '<td align="left">'.$reg['desc_tecnica'].'</td>';
	   echo '<td align="center">
	   <table>
	   <tr align="center">
		<td><a href="Tareas/EditarPlantilla.php?idPlantilla='.base64_encode($idPlantilla).'" target="popup" onClick="window.open(this.href, this.target, width=800,height=800); return false;"><img src="../../../images/easymoblog.png" width="18" height="18" alt="Editar plantilla" title = "Editar plantilla"/></a></td>
		<td><img src="../../../images/button_cancel.png" width="18" height="18" alt="Eliminar plantilla" title = "Eliminar plantilla"/></td>
	   </tr>
	   </table>
		</td>';
	   echo '</tr>';
   }
    ?>
<tbody>
</table>
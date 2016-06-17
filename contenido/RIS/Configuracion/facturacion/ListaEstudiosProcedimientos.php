<?php 
//Conexion a la base de datos
require_once('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables con POST
$servicio = $_GET['servicio'];
$estado = $_GET['estado'];

$sqlEstudios = mysql_query("SELECT e.idestudio, e.nom_estudio, e.cod_iss,e.cod_soat,ea.desc_estado FROM r_estudio e
INNER JOIN estado_actividad ea ON ea.idestado_actividad = e.idestado WHERE idservicio = '$servicio' AND idestado = '$estado'", $cn);

$sqlServicio = mysql_query("SELECT descservicio FROM servicio WHERE idservicio = '$servicio'", $cn);
$regServicio = mysql_fetch_array($sqlServicio);

?>
<script type="text/javascript">
 $(document).ready(function(){
   $('#tabla_listado_pacientes').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers",
		"aaSorting": [[ 1, "asc" ]],
"aoColumns": [
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
$("a['rel='pop-up'']").click(function () {
    var caracteristicas = "height=700,width=800,scrollTo,resizable=0,scrollbars=0,location=0";
    nueva=window.open(this.href, 'Popup', caracteristicas);
    return false;
});
});
</script>
 <table width="100%">
  <tr bgcolor="#E1DFE3">
    	<td><strong>Estudios / procedimientos en servicio de <?php echo $regServicio['descservicio'] ?></strong></td>
    </tr>
 </table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_listado_pacientes">
<thead>
<tr>
    <th align="center" width="10%">Cod.Iss</th>
    <th align="center" width="10%">Cod.Soat</th>
    <th align="left" width="60%">Nombre del estudio / procedimiento</th>
    <th align="center" width="10%">Estado</th> 
    <th align="center" width="10%">Tareas</th>
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
   while($reg =  mysql_fetch_array($sqlEstudios))
   {
		echo '<tr><td align="center">'.$reg['cod_iss'].'</td>';
        echo '<td align="center">'.$reg['cod_soat'].'</td>';
		echo '<td align="left">'.$reg['nom_estudio'].'</td>';
		echo '<td align="center">'.$reg['desc_estado'].'</td>';?>
		<td align="center"><a href="Editar.php?idestudio=<?php echo base64_encode($reg['idestudio'])?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=650, height=500, top=85, left=140'); return false;"><img src="../../../../images/kedit.png" width="15" height="15" title="Editar" alt="Editar" /></a></td></tr>
   <?php
   }
    ?>
</tbody>
</table>
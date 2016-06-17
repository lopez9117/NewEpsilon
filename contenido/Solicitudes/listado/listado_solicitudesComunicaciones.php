<?php 
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
session_start();
$_SESSION['area'] = $area;
$CurrentUser = $_SESSION['currentuser'];
$sede=$_GET['sede'];
$fechaDesde = $_GET['fechaDesde'];
$fechaHasta = $_GET['fechaHasta'];
$Satisfaccion = $_GET['Satisfaccion'];
list($MES,$DIA,$AÑO)=explode("/",$fechaDesde);
$DESDE= $AÑO."-".$MES."-".$DIA;
 list($MES,$DIA,$AÑO)=explode("/",$fechaHasta);
 $HASTA= $AÑO."-".$MES."-".$DIA;
 //consulta para validar la calificacion de las solicitudes
$consulta = mysql_query("SELECT s.idsolicitud, f.nombres, f.apellidos FROM solicitud s
INNER JOIN funcionario f ON s.idfuncionario = f.idfuncionario WHERE idarea=9 and idsatisfaccion=3 and s.idfuncionario='$CurrentUser' AND idestado_solicitud!=1 AND idestado_solicitud!=2", $cn);
$regusuario = mysql_fetch_array($consulta);	
$count = mysql_num_rows($consulta);
if ($area==9)
{
$listado =  mysql_query("SELECT so.idsolicitud, so.desc_requerimiento, so.fechahora_solicitud,so.idestado_solicitud, so.horasolicitud, so.idsatisfaccion,
s.descsede, e.descestado_solicitud,CONCAT(f.nombres,'<br>', f.apellidos) AS nombre, so.idfuncionario, p.desc_prioridad FROM solicitud so
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN estado_solicitud e ON e.idestado_solicitud = so.idestado_solicitud
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN tipo_prioridad p ON p.idprioridad= so.idprioridad WHERE so.idarea='9' AND fechahora_solicitud BETWEEN '$DESDE' AND '$HASTA' ORDER BY so.fechahora_solicitud DESC",$cn);
}
else if($Satisfaccion==3)
{ 
$listado =  mysql_query("SELECT so.idsolicitud, so.desc_requerimiento, so.fechahora_solicitud,so.idestado_solicitud, so.horasolicitud, so.idsatisfaccion,
s.descsede, e.descestado_solicitud, CONCAT(f.nombres,'<br>', f.apellidos) AS nombre, so.idfuncionario, p.desc_prioridad FROM solicitud so
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN estado_solicitud e ON e.idestado_solicitud = so.idestado_solicitud
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN tipo_prioridad p ON p.idprioridad= so.idprioridad WHERE so.idarea='9' AND so.idfuncionario='$CurrentUser' AND idsatisfaccion='$Satisfaccion' AND so.idestado_solicitud>=3 ORDER BY so.fechahora_solicitud DESC",$cn);
}
else if($Satisfaccion<=2)
{ 
$listado =  mysql_query("SELECT so.idsolicitud, so.desc_requerimiento, so.fechahora_solicitud,so.idestado_solicitud, so.horasolicitud, so.idsatisfaccion,
s.descsede, e.descestado_solicitud, CONCAT(f.nombres,'<br>', f.apellidos) AS nombre, so.idfuncionario, p.desc_prioridad FROM solicitud so
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN estado_solicitud e ON e.idestado_solicitud = so.idestado_solicitud
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN tipo_prioridad p ON p.idprioridad= so.idprioridad WHERE so.idarea='9' AND so.idfuncionario='$CurrentUser' AND idsatisfaccion='$Satisfaccion' ORDER BY so.fechahora_solicitud DESC",$cn);
}
else if ($Satisfaccion==4)
{
	$listado =  mysql_query("SELECT so.idsolicitud, so.desc_requerimiento, so.fechahora_solicitud,so.idestado_solicitud, so.horasolicitud, so.idsatisfaccion,
s.descsede, e.descestado_solicitud, CONCAT(f.nombres,'<br>', f.apellidos) AS nombre, so.idfuncionario, p.desc_prioridad FROM solicitud so
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN estado_solicitud e ON e.idestado_solicitud = so.idestado_solicitud
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN tipo_prioridad p ON p.idprioridad= so.idprioridad WHERE so.idarea='9' AND so.idfuncionario='$CurrentUser' ORDER BY so.fechahora_solicitud DESC",$cn);
}
 
?>
 <script type="text/javascript">
 $(document).ready(function(){
   $('#tabla_listado_funcionarios').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
		"sPaginationType": "full_numbers",
		"aaSorting": [[ 2, "desc" ]],
"aoColumns": [
null,
null,
null,
null,
null,
null,
null,
null
]
} );
} );
 </script>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_listado_funcionarios">
<thead>
    <tr>
		<th align="left" width="15%">Sede</th>
        <th align="left" width="15%">Nombre</th>
		<th align="left" width="10%">Fecha/Hora Solicitud</th>
        <th align="left" width="5%">Tipo Prioridad:</th>
        <th align="left" width="5%%">Estado:</th>
        <th align="left" width="5%%">Satisfacción</th>
        <th align="left" width="10%">Visitado Por:</th>
        <th align="left" colspan="11" width="20%">Tareas</th>
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
   while($reg = mysql_fetch_array($listado))
   {
	   $CurrentUser = $_SESSION[currentuser];
	   $id=$reg[idsolicitud];
	   $list= mysql_query("SELECT so.idsolicitud, CONCAT(d.nombres,'<br>', d.apellidos) AS nombre FROM solicitud so
INNER JOIN funcionario d ON d.idfuncionario= so.idfuncionarioresponde WHERE idsolicitud='$id'",$cn);
	   $reg2=mysql_fetch_array($list);
	   $FECHASOL=$reg['fechahora_solicitud'];
	   $url=$reg['url_adjunto'];
       echo '<tr>';
	   echo '<td align="left">'.mb_convert_encoding($reg['descsede'], "UTF-8").'</td>';
       echo '<td align="left">'.mb_convert_encoding($reg['nombre'], "UTF-8").'</td>';
       echo '<td align="left">'.mb_convert_encoding($FECHASOL.'<br>'.$reg['horasolicitud'], "UTF-8").'</td>';
	   echo '<td align="left">'.mb_convert_encoding($reg['desc_prioridad'], "UTF-8").'</td>'; 
	   echo '<td align="left">'.mb_convert_encoding($reg['descestado_solicitud'], "UTF-8").'</td>';	      
	  
	  if ($CurrentUser==$reg['idfuncionario']){
	   if ($reg['idsatisfaccion']==3){
echo '<td align="center">Si<input value="1" type="radio" name="'.$reg['idsolicitud'].'" id="opt" onClick="satisfecho('.$reg['idsolicitud'].')">';?>
<a href="../update/porque.php?id=<?php echo $reg['idsolicitud']?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=280, height=330, top=200, left=500'); return false;">No<input type="radio" name="<?php echo $reg['idsolicitud']?>"(<?php echo $reg['idsolicitud']?>)"></a>
<?php echo '</td>';
		   
	   if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].')" checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')"></td>';

	 }
	 if ($reg['idsatisfaccion']==2) {
echo '<td align="center">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')" checked="checked"></td>';
}
	   }
   else{
	   if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" ('.$reg['idsolicitud'].') checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" ('.$reg['idsolicitud'].')></td>';

	 }
	 if ($reg['idsatisfaccion']==2) {
echo '<td align="center">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" ('.$reg['idsolicitud'].') checked="checked"></td>';
} 
	   }
	  }else
	  {
		  if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" ('.$reg['idsolicitud'].') checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')></td>';

	 }
		 if ($reg['idsatisfaccion']==2) {
echo '<td align="center">Si<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') checked="checked"></td>';
} 
		if ($reg['idsatisfaccion']==3){
			echo '<td align="center">Si<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')">
			No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')"></td>';
}
}
	 
	 if ($reg['idestado_solicitud']==1 || $reg['idestado_solicitud']==2 )
	   {
		   echo '<td>No se ha Visitado</td>';
		   if ($area==9)
	       {   
		   echo '<td align="center">
           <select name="'.$reg['idsolicitud'].'" id="'.$reg['idsolicitud'].'" onchange="CambiarEstado('.$reg['idsolicitud'].')">
            <option value="">.:Seleccione:.</option>
			<option value="2">En Proceso</option>
			<option value="3">Cumplido</option>
			<option value="4">No Cumplido</option>
			</select>
			</td>';
		   }
		   else
		   {
			   echo '<td></td>';
			}
	   }
	   else
	   {
		echo '<td align="left">'.mb_convert_encoding($reg2['nombre'], "UTF-8").'</td>';
		echo '<td></td>';
       }
   echo '<td align="rigth">';
   $sqlAdjunto = mysql_query("SELECT ad.idsolicitud,ad.adjunto,ad.idadjunto,so.idsolicitud FROM adjuntos_solicitudes ad
INNER JOIN solicitud so ON so.idsolicitud = ad.idsolicitud where so.idsolicitud='$id'", $cn);

	while($regAdjunto = mysql_fetch_array($sqlAdjunto))
   {
	   $url=$regAdjunto['adjunto'];
	   list($directorio,$ced,$archivo)=explode("/",$url);
	   if ($archivo!="")
	   {
	echo '<a href="../insert/descarga.php?id='.$regAdjunto['adjunto'].'"><img src="../../../images/ark2.png" width="20" height="20" id="Image1" border="0" alt="Descargar Adjunto" title="Descargar Adjunto"></a>';
	   }
   }
	  ?>
      <!--<a href="../pdf.php?id=<?php echo $reg['idsolicitud']?>" target="pop" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../images/fileprint.png" width="20" height="20" id="Image1" border="0" alt="Imprimir" title="Imprimir"></a>
      --><a href="detalle.php?id=<?php echo $reg['idsolicitud']?>&area=9" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../images/kfind.png" width="20" height="20" id="Image1" border="0" alt="Imprimir" title="Imprimir"></a>
   </td>
       </tr>
       <?php
	   }
    ?>
<tbody>
</table>

<br>
<div class="row" aling="left">
<?php
if ($count>=1)
{
?>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
 Realizar Solicitud
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog">
   <div class="modal-content">
     <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <font color="#006"><h3 class="modal-title" id="myModalLabel">Realizar Solicitud</h3></font>
     </div>
     <div class="modal-body">
<h4><?php echo $regusuario['nombres'].'&nbsp;'.$regusuario['apellidos']?></h4>
<h4>Por favor califique todas las solicitudes resueltas por el departamente de infraestructura.</h4>
<h4>Muchas Gracias.</h4>
     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
     </div>
   </div>
 </div>
</div>
<?php
}
//sino se cumple mostramos el formulario para poder realizar la solicitud.
else
{
?>
 <a  href="../SolicitudComunicaciones.php?usuario=<?php echo base64_encode($CurrentUser)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1900, height=800, top=0, left=140'); return false;" class="btn btn-primary btn-sm">Realizar Solicitud</a>
<?php
}
?>
</div>
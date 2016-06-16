<?php 
session_start();
$_SESSION[area] = $area;
$CurrentUser = $_SESSION[currentuser];
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
echo $fecha_inicio=$_GET[fecha_inicio];
echo $fecha_limite=$_GET[fecha_fin];
$fecha_inicio = date("Y-m-d",strtotime($fecha_inicio));
$fecha_limite = date("Y-m-d",strtotime($fecha_limite));
//consulta para obtener los datos del especialista
if ($area==3 || $area==6 || $area==11)
{
$listado =  mysql_query("SELECT so.idfuncionario, so.idsolicitud, so.desc_requerimiento, so.fechahora_solicitud, so.horasolicitud, so.idsatisfaccion, so.idestado_solicitud,
s.descsede, e.descestado_solicitud, CONCAT(f.nombres,'<br>', f.apellidos) AS nombre, p.desc_prioridad, so.id_tiposolicitud, so.id_estadocompra, so.id_presupuesto,so.idsatisfaccion FROM solicitud so
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN estado_solicitud e ON e.idestado_solicitud = so.idestado_solicitud
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN tipo_prioridad p ON p.idprioridad= so.idprioridad WHERE so.idarea='3' AND so.id_tiposolicitud='1' AND so.id_presupuesto!=0;",$cn);
}
else if ($area==5)
{
	$listado =  mysql_query("SELECT so.idfuncionario, so.idsolicitud, so.desc_requerimiento, so.fechahora_solicitud, so.horasolicitud, so.idsatisfaccion, so.idestado_solicitud,
s.descsede, e.descestado_solicitud, CONCAT(f.nombres,'<br>', f.apellidos) AS nombre, p.desc_prioridad, so.id_tiposolicitud, so.id_estadocompra,so.idsatisfaccion FROM solicitud so
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN estado_solicitud e ON e.idestado_solicitud = so.idestado_solicitud
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN tipo_prioridad p ON p.idprioridad= so.idprioridad WHERE so.idarea='3' AND so.id_tiposolicitud='1' AND so.idestado_solicitud='5'",$cn);
}
else if ($area==7 || $area==10)
{
	$listado =  mysql_query("SELECT so.idfuncionario, so.idsolicitud, so.desc_requerimiento, so.fechahora_solicitud, so.horasolicitud, so.idsatisfaccion, so.idestado_solicitud,
s.descsede, e.descestado_solicitud, CONCAT(f.nombres,'<br>', f.apellidos) AS nombre, p.desc_prioridad, so.id_tiposolicitud, so.id_estadocompra, so.id_presupuesto,so.idsatisfaccion FROM solicitud so
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN estado_solicitud e ON e.idestado_solicitud = so.idestado_solicitud
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN tipo_prioridad p ON p.idprioridad= so.idprioridad
 WHERE so.idarea='3' AND so.id_tiposolicitud='1'",$cn);
}else if ($area==12){
	$listado =  mysql_query("SELECT so.idfuncionario, so.idsolicitud, so.desc_requerimiento, so.fechahora_solicitud, so.horasolicitud, so.idsatisfaccion, so.idestado_solicitud,
s.descsede, e.descestado_solicitud, CONCAT(f.nombres,'<br>', f.apellidos) AS nombre, p.desc_prioridad, so.id_tiposolicitud, so.id_estadocompra, so.id_presupuesto,so.idsatisfaccion FROM solicitud so
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN estado_solicitud e ON e.idestado_solicitud = so.idestado_solicitud
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN tipo_prioridad p ON p.idprioridad= so.idprioridad WHERE so.idarea='3' AND so.id_tiposolicitud='1' and so.idestado_solicitud=8",$cn);
}
	else 
	{
		$listado =  mysql_query("SELECT so.idfuncionario, so.idsolicitud, so.desc_requerimiento, so.fechahora_solicitud, so.horasolicitud, so.idsatisfaccion, so.idestado_solicitud,
s.descsede, e.descestado_solicitud, CONCAT(f.nombres,'<br>', f.apellidos) AS nombre, p.desc_prioridad, so.id_tiposolicitud, so.id_estadocompra FROM solicitud so
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN estado_solicitud e ON e.idestado_solicitud = so.idestado_solicitud
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN tipo_prioridad p ON p.idprioridad= so.idprioridad
 WHERE so.idarea='3' AND so.idfuncionario='$CurrentUser' AND so.id_tiposolicitud='1'",$cn);
	}
?>
<script type="text/javascript">
 $(document).ready(function(){
   $('#tabla_listado_').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers",
		"aaSorting": [[ 0, "desc" ]],
"aoColumns": [
null,
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
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_listado_">
<thead>
    <tr>
        <th align="left" width="5%">Codigo</th><!--Estado-->
        <th align="left" width="20%">Sede</th><!--Estado-->
        <th align="left" width="13%">Nombre</th>
        <th align="left" width="10%">Fecha Solicitud</th>
        <th align="left" width="5%">Hora Solicitud</th>
        <th align="left" width="10%">Recibió a satisfacción</th>
        <th align="left" width="10%">Estado</th>
        <th align="left" width="10%">Respondido por</th>
        <th align="left" width="27%">Tareas</th>
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
	   $id=$reg[idsolicitud];
	   $list= mysql_query("SELECT so.idsolicitud, CONCAT(d.nombres,'<br>', d.apellidos) AS nombre FROM solicitud so
INNER JOIN funcionario d ON d.idfuncionario= so.idfuncionarioresponde WHERE idsolicitud='$id'",$cn);
$reg2=mysql_fetch_array($list);
$sqlAdjunto = mysql_query("SELECT ad.idsolicitud,ad.adjunto,ad.idadjunto,so.idsolicitud FROM adjuntos_solicitudes ad
INNER JOIN solicitud so ON so.idsolicitud = ad.idsolicitud where so.idsolicitud='$id'", $cn);
list($directorio,$ced,$archivo)=explode("/",$url);
//validamos el area y estado de la solicitud para listar solo las solicitudes aprobadas para que el area de suministroshaga su proceso sin inconvenientes
if ($area==5 and $reg[idestado_solicitud]==5)
{
       echo '<tr>';
	   //validamos el estado que califica suministros para validar y dar por completado la solicitud
	   if ($reg['id_estadocompra']==3)
			 {
	   echo '<td align="left" bgcolor="FF8282">'.mb_convert_encoding($reg['idsolicitud'], "UTF-8").'</td>';
       echo '<td align="left" bgcolor="FF8282">'.mb_convert_encoding($reg['descsede'], "UTF-8").'</td>';
       echo '<td align="left" bgcolor="FF8282">'.mb_convert_encoding($reg['nombre'], "UTF-8").'</td>';
       echo '<td align="left" bgcolor="FF8282">'.mb_convert_encoding($reg['fechahora_solicitud'], "UTF-8").'</td>';
	   echo '<td align="left" bgcolor="FF8282">'.mb_convert_encoding($reg['horasolicitud'], "UTF-8").'</td>';
	   if ($CurrentUser==$reg['idfuncionario']){	   
	   if ($reg['idsatisfaccion']==3){
echo '<td align="center" bgcolor="FF8282">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')"></td>';
		   
	   if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="FF8282">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].')" checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')"></td>';

	 }
	 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="FF8282">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')" checked="checked"></td>';
}
	   }
   else{
	   if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="FF8282">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" ('.$reg['idsolicitud'].') checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" ('.$reg['idsolicitud'].')></td>';

	 }
	 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="FF8282">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" ('.$reg['idsolicitud'].') checked="checked"></td>';
} 
	   }
	  }else
	  {
		  if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="FF8282">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" ('.$reg['idsolicitud'].') checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')></td>';

	 }
		 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="FF8282">Si<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') checked="checked"></td>';
} 
		if ($reg['idsatisfaccion']==3){
echo '<td align="center" bgcolor="FF8282">Si<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')"></td>';
}
}
	   echo '<td align="left" bgcolor="FF8282">'.mb_convert_encoding($reg['descestado_solicitud'], "UTF-8").'</td>';	   
	   echo '<td align="left" bgcolor="FF8282">'.mb_convert_encoding($reg2['nombre'], "UTF-8").'</td>'; 
	   echo '<td bgcolor="FF8282">
	   <input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="4" alt="En Tramite" title="En Tramite" onclick="enpro('.$reg['idsolicitud'].')"><img src="../../../images/edit_remove.png" width="20" height="20" id="Image1" border="0" alt="En Tramite" title="En Tramite"><br>
		<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="5" alt="Cumplido" title="Cumplido" onclick="cumplid('.$reg['idsolicitud'].')"><img src="../../../images/apply.png" width="20" height="20" id="Image1" border="0" alt="Cumplido" title="Cumplido">';
		while($regAdjunto = mysql_fetch_array($sqlAdjunto))
   {
	   $url=$regAdjunto['adjunto'];
	   list($directorio,$ced,$archivo)=explode("/",$url);
	   if ($archivo!="")
	   {
	echo '<a href="../insert/descarga.php?id='.$regAdjunto['adjunto'].'"><img src="../../../images/ark2.png" width="20" height="20" id="Image1" border="0" alt="Descargar Adjunto" title="Descargar Adjunto"></a>';
	   }
   }	
	    echo '<a href="../listado/detallecompras.php?id='.$reg['idsolicitud'].'&area=3" target="popup" onClick="window.open(this.href, this.target, width=300,height=400); return false;"><img src="../../../images/kfind.png" width="20" height="20" id="Image1" border="0" alt="Ver Detalles" title="Ver Detalles"></a>';
	   	echo '<a href="facturacompras.php?id='.$reg['idsolicitud'].'" target="popup" onClick="window.open(this.href, this.target, width=300,height=400); return false;"><img src="../../../images/fileprint.png" width="20" height="20" id="Image1" border="0" alt="Imprimir" title="Imprimir"></a></td>';
             }
//validamos el estado que califica suministros para validar y dar por completado la solicitud
		 else if ($reg['id_estadocompra']==4)	
			 {
	   echo '<td align="left" bgcolor="FFFF8A">'.mb_convert_encoding($reg['idsolicitud'], "UTF-8").'</td>';
       echo '<td align="left" bgcolor="FFFF8A">'.mb_convert_encoding($reg['descsede'], "UTF-8").'</td>';
       echo '<td align="left" bgcolor="FFFF8A">'.mb_convert_encoding($reg['nombre'], "UTF-8").'</td>';
       echo '<td align="left" bgcolor="FFFF8A">'.mb_convert_encoding($reg['fechahora_solicitud'], "UTF-8").'</td>';
	   echo '<td align="left" bgcolor="FFFF8A">'.mb_convert_encoding($reg['horasolicitud'], "UTF-8").'</td>';
	   if ($CurrentUser==$reg['idfuncionario']){	   
	   if ($reg['idsatisfaccion']==3){
echo '<td align="center" bgcolor="FFFF8A">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')"></td>';
		   
	   if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="FFFF8A">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].')" checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')"></td>';

	 }
	 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="FFFF8A">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')" checked="checked"></td>';
}
	   }
   else{
	   if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="FFFF8A">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" ('.$reg['idsolicitud'].') checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" ('.$reg['idsolicitud'].')></td>';

	 }
	 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="FFFF8A">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" ('.$reg['idsolicitud'].') checked="checked"></td>';
} 
	   }
	  }else
	  {
		  if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="FFFF8A">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" ('.$reg['idsolicitud'].') checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')></td>';

	 }
		 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="FFFF8A">Si<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') checked="checked"></td>';
} 
		if ($reg['idsatisfaccion']==3){
echo '<td align="center" bgcolor="FFFF8A">Si<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')"></td>';
}
}
	   echo '<td align="left" bgcolor="FFFF8A">'.mb_convert_encoding($reg['descestado_solicitud'], "UTF-8").'</td>';	   
	   echo '<td align="left" bgcolor="FFFF8A">'.mb_convert_encoding($reg2['nombre'], "UTF-8").'</td>'; 
	   echo '<td bgcolor="FFFF8A"><input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="4" checked="checked" alt="En Tramite" title="En Tramite"><img src="../../../images/edit_remove.png" width="20" height="20" id="Image1" border="0" alt="En Tramite" title="En Tramite"><br>
<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="5" alt="Cumplido" title="Cumplido" onclick="cumplid('.$reg['idsolicitud'].')"><img src="../../../images/apply.png" width="20" height="20" id="Image1" border="0" alt="Cumplido" title="Cumplido">';
		while($regAdjunto = mysql_fetch_array($sqlAdjunto))
   {
	   $url=$regAdjunto['adjunto'];
	   list($directorio,$ced,$archivo)=explode("/",$url);
	   if ($archivo!="")
	   {
	echo '<a href="../insert/descarga.php?id='.$regAdjunto['adjunto'].'"><img src="../../../images/ark2.png" width="20" height="20" id="Image1" border="0" alt="Descargar Adjunto" title="Descargar Adjunto"></a>';
	   }
   }	
	    echo '<a href="../listado/detallecompras.php?id='.$reg['idsolicitud'].'&area=3" target="popup" onClick="window.open(this.href, this.target, width=300,height=400); return false;"><img src="../../../images/kfind.png" width="20" height="20" id="Image1" border="0" alt="Ver Detalles" title="Ver Detalles"></a>';
	   echo '<a href="facturacompras.php?id='.$reg['idsolicitud'].'" target="popup" onClick="window.open(this.href, this.target, width=300,height=400); return false;"><img src="../../../images/fileprint.png" width="20" height="20" id="Image1" border="0" alt="Imprimir" title="Imprimir"></a></td>';
		}
//validamos el estado que califica suministros para validar y dar por completado la solicitud
		elseif ($reg['id_estadocompra']==5)	
		{
	   echo '<td align="left" bgcolor="C8CBFD">'.mb_convert_encoding($reg['idsolicitud'], "UTF-8").'</td>';
       echo '<td align="left" bgcolor="C8CBFD">'.mb_convert_encoding($reg['descsede'], "UTF-8").'</td>';
       echo '<td align="left" bgcolor="C8CBFD">'.mb_convert_encoding($reg['nombre'], "UTF-8").'</td>';
       echo '<td align="left" bgcolor="C8CBFD">'.mb_convert_encoding($reg['fechahora_solicitud'], "UTF-8").'</td>';
	   echo '<td align="left" bgcolor="C8CBFD">'.mb_convert_encoding($reg['horasolicitud'], "UTF-8").'</td>';
	   if ($CurrentUser==$reg['idfuncionario']){	   
	   if ($reg['idsatisfaccion']==3){
echo '<td align="center" bgcolor="C8CBFD">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')"></td>';
		   
	   if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="C8CBFD">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].')" checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')"></td>';

	 }
	 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="C8CBFD">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')" checked="checked"></td>';
}
	   }
   else{
	   if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="C8CBFD">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" ('.$reg['idsolicitud'].') checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" ('.$reg['idsolicitud'].')></td>';

	 }
	 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="C8CBFD">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" ('.$reg['idsolicitud'].') checked="checked"></td>';
} 
	   }
	  }else
	  {
		  if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="C8CBFD">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" ('.$reg['idsolicitud'].') checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')></td>';

	 }
		 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="C8CBFD">Si<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') checked="checked"></td>';
} 
		if ($reg['idsatisfaccion']==3){
echo '<td align="center" bgcolor="C8CBFD">Si<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')"></td>';
}
}
	   echo '<td align="left" bgcolor="C8CBFD">'.mb_convert_encoding($reg['descestado_solicitud'], "UTF-8").'</td>';	   
	   echo '<td align="left" bgcolor="C8CBFD">'.mb_convert_encoding($reg2['nombre'], "UTF-8").'</td>'; 
	   echo '<td bgcolor="C8CBFD"><input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="4" alt="En Tramite" title="En Tramite" onclick="cumplido('.$reg['idsolicitud'].')"><img src="../../../images/edit_remove.png" width="20" height="20" id="Image1" border="0" alt="En Tramite" title="En Tramite">
			<br><input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="5" checked="checked" alt="Cumplido" title="Cumplido" onclick="cumplido('.$reg['idsolicitud'].')"><img src="../../../images/apply.png" width="20" height="20" id="Image1" border="0" alt="Cumplido" title="Cumplido">';
		while($regAdjunto = mysql_fetch_array($sqlAdjunto))
   {
	   $url=$regAdjunto['adjunto'];
	   list($directorio,$ced,$archivo)=explode("/",$url);
	   if ($archivo!="")
	   {
	echo '<a href="../insert/descarga.php?id='.$regAdjunto['adjunto'].'"><img src="../../../images/ark2.png" width="20" height="20" id="Image1" border="0" alt="Descargar Adjunto" title="Descargar Adjunto"></a>';
	   }
   }	
	    echo '<a href="../listado/detallecompras.php?id='.$reg['idsolicitud'].'&area=3" target="popup" onClick="window.open(this.href, this.target, width=300,height=400); return false;"><img src="../../../images/kfind.png" width="20" height="20" id="Image1" border="0" alt="Ver Detalles" title="Ver Detalles"></a>';
	   echo '<a href="facturacompras.php?id='.$reg['idsolicitud'].'" target="popup" onClick="window.open(this.href, this.target, width=300,height=400); return false;"><img src="../../../images/fileprint.png" width="20" height="20" id="Image1" border="0" alt="Imprimir" title="Imprimir"></a></td>';
		}	
       echo '</tr>';
}
//si el area es de aprobacion se lista lo necesario para la aprobacion para determinar los colores
else
{
echo '<tr>';
		if ($reg['idestado_solicitud']==1 || $reg['idestado_solicitud']==8)
	   {
		echo '<td align="left" bgcolor="E6EFF1">'.mb_convert_encoding($reg['idsolicitud'], "UTF-8").'</td>';
    	echo '<td align="left" bgcolor="E6EFF1">'.mb_convert_encoding($reg['descsede'], "UTF-8").'</td>';
    	echo '<td align="left" bgcolor="E6EFF1">'.mb_convert_encoding($reg['nombre'], "UTF-8").'</td>';
    	echo '<td align="left" bgcolor="E6EFF1">'.mb_convert_encoding($reg['fechahora_solicitud'], "UTF-8").'</td>';
		echo '<td align="left" bgcolor="E6EFF1">'.mb_convert_encoding($reg['horasolicitud'], "UTF-8").'</td>';
		if ($CurrentUser==$reg['idfuncionario']){	   
	   if ($reg['idsatisfaccion']==3){
echo '<td align="center" bgcolor="E6EFF1">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')"></td>';
		   
	   if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="E6EFF1">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].')" checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')"></td>';

	 }
	 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="E6EFF1">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')" checked="checked"></td>';
}
	   }
   else{
	   if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="E6EFF1">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" ('.$reg['idsolicitud'].') checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" ('.$reg['idsolicitud'].')></td>';

	 }
	 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="E6EFF1">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" ('.$reg['idsolicitud'].') checked="checked"></td>';
} 
	   }
	  }else
	  {
		  if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="E6EFF1">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" ('.$reg['idsolicitud'].') checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')></td>';

	 }
		 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="E6EFF1">Si<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') checked="checked"></td>';
} 
		if ($reg['idsatisfaccion']==3){
echo '<td align="center" bgcolor="E6EFF1">Si<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')"></td>';
}
}
		echo '<td align="left" bgcolor="E6EFF1">'.mb_convert_encoding($reg['descestado_solicitud'], "UTF-8").'</td>';
	    echo '<td bgcolor="E6EFF1">No se ha Visitado</td>';
	   	echo '<td align="rigth" bgcolor="E6EFF1">';
		   if ($area==3)
		   {
			   echo '<select name="'.$reg['idsolicitud'].'" id="'.$reg['idsolicitud'].'" onchange="CambiarEstado('.$reg['idsolicitud'].')">
            <option value="">.:Seleccione:.</option>
			<option value="8">Pre Aprobado</option>
			<option value="6">No Aprobado</option>
			<option value="7">En tramite</option>
			</select>';
		   } else if($area==12){
			   echo '<select name="'.$reg['idsolicitud'].'" id="'.$reg['idsolicitud'].'" onchange="CambiarEstado('.$reg['idsolicitud'].')">
            <option value="">.:Seleccione:.</option>
			<option value="5">Aprobado</option>
			<option value="6">No Aprobado</option>
			</select>';
		   }
		while($regAdjunto = mysql_fetch_array($sqlAdjunto))
   {
	   $url=$regAdjunto['adjunto'];
	   list($directorio,$ced,$archivo)=explode("/",$url);
	   if ($archivo!="")
	   {
	echo '<a href="../insert/descarga.php?id='.$regAdjunto['adjunto'].'"><img src="../../../images/ark2.png" width="20" height="20" id="Image1" border="0" alt="Descargar Adjunto" title="Descargar Adjunto"></a>';
	   }
   }		
		echo '<a href="../listado/detallecompras.php?id='.$reg['idsolicitud'].'&area=3" target="popup" onClick="window.open(this.href, this.target, width=300,height=400); return false;"><img src="../../../images/kfind.png" width="20" height="20" id="Image1" border="0" alt="Ver Detalles" title="Ver Detalles"></a>';
	   	echo '<a href="facturacompras.php?id='.$reg['idsolicitud'].'" target="popup" onClick="window.open(this.href, this.target, width=300,height=400); return false;"><img src="../../../images/fileprint.png" width="20" height="20" id="Image1" border="0" alt="Imprimir" title="Imprimir"></a>';
		'</td>';
		}
		else if ($reg['idestado_solicitud']==5) 
		{
		echo '<td align="left" bgcolor="C8CBFD">'.mb_convert_encoding($reg['idsolicitud'], "UTF-8").'</td>';
    	echo '<td align="left" bgcolor="C8CBFD">'.mb_convert_encoding($reg['descsede'], "UTF-8").'</td>';
    	echo '<td align="left" bgcolor="C8CBFD">'.mb_convert_encoding($reg['nombre'], "UTF-8").'</td>';
    	echo '<td align="left" bgcolor="C8CBFD">'.mb_convert_encoding($reg['fechahora_solicitud'], "UTF-8").'</td>';
		echo '<td align="left" bgcolor="C8CBFD">'.mb_convert_encoding($reg['horasolicitud'], "UTF-8").'</td>';
		if ($CurrentUser==$reg['idfuncionario']){	   
	   if ($reg['idsatisfaccion']==3){
echo '<td align="center" bgcolor="C8CBFD">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')"></td>';
		   
	   if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="C8CBFD">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].')" checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')"></td>';

	 }
	 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="C8CBFD">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')" checked="checked"></td>';
}
	   }
   else{
	   if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="C8CBFD">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" ('.$reg['idsolicitud'].') checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" ('.$reg['idsolicitud'].')></td>';

	 }
	 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="C8CBFD">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" ('.$reg['idsolicitud'].') checked="checked"></td>';
} 
	   }
	  }else
	  {
		  if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="C8CBFD">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" ('.$reg['idsolicitud'].') checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')></td>';

	 }
		 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="C8CBFD">Si<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') checked="checked"></td>';
} 
		if ($reg['idsatisfaccion']==3){
echo '<td align="center" bgcolor="C8CBFD">Si<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')"></td>';
}
}
		echo '<td align="left" bgcolor="C8CBFD">'.mb_convert_encoding($reg['descestado_solicitud'], "UTF-8").'</td>';
		echo '<td align="left" bgcolor="C8CBFD">'.mb_convert_encoding($reg2['nombre'], "UTF-8").'</td>'; 
		echo '<td align="rigth" bgcolor="C8CBFD">';
		while($regAdjunto = mysql_fetch_array($sqlAdjunto))
   {
	   $url=$regAdjunto['adjunto'];
	   list($directorio,$ced,$archivo)=explode("/",$url);
	   if ($archivo!="")
	   {
	echo '<a href="../insert/descarga.php?id='.$regAdjunto['adjunto'].'"><img src="../../../images/ark2.png" width="20" height="20" id="Image1" border="0" alt="Descargar Adjunto" title="Descargar Adjunto"></a>';
	   }
   }	
		echo '<a href="../listado/detallecompras.php?id='.$reg['idsolicitud'].'&area=3" target="popup" onClick="window.open(this.href, this.target, width=300,height=400); return false;"><img src="../../../images/kfind.png" width="20" height="20" id="Image1" border="0" alt="Ver Detalles" title="Ver Detalles"></a>';
	   	echo '<a href="facturacompras.php?id='.$reg['idsolicitud'].'" target="popup" onClick="window.open(this.href, this.target, width=300,height=400); return false;"><img src="../../../images/fileprint.png" width="20" height="20" id="Image1" border="0" alt="Imprimir" title="Imprimir"></a></td>';
		}
		else if ($reg['idestado_solicitud']==6) 
		{
		echo '<td align="left" bgcolor="FF8282">'.mb_convert_encoding($reg['idsolicitud'], "UTF-8").'</td>';
    	echo '<td align="left" bgcolor="FF8282">'.mb_convert_encoding($reg['descsede'], "UTF-8").'</td>';
    	echo '<td align="left" bgcolor="FF8282">'.mb_convert_encoding($reg['nombre'], "UTF-8").'</td>';
    	echo '<td align="left" bgcolor="FF8282">'.mb_convert_encoding($reg['fechahora_solicitud'], "UTF-8").'</td>';
		echo '<td align="left" bgcolor="FF8282">'.mb_convert_encoding($reg['horasolicitud'], "UTF-8").'</td>';
		if ($CurrentUser==$reg['idfuncionario']){	   
	   if ($reg['idsatisfaccion']==3){
echo '<td align="center" bgcolor="FF8282">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')"></td>';
		   
	   if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="FF8282">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].')" checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')"></td>';

	 }
	 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="FF8282">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')" checked="checked"></td>';
}
	   }
   else{
	   if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="FF8282">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" ('.$reg['idsolicitud'].') checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" ('.$reg['idsolicitud'].')></td>';

	 }
	 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="FF8282">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" ('.$reg['idsolicitud'].') checked="checked"></td>';
} 
	   }
	  }else
	  {
		  if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="FF8282">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" ('.$reg['idsolicitud'].') checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')></td>';

	 }
		 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="FF8282">Si<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') checked="checked"></td>';
} 
		if ($reg['idsatisfaccion']==3){
echo '<td align="center" bgcolor="FF8282">Si<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')"></td>';
}
}
		echo '<td align="left" bgcolor="FF8282">'.mb_convert_encoding($reg['descestado_solicitud'], "UTF-8").'</td>';
		echo '<td align="left" bgcolor="FF8282">'.mb_convert_encoding($reg2['nombre'], "UTF-8").'</td>'; 
		echo '<td align="rigth" bgcolor="FF8282">';
		while($regAdjunto = mysql_fetch_array($sqlAdjunto))
   {
	   $url=$regAdjunto['adjunto'];
	   list($directorio,$ced,$archivo)=explode("/",$url);
	   if ($archivo!="")
	   {
	echo '<a href="../insert/descarga.php?id='.$regAdjunto['adjunto'].'"><img src="../../../images/ark2.png" width="20" height="20" id="Image1" border="0" alt="Descargar Adjunto" title="Descargar Adjunto"></a>';
	   }
   }		
		echo '<a href="../listado/detallecompras.php?id='.$reg['idsolicitud'].'&area=3" target="popup" onClick="window.open(this.href, this.target, width=300,height=400); return false;"><img src="../../../images/kfind.png" width="20" height="20" id="Image1" border="0" alt="Ver Detalles" title="Ver Detalles"></a>';
	   	echo '<a href="facturacompras.php?id='.$reg['idsolicitud'].'" target="popup" onClick="window.open(this.href, this.target, width=300,height=400); return false;"><img src="../../../images/fileprint.png" width="20" height="20" id="Image1" border="0" alt="Imprimir" title="Imprimir"></a></td>';
		}
	   	else if ($reg['idestado_solicitud']==7) 
		{
		echo '<td align="left" bgcolor="FFFF8A">'.mb_convert_encoding($reg['idsolicitud'], "UTF-8").'</td>';
    	echo '<td align="left" bgcolor="FFFF8A">'.mb_convert_encoding($reg['descsede'], "UTF-8").'</td>';
    	echo '<td align="left" bgcolor="FFFF8A">'.mb_convert_encoding($reg['nombre'], "UTF-8").'</td>';
    	echo '<td align="left" bgcolor="FFFF8A">'.mb_convert_encoding($reg['fechahora_solicitud'], "UTF-8").'</td>';
		echo '<td align="left" bgcolor="FFFF8A">'.mb_convert_encoding($reg['horasolicitud'], "UTF-8").'</td>';
		if ($CurrentUser==$reg['idfuncionario']){	   
	   if ($reg['idsatisfaccion']==3){
echo '<td align="center" bgcolor="FFFF8A">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')"></td>';
		   
	   if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="FFFF8A">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].')" checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')"></td>';

	 }
	 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="FFFF8A">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" onClick="satisfecho('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" onClick="nosatisfecho('.$reg['idsolicitud'].')" checked="checked"></td>';
}
	   }
   else{
	   if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="FFFF8A">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" ('.$reg['idsolicitud'].') checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" ('.$reg['idsolicitud'].')></td>';

	 }
	 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="FFFF8A">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="2" ('.$reg['idsolicitud'].') checked="checked"></td>';
} 
	   }
	  }else
	  {
		  if ($reg['idsatisfaccion']==1)
 {
echo '<td align="center" bgcolor="FFFF8A">Si<input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="1" ('.$reg['idsolicitud'].') checked="checked">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')></td>';

	 }
		 if ($reg['idsatisfaccion']==2) {
echo '<td align="center" bgcolor="FFFF8A">Si<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') checked="checked"></td>';
} 
		if ($reg['idsatisfaccion']==3){
echo '<td align="center" bgcolor="FFFF8A">Si<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].') ">
No<input type="radio" name="'.$reg['idsolicitud'].'"('.$reg['idsolicitud'].')"></td>';
}
}
		echo '<td align="left" bgcolor="FFFF8A">'.mb_convert_encoding($reg['descestado_solicitud'], "UTF-8").'</td>';
		echo '<td align="left" bgcolor="FFFF8A">'.mb_convert_encoding($reg2['nombre'], "UTF-8").'</td>';
		echo '<td align="rigth" bgcolor="FFFF8A">';
			if ($area==3)
			{
				echo '<select name="'.$reg['idsolicitud'].'" id="'.$reg['idsolicitud'].'" onchange="CambiarEstado('.$reg['idsolicitud'].')">
            <option value="">.:Seleccione:.</option>
			<option value="8">Pre Aprobado</option>
			<option value="6">No Aprobado</option>
			<option value="7">En tramite</option>
			</select>';
			} else if($area==12){
				echo '<select name="'.$reg['idsolicitud'].'" id="'.$reg['idsolicitud'].'" onchange="CambiarEstado('.$reg['idsolicitud'].')">
            <option value="">.:Seleccione:.</option>
			<option value="5">Aprobado</option>
			<option value="6">No Aprobado</option>
			</select>';
			}
		while($regAdjunto = mysql_fetch_array($sqlAdjunto))
   {
	   $url=$regAdjunto['adjunto'];
	   list($directorio,$ced,$archivo)=explode("/",$url);
	   if ($archivo!="")
	   {
	echo '<a href="../insert/descarga.php?id='.$regAdjunto['adjunto'].'"><img src="../../../images/ark2.png" width="20" height="20" id="Image1" border="0" alt="Descargar Adjunto" title="Descargar Adjunto"></a>';
	   }
   }	
		echo '<a href="../listado/detallecompras.php?id='.$reg['idsolicitud'].'&area=3" target="popup" onClick="window.open(this.href, this.target, width=300,height=400); return false;"><img src="../../../images/kfind.png" width="20" height="20" id="Image1" border="0" alt="Ver Detalles" title="Ver Detalles"></a>';
	   	echo '<a href="facturacompras.php?id='.$reg['idsolicitud'].'" target="popup" onClick="window.open(this.href, this.target, width=300,height=400); return false;"><img src="../../../images/fileprint.png" width="20" height="20" id="Image1" border="0" alt="Imprimir" title="Imprimir"></a>';
		'</td>';
	}	
echo '</tr>';
}
//Se cierra el ciclo while
}
    ?>
<tbody>
</table>
</body>
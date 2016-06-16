<?php
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
echo $fecha_inicio=$_GET[fecha_inicio];
echo $fecha_limite=$_GET[fecha_fin];
$fecha_inicio = date("Y-m-d",strtotime($fecha_inicio));
$fecha_limite = date("Y-m-d",strtotime($fecha_limite));

//consulta para obtener los datos del especialista
if ($area==5 || $area==3 || $area==6)
{
$listado =  mysql_query("SELECT so.idsolicitud, so.desc_requerimiento, so.fechahora_solicitud, so.horasolicitud, so.idsatisfaccion, so.idestado_solicitud,
s.descsede, e.descestado_solicitud, f.nombres, f.apellidos, so.url_adjunto, p.desc_prioridad, so.porque FROM solicitud so
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN estado_solicitud e ON e.idestado_solicitud = so.idestado_solicitud
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN tipo_prioridad p ON p.idprioridad= so.idprioridad
 WHERE so.idarea='3' AND fechahora_solicitud BETWEEN '$fecha_inicio' AND '$fecha_limite' ORDER BY so.fechahora_solicitud DESC",$cn);
}
else
{
	$listado =  mysql_query("SELECT so.idsolicitud, so.desc_requerimiento, so.fechahora_solicitud, so.horasolicitud, so.idsatisfaccion, so.idestado_solicitud,
s.descsede, e.descestado_solicitud, f.nombres, f.apellidos, so.url_adjunto, p.desc_prioridad FROM solicitud so
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN estado_solicitud e ON e.idestado_solicitud = so.idestado_solicitud
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN tipo_prioridad p ON p.idprioridad= so.idprioridad
 WHERE so.idarea='3' AND fechahora_solicitud BETWEEN '$fecha_inicio' AND '$fecha_limite' AND so.idfuncionario='$CurrentUser' ORDER BY so.fechahora_solicitud DESC",$cn);
	}
while($reg = mysql_fetch_array($listado))
   {
	   $id=$reg[idsolicitud];
	   $list= mysql_query("SELECT so.idsolicitud, d.nombres, d.apellidos FROM solicitud so
INNER JOIN funcionario d ON d.idfuncionario= so.idfuncionarioresponde WHERE idsolicitud='$id'",$cn);
$reg2=mysql_fetch_array($list);

       echo '<tr>';
       echo '<td align="left">'.mb_convert_encoding($reg['descsede'], "UTF-8").'</td>';
       echo '<td align="left">'.mb_convert_encoding($reg['nombres'].$reg[apellidos], "UTF-8").'</td>';
       echo '<td align="left">'.mb_convert_encoding($reg['fechahora_solicitud'], "UTF-8").'</td>';
	   echo '<td align="left">'.mb_convert_encoding($reg['horasolicitud'], "UTF-8").'</td>';
	   echo '<td align="left">'.mb_convert_encoding($reg['desc_prioridad'], "UTF-8").'</td>';
	   echo '<td align="left">'.mb_convert_encoding($reg['descestado_solicitud'], "UTF-8").'</td>';	   
 
  if ($reg2=="" ||  $reg[idestado_solicitud]==7)
	   {
		   echo '<td>No se ha Visitado</td>';
		   if ($area==3) 
	       {   
		   echo '<td align="center"><a href="../respuesta/respuestasolicitud_compra?id='.$reg['idsolicitud'].'" onclick="$(this).modal({width:833, height:453}).open(); return false;">Responder</a></td>'; 
		   }
			else
	   {
		   echo '<td></td>';
		   }
	   }
	   else {
		echo '<td align="left">'.mb_convert_encoding($reg2['nombres'], "UTF-8").'</td>';
        echo '<td></td>';
		   }	   
   $url=$reg['url_adjunto'];
 
 list($directorio,$ced,$archivo)=explode("/",$url);
   
   if ($archivo=="")
   {
	   echo '<td align="center">Sin Adjunto</td>';
	   }
	   else
	   {
   echo '<td align="center"><a href="../insert/descarga.php?id='.$reg['url_adjunto'].'"><img src="../../../images/ark2.png" width="20" height="20" id="Image1" border="0" alt="Descargar Adjunto" title="Descargar Adjunto"></a></td>';
	   }
	    echo '<td align="center"><a href="../listado/detallecompras.php?id='.$reg['idsolicitud'].'" onclick="$(this).modal({width:833, height:453}).open(); return false;"><img src="../../../images/kfind.png" width="20" height="20" id="Image1" border="0" alt="Ver Detalles" title="Ver Detalles"></a></td>';
		
		 if ($reg['idestado_solicitud']==6)
	   {
		   echo '<td><img src="../../../images/button_cancel.png" width="20" height="20" id="Image1" border="0" alt="No Aprobado" title="No Aprobado"></td>';
		   echo '<td></td>';
	   }
	   else
   {
		if ($area==5)
		{
			if ($reg['idsatisfaccion']==3 and $reg['idestado_solicitud']==5)
			{
echo '<td><a href="../update/RespuestaComprasEnproceso.php?id='.$reg['idsolicitud'].'" onclick="$(this).modal({width:300, height:300}).open(); return false;"><input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="4" alt="En Tramite" title="En Tramite"><img src="../../../images/edit_remove.png" width="20" height="20" id="Image1" border="0" alt="En Tramite" title="En Tramite"></td>
<td><a href="../update/RespuestaComprascumplido.php?id='.$reg['idsolicitud'].'" onclick="$(this).modal({width:300, height:300}).open(); return false;"><input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="5" alt="Cumplido" title="Cumplido"><img src="../../../images/apply.png" width="20" height="20" id="Image1" border="0" alt="Cumplido" title="Cumplido"></td>';
             }
		if ($reg['idsatisfaccion']==4)	
		{
			echo '<td><input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="4" checked="checked" alt="En Tramite" title="En Tramite"><img src="../../../images/edit_remove.png" width="20" height="20" id="Image1" border="0" alt="En Tramite" title="En Tramite"></td>
<td><a href="../update/RespuestaComprascumplido.php?id='.$reg['idsolicitud'].'" onclick="$(this).modal({width:300, height:300}).open(); return false;"><input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="5" alt="Cumplido" title="Cumplido" onclick="cumplido('.$reg['idsolicitud'].')"><img src="../../../images/apply.png" width="20" height="20" id="Image1" border="0" alt="Cumplido" title="Cumplido"></td>';
			}
			elseif ($reg['idsatisfaccion']==5)	
		{
			echo '<td><input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="4" alt="En Tramite" title="En Tramite" onclick="cargar()"><img src="../../../images/edit_remove.png" width="20" height="20" id="Image1" border="0" alt="En Tramite" title="En Tramite"></td>
<td><input type="radio" name="'.$reg['idsolicitud'].'" id="opt" value="5" checked="checked" alt="Cumplido" title="Cumplido"><img src="../../../images/apply.png" width="20" height="20" id="Image1" border="0" alt="Cumplido" title="Cumplido"></td>';
			
			}

	   }
	   else
	   {
	   if ($reg['idsatisfaccion']==4 || $reg['idsatisfaccion']==3  || $reg['idestado_solicitud']==1 || $reg['idestado_solicitud']==7)
	   {
		   echo '<td align="center"><img src="../../../images/edit_remove.png" width="20" height="20" id="Image1" border="0" alt="En Tramite" title="En Tramite"></td>';
	   }
	   if ($reg['idsatisfaccion']==5)
	   {
		   echo '<td><img src="../../../images/apply.png" width="20" height="20" id="Image1" border="0" alt="Cumplido" title="Cumplido"></td>';
	   }
	  
	   }
	   }
       echo '</tr>';
	   
   }
    ?>
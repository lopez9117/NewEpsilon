<?php
	include('selects.php');
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<script type="text/javascript" src="../../../js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../../../js/jquery.dataTables.js"></script>
<script type="text/javascript" src="../../../js/ajax.js"></script>
<script>
function cargardiv()
{
	var tipo_activo
	tipo_activo=document.List_activo.tipo_activo.value;
	//sede=document.List_activo.sede.value;
$(document).ready(function(){
    verlistado()
    //CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
	function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
	  var randomnumber=Math.random()*11;
	$.post("listado_activos.php?activo="+tipo_activo+"", {
		randomnumber:randomnumber
	}, function(data){
	  $("#contenido").html(data);
	});
}
})
}
function DarBaja(codigo)
{
	var codigo;
	//etiqueta donde se va a mostrar la respuesta
	solicitud = document.getElementById('solicitud');
	ajax=nuevoAjax();
	opcion = confirm("Seguro que desea dar de baja a el activo");
	if (opcion==true)
	{
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","DarBaja.php",true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("codigo="+codigo+"&tiempo=" + new Date().getTime());
    finfuncion = CambiarEstadoActivo();
	}
	else
	{
	document.getElementById(codigo).checked=false;	
	}
	
}
function CambiarEstadoActivo()
{
	var tipo_activo
	tipo_activo=document.List_activo.tipo_activo.value;
	//sede=document.List_activo.sede.value;
$(document).ready(function(){
    verlistado()
    //CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
	function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
	  var randomnumber=Math.random()*11;
	$.post("listado_activos.php?activo="+tipo_activo+"", {
		randomnumber:randomnumber
	}, 
	function(data){
	  $("#contenido").html(data);
	});
}
})
}
</script>
<link type="text/css" href="../../../css/demo_table.css" rel="stylesheet" />
<link href="../../../css/default.css" rel="stylesheet" type="text/css">
<link href="../../../css/forms.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.marco table tr form strong {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 14px;
}
-->
</style>
</head>
<body>
<table width="100%" border="0">
<tr><td align="center" valign="middle">
	
	<div class="marco">
	<div class="ruta">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; <a href="../main_menu_activosfijos.php">Activos Fijos</a><span class="class_cargo" style="font-size:14px"> &gt; Hojas de Vida</span></span></div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br> 
   <div align="center"> <form action="List_activo.php" method="post" name="List_activo">
    <strong>Tipo Activo:</strong>
    <select name="tipo_activo" id="tipo_activo" onchange="cargardiv()">
  <option value="">.:Seleccione:.</option>
  <?php
      	while($rowtipoactivo = mysql_fetch_array($listatipoactivo))
		{
			echo '<option value="'.$rowtipoactivo[id_tipo].'">'.$rowtipoactivo[desc_tipo].'</option>';
		}
	  ?>
</select>
    </form></div>
	  <br><br>
      </td>
	</tr>
	<tr>
	<td valign="top" align="left" bgcolor="#DEDEDE" id="contenido"></td>
	</tr>
	</table>
	<br>
	</div>
</td></tr>
</table>
</body>
</html>
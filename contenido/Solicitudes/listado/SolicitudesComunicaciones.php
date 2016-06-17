<?php 
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include("../../../dbconexion/conexion.php");
include("../../../validate/ValidateSecurity2.php");

//current user
$_SESSION['username'];
$_SESSION['user_id'];

if($_SESSION['username']=="" || $_SESSION['user_id']=="" )
{
	echo 'POR FAVOR INICIAR SESSION NUEVAMENTE';
}
else
{
$Anio=date("Y");
$Mes=date("m");
$dias = date('t', mktime(0,0,0, $Mes, 1, $Anio));
$fecha_inicio=($Anio.'-'.$Mes.'-'.'01');
$fecha_limite=($Anio.'-'.$Mes.'-'.$dias);
list($AñO,$MES,$DIA)=explode("-",$fecha_inicio);
 $DESDE= $MES."/".$DIA."/".$AñO;
 list($AñO,$MES,$DIA)=explode("-",$fecha_limite);
 $HASTA= $MES."/".$DIA."/".$AñO;
?>
<!DOCTYPE>
<html>
<html>
<script type="text/javascript" src="../../../js/jquery.js"></script>
<script src="../Javascript/Funciones.js"></script>
<script type="text/javascript" language="javascript" src="../../../js/jquery.dataTables.js"></script>
<script type="text/javascript" src="../../../js/ajax.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/ajax.js"></script>
<script src="../bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../bootstrap-3.3.2-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap-3.3.2-dist/css/bootstrap-theme.min.css">
<link href="ckeditor/skins/moono/editor.css" rel="stylesheet" type="text/css">
<link href="styles/Style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link href="../../../css/default.css" rel="stylesheet" type="text/css">
<link type="text/css" href="../../../css/demo_table.css" rel="stylesheet"/>
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
  <script>
  $(function() {
    $( "#datepicker1" ).datepicker();
  });
  </script>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	overflow-x: hidden;
}
body,td,th {
	font-size: 12px;
}
</style>
<script>
function satisfecho(idsolicitud)
{
	var idsolicitud;
	//etiqueta donde se va a mostrar la respuesta
	solicitud = document.getElementById('solicitud');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","../update/satisfecho.php",true); 
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			solicitud.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idsolicitud="+idsolicitud+"&tiempo=" + new Date().getTime());
	return cargardiv();
}
//+++++++++++++++++++++++++++++++++++++++++++++++ No satisfecho ++++++++++++++++++++++++++++++++++++++++++++
function nosatisfecho(idsolicitud)
{
	var idsolicitud;
	//etiqueta donde se va a mostrar la respuesta
	solicitud = document.getElementById('solicitud');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","../update/nosatisfecho.php",true); 
	//window.open("../update/porque.php?id="+idsolicitud+"","","top=300,left=300,width=300,height=300,aling=center");
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			solicitud.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idsolicitud="+idsolicitud+"&tiempo=" + new Date().getTime());
	return cargardiv();
}
function CambiarEstado(idsolicitud)
{
	var idsolicitud,estado;
	estado=document.getElementById(idsolicitud).value;
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","../update/UpdateEstado.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			solicitud.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idsolicitud="+idsolicitud+"&estado="+estado+"&tiempo=" + new Date().getTime());
	return cargardiv();
}
function exportarexcel()
{
	var fechaDesde,fechaHasta;
	fechaDesde = document.Solicitud.fechaDesde.value;
	fechaHasta = document.Solicitud.fechaHasta.value;
	document.Solicitud.submit();
}
function cargardiv()
{
	var fechaDesde,fechaHasta,Satisfaccion;
	fechaDesde = document.Solicitud.fechaDesde.value;
	fechaHasta = document.Solicitud.fechaHasta.value;
	Satisfaccion = document.Solicitud.Satisfaccion.value;
$(document).ready(function(){
    verlistado()
    //CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
})
function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
	  var randomnumber=Math.random()*0;
	$.post("../listado/listado_solicitudesComunicaciones.php?fechaHasta="+fechaHasta+"&fechaDesde="+fechaDesde+"&Satisfaccion="+Satisfaccion+"", {
		randomnumber:randomnumber
	}, function(data){
	  $("#contenido").html(data);
	});
}
}
</script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
</head>
<body topmargin="0" OnLoad="cargardiv()">
<table width="100%" border="0">
<tr><td align="center" valign="middle">
	<div class="marco">
	<div class="ruta">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; <a href="../menu/main_menu_solicitudes.php"> Solicitudes </a> </span><span class="class_cargo" style="font-size:14px">&gt; Vista Solicitudes</span> 
 </div>
 
 <table width="98%" border="0">
    <tr>
    <td colspan="3" valign="top" align="left">
    <div style="border-bottom: #D3D3D3 2px dotted"></div>
    <form form action="../excel/ficheroExcelComunicaciones.php" name="Solicitud" id="Solicitud" method="post">
    <br />
    <br />
   <div class="row">
<input type="hidden" name="idFuncionario" id="idFuncionario">
        <div class="col-lg-4 col-sm-12 col-xs-12">
            <div class="form-group">
            <label for="datepicker1"><strong>Desde</strong></label>
            <input type="text" id="datepicker1" name="fechaDesde" class="form-control" value="<?php echo $DESDE;
?>" onChange="cargardiv()" readonly />
         </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-12">
            <div class="form-group">
    <label for="datepicker"><strong>Hasta</strong></label>
     <input type="text" id="datepicker" name="fechaHasta" class="form-control" value="<?php
echo $HASTA;
?>" onChange="cargardiv()" readonly />
    </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-12">
            <div class="form-group">
    <label for="Satisfaccion"><strong>Satisfacci&oacute;n</strong></label>
      <select name="Satisfaccion" id="Satisfaccion" onChange="cargardiv()" class="form-control">
      <option value="4">Todas</option> 
      <option value="3">Sin Responder</option>
      <option value="1">Si Satisfecho</option>
      <option value="2">No Satisfecho</option>
      </select>
      </div>
        </div>
        </div>
        <div class="row" align="right">
        <div class="col-lg-12 col-sm-12 col-xs-12">
   <button id="1" type="button" onClick="exportarexcel()" class="btn btn-success btn-sm">Exportar Excel
</button>
      </div>
          </div>
          <br />
</form>
	<tr>
	<td colspan="3" valign="top" align="left" bgcolor="#DEDEDE" id="contenido"></td>
	</tr>
	</table>
	<br>
	</div>
</td></tr>
</table>
<?php
}
?>
</body>
</html>

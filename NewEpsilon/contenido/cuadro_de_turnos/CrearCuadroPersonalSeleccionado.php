<?php
session_start();
//Conexion a la base de datos
include('../../dbconexion/conexion.php');
include('ClassHoras.php');
include('ClassFuncionario.php');
//funcion para abrir conexion
$cn = Conectarse();
//variables con post
$_SESSION['array'] = $_POST['id'];
$_SESSION['sede'] = $_POST['sede'];
$_SESSION['mes'] = $_POST['mes'];
$_SESSION['anio'] = $_POST['anio'];
$_SESSION['grupoEmpleado'] = $_POST['grupoEmpleado'];
$_SESSION['CurrentUser'] = $_POST['Currentuser'];	
//validar que se elija por lo menos un funcionario
if($_SESSION['array'] == "")
{
	echo '<script language="javascript">
		alert("Debe de seleccionar por lo menos un funcionario de la lista");
		window.close();
	</script>';
}
else
{
$mes = $_SESSION['mes'];
$anio  = $_SESSION['anio'];
$sede = $_SESSION['sede'];
$idGrupoEmpleado = $_SESSION['grupoEmpleado'];
$fecha_limite = Horas::DiasMes($mes, $anio);
$GrupoEmpleado = funcionario::GetGrupoEmpleado($cn, $idGrupoEmpleado);
$DescSede = GetSede($cn, $sede);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Cuadro de turnos :. - Prodiagnostico S.A</title>
<!--<script type="text/javascript" src="http://gettopup.com/releases/latest/top_up-min.js"></script>-->
<script language="javascript" src="../../js/jquery-1.9.1.js"></script>
<script language="javascript">
var seconds = 2; // el tiempo en que se refresca
var divid = "Cuadro"; // el div que quieres actualizar!
var url = "QueryCuadro.php"; // el archivo que ira en el div
function refreshdiv(){
// The XMLHttpRequest object
var xmlHttp;
try{
	xmlHttp=new XMLHttpRequest(); // Firefox, Opera 8.0+, Safari
}
catch (e){
	try{
		xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
	}
	catch (e){
		try{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch (e){
			alert("Tu explorador no soporta AJAX.");
			return false;
		}
	}
}
// Timestamp for preventing IE caching the GET request
var timestamp = parseInt(new Date().getTime().toString().substring(0, 10));
var nocacheurl = url+"?t="+timestamp;
// The code...
xmlHttp.onreadystatechange=function(){
	if(xmlHttp.readyState== 4 && xmlHttp.readyState != null){
		document.getElementById(divid).innerHTML=xmlHttp.responseText;
		setTimeout('refreshdiv()',seconds*1000);
	}
}
xmlHttp.open("GET",nocacheurl,true);
xmlHttp.send(null);
}
// Empieza la funci�n de refrescar
window.onload = function(){ refreshdiv(); }
</script>
<link type="text/css" href="../../css/cuadroTurnos.css" rel="stylesheet"/>
	<!--<style type="text/css">
		body { font-family: Arial, Helvetica, sans-serif; font-size: small; }
		.table-fill { background: white; width: 100%; font-size: small; margin-top: 1%;}
		tr { border-top: 1px solid #C1C3D1; border-bottom-: 1px solid #C1C3D1; }
		tr:first-child { border-top:none; }
		tr:last-child {border-bottom:none; }
		tr:nth-child(odd)
		td { background:#EBEBEB; }
		td { background:#FFFFFF; }
		.text-center { text-align: center; background-color: #000066; }
	</style>-->
</head>
<body onload="refreshdiv()">
<table width="100%" id="table">
<tr>
	<td><strong>Cuadro de turnos para: </strong> <?php echo $GrupoEmpleado ?> <strong>en la sede: </strong> <?php echo $DescSede ?><strong> Desde: </strong> <?php echo $anio.'-'.$mes.'-'.'01' ?> <strong>Hasta: </strong> <?php echo $fecha_limite;?></td>
</tr>
</table><br>
<!-- Tabla donde se van a mostrar los funcionarios y los turnos -->
<div id="Cuadro" style="overflow: auto; height: 530px"><?php include("QueryCuadro.php")?></div>
<?php
}
?>
</table>
</div>
</body>
</html>
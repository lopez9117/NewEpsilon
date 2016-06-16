<?php
    //listar sedes del registro del activo
$lista = mysql_query("SELECT codigo,sede FROM activo_fijo WHERE codigo='$activo'", $cn);
$reg3= mysql_fetch_array($lista);
//listar propiedad del activo segun activo
$lista2 = mysql_query("SELECT codigo,propiedad FROM activo_fijo WHERE codigo='$activo'", $cn);
$reg6= mysql_fetch_array($lista2);
//listar adquicicion segun activo
$lista3 = mysql_query("SELECT codigo,adquicicion FROM activo_fijo WHERE codigo='$activo'", $cn);
$reg7= mysql_fetch_array($lista3);
//listar asegurado segun activo
$lista4 = mysql_query("SELECT codigo,idaseguradora FROM activo_fijo WHERE codigo='$activo'", $cn);
$reg8= mysql_fetch_array($lista4);
//listar aseguradora segun activo
$lista5 = mysql_query("SELECT codigo,idaseguradora FROM activo_fijo WHERE codigo='$activo'", $cn);
$reg9= mysql_fetch_array($lista5);
//listar desc hoja de vida segun activo
$lista7 = mysql_query("SELECT codigo,desc_hoja_vida FROM activo_fijo WHERE codigo='$activo'", $cn);
$reg11= mysql_fetch_array($lista7);
$lista8 = mysql_query("SELECT codigo,tipo_depreciacion FROM activo_fijo WHERE codigo='$activo'", $cn);
$reg12= mysql_fetch_array($lista8);
$listahojavida = mysql_query("SELECT * FROM desc_hoja_vida", $cn);
//listado responsable segun activo
	$listado2=mysql_query("SELECT codigo,responsable FROM activo_fijo  where codigo='$activo'",$cn);
	//listado de activo
$reg2= mysql_fetch_array($listado2);
	$listado=mysql_query("SELECT ac.codigo,ac.desc_activo,ac.cantidad,ac.marca,ac.modelo,ac.serie,ac.responsable,ac.centro_costos,ac.sede,ac.fecha_compra,ac.tiempo_depreciacion,ac.propiedad,ac.adquicicion,ac.url_adquicicion,ac.idaseguradora,ac.vencimiento_garantia,ac.url_hoja_vida,ac.contrato_mantenimiento,ac.contrato_calibracion,ac.observaciones,ac.desc_hoja_vida,f.nombres,f.apellidos FROM activo_fijo ac INNER JOIN funcionario f ON f.idfuncionario= ac.responsable WHERE codigo='$activo'",$cn);
$reg4= mysql_fetch_array($listado);
?>
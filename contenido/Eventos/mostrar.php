<?php
session_start();
	$CurrentUser = $_SESSION[currentuser] ;
	$mod = 2;
	include("../ValidarModulo.php");

//conexion a base de datos
require_once('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache">
<title>Cuadro de Turnos - Prodiagnostico S.A</title>
<link href="../css/cuadroTurnos.css" rel="stylesheet" type="text/css" />
<link href="../../css/default.css" rel="stylesheet" type="text/css">
<link type="text/css" href="../css/demo_table.css" rel="stylesheet" />
<link href="../css/default.css" rel="stylesheet" type="text/css">
<!-- END VALIDADOR -->
<style>
	datagrid table { border-collapse: collapse; text-align: left; width: 100%; } .datagrid {font: normal 18px/80% Arial, Helvetica, sans-serif; background: #fff;: hidden; border: 0px solid #006699; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; }.datagrid table td, .datagrid table th { padding: 3px 10px; }.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #006699), color-stop(1, #00557F) );background:-moz-linear-gradient( center top, #006699 5%, #00557F 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#006699', endColorstr='#00557F');background-color:#006699; color:#ffffff; font-size: 15px; font-weight: bold; border-left: 1px solid #0070A8; } .datagrid table thead th:first-child { border: none; }.datagrid table tbody td { color: #00496B; border-left: 1px solid #E1EEF4;font-size: 12px;font-weight: normal; }.datagrid table tbody .alt td { background: #E1EEF4; color: #00496B; }.datagrid table tbody td:first-child { border-left: none; }.datagrid table tbody tr:last-child td { border-bottom: none; }.datagrid table tfoot td div { border-top: 1px solid #006699;background: #E1EEF4;} .datagrid table tfoot td { padding: 0; font-size: 12px } .datagrid table tfoot td div{ padding: 2px; }.datagrid table tfoot td ul { margin: 0; padding:0; list-style: none; text-align: right; }.datagrid table tfoot  li { display: inline; }.datagrid table tfoot li a { text-decoration: none; display: inline-block;  padding: 2px 8px; margin: 1px;color: #FFFFFF;border: 1px solid #006699;-webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #006699), color-stop(1, #00557F) );background:-moz-linear-gradient( center top, #006699 5%, #00557F 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#006699', endColorstr='#00557F');background-color:#006699; }.datagrid table tfoot ul.active, .datagrid table tfoot ul a:hover { text-decoration: none;border-color: #006699; color: #FFFFFF; background: none; background-color:#00557F;}div.dhtmlx_window_active, div.dhx_modal_cover_dv { position: static; }
	h3{
  
  font-family: fantasy;
}





</style>
</head>

<body>
<div id="nav">
<div class="show">
<table width="100%" border="0">
<tr><td align="center" valign="middle">
	
	<div class="marco">
	<div class="ruta">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="menu.php">MEN&Uacute; EVENTOS</a></span> &gt; Eventos Adversos</span>
	</div>








        
         <BR>
        <BR>
        
<BR>
        
        <?php

            $query = 'SELECT l.idevento_adverso,l.n_caidas,l.n_caidas_adverso,l.n_caidas_incidente,l.fecha_reporte,l.mes_reporte,l.fecha_ocurrencia,l.documento,l.nombre,l.eps_del_paciente,l.descrip_caso,l.tipo_evento,l.resp_personal,l.accion_realizada,l.plan_mejora,l.fecha_compromiso,l.responsable_accion,l.implicados,l.seguimiento,l.reincidencia,l.analisis_causal,l.accion_insegura,l.observaciones,l.fecha_seguimiento,l.costo_adicional,m.descrip_lugar_ocurrencia,n.descrip_nombre_evento,p.descrip_servicio,a.descrip_clasificacion_inc,y.descrip_clasificacon_fin,o.descrip_estado FROM 
                evento_adverso l
                INNER JOIN evento_lugar_ocurrencia m ON l.id_lugar_ocurrencia=m.id_lugar_ocurrencia
                INNER JOIN evento_nombre n ON l.id_nombre_evento=n.id_evento_nombre
                INNER JOIN evento_servicio p ON l.id_servicio=p.id_servicio
                INNER JOIN evento_clasificacion_inc a ON l.id_clasificacion_inc=a.id_clasificacion_inc
                INNER JOIN evento_clasificacion_fin y ON l.id_clasificacion_fin=y.id_clasificacion_fin
                INNER JOIN evento_estado o ON l.id_estado=o.id_estado';


            $result = mysql_query($query) or die ('consulta fallida:' . mysql_error());
               
            echo "<div class='datagrid'> <table border='2' width='100%' height='50%'>";
            
           
            echo "<thead><tr><th bgcolor='#079beb' width='50%'><font size='2' font color=''ffffff'>NUMERO DE EVENTO</font></th>";
            echo "<th bgcolor='#079beb' width='50%'><font size='2' font color=''ffffff'>NUMERO TOTAL DE CAIDAS PRESENTADAS</font></th>";
            echo "<th bgcolor='#079beb' width='5%'><font size='2' font color=''ffffff'>NUMERO TOTAL DE CAIDAS EVENTO ADVERSO</font></th>";
            echo "<th bgcolor='#079beb' width='5%'><font size='2' font color=''ffffff'>NUMERO TOTAL DE CAIDAS INCIDENTE</font></th>";
            echo "<th bgcolor='#079beb' width='10%'><font size='2' font color=''ffffff'>FECHA DEL REPORTE</font></th>";
            echo "<th bgcolor='#079beb' width='10%'><font size='2' font color=''ffffff'>MES REPORTE</font></th>";
            echo "<th bgcolor='#079beb' width='20%'><font size='2' font color=''ffffff'>FECHA OCURRENCIA</font></th>";
            echo "<th bgcolor='#079beb' width='%2'><font size='2' font color=''ffffff'>DOCUMENTO </font></th>";
            echo "<th bgcolor='#079beb' width='%2'><font size='2' font color=''ffffff'>NOMBRE</font></th>";
            echo "<th bgcolor='#079beb' width='%2'><font size='2' font color=''ffffff'>EPS DEL PACIENTE</font></th>";
            echo "<th bgcolor='#079beb' width='15%'><font size='2' font color=''ffffff'>DESCRIPCION DEL CASO</font></th>";
            echo "<th bgcolor='#079beb' width='10%'><font size='2' font color=''ffffff'>TIPO DE EVENTO </font></th>";
            echo "<th bgcolor='#079beb' width='10%'><font size='2' font color=''ffffff'>RESPUESTA  DADA POR EL PERSONAL IMPLICADO</font></th>";
            echo "<th bgcolor='#079beb' width='20%'><font size='2' font color=''ffffff'>ACCION REALIZADA INMEDIATA (CORRECCION)</font></th>";
            echo "<th bgcolor='#079beb' width='%2'><font size='2' font color=''ffffff'> PLAN DE MEJORAMIENTO </font></th>";
            echo "<th bgcolor='#079beb' width='%2'><font size='2' font color=''ffffff'>FECHA DE COMPROMISO DE LA ACCION</font></th>";
            echo "<th bgcolor='#079beb' width='%2'><font size='2' font color=''ffffff'>RESPONSABLE DE EJECUTAR ACCION TOMADA</font></th>";
            echo "<th bgcolor='#079beb' width='15%'><font size='2' font color=''ffffff'>IMPLICADOS</font></th>";
            echo "<th bgcolor='#079beb' width='10%'><font size='2' font color=''ffffff'>SEGUIMIENTO AL CUMPLIMIENTO</font></th>";
            echo "<th bgcolor='#079beb' width='10%'><font size='2' font color=''ffffff'>REINCIDENCIA</font></th>";
            echo "<th bgcolor='#079beb' width='20%'><font size='2' font color=''ffffff'>ANALISIS CAUSAL O FACTORES CONTRIBUYENTES</font></th>";
            echo "<th bgcolor='#079beb' width='%2'><font size='2' font color=''ffffff'>ACCION INSEGURA</font></th>";
            echo "<th bgcolor='#079beb' width='%2'><font size='2' font color=''ffffff'>OBSERVACIONES /CONCLUSIONES</font></th>";
            echo "<th bgcolor='#079beb' width='%2'><font size='2' font color=''ffffff'>FECHA DE SEGUIMIENTO</font></th>";
            echo "<th bgcolor='#079beb' width='15%'><font size='2' font color=''ffffff'>COSTO ADICIONAL</font></th>";
            echo "<th bgcolor='#079beb' width='10%'><font size='2' font color=''ffffff'>LUGAR DE OCURRENCIA</font></th>";
            echo "<th bgcolor='#079beb' width='10%'><font size='2' font c>NOMBRE DE EVENTO</font></th>";
            echo "<th bgcolor='#079beb' width='20%'><font size='2' font color=''ffffff'>SERVICIO</font></th>";
            echo "<th bgcolor='#079beb' width='%2'><font size='2' font color=''ffffff'>CLASIFICACION INICIAL </font></th>";
            echo "<th bgcolor='#079beb' width='20%'><font size='2' font color=''ffffff'>CLASIFICACION FINAL</font></th>";
            echo "<th bgcolor='#079beb' width='%2'><font size='2' font color=''ffffff'>ESTADO</font></th>";
            echo "<th bgcolor='#079beb' width='10%'><font size='2' font color=''ffffff'>Editar</font></th></thead>";
           


            while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
            {
                echo "\t<tr>\n";
                foreach ($line as $col_value)
                {
                    echo "\t\t<td>$col_value</td>\n";
                }
                echo "<td><a href='editar.php?id=" . $line['idevento_adverso'] . "'>Editar</a></td>\n";
                
                echo "\t</tr>\n";
            }
             
            echo "</table></div>  \n";
               
            mysql_free_result($result);

           


        ?>
        
<?php

//conexion a base de datos
include('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
 $id =  $_GET['id'];
$query = mysql_query("SELECT *  FROM evento_adverso WHERE idevento_adverso ='$id'");

 $persona = mysql_fetch_array($query, MYSQL_ASSOC);  
// Consultar Todas las Personas registradas
    
//var_dump($persona);

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
        
<BR>
 <BR>
        
<BR>

<h1>Editar usuario</h1>
   
    <form action="modificar.php" method="POST">
<div class='datagrid'> 

         <TABLE BORDER="1"> 
         
<thead>
<TR> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>NUMERO TOTAL DE CAIDAS PRESENTADAS</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>NUMERO TOTAL DE CAIDAS EVENTO ADVERSO:</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>NUMERO TOTAL DE CAIDAS INCIDENTE</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>FECHA DEL REPORTE:</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>MES REPORTE:</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>FECHA OCURRENCIA:</TH>
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>DOCUMENTO:</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>NOMBRE:</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>EPS DEL PACIENTE:</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>DESCRIPCION DEL CASO:</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>TIPO DE EVENTO:</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>RESPUESTA  DADA POR EL PERSONAL IMPLICADO:</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>ACCION REALIZADA INMEDIATA (CORRECCION):</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'> PLAN DE MEJORAMIENTO:</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>FECHA DE COMPROMISO DE LA ACCION:</TH>
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>RESPONSABLE DE EJECUTAR ACCION TOMADA:</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>IMPLICADOS:</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>SEGUIMIENTO AL CUMPLIMIENTO:</TH>
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>REINCIDENCIA:</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>ANALISIS CAUSAL O FACTORES CONTRIBUYENTES:</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>ACCION INSEGURA:</TH> 
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>OBSERVACIONES /CONCLUSIONES:</TH>  
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>FECHA DE SEGUIMIENTO:</TH>
   <TH bgcolor='#079beb' width='2%'><font size='2' font color='ffffff'>COSTO ADICIONAL:</TH>
</TR></thead> 
<TR> 
   <TD><textarea name="n_caidas" ><?php echo $persona['n_caidas']; ?> </textarea></TD> 
   <TD><textarea name="n_caidas_adverso" ><?php echo $persona['n_caidas_adverso']; ?></textarea></TD> 
   <TD><textarea name="n_caidas_incidente" ><?php echo $persona['n_caidas_incidente']; ?></textarea></TD>
   <TD><textarea name="fecha_reporte" ><?php echo $persona['fecha_reporte']; ?></textarea></TD> 
   <TD><textarea name="mes_reporte" ><?php echo $persona['mes_reporte']; ?> </textarea></TD> 
   <TD><textarea name="fecha_ocurrencia" ><?php echo $persona['fecha_ocurrencia']; ?> </textarea></TD> 
   <TD><textarea name="documento"><?php echo $persona['documento']; ?> </textarea></TD> 
   <TD><textarea name="nombre"><?php echo $persona['nombre']; ?></textarea></TD>
   <TD><textarea  name="eps_del_paciente" ><?php echo $persona['eps_del_paciente']; ?></textarea></TD> 
   <TD><textarea name="descrip_caso" ><?php echo $persona['descrip_caso']; ?>  </textarea></TD> 
   <TD><textarea name="tipo_evento"><?php echo $persona['tipo_evento']; ?> </textarea></TD>
   <TD><textarea name="resp_personal"> <?php echo $persona['resp_personal']; ?></textarea></TD> 
   <TD><textarea name="accion_realizada"><?php echo $persona['accion_realizada']; ?></textarea></TD> 
   <TD><textarea name="plan_mejora" ><?php echo $persona['plan_mejora']; ?> </textarea></TD>
   <TD><textarea name="fecha_compromiso"><?php echo $persona['fecha_compromiso']; ?></textarea> </TD> 
   <TD><textarea name="responsable_accion" ><?php echo $persona['responsable_accion']; ?></textarea> </TD> 
   <TD><textarea name="implicados"> <?php echo $persona['implicados']; ?></textarea> </TD>
   <TD><textarea name="seguimiento"> <?php echo $persona['seguimiento']; ?> </textarea></TD> 
   <TD><textarea name="reincidencia" ><?php echo $persona['reincidencia']; ?> </textarea></TD> 
   <TD><textarea name="analisis_causal"> <?php echo $persona['analisis_causal']; ?> </textarea></TD>
   <TD><textarea name="accion_insegura" ><?php echo $persona['accion_insegura']; ?></textarea> </TD> 
   <TD><textarea ea" name="observaciones"> <?php echo $persona['observaciones']; ?></textarea> </TD> 
   <TD><textarea name="fecha_seguimiento"> <?php echo $persona['fecha_seguimiento']; ?></textarea></TD>
   <TD><textarea name="costo_adicional"> <?php echo $persona['costo_adicional']; ?></textarea></TD>
   <input type="hidden" name="id" value=<?php echo $persona['idevento_adverso']; ?>><br>
</TR> 
</table>
<br>
        <input type="submit" value="Editar Persona">
        <form action="mostrar.php" method="POST">
         <input type="submit" value="atras">

           
         
<?php


?>
  
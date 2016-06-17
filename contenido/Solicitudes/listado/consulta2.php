<?php
session_start();
require_once('../../../dbconexion/conexion.php');
include("../../select/selectsListado.php");
//funcion para abrir conexion
$cn = Conectarse();
$id=$_GET[id];
$_SESSION[area] = $area;
$listado=mysql_query("SELECT so.fechahora_visita,so.horavisita, so.asunto, so.idsolicitud, so.desc_requerimiento, so.fechahora_solicitud, so.horasolicitud, so.idsatisfaccion,
s.descsede, e.descestado_solicitud, f.nombres, f.apellidos,a.desc_area, et.descestado_solicitud, p.desc_prioridad FROM solicitud so
INNER JOIN estado_solicitud et ON et.idestado_solicitud= so.idestado_solicitud
INNER JOIN area a ON a.idarea= so.idarea
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN estado_solicitud e ON e.idestado_solicitud = so.idestado_solicitud
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN tipo_prioridad p ON p.idprioridad= so.idprioridad WHERE idsolicitud='$id'",$cn);
$listapresupuesto=mysql_query("SELECT desc_presupuesto,so.id_presupuesto FROM presupuestado pre
INNER JOIN solicitud so ON pre.id_presupuesto=so.id_presupuesto where so.idsolicitud='$id'",$cn);
$regpresupuesto= mysql_fetch_array($listapresupuesto);
$reg= mysql_fetch_array($listado);
$list= mysql_query("SELECT so.idsolicitud, d.nombres, d.apellidos FROM solicitud so
INNER JOIN funcionario d ON d.idfuncionario= so.idfuncionarioresponde WHERE idsolicitud='$id'",$cn);
$reg2=mysql_fetch_array($list); ?>
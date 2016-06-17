<?php
$listado=mysql_query("SELECT so.fechahora_visita,so.horavisita, so.asunto, so.idsolicitud, so.desc_requerimiento,so.idestado_solicitud, so.fechahora_solicitud, so.horasolicitud, so.idsatisfaccion,
s.descsede, f.nombres, f.apellidos,a.desc_area, et.descestado_solicitud, so.id_referencia, tp.desc_prioridad FROM solicitud so
INNER JOIN estado_solicitud et ON et.idestado_solicitud= so.idestado_solicitud
INNER JOIN area a ON a.idarea= so.idarea
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN tipo_prioridad tp ON tp.idprioridad=so.idprioridad 
WHERE idsolicitud='$id'",$cn);
$reg= mysql_fetch_array($listado);
$list= mysql_query("SELECT so.idsolicitud, d.nombres, d.apellidos FROM solicitud so
INNER JOIN funcionario d ON d.idfuncionario= so.idfuncionarioresponde WHERE idsolicitud='$id'",$cn);
$reg2=mysql_fetch_array($list);
$sqlSolicitud = mysql_query("SELECT so.idsolicitud, so.desc_requerimiento,so.fechahora_solicitud,so.horasolicitud,so.fechahora_visita, so.horavisita,
s.descsede, e.descestado_solicitud, f.nombres, f.apellidos, sa.desc_satisfaccion FROM solicitud so
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN estado_solicitud e ON e.idestado_solicitud = so.idestado_solicitud
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN satisfaccion sa ON sa.idsatisfaccion= so.idsatisfaccion
WHERE idsolicitud='$id'",$cn);
$regSolicitud = mysql_fetch_array($sqlSolicitud);
$observacion = mysql_query("SELECT o.observacion, o.fecha, o.hora, f.nombres, f.apellidos FROM observaciones o
INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario
WHERE idsolicitud='$id' AND observacion != ''", $cn);
$ListaPrioridad = mysql_query("SELECT * FROM tipo_prioridad ORDER BY desc_prioridad ASC", $cn);
$ListaSolicitud = mysql_query("SELECT * FROM tipo_solicitud where idarea=1", $cn);
$ListaEstado = mysql_query("SELECT * FROM estado_solicitud where idestado_solicitud between 2 and 4;", $cn);
$priorida=mysql_query("SELECT id_tiposolicitud,idprioridad
FROM solicitud WHERE idsolicitud='$id'",$cn);
$regprioridad= mysql_fetch_array($priorida);
?>
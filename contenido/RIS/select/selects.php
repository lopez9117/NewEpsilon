<?php
//lista de consultas para autollenado de campos seleccionables
$listaTipoDocumento = mysql_query("SELECT * FROM tipo_documento ORDER BY desc_tipodocumento ASC", $cn);
$listaSexo = mysql_query("SELECT * FROM r_sexo", $cn);
$listaEps = mysql_query("SELECT * FROM eps ORDER BY desc_eps ASC", $cn);
$ListaTipoAfilicacion = mysql_query("SELECT * FROM r_tipoafiliacion", $cn);
$listaDepartamentos = mysql_query("SELECT * FROM r_departamento ORDER BY nombre_dpto ASC", $cn);
$ListaMunicipio = mysql_query("SELECT * FROM r_municipio ORDER BY nombre_mun ASC", $cn);
$listaSede = mysql_query("SELECT * FROM sede WHERE idestado_actividad=1 ORDER BY descsede ASC", $cn);
$listaServicio = mysql_query("SELECT * FROM servicio WHERE idestado_actividad=1 AND alias!='' ORDER BY descservicio ASC", $cn);
$listaExtremidad = mysql_query("SELECT * FROM r_extremidad WHERE idestado='1'", $cn);
$listaPrioridad = mysql_query("SELECT * FROM r_prioridad", $cn);
$listaTecnica = mysql_query("SELECT * FROM r_tecnica WHERE idestado = '1'", $cn);
$ListaTipoPAciente = mysql_query("SELECT * FROM r_tipo_paciente", $cn);
$listarEstado = mysql_query("SELECT * FROM estado_actividad", $cn);
$listarMotivoCancel = mysql_query("SELECT * FROM r_motivocancel", $cn);
$ConsultadeERP = mysql_query("SELECT idsede,descsede FROM sede where erp='1' AND idestado_actividad=1 ORDER BY descsede ASC ", $cn);
?>
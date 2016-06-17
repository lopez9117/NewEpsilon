<?php
//conexion a la bd
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//instrucciones de consulta
//Listado de los tipos de documentos validos y registrados en el sistema
$listafuncionario =  mysql_query("SELECT * FROM funcionario ORDER BY nombres ASC",$cn);
//listado de los grupos de empleados
$listaGrupoEmpleado = mysql_query("SELECT * FROM grupo_empleado ORDER BY desc_grupoempleado ASC", $cn);
//Listado de sedes y unidades de servicion activas en el sistema
$listaSedeActiva = mysql_query("SELECT * FROM sede WHERE idestado_actividad=1 ORDER BY descsede ASC", $cn);
//listar tipo de adquicicion
$listadoadquicicion = mysql_query("SELECT * FROM tipo_adquicicion", $cn);
//listar propiedad del activo
$listadopropiedad = mysql_query("SELECT * FROM propiedad", $cn);
//listar depreciacion
$listadodepreciacion = mysql_query("SELECT * FROM depreciacion", $cn);
//listar depreciacion
$listadoasegurado = mysql_query("SELECT * FROM aseguradora", $cn);
//listar Garantia
$listadogarantia = mysql_query("SELECT * FROM garantia", $cn);
$listahojavida = mysql_query("SELECT * FROM desc_hoja_vida", $cn);
$listatipoactivo =  mysql_query("SELECT * FROM tipo_activo",$cn);
$listatiempodepreciacion =  mysql_query("SELECT * FROM tiempo_depreciacion",$cn);
$grupoempleado =  mysql_query("SELECT * FROM grupo_empleado",$cn);
//listado de los grupos de empleados
?>
<?php
//conexion a la bd
require_once('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//instrucciones de consulta
//Listado de los tipos de documentos validos y registrados en el sistema
$listaTipoDocumento =  mysql_query("SELECT * FROM tipo_documento ORDER BY desc_tipodocumento ASC",$cn);
//listado de los grupos de empleados
$listaGrupoEmpleado = mysql_query("SELECT * FROM grupo_empleado ORDER BY desc_grupoempleado ASC", $cn);
//Perfiles disponibles para los usuarios
$listarPerfiles = mysql_query("SELECT * FROM perfil ORDER BY descperfil ASC", $cn);
//Estado de actividad de los usuarios registrados
$listarEstado = mysql_query("SELECT * FROM estado_actividad", $cn);
//listado de universidades registradas
$listaUniversidad = mysql_query("SELECT * FROM universidad ORDER BY desc_universidad ASC", $cn);
//listado de las especialidades para asignar
$listaEspecialidad = mysql_query("SELECT * FROM especialidad ORDER BY desc_especialidad ASC", $cn);
//listado de especialistas activos en el sistema
$ListaEspecialista = mysql_query("SELECT * FROM funcionario WHERE idgrupo_empleado='4' AND idestado_actividad='1' ORDER BY nombres ASC", $cn);
//Listado de sedes y unidades de servicion activas en el sistema
$listaSedeActiva = mysql_query("SELECT * FROM sede WHERE idestado_actividad=1 ORDER BY descsede ASC", $cn);
//Listado de Servicios para el cuadro de turnos
$listaServicios = mysql_query("SELECT * FROM servicio WHERE idestado_actividad = 1 ORDER BY descservicio ASC", $cn);
//Listado de tipo de ausentismos
$listaAusentismo = mysql_query("SELECT * FROM tipo_ausentismo WHERE idtipo !=100 ORDER BY desc_ausentismo ASC", $cn);
//Obtener el tipo de cargo disponible para un funcionario
$listadoCargo = mysql_query("SELECT * FROM tipo_cargo", $cn);
//obtener listado de departamentos de colombia
$listadoDpto = mysql_query("SELECT * FROM r_departamento ORDER BY nombre_dpto ASC", $cn);
//obtener listado de municipios
$listadoMun = mysql_query("SELECT * FROM r_municipio ORDER BY nombre_mun ASC");
?>
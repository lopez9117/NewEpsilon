<?php
$sqlorden = mysql_query("SELECT * FROM _temp WHERE idorden='$idorden'", $cn);
$regorden = mysql_fetch_array($sqlorden);
//datos paciente
$idpac = $regorden['idpaciente'];
$sqlpaciente = mysql_query("SELECT * FROM r_paciente WHERE id_paciente = '$idpac'", $cn);
$respaciente = mysql_num_rows($sqlpaciente);
$regpaciente = mysql_fetch_array($sqlpaciente);
$telefonos = $regorden['telefono'];
$direccion = $regorden['direccion'];
$municipio = utf8_decode($regorden['municipio']);
$departamento = utf8_decode($regorden['departamento']);
$nom1 = $regorden['nombre1'];
$nom2 = $regorden['nombre2'];
$ape1 = $regorden['apellido1'];
$ape2 = $regorden['apellido2'];
$nac = $regorden['fchnacimiento'];
$sex = $regorden['sexo'];
$eps = $regorden['eps'];
//Datos Agendamiento
$idOrd = $regorden['idorden'];
$idmedreferencia = $regorden['idMedRef'];
$sedeOri = $regorden['id_sede'];
$descServ = $regorden['descservicio'];
$id_serv = $regorden['id_servicio'];
$codcups = $regorden['codservicio'];
$tecnica = $regorden['id_tecnica'];
$desc_tecnica = $regorden['tecnica'];
$ubicacion = $regorden['ubicacion'];
$tipoD = $regorden['tipo'];
$fecha_solicitud = $regorden['fch_solicitud'];
$fecha_cita = $regorden['fch_cita'];
$cie10 = $regorden['coddx'];
$diagnostico = $regorden['descripciondx'];
$sustentacion = $regorden['sustentacion'];
$prioridad = $regorden['clasificacion'];
$desc_tipo_pac = $regorden['tipo_paciente'];
if ($sex == "Femenino") {
    $id_sexo = 2;
} else {
    $id_sexo = 1;
}
if ($desc_tipo_pac == 'Hospitalizado') {
    $id_tipo_paciente = 1;
} else if ($desc_tipo_pac == 'Ambulatorio') {
    $id_tipo_paciente = 2;
} else if ($desc_tipo_pac == 'Urgencias') {
    $id_tipo_paciente = 3;
}
$extremidad = $regorden['extremidad'];
$adicional = $regorden['adicional'];
$portatil = $regorden['portatil'];
$anestesia = $regorden['anestesia'];
$desc_eps = $regorden['eps'];
$medico_solicitante = $regorden['NomMedRef'] . ' ' . $regorden['ApeMedRef'];
$especialidad = $regorden['especialidad'];
$sqlmunicipio = mysql_query("SELECT * FROM r_municipio WHERE nombre_mun LIKE '%$municipio%'", $cn);
$regmunipio = mysql_fetch_array($sqlmunicipio);
$id_municipio = $regmunipio['cod_mun'];
$id_departamento = $regmunipio['cod_dpto'];
if ($tipoD == "CC") {
    $tipoDoc = "1";
} elseif ($tipoD == "CE") {
    $tipoDoc = "2";
} elseif ($tipoD == "TI") {
    $tipoDoc = "3";
} elseif ($tipoD == "RC") {
    $tipoDoc = "4";
} else {
    $tipoDoc = "5";
}
$sqlTipo = mysql_query("SELECT idtipo_documento, desc_tipodocumento FROM tipo_documento WHERE idtipo_documento='$tipoDoc'", $cn);
$regTipo = mysql_fetch_array($sqlTipo);
$desc_tipo = $regTipo['desc_tipodocumento'];
$id_tipo_doc = $regTipo['idtipo_documento'];
if ($prioridad == "Urgente") {
    $priori = "1";
} else {
    $priori = "2";
}
$sqlPrioridad = mysql_query("SELECT id_prioridad, desc_prioridad FROM r_prioridad WHERE id_prioridad='$priori'", $cn);
$regPrioridad = mysql_fetch_array($sqlPrioridad);
$desc_prioridad = $regPrioridad['desc_prioridad'];
$id_prioridad = $regPrioridad['id_prioridad'];
$sqlEps = mysql_query("SELECT * FROM eps WHERE desc_eps like '%$eps%' AND idestado= '2';", $cn);
$reseps = mysql_num_rows($sqlEps);
if ($reseps >= 1) {
    $regEps = mysql_fetch_array($sqlEps);
    $desc_eps = $regEps['desc_eps'];
    $id_eps = $regEps['ideps'];
} else {
    $SqliEps = mysql_query("SELECT ideps FROM r_paciente WHERE id_paciente=$idpac");
    $RegSqli = mysql_fetch_array($SqliEps);
    $id_eps = $RegSqli['ideps'];
}
$conver = substr($fecha_solicitud, -0, 8);
$fch_sol = date("d/m/Y", strtotime($conver));
$lugar = 2;
$solo_hora = substr($fecha_solicitud, 8, 4);
$insertar = ":";
$hora_creada = $resultado = substr($solo_hora, 0, $lugar) . $insertar . substr($solo_hora, $lugar);

$conver2 = substr($fecha_cita, -0, 8);
$fch_cita = date("d/m/Y", strtotime($conver2));
$lugar2 = 2;
$solo_hora2 = substr($fecha_cita, 8, 4);
$insertar2 = ":";
$hora_cita = $resultado2 = substr($solo_hora2, 0, $lugar2) . $insertar2 . substr($solo_hora2, $lugar2);
$rest = substr($nac, -0, 8);
$f_nac = date("d/m/Y", strtotime($rest));
function edad($fecha_de_nacimiento)
{
    if (is_string($fecha_de_nacimiento)) {
        $fecha_de_nacimiento = strtotime($fecha_de_nacimiento);
    }
    $diferencia_de_fechas = time() - $fecha_de_nacimiento;
    return ($diferencia_de_fechas / (60 * 60 * 24 * 365));
}

$edad_posible = edad($rest);
?>
<?php
//archivo de conexion a la BD
try {

    require_once("../../../../dbconexion/conexion.php");
    $cn = conectarse();
    $ndocumento = $_POST['ndocumento'];
    $pnombre = strtoupper($pnombre = $_POST['pnombre']);
    $snombre = strtoupper($snombre = $_POST['snombre']);
    $papellido = strtoupper($papellido = $_POST['papellido']);
    $sapellido = strtoupper($sapellido = $_POST['sapellido']);
    $tel = $_POST['tel'];
    $movil = $_POST['movil'];
//obtener caracteres en blanco y vacios de las cadenas de texto
    $ndocumento = trim($ndocumento);
    $pnombre = trim($pnombre);
    $snombre = trim($snombre);
    $papellido = trim($papellido);
    $sapellido = trim($sapellido);
    $tel = trim($tel);
//variables del sistema
    $fecha = date("Y-m-d");
    $hora = date("G:i:s");
//declaracion de variables con POST   $eps = $_POST['ideps']  
    $tipo_documento = $_POST['tipo_documento'];
    $fechanacimiento = convertfecha($_POST['fecha_nacimiento']);
    if ($fechanacimiento == "") {
        $fechanacimiento = '0000-00-00';
    } else {
        $fechanacimiento = $fechanacimiento;
    }
    $genero = $_POST['genero'];
    if ($genero == 1) {
        $sexo = 'M';
    } else {
        $sexo = 'F';
    }
    $eps = $_POST['ideps'];
    if ($eps == '') {
        $eps = 0;
    }
    $tipo_afiliacion = $_POST['tipo_afiliacion'];
    $nivel_afiliacion = $_POST['nivel_afiliacion'];
    $dep = $_POST['dep'];
    $mun = $_POST['mun'];
    $barrio = $_POST['barrio'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $norden = $_POST['norden'];
    $sede = $_POST['sede'];
    $servicio = $_POST['servicio'];
    $estudio = $_POST['estudio'];
    $tecnica = $_POST['tecnica'];
    $extremidad = $_POST['lado'];
    $desc_extremidad = $_POST['Extremidad'];
    $tipopaciente = $_POST['tipopaciente'];
    $prioridad = $_POST['prioridad'];
    $ubicacion = strtoupper($ubicacion = $_POST['ubicacion']);
    $medsolicita = $_POST['medsolicita'];
    $portatil = $_POST['portatil'];
    $peso = $_POST['pesop'];
    $erp = $_POST['erp'];
    $realizacion = $_POST['realizacion'];
    $anestesia = $_POST['anestesia'];
    $sedacion = $_POST['sedacion'];
    $fechasolicitud = $_POST['fechasolicitud'];
    $fechasolicitud = convertfecha($fechasolicitud);
    $horasolicitud = $_POST['horasolicitud'];
    $fechacita = $_POST['fechacita'];
    $fechacita = convertfecha($fechacita);
    $horacita = $_POST['horacita'];
    $fechapreparacion = $_POST['fechapreparacion'];
    $fechapreparacion = convertfecha($fechapreparacion);
    $horapreparacion = $_POST['horapreparacion'];
    $observaciones = $_POST['observaciones'];
//obtener cantidad de caracteres enviados en las observaciones para evitar registros vacios
    $cadenaTexto = $observaciones;
    $cadenaTexto = str_replace(array("\\", "°", "*", "_", "=", "¨", "º", "-", "~", "#", "@", "|", "!", "\"", "·", "$", "%", "&", "/", "(", ")", "?", "'", "¡", "¿", "[", "^", "`", "]", "+", "}", "{", "¨", "´", ">", "<", ";", ",", ":", ".", " "), '', $cadenaTexto);
    $cadena = strlen($cadenaTexto);
    $usuario = $_POST['usuario'];
    $telefonos = $tel . '/' . $movil;
    $adicional = strtoupper($adicional = $_POST['adicional']);
    $unidadedad = $_POST['unidadedad'];
    $edad = $_POST['edad'];
    if ($unidadedad == 'AÑO') {
        $ed = 'Y';
    } else if ($unidadedad == 'MES') {
        $ed = 'M';
    } else if ($unidadedad == 'DIA') {
        $ed = 'D';
    }
    $edadpaciente = $edad . ' ' . $unidadedad;
    $edadpac = '0' . $edad . '' . $ed;
    $adjunto = $_POST['archivos'];
    $ruta = 'uploads';
    $tipo_comentario = '1';
    $copago = $_POST['copago'];
    $comparativa = $_POST['comparativa'];
    $proyeccionesrx = $_POST['proyeccionesrx'];
    $reconstruccion = $_POST['reconstruccion'];
    $guia = $_POST['guiaselected'];
    if ($guia == "") {
        $guia = 0;
    }
    if ($reconstruccion == "") {
        $reconstruccion = 0;
    }
    if ($portatil == "") {
        $portatil = 0;
    }
    if ($anestesia == "") {
        $anestesia = 0;
    }
    if ($comparativa == "") {
        $comparativa = 0;
    }
    if ($anestesia == "") {
        $anestesia = 0;
    }
    if ($sedacion == "") {
        $sedacion = 0;
    }

    if ($servicio == 1) {
        $reconstruccion = 0;
    } elseif ($servicio == 2) {
        $portatil = 0;
        $comparativa = 0;
        $proyeccionesrx = 0;
    } elseif ($servicio == 3 || $servicio == 51) {
        $reconstruccion = 0;
        $comparativa = 0;
        $proyeccionesrx = 0;
    } else {
        $reconstruccion = 0;
        $comparativa = 0;
        $portatil = 0;
        $proyeccionesrx = 0;
    }
    if ($sede == 5 || $sede == 35) {
        $portatil = 0;
    }

    //Consultar cantidad de registros en tabla temporal para cuando se ingresan varios estudios al mismo tiempo
    $consulta_temp = mysql_query("SELECT * FROM r_informe_header_temp WHERE id_paciente='$ndocumento'", $cn);
    $contador_tem = mysql_num_rows($consulta_temp);
//validar si el usuario esta registrado
    $sql = mysql_query("SELECT * FROM r_paciente WHERE id_paciente = '$ndocumento'", $cn) or throw_ex(mysql_error());
    $reg = mysql_num_rows($sql);
    $sql2 = mysql_query("SELECT alias FROM servicio WHERE idservicio = '$servicio'", $cn) or throw_ex(mysql_error());
    $reg2 = mysql_fetch_array($sql2);
    $modalidad = $reg2['alias'];
    $sql3 = mysql_query("SELECT nom_estudio, idestudio  FROM r_estudio WHERE idestudio = '$estudio'", $cn) or throw_ex(mysql_error());
    $reg3 = mysql_fetch_array($sql3);
    $desc_estudio = $reg3['nom_estudio'];
    $sql4 = mysql_query("SELECT stationname,device_aet  FROM r_devices_worklist WHERE idsede = '$realizacion' AND idservicio= '$servicio'", $cn) or throw_ex(mysql_error());
    $reg4 = mysql_fetch_array($sql4);
    $devices_aet = $reg4['stationname'];
//insercion todos los datos de la agenda
    if ($reg >= 1) {
        //Actualizar datos del paciente
        mysql_query("UPDATE r_paciente SET  id_sexo='$genero',id_tipoafiliacion='$tipo_afiliacion',cod_mun='$mun',cod_dpto='$dep',idtipo_documento='$tipo_documento',fecha_nacimiento='$fechanacimiento',barrio='$barrio',direccion='$direccion',email='$email',ideps='$eps',tel='$telefonos',nivel='$nivel_afiliacion',edad='$edadpaciente',peso='$peso' WHERE id_paciente='$ndocumento'", $cn) or throw_ex(mysql_error());
    } else {
//registrar los datos del paciente
        mysql_query("INSERT INTO r_paciente (id_paciente, id_sexo, id_tipoafiliacion, cod_mun, cod_dpto, idtipo_documento, nom1, nom2, ape1, ape2, fecha_nacimiento, barrio, direccion, email, ideps, tel, nivel, edad, peso)
                                VALUES('$ndocumento','$genero','$tipo_afiliacion','$mun','$dep','$tipo_documento','$pnombre','$snombre','$papellido','$sapellido','$fechanacimiento','$barrio','$direccion','$email','$eps','$telefonos',$nivel_afiliacion,'$edadpaciente','$peso')", $cn) or throw_ex(mysql_error());
    }
    // Consulta para sacar maximo id del informe
//obtener un identificador para el informe
    $sqlInfo = mysql_query("SELECT MAX(id_informe+1) AS idInforme FROM r_informe_header", $cn) or throw_ex(mysql_error());
    $regInfo = mysql_fetch_array($sqlInfo);
//identificador para el informe
    $idInforme = $regInfo['idInforme'];
    if ($idInforme == "" || $idInforme == 0) {
        $idInforme = 1;
    }
//insertar datos del acompañante.
    $acompañante = count($_POST['Documento']);
//este for recorre el arreglo
    for ($i = 0; $i < $acompañante; $i++) {
        //con el indice $i, poemos obtener la propiedad que desemos de cada archivo
        //para trabajar con este
        $Documento = $_POST['Documento'][$i];
        $Nombres = $_POST['Nombres'][$i];
        $Apellidos = $_POST['Apellidos'][$i];
        $Telefono = $_POST['Telefono'][$i];
        $Parentezco = $_POST['Parentezco'][$i];
        //Accion para insertar el acompañante
        if ($Documento != "") {
            mysql_query("INSERT INTO r_acudiente VALUES('$Documento','$Nombres $Apellidos','$Telefono','$Parentezco','$ndocumento')", $cn) or throw_ex(mysql_error());
        }
    }
//registrar el informe
    mysql_query("INSERT INTO r_informe_header (id_informe, id_paciente, idestudio, id_prioridad, id_estadoinforme, id_extremidad, idsede, idservicio, ubicacion, portatil, adjunto, id_tecnica, idtipo_paciente, medico_solicitante, hora_solicitud, fecha_solicitud,fecha_preparacion,orden, desc_extremidad,anestesia,sedacion,peso_paciente,erp,lugar_realizacion) VALUES ('$idInforme','$ndocumento','$estudio','$prioridad','1','$extremidad','$sede','$servicio','$ubicacion','$portatil','$url','$tecnica','$tipopaciente','$medsolicita','$horasolicitud','$fechasolicitud','$fechapreparacion $horapreparacion','$norden', '$desc_extremidad','$anestesia','$sedacion','$peso','$erp','$realizacion')", $cn) or throw_ex(mysql_error());
//insert r_informe_header_facturacion
    mysql_query("INSERT INTO r_informe_facturacion(id_informe,copago,guia,comparativa,proyeccion,reconstruccion) VALUES
                                                  ('$idInforme','$copago','$guia','$comparativa','$proyeccionesrx','$reconstruccion')", $cn) or throw_ex(mysql_error());
    //validar adicional para registrar r_detalle_informe
    if ($adicional != "") {
        mysql_query("INSERT INTO r_detalle_informe (id_informe, detalle_informe, adicional, id_tipo_resultado) VALUES('$idInforme', '', '$adicional','0')", $cn) or throw_ex(mysql_error());
    }
//registrar datos para el agendamiento
    mysql_query("INSERT INTO r_log_informe VALUES('$idInforme','$usuario','1','$fechacita','$horacita')", $cn) or throw_ex(mysql_error());
//Actualizar asiganado cuando se agendo la orden enviada del GHIPS
    mysql_query("UPDATE _temp SET asignada='1' where idorden='$norden' ", $cn) or throw_ex(mysql_error());
    //validar insert para crear el worklist
    if ($servicio == "10") {
        if ($realizacion == "1" || $realizacion == "3" || $realizacion == "38" || $realizacion == "37") {
            mysql_query("INSERT INTO r_worklist_temp VALUES ('$ndocumento','$sexo','$edadpac','$pnombre $snombre','$papellido', '$sapellido', '$idInforme', '$fechanacimiento','$modalidad', '$estudio', '$desc_estudio', '$fechacita', '$horacita', '$devices_aet', '0', '$realizacion', '$medsolicita', '$observaciones')", $cn);
        }
    //} else if ($servicio == "2") {
      //  if ($realizacion == "5") {
        //    mysql_query("INSERT INTO r_worklist_temp VALUES ('$ndocumento','$sexo','$edadpac','$pnombre $snombre','$papellido', '$sapellido', '$idInforme', '$fechanacimiento','$modalidad', '$estudio', '$desc_estudio', '$fechacita', '$horacita', '$devices_aet', '0', '$realizacion', '$medsolicita', '$observaciones')", $cn);
        //}
    } else if ($servicio == "1") {
        if ($realizacion == "3" || $realizacion=="32" || $realizacion=="5" || $realizacion=="9") {
            mysql_query("INSERT INTO r_worklist_temp VALUES ('$ndocumento','$sexo','$edadpac','$pnombre $snombre','$papellido', '$sapellido', '$idInforme', '$fechanacimiento','$modalidad', '$estudio', '$desc_estudio', '$fechacita', '$horacita', '$devices_aet', '0', '$realizacion', '$medsolicita', '$observaciones')", $cn);
        }
    }
    //Copiar archivo adjunto
//de se asi, para procesar los archivos subidos al servidor solo debemos recorrerlo
//obtenemos la cantidad de elementos que tiene el arreglo archivos
    $tot = count($_FILES["archivos"]["name"]);
//este for recorre el arreglo
    for ($i = 0; $i < $tot; $i++) {
        //con el indice $i, poemos obtener la propiedad que desemos de cada archivo
        //para trabajar con este
        $tipoFile = $_FILES["archivos"]["type"][$i];
        list($nomadjun, $tipoadjun) = explode("/", $tipoFile);
        $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
        $name = $idInforme . $i;
        //copiar los archivos adjuntos en la carpeta uploads
        copy($tmp_name, $ruta . '/' . $name . '.' . $tipoadjun);
        $url = $ruta . '/' . $name . '.' . $tipoadjun;
        //insertar en la tabla adjuntos para luego realizar consulta del total de archivos adjuntos
        if ($tipoFile != "") {
            mysql_query("INSERT INTO r_adjuntos (adjunto, id_informe) VALUES ('$url','$idInforme')", $cn) or throw_ex(mysql_error());
        }
    }
//verificar si hay observaciones para registrar
    if ($cadena != "0") {
        //registrar observaciones
        mysql_query("INSERT INTO r_observacion_informe VALUES('$idInforme','$usuario','$observaciones','$fecha','$hora','$tipo_comentario')", $cn) or throw_ex(mysql_error());
    }
    // for para insertar varios estudios solo si contiene
    if ($contador_tem >= 1) {
        while ($reg_temp = mysql_fetch_array($consulta_temp)) {
            $sede_temp = $reg_temp['idsede'];
            $erp_temp = $reg_temp['erp'];
            $realizacion_temp = $reg_temp['lugar_realizacion'];
            $idestudio_temp = $reg_temp['idestudio'];
            $id_estremidad_temp = $reg_temp['id_extremidad'];
            $idservicio_temp = $reg_temp['idservicio'];
            $portatil_temp = $reg_temp['portatil'];
            $idtecnica_temp = $reg_temp['id_tecnica'];
            $horasolicitud_temp = $reg_temp['hora_solicitud'];
            $fechasolicitud_temp = $reg_temp['fecha_solicitud'];
            $horacita_temp = $reg_temp['hora_cita'];
            $fechacita_temp = $reg_temp['fecha_cita'];
            $fechapreparacion_temp = $reg_temp['fecha_preparacion'];
            $orden_temp = $reg_temp['orden'];
            $desc_extremidad_temp = $reg_temp['desc_extremidad'];
            $anestesia_temp = $reg_temp['anestesia'];
            $sedacion_temp = $reg_temp['sedacion'];
            $adicional_temp = $reg_temp['adicional'];
            $copago_temp = $reg_temp['copago'];
            $comparativa_temp = $reg_temp['comparativa'];
            $proyeccionesrx_temp = $reg_temp['proyeccion'];
            $reconstruccion_temp = $reg_temp['reconstruccion'];
            $observaciones_temp = $reg_temp['observaciones'];
            $observaciones_temp = str_replace(array("\\", "°", "*", "_", "=", "¨", "º", "-", "~", "#", "@", "|", "!", "\"", "·", "$", "%", "&", "/", "(", ")", "?", "'", "¡", "¿", "[", "^", "`", "]", "+", "}", "{", "¨", "´", ">", "<", ";", ",", ":", ".", " "), '', $observaciones_temp);
            $observaciones_temp = strlen($observaciones_temp);
            $id_informe_temp = mysql_query("SELECT MAX(id_informe+1) AS idInforme FROM r_informe_header", $cn) or throw_ex(mysql_error());
            $var_id_temp = mysql_fetch_array($id_informe_temp);
            $idtemp = $var_id_temp['idInforme'];
            $guia_temp = $reg_temp['guia'];


            if ($idservicio_temp == 1) {
                $reconstruccion_temp = 0;
            } elseif ($idservicio_temp == 2) {
                $portatil_temp = 0;
                $comparativa_temp = 0;
                $proyeccionesrx_temp = 0;
            } elseif ($idservicio_temp == 3 || $idservicio_temp == 51) {
                $reconstruccion_temp = 0;
                $comparativa_temp = 0;
                $proyeccionesrx_temp = 0;
            } else {
                $reconstruccion_temp = 0;
                $comparativa_temp = 0;
                $portatil_temp = 0;
                $proyeccionesrx_temp = 0;
            }
            if ($sede_temp == 5 || $sede_temp == 35) {
                $portatil_temp = 0;
            }

            //insertar los estudios en la tabla principal de r_informe_header
            mysql_query("INSERT INTO r_informe_header (id_informe, id_paciente, idestudio, id_prioridad, id_estadoinforme, id_extremidad, idsede, idservicio, ubicacion, portatil, adjunto, id_tecnica, idtipo_paciente, medico_solicitante, hora_solicitud, fecha_solicitud,fecha_preparacion,orden, desc_extremidad,anestesia,sedacion,peso_paciente,erp,lugar_realizacion) VALUES ('$idtemp','$ndocumento','$idestudio_temp','$prioridad','1','$id_estremidad_temp','$sede_temp','$idservicio_temp','$ubicacion','$portatil_temp','$url','$idtecnica_temp','$tipopaciente','$medsolicita','$horasolicitud_temp','$fechasolicitud_temp','$fechapreparacion_temp','$orden_temp', '$desc_extremidad_temp','$anestesia_temp','$sedacion_temp','$peso','$erp_temp','$realizacion_temp')", $cn) or throw_ex(mysql_error());
            //insertar todos los estudios de facturacion cuanod contiene muchos
            mysql_query("INSERT INTO r_informe_facturacion(id_informe,copago,guia,comparativa,proyeccion,reconstruccion) VALUES ('$idtemp','$copago_temp','$guia_temp','$comparativa_temp','$proyeccionesrx_temp',$reconstruccion_temp)", $cn) or throw_ex(mysql_error());
            //validar adicional para registrar r_detalle_informe
            if ($adicional_temp != "") {
                mysql_query("INSERT INTO r_detalle_informe (id_informe, detalle_informe, adicional, id_tipo_resultado) VALUES('$idtemp', '', '$adicional_temp','0')", $cn) or throw_ex(mysql_error());
            }
            //registrar datos para el agendamiento
            mysql_query("INSERT INTO r_log_informe VALUES('$idtemp','$usuario','1','$fechacita_temp','$horacita_temp')", $cn) or throw_ex(mysql_error());
            //observaciones
            if ($observaciones_temp != "0") {
                //registrar observaciones
                mysql_query("INSERT INTO r_observacion_informe VALUES('$idtemp','$usuario','$observaciones_temp','$fecha','$hora','$tipo_comentario')", $cn) or throw_ex(mysql_error());
            }
            //Copiar archivo adjunto
            //de se asi, para procesar los archivos subidos al servidor solo debemos recorrerlo
            //obtenemos la cantidad de elementos que tiene el arreglo archivos
            //$tot = count($_FILES["archivos"]["name"]);
            //este for recorre el arreglo
            //for ($i = 0; $i < $tot; $i++) {
            //con el indice $i, poemos obtener la propiedad que desemos de cada archivo
            //para trabajar con este
            //  $tipoFile = $_FILES["archivos"]["type"][$i];
            //list($nomadjun, $tipoadjun) = explode("/", $tipoFile);
            //$tmp_name = $_FILES["archivos"]["tmp_name"][$i];
            //$name = $idInforme . $i;
            //copiar los archivos adjuntos en la carpeta uploads
            //copy($tmp_name, $ruta . '/' . $name . '.' . $tipoadjun);
            //$url = $ruta . '/' . $name . '.' . $tipoadjun;
            //insertar en la tabla adjuntos para luego trealizar consulta del total de archivos adjuntos
            //if ($tipoFile != "") {
            //  mysql_query("INSERT INTO r_adjuntos (adjunto, id_informe) VALUES ('$url','$idtemp')", $cn) or throw_ex(mysql_error());
            //}
            //}
            //Actualizar asiganado cuando se agendo la orden enviada del GHIPS
            //mysql_query("UPDATE _temp SET asignada='1' where idorden='$norden_temp' ", $cn) or throw_ex(mysql_error());
            //validar insert para crear el worklist
            if ($idservicio_temp == "10") {
                if ($realizacion_temp == "1" || $realizacion_temp == "3" || $realizacion_temp == "38" || $realizacion_temp == "37") {
                    mysql_query("INSERT INTO r_worklist_temp VALUES ('$ndocumento','$sexo','$edadpac','$pnombre $snombre','$papellido', '$sapellido', '$idtemp', '$fechanacimiento','$modalidad', '$idestudio_temp', '$desc_estudio', '$fechacita_temp', '$horacita_temp', '$devices_aet', '0', '$realizacion_temp', '$medsolicita', '$observaciones')", $cn);
                }
            //} else if ($idservicio_temp == "2") {
              //  if ($realizacion_temp == "5") {
                //    mysql_query("INSERT INTO r_worklist_temp VALUES ('$ndocumento','$sexo','$edadpac','$pnombre $snombre','$papellido', '$sapellido', '$idtemp', '$fechanacimiento','$modalidad', '$idestudio_temp', '$desc_estudio', '$fechacita_temp', '$horacita_temp', '$devices_aet', '0', '$realizacion_temp', '$medsolicita', '$observaciones')", $cn);
                //}
            } else if ($idservicio_temp == "1") {
                if ($realizacion_temp == "3" || $realizacion_temp=="32" || $realizacion_temp=="5" || $realizacion_temp=="9") {
                    mysql_query("INSERT INTO r_worklist_temp VALUES ('$ndocumento','$sexo','$edadpac','$pnombre $snombre','$papellido', '$sapellido', '$idtemp', '$fechanacimiento','$modalidad', '$idestudio_temp', '$desc_estudio', '$fechacita_temp', '$horacita_temp', '$devices_aet', '0', '$realizacion_temp', '$medsolicita', '$observaciones')", $cn);
                }
            }
        }
        mysql_query("DELETE FROM r_informe_header_temp WHERE id_paciente='$ndocumento'", $cn);
    }
    echo '<script language="javascript">
			        setTimeout(window.close, 5000);
            </script>';
} catch (Exeption $e) {
    echo 'Ocurrio un error agendando el paciente ' . $e;
}
// funcion paraconvertir las fechas
function convertfecha($fecha)
{
    list ($dia, $mes, $año) = explode('/', $fecha);
    $fechareturn = $año . '-' . $mes . '-' . $dia;
    return $fechareturn;

}

function throw_ex($er)
{
    echo 'Ocurrio un error ' . $er . '  <br/>';
//    throw new Exception($er);
}

mysql_close($cn);
?>
<title>.: Guardando Cambios :.</title>
<link href="../styles/VisualStyles.css" rel="stylesheet" type="text/css">
<body onBeforeUnload="return window.opener.mostrarAgenda();">
<table width="50%" border="0" align="center" style="margin-top:20%;">
    <tr>
        <td><img src="../../styles/images/MnyxU.gif" width="64" height="64"/>
        </td>
        <td>
            <strong><h3>Guardando los cambios, por favor espere...</h3></strong>
        </td>
    </tr>
</table>
</body>
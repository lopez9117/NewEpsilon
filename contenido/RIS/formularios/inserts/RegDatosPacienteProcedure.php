<?php
//archivo de conexion a la BD
try {
    require_once("../../../../dbconexion/conexionmysqli.php");
    $cn = Conectarse();
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
    $regimen =$_POST['regimen'];
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

    $fechadeseada = $_POST['fechadeseada'];
    $fechadeseada = convertfecha($fechadeseada);

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
    $acompañante = count($_POST['Documento']);
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
    } 
    if ($sede == 5 || $sede == 35) {
        $portatil = 0;
    }
    $procedureAgendamiento = mysqli_query($cn, "CALL AgregarAgenda('$ndocumento','$pnombre','$snombre','$papellido','$sapellido','$genero','$tipo_afiliacion','$mun','$dep','$tipo_documento','$fechanacimiento','$barrio','$direccion','$email','$eps','$telefonos','$nivel_afiliacion','$regimen','$edadpaciente','$peso','$estudio','$prioridad',1,'$extremidad','$sede','$servicio','$ubicacion','$portatil','$tecnica','$tipopaciente','$medsolicita','$horasolicitud','$fechasolicitud','$fechapreparacion $horapreparacion','$fechadeseada','$norden','$desc_extremidad',' ',' ','$anestesia','$sedacion','$peso','$erp',$realizacion,'$usuario','$fechacita','$horacita','$copago','0','0','0','0','$guia','0','$comparativa','$proyeccionesrx','0','0','$reconstruccion','$observaciones','$adicional')") or throw_ex(mysqli_error());
    //echo "CALL AgregarAgenda('$ndocumento','$pnombre','$snombre','$papellido','$sapellido','$genero','$tipo_afiliacion','$mun','$dep','$tipo_documento','$fechanacimiento','$barrio','$direccion','$email','$eps','$telefonos','$nivel_afiliacion','$edadpaciente','$peso','$estudio','$prioridad',1,'$extremidad','$sede','$servicio','$ubicacion','$portatil','$tecnica','$tipopaciente','$medsolicita','$horasolicitud','$fechasolicitud','$fechapreparacion $horapreparacion','$norden','$desc_extremidad',' ',' ','$anestesia','$sedacion','$peso','$erp',$realizacion,'$usuario','$fechacita','$horacita','$copago','0','0','0','0','$guia','0','$comparativa','$proyeccionesrx','0','0','$reconstruccion','$observaciones','$adicional')";
    $returnProcedure = mysqli_fetch_array($procedureAgendamiento);
    $respuesta = $returnProcedure['answer'];
    $idInforme = $returnProcedure['MAX_ID'];
    if (mysqli_more_results($cn))
        while (mysqli_next_result($cn)) ;
////insertar datos del acompañante.
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
            mysqli_query($cn,"INSERT INTO r_acudiente VALUES('$Documento','$Nombres $Apellidos','$Telefono','$Parentezco','$ndocumento')") or throw_ex(mysqli_error($cn));
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
            mysqli_query($cn, "INSERT INTO r_adjuntos (adjunto, id_informe) VALUES ('$url','$idInforme')") or throw_ex(mysqli_error($cn));
        }
    }
	//Adjuntos del GHIPS
	 if ($adjunto != "") {
        list($ruta1, $ruta2, $ruta3, $adjuntoOrden) = explode("/", $adjunto);
        list($nomadjun, $tipoadjun) = explode(".", $adjuntoOrden);
        if ($tipoadjun != "") {
            $name = $idInforme . $i;
            copy($adjunto, $ruta . '/' . $name . '.' . $tipoadjun);
            $url = $ruta . '/' . $name . '.' . $tipoadjun;
            mysqli_query($cn, "INSERT INTO r_adjuntos (adjunto, id_informe) VALUES ('$url','$idInforme')") or throw_ex(mysqli_error($cn));
            unlink($adjunto);
        }
    }
	
if ($respuesta=="Agendado Correctamente"){
    echo '<script language="javascript">
			        setTimeout(window.close, 4000);
            </script>';
	}
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

mysqli_close($cn);
?>
<title>.: Guardando Cambios :.</title>
<link href="../styles/VisualStyles.css" rel="stylesheet" type="text/css">
<body onBeforeUnload="return window.opener.mostrarAgenda();">
<table width="50%" border="0" align="center" style="margin-top:20%;">
    <tr>
        <td><img src="../../styles/images/MnyxU.gif" width="64" height="64"/>
        </td>
        <td>
            <strong><h3><?php echo $respuesta; ?></h3></strong>
        </td>
    </tr>
</table>
</body>
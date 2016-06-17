<?php
	//conexion a la BD
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
//variables del sistema
$fecha = date("Y-m-d");
$hora = date("G:i:s");
//declaracion de variables con POST
echo $tipo=$_POST['tipo'];
$motivo=$_POST['MotivoCancelacion'];
$IdInforme=$_POST['edad'];
$norden = $_POST['norden'];
$sede = $_POST['sede'];
$servicio = $_POST['servicio'];
$estudio = $_POST['estudio'];
$tecnica = $_POST['tecnica'];
$extremidad = $_POST['lado'];
$desc_extremidad=$_POST['Extremidad'];
$tipopaciente = $_POST['tipopaciente'];
$prioridad = $_POST['prioridad'];
$ubicacion = strtoupper($ubicacion = $_POST['ubicacion']);
$medsolicita = $_POST['medsolicita'];
$portatil = $_POST['portatil'];
$fechasolicitud = $_POST['fechasolicitud'];
$fechasolicitud = date("Y-m-d",strtotime($fechasolicitud));
$horasolicitud = $_POST['horasolicitud'];
$fechacita = $_POST['fechacita'];
$fechacita = date("Y-m-d",strtotime($fechacita));
$horacita = $_POST['horacita'];
$observaciones = $_POST['observaciones'];
//obtener cantidad de caracteres enviados en las observaciones para evitar registros vacios
$cadenaTexto = $observaciones;
$cadenaTexto = str_replace( array("\\","°","*","_","=", "¨", "º", "-", "~","#", "@", "|", "!", "\"","·", "$", "%", "&", "/", "(", ")", "?", "'", "¡", "¿", "[", "^", "`", "]", "+", "}", "{", "¨", "´", ">", "<", ";", ",", ":", ".", " "),'', $cadenaTexto );
$cadena = strlen($cadenaTexto);
$usuario = $_POST['usuario'];
$adicional = strtoupper($adicional = $_POST['adicional']);
$ruta='../Inserts/uploads';
$tipo_comentario=$_POST['tipo_comentario'];
if($portatil=="")
{
   $portatil = 0;
}
else
{
    $portatil = $portatil;
}
if ($tipo=="modificar")
{
	//actualizar datos de la agenda
mysql_query("UPDATE r_informe_header SET fecha_solicitud='$fechasolicitud',hora_solicitud='$horasolicitud', medico_solicitante='$medsolicita', id_prioridad='$prioridad', idtipo_paciente='$tipopaciente',
idservicio='$servicio', idsede='$sede', ubicacion='$ubicacion', id_extremidad='$extremidad', idestudio='$estudio', orden='$norden', portatil='$portatil', id_tecnica='$tecnica', desc_extremidad='$desc_extremidad'
WHERE id_informe = '$IdInforme'", $cn);
	//actualizar lel adicional
mysql_query("UPDATE r_detalle_informe SET adicional='$adicional' where id_informe='$IdInforme'", $cn);
	//insertar una observacion
	mysql_query("INSERT INTO r_observacion_informe VALUES('$IdInforme','$usuario','$observaciones','$fecha','$hora','$tipo_comentario')", $cn);
	if (isset ($_FILES["archivos"])){
         //de se asi, para procesar los archivos subidos al servidor solo debemos recorrerlo
         //obtenemos la cantidad de elementos que tiene el arreglo archivos
		 
         $tot = count($_FILES["archivos"]["name"]);
         //este for recorre el arreglo
         for ($i = 0; $i < $tot; $i++){
$sqlAdjunto = mysql_query("SELECT MAX(id_adjunto+1) AS idAdjunto FROM r_adjuntos", $cn);
$regAdjunto = mysql_fetch_array($sqlAdjunto);
		$idAdjunto = $regAdjunto['idAdjunto'];
		if($idAdjunto=="" || $idAdjunto==0)
		{
			$idAdjunto = 1 ;
		}
         //con el indice $i, poemos obtener la propiedad que desemos de cada archivo
         //para trabajar con este
		$tipoFile = $_FILES["archivos"]["type"][$i];
		list($nomadjun,$tipoadjun)=explode("/",$tipoFile);
            $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
            $name = $idInforme.$idAdjunto;
			//copiar los archivos adjuntos en la carpeta uploads
			copy($tmp_name, $ruta.'/'.$name.'.'.$tipoadjun);
            $url = 'uploads'.'/'.$name.'.'.$tipoadjun;
			//insertar en la tabla adjuntos para luego realizar consulta del total de archivos adjuntos
			if ($tipoFile=="")
			{
			}
			else
			{
			mysql_query("INSERT INTO r_adjuntos  VALUES ('$idAdjunto','$url','$IdInforme')",$cn);
			}
		}
      }
	echo '<font color="#006600"><strong>Se realizaron los cambios en el Estudio Correctamente, por favor espere que se cierre la ventana</strong></font>';
		echo '<script language="javascript">
			setTimeout("window.close()",2000);
</script>';
	}

	
?>
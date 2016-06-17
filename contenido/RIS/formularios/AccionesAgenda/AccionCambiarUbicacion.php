<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px;" onBeforeUnload="return window.opener.agendasProgramadas();">
<?php
	//conexion a la BD
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	//declaracion de variables con POST
	$ubicacion = strtoupper($_POST['ubicacion']);
	$documento= $_POST['documento'];
	$estudio = $_POST['estudio'];
	$tecnica = $_POST['tecnica'];
	$idInforme = $_POST['idInforme'];
	$adjunto = $_POST['archivo'];
	$extremidad= $_POST['extremidad'];
	$ruta='../Inserts/uploads';
	$tipoFile = $_FILES['archivos']['type'];
	$consValidacion = mysql_query("SELECT * FROM r_paciente WHERE id_paciente = '$documento'", $cn);
	$regsValidacion = mysql_num_rows($consValidacion);
	
	if($regsValidacion>=1)
	{	
	if($tipoFile!="")
	{
		if (isset ($_FILES["archivos"])) {
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
		$tipoFile = $_FILES["archivos"]["type"]['$i'];
		list($nomadjun,$tipoadjun)=explode("/",$tipoFile);
            $tmp_name = $_FILES["archivos"]["tmp_name"]['$i'];
            $name = $idInforme.$idAdjunto;
			//copiar los archivos adjuntos en la carpeta uploads
			copy($tmp_name, $ruta.'/'.$name.'.'.$tipoadjun);
            $url = 'uploads'.'/'.$name.'.'.$tipoadjun;
			//insertar en la tabla adjuntos para luego realizar consulta del total de archivos adjuntos
			mysql_query("INSERT INTO r_adjuntos  VALUES ('$idAdjunto','$url','$idInforme')",$cn);
		}
      } 
		//consulta
		mysql_query("UPDATE r_informe_header SET id_paciente='$documento', ubicacion = '$ubicacion', idestudio='$estudio', id_tecnica='$tecnica', id_extremidad='$extremidad' WHERE id_informe = '$idInforme'", $cn);
		echo '<script type="text/javascript">
window.close();
</script>';
	}
	elseif($tipoFile=="")
	{
		//consulta
		mysql_query("UPDATE r_informe_header SET id_paciente='$documento', ubicacion = '$ubicacion', idestudio='$estudio', id_tecnica='$tecnica', id_extremidad='$extremidad' WHERE id_informe = '$idInforme'", $cn);
	echo '<script type="text/javascript">
window.close();
</script>';
	}
	}
	else
	echo 'NO se puede cambiar el documento de identificacion el paciente no se encuentra registado en la base de datos';
?>
</body>
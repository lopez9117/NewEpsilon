<?php

require_once('../../dbconexion/conexion.php');
	//funcion para abrir conexion
	$cn = Conectarse();
	$codigo=$_POST[codigo2];
	$valor=$_POST[valor];
	$cuota=$_POST[cuota];
	$tipo_activo=$_POST[tipo_activo];
	$descripcion=$_POST[descripcion];
	$cantidad=$_POST[cantidad];
    $marca=$_POST[marca];
	$tipo_depreciacion=$_POST[tipo_depreciacion];
	$modelo=$_POST[modelo];
	$serie=$_POST[serie];
	$responsable=$_POST[responsable2];
	$centro=$_POST[centro];
	$sede=$_POST[localizacion];
	$fecha=$_POST[datepicker];
	$depreciacion=$_POST[depreciacion];
	$tiempo_depreciacion=$_POST[tiempo_depreciacion];
	$propiedad=$_POST[propiedad2];
    $adquicicion=$_POST[adquicicion2];
	$vencimiento_garantia=$_POST[vencimiento_garantia];
	$idaseguradora=$_POST[asegurado];
	$archivo_adquicicion=$_POST['archivo_adquicicion'];
	$asegurado=$_POST[asegurado];
	$garantia=$_POST[garantia];
	$hoja_vida=$_POST['hoja_vida'];
	$contrato_mantenimiento=$_POST['contrato_mantenimiento'];
	$contrato_calibracion=$_POST['contrato_calibracion'];
	$observacion=$_POST[observacion];
	$hoja_de_vida=$_POST[hoja_de_vida];
	$ruta='uploads';
	$carpeta= '/'.$codigo;
	
	if(file_exists($ruta.'/'.$carpeta))
	{
		copy($_FILES['hoja_vida']['tmp_name'], $ruta.'/'.$codigo.'/'.$_FILES ['hoja_vida']['name']);
		$url = $ruta.'/'.$codigo.'/'.$_FILES['hoja_vida']['name'];
		
		copy($_FILES['archivo_adquicicion']['tmp_name'], $ruta.'/'.$codigo.'/'.$_FILES ['archivo_adquicicion']['name']);
		$url1 = $ruta.'/'.$codigo.'/'.$_FILES['archivo_adquicicion']['name'];
	
	copy($_FILES['contrato_mantenimiento']['tmp_name'], $ruta.'/'.$codigo.'/'.$_FILES ['contrato_mantenimiento']['name']);
		$url2 = $ruta.'/'.$codigo.'/'.$_FILES['contrato_mantenimiento']['name'];
	
	copy($_FILES['contrato_calibracion']['tmp_name'], $ruta.'/'.$codigo.'/'.$_FILES ['contrato_calibracion']['name']);
		$url3 = $ruta.'/'.$codigo.'/'.$_FILES['contrato_calibracion']['name'];
		
	mysql_query("INSERT INTO activo_fijo VALUES ('$codigo','$descripcion','$cantidad','$marca','$modelo','$serie','$responsable','$centro','$sede','$fecha','$tiempo_depreciacion','$propiedad','$adquicicion','$url1','$idaseguradora','$vencimiento_garantia','$url','$url2','$url3','$observacion','$hoja_de_vida','$tipo_activo','1','$tipo_depreciacion','$valor','$cuota')",$cn);
	
	if ($hoja_de_vida==1)
		{ 
		mysql_query("INSERT INTO hoja_vida VALUES ('$fecha','$codigo','$marca','$descripcion','$marca','','$sede','$observacion')",$cn);

?>
<script type="text/javascript">
var variablejs = "<?php echo $codigo; ?>" ;
window.location="../../includes/main_menu.php";
//window.open("qr/codigo.php?id="+variablejs+"","","top=300,left=300,width=300,height=300,aling=center");
</script>
<?php
			}else{
				?>
		<script type="text/javascript">
var variablejs = "<?php echo $codigo; ?>" ;
window.location="../../includes/main_menu.php";
//window.open("qr/codigo.php?id="+variablejs+"","","top=300,left=300,width=300,height=300,aling=center");
</script>
<?php
			}
	}
else
	{
		$carpeta = mkdir($ruta.'/'.$codigo);
		copy($_FILES['hoja_vida']['tmp_name'], $ruta.'/'.$codigo.'/'.$_FILES ['hoja_vida']['name']);
		$url = $ruta.'/'.$codigo.'/'.$_FILES['hoja_vida']['name'];
	
	copy($_FILES['archivo_adquicicion']['tmp_name'], $ruta.'/'.$codigo.'/'.$_FILES ['archivo_adquicicion']['name']);
		$url1 = $ruta.'/'.$codigo.'/'.$_FILES['archivo_adquicicion']['name'];
	
	copy($_FILES['contrato_mantenimiento']['tmp_name'], $ruta.'/'.$codigo.'/'.$_FILES ['contrato_mantenimiento']['name']);
		$url2 = $ruta.'/'.$codigo.'/'.$_FILES['contrato_mantenimiento']['name'];
	
	copy($_FILES['contrato_calibracion']['tmp_name'], $ruta.'/'.$codigo.'/'.$_FILES ['contrato_calibracion']['name']);
		$url3 = $ruta.'/'.$codigo.'/'.$_FILES['contrato_calibracion']['name'];
		
		mysql_query("INSERT INTO activo_fijo VALUES ('$codigo','$descripcion','$cantidad','$marca','$modelo','$serie','$responsable','$centro','$sede','$fecha','$tiempo_depreciacion','$propiedad','$adquicicion','$url1','$idaseguradora','$vencimiento_garantia','$url','$url2','$url3','$observacion','$hoja_de_vida','$tipo_activo','1','$tipo_depreciacion','$valor','$cuota')",$cn);
		
		if ($hoja_de_vida==1)
		{ 
		mysql_query("INSERT INTO hoja_vida VALUES ('$fecha','$codigo','$marca','$descripcion','$marca','','$sede','$observacion')",$cn);
			}else{
				?>
		<script type="text/javascript">
var variablejs = "<?php echo $codigo; ?>" ;
window.location="../../includes/main_menu.php";
//window.open("qr/codigo.php?id="+variablejs+"","","top=300,left=300,width=300,height=300,aling=center");
</script>
<?php

			}
	}
?>
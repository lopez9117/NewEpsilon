<?php

require_once('../../dbconexion/conexion.php');
	//funcion para abrir conexion
	$cn = Conectarse();
	$codigo=$_POST[codigo];
	//include("phpqrcode/qrlib.php");
	//QRcode::png($codigo);
	$descripcion=$_POST[descripcion];
	$cantidad=$_POST[cantidad];
    $marca=$_POST[marca];
	$valor=$_POST[valor];
	$cuota=$_POST[cuota];
	$tipo_cuota=$_POST[tipo_cuota];
 	$modelo=$_POST[modelo];
 	$serie=$_POST[serie];
	$responsable=$_POST[responsable];
	$centro=$_POST[centro];
	$sede=$_POST[localizacion2];
	$fecha=$_POST[fecha];
	$depreciacion=$_POST[depreciacion];
	$tiempo_depreciacion=$_POST[tiempo_depreciacion];
	$propiedad=$_POST[propiedad];
    $adquicicion=$_POST[adquicicion];
	$vencimiento_garantia=$_POST[vencimiento_garantia];
	$idaseguradora=$_POST[idaseguradora];
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
		
	mysql_query("UPDATE activo_fijo SET desc_activo='$descripcion',cantidad='$cantidad',marca='$marca',modelo='$modelo',serie='$serie',responsable='$responsable',centro_costos='$centro',sede='$sede',fecha_compra='$fecha',tiempo_depreciacion='$tiempo_depreciacion',propiedad='$propiedad',adquicicion='$adquicicion',idaseguradora='$idaseguradora',vencimiento_garantia='$vencimiento_garantia',observaciones='$observacion',desc_hoja_vida='$hoja_de_vida',Valor_activo='$valor',cuota='$cuota' WHERE codigo='$codigo'",$cn);
	if ($hoja_de_vida==1)
		{ 
		mysql_query("UPDATE hoja_vida SET descripcion='$descripcion',marca='$marca',modelo='$modelo',localizacion='$sede',observaciones='$observacion' WHERE codigo='$codigo'",$cn);
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
		
		mysql_query("UPDATE activo_fijo SET desc_activo='$descripcion',cantidad='$cantidad',marca='$marca',modelo='$modelo',serie='$serie',responsable='$responsable',centro_costos='$centro',sede='$sede',fecha_compra='$fecha',tiempo_depreciacion='$tiempo_depreciacion',propiedad='$propiedad',adquicicion='$adquicicion',idaseguradora='$idaseguradora',vencimiento_garantia='$vencimiento_garantia',observaciones='$observacion',desc_hoja_vida='$hoja_de_vida',Valor_activo='$valor',cuota='$cuota' WHERE codigo='$codigo'",$cn);
		
		if ($hoja_de_vida==1)
		{ 
		mysql_query("UPDATE hoja_vida SET descripcion='$descripcion',marca='$marca',modelo='$modelo',localizacion='$sede',observaciones='$observacion' WHERE codigo='$codigo'",$cn);
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
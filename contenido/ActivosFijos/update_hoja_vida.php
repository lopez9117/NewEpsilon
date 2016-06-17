<?php

require_once('../../dbconexion/conexion.php');
	//funcion para abrir conexion
	$cn = Conectarse();
	$codigo=$_POST[codigo];
	$descripcion=$_POST{descripcion};
	$nombre_generico=$_POST{nombre_generico};
	$marca2=$_POST{marca2};
	$modelo2=$_POST{modelo2};
	$localizacion2=$_POST{localizacion2};
	$fecha=$_POST{fecha};
	$observacion=$_POST{observacion};
	
	mysql_query("UPDATE hoja_vida SET nombre_generico='$nombre_generico',descripcion='$descripcion',marca='$marca2',modelo='$modelo2',localizacion='$localizacion2',observaciones='$observacion' WHERE codigo='$codigo'",$cn);

		?>
	<script type="text/javascript">
var variablejs = "<?php echo $codigo; ?>" ;
window.location="../../includes/main_menu.php";
//window.open("qr/codigo.php?id="+variablejs+"","","top=300,left=300,width=300,height=300,aling=center");
</script>	

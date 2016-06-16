<?php
	//archivo de conexion a la bd
	include('../../../../dbconexion/conexion.php');
	$cn = Conectarse();
	//declaracion de variables con POST
	$idfuncionario = $_POST['idfuncionario'];
	$desde = $_POST['desde'];
	$cantDias = $_POST['cantDias'];
	$tipo = $_POST['tipo'];
	$observacion = $_POST['observacion'];
	list($month, $day, $year) = explode("/",$desde);
	//funcion para sumar la cantidad de dias habiles*/
	//Esta pequeña funcion me crea una fecha de entrega sin sabados ni domingos  
    $fechaInicial = $fechaInicial = $year.'-'.$month.'-'.$day;
    $MaxDias = ($cantDias-1); //Cantidad de dias maximo para el prestamo, este sera util para crear el for        
	 //Creamos un for desde 0 hasta 3  
	 for ($i=0; $i<$MaxDias; $i++)  
    {  
		$dia = $dia + 1;
		$nuevafecha = strtotime ( '+'.$dia.' day' , strtotime ( $fechaInicial ) ) ; 
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		list($anio, $mes, $d) = explode("-",$nuevafecha);
		$wkdy = (((mktime ( 0, 0, 0, $mes, $d, $anio) - mktime ( 0, 0, 0, 7, 17, 2006))/(60*60*24))+700000) % 7;
        //Comparamos si estamos en sabado o domingo, si es asi restamos una vuelta al for, para brincarnos el o los dias...  
		if($wkdy == 5 || $wkdy==6 )  
		{  
			$i--;  
		}  
		else 
		{  
			$fecha = $anio.'-'.$mes.'-'.$d;
			$sql = mysql_query("SELECT * FROM dia_festivo WHERE fecha_festivo = '$fecha'",$cn);
			$res = mysql_num_rows($sql);
			
			if ($res>=1)
			{
				$i--;
			}
			else
			{
				$fecha.'<br>';	
			} 
		}  
    }  
?>
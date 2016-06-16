<?php
	//archivo de conexion a la bd
	include('../../../dbconexion/conexion.php');
	$cn = Conectarse();
	//declaracion de las variables con post
	$desde = $_POST['desde'];
	$hasta = $_POST['hasta'];
	$nota = $_POST['nota'];
	$funcionario = $_POST['funcionario'];
	$fecha = $_POST['fecha'];
	//validar campos obligatorios en el formulario
	if($desde=="" || $hasta=="" || $funcionario=="")
	{
		echo 'Verifique los campos vacios';
	}
	else
	{
		//consultar si ya se ha realizado el registro de una novedad
		
	}
?>
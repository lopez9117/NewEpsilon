<?php
//conexion a la BD
try {
    require_once("../../../../dbconexion/conexion.php");
    $cn = conectarse();
    $observacion = $_POST['observacion'];
    $usuario = $_POST['usuario'];
    $idinforme = $_POST['informe'];
    $tipo_comentario = $_POST['tipo_comentario'];
    $fecha = date("Y-m-d");
    $hora = date("G:i:s");
    $insumos = $_POST['insumos'];
    $cantidad = $_POST['cantidades'];

    if ($insumos == '') {
        $insumos = '0';
        $cantidad = '0';
    }

//insersion en la bd
    mysql_query("INSERT INTO r_observacion_informe VALUES('$idinforme','$usuario','$observacion','$fecha','$hora', '$tipo_comentario')", $cn) OR showerror(mysql_error());
//Registro de insumos
    mysql_query("UPDATE r_informe_facturacion SET insumos='$insumos',cantidadinsumos='$cantidad'  WHERE id_informe='$idinforme'", $cn) OR showerror(mysql_error());
//codificar variables
    $info = base64_encode($idinforme);
    $user = base64_encode($usuario);

    echo '<script language="javascript">
		location.href="VerDetalles.php?idInforme=' . $info . '&usuario=' . $user . '"
	</script>';

} catch (Exception $e) {
    echo $e;
}
function showerror($e)
{
    echo 'Ha ocurrido un error ' . $e . '<br/>';
}

?>
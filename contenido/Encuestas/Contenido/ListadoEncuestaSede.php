<?php 
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
$sede = $_GET['sede']; $mes = $_GET['mes']; $anio = $_GET['anio']; $encuesta = $_GET['encuesta'];
//construir variables para le fecha
$fechaInicio = $anio.'-'.$mes.'-'.'01';
$fechaFinal = $anio.'-'.$mes.'-'.'31';
//consultar cantidad de encuestas realizadas durante el mes en la sede seleccionada
$consUsuariosEncuestados = mysql_query("SELECT e.idencuesta, e.idusuario, u.nombres, u.cedula FROM e_encuesta e
INNER JOIN e_usuario u ON u.idusuario = e.idusuario
WHERE idnombencuesta = '$encuesta' AND idsede = '$sede' AND fecha BETWEEN '$fechaInicio' AND '$fechaFinal'", $cn);
?>
 <script type="text/javascript">
 $(document).ready(function(){
   $('#tabla_listado_encuestados').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
    } );
})
 </script>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_listado_encuestados">
<thead>
    <tr>
        <th align="center">Identificación</th>
        <th align="center">Usuario</th>
        <th align="center">Ver Detalles</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <th></th>                   
    </tr>
</tfoot>
<tbody>
<?php
//imprimir resultados de la consulta
while($rowEncuestas = mysql_fetch_array($consUsuariosEncuestados))
{
	echo 
	'<tr>
		<td align="left">'.$rowEncuestas['cedula'].'</td>
		<td align="left">'.$rowEncuestas['nombres'].'</td>
		<td align="center"><a href="PollRequest.php?id='.base64_encode($rowEncuestas['idencuesta']).'" onClick="window.open(this.href, this.target, width=600,height=800); return false;" target="Encuesta">Ver Detalles</a>
</td>
	</tr>';
}
?>
<tbody>
</table>

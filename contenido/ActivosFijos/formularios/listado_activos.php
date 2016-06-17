<?php 
session_start();
$_SESSION[area] = $area;
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$tipoactivo=$_GET[activo];
//$sede=$_GET[sede];
//consulta
$listado =  mysql_query("SELECT f.nombres,f.idfuncionario,f.apellidos,ta.desc_tipo,ad.tipo,p.desc_propiedad,ase.aseguradora,s.descsede,a.id_tipo_activo,a.fecha_compra,a.codigo,a.id_tipo_activo FROM activo_fijo a
INNER JOIN sede s ON s.idsede = a.sede
INNER JOIN aseguradora ase ON ase.id = a.idaseguradora
INNER JOIN propiedad p ON p.id_propiedad = a.propiedad
INNER JOIN tipo_adquicicion ad ON ad.id_adquicicion = a.adquicicion
INNER JOIN tipo_activo ta ON ta.id_tipo = a.id_tipo_activo
INNER JOIN funcionario f ON f.idfuncionario = a.responsable where id_tipo_activo='$tipoactivo' AND estado_activo='1'",$cn);
?>
 <script type="text/javascript">
 $(document).ready(function(){
   $('#tabla_listado_funcionarios').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
    } );
})
 </script>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_listado_funcionarios">
<thead>
    <tr><!--Estado-->
        <th align="left">Codigo</th>
        <th align="left">Nombre y Apellido</th>
        <th align="left">Sede</th>
        <th align="left">Propiedad</th>
        <th align="left">Tipo Adquicición</th>
        <th align="left">Fecha Compra</th>
        <th align="left" colspan="1">Tareas</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <th></th>
        <th></th>
       <th></th>                     
    </tr>
</tfoot>
  <tbody>
    <?php


   while($reg=  mysql_fetch_array($listado))
   {
	   $cadena = $reg['codigo'];
$findme   = '0';
while (strpos($cadena, $findme)==0){
$cadena=substr ($cadena,1);
}

       echo '<tr>';
	   echo '<td align="left">'.mb_convert_encoding($cadena, "UTF-8").'</td>';
       echo '<td align="left">'.$reg['nombres'].''.$reg['apellidos'].'</td>';
	   echo '<td align="left">'.mb_convert_encoding($reg['descsede'], "UTF-8").'</td>';
	   echo '<td align="left">'.mb_convert_encoding($reg['desc_propiedad'], "UTF-8").'</td>';
	   echo '<td align="left">'.mb_convert_encoding($reg['tipo'], "UTF-8").'</td>';
	   echo '<td align="left">'.mb_convert_encoding($reg['fecha_compra'], "UTF-8").'</td>';
	    ?>
		<?php
		if ($area==5)
	   {
	   echo '<td align="left"><a href="#" onclick="cargarqr('.$cadena.')"><img src="../../../images/qr.png" width="20" height="20" id="Image1" border="0" alt="Imprimir Codigo Qr" title="Imprimir Codigo Qr" ></a>
	   <a href="#" onclick="cargarcodigobarras('.$cadena.')"><img src="../../../images/cbarras.png" width="30" height="20" id="Image1" border="0" alt="Imprimir Codigo de Barra" title="Imprimir Codigo de Barra"></a>
	   <input type="checkbox" name="'.$cadena.'" id="'.$cadena.'" value="2" onClick="DarBaja('.$cadena.')" alt="Dar de Baja" title="Dar de Baja">
<a href="Cons_activos.php?codigo='.$reg['codigo'].'">Editar</a></td>';
	   }else
	   {
		echo '<td align="left"></td>';   
	   }
	   echo '</tr>';
   }
    ?>
<tbody>
</table>
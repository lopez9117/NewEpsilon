<?php 
//Conexion a la base de datos
require_once('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//consulta
$listado =  mysql_query("SELECT f.idfuncionario, f.nombres, f.apellidos, g.desc_grupoempleado, ea.desc_estado FROM funcionario f
INNER JOIN grupo_empleado g ON g.idgrupo_empleado = f.idgrupo_empleado
INNER JOIN estado_actividad ea ON ea.idestado_actividad = f.idestado_actividad ORDER BY desc_estado, desc_grupoempleado ASC",$cn);
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
    <tr>
        <th align="left">N° Documento</th><!--Estado-->
        <th align="left">Nombres</th>
        <th align="left">Apellidos</th>
        <th align="left">Grupo de empleados</th>
        <th align="left">Estado</th>
        <th align="center">Editar</th>
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
       echo '<tr>';
       echo '<td align="left">'.mb_convert_encoding($reg['idfuncionario'], "UTF-8").'</td>';
       echo '<td align="left">'.mb_convert_encoding($reg['nombres'], "UTF-8").'</td>';
       echo '<td align="left">'.mb_convert_encoding($reg['apellidos'], "UTF-8").'</td>';
	   echo '<td align="left">'.mb_convert_encoding($reg['desc_grupoempleado'], "UTF-8").'</td>';
	   echo '<td align="left">'.mb_convert_encoding($reg['desc_estado'], "UTF-8").'</td>';
	   echo '<td align="center"><a href="editar_registro.php?id='.$reg['idfuncionario'].'">Editar</a></td>';
       echo '</tr>';
   }
    ?>
<tbody>
</table>

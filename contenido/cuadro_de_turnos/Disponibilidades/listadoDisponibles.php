<?php 
//Conexion a la base de datos
include('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//consulta
$listado =  mysql_query("SELECT f.idfuncionario, f.nombres, f.apellidos, g.desc_grupoempleado FROM funcionario f
INNER JOIN grupo_empleado g ON g.idgrupo_empleado = f.idgrupo_empleado
WHERE f.idestado_Actividad = 1 ORDER BY nombres ASC",$cn);
//variables GET
$CurrentUser = $_GET['CurrentUser'];
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
        <th align="center">N° Documento</th><!--Estado-->
        <th align="center">Nombres / Apellidos</th>
        <th align="center">Grupo de empleados / Cargo</th>
        <th align="center">Registrar Disponibilidades</th>
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
       echo '<td align="left">'.mb_convert_encoding($reg['nombres'], "UTF-8").'&nbsp;'.mb_convert_encoding($reg['apellidos'], "UTF-8").'</td>';
	   echo '<td align="left">'.mb_convert_encoding($reg['desc_grupoempleado'], "UTF-8").'</td>'; ?>
	   <td align="center"><a href="Disponibilidad.php?id=<?php echo base64_encode($reg['idfuncionario'])?>&CurrentUser=<?php echo base64_encode($CurrentUser) ?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=700, height=400, top=85, left=140'); return false;">Registrar</a></td>
   <?php
   echo '</tr>';
   }
    ?>
<tbody>
</table>

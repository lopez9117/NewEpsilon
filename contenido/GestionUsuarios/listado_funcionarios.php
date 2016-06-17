<?php 
//Conexion a la base de datos
include('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//consulta
$listado =  mysql_query("SELECT DISTINCT(f.idfuncionario), CONCAT(f.nombres,' ',f.apellidos) AS funcionario, g.desc_grupoempleado FROM funcionario f INNER JOIN grupo_empleado g ON g.idgrupo_empleado = f.idgrupo_empleado WHERE f.idestado_actividad = '1' ORDER BY desc_grupoempleado ASC",$cn);
?>
 <script type="text/javascript">
 $(document).ready(function(){
   $('#tabla_listado_funcionarios').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers",
		"aaSorting": [[ 2, "asc" ]],
"aoColumns": [ null, null, null, null ]
    } );
})
 </script>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_listado_funcionarios">
<thead>
<tr>
    <th align="center" width="25%">N° Documento</th><!--Estado-->
    <th align="center" width="25%">Nombres y apellidos</th>
    <th align="center" width="25%">Grupo de empleados</th>
    <th align="center" width="25%">Tareas</th>
</tr>
</thead>
<tfoot>
<tr>
    <th></th>
    <th></th>                   
</tr>
</tfoot>
<tbody>
<?php
while($reg = mysql_fetch_array($listado))
{
   echo '<tr>';
   echo '<td align="center">'.$reg['idfuncionario'].'</td>';
   echo '<td align="left">'.$reg['funcionario'].'</td>';
   echo '<td align="center">'.$reg['desc_grupoempleado'].'</td>';
   echo '<td align="center">';?>
   <a href="Inserts/insertNewUser.php?idFuncionario=<?php echo base64_encode($reg['idfuncionario'])?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=200'); return false;"><img src="../../images/edit_add.png" width="16" height="16" id="Image1" border="0" alt="Asignar / Quitar permisos" title="Asignar / Quitar permisos"></a>
   <?php echo '</td></tr>';
}
?>
<tbody>
</table>
<?php
	include("../../../dbconexion/conexion.php");
	$cn = Conectarse();
	include("ListasSeleccionables.php");
	//declaracion de variables
	$especialista = $_POST['especialista'];
	list($idEspecialista, $nombreCompleto) = explode("-", $especialista);
	if($especialista=="")
	{
		echo '<font color="#FF0000">Por favor seleccione un especialista</font>';
	}
	else
	{
		//consultar informacion del especialista
		$consEspecialista = mysql_query("SELECT esp.idfuncionario_esp, esp.reg_medico, esp.url_firma, 
		esp.firma_respaldo, esp.iduniversidad, esp.id_especialidad, f.nombres, f.apellidos FROM r_especialista esp
		INNER JOIN funcionario f ON f.idfuncionario = esp.idfuncionario_esp
		WHERE esp.idfuncionario_esp = '$idEspecialista'", $cn);
		$InfoEspecialista = mysql_fetch_array($consEspecialista);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Información Especialista :.</title>
<style type="text/css">
body
{font-family:Arial, Helvetica, sans-serif;
font-size:10px;}
fieldset
{
	width:98%;
}
.input
{font-size:12px;
width:250px;
}
</style>
</head>
<body>
<form id="UpdateEspecialista" name="UpdateEspecialista" method="post" action="Updates/UpdateEspecialista.php">
<fieldset>
	<legend><strong>Especialista</strong></legend>
      <table width="100%" border="0">
        <tr>
          <td width="33%"><strong>N° de identificación</strong></td>
          <td width="33%"><strong>Nombres</strong></td>
          <td width="33%"><strong>Apellidos</strong></td>
        </tr>
        <tr>
          <td><label for="idEspecialista"></label>
          <input type="text" name="idEspecialista" id="idEspecialista" class="input" value="<?php echo $InfoEspecialista['idfuncionario_esp'] ?>" readonly="readonly" /></td>
          <td><label for="nombEspecialista"></label>
          <input type="text" name="nombEspecialista" id="nombEspecialista" class="input" value="<?php echo ucwords(strtolower($InfoEspecialista['nombres'])) ?>" readonly="readonly"/></td>
          <td><label for="apeEspecialista"></label>
          <input type="text" name="apeEspecialista" id="apeEspecialista"class="input" value="<?php echo ucwords(strtolower($InfoEspecialista['apellidos'])) ?>" readonly="readonly"/></td>
        </tr>
        <tr>
          <td><strong>Especialidad</strong></td>
          <td><strong>Universidad</strong></td>
          <td><strong>Registro medico</strong></td>
        </tr>
        <tr>
          <td><select name="especialidad" id="especialidad" class="input">
           <?php
            	while($rowEspecialidad = mysql_fetch_array($consEspecialidad))
				{
				?>
                <option value="<?php echo $rowEspecialidad['id_especialidad']?>"
                <?php
                	if($rowEspecialidad['id_especialidad']==$InfoEspecialista['id_especialidad'])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    >
				<?php echo ucwords(strtolower($rowEspecialidad['nom_especialidad']))?></option>
				<?php
				}
			?>
          </select></td>
          <td><select name="universidad" id="universidad" class="input">
          <?php
          	while($rowUniversidad = mysql_fetch_array($consUniversidad))
				{
				?>
                <option value="<?php echo $rowUniversidad['iduniversidad']?>"
                <?php
                	if($rowUniversidad['iduniversidad']== $InfoEspecialista['iduniversidad'])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    >
				<?php echo ucwords(strtolower($rowUniversidad['nom_universidad']))?></option>
				<?php
				}
		  ?>
          </select></td>
          <td><input type="text" name="registroMedico" id="registroMedico" class="input" value="<?php echo $InfoEspecialista['reg_medico'] ?>" /></td>
        </tr>
        <tr>
          <td><strong>Firma digital</strong></td>
          <td><strong>Firma de respaldo</strong> &nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="firmarespaldo" type="checkbox" value=""<?php if($InfoEspecialista['firma_respaldo']==1)
		  {
			 ?> 
             checked="checked" alt="Seleccione solo si el especialista necesita una firma de respaldo" title="Seleccione solo si el especialista necesita una firma de respaldo"
		  <?php }  ?>/> 
          (Seleccione esta opción solo si es necesario)</td>
          <td><input type="submit" name="button" id="button" value="Actualizar" /></td>
        </tr>
        <tr>
          <td><img src="../images/<?php echo $InfoEspecialista['url_firma']?>" width="150px" height="90px" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><label for="universidad"></label></td>
          <td><label for="registroMedico"></label></td>
          <td>&nbsp;</td>
        </tr>
      </table>
</fieldset>
 </form>
</body>
</html>
<?php }
    mysql_close($cn);
?>
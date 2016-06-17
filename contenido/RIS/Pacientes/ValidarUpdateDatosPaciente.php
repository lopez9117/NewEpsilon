<?php
//conexion a la BD
	require_once("../../../dbconexion/conexion.php");
	$cn = conectarse();	
	//archivo con listas seleccionables
		include("../select/selects.php");
	//declaracion de variables con POST
	$paciente = $_POST['paciente'];
	//separar variables para hacer consulta
	list($regpaciente, $nombres) = explode("--", $paciente);
	echo $PacienteOld = $regpaciente;
	//consultar informacion del paciente y traer la informacion
	$sqlpaciente = mysql_query("SELECT * FROM r_paciente WHERE id_paciente = '$regpaciente'", $cn);
	$con = mysql_num_rows($sqlpaciente);
	if($con=="" || $con=="0" || $regpaciente == "")
	{
		echo '<font color="#FF0000>No se encontraron datos con el actual criterio de busqueda</font>"';
	}
	else
	{
		$regpaciente = mysql_fetch_array($sqlpaciente);
		$edad = $regpaciente['edad'];
	list($edadpac, $unidad) = explode(" ", $edad);	
		$telefonos=$regpaciente['tel'];
		$fechanacimiento = $regpaciente['fecha_nacimiento'];
	list($tel,$cel)=explode("/",$telefonos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>        
<script language="javascript">
function ValidateUpdate()
{
	//declaracion de las variables
	documento = document.UpdatePaciente.ndocumento.value;
	tipo_documento = document.UpdatePaciente.tipo_documento.value;
	pnombre = document.UpdatePaciente.pnombre.value;
	snombre = document.UpdatePaciente.snombre.value; 
	papellido = document.UpdatePaciente.papellido.value;
	sapellido = document.UpdatePaciente.sapellido.value; 
	edad = document.UpdatePaciente.edad.value; 
	unidadedad = document.UpdatePaciente.unidadedad.value; 
	genero = document.UpdatePaciente.genero.value;
	fecha_naci = document.UpdatePaciente.fecha_naci.value;
	eps = document.UpdatePaciente.eps.value;	
	//validar campos obligatorios del formulario
	if(documento=="" || tipo_documento=="0" || pnombre=="" || papellido=="" || edad == "" || unidadedad =="0" || genero =="0" || fecha_naci == "")
	{
		respuesta = "<font color='#FF0000'>Los campos señalados con * son obligatorios, o la fecha de nacimiento no es correcta</font>";
		document.getElementById('respuesta').innerHTML = respuesta;
	}
	else
	{
		alerta = confirm("Si actualiza los datos todos los registros anteriores quedaran asociados a la nueva informacion, Esta seguro que desea continuar?");
		if(alerta==true)
		{
			//enviar formulario
			document.forms['UpdatePaciente'].submit();
		}
	}
}
function calcularEdad2()
{
    var fecha=document.getElementById("fecha_naci").value;
	// Si la fecha es correcta, calculamos la edad
        var values=fecha.split("-");
        var dia = values[2];
        var mes = values[1];
        var ano = values[0];

        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth();
        var ahora_dia = fecha_hoy.getDate();
        
        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if ( ahora_mes < (mes - 1))
        {
            edad--;
        }
        if (((mes - 1) == ahora_mes) && (ahora_dia < dia))
        {
            edad--;
        }
        if (edad > 1900)
        {
            edad -= 1900;
        }
       	document.getElementById('edad').value = edad;
}
</script>
<script src="../formularios/JavasScript/FuncionesAgendamiento.js"></script>
</head>

<body>
<form id="UpdatePaciente" name="UpdatePaciente" method="post" action="AccionUpdatePaciente.php">
<fieldset>
<legend><strong>Información del Paciente</strong></legend>
  <table width="100%" border="0">
                <tr>
                    <td width="16%"><strong>Tipo documento</strong><br><label for="tipo_documento"></label>
					<select name="tipo_documento" class="textlarge">
					<?php
                            while ($rowtipoDocumento = mysql_fetch_array($listaTipoDocumento)) {
                                ?>
                                <option value="<?php echo $rowtipoDocumento['idtipo_documento'] ?>"
                                    <?php
                                    if ($rowtipoDocumento['idtipo_documento'] == $regpaciente['idtipo_documento']) {
										?>
										selected="selected"
                                    <?php
                                    }
                                    ?>
                                    > <?php echo $rowtipoDocumento['desc_tipodocumento'] ?></option>
                            <?php
                            }
                            ?>                                      
                        </select><span class="asterisk">*</span></td>
                    <td width="16%"><strong>N&deg; Documento</strong><br><label for="ndocumento"></label>
                        <input type="text" name="ndocumento" value="<?php echo $regpaciente['id_paciente'] ?>"
                               placeholder="Numero de documento" class="textlarge"/><span class="asterisk">*</span>
                               <input type="hidden" name="PacienteOld" id="PacienteOld" value="<?php echo $PacienteOld ?>" /></td>
                    <td width="16%"><strong>1&deg; Nombre</strong><br><label for="pnombre"></label>
                        <input type="text" name="pnombre" value="<?php echo $regpaciente['nom1'] ?>"
                               placeholder="Primer Nombre" class="textlarge"/><span class="asterisk">*</span></td>
                    <td width="16%"><strong>2&deg; Nombre</strong><br><label for="snombre"></label>
                        <input type="text" name="snombre" value="<?php echo $regpaciente['nom2'] ?>"
                               placeholder="Segundo Nombre" class="textlarge"/></td>
                    <td width="16%"><strong>1&deg; Apellido</strong><br><label for="papellido"></label>
                        <label for="papellido"></label>
                        <input type="text" name="papellido" value="<?php echo $regpaciente['ape1'] ?>"
                               placeholder="Primer Apellido" class="textlarge"/><span class="asterisk">*</span></td>
                    <td width="16%"><strong>2&deg; Apellido</strong><br><label for="sapellido"></label>
                        <input type="text" name="sapellido" value="<?php echo $regpaciente['ape2'] ?>"
                               placeholder="Segundo Apellido" class="textlarge"/></td>
                </tr>
                <tr>
                  <td><strong>Fecha de nacimiento:</strong><br>
                        <label for="fecha_nacimiento"></label>
                          <input type="date" name="fecha_naci" id="fecha_naci" value="<?php echo $fechanacimiento ?>" onblur="calcularEdad2()" /><span class="asterisk">*</span></td>
                    <td id="divedad"><strong>Edad</strong><br/>
                        <input type="text" name="edad" id="edad" size="8" value="<?php echo $edadpac ?>"
                               class="textSmall"/>
                        <label for="unidadedad"></label>
                        <select name="unidadedad" id="unidadedad" style="width:95px">
                            <option value="AÑO" <?php
                            if ($unidad == 'AÑO') {
                                ?>
                                selected="selected"
                            <?php
                            } ?> >A&Ntilde;O(S)
                            </option>
                            <option value="MES" <?php
                            if ($unidad == 'MES') {
                                ?>
                                selected="selected"
                            <?php
                            } ?>>MES(ES)
                            </option>
                            <option value="DIA" <?php
                            if ($unidad == 'DIA') {
                                ?>
                                selected="selected"
                            <?php
                            }
                            ?>>DIA(S)
                            </option>
                        </select>
                        <span class="asterisk">*</span></td>
                    <td><strong>Genero</strong><br/>
                        <label for="genero"></label>
                        <select name="genero" id="genero" class="textlarge">
                            <option value="0">.: Seleccione :.</option>
                            <?php
                            while ($rowGenero = mysql_fetch_array($listaSexo)) {
                                ?>
                                <option value="<?php echo $rowGenero['id_sexo'] ?>"
                                    <?php
                                    if ($rowGenero['id_sexo'] == $regpaciente['id_sexo']) {
                                        ?>
                                        selected="selected"
                                    <?php
                                    }
                                    ?>
                                    > <?php echo $rowGenero['desc_sexo'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <span class="asterisk">*</span></td>
                  <td colspan="2"><strong>EPS</strong><br/>
                  <label for="eps"></label>
        <select name="eps" id="selectLarge">
          <option value="0">.: Seleccione :.</option>
          <?php
            	while($roweps = mysql_fetch_array($listaEps))
				{
				?>
          <option value="<?php echo $roweps['ideps']?>"
                <?php
                	if($roweps['ideps']==$regpaciente['ideps'])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    > <?php echo strtoupper($roweps['desc_eps'])?></option>
          <?php
				}
			?>
        </select><span class="asterisk">*</span>
                        <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>"/></td>
                    <td><strong>Tipo Afiliaci&oacute;n</strong><br>
                        <select name="tipo_afiliacion" class="textlarge">
                            <?php
                            while ($rowTipoAfiliacion = mysql_fetch_array($ListaTipoAfilicacion)) {
                                ?>
                                <option value="<?php echo $rowTipoAfiliacion['id_tipoafiliacion'] ?>"
                                    <?php
                                    if ($rowTipoAfiliacion['id_tipoafiliacion'] == $regpaciente['id_tipoafiliacion']) {
                                        ?>
                                        selected="selected"
                                    <?php
                                    }
                                    ?>
                                    >
                                    <?php echo $rowTipoAfiliacion['desc_tipoafiliacion'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <span class="asterisk">*</span>
                        </label></td>
                    <td><strong>Nivel</strong><br><select name="nivel_afiliacion" class="textlarge">
                            <option value="0">N/A</option>
                            <?php
                            for ($x = 1; $x <= 4; $x = $x + 1) {
                                ?>
                                <option value="<?php echo $x ?>"
                                    <?php
                                    if ($x == $regpaciente['nivel']) {
                                        ?>
                                        selected="selected"
                                    <?php
                                    }
                                    ?>
                                    >
                                    <?php echo $x ?></option>
                            <?php
                            }
                            ?>
                        </select></td>
                </tr>
            </table>
        </fieldset>
        <br>
        <fieldset>
            <!--<legend><a href="#" onclick="muestra_oculta()"><strong>Informacion de contacto</strong></a></legend>-->
            <legend><strong>Informacion de contacto</strong></legend>
            <!--<div id="contacto" style="display:none" >-->
            <div>
                <table width="100%" align="center">
                    <tr>
                        <td width="16%">
                            <strong>Departamento</strong><br>
                            <select name="dep" onChange="cargarMunicipio()" class="textNormal">
                                <option value="0">.: Seleccione :.</option>
                                <?php
                                while ($rowDpto = mysql_fetch_array($listaDepartamentos)) {
                                    ?>
                                    <option value="<?php echo $rowDpto['cod_dpto'] ?>"
                                        <?php
                                        if ($rowDpto['cod_dpto'] == $regpaciente['cod_dpto']) {
                                            ?>
                                            selected="selected"
                                        <?php
                                        }
                                        ?>
                                        >
                                        <?php echo $rowDpto['nombre_dpto'] ?></option>
                                <?php
                                }
                                ?>
                            </select></td>
                        <td width="16%"><label for="municipio"></label>
                            <strong> Municipio</strong><br>
                            <select name="mun" id="mun" class="textNormal">
                                <option value="0">.: Seleccione :.</option>
                                <?php
                                while ($rowMpo = mysql_fetch_array($ListaMunicipio)) {
                                    ?>
                                    <option value="<?php echo $rowMpo['cod_mun'] ?>"
                                        <?php
                                        if ($rowMpo['cod_mun'] == $regpaciente['cod_mun']) {
                                            ?>
                                            selected="selected"
                                        <?php
                                        }
                                        ?>
                                        >
                                        <?php echo $rowMpo['nombre_mun'] ?></option>
                                <?php
                                }
                                ?>
                            </select></td>
                        <td width="16%"><label for="barrio"></label>
                            <strong>Barrio</strong><br>
                            <input name="barrio" type="text" value="<?php echo $regpaciente['barrio']; ?>"
                                   class="textNormal" placeholder="Barrio"/></td>
                        <td width="16%"><label for="direccion"></label>
                            <strong>Direccion</strong><br>
                            <input name="direccion" type="text" value="<?php echo $regpaciente['direccion']; ?>"
                                   class="textNormal" placeholder="Direcciï¿½n del domicilio"/></td>
                        <td><strong>Tel / movil</strong><br><label for="tel"></label>
                            <input name="tel" type="text" value="<?php echo $tel; ?>" class="textlarge"
                                   placeholder="Fijo"/>/
                            <label for="movil"></label>
                            <input name="movil" type="text" value="<?php echo $cel; ?>" class="textlarge"
                                   placeholder="Movil"/></td>
                        <td width="16%"><label for="email"></label>
                            <strong>E-m@il</strong><br>
                            <input name="email" type="text" value="<?php echo $regpaciente['email']; ?>"
                                   class="textNormal" placeholder="Correo electronico"/></td>
                    </tr>
                    <tr>
       <td colspan="3" id="respuesta"></td>
      <td colspan="3" align="right">
          <input type="button" name="guardar" id="guardar" value="Modificar Datos" onclick="ValidateUpdate();" />
          <input type="reset" name="button" id="button" value="Restablecer" />
      </label></td>
    </tr>
                </table>
  </fieldset>
</form>
<br>
</body>
</html>
<?php
	}
	mysql_close($cn);
?>
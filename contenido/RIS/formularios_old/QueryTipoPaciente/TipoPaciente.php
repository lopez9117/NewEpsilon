<?php
include("../../../../dbconexion/conexion.php");
$cn = conectarse();
$idpaciente = $_POST['idpaciente'];
$paciente = mysql_query("SELECT * FROM r_paciente WHERE id_paciente='$idpaciente'",$cn);
$regpaciente = mysql_fetch_array($paciente);
$telefonos = $regpaciente['tel'];
list($tel, $cel) = explode("/", $telefonos);
$listaDepartamentos = mysql_query("SELECT * FROM r_departamento ORDER BY nombre_dpto ASC", $cn);
$ListaMunicipio = mysql_query("SELECT * FROM r_municipio ORDER BY nombre_mun ASC", $cn);
$tipopaciente = $_POST['tipopaciente'];
if ($tipopaciente == '2')
{
?>
    <fieldset>
        <!--<legend><a href="#" onclick="muestra_oculta()"><strong>Informacion de contacto</strong></a></legend>-->
        <legend><strong>Informaci&oacute;n de contacto</strong></legend>
        <!--<div id="contacto" style="display:none" >-->
        <div>
            <table width="100%" align="center">
                <tr>
                    <td width="30%">
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
                        </select><span class="asterisk">*</span></td>
                    <td width="20%"><label for="municipio"></label>
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
                        </select><span class="asterisk">*</span></td>
                    <td width="16%"><label for="barrio"></label>
                        <strong>Barrio</strong><br>
                        <input name="barrio" type="text" value="<?php echo $regpaciente['barrio']; ?>"
                               class="textNormal" placeholder="Barrio"/><span class="asterisk">*</span></td>
                    <td width="16%"><label for="direccion"></label>
                        <strong>Direccion</strong><br>
                        <input name="direccion" type="text" value="<?php echo $regpaciente['direccion']; ?>"
                               class="textNormal" placeholder="Direcci&oacute;n del domicilio"/><span class="asterisk">*</span></td>
                    <td width="10%"><strong>Tel / movil</strong><br><label for="tel"></label>
                        <input name="tel" type="text" value="<?php echo $tel; ?>" class="textlarge"
                               placeholder="Fijo"/>/
                        <label for="movil"></label>
                        <input name="movil" type="text" value="<?php echo $cel; ?>" class="textlarge"
                               placeholder="Movil"/><span class="asterisk">*</span></td>
                    <td width="10%"><label for="email"></label>
                        <strong>E-m@il</strong><br>
                        <input name="email" type="text" value="<?php echo $regpaciente['email']; ?>"
                               class="textNormal" placeholder="Correo electronico"/></td>
                </tr>
            </table>
        </div>
    </fieldset>
<?php
    }
else
{
    ?>
    <fieldset>
        <!--<legend><a href="#" onclick="muestra_oculta()"><strong>Informacion de contacto</strong></a></legend>-->
        <legend><strong>Informaci&oacute;n de contacto</strong></legend>
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
                               class="textNormal" placeholder="Direcci�n del domicilio"/></td>
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
            </table>
        </div>
    </fieldset>
    <?php
}
    ?>
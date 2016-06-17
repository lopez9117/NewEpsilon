<body onLoad="setInterval('MostrarTurnos()',1000); validaFecha()">
<form name="Regturno" id="Regturno" method="post" action="inserts/AccionRegTurno.php">
<?php
//consultar convenciones registradas
$consConvencion = mysql_query("SELECT * FROM convencion_cuadro WHERE idestado_actividad = '1' ORDER BY alias ASC", $cn);
?>
<table width="100%">
    <tr>
        <td><label for="date"></label>
        <input type="text" name="fecha" id="datepicker" class="text" value="<?php echo $Fecha ?>" onChange="validaFecha()" readonly></td>
        <td><div id="respTipo"></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
<tr>
<td width="25%">Convencion:<br>
    <label for="convencion"></label>
    <select name="convencion" id="convencion" class="text" onChange="GetConvencion(); Final()">
    <option value="">-- Seleccione --</option>
    <?php
    while($rowConvencion = mysql_fetch_array($consConvencion))
    {
        echo '<option value="'.$rowConvencion['id'].'">'.$rowConvencion['alias'].'&nbsp;&nbsp;-&nbsp;&nbsp;'.$rowConvencion['hr_inicio'].' - '.$rowConvencion['hr_fin'].'</option>';
    }
    ?>
    </select>
</td>
    <td width="15%">inicio:<br><div id="inicio"><input type="text" class="textsmall" readonly="readonly" name="inicio"/></div></td>
    <td width="15%">finalización:<br><div id="fin"><input type="text" class="textsmall" readonly="readonly" name="fin"/></div></td>
    <td width="25%">Servicio:<br>
        <select name="servicio" id="servicio" class="text">
        <option value="">-- Seleccione --</option>
        <?php
        //consultar servicios
        $consServicio = mysql_query("SELECT * FROM servicio WHERE idestado_actividad = '1'", $cn);
        while($rowServicio = mysql_fetch_array($consServicio))
        {
        echo '<option value="'.$rowServicio['idservicio'].'">'.$rowServicio['descservicio'].'</option>';
        }
        ?>
        </select>
    </td>
<td>&nbsp;<br><input type="button" name="button" id="button" value="Guardar" onClick="Validar()" /></td>
</tr>
<tr>    
<input type="hidden" name="funcionario" id="funcionario" value="<?php echo $Funcionario ?>" readonly="readonly" />
<input type="hidden" name="grupoEmpleado" id="grupoEmpleado" value="<?php echo $grupoEmpleado ?>" readonly="readonly" />
<input type="hidden" name="sede" id="sede" value="<?php echo $sede ?>" readonly="readonly" />
    <td colspan="3" id="notificacion"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
</table>
</form>
<fieldset>
<legend><h4>Turnos</h4></legend>
<span id="contenido"></span>
</fieldset>
</body>
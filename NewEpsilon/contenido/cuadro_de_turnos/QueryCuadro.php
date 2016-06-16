<?php
	session_start();
	//Conexion a la base de datos
	include('../../dbconexion/conexion.php');
	include('ClassHoras.php');
    include('ClassFuncionario.php');
	//funcion para abrir conexion
	$cn = Conectarse();
	$sede = $_SESSION['sede']; 
	$mes = $_SESSION['mes']; 
	$anio = $_SESSION['anio']; 
	$grupoEmpleado = $_SESSION['grupoEmpleado'];
	$CurrentUser = $_SESSION['CurrentUser'];
	$dias = date('t', mktime(0,0,0, $mes, 1, $anio));
	//dia finalizacion del mes
	$fecha_limite = $anio."-".$mes."-".$dias;
	$LaborablesMes = horas::GetHorasMes($cn, $mes, $anio);
?>
<table border="1" rules="all" width="100%" cellpadding="3">
<tr align="center">
    <td id="table" width="6%" align="center">Funcionario</td>
<?php
//ciclo para incrementar los dias del mes
for($d=1;$d<=$dias; $d=$d+1)
{
    $FechaCuadro = ($anio.'-'.$mes.'-'.$d);
     echo '<td width="2%" align="center" id="table">'. funcionario::DiaSemana($FechaCuadro) .'<br>'. $d .'</td>';
}
    echo '
    <td width="2%" align="center" id="table">Lab</td>
    <td width="2%" align="center" id="table">Asig</td>
    <td width="2%" align="center" id="table">Dif</td>';
?>
</tr>
<?php
	$vector = $_SESSION['array'];
	foreach ($vector as $documento)
	{
       $RegFuncionario = funcionario::GetNombresApellidos($cn, $documento);
    echo
    '<tr>
    <td align="center" id="table">'.ucwords(strtolower($RegFuncionario['apellidos'].' '.$RegFuncionario['nombres'])).'</td>';
    for($d=1;$d<=$dias; $d=$d+1)
    {
        //funcion para conocer a que dia de la semana corresponde la fecha generada
        $wkdy = (((mktime ( 0, 0, 0, $mes, $d, $anio) - mktime ( 0, 0, 0, 7, 17, 2006))/(60*60*24))+700000) % 7;
        //si los dias son menores o iguales a 9 los concateno con cero para obtener una fecha valida y comparable
        if($d>=1 && $d<=9 )
        {
            $fecha = ($anio.$mes.$d);
            $fechaCons = ($anio.'-'.$mes.'-'.'0'.$d);
            //si la vaiable $wkdy es igual a 6 equivale a domingo y se pintara la casilla de otro color
            if($wkdy==6)
            {
                //consultar si hay un turno registrado en la fecha
                $consTurno = mysql_query("SELECT c.alias, t.idturno FROM convencion_cuadro c
INNER JOIN turno_funcionario t ON t.idConvencion = c.id WHERE t.fecha = '$fechaCons' AND t.idfuncionario = '$documento' AND t.idsede = '$sede'", $cn);
                $respTurno = mysql_num_rows($consTurno);
                //$regsTurno = mysql_fetch_array($consTurno);
                if($respTurno>=1)
                {
                    echo '<td align="center" id="table">';?>
					<a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=600, height=300, top=85, left=140'); return false;">
					<?php 
					while($rowTurno = mysql_fetch_array($consTurno))
					{
						echo $rowTurno['alias'].'/';
					}
					echo '</a></td>';
                }
                else
                {
					//consultar si hay novedades registradas
					$sqlNovedad = mysql_query("SELECT t.idtipo_turno, t.idturno, t.idgrupo_empleado, ta.color FROM turno_funcionario t
INNER JOIN tipo_ausentismo ta ON ta.idtipo = t.idtipo_turno WHERE t.idfuncionario = '$documento' AND fecha = '$fechaCons'", $cn);
					$ConNovedad = mysql_num_rows($sqlNovedad);
					//si hay novedad
					if($ConNovedad>=1)
					{
						$regNovedad = mysql_fetch_array($ConNovedad);
						echo '<td align="center" bgcolor="'.$regNovedad['color'].'">'?>
						<a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=600, height=300, top=85, left=140'); return false;">+</a></td>
                    <?php
					}
					else
					{
                    	echo '<td align="center" id="table">' ?>
                        <a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=650, height=300, top=85, left=140'); return false;">+</a></td>
                        <?php
					}
                }
            }
            else
            {
                //consultar si la variable equivale a un dia festivo
                $sqlFecha = mysql_query("SELECT * FROM dia_festivo WHERE fecha_festivo = '$fechaCons'", $cn);
                $conFecha = mysql_num_rows($sqlFecha);
                //si la fecha equivale a festivo aparecera de otro color
                if($conFecha>=1)
                {
                    //consultar si hay un turno registrado en la fecha
                    $consTurno = mysql_query("SELECT c.alias, t.idturno FROM convencion_cuadro c
INNER JOIN turno_funcionario t ON t.idConvencion = c.id WHERE t.fecha = '$fechaCons' AND t.idfuncionario = '$documento' AND t.idsede = '$sede'", $cn);
                    $respTurno = mysql_num_rows($consTurno);
                    //$regsTurno = mysql_fetch_array($consTurno);
                    if($respTurno>=1)
                    {
                        echo '<td align="center" id="table">'?>
                        <a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=650, height=300, top=85, left=140'); return false;">
                        <?php
					while($rowTurno = mysql_fetch_array($consTurno))
					{
						echo $rowTurno['alias'].'/';
					}
					echo '</a></td>';
                    }
                    else
                    {
						//consultar si hay novedades registradas
						$sqlNovedad = mysql_query("SELECT t.idtipo_turno, t.idturno, t.idgrupo_empleado, ta.color FROM turno_funcionario t
	INNER JOIN tipo_ausentismo ta ON ta.idtipo = t.idtipo_turno WHERE t.idfuncionario = '$documento' AND fecha = '$fechaCons'", $cn);
						$ConNovedad = mysql_num_rows($sqlNovedad);
						//si hay novedad
						if($ConNovedad>=1)
						{
							$regNovedad = mysql_fetch_array($ConNovedad);
							echo '<td align="center" bgcolor="'.$regNovedad['color'].'">'?>
                            <a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=650, height=300, top=85, left=140'); return false;">+</a></td>';
                            <?php
						}
						else
						{
                    		echo '<td align="center" id="table">'?>
                            <a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=650, height=300, top=85, left=140'); return false;">+</a></td>
                            <?php
						}
                    }
                }
                else
                {    
                    //consultar si hay un turno registrado en la fecha
                    $consTurno = mysql_query("SELECT c.alias, t.idturno FROM convencion_cuadro c
INNER JOIN turno_funcionario t ON t.idConvencion = c.id WHERE t.fecha = '$fechaCons' AND t.idfuncionario = '$documento' AND t.idsede = '$sede'", $cn);
                    $respTurno = mysql_num_rows($consTurno);
                   // $regsTurno = mysql_fetch_array($consTurno);
                    if($respTurno>=1)
                    {
                        echo '<td align="center">'?>
                        <a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=650, height=300, top=85, left=140'); return false;">
                        <?php
					while($rowTurno = mysql_fetch_array($consTurno))
					{
						echo $rowTurno['alias'].'/';
					}
					echo '</a></td>';	
                    }
                    else
                    {
						//consultar si hay novedades registradas
						$sqlNovedad = mysql_query("SELECT t.idtipo_turno, t.idturno, t.idgrupo_empleado, ta.color FROM turno_funcionario t
	INNER JOIN tipo_ausentismo ta ON ta.idtipo = t.idtipo_turno WHERE t.idfuncionario = '$documento' AND fecha = '$fechaCons'", $cn);
						$ConNovedad = mysql_num_rows($sqlNovedad);
						//si hay novedad
						if($ConNovedad>=1)
						{
							$regNovedad = mysql_fetch_array($sqlNovedad);
							echo '<td align="center" bgcolor="'.$regNovedad['color'].'">'?>
                            <a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=650, height=300, top=85, left=140'); return false;">+</a></td>
                            <?php
						}
						else
						{
                        	echo '<td align="center">'?>
                            <a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=650, height=300, top=85, left=140'); return false;">+</a></td>
                            <?php
						}
                    }
                }
            }
        }
        //si los dias arrojados por el ciclo son mayores a 9 obtienen el valor que les asigna el ciclo
        else
        {
            $fecha = $anio.$mes.$d;
            $fechaCons = ($anio.'-'.$mes.'-'.$d);
            //si la variable $wkdy es igual a 6 equivale a domingo y se pintara la casilla de otro color
            if($wkdy==6)
            {   
                //consultar si hay un turno registrado en la fecha
                $consTurno = mysql_query("SELECT c.alias, t.idturno FROM convencion_cuadro c
INNER JOIN turno_funcionario t ON t.idConvencion = c.id WHERE t.fecha = '$fechaCons' AND t.idfuncionario = '$documento' AND t.idsede = '$sede'", $cn);
                $respTurno = mysql_num_rows($consTurno);
               // $regsTurno = mysql_fetch_array($consTurno);
                if($respTurno>=1)
                {
                    echo '<td align="center" id="table">'?>
                   <a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=650, height=300, top=85, left=140'); return false;">
                   <?php
					while($rowTurno = mysql_fetch_array($consTurno))
					{
						echo $rowTurno['alias'].'/';
					}
					echo '</a></td>';
                }
                else
                {
					//consultar si hay novedades registradas
					$sqlNovedad = mysql_query("SELECT t.idtipo_turno, t.idturno, t.idgrupo_empleado, ta.color FROM turno_funcionario t
INNER JOIN tipo_ausentismo ta ON ta.idtipo = t.idtipo_turno WHERE t.idfuncionario = '$documento' AND fecha = '$fechaCons'", $cn);
					$ConNovedad = mysql_num_rows($sqlNovedad);
					//si hay novedad
					if($ConNovedad>=1)
					{
						$regNovedad = mysql_fetch_array($sqlNovedad);
						echo '<td align="center" bgcolor="'.$regNovedad['color'].'">'?>
                        <a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=650, height=300, top=85, left=140'); return false;">+</a></td>
                        <?php
					}
					else
					{
                    	echo '<td align="center" id="table">'?>
						<a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=600, height=300, top=85, left=140'); return false;">+</a></td>
                        <?php
					}
                }
            }
            //sino el color de fondo sera blanco
            else
            {
                //consultar si la variable equivale a un dia festivo
                $sqlFecha = mysql_query("SELECT * FROM dia_festivo WHERE fecha_festivo = '$fechaCons'", $cn);
                $conFecha = mysql_num_rows($sqlFecha);
                //si la fecha equivale a festivo aparecera de otro color
                if($conFecha>=1)
                {  
                    //consultar si hay un turno registrado en la fecha
                    $consTurno = mysql_query("SELECT c.alias, t.idturno FROM convencion_cuadro c
INNER JOIN turno_funcionario t ON t.idConvencion = c.id WHERE t.fecha = '$fechaCons' AND t.idfuncionario = '$documento' AND t.idsede = '$sede'", $cn);
                    $respTurno = mysql_num_rows($consTurno);
                   // $regsTurno = mysql_fetch_array($consTurno);
                    if($respTurno>=1)
                    {
                        echo '<td align="center" id="table">'?>
						<a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=600, height=300, top=85, left=140'); return false;">
                        <?php
					while($rowTurno = mysql_fetch_array($consTurno))
					{
						echo $rowTurno['alias'].'/';
					}
					echo '</a></td>';
                    }
                    else
                    {
						//consultar si hay novedades registradas
						$sqlNovedad = mysql_query("SELECT t.idtipo_turno, t.idturno, t.idgrupo_empleado, ta.color FROM turno_funcionario t
	INNER JOIN tipo_ausentismo ta ON ta.idtipo = t.idtipo_turno WHERE t.idfuncionario = '$documento' AND fecha = '$fechaCons'", $cn);
						$ConNovedad = mysql_num_rows($sqlNovedad);
						//si hay novedad
						if($ConNovedad>=1)
						{
							$regNovedad = mysql_fetch_array($sqlNovedad);
							echo '<td align="center" bgcolor="'.$regNovedad['color'].'">'?>
                            <a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=650, height=300, top=85, left=140'); return false;">+</a></td>
                            <?php
						}
						else
						{
                        	echo '<td align="center" id="table">'?>
                            <a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=650, height=300, top=85, left=140'); return false;">+</a></td>
                            <?php
						}
                    }
                }
                else
                {
                    //consultar si hay un turno registrado en la fecha
                    $consTurno = mysql_query("SELECT c.alias, t.idturno FROM convencion_cuadro c
INNER JOIN turno_funcionario t ON t.idConvencion = c.id WHERE t.fecha = '$fechaCons' AND t.idfuncionario = '$documento' AND t.idsede = '$sede'", $cn);
                    $respTurno = mysql_num_rows($consTurno);
                  //  $regsTurno = mysql_fetch_array($consTurno);
                    if($respTurno>=1)
                    {
                        echo '<td align="center">'?>
                        <a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=650, height=300, top=85, left=140'); return false;">
                        <?php
					while($rowTurno = mysql_fetch_array($consTurno))
					{
						echo $rowTurno['alias'].'/';
					}
					echo '</a></td>';
                    }
                    else
                    {
						//consultar si hay novedades registradas
						$sqlNovedad = mysql_query("SELECT t.idtipo_turno, t.idturno, t.idgrupo_empleado, ta.color FROM turno_funcionario t
	INNER JOIN tipo_ausentismo ta ON ta.idtipo = t.idtipo_turno WHERE t.idfuncionario = '$documento' AND fecha = '$fechaCons'", $cn);
						$ConNovedad = mysql_num_rows($sqlNovedad);
						//si hay novedad
						if($ConNovedad>=1)
						{
							$regNovedad = mysql_fetch_array($sqlNovedad);
							echo '<td align="center" bgcolor="'.$regNovedad[color].'">'?>
                           <a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=650, height=300, top=85, left=140'); return false;">+</a></td>
                           <?php
						}
						else
						{
                        	echo '<td align="center">'?>
                            <a href="RegistrarTurno.php?Funcionario=<?php echo base64_encode($documento)?>&Fecha=<?php echo base64_encode($fechaCons)?>'&grupoEmpleado=<?php echo base64_encode($grupoEmpleado)?>&sede=<?php echo base64_encode($sede)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=650, height=300, top=85, left=140'); return false;">+</a></td>
                            <?php
						}
                    }
                }
            }
        }
    }
	//consultar cantidad de horas asignadas
	$sqlcont = mysql_query("SELECT SUM(t.diurna + t.diurnafest + t.nocturna + t.nocturnafest) AS asignadas
FROM turno_funcionario t WHERE t.idfuncionario = '$documento' AND t.fecha BETWEEN '$anio-$mes-01' AND '$fecha_limite';", $cn);
	$rescont = mysql_fetch_array($sqlcont);
	echo '<td width="2%" align="center">'. $LaborablesMes .'</td>';
	echo '<td width="2%" align="center">'.$rescont['asignadas'].'</td>';
	echo '<td width="2%" align="center">'.($rescont['asignadas']-($LaborablesMes)).'</td>';
	}
?>
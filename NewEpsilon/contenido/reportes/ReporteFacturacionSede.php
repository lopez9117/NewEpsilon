<?php

ini_set('max_execution_time', 0);
//conexion a la base de datos
include("../../dbconexion/conexion.php");
//include("validateinvoicepayment.php");
$cn = conectarse();
//variables con POST
$desde = base64_decode($_GET['FchDesde']);
$hasta = base64_decode($_GET['FchHasta']);
$erp = base64_decode($_GET['erp']);
//consultar el nombre de la sede para el reporte
$nomsede = mysql_query("SELECT codigo FROM sede WHERE idsede='$erp'", $cn);
$nombresede = mysql_fetch_array($nomsede);
$codigo = $nombresede['codigo'];

//consulta para del  valor del dia del salario minimo

$conminimo = mysql_query("SELECT valor_numero FROM variables_entorno WHERE id_variable='4'", $cn);
$regminimo = mysql_fetch_array($conminimo);
$valorminimo = $regminimo['valor_numero'];


$confluoroscopia = mysql_query("select idestudio from r_estudio where cod_iss in (212330,212331,212332,212333,212334,212335,212336)", $cn);
$VecFluoroscopia = array();
while ($Row = mysql_fetch_array($confluoroscopia)) {
    $VecFluoroscopia[$Row['idestudio']] = $Row['idestudio'];
}

//lineas para exportar a excel
header("Expires: 0");
header('Content-type: application/vnd.ms-excel');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Facturacion " . $desde . '-' . $hasta . ' ' . $codigo . ".xls");
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>.: Reporte de Facturacion :.</title>
</head>
<style type="text/css">
    body {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        font-size: 10px;
    }
</style>
<body>
<table width="100%" border="1" rules="all">
    <tr style="background:#0000AA;color: #FFF;">
        <td><b>CEDULA</b></td>
        <td><b>INGRESO</b></td>
        <td><b>1er NOMBRE</b></td>
        <td><b>2do NOMBRE</b></td>
        <td><b>1er APELLIDO</b></td>
        <td><b>2do APELLIDO</b></td>
        <td><b>EDAD ACTUAL</b></td>
        <td><b>N° CENTRO DE COSTOS</b></td>
        <td><b>CENTRO DE COSTOS</b></td>
        <td><b>SERVICIO</b></td>
        <td><b>ESTUDIO</b></td>
        <td><b>CUPS</b></td>
        <td><b>CODIGO</b></td>
        <td><b>VALOR PLENO</b></td>
        <td><b>VALOR BRUTO</b></td>
        <td><b>COPAGO</b></td>
        <td><b>VALOR A PAGAR</b></td>
        <td><b>EPS</b></td>
        <td><b>TIPO PACIENTE</b></td>
        <td><b>TECNICA</b></td>
        <td><b>LECTURA</b></td>
        <td><b>AGENDADO POR</b></td>
        <td><b>PROGRAMACION</b></td>
        <td><b>REALIZACION</b></td>
        <td><b>FECHA DE APROBACION</b></td>
        <td><b>PUBLICADO POR</b></td>
        <td><b>OBSERVACIONES</b></td>
        <td><b>SEDE</b></td>
        <td><b>LUGAR REALIZACION</b></td>
        <td><b>CANTIDAD</b></td>
        <td><b>TIPO DE DOCUMENTO</b></td>
    </tr>
    <?php
    include("validateinvoicepayment.php");
    if ($erp == 46) {
        $erpb = '(18, 24, 42, 21, 19, 23, 22, 20)';
    } elseif ($erp == 51) {
        $erpb = '(17,33)';
    } else {
        $erpb = '(' . $erp . ')';
    }

    //consultar la cantidad de estudios realizados en cada sede con lectura
    $ConTotal = mysql_query("SELECT DISTINCT(i.id_informe),i.id_estadoinforme FROM r_informe_header i LEFT JOIN r_log_informe l ON i.id_informe = l.id_informe
WHERE i.erp IN $erpb AND l.fecha BETWEEN '$desde' AND '$hasta' AND (l.id_estadoinforme = '8' OR l.id_estadoinforme = '10')", $cn);


    //consultar la cantidad de estudios realizados en cada sede con sin lectura
    //$SinLectura = mysql_query("SELECT DISTINCT i.id_informe FROM r_informe_header i LEFT JOIN r_log_informe l ON i.id_informe = l.id_informe
    //WHERE i.erp IN $erpb AND l.fecha BETWEEN '$desde' AND '$hasta' AND i.id_estadoinforme = '10'", $cn);

    //Consultar Informacion del portatil
    $conportatil = mysql_query("SELECT * FROM r_estudio WHERE idestudio='63'", $cn);
    $RegPortatil = mysql_fetch_array($conportatil);

    //Consulta de comparativas
    $conComparativa = mysql_query("SELECT * FROM r_estudio WHERE idestudio='21'", $cn);
    $RegComparativa = mysql_fetch_array($conComparativa);

    //CONSULTA DE PROYECCIONES
    $conProyeccion = mysql_query("SELECT * FROM r_estudio WHERE idestudio='1108'", $cn);
    $RegProyeccion = mysql_fetch_array($conProyeccion);

    //CONSULTA DE ESPACIOS ADICIONALES
    $conEspacios = mysql_query("SELECT * FROM r_estudio WHERE idestudio='870'", $cn);
    $RegEspacios = mysql_fetch_array($conEspacios);

    //Consulta de reconstruccion 3d
    $conreconstruccion = mysql_query("SELECT * FROM r_estudio WHERE idestudio='878'", $cn);
    $Regreconstruccion = mysql_fetch_array($conreconstruccion);

    //Consulta de reconstruccion 3d
    $confluoro = mysql_query("SELECT * FROM r_estudio WHERE idestudio='915'", $cn);
    $Regfluoro = mysql_fetch_array($confluoro);


    //validar cantidades de informes con y sin lectura
    $contConTotal = mysql_num_rows($ConTotal);
    //    $contSinLectura = mysql_num_rows($SinLectura);
    //imprimir filas de archivos con lectura
    if ($contConTotal >= 1) {
        while ($row = mysql_fetch_array($ConTotal)) {
            $idInforme = $row['id_informe'];
            $query = '';
            $query = "SELECT DISTINCT(i.id_informe), i.portatil,i.orden, i.hora_solicitud, i.fecha_solicitud, i.ubicacion, i.orden,i.idservicio,i.idestudio,
	                                	ser.descservicio, p.id_paciente,p.edad, p.nom1, p.nom2, p.ape1, p.ape2,se.idsede,i.erp,se.descsede, est.nom_estudio,eps.ideps,eps.desc_eps,
		                                tec.id_tecnica,tec.desc_tecnica, tp.desctipo_paciente, i.id_estadoinforme,est.idestudio,est.cod_iss,est.val_iss,est.val_soat,est.cod_soat,
		                                rif.guia,rif.bilateral,rif.eco_biopsia,est.idservicio,est.cups_iss,est.uvr,rif.copago,rif.comparativa,rif.proyeccion,rif.espacios_tomografia,rif.reconstruccion,
		                                peso_paciente,i.idtipo_paciente,
		                                ser.idCentroCostos,ccc.descCentroCostos,i.id_estadoinforme,est.typebiopsiadrenaje,ptd.cod_documento,
		                                (select descsede from sede where idsede=i.idsede)as sede,
		                                (select descsede from sede where idsede=i.lugar_realizacion) as realizacion
		                                FROM r_informe_header i
		                                INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
		                                INNER JOIN servicio ser ON ser.idservicio = i.idservicio
		                                LEFT JOIN c_centro_costos ccc ON ccc.idCentroCostos = ser.idCentroCostos
		                                INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
		                                INNER JOIN tipo_documento ptd ON p.idtipo_documento = ptd.idtipo_documento
		                                INNER JOIN sede se ON se.idsede = i.idsede
		                                INNER JOIN r_estudio est ON est.idestudio = i.idestudio
		                                INNER JOIN eps eps ON eps.ideps = p.ideps
		                                INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
		                                LEFT JOIN r_informe_facturacion rif ON i.id_informe=rif.id_informe
		                                WHERE i.id_informe = '$idInforme'";

            $SqlInforme = mysql_query($query, $cn);
            $RegInforme = mysql_fetch_array($SqlInforme);

            //query para consultar la edad actual de el paciente
            $estadoinforme = $row['id_estadoinforme'];
            $lectura = '';
            $lecturanum = '';
            if ($estadoinforme == 10) {
                $lectura = 'NO';
                $lecturanum = '2';
            } else {
                $lectura = 'SI';
                $lecturanum = '1';
            }

            $conagenda = mysql_query("SELECT l.fecha, l.hora, f.nombres, f.apellidos
					FROM r_log_informe l
                    INNER JOIN funcionario f ON f.idfuncionario = l.idfuncionario
                    WHERE l.id_informe = '$idInforme' AND l.id_estadoinforme = '1'", $cn);
            $regAgenda = mysql_fetch_array($conagenda);

            $conToma = mysql_query("SELECT  l.fecha, l.hora,f.nombres,f.apellidos
                    FROM r_informe_header i
                    INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
                    INNER JOIN funcionario f ON f.idfuncionario = l.idfuncionario
                    WHERE i.id_informe = '$idInforme' AND l.id_estadoinforme IN(2,10)", $cn);
            $regToma = mysql_fetch_array($conToma);

            if ($estadoinforme == 8) {
                $conLee = mysql_query("SELECT l.fecha, l.hora, f.nombres, f.apellidos
				FROM r_informe_header i
                    INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
                    INNER JOIN funcionario f ON f.idfuncionario = l.idfuncionario
                    WHERE l.id_informe = '$idInforme' AND l.id_estadoinforme = '3'", $cn);
                $regLee = mysql_fetch_array($conLee);

                $conPublica = mysql_query("SELECT l.fecha, l.hora, f.nombres, f.apellidos
				FROM r_log_informe l
                    INNER JOIN funcionario f ON f.idfuncionario = l.idfuncionario
                    WHERE l.id_informe = '$idInforme' AND l.id_estadoinforme = '8'", $cn);
                $regPublica = mysql_fetch_array($conPublica);
            }

            //consultar detalles del log
            $consDetalles = mysql_query("SELECT DISTINCT(l.id_estadoinforme), l.fecha, l.hora, CONCAT(f.nombres,' ',f.apellidos) AS funcionario FROM r_log_informe l
		INNER JOIN funcionario f ON f.idfuncionario = l.idfuncionario
		WHERE l.id_informe = '$idInforme' AND l.id_estadoinforme BETWEEN '1' AND '8' GROUP BY l.id_estadoinforme ORDER BY l.id_estadoinforme ASC limit 4,1", $cn);
            echo
                '<tr>
                    <td>' . $RegInforme['id_paciente'] . '</td>
		            <td>' . $RegInforme['orden'] . '</td>
		            <td>' . $RegInforme['nom1'] . '</td>
		            <td>' . $RegInforme['nom2'] . '</td>
		            <td>' . $RegInforme['ape1'] . '</td>
		            <td>' . $RegInforme['ape2'] . '</td>
	                <td>' . $RegInforme['edad'] . '</td>
	                <td>' . $RegInforme['idCentroCostos'] . '</td>
	                <td>' . $RegInforme['descCentroCostos'] . '</td>
		            <td>' . validateservicioaval($RegInforme['idservicio'], $RegInforme['idestudio'], $RegInforme['erp']) . '</td>
		            <td>' . $RegInforme['nom_estudio'] . '</td>
		            <td>' . validatecodigoiss($RegInforme['cups_iss'], '2') . '</td>';
            if ($RegInforme['idservicio'] == 10 && $RegInforme['id_tecnica'] == 3) {
                echo '<td>313322</td>';
            } else {
                echo '<td>' . validatesoatiss($RegInforme, $valorminimo, $RegInforme['erp'], 'codigo') . '</td>';
            }
            echo
                '<td>' . round(validateuvr(validatesoatiss($RegInforme, $valorminimo, $RegInforme['erp'], 'val'), $RegInforme['uvr'])) . '</td>';
            $val = validatepayment($RegInforme, $lecturanum, 'valor', $cn);
            $copago = $RegInforme['copago'];
            if ($copago == null || $copago == "") {
                $copago = 0;
            }
            $valpagar = $val - $copago;
            echo
                '<td>' . round($val) . '</td>
                    <td>' . round($copago) . '</td>
                    <td>' . round($valpagar) . '</td>
                    <td>' . $RegInforme['desc_eps'] . '</td>
                    <td>' . $RegInforme['desctipo_paciente'] . '</td>
                    <td>' . $RegInforme['desc_tecnica'] . '</td>
                    <td>' . $lectura . '</td>
                    <td>' . $regAgenda['nombres'] . '&nbsp;' . $regAgenda['apellidos'] . '</td>
			        <td>' . $regAgenda['fecha'] . '</td>
			        <td>' . $regToma['fecha'] . ' ' . $regToma['hora'] . '</td>';

            //imprimir resultados dentro de un ciclo
            echo '<td>';
            if ($estadoinforme == 8) {
                while ($rowDetalles = mysql_fetch_array($consDetalles)) {
                    $fecha = ($rowDetalles['fecha'] . '/' . $rowDetalles['hora']);
                    echo $rowDetalles['fecha'];
                }
            } else {
                echo '';
            }
            echo '</td>';
            if ($estadoinforme == 8) {
                echo '<td>' . $regPublica['nombres'] . '&nbsp;' . $regPublica['apellidos'] . '</td>';
            } else {
                echo '<td>' . '&nbsp' . '</td>';
            }
//impriimr todas las observaciones realizadas en el proceso
            $sqlObservaciones = mysql_query("SELECT o.observacion, f.nombres, f.apellidos FROM r_observacion_informe o INNER JOIN funcionario f ON f.idfuncionario = o. idfuncionario WHERE o.id_informe = '$idInforme'", $cn);
            echo '<td>';
            while ($rowObservaciones = mysql_fetch_array($sqlObservaciones)) {
                echo $rowObservaciones['nombres'] . '&nbsp;' . $rowObservaciones['apellidos'] . ' : ' . $rowObservaciones['observacion'] . ' // ';
            }
            echo '</td>';
            echo '<td>' . $RegInforme['sede'] . '</td>
                  <td>' . $RegInforme['realizacion'] . '</td>
                  <td>1</td>
                  <td>' . $RegInforme['cod_documento'] . '</td>';

            echo '</tr>';
            if ($RegInforme['portatil'] == 1 || $RegInforme['comparativa'] == 1 || $RegInforme['proyeccion'] > 0 ||
                $RegInforme['espacios_tomografia'] >= 1 || $RegInforme['reconstruccion'] == 1 ||
                $RegInforme['bilateral'] == 1 || $RegInforme['guia'] != 0 || $RegInforme['eco_biopsia'] != 0 ||
                $RegInforme['idestudio'] = $VecFluoroscopia[$RegInforme['idestudio']]
            ) {
                if ($RegInforme['portatil'] == 1) {
                    $valportatil = round(validatepayment($RegInforme, $lecturanum, 'portatil', $cn));
                    echo agregaradicionales($RegInforme['portatil'], $RegInforme, $regAgenda, $regToma, $RegPortatil, $valportatil, $valorminimo, $erp);
                }
                if ($RegInforme['comparativa'] == 1) {
                    $valcomparativa = round(validatepayment($RegInforme, $lecturanum, 'comparativa', $cn));
                    echo agregaradicionales($RegInforme['comparativa'], $RegInforme, $regAgenda, $regToma, $RegComparativa, $valcomparativa, $valorminimo, $erp);
                }
                if ($RegInforme['proyeccion'] > 0) {
                    $valproyeccion = round(validatepayment($RegInforme, $lecturanum, 'proyeccion', $cn));
                    echo agregaradicionales($RegInforme['proyeccion'], $RegInforme, $regAgenda, $regToma, $RegProyeccion, $valproyeccion, $valorminimo, $erp);
                }
                if ($RegInforme['espacios_tomografia'] >= 1) {
                    $valespacios = round(validatepayment($RegInforme, $lecturanum, 'espacios', $cn));
                    echo agregaradicionales($RegInforme['espacios_tomografia'], $RegInforme, $regAgenda, $regToma, $RegEspacios, $valespacios, $valorminimo, $erp);
                }
                if ($RegInforme['reconstruccion'] == 1) {
                    $valreconstruccion = round(validatepayment($RegInforme, $lecturanum, 'reconstruccion', $cn));
                    echo agregaradicionales($RegInforme['reconstruccion'], $RegInforme, $regAgenda, $regToma, $Regreconstruccion, $valreconstruccion, $valorminimo, $erp);
                }
                if ($RegInforme['bilateral'] == 1) {
                    $valbilateral = round($val);
                    echo agregaradicionales($RegInforme['bilateral'], $RegInforme, $regAgenda, $regToma, $RegInforme, $valreconstruccion, $valorminimo, $erp);
                }
                if ($RegInforme['guia'] != 0) {
                    $idguia = $RegInforme['guia'];
                    $conguia = mysql_query("SELECT * FROM r_estudio WHERE idestudio='$idguia'", $cn);
                    $RegGuia = mysql_fetch_array($conguia);
                    $valGuia = 9999;
//                    $valGuia = round(validatepayment($RegInforme, '1', 'reconstruccion', $cn));
                    echo agregaradicionales(1, $RegInforme, $regAgenda, $regToma, $RegGuia, $valGuia, $valorminimo, $erp);
                }
                if ($RegInforme['eco_biopsia'] != 0) {
                    $idprocedimiento = $RegInforme['eco_biopsia'];
                    $conProcedimiento = mysql_query("SELECT * FROM r_estudio WHERE idestudio='$idprocedimiento'", $cn);
                    $regProcedimiento = mysql_fetch_array($conProcedimiento);

                    $valProcedimiento = $regProcedimiento['val_iss'];//round(validatepayment($RegInforme, '1', 'reconstruccion', $cn));
                    echo agregaradicionales(1, $RegInforme, $regAgenda, $regToma, $regProcedimiento, $valProcedimiento, $valorminimo, $erp);
                }
                if ($RegInforme['idestudio'] = $VecFluoroscopia[$RegInforme['idestudio']]) {
                    $valfluoro = 87;
                    echo agregaradicionales(1, $RegInforme, $regAgenda, $regToma, $Regfluoro, $valfluoro, $valorminimo, $erp);
                }
            }
        }
    }

    function validateservicioaval($servicio, $idestudio, $idsede)
    {
        $servicioreturn = '';
        if ($servicio == 1) {
            $servicioreturn = 'Rayos X Convencional';
        } elseif ($servicio == 2) {
            if ($idsede == 17 || $idsede == 33) {
                $servicioreturn = 'Tomograf&iacute;a';
            } else {
                $servicioreturn = 'Tomografia';
            }

        } elseif ($servicio == 3) {
            if ($idsede == 3) {
                if ($idestudio == 942 || $idestudio == 954 || $idestudio == 955 || $idestudio == 958)//|| $idestudio == 953
                {
                    $servicioreturn = 'Ecografia Ginecologica';
                } else {
                    $servicioreturn = 'Ecografias Generales';
                }
            } elseif ($idsede == 9) {
                if ($idestudio == 942 || $idestudio == 954 || $idestudio == 955 || $idestudio == 958 || $idestudio == 953)//
                {
                    $servicioreturn = 'Ecografia Ginecologica';
                } else {
                    $servicioreturn = 'Ecografias Generales';
                }
            } elseif ($idsede == 1) {
                if ($idestudio == 954 || $idestudio == 955 || $idestudio == 958 || $idestudio == 953)//
                {
                    $servicioreturn = 'Ecografia Ginecologica';
                } else {
                    $servicioreturn = 'Ecografias Generales';
                }
            } elseif ($idsede == 17 || $idsede == 33) {
                $servicioreturn = 'Ecograf&iacute;as Generales';
            } else {
                $servicioreturn = 'Ecografias Generales';
            }
        } elseif ($servicio == 4) {
            if ($idsede == 3) {
                $servicioreturn = 'Estudios Especiales Radiologia';
            } else {
                $servicioreturn = 'Estudios Especiales';
            }
        } elseif ($servicio == 5 || $servicio == 23) {
            $servicioreturn = 'Prodiagnostico(Hemodinamia Vascular)';
        } elseif ($servicio == 7) {
            if ($idsede == 3) {
                $servicioreturn = 'Biopsias (Procedimiento de Intervencion)';
            } else {
                $servicioreturn = 'Biopsias y Drenaje';
            }
        } elseif ($servicio == 8) {
            if ($idsede == 9) {
                $servicioreturn = 'Endoscopias';
            } else {
                $servicioreturn = 'Unidad de Gastro';
            }
        } elseif ($servicio == 10) {
            if ($idsede == 3) {
                $servicioreturn = 'Resonancia magnetica';
            } else {
                $servicioreturn = 'Resonancia';
            }
        } elseif ($servicio == 51) {
            if ($idsede == 1) {
                $servicioreturn = 'Estudios Vasculares no invasivos';
            } elseif ($idsede == 17 || $idsede == 51) {
                $servicioreturn = 'Ecograf&iacute;as Doppler';
            } else {
                $servicioreturn = 'Ecografía Doppler';
            }
        } elseif ($servicio == 20) {
            if ($idsede) {
                $servicioreturn = 'Estudios Especiales Radiologia';
            } else {
                $servicioreturn = 'Mamografia';
            }
        } elseif ($servicio == 52) {
            $servicioreturn = 'Estudios Vasculares no Invasivos';
        }
        return $servicioreturn;
    }

    function validatesoatiss($reginforme, $minimodia, $erp, $type)
    {
        $codigoreturn = '';
        $valreturn = 0;

        if ($erp == 31 || $erp == 17 || $erp == 33 || $erp == 47) {
            $codigoreturn = $reginforme['cod_soat'];
            $valreturn = ($minimodia * ($reginforme['val_soat'] / 30));
        } else {
            $codigoreturn = $reginforme['cod_iss'];
            $valreturn = $reginforme['val_iss'];
        }
        if ($type == 'codigo') {
            return $codigoreturn;

        } elseif ($type == 'val') {
            return $valreturn;
        }
    }

    function agregaradicionales($type, $RegInforme, $regAgenda, $regToma, $information, $valor, $minimo, $erp)
    {
        $stringreturn = '';
        for ($i = 0; $i < $type; $i++) {
            $stringreturn .= '<tr>
                       <td>' . $RegInforme['id_paciente'] . '</td>
		               <td>' . $RegInforme['orden'] . '</td>
		               <td>' . $RegInforme['nom1'] . '</td>
		               <td>' . $RegInforme['nom2'] . '</td>
		               <td>' . $RegInforme['ape1'] . '</td>
		               <td>' . $RegInforme['ape2'] . '</td>
		               <td>' . $RegInforme['edad'] . '</td>
	                   <td>' . $RegInforme['idCentroCostos'] . '</td>
	                   <td>' . $RegInforme['descCentroCostos'] . '</td>
		               <td>' . validateservicioaval($RegInforme['idservicio'], $RegInforme['idestudio'], $RegInforme['idsede']) . '</td>
                       <td>' . $information['nom_estudio'] . '</td>
                       <td>' . $information['cups_iss'] . '</td>
                       <td>' . validatesoatiss($information, $minimo, $RegInforme['erp'], 'codigo') . '</td>
                       <td>' . validateuvr(round(validatesoatiss($information, $minimo, $RegInforme['erp'], 'val')), $information['uvr']) . '</td>
                       <td>' . $valor . '</td>
                       <td>0</td>
                       <td>' . $valor . '</td>
                       <td>' . $RegInforme['desc_eps'] . '</td>
                       <td>' . $RegInforme['desctipo_paciente'] . '</td>
                       <td>' . $RegInforme['desc_tecnica'] . '</td>
                       <td>&nbsp;</td>
                       <td>' . $regAgenda['nombres'] . '&nbsp;' . $regAgenda['apellidos'] . '</td>
			           <td>' . $regAgenda['fecha'] . '</td>
			           <td>' . $regToma['fecha'] . '</td>
			           <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td>' . $RegInforme['sede'] . '</td>
                       <td>' . $RegInforme['realizacion'] . '</td>
                       <td>0</td>
                       <td>' . $RegInforme['cod_documento'] . '</td>
                       </tr>';
        }
        return $stringreturn;
    }

    ?>
</table>
</body>
</html>
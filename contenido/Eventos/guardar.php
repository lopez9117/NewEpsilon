<?php
session_start();
//registrar la sede y el usuario seleccionados en una variable de sesion permanente
$user = base64_decode($_SESSION['usuario_encuestas']);
//conexion a base de datos
require_once('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
   $NCP = $_POST['NCP']; 
   $NCE = $_POST['NCE'];
   $NCI = $_POST['NCI']; 
   $DATE = $_POST['DATE'];
   $MES = $_POST['MES']; 
   $DATE1 = $_POST['DATE1']; 
   $DOC = $_POST['DOC'];
   $NOM = $_POST['NOM'];
   $EPS = $_POST['EPS'];
   $select = $_POST['select']; 
   $textarea = $_POST['textarea']; 
   $select1 = $_POST['select1']; 
   $select2 = $_POST['select2'];
   $TEVEN = $_POST['TEVEN'];
   $select3 = $_POST['select3'];
   $textarea1 = $_POST['textarea1'];
   $textarea2 = $_POST['textarea2'];
   $textarea3 = $_POST['textarea3'];
   $DATE2 = $_POST['DATE2'];
   $RESPOACCION = $_POST['RESPOACCION'];
   $IMPLIC = $_POST['IMPLIC'];
   $textarea4 = $_POST['textarea4'];
   $REINCI = $_POST['REINCI'];
   $textarea6 = $_POST['textarea6'];
   $textarea5 = $_POST['textarea5'];
   $select4 = $_POST['select4'];
   $select5 = $_POST['select5'];
   $textarea7 = $_POST['textarea7'];
   $DATE3 = $_POST['DATE3'];
   $COSTA = $_POST['COSTA'];

$query = "INSERT INTO evento_adverso
         (n_caidas,n_caidas_adverso,n_caidas_incidente,fecha_reporte,mes_reporte,fecha_ocurrencia,documento,nombre,eps_del_paciente,descrip_caso,tipo_evento,resp_personal,accion_realizada,plan_mejora,fecha_compromiso,responsable_accion,implicados,seguimiento,reincidencia,analisis_causal,accion_insegura,observaciones,fecha_seguimiento,costo_adicional,id_lugar_ocurrencia,id_nombre_evento,id_servicio,id_clasificacion_inc,id_clasificacion_fin,id_estado)
		 VALUES('" . $NCP . "','" . $NCE . "','" . $NCI . "','" . $DATE . "','" . $MES . "','" . $DATE1 . "','" . $DOC . "','" . $NOM . "','" . $EPS . "','" . $textarea . "','" . $TEVEN . "','" . $textarea1 . "','" . $textarea2 . "','" . $textarea3 . "','" 
		     . $DATE2 . "','" . $RESPOACCION . "','" . $IMPLIC . "','" . $textarea4 . "','" 
		     . $REINCI. "','" . $textarea6 . "','" . $textarea5 . "','" . $textarea7 . "','" 
		     . $DATE3 . "','" . $COSTA . "','" . $select . "','" . $select1 . "','" . $select2 . "','" . $select3 . "','" . $select4 . "','" . $select5 . "')";

    mysql_query($query);
   
    header("location:mostrar.php");


?>
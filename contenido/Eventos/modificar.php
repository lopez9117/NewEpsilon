<?php
include('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
   $NCP = $_POST['n_caidas']; 
   $NCE = $_POST['n_caidas_adverso'];
   $NCI = $_POST['n_caidas_incidente']; 
   $DATE = $_POST['fecha_reporte'];
   $MES = $_POST['mes_reporte']; 
   $DATE1 = $_POST['fecha_ocurrencia']; 
   $DOC = $_POST['documento'];
   $NOM = $_POST['nombre'];
   $EPS = $_POST['eps_del_paciente']; 
   $textarea = $_POST['descrip_caso']; 
   $TEVEN = $_POST['tipo_evento'];
   $textarea1 = $_POST['resp_personal'];
   $textarea2 = $_POST['accion_realizada'];
   $textarea3 = $_POST['plan_mejora'];
   $DATE2 = $_POST['fecha_compromiso'];
   $RESPOACCION = $_POST['responsable_accion'];
   $IMPLIC = $_POST['implicados'];
   $textarea4 = $_POST['seguimiento'];
   $REINCI = $_POST['reincidencia'];
   $textarea6 = $_POST['analisis_causal'];
   $textarea5 = $_POST['accion_insegura'];
   $textarea7 = $_POST['observaciones'];
   $DATE3 = $_POST['fecha_seguimiento'];
   $COSTA = $_POST['costo_adicional'];
   $id=$_POST['id'];


 $query= "UPDATE evento_adverso SET n_caidas='$NCP', n_caidas_adverso='$NCE', n_caidas_incidente='$NCI', fecha_reporte='$DATE', mes_reporte = '$MES', fecha_ocurrencia = '$DATE1', documento = '$DOC', nombre = '$NOM', eps_del_paciente = '$EPS', descrip_caso = '$textarea', tipo_evento = '$TEVEN', resp_personal = '$textarea1',accion_realizada='$textarea2',plan_mejora='$textarea3',fecha_compromiso='$DATE2',responsable_accion='$RESPOACCION',implicados='$IMPLIC',seguimiento='$textarea4',reincidencia='$REINCI',analisis_causal='$textarea6',accion_insegura='$textarea5',observaciones='$textarea7',fecha_seguimiento='$DATE3',costo_adicional='$COSTA' WHERE idevento_adverso = '$id'";

  


 mysql_query($query);
   
    header("location:mostrar.php");

?>

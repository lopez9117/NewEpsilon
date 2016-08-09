<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script src="../../js/jquery-1.7.1.js"></script>
<script src="../../js/ui/jquery.ui.core.js"></script>
<script src="../../js/ui/jquery.ui.widget.js"></script>
<script src="../../js/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.dataTables.js"></script>
<link href="../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<link href="../../js/lib/base.css" rel="stylesheet" type="text/css">
<script>
function VerProduccion()
{
	var FechaDesde, FechaHasta;
	FechaDesde = document.Produccion.FechaDesde.value;
	FechaHasta = document.Produccion.FechaHasta.value;
	if(FechaDesde == "" || FechaHasta == "")
	{
		alert("Campos Vacios");
	}
	else
	{
		$(document).ready(function(){
		verlistado()
			//CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
		})
		function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
			  var randomnumber=Math.random()*11;
			$.post("ListadoEspecialistas.php?FechaDesde="+FechaDesde+"&FechaHasta="+FechaHasta+"", {
				randomnumber:randomnumber
			}, function(data){
			  $("#contenido").html(data);
			});
		}
	}
}
</script>
<link type="text/css" href="../../css/demo_table.css" rel="stylesheet" />
<link href="../../css/default.css" rel="stylesheet" type="text/css">
<link href="../../css/forms.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>
<body>
 <form name="Produccion" id="Produccion" method="post" action="#">
<table width="100%" border="0">
<tr><td align="center" valign="middle">
	<div class="marco">
	<div class="ruta">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; <a href="main_menu_reportes.php">Reportes</a></span>
	    <span class="class_cargo" style="font-size:14px">&gt; Producci&oacute;n por Especialista</span></div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br></td>
	</tr>
	<tr>
	<td valign="top" align="center" bgcolor="#DEDEDE">
		<table width="99%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#E6E9EC" bgcolor="#DEDEDE"><tr>
		  <td width="100%" height="8" align="center" background="">
          <table width="100%" border="0">
		  <tr>
		    <td height="19"><table width="95%" border="0" align="center">
		      <tr>
		        <td width="15%">Desde:<br>
                  <input name="FechaDesde" type="text" id="FechaDesde" onclick="document.getElementById('boton').disabled=false;" />*
            <script>

			$( "#FechaDesde" ).datepicker({
				changeMonth: true,
				changeYear: true,
				showOtherMonths: true,
				selectOtherMonths: true,
			});
		</script></td>
		        <td width="15%">Hasta:<br>
                  <label for="FechaHasta"></label>
                  <input type="text" name="FechaHasta" id="FechaHasta" onclick="document.getElementById('boton').disabled=false;"" />*
                  <script>
			$( "#FechaHasta" ).datepicker({
				changeMonth: true,
				changeYear: true,
				showOtherMonths: true,
				selectOtherMonths: true,
			});
		</script>
        </td>
        <td><br><input type="button" value="Consultar" class="ui-button" id="boton"  onclick="VerProduccion();this.disabled='disabled'"/></td>
		        </tr>
                <tr>
                <td colspan="3"><div id="contenido"></div></td>
                </tr>
		      </table></td>
		    </tr>
		  </table></td></tr></table></td>
	</tr>
	</table>
	<br>
	</div>
</td></tr>
</table>
</form>
</body>
</html>
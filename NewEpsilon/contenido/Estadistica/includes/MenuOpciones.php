<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Graficos</title>
<link rel="StyleSheet" href="../css/dtree.css" type="text/css" />
	<script type="text/javascript" src="../js/dtree.js"></script>
</head>

<body leftMargin='20'>

<div class="dtree">
	<script type="text/javascript">
		<!--
		//id, pid, name, url, title, target, icon, iconOPne, open,

		d = new dTree('d');
		d.config.target="main";		
		d.config.folderLinks = false;
		
// ----------------- INTRODUCTION ------------------//
		d.add(0,-1,'<B>Estadisticas</B>','','Estadisticas');
		d.add(1,0,'Sistemas de información','','Sistemas de información','','','',true);
		d.add(100,1,'Consolidado de solicitudes','Totales.php','Ver acumulado de solicitudes por sedes');
		d.add(108,1,'Satisfacción cliente Interno','SatisfaccionSistemas.php', 'Ver la satisfacción del cliente interno');
		d.add(101,1,'Oportunidad','SysReq.html', 'Ver oportunidad en atender solicitudes');
		/*d.add(102,1,'Installation','Installation.html');*/
		
		document.write(d);

		//-->
	</script>
	<p><a href="javascript: d.openAll();">Expandir</a> | <a href="javascript: d.closeAll();">Contraer</a></p>
</div>
</body>
</html>
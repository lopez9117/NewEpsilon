<?php
	session_start();
		
	unset($_SESSION[usuario]);
	unset($_SESSION[sede]); 
	
	echo '<script language="javascript">
		parent.parent.window.close();
	</script>';
?>
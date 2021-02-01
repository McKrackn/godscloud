<?php
if ($_SESSION['rolle']=='REG') {
	$_SESSION['message']="Bereits eingeloggt, keine Notwendigkeit hier zu sein!";
	header("Location:index.php"); 
}
?>
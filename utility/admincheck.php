<?php if ($_SESSION['rolle'] != 'ADM') {
	$_SESSION['message']="Zutritt nur für Admins!";
	$_SESSION["messagetype"]="danger";
	header("Location:index.php"); 
}
//echo '<img src="page_pics/adminarea.png" alt="AdminArea" class="adminarea">';
?>
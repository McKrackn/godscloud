<?php if ($_SESSION["rolle"] != "REG" && $_SESSION["rolle"] != "ADM") {
  $_SESSION["message"] = "Sie haben hier nichts zu suchen!";
  header("Location:index.php"); 
	return;
}
?>
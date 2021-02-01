<?php

	if(isset($_POST['login'])) {

	//Überprüfen auf IP-Ban wegen zu vielen Loginversuchen:
		$failcount=$db->getFails($_SERVER["REMOTE_ADDR"]);

	if ($failcount >= 5) {
		$_SESSION["message"] = "Zu viele Fehlversuche! Jesus ist traurig, bitte kontaktieren Sie ihn entweder persönlich oder den Administrator, um Buße zu tun.";
		$_SESSION["messagetype"]="danger";
		$_SESSION["rolle"] = "CON";
		header("Location:index.php"); 
		return;
	} else {
		$_SESSION["actuser"] = $db->getUserInfo($_POST["username"], md5($_POST["psw"]));
	}

	//Login erfolgreich:
	if (isset($_SESSION["actuser"]) && $_SESSION["actuser"]->getRolle() != 'CON') {
		$_SESSION["logusername"] = $_SESSION["actuser"]->getUsername();
		$_SESSION["rolle"] = $_SESSION["actuser"]->getRolle();
		$_SESSION["message"] = "LogIn erfolgreich, gebenedeit seist du, " . $_SESSION["actuser"]->getUsername() . " - der Himmel wartet!";
		$db->logAction($_SESSION["logusername"], 'Login', $_SESSION["rolle"], 0, 0, $_SERVER["REMOTE_ADDR"]);

	//Login eines gesperrten Users:
	} elseif (isset($_SESSION["actuser"]) && $_SESSION["actuser"]->getRolle() == 'CON') {
		$_SESSION["logusername"] = $_SESSION["actuser"]->getUsername();
		$_SESSION["rolle"] = $_SESSION["actuser"]->getRolle();
		$_SESSION["message"] = "Der User " . $_SESSION["actuser"]->getUsername() . " ist gesperrt. Bitte wenden Sie sich an den Administrator oder Ihre regionale Gottheit.";
		$_SESSION["messagetype"]="danger";
		$db->logAction($_SESSION["logusername"], 'Login', $_SESSION["rolle"], 0, 0, $_SERVER["REMOTE_ADDR"]);
		header("Location:index.php?type=con"); 
		return;

	//fehlgeschlagener Login:
	} elseif (!isset($_SESSION["actuser"])) {
		$_SESSION["message"] = "Falscher Username und/oder Passwort!";
		$_SESSION["messagetype"]="warning";
		if ($failcount==4) {
			$_SESSION["message"] .= " Vorsicht!!!";
			$_SESSION["messagetype"]="warning";
		}
		$db->logAction($_SESSION["logusername"], 'FAILEDLogin', $_POST["username"], 0, 0, $_SERVER["REMOTE_ADDR"]);

	//keine der Optionen, sollte nicht passieren:
	} else {
		$_SESSION["message"] = "Hier sollte niemand sein. Du nicht, und ich eigentlich auch nicht. Darum geh weg, damit ich diesen merkwürdigen Ort auch verlassen kann.";
		$_SESSION["messagetype"]="info";
	}
	header("Location:index.php"); 
	return;
}
?>
<blockquote class="rounded-pill blockquote text-right h3">
	Es gibt keine größere Liebe, als wenn einer sein Leben für seine Freunde hingibt.
  <footer class="blockquote-footer text-monospace">Johannes 15:13 </footer>
</blockquote>

<div class="jumbotron content">
<div class="contentborder">
<p class="small font-weight-bold text-right text-monospace">keine Sorge, in diesen Himmel dürfen auch Erwachsene.</p>
		<img src="page_pics/gate2heaven.jpg" class="contentpic"> 
			<form style="display:grid" method="POST">
				<div class="form-group">
       		        <label class="control-label" for="username"><b>Username</b></label>
                	<input type="text" autocomplete="username" placeholder="Username eingeben" name="username" class="form-control" value="" required>
				</div>
				<div class="form-group">
                	<label class="control-label" for="psw"><b>Password</b></label>
               		<input type="password" autocomplete="new-password" placeholder="Password eingeben" style="margin-bottom:0px;" class="form-control" name="psw" required>
				</div>
				<div class="form-group">
					<footer style="font-size: x-small" class="text-right alert-link text-dark"><a href="<?php $_SERVER['PHP_SELF'] ?>?type=resetpwd">Passwort vergessen?</a></footer>
					<br><button class="btn btn-dark btn-block" type="submit" name="login" value="login"><h4>Login</h4></button>
</div>
			</form> 
		</div>
</div>
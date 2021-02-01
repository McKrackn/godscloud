<?php
include 'utility/guestcheck.php';
include 'config/dbaccess.php';
if(isset($_POST['pwdrequest'])) {

//parametrisierte Query zum Schutz vor Injections:
	$sql ="SELECT email FROM users WHERE Username=:userormail or Email=:userormail";
	$query = $dbh -> prepare($sql);
	$query-> bindParam(':userormail', $_POST['userormail'], PDO::PARAM_STR);
	$query-> execute();
	if($query->rowCount() == 0)	{
		$_SESSION["message"] = "kein vorhandener User oder E-Mail gefunden!";
		$_SESSION["messagetype"]="warning";
	} else {
		$emailaddr = $query->fetchColumn();

//zufälligen String erzeugen, Länge 8:
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$rand = '';
	for ($i = 0; $i < 7; $i++) {
		$rand .= $characters[rand(0, $charactersLength - 1)];
   	}
	$newpwd = $rand;
	$encpwd = md5($newpwd);

//updaten des Userpasswortes:
	$sql ="UPDATE users set Password=:password WHERE Email=:emailaddr";
	$query= $dbh -> prepare($sql);
	$query-> bindParam(':password', $encpwd, PDO::PARAM_STR);
	$query-> bindParam(':emailaddr', $emailaddr, PDO::PARAM_STR);
	$query-> execute();

//Mail mit neuem Passwort versenden:
	include_once("utility/McMail.php");
	$mail = new McMail();
	$mail->zak($emailaddr,"Ihr neues Passwort für die göttliche Cloud","und jetzt bitte aber merken: " . $newpwd);
	$_SESSION["message"] = "neues Passwort an folgende Adresse gesendet: " . $emailaddr;
}
   header("Location:index.php"); 
}
?>
<blockquote class="rounded-pill blockquote text-right h3">
	An deinen Satzungen will ich mich ergötzen, dein (Pass-)Wort nicht vergessen.
	<footer class="blockquote-footer text-monospace">Psalme 119:16</footer>
</blockquote>
		<div class="jumbotron content">
<div class="contentborder">
			<small style="margin-bottom:2em;">Doch das passiert schon mal, aber nicht verzagen, Gott ist gnädig - und so ist seine Cloud! Geben Sie unten entweder den Usernamen oder die E-Mail-Adresse ein, und Sie erhalten ein neues Passwort in Kürze. </small>&nbsp;
       			<form  style="margin-top:2em;" method="POST">
			<div class="form-group">
       		        	<label for="username"><b>Username oder E-Mail-Adresse</b></label>
                		<input type="text" name="userormail" class="form-control mb" required>
			</div>
                		<br><button class="btn btn-dark btn-block" type="submit" name="pwdrequest" value="pwdrequest"><h4>Passwort anfordern</h4></button>
		        </form> 
        </div>
</div>
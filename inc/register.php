<?php
include 'utility/guestcheck.php';

//Userregistrierung:
if(isset($_POST['Registrieren'])) {
    if (md5($_POST['pass']) != md5($_POST['pass2'])) {
      $_SESSION["message"] = "Passwörter stimmen nicht überein!";
      $_SESSION["messagetype"]="warning";
      header("Location:index.php?type=registrieren"); 
      return;
    } else {

//Erstellen eines Userobjektes und Speicherung auf der DB:
  $_SESSION["actuser"] = new User(NULL, $_POST['Anrede'], $_POST['fname'], $_POST['lname'], $_POST['address'], $_POST['plz'], $_POST['uname'], md5($_POST['pass']), $_POST['email'], "REG", "invisible");
  
  if (!$db->registerUser($_SESSION["actuser"])) {
                 $_SESSION["message"] = "Username und/oder Email existieren bereits oder sind nicht gültig, bitte andere wählen!";
                 $_SESSION["messagetype"]="warning";
                 unset($_SESSION["actuser"]);
                 header("Location:index.php?type=registrieren"); 
                 return;                
                }	else {

//Speichern des Usernamens und der Rolle in der Session als eingeloggt sowie Anlegen eines Logeintrags in der DB:
        $_SESSION["logusername"] = $_POST['uname']; 
         if ($db->logAction($_SESSION["logusername"], 'Registrierung', $_POST["email"], 0, 0, $_SERVER["REMOTE_ADDR"])) {
          $_SESSION["message"] = "Erfolgreich registriert";
          $_SESSION['rolle'] = 'REG'; 
          $_SESSION["actuser"]->setId($db->getId($_SESSION["logusername"]));
          //WillkommensMail versenden:
	          include_once("utility/McMail.php");
	          $mail = new McMail();
	          $mail->zak($_POST["email"],"Willkommen in der göttlichen Cloud!","Falls Sie das nicht waren, tut es mir wirklich leid. Sie haben wahrscheinlich ein Problem. Haben Sie Feinde?");
        } else { 
          $_SESSION["message"] = "Fast geschafft, aber am Ende hats doch nicht sollen sein - die Technik wars wieder mal, und keine hat eine Ahnung.";
          $_SESSION["messagetype"]="warning";
          unset($_SESSION["actuser"]);
          header("Location:index.php?type=registrieren"); 
    }
}
header("Location:index.php");
}
}
//html-Registrierungs-Formular:
?>
<blockquote class="rounded-pill blockquote text-right h3 right">
	Der Herr aber wird mich erlösen von allem Übel und mich retten in sein himmlisches Reich.
	<footer class="blockquote-footer text-monospace">Timotheus 4:18</footer>
</blockquote>
<div class="jumbotron content">
<div class="contentborder">
<p class="small text-right text-monospace">Ist Ihre Seele auch verloren, Ihre Daten können Sie noch retten - im ewigen Fegefeuer können Sie so zumindest alte Urlaubsfotos ansehen.</p>
<form class="form-horizontal" method="POST">

  <div class="form-group row">
    <label class="col-md-2 control-label col-form-label" for="Anrede">Anrede:</label>
    <div class="col-md-10">
      <select id="Anrede" name="Anrede" class="form-control">
        <option value="">----</option>
        <option value="w">Frau</option>
        <option value="m">Herr</option>
        <option value="x">ein Mensch, sie zu knechten, sie alle zu finden, ins Dunkel zu treiben und ewig zu binden - im Lande Mordor, wo die Schatten drohn.</option>
      </select>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-2 col-form-label control-label" for="fname">Vorname:</label>  
    <div class="col-md-4">
    <input id="fname" name="fname" type="text" placeholder="Eric" class="form-control input-md">
    </div>

    <label class="col-md-2 control-label col-form-label" for="lname">Nachname:</label>  
    <div class="col-md-4">
    <input id="lname" name="lname" type="text" placeholder="Cartman" class="form-control">
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-2 col-form-label control-label" for="address">Adresse:</label>  
    <div class="col-md-4">
    <input id="address" name="address" type="text" placeholder="Evergreen Terrace 127" class="form-control input-md">
    </div>

    <label class="col-md-2 control-label col-form-label" for="plz">PLZ:</label>  
    <div class="col-md-4">
    <input id="plz" name="plz" type="text" placeholder="90210" class="form-control">
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-2 col-form-label control-label font-weight-bold" for="uname">*<u>Benutzername:</u></label>  
    <div class="col-md-4">
    <input id="uname" pattern="[A-Za-z0-9_-]*" name="uname"  placeholder="nur Buchstaben, Zahlen und Striche erlaubt" type="text" class="form-control input-md" required>
    </div>

    <label class="col-md-2 control-label col-form-label font-weight-bold" for="email">*<u>E-Mail:</u></label>  
    <div class="col-md-4">
    <input id="email" name="email" type="text" placeholder="zB god@heaven.com" class="form-control" required>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-2 col-form-label control-label font-weight-bold" for="pass">*<u>Passwort:</u></label>  
    <div class="col-md-4">
    <input id="pass" name="pass" type="password" placeholder="*****" class="form-control input-md" required>
    </div>

    <label class="col-md-2 control-label col-form-label font-weight-bold" for="pass2">*<u>Passwort bestätigen:</u></label>  
    <div class="col-md-4">
    <input id="pass2" name="pass2" type="password" placeholder="*****" class="form-control" required>
    </div>
  </div>

  <p class="text-right small font-weight-bold" style="font-size:small">*<u>Pflichtfelder</u></p>
  <div class="form-group row">
    <div class="col-sm-12"><br>
    <button class="btn btn-dark btn-block" type="submit" name="Registrieren" value="Registrieren"><h4>Registrieren</h4></button>
    </div>  
  </div>
</form>
</div>
</div>
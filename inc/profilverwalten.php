<?php
include 'utility/usercheck.php';

?>

<blockquote class="rounded-pill blockquote text-right h3">
  Jesus Christus gestern und heute und derselbe auch in Ewigkeit.
  <footer class="blockquote-footer text-monospace">Hebräer 13:8</footer>
</blockquote>

<div class="jumbotron content">
<div class="contentborder">
  <p class="small font-weight-bold text-right text-monospace">Aber leider sind nicht alle von uns so ewig wie Jesus Christus. Also schäme dich nicht und beichte deine Veränderungen!</p>
  <form class="form-horizontal" method="POST">
    <div class="form-group row">
      <label class="col-md-2 col-form-label control-label" for="uname">*<u><b>Anrede:</b></u></label>  
      <div class="col-md-10">
      <input id="Anrede" name="Anrede" type="text" value="
  <?php 
  switch ($_SESSION["actuser"]->getAnrede()) {
    case 'm':
      echo 'Herr';
    break;
    case 'w':
      echo 'Frau';
    break;
    case 'x':
      echo 'ein Mensch, sie zu knechten, sie alle zu finden, ins Dunkel zu treiben und ewig zu binden - bla bla bla'; 
    break;
    default:
      echo 'be whatever you want';
    break;
  } ?>" class="form-control input-md" disabled>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-2 col-form-label control-label" for="fname">Vorname:</label>  
  <div class="col-md-4">
  <input id="fname" name="fname" type="text" value="<?php echo $_SESSION["actuser"]->getVorname() ?>" class="form-control input-md">
  </div>

  <label class="col-md-2 control-label" for="lname">Nachname:</label>  
  <div class="col-md-4">
  <input id="lname" name="lname" type="text" value="<?php echo $_SESSION["actuser"]->getNachname() ?>" class="form-control">
  </div>
</div>

<div class="form-group row">
  <label class="col-md-2 col-form-label control-label" for="address">Adresse:</label>  
  <div class="col-md-4">
  <input id="address" name="address" type="text" value="<?php echo $_SESSION["actuser"]->getAddresse() ?>" class="form-control input-md">
  </div>

  <label class="col-md-2 control-label" for="plz">PLZ:</label>  
  <div class="col-md-4">
  <input id="plz" name="plz" type="text" class="form-control" value="<?php echo $_SESSION["actuser"]->getPlz() ?>">
  </div>
</div>

<div class="form-group row">
  <label class="col-md-2 col-form-label control-label" for="uname">*<u><b>Benutzername:</b></u></label>  
  <div class="col-md-4">
  <input id="uname" name="uname" type="text" value="<?php echo $_SESSION["actuser"]->getUsername() ?>" class="form-control input-md" disabled>
  </div>

  <label class="col-md-2 control-label" for="email">*<u><b>E-Mail:</b></u></label>  
  <div class="col-md-4">
  <input id="email" name="email" type="text" class="form-control" disabled value="<?php echo $_SESSION["actuser"]->getEmail() ?>">
  </div>
</div>

<div class="form-group row" style="margin-bottom: 0;">
  <label class="col-md-2 col-form-label control-label" for="apass">altes Passwort<br>(f&uuml;r &Auml;nderung):</label>  
  <div class="col-md-4">
  <input id="apass" name="apass" type="password" autocomplete="new-password" placeholder="******" class="form-control input-md" required>
  </div>

  <label class="col-md-2 control-label" for="passneu">neues Passwort<br>(falls gew&uuml;nscht):</label>  
  <div class="col-md-4">
  <input id="passneu" name="passneu" type="password" autocomplete="new-password" class="form-control" >
  </div>
</div>

<footer class="text-right small" style="font-size:small; margin-bottom:0;">*<u><b>nicht änderbar</b></u></footer>
  <div class="form-group row">
    <div class="col-sm-12">
      <br><button class="btn btn-dark btn-block" type="submit" name="saveProfile" value="Speichern"><h4>Speichern</h4></button>
    </div>  
  </div>
</form>
</div>
</div>
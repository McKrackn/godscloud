<?php

//User blocken:
if(isset($_POST['block'])) {
	if ($db->setBlock($_SESSION['actuser']->getId(), $_POST['block'])) {
    $db->unsetFriend($_SESSION['actuser']->getId(),$_POST['block']);
    $_SESSION["message"] ="Dieser Engel wird dich nicht mehr belästigen!";
    $db->logAction($_SESSION["logusername"], 'block', $_POST['add'], 0, 0, $_SERVER["REMOTE_ADDR"]);
	} else {
		$_SESSION["message"] ="Irgendwas hat nicht funktionert, ist der User vielleicht schon blockiert?";
		$_SESSION["messagetype"]="warning";
	}
	unset($_POST['block']);
	header("Location:#"); 
}

//User entblocken:
if(isset($_POST['unblock'])) {
	if ($db->unsetBlock($_SESSION['actuser']->getId(),$_POST['unblock'])) {
    $_SESSION["message"] ="Dieser Engel kann dich wieder erreichen!";
    $db->logAction($_SESSION["logusername"], 'unblock', $_POST['unblock'], 0, 0, $_SERVER["REMOTE_ADDR"]);
	} else {
		$_SESSION["message"] ="Irgendwas hat nicht funktionert, ist der User vielleicht schon entblockiert?";
		$_SESSION["messagetype"]="warning";
	}
	unset($_POST['unblock']);
	header("Location:#"); 
}

//Freundschaftsanfrage annehmen:
if(isset($_POST['frqacc'])) {
	if ($db->replyFrq($_POST['frqacc'], 'accepted')) {
    $db->modifyMsg($_POST['frqacc'], 'deleted');
		$_SESSION["message"] ="Glückwunsch zur neuen Freundschaft!";
	} else {
		$_SESSION["message"] ="Irgendwas hat nicht funktionert, bitte auf der Datenbank nachsehen.";
		$_SESSION["messagetype"]="warning";
	}
	unset($_POST['frqacc']);
	header("Location:#"); 
}

//Freundschaftsanfrage ablehnen:
if(isset($_POST['frqdec'])) {
	if ($db->replyFrq($_POST['frqdec'], 'denied')) {
    $db->modifyMsg($_POST['frqdec'], 'deleted');
		$_SESSION["message"] ="Abgelehnt! Wer braucht schon Freunde?";
	} else {
		$_SESSION["message"] ="Irgendwas hat nicht funktionert, bitte auf der Datenbank nachsehen.";
		$_SESSION["messagetype"]="warning";
	}
	unset($_POST['frqdec']);
	header("Location:#"); 
}

//User entfreunden:
if(isset($_POST['unfriend'])) {
	if ($db->unsetFriend($_SESSION['actuser']->getId(),$_POST['unfriend'])) {
    $_SESSION["message"] ="Entfremdung erfolgreich! Freundschaft wird sowieso überbewertet.";
    $db->logAction($_SESSION["logusername"], 'unfriend', $_POST['unfriend'], 0, 0, $_SERVER["REMOTE_ADDR"]);
	} else {
		$_SESSION["message"] ="Irgendwas hat nicht funktionert, ist der User vielleicht gar kein Freund mehr?";
		$_SESSION["messagetype"]="warning";
	}
	unset($_POST['unfriend']);
	header("Location:#"); 
}

//Nachricht löschen:
if(isset($_POST['delmsg'])) {
	if ($db->modifyMsg($_POST['delmsg'], 'deleted')) {
		$_SESSION["message"] ="Der Leibhaftige wird sich darum kümmern.";
	} else {
		$_SESSION["message"] ="Irgendwas hat nicht funktionert, bitte auf der Datenbank nachsehen.";
		$_SESSION["messagetype"]="warning";
	}
	unset($_POST['delmsg']);
	header("Location:#"); 
}

//Freundschaftsanfrage verschicken:
if(isset($_POST['add'])) {
	if ($db->requestFriend($_SESSION['actuser']->getId(),$_POST['add'])) {
		$db->createMsg($_SESSION['actuser']->getId(), $_POST['add'], "Freundschaftsanfrage von " . $_SESSION['logusername'] , "frq");
    $_SESSION["message"] ="Freundschaftsanfrage verschickt!";
    $db->logAction($_SESSION["logusername"], 'requestFriend', $_POST['add'], 0, 0, $_SERVER["REMOTE_ADDR"]);
	} else {
		$_SESSION["message"] ="Es existiert bereits eine Anfrage.";
		$_SESSION["messagetype"]="warning";
	}
	unset($_POST['add']);
  header("Location:#"); 
}

//Nachricht senden:
if(isset($_POST['msg'])) {
	if ($db->createMsg($_SESSION['actuser']->getId(), $_POST['msg'], $_POST['subject'], $_POST['msgbody'])) {
	$_SESSION["message"] ="Nachricht wurde versandt!";
    $db->logAction($_SESSION["logusername"], 'msg', $_POST['msg'], 0, 0, $_SERVER["REMOTE_ADDR"]);
	} else {
		$_SESSION["message"] ="Irgendwas hat nicht funktionert, ist der User vielleicht blockiert?";
		$_SESSION["messagetype"]="warning";
	}
	unset($_POST['msg']);
	header("Location:#"); 
}

//Chronos spielen, Zufallszahl für background festlegen, Sichtbarkeitsänderung verarbeiten:s
if (isset($_POST['setTime'])) {
    $_SESSION['calcTime'] = mktime(substr($_POST['acttime'],0,2),substr($_POST['acttime'],3,2));
    $_SESSION["message"] = "Der Herr der Zeit hat gezaubert, es ist jetzt " . date("h:i", $_SESSION['calcTime']);
    include "utility/CalcTime.php";
    header("Location:#"); 
    return;
}

if (isset($_POST['rnd'])) {
    $_SESSION['randSeed'] = rand(0,1);
    $_SESSION["message"] = "Gott würfelt nicht! So sagt man, aber es stimmt nicht. Seine Würfel sind nur zu gewaltig für uns zu begreifen.";
    header("Location:#"); 
    return;
}

if (isset($_POST['setvisbutton'])) {
    if ($db->changeVisStatus($_POST['setvisbutton'],$_SESSION['actuser']->getUsername()) && $_SESSION['actuser']->getVisibility() != $_POST['setvisbutton']) {
        $_SESSION['actuser']->setVisibility($_POST['setvisbutton']);
        $_SESSION["message"] = "Sichtbarkeit geändert.";
    }
    header("Location:#"); 
    return;
}

//User löschen:
if(isset($_POST['del'])) {
	if ($db->deleteUser($_POST['del'])) {
		$_SESSION["message"] ="User wurde mit der Kraft Gottes gebannt und wird nicht mehr wiederkehren.";
	} else {
		$_SESSION["message"] ="Irgendwas hat nicht funktionert, bitte auf der Datenbank nachsehen.";
		$_SESSION["messagetype"]="warning";
	}
	unset($_POST['del']);
	header("Location:#"); 
}

//User sperren/entsperren:
if(isset($_POST['mod'])) {
	if ($db->changeUserStatus($_POST['mod'])) {
		$_SESSION["message"] ="Der magische Himmelsschlüssel erscheint und erfüllt deinen Wunsch!";
	} else {
		$_SESSION["message"] ="Irgendwas hat nicht funktionert, bitte auf der Datenbank nachsehen.";
		$_SESSION["messagetype"]="warning";
	}
	unset($_POST['mod']);
	header("Location:#"); 
}

//IP sperren/entsperren:
if(isset($_POST['modIP'])) {
	if ($db->changeIPStatus($_POST['modIP'], $_SESSION['logusername'])) {
		$_SESSION["message"] ="IP-Adresse " .$_POST['modIP']. " ist wieder unschuldig wie die heilige Mutter Maria.";
	} else {
		$_SESSION["message"] ="Irgendwas hat nicht funktionert, bitte auf der Datenbank nachsehen.";
		$_SESSION["messagetype"]="warning";
	}
	unset($_POST['modIP']);
	header("Location:#"); 
}

//Mail an den Admin versenden:
    if(isset($_POST['contact'])) {
        include_once("utility/McMail.php");
        $mail = new McMail();
        $_SERVER["SERVER_ADMIN"] = "c.lagelstorfer@gmail.com";
        $mail->zak($_SERVER["SERVER_ADMIN"],"GodsCloud-Feedback von " . $_SESSION['logusername'] . " aka " . $_POST['name'] . ":" . $_POST['subject'], $_POST['message']);
        $_SESSION["message"] = "Nachricht wurde versendet!";
        header("Location:index.php");
    }

//Profil ändern:
    if (isset($_POST['saveProfile'])) { 
        $apass = md5($_POST['apass']);
      //Richtigkeit des Passworts prüfen:
      if ($apass == $_SESSION["actuser"]->getPassword()) {
      
      //Felder einzeln auf Änderungen prüfen:
      if (isset($_POST['fname'])) 
      { $fname = ($_POST['fname']);
        $_SESSION["actuser"]->setVorname($fname);} 
      if (isset($_POST['lname']))
      { $lname = ($_POST['lname']);
        $_SESSION["actuser"]->setNachname($lname);}
      if (isset($_POST['address']))
      { $address = ($_POST['address']);
        $_SESSION["actuser"]->setAdresse($address);}
      if (isset($_POST['plz']))
      { $plz = ($_POST['plz']);
        $_SESSION["actuser"]->setPlz($plz);}
      if (isset($_POST['passneu']) && strlen($_POST['passneu']>0)) {
        $_SESSION["actuser"]->setPassword(($_POST['passneu']));
      }
      
      //Userobjekt zur Änderung wird erstellt:
            $edited = new User("", "", $_SESSION["actuser"]->getVorname(), $_SESSION["actuser"]->getNachname(), $_SESSION["actuser"]->getAddresse(), $_SESSION["actuser"]->getPlz(), $_SESSION["actuser"]->getUsername(), md5($_POST['passneu']), "", "", "");
            if($db->updateUser($edited)) {
              $db->logAction($_SESSION["logusername"], 'changeProfile', $_SESSION["rolle"], 0, 0, $_SERVER["REMOTE_ADDR"]);
              $_SESSION["message"] = "Speichern erfolgreich!";
            } else {
              $_SESSION["message"] ="Speichern fehlgeschlagen! Bitte nochmals versuchen oder oder bei Unklarheiten beten bzw. Kontakt aufnehmen.";
              $_SESSION["messagetype"]="warning";
            }
        } else {
          $_SESSION["message"] ="aktuelles Passwort inkorrekt";
              $_SESSION["messagetype"]="warning";
        }
          header("Location:index.php"); 
          return;
      }

//Dropdown-Button für das Admin-Menü
function adminButton() {
    echo '<li class="nav-item dropdown" style="width: 150px;">';
    echo '<a class="nav-link dropdown-toggle" data-target="#adminmenu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="index.php">Admin</a>';
    echo '<div class="dropdown-menu" id="adminmenu">';
    echo '<a class="dropdown-item" href="index.php?type=userverwalten">Userverwaltung</a>';
    echo '<a class="dropdown-item" href="index.php?type=ipsperrenverwalten">gesperrte IP-Adressen</a>';
    echo '<form method="POST">';
    echo '<input id="acttime" style="font-size: small; margin-top: 4px; margin-left: 12px;" type="time" name="acttime" value="'. date("H:i", $_SESSION['calcTime']) .'">';
    echo '<button class="btn-dark" style="font-size: small; margin-bottom: 4px;" type="submit" name="setTime" id="setTime">setTime</button>';
    echo '<button class="nav-item btn-dark" style="font-size: small; padding: 2px; margin-left: 2px; height: max-content; align-self: center;" type="submit" name="rnd" id="rnd">rnd</button>';
    echo '</form>';
    echo '</div>';
    echo '</li>';
}

//Dropdown-Button für das User-Menü
function socialButton() {
echo '<li class="nav-item dropdown ml-auto" style="width: 150px; margin-right: 20px">';
echo '<a class="nav-link dropdown-toggle" data-target="#profilemenu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="index.php">';
if($_SESSION["actuser"]->getVisibility() == 'invisible') {
    echo '<i class="fa fa-cloud" style="color:silver" title="unsichtbar"></i>';
} elseif($_SESSION["actuser"]->getVisibility() == 'away') {
    echo '<i class="fa fa-cloud" style="color:orange" title="nicht verfügbar"></i>';
} elseif($_SESSION["actuser"]->getVisibility() == 'visible2friends') {
    echo '<i class="fa fa-cloud" style="color:white; background-color:green" title="sichtbar (Freunde)"></i>';
} elseif($_SESSION["actuser"]->getVisibility() == 'visible') {
    echo '<i class="fa fa-cloud" style="color:green" title="sichtbar"></i>';
} 
echo ' ' . $_SESSION["actuser"]; 
echo '</a>';
echo '<div class="dropdown-menu" id="profilemenu">';
if($_SESSION["actuser"]->getVisibility() == 'invisible') {
    echo '<button name="visbutton" class="btn btn-secondary btn-block" type="button" data-toggle="collapse" data-target="#stati" data-trigger="focus" title="Status ändern">unsichtbar</button>';
} elseif($_SESSION["actuser"]->getVisibility() == 'away') {
    echo '<button name="visbutton" class="btn btn-warning btn-block" type="button" data-toggle="collapse" data-target="#stati" data-trigger="focus" title="Status ändern">nicht verfügbar</button>';
} elseif($_SESSION["actuser"]->getVisibility() == 'visible2friends') {
    echo '<button name="visbutton" class="btn btn-outline-success btn-block" type="button" data-toggle="collapse" data-target="#stati" data-trigger="focus" title="Status ändern"><small>sichtbar (Freunde)</small></button>';
} elseif($_SESSION["actuser"]->getVisibility() == 'visible') {
    echo '<button name="visbutton" class="btn btn-success btn-block" role="button" data-toggle="collapse" data-target="#stati" data-trigger="focus" title="Status ändern">sichtbar</button>';
}
echo '<div class="dropdown-divider"></div>';
echo '<a class="dropdown-item" href="index.php?type=profilverwalten">Profil</a>';
echo '<a class="dropdown-item" href="index.php?type=more">mehr...</a>';
echo '<a class="dropdown-item" href="index.php?type=logout&logusername='. $_SESSION['logusername'] .'">Logout</a>';
echo '</div>';
echo '</li>';
}
//Navigation nach Benutzerrolle anpassen:
//Gastuser:
if ($_SESSION['rolle']=='NON') { ?>
        <nav class="navbar navbar-expand-md navbar-light fixed-top topnav" style="z-index:11" >
            <ul class="navbar-nav mr-auto">
            <a class="nav-item nav-link active" style="width:150px;"  href="index.php?type=home">Home <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" style="width:150px;" href="index.php?type=hilfe">Hilfe</a>
            <a class="nav-item nav-link" style="width:150px;" href="index.php?type=kontakt">Kontakt</a>
            <a class="nav-item nav-link" style="width:150px;" href="index.php?type=impressum">Impressum</a>
            <a class="nav-item nav-link" style="width:150px;" href="index.php?type=registrieren">Registrieren</a>
            <a class="nav-item nav-link" style="width:150px;" href="index.php?type=login">LogIn</a>
        </ul>
        </nav>

        <div class="jumbotron fixed-top" id="banner" style="margin-top:4em; margin-bottom:2em;"  >
			<p class="h2 glow">
                <img src="page_pics/godscloud-logo.png" class="logo" height=70em href="index.php?type=home">
                Cloud your picture. Picture your cloud.
			    <img src="page_pics/godscloud-logo.png" class="logo" height=70em href="index.php?type=home">
            </p>
			<p style="text-align:right; padding-right:15%; font-size: small"> (nicht eingeloggt) </p>
        </div>
        <img src=<?php echo $icon ?> id="rotate" class="d-inline rotate" style="left: <?php echo $timePassed ?>%">
<?php } elseif ($_SESSION['rolle']=='REG') { ?>
    <nav class="navbar navbar-expand-md navbar-light fixed-top topnav" style="z-index:11" >
        <ul class="navbar-nav" style="width:100%">
            <a class="nav-item nav-link active" style="width:150px;" href="index.php?type=home">Home <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="index.php?type=news" onclick="return alert('Noch keine News!');" style="width: 150px;">News</a>
            <a class="nav-item nav-link" style="width:150px;" href="index.php?type=hilfe">Hilfe</a>
            <a class="nav-item nav-link" style="width:150px;" href="index.php?type=kontakt">Kontakt</a>
            <a class="nav-item nav-link" style="width:150px;" href="index.php?type=impressum">Impressum</a>
            <a class="nav-item nav-link" style="width:150px;" href="index.php?type=bilderverwalten">Bilder</a>
        <?php socialButton();?>
        </ul>
        </nav>
        <div class="jumbotron fixed-top" id="banner" style="margin-top:4em; margin-bottom:2em;">
        <p class="h2 glow">
                <img src="page_pics/godscloud-logo.png" class="logo">
                Cloud your picture. Picture your cloud.
                <img src="page_pics/godscloud-logo.png" class="logo">
        </p>
            <p style="text-align:right; padding-right:15%; font-size: small"> (eingeloggt als <?php echo $_SESSION["actuser"]   ?>) </p>
        </div>
<?php } elseif ($_SESSION['rolle']=='ADM') {
//Adminuser
echo '<nav class="navbar navbar-expand-md navbar-light fixed-top topnav" style="z-index:11" >';
echo '<ul class="navbar-nav" style="width:100%">';
echo '<a class="nav-item nav-link active" href="index.php?type=home" style="width: 150px;">Home <span class="sr-only">(current)</span></a>';
echo '<a class="nav-item nav-link" href="index.php?type=hilfe" style="width: 150px;">Hilfe</a>';
echo '<a class="nav-item nav-link" href="index.php?type=kontakt" style="width: 150px;">Kontakt</a>';
echo '<a class="nav-item nav-link" href="index.php?type=impressum" style="width: 150px;">Impressum</a>';
echo '<a class="nav-item nav-link" href="index.php?type=memory" style="width: 150px;">Memory</a>';
echo '<a class="nav-item nav-link" href="index.php?type=bilderverwalten" style="width: 150px;">Bilder</a>';
// echo '<li class="nav-item dropdown" style="width:150px;">';
// echo '<a class="nav-link dropdown-toggle" data-target="#picmenu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="index.php">Bilder</a>';
// echo '<div class="dropdown-menu" id="picmenu">';
// echo '<a class="dropdown-item" href="index.php?type=bilderverwalten">Bilderverwaltung</a>';
// echo '<a class="dropdown-item" style="text-align:left" href="index.php?type=map">Kartendarstellung</a>';
// echo '<a class="dropdown-item" href="index.php?type=tagcloud">Tag Cloud</a>';
// echo '</div>';
// echo '</li>';
adminButton();
socialButton();
echo '</ul>';
echo '</nav>';
echo '<div class="jumbotron fixed-top" id="banner" style="margin-top:4em; margin-bottom:2em;">';
echo '<p class="h2 glow">';
echo '<img src="page_pics/godscloud-logo.png" class="logo" id="logo">';
echo 'Cloud your picture. Picture your cloud.';
echo '<img src="page_pics/godscloud-logo.png" class="logo">';
echo '</p>';
echo '<p style="text-align:right; padding-right:15%; font-size: small">(eingeloggt als ADMIN)</p>';
echo '</div>';
echo '<img src="'. $icon .'" id="rotate" class="d-inline rotate" style="left: '. $timePassed .'%">';
} else if ($_SESSION['rolle']=='CON') { ?>
    <nav class="navbar navbar-expand-md navbar-light fixed-top topnav" style="z-index:11" >
        <ul class="navbar-nav" style="width:100%; background-color: red;">
            <a class="nav-item nav-link" style="width:150px; background-color: red; color: white" href="index.php?type=con">Home</a>
            <a class="nav-item nav-link" style="width:150px; background-color: red; color: white" href="index.php?type=darkkontakt">Kontakt</a>
            <a class="nav-item nav-link" style="background-color: red; color: yellow; width:150px;" href="index.php?type=logoutdark&logusername=<?php echo $_SESSION['logusername']?>">Logout</a>
            <a class="nav-item nav-link" style="background-color: red; color: yellow; width:150px;" href="index.php?type=logoutdark&logusername=<?php echo $_SESSION['logusername']?>">Logout</a>
            <li class="nav-item dropdown ml-auto" style="width: 150px;">
					<a class="nav-link dropdown-toggle" data-target="#adminmenu" data-toggle="dropdown" role="button" aria-haspopup="true" style="background-color: red; color: yellow; width:150px;" aria-expanded="false" href="index.php">Sünder!</a>
					<div class="dropdown-menu" id="adminmenu" style="padding: unset; min-width: unset;">
						<a class="dropdown-item" style="background-color: red; color: yellow; width:150px;" href="index.php?type=logoutdark&logusername=<?php echo $_SESSION['logusername']?>">Logout</a>
						<a class="dropdown-item" style="background-color: red; color: yellow; width:150px;" href="index.php?type=logoutdark&logusername=<?php echo $_SESSION['logusername']?>">Logout</a>
						<a class="dropdown-item" style="background-color: red; color: yellow; width:150px;" href="index.php?type=logoutdark&logusername=<?php echo $_SESSION['logusername']?>">Logout</a>
						<a class="dropdown-item" style="background-color: red; color: yellow; width:150px;" href="index.php?type=logoutdark&logusername=<?php echo $_SESSION['logusername']?>">Logout</a>
					</div>
                </li>
	    </ul>
        </nav>
        <div class="jumbotron fixed-top bg-warning text-dark" id="banner" style="margin-top:4em;  margin-bottom:2em;"  >
			<p class="h2 glow_dark">
            <img src="page_pics/godscloud-logo.png" class="logo">
                Repent to get clouded again.
                <img src="page_pics/godscloud-logo.png" class="logo">
</p>
			<p style="text-align:right; padding-right:15%; font-size: small"> persona non grata: <?php echo $_SESSION["logusername"] ?> </p>
        </div>
        <img src=<?php echo "dark" . $icon ?> id="rotate" class="d-inline rotate" style="left: <?php echo $timePassed ?>%">
<?php } ?>
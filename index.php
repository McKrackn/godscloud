<?php

//includes: 
spl_autoload_register(function($class) {
    if (is_readable("model".strtolower($class) . '.class.php')) {
        include_once "model".strtolower($class) . '.class.php';
    }
    if (is_readable("utility/DB.class.php")) {
        include_once("utility/DB.class.php");
    }
    if (is_readable("model/Picture.class.php")) {
        include_once("model/Picture.class.php");
    }
});

//Session starten, Zeit setzen und Zufallszahl für Designwahl bestimmen:
session_start();

if (!isset($_SESSION['randSeed'])) {
    $_SESSION['randSeed'] = rand(0,1);
    
//Initialisierung des Alertings:
$_SESSION["messagetype"]="success";
}

if (!isset($_SESSION['calcTime']) || ((time()-$_SESSION['calcTime']) / 60) > 5) {
	$_SESSION['calcTime'] = time();
}

include "utility/CalcTime.php";

//keine Rolle ist auch eine Rolle:
if (isset($_SESSION['actuser'])) { 
    $_SESSION['pass'] = $_SESSION['actuser']->getPassword();
    $_SESSION['rolle'] = $_SESSION['actuser']->getRolle();
    $_SESSION['logusername'] = $_SESSION['actuser']->getUsername();
} else {
    $_SESSION['rolle'] = "NON";
    $_SESSION['logusername'] = "noLoggedUser";
}

//DB-Verbindung über util/DB.class.php aufbauen:
$db = new DB();
$db->connect();

//html-head:
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="res/css/font-awesome.min.css">
    <script src="res/jquery-3.5.1.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <link rel="stylesheet" href="res/bootstrap.min.css">
    <link rel="stylesheet" href="res/daynight.css">
    <?php 
    switch($dayQuarter) {
        case 0:
        case 3: ?>
            <link rel="stylesheet" href="res/night.css">
        <?php break;
        case 1: 
        case 2: ?>
            <link rel="stylesheet" href="res/day.css">
        <?php break;
    }

    if ($_SESSION['rolle']=='CON') { ?>
        <style> body {background-image:url("darkpage_pics/gods-cloud<?php echo $dayQuarter ?>.jpg")}</style>    
    <?php } else { ?>
        <style> body {background-image:url("page_pics/backgrounds/gods-cloud<?php echo $dayQuarter,$_SESSION['randSeed'] ?>.jpg")}</style>
    <?php } ?>
	<title>GodsCloud - get Clouded like God!</title>
</head>
<body>
    <form method="POST" class="form-inline popover collapse" id="stati" data-trigger="focus" style="z-index: 1; right: 1%; top: 10%; left: unset;">
        <button name="setvisbutton" value="invisible" class="btn btn-secondary btn-block" type="submit">unsichtbar</button>
        <button name="setvisbutton" value="away" class="btn btn-warning btn-block" type="submit">nicht verfügbar</button>
        <button name="setvisbutton" value="visible2friends" class="btn btn-outline-success btn-block" type="submit"><small>sichtbar (Freunde)</small></button>
        <button name="setvisbutton" value="visible" class="btn btn-success btn-block" type="submit">sichtbar</button>
    </form>
<?php

//falls vorhanden, Systemnachrichten ausgeben:
if (isset($_SESSION['message'])) { ?>
<div class="alert alert-<?php echo $_SESSION["messagetype"] ?> alert-dismissible fade show" role="alert">
    <?php echo $_SESSION["message"] ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php
    unset($_SESSION["message"]);
    $_SESSION["messagetype"]="success";
} ?>
    <div class="container" style="padding-top:10em;">
<?php

//Navigationsleiste je nach eingeloggtem User und dessen Rolle:
include 'inc/navigation.php';

//Inkludieren des passenden Inhalts:
    switch (filter_input(INPUT_GET, "type", FILTER_SANITIZE_SPECIAL_CHARS)) { 
        case "registrieren":
            include 'inc/register.php';
            break;
        case "login":
            include 'inc/login.php';
            break;
        case "hilfe":
            include 'inc/help.php';
            break;
        case "profilverwalten":
            include 'inc/profilverwalten.php';
            break;
        case "bilderverwalten":
            include 'inc/bilderverwalten.php';
            break;
        case "userverwalten":
            include 'inc/adm/userverwalten.php';
            break;
        case "impressum":
            include 'inc/impressum.php';
            break;
        case "tagcloud":
            include 'inc/tagcloud.php';
            break;
        case "map":
            include 'inc/map.php';
            break;
        case "resetpwd":
            include 'inc/resetpwd.php';
            break;
        case "memory":
            include 'pokememory/pokemon.php';
            break;
        case "kontakt":
            include 'inc/kontakt.php';
            break;
        case "darkkontakt":
            include 'inc/darkkontakt.php';
            break;
        case "ipsperrenverwalten":
            include 'inc/adm/ipsperrenverwaltung.php';
            break;
        case "dbverwalten":
            include '/applications.html';
            break;
        // case "news":
        //     include 'inc/news.php';
        //     break;
        case "more":
            include 'inc/more.php';
            break;
        case "con":
            include 'inc/repent.php';
            break;
        case "logoutSeite":
            include 'inc/logout.php';
            break;
        case "logout":
            header("Location:index.php?type=logoutSeite&logusername=" . $_GET['logusername']); 
            session_destroy();
            echo("<meta http-equiv='refresh' content='0'>"); //Refresh by HTTP 'meta'
            break;
        case "logoutdark":
            session_destroy();
            header("Location:index.php"); 
            break;
    	default:
            include 'inc/home.php';       
            break;     
    }



//Logik, haufenweise:



// get image location
function get_image_location($image = 'page_pics/gods_cloud.jpg') {
    $exif = exif_read_data($image, 0, true);

    if ($exif && isset($exif['GPS'])) {

        $GPSLatitudeRef = $exif['GPS']['GPSLatitudeRef'];
        $GPSLatitude = $exif['GPS']['GPSLatitude'];
        $GPSLongitudeRef = $exif['GPS']['GPSLongitudeRef'];
        $GPSLongitude = $exif['GPS']['GPSLongitude'];

        $lat_degrees = count($GPSLatitude) > 0 ? gps2Num($GPSLatitude[0]) : 0;
        $lat_minutes = count($GPSLatitude) > 1 ? gps2Num($GPSLatitude[1]) : 0;
        $lat_seconds = count($GPSLatitude) > 2 ? gps2Num($GPSLatitude[2]) : 0;

        $lon_degrees = count($GPSLongitude) > 0 ? gps2Num($GPSLongitude[0]) : 0;
        $lon_minutes = count($GPSLongitude) > 1 ? gps2Num($GPSLongitude[1]) : 0;
        $lon_seconds = count($GPSLongitude) > 2 ? gps2Num($GPSLongitude[2]) : 0;

        $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
        $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;

        $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60 * 60)));
        $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60 * 60)));

        return array('latitude' => $latitude, 'longitude' => $longitude);
    } else {
        return false;
    }
}

//DB-Verbindung schließen:
$db->close();
?>
</div>
    <script src="res/jquery-ui.js"></script>
    <script src="res/bootstrap.bundle.min.js"></script>
    <script>
        /* $(document).ready(function(){
            $(".rotate").hover(function(){
                    $(".message").toggle("slow");
                    $(".contentborder").css({"border-top":"unset","border-top-left-radius":0,"border-top-right-radius":0});
                }, function() {
                    $(".message").toggle("slow");
                    $(".contentborder").css({"border-top":"initial","border-top-left-radius":".7rem","border-top-right-radius":".7rem"});
                });
        }); */
        
        //popovers aktivieren:
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
        });

        //Animation für die AdminArea-Grafik:
        $(document).ready(function(){
            $("#adminsearch").focus(function(){
                $(".adminarea").css({"animation-duration":"2s"});
                $(".adminarea").css({"filter":"hue-rotate(270deg)"});
                }),
                
            $("#adminsearch").focusout(function(){
                $(".adminarea").css({"animation-duration":"2s"});
                $(".adminarea").css({"filter":"hue-rotate(0deg)"});
            });
        });
    </script>
    </body>
</html>
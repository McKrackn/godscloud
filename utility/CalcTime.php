<?php
global $dayQuarter;
global $timePassed;
global $icon;

$sunriseTS = date_sunrise($_SESSION['calcTime'], SUNFUNCS_RET_TIMESTAMP); 
$sunsetTS = date_sunset($_SESSION['calcTime'], SUNFUNCS_RET_TIMESTAMP); 

// künstlich die Zeitgrenzen verschieben (+2h sunrise, +3h sunset), um menschlichere Zeiten zu haben
// bei DateTime-Objekt:
// $sunriseDT->add(new DateInterval('PT2H'));
// $sunsetDT->add(new DateInterval('PT3H'));
// oder mathematisch bei Timestamp::
$sunriseTS=$sunriseTS + 2*60*60;
$sunsetTS=$sunsetTS + 3*60*60;

$middayTS = ceil($sunriseTS+(($sunsetTS-$sunriseTS)/2));
$midnightTS = ceil($sunsetTS+(($sunsetTS-$sunriseTS)/2));

$sunriseDT = new DateTime("@$sunriseTS"); 
$sunsetDT = new DateTime("@$sunsetTS"); 
$middayDT = new DateTime("@$middayTS"); 
$midnightDT = new DateTime("@$midnightTS"); 



//herausfinden des Tagesviertels:
if ($_SESSION['calcTime'] >= $midnightTS || $_SESSION['calcTime'] <= $sunriseTS)
	$dayQuarter=0; //nacht
elseif ($_SESSION['calcTime'] < $middayTS && $_SESSION['calcTime'] >= $sunriseTS)
	$dayQuarter=1; //morgen
elseif ($_SESSION['calcTime'] < $sunsetTS  && $_SESSION['calcTime'] >= $middayTS)
	$dayQuarter=2; //tag
elseif ($_SESSION['calcTime'] < $midnightTS && $_SESSION['calcTime'] >= $sunsetTS)
	$dayQuarter=3; //abend

if ($dayQuarter == 3 || $dayQuarter == 0) {
	$icon = 'page_pics/moon.png';
	$timePassed = floor(($_SESSION['calcTime']-date_timestamp_get($sunriseDT))/(date_timestamp_get($sunsetDT)-date_timestamp_get($sunriseDT))*100)-100;
} else {
	$icon = 'page_pics/sun.png';
	$timePassed = abs(floor(($_SESSION['calcTime']-date_timestamp_get($sunsetDT))/(date_timestamp_get($sunriseDT)-date_timestamp_get($sunsetDT))*100-100));
}
?>
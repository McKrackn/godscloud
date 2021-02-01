<?php
session_start();
$handle = opendir($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['REQUEST_URI']) . '/../pictures/' . $_SESSION['logusername'] . '/thumbnail/');
//$handle = opendir(dirname(realpath(__FILE__)) . '/web-iih/pictures/' . $_SESSION['logusername'] . '/thumbnail/'); 
$thumbnails = array();
while ($file = readdir($handle)) {
    if ($file !== '.' && $file !== '..') { 
        $thumbnails[] = dirname($_SERVER['REQUEST_URI']) . '/../pictures/' . $_SESSION['logusername'] . '/thumbnail/' . $file; 
    }
}

$tbJson = json_encode($thumbnails);

echo $tbJson;

?>


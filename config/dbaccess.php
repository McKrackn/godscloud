<?php 

// DB credentials.
define('DB_HOST','');
define('DB_USER','');
define('DB_NAME','');

//DB-Verbindung über PDO aufbauen:
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,'' ,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("SQL ist müde und sagt: " . $e->getMessage());
}
?>

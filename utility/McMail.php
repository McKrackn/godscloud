<?php
require_once "Mail.php";

Class McMail {

//Atttribute:
  protected $from = "yalamach@gmail.com";
  protected $to = NULL;
  protected $subject = NULL;
  protected $body = NULL;
  protected $host = "ssl://smtp.gmail.com";
  protected $username = "yalamach@gmail.com";
  protected $password = "Yalamach1!";
  protected $port = "465";

//quasi-Konstruktor:
function zak($to, $subject, $body) {
  $this->to = $to ;
  $this->subject = $subject;
  $this->body = $body;

//Mailheader basteln, Mail basteln und dann versenden
  $headers = array ('From' => $this->from,
  'To' => $this->to,
  'Subject' => $this->subject);
  $smtp = Mail::factory('smtp',
  array ('host' => $this->host,
  'port' => $this->port,
  'auth' => true,
  'username' => $this->username,
  'password' => $this->password));
 
// $mail = $smtp->send($to, $headers, $body);
 
 if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>");
	$_SESSION["message"] = $mail->getMessage();

  } else {
    if(!isset($_SESSION["message"]))
	    $_SESSION["message"] = "Mailversand erfolgreich!";
  }
  }
}
 ?>
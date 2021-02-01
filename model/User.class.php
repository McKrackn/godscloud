<?php

class User implements JsonSerializable {

	//Attribute:
    private $id;
    private $anrede;
    private $vorname;
    private $nachname;
    private $addresse;
    private $plz;
    private $username;
    private $password;
    private $email;
    private $rolle;
    private $visibility;

	//Konstruktor:
    function __construct($id, $anrede, $vorname, $nachname, $addresse, $plz, $username, $password, $email, $rolle, $visibility) {
        $this->id = $id;
        $this->anrede = $anrede;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->addresse = $addresse;
        $this->plz =$plz;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->rolle = $rolle;  
        $this->visibility = $visibility;  
    }

    function __toString(){
                return $this->username;
        }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }

	//Getter und Setter:
    public function getVorname() {
        return $this->vorname;
    }
    
    public function getId(){
        return $this->id;
    }

    public function getNachname() {
        return $this->nachname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getAnrede() {
        return $this->anrede;
    }

    public function getAddresse() {
        return $this->addresse;
    }

    public function getPlz() {
        return $this->plz;
    }

    public function getUsername() {
        if ($this->username == null) {
            return 'noUser';
        } else return $this->username;    }

    public function getPassword() {
        return $this->password;
    }

    public function getRolle() {
        if ($this->rolle == null) {
            return 'NON';
        } else return $this->rolle;
    }

    public function getVisibility() {
        return $this->visibility;
    }

    public function setVorname($Vorname) {
       $this->vorname = $Vorname;
    }

    public function setNachname($Nachname) {
        $this->nachname = $Nachname;
    }

    public function setEmail($Email) {
       $this->email = $Email;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setAnrede($Anrede) {
       $this->anrede = $Anrede;
    }

    public function setAdresse($address) {
        $this->addresse = $address;
    }

    public function setUsername($Username) {
        $this->username = $Username;
    }

    public function setPlz($plz) {
        $this->plz = $plz;
    }

    public function setPassword($password) {
       $this->password = $password;
    }

    public function setRolle($rolle) {
        $this->rolle = $rolle;
     }

     public function setVisibility($visibility) {
        $this->visibility = $visibility;
     }
}
?>

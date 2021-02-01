<?php
include("model/User.class.php");

Class DB {
    private $host = "wi-projectdb.technikum-wien.at";
    private $user = "s20-bvz2-fst-251";
    private $pass = "DbPass4v625";
    private $dbname = "s20-bvz2-fst-251b";
    private $conn = null;

	//Serververbinung aufbauen
    function connect() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->dbname); 
        if (!$this->conn) {
            $_SESSION["message"] = "Verbindung zur Datenbank konnte nicht hergestellt werden! also ich bin jetzt auch richtig ratlos.";
        }
    }

    //userbezogene Funktionen für den operativen Betrieb
    public function getUserInfo($username, $password) {
        $this->conn;
        $query = "SELECT ID, sex as  Anrede, Vorname, Nachname, Address, Plz, Username, Password, Email, Rolle, visibility from users where username = '".$username."' and password = '".$password."'";
        $statement = $this->conn->prepare($query);
        $statement->execute();
        $statement->bind_result($id, $anrede, $vorname, $nachname, $addresse, $plz, $username, $password, $email, $rolle, $visibility);
               
       while ($statement->fetch()) {
           
            $user = new User($id, $anrede, $vorname, $nachname, $addresse, $plz, $username, $password, $email, $rolle, $visibility);
        }
        if (isset($user))
        return $user;
    }

    public function registerUser($user) {
        $this->conn;
        $query = "INSERT INTO users (sex, Vorname, Nachname, Address, plz, Username, Password, Email)
        VALUES ('".$user->getAnrede()."','".$user->getVorname()."','".$user->getNachname()."','"
                . "".$user->getAddresse()."','".$user->getPlz()."','"
                . "".$user->getUsername()."','".$user->getPassword()."','".$user->getEmail()."')";
        
        $statement = $this->conn->prepare($query);
        return $statement->execute();
    }

    public function getId($username) {
        $this->conn;
        $query = "SELECT id from users where username = '".$username."'";
        $statement = $this->conn->prepare($query);
        $statement->execute();
        $statement->bind_result($id);
        $statement->fetch();
        // $this->close();

        if (isset($id))
        return $id;
        else
        return 0;
    }

    public function requestFriend($requesting_user_id, $requested_user_id) {
        $this->conn;
        $query = "INSERT INTO users2friends(requesting_user_id, requested_user_id, status) VALUES('".$requesting_user_id."','".$requested_user_id."','requested')";
        
        $statement = $this->conn->prepare($query);
        return $statement->execute();
    }
    
    public function replyFrq($msg_id, $status) {
        $this->conn;
        $query = "UPDATE users2friends SET status='".$status."' where status='requested' and (requesting_user_id, requested_user_id) in (select sender_id, receiver_id from messages where msg_id='".$msg_id."')";
        
        $statement = $this->conn->prepare($query);
        return $statement->execute();
    }

    public function unsetFriend($unfriender, $unfriended) {
        $this->conn;
        $query = "delete from users2friends where (requesting_user_id='".$unfriender."' and requested_user_id='".$unfriended."') or (requesting_user_id='".$unfriended."' and requested_user_id='".$unfriender."')";
        
        $statement = $this->conn->prepare($query);
        return $statement->execute();
    }

    public function updateUser($userObjekt) {
           $this->conn;
           $query = "UPDATE users SET Vorname = '".$userObjekt->getVorname()."',"
                   . " Nachname = '".$userObjekt->getNachname()."', Address= '".$userObjekt->getAddresse()."',"
                   . " plz ='".$userObjekt->getPlz()."', "
                   . "Password ='".$userObjekt->getPassword()."' WHERE Username = '".$userObjekt->getUsername()."'";
           $statement = $this->conn->prepare($query);
           return $statement->execute();
       }

    public function changeVisStatus($visibility, $loguser) {
        $this->conn;
        $query = "update users set visibility = '" . $visibility . "' where Username='" . $loguser . "'";
        $statement = $this->conn->prepare($query);
        // $this->close(); 
        return $statement->execute();
    }

    public function setBlock($blocking_user, $blocked_user) {
        $this->conn;
        $query = "insert into blocks(blocking_user_id,blocked_user_id) VALUES('" .$blocking_user. "','" .$blocked_user. "')";
        $statement = $this->conn->prepare($query);
        // $this->close(); 
        return $statement->execute();
    }

    public function unsetBlock($blocking_user, $blocked_user) {
        $this->conn;
        $query = "delete from blocks where blocking_user_id = '" .$blocking_user. "' and blocked_user_id = '" .$blocked_user. "'";
        $statement = $this->conn->prepare($query);
        // $this->close(); 
        return $statement->execute();
    }

    public function getVisUserList() {
        $this->conn;
        $this->userArray = array();
        $query = "SELECT ID, sex as Anrede, NULL as Vorname, NULL as Nachname, NULL as Address, NULL as Plz, Username, NULL as Password, NULL as Email, NULL as Rolle, NULL as visibility from users where Rolle != 'DEL' and visibility='visible'";
        $statement = $this->conn->prepare($query);
        $statement->execute();
        $statement->bind_result($id, $anrede, $vorname, $nachname, $addresse, $plz, $username, $password, $email, $rolle, $visibility);
               
       while ($statement->fetch()) {
            $user = new User($id, $anrede, $vorname, $nachname, $addresse, $plz, $username, $password, $email, $rolle, $visibility);
            array_push($this->userArray, $user);
        }
        // $this->close();
        return $this->userArray;    
    }

    public function getBlockUserList($blocking_user) {
        $this->conn;
        $this->userArray = array();
        $query = "SELECT ID, sex as Anrede, Vorname, Nachname, Address, Plz, Username, Password, Email, Rolle, visibility from users where Rolle != 'DEL' and id in (select blocked_user_id from blocks where blocking_user_id='" .$blocking_user. "')";
        $statement = $this->conn->prepare($query);
        $statement->execute();
        $statement->bind_result($id, $anrede, $vorname, $nachname, $addresse, $plz, $username, $password, $email, $rolle, $visibility);
               
       while ($statement->fetch()) {
            $user = new User($id, $anrede, $vorname, $nachname, $addresse, $plz, $username, $password, $email, $rolle, $visibility);
            array_push($this->userArray, $user);
        }
        // $this->close();
        return $this->userArray;    
    }

    public function getFriendsUserList($UserId) {
        $this->conn;
        $this->userArray = array();
        $query = "SELECT ID, sex as Anrede, Vorname, Nachname, Address, Plz, Username, Password, Email, Rolle, visibility from users where Rolle != 'DEL' and id in (select requesting_user_id from users2friends where status = 'accepted' and requested_user_id='" .$UserId. "' union select requested_user_id from users2friends where status = 'accepted' and requesting_user_id='" .$UserId. "')";
        $statement = $this->conn->prepare($query);
        $statement->execute();
        $statement->bind_result($id, $anrede, $vorname, $nachname, $addresse, $plz, $username, $password, $email, $rolle, $visibility);
               
       while ($statement->fetch()) {
            $user = new User($id, $anrede, $vorname, $nachname, $addresse, $plz, $username, $password, $email, $rolle, $visibility);
            array_push($this->userArray, $user);
        }
            return $this->userArray;    
    }

    public function getUnreadMsg($UserId) {
        $this->conn;
        $this->msgArray = array();
        $query = "SELECT count(*) FROM messages WHERE status = 'unread' and receiver_id = '" .$UserId. "'";
        $statement = $this->conn->prepare($query);
        $statement->execute();
        $statement->bind_result($unreadcount);
               
        $statement->fetch();
        return $unreadcount;    
    }

    public function getMsgList($UserId) {
        $this->conn;
        $this->msgArray = array();
        $query = "SELECT msg_id, sender_id, username, status, msg_timestamp, msg_subject, msg_body FROM messages a inner join users b on a.sender_id=b.id WHERE status != 'deleted' and receiver_id = '" .$UserId. "' ORDER BY msg_timestamp DESC";
        $statement = $this->conn->prepare($query);
        $statement->execute();
        $statement->bind_result($msg_id, $sender_id, $username, $status, $msg_timestamp, $msg_subject, $msg_body);
               
        while ($statement->fetch()) {
            $msgdata = array(
                "msg_id" => $msg_id,
                "sender_id" => $sender_id,
                "username" => $username,
                "status" => $status,
                "msg_timestamp" => $msg_timestamp,
                "msg_subject" => $msg_subject,
                "msg_body" => $msg_body
            );
            array_push($this->msgArray, $msgdata);
         } 
            return $this->msgArray;    
    }
    
    public function createMsg($sender_id, $receiver_id, $msg_subject, $msg_body) {
        $this->conn;
        $query = "INSERT INTO messages(sender_id, receiver_id, msg_subject, msg_body) VALUES('".$sender_id."','".$receiver_id."','".$msg_subject."','".$msg_body."')";
        $statement = $this->conn->prepare($query);
        return $statement->execute();     
    }
    
    public function modifyMsg($msg_id, $status) {
        $this->conn;
        $query = "UPDATE messages SET status='" . $status . "' where msg_id='" . $msg_id . "'";
        $statement = $this->conn->prepare($query);
        return $statement->execute();     
    }
    
    public function insertPicture($pic) {
        $this->conn;
        
        $query = "INSERT INTO pics (filename, file_datetime, uploaddate, filesize, filetype, picsize, owner)
        VALUES ('".$pic->getFilename()."','".$pic->getFiledatetime()."','".$pic->getUploaddate()."','".$pic->getFilesize()."','"
                . "".$pic->getFiletype()."','".$pic->getPicsize()."','".$pic->getOwner()."')";
        
        $statement = $this->conn->prepare($query);
        return $statement->execute();     
    }
    
    //Adminfunktionen
    public function getFails($remoteIP) {
        $this->conn;
        $query = "SELECT count(*) as failcount from actionlog where logip = '".$remoteIP."' and logaction='FAILEDLogin' and cast(logdate as datetime) >= (select cast(max(logdate) as datetime) from actionlog where logip = '".$remoteIP."' and (logaction='unbanIP' or logaction='Login'))";
        $statement = $this->conn->prepare($query);
        $statement->execute();
        $statement->bind_result($failcount);
        $statement->fetch();
        // $this->close();

        if (isset($failcount))
        return $failcount;
        else
        return 0;
    }

    public function getIPInfo($logip) {
        $this->logArray = array();
        $this->conn;
        $query = "SELECT logdate, loguser, logaction, logdetails from actionlog where logip = '" . $logip . "' order by logdate desc LIMIT 10;";
        $statement = $this->conn->prepare($query);
        $statement->execute();
        $statement->bind_result($logdate, $loguser, $logaction, $logdetails);
               
       while ($statement->fetch()) {
           $logdata = array(
               "logdate" => $logdate,
               "loguser" => $loguser,
               "logaction" => $logaction,
               "logdetails" => $logdetails
           );
           array_push($this->logArray, $logdata);
        } 
        return $this->logArray;
    }

    public function getIPsperren() {
        $this->ipArray = array();
        $this->conn;
        $query = "SELECT a.logip, min(a.logdate) as mindate, max(a.logdate) as maxdate, count(*) as failcount from actionlog a left join (select logip, max(logdate) as logdate from actionlog where logaction='unbanIP' or logaction='Login' group by logip) b on a.logip=b.logip where cast(a.logdate as datetime) > cast(b.logdate as datetime) or b.logdate is null group by a.logip";
        $statement = $this->conn->prepare($query);
        $statement->execute();
        $statement->bind_result($logip, $mindate, $maxdate, $failcount);

            while ($statement->fetch()) {
                $ipdata = array(
                    "logip" => $logip,
                    "mindate" => $mindate,
                    "maxdate" => $maxdate,
                    "failcount" => $failcount
                );
                array_push($this->ipArray, $ipdata);
            };
            return $this->ipArray;
    }
 
    public function changeUserStatus($UserId) {
        $this->conn;
        $query = "UPDATE users set rolle = case when ROLLE = 'CON' THEN 'REG' ELSE 'CON' END WHERE ID = '".$UserId."'";
        $statement = $this->conn->prepare($query);
        // $this->close();
        return $statement->execute();
    }

    public function changeIPStatus($logip, $loguser) {
        $this->conn;
        $query = "INSERT INTO actionlog (loguser, logaction, logdetails, logip) VALUES ('" . $loguser . "','unbanIP', 'unbanned by admin','".$logip."')";
        $statement = $this->conn->prepare($query);
        // $this->close();
        return $statement->execute();
    }

    public function getUserList() {
        $this->userArray = array();
        $this->conn;
        $query = "SELECT ID, sex as Anrede, Vorname, Nachname, Address, Plz, Username, Password, Email, Rolle, visibility from users where Rolle != 'DEL'";
        $statement = $this->conn->prepare($query);
        $statement->execute();
        $statement->bind_result($id, $anrede, $vorname, $nachname, $addresse, $plz, $username, $password, $email, $rolle, $visibility);
               
       while ($statement->fetch()) {
            $user = new User($id, $anrede, $vorname, $nachname, $addresse, $plz, $username, $password, $email, $rolle, $visibility);
            array_push($this->userArray, $user);
        }
        // $this->close();
        return $this->userArray;    
    }

    public function deleteUser($UserId) {
        $this->conn;
        $query = "UPDATE users set rolle = 'DEL' WHERE ID = '".$UserId."'";
        $statement = $this->conn->prepare($query);
        return $statement->execute();
    }

    //sonstige Funktionen:
    public function getLastError() {
        return mysqli_error($this->conn); 
    }

    public function logAction($loguser, $logaction, $logdetails, $pic_id, $tag_id, $logip) {
        $this->conn;

        $query = "INSERT INTO actionlog(loguser, logaction, logdetails, pic_id, tag_id, logip) 
        VALUES ('".$loguser."','".$logaction."','".$logdetails."','".$pic_id."','".$tag_id."','".$logip."')";
        $statement = $this->conn->prepare($query);
        return $statement->execute();     
    }
    
    public function close()
    {
        $this->conn->close();
    }
}
?>


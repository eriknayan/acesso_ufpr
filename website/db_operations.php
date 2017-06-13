<?php

require_once('utilities.php');

class DBOperator {
    private $conn;

    function __construct() {

        $dbhost = 'localhost';
        $dbuser = Keys::getDbUser();
        $dbpass = Keys::getDbPasswd();
        $dbname = 'arion';
        $this->conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

        // Checks if successfully connected to db
        if($this->conn->connect_errno) {
            error_log("db_operations: Failed to connect to db.");
            throw new Exception("Unable to connect do db.");
        }
    }

    function __destruct() {
        $this->conn->close();
    }

    // Returns all user information in associative array
    public function getUserInfoFromSessionCookie($cookie) {
        $email = extractEmailFromCookie($cookie);

        $query = "SELECT name, email, type, grr, cardId, balance FROM Users WHERE email = '$email';";
        $result = $this->conn->query($query);
        if (!$result) {
            error_log("db_operations: Error when fetching user info");
            return false;
        }
        else {
            $row = $result->fetch_assoc();
            $result->close();
            return $row;
        }
    }

    public function getLastFiveTransactions($cookie) {
        $cardId = $this->getUserInfoFromSessionCookie($cookie)["cardId"];

        $query = "SELECT Transactions.tranId, Transactions.tranTime, Transactions.value, Restaurants.restName FROM Transactions LEFT JOIN Restaurants ON Transactions.restId=Restaurants.restId WHERE Transactions.cardId='$cardId' ORDER BY Transactions.tranTime DESC LIMIT 5;";

        return $this->conn->query($query);
    }

    public function isUserInDb($email, $cardId = NULL) {
        $email = $this->escape_string($email);
        if (!is_null($cardId)) {
            $cardId = $this ->escape_string($cardId);
        }

        $checkQuery = is_null($cardId) ? "SELECT * FROM Users WHERE email='$email';" :
                                         "SELECT * FROM Users WHERE email='$email' OR cardId='$cardId';";

        $checkCursor = $this->conn->query($checkQuery);
        if (!$checkCursor) {
            error_log("db_operations: Failed to check if user exists in db");
            die();
        }

        $hasMatch = ($checkCursor->num_rows > 0);
        $checkCursor->close();
        return $hasMatch;
    }

    // Return: confirmation key used in confirmation email
    public function insertUserInTemporaryTable($cardId, $name, $email, $passwd, $grr, $role) {

        // Escape strings
        $cardId = $this->escape_string($cardId);
        $name = $this->escape_string($name);
        $email = $this->escape_string($email);
        $passwd = $this->escape_string($passwd);
        $grr = $this->escape_string($grr);
        $role = $this->escape_string($role);

        // Converts our role string to a correspondent number before inserting into the db
        $roleToNumber = array (
            "Estudante" => 0,
            "Professor" => 1,
            "Servidor" => 2,
            "Admin" => 3
        );
        $roleNumber = $roleToNumber[$role];

        // Hashes password using BCRYPT method
        $passwdHashed = password_hash($passwd, PASSWORD_BCRYPT);

        // Creates random confirmation key
        $confirmationKey = $name . $email . date('mY');
        $confirmationKey = md5($confirmationKey);

        // Get registration date with current time
        $date = date_create();
        $regdate = date_format($date,"Y-m-d");

        $query = "INSERT INTO Tempusers (cardId,name,email,password,grr,type,regdate,confirmkey)
         VALUES (
          '$cardId','$name','$email','$passwdHashed','$grr','$roleNumber','$regdate','$confirmationKey')";
        $retval = $this->conn->query($query);

        if (!$retval) {
            error_log("db_operations: Failed to insert user in temporary table.");
            return false;
        }
        else {
            return $confirmationKey;
        }
    }

    public function insertUserInPermanentTable($confirmationKey) {
        $confirmationKey = $this->escape_string($confirmationKey);

        $query = "SELECT * FROM Tempusers WHERE confirmkey = '$confirmationKey'";
        $result = $this->conn->query($query);

        if (!$result) {
            error_log("db_operations: Error when querying db.");
            return false;
        }

        if ($result->num_rows == 0) {
            return false;
        }
        else if ($result->num_rows > 1) {
            $delQuery = "DELETE FROM Tempusers WHERE confirmkey = '$confirmationKey'";
            $this->conn->query($delQuery);
            $this->conn->commit();
            return false;
        }

        $row = $result->fetch_assoc();
        $result->close();

        // Get info from temporary record
        $cardId = $row['cardId'];
        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];
        $grr = $row['grr'];
        $type = $row['type'];

        //Get current date
        $date = date_create();
        $regdate = date_format($date,"Y-m-d");

        $addQuery = "INSERT INTO Users (
            cardId,name,email,password,grr,type,regdate) VALUES (
            '$cardId','$name','$email','$password','$grr','$type','$regdate')";
        if (!$this->conn->query($addQuery)) {
            error_log("db_operations: Couldn't insert user in permanent table.");
            $this->conn->rollback();
            return false;
        }

        // Delete user from temporary table
        $delQuery = "DELETE FROM Tempusers WHERE confirmkey = '$confirmationKey'";
        $this->conn->query($delQuery);

        // Commit transaction changes
        $this->conn->commit();
        return true;
    }

    public function validatePasswd($email, $passwd) {
        $email = $this->escape_string($email);
        $passwd = $this->escape_string($passwd);

        $checkQuery = "SELECT password, type FROM Users WHERE email='$email';";
        $resultCursor = $this->conn->query($checkQuery);

        if (!$resultCursor) {
            error_log("db_operations: Error querying the password in db.");
            return false;
        }

        $assoc_res = $resultCursor->fetch_assoc();
        $passInDb = $assoc_res["password"];
        $type = $assoc_res["type"];

        $resultCursor->close();

        // Checks if typed password matches with hashed one in db
        if (password_verify($passwd, $passInDb)) {
            if ($type ==  3) {
                return "admin";
            }
            else {
                return "regular";
            }
        }
        return false;
    }

    public function isAdmin($cookie) {
        $type = $this->getUserInfoFromSessionCookie($cookie)["type"];

        if ($type == 3) return true;
        else return false;
    }

    public function escape_string($string) {
        return $this->conn->real_escape_string($string);
    }

}

?>
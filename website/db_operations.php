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

        $query = "SELECT name, email, type, grr, cardId, balance FROM Users WHERE email = '$cookie';";
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
        $cardId = getUserInfoFromSessionCookie($cookie)["cardId"];

        $query = "SELECT Transactions.tranId, Transactions.tranTime, Transactions.value, Transactions.type, Restaurants.restName FROM Transactions LEFT JOIN Restaurants ON Transactions.restId=Restaurants.restId WHERE Transactions.cardId='$cardId' ORDER BY Transactions.tranTime DESC LIMIT 5;";

        return $this->conn->query($query);
    }

    public function isUserInDb($email, $cardId = NULL) {
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
    public function insertUserInTemporaryTable($cardId, $name, $email, $passwd, $grr, $roleNumber) {

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
          '$id','$name','$email','$passwdHashed','$grr','$roleNumber','$regdate','$confirmationKey')";
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
        $query = "SELECT * FROM Tempusers WHERE confirmkey = '$confirmationKey'";
        $result = $this->conn->query($query);

        if (!$result) {
            error_log("db_operations: Error when querying db.");
            return false;
        }

        if ($result->num_rows != 1) {
            error_log("db_operations: Unexpected number of rows after query in temporary users table.");
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
        $expdate = date_add($date,date_interval_create_from_date_string("10 years"));
        $expdate = date_format($expdate,"Y-m-d");

        $addQuery = "INSERT INTO Users (
            cardId,name,email,password,grr,type,regdate,expdate) VALUES (
            '$cardId','$name','$email','$password','$grr','$type','$regdate','$expdate')";
        if (!$this->conn->query($addQuery)) {
            error_log("db_operations: Couldn't insert user in permanent table.");
            $this->conn->rollback();
            return false;
        }

        // Delete user from temporary table
        $delQuery = "DELETE FROM Tempusers WHERE confirmkey = '$key'";
        $this->conn->query($delQuery);

        // Commit transaction changes
        $this->conn->commit();
        return true;
    }

    public function isPasswordValid($email, $passwd) {
        $checkQuery = "SELECT password FROM Users WHERE email='$email';";
        $resultCursor = $this->conn->query($checkQuery);

        if (!$resultCursor) {
            error_log("db_operations: Error querying the password in db.");
            return false;
        }

        $passInDb = $resultCursor->fetch_assoc()["password"];
        $resultCursor->close();

        // Checks if typed password matches with hashed one in db
        return password_verify($passwd, $passInDb);
    }

}

?>
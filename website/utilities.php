<?php

// Validates a cookie received from a client.
// Returns true if cookie is valid, false otherwise
function validateCookie($cookie) {
    $secretKey = '***SECRET_KEY***' ;

    $splitCookie = explode("|", $cookie);
    $numElements = count($splitCookie);
    // Parse number of elements in cookie
    if ($numElements != 2) {
        return false;
    }

    // Check if user is in db
    if (!userInDb($splitCookie[0])) {
        return false;
    }

    // Check if cookie hash is correct
    if (hash_hmac("sha256", $splitCookie[0], $secretKey) === $splitCookie[1]) {
        return true;
    }
    else {
        return false;
    }
}

// Creates a secure cookie using hmac with a secret key
function createSecureCookie($email) {
    $secretKey = '***SECRET_KEY***';
    return $email . "|" . hash_hmac("sha256", $email, $secretKey);
}

// Deletes session cookie
function deleteCookie() {
    setcookie("session", "", time()-36000, "/", "arion.ddns.net");
    return;
}

// Checks if the email and passwd sent to server matches the ones in db
function validateEmailAndPasswd($email, $passwd) {
    $dbhost = 'localhost';
    //$dbhost = 'arion.ddns.net';
    $dbuser = 'form';
    $dbpass = '***PASSWD***';
    $dbname = 'arion';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Checks if successfully connected to db
    if($conn->connect_errno) {
        showErrorMessage("Nosso sistema está com dificuldades técnicas no momento.
        Por favor, tente novamente mais tarde.");
    }

    $email = $conn->real_escape_string($email);
    $checkQuery = "SELECT password FROM Users WHERE email='$email';";
    $resultCursor = $conn->query($checkQuery);

    if (!$resultCursor) {
        // Error in query
        return false;
    }

    $dbPass = mysql_fetch_assoc($resultCursor);
    $resultCursor->close();
    $conn->close();

    if (password_verify($passwd, $dbPass)) {
        // Password is valid
        return true;
    }
    return false;
}

// Checks if a given user name is in the database
// Returns true if one or more entries were found, false otherwise
function userInDb($email) {
    $dbhost = 'localhost';
    //$dbhost = 'arion.ddns.net';
    $dbuser = 'form';
    $dbpass = '***PASSWD***';
    $dbname = 'arion';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Checks if successfully connected to db
    if($conn->connect_errno) {
        showErrorMessage("Nosso sistema está com dificuldades técnicas no momento.
        Por favor, tente novamente mais tarde.");
    }

    $email = $conn->real_escape_string($email);
    $checkQuery = "SELECT * FROM Users WHERE email='$email';";
    $resultCursor = $conn->query($checkQuery);
    if (mysql_num_rows($resultCursor) >= 1) {
        $resultCursor->close();
        $conn->close();
        return true;
    }
    $resultCursor->close();
    $conn->close();
    return false;
}

// TODO: Implement passwd file read
/*
class Keys {
    public $userDb;
    public $passwdDb;
    public $secretKeyCaptcha;
    public $userEmail;
    public $passwdEmail;
    public $secretKeyCookie;

    function __construct() {
        $mKeys = file_get_contents("../../../keys");
        $lines = explode("\n", $mKeys);
        foreach ($lines as $line) {
            $key
        }
    }
}
*/

?>
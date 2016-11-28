<?php

// Validates a cookie received from a client.
// Returns true if cookie is valid, false otherwise
function validateCookie($cookie) {
    $secretKey = Keys::getCookieSecretKey() ;

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
    $secretKey = Keys::getCookieSecretKey();
    return $email . "|" . hash_hmac("sha256", $email, $secretKey);
}

// Deletes session cookie
function deleteCookie() {
    setcookie("session", "", time()-36000, "/", "arion.ddns.net");
    return;
}

function extractEmailFromCookie($cookie) {
    $splitCookie = explode("|", $cookie);
    return $splitCookie[0];
}

// Checks if the email and passwd sent to server matches the ones in db
function validateEmailAndPasswd($email, $passwd) {
    $dbhost = 'localhost';
    //$dbhost = 'arion.ddns.net';
    $dbuser = Keys::getDbUser();
    $dbpass = Keys::getDbPasswd();
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

    $passInDb = $resultCursor->fetch_assoc()["password"];
    $resultCursor->close();
    $conn->close();

    // Checks if typed password matches with hashed one in db
    return password_verify($passwd, $passInDb);
}

// Checks if a given user name is in the database
// Returns true if one or more entries were found, false otherwise
function userInDb($email) {
    $dbhost = 'localhost';
    //$dbhost = 'arion.ddns.net';
    $dbuser = Keys::getDbUser();
    $dbpass = Keys::getDbPasswd();
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
    if ($conn->affected_rows >= 1) {
        $resultCursor->close();
        $conn->close();
        return true;
    }
    $resultCursor->close();
    $conn->close();
    return false;
}

// Class containing the functions to retrieve passwords stored in file
class Keys {

    public static function getDbUser() {
        return Keys::getFileArray()[0];
    }
    public static function getDbPasswd() {
        return Keys::getFileArray()[1];
    }
    public static function getCaptchaKey() {
        return Keys::getFileArray()[2];
    }
    public static function getEmailPasswd() {
        return Keys::getFileArray()[3];
    }
    public static function getCookieSecretKey() {
        return Keys::getFileArray()[4];
    }

    static function getFileArray() {
        $mKeys = file_get_contents("../../../keys");
        return explode("\n", $mKeys);
    }

}

?>
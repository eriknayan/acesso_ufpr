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

    require_once("db_operations.php");
    $db = new DBOperator();

    // Check if user is in db
    if (!$db->isUserInDb($splitCookie[0])) {
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
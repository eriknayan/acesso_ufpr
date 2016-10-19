<?php

function showErrorMessage($msg) {
    $_SESSION['Error'] = $msg;
    include('login_page.php');
    die();
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
    $checkQuery = "SELECT * FROM Users WHERE name='$email';";
    $resultCursor = $conn->query($checkQuery);
    if ($resultCursor >= 1) {
        $resultCursor->close();
        $conn->close();
        return true;
    }
    $resultCursor->close();
    $conn->close();
    return false;
}

// Validates a cookie received from a client.
// Returns true if cookie is valid, false otherwise
function validateCookie($cookie, $secretKey) {

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

function createSecureCookie($email, $secretKey) {
    return $email . "|" . hash_hmac("sha256", $email, $secretKey);
}

if($_SERVER['REQUEST_METHOD'] == "GET") {
    // Shows login page in case no data was posted to server
    include("login_page.php");
    die();
}
else {

    // In case post to site didn't contain email, password or cookie, show error message
    if ((empty($_POST["email"]) || empty($_POST["passwd"])) && !isset($_COOKIE["sess"])) {
        showErrorMessage("Email ou senha não foram fornecidos.");
    }

    $secretKey = "***SECRET***";

    // Validate by cookie
    if (isset($_COOKIE["sess"])) {
        if (validateCookie($_COOKIE["sess"], $secretKey)) {
            // Valid cookie, go to welcome page
            die();
        }
        else {
            // Invalid cookie
            showErrorMessage("Erro no login, por favor tente novamente.");
        }
    }

    if (isset($_POST["remember"])) {
        // Expires in 60 days
        // TODO: Change secure flag to true after HTTPS is implemented
        setcookie("sess", createSecureCookie($email, $secretKey), time()+60*60*24*60, "/", "arion.ddns.net", false, true);

    }

}


?>
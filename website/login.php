<?php

require_once("utilities.php");

function showErrorMessage($msg) {
    $_SESSION['Error'] = $msg;
    include('login_page.php');
    die();
}

if($_SERVER['REQUEST_METHOD'] == "GET") {

    //Check if logout was requested
    if (isset($_GET["logout"])) {
        // Delete cookie
        deleteCookie();
    }

    // Checks if cookie is set for this connection
    else if (isset($_COOKIE["session"])) {
        if (validateCookie($_COOKIE["session"])) {
            // If cookie is valid, redirect to home page
            header("Location: welcome.php");
            die();
        }
        else {
            // If cookie is invalid, erase it
            deleteCookie();
        }
    }
    // Shows login page in case no data was posted to server and no cookie was set
    include("login_page.php");
    die();
}
// Executed when email and passwd are sent to login
else {

    // In case post to site didn't contain email, password or cookie, show error message
    if ((empty($_POST["email"]) || empty($_POST["passwd"])) && !isset($_COOKIE["session"])) {
        showErrorMessage("Email ou senha não foram fornecidos.");
    }

    // Validate by cookie
    if (isset($_COOKIE["session"])) {
        if (validateCookie($_COOKIE["session"])) {
            // Valid cookie, go to welcome page
            header("Location: welcome.php");
            die();
        }
        else {
            // Invalid cookie, reset it and output error message
            deleteCookie();
            showErrorMessage("Erro no login. Por favor tente novamente.");
        }
    }

    require_once("db_operations.php");
    $db = new DBOperator();

    if ($db->isPasswordValid($_POST["email"], $_POST["passwd"])) {
        // Validated! Redirect to welcome page. Check how to validate email and passwd again after redirect

        if (isset($_POST["remember"])) {
            // Expires in 60 days, httponly
            // TODO: Change secure flag to true after HTTPS is implemented
            setcookie("session", createSecureCookie($_POST["email"]), time()+60*60*24*60, "/", "arion.ddns.net", false, true);
        }
        else {
            // Expires at the end of session (when browser is closed), httponly
            // TODO: Change secure flag to true after HTTPS is implemented
            setcookie("session", createSecureCookie($_POST["email"]), 0, "/", "arion.ddns.net", false, true);
        }
        // Redirects to welcome page
        header("Location: welcome.php");
    }
    else {
        showErrorMessage("Login ou senha inválidos. Por favor tente novamente.");
    }

}
?>
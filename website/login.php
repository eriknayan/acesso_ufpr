<?php

session_start();

require_once("utilities.php");
require_once("db_operations.php");

function showErrorMessage($msg) {
    $_SESSION['Error'] = $msg;
    include('login_page.php');
    die();
}

if (isset($_GET["logout"])) {
    // Delete cookie
    deleteCookie();
}

if (isset($_COOKIE["session"])) {
    $type = validateCookie($_COOKIE["session"]);
    if ($type == "admin") {
        header("Location: restricted.php");
    }
    else if ($type == "regular") {
        header("Location: welcome.php");
    }
    else {
        deleteCookie();
        include('login_page.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST["email"]) || empty($_POST["passwd"])) {
        showErrorMessage("Email ou senha não foram fornecidos.");
    }
    $db = new DBOperator();

    $type = $db->validatePasswd($_POST["email"], $_POST["passwd"]);
    if ($type) {
        if (isset($_POST["remember"])) {
            // Expires in 60 days, httponly
            // TODO: Change secure flag to true after HTTPS is implemented
            setcookie("session", createSecureCookie($_POST["email"]), time()+60*60*24*60, "/", "arionufpr.ddns.net", false, true);
        }
        else {
            // Expires at the end of session (when browser is closed), httponly
            // TODO: Change secure flag to true after HTTPS is implemented
            setcookie("session", createSecureCookie($_POST["email"]), 0, "/", "arionufpr.ddns.net", false, true);
        }
        if ($type == "admin") {
            header("Location: restricted.php");
        }
        else if ($type == "regular") {
            header("Location: welcome.php");
        }
    }
    else {
        showErrorMessage("Erro no login. Por favor tente novamente.");
    }
}

if (($_SERVER['REQUEST_METHOD'] == "GET" && !isset($_COOKIE["session"])) || isset($_GET["logout"])) {
    include("login_page.php");
    exit();
}
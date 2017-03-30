<?php
if ($_SERVER["REQUEST_METHOD"] === 'GET') {
    // Shows registration form in case no data was posted to server
    include("register_page.php");
    die();
}
// If data was posted to server, validate and add to db
else {
    function showErrorMessage($msg) {
        $_SESSION['Error'] = $msg;
        include('register_page.php');
        die();
    }

// Checks if all fields were filled
    if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["grr"])
        || empty($_POST["barcode"]) || empty($_POST["passwd"]) || empty($_POST["role"])) {
        // Shows error message
        showErrorMessage("Um ou mais campos preenchidos são inválidos. Por favor tente novamente.");
    }

    require("captcha_validation.php");
    if (!validateCaptcha($_POST["g-recaptcha-response"])) {
        // Captcha failed to validate, show error page
        showErrorMessage("Erro na validação do captcha. Por favor tente novamente.");
    }

    require_once("db_operations.php");
    $db = new DBOperator();

    // Validate input from POST parameters
    // TODO: fix regex of preg_match call
    if (/*!preg_match("[A-Za-z\x20áàãâéèêóòõô]", $_POST["name"]) ||*/ !ctype_digit($_POST["grr"]) ||
        !ctype_digit($_POST["barcode"]) || ($_POST["role"] != "Estudante" && $_POST["role"] != "Professor" &&
            $_POST["role"] != "Servidor") || strlen($_POST["name"]) > 50 || strlen($_POST["email"]) > 50 ||
        strlen($_POST["passwd"]) > 35 || strlen($_POST["grr"]) > 8 || strlen($_POST["barcode"]) > 12) {
        showErrorMessage("Um ou mais campos preenchidos são inválidos. Por favor tente novamente.");
    }

    if ($db->isUserInDb($_POST["email"], $_POST["barcode"])) {
        showErrorMessage("O usuário que você está tentando cadastrar já existe.");
    }

    $key = $db->insertUserInTemporaryTable($_POST["barcode"], $_POST["name"], $_POST["email"], $_POST["passwd"], $_POST["grr"], $_POST["role"]);
    if (!$key) {
        showErrorMessage("Tivemos um erro ao cadastrá-lo. Por favor tente novamente mais tarde");
    }

    require("send_email.php");
    if (!sendEmail($_POST["name"], $_POST["email"], $key)) {
        showErrorMessage("Tivemos um erro ao enviar seu email. Tente novamente em 72 horas.");
    }

    // TODO: Implement front-end for register_success.php
    header("Location: register_success.php");
}
?>
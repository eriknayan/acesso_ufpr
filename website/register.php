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

// Extract values from POST parameters
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $grr = $conn->real_escape_string($_POST["grr"]);
    $id = $conn->real_escape_string($_POST["barcode"]);
    $passwd = $conn->real_escape_string($_POST["passwd"]);
    $role = $conn->real_escape_string($_POST["role"]);

// Validate input from POST parameters
// TODO: fix regex of preg_match call
    if (/*!preg_match("[A-Za-z\x20áàãâéèêóòõô]", $name) ||*/ !ctype_digit($grr) ||
        !ctype_digit($id) || ($role != "Estudante" && $role != "Professor" &&
            $role != "Servidor") || strlen($name) > 50 || strlen($email) > 50 ||
        strlen($passwd) > 35 || strlen($grr) > 8 || strlen($id) > 12) {
        showErrorMessage("Um ou mais campos preenchidos são inválidos. Por favor tente novamente.");
    }

    if ($db->isUserInDb($email, $id)) {
        showErrorMessage("O usuário que você está tentando cadastrar já existe.");
    }

// Converts our role string to a correspondent number before inserting into the db
    $roleToNumber = array (
        "Estudante" => 0,
        "Professor" => 1,
        "Servidor" => 2
    );
    $roleNumber = $roleToNumber[$role];

    $key = $db->insertUserInTemporaryTable($id, $name, $email, $passwd, $grr, $roleNumber);
    if (!$key) {
        showErrorMessage("Tivemos um erro ao cadastrá-lo. Por favor tente novamente mais tarde");
    }

    require("send_email.php");
    if (!sendEmail($name, $email, $key)) {
        showErrorMessage("Tivemos um erro ao enviar seu email. Tente novamente em 72 horas.");
    }

    // TODO: Implement front-end for register_success.php
    header("Location: register_success.php");
}
?>
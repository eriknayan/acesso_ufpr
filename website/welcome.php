<?php

session_start();

require_once("utilities.php");

if (!isset($_COOKIE["session"])) {
    // Redirect to login page in case there are no session cookies
    header("Location: login.php");
}
if (!validateCookie($_COOKIE["session"])) {
    // Redirect to login page in case the session cookie is invalid
    header("Location: login.php?logout=true");
}

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

    $email_cookie = extractEmailFromCookie($_COOKIE["session"]);

    $query = "SELECT name, email, type, grr, cardId FROM Users WHERE email = '$email_cookie';";
    $result = $conn->query($query);

    $row = $result->fetch_assoc();

// Copies values to session variables
    $_SESSION["name"] = $row["name"];
    $_SESSION["email"] = $row["email"];
    $_SESSION["role"] = $row["type"];
    $_SESSION["grr"] = $row["grr"];
    $_SESSION["cardId"] = $row["cardId"];

?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="css/welcome.css">
    <title>Acesso RU UFPR - Início</title>
    <meta name="description" content="O sistema de acesso oficial da UFPR">
</head>
<body>
    <div class="container">
        <!-- HEADER SECTION -->
        <?php include("header.php"); ?>
        <!-- MENU SECTION -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Arion</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Saldo</a></li>
                    <li><a href="#">Recarga</a></li>
                    <li><a href="#">Transações</a></li>
                    <li><a href="/personalinfo.php">Informações pessoais</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="login.php?logout=true" class="navbar-left"><img src="images/logout.svg" class="logout-img">Sair</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- BALANCE SECTION -->
        <div class="row text-center">
            <div class="col-xs-12">
                <h3>Bem-vindo <?php echo 'Pedro' ?>!</h3>
                <h3 class="section-margin">Seu saldo é de: <?php echo 'R$' . '10,00'; ?></h3>
                <a href="#">Faça uma recarga aqui</a>
                <h3 class="section-margin">Suas últimas 5 transações foram:</h3>
                <table class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Data e Hora</th>
                            <th>Transação</th>
                            <th>Valor</th>
                            <th>Local</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // TODO: Change static table to dynamic
                        ?>
                        <tr>
                            <td>12345</td>
                            <td>21/07/2016 12:25:30</td>
                            <td>Almoço RU</td>
                            <td>1,30</td>
                            <td>Centro Politécnico</td>
                        </tr>
                        <tr>
                            <td>13466</td>
                            <td>23/07/2016 12:25:30</td>
                            <td>Almoço RU</td>
                            <td>1,30</td>
                            <td>Reitoria</td>
                        </tr>
                        <tr>
                            <td>74462</td>
                            <td>24/07/2016 12:25:30</td>
                            <td>Lanche</td>
                            <td>1,30</td>
                            <td>Cantina 1</td>
                        </tr>
                        <tr>
                            <td>39847</td>
                            <td>25/07/2016 12:25:30</td>
                            <td>Lanche</td>
                            <td>1,30</td>
                            <td>Cantina 2</td>
                        </tr>
                        <tr>
                            <td>46823</td>
                            <td>26/07/2016 18:25:30</td>
                            <td>Janta RU</td>
                            <td>1,30</td>
                            <td>Agrárias</td>
                        </tr>
                    </tbody>
                </table>
                <a href="#">Veja seu histórico completo aqui</a>
            </div>
        </div>
    </div>
</body>
</html>
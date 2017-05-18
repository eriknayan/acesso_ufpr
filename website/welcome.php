<?php

session_start();

require_once("utilities.php");
require_once("db_operations.php");

if (!isset($_COOKIE["session"])) {
    // Redirect to login page in case there are no session cookies
    header("Location: login.php");
}
if (!validateCookie($_COOKIE["session"])) {
    // Redirect to login page in case the session cookie is invalid
    header("Location: login.php?logout=true");
}

    $db = new DBOperator();
    $info = $db->getUserInfoFromSessionCookie($_COOKIE["session"]);

    if (!$info) {
        die();
    }
    else {
        // Puts info in session variables
        $_SESSION["name"] = $info["name"];
        $_SESSION["email"] = $info["email"];
        $_SESSION["role"] = $info["type"];
        $_SESSION["grr"] = $info["grr"];
        $_SESSION["cardId"] = $info["cardId"];
        $_SESSION["balance"] = $info["balance"];
    }

    if (!isset($_SESSION["transactions"])) {
        $transactions = $db->getLastFiveTransactions($_COOKIE["session"]);
        if (!$transactions) {
            die();
        }
        else {
            $_SESSION["transactions"] = $transactions;
        }
    }
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
                    <a class="navbar-brand" href="/index.php">
                        <img alt="Arion" src="/images/favicon.ico">
                    </a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Saldo</a></li>
                    <li><a href="/recharge.php">Recarga</a></li>
                    <li><a href="#">Transações</a></li>
                    <li><a href="/personalinfo.php">Informações pessoais</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="login.php?logout=true" class="navbar-left">
                            <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>Sair
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- BALANCE SECTION -->
        <div class="row text-center">
            <div class="col-xs-12">
                <h3>Bem-vindo <?php echo $_SESSION["name"] ?>!</h3>
                <h3 class="section-margin">Seu saldo é de: <?php echo 'R$' . $_SESSION["balance"]; ?></h3>
                <a href="/recharge.php">Faça uma recarga aqui</a>
                <h3 class="section-margin">Suas últimas 5 transações foram:</h3>
                <table class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Data e Hora</th>
                            <th>Valor</th>
                            <th>Local</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fill up table dynamically
                        while ($row = $_SESSION["transactions"]->fetch_array()) {
                            echo "<tr>";
                            echo "<td>" . $row["tranId"] . "</td>";
                            echo "<td>" . $row["tranTime"] . "</td>";
                            if ($row["type"]) { echo "<td>" . $row["value"] . "</td>"; }
                            else { echo "<td>-" . $row["value"] . "</td>"; }
                            echo "<td>" . $row["restName"] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <a href="#">Veja seu histórico completo aqui</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php

    require_once('utilities.php');
    require_once('db_operations.php');

    if (empty($_GET["k"])) {
        die ("Missing confirmation key");
    }

    $key = $_GET["k"];

    require_once("db_operations.php");
    $db = new DBOperator();

    if (!$db->insertUserInPermanentTable($key)) {
        die("Tivemos um erro ao confirmar seu usuário. Tente confirmar ou criar sua conta novamente.");
    }

    header("refresh:5;url=login.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Acesso RU UFPR - Confirmação</title>
    <meta name="description" content="O sistema de acesso oficial da UFPR">
</head>
<body>
    <div class="container">
        <!-- HEADER SECTION -->
        <?php include("header.php"); ?>

        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-success text-center">
                    Obrigado! Sua conta foi ativada com sucesso!<br>
                    Você será redirecionado em 5 segundos.
                </div>
            </div>
        </div>
    </div>
</body>
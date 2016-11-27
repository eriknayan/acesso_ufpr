<?php
require("utilities.php");

if (!isset($_COOKIE["session"])) {
    // Redirect to login page in case there are no session cookies
    header("Location: login.php");
}
if (!validateCookie($_COOKIE["session"])) {
    // Redirect to login page in case the session cookie is invalid
    header("Location: login.php?logout=1");
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
                    <a class="navbar-brand" href="#">Arion</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="/welcome.php">Saldo</a></li>
                    <li><a href="#">Recarga</a></li>
                    <li><a href="#">Transações</a></li>
                    <li class="active"><a href="#">Informações pessoais</a></li>
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
                <h3>Dados cadastrais de <?php echo $_SESSION['name']?></h3>
            </div>
        </div>
            <!-- REGISTRATION FIELDS -->
        <div class="row section-margin">
            <div class="col-sm-4 col-sm-offset-4">
                <form name=PersonalInfo role="form">
                  <!-- NOME -->
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" name=name class="form-control" id=name value=<?php echo $_SESSION['name']?> readonly>
                    </div>
                    <!-- EMAIL -->
                    <div class="form-group">
                        <label for="email">Endereço de Email</label>
                        <input type="text" name=email class="form-control" id=email value=<?php echo $_SESSION['email']?> readonly>
                    </div>
                    <!-- VINCULO -->
                    <div class="form-group">
                        <label for="role">Vínculo com a UFPR</label>
                        <input type="text" name=role class="form-control" id=role value=<?php echo $_SESSION['role']?> readonly>
                    </div>
                    <!-- GRR -->
                    <div class="form-group">
                        <label for="grr">Número de matrícula (GRR)</label>
                        <input type="text" name=GRR class="form-control" id=grr value=<?php echo $_SESSION['grr']?> readonly>
                    </div>
                    <!-- NUM. CARTEIRINHA -->
                    <div class="form-group">
                        <label for="cardId">Número da carteirinha</label>
                        <input type="text" name=cardId class="form-control" id=cardId value=<?php echo $_SESSION['cardId']?> readonly>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>


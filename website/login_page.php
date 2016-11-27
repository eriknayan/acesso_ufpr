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
    <title>Acesso RU UFPR - Cadastro</title>
    <meta name="description" content="O sistema de acesso oficial da UFPR">
</head>
<body>
<div class="container">
    <!-- HEADER SECTION -->
    <?php include("header.php"); ?>

    <!-- CHECKS IF ANY ERROR OCCURED IN LOGIN.PHP -->
    <?php
    if (isset($_SESSION['Error'])) {
        echo '
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4 text-center">
                <div class="alert alert-danger">
                    ' . $_SESSION['Error'] . '
                </div>
            </div>
        </div>';
    }
    ?>

    <!-- LOGIN FIELDS -->
    <div class="row form-margin">
        <div class="col-sm-4 col-sm-offset-4">
            <form role="form" method="post">
                <div class="form-group">
                    <label for="emailInput">Endereço de Email</label>
                    <input type="email" name="email" class="form-control" id="emailInput" placeholder="Digite seu email" autofocus>
                </div>
                <div class="form-group">
                    <label for="passwordInput">Senha</label>
                    <input type="password" name="passwd" class="form-control" id="passwordInput" placeholder="Senha">
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="remember" value="checked">Lembre-se do usuário</label>
                </div>
                <button type="submit" class="btn btn-default">Login</button>
            </form>
        </div>
    </div>
    <!-- FOOTER SECTION -->
    <?php include("footer.php") ?>
</body>
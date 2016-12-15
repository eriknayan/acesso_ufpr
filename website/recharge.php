<?php

session_start();

require_once("utilities.php");

if (!isset($_COOKIE["session"])) {
    // Redirect to login page in case there are no session cookies
    header("Location: login.php");
}
if (!validateCookie($_COOKIE["session"])) {
    // Redirect to login page in case the session cookie is invalid
    header("Location: login.php?logout=1");
}

require_once("db_operations.php");
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

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/validator.min.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
    <script type="text/javascript" src="js/card.js"></script>
    <link rel="stylesheet" href="css/recharge.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="css/welcome.css">
    <title>Acesso RU UFPR - Recarga</title>
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
                    <li class="active"><a href="#">Recarga</a></li>
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
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <p>Para realizar uma recarga, preencha os dados do seu cartão de crédito abaixo. Todas as informações enviadas são seguras.</p>
                <div class="panel panel-default credit-card-box">
                    <div class="panel-heading display-table" >
                        <div class="row display-tr" >
                            <h3 class="panel-title display-td" >Detalhes de pagamento</h3>
                            <div class="display-td" >
                                <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form role="form" id="payment-form" method="POST" action="javascript:void(0);">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                    <label for="cardId">Cartão a ser recarregado</label>
                                    <input type="text" name=cardId class="form-control" id=cardId value="<?php echo $_SESSION['cardId']?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Valor da Recarga</label>
                                        <select class="form-control" name="value">
                                            <option>R$ 10,00</option>
                                            <option>R$ 20,00</option>
                                            <option>R$ 30,00</option>
                                            <option>R$ 50,00</option>
                                            <option>R$ 100,00</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="cardNumber">Número do cartão de crédito</label>
                                        <div class="input-group">
                                            <input
                                                type="tel"
                                                class="form-control"
                                                name="cardNumber"
                                                placeholder="Número do cartão"
                                                autocomplete="cc-number"
                                                required autofocus
                                            />
                                            <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="cardName">Nome no cartão</label>
                                        <input
                                            type="text"
                                            class="form-control caps-lock"
                                            name="cardName"
                                            placeholder="Nome no cartão"
                                            autocomplete="cc-name"
                                            required autofocus
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-7 col-md-7">
                                    <div class="form-group">
                                        <label for="cardExpiry">Data de validade</label>
                                        <input
                                            type="tel"
                                            class="form-control"
                                            name="cardExpiry"
                                            placeholder="MM / AA"
                                            autocomplete="cc-exp"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5 pull-right">
                                    <div class="form-group">
                                        <label for="cardCVC">Cód. Verificação</label>
                                        <input
                                            type="tel"
                                            class="form-control"
                                            name="cardCVC"
                                            placeholder="CVC"
                                            autocomplete="cc-csc"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button class="subscribe btn btn-success btn-lg btn-block" type="button">Realizar pagamento</button>
                                </div>
                            </div>
                            <div class="row" style="display:none;">
                                <div class="col-xs-12">
                                    <p class="payment-errors"></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
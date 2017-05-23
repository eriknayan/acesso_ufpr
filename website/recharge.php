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
            <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav-bar" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/index.php">
                        <img alt="Arion" src="/images/favicon.ico">
                    </a>
                </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="main-nav-bar">
                <!-- Searches users through ID or Card -->
                <div class="nav navbar-nav">
                    <li><a href="/restricted.php">Débitos</a></li>
                    <li><a href="/register_page.php">Cadastros</a></li>
                    <li><a href="#">Indicadores</a></li>
                    <li><a href="#">Tranferências</a></li>
                    <li class="active"><a href="/recharge.php">Recargas</a></li>
                </div>       
                <ul class="nav navbar-nav navbar-right">
                    <!-- Menus -->
                    <form class="navbar-form navbar-left">
                    <div class="input-group has-feedback">
                    <label for="userInput"></label>
                    <input type="text" name="cod" class="form-control" id="userInput" placeholder="Buscar usuário" min="100000000000" max="999999999999" maxlength="12" oninput="maxLengthCheck(this)" data-error="Número de carteirinha inválido" value="<?= $_GET['codigo_search'] ?>" />
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <div class="help-block with-errors"></div>
                    <span class="input-group-btn">
                        <a class="btn btn-default" href="#">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </a>
                        <a class="btn btn-default" href="http://zxing.appspot.com/scan?ret=http://arionufpr.ddns.net/restricted.php?codigo_search={CODE}" role="button">
                            <span class="glyphicon glyphicon-barcode" aria-hidden="true"></span>
                        </a>
                    </span>
                    </div>
                    </form>
                    <!-- Logout -->
                    <li>
                        <a href="login.php?logout=true" class="navbar-righ">
                            <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>Sair
                        </a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
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
                                        <select class="form-control" name="value" required="">
                                            <option value="" disabled selected>Selecione um valor</option>
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
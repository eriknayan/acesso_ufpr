<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="css/welcome.css">
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/validator.min.js"></script>
    <script src="js/jquery-3.1.0.min.js"></script>
    <title>Arion - Área Restrita</title>
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
            <div class="col-sm-4">
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
                <div class="nav navbar-nav">
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Menu <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="active"><a href="#">Débito</a></li>
                        <li><a href="#">Indicadores</a></li>
                        <li><a href="#">Tranferências</a></li>
                        <li><a href="/recharge.php">Recargas</a></li>
                    </ul>
                    </li>
                </div>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="col-sm-8">
            <div class="collapse navbar-collapse" id="main-nav-bar">
                <!-- Searches users through ID or Card -->
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
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="login.php?logout=true" class="navbar-righ">
                            <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>Sair
                        </a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
            </div>
            </div><!-- /.container-fluid -->
        </nav>
        <!-- READER SECTION -->
        <div class="barcode-reader text-center">
            <h1 class="text-uppercase sub-title"> Débito de carteirinha</h1>
            <img src="images/barcode.svg" class="img-responsive center-block img-feature smartphone" alt="Barcode" height="180" width="180">
            <!--  CÓDIGO DA CARTEIRINHA -->
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="input-group has-feedback">
                    <label for="codInput"></label>
                    <input type="text" name="cod" class="form-control" id="codInput" placeholder="Aperte ao lado para ler" min="100000000000" max="999999999999" maxlength="12" oninput="maxLengthCheck(this)" data-error="Número de carteirinha inválido" value="<?= $_GET['codigo_deb'] ?>" />
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <div class="help-block with-errors"></div>
                    <span class="input-group-btn">
                        <a class="btn btn-default" href="http://zxing.appspot.com/scan?ret=http://arionufpr.ddns.net/restricted.php?codigo_deb={CODE}" role="button">
                            <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
                        </a>
                    </span>
                    </div>
                </div>
            </div>
            <!-- READ RESULTS EXAMPLES 
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
                Débito realizado com sucesso. <strong> SALDO ATUAL: #### </strong> 
            </div> 
         
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
                <strong> Erro!</strong> Usuário já consumiu refeição. 
            </div> 
            
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
                <strong> Erro!</strong> Usuário não cadastrado no sistema Arion.
            </div>
            
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
                <strong> Erro!</strong> Saldo insuficiente.
            </div> //-->            
        </div>      
    </div>
</body>
</html>
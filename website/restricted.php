<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="css/welcome.css">
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
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img alt="Arion" src="/images/favicon.ico">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Débito</a></li>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Tranferências</a></li>
                    <li><a href="#">Recargas</a></li>
                </ul>
                <form class="navbar-form navbar-left">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Buscar usuário">
                    <div class="btn-group">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Ler carteirinha</a></li>
                    </ul>
                    </div>
                    </div>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="login.php?logout=true" class="navbar-left"><img src="images/logout.svg" class="logout-img">Sair</a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <!-- READER SECTION -->
        <div class="barcode-reader text-center">
            <h1 class="text-uppercase sub-title"> Leitura de carteirinha</h1>
            <img src="images/barcode.svg" class="img-responsive center-block img-feature" alt="Barcode" height="320" width="320">
            <p></p>
            <p class="lead">Clique no botão abaixo para realizar a leitura pelo <i>app</i>.</p>
            <p><a class="btn btn-lg btn-success" href="http://zxing.appspot.com/scan?ret=http://arionufpr.ddns.net/restricted.php?codigo={CODE}" role="button">Ler carteirinha</a></p>
            <!--  CÓDIGO DA CARTEIRINHA -->
            <div class="col-sm-4 col-sm-offset-4">
                <div class="form-group has-feedback">
                    <label for="codInput"></label>
                    <input type="text" name="cod" class="form-control" id="codInput" placeholder="Código da carteirinha" value="<?= $_GET['codigo'] ?>" />
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <div class="help-block with-errors"></div>
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
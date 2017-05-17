<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Acesso RU UFPR - Área Restrita</title>
    <meta name="description" content="O sistema de acesso oficial da UFPR">
</head>
<body>
    <div class="container">
        <!-- HEADER SECTION -->
        <?php include("header.php"); ?>
        <!-- READER SECTION -->
        <div class="barcode-reader text-center">
            <h1 class="text-uppercase sub-title"> Leitura de carteirinha</h1>
            <img src="images/barcode.svg" class="img-responsive center-block img-feature" alt="Barcode" height="320" width="320">
            <p></p>
            <p class="lead">Clique no botão abaixo para realizar a leitura pelo <i>app</i>.</p>
            <p><a class="btn btn-lg btn-success" href="http://zxing.appspot.com/scan?ret=http://arionufpr.ddns.net/restricted.php?codigo={CODE}" role="button">Ler carteirinha</a></p> <!--Chamada ao app Barcode Scanner
        <!--  CÓDIGO DA CARTEIRINHA -->
            <div class="col-sm-4 col-sm-offset-4">
                <div class="form-group has-feedback">
                    <label for="codInput"></label>
                    <input type="text" name="cod" class="form-control" id="codInput" placeholder="Código da carteirinha" value="<?= $_GET['codigo'] ?>" />
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <div class="help-block with-errors"></div>
                </div>           
            </div>
        </div>
    </div>
</body>
</html>
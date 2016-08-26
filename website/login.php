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
        <div class="row header">
            <div class="col-md-6 col-xs-6">
                <a href="index.html"><img src="images/ufprlogo.png" class="img-responsive" alt="Logo UFPR"></a>
            </div>
            <div class="col-md-6  col-xs-6 text-right">
                <h2>Acesso RU UFPR</h2>
                <h4>Eliminando a fila do seu RU</h4>
            </div>
        </div>
        <hr style="width: 100%; height: 1px; background-color:#868686;">
        <!-- LOGIN FIELDS -->
        <div class="row form-margin">
            <div class="col-sm-4 col-sm-offset-4">
                <form role="form">
                    <div class="form-group">
                        <label for="emailInput">Endereço de Email</label>
                        <input type="email" class="form-control" id="emailInput" placeholder="Digite seu email">
                    </div>
                    <div class="form-group">
                        <label for="passwordInput">Senha</label>
                        <input type="password" class="form-control" id="passwordInput" placeholder="Senha">
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox">Lembre-se do usuário</label>
                    </div>
                    <button type="submit" class="btn btn-default">Login</button>
                </form>
            </div>
        </div>
</body>
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
    <script src="js/validator.min.js"></script>
    <title>Acesso RU UFPR - Cadastro</title>
    <meta name="description" content="O sistema de acesso oficial da UFPR">
</head>
<body>
    <div class="container">
        <!-- HEADER SECTION -->
        <?php include("header.php"); ?>
        <!-- REGISTRATION FIELDS -->
        <div class="row form-margin">
            <div class="col-sm-4 col-sm-offset-4">
                <form action="result_registration.php" method="post" data-toggle="validator" role="form">
                    <!-- NOME -->
                    <div class="form-group has-feedback">
                        <label for="nameInput">Nome</label>
                        <input type="text" name="name" class="form-control" pattern="[A-Za-z\x20áàãâéèêóòõô]{1,}" id="nameInput" data-error="Nome não pode possuir números ou símbolos." placeholder="Digite seu nome" required autofocus>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <div class="help-block with-errors"></div>
                    </div>
                    <!-- EMAIL -->
                    <div class="form-group has-feedback">
                        <label for="emailInput">Endereço de Email</label>
                        <input type="email" name="email" class="form-control" id="emailInput" data-error="Email inválido" placeholder="Digite seu email" required>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <div class="help-block with-errors"></div>
                    </div>
                    <!-- CONFIRME EMAIL -->
                    <div class="form-group has-feedback">
                        <label for="emailInput">Confirme seu Email</label>
                        <input type="email" class="form-control" id="emailInput" data-match="#emailInput" data-match-error="Emails não conferem" placeholder="Confirme seu email" required>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <div class="help-block with-errors"></div>
                    </div>
                    <!-- VINCULO -->
                    <div class="form-group">
                        <label>Vínculo com a UFPR</label>
                        <select class="form-control" name="role">
                            <option>Estudante</option>
                            <option>Professor</option>
                            <option>Servidor</option>
                        </select>
                    </div>
                    <!-- GRR -->
                    <div class="form-group has-feedback">
                        <label for="grrInput">Número de Matrícula (GRR)</label>
                        <input type="number" name="grr" class="form-control" id="grrInput" placeholder="GRRXXXXXXXX" min="10000000" max="99999999" maxlength="8" oninput="maxLengthCheck(this)" data-error="GRR Inválido" required/>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <div class="help-block with-errors"></div>
                    </div>
                    <!-- NUM. CARTEIRINHA -->
                    <div class="form-group has-feedback">
                        <label for="grrInput">Número da carteirinha (Código de barras)</label>
                        <input type="number" name="barcode" class="form-control" placeholder="Carteirinha" min="10000000" max="99999999" maxlength="8" oninput="maxLengthCheck(this)" data-error="Número de carteirinha inválido" required/>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <div class="help-block with-errors"></div>
                    </div>
                    <!-- SENHA -->
                    <div class="form-group has-feedback">
                        <label for="passwordInput">Senha</label>
                        <input type="password" name="passwd" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" data-error="Senha deve conter no mínimo um número, uma letra maiúscula e uma minúscula, e 6 ou mais caracteres." id="passwordInput" placeholder="Senha" required>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <div class="help-block with-errors"></div>
                    </div>
                    <!-- CONFIRMAÇÃO DE SENHA -->
                    <div class="form-group has-feedback">
                        <label for="passwdConfirmInput">Confirme sua senha</label>
                        <input type="password" class="form-control" data-match="#passwordInput" data-match-error="Senhas não conferem" placeholder="Confirme sua senha" required>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <div class="help-block with-errors"></div>
                    </div>
                    <!-- BOTÃO ENVIAR -->
                    <button type="submit" class="btn btn-default">Enviar</button>
                </form>
            </div>
        </div>
    <!-- FOOTER SECTION -->
    <?php include("footer.php") ?>
</body>
<script type="text/javascript">
function maxLengthCheck(object) {
    if(object.value.length > object.maxLength)
        object.value = object.value.slice(0, object.maxLength)
}
</script>
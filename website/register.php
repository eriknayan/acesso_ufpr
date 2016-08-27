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

        <!-- REGISTRATION FIELDS -->
        <div class="row form-margin">
            <div class="col-sm-4 col-sm-offset-4">
                <form action="result_registration.php" method="post" data-toggle="validator" role="form">
                    <!-- NOME -->
                    <div class="form-group has-feedback">
                        <label for="nameInput">Nome</label>
                        <input type="text" class="form-control" pattern="[A-Za-z\x20áàãâéèêóòõô]{1,}" id="nameInput" data-error="Nome não pode possuir números ou símbolos." placeholder="Digite seu nome" required autofocus>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <div class="help-block with-errors"></div>
                    </div>
                    <!-- EMAIL -->
                    <div class="form-group has-feedback">
                        <label for="emailInput">Endereço de Email</label>
                        <input type="email" class="form-control" id="emailInput" data-error="Email inválido" placeholder="Digite seu email" required>
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
                        <select class="form-control">
                            <option>Estudante</option>
                            <option>Professor</option>
                            <option>Servidor</option>
                        </select>
                    </div>
                    <!-- GRR -->
                    <div class="form-group has-feedback">
                        <label for="grrInput">Número de Matrícula (GRR)</label>
                        <input type="number" class="form-control" id="grrInput" placeholder="GRRXXXXXXXX" min="10000000" max="99999999" maxlength="8" oninput="maxLengthCheck(this)" data-error="GRR Inválido" required/>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <div class="help-block with-errors"></div>
                    </div>
                    <!-- NUM. CARTEIRINHA -->
                    <div class="form-group has-feedback">
                        <label for="grrInput">Número da carteirinha (Código de barras)</label>
                        <input type="number" class="form-control" placeholder="Carteirinha" min="10000000" max="99999999" maxlength="8" oninput="maxLengthCheck(this)" data-error="Número de carteirinha inválido" required/>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <div class="help-block with-errors"></div>
                    </div>
                    <!-- SENHA -->
                    <div class="form-group has-feedback">
                        <label for="passwordInput">Senha</label>
                        <input type="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" data-error="Senha deve conter no mínimo um número, uma letra maiúscula e uma minúscula, e 6 ou mais caracteres." id="passwordInput" placeholder="Senha" required>
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
    <div class="row footer text-center">
        <div class="col-md-4">
            <a href="http://maps.google.com/?q=-25.449753,-49.232942" target="_blank">
                <img src="images/pin.png" class="img-responsive center-block img-footer" alt="Pino no mapa">
                <address>
                    <strong>Universidade Federal do Paraná</strong><br>
                    Centro Politécnico<br>
                    Curitiba, PR
                </address>
            </a>
        </div>
        <div class="col-md-4">
            <a href="mailto:pmantovani94@gmail.com">
                <img src="images/envelope.png" class="img-responsive center-block img-footer" alt="Contato email">
                <p>pmantovani94@gmail.com</ap>
            </a>
        </div>
        <div class="col-md-4">
            <a href="tel:+554191477772">
                <img src="images/telephone.png" class="img-responsive center-block img-footer" alt="Telefone">
                <p>+55 41 9147-7772</p>
            </a>
        </div>
    </div>
</body>
<script type="text/javascript">
function maxLengthCheck(object) {
    if(object.value.length > object.maxLength)
        object.value = object.value.slice(0, object.maxLength)
}
</script>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Acesso RU UFPR - Eliminando a fila do seu RU</title>
  <meta name="description" content="O sistema de acesso oficial da UFPR">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <div class="grid">
    <div class="row">
        <div class="col-6">
            <img src="http://placehold.it/100x70" width="20%" height="20%">
        </div>
        <div class="col-6">
            <p>Acesso RU UFPR</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 title">
        <p>O sistema de acesso e pagamento oficial dos restaurantes da UFPR</p>
        </div>
    </div>
    <div class="row">
        <button id="button1" class="buttons" onclick="changeButtonColor()"><a href="http://www.acessoufpr.ddns.net">Crie sua conta</a>
        </button>
        <button id="button2" class="buttons" onclick="changeButton2Color()"><a href="http://www.acessoufpr.ddns.net">Faça seu login</a></button>
    </div>
  </div>
</body>

<script type="text/javascript">
    function changeButtonColor() {
        document.getElementById("button1").style.backgroundColor = "red";
    }

    function changeButton2Color() {
        document.getElementById("button2").style.backgroundColor = "green";
    }
</script>
</html>

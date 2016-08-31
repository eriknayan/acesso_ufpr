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
<?php
    //$dbhost = 'localhost:3036';
    $dbhost = 'localhost';
    $dbuser = 'adminsql';
    $dbpass = '!acessoufpr_sql16';
    $dbname = 'acessoufpr';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if(! $conn ) {
        die('Could not connect: ' . mysql_error());
    }

    echo 'Connected successfully';

    $name = $_POST["name"];
    $email = $_POST["email"];

    $query = "INSERT INTO Users (name,email) VALUES ('$name','$email')";
    $retval = mysqli_query($conn, $query);

    if (! $retval) {
        die('Query failed: ' . mysql_error());
    }

    mysqli_close($conn);

?>

    Welcome <?php echo $_POST["name"]; ?><br>
Your email address is: <?php echo $_POST["email"]; ?>
</body>
</html>
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

    // Checks if all fields are set
    if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["grr"])
     && !empty($_POST["barcode"]) && !empty($_POST["passwd"]) && !empty($_POST["role"])) {}
    else {}

    //$dbhost = 'localhost:3036';
    $dbhost = 'acessupfr.ddns.net';
    $dbuser = 'form';
    $dbpass = '***PASSWD***';
    $dbname = 'arion';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // Checks if successfully connected to db 
    if(! $conn ) {
        die('Could not connect: ' . mysql_error());
    }

    $name = mysql_real_escape_string($_POST["name"]);
    $email = $_POST["email"];
    $grr = mysql_real_escape_string($_POST["grr"]);
    $id = mysql_real_escape_string($_POST["barcode"]);
    $passwd = md5(mysql_real_escape_string($_POST["passwd"]));
    $role = mysql_real_escape_string($_POST["role"]);
    // Creates random key used for confirmation
    $confirmkey = $username . $email . date('mY');
    $confirmkey = md5($confirmkey)

    $query = "INSERT INTO Tempusers (cardId,name,email,password,grr,type,balance,confirmkey)
     VALUES (
      '$id','$name','$email','$passwd','$grr','$role','0.00','$confirmkey')";
    $retval = mysqli_query($conn, $query);

    // Checks if insert was successful
    if (! $retval) {
        die('Query failed: ' . mysql_error());
    }

    mysqli_close($conn);

?>

    Welcome <?php echo $_POST["name"]; ?><br>
Your email address is: <?php echo $_POST["email"]; ?>
</body>
</html>
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

    // Checks if all fields were filled
    if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["grr"])
     || empty($_POST["barcode"]) || empty($_POST["passwd"]) || empty($_POST["role"])) {
        die ("Missing parameters");
    }

    require("captcha_validation.php");
    if (!validateCaptcha($_POST["g-recaptcha-response"])) {
        // Captcha failed to validate
        die ("Error in captcha validation <br>");
    }

    $dbhost = 'localhost';
    //$dbhost = 'arion.ddns.net';
    $dbuser = 'form';
    $dbpass = '***PASSWD***';
    $dbname = 'arion';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // Checks if successfully connected to db
    if(mysqli_connect_errno()) {
        die('Could not connect to MySQL database: ' . mysqli_connect_error());
    }

    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $grr = mysqli_real_escape_string($conn, $_POST["grr"]);
    $id = mysqli_real_escape_string($conn, $_POST["barcode"]);
    $passwd = md5(mysqli_real_escape_string($conn, $_POST["passwd"]));
    $role = mysqli_real_escape_string($conn, $_POST["role"]);
    // Creates random key used for confirmation
    $confirmkey = $username . $email . date('mY');
    $confirmkey = md5($confirmkey);

    $query = "INSERT INTO Tempusers (cardId,name,email,password,grr,type,balance,confirmkey)
     VALUES (
      '$id','$name','$email','$passwd','$grr','$role','0.00','$confirmkey')";
    $retval = mysqli_query($conn, $query);

    // Checks if insert was successful
    if (! $retval) {
        die('Error inserting in database: ' . mysqli_error());
    }

    mysqli_close($conn);

?>

    Welcome <?php echo $_POST["name"]; ?><br>
Your email address is: <?php echo $_POST["email"]; ?>
</body>
</html>
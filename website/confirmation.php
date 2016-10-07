<?php

    if (empty($_GET["k"])) {
        die ("Missing confirmation key");
    }

    $dbhost = 'localhost';
    //$dbhost = 'arion.ddns.net';
    $dbuser = 'form';
    $dbpass = '***PASSWD***';
    $dbname = 'arion';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Checks if successfully connected to db
    if($conn->connect_errno) {
        die('Could not connect to database: ' . $conn->connect_error);
    }

    $key = $_GET["k"];
    $key = $conn->real_escape_string($key);

    $query = "SELECT * FROM Tempusers WHERE confirmkey = '$key'";
    $result = $conn->query($query);

    // Result of query had an error
    if (!$result) {
        $conn->close();
        die('Error during query in database');
    }

    if ($result->num_rows == 0) {
        $result->free();
        $conn->close();
        die('User not found. Please create your account again.');
    }

    if ($result->num_rows > 1) {

        $delQuery = "DELETE FROM Tempusers WHERE confirmkey = '$key'";
        $conn->query($delQuery);
        $result->free();
        $conn->close();
        die('Error in validation, please create your account again.');
    }
    $row = $result->fetch_assoc();
    $result->free();

    // Add user into permanent table
    $cardId = $row['cardId'];
    $name = $row['name'];
    $email = $row['email'];
    $password = $row['password'];
    $grr = $row['grr'];
    $type = $row['type'];

    //Get current date
    $date = create_date();
    $regdate = date_format($date,"Y-m-d");
    $expdate = date_add($date,date_interval_create_from_date_string("10 years"));
    $expdate = date_format($expdate,"Y-m-d");

    $addQuery = "INSERT INTO Users (
        cardId,name,email,password,grr,type,regdate,expdate) VALUES (
        '$cardId','$name','$email','$password','$grr','$type','$regdate','$expdate')";
    if (!$conn->query($addQuery)) {
        die('Error while inserting to database: ' . $conn->error);
    }

    // Delete user from temporary table
    $delQuery = "DELETE FROM Tempusers WHERE confirmkey = '$key'";
    $conn->query($delQuery);

    // Commit transaction changes
    $conn->commit();
    $conn->close();

    echo "Hi " . $row["name"] . "!\n";
    echo "Thank you! Your account was activated successfully!";
?>


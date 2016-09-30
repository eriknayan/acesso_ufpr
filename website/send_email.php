<?php
    function sendEmail($name, $email, $key) {
        $to      = $email;
        $subject = 'Confirm your account at Arion';
        $message = 'Olá' . $name . "\r\n" .
            "Confirm your account at " . $key;
        $headers = 'From: pedro@arion.com' . "\r\n" .
            'Reply-To: pedro@arion.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
        return;
    }
?>
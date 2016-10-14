<?php
    function sendEmail($name, $email, $key) {
        // Includes phpmailer library
        require_once("class/PHPMailerAutoload.php");

        // Instantiates PHPMailer class
        $mail = new PHPMailer(true);

        // SMTP message type
        $mail->IsSMTP();

        try {
            $mail->Host = 'smtp.seudominio.com.br'; // SMTP server address
            $mail->SMTPAuth   = true;  // Use SMTP authentication
            $mail->Port       = 587; //  Use SMTP port 587
            $mail->Username = 'usuário de smtp'; // Username at SMTP server
            $mail->Password = 'senha de smtp'; // Password at SMTP server

            // Sender info
            $mail->SetFrom('seu@e-mail.com.br', 'Pedro Mantovani Antunes'); // Email and name
            $mail->AddReplyTo('seu@e-mail.com.br', 'Pedro Mantovani Antunes'); // Email and name
            $mail->Subject = 'Bem-vindo ao sistema Arion'; // Email subject

            // Receiver info
            $mail->AddAddress($email, $name);

            // Optional fields
            //$mail->AddCC('destinarario@dominio.com.br', 'Destinatario'); // CC
            //$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // BCC (hidden copy)
            //$mail->AddAttachment('images/phpmailer.gif'); // Add an attachment

            // Email body (html)
            $mail->MsgHTML("Olá " . $name . "! <br><br>
                Seja bem-vindo ao sistema Arion. Trabalhamos duro para diminuir a fila do seu Restaurante Universitário.<br><br>
                Mas antes, precisamos que ative sua conta com o link abaixo:
                <a href='arion.ddns.net/confirmation.php?k=" . $key . "'> Ative sua conta aqui!</a><br><br>
                Obrigado!
                Equipe Arion");


            // To include an html file instead
            //$mail->MsgHTML(file_get_contents('arquivo.html'));

            // Returns true if successful
            return $mail->Send();

            } catch (phpmailerException $e) {
                return false; // PHPMailer error message
        }
    }
?>
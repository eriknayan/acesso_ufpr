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
            $mail->SetFrom('seu@e-mail.com.br', 'Nome'); // Email and name
            $mail->AddReplyTo('seu@e-mail.com.br', 'Nome'); // Email and name
            $mail->Subject = 'Assunto'; // Email subject

            // Receiver info
            $mail->AddAddress($email, $name);

            // Optional fields
            //$mail->AddCC('destinarario@dominio.com.br', 'Destinatario'); // CC
            //$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // BCC (hidden copy)
            //$mail->AddAttachment('images/phpmailer.gif'); // Add an attachment

            // Email body (html)
            $mail->MsgHTML("Sua chave de ativamento é: " . $key);

            // To include an html file instead
            //$mail->MsgHTML(file_get_contents('arquivo.html'));

            if ($mail->Send()) {
                echo "Message sent successfuly";
            }
            else {
                echo "An error occurred while sending a message";
            }

            } catch (phpmailerException $e) {
                echo $e->errorMessage(); // PHPMailer error message
        }
    }
?>
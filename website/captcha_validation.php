<?php
    // Checks captcha validations
    function validateCaptcha($response) {
        $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
        // Data to be sent via POST method to recaptcha server
        $data = array('secret' => '***SECRET_KEY***', 'response' => $response);
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        // Sends request to server and gets the response
        $result = file_get_contents($url, false, $context);
        // If result is false, there was an error getting the response
        if ($result === FALSE) {
            /* Handle error */
            echo "Error getting response from catpcha server <br>";
            return false;
        }
        else {
            $json_res = json_decode($result, true);
            if (!$json_res["success"]) {
                // Recaptcha failed!
                echo "Error in captcha validation: <br>" . var_dump($json_res["error-codes"]);
                return false;
            }
            else {
                // Recaptcha was successful
                return true;
            }
        }
    }

?>
<?php
$SecretKey = "6LfyGr8ZAAAAAOSe853z3rrcHmU35_19btCtTSiH";
// require ReCaptcha class
require('vendor\google\recaptcha\src\autoload.php');

// message that will be displayed when everything is OK :)
$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';

// If something goes wrong, we will display this message.
$errorMessage = 'There was an error while submitting the form. Please try again later';


// let's do the sending

// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);

try {
    if (!empty($_POST)) {

        // validate the ReCaptcha, if something is wrong, we throw an Exception,
        // i.e. code stops executing and goes to catch() block

        if (!isset($_POST['g-recaptcha-response'])) {
//            die($_POST['g-recaptcha-response']);
            throw new \Exception('ReCaptcha is not set.');
        }

        // do not forget to enter your secret key from https://www.google.com/recaptcha/admin

        $recaptcha = new \ReCaptcha\ReCaptcha($SecretKey, new \ReCaptcha\RequestMethod\CurlPost());

        // we validate the ReCaptcha field together with the user's IP address
        $gRecaptchaResponse = getCaptcha($SecretKey);
        $response = $recaptcha->verify($gRecaptchaResponse, $_SERVER['REMOTE_ADDR']);
        if (!$response->isSuccess()) {
            throw new \Exception('ReCaptcha was not validated.');
        }
        $responseArray = array('type' => 'success', 'message' => $okMessage);
    }
} catch (\Exception $e) {
    $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
} else {
    echo $responseArray['message'];
}



function getCaptcha($SecretKey)
{
    if ($SecretKey) {
        // Input data
        $secret = '6LfyGr8ZAAAAAOSe853z3rrcHmU35_19btCtTSiH';
        $response = $_POST['g-recaptcha-response'];
        $remoteip = $_SERVER['REMOTE_ADDR'];

        $url = "https://www.google.com/recaptcha/api/siteverify";

        $post_data = http_build_query(
            [
                'secret' => $secret,
                'response' => $response,
                'remoteip' => $remoteip
            ]
        );
        $options = [
            // If site has SSL then
//            'ssl' => [
//                // In my case its /etc/ssl/certs/cacert.pem
//                'cafile' => '/path/to/cacert.pem',
//                'verify_peer' => true,
//                'verify_peer_name' => true,
//            ],
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $post_data
            ]
        ];
        $context = stream_context_create($options);
        $Resposta = file_get_contents($url, false, $context);
        $Retorno = json_decode($Resposta);

        return $Retorno;
    }
}

function returnCaptcha($gRecaptchaResponse)
{
    echo "entrou calss_captcha";
    $EnviaMail = False;

    if ($gRecaptchaResponse->success == true && $gRecaptchaResponse->score > 0.5) {
        $EnviaMail = True;
    } else {
        $EnviaMail = False;s
    }
    return $EnviaMail;
}

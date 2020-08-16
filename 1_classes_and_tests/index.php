<?php
const MaxLoginTries = 3;    // number of login tries

if ($_POST) {
    session_start();
    $token = (isset($_SESSION['id']['token'])) ?  $_SESSION['id']['token'] : md5(uniqid(rand(), true));
    $_SESSION['id']['token'] = $token;

/*    echo("<pre>");    var_dump($_POST);     echo("</pre>");
    echo("<pre>");    var_dump($_SESSION['id']);     echo("</pre>");*/


    $auth = new Auth;
} else {
    $token = /*(isset($_SESSION['id']['token'])) ?  $_SESSION['id']['token'] :*/ md5(uniqid(rand(), true));
    $_SESSION['id']['token'] = $token;
}

class Auth {
    private $credentials;

    public function __construct()
    {
        $this->credentials = [
            'email' =>  'test@example.com',
            'password' => password_hash('testtest', PASSWORD_BCRYPT)
        ];

        $this->formValidate();
        $_SESSION['id']['ip'] = $this->getIp();
    }

    private function checkToken($token){
        //if we dont have a valid token, return invalid;
        $validpermission = 1;
        if(!$token){
            $this->setVar('validpermission', 0);
            $this->setVar('error', 'no token found, security bridge detected');
            return false;
        }
        //if we have a valid token check that is is valid
        $key = $_SESSION['id']['token'];
        if($key !== $token ){
//            var_dump($key . " " . $token);
            $this->setVar('validpermission', 0);
            $this->setVar('error', 'invalid token');
            return false;
        }
        if($validpermission !== 1){
            echo 'invalid Permissions to run this script';
            return false;
        } else{
            return true;
        }
    }

    private function &setVar( $name, $value = null ) {
        if (!is_null( $value )) {
            $name = $value;
        }
        return $name;
    }

    private function getIp() {
        $keys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'REMOTE_ADDR'
        ];
        foreach ($keys as $key) {
            if (!empty($_SERVER[$key])) {
                $tmp = explode(',', $_SERVER[$key]);
                $ip = trim(end($tmp));
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
    }

    function formValidate()
    {

        // define variables and set to empty values
        $errors = [
            'email' => '',
            'password' => '',
            'token' => ''
        ];
        unset($_SESSION['id']['errors']);
        $email = $password = "";
        if (!$this->checkToken($_POST['token']))
        {
            $errors['token'] = "Token error";
        }

        if (empty($_POST["email"])) {
            $errors['email'] = "Email is required";
        } else {
            $email = $this->test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email format";
            }
//            var_dump('email validation: '.$email." ". $this->credentials['email']);
            if ($email != $this->credentials['email'] ) {
                $errors['email'] = "Unknown email";
            }
        }

        if (empty($_POST["password"])) {
            $errors['password'] = "Password is required";
        } else {
//            echo('countLoginTries ');var_dump(isset($_SESSION['id']['countLoginTries']));
//            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
            $password = $_POST["password"];
            if (!($email === $this->credentials['email'] &&
                password_verify( $password , $this->credentials['password'] ))
            ) {
echo("<br>".$email." ".$this->credentials['email']." " . $password . " " . $this->credentials['password'] ."<br>");
//var_dump(password_verify( $password , $this->credentials['password'] ));
                $errors['password'] = "Invalid password";
                $_SESSION['id']['countLoginTries'] = (isset($_SESSION['id']['countLoginTries'])) ? $_SESSION['id']['countLoginTries']+1 : 1;
                $_SESSION['id']['errors'] = array_filter ($errors, function ($v){
                    return $v !== "";
                });
//var_dump($_SESSION['id']['countLoginTries']);
            } else {
//var_dump("Creds OK");
                unset($_SESSION['id']['errors']);
            }
        }

        return count(array_filter ($errors, function ($v){
                return $v === "";
            })) === 0;
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

$recaptcha = <<< HEREDOC
    <div>
        <div class="g-recaptcha" data-sitekey="6LfyGr8ZAAAAAMmIQLlHfE8ZZRciOtZ9CWLwle_f"></div>
       <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" /><br/><br/>
        <div class="help-block with-errors"></div>
    </div>
HEREDOC;

$buttonRecaptchaAttribs = <<<HEREDOC
    class="g-recaptcha" 
    data-sitekey="6LfyGr8ZAAAAAMmIQLlHfE8ZZRciOtZ9CWLwle_f" 
    data-callback='onSubmit'
    data-action='submit'
HEREDOC;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Classes and tests</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,initial-scale=1.0,maximum-scale=1.0,user-scalable=no,viewport-fit=cover">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<!--    <script src="js/script.js"></script>-->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

    <div class="content contact-form">
        <div class="card my-5 px-5 col-6 mx-auto bg-info">
            <div class="d-flex row card-title w-100">
                <h4 class="justify-content-center text-center col-6 offset-3 my-4">Sign In Form</h4>
            </div>
            <div class="card-body">
                <div id="errors" class="alert alert-warning alert-dismissible fade show <?php echo ($_SESSION['id']['errors']) ? "" : "d-none"; ?>" role="alert">
                    <p><?php echo ($_SESSION['id']['errors']) ? implode(' ', $_SESSION['id']['errors']) : '' ?></p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form"
                      method="post"
                      action=""
                <div class="row">
                    <div class="mx-auto">
                        <div class="form-group">
                            <input type="email" id="email" name="email" class="form-control" required placeholder="Your Email *" value="" />
                            <span><?php ($_SESSION['id']['errors']['email']) ? $_SESSION['id']['errors']['email'] : '' ?></span>
                        </div>
                        <div class="form-group">
                            <input type="password" id="password" name="password" class="form-control" required placeholder="Your Password *" value="" />
                            <span><?php ($_SESSION['id']['errors']['email']) ? $_SESSION['id']['errors']['email'] : '' ?></span>
                        </div>

                        <?php if ($_SESSION['id']['countLoginTries'] >= MaxLoginTries ) {
                            require('recaptcha.php');
                            echo $recaptcha;
                        } ?>

                    </div>
                </div>

                <div class="form-group">
                    <input type="hidden" name="token" value="<?php echo $token; ?>" class="form-control"/>
                </div>

                <div class="form-group">
                    <input type="submit"
                           id="btnSubmit"
                           name="btnSubmit"
                           class="btnContact btn btn-warning"
                           value="Log In"
                            <?php if ($_SESSION['id']['countLoginTries'] >= MaxLoginTries ) {
                                echo $buttonRecaptchaAttribs;
                            } ?>
                    />
                </div>

                </form>
            </div>

        </div>

    </div>
    <?php unset($_SESSION['id']['errors']) ?>
    <script src='/js/script.js'></script>
</body>
<script>
</script>
</html>
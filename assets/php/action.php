<?php
    session_start();

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';
    require 'vendor/phpmailer/phpmailer/src/Exception.php';
    require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'vendor/phpmailer/phpmailer/src/SMTP.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    require_once 'auth.php';
    $user = new Auth();

    //Handle Register Ajax Request
    if(isset($_POST['action']) && $_POST['action'] == 'register'){
        $name = $user->test_input($_POST['name']);
        $email = $user->test_input($_POST['email']);
        $pass = $user->test_input($_POST['password']);

        $hpass = password_hash($pass, PASSWORD_DEFAULT);

        if($user->user_exist($email)){
        echo $user->showMessage('warning', 'This email is already registered!');
        }else{
            if($user->register($name,$email,$hpass)){
                echo 'register';
                $_SESSION['user'] = $email;
            }else{
                echo $user->showMessage('danger', 'Something went wrong! try again later!');
            }
        }
    }

    //Handle Login Ajax Request
    if(isset($_POST['action']) && $_POST['action'] == 'login'){
        $email = $user->test_input($_POST['email']);
        $pass = $user->test_input($_POST['password']);

        $loggedInUser = $user->login($email);
        if($loggedInUser != null){
            if(password_verify($pass,$loggedInUser['password'])){
                if(!empty($_POST['rem'])){
                    setcookie("email", $email, time()+(30*24*60*60),'/');
                    setcookie("password", $pass, time()+(30*24*60*60),'/');
                }else{
                    setcookie("email", "",1,'/');
                    setcookie("password", "",1,'/');
                }
                echo 'login';
                $_SESSION['user'] = $email;
            }else{
            echo $user->showMessage('danger', 'Password Incorrect!');
        }
      }else{
        echo $user->showMessage('danger', 'User not Found!');
      }
    }

    //Handle Forgot Password Ajax Request
    if(isset($_POST['action']) && $_POST['action'] == 'forgot'){
        //print_r($_POST);
        $email = $user->test_input($_POST['email']);

        $user_found = $user->currentUser($email);

        if($user_found != null){
            $token = uniqid();
            $token = str_shuffle($token);

            $user->forgot_password($token, $email);

            try{
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = Database::USERNAME;
                $mail->Password = Database::PASSWORD;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;


                $mail->SetFrom(Database::USERNAME,'Irakoze Tititof');
                $mail->AddAddress($email);

                $mail->IsHTML(true);
                $mail->Subject = 'Reset Password';
                $mail->Body = '<h3>Click the below link to reset your password.<br>
                    <a href="http://localhost:8888/user-system/reset-pass.php?email='.$email.'&token='.$token.'">http://localhost:8888/user-system/reset-pass.php?email='.$email.'&token='.$token.'</a>
                    <br>Irakoze<br>Tititof</h3>';

                    $mail->Send();
                    echo $user->showMessage('success', 'We Have send you the reset link in your e-mail ID, please check your e-mail!');
            }
            catch(Exception $e){
                echo $user->showMessage('danger','Something went wrong please try again later!');
            }
        }else{
            echo $user->showMessage('info','This e-mail is not registered!');
        }
    }
?>

<?php
include_once 'inc/database.php';
include_once 'inc/methods.php';
include_once 'config/config.php';

$ref_id = '';
if (isset($_GET['ref'])) { 
$ref_id = $_GET['ref'];
}


//Load Composer's autoloader
require 'phpmailer/vendor/autoload.php';
 use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$error = '';
$email = '';



if (isset($_POST['submit'])) {   
    
   $email = trim($_POST['email']);
   $pass = 'tM?'.rand(10000, 99999);
       
    $sql = 'SELECT * FROM user  WHERE email = :email  LIMIT 1';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        $id = $row -> id;
        if ($row) {
        $sql_1 = 'UPDATE user SET pass = :pass Where id = :id LIMIT 1';
        $update = $pdo->prepare($sql_1);        
        $update->execute([':pass' => $pass,':id' => $id]);
        
        $to1 = $email;
        $subject_1 = 'Elite pay  Password Reset';
        $first_name_1 = $row -> first_name;
        $last_name_1 = $row -> last_name;
        $body_1 = '<p>Your password has been reset</p>';
        $body_1 .= '<p>Your password is '.$pass.'</p>';
        $body_1 .= '<p>You can change this password from the account setting in your dashboard. </p>';
        send_email($to1,$subject_1,$first_name_1, $last_name_1,$body_1,new PHPMailer()); 

        echo '<script>
                setTimeout(function() {
                window.location.href = "forgot-password.php?r=successful";
                }, 200);
                </script>';
        }
        else{
             $error = 'Oops we cannot find your email !';
        }
        

            
         

  
    
   
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no" />
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/faq.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="shortcut icon" type="image/jpg" href="favicon.jpg">
    <title>Elite Pay</title>
</head>

<body>

    <?php if (isset($_GET['r'])):?>
    <script>
    swal("Check your email !", "Password Reset succesfully!", "success");
    </script>
    <?php endif?>
    <section id="" class="sign">
        <h2 class="brand-name">Elite Pay</h2>
        <div style="height:100vh" class="contact-form">


            <div class="form-container">
                <div style="text-align: center">
                    <span style="font-size: 5em;color: #06041d;" class="fa fa-exclamation-circle"></span>
                </div>


                <div class="form-header">
                    <h2>Forgot Password</h2>

                    <p style="font-size:0.8em;color:red">
                        <?php 
                echo $error;
                
                ?></p>
                </div>
                <p style="font-size: 0.9em;text-align: center;color: #6a6c6e;">
                    Enter your email to reset your password
                </p>

                <form id="forgot-pass" action="" method="post">


                    <div class=" row-1">
                        <input id="email" style="width:100%; margin-right: 0" name="email" type="text"
                            placeholder="Email" value="<?php echo $email;?>" required>

                    </div>


                    <div class="submit-container">
                        <input id="submit" class="btn btn-primary" type="submit" name="submit" value="Submit">

                    </div>
                </form>
                <p class="form-footer">
                    <a style="text-decoration: none !important;color: #707474;" href="sign-in.php"><span
                            class="fa fa-angle-left"></span>
                        Back to login</a>
                </p>

            </div>
        </div>


        <script src="assets/js/jquery-3.0.0.min.js"></script>
        <script src="assets/js/app.js"></script>
</body>

</html>
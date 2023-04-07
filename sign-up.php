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
$id = '';
$email = '';
$first_name = '';
$last_name = '';    
$phone = '';
$pass = '';
$confirm_pass = '';
$wallet_address = '';

if (isset($_POST['submit']) && $_POST['g-recaptcha-response'] != '') { 
    $secret = '6LcxZF4iAAAAAEXyAbxvJoMQNy-4Q7BzTofp-BHi';
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='. $secret.'&response='.$_POST['g-recaptcha-response']);
    $responseData  = json_decode($verifyResponse);
    if ($responseData -> success) {
        $email = trim($_POST['email']);
    $id = md5(time().$email);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];    
    $phone = $_POST['phone'];
    $pass = trim($_POST['pass']);
    $pass_md5= $pass;
    $confirm_pass = trim($_POST['comfirm_pass']);
    $wallet_address = $_POST['wallet_address'];
    $otp = rand(10000, 99999);

    $query = 'SELECT COUNT(*) FROM user WHERE email = :email LIMIT 1';
    $stmtCheck = $pdo->prepare($query);
    $stmtCheck->bindParam(':email',$email);
    $stmtCheck->execute();
    $row = $stmtCheck->fetchColumn();    
    if ($row > 0 ) {
        $error = 'Email already exist';
    }
    elseif ($pass != $confirm_pass) {
       $error = 'Password do not match';
    }
    elseif (empty($email)) {
       $error = 'Email fild cannot be empty';
    }
    else{  
        
        $sql = 'INSERT INTO user (id, first_name, last_name, email,phone, pass, wallet_address, otp_code) VALUES (:id,:first_name,:last_name,:email,:phone,:pass,:wallet_address,:otp)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id,'first_name' => $first_name,'last_name' => $last_name,'email' => $email,'phone' => $phone,'pass' => $pass_md5,'wallet_address' => $wallet_address,'otp'=> $otp]);
        
        $to1 = $email;
        $subject_1 = 'Elite-pay Registeration succesful!';
        $first_name_1 = $first_name;
        $last_name_1 = $last_name;
        $body_1 = '<p>Thanks you for signing up with Elite-pay. Click  activate below to activate your account</p><br/>';
        $body_1 .= '<p><a href="elite-pay.net/verify.php?otp='.$otp.'&id='.$id.'">Activate Account<a></p>';
        send_email($to1,$subject_1,$first_name_1, $last_name_1,$body_1,new PHPMailer(true)); 

                $ip_address = get_client_ip();
            $activity = 'new user registeration';
            logs($id,$ip_address,$activity);
                    

            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $id;
            echo '<script>
                        setTimeout(function() {
                        window.location.href = "thank-you.php";
                        }, 200);
                        </script>';
                        
        if ($ref_id != '') {
        $query = 'SELECT * FROM user WHERE id = :id LIMIT 1';
        $stmtCheck = $pdo->prepare($query);
        $stmtCheck->bindParam(':id',$ref_id);
        $stmtCheck->execute();
        $row_r = $stmtCheck->fetch();  

        if ($row_r) {
         $sql = 'INSERT INTO referral ( user_id, ref_id) VALUES (:user_id,:ref_id)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $id,'ref_id'=> $ref_id]);

        
        $to2 = $row_r -> email;
        $subject_2 = 'You have new referral';
        $first_name_2 = $row_r -> first_name;
        $last_name_2 = $row_r -> last_name;
        $body_2 = '<h2>You have a new client</h2>';  
        $body_2 .= '<p> First Name : '.$first_name_1.'</p>'; 
        $body_2 .= '<p>Last Name : '.$last_name_2.'</p>'; 
        $body_2 .= '<p>Email : '.$email.'</p>';      
        send_email($to2,$subject_2,$first_name_2, $last_name_2,$body_2,new PHPMailer(true));      

            }               
            
            
            
            }
        



               


    
    }
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
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/faq.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/jpg" href="favicon.jpg">
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <title>Elite pay</title>
</head>

<body>


    <section id="" class="sign">
        <h2 class="brand-name">Elite Pay</h2>
        <div style="height:100vh" class="contact-form">


            <div class="form-container">
                <div class="form-header">
                    <h2>Sign up form</h2>
                    <h4>It's quick and easy

                    </h4>
                    <p style="font-size:0.8em;color:red">
                        <?php 
                echo $error;
                
                ?></p>
                </div>
                <form id="sign-up-form" action="" method="post">
                    <div class="row-1">
                        <input id="first-name" name="first_name" type="text" placeholder="First Name"
                            value="<?php echo $first_name;?>" required>
                        <input id="last-name" name="last_name" type="text" placeholder="Last Name"
                            value="<?php echo $last_name ;?>" required>
                    </div>
                    <div class="row-1">
                        <input id="email" name="email" type="email" placeholder="Email" value="<?php echo $email; ?>"
                            required>
                        <input id="phone" name="phone" type="tel" placeholder="Phone 124-456-678"
                            value="<?php echo $phone; ?>" required minlength="9" maxlength="16">
                    </div>
                    <div class="row-1">
                        <input id="pass" name="pass" type="password" placeholder="Password" value="<?php echo $pass;?>"
                            required>
                        <input id="comfirm-pass" name="comfirm_pass" type="password" placeholder="Comfirm Password"
                            value="<?php echo $confirm_pass; ?>" required>
                    </div>
                    <div class=" row-1">
                        <input id="wallet-address" style="width:100%; margin-right: 0" name="wallet_address" type="text"
                            placeholder="Wallet Address" value="<?php echo $wallet_address;?>" required>

                    </div>
                    <div class=" row-1">
                        <input id="ref-id" style="width:100%; margin-right: 0" name="wallet_address" type="text"
                            placeholder="Referral Link" value="<?php echo $ref_id;?>" disabled>

                    </div>
                    <div class=" row-1">
                        <div class="g-recaptcha" data-sitekey="6LcxZF4iAAAAAL39qSL5Gsf00K0QUfJqV_zy6wa2"></div>

                    </div>

                    <div class="submit-container">
                        <input id="submit" type="submit" name="submit" value="Register">

                    </div>
                </form>
                <p class="form-footer">Already have account?
                    <a href="sign-in.php">Login here</a>
                </p>
            </div>
        </div>


        <script src="assets/js/jquery-3.0.0.min.js"></script>
        <script src="assets/js/app.js"></script>
</body>

</html>
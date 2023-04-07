<?php
require_once 'inc/database.php';

    $error = '';
    $email = '';
    $pass = '';
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $pass = trim($_POST['pass']);
    $pass_md5= md5($pass);
    $sql = 'SELECT id, email, pass,first_name,last_name,verified_status FROM user  WHERE email = :email && (pass =:pass || pass =:pass_md5) LIMIT 1';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email,'pass_md5' => $pass,'pass' => $pass_md5]);
        $row = $stmt->fetch();
        if ($row) {
        
        if ($row->verified_status == 1) {
            session_start();            
        $_SESSION['id'] = $row->id;
        $_SESSION['email'] = $row->email;
        $_SESSION['name'] = $row->first_name . ' ' .$row->last_name ;
            header('location: dashboard/index.php');
        }
        else{
                $error = $email.' is not verified, go to your email inbox and click the activation link.';        
             }            
    }
        else {
            $error = 'Invalid credentials';
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
    <title>Elite pay</title>
</head>

<body>


    <div style="height:100vh" class="contact-form">


        <div class="form-container">
            <div class="form-header">
                <h2>Login form</h2>
                <h4>It's quick and easy</h4>
                <p style="font-size:0.8em;color:red"><?php echo $error; ?></p>

            </div>
            <form action="" method="post">

                <div class="row-1">
                    <input style="width:100%" type="email" placeholder="Email" name="email" value="<?php echo $email?>"
                        required>

                </div>
                <div class="row-1">
                    <input style="width:100%" type="password" placeholder="Password" name="pass"
                        value="<?php echo $pass?>" required>

                </div>
                <div>
                    <input type="checkbox">
                    <label>Remember me</label>
                </div>

                <div class="submit-container">
                    <input id="submit" type="submit" value="Login" name="submit">

                </div>
            </form>
            <p class="form-footer">Don't have an account yet?
                <a href="sign-up.php">Sign-up here</a>
            </p>
            <p class="form-footer">Forgot Password?
                <a href="forgot-password.php">Click here</a>
            </p>
        </div>
    </div>
    <script src="assets/js/jquery-3.0.0.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>
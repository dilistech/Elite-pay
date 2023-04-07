<?php
require_once 'inc/sign-header.php';
require_once 'inc/database.php';

    $error = '';
    $email = '';
    $pass = '';
 if (isset($_POST['submit'])) {
     $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass_md5= md5($pass);
    $sql = 'SELECT id, email, pass FROM admin  WHERE email = :email && pass =:pass LIMIT 1';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email,'pass' => $pass_md5]);
        $row = $stmt->fetch();
        if ($row) {
        
        
            session_start();            
            $_SESSION['admin_id'] = $row->id;

            echo '<script>
                setTimeout(function() {
                window.location.href = "admin/index.php";
                }, 100);
                </script>';
            
                
        
                 
          }
        else {
            $error = 'Invalid credentials';
        }
 }


    
?>



<div style="height:100vh" class="contact-form">


    <div class="form-container">
        <div class="form-header">
            <h2>Admin Login</h2>
            <p style="font-size:0.8em;color:red"><?php echo $error; ?></p>

        </div>
        <form action="" method="post">

            <div class="row-1">
                <input style="width:100%" type="email" placeholder="Email" name="email" value="<?php echo $email?>"
                    required>

            </div>
            <div class="row-1">
                <input style="width:100%" type="password" placeholder="Password" name="pass" value="<?php echo $pass?>"
                    required>

            </div>


            <div class="submit-container">
                <input id="submit" type="submit" value="Login" name="submit">

            </div>
        </form>

    </div>
</div>
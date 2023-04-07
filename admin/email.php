 <?php
  include_once '../inc/database.php';
 include_once '../inc/methods.php';
 include_once '../inc/interest-calc.php';
 
 session_start();
if (!isset($_SESSION['admin_id'])) {
    header('location: ../admin-login.php');
}

require '../phpmailer/vendor/autoload.php';
 use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

 $mail = new PHPMailer(true);
 
if (isset($_GET['r']) && isset($_POST['submit']) ) {
    $user_id = $_GET['r'];
    $title = $_POST['title'];
    $message = $_POST['message'];

    $sql = 'SELECT * FROM `user` WHERE id = :id LIMIT 1';
       
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $user_id]);
        $row = $stmt->fetch();

        $body = '<p>Hello, <span style="text-transform: capitalize">'.$row -> first_name.' '.$row -> last_name.'</span></p>';
            $body .= '<p>'.$message.'</p>';
                  
             send_email($row -> email,$title,$row -> first_name, $row -> last_name,$body,$mail);
             
             echo '<script>
                setTimeout(function() {
                window.location.href = "email.php?r=successful";
                }, 100);
                </script>';

    
        
}





 $sql = 'SELECT * FROM user  WHERE verified_status = :status';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['status' => 1]);
    $rows = $stmt->fetchAll();
 ?>
 <?php require_once 'inc/header.php'; ?>
 <?php if (isset($_GET['r'])):?>
 <script>
swal("Good job!", "email sent succesfully!", "success");
 </script>
 <?php endif?>
 <div class="container">
     <?php require_once 'inc/head.php'; ?>

     <form action="" method="post">
         <div class="form-group">
             <label for="title">Title:</label>
             <input type="text" class="form-control" id="title" name="title">
         </div>
         <div class="form-group">
             <label for="message">Message:</label>
             <textarea class="form-control" id="message" rows="3" name="message"></textarea>
         </div>
         <button type="submit" class="btn btn-primary" name="submit">Send</button>
     </form>

 </div>
 <?php require_once 'inc/footer.php'; ?>
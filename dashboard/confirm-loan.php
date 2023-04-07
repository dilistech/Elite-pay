 <?php
 include_once '../inc/database.php';
 include_once '../inc/methods.php';
 
 session_start();
 if (!isset($_SESSION['id'])) {
header('location: ../sign-in.php');
} 

require '../phpmailer/vendor/autoload.php';
 use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


 $user_id = $_SESSION['id'];
 $mail = new PHPMailer(true);

 

    
  

    
 
?>
 <?php require_once 'inc/header.php'; ?>
 <div class="container">
     <?php require_once 'inc/head.php'; ?>
     <div>
         <h3>Loan-Invoice:
             <?php
            
            echo $_SESSION['Tid'] ;?>
         </h3>
         <p>Amount:
             <span>$
                 <?php
            
            echo number_format($_SESSION['amount'], 2);
            ?>
             </span>
         </p>
         <div style="display:flex;justify-content:center">
             <img src="../assets/imgs/barcode.png" alt="">
         </div>

         <h3>Your loan request is successful</h3>

     </div>




 </div>

 <?php require_once 'inc/footer.php'; ?>
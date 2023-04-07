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

      $b_sql = 'SELECT * FROM `wallet` WHERE id = :id';
        $b_stmt = $pdo->prepare($b_sql);
        $b_stmt->execute(['id' => 1]);
        $btc = $b_stmt->fetch();

    $c_sql = 'SELECT * FROM `wallet` WHERE id = :id';
        $c_stmt = $pdo->prepare($c_sql);
        $c_stmt->execute(['id' => 2]);
        $eth = $c_stmt->fetch();

     
        

  
 
?>
 <?php require_once 'inc/header.php'; ?>
 <div class="container">
     <?php require_once 'inc/head.php'; ?>


     <div class="inv-act">
         <h3>Activate your investment</h3>
         <p>Kindly deposit <b>$<?php echo $_SESSION['amount']?></b> to any of the following wallets</p>
         <div class="row">
             <div class="col-sm-4"><b>BITCOIN (BTC)</b></div>
             <div class="col-sm-8"><?php echo $btc -> crypto_address?></div>
         </div>
         <div class="row">
             <div class="col-sm-4"><b>ETHEREUM (ETH)</b></div>
             <div class="col-sm-8"><?php echo $eth -> crypto_address?></div>
         </div>


     </div>


 </div>

 <?php require_once 'inc/footer.php'; ?>
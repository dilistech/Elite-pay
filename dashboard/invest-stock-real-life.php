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

 

     $p_sql = 'SELECT * FROM packages where type = 2';
    $p_stmt = $pdo->prepare($p_sql);
        $p_stmt->execute();
        $rows = $p_stmt->fetchAll();

        $sql = 'SELECT * FROM user  WHERE id = :id LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $user_id]);
    $row = $stmt->fetch();
        
         $b_sql = 'SELECT * FROM `wallet` WHERE id = :id';
        $b_stmt = $pdo->prepare($b_sql);
        $b_stmt->execute(['id' => 1]);
        $btc = $b_stmt->fetch();

    $c_sql = 'SELECT * FROM `wallet` WHERE id = :id';
        $c_stmt = $pdo->prepare($c_sql);
        $c_stmt->execute(['id' => 2]);
        $eth = $c_stmt->fetch();

  

    $error = '';  
    $amount_d = '';    
    $body = '';   
    if (isset($_POST['submit'])) {
        $package_id = $_POST['plan'];
        $amount = $_POST['amount'];
        $min = $_POST['min'];
        $max = $_POST['max'];
        $amount_d = $amount;
        $id = md5(time());
        if ($amount < $min) {
        $error = "Amount cannot be less than"." $".number_format($min,2);
               
        } elseif ($amount > $max) {

            $error = "Amount cannot be greater than"." $".number_format($max,2);       
            
        }
        else {
            $date = date("Y-m-d H:i:s");
        $insert_sql = 'INSERT INTO account (tid,user_id, package_id, amount) VALUES (:tid,:user_id,:package_id,:amount)';
        $insert_stmt = $pdo->prepare($insert_sql);
        $insert_stmt->execute(['tid' => $id,'user_id' => $user_id,'package_id' => $package_id,'amount' => $amount]);
        $aid = $pdo->lastInsertId();
        $_SESSION['amount'] = $amount_d; 
            
            
         $sql_t = 'INSERT INTO transaction ( user_id, package_id,amount,type,aid)
             VALUES (:user_id,:package_id,:amount,:type,:aid)';
        $stmt_t = $pdo->prepare($sql_t);
        $stmt_t->execute([ 'user_id' => $user_id,'package_id'=> $package_id,
         'amount' => $amount,'type'=> 'deposit','aid'=> $id]);
         

         $ip_address = get_client_ip();
          logs($user_id,$ip_address,'deposit');

          
           $body = '<p>Hello, <span style="text-transform: capitalize">'.$row -> first_name.' '.$row -> last_name.'</span></p>';
          $body .= '<p>You requested to deposit'.' $'.number_format($amount,2);'</p>';
          $body .= '<p>Kindly make deposit to any of the following wallets to activate your investment plan</p>';
          $body .= '<p>BITCOIN (BTC) :'.$btc -> crypto_address.'</p>';
          $body .= '<p>ETHEREUM (ETH) :'.$eth -> crypto_address.'</p>';
               
             send_email($row -> email,'Deposit Request',$row -> first_name, $row -> last_name,$body,$mail);
             
             echo '<script>
                setTimeout(function() {
                window.location.href = "investment-activation.php";
                }, 200);
                </script>';
            // header('location: investment-activation.php'); 
        
        }

    }
 
?>
 <?php require_once 'inc/header.php'; ?>
 <div class="container">
     <?php require_once 'inc/head.php'; ?>


     <div class="invest-wrapper">
         <h2>CRYPTO INVESTMENT</h2>
         <h3 style="text-align:center;font-size:0.9em;color:red"><?php echo $error;?></h3>



         <form id="deposit" action="" method="post">

             <?php foreach($rows as $row ): ?>
             <div class="row desc">
                 <div style="text-align:center" class="col-sm-4">
                     <span style="font-size:5em;color:gold" class="fa fa-certificate"></span>
                 </div>
                 <div class="col-sm-8">
                     <div class="form-check">
                         <input class="form-check-input" type="radio" name="plan" id="<?php echo $row -> name ?>"
                             value="<?php echo $row -> id ?>" data-min="<?php echo $row -> min_amount ?>"
                             data-max="<?php echo $row -> max_amount  ?>" required>
                         <label class="form-check-label" for="<?php echo $row -> name ?>">
                             <b class="title"><?php echo $row -> name ?></b>
                         </label>
                     </div>
                     <ul>
                         <li>Min: <b>$ <?php echo number_format($row -> min_amount ) ?></b> Max: <b>$
                                 <?php echo number_format($row -> max_amount ) ?></b>
                         </li>
                         <li>@ <b><?php echo $row -> interest_rate ?>%</b> interest rate after 7 days
                         </li>
                         <li>Capitals are Withdrawable</li>

                     </ul>
                 </div>
             </div>
             <?php endforeach;?>
             <div class="row">
                 <div class="col-sm-5"><span for="amount">How much do you wish to deposit?</span>
                 </div>
                 <div class="col-sm-7">
                     <input type="number" class="form-control" id="amount" name="amount" value="<?php echo $amount_d ?>"
                         required>
                 </div>
             </div>
             <div style="text-align:center" class="create-inv">
                 <input id="min" type="hidden" value="" name="min">
                 <input id="max" type="hidden" value="" name="max">
                 <input id="type" type="hidden" value="">
                 <p id="error" style="text-align:center;font-size:0.9em;color:red"><?php echo $error ?></p>
                 <button type="submit" name="submit" class="btn btn-primary">Create
                     investment</button>
             </div>
         </form>

     </div>


 </div>
 <script>
const deposit = document.querySelector('#deposit');
let inputs = document.querySelectorAll('input[name="plan"]');
let min = document.querySelector('#min');
let max = document.querySelector('#max');
let amount = document.querySelector('#amount');
let errorP = document.querySelector('#error');




inputs.forEach(input => {
    input.addEventListener('click', e => {
        let minVal = e.target.getAttribute('data-min');
        let maxVal = e.target.getAttribute('data-max');
        min.value = minVal;
        max.value = maxVal;
    });
});
 </script>
 <?php require_once 'inc/footer.php'; ?>
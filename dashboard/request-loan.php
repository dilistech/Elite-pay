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

 

     $p_sql = 'SELECT * FROM packages where type = 3';
    $p_stmt = $pdo->prepare($p_sql);
        $p_stmt->execute();
        $rows = $p_stmt->fetchAll();

        $sql = 'SELECT * FROM user  WHERE id = :id LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $user_id]);
    $row = $stmt->fetch();
        
        

  

    $error = '';  
    $amount_d = 0.00;    
    $body = '';   
    if (isset($_POST['submit'])) {
        $package_id = $_POST['plan'];
        $amount = $_POST['amount'];
        $min = $_POST['min'];
        $max = $_POST['max'];
        $amount_d =  $amount;
        $id = md5(time());
        $date_time  = date('Y-m-d H:i:s');
        
            $date = date("Y-m-d H:i:s");
        $insert_sql = 'INSERT INTO account (tid,user_id, package_id, amount) VALUES (:tid,:user_id,:package_id,:amount)';
        $insert_stmt = $pdo->prepare($insert_sql);
        $insert_stmt->execute(['tid' => $id,'user_id' => $user_id,'package_id' => $package_id,'amount' => $amount]);
        $aid = $pdo->lastInsertId();

        $_SESSION['Tid'] = $id;
        $_SESSION['amount'] = $amount_d; 
            
            
         $sql_t = 'INSERT INTO transaction ( user_id, package_id,amount,type,aid)
             VALUES (:user_id,:package_id,:amount,:type,:aid)';
        $stmt_t = $pdo->prepare($sql_t);
        $stmt_t->execute([ 'user_id' => $user_id,'package_id'=> $package_id,
         'amount' => $amount,'type'=> 'loan request','aid'=> $id]);
         

         $ip_address = get_client_ip();
          logs($user_id,$ip_address,'loan request');

          
           $body = '<p>Hello, <span style="text-transform: capitalize">'.$row -> first_name.' '.$row -> last_name.'</span></p>';
            $body .= '<p>Your request to take loan from Elite-pay was created successfully!</p>';
            $body .= '<p>Transaction id  :' .$id.'</p>';
            $body .= '<p>Amount :$ ' .$amount.'</p>';
            $body .= '<p>Date : ' .$date_time.'</p>';      
             send_email($row -> email,'Loan Request',$row -> first_name, $row -> last_name,$body,$mail);
             
             echo '<script>
                setTimeout(function() {
                window.location.href = "confirm-loan.php?r=successful";
                }, 200);
                </script>';
            // header('location: investment-activation.php'); 
        
        

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
                             data-max="<?php echo $row -> max_amount  ?>" checked="checked" required>
                         <label class="form-check-label" for="<?php echo $row -> name ?>">
                             <b class="title"><?php echo $row -> name ?></b>
                         </label>
                     </div>
                     <ul>
                         <li>Min: <b>$ <?php echo number_format($row -> min_amount ) ?></b> Max: <b>$
                                 <?php echo number_format($row -> max_amount ) ?></b>
                         </li>
                         <li>@ <b><?php echo $row -> interest_rate ?>%</b> interest rate after 3 Months
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
                     <input type="number" class="form-control" min="<?php echo $row -> min_amount?>"
                         max="<?php echo $row -> max_amount?>" id="amount" name="amount" value="" required>
                 </div>
             </div>
             <div style="text-align:center" class="create-inv">
                 <input id="min" type="hidden" value=" " name="min">
                 <input id="max" type="hidden" value=" " name="max">
                 <input id="type" type="hidden" value="">
                 <p id="error" style="text-align:center;font-size:0.9em;color:red"><?php echo $error ?></p>
                 <button type="submit" name="submit" class="btn btn-primary">Request Loan</button>
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
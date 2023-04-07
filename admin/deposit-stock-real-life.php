 <?php
 include_once '../inc/database.php';
 include_once '../inc/methods.php';
 
 session_start();
if (!isset($_SESSION['admin_id'])) {
    header('location: ../admin-login.php');
}

require '../phpmailer/vendor/autoload.php';
 use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



 $mail = new PHPMailer(true);

 

    $sql = 'SELECT * FROM `account` INNER JOIN packages ON account.package_id = packages.id INNER JOIN user ON account.user_id = user.id WHERE packages.type = 2 && account.status = 0 ';
       
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();


         if (isset($_POST['deposit'])) {
            $id = $_POST['tid'];
            $i_sql = 'SELECT * FROM `account` INNER JOIN packages ON account.package_id = packages.id
            INNER JOIN user ON account.user_id = user.id WHERE account.tid = :tid LIMIT 1';
     
            $stmt = $pdo->prepare($i_sql);
            $stmt->execute(['tid' => $id]);
            $row = $stmt->fetch();

            

            $user_id = $row -> user_id;
            $referral_percent = $row -> referral_bonus;
            $amount = $row -> amount;
            $referral_bonus = $amount * ($referral_percent / 100);

            $i_sql = 'SELECT * FROM `referral`INNER JOIN user ON referral.ref_id = user.id
             WHERE user_id = :user_id && status = 0 LIMIT 1';
     
            $stmt = $pdo->prepare($i_sql);
            $stmt->execute(['user_id' => $user_id]);
            $r_row = $stmt->fetch();            

            if ($r_row) {
                $r_id = $r_row -> id;
            
             $r_sql = 'UPDATE referral SET status = 1,interest_earned = :interest_earned
            Where id = :id LIMIT 1';
            $r_update = $pdo->prepare($r_sql);     
            $r_update->execute(['interest_earned' => $referral_bonus,'id' => $r_id]);

            

          $body = 'Hello, <span style="text-transform: capitalize">'.$r_row -> first_name.' '. $r_row -> last_name.'</span></p>';
          $body .= '<h2>Your referred client made deposit .</h2>';
            $body .= '<p>User Id:'.$r_row -> user_id.'</p>';
            $body .= '<p>Amount:'.$amount.'</p>';
            $body .= '<p>Interest earned:'.$referral_bonus.'</p>';   
             send_email($r_row -> email,'Your referred client just made a deposit',$r_row -> first_name, $r_row -> last_name,$body,new PHPMailer(true));
             
             
       


  }
            
            


            
         $timestamp = date('Y-m-d H:i:s',time());            

        $sql = 'UPDATE account SET status = 1,verified_date = :verified_date,current_update = :current_update,balance = :balance
         Where tid = :id LIMIT 1';
        $update = $pdo->prepare($sql);     
        $update->execute(['verified_date' => $timestamp,'current_update' => $timestamp,'balance' => $amount,'id' => $id]);
        
        $ip_address = get_client_ip();
          logs($user_id,$ip_address,'deposit approved');
          
        $body = 'Hello, <span style="text-transform: capitalize">'.$row -> first_name.' '. $row -> last_name.'</span></p>';
        $body .= '<p>Congratulations your deposit is approved'.' '.'</p>';  
      
        send_email($row -> email,'Deposit Approved',$row -> first_name, $row -> last_name,$body,new PHPMailer(true));

        
             
       echo '<script>
                setTimeout(function() {
                window.location.href = "deposit-crypto.php?r=success";
                }, 200);
                </script>';
        }
      

        
 
?>
 <?php require_once 'inc/header.php'; ?>
 <div class="container">
     <?php require_once 'inc/head.php'; ?>


     <div class="table-responsive">
         <table id="dtVerticalScrollExample" class="table table-striped table-bordered table-sm" cellspacing="0"
             width="100%">
             <thead>
                 <tr>
                     <td>##</td>
                     <td>Ref.Id</td>
                     <td>First Name</td>
                     <td>Last Name</td>
                     <td>Email</td>
                     <td>Status</td>
                     <td>Plan</td>
                     <td>Amount</td>
                     <td>Reg. Date</td>
                     <td>Approve</td>
                     <td>Delete</td>
                 </tr>
             </thead>
             <tbody>
                 <?php 
                                    $i = 1;
                                    if (!empty($rows)):;
                                     ?>
                 <?php
                                     foreach ($rows as $row):
                                       
                                        $timestamp = strtotime($row -> reg_date);
                                        $read_date = date(' jS  F Y ', $timestamp);
                                    ?>
                 <tr>
                     <td><?php echo $i ?></td>
                     <td><?php echo $row -> tid ?></td>
                     <td><?php echo $row -> first_name ?></td>
                     <td><?php echo $row -> last_name ?></td>
                     <td><?php echo $row -> email ?></td>
                     <td>Pending</td>
                     <td><?php echo $row -> name ?></td>
                     <td><?php echo $row -> amount ?></td>
                     <td><?php echo $read_date ?></td>
                     <td>
                         <form action="" method="post">
                             <button type="submit" name="deposit" class="btn btn-success">Approve</button>
                             <input type="hidden" name="tid" value="<?php echo $row -> tid ?>">


                         </form>
                     </td>
                     <td>
                         <form action="">
                             <button class="btn btn-danger">Delete</button>
                         </form>
                     </td>

                 </tr>
                 <?php 
                                $i++;
                                endforeach
                                 ?>
                 <?php else: ?>
                 <tr>
                     <td>No transaction found</td>
                 </tr>
                 <?php endif ?>
             </tbody>

         </table>
     </div>


 </div>
 <?php require_once 'inc/footer.php'; ?>
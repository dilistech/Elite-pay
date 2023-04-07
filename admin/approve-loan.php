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

  if (isset($_POST['approve'])) {
            $id = $_POST['tid'];
            $amount = $_POST['amount'];
            $wallet_address = ' bc1qdamq8kmmz59gcp839rcptn47hcppldrq62jmcf';
            $insurance_fee = $amount * 0.1;
            $user_id = $_POST['user_id'];
            $date_time  = date('Y-m-d H:i:s');
            $timestamp = date('Y-m-d H:i:s',time());            
            $sql = 'SELECT * FROM user  WHERE id = :id LIMIT 1';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $user_id]);
            $row = $stmt->fetch();
        $sql = 'UPDATE account SET status = 2,verified_date = :verified_date,balance = :balance
         Where tid = :id LIMIT 1';
        $update = $pdo->prepare($sql);     
        $update->execute(['verified_date' => $timestamp,'balance' => $amount,'id' => $id]);

        $ip_address = get_client_ip();
          logs($user_id,$ip_address,'loan request approved');

          
           $body = '<p>Hello, <span style="text-transform: capitalize">'.$row -> first_name.' '.$row -> last_name.'</span></p>';
            $body .= '<p>Congrats on your loan approval, kindly make insurance deposit 10% of
            your loan  approved amount to this wallet address 

  bc1qdamq8kmmz59gcp839rcptn47hcppldrq62jmcf

  Note you start making your withdrawal and invest loan after insurance deposit.  
            

             
            
            </p>';
            $body .= '<p>Transaction id  :' .$id.'</p>';
            $body .= '<p>Amount :$ ' .$amount.'</p>';
            $body .= '<p>Insurance Fee :$ ' .$insurance_fee.'</p>';
            $body .= '<p>Wallet Address :' .$wallet_address.'</p>';
            $body .= '<p>Date : ' .$date_time.'</p>';      
             send_email($row -> email,'Loan Request',$row -> first_name, $row -> last_name,$body,$mail);
             
             echo '<script>
                setTimeout(function() {
                window.location.href = "transaction-history.php?r=successful";
                }, 200);
                </script>';
        }

 

    $sql = 'SELECT * FROM `account` INNER JOIN packages ON account.package_id = packages.id INNER JOIN user ON account.user_id = user.id WHERE packages.type = 3 && account.status = 0 ';
       
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        
 
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
                                       
                                        $timestamp = strtotime($row -> registeration_date);
                                        $read_date = date(' jS  F Y ', $timestamp);
                                        if ($row -> status == 0) {
                                            $status = 'pending';
                                        }
                                    ?>
                 <tr>
                     <td><?php echo $i ?></td>
                     <td><?php echo $row -> tid ?></td>
                     <td><?php echo $row -> first_name ?></td>
                     <td><?php echo $row -> last_name ?></td>
                     <td><?php echo $row -> email ?></td>
                     <td><?php echo $status ?></td>
                     <td><?php echo $row -> name ?></td>
                     <td><?php echo $row -> amount ?></td>
                     <td><?php echo $read_date ?></td>
                     <td>
                         <form action="" method="post">
                             <input type="hidden" value="<?php echo $row -> tid ?>" name="tid">
                             <input type="hidden" value="<?php echo $row -> amount ?>" name="amount">
                             <input type="hidden" value="<?php echo $row -> user_id ?>" name="user_id">
                             <button type="submit" name="approve" class="btn btn-success">Approve</button>
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
 <?php require_once 'inc/footer.php'; ?>
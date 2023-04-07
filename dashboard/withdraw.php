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

 $mail = new PHPMailer(true);

 $user_id = $_SESSION['id'];
$error = '';
$amount = 0.00;

 

  $sql_a = 'SELECT *,account.tid AS aid  FROM `account` INNER JOIN packages ON account.package_id = packages.id WHERE 
   account.user_id = :user_id && account.status = 1 && account.profit > 0';
        $stmt_a = $pdo->prepare($sql_a);
        $stmt_a->execute([':user_id' => $user_id]);
        $rows = $stmt_a->fetchAll();

        
               
        

 

    
     if(isset($_POST['withdraw'])){
            $tid = $_POST['aid'];
            $amount = $_POST['amount'];
            $investor_id = $_POST['investor_id'];
            $package_id = $_POST['package_id'];
            
            
            $sql = 'SELECT * FROM `account` INNER JOIN user ON account.user_id = user.id WHERE  account.tid = :tid LIMIT 1';
       $stmt = $pdo->prepare($sql);
        $stmt->execute([':tid' => $tid]);
        $row = $stmt->fetch();
        
        if ($row) {
            $balance = $row -> balance;
            $data_amount = $row -> amount;
            $profit = $row -> profit;
            if ($balance >= $amount) {
                if ($amount >= $profit) {

                      $sql_t = 'INSERT INTO transaction ( user_id, package_id,amount,type,aid)
                        VALUES (:user_id,:package_id,:amount,:type,:aid)';
                        $stmt_t = $pdo->prepare($sql_t);
                        $stmt_t->execute([ 'user_id' => $user_id,'package_id'=> $package_id,
                        'amount' => $profit,'type'=> 'profit','aid'=> $row -> tid]);

                    $balance -=  $amount;
                    $profit = 0;
                    $data_amount = $balance;
                    
                }
                else {
                    $profit -= $amount;
                    $balance = $data_amount + $profit;
                    $sql_t = 'INSERT INTO transaction ( user_id, package_id,amount,type,aid)
                        VALUES (:user_id,:package_id,:amount,:type,:aid)';
                        $stmt_t = $pdo->prepare($sql_t);
                        $stmt_t->execute([ 'user_id' => $user_id,'package_id'=> $package_id,
                        'amount' => $profit,'type'=> 'profit','aid'=> $row -> tid]);

                    
                }
                 $update_sql = 'UPDATE account SET amount = :amount, balance = :balance,profit = :profit Where tid = :tid LIMIT 1';
                $update = $pdo->prepare($update_sql);        
                $update->execute(['amount' => $data_amount,'balance' => $balance,'profit' => $profit,'tid' => $row -> tid]);
                
                $id = md5(time());
                 $w_sql = 'INSERT INTO withdraw (wid,aid,withdraw_amount,investor_id) VALUES 
                (:id,:aid,:withdraw_amount,:investor_id)         
                ';                
               $w_stmt = $pdo->prepare($w_sql);
                $w_stmt->execute(['id' => $id,'aid'=> $row -> tid,'withdraw_amount' => $amount,
                'investor_id' => $investor_id]);

                $sql_w = 'INSERT INTO transaction ( user_id, package_id,amount,type,aid)
                        VALUES (:user_id,:package_id,:amount,:type,:aid)';
                        $stmt_w = $pdo->prepare($sql_w);
                        $stmt_w->execute([ 'user_id' => $user_id,'package_id'=> $package_id,
                        'amount' => $amount,'type'=> 'withdraw','aid'=> $row -> tid]);

                $ip_address = get_client_ip();
                logs($user_id,$ip_address,'withdraw');

            $body = '<p>Hello, <span style="text-transform: capitalize">'.$row -> first_name.' '.$row -> last_name.'</span></p>';
            $body .= '<p>Your request to withdraw'.' $'.number_format($amount,2).' was placed successfully!</p>';               
             send_email($row -> email,'Withdraw Request',$row -> first_name, $row -> last_name,$body,$mail);
             
             echo '<script>
                setTimeout(function() {
                window.location.href = "withdraw.php?r=successful";
                }, 200);
                </script>';
                // header('location: https://elite-pay.net/dashboard/withdraw-stock.php');
                
            }
            else {
                $error = 'You can not withdraw above your balance';
                 echo '<script>
                alert("You can not withdraw above your balance");
                </script>';
            }
            
        }
            

            
        }
 
?>
 <?php require_once 'inc/header.php'; ?>
 <div class="container">
     <?php require_once 'inc/head.php'; ?>

     <div class="table-responsive" style="overflow-x: auto">
         <table class="table" style="width:auto">
             <thead>
                 <tr>
                     <th>#</th>
                     <th>Plan</th>
                     <th>Amount</th>
                     <th>Profit</th>
                     <th>Balance</th>
                     <th>Invest Date</th>
                     <th>Approved Date</th>
                     <th>Status</th>
                     <th>Action</th>
                 </tr>
             </thead>
             <tbody>
                 <?php if (!empty($rows)):; ?>


                 <?php
                                    $i = 0;
                                    foreach($rows as $row ): 
                                     
                                    $state = '';
                                    $color = '';
                                    $verified_date = strtotime($row -> verified_date);
                                    $datediff = time() - $verified_date;
                                    $days = $datediff / (60 * 60 * 24);                                    
                                    if ($days % $row -> withdraw_duration == 0 ) {
                                        $state = '';
                                        $color = 'btn-success';
                                        $status = 'OK!';
                                    }
                                    else {
                                        $state = 'disabled';
                                        $color = 'btn-danger';
                                        $status = 'Not due!';
                                    }                                        

                                        
                                        $i++;
                                        $timestamp_i = strtotime($row -> registeration_date);
                                        $read_date_i = date('jS  F Y ', $timestamp_i);
                                        $timestamp_a = strtotime($row -> verified_date);
                                        $read_date_a = date(' jS  F Y ', $timestamp_a);
                                    ?>
                 <div class="modal fade" id="<?php echo $row -> aid ?>" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLabel"> Withdraw </h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                             </div>
                             <form action="" method="post">
                                 <div class="modal-body">
                                     <p style="color:red"><?php echo $error ?></p>

                                     <div class="form-group row">
                                         <label for="email" class="col-sm-2 col-form-label">
                                             Amount:</label>
                                         <div class="col-sm-10">
                                             <input type="text" name="amount" class="form-control" id="amount"
                                                 placeholder="Amount" value="<?php echo number_format($amount, 2)?>"
                                                 required>
                                         </div>

                                     </div>

                                     <div class="modal-footer">

                                         <input type="hidden" name="aid" value="<?php echo $row -> aid?>">
                                         <input type="hidden" name="investor_id" value="<?php echo $row -> user_id?>">
                                         <input type="hidden" name="package_id" value="<?php echo $row -> package_id?>">


                                         <button type="button" class="btn btn-secondary"
                                             data-dismiss="modal">Close</button>
                                         <button type="submit" name="withdraw" class="btn btn-primary">Withdraw</button>



                                     </div>
                             </form>

                         </div>
                     </div>
                 </div>
                 <tr>
                     <td>
                         <?Php echo $i ?>
                     </td>
                     <td>
                         <?Php echo $row -> name ?>
                     </td>
                     <td>
                         <?Php echo $row -> amount ?>
                     </td>
                     <td>
                         <?Php echo $row -> profit ?>
                     </td>
                     <td>
                         <?Php echo $row -> balance ?>
                     </td>
                     <td>
                         <?Php echo $read_date_i ?>
                     </td>
                     <td>
                         <?Php echo $read_date_a ?>
                     </td>
                     <td>
                         <?Php echo $status ?>
                     </td>
                     <td>
                         <!-- <form action="" method="post">
                                                <input type="hidden" name="aid" value="<?Php echo $row -> aid ?>">
                                                <input type="hidden" name="amount" value="<?Php echo $row -> amount ?>">
                                                <input type="hidden" name="investor_id" 
                                                        value="<?php echo $row -> user_id?>">
                                                        <input type="hidden" name="package_id" 
                                                        value="<?Php echo $row -> package_id ?>">

                                                <button class="btn <?Php echo $color ?>" <?Php echo $state ?>
                                                    name="withdraw">Withdraw</button>
                                            </form> -->
                         <button id="<?php echo $row -> aid ?>" type=" button" class="btn <?Php echo $color ?>"
                             data-toggle="modal" data-target="#<?php echo $row -> aid ?>" <?php echo $state ?>>
                             Withdraw
                         </button>
                     </td>

                 </tr>
                 <?php endforeach;?>
                 <?Php else: ?>
                 <p>You have no investment to withdraw</p>
                 <?Php endif ?>
             </tbody>
         </table>
     </div>



 </div>
 <?php require_once 'inc/footer.php'; ?>
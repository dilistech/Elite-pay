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

 

     $p_sql = 'SELECT * FROM packages where type = 1';
    $p_stmt = $pdo->prepare($p_sql);
        $p_stmt->execute();
        $rows = $p_stmt->fetchAll();
        
        

  

    $error = '';  
    $amount_d = '';    
    $body = '';   
    if (isset($_POST['submit'])) {
        $package_id = $_POST['plan'];
        $amount = $_POST['amount'];
        $min = $_POST['min'];
        $max = $_POST['max'];
        $amount_d = $amount;
        if ($amount < $min) {
        $errorM = "Amount cannot be less than"." $".number_format($min);
               
        } elseif ($amount > $max) {

            $errorM = "Amount cannot be greater than"." $".number_format($max);       
            
        }
        else {
            $sql_u = 'INSERT INTO account ( user_id, package_id,amount,balance,status)
             VALUES (:user_id,:package_id,:amount,:balance,:status)';
        $stmt_u = $pdo->prepare($sql_u);
        $stmt_u->execute([ 'user_id' => $user_id,'package_id'=> $package_id,
         'amount' => $amount,'balance'=> $amount,'status'=> 'pending']);
         $_SESSION['amount'] = $amount_d; 
            $aid = $pdo->lastInsertId();
            
         $sql_t = 'INSERT INTO transaction ( user_id, package_id,amount,type,aid)
             VALUES (:user_id,:package_id,:amount,:type,:aid)';
        $stmt_t = $pdo->prepare($sql_t);
        $stmt_t->execute([ 'user_id' => $user_id,'package_id'=> $package_id,
         'amount' => $amount,'type'=> 'deposit','aid'=> $aid]);
         

         $ip_address = get_client_ip();
          logs($user_id,$ip_address,'deposit');

          
           $body = '<p>Hello, <span style="text-transform: capitalize">'.$row -> first_name.' '.$row -> last_name.'</span></p>';
          $body .= '<p>You requested to deposit'.' $'.number_format($amount,2);'</p>';
          $body .= '<p>Kindly make deposit to any of the following wallets to activate your investment plan</p>';
          $body .= '<p>BITCOIN (BTC) BINANCE : 0xd7cc1d38f969fdbe04d676234b7d181161d70472</p>';
            $body .= '<p>ETHEREUM (ETH) BINANCE : 0xd7cc1d38f969fdbe04d676234b7d181161d70472</p>';
            $body .= '<p>TETHER (BNB) BINANCE : 0xd7cc1d38f969fdbe04d676234b7d181161d70472</p>';
            $body .= '<p>BITCOIN (BTC) TRUST WALLET : bc1qqtasmc3gt7fygp7gt9cyl38jrmx679wzmx2jpu</p>';
            $body .= '<p>ETHEREUM (ETH) TRUST WALLET : 0x9ba55af280C4FffA84Be177f3e2726A8c2E957CD</p>';      
             send_email_d($row -> email,'Deposit Request',$row -> first_name, $row -> last_name,$body,$mail);
             
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

    <div class="col-sm-7 ">
                        <div class="table-responsive">
                            <table id="dtVerticalScrollExample" class="table table-striped table-bordered table-sm"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td>##</td>
                                        <td>Plan</td>
                                        <td>Amount</td>
                                        <td>Balance</td>
                                        <td>Profit</td>
                                        <td>Status</td>
                                        <td>Reg. Date</td>
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
                                        <td><?php echo $row -> name ?></td>
                                        <td><?php echo $row -> amount ?></td>
                                        <td><?php echo $row -> balance ?></td>
                                        <td><?php echo $row -> profit ?></td>
                                        <td><?php echo $row -> status ?></td>
                                        <td><?php echo $read_date ?></td>

                                    </tr>

                                </tbody>
                                <?php 
                                $i++;
                                endforeach
                                 ?>
                                <?php else: ?>
                                <tr>
                                    <td>No transaction found</td>
                                </tr>
                                <?php endif ?>
                            </table>
                        </div>
                    </div>
     


 </div>
 <?php require_once 'inc/footer.php'; ?>
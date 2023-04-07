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
   account.user_id = :user_id && account.status = 2';
        $stmt_a = $pdo->prepare($sql_a);
        $stmt_a->execute([':user_id' => $user_id]);
        $rows = $stmt_a->fetchAll();

        
               
        

 

    
     if(isset($_POST['withdraw'])){
            $tid = $_POST['aid'];            
            
            
          $sql = 'UPDATE account SET status = 3
         Where tid = :id LIMIT 1';
        $update = $pdo->prepare($sql);     
        $update->execute(['id' => $tid]);
            

            
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
                                    if ($days >= 1  && $row -> status = 'active') {
                                        $state = '';
                                        $color = 'btn-success';
                                        
                                    }
                                    else {
                                        $state = 'disabled';
                                        $color = 'btn-danger';
                                    }                                        

                                        
                                        $i++;
                                        $timestamp_i = strtotime($row -> registeration_date);
                                        $read_date_i = date('jS  F Y ', $timestamp_i);
                                        $timestamp_a = strtotime($row -> verified_date);
                                        $read_date_a = date(' jS  F Y ', $timestamp_a);
                                    ?>

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
                         <?Php echo $row -> balance ?>
                     </td>
                     <td>
                         <?Php echo $read_date_i ?>
                     </td>
                     <td>
                         <?Php echo $read_date_a ?>
                     </td>
                     <td>
                         <?Php echo $row -> status ?>
                     </td>
                     <td>
                         <form action="" method="post">
                             <input type="hidden" name="aid" value="<?Php echo $row -> aid ?>">


                             <button class="btn <?Php echo $color ?>" <?Php echo $state ?>
                                 name="withdraw">Withdraw</button>
                         </form>

                     </td>

                 </tr>
                 <?php endforeach;?>
                 <?Php else: ?>
                 <td>You have no loan to withdraw</td>
                 <?Php endif ?>
             </tbody>
         </table>
     </div>



 </div>
 <?php require_once 'inc/footer.php'; ?>
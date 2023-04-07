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

 
$sql = 'SELECT * FROM `referral` INNER JOIN user ON referral.user_id = user.id WHERE referral.ref_id = :user_id';
       
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $rows = $stmt->fetchAll();

        
        
        $user_sql = 'SELECT COUNT(*) FROM `referral` WHERE ref_id = :user_id';  
        $user_stmt = $pdo->prepare($user_sql);
        $user_stmt->execute([':user_id' => $user_id]);
        $user_count = $user_stmt->fetchColumn();
        
        $bonus_sql = 'SELECT SUM(interest_earned) FROM `referral` WHERE ref_id = :user_id';
        $bonus_stmt = $pdo->prepare($bonus_sql);
        $bonus_stmt->execute([':user_id' => $user_id]);
        $bonus = $bonus_stmt->fetch(PDO::FETCH_NUM);
        
        


 
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
                     <td>First Name</td>
                     <td>Last Name</td>
                     <td>Email</td>
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
                                       
                                        if ($row -> verified_status == 0) {
                                        $status =  'Not activated yet';                                        
                                    }
                                        elseif ($row -> verified_status > 0  ) {
                                           $status =  'Active'; 
                                        }
                                        $timestamp = strtotime($row -> reg_date);
                                        $read_date = date(' jS  F Y ', $timestamp);
                                    ?>
                 <tr>
                     <td><?php echo $i ;?></td>
                     <td><?php echo $row -> first_name ;?></td>
                     <td> <?php echo $row -> last_name  ;?></td>
                     <td><?php echo $row -> email  ;?></td>
                     <td><?php echo $status ?></td>
                     <td><?php echo $read_date ?></td>

                 </tr>
                 <?php 
                                $i++;
                                endforeach
                                 ?>
                 <?php else: ?>
                 <tr>
                     <td>You have no referral(s)</td>
                 </tr>
                 <?php endif ?>
             </tbody>

         </table>
     </div>


 </div>

 <?php require_once 'inc/footer.php'; ?>
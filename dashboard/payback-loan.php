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


     <div class="table-responsive">
         <table id="dtVerticalScrollExample" class="table table-striped table-bordered table-sm" cellspacing="0"
             width="100%">
             <thead>
                 <tr>
                     <th>##</th>
                     <th>Ref. Id</th>
                     <th>Plan</th>
                     <th>Interest</th>
                     <th>Amount</th>
                     <th>Loan Total</th>
                     <th>Loan Status</th>
                     <th>Invest Date</th>
                     <th>Verified Date</th>
                     <th>Action</th>
                 </tr>
             </thead>
             <tbody>

                 <tr>
                     <td style="font-size:0.9em" colspan="8">You dont have any loan due for payment!</td>
                 </tr>

             </tbody>

         </table>
     </div>


 </div>

 <?php require_once 'inc/footer.php'; ?>
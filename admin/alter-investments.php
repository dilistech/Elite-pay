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

 $sql = 'SELECT *,account.status AS v_status FROM `account` INNER JOIN packages ON account.package_id = packages.id INNER JOIN user ON account.user_id = user.id WHERE packages.type  < 3 && account.status = 1 ';
       
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        
if (isset($_POST['alter-date'])) {
 
     $tid = $_POST['tid'];  
     $date = $_POST['date']; 
     $str = strtotime($date); 
     $timestamp = date('Y-m-d H:i:s',$str );     
    
              
        
        $sql = 'UPDATE account SET verified_date = :verified_date
         Where tid = :tid LIMIT 1';
        $update = $pdo->prepare($sql);     
        $update->execute(['verified_date' => $timestamp,'tid' => $tid]);

        header('location: alter-investments.php?action=true');   
        
   }


   if (isset($_POST['alter_profit'])) {
         $id = $_POST['id'];
         $profit = $_POST['profit'];
         $balance = $_POST['balance']; 
         $amount = $_POST['amount'];         
        $sql = 'UPDATE account SET profit = :profit,balance = :balance,amount = :amount
            Where tid = :id LIMIT 1';
        
            $update = $pdo->prepare($sql);     
            $update->execute(['profit' => $profit,'balance' => $balance,'amount' => $amount,'id' => $id]);                 
             header('location: alter-investments.php?action=true');
        }
        
        
        
        


 
?>
 <?php require_once 'inc/header.php'; ?>
 <div class="container">
     <?php if(isset($_GET['action'])):  ?>
     <script>
     swal("Good job!", "Changes saved successfully!", "success");
     </script>
     <?php endif  ?>
     <?php require_once 'inc/head.php'; ?>

     <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <form action="" method="post">
                     <div class="modal-body">

                         <div class="form-group">
                             <label for="recipient-name" class="col-form-label">Profit:</label>
                             <input type="number" class="form-control" id="profit" value=" " step="any" name="profit">
                         </div>
                         <div class="form-group">
                             <label for="recipient-name" class="col-form-label">Amount Invested:</label>
                             <input type="number" class="form-control" id="amount" value="" step="any" name="amount">
                         </div>
                         <div class="form-group">
                             <label for="recipient-name" class="col-form-label">Balance:</label>
                             <input type="number" class="form-control" id="balance" value="" step="any" name="balance">
                         </div>


                     </div>
                     <div class="modal-footer">
                         <input type="hidden" id="alter-id" value="" name="id">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         <button type="submit" class="btn btn-primary" name="alter_profit">Update</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>


     <div class="table-responsive">
         <table id="dtVerticalScrollExample" class="table table-striped table-bordered table-sm" cellspacing="0"
             width="100%">
             <thead>
                 <tr>
                     <th>##</th>
                     <th>Tranx. Id</th>
                     <th>User Id</th>
                     <th>First Name</th>
                     <th>Last Name</th>
                     <th>Email</th>
                     <th>Plan</th>
                     <th>Status</th>
                     <th>Amount</th>
                     <th>Profit</th>
                     <th>Balance</th>
                     <th>Reg Date</th>
                     <th>Verified Date</th>
                     <th>Alter Date</th>
                     <th>Alter Investment</th>



                 </tr>
             </thead>
             <tbody>
                 <?php
                                $i = 0;
                                if($rows):
                                foreach($rows as $row ): 
                                    $i++;
                                 
                            ?>
                 <div class="modal fade" id="<?php echo $row -> tid  ;?>" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLabel">Alter Date</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                             </div>
                             <form action="" method="post">
                                 <div class="modal-body">

                                     <div class="form-group">
                                         <label for="recipient-name" class="col-form-label">Date:</label>

                                         <input type="datetime-local" class="form-control" value="" name="date"
                                             pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}">
                                         <input type="hidden" name="tid" value="<?php echo $row -> tid  ;?>">
                                     </div>


                                 </div>
                                 <div class="modal-footer">
                                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                     <button type="submit" class="btn btn-primary" name="alter-date">Alter
                                         Date</button>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>
                 <tr>
                     <td><?php echo $i ;?></td>
                     <td><?php echo $row -> tid ;?></td>
                     <td><?php echo $row -> user_id;?></td>
                     <td><?php echo $row -> first_name;?></td>
                     <td><?php echo $row -> last_name;?></td>
                     <td><?php echo $row -> email;?></td>
                     <td> <?php echo $row -> name ;?></td>
                     <td style="color:gold">Pending</td>
                     <td>$<?php echo number_format($row -> amount, 2) ;?></td>
                     <td>$<?php echo number_format($row -> profit, 2) ;?></td>
                     <td>$<?php echo number_format($row -> balance, 2) ;?></td>
                     <td><?php echo $row -> registeration_date  ;?></td>
                     <td><?php echo $row -> verified_date  ;?></td>

                     <td>
                         <button type="button" class="btn btn-primary" data-toggle="modal"
                             data-target="#<?php echo $row -> tid  ;?>">Edit</button>
                     </td>
                     <td>
                         <button id="alt-btn" type="button" class="btn btn-primary" data-toggle="modal"
                             data-target="#exampleModal">Alter</button>
                     </td>
                     <input id="td-amount" type="hidden" value="<?php echo $row -> amount;?>">
                     <input id="td-profit" type="hidden" value="<?php echo $row -> profit;?>">
                     <input id="td-balance" type="hidden" value="<?php echo $row -> balance;?>">
                     <input id="td-id" type="hidden" value="<?php echo $row -> tid;?>">
                 </tr>


                 <?php endforeach;?>
                 <?php endif;?>
             </tbody>
             <tfoot>
                 <tr>
                     <?php 
                                if (!$rows): ?>
                     <td style=" font-size:0.9em" colspan="8">You dont have any stock Deposit!
                     </td>
                     <?Php endif ?>
                 </tr>
             </tfoot>
         </table>
     </div>



 </div>
 <script>
const altBtns = document.querySelectorAll('#alt-btn');
let profit = document.querySelector('#profit');
let amount = document.querySelector('#amount');
let balance = document.querySelector('#balance');
let alterId = document.querySelector('#alter-id');


altBtns.forEach(altBtn => {
    altBtn.addEventListener('click', e => {
        let tr = e.target.parentNode.parentNode;
        let tdProfit = tr.querySelector('#td-profit');
        let tdAmount = tr.querySelector('#td-amount');
        let tdBalance = tr.querySelector('#td-balance');
        let id = tr.querySelector('#td-id');
        profit.value = tdProfit.value;
        amount.value = tdAmount.value;
        balance.value = tdBalance.value;
        alterId.value = id.value;

    });
});

profit.addEventListener('keyup', e => {
    balance.value = parseFloat(profit.value) + parseFloat(amount.value);
});
 </script>
 <?php require_once 'inc/footer.php'; ?>
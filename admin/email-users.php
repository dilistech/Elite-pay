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

 if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = 'DELETE FROM user WHERE id = :id ';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $count = $stmt->rowCount();
            header('Location:users.php?action=Delete');
        }

    if (isset($_POST['approve'])) {
            $id = $_POST['id'];                      
            $u_sql = 'UPDATE user SET verified_status = 1 Where id = :id LIMIT 1';
            $update = $pdo->prepare($u_sql);        
            $update->bindParam(':id',$id);
            $update->execute();

        header('Location:users.php?action=Approve');
        }
      

    $sql = 'SELECT * FROM `user`';
       
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        
 
?>
 <?php require_once 'inc/header.php'; ?>
 <?php if(isset($_GET['action'])):  ?>
 <script>
swal("Good job!", "<?php echo $_GET['action'] ?>", "success");
 </script>
 <?php endif  ?>
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
                     <td>Action</td>

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

                                        if ($row -> verified_status == 0) {
                                        $status =  'Not activated yet';    
                                        $state = 'disabled';    
                                        $label = 'Approve';                                
                                    }
                                        elseif ($row -> verified_status > 0  ) {
                                           $status =  'Active'; 
                                           $state = 'disabled';
                                           $label = 'Approved';
                                        }
                                    ?>
                 <tr>
                     <td><?php echo $i ?></td>
                     <td><?php echo $row -> first_name ?></td>
                     <td><?php echo $row -> last_name ?></td>
                     <td><?php echo $row -> email ?></td>
                     <td><?php echo $status ?></td>
                     <td><?php echo $read_date ?></td>
                     <td>
                         <a href="email.php?r=<?php echo $row -> id ?>" class="btn btn-primary">Send Email</a>
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
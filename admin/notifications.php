 <?php
  include_once '../inc/database.php';
 include_once '../inc/methods.php';
 include_once '../inc/interest-calc.php';
 
 session_start();
if (!isset($_SESSION['admin_id'])) {
    header('location: ../admin-login.php');
}

unset($_SESSION['user_ids']);
if(isset($_POST['submit'])){
    $user_ids = $_POST['user_id'];
    $_SESSION['user_ids'] = $user_ids;
    header('location: notification.php');
    
}


 $sql = 'SELECT * FROM user  WHERE verified_status = :status';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['status' => 1]);
    $rows = $stmt->fetchAll();
 ?>
 <?php require_once 'inc/header.php'; ?>
 <div class="container">
     <?php require_once 'inc/head.php'; ?>
     <form action="" method="post">
         <div class="table-responsive">
             <table id="dtVerticalScrollExample" class="table table-striped table-bordered table-sm" cellspacing="0"
                 width="100%">
                 <thead>
                     <tr>
                         <td>##</td>
                         <td>First Name</td>
                         <td>Last Name</td>
                         <td>Email</td>
                         <td>Check</td>
                         <td>Message</td>

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
                         <td><?php echo $row -> first_name ?></td>
                         <td><?php echo $row -> last_name ?></td>
                         <td><?php echo $row -> email ?></td>
                         <td>
                             <div class="form-check">
                                 <input class="form-check-input" type="checkbox" value="<?php echo $row -> id ?>"
                                     name="user_id[]">
                             </div>
                         </td>
                         <td><a href="notification?r=<?php echo $row -> id ?>" class="btn btn-secondary">Send
                                 Notification</a></td>

                     </tr>
                     <?php 
                                $i++;
                                endforeach
                                 ?>
                     <?php else: ?>
                     <tr>
                         <td>No user found</td>
                     </tr>
                     <?php endif ?>
                 </tbody>

             </table>
         </div>

         <button type=" submit" class="btn btn-primary" name="submit">Send to checked</button>
     </form>


 </div>
 <?php require_once 'inc/footer.php'; ?>
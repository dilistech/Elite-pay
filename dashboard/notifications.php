 <?php
  include_once '../inc/database.php';
 include_once '../inc/methods.php';
 include_once 'interest-calc.php';
 
 session_start();
 if (!isset($_SESSION['id'])) {
header('location: ../sign-in.php');
} 
 $user_id = $_SESSION['id'];

 $sql_n = 'SELECT * FROM `notifications` WHERE user_id = :user_id ';
        $stmt_n = $pdo->prepare($sql_n);
        $stmt_n->execute([':user_id' => $user_id]);
        $rows = $stmt_n->fetchAll();
        
    
$sql_u = 'SELECT * FROM `notifications` WHERE user_id = :user_id && status = 0 ';
        $stmt_u = $pdo->prepare($sql_u);
        $stmt_u->execute([':user_id' => $user_id]);
        $u_rows = $stmt_u->fetchAll();
        
        foreach ($u_rows as $row) {
            $update_sql = 'UPDATE notifications SET status = 1 Where id = :id LIMIT 1';
            $update = $pdo->prepare($update_sql);        
            $update->execute(['id' => $row -> id]);
        }
            
   
 
 
 ?>

 <?php require_once 'inc/header.php'; ?>
 <div class="container">
     <?php require_once 'inc/head.php'; ?>


     <div class="">
         <?php if (!empty($rows)):
            foreach ($rows as $row):
                
                $timestamp = strtotime($row -> reg_date);
                $read_date = date(' jS  F Y ', $timestamp);
                ?>
         <div class="round-edge color-ash dash-info">
             <h3><?php echo $row -> title ?> <span><?php echo $read_date ?></span>
             </h3>
             <p style="font-size:1.2em;color:black"><?php echo $row -> title ?></p>

         </div>
         <?php endforeach ?>

         <?php else: ?>
         <p>No notification yet</p>
         <?php endif ?>

     </div>



 </div>


 <?php require_once 'inc/footer.php'; ?>
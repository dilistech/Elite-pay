 <?php
  include_once '../inc/database.php';
 include_once '../inc/methods.php';
 include_once '../inc/interest-calc.php';
 
 session_start();
if (!isset($_SESSION['admin_id'])) {
    header('location: ../admin-login.php');
}
if (isset($_GET['r']) && isset($_POST['submit']) ) {
    $user_id = $_GET['r'];
    $title = $_POST['title'];
    $message = $_POST['message'];

    $insert_sql = 'INSERT INTO notifications (user_id, title, message) VALUES (:user_id,:title,:message)';
        $insert_stmt = $pdo->prepare($insert_sql);
        $insert_stmt->execute(['user_id' => $user_id,'title' => $title,'message' => $message]);
        header('location: notification.php?action=successful');
        
}
if (isset($_SESSION['user_ids']) && isset($_POST['submit']) ) {
    $user_ids = $_SESSION['user_ids'];
    $title = $_POST['title'];
    $message = $_POST['message'];
    
    foreach ($user_ids as $user_id) {
        $insert_sql = 'INSERT INTO notifications (user_id, title, message) VALUES (:user_id,:title,:message)';
        $insert_stmt = $pdo->prepare($insert_sql);
        $insert_stmt->execute(['user_id' => $user_id,'title' => $title,'message' => $message]);
    }
    header('location: Notification.php?action=successful');
    
}




 $sql = 'SELECT * FROM user  WHERE verified_status = :status';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['status' => 1]);
    $rows = $stmt->fetchAll();
 ?>
 <?php require_once 'inc/header.php'; ?>
 <?php if (isset($_GET['action'])):?>
 <script>
swal("Good job!", "notification sent succesfully!", "success");
 </script>
 <?php endif?>
 <div class="container">
     <?php require_once 'inc/head.php'; ?>

     <form action="" method="post">
         <div class="form-group">
             <label for="title">Title:</label>
             <input type="text" class="form-control" id="title" name="title">
         </div>
         <div class="form-group">
             <label for="message">Message:</label>
             <textarea class="form-control" id="message" rows="3" name="message"></textarea>
         </div>
         <button type="submit" class="btn btn-primary" name="submit">Send</button>
     </form>

 </div>
 <?php require_once 'inc/footer.php'; ?>
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
 $sql_a = 'SELECT * FROM `account` INNER JOIN packages ON account.package_id = packages.id WHERE 
   account.user_id = :user_id ';
        $stmt_a = $pdo->prepare($sql_a);
        $stmt_a->execute([':user_id' => $user_id]);
        $rows = $stmt_a->fetchAll();
        
      

    

    
$sql = 'SELECT * FROM user  WHERE id = :id LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $user_id]);
    $p_row = $stmt->fetch();

    
     
   

      $error = '';       
    if (isset($_POST['image_upload'])) {
       $file = $_FILES['avatar'];
       $file_name = $file['name'];
       $file_temp_name = $file['tmp_name'];
       $file_size = $file['size'];
       $file_error = $file['error'];
       $file_type = $file['type'];        
       $file_ext = explode('.',$file_name);      
       
       $file_actual_ext = strtolower(end($file_ext));

       $allowed_files = array('jpg','jpeg','png');
       if (in_array($file_actual_ext,$allowed_files)) {
           if ($file_error === 0 ) {
               if ($file_size < 2000000) {
                   $file_new_name = uniqid('',true).'.'.$file_actual_ext;                   
                   $file_dest = dirname(__FILE__).'/profile-pictures'.'/'.$file_new_name;
                   move_uploaded_file($file_temp_name,$file_dest);                   
                   
                    $update_sql = 'UPDATE user SET display_picture = :file_new_name Where id = :id LIMIT 1';
                    $update = $pdo->prepare($update_sql);        
                    $update->execute(['file_new_name' => $file_new_name,'id' => $user_id]);

                    header('location:account-settings.php');
                   
               }
               else {
                   $error = 'Choose a file less than 2MB!';
               }
           }
           else {
               $error = 'There was an error uploading your file!';
           }
       }
       else {
           $error = 'you cannot upload files of this type!';
       }
       
       
    }    
    if (isset($_POST['update_bio'])) {
       $first_name = $_POST['first_name'];
       $last_name = $_POST['last_name'];
       $email = $_POST['email'];       
       $wallet_address = $_POST['wallet_address'];

       $update_sql = 'UPDATE user SET first_name = :first_name,last_name = :last_name,
       wallet_address = :wallet_address
        Where id = :id LIMIT 1';
        $update = $pdo->prepare($update_sql);        
        $update->execute(['first_name' => $first_name,'last_name' => $last_name,
        'wallet_address' => $wallet_address, 'id' => $user_id]);
        
        header('location: account-settings.php');
        
    } 
        

  

 
?>
 <?php require_once 'inc/header.php'; ?>
 <div class="container">
     <?php require_once 'inc/head.php'; ?>

     <div class="account-head">
         <div class="avatar">
             <?php
             
                        if ($p_row -> display_picture != '') {
                            $path = 'profile-pictures/'.$p_row -> display_picture;
                        }
                        else {
                            $path = 'profile-pictures/avatar.png';
                        }
                        if ($p_row-> verified_status == 0) {
                            $status = 'Pending';
                        }
                        else{
                            $status = 'Active';
                        }
                        ?>

             <img style="width:150px;height:150px;margin:20px 0" src="<?php echo $path?>" alt="">
             <form action="" method="post" enctype="multipart/form-data">
                 <input class="form-control" type="file" name="avatar" required>
                 <input style="margin:20px 0" class="btn btn-primary" type="submit" name="image_upload" value="upload">
             </form>
         </div>
         <div class="row">
             <div class="col-sm-6">
                 <div style="margin:15px 0" class="row">
                     <div class="col-sm-4">First Name:</div>
                     <div style="text-transform: capitalize;" class="col-sm-8"><?php echo $p_row->first_name ?></div>
                 </div>
                 <div style="margin:15px 0" class="row">
                     <div class="col-sm-4">Last Name:</div>
                     <div style="text-transform: capitalize;" class="col-sm-8"><?php echo $p_row->last_name ?></div>
                 </div>
                 <div style="margin:15px 0" class="row">
                     <div class="col-sm-3">Email:</div>
                     <div class="col-sm-8"><?php echo $p_row->email ?></div>
                 </div>
                 <div style="margin:15px 0" class="row">
                     <div class="col-sm-4">Status:</div>
                     <div class="col-sm-8"><?php echo $status ?></div>
                 </div>
                 <div style="margin:15px 0" class="row">
                     <div class="col-sm-4">Wallet Address:</div>
                     <div class="col-sm-8"><?php echo $p_row->wallet_address ?></div>
                 </div>
                 <div style="margin:15px 0" class="row">
                     <div class="col-sm-4">Reg. Date:</div>
                     <div class="col-sm-8"><?php echo $p_row->reg_date ?></div>
                 </div>

             </div>
             <div class="col-sm-6">
                 <div class="user-detail">

                     <p>
                         <span style="font-weight:bold">Referral link:</span>

                         <span>https://elite-pay.net/sign-up.php?ref= <?php echo $p_row->id ?></span>

                     </p>
                     <p>
                         <span style="font-weight:bold">Email:</span>
                         <span> <?php echo $p_row->email ?></span>
                     </p>

                 </div>

                 <h2 class="update-profile">Update My Profile</h2>



                 <form action="" method="post">
                     <div class="form-group row">
                         <label for="first-name" class="col-sm-2 col-form-label">First Name</label>
                         <div class="col-sm-10">
                             <input type="text" name="first_name" class="form-control black" id="first-name"
                                 placeholder="First Name" value="<?php echo $p_row -> first_name ?>" required>
                         </div>
                     </div>
                     <div class="form-group row">
                         <label for="last-name" class="col-sm-2 col-form-label">Last Name</label>
                         <div class="col-sm-10">
                             <input type="text" name="last_name" class="form-control black" id="first-name"
                                 placeholder="Last Name" value="<?php echo $p_row -> last_name ?>" required>
                         </div>
                     </div>
                     <div class="form-group row">
                         <label for="email" class="col-sm-2 col-form-label">Email</label>
                         <div class="col-sm-10">
                             <input type="email" name="email" class="form-control black" id="first-name"
                                 placeholder="Email" value="<?php echo $p_row -> email?>" disabled>
                         </div>
                     </div>

                     <div class="form-group row">
                         <label for="wallet-address" class="col-sm-2 col-form-label">Wallet Address</label>
                         <div class="col-sm-10">
                             <input type="text" name="wallet_address" class="form-control black" id="first-name"
                                 placeholder="First Name" value="<?php echo $p_row -> wallet_address?>" required>
                         </div>
                     </div>



                     <div class="form-group row">
                         <div style="text-align:center" class="col-sm-10">
                             <button type="submit" class="btn btn-primary" name="update_bio">Update Bio</button>
                         </div>
                     </div>
                 </form>
             </div>
         </div>


     </div>



 </div>

 <?php require_once 'inc/footer.php'; ?>
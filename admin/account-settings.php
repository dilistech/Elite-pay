 <?php
  include_once '../inc/database.php';
 include_once '../inc/methods.php';
 include_once 'interest-calc.php';
 
 session_start();
if (!isset($_SESSION['admin_id'])) {
    header('location: ../admin-login.php');
}

$error = '';
$success = '';
$old_pass = '';
$new_pass = '';
$confirm_new_pass = '';
$user_id = $_SESSION['admin_id'];
   $sql = 'SELECT * FROM admin  WHERE id = :id LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $user_id]);
    $row = $stmt->fetch();

    $wallet_sql = 'SELECT * FROM wallet';
    $wallet_stmt = $pdo->prepare($wallet_sql);
    $wallet_stmt->execute();
    $rows = $wallet_stmt->fetchAll();

    $cr_sql = 'SELECT * FROM crypto';
    $cr_stmt = $pdo->prepare($cr_sql);
    $cr_stmt->execute();
    $cr_rows = $cr_stmt->fetchAll();
    
    if (isset($_POST['update_bio'])) {
       $email = $_POST['email'];
       

       $update_sql = 'UPDATE admin SET email = :email Where id = :id LIMIT 1';
        $update = $pdo->prepare($update_sql);        
        $update->execute(['email' => $email, 'id' => $user_id]);
        
        header('location: account-settings.php');
        
    }

    if (isset($_POST['update_bio'])) {
       $email = $_POST['email'];
       

       $update_sql = 'UPDATE admin SET email = :email Where id = :id LIMIT 1';
        $update = $pdo->prepare($update_sql);        
        $update->execute(['email' => $email, 'id' => $user_id]);
        
        header('location: account-settings.php');
        
    }
       
     if (isset($_POST['crypto_update'])) {
       $id = $_POST['id'];
       $crypto_name = $_POST['crypto_name'];
       $crypto_address = $_POST['crypto_address'];
       

       $update_sql = 'UPDATE wallet SET crypto_name = :crypto_name,crypto_address = :crypto_address
        Where id = :id LIMIT 1';
        $update = $pdo->prepare($update_sql);        
        $update->execute(['crypto_name' => $crypto_name, 'crypto_address' => $crypto_address,'id' => $id]);
        
        header('location: account-settings.php');
        
    }   
    if (isset($_POST['crypto_price'])) {
       $id = $_POST['id'];
       $name = $_POST['name'];
       $price = $_POST['price'];
       

       $update_sql = 'UPDATE crypto SET name = :name,price = :price
        Where id = :id LIMIT 1';
        $update = $pdo->prepare($update_sql);        
        $update->execute(['name' => $name, 'price' => $price,'id' => $id]);
        
        header('location: account-settings.php');
        
    } 
    if (isset($_POST['change_password'])) {
       $id = $_POST['id'];
       $new_pass = $_POST['new_pass'];       
       $old_pass = $_POST['old_pass'];
       $confirm_new_pass = $_POST['confirm_new_pass'];
       $pass_md5 = md5($old_pass);

        $sql = 'SELECT * FROM admin  WHERE id = :id LIMIT 1';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $user_id]);
        $row = $stmt->fetch();
        
        if ($row -> pass == $pass_md5) {
        $update_sql = 'UPDATE admin SET pass = :pass
        Where id = :id LIMIT 1';
        $update = $pdo->prepare($update_sql);        
        $update->execute(['pass' => $new_pass,'id' => $id]);
        
        header('location: account-settings.php#old-pass');
        $success = 'Password Updated Successfully!';
        
        }
        else {
            $error = 'Old password is incorrect';
        }
       

       
    }
 
 
 ?>

 <?php require_once 'inc/header.php'; ?>
 <div class="container">
     <?php require_once 'inc/head.php'; ?>


     <div class="contents-area">



         <div class="invest-wrapper">
             <div style="margin-top: 20px;text-align: center;" class="account-head">
                 <div class="avatar">

                     <img style="height: 150px;width: 150px;margin-bottom: 20px;" src="profile-pictures/avatar.png"
                         alt="">

                 </div>
                 <div class="user-detail">
                     <p>
                         <span style="font-weight:bold">Account Type:</span>
                         <span style="color:green">Super Admin</span>
                     </p>
                     <p>
                         <span style="font-weight:bold">Email:</span>
                         <span> <?php echo $row -> email ?></span>
                     </p>

                 </div>

             </div>
             <h2>Update My Admin Profile</h2>



             <form action="" method="post">

                 <div class="form-group row">
                     <label for="email" class="col-sm-2 col-form-label">Email</label>
                     <div class="col-sm-10">
                         <input type="email" name="email" class="form-control" id="first-name" placeholder="Email"
                             value="<?php echo $row -> email?>" required>
                     </div>
                 </div>

                 <div class="form-group row">
                     <div style="text-align:center" class="col-sm-10">
                         <button type="submit" class="btn btn-primary" name="update_bio">Update Bio</button>
                     </div>
                 </div>
             </form>

             <h3>Change Wallet Credentials</h3>

             <div style="padding:20px" class="investments table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                 <table class="table table-bordered table-hover ">
                     <thead>
                         <tr>
                             <th>Crypto Name</th>
                             <th>Crypto Address</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php foreach ($rows as $row):?>
                         <div class="modal fade" id="<?php echo $row -> id ?>" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                             <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <h5 class="modal-title" id="exampleModalLabel"> Update Crypto wallet</h5>
                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                         </button>
                                     </div>
                                     <form action="" method="post">
                                         <div class="modal-body">
                                             <div class="form-group row">
                                                 <label for="email" class="col-sm-2 col-form-label">Crypto
                                                     Name:</label>
                                                 <div class="col-sm-10">
                                                     <input type="text" name="crypto_name" class="form-control"
                                                         id="first-name" placeholder="Email"
                                                         value="<?php echo $row -> crypto_name?>" required>
                                                 </div>

                                             </div>
                                             <div class="form-group row">
                                                 <label for="email" class="col-sm-2 col-form-label">Crypto
                                                     Address</label>
                                                 <div class="col-sm-10">
                                                     <input type="text" name="crypto_address" class="form-control"
                                                         id="first-name" value="<?php echo $row -> crypto_address?>"
                                                         required>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="modal-footer">
                                             <input type="hidden" name="id" id="id" value="<?php echo $row -> id?>">


                                             <button type="button" class="btn btn-secondary"
                                                 data-dismiss="modal">Close</button>
                                             <button type="submit" name="crypto_update"
                                                 class="btn btn-primary">Update</button>
                                         </div>
                                     </form>

                                 </div>
                             </div>
                         </div>
                         <tr>
                             <td><?php echo $row -> crypto_name ?></td>
                             <td><?php echo $row -> crypto_address ?></td>
                             <td>
                                 <button id="<?php echo $row -> id ?>" type="button" class="btn btn-primary"
                                     data-toggle="modal" data-target="#<?php echo $row -> id ?>">
                                     Edit
                                 </button>
                             </td>
                         </tr>

                         <?php endforeach?>


                     </tbody>
                 </table>

             </div>

             <h3>Change Crypto Price</h3>

             <div style="padding:20px" class="investments table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                 <table class="table table-bordered table-hover ">
                     <thead>
                         <tr>
                             <th>Name</th>
                             <th>Price</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php foreach ($cr_rows as $row):?>
                         <div class="modal fade" id="cr<?php echo $row -> id ?>" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                             <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <h5 class="modal-title" id="exampleModalLabel"> Edit</h5>
                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                         </button>
                                     </div>
                                     <form action="" method="post">
                                         <div class="modal-body">
                                             <div class="form-group row">
                                                 <label for="email" class="col-sm-2 col-form-label">Name:</label>
                                                 <div class="col-sm-10">
                                                     <input type="text" name="name" class="form-control" id="first-name"
                                                         placeholder="Email" value="<?php echo $row -> name?>" required>
                                                 </div>

                                             </div>
                                             <div class="form-group row">
                                                 <label for="email" class="col-sm-2 col-form-label">Price</label>
                                                 <div class="col-sm-10">
                                                     <input type="text" name="price" class="form-control"
                                                         id="first-name" value="<?php echo $row -> price?>" required>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="modal-footer">
                                             <input type="hidden" name="id" id="id" value="<?php echo $row -> id?>">


                                             <button type="button" class="btn btn-secondary"
                                                 data-dismiss="modal">Close</button>
                                             <button type="submit" name="crypto_price"
                                                 class="btn btn-primary">Update</button>
                                         </div>
                                     </form>

                                 </div>
                             </div>
                         </div>
                         <tr>
                             <td><?php echo $row -> name ?></td>
                             <td><?php echo $row -> price ?></td>
                             <td>
                                 <button id="<?php echo $row -> id ?>" type="button" class="btn btn-primary"
                                     data-toggle="modal" data-target="#cr<?php echo $row -> id ?>">
                                     Edit
                                 </button>
                             </td>
                         </tr>

                         <?php endforeach?>


                     </tbody>
                 </table>

             </div>





             <h3>Change My Password</h3>
             <form action="" method="post">
                 <p style="color:red; font-size:0.8em"><?php echo $error ?></p>
                 <p style="color:green; font-size:0.8em"><?php echo $success ?></p>
                 <div id="old-pass" class="form-group row">
                     <label for="old-pass" class="col-sm-2 col-form-label">Old Password</label>
                     <div class="col-sm-10">
                         <input type="password" name="old_pass" class="form-control" id="old-pass"
                             placeholder="Old Password" value="<?php echo $old_pass?>" required>
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="new-pass" class="col-sm-2 col-form-label">New Password</label>
                     <div class="col-sm-10">
                         <input type="password" name="new_pass" class="form-control" id="new-pass"
                             placeholder="New Password" value="<?php echo $new_pass?>" required>
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="confirm-new-pass" class="col-sm-2 col-form-label">Confirm New Password</label>
                     <div class="col-sm-10">
                         <input type="password" name="confirm_new_pass" class="form-control" id="confirm-new-pass"
                             placeholder="Confirm New Password" value="<?php echo $confirm_new_pass?>" required>
                     </div>
                 </div>





                 <div class="form-group row">
                     <div style="text-align:center" class="col-sm-10">
                         <input type="hidden" name="id" id="id" value="<?php echo $row -> id?>">
                         <button type="submit" class="btn btn-primary" name="change_password">Change
                             Password</button>
                     </div>
                 </div>
             </form>

         </div>




     </div>



 </div>


 <?php require_once 'inc/footer.php'; ?>
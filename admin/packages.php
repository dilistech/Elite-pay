 <?php
  include_once '../inc/database.php';
 include_once '../inc/methods.php';
 include_once '../inc/interest-calc.php';
 
 session_start();
if (!isset($_SESSION['admin_id'])) {
    header('location: ../admin-login.php');
}

 if (isset($_POST['submit'])) {
       $id = $_POST['id'];
       $name = $_POST['name'];
       $interest_rate = $_POST['interest_rate'];
       $interest_rate_duration = $_POST['interest_rate_duration'];
       $withdraw_duration = $_POST['withdraw_duration'];
       $min_amount = $_POST['min_amount'];
       $max_amount = $_POST['max_amount'];
       

       $update_sql = 'UPDATE packages SET name = :name,interest_rate = :interest_rate,
       interest_rate_duration = :interest_rate_duration,
       withdraw_duration = :withdraw_duration,min_amount = :min_amount,max_amount = :max_amount
        Where id = :id LIMIT 1';
        $update = $pdo->prepare($update_sql);        
        $update->execute(['name' => $name, 'interest_rate' => $interest_rate,'interest_rate_duration' => $interest_rate_duration,
    'withdraw_duration' => $withdraw_duration,'min_amount' => $min_amount, 'max_amount' => $max_amount,'id' => $id]);
        
        header('location: packages.php?action=success');
        
    } 

 $sql_c = 'SELECT * FROM packages  WHERE type = :type';
    $stmt_c = $pdo->prepare($sql_c);
    $stmt_c->execute(['type' => 1]);
    $rows_c = $stmt_c->fetchAll();

    $sql_r = 'SELECT * FROM packages  WHERE type = :type';
    $stmt_r = $pdo->prepare($sql_r);
    $stmt_r->execute(['type' => 2]);
    $rows_r = $stmt_r->fetchAll();

    $sql_l = 'SELECT * FROM packages  WHERE type = :type';
    $stmt_l = $pdo->prepare($sql_l);
    $stmt_l->execute(['type' => 3]);
    $rows_l = $stmt_l->fetchAll();
 ?>
 <?php require_once 'inc/header.php'; ?>
 <div class="container">
     <?php require_once 'inc/head.php'; ?>

     <h3 style="margin:20px 0">CRYPTO INVESTMENT</h3>

     <div class="responsive">
         <table id="dtVerticalScrollExample" class="table table-bordered table-sm" cellspacing="0" width="100%">
             <thead>
                 <tr>
                     <th>Name</th>
                     <th>Interest Rate</th>
                     <th>Interest Duration</th>
                     <th>Withdraw Duration</th>
                     <th>Min Amount</th>
                     <th>Max Amount</th>
                     <th>Action</th>
                 </tr>
             </thead>
             <tbody>
                 <?php foreach ($rows_c as $row):?>
                 <div class="modal fade" id="<?php echo $row -> id ?>" tabindex="-1" role="dialog"
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
                                         <label for="email" class="col-sm-2 col-form-label">
                                             Name:</label>
                                         <div class="col-sm-10">
                                             <input type="text" name="name" class="form-control" placeholder="Name"
                                                 value="<?php echo $row -> name?>" required>
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <label for="email" class="col-sm-2 col-form-label">Interest Rate:</label>
                                         <div class="col-sm-10">
                                             <input type="number" name="interest_rate" class="form-control"
                                                 placeholder="Interest Rate" value="<?php echo $row -> interest_rate?>"
                                                 step="any" required>
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <label for="email" class="col-sm-2 col-form-label">Interest Duration:</label>
                                         <div class="col-sm-10">
                                             <input type="number" placeholder="Interest Duration"
                                                 name="interest_rate_duration" class="form-control" step="any"
                                                 value="<?php echo $row -> interest_rate_duration?>" required>
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <label for="email" class="col-sm-2 col-form-label">Withdraw Duration:</label>
                                         <div class="col-sm-10">
                                             <input type="text" name="withdraw_duration" class="form-control" step="any"
                                                 value="<?php echo $row -> withdraw_duration?>" required>
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <label for="email" class="col-sm-2 col-form-label">Min Amount:</label>
                                         <div class="col-sm-10">
                                             <input type="number" name="min_amount" class="form-control"
                                                 placeholder="Min Amount" value="<?php echo $row -> min_amount?>"
                                                 step="any" required>
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <label for="email" class="col-sm-2 col-form-label">Max Amount:</label>
                                         <div class="col-sm-10">
                                             <input type="number" name="max_amount" class="form-control"
                                                 placeholder="Max Amount" value="<?php echo $row -> max_amount?>"
                                                 step="any" required>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="modal-footer">
                                     <input type="hidden" name="id" id="id" value="<?php echo $row -> id?>">


                                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                     <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                 </div>
                             </form>

                         </div>
                     </div>
                 </div>
                 <tr>
                     <td><?php echo $row -> name ?></td>
                     <td><?php echo $row -> interest_rate ?><span>%</span></td>
                     <td><?php echo $row -> interest_rate_duration ?><span>days</span></td>
                     <td><?php echo $row -> withdraw_duration ?><span>days</span></td>
                     <td>$<?php echo number_format($row -> min_amount ,2)?></td>
                     <td>$<?php echo number_format($row -> max_amount ,2) ?></td>
                     <td>
                         <button id="<?php echo $row -> id ?>" type="button" class="btn btn-primary" data-toggle="modal"
                             data-target="#<?php echo $row -> id ?>">
                             Edit
                         </button>
                     </td>
                 </tr>

                 <?php endforeach?>


             </tbody>
         </table>

     </div>


     <h3 style="margin:20px 0">STOCK / REAL LIFE INVESTMENT</h3>

     <div class="responsive">
         <table id="real" class="table table-bordered table-sm" cellspacing="0" width="100%">
             <thead>
                 <tr>
                     <th>Name</th>
                     <th>Interest Rate</th>
                     <th>Interest Duration</th>
                     <th>Withdraw Duration</th>
                     <th>Min Amount</th>
                     <th>Max Amount</th>
                     <th>Action</th>
                 </tr>
             </thead>
             <tbody>
                 <?php foreach ($rows_r as $row):?>
                 <div class="modal fade" id="<?php echo $row -> id ?>" tabindex="-1" role="dialog"
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
                                         <label for="email" class="col-sm-2 col-form-label">
                                             Name:</label>
                                         <div class="col-sm-10">
                                             <input type="text" name="name" class="form-control" placeholder="Name"
                                                 value="<?php echo $row -> name?>" required>
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <label for="email" class="col-sm-2 col-form-label">Interest Rate:</label>
                                         <div class="col-sm-10">
                                             <input type="number" name="interest_rate" class="form-control"
                                                 placeholder="Interest Rate" value="<?php echo $row -> interest_rate?>"
                                                 step="any" required>
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <label for="email" class="col-sm-2 col-form-label">Interest Duration:</label>
                                         <div class="col-sm-10">
                                             <input type="number" placeholder="Interest Duration"
                                                 name="interest_rate_duration" class="form-control" step="any"
                                                 value="<?php echo $row -> interest_rate_duration?>" required>
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <label for="email" class="col-sm-2 col-form-label">Withdraw Duration:</label>
                                         <div class="col-sm-10">
                                             <input type="text" name="withdraw_duration" class="form-control" step="any"
                                                 value="<?php echo $row -> withdraw_duration?>" required>
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <label for="email" class="col-sm-2 col-form-label">Min Amount:</label>
                                         <div class="col-sm-10">
                                             <input type="number" name="min_amount" class="form-control"
                                                 placeholder="Min Amount" value="<?php echo $row -> min_amount?>"
                                                 step="any" required>
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <label for="email" class="col-sm-2 col-form-label">Max Amount:</label>
                                         <div class="col-sm-10">
                                             <input type="number" name="max_amount" class="form-control"
                                                 placeholder="Max Amount" value="<?php echo $row -> max_amount?>"
                                                 step="any" required>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="modal-footer">
                                     <input type="hidden" name="id" id="id" value="<?php echo $row -> id?>">


                                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                     <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                 </div>
                             </form>

                         </div>
                     </div>
                 </div>
                 <tr>
                     <td><?php echo $row -> name ?></td>
                     <td><?php echo $row -> interest_rate ?><span>%</span></td>
                     <td><?php echo $row -> interest_rate_duration ?><span>days</span></td>
                     <td><?php echo $row -> withdraw_duration ?><span>days</span></td>
                     <td>$<?php echo number_format($row -> min_amount ,2)?></td>
                     <td>$<?php echo number_format($row -> max_amount ,2) ?></td>
                     <td>
                         <button id="<?php echo $row -> id ?>" type="button" class="btn btn-primary" data-toggle="modal"
                             data-target="#<?php echo $row -> id ?>">
                             Edit
                         </button>
                     </td>
                 </tr>

                 <?php endforeach?>


             </tbody>
         </table>

     </div>


     <h3 style="margin:20px 0">ELITE USDC LOAN</h3>

     <div class="responsive">
         <table id="loan" class="table table-bordered table-sm" cellspacing="0" width="100%">
             <thead>
                 <tr>
                     <th>Name</th>
                     <th>Interest Rate</th>
                     <th>Interest Duration</th>
                     <th>Withdraw Duration</th>
                     <th>Min Amount</th>
                     <th>Max Amount</th>
                     <th>Action</th>
                 </tr>
             </thead>
             <tbody>
                 <?php foreach ($rows_l as $row):?>
                 <div class="modal fade" id="<?php echo $row -> id ?>" tabindex="-1" role="dialog"
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
                                         <label for="email" class="col-sm-2 col-form-label">
                                             Name:</label>
                                         <div class="col-sm-10">
                                             <input type="text" name="name" class="form-control" placeholder="Name"
                                                 value="<?php echo $row -> name?>" required>
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <label for="email" class="col-sm-2 col-form-label">Interest Rate:</label>
                                         <div class="col-sm-10">
                                             <input type="number" name="interest_rate" class="form-control"
                                                 placeholder="Interest Rate" value="<?php echo $row -> interest_rate?>"
                                                 step="any" required>
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <label for="email" class="col-sm-2 col-form-label">Interest Duration:</label>
                                         <div class="col-sm-10">
                                             <input type="number" placeholder="Interest Duration"
                                                 name="interest_rate_duration" class="form-control" step="any"
                                                 value="<?php echo $row -> interest_rate_duration?>" required>
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <label for="email" class="col-sm-2 col-form-label">Withdraw Duration:</label>
                                         <div class="col-sm-10">
                                             <input type="text" name="withdraw_duration" class="form-control" step="any"
                                                 value="<?php echo $row -> withdraw_duration?>" required>
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <label for="email" class="col-sm-2 col-form-label">Min Amount:</label>
                                         <div class="col-sm-10">
                                             <input type="number" name="min_amount" class="form-control"
                                                 placeholder="Min Amount" value="<?php echo $row -> min_amount?>"
                                                 step="any" required>
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <label for="email" class="col-sm-2 col-form-label">Max Amount:</label>
                                         <div class="col-sm-10">
                                             <input type="number" name="max_amount" class="form-control"
                                                 placeholder="Max Amount" value="<?php echo $row -> max_amount?>"
                                                 step="any" required>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="modal-footer">
                                     <input type="hidden" name="id" id="id" value="<?php echo $row -> id?>">


                                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                     <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                 </div>
                             </form>

                         </div>
                     </div>
                 </div>
                 <tr>
                     <td><?php echo $row -> name ?></td>
                     <td><?php echo $row -> interest_rate ?><span>%</span></td>
                     <td><?php echo $row -> interest_rate_duration ?><span>days</span></td>
                     <td><?php echo $row -> withdraw_duration ?><span>days</span></td>
                     <td>$<?php echo number_format($row -> min_amount ,2)?></td>
                     <td>$<?php echo number_format($row -> max_amount ,2) ?></td>
                     <td>
                         <button id="<?php echo $row -> id ?>" type="button" class="btn btn-primary" data-toggle="modal"
                             data-target="#<?php echo $row -> id ?>">
                             Edit
                         </button>
                     </td>
                 </tr>

                 <?php endforeach?>


             </tbody>
         </table>

     </div>



 </div>
 <?php require_once 'inc/footer.php'; ?>
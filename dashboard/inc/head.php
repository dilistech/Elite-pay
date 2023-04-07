<?php
$timestamp = strtotime($row ->reg_date);
$read_date = date('l jS \of F Y h:i:s A ', $timestamp);

$cr_sql = 'SELECT * FROM crypto ';
    $cr_stmt = $pdo->prepare($cr_sql);
    $cr_stmt->execute(['id' => $user_id]);
    $cr_rows = $cr_stmt->fetchAll();

    
?>
<div class="dash-head">
    <h2>My Dashboard </h2>
    <h3>Hello, and Welcome! <span style="text-transform: capitalize;"><?php echo $row -> first_name; ?></span></h3>
    <p> <span>EMAIL</span>: <?php echo $row -> email; ?> <span>JOIN DATE</span> : <?php echo $read_date; ?>
    </p>
    <p>My Referrals (Total - <?php echo $r_count; ?>)</p>
    <p style="font-size:1.2em">
        <?php foreach ($cr_rows as $row): ?>

        <span style="color: white"><?php echo $row -> name ?></span>
        <span><?php echo $row -> price ?></span>



        <?php endforeach ?>
    </p>


</div>
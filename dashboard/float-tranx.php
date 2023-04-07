<?php

 $sql_a = 'SELECT *,transaction.type AS a_type,transaction.reg_date AS a_date FROM `transaction`
  INNER JOIN packages ON transaction.package_id = packages.id 
 INNER JOIN user ON transaction.user_id = user.id WHERE NOT transaction.type = :type ORDER BY transaction.reg_date
  DESC  LIMIT 20';
        $stmt_a = $pdo->prepare($sql_a);
        $stmt_a->execute(['type' => 'profit']);
        $w_rows = $stmt_a->fetchAll();
        
        
?>

<div style="margin-top:20px" class="marquee">
    <div class="flow">
        <?php 
                $arrow = '';
                $color = '';
          foreach($w_rows as $row ):        
           $timestamp = strtotime($row -> a_date);
           $read_date = date(' jS  F Y ', $timestamp);

           
           if (strpos($row -> a_type, 'withdraw') !== false) {
                $arrow = 'up';
                $color = 'red';
           }
           else{
                  $arrow = 'down';
                $color = 'green'; 
           }
                
         ?>
        <div class="cont">
            <span style="color:<?php echo $color ?>" class="fa fa-arrow-<?php echo $arrow ?> "></span>
            <span style="text-transform: capitalize;"><?php echo $row -> first_name ?></span>
            <span style="text-transform: capitalize;"><?php echo $row -> last_name ?></span>
            <span><?php echo $row -> email ?></span>
            <span style="color:<?php echo $color ?>">$<?php echo number_format($row -> amount, 2); ?></span>
            <span><?php echo $read_date ?></span>
            <span style="padding: 0 5px;color:gold">|</span>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
$tranx_sql = 'SELECT * FROM `account` INNER JOIN packages ON account.package_id = packages.id WHERE  account.status= 1 
';
        $tranx_stmt = $pdo->prepare($tranx_sql);
        $tranx_stmt->execute();
        $tranx_rows = $tranx_stmt->fetchAll();
        if ($tranx_rows) {
            foreach ($tranx_rows as $tranx_row ) {
                $current_update = strtotime($tranx_row -> current_update);                             

                $datediff = time() - $current_update;
                $days =  $datediff / (60 * 60 * 24);

                if ($days >= 1) {
                    $tid = $tranx_row -> tid;
                    $interest_rate = $tranx_row -> interest_rate;
                    $interest_rate_duration = $tranx_row -> interest_rate_duration;

                    $day_interest = $interest_rate / $interest_rate_duration ;

                    $amount = $tranx_row -> amount;

                    $calc_profit = $days * $day_interest * $amount * 0.01;

                    $profit = $tranx_row -> profit;                    

                    $profit += $calc_profit;                    

                    $balance = $profit + $amount;
  
                    $update_sql = 'UPDATE account SET profit = :profit,balance = :balance,
                    current_update = :current_update Where tid = :tid LIMIT 1';
                    $update = $pdo->prepare($update_sql);        
                    $update->execute(['profit' => $profit,'balance' => $balance,
                    'current_update' => date('Y-m-d H:i:s'),'tid' => $tid]);

                                
                }
                
        
      
            }
        }
?>
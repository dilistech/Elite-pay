<?php



$r_count = 0;
       $ref_sql = 'SELECT COUNT(*) FROM `referral`'; 
        $ref_stmt = $pdo->prepare($ref_sql);
        $ref_stmt->execute();
        $ref_count = $ref_stmt->fetchColumn();
        if ($ref_count) {
                $r_count = $ref_count;
            }
            else{
                $r_count = 0;
            }


?>
<!doctype html>
<html lang="en">

<head>
    <title>Elite-pay</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/dash-css/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../assets/css/dash.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
    @media only screen and (min-width: 200px) and (max-width: 991.98px) {
        #sidebar.active {
            min-width: 150px !important;
            max-width: 150px !important;
        }
    }

    ul.collapse{
        background:#0903b9;
    }
    </style>
</head>



<body>

    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar" class="active">
            <h1><a href="index.html" class="logo avatar"><img src="profile-pictures/avatar.png" alt=""></a></h1>
            <ul class="list-unstyled components mb-5">
                <li class="active">
                    <a href="index.php"><span class="fa fa-desktop"></span> Dashboard</a>
                </li>

                <li>
                    <a data-toggle="collapse" href="#deposit" role="button" aria-expanded="false" aria-controls="deposit">
                      <span class="fa fa-send"></span>  Deposit
                    </a>
                </li>
                <ul class="collapse" id="deposit">
                    <li>
                    <a href="deposit-crypto.php"> Crypto </a>
                </li>
                <li>
                    <a href="deposit-stock-real-life.php"> Stock &
                            Real
                            Life</a>
                </li>
                </ul>
                
                
                <li>
                    <a href="approve-loan.php"><span class="fa fa-money"></span> Approve Loan</a>
                </li>

                <li>
                    <a data-toggle="collapse" href="#withdraw" role="button" aria-expanded="false" aria-controls="withdraw">
                       <span class="fa fa-btc"></span> Withdraw
                    </a>
                </li>
                <ul class="collapse" id="withdraw">
                    <li>
                    <a href="withdraw-investment.php"> Investment</a>
                </li>
                <li>
                    <a href="withdraw-loan.php">Loan</a>
                </li>
                </ul>
                
                
                <li>
                    <a href="transaction-history.php"><span class="fa fa-area-chart"></span> Transaction History</a>
                </li>
                <li>
                    <a href="users.php"><span class="fa fa-users"></span> User(s)</a>
                </li>
                <li>
                    <a href="packages.php"><span class="fa fa-certificate"></span> Packages</a>
                </li>
                <li>
                    <a href="email-users.php"><span class="fa fa-envelope-o"></span> Send Email</a>
                </li>
                <li>
                    <a data-toggle="collapse" href="#alter" role="button" aria-expanded="false" aria-controls="alter">
                       <span class="fa fa-pencil-square"></span> Alter
                    </a>
                </li>
                <ul class="collapse" id="alter">
                  <li>
                    <a href="alter-investments.php"> Investment</a>
                </li>
                <li>
                    <a href="alter-loan.php"> Loan</a>
                </li>
                </ul>
                
                <li>
                    <a href="logs.php"><span class="fa fa-star"></span> Logs</a>
                </li>
                <li>
                    <a href="account-settings.php"><span class="fa fa-gear"></span> Acoount Settings</a>
                </li>

            </ul>

            <div class="footer">
                <p>
                    Elite-pay
                </p>
            </div>
        </nav>

        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fa fa-bars"></i>
                        <span class="sr-only">Toggle Menu</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="notifications.php">Notifications</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="admin-sign-out.php">Sign Out</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>
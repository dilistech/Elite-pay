<?php
require_once 'inc/database.php';
$crypto_sql = 'SELECT * FROM `packages`  WHERE type = 1 ';
        $crypto_stmt = $pdo->prepare($crypto_sql);
        $crypto_stmt->execute();
        $crypto_rows = $crypto_stmt->fetchAll();

$stock_sql = 'SELECT * FROM `packages`  WHERE type = 2 ';
        $stock_stmt = $pdo->prepare($stock_sql);
        $stock_stmt->execute();
        $stock_rows = $stock_stmt->fetchAll();

        $loan_sql = 'SELECT * FROM `packages`  WHERE type = 3 ';
        $loan_stmt = $pdo->prepare($loan_sql);
        $loan_stmt->execute();
        $loan_rows = $loan_stmt->fetchAll();

require_once 'inc/header.php';

?>
<div class="banner">
    <img src="assets/imgs/bg-1.jpg" alt="">
    <div style="overflow: visible !important;">
        <h1>ELITE PAY</h1>
        <h2>Elite pay creates technology and products that reduce the cost and complexity of trust.</h2>
        <a href="/sign-up.php">Sign up</a>
    </div>


</div>
<div class="container">
    <div class="intro">
        <h2 style="text-align:center;padding:20px 0">WELCOME TO ELITE PAY</h2>
        <div class="row">
            <div class="col-sm-6">
                <img style="padding-bottom:20px" class="img-fluid" src="assets/imgs/bg-5.jpg" alt="intro image">
            </div>
            <div class="col-sm-6">
                <h3>Number 1 Global Investment Company!</h3>
                <p>Elite-pay investment platform offers portfolios of careful preparation and
                    fruitful
                    work
                    of experts in the fields of crypto trading,oil emission/ exploration
                    ,real estates,gold & precious stones,forex trading,
                    stock exchange and bonds.
                    Using modern methods of doing business and a personal approach to each client, we offer a unique
                    investment
                    model to people who want to use Bitcoin not only as a method of payment, but also as a reliable
                    source of
                    stable
                    income. Elite-pay business uses only modern mining equipment and trades at the most stable markets,
                    which
                    minimizes the risk of financial loss to customers and guarantees them a stable income accrued every
                    calendar
                    day.</p>
                <a class="btn btn-secondary" href="sign-up.php">Sign up</a>
            </div>

        </div>


    </div>

    <div class="service">
        <h3>Services</h3>
        <div class="row">

            <div class="col-sm-4 mb-3">
                <img src="assets/imgs/crypto-1.jpg" alt=""></img>
                <div>
                    <h4>Crypto Trading</h4>
                    <p>
                        our crypto experts always work together with our team of software
                        engineers to ensure that we make 100% profit on all our trades.
                        Our software engineers created a
                        robust
                        artificial intelligence robot that gurantees profit.

                    </p>
                    <div class="text-center">
                        <a href="crypto-trading.php" class="btn btn-secondary">Learn More</a>
                    </div>

                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <img src="assets/imgs/oil-1.jpg" alt=""></img>
                <div>
                    <h4>Oil Emission/ Exploration</h4>
                    <p>

                        We invest in petroleum industry in 4 major ways; which includes
                        exchange-traded funds (ETFs), master limited partnership(MLP), oil futures and direct
                        participation (DPP).
                    </p>
                    <div class="text-center">
                        <a href="oil-emission" class="btn btn-secondary">Learn More</a>
                    </div>


                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <img src="assets/imgs/real-estate-1.jpg" alt=""></img>
                <div>
                    <h4>Real Estate</h4>
                    <p>
                        We are constantly buying and selling assets
                        ranging from office and apartment buildings to warehouses, hospitals, shopping centers, hotels
                        and commercial forests.

                    </p>
                    <div class="text-center">
                        <a href="real-estate" class="btn btn-secondary">Learn More</a>
                    </div>

                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <img src="assets/imgs/gold-precious-stones-1.jpg" alt=""></img>
                <div>
                    <h4>Gold & Precious Stones</h4>
                    <p>
                        Gold trading is the practice of speculating on the price of gold markets in order
                        to make a profit – usually via futures, options, spot prices or shares and
                        exchange-traded funds (ETFs).

                    </p>
                    <div class="text-center">
                        <a href="gold-precious-stones.php" class="btn btn-secondary">Learn More</a>
                    </div>


                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <img src="assets/imgs/stock-1.jpg" alt=""></img>
                <div>
                    <h4>Stock Exchange & Bonds</h4>
                    <p>
                        We trade equity securities (e.g., shares) issued by corporations debt securities,
                        debt securities issued by
                        corporations or governments.

                    </p>
                    <div class="text-center">
                        <a href="stock-exchange.php" class="btn btn-secondary">Learn More</a>
                    </div>

                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <img src="assets/imgs/forex-1.jpg" alt=""></img>
                <div>
                    <h4>Forex Trading</h4>
                    <p>
                        The foreign exchange market is a global decentralized or over-the-counter market
                        for the trading of currencies. It includes all aspects of buying,
                        selling and exchanging currencies
                        at current or determined prices.
                    </p>
                    <div class="text-centerr">
                        <a href="forex-trading.php" class="btn btn-secondary">Learn More</a>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

<div id="investments" class="wrapper">
    <div class="investments">
        <h2>OUR CRYPTO INVESTMENT PLANS</h2>
        <div class="investment">
            <?php foreach ($crypto_rows as $row): ?>
            <div class="pricing-plans">
                <div class="plans">
                    <ul>
                        <li class="items items-1"><?php echo $row -> name  ?></li>
                        <li class="items"><?php echo $row -> interest_rate  ?>% Weekly</li>
                        <li>Starts From</li>
                        <li class="items">$ <?php echo number_format($row ->min_amount,2)  ?></li>
                        <li>To</li>
                        <li>maximum</li>
                        <li class="items">$ <?php echo number_format($row ->max_amount,2)  ?></li>
                        <li><?php echo $row -> referral_bonus  ?>% Referal Bonus</li>
                        <li><?php echo $row -> compoundment_bonus  ?>% Compoundment Bonus</li>
                        <li>You can withdrawals funds once in 7 days</li>
                        <li>Other Special Benefits</li>
                        <li>*Capitals are Withdrawable</li>
                        <li class="anchor-list">
                            <a href="/sign-up.php">Choose Plan</a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="investments">
        <h2>STOCK / REAL LIFE INVESTMENT PLANS</h2>
        <div class="investment">
            <?php foreach ($stock_rows as $row): ?>
            <div class="pricing-plans">
                <div class="plans">
                    <ul>
                        <li class="items items-1"><?php echo $row -> name  ?></li>
                        <li class="items"><?php echo $row -> interest_rate  ?>% Weekly</li>
                        <li>Starts From</li>
                        <li class="items">$ <?php echo number_format($row ->min_amount,2)  ?></li>
                        <li>To</li>
                        <li>maximum</li>
                        <li class="items">$ <?php echo number_format($row ->max_amount,2)  ?></li>
                        <li><?php echo $row -> referral_bonus  ?>% Referal Bonus</li>
                        <li><?php echo $row -> compoundment_bonus  ?>% Compoundment Bonus</li>
                        <li>You can withdrawals funds once in 7 days</li>
                        <li>Other Special Benefits</li>
                        <li>*Capitals are Withdrawable</li>
                        <li class="anchor-list">
                            <a href="/sign-up.php">Choose Plan</a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="investments">
        <h2>ELITE USDC LOAN</h2>
        <div class="investment">
            <?php foreach ($loan_rows as $row): ?>
            <div class="pricing-plans">
                <div class="plans">
                    <ul>
                        <li class="items items-1"><?php echo $row -> name  ?></li>
                        <li>starts from</li>
                        <li class="items">$ <?php echo number_format($row ->min_amount,2);  ?></li>
                        <li>To</li>
                        <li>Maximum</li>
                        <li class="items">$ <?php echo number_format($row ->max_amount,2);  ?></li>
                        <li>10% Intrest return after three months</li>
                        <li class="anchor-list">
                            <a href="/sign-up.php">Choose Plan</a>
                        </li>
                    </ul>
                </div>

            </div>
            <?php endforeach ?>
        </div>
    </div>

</div>
<div class="how-it-works">
    <div class="wrapper">

        <h2>How It Works</h2>
        <p>To start your investment journey in Elite pay, you need to follow few simple steps. Starting from
            account
            registration to profit withdrawal, every step is comprehensible in our user friendly investment
            portal.
        </p>



        <div class="flex">
            <div class="font "><i style="color:green" class="fa fa-sign-in"></i></div>
            <div class="detail ">
                <h3>Sign up With Us</h3>
                <p>You’ll need to have account with us to make your deposit, and you can do this by completing your
                    registration.</p>
            </div>
        </div>
        <div class="flex">
            <div class="font"><i style="color:purple" class="fa fa-envelope"></i></div>
            <div class="detail ">
                <h3>Choose Your Preferred Plan & Make A Deposit</h3>
                <p>As soon as you’ve choosen your prefered plan and made your deposits, sit back and watch your
                    investment
                    grows.</p>
            </div>

        </div>
        <div class="flex">
            <div class="font"><i style="color:darkcyan" class="fa fa-money"></i></div>
            <div class="detail ">
                <h3>Request For Withdrawal</h3>
                <p>Its easy and quick to request for your withdrawals and have your earnings paid to you depending
                    on
                    the
                    package.</p>
            </div>

        </div>
        <div class="flex">
            <div class="font"><i style="color:goldenrod" class="fa fa-money"></i></div>
            <div class="detail ">
                <h3>Payment</h3>
                <p>Withdrawn Amount will be sent to your wallet address within 48hrs of request.</p>
            </div>

        </div>
    </div>


</div>
<div class=" assurance">
    <div class="wrapper">
        <h2>Beautiful, functional and nearly</h2>
        <div class="flex assure">
            <div>
                <h3><span style="color:green" class="fa fa-globe"></span>Worldwide Access</h3>
                <p>Invest with us no matter where you are located. No restrictions even for users from China or USA.
                </p>
            </div>
            <div>
                <h3><span style="color:brown" class="fa fa-registered"></span>Registered Legal Company</h3>
                <p>We are registered investment company in the United Kingdom under No: +1(520)783-5416.</p>
            </div>
            <div>
                <h3><span style="color:purple" class="fa fa-lock"></span>High Security</h3>
                <p>We secure all user data by using 256-bit EV SSL security certificate.</p>
            </div>
            <div>
                <h3><span style="color:goldenrod" class="fa fa-money"></span>Instant Payments</h3>
                <p>Your bitcoins are sent to your address as soon as you submit your request.</p>
            </div>
            <div>
                <h3><span style="color:darkcyan" class="fa fa-support"></span>Online Support</h3>
                <p>Our support will answer your questions in shortest time possible.</p>
            </div>
            <div>
                <h3><span style="color:blue" class="fa fa-diamond"></span>High Profitability</h3>
                <p>We tend to be the cryptocurrency investments with highest ROI</p>
            </div>
        </div>

    </div>


</div>

<?php require_once 'inc/footer.php';?>
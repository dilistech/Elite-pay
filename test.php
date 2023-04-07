<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Thank you</title>
    <style>
    body {
        font-family: "Roboto", sans-serif;
    }
    </style>
</head>

<body style="color:white;background:blue;display:flex;justify-content: center;align-items: center;height:100vh;">
    <div style="height:100px">
        <h2 style="display: flex;justify-content: center;margin-bottom: 20px;">
            <span style="font-size:4em" class="fa fa-envelope"></span>
        </h2>
        <h3 style="font-size: 1.3em">Thank you for signing up with Elite-pay. We have sent a verification email to
            <?php
            session_start();
            echo $_SESSION['email'] ;?></h3>


    </div>
</body>

</html>
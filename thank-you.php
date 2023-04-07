<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Thank you</title>
    <style>
    body {
        font-family: "Roboto", sans-serif;
    }
    </style>
</head>

<body style="color:white;background:blue;display:flex;justify-content: center;align-items: center;height:100vh;">
    <div class="container">
        <h2 style=" display: flex;justify-content: center;margin-bottom: 20px;">
            <span style="font-size:4em" class="fa fa-envelope"></span>
        </h2>
        <?php
            session_start();
           ?>
        <div>
            <h3 style="font-size: 1.3em">Thank you for signing up with Elite Pay. We have sent a verification email
                to
                <?php  echo $_SESSION['email'] ;?>
            </h3>
        </div>
        <div>
            Click here to Sign in <a class="btn btn-secondary" href="sign-in.php">Sign in</a>
        </div>




    </div>
</body>

</html>
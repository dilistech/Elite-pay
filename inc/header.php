<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no" />
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
    body {
        color: #000;
        overflow-x: hidden;
        height: 100%;
        background-image: linear-gradient(180deg, #1E88E5, #fff);
        background-repeat: no-repeat
    }

    .card {
        box-shadow: 0px 4px 8px 0px #BDBDBD
    }

    .profile-pic {
        width: 100px !important;
        height: 100px;
        box-shadow: 0px 4px 8px 0px #BDBDBD
    }

    .owl-carousel .owl-nav button.owl-next,
    .owl-carousel .owl-nav button.owl-prev {
        background: 0 0;
        color: #1E88E5 !important;
        border: none;
        padding: 5px 20px !important;
        font: inherit;
        font-size: 50px !important
    }

    .owl-carousel .owl-nav button.owl-next:hover,
    .owl-carousel .owl-nav button.owl-prev:hover {
        color: #0D47A1 !important;
        background-color: transparent
    }

    .owl-dots {
        display: none
    }

    button:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        outline-width: 0
    }

    .item {
        display: none
    }

    .next {
        display: block !important;
        position: relative;
        transform: scale(0.8);
        transition-duration: 0.3s;
        opacity: 0.6
    }

    .prev {
        display: block !important;
        position: relative;
        transform: scale(0.8);
        transition-duration: 0.3s;
        opacity: 0.6
    }

    .item.show {
        display: block;
        transition-duration: 0.4s
    }



    @media screen and (max-width: 999px) {

        .next,
        .prev {
            transform: scale(1);
            opacity: 1
        }

        .item {
            display: block !important
        }
    }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/faq.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <title>Elite pay</title>
    <link rel="shortcut icon" type="image/jpg" href="favicon.jpg">
</head>

<body>
    <div id="pre-loader" class="pre-loader">
        <div class="loader">
            <div>
                <p>Elite pay</p>
                <h6>You're welcome, content is loading...</h6>
            </div>
        </div>

    </div>

    <header id="header-id" class="display-none">
        <div class="header">
            <nav class="nav-header-menu">
                <ul class="logo">
                    <li><a href="index.php">Elite pay</a></li>
                    <li id="logo-icon" class="logo-icon"><span><a href="#"></a></span></li>
                </ul>
                <ul class="main-menu">
                    <li><a href="about.php">About us</a></li>
                    <li><a href="index.php#investments">Investment plans</a></li>
                    <li><a href="faq.php">FAQ's</a></li>
                    <li><a href="contact.php">Contact</a></li>

                </ul>
                <ul class="auth">
                    <li><a href="sign-in.php">Sign In</a></li>
                    <li><a href="sign-up.php">Sign Up</a></li>


                </ul>

            </nav>
        </div>
    </header>
    <section id="section-id" class="content display-none">
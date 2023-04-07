<div class="container-fluid px-3 px-sm-5 my-5 text-center">
    <h4 class="mb-5 font-weight-bold">What Our Client Say</h4>
    <div class="owl-carousel owl-theme">
        <div class="item first prev">
            <div class="card border-0 py-3 px-4">
                <div class="row justify-content-center"> <img src="assets/imgs/ximena.jpg"
                        class="img-fluid profile-pic mb-4 mt-3">
                </div>
                <h6 class="mb-3 mt-2">Xiemena Cindy</h6>
                <p class=" mb-5 mx-2">I invested in the Basic Plan. It wasn’t easy to wait days to have my
                    bitcoins doubled, but most
                    important thing is this site is legit and paying. Plus for good and patient support. I will invest
                    again.</p>
            </div>
        </div>
        <div class="item show">
            <div class="card border-0 py-3 px-4">
                <div class="row justify-content-center"> <img src="assets/imgs/sisanda.jpg"
                        class="img-fluid profile-pic mb-4 mt-3">
                </div>
                <h6 class="mb-3 mt-2">Sisanda Ndimande</h6>
                <p class=" mb-5 mx-2">With Elite pay I managed to work with my finance and found a great way to
                    earn money all day
                    long,
                    not going at
                    work!
                    I began interested in investment and economy, therefore I can do some forecasts regarding
                    Bitcoin.</p>
            </div>
        </div>
        <div class="item next">
            <div class="card border-0 py-3 px-4">
                <div class="row justify-content-center"> <img src="assets/imgs/john.jpg"
                        class="img-fluid profile-pic mb-4 mt-3"> </div>
                <h6 class="mb-3 mt-2">John Paul</h6>
                <p class="content mb-5 mx-2">I started operating with Elite pay last year. I always follow up
                    innovations and don’t miss any
                    novelty.
                    Bitcoin is a great and indeed revolutionary way to earn money! I
                    constantly make payments and do mining - now I always have extra</p>
            </div>
        </div>
        <div class="item last">
            <div class="card border-0 py-3 px-4">
                <div class="row justify-content-center"> <img src="assets/imgs/richard.jpg"
                        class="img-fluid profile-pic mb-4 mt-3">
                </div>
                <h6 class="mb-3 mt-2">William Richard</h6>
                <p class=" mb-5 mx-2">I invested in the Basic Plan. It wasn’t easy to wait days to have my
                    bitcoins doubled, but most
                    important thing is this site is legit and paying. Plus for good and patient support. I will invest
                    again..</p>
            </div>
        </div>
    </div>
</div>
<Footer style="margin-bottom: 80px;" class="footer-section">
    <div class="align-center">
        <div class="wrapper">
            <div class="footer-flex">
                <div>
                    &#169; <span>2012 - </span><?php echo date('Y')?> All Rights Reserved.
                </div>
                <div>
                    <a href=""><span class="fa fa-instagram"></span></a>
                    <a href=""><span class="fa fa-facebook"></span></a>
                    <a href=""><span class="fa fa-twitter"></span></a>
                </div>
            </div>
            <div class="theme-powered">
                <p>Powered by Elite pay. </p>
            </div>

        </div>
        <a href="#" class="to-top"><span class="fa fa-arrow-up"></span></a>
    </div>






</Footer>
</section>
<script src="assets/js/jquery-3.0.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<script>
$('.carousel').carousel()
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
$(document).ready(function() {

    $('.owl-carousel').owlCarousel({
        mouseDrag: false,
        loop: true,
        margin: 2,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 3
            }
        }
    });

    $('.owl-prev').click(function() {
        $active = $('.owl-item .item.show');
        $('.owl-item .item.show').removeClass('show');
        $('.owl-item .item').removeClass('next');
        $('.owl-item .item').removeClass('prev');
        $active.addClass('next');
        if ($active.is('.first')) {
            $('.owl-item .last').addClass('show');
            $('.first').addClass('next');
            $('.owl-item .last').parent().prev().children('.item').addClass('prev');
        } else {
            $active.parent().prev().children('.item').addClass('show');
            if ($active.parent().prev().children('.item').is('.first')) {
                $('.owl-item .last').addClass('prev');
            } else {
                $('.owl-item .show').parent().prev().children('.item').addClass('prev');
            }
        }
    });

    $('.owl-next').click(function() {
        $active = $('.owl-item .item.show');
        $('.owl-item .item.show').removeClass('show');
        $('.owl-item .item').removeClass('next');
        $('.owl-item .item').removeClass('prev');
        $active.addClass('prev');
        if ($active.is('.last')) {
            $('.owl-item .first').addClass('show');
            $('.owl-item .first').parent().next().children('.item').addClass('prev');
        } else {
            $active.parent().next().children('.item').addClass('show');
            if ($active.parent().next().children('.item').is('.last')) {
                $('.owl-item .first').addClass('next');
            } else {
                $('.owl-item .show').parent().next().children('.item').addClass('next');
            }
        }
    });

});
</script>
<script src="assets/js/app.js"></script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API = Tawk_API || {},
    Tawk_LoadStart = new Date();
(function() {
    var s1 = document.createElement("script"),
        s0 = document.getElementsByTagName("script")[0];
    s1.async = true;
    s1.src = 'https://embed.tawk.to/601e891fc31c9117cb767211/1etrkf9co';
    s1.charset = 'UTF-8';
    s1.setAttribute('crossorigin', '*');
    s0.parentNode.insertBefore(s1, s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>

</html>
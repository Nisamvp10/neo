 <?= view('frontend/inc/footer') ?>
        <!-- JS here -->
       <script src="<?=base_url('public/assets/template/');?>assets/js/jquery-3.7.1.min.js"></script>
      <!-- Bootstrap min Js -->
      <script src="<?=base_url('public/assets/template/');?>assets/js/bootstrap.min.js"></script>
      <!-- Swiper bundle min Js -->
      <script src="<?=base_url('public/assets/template/');?>assets/js/swiper-bundle.min.js"></script>
      <!-- Counterup min Js -->
      <script src="<?=base_url('public/assets/template/');?>assets/js/jquery.counterup.min.js"></script>
      <!-- Wow min Js -->
      <script src="<?=base_url('public/assets/template/');?>assets/js/wow.min.js"></script>
      <!-- Magnific popup min Js -->
      <script src="<?=base_url('public/assets/template/');?>assets/js/magnific-popup.min.js"></script>
      <!-- Nice select min Js -->
      <script src="<?=base_url('public/assets/template/');?>assets/js/nice-select.min.js"></script>
      <!-- Pace min Js -->
      <script src="<?=base_url('public/assets/template/');?>assets/js/pace.min.js"></script>
      <!-- Isotope pkgd min Js -->
      <script src="<?=base_url('public/assets/template/');?>assets/js/isotope.pkgd.min.js"></script>
      <!-- Waypoints Js -->
      <script src="<?=base_url('public/assets/template/');?>assets/js/jquery.waypoints.js"></script>
      <!-- Script Js -->
      <script src="<?=base_url('public/assets/template/');?>assets/js/script.js"></script>



<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script src="<?=base_url('public/assets/template/');?>assets/js/main.js"></script>
    
      <script src="<?=base_url('public/assets/js/sweetalert.js');?>"></script>
      <script src="<?= base_url('public/assets/js/toastr.min.js') ;?>"></script>
      <script src="<?=base_url('public/assets/js/app.js');?>" ></script>
      <script>
           App.init({
            'siteUrl' : '<?=base_url()?>'
          })

              $(document).ready(function () {
            if ($('.banner__slider').length) {
                $('.banner__slider').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    speed: 900,
                    arrows: true,
                    dots: true,
                    infinite: true,
                    fade: true,
                    pauseOnHover: true,
                    prevArrow: '<button type="button" class="slick-prev banner-nav-btn banner-nav-prev" aria-label="Previous Slide"><i class="fa-solid fa-chevron-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next banner-nav-btn banner-nav-next" aria-label="Next Slide"><i class="fa-solid fa-chevron-right"></i></button>'
                });
            }
        });
    </script>
    <script src="<?=base_url('public/assets/js/cart.js');?>"></script>
    </body>
 
 </html>
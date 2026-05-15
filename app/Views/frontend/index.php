<?= view('frontend/inc/header') ?>



   

<main>
        <!-- Banner area start here -->
        <section class="banner-area pb-130">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="banner__item">
                            <div class="image">
                                <img src="<?=base_url('public/assets/template/');?>assets/images/banner.png" alt="image">
                            </div>
                            <div class="banner__content">
                                <h5 class="wow fadeInUp" data-wow-delay=".1s">GET <span class="primary-color">25% OFF</span> NOW
                                </h5>
                                <h1 class="wow fadeInUp" data-wow-delay=".2s">India’s No. 1
  <br>
                                    for <span class="primary-color">neon lights brand
</span></h1>
                                <a class="btn-one wow fadeInUp mt-65" data-wow-delay=".3s" href="detials.html"><span>Shop
                                        Now</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="swiper product__slider">
                            <div class="swiper-wrapper">
                                <?php
                                $getProductList = getProductList('premium');
                                if(!empty($getProductList)){
                                    foreach($getProductList as $row) {
                                        $priceData = findProductPrice($row->id);
                                ?>
                                <div class="swiper-slide">
                                    <div class="product__slider-item bor">
                                        <a href="#0" class="wishlist"><i class="fa-regular fa-heart"></i></a>
                                        <a href="<?= base_url().'product-details/'.$row->slug;?>" class="product__image pt-20 d-block">
                                            <img src="<?=validImg($row->product_image)?>" alt="image">
                                        </a>
                                        <div class="product__content">
                                            <h4 class="mb-15"><a class="primary-hover"
                                                    href="<?= base_url().'product-details/'.$row->slug;?>"><?=$row->product_title?> </a></h4>
                                            <del><?=money_format_custom($priceData['price'])?></del><span class="primary-color ml-10"><?=money_format_custom($priceData['salesPrice'])?></span>
                                            <div class="star mt-20">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php 
                                    }
                                }
                                ?>

                               


                                </div>
                            </div>
                            <div class="dot product__dot mt-40"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Banner area end here -->

        <!-- Category area start here -->
        <section class="category-area">
            <div class="container">
                <div class="sub-title wow fadeInUp text-center mb-65" data-wow-delay=".1s">
                    <h3><span class="title-icon"></span> our top categories <span class="title-icon"></span>
                    </h3>
                </div>
                <div class="swiper category__slider">
                    <div class="swiper-wrapper">
                        <?php
                        $mainCate = services();
                        if(!empty($mainCate)) {
                            foreach($mainCate as $categories) {
                                ?>
                                   <div class="swiper-slide">
                                        <div class="category__item text-center">
                                            <a href="<?=base_url('collections/').$categories['slug'];?>" class="category__image d-block">
                                                <img src="<?=validImg($categories['cate_image'])?>" alt="image">
                                                <div class="category-icon">
                                                    <img src="<?=validImg($categories['cate_image'])?>" alt="icon">
                                                </div>
                                            </a>
                                            <h4 class="mt-30"><a href="#"><?=$categories['category'];?> </a></h4>
                                        </div>
                                    </div>
                                    
                                <?php
                            }
                        }?>
                     
                    </div>
                </div>
            </div>
        </section>
        <!-- Category area end here -->

        <!-- Ad banner area start here -->

        <!-- Ad banner area end here -->

        <!-- Product area start here -->
     
                <section class="product-area pt-130 pb-130 ">
            <div class="container">
                <div
                    class="product__wrp pb-30 mb-65 bor-bottom d-flex flex-wrap align-items-center justify-content-xl-between justify-content-center">
                    <div class="section-header d-flex align-items-center wow fadeInUp" data-wow-delay=".1s">
                        <span class="title-icon mr-10"></span>
                        <h2>latest arrival products</h2>
                    </div>
                    <ul class="nav nav-pills mt-4 mt-xl-0">
                        <li class="nav-item wow fadeInUp" data-wow-delay=".1s">
                            <a href="#latest-item" data-bs-toggle="tab" class="nav-link px-4 active">
                                latest item
                            </a>
                        </li>
                        <li class="nav-item wow fadeInUp" data-wow-delay=".2s">
                            <a href="#<?= base_url('products'); ?>" class="nav-link px-4 bor-left bor-right">
                                View All Products
                            </a>
                        </li>
                        <!-- <li class="nav-item wow fadeInUp" data-wow-delay=".3s">
                            <a href="#featured-products" data-bs-toggle="tab" class="nav-link ps-4">
                                featured products
                            </a>
                        </li> -->
                    </ul>
                </div>
                <div class="tab-content">
                    <div id="latest-item" class="tab-pane fade show active">
                        <div class="row g-4">

                            <?php
                                $rowKey = 0;
                                $perRows = 4;
                                $getProductList = getProductList('latest');
                                $total = count($getProductList ?? []);

                                if (!empty($getProductList)) {

                                    echo '<div class="row g-4">';

                                    foreach ($getProductList as $row) {

                                    $priceData = findProductPrice($row->id);
                            ?>
                                        <div class="col-xxl-3 col-xl-4 col-md-6">
                                            <div class="product__item bor">
                                                <a href="#0" class="wishlist"><i class="fa-regular fa-heart"></i></a>
                                                <a href="<?= base_url().'product-details/'.$row->slug;?>" class="product__image pt-20 d-block">
                                                    <img class="font-image" src="<?=validImg($row->product_image)?>" alt="image">
                                                    <img class="back-image" src="<?=validImg($row->product_image)?>" alt="image">
                                                </a>
                                                <div class="product__content">
                                                    <h4 class="mb-15"><a class="primary-hover" href="<?= base_url().'product-details/'.$row->slug;?>"><?=$row->product_title?></a></h4>
                                                    <del><?=money_format_custom($priceData['price'])?></del><span class="primary-color ml-10"><?=money_format_custom($priceData['salesPrice'])?></span>
                                                    <div class="star mt-20">
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                    </div>

                                                </div>
                                                <a class="product__cart d-block bor-top" href="#0"><i class="fa-regular fa-cart-shopping primary-color me-1"></i>
                                                    <span>Add to cart</span></a>
                                            </div>
                                        </div>

                           <?php
                                        $rowKey++;

                                        if ($rowKey % $perRows == 0 && $rowKey != $total) {
                                            echo '</div><div class="row g-4">';
                                        }
                                    }

                                    echo '</div>'; // ALWAYS CLOSE LAST ROW
                                }
                                ?>
                        </div>
                    </div>
                  <!--  -->
                </div>
            </div>
        </section>

        <!-- Product area end here -->



        <section class="discount-area about-area bg-image pt-130 pb-130" data-background="<?=base_url('public/assets/template/');?>assets/images/discount-bg2.jpg">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="image position-relative">
                            <img class="radius-10" src="<?=base_url('public/assets/template/');?>assets/images/abt.png" alt="image">
                            
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="discount__item pl-30">
                            <div class="section-header">
                                <div class="section-title-icon">
                                    <span class="title-icon mr-10"></span>
                                    <h2>About Neon Stories
</h2>
                                </div>
                                <p class="mt-30 mb-55">
                                    Every space has a story to tell, and at Neon Stories, we help you tell yours in bold, vibrant color. We believe that lighting isn't just about illumination; it's about expression, mood, and bringing your unique vision to life. Whether you are looking to elevate your bedroom, energize your workspace, or create an unforgettable backdrop for your next big event, we are here to craft the perfect glowing centerpiece.
                                </p>
                                <a class="btn-one" href="#"><span>More About us</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


     <section class="gallery-area pt-130 pb-130">
          <div class="container"> 
            <div class="swiper gallery__slider2">
                <div class="swiper-wrapper">
                    
                    <div class="swiper-slide">
                       
                           <div class="gallery__item">
                            <div class="off-tag">50% <br>
                                off</div>
                            <div class="gallery__image image">
<video autoplay loop muted playsinline width="100%" height="600">
  <source src="<?=base_url('public/assets/template/');?>assets/video/neon stories 1.mp4" type="video/mp4">
</video>

                            </div>
                            <div class="gallery__content">
                                <h3 class="mb-10"><a href="customize.html">
                      Turn Your Logo 
                    </a></h3>
                               
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                      
                           <div class="gallery__item">
                            <div class="off-tag">50% <br>
                                off</div>
                            <div class="gallery__image image">
<video autoplay loop muted playsinline width="100%" height="600">
  <source src="<?=base_url('public/assets/template/');?>assets/video/neon stories 2.mp4" type="video/mp4">
</video>


                            </div>
                            <div class="gallery__content">
                                <h3 class="mb-10"><a href="customize.html">
                     Multi-Color Signs 
                    </a></h3>
                       
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                      
                           <div class="gallery__item">
                            <div class="off-tag">50% <br>
                                off</div>
                            <div class="gallery__image image">

<video autoplay loop muted playsinline width="100%" height="600">
  <source src="<?=base_url('public/assets/template/');?>assets/video/neon stories 3.mp4" type="video/mp4">
</video>

                            </div>
                            <div class="gallery__content">
                                <h3 class="mb-10"><a href="customize.html">
                    Shop Our Bestsellers
                    </a></h3>
                              
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                            
                           <div class="gallery__item">
                            <div class="off-tag">50% <br>
                                off</div>
                            <div class="gallery__image image">
<video autoplay loop muted playsinline width="100%" height="600">
  <source src="<?=base_url('public/assets/template/');?>assets/video/neon stories 4.mp4" type="video/mp4">
</video>

                            </div>
                            <div class="gallery__content">
                                <h3 class="mb-10"><a href="customize.html">Customise Your Own</a></h3>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>

                <section class="get-now-area pt-130 pb-130">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-7">
                        <h4 class="mb-30 wow fadeInUp" data-wow-delay=".1s">
                            
                           NEON <span class="primary-color">STORIES</span></h4>
                        <div class="section-header d-flex align-items-center wow fadeInUp" data-wow-delay=".2s">
                            <span class="title-icon mr-10"></span>
                            <h2>​Why Choose Neon Stories?

</h2>
                        </div>
                        <div class="get-now__content">
                          
                            <p class="fw-600 wow fadeInUp" data-wow-delay=".3s">
                                
                     
                                Premium Craftsmanship: Our signs are meticulously handcrafted using top-tier LED technology, ensuring a bright, consistent glow that outshines the rest.
​Completely Customizable: Your story, your rules. We offer endless possibilities in fonts, colors, and shapes so your sign is 100% uniquely yours.
​Eco-Friendly & Safe: We use modern LED flex technology. This means our signs are energy-efficient, shatter-resistant, and remain cool to the touch, making them perfectly safe for any room.
                            </p>
            
                            
          
                                 <p class="fw-600 wow fadeInUp" data-wow-delay=".3s">


                                    ​Hassle-Free Installation: We design our signs to be lightweight and incredibly easy to mount, so you can plug in and light up your space in minutes.
​Let’s Glow Together
</p>


                                <p class="fw-600 wow fadeInUp" data-wow-delay=".3s">


                                    We aren't just creating signs; we are crafting the glowing moments that define your favorite spaces. Explore our collections, dream up a custom design, and let Neon Stories light up your world.
</p>



                             <a class="btn-one mt-20 wow fadeInUp" data-wow-delay=".3s" href="#"><span>Shop
                                        Now</span></a>
                           
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="get-now__image mt-5 mt-xl-0">
                            <div class="get-bg-image">
                                <img src="<?=base_url('public/assets/template/');?>assets/images/get-bg.png" alt="image">
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </section>


            <section class="gallery-area">
            <div class="swiper gallery__slider">
                <div class="swiper-wrapper">
                     <?php
                        $getFeaturedProductList = getProductList('featured');
                        if(!empty($getFeaturedProductList)){
                            foreach($getFeaturedProductList as $row) {
                                $priceData = findProductPrice($row->id);
                        ?>
                    <div class="swiper-slide">
                        <div class="gallery__item">
                            <?php if($priceData['discountAmount'] > 0){ ?>
                            <div class="off-tag"> <?=$row->compare_price?> <?=$priceData['offSymbol']?><br>Off </div>
                            <?php } ?>
                            <div class="gallery__image image">
                                <img src="<?=validImg($row->product_image)?>" alt="image">
                            </div>
                            <div class="gallery__content">
                                <h3 class="mb-10"><a href="<?= base_url().'product-details/'.$row->slug;?>"><?= $row->product_title ?></a></h3>
                                <p><?=substr($row->short_description, 0, 50)?></p>
                                <a href="<?= base_url().'product-details/'.$row->slug;?>" class="btn-two mt-25"><span>Shop Now</span></a>
                            </div>
                        </div>
                    </div>
                     <?php 
                            }
                        }
                        ?>
                   
                
               

                </div>
            </div>
        </section>

      

                <section class="testimonial pt-130 pb-130">
            <div class="container">
                <div class="testimonial__wrp bor radius-10">
                    <div class="testimonial__head-wrp bor-bottom pb-65 pt-65 pl-65 pr-65">
                        <div class="section-header d-flex align-items-center wow fadeInUp" data-wow-delay=".1s">
                            <span class="title-icon mr-10"></span>
                            <h2>customers speak for us</h2>
                        </div>
                        <div class="arry-btn my-4 my-lg-0">
                            <button class="arry-prev testimonial__arry-prev wow fadeInUp" data-wow-delay=".2s"><i
                                    class="fa-light fa-chevron-left"></i></button>
                            <button class="ms-3 active arry-next testimonial__arry-next wow fadeInUp"
                                data-wow-delay=".3s"><i class="fa-light fa-chevron-right"></i></button>
                        </div>
                    </div>
                    <div class="pt-45 pb-45 pr-55">
                        <div class="row g-4 align-items-center justify-content-between">
                            <div class="col-lg-7">
                                <div class="swiper testimonial__slider">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="testimonial__item pl-65">
                                                <div class="testi-header mb-30">
                                                    <div class="testi-content">
                                                        <h3>Kenneth S. Fisher</h3>
                                                        <span>marketing manager</span>
                                                    </div>
                                                    <i class="fa-solid fa-quote-right"></i>
                                                </div>
                                                <p>posuere luctus orci. Donec vitae mattis quam, vitae tempor arcu.
                                                    Aenean non odio porttitor, convallis erat sit amet, facilisis velit.
                                                    Nulla ornare convallis malesuada. Phasellus molestie, ipsum ac
                                                    fringilla.</p>
                                                <div class="star mt-30">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="testimonial__item pl-65">
                                                <div class="testi-header mb-30">
                                                    <div class="testi-content">
                                                        <h3>Francis A. Cote</h3>
                                                        <span>Garden Maker</span>
                                                    </div>
                                                    <i class="fa-solid fa-quote-right"></i>
                                                </div>
                                                <p>posuere luctus orci. Donec vitae mattis quam, vitae tempor arcu.
                                                    Aenean non odio porttitor, convallis erat sit amet, facilisis velit.
                                                    Nulla ornare convallis malesuada. Phasellus molestie, ipsum ac
                                                    fringilla.</p>
                                                <div class="star mt-30">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="testimonial__image">
                                    <div class="swiper testimonial__slider">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="<?=base_url('public/assets/template/');?>assets/images/testimonial2.png" alt="image">
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="<?=base_url('public/assets/template/');?>assets/images/testimonial2.png" alt="image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

  <section class="service-area  pb-130">
            <div class="container">
                <div class="row g-4 align-items-center justify-content-center justify-content-lg-start">
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="service__item mb-50 wow fadeInUp" data-wow-delay=".1s">
                            <div class="service__icon">
                                <img src="<?=base_url('public/assets/template/');?>assets/images/feature-icon1.png" alt="icon">
                            </div>
                            <div class="service__content">
                                <h4>Free delivery</h4>
                                <p>For all orders above Rs 1145</p>
                            </div>
                        </div>
                        <div class="service__item wow fadeInUp" data-wow-delay=".2s">
                            <div class="service__icon">
                                <img src="<?=base_url('public/assets/template/');?>assets/images/feature-icon2.png" alt="icon">
                            </div>
                            <div class="service__content">
                                <h4>Secure payments</h4>
                                <p>Confidence on all your devices</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-4 d-none d-lg-block wow bounceIn" data-wow-delay=".7s">
                        <div class="service__image image">
                            <img src="<?=base_url('public/assets/template/');?>assets/images/service-image.png" alt="image">
                            <div class="section-header service-header d-flex align-items-center">
                                <span class="title-icon mr-10"></span>
                                <h2>sign up & save 25%</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="service__item mb-50 wow fadeInUp" data-wow-delay=".3s">
                            <div class="service__icon">
                                <img src="<?=base_url('public/assets/template/');?>assets/images/feature-icon3.png" alt="icon">
                            </div>
                            <div class="service__content">
                                <h4>Top-notch support</h4>
                                <p>info@neonstories.com</p>
                            </div>
                        </div>
                        <div class="service__item wow fadeInUp" data-wow-delay=".4s">
                            <div class="service__icon">
                                <img src="<?=base_url('public/assets/template/');?>assets/images/feature-icon4.png" alt="icon">
                            </div>
                            <div class="service__content">
                                <h4>180 Days Return</h4>
                                <p>money back guranry</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    
    </main>

 <?= view('frontend/inc/footerLink') ?>



 <script src="<?=base_url('public/assets/template/')?>assets/js/cart.js"></script>

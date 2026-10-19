<?= view('frontend/inc/header') ?>


<style>

</style>
   

<main>
    <!-- Full-Width Hero Banner Area Start -->
    <section class="banner-area hero-banner-section">
        <div class="hero-banner-slider banner__slider">
            <?php if (!empty($banner)): ?>
                <?php foreach ($banner as $ban): ?>
                    <div class="hero-banner-slide banner__item">
                        <!-- Full-Width Background Image & Ambient Overlay -->
                        <div class="hero-slide-bg">
                            <img class="hero-bg-img" src="<?= validImg($ban->image) ?>" alt="<?= esc(strip_tags($ban->title)) ?>">
                            <div class="hero-slide-overlay"></div>
                        </div>

                        <!-- Foreground Content Layer -->
                        <div class="container hero-slide-content h-100">
                            <div class="row align-items-center h-100">
                                <div class="col-xl-8 col-lg-9 col-md-11">
                                    <?php if (!empty($ban->subtitle)): ?>
                                        <div class="hero-pill-badge wow fadeInUp" data-wow-delay=".1s">
                                            <span class="badge-pulse-dot"></span>
                                            <span class="badge-label"><?= esc($ban->subtitle) ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <h1 class="hero-main-title wow fadeInUp" data-wow-delay=".2s">
                                        <?= $ban->title ?>
                                    </h1>

                                    <div class="hero-btn-group wow fadeInUp" data-wow-delay=".3s">
                                        <a class="hero-btn-primary" href="<?= !empty($ban->url) ? $ban->url : base_url('') ?>">
                                            <span><?= !empty($ban->button_title) ? esc($ban->button_title) : 'Shop Now' ?></span>
                                            <i class="fa-solid fa-arrow-right-long"></i>
                                        </a>
                                        <a class="hero-btn-secondary" href="<?= base_url('collections/customize') ?>">
                                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                                            <span>Customize Your Neon</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback Banner Slide if no dynamic banners in DB -->
                <div class="hero-banner-slide banner__item">
                    <div class="hero-slide-bg">
                        <img class="hero-bg-img" src="<?= base_url('public/assets/template/assets/images/banner.png') ?>" alt="Neon Stories">
                        <div class="hero-slide-overlay"></div>
                    </div>
                    <div class="container hero-slide-content h-100">
                        <div class="row align-items-center h-100">
                            <div class="col-xl-8 col-lg-9 col-md-11">
                                <div class="hero-pill-badge wow fadeInUp" data-wow-delay=".1s">
                                    <span class="badge-pulse-dot"></span>
                                    <span class="badge-label">PREMIUM HANDCRAFTED NEON</span>
                                </div>
                                <h1 class="hero-main-title wow fadeInUp" data-wow-delay=".2s">
                                    India’s No. 1 <br> for <span class="primary-color">neon lights brand</span>
                                </h1>
                                <div class="hero-btn-group wow fadeInUp" data-wow-delay=".3s">
                                    <a class="hero-btn-primary" href="<?= base_url('') ?>">
                                        <span>Shop Now</span>
                                        <i class="fa-solid fa-arrow-right-long"></i>
                                    </a>
                                    <a class="hero-btn-secondary" href="<?= base_url('collections/customize') ?>">
                                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                                        <span>Customize Your Neon</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!-- Full-Width Hero Banner Area End -->

    <!-- Premium Products Showcase Section Start -->
    <?php
    $getProductList = getProductList('premium');
    if (!empty($getProductList)):
    ?>
    <section class="premium-showcase-section">
        <div class="container">
            <!-- Header with Title and Swiper Controls -->
            <div class="premium-header-bar wow fadeInUp" data-wow-delay=".1s">
                <div>
                    <div class="premium-title-tag">
                        <span class="title-icon"></span>
                        <span>EXCLUSIVE SELECTION</span>
                        <span class="title-icon"></span>
                    </div>
                    <h2 class="premium-section-title mb-0">
                        Trending <span class="primary-color">Premium Neon</span>
                    </h2>
                </div>
                <div class="premium-controls-wrap mt-3 mt-md-0">
                    <button type="button" class="premium-swiper-btn premium-prev" aria-label="Previous Product">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button type="button" class="premium-swiper-btn premium-next" aria-label="Next Product">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                    <a href="<?= base_url(''); ?>" class="premium-view-all-btn ms-2">
                        <span>View All</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Product Swiper Slider (4 items on desktop) -->
            <div class="swiper product__slider">
                <div class="swiper-wrapper">
                    <?php
                    foreach ($getProductList as $row) {
                        $priceData = findProductPrice($row->id);
                        $discountPercent = 0;
                        if (!empty($priceData['price']) && !empty($priceData['salesPrice']) && $priceData['price'] > $priceData['salesPrice']) {
                            $discountPercent = round((($priceData['price'] - $priceData['salesPrice']) / $priceData['price']) * 100);
                        }
                    ?>
                    <div class="swiper-slide">
                        <div class="premium-product-card">
                            <div class="card-badges">
                                <span class="badge-premium-pill">
                                    <i class="fa-solid fa-bolt"></i> PREMIUM
                                </span>
                                <?php if ($discountPercent > 0): ?>
                                    <span class="badge-discount-pill">-<?= $discountPercent ?>%</span>
                                <?php endif; ?>
                            </div>

                            <a href="#0" class="wishlist" title="Add to Wishlist">
                                <i class="fa-regular fa-heart"></i>
                            </a>

                            <a href="<?= base_url().'product-details/'.$row->slug;?>" class="premium-card-image-wrap">
                                <img src="<?=validImg($row->product_image)?>" alt="<?=esc($row->product_title)?>" class="premium-card-img">
                            </a>

                            <div class="premium-card-body">
                                <h4 class="premium-card-title">
                                    <a href="<?= base_url().'product-details/'.$row->slug;?>"><?=esc($row->product_title)?></a>
                                </h4>
                                <div class="premium-price-box">
                                    <span class="premium-sales-price"><?=money_format_custom($priceData['salesPrice'])?></span>
                                    <?php if (!empty($priceData['price']) && $priceData['price'] > $priceData['salesPrice']): ?>
                                        <del class="premium-regular-price"><?=money_format_custom($priceData['price'])?></del>
                                    <?php endif; ?>
                                </div>
                                <div class="premium-card-rating">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <span class="rating-text">(5.0)</span>
                                </div>
                                <div class="premium-card-action">
                                    <a class="btn-card-details" href="<?= base_url().'product-details/'.$row->slug;?>">
                                        <span>View Details</span>
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="dot product__dot mt-40"></div>
        </div>
    </section>
    <?php endif; ?>
    <!-- Premium Products Showcase Section End -->

        <!-- Category area start here -->
        <section class="category-area pt-5 pb-5 bg-light-dark sec-w">
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
                                        <div class="category__item text-center main-border">
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
     
                <section class="product-area pt-70 pb-70 ">
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
                            <a href="#<?= base_url(''); ?>" class="nav-link px-4 bor-left bor-right">
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
                                            <div class="product__item bor main-border">
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
                                                <a class="product__cart d-block bor-top" href="<?= base_url().'product-details/'.$row->slug;?>"><i class="fa-regular fa-eye me-1"></i>
                                                    <span>View Details</span></a>
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



        <section class="discount-area about-area  pt-70 pb-70 bg-light-dark" >
            <div class="container">
                <div class="row align-items-center main-border">
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
                                    <h2>About Neon Stories</h2>
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

        <!-- Why Choose Neon Stories Area Start -->
        <section class="why-choose-area get-now-area">
            <div class="why-choose-ambient-bg"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-xl-7">
                        <div class="why-choose-content">
                            <!-- Tag / Subtitle -->
                            <div class="why-tag-wrap wow fadeInUp" data-wow-delay=".1s">
                                <span class="why-tag-dot"></span>
                                <span class="why-tag-text">WHY CHOOSE</span>
                            </div>

                            <!-- Main Title -->
                            <h2 class="why-choose-title wow fadeInUp" data-wow-delay=".2s">
                                Why Choose Neon Stories?
                            </h2>

                            <!-- Description -->
                            <p class="why-choose-desc wow fadeInUp" data-wow-delay=".3s">
                                We're more than just a neon brand &mdash; we're a team of creators and dreamers. From custom designs to premium quality, every sign is crafted with care. Our neon lights are durable, energy efficient and made to make your space unforgettable.
                            </p>

                            <!-- 2x2 Feature Grid -->
                            <div class="why-feature-grid wow fadeInUp" data-wow-delay=".4s">
                                <div class="why-feature-item">
                                    <div class="why-feature-icon">
                                        <i class="fa-solid fa-award"></i>
                                    </div>
                                    <div class="why-feature-text">
                                        <span class="why-feature-name">Premium Quality</span>
                                        <span class="why-feature-sub">Long Lasting Glow</span>
                                    </div>
                                </div>

                                <div class="why-feature-item">
                                    <div class="why-feature-icon">
                                        <i class="fa-solid fa-bezier-curve"></i>
                                    </div>
                                    <div class="why-feature-text">
                                        <span class="why-feature-name">Custom Designs</span>
                                        <span class="why-feature-sub">Made Just for You</span>
                                    </div>
                                </div>

                                <div class="why-feature-item">
                                    <div class="why-feature-icon">
                                        <i class="fa-solid fa-truck-fast"></i>
                                    </div>
                                    <div class="why-feature-text">
                                        <span class="why-feature-name">Fast & Reliable Shipping</span>
                                        <span class="why-feature-sub">Across India</span>
                                    </div>
                                </div>

                                <div class="why-feature-item">
                                    <div class="why-feature-icon">
                                        <i class="fa-solid fa-headset"></i>
                                    </div>
                                    <div class="why-feature-text">
                                        <span class="why-feature-name">Dedicated Support</span>
                                        <span class="why-feature-sub">We're Here for You</span>
                                    </div>
                                </div>
                            </div>

                            <!-- CTA Button -->
                            <div class="why-btn-wrap wow fadeInUp" data-wow-delay=".5s">
                                <a class="why-btn-explore" href="<?= base_url(''); ?>">
                                    <span>Explore More</span>
                                    <i class="fa-solid fa-arrow-right-long"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 col-xl-5 mt-5 mt-lg-0">
                        <div class="why-portal-wrapper wow fadeInRight" data-wow-delay=".3s">
                            <div class="why-portal-outer-ring">
                                <div class="why-portal-inner">
                                    <img src="<?=base_url('public/assets/template/');?>assets/images/get-bg.png" alt="Why Choose Neon Stories" class="why-portal-img">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Why Choose Neon Stories Area End -->


        <!-- Featured Products Gallery Slider Start -->
        <section class="gallery-area gallery-featured-area pt-70 pb-70">
            <div class="container mb-40">
                <div class="d-flex flex-wrap align-items-end justify-content-between">
                    <div>
                        <div class="sub-title mb-10 wow fadeInUp" data-wow-delay=".1s">
                            <span class="title-icon mr-10"></span>
                            <span class="text-uppercase fw-semibold" style="letter-spacing: 2px; color: var(--primary-color); font-size: 13px;">HANDPICKED SPOTLIGHT</span>
                            <span class="title-icon ml-10"></span>
                        </div>
                        <h2 class="mb-0 wow fadeInUp" data-wow-delay=".2s" style="color: #ffffff; font-weight: 700;">
                            Featured <span class="primary-color">Neon Collection</span>
                        </h2>
                    </div>
                    <div class="gallery-nav-btns d-flex gap-2 mt-3 mt-md-0 wow fadeInUp" data-wow-delay=".3s">
                        <button type="button" class="gallery-swiper-btn gallery-prev" aria-label="Previous Slide">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button type="button" class="gallery-swiper-btn gallery-next" aria-label="Next Slide">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                        <a href="<?= base_url(''); ?>" class="gallery-view-all-btn ms-2">
                            <span>View All</span>
                            <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="swiper gallery__slider">
                <div class="swiper-wrapper">
                    <?php
                    $getFeaturedProductList = getProductList('featured');
                    if (!empty($getFeaturedProductList)) {
                        foreach ($getFeaturedProductList as $row) {
                            $priceData = findProductPrice($row->id);
                    ?>
                        <div class="swiper-slide">
                            <div class="gallery__item main-border">
                                <?php if (!empty($priceData['discountAmount']) && $priceData['discountAmount'] > 0) { ?>
                                    <div class="gallery__off-tag">
                                        <span>-<?=$row->compare_price?><?=$priceData['offSymbol']?></span>
                                    </div>
                                <?php } ?>

                                <a href="<?= base_url().'product-details/'.$row->slug;?>" class="gallery__image">
                                    <img src="<?=validImg($row->product_image)?>" alt="<?=esc($row->product_title)?>">
                                </a>

                                <div class="gallery__content">
                                    <div class="gallery__content-top">
                                        <h3 class="gallery__item-title">
                                            <a href="<?= base_url().'product-details/'.$row->slug;?>"><?= esc($row->product_title) ?></a>
                                        </h3>
                                        <?php if (!empty($row->short_description)): ?>
                                            <p class="gallery__item-desc"><?= esc(strip_tags($row->short_description)) ?></p>
                                        <?php else: ?>
                                            <p class="gallery__item-desc">Custom handcrafted neon light designed for your space.</p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="gallery__content-bottom">
                                        <div class="gallery__item-price">
                                            <span class="price-sales"><?=money_format_custom($priceData['salesPrice'])?></span>
                                            <?php if (!empty($priceData['price']) && $priceData['price'] > $priceData['salesPrice']): ?>
                                                <del class="price-regular ms-2"><?=money_format_custom($priceData['price'])?></del>
                                            <?php endif; ?>
                                        </div>

                                        <a href="<?= base_url().'product-details/'.$row->slug;?>" class="gallery__btn">
                                            <span>Shop Now</span>
                                            <i class="fa-solid fa-arrow-right-long"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php 
                        }
                    }
                    ?>
                </div>
                <div class="dot gallery__dot mt-35"></div>
            </div>
        </section>
        <!-- Featured Products Gallery Slider End -->

      

        <!-- Testimonial Area Start -->
        <section class="testimonial pt-70 pb-70">
            <div class="container">
                <div class="testimonial__wrp radius-10">
                    <div class="testimonial__head-wrp pb-20 pt-25 pl-40 pr-40">
                        <div>
                            <div class="sub-title mb-2">
                                <span class="badge-neon-pill"><i class="fa-solid fa-sparkles"></i> 4.9/5 Rating from 2,500+ Spaces</span>
                            </div>
                            <div class="section-header d-flex align-items-center wow fadeInUp" data-wow-delay=".1s">
                                <span class="title-icon mr-10"></span>
                                <h2>Customers Speak For Us</h2>
                            </div>
                        </div>
                        <div class="arry-btn my-3 my-lg-0 d-flex">
                            <button class="arry-prev testimonial__arry-prev wow fadeInUp main-border" data-wow-delay=".2s" aria-label="Previous Review">
                                <i class="fa-light fa-chevron-left"></i>
                            </button>
                            <button class="ms-3 active arry-next testimonial__arry-next wow fadeInUp main-border" data-wow-delay=".3s" aria-label="Next Review">
                                <i class="fa-light fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-4 p-lg-5">
                        <div class="swiper testimonial__slider">
                            <div class="swiper-wrapper">
                                <?php if (!empty($feedback)): ?>
                                    <?php foreach ($feedback as $fb): 
                                        $profileImg = !empty($fb->profile) ? validImg($fb->profile) : base_url('public/assets/template/assets/images/testimonial2.png');
                                        $authorName = !empty($fb->username) ? $fb->username : 'Happy Customer';
                                        $authorRole = !empty($fb->designation) ? $fb->designation : 'Verified Neon Sign Owner';
                                        $authorNote = !empty($fb->note) ? $fb->note : 'The neon sign turned out absolutely stunning! Incredible quality, bright colors, and fast delivery.';
                                    ?>
                                        <div class="swiper-slide">
                                            <div class="testimonial-box">
                                                <div class="row g-4 align-items-center">
                                                    <div class="col-lg-8 col-md-7">
                                                        <div class="d-flex align-items-center gap-3 mb-20 flex-wrap">
                                                            <div class="neon-stars">
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                            </div>
                                                            <span class="verified-pill"><i class="fa-solid fa-circle-check"></i> Verified Purchase</span>
                                                        </div>
                                                        <p class="testi-quote-text">
                                                            "<?= esc($authorNote) ?>"
                                                        </p>
                                                        <div class="testi-author-info mt-25 d-flex align-items-center justify-content-between">
                                                            <div>
                                                                <h3 class="author-name"><?= esc($authorName) ?></h3>
                                                                <span class="author-role"><?= esc($authorRole) ?></span>
                                                            </div>
                                                            <div class="testi-quote-icon">
                                                                <i class="fa-solid fa-quote-right"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-5">
                                                        <div class="testi-avatar-side text-center">
                                                            <div class="testi-avatar-portal">
                                                                <img src="<?= $profileImg ?>" alt="<?= esc($authorName) ?>">
                                                            </div>
                                                            <div class="portal-trust-tag mt-3">
                                                                <i class="fa-solid fa-sparkles text-cyan me-1"></i> 100% Custom Crafted
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- Fallback High Quality Testimonial 1 -->
                                    <div class="swiper-slide">
                                        <div class="testimonial-box">
                                            <div class="row g-4 align-items-center">
                                                <div class="col-lg-8 col-md-7">
                                                    <div class="d-flex align-items-center gap-3 mb-20 flex-wrap">
                                                        <div class="neon-stars">
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                        </div>
                                                        <span class="verified-pill"><i class="fa-solid fa-circle-check"></i> Verified Purchase</span>
                                                    </div>
                                                    <p class="testi-quote-text">
                                                        "The custom LED neon sign for our cafe entrance turned out absolutely phenomenal! The glow is crisp, vibrant, and uniform with zero dark spots. All our guests take selfies in front of it every single day. Multi-layer wooden packing kept it 100% safe during shipping."
                                                    </p>
                                                    <div class="testi-author-info mt-25 d-flex align-items-center justify-content-between">
                                                        <div>
                                                            <h3 class="author-name">Aarav Sharma</h3>
                                                            <span class="author-role">Cafe &amp; Bistro Owner • Mumbai</span>
                                                        </div>
                                                        <div class="testi-quote-icon">
                                                            <i class="fa-solid fa-quote-right"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-5">
                                                    <div class="testi-avatar-side text-center">
                                                        <div class="testi-avatar-portal">
                                                            <img src="<?=base_url('public/assets/template/');?>assets/images/testimonial2.png" alt="Aarav Sharma">
                                                        </div>
                                                        <div class="portal-trust-tag mt-3">
                                                            <i class="fa-solid fa-sparkles text-cyan me-1"></i> Custom Cafe Branding
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fallback High Quality Testimonial 2 -->
                                    <div class="swiper-slide">
                                        <div class="testimonial-box">
                                            <div class="row g-4 align-items-center">
                                                <div class="col-lg-8 col-md-7">
                                                    <div class="d-flex align-items-center gap-3 mb-20 flex-wrap">
                                                        <div class="neon-stars">
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                        </div>
                                                        <span class="verified-pill"><i class="fa-solid fa-circle-check"></i> Verified Purchase</span>
                                                    </div>
                                                    <p class="testi-quote-text">
                                                        "We ordered our couple initials with warm white and rose pink glow for our wedding reception. It stole the spotlight on the backdrop! Now it hangs beautifully in our living room. Super easy to mount, complete with dimmer remote and adapter."
                                                    </p>
                                                    <div class="testi-author-info mt-25 d-flex align-items-center justify-content-between">
                                                        <div>
                                                            <h3 class="author-name">Riya &amp; Kabir Mehta</h3>
                                                            <span class="author-role">Wedding Decor Sign • New Delhi</span>
                                                        </div>
                                                        <div class="testi-quote-icon">
                                                            <i class="fa-solid fa-quote-right"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-5">
                                                    <div class="testi-avatar-side text-center">
                                                        <div class="testi-avatar-portal">
                                                            <img src="<?=base_url('public/assets/template/');?>assets/images/testimonial2.png" alt="Riya & Kabir">
                                                        </div>
                                                        <div class="portal-trust-tag mt-3">
                                                            <i class="fa-solid fa-sparkles text-cyan me-1"></i> Wedding Backdrop Neon
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fallback High Quality Testimonial 3 -->
                                    <div class="swiper-slide">
                                        <div class="testimonial-box">
                                            <div class="row g-4 align-items-center">
                                                <div class="col-lg-8 col-md-7">
                                                    <div class="d-flex align-items-center gap-3 mb-20 flex-wrap">
                                                        <div class="neon-stars">
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                        </div>
                                                        <span class="verified-pill"><i class="fa-solid fa-circle-check"></i> Verified Purchase</span>
                                                    </div>
                                                    <p class="testi-quote-text">
                                                        "Top-tier craftsmanship! The acrylic backboard is laser-cut to perfection and the Japanese silicone LED neon tubing looks super sleek even when turned off. The color brightness on camera during streams is unreal. 10/10 recommendation!"
                                                    </p>
                                                    <div class="testi-author-info mt-25 d-flex align-items-center justify-content-between">
                                                        <div>
                                                            <h3 class="author-name">Devansh Verma</h3>
                                                            <span class="author-role">Gaming &amp; YouTube Studio • Bengaluru</span>
                                                        </div>
                                                        <div class="testi-quote-icon">
                                                            <i class="fa-solid fa-quote-right"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-5">
                                                    <div class="testi-avatar-side text-center">
                                                        <div class="testi-avatar-portal">
                                                            <img src="<?=base_url('public/assets/template/');?>assets/images/testimonial2.png" alt="Devansh Verma">
                                                        </div>
                                                        <div class="portal-trust-tag mt-3">
                                                            <i class="fa-solid fa-sparkles text-cyan me-1"></i> Gaming Studio Sign
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="dot testimonial__dot mt-35"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonial Area End -->

        <!-- Service & Trust Badges Area Start -->
        <section class="service-area pb-130">
            <div class="container">
                <div class="row g-4 justify-content-center">
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="service-card-item wow fadeInUp" data-wow-delay=".1s">
                            <div class="service-icon-box">
                                <i class="fa-solid fa-truck-fast"></i>
                            </div>
                            <div class="service-text">
                                <h4>Free Safe Delivery</h4>
                                <p>Pan-India tracked express shipping with heavy-duty protective wooden crating</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="service-card-item wow fadeInUp" data-wow-delay=".2s">
                            <div class="service-icon-box">
                                <i class="fa-solid fa-shield-check"></i>
                            </div>
                            <div class="service-text">
                                <h4>2-Year Glow Warranty</h4>
                                <p>Full replacement warranty on premium LED tubing, wiring, and certified power adapters</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="service-card-item wow fadeInUp" data-wow-delay=".3s">
                            <div class="service-icon-box">
                                <i class="fa-solid fa-lock-keyhole"></i>
                            </div>
                            <div class="service-text">
                                <h4>100% Secure Payments</h4>
                                <p>Bank-grade encrypted checkout via UPI, Debit/Credit Cards, NetBanking &amp; No-Cost EMI</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="service-card-item wow fadeInUp" data-wow-delay=".4s">
                            <div class="service-icon-box">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                            <div class="service-text">
                                <h4>Dedicated Support</h4>
                                <p>Instant WhatsApp design previews, free visual mockups &amp; 24/7 client care assistance</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Neon VIP Perks Banner -->
                <div class="service-promo-card mt-45 wow fadeInUp" data-wow-delay=".5s">
                    <div class="row align-items-center justify-content-between g-4">
                        <div class="col-lg-7 col-md-8">
                            <div class="service-promo-content">
                                <div class="promo-tag mb-2">
                                    <span class="badge-neon-pill"><i class="fa-solid fa-sparkles"></i> Limited Time Offer</span>
                                </div>
                                <h3>Light Up Your Space &amp; Save <span class="primary-color">10% OFF</span></h3>
                                <p class="mb-0">
                                    Design your personalized LED neon sign today with live digital preview. Use coupon code <span class="promo-code-pill">NEON10</span> at checkout!
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-4 text-md-end">
                            <div class="service-promo-actions d-flex flex-wrap align-items-center justify-content-md-end gap-3">
                                <a href="<?=base_url('collections/customize');?>" class="btn-one">
                                    <span>Customize Sign</span>
                                    <i class="fa-regular fa-arrow-right-long ms-2"></i>
                                </a>
                                <a href="<?=base_url('contact');?>" class="service-ghost-btn">
                                    <span>Get Free Mockup</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Service & Trust Badges Area End -->

    
    </main>

 <?= view('frontend/inc/footerLink') ?>

 <script src="<?=base_url('public/assets/template/')?>assets/js/cart.js"></script>

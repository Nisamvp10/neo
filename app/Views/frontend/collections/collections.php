<?= view('frontend/inc/header') ?>

<main>
    <!-- Full-Width Hero Banner Area Start -->
<section class="banner-area hero-banner-section">
</section>
   
<?= view('frontend/sections/categories'); ?>
 

    <section class="product-area pt-130 pb-130 ">
            <div class="container">
                <div
                    class="product__wrp pb-30 mb-65 bor-bottom d-flex flex-wrap align-items-center justify-content-xl-between justify-content-center">
                    <div class="section-header d-flex align-items-center wow fadeInUp" data-wow-delay=".1s">
                        <span class="title-icon mr-10"></span>
                        <h2><?php echo $page; ?></h2>
                    </div>
                    
                </div>
                <div class="tab-content">
                    <div id="latest-item" class="tab-pane fade show active">
                        <?= view('frontend/products/custom_products',['products' => $custProducts]) ?>
                  
                </div>
            </div>
        </section>

         <?= view('frontend/inc/footerLink') ?>


<?= view('frontend/inc/header') ?>
<main>
    <?= view('frontend/category/category') ?>

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
                            <a href="#top-ratting" data-bs-toggle="tab" class="nav-link px-4 bor-left bor-right">
                                top ratting
                            </a>
                        </li>
                        <li class="nav-item wow fadeInUp" data-wow-delay=".3s">
                            <a href="#featured-products" data-bs-toggle="tab" class="nav-link ps-4">
                                featured products
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div id="latest-item" class="tab-pane fade show active">
                        <?= view('frontend/products/custom_products',['products' => $custProducts]) ?>
                  
                </div>
            </div>
        </section>

         <?= view('frontend/inc/footerLink') ?>


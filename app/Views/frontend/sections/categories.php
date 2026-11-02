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
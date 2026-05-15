<?= view('frontend/inc/header') ?>
<main>
     <section class="page-banner bg-image pt-130 pb-130" data-background="<?=base_url('public/assets/template/assets/images/inner-banner.jpg')?>">
            <div class="container">
                <h2 class="wow fadeInUp mb-15" data-wow-duration="1.1s" data-wow-delay=".1s"><?=$pageTitle?></h2>
                <div class="breadcrumb-list wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".3s">
                  <a href="#" class="primary-hover"><i class="fa-solid fa-house me-1"></i> Home <i
                            class="fa-regular text-white fa-angle-right"></i></a>
                    <a href="#" class="primary-hover"><?=$page?> <i class="fa-regular text-white fa-angle-right"></i></a>
                    <span><?=$pageTitle?> </span>
                </div>
            </div>
        </section>

          <section class="shop-single pt-130 pb-130">
            <div class="container">
                <!-- product-details area start here -->
                <?= view('frontend/products/product_detail', ['product' => $product,'productSize' => $productSize,'productAddon' => $productAddon,'productColor' => $productColor,'productVariantImages' => $productVariantImages]); ?>
                <!-- product-details area end here -->

                <!-- description review area start here -->
                <div class="shop-singe-tab">
                    <ul class="nav nav-pills mb-4 bor-top bor-bottom py-2">
                        <li class="nav-item">
                            <a href="#description" data-bs-toggle="tab" class="nav-link ps-0 pe-3 active">
                                <h4 class="text-uppercase">description</h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#review" data-bs-toggle="tab" class="nav-link">
                                <h4 class="text-uppercase">What’s in the box?</h4>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="description" class="tab-pane fade show active">
                            <p class="pb-4 text-justify">
                                Neon Attack’s neon signs are handcrafted with advanced 2nd gen LED on high-quality 6MM transparent acrylic. Energy-efficient, durable, and easy to install—perfect for any space!
Neon Attack’s neon signs are handcrafted with advanced 2nd gen LED on high-quality 6MM transparent acrylic. Energy-efficient, durable, and easy to install—perfect for any space!



                            </p>
                            <p class="pb-4 text-justify"> Neon Attack’s neon signs are handcrafted with advanced 2nd gen LED on high-quality 6MM transparent acrylic. Energy-efficient, durable, and easy to install—perfect for any space!

 Neon Attack’s neon signs are handcrafted with advanced 2nd gen LED on high-quality 6MM transparent acrylic. Energy-efficient, durable, and easy to install—perfect for any space!

</p>
                            <p class="text-justify">Neon Attack’s neon signs are handcrafted with advanced 2nd gen LED on high-quality 6MM transparent acrylic. Energy-efficient, durable, and easy to install—perfect for any space!

Neon Attack’s neon signs are handcrafted with advanced 2nd gen LED on high-quality 6MM transparent acrylic. Energy-efficient, durable, and easy to install—perfect for any space!

</p>
                        </div>
                        <div id="review" class="tab-pane fade">
                          
                                                      <p class="pb-4 text-justify">
                                Neon Attack’s neon signs are handcrafted with advanced 2nd gen LED on high-quality 6MM transparent acrylic. Energy-efficient, durable, and easy to install—perfect for any space!
Neon Attack’s neon signs are handcrafted with advanced 2nd gen LED on high-quality 6MM transparent acrylic. Energy-efficient, durable, and easy to install—perfect for any space!



                            </p>
                            <p class="pb-4 text-justify"> Neon Attack’s neon signs are handcrafted with advanced 2nd gen LED on high-quality 6MM transparent acrylic. Energy-efficient, durable, and easy to install—perfect for any space!

 Neon Attack’s neon signs are handcrafted with advanced 2nd gen LED on high-quality 6MM transparent acrylic. Energy-efficient, durable, and easy to install—perfect for any space!

</p>
                            <p class="text-justify">Neon Attack’s neon signs are handcrafted with advanced 2nd gen LED on high-quality 6MM transparent acrylic. Energy-efficient, durable, and easy to install—perfect for any space!

Neon Attack’s neon signs are handcrafted with advanced 2nd gen LED on high-quality 6MM transparent acrylic. Energy-efficient, durable, and easy to install—perfect for any space!

</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- description review area end here -->
        </section>




    

<?= view('frontend/inc/footerLink') ?>
<script>
var thumbSwiper = new Swiper(".shop-slider-thumb", {
    spaceBetween: 10,
    slidesPerView: 4,
    watchSlidesProgress: true,
});

var shopSwiper = new Swiper(".shop-single-slide", {
    spaceBetween: 10,
    thumbs: {
        swiper: thumbSwiper,
    },
});

document.querySelectorAll('.color_list').forEach(btn => {

    btn.addEventListener('click', function () {

        let color = this.dataset.color;

        let slides = document.querySelectorAll('.shop-single-slide .swiper-slide');

        slides.forEach((slide, index) => {

            if (slide.dataset.color === color) {

                // move swiper to matched slide
                shopSwiper.slideTo(index);

            }

        });

    });

});

// SIZE
$(document).on('click', '.sizeItem', function () {
    $('.sizeItem').removeClass('active');
    $(this).addClass('active');
    $(this).find('.sizeRadio').prop('checked', true);
    calculatePrice();

});

// ADDON
$(document).on('click', '.addonBox', function () {
    $(this).toggleClass('active');
    let checkbox = $(this).find('.addonCheckbox');
    checkbox.prop('checked', !checkbox.prop('checked'));
    calculatePrice();
});

// COLOR
$(document).on('click', '.color_list', function () {

    $('.color_list').removeClass('active');
    $(this).addClass('active');
    $(this).find('.colorRadio').prop('checked', true);
    calculatePrice();
});

function calculatePrice(){
    // PRODUCT ID
    let productId = <?= $product['id'] ?>;
    // SIZE
    let sizeId = $('.sizeRadio:checked').val();
    // COLOR
    let colorId = $('.colorRadio:checked').val();
    // ADDONS
    let addonIds = [];
    $('.addonCheckbox:checked').each(function(){
        addonIds.push($(this).val());
    });
    let qty = parseInt($('.qty').val()) || 1;
    console.log(qty);
    $.ajax({
        url : App.getSiteurl()+'calculate-product-price',
        type : "POST",
        data : {
            product_id : productId,
            size_id : sizeId,
            color_id : colorId,
            addon_ids : addonIds,
            qty : qty,
        },
        dataType : "json",
        success:function(response){
           if(response.success == true){
               $('#productSellingPrice').html(response.salesPrice);
               $('#productPrice').html(response.basePrice);
            }
        }
    });

}
// =========================
// SIZE CLICK
// =========================

$('.sizeRadio').change(function(){

    $('.board-size-list').removeClass('active');
    $(this).closest('.board-size-list').addClass('active');
    calculatePrice();
});

// =========================
// ADDON CLICK
// =========================

$('.addonCheckbox').change(function(){
    $(this).closest('.addonBox').toggleClass('active');
    calculatePrice();
});
// =========================
// COLOR CLICK
// =========================

$('.colorRadio').change(function(){
   $(this).find('.colorRadio').prop('checked',true).trigger('change');
    calculatePrice();

});

$(document).on('click', '.qtyplus, .qtyminus', function () {
    let qty = parseInt($('.qty').val()) || 1;
    if (qty >=1){
       calculatePrice();
    }

});


</script>
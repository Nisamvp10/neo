<?php

$mainProductImages = [];

if (!empty($product['product_image'])) {
    $mainProductImages['images'][] =[
        'image'=>     validImg($product['product_image']),
        'alt'=>'product',
    ];
}

if (!empty($productVariantImages)) {
    foreach ($productVariantImages as $index => $variantImage) {
        $mainProductImages['images'][] = [
            'image'=>validImg($variantImage['image']),
            'alt'=>'gallery'.$index,
        ];
    }
}


if (!empty($productColor)) {
    foreach ($productColor as $color) {
        $mainProductImages['images'][] = [
            'image'=>validImg($color['preview_image']),
            'alt'=> $color['color_name']
        ];
    }
}
// Product Price
$productPrice = $product['price'] ?? 0;
// product size first showing low size price
$priceInfo = lowPrizesizeItem($product['id']);
$defaultitemPrice = $priceInfo['extra_price'];
$defaultSizeId = $priceInfo['id'];

$totalPrice = $productPrice+$defaultitemPrice ?? 0;
// discount calculation 
$comparePrice = $product['compare_price'] ?? 0;
$discountPercent = 0;
$sellingPrice = 0;

if ($comparePrice > 0) {
    $discountPercent = ($totalPrice / 100) * $comparePrice;
    $sellingPrice = $totalPrice - $discountPercent;
}else{
    $sellingPrice = $totalPrice;
}
$pricedata = findProductPrice($product['id']);
?>

<style>
    .board-size-list{
        padding: 10px;
        border: 1px #d1d1d1 solid;
        border-radius: 10px;
        margin-right: 10px;
    }
    .board-size-list:last-child{
        margin-right: 0px;
    }
    .board-size-list.active{
        background: #1db3b3;
        color: #fff;
    }
    .addOn-wrap {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-top: 12px;
        
    }
    .color-wrap{
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin-top: 12px;
    }
    .color-wrap{
        grid-template-columns: repeat(auto-fit, 40px);
        justify-content: flex-start;
        gap: 8px;
        display: grid;
    }
    .color-wrap .color_list{
      cursor: pointer;
        border: 3px solid rgb(var(--section-background, var(--background)));
        border-radius: var(--color-swatch-border-radius);
        -webkit-tap-highlight-color: transparent;
        background-position: center;
        background-size: cover;
        width: 35px;
        height: 35px;
        display: block;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
        border: 1px #f1f1f1 solid;
    }
    .sizeItem,
.addonBox,
.color_list{
    cursor:pointer;
}
</style>
<div class="product-details-single pb-40">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="image img">
                <div class="swiper shop-single-slide">
                    <div class="swiper-wrapper">
                        <?php foreach($mainProductImages['images'] as $image):?>
                        <div class="swiper-slide" data-color="<?= strtolower($image['alt']) ?>">
                            <img src="<?= $image['image'] ?>" alt="<?= $image['alt'] ?>">
                        </div>
                        <?php endforeach;?>
                       
                    </div>
                </div>
                <div class="mt-3 swiper shop-slider-thumb">
                    <div class="swiper-wrapper">
                         <?php foreach($mainProductImages['images'] as $image):?>
                        <div class="swiper-slide slide-smoll" data-color="<?= strtolower($image['alt']) ?>">
                            <img src="<?= $image['image'] ?>" alt="<?= $image['alt'] ?>" style="height: 100px;">
                        </div>
                        <?php endforeach;?>
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="content h24">
                <h3 class="pb-2 primary-color"><?= $product['product_title'] ?? ''; ?></h3>
                <div class="star primary-color pb-2">
                    <span><i class="fa-solid fa-star sm-font"></i></span>
                    <span><i class="fa-solid fa-star sm-font"></i></span>
                                    <span><i class="fa-solid fa-star sm-font"></i></span>
                                    <span><i class="fa-solid fa-star sm-font"></i></span>
                                    <span><i class="fa-solid fa-star-half-stroke sm-font"></i></span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">

                                    <h2 class="pb-3" id="productSellingPrice"><?= money_format_custom($pricedata['salesPrice']); ?></h2>
                                    <?=($pricedata['discountAmount'] >0 ?'<span class="pb-3 text-decoration-line-through total_price" id="productPrice">'.money_format_custom($pricedata['price']).'</span>'  :'') ;?>
                                </div>
                                <h4 class="pb-2 primary-color">Product Description</h4>
                                <p class="text-justify mb-10">
                                    <?= $product['short_description'] ?? ''; ?>
                                 </p>
                              
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="details-area align-items-center">
                                        <?php if(!empty($productSize)):?>
                                        <div class="category flex-wrap mt-4 d-flex py-3 bor-top bor-bottom align-items-center">
                                            <h4 class="pe-3">Size :</h4>
                                            <?php foreach($productSize as $key=> $size):?>
                                                <div class="board-size-list sizeItem <?=($defaultSizeId == $size['id']) ? 'active' : '' ?> ">
                                                <input class="sizeRadio visually-hidden" type="radio" name="size" value="<?= $size['id'] ?? ''; ?>" id=""  <?= ($key == 0) ? 'checked' : '' ?>>
                                                <label class="" for=""><?= $size['width'].' X '.$size['height'] ?? ''; ?></label></div>
                                            <?php endforeach;?>
                                        </div>
                                        <?php endif;?>
                                       <?php
                                        if(!empty($productAddon)):?>
                                        <div class=" py-3 bor-bottom">
                                            <h4 class="pe-3">Add On :</h4>
                                            <div class="d-grid addOn-wrap">
                                            <?php foreach($productAddon as $addon):?>
                                            <a href="#0" class="primary-hover ">
                                                <div class="board-size-list m-0 addonBox">
                                                    <p><?= $addon['addon_name'] ?? ''; ?></p>
                                                    <small class="d-block"><?= money_format_custom($addon['addon_price'] ?? ''); ?></small>
                                                    <input type="checkbox" class="addonCheckbox visually-hidden"  name="addon" value="<?= $addon['id'] ?? ''; ?>">
                                                </div>
                                            </a>
                                            <?php endforeach;?>
                                            </div>
                                        </div>
                                        <?php endif;?>
                                        <?php if(!empty($productColor)):?>
                                        <div class=" py-3 bor-bottom">
                                            <h4 class="pe-3">Color:</h4>
                                            <div class="d-grid color-wrap">
                                           <?php foreach($productColor as $color): ?>
                                                <label class="color_list m-0 primary-hover" style="background-color: <?= $color['color_code'] ?>" data-color="<?= strtolower($color['color_name']) ?>" >
                                                    <input type="radio" class="colorRadio visually-hidden" name="color" value="<?= $color['id'] ?>">
                                                </label>
                                            <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <?php endif;?>
                                        <div class="d-flex flex-wrap align-items-center py-3 bor-bottom">
                                            <h4 class="pe-3">Share:</h4>
                                            <div class="social-media">
                                                <a href="#" class="mx-2 primary-color secondary-hover">
                                                    <i class="fa-brands fa-facebook-f"></i></a>
                                                <a href="#" class="mx-2 primary-color secondary-hover">
                                                    <i class="fa-brands fa-twitter"></i></a>
                                                <a href="#" class="mx-2 primary-color secondary-hover">
                                                    <i class="fa-brands fa-linkedin-in"></i></a>
                                                <a href="#" class="mx-2 primary-color secondary-hover">
                                                    <i class="fa-brands fa-instagram"></i></a>
                                                <a href="#" class="mx-2 primary-color secondary-hover">
                                                    <i class="fa-brands fa-pinterest-p"></i></a>
                                            </div>
                                        </div>
                                        <div class="cart-wrp py-4">
                                            <div class="cart-quantity">
                                                <form id='myform' method='POST' class='quantity' action='#'>
                                                    <input type='button' value='-' class='qtyminus minus'>
                                                    <input type='text' min='1' name='quantity' value='1' class='qty'>
                                                    <input type='button' value='+' class='qtyplus plus'>
                                                </form>
                                            </div>
                                            <!-- <div class="discount">
                                                <input type="text" placeholder="Enter Discount Code">
                                            </div> -->
                                        </div>
                                        <a href="#0" class="d-block text-center btn-two mt-40"><span><i class="fa-solid fa-basket-shopping pe-2"></i>add to cart</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
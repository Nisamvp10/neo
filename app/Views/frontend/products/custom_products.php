<div class="row g-4">
<?php
    $html = '';
    $rows = 1;
    $cols = 4;
    $i = 0;
    if(!empty($products)){
        foreach($products as $product) {
           if($i % $cols == 0){
            //$html .= '<div class="row g-4">';
           }
           $productPrice = $product->price ?? 0;
           $defaultprice = $product->extra_price ?? 0;
           $lowSalePrice = $productPrice + $defaultprice;
           $sellingPrice = $lowSalePrice;
           $comparePrice = $product->compare_price ?? 0;
           $priceOfferType = $product->price_offer_type ?? 2;
           $discountBadge = '';

           if ($lowSalePrice > 0 && $comparePrice > 0) {
               if ($priceOfferType == 1) {
                   // Flat discount in Rs
                   $discountAmount = $comparePrice;
                   $sellingPrice = max(0, $lowSalePrice - $discountAmount);
                   $discountBadge = '-' . money_format_custom($comparePrice);
               } else {
                   // Percentage discount (%)
                   $discountAmount = ($lowSalePrice / 100) * $comparePrice;
                   $sellingPrice = max(0, $lowSalePrice - $discountAmount);
                   $discountBadge = '-' . round($comparePrice) . '%';
               }
           }
       ?>

         <div class="col-xxl-3 col-xl-4 col-md-6 d-flex">
            <div class="premium-product-card w-100">
                <div class="card-badges">
                    <?php if (!empty($discountBadge) && $lowSalePrice > $sellingPrice): ?>
                        <span class="badge-discount-pill"><?= $discountBadge ?></span>
                    <?php else: ?>
                        <span class="badge-premium-pill">
                            <i class="fa-solid fa-bolt"></i> HOT
                        </span>
                    <?php endif; ?>
                </div>

                <a href="#0" class="wishlist" title="Add to Wishlist" aria-label="Add to Wishlist">
                    <i class="fa-regular fa-heart"></i>
                </a>

                <a href="<?= base_url().'product-details/'.$product->slug;?>" class="premium-card-image-wrap">
                    <img src="<?=validImg($product->product_image)?>" alt="<?=esc($product->product_title)?>" class="premium-card-img">
                </a>

                <div class="premium-card-body">
                    <h4 class="premium-card-title">
                        <a href="<?= base_url().'product-details/'.$product->slug;?>" title="<?=esc($product->product_title)?>"><?=esc($product->product_title)?></a>
                    </h4>

                    <div class="premium-price-box">
                        <span class="premium-sales-price"><?=money_format_custom($sellingPrice)?></span>
                        <?php if ($lowSalePrice > $sellingPrice): ?>
                            <del class="premium-regular-price"><?=money_format_custom($lowSalePrice)?></del>
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
                        <a class="btn-card-details" href="<?= base_url().'product-details/'.$product->slug;?>">
                            <span>View Details</span>
                            <i class="fa-regular fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
                                        
          
                                        
    <?php 

        if($i % $cols == $cols - 1){
          //  $html .= '</div>';
        }
        $i++;
         }
    }else{
        echo '<div class="col-12 text-center py-5"><p class="text-white-50 fs-5">No Products Found</p></div>'; 
    }
?>
</div>
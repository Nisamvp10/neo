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
           $productPrice = $product->price;
           $defaultprice = $product->extra_price ?? 0;
           $lowSalePrice =  $productPrice+$defaultprice;
           $sellingPrice = 0;
           $discountPercent = 0;
           $comparePrice = $product->compare_price ?? 0;//discount calculate in percentage
           if($productPrice>0){
                $discountPercent = ($productPrice / 100) * $comparePrice;
                $sellingPrice = $productPrice - $discountPercent;
           }else{
            $sellingPrice = $lowSalePrice;
           }


       ?>
            <div class="col-xxl-3 col-xl-4 col-md-6">
                <div class="w-100">
                    <div class="product__item bor">
                        <a href="#0" class="wishlist"><i class="fa-regular fa-heart"></i></a>
                        <a href="<?= base_url().'product-details/'.$product->slug;?>" class="product__image pt-20 d-block">
                            <img class="font-image" src="<?=validImg($product->product_image ?? '');?>" alt="image">
                            <img class="back-image" src="<?=validImg($product->product_image ?? '');?>" alt="image">
                        </a>
                        <div class="product__content">
                            <h4 class="mb-15"><a class="primary-hover" href="<?= base_url().'product-details/'.$product->slug;?>"><?= $product->product_title ?? '';?></a></h4>
                          <div class="d-flex align-items-center justify-content-between">
                           <?=($discountPercent > 0 ?  '<del>'.money_format_custom($lowSalePrice).'</del>' : '' );?>
                              <span class="primary-color ml-10"><?=money_format_custom($sellingPrice);?></span>
                          </div>
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
        </div>
                                        
            <?php 

        if($i % $cols == $cols - 1){
          //  $html .= '</div>';
        }
        $i++;
         }
    }else{
        $html = "<p>No Products Found</p>"; 
    }
?>
</div>
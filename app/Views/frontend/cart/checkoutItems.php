<?php
    $couponDiscount = 0;

    if(isset($cartdata) && $cartdata != null) {
        $couponDiscount = ($cartdata['coupon_discount'] ==0)?0:$cartdata['coupon_discount'] ?? 0;
    }
    $amountAmt = 0;
    $taxAmt = getappdata('tax');
    if($subtotal)   {
        foreach($subtotal as $res) {
            $amountAmt += $res['subtotal'];  
        }
    }   
    
 
    $subtotalAmt = ($amountAmt - $couponDiscount);
    $taxCalculate = round($subtotalAmt * ($taxAmt / 100));
    $totalAmt = $amountAmt + $taxCalculate - $couponDiscount;
    ?>

<div class="cart-checkout-wrapper  m-2 border  ">
            <div class="coupon_code right" data-aos="fade-up" data-aos-delay="400">
                <h3 class="p-10 bg-off-white py-3 px-2">Order Summary  (<?= count($subtotal) ?>)</h3>
                <div class="coupon_inner p-2 cart__collaterals-wrap m-0">
                     <div class="coupon-left mt-2">
                            <div class="coupon-input d-flex align-items-center mt-3 mb-3">
                                <input class="couponcodeInput" placeholder="Coupon code" class="h-auto " type="text">
                                <button type="button" class="theme-btn style6 applyCoupon h-auto px-3 py-2">Apply</button>
                            </div>
                        </div>

                <div class="checkout__item-right sub-bg">
                    <ul>
                        <li class="bor-bottom pb-4 d-flex justify-content-between">
                            <h4>Products</h4>
                            <h4>Subtotal</h4>
                        </li>
                    <?php
                    if(!empty($subtotal)) {
                        foreach($subtotal as $res) {
                            ?>
                            <li class="bor-bottom py-2">
                                <a href="#"><?= $res['product_title'] ?> x <?= $res['quantity'] ?></a> 
                                <span><?= money_format_custom(($res['price'] * $res['quantity'])) ?></span>
                            </li>
                            <?php
                        }
                    }
                    ?>
                            <li class="bor-bottom py-2">
                                 <a href="#">Subtotal</a> 
                                <span><?= money_format_custom($amountAmt) ?></span>
                            </li>
                            <li class="bor-bottom py-2">
                                <a href="#">Tax</a> 
                                <span><?= money_format_custom($taxCalculate) ?></span>
                            </li>
                            <?php if($couponDiscount > 0) { ?>
                            <li class="bor-bottom py-2">
                                <a href="#">Coupon Discount</a> 
                                <span><?= money_format_custom($couponDiscount) ?></span>
                            </li>
                            <?php } ?>
                            <li class="bor-bottom py-2">
                                <a href="#">Total</a> 
                                <span class="amount"><?= money_format_custom($totalAmt) ?></span>
                            </li>
                    </ul>
                </div>
                

                    <div class="checkout-btn cart__collaterals">
                        <a href="javascript:void(0)" class="theme-btn style6 checkoutBtn tg-btn tg-btn-three black-btn">Place Order <?=money_format_custom($totalAmt)?></a>
                    </div>
                </div>
            </div>
        </div>
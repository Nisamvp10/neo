<?php
    $amountAmt = 0;
    $taxAmt = getappdata('tax');
    if($subtotal)   {
        foreach($subtotal as $res) {
            $amountAmt += $res['subtotal'];  
        }
    }    
    $taxCalculate = round($amountAmt * ($taxAmt / 100));
    $totalAmt = $amountAmt + $taxCalculate;
    ?>

<div class="cart-checkout-wrapper mb-0 border">
            <div class="coupon_code right" data-aos="fade-up" data-aos-delay="400">
                <h3 class="p-10 bg-off-white py-3 px-2">Order Summary  (<?= count($subtotal) ?>)</h3>
                <div class="coupon_inner p-2 cart__collaterals-wrap m-0">
                    
                     <div class="list-wrap d-grid gap-2">
                        <div class="d-flex align-items-center justify-content-between">Subtotal <span><?= money_format_custom($amountAmt) ?></span></div>
                        <div class="d-flex align-items-center justify-content-between">Tax <span><?= money_format_custom($taxCalculate) ?></span></div>

                        <div class="d-flex align-items-center justify-content-between">Total <span class="amount"><?= money_format_custom($totalAmt) ?></span></div>
                    </div>

                    
                    <div class="cart_subtotal d-flex align-items-center justify-content-between d-none">
                        <p>Tax</p>
                        <p class="cart_amount"><?= money_format_custom($taxCalculate) ?></p>
                    </div>
                     
                        

                    <div class="cart-subtotal d-none">
                        <p>Total</p>
                        <p class="cart_amount"><?= money_format_custom($totalAmt) ?></p> 
                    </div>
                    <div class="checkout-btn cart__collaterals">
                        <a href="<?= base_url('checkout') ?>" class="theme-btn style6 checkoutBtn tg-btn tg-btn-three black-btn">Proceed to
                            Checkout</a>
                    </div>
                </div>
            </div>
        </div>
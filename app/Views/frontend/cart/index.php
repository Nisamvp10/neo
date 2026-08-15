<?= view('frontend/inc/header') ?>
    <main class="main-area fix">
        <!-- breadcrumb-area -->
        <section class="breadcrumb__area breadcrumb__bg" data-background="<?=base_url('public/assets/template/');?>assets/img/bg/sd_bg.jpg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <div class="breadcrumb__content">
                            <h2 class="title">Cart</h2>
                            <nav class="breadcrumb">
                                <span property="itemListElement" typeof="ListItem">
                                    <a href="<?=base_url();?>">Home</a>
                                </span>
                                <span class="breadcrumb-separator">|</span>
                                <span property="itemListElement" typeof="ListItem">Cart</span>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
          
        </section>

     <section class="cart-page pt-130 pb-130">
            <div class="container">

                <div class="shopping-cart radius-10 bor sub-bg">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12" id="cartItems"></div>
                        <div class="col-sm-12 col-lg-4 col-md-4 " id="cartSubtotal"></div>
                    </div>
            </div>
     
        </div>
</section>
</main>
<?= view('frontend/inc/footerLink') ?>
<script src="<?=base_url('public/assets/template/');?>assets/js/count.js"></script>

<script>
    mycart();

    function mycart(){
      
        $.ajax({
            url: "<?=base_url('cart/getMyCartItems');?>",
            method: "POST",
            success: function (response) {
                $('#cartItems').html(response.res);
                $('#cartSubtotal').html(response.subtotal);
            }
        });
    }


   $(document).on('submit','#cartItemsForm', function (e) {
    e.preventDefault();
    const formData = $(this).serialize();
    $.ajax({
        url: App.getSiteurl() + "cart/update",
        method: 'POST',
        data: $(this).serialize(),
        success: function (data) {
            if (data.status) {
                toastr.success(data.message);
                cartNotification();
                mycart();
            } else {
                toastr.error(data.message);
            }
        }
    });
});

document.addEventListener('click', async (e) => {

    /* ================= REMOVE FROM CART ================= */
    if (e.target.closest('.removeFromCart')) {
        const btn = e.target.closest('.removeFromCart');
        const productId = btn.dataset.id;

        const response = await fetch(App.getSiteurl() + "cart/remove", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify({
                product_id: productId
            })
        });

        const data = await response.json();

        if (data.status) {
            toastr.success(data.message);

            // remove item from UI
            document.querySelector(`.cart-item[data-id="${productId}"]`)?.remove();

            document.getElementById('cartCount').innerText = data.cartCount;
            cartNotification();
            mycart();
        } else {
            toastr.error(data.message);
        }
    }

});



        function updateCart() {

            $.ajax({
                url: App.getSiteurl() + "cart/update",
                type: "POST",
                data: $("#cartItemsForm").serialize(),

                beforeSend: function () {
                    $(".plus-minus-input button").prop("disabled", true);
                },

                success: function (data) {

                    if (data.status) {
                        cartNotification();
                        mycart();      // Reload cart
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }

                },

                complete: function () {
                    $(".plus-minus-input button").prop("disabled", false);
                }

            });

        }


        function plusCartQty(btn) {

            let input = $("#" + $(btn).data("field"));

            let qty = parseInt(input.val()) || 1;

            input.val(qty + 1);

            updateCart();

        }


        function minusCartQty(btn) {

            let input = $("#" + $(btn).data("field"));

            let qty = parseInt(input.val()) || 1;

            if (qty > 1) {

                input.val(qty - 1);

                updateCart();

            }

        }



        $(document).on("change", "input[name='quantity[]']", function () {

            let qty = parseInt($(this).val());

            if (qty < 1 || isNaN(qty)) {
                $(this).val(1);
            }

            updateCart();

        });


</script>

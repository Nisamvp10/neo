
<?= view('frontend/inc/headerLink');?>
<body>


  <!-- Header area start here -->
    <div class="top__header top-header-one pt-30 pb-30">
        <div class="container">
            <div class="top__wrapper">
                <a href="<?=base_url();?>" class="main__logo">
                    <img src="<?=base_url('public/assets/template/');?>assets/images/logo.png" alt="logo__image">
                </a>
                <div class="search__wrp">
                    <input placeholder="Search for" aria-label="Search">
                    <button><i class="fa-solid fa-search"></i></button>
                </div>
                <div class="account__wrap">
                    <div class="account d-flex align-items-center">
                        <div class="user__icon">
                            <a href="#0">
                                <i class="fa-regular fa-user"></i>
                            </a>
                        </div>
                        <a href="#0" class="acc__cont">
                            <span class="text-white">
                                My Account
                            </span>
                        </a>
                    </div>
                    <div class="cart d-flex align-items-center">
                        <span class="cart__icon">
                            <i class="fa-regular fa-cart-shopping"></i>
                        </span>
                        <a href="#0" class="c__one">
                            <span class="text-white">
                                Rs 
                            </span>
                        </a>
                        <span class="one">
                            0.00
                        </span>
                    </div>
                    <div class="flag__wrap d-none">
                        <div class="flag">
                            <img src="<?=base_url('public/assets/template/');?>assets/images/us.png" alt="flag">
                        </div>
                        <select name="flag">
                            <option value="0">
                                Usa
                            </option>
                            <option value="1">
                                Canada
                            </option>
                            <option value="2">
                                Australia
                            </option>
                            <option value="3">
                                Germany
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <header class="header-section">
        <div class="container">
            <div class="header-wrapper pl-65">
                <div class="header-bar d-lg-none">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <ul class="main-menu">
                    <li class="d-none d-lg-block"><button id="openButton" class="side-bar-btn"><i
                                class="fa-sharp text-white fa-light mr-60 fa-bars"></i></button>
                    </li>
                
                    <li>
                        <a href="#">Customise Your Neon Light</a>
                    </li>
                 
                    <li>
                        <a href="#">Shop Neon Collection</a>
                    </li>
                     
                    <li>
                        <a href="#">Best Sellers</a>
                    </li>
                     
                    <li>
                        <a href="#">Business Logo</a>
                    </li>

                     <li>
                        <a href="#">Shark Tank</a>
                    </li>
                </ul>
                <div class="shipping__item d-none d-sm-flex align-items-center">
                   
                    <div class="menu__right d-flex align-items-center">
                        <div class="thumb">
                            <img src="<?=base_url('public/assets/template/')?>assets/images/shipping.png" alt="image">
                        </div>
                        <div class="content">
                            <p>
                                Free Shipping <br> on order <strong>over Rs 100</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    
    <!-- Sidebar area start here -->
    <div id="targetElement" class="side_bar slideInRight side_bar_hidden">
        <div class="side_bar_overlay"></div>
        <div class="logo mb-30">
            <img src="<?=base_url('public/assets/template/')?>assets/images/logo.png" alt="logo">
        </div>
        <p class="text-justify">All our products are handmade in India with flawless finishing

That enables us to create 100% customized Neon Signs as per your preference. Just reach out to us and we’ll take care of it!/p>
        <ul class="info py-4 mt-65 bor-top bor-bottom">
            <li><i class="fa-solid primary-color fa-location-dot"></i> <a href="#0">info@neonstories.com</a>
            </li>
            <li class="py-4"><i class="fa-solid primary-color fa-phone-volume"></i> <a href="#">+91 2659
                    302 003</a>
            </li>
            <li><i class="fa-solid primary-color fa-paper-plane"></i> <a href="#0">info@neonstories.com</a></li>
        </ul>
        <div class="social-icon mt-65">
            <a href="#0"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#0"><i class="fa-brands fa-twitter"></i></a>
            <a href="#0"><i class="fa-brands fa-linkedin-in"></i></a>
            <a href="#0"><i class="fa-brands fa-instagram"></i></a>
        </div>
        <button id="closeButton" class="text-white"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <!-- Sidebar area end here -->


        <!-- Preloader area start -->
    <div class="loading">
        <span class="text-capitalize">L</span>
        <span>o</span>
        <span>a</span>
        <span>d</span>
        <span>i</span>
        <span>n</span>
        <span>g</span>
    </div>

    <div id="preloader"></div>
    <!-- Preloader area end -->

    <!-- Mouse cursor area start here -->
    <div class="mouse-cursor cursor-outer"></div>
    <div class="mouse-cursor cursor-inner"></div>
    <!-- Mouse cursor area end here -->
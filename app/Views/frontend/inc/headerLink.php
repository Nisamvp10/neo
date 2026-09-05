<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        $page = $page ?? "";
        if($page == "home"){
                echo '';
        }elseif($page == "Products"){
            echo '';
        }elseif($page == "Contact Us"){
            echo '';
        }elseif($page == "About Us"){
            echo '';
        }elseif($page == "Checkout"){
            echo "";
        }elseif($page == "Cart"){
            echo "";
        }
            ?>
   
    <!-- End Google Tag Manager -->
    <title>Neon Stories </title>
    <!-- Favicon img -->
    <link rel="shortcut icon" href="<?=base_url('public/assets/template/assets/images/favicon.png');?>">
    <!-- Bootstarp min css -->
    <link rel="stylesheet" href="<?=base_url('public/assets/template/assets/css/bootstrap.min.css');?>">
    <!-- All min css -->
    <link rel="stylesheet" href="<?=base_url('public/assets/template/assets/css/all.min.css');?>">
    <!-- Swiper bundle min css -->
    <link rel="stylesheet" href="<?=base_url('public/assets/template/assets/css/swiper-bundle.min.css');?>">
    <!-- Magnigic popup css -->
    <link rel="stylesheet" href="<?=base_url('public/assets/template/assets/css/magnific-popup.css');?>">
    <!-- Animate css -->
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url('public/assets/template/assets/css/animate.css');?>">
    <!-- Nice select css -->
    <link rel="stylesheet" href="<?=base_url('public/assets/template/assets/css/nice-select.css');?>">
    <!-- Style css -->
    <link rel="stylesheet" href="<?=base_url('public/assets/template/assets/css/style.css');?>">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Great+Vibes&family=Prosto+One&display=swap" rel="stylesheet">
    <style>
    /* font install from folder */
    @font-face {
        font-family: 'Delight';
        src: url('<?=base_url('public/assets/template/assets/fonts/Delight.ttf');?>') format('truetype');
        font-weight: normal;
        font-style: normal;
        font-display: swap;
    }
    @font-face {
            font-family: 'Passionate';
            src: url('<?=base_url('public/assets/template/assets/fonts/Passionate.eot');?>');
            src: url('<?=base_url('public/assets/template/assets/fonts/Passionate.eot?#iefix')?>') format('embedded-opentype'),
                url('<?=base_url('public/assets/template/assets/fonts/Passionate.woff2')?>') format('woff2'),
                url('<?=base_url('public/assets/template/assets/fonts/Passionate.woff')?>') format('woff'),
                url('<?=base_url('public/assets/template/assets/fonts/Passionate.ttf')?>') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

    }
    </style>
</head>
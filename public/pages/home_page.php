<?php
    if(!defined('UniProjects')) {
        $GLOBALS['errors'][]='Outside of the Project network!';
        include_once('site_down.php');
        die();
        // die(json_encode(array('result'=>0,'message'=>'Outside of the project network?')));
    }


    // echo '<p class="text-white">';
    //     print_r($_GET);
    // echo '</p>';

?>
<div class="row h-100" id="auth">
    <div class="d-flex align-items-center justify-content-center vh-100 text-white">
        <div class="text-center home-div" attr="init">
            <h1 class="display-1 fw-bold">Loading</h1>
        </div>
        <div class="text-center home-div"attr="signin" style="display:none;">
            <h1 class="display-1 fw-bold">Password Required</h1>
            <p class="lead">
                <input type="password" placeholder="Password" value="" autocomplete="new-password"  class="input-lg form-control" aria-label="Password" aria-describedby="inputGroup-sizing-lg" id="home-login-password">
                <button class="btn btn-md btn-primary w-100 mt-2">Enter</button>
            </p>
            <p>
                Welcome to Smart Shop — this website is a University project.<br/>
                The password is given out by the researcher. For more information, go to <a href="/about">/about</a>
            </p>
        </div>
    </div>
</div>
<div class="row h-100" id="app" style="display:none;">
    <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3 p-3 bg-secondary">
        <a href="/home" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <span class="fs-4">Smart Shop</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <button href="/home" class="nav-link link-dark app-nav-panel" attr="home"><i class="fa-solid fa-house"></i> Home</button>
            </li>
            <li>
                <button class="nav-link link-dark app-nav-panel" attr="departments"><i class="fa-solid fa-cart-shopping"></i> By department</button>
            </li>
            <li>
                <button class="nav-link link-dark app-nav-panel" attr="shoplist"><i class="fa-solid fa-bag-shopping"></i> Shoppoing lists</button>
            </li>
            <li>
                <button class="nav-link link-dark" attr="feedback"><i class="fa-solid fa-comments"></i> Feedback</button>
            </li>
            <li>
                <a href="/admin" class="nav-link link-dark"><i class="fa-solid fa-screwdriver-wrench"></i> Admin</a>
            </li>
        </ul>
    </div>
    <div class="col-12 col-sm-8 col-md-9 col-lg-9 col-xl-9">
        <div class="container px-4 px-lg-5 mt-5 app-window text-blue" style="display:none;" attr="home"></div>
        <div class="container px-4 px-lg-5 mt-5 app-window text-white" style="display:none;" attr="product">
            <div class="row">
                <div class="col-12 col-sm-12 col-s-12 col-lg-12 col-xl-12">
                    <button class="btn btn-sm btn-outline-warning mt-auto app-nav-shop-list shopping-cart" attr="add" barcode="" uid="">Add to shopping cart</button> 
                    <a class="btn btn-sm btn-outline-primary mt-auto view-on-map" href="/maptiler/leaflet.html?barcode=">View on map</a>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-6">
                    <h4 class="name"></h4>
                    <p class="store_info"></p>
                    <img src="" class="image" alt="" />
                </div>
                <div style="border-left:2px solid #000" class="col-12 col-sm-12 col-md-4 col-lg-8 col-xl-6">
                    <p class="description"></p>
                </div>
                <div class="col-12 col-sm-12 col-s-12 col-lg-12 col-xl-12">
                    <!-- <div id="map_shop_interactive"></div> -->
                </div>
            </div>
        </div>
        <div class="container px-4 px-lg-5 mt-5 app-window text-white" style="display:none;" attr="department_products">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-6">
                    <h4 attr="name"></h4>
                    <img src="" attr="image" alt="" />

                    <div id="shop_map"></div>
                </div>
            </div>
        </div>
        <div class="container px-4 px-lg-5 mt-5 app-window text-white" style="display:none;" attr="departments"></div>
        <div class="container px-4 px-lg-5 mt-5 app-window text-white" style="display:none;" attr="shopping_cart"></div>
        </div>
    </div>
</div>

<?php
    if(!defined('UniProjects')) {
        $GLOBALS['errors'][]='Outside of the Project network!';
        include_once('site_down.php');
        die();
        // die(json_encode(array('result'=>0,'message'=>'Outside of the project network?')));
    }
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
            <li class="nav-item">
                <button href="/home" class="nav-link link-dark app-nav-update" attr="home"><i class="fa-solid fa-house"></i> Home</button>
            </li>
            <li>
                <button class="nav-link link-dark app-nav-update" attr="departments"><i class="fa-solid fa-cart-shopping"></i> Shop by department</button>
            </li>
            <li>
                <button class="nav-link link-dark app-nav-update" attr="shoplist"><i class="fa-solid fa-bag-shopping"></i> Shoppoing lists</button>
            </li>
            <li>
                <button class="nav-link link-dark app-nav-update" attr="feedback"><i class="fa-solid fa-comments"></i> Feedback</button>
            </li>
            <li>
                <a href="/admin" class="nav-link link-dark"><i class="fa-solid fa-screwdriver-wrench"></i> Admin</a>
            </li>
        </ul>
    </div>
    <div class="col-12 col-sm-8 col-md-9 col-lg-9 col-xl-9">
        <div class="container px-4 px-lg-5 mt-5 app-window" attr="home"></div>
    </div>
</div>
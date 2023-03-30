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
    <div class="d-flex align-items-center justify-content-center vh-100 text-white col-12">
        <div class="text-center home-div" attr="init">
            <h1 class="display-1 fw-bold">Loading</h1>
        </div>
        <div class="text-center home-div"attr="welcome" style="display:none;">
            <div class="row">
                <div class="col-12">
                    <div style="position:absolute;top:0px;left:0px;width:100%;">
                        Need to contact me? <a href="mailto:1702201@student.uwtsd.ac.uk">1702201@student.uwtsd.ac.uk</a><br/>
                        <button class="mt-2 mb-2 btn btn-sm btn-primary" id="home-div-welcome-login">Login</button>
                        <button class="mt-2 mb-2 btn btn-sm btn-dark login-cycle-option" attr="next">Next</button>
                        <button class="mt-2 mb-2 btn btn-sm btn-info login-cycle-option" attr="previous">Previous</button>
                        <button style="display:none;" class="mt-2 mb-2 btn btn-sm btn-secondary login-cycle-option" attr="resume">Resume cylce</button>
                    </div>
                    <div class="pl-4 pl-4 login-home-item">
                        <h1 class="display-5 fw-bold">Welcome!</h1>
                        <p class="lead">
                            This website is being ran as part of a University Dissertation. Its intention is to assess whether customers require more information whilst in-store shopping.<br/>
                            The research is looking into current technologies being used, current ways of shopping in-store, what is the difference between online shopping and what do shops do to encourage in-store shopping.
                        </p>
                    </div>
                    <div class="pl-4 pl-4 login-home-item" style="display:none;">
                        <img src="/img/map-example.png" class="img-fluid w-50" alt="Map Example">
                        <p class="lead">
                            The above screen-shot shows an example of the mapping feature.
                        </p>
                    </div>
                    <div class="pl-4 pl-4 login-home-item" style="display:none;">
                        <h1 class="display-5 fw-bold">What is being done differently in this research?</h1>
                        <p class="lead">
                            We are gathering several products and storing them on this site, we are assiging alises, departments, stock levels, where the product is on the shelf, a map location, where the product is, an online shopping list that will mark items off once scanned in-store and lastly, best directions to navigate the shop.
                        </p>
                    </div>
                    <div class="pl-4 pl-4 login-home-item" style="display:none;">
                        <h1 class="display-5 fw-bold">Why is a Website needed?</h1>
                        <p class="lead">
                            To apply methods and run a test group, assessing if the information provided would be useful if the products and location were correct for a real life store. 
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="text-center home-div"attr="signin" style="display:none;">
            <h1 class="display-1 fw-bold">Password Required</h1>
            <p class="lead">
                <input type="password" placeholder="Password" value="" autocomplete="new-password"  class="input-lg form-control" aria-label="Password" aria-describedby="inputGroup-sizing-lg" id="home-login-password">
                <button class="btn btn-md btn-primary w-100 mt-2 login">Enter</button>
            </p>
        </div> -->
    </div>
</div>

<!-- <div class="row h-100" id="auth">
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
</div> -->
<div class="row" id="app" style="display:none;">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid m-0 p-0">
            <a class="navbar-brand" href="/home">Smart Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <button class="nav-link app-nav-panel border-0 bg-transparent" attr="home"><i class="fa-solid fa-house"></i> Home</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link app-nav-panel border-0 bg-transparent" attr="departments"><i class="fa-solid fa-cart-shopping"></i> By Department</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link app-nav-panel border-0 bg-transparent" attr="shoplist"><i class="fa-solid fa-bag-shopping"></i> Shopping list</button>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link border-0 bg-transparent" href="https://docs.google.com/forms/d/e/1FAIpQLSfkdo0Isgsd98mLytHC63fgfNrUvIqLTpfpVSUFJifwVIYI_A/viewform"><i class="fa-solid fa-comments"></i> Feedback</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link border-0 bg-transparent" href="/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                    <?php
                        if(session::isAdmin()) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin"><i class="fa-solid fa-screwdriver-wrench"></i> Admin</a>
                        </li>
                        <?php
                        }
                    ?>
                </ul>
                <form class="d-flex">
                    <!-- <label class="label text-primary">Search</label> -->
                    <input class="form-control me-2" type="search" placeholder="Start Typing" aria-label="Search">
                    <!-- <button class="btn btn-outline-success" type="submit">Search</button> -->
                </form>
                <div id="navbarSupportedContentSearchDropDown" style="display:none;" class="p-2 bg-dark border-secondary m-4 mt-0 rounded"></div>
                <div id="navbarSupportedContentSearchDropDownBackDrop" style="display:none;"></div>
            </div>
        </div>
    </nav>

    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="container px-4 px-lg-5 mt-5 app-window text-dark" style="display:none;" attr="home"></div>
        <div class="container px-4 px-lg-5 mt-5 app-window text-white" style="display:none;" attr="product">
            <div class="row">
                <div class="col-12 col-sm-12 col-s-12 col-lg-12 col-xl-12">
                    <button class="btn btn-sm btn-outline-warning mt-auto app-nav-shop-list shopping-cart" attr="add" barcode="" uid="">Add to shopping cart</button> 
                    <a class="btn btn-sm btn-outline-primary mt-auto view-on-map" href="/maptiler/leaflet.html?barcode=">View on map</a>
                </div>
                <div class="col-12 restrictions_apply mt-1" style="display:none;">
                    <div class="alert alert-danger">
                        <p><b>Verification notice!</b> Verification may be required for this product - restrictions may apply.</p>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-6">
                    <h4 class="name"></h4>
                    <p class="store_info"></p>
                    <img src="" class="img-fluid image" alt="" />
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
        <div class="container px-4 px-lg-5 mt-5 app-window text-white" style="display:none;" attr="shopping_cart">
            <div class="row">
                <div class="col-12">
                    <div class="rounded p-1 bg-secondary">
                        <h4>Your shopping list</h4>
                        <p>
                            Your <b>Shopping List</b> is a reminder about product(s) you may need to get whilst shopping. You can add and remove items from your list at any time — whilst in-store you can refer to this list and search where the products are.<span attr="view_all"></span>
                        </p>
                    </div>
                </div>
                <div class="col-12" attr="list"></div>
            </div>
        </div>
    </div>
</div>

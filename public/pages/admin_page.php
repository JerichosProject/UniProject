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
        <div class="text-center home-div"attr="notadmin" style="display:none;">
            <h1 class="display-1 fw-bold">Error</h1>
            <p class="lead">
                You are not an administrator! You need to enter the right password to become one.<br/>
                Logout and login using the correct password. <a href="/logout">Logout</a> or go <a href="/home">Home</a>
            </p>
            <p>
                Welcome to Smart Shop — this website is a University project.<br/>
                The password is given out by the researcher. For more information, go to <a href="/about">/about</a>
            </p>
        </div>
    </div>

</div>
<div class="row h-100" id="app" style="display:none;">
    <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3 p-3 bg-gray-dark text-white">
        <a href="/home" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-white text-white text-decoration-none">
            <span class="fs-4">Smart Shop - Admin</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <button id="app-pane-create-product" class="text-white nav-link">
                    <i class="fa-solid fa-folder-open"></i> Create Product
                </button>
            </li>
            <li class="nav-item">
                <button id="app-pane-create-aisle" class="text-white nav-link">
                    <i class="fa-solid fa-grip-vertical"></i> Create Aisle
                </button>
            </li>
            <li class="nav-item">
                <button id="app-pane-create-category" class="text-white nav-link">
                    <i class="fa-solid fa-box-archive"></i> Create Category
                </button>
            </li>
        </ul>
    </div>
    <div class="col-12 col-sm-8 col-md-9 col-lg-9 col-xl-9">
        <div class="container app-window" attr="product" style="display:none;">
            <div class="row text-white mt-3 pr-3 mb-4">
                <div class="col-6 mt-2">
                    <h4>Name</h4>
                    <input type="input" class="form-control input-md" attr="name" />
                    <p>Leave blank and we will use API name</p>
                </div>
                <div class="col-6 mt-2">
                    <h4>URL Name</h4>
                    <input type="input" class="form-control input-md" attr="urlname" />
                </div>
                <div class="col-6 mt-2">
                    <h4>Barcode</h4>
                    <input type="number" class="form-control input-md" attr="barcode" />
                </div>
                <div class="col-3 mt-2">
                    <h4>Price</h4>
                    <input type="input" class="form-control input-md" attr="price" />
                </div>
                <div class="col-3 mt-2">
                    <h4>Stock</h4>
                    <input type="input" class="form-control input-md" attr="stock" />
                </div>
                <div class="col-6 mt-2">
                    <h4>Image</h4>
                    <input type="input" class="form-control input-md" attr="image" />
                </div>
                <div class="col-6 mt-2">
                    <h4>Category</h4>
                    <select class="form-control input-md" attr="categiries"></select>
                </div>
                <div class="col-6 mt-2">
                    <h4>Aisle</h4>
                    <select type="input" class="form-control input-md" attr="aisles"></select>
                </div>
                <div class="col-6 mt-2">
                    <h4>Shelf</h4>
                    <input type="number" class="form-control input-md" attr="shelf" />
                </div>
                <div class="col-6 mt-2">
                    <input type="button" class="btn btn-md btn-success" attr="submit" value="Create" /> 
                    <input type="button" class="btn btn-md btn-info" attr="product_info" value="Product info" />
                </div>
            </div>
        </div>
        <div class="container app-window" attr="categories" style="display:none;">
            <div class="row text-white mt-3 pr-3 mb-4">
                <div class="col-6 mt-2">
                    <h4>Name</h4>
                    <input type="input" class="form-control input-md" attr="name" />
                </div>
                <div class="col-6 mt-2">
                    <h4>URL Name</h4>
                    <input type="input" class="form-control input-md" attr="urlname" />
                </div>
                <div class="col-12 mt-2">
                    <h4>Image</h4>
                    <input type="input" class="form-control input-md" attr="image" />
                </div>
                <div class="col-6 mt-2">
                    <h4>Submit</h4>
                    <input type="button" class="btn btn-md btn-success" attr="submit" value="Create" />
                </div>
            </div>
        </div>
        <div class="container app-window" attr="aisle" style="display:none;">
            <div class="row text-white mt-3 pr-3 mb-4">
                <div class="col-6 mt-2">
                    <h4>Name</h4>
                    <input type="input" class="form-control input-md" attr="name" />
                </div>
                <div class="col-6 mt-2">
                    <h4>Number</h4>
                    <input type="input" class="form-control input-md" attr="number" />
                </div>
                <div class="col-6 mt-2">
                    <h4>Submit</h4>
                    <input type="button" class="btn btn-md btn-success" attr="submit" value="Create" />
                </div>
            </div>
        </div>
    </div>
</div>



<!--

    TO DO LIST FOR TODAY:
        
    #   MAKE THE CREATE PRODUCT WORK
    #   CREATE A BUTTON TO CACHE PRODUCTS - FIND PRODUCTS IN DB THAT DO NOT HAVE AN APIKEY...IF FOUND SEND API TO WEBSITE...CACHE TO TXT
    #   CREATE AISLES
    #   CREATE CATEGORIES
    #   MAKE CATEGORIES APPEAR ON HOME PAGE
    #   MAKE PRODUCTS APPEAR ON CATEGORY PAGE

    #   START SHOPPING LIST FEATURE?
    #   START MAPPING FEATURE?


-->
<?php
    if(!defined('UniProjects')) {
        ?>
            <!DOCTYPE html>
            <html lang="en">
                <head>
                    <title>404 - Smart Shop</title>
                    <?php
                        if(file_exists('page_modules/header.php')) include('page_modules/header.php');
                        else include('../page_modules/header.php');
                    ?>
                </head>
                <body class="bg-dark">
                    <div class="d-flex align-items-center justify-content-center vh-100 text-white">
                        <div class="text-center">
                            <h1 class="display-1 fw-bold">404</h1>
                            <p class="fs-3"> <span class="text-danger">Opps!</span> Page not found.</p>
                            <p class="lead">
                                <b>Page Not Found!</b> Have you got the correct link?
                            </p>
                            <a class="btn btn-sm btn-primary" href="/home">Home</a>
                            <div class="mt-3 alert alert-danger">
                                <h2>Note!</h2>
                                <h5>This <b>404</b> was returned from the web server! This is not connected to Smart Shop.</h5>
                            </div>
                        </div>
                    </div>
                </body>
                <?php
                    if(file_exists('page_modules/footer.php')) include('page_modules/footer.php');    
                    else include('../page_modules/footer.php');    
                ?>
            </html>
        <?php
        die();
        // die(json_encode(array('result'=>0,'message'=>'Outside of the network?')));
    }
?>
<div class="d-flex align-items-center justify-content-center vh-100 text-white">
    <div class="text-center">
        <h1 class="display-1 fw-bold">404</h1>
        <p class="fs-3"> <span class="text-danger">Opps!</span> Page not found.</p>
        <p class="lead">
            <b>Page Not Found!</b> Have you got the correct link?
        </p>
        <a class="btn btn-sm btn-primary" href="/home">Home</a>
    </div>
</div>
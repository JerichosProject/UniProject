
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Site Down - Smart Shop</title>
		<?php include('page_modules/header.php'); ?>
    </head>
    <body class="bg-dark">
        <div class="d-flex align-items-center justify-content-center vh-100 text-white">
            <div class="text-center">
                <h1 class="display-1 fw-bold">503</h1>
                <p class="fs-3"> <span class="text-danger">Opps!</span> Service error.</p>
                <p class="lead">
                    <b>Service unavailable!</b> Please return after a while — we are trying to fix this issue as soon as possible.
                </p>
                <button class="btn btn-sm btn-primary" onclick="$('#errors-div').show();">Reason</button>
                <div class="mt-2 offset-3 col-6 text-dark h-100 p-5 bg-light border rounded-3" id="errors-div" style="display:none;">
                    <?php
                        if(isset($GLOBALS['errors'])&&is_array($GLOBALS['errors'])&&count($GLOBALS['errors'])>0) {
                            foreach($GLOBALS['errors'] as $errors) {
                                print_r($errors).'<br/>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
    <?php include('page_modules/footer.php'); ?>
</html>
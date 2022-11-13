<?php
	require('scripts/main.php');

	if(!defined('UniProjects')) die(json_encode(array('result'=>0,'message'=>'Outside of the network?')));
?>
<!DOCTYPE php>
<html>
    <head>
        <title>Smart Shop - Being developed</title>
		<?php include('page_modules/header.php'); ?>
    </head>

    <head>
        <title>Site Down - Smart Shop</title>
		<?php include('page_modules/header.php'); ?>
    </head>
    <body class="bg-dark">
        <div class="d-flex align-items-center justify-content-center vh-100 text-white">
            <div class="text-center">
                <h1 class="display-1 fw-bold">Being developed</h1>
                <p class="lead">
                    Site is being developed...will be published soon?
                </p>
            </div>
        </div>
    </body>
    

	<script src="/scripts/js/home.js" type="text/javascript"></script>
	<?php include('page_modules/footer.php'); ?>
</html>
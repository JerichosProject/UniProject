<?php
	require('scripts/main.php');

	if(!defined('UniProjects')) die(json_encode(array('result'=>0,'message'=>'Outside of the network?')));
    print_r(get_page::get_url())
?>
<!DOCTYPE php>
<html>
    <head>
        <title>Smart Shop - Being developed</title>
		<?php include('page_modules/header.php'); ?>
    </head>
    <body class="bg-dark">
        <?php
            if(get_page::get_url()[0]=='admin') require_once('pages/admin_page.php');
            elseif(get_page::get_url()[0]=='about') require_once('pages/about_page.php');
            else require_once('pages/home_page.php');
        ?>
    </body>
    

	<?php
        include('page_modules/footer.php');
        if(get_page::get_url()[0]=='admin') echo '<script src="/scripts/js/admin.js" type="text/javascript"></script>';
        elseif(get_page::get_url()[0]=='about') echo '<script src="/scripts/js/about.js" type="text/javascript"></script>';
        else echo '<script src="/scripts/js/home.js" type="text/javascript"></script>';
    ?>
</html>
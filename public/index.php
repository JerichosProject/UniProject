<?php
	require('scripts/main.php');

	if(!defined('UniProjects')) die(json_encode(array('result'=>0,'message'=>'Outside of the network?')));
    // echo '<p class="text-white">';
    //     print_r($_SERVER);
    //     echo '<br/>';
    //     print_r($_GET);
    //     echo '<br/>';
    //     print_r(get_page::get_url($_GET));
    // echo '</p>';
    //echo '<p class="text-danger">'.getcwd().'</p>';
    // echo '<div class="alert alert-danger">';
    //     print_r(get_page::get_url());
    //     print_r($_GET);
    // echo '</div>';
?>
<!DOCTYPE php>
<html>
    <head>
        <title>Smart Shop - Being developed</title>
		<?php include('page_modules/header.php'); ?>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css">
        <link rel="stylesheet" href="https://cdn.rawgit.com/ardhi/Leaflet.MousePosition/master/src/L.Control.MousePosition.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js" type="text/javascript"></script>
        <script src="https://cdn.rawgit.com/ardhi/Leaflet.MousePosition/master/src/L.Control.MousePosition.js" type="text/javascript"></script>


        <style type="text/css">
            /* html, body { margin:0; padding: 0; height: 100%; width: 100%; } */
            /* body { width:100%; height:100%; background: #ffffff; } */
            #map_shop_interactive {
                /* height: 100%; */
                width: 100%;
                background-color: #FFFFFF;
                height:90vh;
                /* width:90vh; */
            }
            #slider { position: absolute; top: 10px; right: 10px; }
            
        </style>

    </head>
    <body class="bg-dark text-white">
        <div class="container-fluid">
            <?php
                if(get_page::get_url()[0]=='admin') require_once('pages/admin_page.php');
                elseif(get_page::get_url()[0]=='about') require_once('pages/about_page.php');
                elseif(in_array(get_page::get_url()[0],array('home','product','departments','list'))) require_once('pages/home_page.php');
                else require_once('pages/not_found.php');
            ?>
        </div>
    </body>
    
	<?php
        include('page_modules/footer.php');
        if(get_page::get_url()[0]=='admin') echo '<script src="/scripts/js/admin.js" type="text/javascript"></script>';
        elseif(get_page::get_url()[0]=='about') echo '<script src="/scripts/js/about.js" type="text/javascript"></script>';
        else echo '<script src="/scripts/js/home.js" type="text/javascript"></script>';
    ?>
</html>
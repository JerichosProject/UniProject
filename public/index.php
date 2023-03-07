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


<script type="text/javascript">
    var mapExtent = [0.00000000, -1718.00000000, 2788.00000000, 0.00000000];
    var mapMinZoom = 1;
    var mapMaxZoom = 3;
    var mapMaxResolution = 1.00000000;
    var mapMinResolution = Math.pow(2, mapMaxZoom) * mapMaxResolution;
    // var tileExtent = [-1734.40009,2780.79993,-27.20013,19.19958];
    // var tileExtent = [-1718.00000000, -1718.00000000, 2788.00000000, 0.00000000];
    var tileExtent = [0.00000000, -1718.00000000, 2788.00000000, 0.00000000];
    // var tileExtent = [-1747.99991,-26.39996,-143.6,1889.2];
    var crs = L.CRS.Simple;
    // crs.transformation = new L.Transformation(1, -tileExtent[0], -1, tileExtent[3]);
    crs.scale = function(zoom) {
        return Math.pow(2, zoom) / mapMinResolution;
    };
    crs.zoom = function(scale) {
        return Math.log(scale * mapMinResolution) / Math.LN2;
    };
    var layer;
    var map = new L.Map('map_shop_interactive', {
        maxZoom: mapMaxZoom,
        minZoom: mapMinZoom,
        crs: crs,
        center: [-977.59,1165.5997], // starting 
    });
    
    layer = L.tileLayer("/{z}/{x}/{y}.jpg", {
        minZoom: mapMinZoom,
        maxZoom: mapMaxZoom,
        tileSize: L.point(512, 512),
        attribution: '<a href="https://www.maptiler.com/engine/">MapTiler</a>',
        noWrap: true,
        tms: false,
    }).addTo(map);  
    // console.log(layer);
    // map.fitBounds([
    //     crs.unproject(L.point(mapExtent[2], mapExtent[3])),
    //     crs.unproject(L.point(mapExtent[0], mapExtent[1]))
    // ]);

    map.fitBounds([
        [-1747.99991,-26.39996], // southwestern corner of the bounds
        [-143.6,1889.2] // northeastern corner of the bounds
    ]);


    L.control.mousePosition().addTo(map)

</script>
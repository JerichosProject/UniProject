<?php
  require_once('../scripts/main.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>maptiler</title>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/ardhi/Leaflet.MousePosition/master/src/L.Control.MousePosition.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js" type="text/javascript"></script>
    <script src="https://cdn.rawgit.com/ardhi/Leaflet.MousePosition/master/src/L.Control.MousePosition.js" type="text/javascript"></script>
    <style>
      html, body, #map {
        width:100%;
        height:100%;margin:0;
        padding:0;
        z-index: 1;
        background: #ffffff;
      }
      #slider{
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 5;
      }
      .polygon-labels{
        background:transparent;
        border:transparent;
        box-shadow:none;
        font-size:1.2em;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <input id="slider" type="range" min="0" max="1" step="0.1" value="1" oninput="layer.setOpacity(this.value)">
    <script src="/plugins/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      var mapExtent = [0.00000000, -1718.00000000, 2788.00000000, 0.00000000];
      var mapMinZoom = 0;
      var mapMaxZoom = 3;
      var mapMaxResolution = 1.00000000;
      var mapMinResolution = Math.pow(2, mapMaxZoom) * mapMaxResolution;
      var tileExtent = [0.00000000, -1718.00000000, 2788.00000000, 0.00000000];
      var crs = L.CRS.Simple;
      crs.transformation = new L.Transformation(1, -tileExtent[0], -1, tileExtent[3]);
      crs.scale = function(zoom) {
        return Math.pow(2, zoom) / mapMinResolution;
      };
      crs.zoom = function(scale) {
        return Math.log(scale * mapMinResolution) / Math.LN2;
      };
      var layer;
      var map = new L.Map('map', {
          maxZoom: mapMaxZoom,
          minZoom: mapMinZoom,
          crs: crs
        });
        
        layer = L.tileLayer('{z}/{x}/{y}.jpg', {
          minZoom: mapMinZoom, maxZoom: mapMaxZoom,
          tileSize: L.point(512, 512),
          attribution: '<a href="https://www.maptiler.com/engine/">Rendered with MapTiler Engine</a>, non-commercial use only',
          noWrap: true,
          tms: false
        }).addTo(map);  
        console.log(layer);
      map.fitBounds([
        crs.unproject(L.point(mapExtent[2], mapExtent[3])),
        crs.unproject(L.point(mapExtent[0], mapExtent[1]))
      ]);
      L.control.mousePosition().addTo(map)


      var aisles={
        0:{
          name:'Exit',
          colour:'green',
          vertical:true,
          points:[
            [-560.0,37.0],
            [-560.0,110.0],
            [-966.8,110.0],
            [-966.8,37.0]
          ]
        },
        1:{
          name:'Aisle 1',
          colour:'red',
          vertical:true,
          points:[
            [-417.39,52.20],
            [-417.39,508.20],
            [-483.39,508.20],
            [-483.39,52.20]
          ]
        },
        2:{
          name:'Aisle 2',
          colour:'lime',
          points:[
            [-84.40,67.0],
            [-84.40,138.0],
            [-332.40,138.0],
            [-332.40,67.0]
          ]
        },
        3:{
          name:'Aisle 3',
          colour:'lime',
          points:[
            [-29.0,163.0],
            [-29.0,493.0],
            [-97.0,493.0],
            [-97.0,163.0]
          ]
        },
        4:{
          name:'Aisle 4',
          colour:'gray',
          points:[
            [-165.79,763.40],
            [-165.79,865.4],
            [-686.0,865.4],
            [-686.0,763.40]
          ]
        },
        5:{
          name:'Aisle 5',
          colour:'gray',
          points:[
            [-165.79,1068.79],
            [-165.79,1170.79],
            [-686.0,1170.79],
            [-686.0,1068.79]
          ]
        },
        6:{
          name:'Aisle 6',
          colour:'gray',
          points:[
            [-165.79,1375.0],
            [-165.79,1476.0],
            [-686.0,1476.0],
            [-686.0,1375.0]
          ]
        },
        7:{
          name:'Aisle 7',
          colour:'yellow',
          points:[
            [-165.79,1744.0],
            [-165.79,1843.0],
            [-686.0,1843.0],
            [-686.0,1744.0]
          ]
        },
        8:{
          name:'Aisle 8',
          colour:'yellow',
          points:[
            [-165.79,2106.0],
            [-165.79,2206.0],
            [-686.0,2206.0],
            [-686.0,2106.0]
          ]
        },
        9:{
          name:'Checkouts',
          colour:'pink',
          fillopacity:0.7,
          opacity:1.0,
          points:[
            [-1037.0,160.59],
            [-1034.0,360.0],
            [-1575.0,360.0],
            [-1575.0,160.59]
          ]
        },
        10:{
          name:'Aisle 19',
          colour:'red',
          fillopacity:0.7,
          opacity:1.0,
          points:[
            [-1460.24,1860.0],
            [-1460.24,2416.0],
            [-1558.30,2416.0],
            [-1558.30,1860.0]
          ]
        },
        11:{
          name:'Aisle 9',
          colour:'cyan',
          fillopacity:0.7,
          opacity:1.0,
          points:[
            [-896.0,514.0],
            [-896.0,1644.60],
            [-994.74,1644.60],
            [-994.74,514.0]
          ]
        },
        12:{
          name:'Aisle 10',
          colour:'cyan',
          fillopacity:0.7,
          opacity:1.0,
          points:[
            [-896.0,1858.0],
            [-896.0,2415.60],
            [-994.74,2415.60],
            [-994.74,1858.0]
          ]
        },
        13:{
          name:'Aisle 11',
          colour:'darkgray',
          fillopacity:0.7,
          opacity:1.0,
          points:[
            [-1084.0,508.0],
            [-1084.0,1123.0],
            [-1185.0,1123.0],
            [-1185.0,508.0]
          ]
        },
        14:{
          name:'Aisle 12',
          colour:'cyan',
          fillopacity:0.7,
          opacity:1.0,
          points:[
            [-1084.0,1268.0],
            [-1084.0,1643.0],
            [-1185.0,1643.0],
            [-1185.0,1268.0]
          ]
        },
        15:{
          name:'Aisle 13',
          colour:'cyan',
          fillopacity:0.7,
          opacity:1.0,
          points:[
            [-1084.0,1852.0],
            [-1084.0,2417.0],
            [-1185.0,2417.0],
            [-1185.0,1852.0]
          ]
        },
        16:{
          name:'Aisle 14',
          colour:'darkgray',
          fillopacity:0.7,
          opacity:1.0,
          points:[
            [-1284.0,508.0],
            [-1284.0,1123.0],
            [-1381.0,1123.0],
            [-1381.0,508.0]
          ]
        },
        17:{
          name:'Aisle 15',
          colour:'darkgray',
          fillopacity:0.7,
          opacity:1.0,
          points:[
            [-1284.0,1268.0],
            [-1284.0,1643.0],
            [-1381.0,1643.0],
            [-1381.0,1268.0]
          ]
        },
        18:{
          name:'Aisle 16',
          colour:'darkgray',
          fillopacity:0.7,
          opacity:1.0,
          points:[
            [-1274.0,1852.0],
            [-1274.0,2417.0],
            [-1381.0,2417.0],
            [-1381.0,1852.0]
          ]
        },
        19:{
          name:'Aisle 17',
          colour:'darkgray',
          fillopacity:0.7,
          opacity:1.0,
          points:[
            [-1480.0,508.0],
            [-1480.0,1123.0],
            [-1578.0,1123.0],
            [-1578.0,508.0]
          ]
        },
        20:{
          name:'Aisle 18',
          colour:'darkgray',
          fillopacity:0.7,
          opacity:1.0,
          points:[
            [-1480.0,1268.0],
            [-1480.0,1643.0],
            [-1578.0,1643.0],
            [-1578.0,1268.0]
          ]
        },
        21:{
          name:'Aisle 20',
          colour:'darkgray',
          fillopacity:0.7,
          opacity:1.0,
          points:[
            [-41.67,2663.59],
            [-41.67,2763.59],
            [-1690.32,2765.0],
            [-1690.32,2670.0]
          ]
        },
      };

      let poly=null;
      $.each(aisles,function(index,aisle) {
        poly1 = L.polygon(aisle.points).addTo(map);
        poly1.setStyle({fillColor: aisle.colour,color:aisle.colour,opacity:(aisle.opacity!=undefined?aisle.opacity:0.6),fillOpacity:(aisle.fillopacity!=undefined?aisle.fillopacity:0.2)});
        // console.log(aisle.vertical)
        poly1.bindTooltip(aisle.name, {permanent: true, direction:"center", className: 'polygon-labels'+(aisle.vertical!=undefined && aisle.vertical==true?' polygon-labels-vertical':'')})

      });

      //https://stackoverflow.com/questions/65073619/how-can-i-do-to-change-the-color-of-the-marker thanks to them;
      const redIcon = new L.Icon({
        iconUrl:
          "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png",
        shadowUrl:
          "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
      });

      <?php
        $barcode=null;
        if(isset($_GET['barcode'])&&is_numeric($_GET['barcode'])) $barcode=$_GET['barcode'];

        if($barcode!=null) {
          $stmt=$dbh->prepare('SELECT * FROM `tbl_products` WHERE `barcode`=:barcode LIMIT 1');
          $stmt->execute(array('barcode'=>$barcode));
          if($stmt->rowCount()>0) {
            $row=$stmt->fetch();
            if($row['locations']!='') {
              foreach(json_decode($row['locations'],true) as $loc) {
                $long=$loc[0];
                $lat=$loc[1];
                echo '
                  var marker = L.marker(['.$long.','.$lat.']'.($row['verification']==1?',{icon: redIcon}':'').').addTo(map);
                  marker.bindTooltip("'.substr($row['name'],0,20).'", {permanent: true, direction:"center", className: \'polygon-labels\'});
                ';
              }
            }
          }
        }elseif(isset($_GET['shoppinglist'])&&$_GET['shoppinglist']==true) {
          print_r(session::isLoggedIn());
          if(session::isLoggedIn()) {
            $stmtCart=$dbh->prepare('SELECT * FROM `tbl_shopping_cart` WHERE `userid`=:userid');
            $stmtCart->execute(array('userid'=>$_SESSION['smartshop']['id']));
            if($stmtCart->rowCount()>0) {
              $stmtProduct=$dbh->prepare('SELECT * FROM `tbl_products` WHERE `barcode`=:barcode LIMIT 1');

              $rowsCart=$stmtCart->fetchAll();
              foreach($rowsCart as $cart) {
                $stmtProduct->execute(array('barcode'=>$cart['barcode']));
                if($stmtProduct->rowCount()>0) {
                  $rows=$stmtProduct->fetchAll();
                  foreach($rows as $row) {
                    if($row['locations']!='') {
                      foreach(json_decode($row['locations'],true) as $loc) {
                        $long=$loc[0];
                        $lat=$loc[1];
                        echo '
                          var marker = L.marker(['.$long.','.$lat.']'.($row['verification']==1?',{icon: redIcon}':'').').addTo(map);
      
                          marker.bindPopup("'.general::html_escape(general::emoji_remove($row['name'])).'");
                        ';
                      }
                    }
                  }
                  echo '
                  marker.on(\'mouseover\', function (e) {
                      this.openPopup();
                  });
                  marker.on(\'mouseout\', function (e) {
                      this.closePopup();
                  });
                  ';
                }
              }
            }
          }
        }else{
          //show all products - 14/3/23 - suggestion from guest
          // bind popup documentation - thanks to: https://gis.stackexchange.com/questions/31951/showing-popup-on-mouse-over-not-on-click-using-leaflet ;
          $stmt=$dbh->prepare('SELECT * FROM `tbl_products`');
          $stmt->execute();
          if($stmt->rowCount()>0) {
            $rows=$stmt->fetchAll();
            foreach($rows as $row) {
              if($row['locations']!='') {
                foreach(json_decode($row['locations'],true) as $loc) {
                  $long=$loc[0];
                  $lat=$loc[1];
                  echo '
                    var marker = L.marker(['.$long.','.$lat.']'.($row['verification']==1?',{icon: redIcon}':'').').addTo(map);

                    marker.bindPopup("'.general::html_escape(general::emoji_remove($row['name'])).'");
                  ';
                }
              }
            }
            echo '
            marker.on(\'mouseover\', function (e) {
                this.openPopup();
            });
            marker.on(\'mouseout\', function (e) {
                this.closePopup();
            });
            ';
          }
        }
      ?>

    </script>
  </body>
</html>

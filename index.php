<?php
	require('scripts/main.php');

	if(!defined('UniProjects')) {die(json_encode(array('result'=>0,'message'=>'Outside of the network?')));}
?>
<!DOCTYPE php>
<html>
    <head>
        <title>Graph study</title>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="/plugins/morrisjs/morris.css" />
		<meta name="description" content="Some content" />
		<meta name="author" content="Created by Jericho Uzzell" />

        <link href="/plugins/bootstrap5/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="/plugins/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="/plugins/sweetalerts2/css/sweetalert2.min.css">
    </head>

    <body>
        <div class="col-lg-8 mx-auto p-3 py-md-5">
            <header class="d-flex align-items-center pb-3 mb-5 border-bottom">
                <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                    <span class="fs-4">Graph test</span>
                </a>
            </header>
            <main>
                <div class="row g-5">
                    <div class="col-md-12" id="graph-main" style="display:none;">
						<div id="graph-main-div"></div>
                    </div>
                </div>
            </main>
            <footer class="pt-5 my-5 text-muted border-top">
                Created by the Bootstrap team &middot; &copy; 2021
            </footer>
        </div>
    </body>
    

    <script src="/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="/plugins/bootstrap5/bootstrap.min.js" type="text/javascript"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="/plugins/morrisjs/morris.min.js" type="text/javascript"></script>

	<script>
		$(document).ready(function() {
			//graph-main-div
			
			$('#graph-main').show();
			let Lin = Morris.Area({
				element: 'graph-main-div',
				data:
				[
					{m:'2021-02',item1:2,item2:5,item3:4},
					{m:'2021-03',item1:3,item2:6,item3:2},
					{m:'2021-04',item1:7,item2:2,item3:4},
					{m:'2021-05',item1:1,item2:7,item3:5},
					{m:'2021-06',item1:3,item2:3,item3:7}
				],
				xLabels: 'day',
				xkey: 'm',
				ykeys: ['item1','item2','item3'],
				labels: ['item1','item2','item3'],
				// labels: headers_name,
				xLabelFormat: function (d) {
					var weekdays = new Array(7);
					weekdays[0] = "SUN";
					weekdays[1] = "MON";
					weekdays[2] = "TUE";
					weekdays[3] = "WED";
					weekdays[4] = "THU";
					weekdays[5] = "FRI";
					weekdays[6] = "SAT";

					return weekdays[d.getDay()] + ' ' + 
						("0" + (d.getMonth() + 1)).slice(-2) + '-' + 
						("0" + (d.getDate())).slice(-2);
				},
				pointSize: 5,
				hideHover: 'false',
				// lineColors: colours,
				lineWidth: 5,
				xLabelAngle: 45,
				fillOpacity: 0.0,
				resize: true,
				pointFillColors: ['#fff'],
				pointStrokeColors: ['black'],
				// gridIntegers: true,
				//dateFormat: function (d) {
				//    var ds = new Date(d);
				//    return ds.getDate() + ' ' + months[ds.getMonth()];
				//},
				behaveLikeLine: true,
				parseTime: true //
			});
		});
	</script>
</html>
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
		<meta name="description" content="Graph study for University, contact me 1702201@student.uwtsd.ac.uk" />
		<meta name="author" content="Created by Jericho Uzzell" />

        <link href="/plugins/bootstrap5/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="/plugins/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="/plugins/sweetalerts2/css/sweetalert2.min.css">
    </head>

    <body>
		<div id="body-welcome">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-sm-12 offset-md-2 col-md-8 offset-lg-2 col-lg-8 offset-xl-2 col-xl-8">
						<div class="row">
							<div class="mt-3">
								<div class="alert alert-info">
									<h4>Please wait!</h4>
									<p>We are just getting the website ready!</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="body-login" style="display:none;">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-sm-12 offset-md-2 col-md-8 offset-lg-2 col-lg-8 offset-xl-2 col-xl-8">
						<div class="row">
							<div class="mt-3">
								<h2>Welcome!</h2>
								<p>
									This website is a University project, trying to understand data presentation in a usability study.<br/>
									You can enter a name, age and gender if you would like or click the anonymous button and we will generate details for you.
								</p>
							</div>
							<div class="mt-3">
								<div class="row g-3">
									<div class="col-md-8">
										<label for="body-login-form-name" class="form-label">Name</label>
										<input type="text" class="form-control" id="body-login-form-name">
									</div>
									<div class="col-md-4">
										<label for="body-login-form-age" class="form-label">Age</label>
										<input type="number" class="form-control" id="body-login-form-age">
									</div>
									<div class="col-md-12">
										<label for="body-login-form-gender" class="form-label">Gender</label>
										<input type="text" class="form-control" id="body-login-form-gender">
									</div>
									<div class="col-md-12">
										<label for="body-login-form-anonymous" class="form-label">Anonymous</label>
									    <input class="form-check-input" type="checkbox" id="body-login-form-anonymous">
									</div>
									<div class="col-md-12">
									    <button class="btn btn-block btn-xl btn-primary" id="body-login-form-continue">Continue</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="body-session" style="display:none;">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-sm-12 offset-md-2 col-md-8 offset-lg-2 col-lg-8 offset-xl-2 col-xl-8">
						<div class="row">
							<div class="mt-3">
								<h2>Generating questions!</h2>
								<p>
									We are just generating some questions now, please wait!
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="body-session-questions" style="display:none;">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-sm-12 offset-md-2 col-md-8 offset-lg-2 col-lg-8 offset-xl-2 col-xl-8">
						<div class="row">
							<div class="mt-3">
								<button class="btn btn-warning btn-lg" id="body-session-questions-end">End</button>
								<button class="btn btn-danger btn-lg" id="body-session-questions-withdraw">Withdraw!</button> 
								<button class="btn btn-info btn-lg" id="body-session-questions-anonymous" style="display:none">Anonymous</button> 
							</div>
							<div class="mt-1 text-end">
								<h1>
									<span class="text-secondary" id="body-session-questions-question-number"></span>/10
								</h1>
							</div>
							<div class="mt-1" id="body-session-questions-graph"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </body>
    

    <script src="/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="/plugins/bootstrap5/bootstrap.min.js" type="text/javascript"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="/plugins/morrisjs/morris.min.js" type="text/javascript"></script>
    <script src="/plugins/sweetalerts2/js/sweetalert2.all.min.js"></script>
	<script src="/scripts/js/errors.js" type="text/javascript"></script>
	<script src="/scripts/js/validator.js" type="text/javascript"></script>
	<script src="/scripts/js/home.js" type="text/javascript"></script>
</html>
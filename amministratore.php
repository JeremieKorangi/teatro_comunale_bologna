<!doctype html>
<html lang="en">
  <head>
  	<title>Web app per vendite e accesso al teatro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="login/css/style.css">

	<?php include('inc/body.php'); ?>

  </head>
	<body>

	<section class="ftco-section">
		<div class="container">
		<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">T-APP 		
					</h2>
				</div>
			</div> 

			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center">AMMINISTRATORE</h3> <br> <br> <br>
		      	
	            <div class="form-group">
	            	<a href="login/admin.php"><button type="submit" class="form-control btn btn-primary submit px-3">ADMIN</button></a>
	            </div>
				<div class="form-group">
	            	<a href="login/punto_di_vendita"><button type="submit" class="form-control btn btn-primary submit px-3">PUNTO DI VENDITA</button></a>
	            </div>
				<div class="form-group">
	            	<a href="login/controllore"><button type="submit" class="form-control btn btn-primary submit px-3">CONTROLLORE</button></a>
	            </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
  	<script src="js/popper.js"></script>
  	<script src="js/bootstrap.min.js"></script>
  	<script src="js/main.js"></script>

	</body>
</html>


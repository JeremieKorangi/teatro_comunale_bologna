<!doctype html>
<html lang="en">
  <head>
  	<title>T-APP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/style.css">

	<?php include('../inc/body.php'); ?>

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
		      	<h3 class="mb-4 text-center">Accedi al tuo conto personale  </h3>
		      	<form action="#" class="signin-form" id="signupForm">
		      		<div class="form-group">
		      			<input type="text" class="form-control" id="indirizzo_mail" placeholder="Indirizzo mail" required>
		      		</div>
	            <div class="form-group">
	              <input id="password-field" type="password" id="password" class="form-control" placeholder="Password" required>
	              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
	            </div>
	            <div class="form-group">
				<button type="submit" class="form-control btn btn-primary submit px-3">Accesso</button>
	            </div>
	            <div class="form-group d-md-flex">
	            	<div class="w-50">
		            	<label class="checkbox-wrap checkbox-primary">Non dimenticare l'accesso
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
									<a href="#" style="color: #fff">Password dimenticata</a>
								</div>
	            </div>
	          </form>
			  <a href="../index"><button class="btn btn-primary" style="float:left">Home page</button></a>

			  <a href="registrati"><button class="btn btn-primary" style="float:right">Registrati</button></a>
		      </div>
				</div>
			</div>
		</div>
	</section>

  <script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <script>
	document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("signupForm").addEventListener("submit", async function (event) {
        event.preventDefault();

        const email = document.getElementById("indirizzo_mail").value.trim();
        const password = document.getElementById("password-field").value.trim();

        if (email === "" || password === "") {
            alert("Tutti i campi sono obbligatori !");
            return;
        }

        const response = await fetch("../api/index.php?op=login", {
            method: "POST",
            body: JSON.stringify({
                action: "login",
                indirizzo_mail: email,
                password: password,
            }),
        });

        const result = await response.json();

        if (result.success) {
			<?php if(!isset($_GET['id'])) : ?>
				alert("Bravissimo ! Verrai reindirizzato verso il dashboard.");
				window.location.href = "../utente/"; 
			<?php else: ?>
				alert("Bravissimo ! Puo procedere all'iscrizione all'evento desiderato !");
            	window.location.href = "../show_evento?id=<?= $_GET['id']; ?>"
			<?php endif; ?>
        } else {
            alert("Errore : " + result.message);
        }
    });
});

</script>

</body>
</html>


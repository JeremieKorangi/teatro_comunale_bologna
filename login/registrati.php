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
					<h2 class="heading-section">T-APP</h2>
				</div>
			</div> 

			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center">Crea il tuo conto per iniziare  </h3>
								<form action="#" class="signin-form" id="signupForm">
					<div class="form-group">
						<input type="text" class="form-control" id="nome_utente" placeholder="Nome utente" required>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="indirizzo_mail" placeholder="Inserire l'indirizzo mail" required>
					</div>
					<div class="form-group">
						<input id="password" type="password" class="form-control" placeholder="Inserire la password" required>
						<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
					</div>
					<div class="form-group">
						<input id="password_confirm" type="password" class="form-control" placeholder="Ripetere la password" required>
						<span toggle="#password_confirm" class="fa fa-fw fa-eye field-icon toggle-password"></span>
					</div>
                 
					<div class="form-group">
						<button type="submit" class="form-control btn btn-primary submit px-3">Registrati</button>
					</div>
				</form>

                 <a href="../index.php"><button class="btn btn-primary" style="float:left">Home page</button></a>

			    <a href="index"><button class="btn btn-primary" style="float:right">Accedere</button></a>  
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
    document.getElementById("signupForm").addEventListener("submit", function (event) {
        event.preventDefault(); 

        let nomeUtente = document.getElementById("nome_utente").value.trim();
        let email = document.getElementById("indirizzo_mail").value.trim();
        let password = document.getElementById("password").value.trim();
        let confirmPassword = document.getElementById("password_confirm").value.trim();
        let errors = [];

        
        if (nomeUtente === "") {
            errors.push("Il nome utente deve essere inserito.");
        }

       
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            errors.push("L'indirizzo mail non è valido.");
        }

       
        if (password.length < 6) {
            errors.push("La password deve contenere almeno 6 caratteri.");
        }

      
        if (password !== confirmPassword) {
            errors.push("Le password non corrispondono.");
        }

       
        if (errors.length > 0) {
            alert(errors.join("\n")); 
        } else {
						
			const username = document.getElementById("nome_utente").value;
            const email = document.getElementById("indirizzo_mail").value;
            const password = document.getElementById("password").value;


            fetch("../api/index.php?op=registrati", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    action: "register",
                    nome_utente: username,
                    indirizzo_mail: email,
                    password: password,
                })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || data.error);
            })
            .catch(error => console.error("Errore:", error));
			

              setTimeout(() => {
                  window.location.href = "index";
               }, 3000);
        }
    });


    document.querySelectorAll(".toggle-password").forEach(function (toggle) {
        toggle.addEventListener("click", function () {
            let passwordField = document.querySelector(toggle.getAttribute("toggle"));
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggle.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggle.classList.remove("fa-eye-slash");
            }
        });
    });
});
</script>



	</body>
</html>


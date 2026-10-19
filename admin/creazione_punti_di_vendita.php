<?php
    require "inc/sessione.php";
    attivazione_sessione("nome_admin");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Web app per le vendite e accessi al teatro</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
            }

        .navbar {
            display: flex;
            justify-content: space-between;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
        }

        .menu-icon, .home-icon, .user-profile {
            font-size: 18px;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 20px;
            padding: 20px;
        }

        .menu-item {
            background-color:  #101130;
            color: #fff;
            text-align: center;
            padding: 60px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .menu-item:hover {
            background-color: #0056b3;
        }
        @media (max-width: 768px) {
            .container {
                grid-template-columns: repeat(2, 1fr); /* Deux colonnes sur tablette */
            }
        }

        @media (max-width: 480px) {
            .container {
                grid-template-columns: 1fr; /* Une seule colonne sur mobile */
            }
        }

    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
       <?php include "inc/menu.php"; ?>
    
       <div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center mb-4 text-primary">Creare un punto di vendita</h2>
        <form id="formPuntoVendita" method="POST" action="crea_punto_vendita.php">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome del punto vendita</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="col-md-6">
                    <label for="responsabile" class="form-label">Indirizzo mail</label>
                    <input type="email" class="form-control" id="mail" name="responsabile" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="email" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="email">
                </div>
                <div class="col-md-6">
                    <label for="telefono" class="form-label">Conferma password</label>
                    <input type="password" class="form-control" id="password_conferma" name="telefono">
                </div>
            </div>

            <div class="mb-3">
                <label for="indirizzo" class="form-label">Telefono</label>
                <input type="text" class="form-control" id="telefono" name="indirizzo" required>
            </div>

          

            <div class="text-center">
                <button type="submit" class="btn btn-primary px-5">Creare</button>
            </div>
        </form>
    </div>
</div>

       

    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php require "inc/logout_mod.php"; ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script src="js/notifica.js"></script>

    <script>document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("formPuntoVendita").addEventListener("submit", function (event) {
            event.preventDefault(); 

            let nomeUtente = document.getElementById("nome").value.trim();
            let email = document.getElementById("mail").value.trim();
            let password = document.getElementById("password").value.trim();
            let confirmPassword = document.getElementById("password_conferma").value.trim();
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
                            
                const username = document.getElementById("nome").value;
                const email = document.getElementById("mail").value;
                const password = document.getElementById("password").value;
                const telefono = document.getElementById("telefono").value;



                fetch("../api/index.php?op=registrati", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        action: "punti_di_vendita",
                        nome_utente: username,
                        indirizzo_mail: email,
                        password: password,
                        telefono:telefono
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
    });
    </script>
</body>

</html>
<?php 
    require "inc/sessione.php";
    attivazione_sessione("nome_utente")
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Area personale T-APP</title>

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
    grid-template-columns: repeat(2, 2fr);
    gap: 20px;
    padding: 20px;
}

.menu-item {
    background-color: #101130;;
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

       <div class="row">

                    <div class="container">
                        <a href="biglietti">
                            <div class="menu-item" id="eventi">
                             <i class="fas fa-tag icon"></i>
                                <span>BIGLIETTI</span>
                            </div>
                         </a>
                         <a href="abbonamenti">
                        <div class="menu-item" id="dati-personali">
                         <i class="fas fa-tag icon"></i>   
                            <span>ABBONAMENTI</span>
                        </div>
                        <a href="../evento">
                            <div class="menu-item" id="eventi">
                             <i class="fas fa-inbox icon"></i>
                                <span>SPETTACOLI</span>
                            </div>
                         </a>
                        <a href="inc/disconnessione.php">
                        <div class="menu-item" id="disconnessione">
                     
                          <i class="fas fa-user icon"></i>
                            <span>LOGOUT</span>
                        </div>
                    </div>

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
    <script>
        function getStatistiche() {
    fetch("../api/index.php?op=backend&action=statistiche") 
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let disponibili = document.getElementById("eventi_disponibili");
                let inseriti = document.getElementById("eventi_inseriti");
                let iscritti = document.getElementById("eventi_iscritti");

                if (disponibili && inseriti && iscritti) {
                    disponibili.textContent = data.eventi.eventi_disponibili ?? 0;
                    inseriti.textContent = data.eventi.eventi_inseriti ?? 0;
                    iscritti.textContent = data.eventi.eventi_iscritti ?? 0;
                } else {
                    console.error("Errore");
                }
            } else {
                console.error("Erreur API :", data.message);
            }
        })
        .catch(error => console.error("Erreur durante la recuperazione delle statistiche :", error));
}

document.addEventListener("DOMContentLoaded", getStatistiche);

setInterval(getStatistiche, 5000);

    </script>
</body>

</html>
<?php
    require "inc/sessione.php";
    attivazione_sessione("adminID");
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />


    <style>
        body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
        }

    .stat-menu {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
        justify-content: center;
    }

    .stat-button {
        background: #1e3a8a;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 18px;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background 0.3s ease, transform 0.2s ease;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .stat-button:hover {
        background: #2563eb;
        transform: translateY(-2px);
    }

    .stat-button i {
        font-size: 18px;
    }

    .stat-frame {
        width: 100%;
        height: 600px;
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 12px rgba(0,0,0,0.1);
    }
    </style>

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

       <?php include "inc/menu.php"; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row -->
                    <div class="row">

                   <!-- <div class="container">
                        <div style="position: relative; width: 200%; padding-bottom: 100%; height: 0; overflow: hidden;">
                             <iframe src="http://localhost:3000/d-solo/eel66qk3wqg3ke/somma-biglietto-del-giorno?from=1745632614741&to=1745632614741&timezone=browser&orgId=1&theme=light&panelId=1&__feature.dashboardSceneSolo" frameborder="0" 
                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border-radius:15px" 
                                    allowfullscreen>
                              </iframe>
                        </div>
                    </div> -->

                    <div class="stat-menu">
                        <button class="stat-button" onclick="caricaPannello('globale')">
                            <i class="fas fa-chart-pie"></i> Vista Globale
                        </button>

                        <button class="stat-button" onclick="caricaPannello('ora')">
                            <i class="fas fa-clock"></i> Incassi giornalieri
                        </button>
                        
                        <button class="stat-button" onclick="caricaPannello('mese')">
                            <i class="fas fa-calendar-alt"></i> Incassi Mensili
                        </button>
                      

                    </div>

                    <iframe id="grafanaFrame" class="stat-frame" src=""></iframe>

    <?php require "inc/logout_mod.php"; ?>

    <script>
    function caricaPannello(tipo) {
        const urls = {
        globale: "http://localhost:3000/d-solo/bely22a12dedcb/vista-globale-abbonamenti-2020?from=1747278482368&to=1747300082368&timezone=browser&orgId=1&theme=light&panelId=1&__feature.dashboardSceneSolo",
       
        };

        document.getElementById("grafanaFrame").src = urls[tipo];
    }
    </script>

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

    </script>
</body>

</html>
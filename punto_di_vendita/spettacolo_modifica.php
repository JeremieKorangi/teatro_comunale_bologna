<?php 
    require "inc/sessione.php";
    //attivazione_sessione("nome_utente")

    $host="localhost";
    $nome_database="tirocinio";
    $nome="root";
    $password="";

    $db= new PDO("mysql:dbname=$nome_database;host=$host", "$nome", "$password");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["okay"])) {
    
        $titolo = $_POST["titolo"];
        $luogo = $_POST["luogo"];
        $datetime = $_POST["datetime"];
        $descrizione = $_POST["descrizione"];

        $imagePath = null; // Initialisation

        if (!empty($_FILES['image']['name'])) {
            $uploadDir = "../img/"; // Dossier de stockage des images
            $fileName = basename($_FILES["image"]["name"]); // Nom du fichier
            $targetFilePath = $uploadDir . time() . "_" . $fileName; // Éviter les doublons
    
            $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION)); // Extension
            $allowedTypes = ["jpg", "jpeg", "png", "gif"]; // Formats autorisés
    
            // Vérifier si l'extension est valide
            if (in_array($imageFileType, $allowedTypes)) {
                // Déplacer le fichier vers le dossier "uploads/"
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    $imagePath = $targetFilePath; 
                } else {
                    echo "Erreur lors du téléchargement de l'image.";
                }
            } else {
                echo "Format d'image non autorisé. Seuls JPG, JPEG, PNG et GIF sont acceptés.";
            }
        }
    

        $req=$db->prepare("INSERT INTO spettacolo (titolo_spettacolo, data_e_ora_spettacolo, sala_citta_luogo, descrizione,immagine) VALUES (?,?,?,?,?)");
        $req->execute([$titolo,$datetime,$luogo,$descrizione,$imagePath]);
       
        $spettacoloID=$db->lastInsertId();

        $p1=$db->prepare("INSERT INTO prezzo (tipo, importo,spettacoloID) VALUES (?,?,$spettacoloID)");
        $p1->execute(["black",$_POST["black"]]);

        $p2=$db->prepare("INSERT INTO prezzo (tipo, importo,spettacoloID) VALUES (?,?,$spettacoloID)");
        $p2->execute(["darkgray",$_POST["darkgray"]]);

        $p3=$db->prepare("INSERT INTO prezzo (tipo, importo,spettacoloID) VALUES (?,?,$spettacoloID)");
        $p3->execute(["orange",$_POST["orange"]]);

        $p4=$db->prepare("INSERT INTO prezzo (tipo, importo,spettacoloID) VALUES (?,?,$spettacoloID)");
        $p4->execute(["gold",$_POST["gold"]]);

        $p5=$db->prepare("INSERT INTO prezzo (tipo, importo,spettacoloID) VALUES (?,?,$spettacoloID)");
        $p5->execute(["blue",$_POST["blue"]]);

        $riduzioni = isset($_POST["riduzioni"]) ? implode(",", $_POST["riduzioni"]) : "";
        $p6=$db->prepare("INSERT INTO riduzione (tipo,spettacoloID) VALUES (?,$spettacoloID)");
        $p6->execute([$riduzioni]);
       // var_dump($_POST['riduzioni']);
        
       $punti_di_vendita=isset($_POST["punti_vendita"]) ? implode (",", $_POST["punti_vendita"]) : "";
       $p7=$db->prepare("INSERT INTO punto_di_vendita (nome, spettacoloID) VALUES (?,$spettacoloID)");
       $p7->execute([$punti_di_vendita]);
    }
    
 

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Web app per le vendite e accessi al teatro</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#riduzioni').select2({
            placeholder: "Seleziona le riduzioni",
            allowClear: true
        });
    });
    </script>


    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 400;
            margin: 70px auto;
            background: white;
            padding: 50px;
            border-radius: 50px;
            box-shadow: 10px 0px 10px rgba(0, 0, 0, 0.1);
        }
    
        .form-control-color {
            width: 3rem;
            height: 3rem;
            border: none;
            background: none;
            padding: 0;
        }
        .d-flex.align-items-center {
            align-items: center;
        }
        .me-2 {
            margin-right: 0.5rem;
        }
        img {
            max-width: 100%;
            height: auto;
        }

    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
    <?php include "inc/menu.php"; ?>

            <div class="form-container">
                 <?php
                    if(isset($_SESSION["success"])) : ?>
                    <div class="btn btn-primary"><?= $_SESSION["success"]; ?></div>
                  <?php endif; unset($_SESSION["success"]); ?>
                <h3 class="text-center mb-4">Inserire uno spettacolo</h3>
                
                <form method="post" id="articleForm" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="titre" class="form-label">Titolo</label>
                        <input type="text"  name="titolo" class="form-control" id="titolo" required>
                    </div>
                    <div class="mb-3">
                        <label for="titre" class="form-label">Sala - Città Luogo</label>
                        <input type="text" class="form-control" name="luogo" required>
                    </div>
                    <div class="mb-3">
                <label for="datetime" class="form-label">Data e ora</label>
                <input type="text" class="form-control" id="datetime" name="datetime" placeholder="Selezionare la data e l'ora" required>
            </div>

                    <div class="mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <textarea class="form-control" id="descrizione" name="descrizione" rows="4" placeholder="Inserire la descrizione"></textarea>
            </div>

            <div class="mb-3">
                <div class="mb-3 text-center">
                    <img src="../img/mappa.png" alt="Mappa dei posti con colori" class="img-fluid">
                </div>
                <label class="form-label">Prezzi per Sezione</label>
                <div class="d-flex align-items-center mb-2">
                    <input type="color" class="form-control form-control-color me-2" value="black" disabled>
                    <span class="me-2">Fila:</span>
                    <input type="number" class="form-control" name="black" placeholder="Inserisci il prezzo" required>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <input type="color" class="form-control form-control-color me-2" value="#FFD700" disabled>
                    <span class="me-2">Palco:</span>
                    <input type="number" class="form-control" name="gold" placeholder="Inserisci il prezzo" required>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <input type="color" class="form-control form-control-color me-2" value="#FFA500" disabled>
                    <span class="me-2">Proscenio:</span>
                    <input type="number" class="form-control" name="orange" placeholder="Inserisci il prezzo" required>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <input type="color" class="form-control form-control-color me-2" value="#808080" disabled>
                    <span class="me-2">Lunetta:</span>
                    <input type="number" class="form-control" name="darkgray" placeholder="Inserisci il prezzo" required>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <input type="color" class="form-control form-control-color me-2" value="#0000FF" disabled>
                    <span class="me-2">Loggione:</span>
                    <input type="number" class="form-control" name="blue" placeholder="Inserisci il prezzo" required>
                </div>
            </div>


            <br>

            <div class="mb-3">
                <label for="punti-vendita" class="form-label">Punti di Vendita</label>
                <div id="punti-vendita-container">
                    <div class="d-flex mb-2">
                        <input type="text" class="form-control" name="punti_vendita[]" placeholder="Inserire un punto di vendita" required>
                        <button type="button" class="btn btn-danger ms-2 remove-field" style="display: none;">X</button>
                    </div>
                </div>
                <button type="button" class="btn btn-success mt-2" id="add-punto-vendita">+ Aggiungere un punto di vendita</button>
            </div>

            <br>

            <div class="mb-3">
                <label for="riduzioni" class="form-label">Seleziona le Riduzioni</label>
                <select class="form-control" id="riduzioni" name="riduzioni[]" multiple>
                    <option value="INTERO">INTERO</option>
                    <option value="UNDER30">UNDER30</option>
                    <option value="RIDOTTO">RIDOTTO</option>
                    <option value="OMAGGIO">OMAGGIO</option>
                    <option value="RIDOTTO4">RIDOTTO4</option>
                    <option value="DIPENDENTI">DIPENDENTI</option>
                    <option value="COURTESY">COURTESY</option>
                    <option value="SCONTO20%">SCONTO20%</option>
                    <option value="LAST MINUTE">LAST MINUTE</option>
                    <option value="SCONTO10%">SCONTO10%</option>
                    <option value="INTEGRAZIONE">INTEGRAZIONE</option>
                    <option value="UNDER18">UNDER18</option>
                    <option value="UNIVERSITARI">UNIVERSITARI</option>
                    <option value="RIDOTTO ABB.">RIDOTTO ABB.</option>
                    <option value="CARD MUSEI">CARD MUSEI</option>
                    <option value="OVER65">OVER65</option>
                    <option value="STUDENTI">STUDENTI</option>
                    <option value="PROMOZIONE">PROMOZIONE</option>
                    <option value="SCONTO15%">SCONTO15%</option>
                    <option value="UNDER15">UNDER15</option>
                    <option value="SCONTO5%">SCONTO5%</option>
                    <option value="INVITO">INVITO</option>
                    <option value="OFFERTA">OFFERTA</option>
                    <option value="JAZZ CARD">JAZZ CARD</option>
                    <option value="TRENITALIA">TRENITALIA</option>
                </select>
                <small class="form-text text-muted">Seleziona una o più riduzioni tenendo premuto Ctrl (Windows) o Cmd (Mac).</small>
            </div>



                    <div class="mb-3">
                        <label for="image" class="form-label">Immagine</label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
                    </div>

                    <button type="submit" name="okay" class="btn btn-primary w-100">Publiccare</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.7.1/tinymce.min.js"></script>

    <script>
    tinymce.init({
        selector: '#descrizione',
        menubar: false,
        plugins: 'advlist autolink lists link charmap print preview anchor',
        toolbar: 'bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
        branding: false
    });
    </script>

<script>
    flatpickr("#datetime", {
        enableTime: true,
        dateFormat: "d-m-y H:i",
        time_24hr: true,
        locale: "fr"
    });
</script>

<script src="js/notifica"></script>

<script>
    document.getElementById('add-punto-vendita').addEventListener('click', function () {
        let container = document.getElementById('punti-vendita-container');

        // Création d'un div contenant l'input et le bouton de suppression
        let div = document.createElement('div');
        div.classList.add('d-flex', 'mb-2');

        let input = document.createElement('input');
        input.type = 'text';
        input.name = 'punti_vendita[]';
        input.classList.add('form-control');
        input.placeholder = 'Inserire un punto di vendita';
        input.required = true;

        let removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.classList.add('btn', 'btn-danger', 'ms-2', 'remove-field');
        removeBtn.textContent = 'X';
        
        // Suppression du champ lorsqu'on clique sur "X"
        removeBtn.addEventListener('click', function () {
            div.remove();
        });

        div.appendChild(input);
        div.appendChild(removeBtn);
        container.appendChild(div);

        // Afficher le bouton de suppression pour tous les champs (sauf le premier)
        document.querySelectorAll('.remove-field').forEach(btn => btn.style.display = 'inline-block');
    });
</script>


</body>

</html>
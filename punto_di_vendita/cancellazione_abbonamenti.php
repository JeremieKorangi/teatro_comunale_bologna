<?php
    require "inc/sessione.php";
    attivazione_sessione("nome_punto_di_vendita");
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Punto di vendita - Web app vendite e accessi al teatro</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

       <?php include "inc/menu.php"; ?>
        
          
                <!-- Begin Page Content -->
                <div class="container-fluid">
                <?php if(isset($_SESSION["success"])) : ?>
                    <div class="btn btn-success">
                    La cancellazione è stata effettuata con successo !
                    </div>
                <?php endif; unset($_SESSION["success"]); ?>
        
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800" style="text-align:center";>CANCELLARE ABBONAMENTI ACQUISTATI - Punto di vendita : <?= htmlspecialchars($_SESSION["nome_punto_di_vendita"]); ?></h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                              <div style="max-height: 500px; overflow-y: auto; border: 1px solid #ccc;">
                                 <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                    <tr style="background-color:#0056b3; color:white">
                                         <th style="position: sticky; top: 0; background-color: green; z-index: 2;">Nome utente</th>
                                         <th style="position: sticky; top: 0; background-color: green; z-index: 2;">Indirizzo mail</th>
                                        <th style="position: sticky; top: 0; background-color: #0056b3; z-index: 2;">Titolo spettacolo</th>
                                        <th style="position: sticky; top: 0; background-color: #0056b3; z-index: 2;">Data movimento</th>
                                        <th style="position: sticky; top: 0; background-color: #0056b3; z-index: 2;">Riduzione</th>
                                        <th style="position: sticky; top: 0; background-color: #0056b3; z-index: 2;">Prezzo incassato</th>
                                        <th style="position: sticky; top: 0; background-color: #0056b3; z-index: 2;">Sala - Città luogo</th>
                                        <th style="position: sticky; top: 0; background-color: #0056b3; z-index: 2;">Città anagrafica biglietto</th>

                                        <th style="position: sticky; top: 0; background-color: #0056b3; z-index: 2;">Posto</th>
                                        <th style="position: sticky; top: 0; background-color: #0056b3; z-index: 2;">Ora controllo accesso</th>
                                        <th style="position: sticky; top: 0; background-color: green; z-index: 2;";>Codice QR</th>
                                        <th style="position: sticky; top: 0; background-color: red; z-index: 2;";>Cancella l'abbonamento</th>

                                    </tr>
                                       
                                    </thead>
                                   
                                    <tbody id="getEvent">
                                    <?php 
                                        require "../api/database.php";
                                        
                                        $req=$db->prepare("SELECT * FROM spettacolo JOIN abbonamento JOIN riduzione JOIN utente WHERE abbonamento.spettacolo=spettacolo.spettacoloID AND abbonamento.punto_di_vendita=? AND abbonamento.spettacolo=riduzione.spettacoloID AND abbonamento.utente=utente.PersonID");
                                        $req->execute([$_SESSION['punto_di_venditaID']]);
                                        $res=$req->fetchAll(PDO::FETCH_ASSOC);
                                       // var_dump($res);
                                        foreach($res as $spettacolo) :
                                      ?>
                                            <tr data-id="<?= $spettacolo["abbonamentoID"]; ?>">
                                                <td><?= $spettacolo["Nome"]; ?></td>
                                                <td><?= $spettacolo["Indirizzo_mail"]; ?></td>
                                                <td><?= $spettacolo["titolo_spettacolo"]; ?></td>     
                                                <td><?= $spettacolo["data_movimento"]; ?></td>
                                                <td><?= $spettacolo["tipo"]; ?></td>
                                                <td><?= $spettacolo["prezzo_biglietto"]; ?></td>
                                                <td><?= $spettacolo["sala_citta_luogo"]; ?></td>
                                                <td><?= $spettacolo["citta_anagrafica_biglietto"]; ?></td>

                                                <td><?= $spettacolo["posto_biglietto"]; ?></td>
                                                <td></td>
                                                <td>
                                                    <div class="qr-container" data-id="<?= $spettacolo["abbonamentoID"] ?>"></div>
                                                </td>
                                                <td><a href="inc/cancellazione_abbonamento?id=<?= $spettacolo["abbonamentoID"];?>"><class class="btn btn-danger" style="float:right"><i class="fas fa-trash icon"></i></class></td>

                                            </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                              </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->



        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    
   

    

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

   <?php require "inc/logout_mod.php"; ?>

   <div id="qrModal" style="
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
    ">
        <div onclick="document.getElementById('qrModal').style.display='none'" style="cursor: pointer;">
            <img id="qrLarge" src="" alt="QR Agrandi" style="max-width: 90vw; max-height: 90vh; border: 4px solid white; border-radius: 12px;" />
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <script src="js/notifica.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".qr-container").forEach((container, index) => {
            const id = container.dataset.id || `default-${index}`;
            const qr = new QRCode(container, {
                text: `../admin/controllore/valida?id=${id}`,
                width: 70,
                height: 70
            });

            setTimeout(() => {
                const canvas = container.querySelector("canvas");
                if (canvas) {
                    canvas.style.cursor = "zoom-in";
                    canvas.addEventListener("click", () => {
                        const qrModal = document.getElementById("qrModal");
                        const qrLarge = document.getElementById("qrLarge");
                        qrLarge.src = canvas.toDataURL("image/png");
                        qrModal.style.display = "flex";
                    });
                }
            }, 500);
        });
    });
    </script>



    <script>

    function getAllArticles() {
        fetch('../api/index.php?op=backend&action=getEvent')
            .then(response => response.json())
            .then(data => {
                console.log("Données reçues:", data); 
                const articles = data.eventi;

                if (!Array.isArray(articles)) {
                    throw new Error("I dati non sono ricevuti correttamente !");
                }
                const container = document.getElementById("getEvent");
                container.innerHTML = ""; 

                articles.forEach((article, index) => { 
                    const articleHTML = `
                        <tr>
                                                <td><img src="../img/${article.immagine}" style="width: 120px; height: 80px; border-radius: 8px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);" alt="Aperçu de l'événement"></td>      
                                                <td>${article.titolo}</td>
                                                <td>${article.descrizione}</td>
                                                <td>${article.luogo_svolgimento}</td>
                                                <td>${article.data_svolgimento}</td>
                                                <td>${article.data_creazione}</td>
                                            </tr>
                    
                    `;

                    container.innerHTML += articleHTML;
                });
            })
            .catch(error => console.error("Errore:", error));
    }
        getAllArticles();

    setInterval(getAllArticles, 5000);

</script>


</body>

</html>
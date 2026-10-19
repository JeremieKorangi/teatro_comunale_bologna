<?php session_start();?>
<?php 
                                    require 'api/database.php';

                                    $jey=$db->prepare("SELECT * FROM posto WHERE spettacoloID=?");
                                    $jey->execute([$_GET['id']]);
                                    $posti=$jey->fetchAll(PDO::FETCH_ASSOC);
                            
                                    $req1=$db->prepare("SELECT * FROM prezzo WHERE spettacoloID=? AND tipo='black'");
                                    $req1->execute([$_GET["id"]]);
                                    $black=$req1->fetch(PDO::FETCH_ASSOC);
                            
                                    $req2=$db->prepare("SELECT * FROM prezzo WHERE spettacoloID=? AND tipo='gold'");
                                    $req2->execute([$_GET["id"]]);
                                    $gold=$req2->fetch(PDO::FETCH_ASSOC);
                            
                                    $req3=$db->prepare("SELECT * FROM prezzo WHERE spettacoloID=? AND tipo='orange'");
                                    $req3->execute([$_GET["id"]]);
                                    $orange=$req3->fetch(PDO::FETCH_ASSOC);
                            
                                    $req4=$db->prepare("SELECT * FROM prezzo WHERE spettacoloID=? AND tipo='darkgray'");
                                    $req4->execute([$_GET["id"]]);
                                    $darkgray=$req4->fetch(PDO::FETCH_ASSOC);
                            
                                    $req5=$db->prepare("SELECT * FROM prezzo WHERE spettacoloID=? AND tipo='blue'");
                                    $req5->execute([$_GET["id"]]);
                                    $blue=$req5->fetch(PDO::FETCH_ASSOC);

                                    $req=$db->prepare("SELECT * FROM punto_di_vendita WHERE spettacoloID=?");
                                    $req->execute([$_GET['id']]);
                                    $res=$req->fetch(PDO::FETCH_ASSOC);

                                    $req1=$db->prepare("SELECT * FROM riduzione WHERE spettacoloID=?");
                                    $req1->execute([$_GET['id']]);
                                    $res2=$req1->fetch(PDO::FETCH_ASSOC);
                                        
                                    $punto_di_vendita_array=explode(",", $res["nome"]);
                                
                                    $riduzioni_array = explode(",", $res2["tipo"]);
                                ?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<?php include "inc/head.php"; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
.evento-dettaglio-layout {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.menu-sticky {
    position: sticky;
    top: 100px;
    flex: 0 0 200px;
}

.menu-sticky ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.menu-sticky li {
    margin-bottom: 15px;
}

.menu-sticky a {
    text-decoration: none;
    color: #222;
    font-weight: 500;
    transition: all 0.2s ease;
}

.menu-sticky a:hover {
    color: #007bff;
}

.evento-contenuto {
    flex: 1;
}

.evento-top {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    margin-bottom: 40px;
}

.evento-immagine img {
    max-width: 350px;
    width: 100%;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.evento-info h2 {
    font-size: 28px;
    margin-bottom: 10px;
}

.btn-acquista {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background: #000;
    color: white;
    border-radius: 6px;
    text-decoration: none;
}

.blocco-info {
    margin-bottom: 40px;
    background: #f9f9f9;
    padding: 25px;
    border-radius: 8px;
    border: 1px solid #ddd;
}

.blocco-info h3 {
    font-size: 22px;
    margin-bottom: 10px;
}

.blocco-info ul {
    list-style: disc inside;
    padding-left: 10px;
}

.pagamento button {
    margin-right: 15px;
    margin-top: 10px;
}

.event-buttons {
    margin-top: 20px;
}

.btn-success {
    background-color: #28a745;
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-cancel,
.btn-iscriversi,
.btn-register {
    margin-right: 10px;
    padding: 10px 20px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
}

.btn-cancel {
    background: #ccc;
}

.btn-iscriversi {
    background: green;
    color: white;
}

.btn-register {
    background: #ff5722;
    color: white;
}

/* Design desktop par défaut */
.evento-dettaglio-layout {
    display: flex;
    align-items: flex-start;
    gap: 40px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

.menu-sticky {
    position: sticky;
    top: 100px;
    flex: 0 0 200px;
}

.menu-sticky ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.menu-sticky li {
    margin-bottom: 15px;
}

.menu-sticky a {
    text-decoration: none;
    color: #222;
    font-weight: 500;
    transition: all 0.2s ease;
}

.menu-sticky a:hover {
    color: #007bff;
}

.evento-contenuto {
    flex: 1;
}

.evento-top {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    margin-bottom: 40px;
}

.evento-immagine img {
    max-width: 350px;
    width: 100%;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.blocco-info {
    margin-bottom: 40px;
    background: #f9f9f9;
    padding: 25px;
    border-radius: 8px;
    border: 1px solid #ddd;
}

/* ----------------------------------- */
/* Responsive design */
/* ----------------------------------- */

@media screen and (max-width: 768px) {
    .evento-dettaglio-layout {
        flex-direction: column;
        padding: 20px 10px;
    }

    .menu-sticky {
        position: relative;
        top: 0;
        flex: 1;
        width: 100%;
        background: #fff;
        border-bottom: 1px solid #ddd;
        margin-bottom: 20px;
        overflow-x: auto;
    }

    .menu-sticky ul {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        padding: 10px 0;
        gap: 10px;
        overflow-x: auto;
        white-space: nowrap;
    }

    .menu-sticky li {
        margin: 0;
    }

    .menu-sticky a {
        padding: 8px 14px;
        background: #f0f0f0;
        border-radius: 20px;
        font-size: 14px;
    }

    .evento-top {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .evento-info h2 {
        font-size: 22px;
    }

    .btn-acquista {
        margin-top: 15px;
    }

    .evento-immagine img {
        max-width: 100%;
    }
}


</style>


<style>
    /* Layout principal */
.evento-dettaglio-layout {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  padding: 20px;
}

/* Menu sticky */
.menu-sticky {
  position: sticky;
  top: 100px;
  min-width: 220px;
  background-color: #f9f9f9;
  padding: 15px 20px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  height: fit-content;
}

.menu-sticky ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.menu-sticky li {
  margin-bottom: 15px;
}

.menu-sticky a {
  text-decoration: none;
  display: block;
  padding: 10px 15px;
  color: #333;
  font-weight: 500;
  border-radius: 8px;
  transition: 0.3s;
  background-color: #fff;
}

.menu-sticky a:hover,
.menu-sticky a.active {
  background-color: #007bff;
  color: white;
}

/* Contenu */
.evento-contenuto {
  flex: 1;
  min-width: 300px;
}

.blocco-info {
  display: none;
  opacity: 0;
  transition: opacity 0.3s ease;
  margin-bottom: 30px;
}

.blocco-info.active {
  display: block;
  opacity: 1;
}

/* Responsive mobile */
@media (max-width: 768px) {
  .evento-dettaglio-layout {
    flex-direction: column;
  }

  .menu-sticky {
    position: relative;
    width: 100%;
    margin-bottom: 20px;
  }
}

.cart-sidebar {
  position: justify;
  top: 100px;
  background-color: #fff;
  border: 1px solid #eee;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  width: 200px;
  margin-left: 30px;
  height: fit-content;
}

.cart-sidebar h4 {
  font-size: 18px;
  margin-bottom: 15px;
  color: #007bff;
}

.cart-sidebar ul {
  list-style: disc;
  padding-left: 20px;
  margin-top: 10px;
}

@media (max-width: 992px) {
  .cart-sidebar {
    display: block;
    position: relative;
    width: 100%;
    margin: 20px 0;
    top: auto;
  }
}

.pdf-style {
    font-family: 'Segoe UI', sans-serif;
    background: white;
    padding: 30px;
    color: #333;
}

.ticket-container {
    max-width: 800px;
    margin: auto;
    border: 1px solid #ddd;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    background: #fff;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
}

.left {
    flex: 1;
}

.event-title {
    font-size: 22px;
    color: #8e44ad;
}

.event-img {
    width: 140px;
    border-radius: 10px;
    box-shadow: 0 0 8px rgba(0,0,0,0.15);
}

.title {
    font-size: 18;
    color: #2c3e50;
}

.user-info, .info {
    margin-top: 20px;
    font-size: 16px;
}

.posti-section {
    margin-top: 25px;
}

.posti-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-top: 10px;
}

.posto-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #e0e0e0;
    padding: 15px;
    border-radius: 10px;
    background: #f9f9f9;
}

.posto-box img.qr {
    width: 90px;
    height: 90px;
}

.extra-info {
    margin-top: 25px;
}

.extra-info h3 {
    color: #34495e;
    margin-bottom: 10px;
}

.extra-info ul {
    margin-left: 20px;
    padding-left: 10px;
}

.extra-info ul li {
    margin-bottom: 5px;
}

.page-break {
    page-break-before: always;
    break-before: page;
}


</style>



<body id="content">

    <!-- Start Header Area -->
    <header class="header navbar-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-10">
                    <div class="nav-inner">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="evento">
                                <img src="assets/images/logo/logo.png" alt="Logo">
                            </a>
                            <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <?php if(isset($_SESSION['id_account'])): ?>
                                        <li class="nav-item">
                                            <a href="utente/" aria-label="Toggle navigation">DASHBOARD</a>
                                        </li>
                                            <div class="user-notification">
                                                <span class="user-text">👋 <?= htmlspecialchars($_SESSION['nome_utente']); ?> è connesso</span>
                                                <button class="btn-green">✓</button>
                                            </div>
                                    <?php elseif(isset($_SESSION["punto_di_venditaID"])) : ?>
                                        <li class="nav-item">
                                            <a href="punto_di_vendita/" aria-label="Toggle navigation">DASHBOARD</a>
                                        </li>
                                            <div class="user-notification">
                                                <span class="user-text">👋 <?= htmlspecialchars($_SESSION['nome_punto_di_vendita']); ?> è connesso</span>
                                                <button class="btn-green">✓</button>
                                            </div>
                                    <?php else: ?>
                                        <li class="nav-item">
                                            <a href="index" aria-label="Toggle navigation">HOME PAGE</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="login/" aria-label="Toggle navigation">LOGIN</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="login/registrati" aria-label="Toggle navigation">REGISTRATI</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div> 
                            
                        </nav>
                    </div>
                </div>
            </div> 
        </div> 
    </header>
    <!-- End Header Area -->

    <!-- Start Features Area -->
    <section class="features section">
        <div class="container">
                  
    <div class="evento-dettaglio-layout">

    <!-- CONTENU -->
    <div class="evento-contenuto">
 
        <div class="evento-top">
            <div class="evento-immagine">
                <img id="immagine" src="" alt="Immagine dell'evento">
            </div>
            <div class="evento-info">
                <h2 id="titolo"></h2>
                <p><strong><i class="lni lni-map-marker"></i></strong> <span id="luogo"></span></p>
                <p><strong><i class="lni lni-calendar"></i></strong> <span id="data"></span></p>

                <form id="billetForm" action="biglietto.php" method="get">
                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                    <button type="submit" id="generatePDF" class="btn-iscriversi">Conferma e paga</button>
                </form>
 <br>
                        <a href="evento?id=<?= $_GET["id"]; ?>" class="btn-register">Torna alla scheda spettacolo</a>

                <div id="pdf-content" style="display: none;" class="pdf-style">
                    <div class="ticket-container">

                         <!-- Infos client -->
                        <div class="user-info">
                            <p><strong>👤 Nome:</strong> <?php echo $_SESSION['nome_utente']; ?></p>
                            <p><strong>📧 Indirizzo mail:</strong> <?php echo $_SESSION['indirizzo_mail']; ?></p> <br>
                            <h1 class="title" style="font-size:10px">🎟️ Biglietto per lo spettacolo</h1>
                            <h2 id="pdf-titolo" class="event-title"></h2>
                        </div>

                        <!-- En-tête : Titre + image -->
                       
                        <div class="header">
                            <div class="right">
                                <img src="URL_DE_L_IMAGE_DU_SPECTACLE" alt="Image événement" class="event-img">
                            </div>
                        </div>


                        <!-- Infos événement -->
                        <div class="info">
                            <p><strong>📍 Luogo:</strong> <span id="pdf-luogo"></span></p>
                            <p><strong>📅 </strong> <span id="pdf-data"></span></p>
                        </div>
                        
                        <div class="info">
                        <h5 style="color: #1e88e5;">💳 Pagamento con PagoPA</h3>
                            <p>Scansiona il codice per completare il pagamento:</p> <br>
                             <div style="text-align:center" id="pagoPA"></div>
                        </div>
                                    <br>
                        <!-- Points de vente -->
                        <div class="extra-info">
                            <h5>📍 Punti di vendita associati:</h3>
                            <ul>
                                <?php foreach($punto_di_vendita_array as $punto_di_vendita): ?>
                                    <li><?= $punto_di_vendita; ?></li>
                                <?php endforeach; ?>                          
                            </ul>
                        </div>
                        <br> <br>

                          <!-- Réductions -->
                          <div class="extra-info">
                            <h5>💸 Riduzioni disponibili:</h3>
                            <ul>
                                <?php foreach($riduzioni_array as $riduzione): ?>
                                    <li><?= $riduzione; ?></li>
                                <?php endforeach; ?>
                            </ul>
                            </div>

                        <div class="page-break"></div> <br> <br> <br>

                        <!-- Postes sélectionnés -->
                        <div class="posti-section">

                            <h4>🪑 Posti selezionati:</h3>
                            <div id="pdf-posti" class="posti-list">
                           
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>

       
    </div>
            <!-- PANIER STICKY A DROITE -->
            <aside class="cart-sidebar">
                <h4><i class="fas fa-shopping-cart"></i> Riepilogo</h4>
                <p><strong>Posti selezionati:</strong> <span id="quantitaPosti">0</span></p>
                <p><strong>Prezzo totale:</strong> € <span id="prezzoTotale">0.00</span></p>
                <ul id="listaPosti"></ul>
            </aside>
                   
            </div>
        </div>
    </section>
 
    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>
    

    <!-- ========================= JS here ========================= -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/tiny-slider.js"></script>
    <script src="assets/js/glightbox.min.js"></script>
    <script src="assets/js/count-up.min.js"></script>
    <script src="assets/js/main.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <!-- html2canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <!-- QRCode.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <!-- JsBarcode -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

    <script type="module">
    
    function generateUniqueKey() {
        return 'xxxxxxxxyxxxxxxx'.replace(/[xy]/g, function (c) {
            const r = Math.random() * 16 | 0;
            return r.toString(16);
        });
    }
  
    const chiave = generateUniqueKey();

    import html2canvas from "https://cdn.skypack.dev/html2canvas";
    import { jsPDF } from "https://cdn.skypack.dev/jspdf";

    function generatePDF(){
        
        const posti = JSON.parse(localStorage.getItem("postiSelezionati")) || [];
        if (posti.length === 0) {
            alert("Nessun posto selezionato.");
            return;
        }

        document.getElementById("pdf-titolo").innerText = document.getElementById("titolo").innerText;
        document.getElementById("pdf-luogo").innerText = document.getElementById("luogo").innerText;
        document.getElementById("pdf-data").innerText = document.getElementById("data").innerText;
       
        new QRCode(document.getElementById("pagoPA"), {
            text: "https://tusito.it/valida?id=test123",
            width: 100,
            height: 100
         });

         const pdfPosti = document.getElementById("pdf-posti");
        pdfPosti.innerHTML = "";

        posti.forEach((posto, index) => {
            const wrapper = document.createElement("div");
            wrapper.style.display = "flex";
            wrapper.style.alignItems = "right";
            wrapper.style.marginBottom = "10px";

            const info = document.createElement("p");
            info.innerText = `Posto : ${posto.id}`;
            info.style.marginRight = "20px";

            const qrDiv = document.createElement("div");
            qrDiv.id = `qr-${index}`;
            qrDiv.style.width = "80px";
            qrDiv.style.height = "80px";

            wrapper.appendChild(info);
            wrapper.appendChild(qrDiv);
            pdfPosti.appendChild(wrapper);

            new QRCode(qrDiv, {
                text: `controllo?id=${chiave}&posto=${posto.id}`, // lien unique de validation
                width: 70,
                height: 70
            });
        });

        setTimeout(() => {
            const pdfContainer = document.getElementById("pdf-content");
            pdfContainer.style.display = "block";

            html2canvas(pdfContainer, { scale: 2 }).then(canvas => {
                const imgData = canvas.toDataURL("image/png");
                const pdf = new jsPDF("p", "mm", "a4");

                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = pdf.internal.pageSize.getHeight();

                const canvasWidth = canvas.width;
                const canvasHeight = canvas.height;

                const imgHeight = (pdfWidth * canvasHeight) / canvasWidth;
                const totalPDFPages = Math.ceil(imgHeight / pdfHeight);

                for (let page = 0; page < totalPDFPages; page++) {
                    const position = -page * pdfHeight;

                    if (page > 0) {
                        pdf.addPage();
                    }

                    pdf.addImage(
                        imgData,
                        "PNG",
                        0,
                        position,
                        pdfWidth,
                        imgHeight
                    );
                }

                pdf.save("riepilogo_biglietto.pdf");
                pdfContainer.style.display = "none";
            });
        }, 500);

        setTimeout(()=>{window.location.href="utente/"}, 10000);
    }

    document.getElementById("billetForm").addEventListener("submit", function (e) {
        e.preventDefault(); 
       

        const utenteID = <?php echo json_encode($_SESSION['id_account']); ?>;
        const spettacoloID = urlParams.get("id");
        const posti = JSON.parse(localStorage.getItem("postiSelezionati")) || [];

        const prezzi = {
            black: <?= $black['importo']; ?>,
            gold: <?= $gold['importo']; ?>,
            orange: <?= $orange['importo']; ?>,
            darkgray: <?= $darkgray['importo']; ?>,
            blue: <?= $blue['importo']; ?>
        };
        let totale = 0;

        posti.forEach(posto => {
            if (prezzi[posto.tipo]) {
                totale += parseFloat(prezzi[posto.tipo]);
            }
        });

        const dat=document.getElementById("data").textContent;
        const luogo=document.getElementById("luogo").textContent;

        console.log(dat);

        fetch("api/biglietto.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                citta:luogo,
                tipo:dat,
                id_biglietto:chiave,
                utente_id: utenteID,
                spettacolo_id: spettacoloID,
                posti: posti,
                prezzo:totale
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                generatePDF(); 
                alert("Il pagamento è stato effettuato con successo !");
                document.getElementById("generatePDF").style.display=none;
            } else {
                alert("Erreur : " + (data.message || "Problema durante il salvataggio del biglietto"));
            }
        })
        .catch(error => {
            console.error("Errore durante l'invio dei dati:", error);
        });
    });

</script>


<script>

    const prezzi = {
        black: <?= $black['importo']; ?>,
        gold: <?= $gold['importo']; ?>,
        orange: <?= $orange['importo']; ?>,
        darkgray: <?= $darkgray['importo']; ?>,
        blue: <?= $blue['importo']; ?>
    };

    function aggiornaCarrello() {
        const posti = JSON.parse(localStorage.getItem("postiSelezionati")) || [];

        console.log(posti);

        let totale = 0;

        posti.forEach(posto => {
            if (prezzi[posto.tipo]) {
                totale += parseFloat(prezzi[posto.tipo]);
            }
        });

        document.getElementById("quantitaPosti").innerText = posti.length;
        document.getElementById("prezzoTotale").innerText = totale.toFixed(2);

        const lista = document.getElementById("listaPosti");
        if (lista) {
            lista.innerHTML = "";
            posti.forEach(posto => {
                const li = document.createElement("li");
                li.innerText = `Posto : ${posto.id} - €${prezzi[posto.tipo].toFixed(2)}`;
                lista.appendChild(li);
            });
        }
    }

        aggiornaCarrello();
    </script>


    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const eventId = urlParams.get("id");

        if (!eventId) {
            alert("Nessun evento trovato !");
            window.location.href = "evento";
        } else {
            fetch(`api/index.php?id=${eventId}&op=show_evento`)
                .then(response => response.json())
                .then(data => {
                    if (!data || data.success === false) {
                        alert("Spettacolo non trovato !");
                        window.location.href = "evento";
                        return;
                    }

                    let event = data[0];

                    document.getElementById("titolo").textContent = event.titolo_spettacolo ?? "Senza titolo";
                    document.getElementById("immagine").src = event.immagine ? `img/${event.immagine}` : "img/default.jpg";
                    document.getElementById("data").textContent = event.data_e_ora_spettacolo ? event.data_e_ora_spettacolo : "ABBONAMENTO";
                    document.getElementById("luogo").textContent = event.sala_citta_luogo ?? "Luogo sconosciuto";
                    document.getElementById("descrizione").innerHTML = event.descrizione;

                    document.querySelector(".btn-iscriversi").setAttribute("data-id", event.spettacoloID);
                })
                .catch(error => console.error("Errore:", error));
        }

     </script>



    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const closeButton = document.querySelector(".btn-green");
        if (closeButton) {
            closeButton.addEventListener("click", function () {
                document.querySelector(".user-notification").style.display = "none";
            });
        }
    });
    </script>
    
<script>
document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('.menu-sticky a');
    const sections = document.querySelectorAll('.blocco-info');

    // Active la première section
    sections[0].classList.add('active');
    links[0].classList.add('active');

    links.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            // Gère l'état actif
            links.forEach(l => l.classList.remove('active'));
            this.classList.add('active');

            // Masque toutes les sections
            sections.forEach(section => section.classList.remove('active'));

            // Affiche la section ciblée
            const targetId = this.getAttribute('href').substring(1);
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                targetSection.classList.add('active');

                // Scroll ajusté
                const yOffset = -80;
                const y = targetSection.getBoundingClientRect().top + window.scrollY + yOffset;
                window.scrollTo({ top: y, behavior: 'smooth' });
            }
        });
    });
});
</script>

<script>
function updateCartSidebar() {
    const quantita = document.getElementById('quantitaPosti')?.textContent || '0';
    const totale = document.getElementById('prezzoTotale')?.textContent || '0.00';
    const lista = document.getElementById('listaPosti')?.innerHTML || '';

    document.getElementById('cart-quantitaPosti').textContent = quantita;
    document.getElementById('cart-prezzoTotale').textContent = totale;
    document.getElementById('cart-listaPosti').innerHTML = lista;
}

// Rafraîchir automatiquement le panier toutes les secondes (ou à chaque ajout de siège si tu veux lier à un événement)
setInterval(updateCartSidebar, 1000);
</script>



</body>

</html>

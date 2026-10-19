

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mappa dei Posti del Teatro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #101130;
        }

        .canvas-container {
            position: relative;
            overflow: hidden;
            border: 2px solid #ccc;
            border-radius: 10px;
            background-color: white;
        }

        canvas {
            display: block;
            cursor: grab;
        }

        .controls {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .controls button {
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #confirmSelection {
            display: block;
            margin: 20px auto;
            padding: 15px 30px;
            font-size: 18px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        } 

        #annulla {
            display: block;
            margin: 20px auto;
            padding: 15px 30px;
            font-size: 18px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #confirmSelection:hover {
            background-color: #0056b3;
        }

        .controls-container {
    display: flex;
    flex-direction: row; /* Disposizione orizzontale */
    align-items: center;
    justify-content: space-between; /* Separa legenda e bottone */
    width: 100%;
    padding: 10px;
    flex-wrap: wrap; /* Permette di adattarsi a schermi piccoli */
}

.legend {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap; /* Rende la legenda adattabile su schermi piccoli */
    align-items: center;
    gap: 8px; /* Spazio tra gli elementi */
    padding: 10px;
    background: white;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    max-width: 70%; /* Occupa solo il necessario senza sovrapporsi */
}

.legend-item {
    display: flex;
    align-items: center;
    font-size: 16px;
    margin-right: 15px;
}

.color-box {
    width: 20px;
    height: 20px;
    display: inline-block;
    margin-right: 5px;
    border-radius: 5px;
    border: 1px solid black;
}

#confirmSelection {
    padding: 10px 20px;
    font-size: 18px;
    background-color: blue;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}



/* 🔹 Responsività per dispositivi mobili */
@media (max-width: 768px) {
    .controls-container {
        flex-direction: column; /* Disposizione verticale su schermi piccoli */
        align-items: center;
    }

    .legend {
        max-width: 100%;
        justify-content: center; /* Centrata su mobile */
        text-align: center;
    }
}




    </style>
</head>
<body>
    <div class="controls">
        <button id="zoomIn">Zoom +</button>
        <button id="zoomOut">Zoom -</button>
        <button id="reset">Reset</button>
    </div>

    <div class="canvas-container">
        <canvas id="TCBOmap" width="1531" height="1030"></canvas>
    </div>



    <div class="controls-container">
    <button id="confirmSelection">Prenota</button>

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

    ?>
    
    <div class="legend">
         <div class="legend-item"><span class="color-box" style="background: green;"></span>Posto selezionato</div>
    </div>
    <div class="legend">
        <div class="legend-item"><span class="color-box" style="background: black;"></span>Fila - €<?= $black['importo']; ?></div>
        <div class="legend-item"><span class="color-box" style="background: gold;"></span>Palco - €<?= $gold['importo']; ?></div>
        <div class="legend-item"><span class="color-box" style="background: orange;"></span>Proscenio - €<?= $orange['importo']; ?></div>
        <div class="legend-item"><span class="color-box" style="background: darkgray;"></span>Lunetta - €<?= $darkgray['importo']; ?></div>
        <div class="legend-item"><span class="color-box" style="background: blue;"></span>Loggione - €<?= $blue['importo']; ?></div>
    </div>
    <div class="legend">
         <div class="legend-item"><span class="color-box" style="background: red;"></span>Posto non disponibile</div>
    </div>
    <a style="background-color:red" id="confirmSelection" href="show_evento?id=<?= $_GET['id']; ?>">Annulla</a>  


</div>


    <script>

       

        document.addEventListener("DOMContentLoaded", () => {
            const canvas = document.getElementById("TCBOmap");
            const ctx = canvas.getContext("2d");
            const canvasContainer = document.querySelector(".canvas-container");

            let zoomLevel = 1;
            const zoomStep = 0.1;
            const minZoom = 0.5;
            const maxZoom = 2.5;

            let isDragging = false;
            let startX, startY, offsetX = 0, offsetY = 0;

           
            const posto = <?php echo json_encode(array_map(function($p) {
                return [$p['nome'], (int)$p['x'], (int)$p['y'], $p['disponibilita']];
            }, $posti)); ?>;
           

            const originalColors = {}; 
            posto.forEach(seat => originalColors[seat[0]] = seat[3]); 



            function drawSeats() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.save();
                ctx.translate(offsetX, offsetY);
                ctx.scale(zoomLevel, zoomLevel);
                
                posto.forEach(([id, x, y, color]) => {
                    ctx.fillStyle = color;
                    ctx.beginPath();
                    ctx.arc(x, y, 6, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.strokeStyle = "black";
                    ctx.stroke();
                    ctx.closePath();
                });

                ctx.restore();
            }

            canvas.addEventListener("click", (event) => {
                const rect = canvas.getBoundingClientRect();
                const x = (event.clientX - rect.left - offsetX) / zoomLevel;
                const y = (event.clientY - rect.top - offsetY) / zoomLevel;

                posto.forEach(seat => {
                    const [id, seatX, seatY, color] = seat;
                    const distance = Math.sqrt((x - seatX) ** 2 + (y - seatY) ** 2);
                    if (distance < 10) {
                        if (["black", "gold", "darkgray", "orange", "blue"].includes(seat[3])) {
                            seat[3]="green";
                        }else if (seat[3] === "green") {
                             seat[3] = originalColors[id]; // Torna al colore originale
                          }                        
                        drawSeats();
                    }
                });
            });

            function zoomIn() {
                if (zoomLevel < maxZoom) {
                    zoomLevel += zoomStep;
                    drawSeats();
                }
            }

            function zoomOut() {
                if (zoomLevel > minZoom) {
                    zoomLevel -= zoomStep;
                    drawSeats();
                }
            }

            function resetView() {
                zoomLevel = 1;
                offsetX = 0;
                offsetY = 0;
                drawSeats();
            }

            document.getElementById("zoomIn").addEventListener("click", zoomIn);
            document.getElementById("zoomOut").addEventListener("click", zoomOut);
            document.getElementById("reset").addEventListener("click", resetView);

            canvas.addEventListener("mousedown", (event) => {
                isDragging = true;
                startX = event.clientX - offsetX;
                startY = event.clientY - offsetY;
            });

            canvas.addEventListener("mousemove", (event) => {
                if (isDragging) {
                    offsetX = event.clientX - startX;
                    offsetY = event.clientY - startY;
                    drawSeats();
                }
            });

            canvas.addEventListener("mouseup", () => isDragging = false);
            canvas.addEventListener("mouseleave", () => isDragging = false);

            document.getElementById("confirmSelection").addEventListener("click", () => {
                const selectedSeats = posto
                .filter(seat => seat[3] === "green")
                .map(seat => {
                    return {
                        id: seat[0],         // nom du poste, ex: "fila_V_2"
                        tipo: originalColors[seat[0]] // ex: "gold", "black", etc.
                    };
                });

                const nomiPosti = selectedSeats.map(p => p.id);
               
                if (selectedSeats.length) {
                    localStorage.setItem("postiSelezionati", JSON.stringify(selectedSeats));
                    alert(`Hai selezionato: ${nomiPosti.join(", ")}`);
                    window.location.href = "show_evento?id=<?= $_GET['id']; ?>";
                } else {
                    alert("Nessun posto selezionato");
                }
            });

            drawSeats();
        });
    </script>
</body>
</html>

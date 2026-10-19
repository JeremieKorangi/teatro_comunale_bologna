<?php
    require "inc/sessione.php";
    attivazione_sessione("nome_admin");
?>

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
    align-items: right;
    gap: 8px; /* Spazio tra gli elementi */
    padding: 10px;
    background: white;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    max-width: 70%; /* Occupa solo il necessario senza sovrapporsi */
}

.legend-item {
    display: flex;
    align-items: right;
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
    <a href="index" id=confirmSelection>
          HOME PAGE
</a>

    <?php
        require '../api/database.php';

        $jey=$db->prepare("SELECT 
        p.nome,
        p.x,
        p.y,
        p.disponibilita,
        b.Ora_controllo_accessi
    FROM posto p
    LEFT JOIN biglietto b 
        ON b.posto_biglietto = p.nome 
        AND b.spettacolo = p.spettacoloID
    WHERE p.spettacoloID = ?");
        $jey->execute([$_GET['id']]);
        $posti=$jey->fetchAll(PDO::FETCH_ASSOC);

    ?>
    
    <div class="legend">
         <div class="legend-item"><span class="color-box" style="background: red;"></span>Posto controllato</div>
    </div> 
   
    <a style="background-color:red" id="confirmSelection" href="controllo_ora_accesso?op=<?= $_GET['op']; ?>">Annulla</a>  

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
                $color = (!is_null($p['Ora_controllo_accessi'])) ? 'red' : 'white';
                return [$p['nome'], (int)$p['x'], (int)$p['y'], $color];
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

         

            drawSeats();
        });
    </script>
</body>
</html>

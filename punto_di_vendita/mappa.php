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

    <div class="legend">
        <div class="legend-item"><span class="color-box" style="background: black;"></span>Fila - €30</div>
        <div class="legend-item"><span class="color-box" style="background: gold;"></span>Palco - €50</div>
        <div class="legend-item"><span class="color-box" style="background: orange;"></span>Proscenio - €40</div>
        <div class="legend-item"><span class="color-box" style="background: gray;"></span>Lunetta - €35</div>
        <div class="legend-item"><span class="color-box" style="background: blue;"></span>Loggione - €20</div>
    </div>
    <button style="background-color:red" id="confirmSelection">Annulla</button>


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

            const posto = [
            ["fila_A_24",1002,909,"white"],
            ["fila_A_22",977,909,"white"],
            ["fila_A_20",952,909,"white"],
            ["fila_A_18",927,909,"white"],
            ["fila_A_16",901,909,"white"],
            ["fila_A_14",876,909,"white"],
            ["fila_A_12",851,909,"white"],
            ["fila_A_10",826,909,"white"],
            ["fila_A_8",801,909,"white"],
            ["fila_A_6",776,909,"white"],
            ["fila_A_4",751,909,"white"],
            ["fila_A_2",726,909,"white"],
            ["fila_A_25",650,909,"white"],
            ["fila_A_23",625,909,"white"],
            ["fila_A_21",600,909,"white"],
            ["fila_A_19",575,909,"white"],
            ["fila_A_17",550,909,"white"],
            ["fila_A_15",524,909,"white"],
            ["fila_A_13",499,909,"white"],
            ["fila_A_11",474,909,"white"],
            ["fila_A_9",449,909,"white"],
            ["fila_A_7",424,909,"white"],
            ["fila_A_5",399,909,"white"],
            ["fila_A_3",374,909,"white"],
            ["fila_B_26",1027,884,"white"],
            ["fila_B_24",1002,884,"white"],
            ["fila_B_22",977,884,"white"],
            ["fila_B_20",952,884,"white"],
            ["fila_B_18",927,884,"white"],
            ["fila_B_16",901,884,"white"],
            ["fila_B_14",876,884,"white"],
            ["fila_B_12",851,884,"white"],
            ["fila_B_10",826,884,"white"],
            ["fila_B_8",801,884,"white"],
            ["fila_B_6",776,884,"white"],
            ["fila_B_4",751,884,"white"],
            ["fila_B_2",726,884,"white"],
            ["fila_B_25",650,884,"white"],
            ["fila_B_23",625,884,"white"],
            ["fila_B_21",600,884,"white"],
            ["fila_B_19",575,884,"white"],
            ["fila_B_17",550,884,"white"],
            ["fila_B_15",524,884,"white"],
            ["fila_B_13",499,884,"white"],
            ["fila_B_11",474,884,"white"],
            ["fila_B_9",449,884,"white"],
            ["fila_B_7",424,884,"white"],
            ["fila_B_5",399,884,"white"],
            ["fila_B_3",374,884,"white"],
            ["fila_B_1",349,884,"white"],
            ["fila_C_26",1027,859,"white"],
            ["fila_C_24",1002,859,"white"],
            ["fila_C_22",977,859,"white"],
            ["fila_C_20",952,859,"white"],
            ["fila_C_18",926,859,"white"],
            ["fila_C_16",901,859,"white"],
            ["fila_C_14",876,859,"white"],
            ["fila_C_12",851,859,"white"],
            ["fila_C_10",826,859,"white"],
            ["fila_C_8",801,859,"white"],
            ["fila_C_6",776,859,"white"],
            ["fila_C_4",751,859,"white"],
            ["fila_C_2",726,859,"white"],
            ["fila_C_25",650,859,"white"],
            ["fila_C_23",625,859,"white"],
            ["fila_C_21",600,859,"white"],
            ["fila_C_19",575,859,"white"],
            ["fila_C_17",550,859,"white"],
            ["fila_C_15",524,859,"white"],
            ["fila_C_13",499,859,"white"],
            ["fila_C_11",474,859,"white"],
            ["fila_C_9",449,859,"white"],
            ["fila_C_7",424,859,"white"],
            ["fila_C_5",399,859,"white"],
            ["fila_C_3",374,859,"white"],
            ["fila_C_1",349,859,"white"],
            ["fila_D_26",1027,834,"white"],
            ["fila_D_24",1002,834,"white"],
            ["fila_D_22",977,834,"white"],
            ["fila_D_20",952,834,"white"],
            ["fila_D_18",927,834,"white"],
            ["fila_D_16",901,834,"white"],
            ["fila_D_14",876,834,"white"],
            ["fila_D_12",851,834,"white"],
            ["fila_D_10",826,834,"white"],
            ["fila_D_8",801,834,"white"],
            ["fila_D_6",776,834,"white"],
            ["fila_D_4",751,834,"white"],
            ["fila_D_2",726,834,"white"],
            ["fila_D_25",650,834,"white"],
            ["fila_D_23",625,834,"white"],
            ["fila_D_21",600,834,"white"],
            ["fila_D_19",575,834,"white"],
            ["fila_D_17",549,834,"white"],
            ["fila_D_15",524,834,"white"],
            ["fila_D_13",499,834,"white"],
            ["fila_D_11",474,834,"white"],
            ["fila_D_9",449,834,"white"],
            ["fila_D_7",424,834,"white"],
            ["fila_D_5",399,834,"white"],
            ["fila_D_3",374,834,"white"],
            ["fila_D_1",349,834,"white"],
            ["fila_E_24",1002,808,"white"],
            ["fila_E_22",977,808,"white"],
            ["fila_E_20",952,808,"white"],
            ["fila_E_18",927,808,"white"],
            ["fila_E_16",901,808,"white"],
            ["fila_E_14",876,808,"white"],
            ["fila_E_12",851,808,"white"],
            ["fila_E_10",826,808,"white"],
            ["fila_E_8",801,808,"white"],
            ["fila_E_6",776,808,"white"],
            ["fila_E_4",751,808,"white"],
            ["fila_E_2",726,808,"white"],
            ["fila_E_25",650,808,"white"],
            ["fila_E_23",625,808,"white"],
            ["fila_E_21",600,808,"white"],
            ["fila_E_19",575,808,"white"],
            ["fila_E_17",549,808,"white"],
            ["fila_E_15",524,808,"white"],
            ["fila_E_13",499,808,"white"],
            ["fila_E_11",474,808,"white"],
            ["fila_E_9",449,808,"white"],
            ["fila_E_7",424,808,"white"],
            ["fila_E_5",399,808,"white"],
            ["fila_E_3",374,808,"white"],
            ["fila_F_24",1002,783,"white"],
            ["fila_F_22",977,783,"white"],
            ["fila_F_20",952,783,"white"],
            ["fila_F_18",927,783,"white"],
            ["fila_F_16",901,783,"white"],
            ["fila_F_14",876,783,"white"],
            ["fila_F_12",851,783,"white"],
            ["fila_F_10",826,783,"white"],
            ["fila_F_8",801,783,"white"],
            ["fila_F_6",776,783,"white"],
            ["fila_F_4",751,783,"white"],
            ["fila_F_2",726,783,"white"],
            ["fila_F_25",650,783,"white"],
            ["fila_F_23",625,783,"white"],
            ["fila_F_21",600,783,"white"],
            ["fila_F_19",575,783,"white"],
            ["fila_F_17",550,783,"white"],
            ["fila_F_15",524,783,"white"],
            ["fila_F_13",499,783,"white"],
            ["fila_F_11",474,783,"white"],
            ["fila_F_9",449,783,"white"],
            ["fila_F_7",424,783,"white"],
            ["fila_F_5",399,783,"white"],
            ["fila_F_3",374,783,"white"],
            ["fila_G_24",1002,758,"white"],
            ["fila_G_22",977,758,"white"],
            ["fila_G_20",952,758,"white"],
            ["fila_G_18",926,758,"white"],
            ["fila_G_16",901,758,"white"],
            ["fila_G_14",876,758,"white"],
            ["fila_G_12",851,758,"white"],
            ["fila_G_10",826,758,"white"],
            ["fila_G_8",801,758,"white"],
            ["fila_G_6",776,758,"white"],
            ["fila_G_4",751,758,"white"],
            ["fila_G_2",726,758,"white"],
            ["fila_G_25",650,758,"white"],
            ["fila_G_23",625,758,"white"],
            ["fila_G_21",600,758,"white"],
            ["fila_G_19",575,758,"white"],
            ["fila_G_17",550,758,"white"],
            ["fila_G_15",524,758,"white"],
            ["fila_G_13",499,758,"white"],
            ["fila_G_11",474,758,"white"],
            ["fila_G_9",449,758,"white"],
            ["fila_G_7",424,758,"white"],
            ["fila_G_5",399,758,"white"],
            ["fila_G_3",374,758,"white"],
            ["fila_H_24",1002,733,"white"],
            ["fila_H_22",977,733,"white"],
            ["fila_H_20",952,733,"white"],
            ["fila_H_18",926,733,"white"],
            ["fila_H_16",901,733,"white"],
            ["fila_H_14",876,733,"white"],
            ["fila_H_12",851,733,"white"],
            ["fila_H_10",826,733,"white"],
            ["fila_H_8",801,733,"white"],
            ["fila_H_6",776,733,"white"],
            ["fila_H_4",751,733,"white"],
            ["fila_H_2",726,733,"white"],
            ["fila_H_25",650,733,"white"],
            ["fila_H_23",625,733,"white"],
            ["fila_H_21",600,733,"white"],
            ["fila_H_19",575,733,"white"],
            ["fila_H_17",549,733,"white"],
            ["fila_H_15",524,733,"white"],
            ["fila_H_13",499,733,"white"],
            ["fila_H_11",474,733,"white"],
            ["fila_H_9",449,733,"white"],
            ["fila_H_7",424,733,"white"],
            ["fila_H_5",399,733,"white"],
            ["fila_H_3",374,733,"white"],
            ["fila_I_24",1002,708,"white"],
            ["fila_I_22",977,708,"white"],
            ["fila_I_20",952,708,"white"],
            ["fila_I_18",926,708,"white"],
            ["fila_I_16",901,708,"white"],
            ["fila_I_14",876,708,"white"],
            ["fila_I_12",851,708,"white"],
            ["fila_I_10",826,708,"white"],
            ["fila_I_8",801,708,"white"],
            ["fila_I_6",776,708,"white"],
            ["fila_I_4",751,708,"white"],
            ["fila_I_2",726,708,"white"],
            ["fila_I_25",650,708,"white"],
            ["fila_I_23",625,708,"white"],
            ["fila_I_21",600,708,"white"],
            ["fila_I_19",575,708,"white"],
            ["fila_I_17",549,708,"white"],
            ["fila_I_15",524,708,"white"],
            ["fila_I_13",499,708,"white"],
            ["fila_I_11",474,708,"white"],
            ["fila_I_9",449,708,"white"],
            ["fila_I_7",424,708,"white"],
            ["fila_I_5",399,708,"white"],
            ["fila_I_3",374,708,"white"],
            ["fila_L_24",1002,683,"white"],
            ["fila_L_22",977,683,"white"],
            ["fila_L_20",952,683,"white"],
            ["fila_L_18",927,683,"white"],
            ["fila_L_16",901,683,"white"],
            ["fila_L_14",876,683,"white"],
            ["fila_L_12",851,683,"white"],
            ["fila_L_10",826,683,"white"],
            ["fila_L_8",801,683,"white"],
            ["fila_L_6",776,683,"white"],
            ["fila_L_4",751,683,"white"],
            ["fila_L_2",726,683,"white"],
            ["fila_L_25",650,683,"white"],
            ["fila_L_23",625,683,"white"],
            ["fila_L_21",600,683,"white"],
            ["fila_L_19",575,683,"white"],
            ["fila_L_17",550,683,"white"],
            ["fila_L_15",524,683,"white"],
            ["fila_L_13",499,683,"white"],
            ["fila_L_11",474,683,"white"],
            ["fila_L_9",449,683,"white"],
            ["fila_L_7",424,683,"white"],
            ["fila_L_5",399,683,"white"],
            ["fila_L_3",374,683,"white"],
            ["fila_M_24",1002,658,"white"],
            ["fila_M_22",977,658,"white"],
            ["fila_M_20",952,658,"white"],
            ["fila_M_18",926,658,"white"],
            ["fila_M_16",901,658,"white"],
            ["fila_M_14",876,658,"white"],
            ["fila_M_12",851,658,"white"],
            ["fila_M_10",826,658,"white"],
            ["fila_M_8",801,658,"white"],
            ["fila_M_6",776,658,"white"],
            ["fila_M_4",751,658,"white"],
            ["fila_M_2",726,658,"white"],
            ["fila_M_25",650,658,"white"],
            ["fila_M_23",625,658,"white"],
            ["fila_M_21",600,658,"white"],
            ["fila_M_19",575,658,"white"],
            ["fila_M_17",549,658,"white"],
            ["fila_M_15",524,658,"white"],
            ["fila_M_13",499,658,"white"],
            ["fila_M_11",474,658,"white"],
            ["fila_M_9",449,658,"white"],
            ["fila_M_7",424,658,"white"],
            ["fila_M_5",399,658,"white"],
            ["fila_M_3",374,658,"white"],
            ["fila_N_22",977,582,"white"],
            ["fila_N_20",952,582,"white"],
            ["fila_N_18",926,582,"white"],
            ["fila_N_16",901,582,"white"],
            ["fila_N_14",876,582,"white"],
            ["fila_N_12",851,582,"white"],
            ["fila_N_10",826,582,"white"],
            ["fila_N_8",801,582,"white"],
            ["fila_N_6",776,582,"white"],
            ["fila_N_4",751,582,"white"],
            ["fila_N_2",726,582,"white"],
            ["fila_N_25",650,582,"white"],
            ["fila_N_23",625,582,"white"],
            ["fila_N_21",600,582,"white"],
            ["fila_N_19",575,582,"white"],
            ["fila_N_17",549,582,"white"],
            ["fila_N_15",524,582,"white"],
            ["fila_N_13",499,582,"white"],
            ["fila_N_11",474,582,"white"],
            ["fila_N_9",449,582,"white"],
            ["fila_N_7",424,582,"white"],
            ["fila_N_5",399,582,"white"],
            ["fila_O_22",977,557,"white"],
            ["fila_O_20",952,557,"white"],
            ["fila_O_18",927,557,"white"],
            ["fila_O_16",901,557,"white"],
            ["fila_O_14",876,557,"white"],
            ["fila_O_12",851,557,"white"],
            ["fila_O_10",826,557,"white"],
            ["fila_O_8",801,557,"white"],
            ["fila_O_6",776,557,"white"],
            ["fila_O_4",751,557,"white"],
            ["fila_O_2",726,557,"white"],
            ["fila_O_25",650,557,"white"],
            ["fila_O_23",625,557,"white"],
            ["fila_O_21",600,557,"white"],
            ["fila_O_19",575,557,"white"],
            ["fila_O_17",550,557,"white"],
            ["fila_O_15",524,557,"white"],
            ["fila_O_13",499,557,"white"],
            ["fila_O_11",474,557,"white"],
            ["fila_O_9",449,557,"white"],
            ["fila_O_7",424,557,"white"],
            ["fila_O_5",399,557,"white"],
            ["fila_P_22",977,532,"white"],
            ["fila_P_20",952,532,"white"],
            ["fila_P_18",927,532,"white"],
            ["fila_P_16",901,532,"white"],
            ["fila_P_14",876,532,"white"],
            ["fila_P_12",851,532,"white"],
            ["fila_P_10",826,532,"white"],
            ["fila_P_8",801,532,"white"],
            ["fila_P_6",776,532,"white"],
            ["fila_P_4",751,532,"white"],
            ["fila_P_2",726,532,"white"],
            ["fila_P_25",650,532,"white"],
            ["fila_P_23",625,532,"white"],
            ["fila_P_21",600,532,"white"],
            ["fila_P_19",575,532,"white"],
            ["fila_P_17",550,532,"white"],
            ["fila_P_15",524,532,"white"],
            ["fila_P_13",499,532,"white"],
            ["fila_P_11",474,532,"white"],
            ["fila_P_9",449,532,"white"],
            ["fila_P_7",424,532,"white"],
            ["fila_P_5",399,532,"white"],
            ["fila_Q_22",977,507,"white"],
            ["fila_Q_20",952,507,"white"],
            ["fila_Q_18",926,507,"white"],
            ["fila_Q_16",901,507,"white"],
            ["fila_Q_14",876,507,"white"],
            ["fila_Q_12",851,507,"white"],
            ["fila_Q_10",826,507,"white"],
            ["fila_Q_8",801,507,"white"],
            ["fila_Q_6",776,507,"white"],
            ["fila_Q_4",751,507,"white"],
            ["fila_Q_2",726,507,"white"],
            ["fila_Q_25",650,507,"white"],
            ["fila_Q_23",625,507,"white"],
            ["fila_Q_21",600,507,"white"],
            ["fila_Q_19",575,507,"white"],
            ["fila_Q_17",549,507,"white"],
            ["fila_Q_15",524,507,"white"],
            ["fila_Q_13",499,507,"white"],
            ["fila_Q_11",474,507,"white"],
            ["fila_Q_9",449,507,"white"],
            ["fila_Q_7",424,507,"white"],
            ["fila_Q_5",399,507,"white"],
            ["fila_R_22",977,482,"white"],
            ["fila_R_20",952,482,"white"],
            ["fila_R_18",927,482,"white"],
            ["fila_R_16",901,482,"white"],
            ["fila_R_14",876,482,"white"],
            ["fila_R_12",851,482,"white"],
            ["fila_R_10",826,482,"white"],
            ["fila_R_8",801,482,"white"],
            ["fila_R_6",776,482,"white"],
            ["fila_R_4",751,482,"white"],
            ["fila_R_2",726,482,"white"],
            ["fila_R_25",650,482,"white"],
            ["fila_R_23",625,482,"white"],
            ["fila_R_21",600,482,"white"],
            ["fila_R_19",575,482,"white"],
            ["fila_R_17",549,482,"white"],
            ["fila_R_15",524,482,"white"],
            ["fila_R_13",499,482,"white"],
            ["fila_R_11",474,482,"white"],
            ["fila_R_9",449,482,"white"],
            ["fila_R_7",424,482,"white"],
            ["fila_R_5",399,482,"white"],
            ["fila_S_20",952,456,"white"],
            ["fila_S_18",926,456,"white"],
            ["fila_S_16",901,456,"white"],
            ["fila_S_14",876,456,"white"],
            ["fila_S_12",851,456,"white"],
            ["fila_S_10",826,456,"white"],
            ["fila_S_8",801,456,"white"],
            ["fila_S_6",776,456,"white"],
            ["fila_S_4",751,456,"white"],
            ["fila_S_2",726,456,"white"],
            ["fila_S_25",650,456,"white"],
            ["fila_S_23",625,456,"white"],
            ["fila_S_21",600,456,"white"],
            ["fila_S_19",575,456,"white"],
            ["fila_S_17",549,456,"white"],
            ["fila_S_15",524,457,"white"],
            ["fila_S_13",499,456,"white"],
            ["fila_S_11",474,456,"white"],
            ["fila_S_9",449,456,"white"],
            ["fila_S_7",424,456,"white"],
            ["fila_T_18",926,431,"white"],
            ["fila_T_16",901,431,"white"],
            ["fila_T_14",876,431,"white"],
            ["fila_T_12",851,431,"white"],
            ["fila_T_10",826,431,"white"],
            ["fila_T_8",801,431,"white"],
            ["fila_T_6",776,431,"white"],
            ["fila_T_4",751,431,"white"],
            ["fila_T_2",726,431,"white"],
            ["fila_T_25",650,431,"white"],
            ["fila_T_23",625,431,"white"],
            ["fila_T_21",600,431,"white"],
            ["fila_T_19",575,431,"white"],
            ["fila_T_17",550,431,"white"],
            ["fila_T_15",524,431,"white"],
            ["fila_T_13",499,431,"white"],
            ["fila_T_11",474,431,"white"],
            ["fila_T_9",449,431,"white"],
            ["fila_U_14",876,406,"white"],
            ["fila_U_12",851,406,"white"],
            ["fila_U_8",801,406,"white"],
            ["fila_U_6",776,406,"white"],
            ["fila_U_2",726,406,"white"],
            ["fila_U_25",650,406,"white"],
            ["fila_U_23",625,406,"white"],
            ["fila_U_21",600,406,"white"],
            ["fila_U_19",575,406,"white"],
            ["fila_U_17",549,406,"white"],
            ["fila_U_10",826,406,"white"],
            ["fila_U_4",751,406,"white"],
            ["fila_U_15",524,406,"white"],
            ["fila_U_13",499,406,"white"],
            ["fila_V_10",826,381,"white"],
            ["fila_V_8",801,381,"white"],
            ["fila_V_6",776,381,"white"],
            ["fila_V_4",751,381,"white"],
            ["fila_V_2",726,381,"white"],
            ["fila_V_25",650,381,"white"],
            ["fila_V_23",625,381,"white"],
            ["fila_V_21",600,381,"white"],
            ["fila_V_19",575,381,"white"],
            ["fila_V_17",550,381,"white"],
            ["palco_I_2_1",1082,853,"white"],
            ["palco_I_24_3",299,854,"white"],
            ["palco_I_2_5",1100,838,"white"],
            ["palco_I_2_2",1082,839,"white"],
            ["palco_I_24_2",299,838,"white"],
            ["palco_I_24_5",281,839,"white"],
            ["palco_I_2_4",1100,823,"white"],
            ["palco_I_2_3",1082,823,"white"],
            ["palco_I_24_1",299,823,"white"],
            ["palco_I_24_4",281,823,"white"],
            ["palco_I_3_1",1082,793,"white"],
            ["palco_I_23_3",299,793,"white"],
            ["palco_I_3_2",1082,778,"white"],
            ["palco_I_23_5",281,778,"white"],
            ["palco_I_3_5",1100,778,"white"],
            ["palco_I_23_2",299,778,"white"],
            ["palco_I_3_4",1100,763,"white"],
            ["palco_I_3_3",1082,763,"white"],
            ["palco_I_23_1",299,763,"white"],
            ["palco_I_23_4",281,763,"white"],
            ["palco_I_4_1",1082,733,"white"],
            ["palco_I_22_3",299,733,"white"],
            ["palco_I_4_5",1100,718,"white"],
            ["palco_I_4_2",1082,718,"white"],
            ["palco_I_22_2",299,718,"white"],
            ["palco_I_22_5",281,718,"white"],
            ["palco_I_4_4",1100,703,"white"],
            ["palco_I_4_3",1082,703,"white"],
            ["palco_I_22_1",299,703,"white"],
            ["palco_I_22_4",281,703,"white"],
            ["palco_I_5_1",1082,672,"white"],
            ["palco_I_21_3",299,672,"white"],
            ["palco_I_5_5",1100,658,"white"],
            ["palco_I_5_2",1082,657,"white"],
            ["palco_I_21_2",299,658,"white"],
            ["palco_I_21_5",281,657,"white"],
            ["palco_I_5_4",1100,643,"white"],
            ["palco_I_5_3",1082,643,"white"],
            ["palco_I_21_1",299,643,"white"],
            ["palco_I_21_4",281,643,"white"],
            ["palco_I_6_1",1082,612,"white"],
            ["palco_I_20_3",299,612,"white"],
            ["palco_I_6_5",1100,597,"white"],
            ["palco_I_6_2",1082,597,"white"],
            ["palco_I_20_2",299,597,"white"],
            ["palco_I_20_5",281,597,"white"],
            ["palco_I_6_4",1100,582,"white"],
            ["palco_I_6_3",1082,582,"white"],
            ["palco_I_20_1",299,582,"white"],
            ["palco_I_20_4",281,582,"white"],
            ["palco_I_7_1",1082,552,"white"],
            ["palco_I_19_3",299,552,"white"],
            ["palco_I_7_5",1100,537,"white"],
            ["palco_I_7_2",1082,537,"white"],
            ["palco_I_19_2",299,537,"white"],
            ["palco_I_19_5",281,537,"white"],
            ["palco_I_7_4",1100,522,"white"],
            ["palco_I_7_3",1082,522,"white"],
            ["palco_I_19_1",299,522,"white"],
            ["palco_I_19_4",281,522,"white"],
            ["palco_I_8_1",1082,492,"white"],
            ["palco_I_18_3",299,492,"white"],
            ["palco_I_8_5",1100,477,"white"],
            ["palco_I_8_2",1082,477,"white"],
            ["palco_I_18_2",299,477,"white"],
            ["palco_I_18_5",281,477,"white"],
            ["palco_I_18_1",299,461,"white"],
            ["palco_I_8_4",1100,461,"white"],
            ["palco_I_8_3",1082,461,"white"],
            ["palco_I_18_4",281,461,"white"],
            ["palco_I_9_1",1102,406,"white"],
            ["palco_I_9_2",1087,407,"white"],
            ["palco_I_9_3",1072,407,"white"],
            ["palco_I_17_1",318,407,"white"],
            ["palco_I_17_2",304,407,"white"],
            ["palco_I_17_3",289,407,"white"],
            ["palco_I_9_4",1095,391,"white"],
            ["palco_I_9_5",1080,391,"white"],
            ["palco_I_17_4",311,391,"white"],
            ["palco_I_17_5",296,391,"white"],
            ["palco_I_9_6",1087,376,"white"],
            ["palco_I_17_6",304,376,"white"],
            ["palco_I_10_1",1067,334,"white"],
            ["palco_I_10_2",1052,334,"white"],
            ["palco_I_10_3",1037,333,"white"],
            ["palco_I_16_1",354,334,"white"],
            ["palco_I_16_2",339,334,"white"],
            ["palco_I_16_3",324,334,"white"],
            ["palco_I_10_4",1062,318,"white"],
            ["palco_I_10_5",1044,318,"white"],
            ["palco_I_16_4",346,318,"white"],
            ["palco_I_16_5",331,318,"white"],
            ["palco_I_11_1",969,306,"white"],
            ["palco_I_11_2",954,306,"white"],
            ["palco_I_11_3",939,306,"white"],
            ["palco_I_15_1",452,306,"white"],
            ["palco_I_15_2",436,306,"white"],
            ["palco_I_15_3",422,306,"white"],
            ["palco_I_10_6",1052,303,"white"],
            ["palco_I_16_6",339,303,"white"],
            ["palco_I_11_4",961,291,"white"],
            ["palco_I_11_5",947,291,"white"],
            ["palco_I_15_4",444,291,"white"],
            ["palco_I_15_5",429,291,"white"],
            ["palco_I_12_1",836,289,"white"],
            ["palco_I_12_2",821,289,"white"],
            ["palco_I_12_3",806,288,"white"],
            ["palco_I_14_1",585,288,"white"],
            ["palco_I_14_2",570,289,"white"],
            ["palco_I_14_3",554,288,"white"],
            ["palco_I_11_6",954,276,"white"],
            ["palco_I_15_6",436,276,"white"],
            ["palco_I_12_4",829,273,"white"],
            ["palco_I_12_5",814,273,"white"],
            ["palco_I_14_4",577,273,"white"],
            ["palco_I_14_5",562,273,"white"],
            ["palco_I_12_6",821,258,"white"],
            ["palco_I_14_6",570,258,"white"],
            ["palco_II_2_1",1137,853,"white"],
            ["palco_II_24_3",243,854,"white"],
            ["palco_II_2_5",1155,839,"white"],
            ["palco_II_2_2",1137,838,"white"],
            ["palco_II_24_2",243,839,"white"],
            ["palco_II_24_5",226,838,"white"],
            ["palco_II_2_4",1155,823,"white"],
            ["palco_II_2_3",1137,823,"white"],
            ["palco_II_24_1",243,823,"white"],
            ["palco_II_24_4",226,823,"white"],
            ["palco_II_3_1",1137,793,"white"],
            ["palco_II_23_3",243,793,"white"],
            ["palco_II_3_5",1155,778,"white"],
            ["palco_II_3_2",1137,778,"white"],
            ["palco_II_23_2",243,778,"white"],
            ["palco_II_23_5",226,778,"white"],
            ["palco_II_3_4",1155,763,"white"],
            ["palco_II_3_3",1137,763,"white"],
            ["palco_II_23_1",243,763,"white"],
            ["palco_II_23_4",226,763,"white"],
            ["palco_II_4_1",1137,733,"white"],
            ["palco_II_22_3",243,733,"white"],
            ["palco_II_4_5",1155,718,"white"],
            ["palco_II_4_2",1137,718,"white"],
            ["palco_II_22_2",243,718,"white"],
            ["palco_II_22_5",226,718,"white"],
            ["palco_II_4_4",1155,703,"white"],
            ["palco_II_4_3",1137,703,"white"],
            ["palco_II_22_1",243,703,"white"],
            ["palco_II_22_4",226,703,"white"],
            ["palco_II_5_1",1137,672,"white"],
            ["palco_II_21_3",243,672,"white"],
            ["palco_II_5_5",1155,657,"white"],
            ["palco_II_5_2",1137,658,"white"],
            ["palco_II_21_2",243,658,"white"],
            ["palco_II_21_5",226,658,"white"],
            ["palco_II_5_4",1155,643,"white"],
            ["palco_II_5_3",1137,642,"white"],
            ["palco_II_21_1",243,643,"white"],
            ["palco_II_21_4",226,643,"white"],
            ["palco_II_6_1",1137,612,"white"],
            ["palco_II_20_3",243,612,"white"],
            ["palco_II_6_5",1155,597,"white"],
            ["palco_II_6_2",1137,597,"white"],
            ["palco_II_20_2",243,597,"white"],
            ["palco_II_20_5",226,597,"white"],
            ["palco_II_6_4",1155,582,"white"],
            ["palco_II_6_3",1137,582,"white"],
            ["palco_II_20_1",243,582,"white"],
            ["palco_II_20_4",226,582,"white"],
            ["palco_II_7_1",1137,552,"white"],
            ["palco_II_19_3",243,552,"white"],
            ["palco_II_7_5",1155,537,"white"],
            ["palco_II_7_2",1137,537,"white"],
            ["palco_II_19_2",243,537,"white"],
            ["palco_II_19_5",225,537,"white"],
            ["palco_II_7_4",1155,522,"white"],
            ["palco_II_7_3",1137,522,"white"],
            ["palco_II_19_1",243,522,"white"],
            ["palco_II_19_4",226,522,"white"],
            ["palco_II_8_1",1137,492,"white"],
            ["palco_II_18_3",243,492,"white"],
            ["palco_II_8_5",1155,476,"white"],
            ["palco_II_8_2",1137,477,"white"],
            ["palco_II_18_2",243,477,"white"],
            ["palco_II_18_5",225,477,"white"],
            ["palco_II_8_4",1155,461,"white"],
            ["palco_II_8_3",1137,461,"white"],
            ["palco_II_18_1",243,461,"white"],
            ["palco_II_18_4",226,461,"white"],
            ["palco_II_9_1",1158,389,"white"],
            ["palco_II_9_2",1143,389,"white"],
            ["palco_II_9_3",1127,389,"white"],
            ["palco_II_17_1",264,389,"white"],
            ["palco_II_17_2",248,389,"white"],
            ["palco_II_17_3",233,389,"white"],
            ["palco_II_9_4",1150,374,"white"],
            ["palco_II_9_5",1135,374,"white"],
            ["palco_II_17_4",256,374,"white"],
            ["palco_II_17_5",241,374,"white"],
            ["palco_II_9_6",1143,359,"white"],
            ["palco_II_17_6",248,359,"white"],
            ["palco_II_10_1",1112,293,"white"],
            ["palco_II_10_2",1097,293,"white"],
            ["palco_II_10_3",1082,293,"white"],
            ["palco_II_16_1",309,293,"white"],
            ["palco_II_16_2",293,293,"white"],
            ["palco_II_16_3",278,293,"white"],
            ["palco_II_10_4",1105,278,"white"],
            ["palco_II_10_5",1090,278,"white"],
            ["palco_II_16_4",301,278,"white"],
            ["palco_II_16_5",286,278,"white"],
            ["palco_II_10_6",1097,263,"white"],
            ["palco_II_16_6",293,263,"white"],
            ["palco_II_11_1",1004,261,"white"],
            ["palco_II_11_2",989,261,"white"],
            ["palco_II_11_3",974,261,"white"],
            ["palco_II_15_1",417,261,"white"],
            ["palco_II_15_2",402,261,"white"],
            ["palco_II_15_3",386,261,"white"],
            ["palco_II_11_4",997,246,"white"],
            ["palco_II_11_5",982,246,"white"],
            ["palco_II_15_4",409,246,"white"],
            ["palco_II_15_5",394,246,"white"],
            ["palco_II_12_1",876,243,"white"],
            ["palco_II_12_2",861,243,"white"],
            ["palco_II_12_3",846,243,"white"],
            ["palco_II_14_1",545,241,"white"],
            ["palco_II_14_2",529,241,"white"],
            ["palco_II_14_3",515,241,"white"],
            ["palco_II_13_1",710,233,"white"],
            ["palco_II_13_2",693,233,"white"],
            ["palco_II_13_3",675,233,"white"],
            ["palco_II_13_4",658,233,"white"],
            ["palco_II_11_6",989,231,"white"],
            ["palco_II_15_6",402,231,"white"],
            ["palco_II_12_4",868,228,"white"],
            ["palco_II_12_5",854,228,"white"],
            ["palco_II_14_5",522,225,"white"],
            ["palco_II_14_4",537,225,"white"],
            ["palco_II_13_5",710,216,"white"],
            ["palco_II_13_6",693,216,"white"],
            ["palco_II_13_7",675,215,"white"],
            ["palco_II_13_8",658,216,"white"],
            ["palco_II_12_6",861,213,"white"],
            ["palco_II_14_6",529,210,"white"],
            ["palco_II_13_9",693,198,"white"],
            ["palco_II_13_10",675,198,"white"],
            ["palco_III_2_1",1193,853,"white"],
            ["palco_III_24_3",188,854,"white"],
            ["palco_III_2_5",1210,839,"white"],
            ["palco_III_2_2",1193,838,"white"],
            ["palco_III_24_2",188,839,"white"],
            ["palco_III_24_5",171,838,"white"],
            ["palco_III_2_4",1210,823,"white"],
            ["palco_III_2_3",1193,823,"white"],
            ["palco_III_24_1",188,823,"white"],
            ["palco_III_24_4",171,823,"white"],
            ["palco_III_3_1",1193,793,"white"],
            ["palco_III_23_3",188,793,"white"],
            ["palco_III_23_2",188,778,"white"],
            ["palco_III_3_5",1210,778,"white"],
            ["palco_III_3_2",1193,778,"white"],
            ["palco_III_23_5",171,778,"white"],
            ["palco_III_3_4",1210,763,"white"],
            ["palco_III_3_3",1193,763,"white"],
            ["palco_III_23_1",188,763,"white"],
            ["palco_III_23_4",171,763,"white"],
            ["palco_III_4_1",1193,733,"white"],
            ["palco_III_22_3",188,733,"white"],
            ["palco_III_4_5",1210,718,"white"],
            ["palco_III_4_2",1193,718,"white"],
            ["palco_III_22_2",188,718,"white"],
            ["palco_III_22_5",171,718,"white"],
            ["palco_III_4_4",1210,703,"white"],
            ["palco_III_4_3",1193,703,"white"],
            ["palco_III_22_1",188,703,"white"],
            ["palco_III_22_4",171,703,"white"],
            ["palco_III_5_1",1193,672,"white"],
            ["palco_III_21_3",188,672,"white"],
            ["palco_III_5_5",1210,658,"white"],
            ["palco_III_5_2",1193,658,"white"],
            ["palco_III_21_2",188,657,"white"],
            ["palco_III_21_5",171,657,"white"],
            ["palco_III_5_4",1210,643,"white"],
            ["palco_III_5_3",1193,643,"white"],
            ["palco_III_21_1",188,643,"white"],
            ["palco_III_21_4",171,642,"white"],
            ["palco_III_20_3",188,612,"white"],
            ["palco_III_6_1",1193,612,"white"],
            ["palco_III_6_5",1210,597,"white"],
            ["palco_III_6_2",1193,597,"white"],
            ["palco_III_20_2",188,597,"white"],
            ["palco_III_20_5",171,597,"white"],
            ["palco_III_6_4",1210,582,"white"],
            ["palco_III_6_3",1193,582,"white"],
            ["palco_III_20_1",188,582,"white"],
            ["palco_III_20_4",171,582,"white"],
            ["palco_III_7_1",1193,552,"white"],
            ["palco_III_19_3",188,552,"white"],
            ["palco_III_7_5",1210,537,"white"],
            ["palco_III_7_2",1193,537,"white"],
            ["palco_III_19_2",188,537,"white"],
            ["palco_III_19_5",171,537,"white"],
            ["palco_III_7_4",1210,522,"white"],
            ["palco_III_7_3",1193,522,"white"],
            ["palco_III_19_1",188,522,"white"],
            ["palco_III_19_4",171,522,"white"],
            ["palco_III_8_1",1193,492,"white"],
            ["palco_III_18_3",188,492,"white"],
            ["palco_III_8_5",1210,477,"white"],
            ["palco_III_8_2",1193,477,"white"],
            ["palco_III_18_2",188,477,"white"],
            ["palco_III_18_5",171,477,"white"],
            ["palco_III_8_4",1210,461,"white"],
            ["palco_III_8_3",1193,461,"white"],
            ["palco_III_18_1",188,461,"white"],
            ["palco_III_18_4",171,461,"white"],
            ["palco_III_9_3",1183,371,"white"],
            ["palco_III_17_1",208,371,"white"],
            ["palco_III_17_2",193,371,"white"],
            ["palco_III_17_3",178,371,"white"],
            ["palco_III_9_1",1213,371,"white"],
            ["palco_III_9_2",1197,371,"white"],
            ["palco_III_17_4",200,356,"white"],
            ["palco_III_9_4",1205,356,"white"],
            ["palco_III_9_5",1190,356,"white"],
            ["palco_III_17_5",186,356,"white"],
            ["palco_III_9_6",1197,341,"white"],
            ["palco_III_17_6",193,341,"white"],
            ["palco_III_10_1",1157,253,"white"],
            ["palco_III_10_2",1143,253,"white"],
            ["palco_III_10_3",1127,253,"white"],
            ["palco_III_16_1",264,253,"white"],
            ["palco_III_16_2",248,253,"white"],
            ["palco_III_16_3",233,253,"white"],
            ["palco_III_10_4",1150,238,"white"],
            ["palco_III_10_5",1135,238,"white"],
            ["palco_III_16_4",256,238,"white"],
            ["palco_III_16_5",241,238,"white"],
            ["palco_III_10_6",1143,223,"white"],
            ["palco_III_16_6",248,223,"white"],
            ["palco_III_11_1",1037,213,"white"],
            ["palco_III_11_2",1022,213,"white"],
            ["palco_III_11_3",1007,213,"white"],
            ["palco_III_15_1",384,213,"white"],
            ["palco_III_15_2",369,213,"white"],
            ["palco_III_15_3",354,213,"white"],
            ["palco_III_11_4",1029,198,"white"],
            ["palco_III_11_5",1014,198,"white"],
            ["palco_III_12_1",926,198,"white"],
            ["palco_III_12_2",911,198,"white"],
            ["palco_III_12_3",896,198,"white"],
            ["palco_III_14_1",510,198,"white"],
            ["palco_III_14_2",495,198,"white"],
            ["palco_III_14_3",479,198,"white"],
            ["palco_III_15_4",376,198,"white"],
            ["palco_III_15_5",361,198,"white"],
            ["palco_III_11_6",1022,183,"white"],
            ["palco_III_12_4",919,183,"white"],
            ["palco_III_12_5",904,183,"white"],
            ["palco_III_14_4",502,183,"white"],
            ["palco_III_14_5",487,183,"white"],
            ["palco_III_15_6",369,183,"white"],
            ["palco_III_12_6",911,168,"white"],
            ["palco_III_14_6",495,168,"white"],
            ["palco_III_13_1",711,165,"white"],
            ["palco_III_13_2",693,165,"white"],
            ["palco_III_13_3",675,165,"white"],
            ["palco_III_13_4",658,165,"white"],
            ["palco_III_13_5",710,148,"white"],
            ["palco_III_13_6",693,148,"white"],
            ["palco_III_13_7",675,148,"white"],
            ["palco_III_13_8",658,148,"white"],
            ["palco_III_13_9",693,130,"white"],
            ["palco_III_13_10",675,130,"white"],
            ["palco_IV_2_1",1248,853,"white"],
            ["palco_IV_24_3",133,854,"white"],
            ["palco_IV_2_5",1265,838,"white"],
            ["palco_IV_2_2",1248,839,"white"],
            ["palco_IV_24_2",133,839,"white"],
            ["palco_IV_24_5",115,838,"white"],
            ["palco_IV_2_4",1265,823,"white"],
            ["palco_IV_2_3",1248,823,"white"],
            ["palco_IV_24_1",133,823,"white"],
            ["palco_IV_24_4",115,823,"white"],
            ["palco_IV_3_1",1248,793,"white"],
            ["palco_IV_23_3",133,793,"white"],
            ["palco_IV_23_5",115,778,"white"],
            ["palco_IV_3_5",1265,778,"white"],
            ["palco_IV_3_2",1248,778,"white"],
            ["palco_IV_23_2",133,778,"white"],
            ["palco_IV_3_4",1265,763,"white"],
            ["palco_IV_3_3",1248,763,"white"],
            ["palco_IV_23_1",133,763,"white"],
            ["palco_IV_23_4",115,763,"white"],
            ["palco_IV_4_1",1248,733,"white"],
            ["palco_IV_22_3",133,733,"white"],
            ["palco_IV_4_5",1265,718,"white"],
            ["palco_IV_4_2",1248,718,"white"],
            ["palco_IV_22_2",133,718,"white"],
            ["palco_IV_22_5",115,718,"white"],
            ["palco_IV_4_4",1265,703,"white"],
            ["palco_IV_4_3",1248,703,"white"],
            ["palco_IV_22_1",133,703,"white"],
            ["palco_IV_22_4",115,703,"white"],
            ["palco_IV_5_1",1248,672,"white"],
            ["palco_IV_21_3",133,672,"white"],
            ["palco_IV_5_5",1265,657,"white"],
            ["palco_IV_5_2",1248,657,"white"],
            ["palco_IV_21_2",133,657,"white"],
            ["palco_IV_21_5",115,658,"white"],
            ["palco_IV_5_4",1265,643,"white"],
            ["palco_IV_5_3",1248,643,"white"],
            ["palco_IV_21_1",133,643,"white"],
            ["palco_IV_21_4",115,643,"white"],
            ["palco_IV_6_1",1248,612,"white"],
            ["palco_IV_20_3",133,612,"white"],
            ["palco_IV_6_5",1265,597,"white"],
            ["palco_IV_6_2",1248,597,"white"],
            ["palco_IV_20_2",133,597,"white"],
            ["palco_IV_20_5",115,597,"white"],
            ["palco_IV_6_4",1265,582,"white"],
            ["palco_IV_6_3",1248,582,"white"],
            ["palco_IV_20_1",133,582,"white"],
            ["palco_IV_20_4",115,582,"white"],
            ["palco_IV_7_1",1248,552,"white"],
            ["palco_IV_19_3",133,552,"white"],
            ["palco_IV_7_5",1265,537,"white"],
            ["palco_IV_7_2",1248,537,"white"],
            ["palco_IV_19_2",133,537,"white"],
            ["palco_IV_19_5",115,537,"white"],
            ["palco_IV_7_4",1265,522,"white"],
            ["palco_IV_7_3",1248,522,"white"],
            ["palco_IV_19_1",133,522,"white"],
            ["palco_IV_19_4",115,522,"white"],
            ["palco_IV_8_1",1248,492,"white"],
            ["palco_IV_18_3",133,492,"white"],
            ["palco_IV_8_5",1265,477,"white"],
            ["palco_IV_8_2",1248,476,"white"],
            ["palco_IV_18_2",133,477,"white"],
            ["palco_IV_18_5",115,477,"white"],
            ["palco_IV_8_4",1265,461,"white"],
            ["palco_IV_8_3",1248,461,"white"],
            ["palco_IV_18_1",133,461,"white"],
            ["palco_IV_18_4",115,461,"white"],
            ["palco_IV_9_1",1268,354,"white"],
            ["palco_IV_9_2",1253,354,"white"],
            ["palco_IV_9_3",1238,354,"white"],
            ["palco_IV_17_1",153,354,"white"],
            ["palco_IV_17_2",138,354,"white"],
            ["palco_IV_17_3",123,354,"white"],
            ["palco_IV_9_4",1261,339,"white"],
            ["palco_IV_9_5",1245,339,"white"],
            ["palco_IV_17_4",146,339,"white"],
            ["palco_IV_17_5",130,339,"white"],
            ["palco_IV_9_6",1253,324,"white"],
            ["palco_IV_17_6",138,324,"white"],
            ["palco_IV_10_1",1203,213,"white"],
            ["palco_IV_10_2",1188,213,"white"],
            ["palco_IV_10_3",1172,213,"white"],
            ["palco_IV_16_1",218,213,"white"],
            ["palco_IV_16_2",203,213,"white"],
            ["palco_IV_16_3",188,213,"white"],
            ["palco_IV_10_4",1195,198,"white"],
            ["palco_IV_10_5",1180,198,"white"],
            ["palco_IV_16_4",211,198,"white"],
            ["palco_IV_16_5",196,198,"white"],
            ["palco_IV_10_6",1187,183,"white"],
            ["palco_IV_16_6",203,183,"white"],
            ["palco_IV_11_1",1077,165,"white"],
            ["palco_IV_11_2",1062,165,"white"],
            ["palco_IV_11_3",1047,165,"white"],
            ["palco_IV_15_1",343,165,"white"],
            ["palco_IV_15_2",329,165,"white"],
            ["palco_IV_15_3",314,165,"white"],
            ["palco_IV_11_4",1069,150,"white"],
            ["palco_IV_11_5",1054,150,"white"],
            ["palco_IV_12_1",969,150,"white"],
            ["palco_IV_12_2",954,150,"white"],
            ["palco_IV_12_3",939,150,"white"],
            ["palco_IV_14_1",474,150,"white"],
            ["palco_IV_14_2",459,150,"white"],
            ["palco_IV_14_3",444,150,"white"],
            ["palco_IV_15_4",336,150,"white"],
            ["palco_IV_15_5",321,150,"white"],
            ["palco_IV_11_6",1062,135,"white"],
            ["palco_IV_12_4",961,135,"white"],
            ["palco_IV_12_5",947,135,"white"],
            ["palco_IV_14_4",467,135,"white"],
            ["palco_IV_14_5",452,135,"white"],
            ["palco_IV_15_6",329,135,"white"],
            ["palco_IV_12_6",954,120,"white"],
            ["palco_IV_14_6",459,120,"white"],
            ["lunetta_I_1_1",1082,899,"white"],
            ["lunetta_I_1_3",1100,883,"white"],
            ["lunetta_I_1_2",1082,883,"white"],
            ["lunetta_I_25_2",299,899,"white"],
            ["lunetta_I_25_1",299,883,"white"],
            ["lunetta_I_25_3",281,883,"white"],
            ["proscenio_IV_0_12",1265,1004,"white"],
            ["proscenio_IV_0_1",1248,1004,"white"],
            ["proscenio_III_0_12",1210,1004,"white"],
            ["proscenio_III_0_1",1193,1004,"white"],
            ["proscenio_II_0_12",1155,1004,"white"],
            ["proscenio_II_0_1",1137,1004,"white"],
            ["proscenio_I_0_12",1100,1004,"white"],
            ["proscenio_I_0_1",1082,1004,"white"],
            ["proscenio_I_26_6",299,1004,"white"],
            ["proscenio_I_26_12",281,1004,"white"],
            ["proscenio_II_26_6",243,1004,"white"],
            ["proscenio_II_26_12",225,1004,"white"],
            ["proscenio_III_26_6",188,1004,"white"],
            ["proscenio_III_26_12",171,1004,"white"],
            ["proscenio_IV_26_6",133,1004,"white"],
            ["proscenio_IV_26_12",115,1004,"white"],
            ["proscenio_IV_0_11",1265,989,"white"],
            ["proscenio_IV_0_2",1248,989,"white"],
            ["proscenio_III_0_11",1210,989,"white"],
            ["proscenio_III_0_2",1193,989,"white"],
            ["proscenio_II_0_11",1155,989,"white"],
            ["proscenio_II_0_2",1137,989,"white"],
            ["proscenio_I_0_11",1100,989,"white"],
            ["proscenio_I_0_2",1082,989,"white"],
            ["proscenio_I_26_5",299,989,"white"],
            ["proscenio_I_26_11",281,989,"white"],
            ["proscenio_II_26_5",243,989,"white"],
            ["proscenio_II_26_11",226,989,"white"],
            ["proscenio_III_26_5",188,989,"white"],
            ["proscenio_III_26_11",171,989,"white"],
            ["proscenio_IV_26_5",133,989,"white"],
            ["proscenio_IV_26_11",115,989,"white"],
            ["proscenio_IV_0_10",1265,974,"white"],
            ["proscenio_IV_0_3",1248,974,"white"],
            ["proscenio_III_0_10",1210,974,"white"],
            ["proscenio_III_0_3",1193,974,"white"],
            ["proscenio_II_0_10",1155,974,"white"],
            ["proscenio_II_0_3",1137,974,"white"],
            ["proscenio_I_0_10",1100,974,"white"],
            ["proscenio_I_0_3",1082,974,"white"],
            ["proscenio_I_26_4",299,974,"white"],
            ["proscenio_I_26_10",281,974,"white"],
            ["proscenio_II_26_4",243,974,"white"],
            ["proscenio_II_26_10",225,974,"white"],
            ["proscenio_III_26_4",188,974,"white"],
            ["proscenio_III_26_10",171,974,"white"],
            ["proscenio_IV_26_4",133,974,"white"],
            ["proscenio_IV_26_10",115,974,"white"],
            ["proscenio_IV_0_9",1265,959,"white"],
            ["proscenio_IV_0_4",1248,959,"white"],
            ["proscenio_III_0_9",1210,959,"white"],
            ["proscenio_III_0_4",1193,959,"white"],
            ["proscenio_II_0_9",1155,959,"white"],
            ["proscenio_II_0_4",1137,959,"white"],
            ["proscenio_I_0_9",1100,959,"white"],
            ["proscenio_I_0_4",1082,959,"white"],
            ["proscenio_I_26_3",299,959,"white"],
            ["proscenio_I_26_9",281,959,"white"],
            ["proscenio_II_26_3",243,959,"white"],
            ["proscenio_II_26_9",225,959,"white"],
            ["proscenio_III_26_3",188,959,"white"],
            ["proscenio_III_26_9",171,959,"white"],
            ["proscenio_IV_26_3",133,959,"white"],
            ["proscenio_IV_26_9",115,959,"white"],
            ["proscenio_IV_0_8",1265,944,"white"],
            ["proscenio_IV_0_5",1248,944,"white"],
            ["proscenio_III_0_8",1210,944,"white"],
            ["proscenio_III_0_5",1193,944,"white"],
            ["proscenio_II_0_8",1155,944,"white"],
            ["proscenio_II_0_5",1137,944,"white"],
            ["proscenio_I_0_8",1100,944,"white"],
            ["proscenio_I_0_5",1082,944,"white"],
            ["proscenio_I_26_2",299,944,"white"],
            ["proscenio_I_26_8",281,944,"white"],
            ["proscenio_II_26_2",243,944,"white"],
            ["proscenio_II_26_8",226,944,"white"],
            ["proscenio_III_26_2",188,944,"white"],
            ["proscenio_III_26_8",171,944,"white"],
            ["proscenio_IV_26_2",133,944,"white"],
            ["proscenio_IV_26_8",115,944,"white"],
            ["proscenio_IV_0_7",1265,929,"white"],
            ["proscenio_IV_0_6",1248,929,"white"],
            ["proscenio_III_0_7",1210,929,"white"],
            ["proscenio_III_0_6",1193,929,"white"],
            ["proscenio_II_0_7",1155,929,"white"],
            ["proscenio_II_0_6",1137,929,"white"],
            ["proscenio_I_0_7",1100,929,"white"],
            ["proscenio_I_0_6",1082,929,"white"],
            ["proscenio_I_26_1",299,929,"white"],
            ["proscenio_I_26_7",281,929,"white"],
            ["proscenio_II_26_1",243,929,"white"],
            ["proscenio_II_26_7",226,929,"white"],
            ["proscenio_III_26_1",188,929,"white"],
            ["proscenio_III_26_7",171,929,"white"],
            ["proscenio_IV_26_1",133,929,"white"],
            ["proscenio_IV_26_7",115,929,"white"],
            ["loggione_23",1318,416,"white"],
            ["loggione_115",57,417,"white"],
            ["loggione_25",1318,391,"white"],
            ["loggione_113",57,391,"white"],
            ["loggione_27",1318,366,"white"],
            ["loggione_111",57,366,"white"],
            ["loggione_29",1318,329,"white"],
            ["loggione_109",57,329,"white"],
            ["loggione_31",1318,303,"white"],
            ["loggione_107",57,303,"white"],
            ["loggione_33",1316,278,"white"],
            ["loggione_105",60,278,"white"],
            ["loggione_102",27,253,"white"],
            ["loggione_38",1341,228,"white"],
            ["loggione_35",1308,228,"white"],
            ["loggione_103",67,228,"white"],
            ["loggione_100",35,228,"white"],
            ["loggione_40",1333,203,"white"],
            ["loggione_37",1296,203,"white"],
            ["loggione_101",80,203,"white"],
            ["loggione_98",42,203,"white"],
            ["loggione_39",1281,178,"white"],
            ["loggione_99",95,178,"white"],
            ["loggione_97",128,143,"white"],
            ["loggione_41",1250,138,"white"],
            ["loggione_95",150,120,"white"],
            ["loggione_43",1225,115,"white"],
            ["loggione_96",118,113,"white"],
            ["loggione_93",175,103,"white"],
            ["loggione_42",1255,97,"white"],
            ["loggione_45",1200,97,"white"],
            ["loggione_94",143,87,"white"],
            ["loggione_44",1230,75,"white"],
            ["loggione_92",173,70,"white"],
            ["loggione_47",1125,67,"white"],
            ["loggione_91",251,67,"white"],
            ["loggione_49",1100,62,"white"],
            ["loggione_51",1075,62,"white"],
            ["loggione_53",999,62,"white"],
            ["loggione_55",974,62,"white"],
            ["loggione_57",949,62,"white"],
            ["loggione_59",899,62,"white"],
            ["loggione_61",874,62,"white"],
            ["loggione_63",849,62,"white"],
            ["loggione_65",761,62,"white"],
            ["loggione_67",736,62,"white"],
            ["loggione_69",711,62,"white"],
            ["loggione_71",685,62,"white"],
            ["loggione_73",660,62,"white"],
            ["loggione_75",527,62,"white"],
            ["loggione_77",502,62,"white"],
            ["loggione_79",477,62,"white"],
            ["loggione_81",427,62,"white"],
            ["loggione_83",402,62,"white"],
            ["loggione_85",376,62,"white"],
            ["loggione_87",301,62,"white"],
            ["loggione_89",276,62,"white"],
            ["loggione_46",1200,57,"white"],
            ["loggione_90",200,52,"white"],
            ["loggione_48",1170,40,"white"],
            ["loggione_88",251,35,"white"],
            ["loggione_50",1125,30,"white"],
            ["loggione_52",999,27,"white"],
            ["loggione_54",974,27,"white"],
            ["loggione_56",949,27,"white"],
            ["loggione_58",924,27,"white"],
            ["loggione_60",899,27,"white"],
            ["loggione_62",874,27,"white"],
            ["loggione_64",761,27,"white"],
            ["loggione_66",736,27,"white"],
            ["loggione_68",710,27,"white"],
            ["loggione_70",685,27,"white"],
            ["loggione_72",660,27,"white"],
            ["loggione_74",635,27,"white"],
            ["loggione_76",502,27,"white"],
            ["loggione_78",477,27,"white"],
            ["loggione_80",452,27,"white"],
            ["loggione_82",427,27,"white"],
            ["loggione_84",401,27,"white"],
            ["loggione_86",376,27,"white"]
                
            ];  

           
            posto.forEach(p => {
                if (p[0].startsWith("fila_")) { 
                    p[3] = "black"; 
                }
            });

            posto.forEach(p => {
                if (p[0].startsWith("palco")) { 
                    p[3] = "gold";
                }
            });

            posto.forEach(p => {
                if (p[0].startsWith("lunetta")) { 
                    p[3] = "darkgray";
                }
            });

            posto.forEach(p => {
                if (p[0].startsWith("proscenio")) { 
                    p[3] = "orange";
                }
            });

            posto.forEach(p => {
                if (p[0].startsWith("loggione")) { 
                    p[3] = "blue";
                }
            });

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

                        //seat[3] = seat[3] === "white" ? "blue" : "white";
                        
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
                const selectedSeats = posto.filter(seat => seat[3] === "green").map(seat => seat[0]);
                alert(selectedSeats.length ? `Hai selezionato: ${selectedSeats.join(", ")}` : "Nessun posto selezionato");
            });

            drawSeats();
        });
    </script>
</body>
</html>


<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>T-APP</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link rel="stylesheet" href="assets/css/tiny-slider.css" />
    <link rel="stylesheet" href="assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />

    

    <style>
        .event-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
    margin-bottom: 20px;
}

.event-card:hover {
    transform: translateY(-5px);
}


.event-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.event-body {
    padding: 15px;
}

.event-title {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.event-meta {
    font-size: 14px;
    color: #777;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 10px;
}

.event-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
    background: #f8f9fa;
    padding: 5px 10px;
    border-radius: 5px;
}

.event-meta i {
    color: #007bff;
}

.event-hashtag {
    font-weight: bold;
    color: #007bff;
}

.event-description {
    font-size: 14px;
    color: #555;
    margin-bottom: 10px;
}

.event-footer {
    display: flex;
    justify-content: center;
    padding: 10px;
}

.btn-iscriversi {
    background: #007bff;
    color: white;
    padding: 8px 20px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    transition: 0.3s;
}

.btn-iscriversi:hover {
    background: #0056b3;
}

.image-selected {
    max-width: 100%;
    max-height: 90vh;  /* 90% de la hauteur de l'écran */
    object-fit: contain;
}

/* Contenitore per i pulsanti */
.event-buttons {
    display: flex;  /* Disporre i pulsanti in linea */
    gap: 10px;      /* Distanza tra i pulsanti */
    justify-content: center; /* Centra i pulsanti */
    margin-top: 20px; /* Spazio sopra i pulsanti */
}

/* Pulsante per annullare */
.btn-cancel {
    background-color: #d9534f; /* Colore rosso */
    color: white;               /* Testo bianco */
    border: none;               /* Rimuove il bordo */
    padding: 10px 20px;         /* Padding interno */
    font-size: 16px;            /* Dimensione del testo */
    border-radius: 5px;         /* Angoli arrotondati */
    cursor: pointer;           /* Cursore a forma di mano */
    transition: background-color 0.3s ease; /* Transizione morbida per il colore */
}

/* Cambia il colore del pulsante per annullare quando ci passi sopra */
.btn-cancel:hover {
    background-color: #c9302c; /* Colore rosso scuro al passaggio */
}

/* Pulsante per iscriversi */
.btn-register {
    background-color: #007bff; /* Colore blu */
    color: white;               /* Testo bianco */
    border: none;               /* Rimuove il bordo */
    padding: 10px 20px;         /* Padding interno */
    font-size: 16px;            /* Dimensione del testo */
    border-radius: 5px;         /* Angoli arrotondati */
    cursor: pointer;           /* Cursore a forma di mano */
    transition: background-color 0.3s ease; /* Transizione morbida per il colore */
}

/* Cambia il colore del pulsante per iscriversi quando ci passi sopra */
.btn-register:hover {
    background-color: #31b0d5; /* Colore blu scuro al passaggio */
}

/* Style de la modale */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    width: 90%;
    max-width: 400px;
}

.close {
    float: right;
    font-size: 24px;
    cursor: pointer;
}

.modal-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.btn-option {
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    flex: 1;
    margin: 5px;
}

.btn-option:first-child {
    background-color: green;
    color: white;
}

.btn-option:last-child {
    background-color: red;
    color: white;
}

.hidden {
    display: none;
}

#form-inscription {
    margin-top: 20px;
}

#form-inscription input {
    display: block;
    width: 100%;
    margin-bottom: 10px;
    padding: 8px;
}

.btn-submit {
    width: 100%;
    background-color: blue;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.user-notification {
    position: fixed;
    top: 10px;
    right: 20px;
    background: #2ecc71; /* Vert */
    color: white;
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.5s ease-in-out;
}

.user-text {
    font-weight: bold;
}

.btn-green {
    background: white;
    color: #2ecc71;
    border: none;
    padding: 5px 10px;
    font-weight: bold;
    border-radius: 50%;
    cursor: pointer;
    transition: background 0.3s;
}

.btn-green:hover {
    background: #27ae60;
    color: white;
}

/* Animation d'apparition */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}



 </style>


</head>
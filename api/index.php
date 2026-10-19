<?php 

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8"); 

$method=$_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"),true);


require "presenter.php";

$result=new presenter($db);

// Per fare login, viene inviata una richiesta di accesso all'api dalla pagina login con indirizzo api/index.php?op=login
if($_GET['op']=="login"){
    richiesta($method,$data,$db,NULL);
}

if($_GET['op']=="admin"){
    richiesta($method,$data,$db,NULL);
}

//Per registrare un nuovo account, viene inviata una richiesta verso l'api dalla pagina registrati con indirizzo api/index.php?op=registrati
if($_GET['op']=="registrati"){
    richiesta($method,$data,$db,NULL);
}

// Per mostare la lista di tutti gli eventi disponibili, url : api/index.php?op=evento
if($_GET['op']=="evento"){
    $result->handleRequest($method,$data,NULL);
}


if($_GET['op']=="show_evento"){
    $result->handleRequest($method,$data,$_GET['id']);
}

if($_GET['op']=="ricerca"){
    richiesta($method,$data,$db,$_GET['hashtag']);
}

if($_GET['op']=="iscrizione"){
    richiesta($method,$data,$db,NULL);
}

if($_GET['op']=="backend"){
    session_start();
    $data=["action" => $_GET['action'],
   "id_account"=>$_SESSION['id_account']];
    
    richiesta($method,$data, $db, NULL);
}

if($_GET['op']=="backend"&& $_GET['action']=="modifica"){
    $result->handleRequest($method,$data,$_GET['id']);
}

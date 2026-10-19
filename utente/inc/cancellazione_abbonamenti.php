<?php 
require "sessione.php";
attivazione_sessione("nome_utente");
require "../../api/database.php";

$req1=$db->prepare("SELECT * FROM abbonamento WHERE abbonamentoID=?");
$req1->execute([$_GET['id']]);
$res1=$req1->fetchAll(PDO::FETCH_ASSOC);


function getColorByName($name) {
    if (strpos($name, "fila") === 0) return "black";
    if (strpos($name, "palco") === 0) return "gold";
    if (strpos($name, "proscenio") === 0) return "orange";
    if (strpos($name, "lunetta") === 0) return "darkgray";
    if (strpos($name, "loggione") === 0) return "blue";
    return "white"; 
}

foreach($res1 as $jey){
    $dispo=getColorByName($jey['posto_biglietto']);
    $req2=$db->prepare("UPDATE posto SET disponibilita=? WHERE nome=? AND spettacoloID=?");
    $req2->execute([$dispo, $jey["posto_biglietto"], $jey["spettacolo"]]);
}


$req=$db->prepare("DELETE FROM abbonamento WHERE abbonamentoID=?");
$req->execute([$_GET['id']]);

$_SESSION['success']="La cancellazione è stata effettuata con successo !";
header('Location: ../cancellazione_abbonamenti');
exit();



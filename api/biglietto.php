<?php
header("Content-Type: application/json");

require 'database.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["utente_id"], $data["spettacolo_id"], $data["posti"], $data["tipo"])) {
    echo json_encode(["success" => false, "message" => "Dati incompleti"]);
    exit;
}

$utente_id = intval($data["utente_id"]);
$spettacolo_id = intval($data["spettacolo_id"]);
$posti = $data["posti"]; 
$prezzo=intval($data["prezzo"]);

if($data["tipo"]=="ABBONAMENTO"){
    try {
        $total=20+$prezzo;

        foreach ($posti as $posto) {
            $stmt = $db->prepare("INSERT INTO abbonamento (abbonamentoID, utente, spettacolo, posto_biglietto, prezzo_biglietto,data_movimento,citta_anagrafica_biglietto) VALUES (?, ?, ?, ?, ?,NOW(),?)");
            $stmt->execute([$data['id_biglietto'], $utente_id, $spettacolo_id, $posto["id"], $total, $data["citta"]]);
        }
    
        foreach($posti as $posto){
            $req=$db->prepare("UPDATE posto SET disponibilita='red' WHERE nome=? AND spettacoloID=?");
            $req->execute([$posto["id"],$spettacolo_id]);
        }
    
        echo json_encode(["success" => true]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
    
}else{
    try {
   
        foreach ($posti as $posto) {
            $stmt = $db->prepare("INSERT INTO biglietto (BigliettoID, utente, spettacolo, posto_biglietto, prezzo_biglietto,Data_movimento) VALUES (?, ?, ?, ?, ?,NOW())");
            $stmt->execute([$data['id_biglietto'], $utente_id, $spettacolo_id, $posto["id"], $prezzo]);
        }
    
        foreach($posti as $posto){
            $req=$db->prepare("UPDATE posto SET disponibilita='red' WHERE nome=? AND spettacoloID=?");
            $req->execute([$posto["id"],$spettacolo_id]);
        }
    
        echo json_encode(["success" => true]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }    
}

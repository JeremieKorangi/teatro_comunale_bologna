<?php
header("Content-Type: application/json");

require 'database.php';

$data = json_decode(file_get_contents("php://input"), true);

file_put_contents("log.txt", json_encode($data) . PHP_EOL, FILE_APPEND);

if (!isset($data["nome"], $data["spettacolo_id"], $data["posti"], $data["tipo"])) {
    echo json_encode(["success" => false, "message" => "Dati incompleti"]);
    exit;
}

$spettacolo_id = intval($data["spettacolo_id"]);
$posti = $data["posti"]; 
$prezzo=intval($data["prezzo"]);

if($data["tipo"]=="ABBONAMENTO"){

    
    $req=$db->prepare("INSERT INTO utente (Nome, Indirizzo_mail, telefono, passsword) VALUES (?,?,?,NULL)");
    $req->execute([$data["nome"], $data["mail"],$data["telefono"]]);
    
    $id=$db->lastInsertId();

    try {
        $total=20+$prezzo;

        foreach ($posti as $posto) {
            $stmt = $db->prepare("INSERT INTO abbonamento (abbonamentoID, utente, spettacolo, posto_biglietto, prezzo_biglietto,data_movimento,citta_anagrafica_biglietto,punto_di_vendita) VALUES (?, ?, ?, ?, ?,NOW(),?,?)");
            $stmt->execute([$data['id_biglietto'], $id, $spettacolo_id, $posto["id"], $total, $data["citta"],$data["puntoDiVenditaID"]]);
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

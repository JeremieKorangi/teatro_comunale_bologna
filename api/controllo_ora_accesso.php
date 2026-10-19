<?php
// Récupération des données POST
$data = json_decode(file_get_contents("php://input"), true);

// Vérifie si la clé est bien reçue
if (!isset($data['chiave_biglietto'])) {
    echo json_encode(["success" => false, "message" => "QR invalide"]);
    exit;
}

// Parse l'URL pour extraire les paramètres
parse_str(parse_url($data['chiave_biglietto'], PHP_URL_QUERY), $params);

$id_biglietto = $params['id'] ?? null;
$posto = $params['posto'] ?? null;

if (!$id_biglietto || !$posto) {
    echo json_encode(["success" => false, "message" => "Paramètres manquants"]);
    exit;
}

require "database.php"; // ton fichier de connexion

// Vérifie si le billet existe et n'a pas encore été validé
$stmt = $db->prepare("SELECT * FROM biglietto WHERE BigliettoID = ? AND posto_biglietto = ?");
$stmt->execute([$id_biglietto, $posto]);
$billet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$billet) {
    echo json_encode(["success" => false, "message" => "Billet non trouvé"]);
    exit;
}

// Vérifie si déjà validé
if ($billet['Ora_controllo_accessi'] !== null) {
    echo json_encode(["success" => false, "message" => "Billet déjà utilisé"]);
    exit;
}

// Mise à jour : validation du billet
$stmt = $db->prepare("UPDATE biglietto SET Ora_controllo_accessi = NOW() WHERE BigliettoID = ?");
$stmt->execute([$id_biglietto]);

echo json_encode(["success" => true, "message" => "Accès validé avec succès"]);

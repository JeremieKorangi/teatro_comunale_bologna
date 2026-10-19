<?php
session_start();

require "../../api/database.php";

$id=htmlspecialchars($_GET["id"]);

$req=$db->prepare("DELETE FROM spettacolo WHERE spettacoloID=?");
$req->execute([$id]);

$req1=$db->prepare("DELETE FROM  prezzo WHERE spettacoloID=?");
$req1->execute([$id]);

$req2=$db->prepare("DELETE FROM posto WHERE spettacoloID=?");
$req2->execute([$id]);

$req3=$db->prepare("DELETE FROM punto_di_vendita WHERE spettacoloID=?");
$req3->execute([$id]);

$req4=$db->prepare("DELETE FROM riduzione WHERE spettacoloID=?");
$req4->execute([$id]);

$_SESSION["success"]="Lo spettacolo è stato cancellato con successo !";

header("Location: ../spettacoli_cancellazione");
exit();


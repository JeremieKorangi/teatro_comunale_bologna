<?php 
require "sessione.php";
attivazione_sessione("adminID");
require "../../api/database.php";


$req=$db->prepare("DELETE FROM punto_di_vendita_2 WHERE punto_di_venditaID=?");
$req->execute([$_GET['id']]);

$_SESSION['success']="La cancellazione è stata effettuata con successo !";
header('Location: ../cancellazione_punti_di_vendita');
exit();



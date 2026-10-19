<?php 
require "sessione.php";
attivazione_sessione("adminID");
require "../../api/database.php";


$req=$db->prepare("DELETE FROM utente WHERE PersonID=?");
$req->execute([$_GET['id']]);

$_SESSION['success']="La cancellazione è stata effettuata con successo !";
header('Location: ../cancellazione_utente');
exit();



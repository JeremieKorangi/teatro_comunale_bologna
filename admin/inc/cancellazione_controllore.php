<?php 
require "sessione.php";
attivazione_sessione("nome_admin");
require "../../api/database.php";


$req=$db->prepare("DELETE FROM controllore WHERE controlloreID=?");
$req->execute([$_GET['id']]);

$_SESSION['success']="La cancellazione è stata effettuata con successo !";
header('Location: ../cancellazione_controllori');
exit();



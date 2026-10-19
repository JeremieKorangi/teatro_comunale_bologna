<?php 

$host="localhost";
$nome_database="tirocinio";
$nome="root";
$password="";

$db= new PDO("mysql:dbname=$nome_database;host=$host", "$nome", "$password");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

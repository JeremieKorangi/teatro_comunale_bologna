<?php 
    session_start();
    function attivazione_sessione($data){
        if(!isset($_SESSION["$data"])){
            header("Location: ../login/");
            exit();
        }
    }

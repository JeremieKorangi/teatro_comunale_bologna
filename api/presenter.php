<?php

require_once "database.php";
require_once "model.php";


class Presenter {
    private $model;

    public function __construct($db) {
        $this->model = new model($db);
    }

    public function handleRequest($method, $data,$id) {
        switch ($method) {
            case 'GET':
                if($id != NULL){
                    $articles=$this->model->getEventiById($id);
                    echo json_encode($articles);
                }else{
                    $articles = $this->model->getEventi();
                    echo json_encode($articles);
                } 
                
                break;

            case 'POST':
                if($this->model->inserimento_evento($data)){
                    echo json_encode(["success" => true, "message" => "L'evento è stato aggiunto con successo"]);
                } else{
                    echo json_encode(["success" => false, "message" => "Errore durante l'inserimento"]);
                }

                break;

            case 'PUT':
                if($this->model->aggiornamento_evento($id,$data)){
                    echo json_encode(["success" => true, "message" => "L'evento è stato aggiornato con successo !"]);
                }else{
                    echo json_encode(["success" => false, "message" => "Errore durante l'aggiornamento dell'evento !"]);
                }
                break;

            case 'DELETE':
                if ($id != NULL) {
                    if ($this->model->rimozione($id)) {
                       echo json_encode(["success" => true, "message" => "L'evento è stato cancellato con successo"]);
                    } else {
                       echo json_encode(["success" => false, "message" => "Errore"]);
                   }
                } else {
                    echo json_encode(["success"=>false, "message"=>"Errore"]);
                }
               break;

            default:
                 echo json_encode(["success"=>false, "message"=>"Errore"]);
            break;
        }
    }

}




function richiesta($method,$data,$database,$hashtag) {

    switch ($method) {
        case "POST":
            if (isset($data["action"]) && $data["action"] == "login") {
                if(login($data,$database)==false){
                    echo json_encode(["success" => false, "message" => "I dati non sono corretti !"]);
                } else{
                    echo json_encode(["success" => true, "message" => "Connessione stabilita !"]);
                }  
            } elseif (isset($data["action"]) && $data["action"] == "register") {
                if(registra_account($data,$database))
                      echo json_encode(["success" => true, "message" => "I dati sono stati inseriti correttamento, verrai reindirizzato nella pagina di login..."]);
                 else   
                      echo json_encode(["success" => false, "message" => "Errore !"]);
             }elseif (isset($data["action"]) && $data["action"] == "punti_di_vendita") {
                if(registra_punti_di_vendita($data,$database))
                      echo json_encode(["success" => true, "message" => "I dati sono stati inseriti correttamente !"]);
                 else   
                      echo json_encode(["success" => false, "message" => "Errore !"]);
             }elseif (isset($data["action"]) && $data["action"] == "admin") {
                if(login_admin($data,$database))
                      echo json_encode(["success" => true, "message" => "Connessione stabilita !"]);
                 else   
                      echo json_encode(["success" => false, "message" => "I dati non sono corretti  !"]);
             }elseif (isset($data["action"]) && $data["action"] == "controllore") {
                if(login_controllore($data,$database))
                      echo json_encode(["success" => true, "message" => "Connessione stabilita !"]);
                 else   
                      echo json_encode(["success" => false, "message" => "I dati non sono corretti  !"]);
             }elseif (isset($data["action"]) && $data["action"] == "punto_di_vendita") {
                if(login_punto_di_vendita($data,$database))
                      echo json_encode(["success" => true, "message" => "Connessione stabilita !"]);
                 else   
                      echo json_encode(["success" => false, "message" => "I dati non sono corretti  !"]);
             }elseif (isset($data["action"]) && $data["action"] == "controllore") {
                if(registra_controllore($data,$database))
                      echo json_encode(["success" => true, "message" => "I dati sono stati inseriti correttamente !"]);
                 else   
                      echo json_encode(["success" => false, "message" => "I dati non sono corretti  !"]);
             } elseif(isset($data["action"]) && $data["action"]=="iscrizione"){
                if(iscrizione($data,$database)){
                    echo json_encode(["success" => true, "message" => "L'iscrizione è avvenuta con successo !"]);
                }
                else{
                    echo json_encode(["success" => false, "message" => "L'iscrizione risulta già fatta per questo evento ! Si prega di scegliere un altro evento."]);
                }
            }elseif(isset($data["action"]) && $data["action"]=="iscrizione_utente_esterno"){
                if(iscrizione_esterno($data,$database)){
                    echo json_encode(["success" => true, "message" => "L'iscrizione è avvenuta con successo !"]);
                }else{
                    echo json_encode(["success" => false, "message" => "L'iscrizione risulta già fatta per questo evento ! Si prega di scegliere un altro evento."]);
                }
            }elseif(isset($data["action"]) && $data["action"]=="punti_vendita"){
                $res=punti_vendita($data,$database);
                echo json_encode($res);
            }

            break;

        case "GET":
            if(isset($data["id_account"]) && $data["action"]=="getEvent"){
                $articles=getEventiByUser($data["id_account"],$database);
                if (!$articles) {
                    echo json_encode(["success" => false, "message" => "Nessun elemento trovato"]);
                } else {
                    echo json_encode(["success" => true, "eventi" => $articles]);
                }
            }elseif(isset($data["action"]) && $data["action"]=="notifica"){
                $eventi=getNotifica($data,$database);
                if($eventi){
                    echo json_encode($eventi);
                }else{
                    echo json_encode(["success"=>false, "message"=>"Nessuna notifica"]);
                }
            }elseif(isset($data["id_account"]) && $data["action"]=="eventi_iscritti"){
                $eventi=getEventiIscritti($data,$database);
                if($eventi){
                    echo json_encode($eventi);
                }else{
                    echo json_encode(["success"=>false, "message"=>"Nessuna notifica"]);
                }
            }elseif(isset($data["id_account"]) && $data["action"]=="statistiche"){
                $eventi=getStatistiche($data,$database);
                if($eventi){
                    echo json_encode(["success"=>true, "eventi"=>$eventi]);
                }else{
                    echo json_encode(["success"=>false, "message"=>"Nessuna notifica"]);
                }
            }elseif(isset($hashtag)){
                $eventi=getEventByHashtag($hashtag,$database);
                 if($eventi){
                    echo json_encode($eventi);
                 }else{
                    echo json_encode(["success" => false, "message" => "Nessun elemento trovato"]);
                 }   
            }
            break;
        case "DELETE":
            if($data["action"]=="delete_iscrizione"){
            if(deleteIscrizione($data,$database)){
                echo json_encode(["success" => true, "message" => "L'iscrizione è stata cancellata con successo"]);
            }else{
                echo json_encode(["success" => false, "message" => "Errore durante la cancellazione"]);
            } } else{
                if(deleteNotifica($data,$database)){
                    echo json_encode(["success" => true, "message" => "La notifica è stata cancellata con successo !"]);
                }else{
                    echo json_encode(["success" => false, "message" => "Errore durante la cancellazione"]);
                }
            }
            break;
        default:
            echo json_encode(["error" => "Metodo non supportato"]);
    }
}
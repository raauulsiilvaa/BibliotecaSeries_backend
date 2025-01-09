<?php
require_once(__DIR__ . '/../utils/DBConnection.php');

class ActorsSeries {

    private $series_id; 
    private $actor_id; 

    public function __construct($series_id, $actor_id){
        $this->series_id = $series_id; 
        $this->actor_id = $actor_id; 
    }
    public function setIdSeries($series_id){
        $this->series_id = $series_id; 
    }
    public function getIdSeries(){
        return $this->series_id; 
    }
    public function setIdActor($actor_id){
        $this->actor_id = $actor_id; 
    }
    public function getIdActor(){
        return $this->actor_id; 
    }

    //getActorsForSeries
    
    function getAll() {
        $mysqli = DBConnection::getInstance()->getConnection();

        $query = $mysqli->query("SELECT actor_id FROM ActorSeries WHERE series_id = " . $this->series_id);
        $actors = [];
        foreach ($query as $item) {
            $actors[] = $item["actor_id"];
        }
        return $actors;
    }

    function getSeriesForActor($actorId) {
        $mysqli = DBConnection::getInstance()->getConnection();

        $query = $mysqli->query("SELECT series_id FROM ActorSeries WHERE actor_id = $actorId");
        $series = [];

        foreach ($query as $item) {
            $series[] = $item["series_id"];
        }
        return $series;
    }

    //associateActorToSeries
    function store() {
        $mysqli = DBConnection::getInstance()->getConnection();

        $insertQuery = "INSERT INTO ActorSeries (series_id, actor_id) VALUES ($this->series_id, $this->actor_id)";
        $result = $mysqli->query($insertQuery);

        return $result;
    }
     function update() {
        $mysqli = DBConnection::getInstance()->getConnection();
    
        $updateQuery = "UPDATE ActorSeries SET actor_id = {$this->actor_id} WHERE series_id = {$this->series_id}";
        $result = $mysqli->query($updateQuery);
    
        return $result;
    }

    function delete() {
        $mysqli = DBConnection::getInstance()->getConnection();
    
        $deleteQuery = "DELETE FROM ActorSeries WHERE series_id = $this->series_id";
        $result = $mysqli->query($deleteQuery);
    
        return $result;
    }
    function getItem(){
        $mysqli = DBConnection::getInstance()->getConnection(); 
        $query = $mysqli->query('SELECT * FROM ActorSeries WHERE series_id = ' . $this->series_id);  

        foreach($query as $item){
            $itemObject = new ActorsSeries($item["series_id"], $item["actor_id"]); 
            break; 
        }
        return $itemObject; 
    }
    
    //isActorAssociatedToSeries
    function isActorAssociatedToSeries(){
        $mysqli = DBConnection::getInstance()->getConnection(); 
        $query = $mysqli->query('SELECT * FROM ActorSeries WHERE actor_id = ' . $this->actor_id);  
        $isAssociated = false; 

        if ($query->num_rows != 0) {
            $isAssociated = true; 
        }
        return $isAssociated;
    }
}
?>


<?php
require_once(__DIR__ . '/../utils/DBConnection.php');

class LanguageSeriesAudio {
    public $series_id; 
    public $language_id; 

    public function __construct($series_id, $language_id){
        $this->series_id = $series_id; 
        $this->language_id = $language_id; 
    }
    public function setIdSeries($series_id){
        $this->series_id = $series_id; 
    }
    public function getIdSeries(){
        return $this->series_id; 
    }
    public function setIdLanguage($language_id){
        $this->language_id = $language_id; 
    }
    public function getIdLanguage(){
        return $this->language_id; 
    }

    //getLanguagesAudioForSeries
    function getAll() {
        $mysqli = DBConnection::getInstance()->getConnection();

        $query = $mysqli->query("SELECT language_id FROM LanguageSeriesAudio WHERE series_id = " . $this->series_id);
        $languagesAudio = [];

        foreach ($query as $item) {
            $languagesAudio[] = $item["language_id"];
        }
        return $languagesAudio;
    }

    function store() {
        $mysqli = DBConnection::getInstance()->getConnection();

        $insertQuery = "INSERT INTO LanguageSeriesAudio (series_id, language_id) VALUES ($this->series_id, $this->language_id)";

        $result = $mysqli->query($insertQuery);

        return $result;
    }
    function getItem(){
        $mysqli = DBConnection::getInstance()->getConnection(); 
        $query = $mysqli->query('SELECT * FROM LanguageSeriesAudio WHERE series_id = ' . $this->series_id);  

        foreach($query as $item){
            $itemObject = new LanguageSeriesAudio($item["series_id"], $item["language_id"]); 
            break; 
        }
        return $itemObject; 
    }
    function delete() {
        $mysqli = DBConnection::getInstance()->getConnection();
    
        $deleteQuery = "DELETE FROM LanguageSeriesAudio WHERE series_id = $this->series_id";
        $result = $mysqli->query($deleteQuery);
    
        return $result;
    }

    function isLanguageAssociatedToSeries(){
        $mysqli = DBConnection::getInstance()->getConnection(); 
        $query = $mysqli->query('SELECT * FROM LanguageSeriesAudio WHERE language_id = ' . $this->language_id);  
        $isAssociated = false; 

        if ($query->num_rows != 0) {
            $isAssociated = true; 
        }
        return $isAssociated; 
    }
}
?>

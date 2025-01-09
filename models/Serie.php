<?php
    require_once(__DIR__ . '/../utils/DBConnection.php');
    
    class Serie {
        private $id; 
        private $title; 
        private $platformId; 
        private $directorId; 


        public function __construct($idSerie, $titleSerie, $platformerieId, $directorSerieId){
            $this->id = $idSerie; 
            $this->title = $titleSerie; 
            $this->platformId = $platformerieId; 
            $this->directorId = $directorSerieId;             
        }
        public function setId($id){
            $this->id = $id; 
        }
        public function getId(){
            return $this->id; 
        }
        public function setTitle($title){
            $this->title = $title; 
        }
        public function getTitle(){
            return $this->title; 
        }
        public function setPlatformId($platformId){
            $this->platformId = $platformId; 
        }
        public function getPlatformId(){
            return $this->platformId; 
        }
        public function setDirectorId($directorId){
            $this->directorId = $directorId; 
        }
        public function getDirectorId(){
            return $this->directorId; 
        }

        public function getActors(){
            return $this->actors;
        }

        public function getLanguagesAudio(){
            return $this->languagesAudio;
        }

        public function getLanguagesSubtitles(){
            return $this->languagesSubtitles;
        }

        public function setActors($actors) {
            $this->actors = $actors;
        }

        public function setLanguagesAudio($languagesAudio) {
            $this->languagesAudio = $languagesAudio;
        }

        public function setLanguagesSubtitles($languagesSubtitles) {
            $this->languagesSubtitles = $languagesSubtitles;
        }
  
        function getAll() {
            $mysqli = DBConnection::getInstance()->getConnection();
            $query = $mysqli->query('SELECT * FROM Serie');  
            $listData = []; 

            foreach($query as $item){
                $itemObject = new Serie($item["id"], $item["title"], $item["platform_id"],$item["director_id"]); 
                array_push($listData, $itemObject); 
            }
            
            return $listData; 
        }

        function store(){
            $serieCreated = false; 
            $resultInsert = null; 
            $serieInsertId = null; 
            $mysqli = DBConnection::getInstance()->getConnection(); 

            $resultExistingSerie = $mysqli->query("SELECT title FROM Serie WHERE title = '$this->title' AND platform_id = '$this->platformId'");

            if ($resultExistingSerie->num_rows == 0) {
                // No existe un Serie con el mismo nombre, se puede crear
                $insertQuery = "INSERT INTO Serie (title, platform_id, director_id) VALUES ('$this->title', '$this->platformId', '$this->directorId')";

                if ($resultInsert = $mysqli->query($insertQuery)) {
                    $serieCreated = true;
                   $serieInsertId = $mysqli->insert_id;
                }
            }
          
            return [
                "isSerieCreated" => $serieCreated,
                "seriesIdCreated" => $serieInsertId
            ];
        }   

        function update(){
            $SerieEdited = false; 
            $mysqli = DBConnection::getInstance()->getConnection(); 

            // TO DO: Comprobar que existe antes de editar
            $resultExistingSerie = $mysqli->query("SELECT id FROM Serie WHERE title = '$this->title' AND id != $this->id");

            if ($resultExistingSerie->num_rows == 0) {
                // No existe una serie con el mismo nombre, se puede editar
                $updateQuery = "UPDATE Serie SET title = '$this->title', platform_id = '$this->platformId', director_id = '$this->directorId'
                                WHERE id = $this->id";

                if ($resultUpdate = $mysqli->query($updateQuery)) {
                    $SerieEdited = true;
                }
            }
            return $SerieEdited; 
        }  
        
        function delete(){
            $SerieDeleted = false; 
            $mysqli = DBConnection::getInstance()->getConnection(); 

            //Comprueba que existe la serie antes de borrarla
            $resultExistingSerie = $mysqli->query('SELECT id FROM Serie WHERE id = ' . $this->id);

            if ($resultExistingSerie->num_rows != 0) { 
                $deleteQuery = "DELETE FROM Serie where id = " . $this->id;

                if ($result = $mysqli->query($deleteQuery)) {
                    $SerieDeleted = true;
                }
            }
            return $SerieDeleted; 
        }

        function getItem(){
            $mysqli = DBConnection::getInstance()->getConnection(); 
            $query = $mysqli->query('SELECT * FROM Serie WHERE id = ' . $this->id);  

            foreach($query as $item){
                $itemObject = new Serie($item["id"], $item["title"], $item["platform_id"], $item["director_id"]); 

                // $actors = ActorSeriesModel::getActorsForSeries($this->id);
                // $languagesAudio = LanguageSeriesAudioModel::getLanguagesAudioForSeries($this->id);
                // $languagesSubtitles = LanguageSeriesSubtitlesModel::getLanguagesSubtitlesForSeries($this->id);

                // $itemObject->setActors($actors);
                // $itemObject->setLanguagesAudio($languagesAudio);
                // $itemObject->setLanguagesSubtitles($languagesSubtitles);
                break; 
            }
            //$mysqli->close();
            return $itemObject; 
        }
    }
?>
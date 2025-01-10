<?php
    require_once(__DIR__ . '/../utils/DBConnection.php');
    
    class Actor {
        private $id; 
        private $name; 
        private $surnames; 
        private $birthdate; 
        private $nationality; 

        public function __construct($idActor, $nameActor, $surnameActor, $birthdateActor, $nationalityActor){
            $this->id = $idActor; 
            $this->name = $nameActor; 
            $this->surnames = $surnameActor; 
            $this->birthdate = $birthdateActor; 
            $this->nationality = $nationalityActor; 
        }
        public function setId($id){
            $this->id = $id; 
        }
        public function getId(){
            return $this->id; 
        }
        public function setName($name){
            $this->name = $name; 
        }
        public function getName(){
            return $this->name; 
        }
        public function setSurnames($surnames){
            $this->name = $surnames; 
        }
        public function getSurnames(){
            return $this->surnames; 
        }
        public function setBirthdate($birthdate){
            $this->birthdate = $birthdate; 
        }
        public function getBirthdate(){
            return $this->birthdate; 
        }
        public function getNationality(){
            return $this->nationality; 
        }
        public function setNationality($nationality){
            $this->name = $nationality; 
        }

        function getAll() {
            $mysqli = DBConnection::getInstance()->getConnection();
            $query = $mysqli->query('SELECT * FROM Actor');  
            $listData = []; 

            foreach($query as $item){
                $itemObject = new Actor($item["id"], $item["name"], $item["surnames"],$item["birthdate"],  $item["nationality"]); 
                array_push($listData, $itemObject); 
            }

            return $listData; 
        }

        function store(){
            $actorCreated = false; 
            $mysqli = DBConnection::getInstance()->getConnection(); 

            $resultExistingActor = $mysqli->query("SELECT name FROM Actor WHERE name = '$this->name' AND surnames = '$this->surnames' AND birthdate = '$this->birthdate' AND nationality = '$this->nationality'");

            // Verificar si existe un actor con ese nombre, apellido, fecha de nacimiento y nacionalidad
            if ($resultExistingActor->num_rows == 0) {
                $insertQuery = "INSERT INTO Actor (name, surnames, birthdate, nationality) VALUES ('$this->name', '$this->surnames', '$this->birthdate', '$this->nationality')";

                if ($resultInsert = $mysqli->query($insertQuery)) {
                    $actorCreated = true;
                }
            }
            return $actorCreated; 
        }   

        function update(){
            $actorEdited = false; 
            $mysqli = DBConnection::getInstance()->getConnection(); 

            $resultExistingActor = $mysqli->query("SELECT id FROM Actor WHERE name = '$this->name' AND surnames = '$this->surnames' AND birthdate = '$this->birthdate' AND nationality = '$this->nationality' AND id != '$this->id'");
            // Verificar si existe un actor con ese nombre, apellido, fecha de nacimiento, nacionalidad y diferente id
            if ($resultExistingActor->num_rows == 0) {
                $updateQuery = "UPDATE Actor SET name = '$this->name', surnames = '$this->surnames', birthdate = '$this->birthdate', nationality = '$this->nationality' 
                                WHERE id = '$this->id'";

                if ($resultUpdate = $mysqli->query($updateQuery)) {
                    echo "RESULT UPDATE: " . $resultUpdate;
                    $actorEdited = true;
                }
            }

            return $actorEdited; 
        }  
        
        function delete(){
            $mysqli = DBConnection::getInstance()->getConnection();

            $deleteQuery = "DELETE FROM Actor where id = " . $this->id;

            return $mysqli->query($deleteQuery); 
        }

        function getItem(){
            $mysqli = DBConnection::getInstance()->getConnection(); 
            $query = $mysqli->query('SELECT * FROM Actor WHERE id = ' . $this->id);  

            foreach($query as $item){
                $itemObject = new Actor($item["id"], $item["name"], $item["surnames"], $item["birthdate"], $item["nationality"]); 
                break; 
            }
            return $itemObject; 
        }
    }
?>
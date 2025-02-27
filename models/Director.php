<?php
    require_once(__DIR__ . '/../utils/DBConnection.php');
    
    class Director {
        private $id; 
        private $name; 
        private $surnames; 
        private $birthdate; 
        private $nationality; 

        public function __construct($idDirector, $nameDirector, $surnameDirector, $birthdateDirector, $nationalityDirector){
            $this->id = $idDirector; 
            $this->name = $nameDirector; 
            $this->surnames = $surnameDirector; 
            $this->birthdate = $birthdateDirector; 
            $this->nationality = $nationalityDirector; 
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
            $query = $mysqli->query('SELECT * FROM Director');  
            $listData = []; 

            foreach($query as $item){
                $itemObject = new Director($item["id"], $item["name"], $item["surnames"],$item["birthdate"],  $item["nationality"]); 
                array_push($listData, $itemObject); 
            }

            return $listData; 
        }

        function store(){
            $directorCreated = false; 
            $mysqli = DBConnection::getInstance()->getConnection(); 

            $resultExistingDirector = $mysqli->query("SELECT name FROM Director WHERE name = '$this->name' AND surnames = '$this->surnames' AND birthdate = '$this->birthdate' AND nationality = '$this->nationality'");

            // Verificar si existe un director con el mismo nombre, apellidos, fecha de nacimiento y naionalidad
            if ($resultExistingDirector->num_rows == 0) {
                $insertQuery = "INSERT INTO Director (name, surnames, birthdate, nationality) VALUES ('$this->name', '$this->surnames', '$this->birthdate', '$this->nationality')";

                if ($resultInsert = $mysqli->query($insertQuery)) {
                    $directorCreated = true;
                }
            }
            return $directorCreated; 
        }   

        function update(){
            $directorEdited = false; 
            $mysqli = DBConnection::getInstance()->getConnection(); 

            $resultExistingDirector = $mysqli->query("SELECT id FROM Director WHERE name = '$this->name' AND surnames = '$this->surnames' AND birthdate = '$this->birthdate' AND nationality = '$this->nationality' AND id != '$this->id'");

            // Verificar si ya existe un director con el mismo nombre, apellidos, fecha de nacimiento, nacionalidad y diferente id
            if ($resultExistingDirector->num_rows == 0) {
                $updateQuery = "UPDATE Director SET name = '$this->name', surnames = '$this->surnames', birthdate = '$this->birthdate', nationality = '$this->nationality' 
                                WHERE id = '$this->id'";

                if ($resultUpdate = $mysqli->query($updateQuery)) {
                    $directorEdited = true;
                }
            }
            return $directorEdited; 
        }  
        
        function delete(){
            $mysqli = DBConnection::getInstance()->getConnection(); 

            $deleteQuery = "DELETE FROM Director where id = " . $this->id;

            return $mysqli->query($deleteQuery);
        }

        function getItem(){
            $mysqli = DBConnection::getInstance()->getConnection(); 
            $query = $mysqli->query('SELECT * FROM Director WHERE id = ' . $this->id);  

            foreach($query as $item){
                $itemObject = new Director($item["id"], $item["name"], $item["surnames"], $item["birthdate"], $item["nationality"]); 
                break; 
            }
            return $itemObject; 
        }

        function isDirectorAssociatedToSeries(){
            $mysqli = DBConnection::getInstance()->getConnection(); 
            $query = $mysqli->query('SELECT * FROM Serie WHERE director_id = ' . $this->id);  
            $isAssociated = false; 

            if ($query->num_rows != 0) {
                $isAssociated = true; 
            }
            return $isAssociated; 
        }
    }
?>
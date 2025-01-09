<?php
    require_once(__DIR__ . '/../utils/DBConnection.php');
    
    class Language {
        private $id; 
        private $name; 
        private $ISOCode;

        public function __construct($idLanguage, $nameLanguage, $ISOCodeLanguage){
            $this->id = $idLanguage; 
            $this->name = $nameLanguage; 
            $this->ISOCode = $ISOCodeLanguage; 
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
        public function setISOCode($ISOCode){
            $this->ISOCode = $ISOCode; 
        }
        public function getISOCode(){
            return $this->ISOCode; 
        }

        function getAll() {
            $mysqli = DBConnection::getInstance()->getConnection(); // Uso del Singleton
            $query = $mysqli->query('SELECT * FROM Language');  
            $listData = []; 

            foreach($query as $item){
                $itemObject = new Language($item["id"], $item["name"], $item["ISOCode"]); 
                array_push($listData, $itemObject); 
            }
            return $listData; 
        }

        function store(){
            $languageCreated = false; 
            $mysqli = DBConnection::getInstance()->getConnection(); 

            $resultExistingLanguage = $mysqli->query("SELECT name FROM Language WHERE name = '$this->name'");

            if ($resultExistingLanguage->num_rows == 0) {
                // No existe una plataforma con el mismo nombre, se puede crear
                $insertQuery = "INSERT INTO Language (name, ISOCode) VALUES ('$this->name','$this->ISOCode')";

                if ($resultInsert = $mysqli->query($insertQuery)) {
                    $languageCreated = true;
                }
            }
            return $languageCreated; 
        }   

        function update(){
            $languageEdited = false; 
            $mysqli = DBConnection::getInstance()->getConnection(); 

            // TO DO: Comprobar que existe antes de editar
            $resultExistingLanguage = $mysqli->query("SELECT name FROM Language WHERE name = '$this->name' AND id != $this->id");

            if ($resultExistingLanguage->num_rows == 0) {
                // No existe una plataforma con el mismo nombre, se puede editar
                $updateQuery = "UPDATE Language SET name = '" . $this->name . "', ISOCode = '" . $this->ISOCode . "' WHERE id = " . $this->id;

                if ($resultUpdate = $mysqli->query($updateQuery)) {
                    $languageEdited = true;
                }
            }
            return $languageEdited; 
        }  
        
        function delete(){
            $languageDeleted = false; 
            $mysqli = DBConnection::getInstance()->getConnection(); 

            //Comprueba que existe la plataforma antes de borrarla
            $resultExistingLanguage = $mysqli->query('SELECT id FROM Language WHERE id = ' . $this->id);

            if ($resultExistingLanguage->num_rows != 0) { 
                $deleteQuery = "DELETE FROM Language where id = " . $this->id;

                if ($result = $mysqli->query($deleteQuery)) {
                    $languageDeleted = true;
                }
            }
            return $languageDeleted; 
        }

        function getItem(){
            $mysqli = DBConnection::getInstance()->getConnection(); 
            $query = $mysqli->query('SELECT * FROM Language WHERE id = ' . $this->id);  

            foreach($query as $item){
                $itemObject = new Language($item["id"], $item["name"], $item["ISOCode"]); 
                break; 
            }
            return $itemObject; 
        }

        function isLanguageAssociatedToSeries(){
            $mysqli = DBConnection::getInstance()->getConnection(); 
            $query = $mysqli->query('SELECT * FROM Serie WHERE idLanguage = ' . $this->id);  
            $isAssociated = false; 

            if ($query->num_rows != 0) {
                $isAssociated = true; 
            }
            return $isAssociated; 
        }
    }
?>
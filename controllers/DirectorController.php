<?php
    require_once('../../models/Director.php'); 

    
    function listDirectors() {
        $model = new Director(null, null, null, null, null); 
        $directorList = $model->getAll();
        $directorObjectArray = [];

        foreach($directorList as $directorItem){
            $directorObject = new Director($directorItem->getId(), $directorItem->getName(),  $directorItem->getSurnames(),  $directorItem->getBirthdate(),  $directorItem->getNationality()); 
            array_push($directorObjectArray, $directorObject); 
        }
        return $directorObjectArray; 
    }

    function storeDirector($directorName, $directorSurnames, $directorBirthdate, $directorNationality){ 
        $newDirector = new Director(null, $directorName, $directorSurnames, $directorBirthdate, $directorNationality); 
        return $directorCreated = $newDirector->store(); 
    }

    function updateDirector($directorId, $directorName, $directorSurnames, $directorBirthdate, $directorNationality){ 
        $director = new Director($directorId, $directorName, $directorSurnames, $directorBirthdate, $directorNationality); 
        $directorEdited = $director->update();
        
        return $directorEdited; 
    }

    function deleteDirector($directorId){
        $director = new Director($directorId, null, null, null, null); 
        $directorDeleted = $director->delete();

        return $directorDeleted; 
    }
    function getDirectorData($idDirector){
        $director = new Director($idDirector, null, null, null, null); 
        $directorObject = $director->getItem(); 

        return $directorObject; 
    }
?>
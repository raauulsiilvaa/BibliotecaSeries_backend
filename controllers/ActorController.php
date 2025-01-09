<?php
    require_once('../../models/Actor.php'); 

    
    function listActors() {
        $model = new Actor(null, null, null, null, null); 
        $actorList = $model->getAll();
        $actorObjectArray = [];

        foreach($actorList as $actorItem){
            $actorObject = new Actor($actorItem->getId(), $actorItem->getName(),  $actorItem->getSurnames(),  $actorItem->getBirthdate(),  $actorItem->getNationality()); 
            array_push($actorObjectArray, $actorObject); 
        }
        return $actorObjectArray; 
    }

    function storeActor($actorName, $actorSurnames, $actorBirthdate, $actorNationality){ 
        $newActor = new Actor(null, $actorName, $actorSurnames, $actorBirthdate, $actorNationality); 
        return $actorCreated = $newActor->store(); 
    }

    function updateActor($actorId, $actorName, $actorSurnames, $actorBirthdate, $actorNationality){ 
        $actor = new Actor($actorId, $actorName, $actorSurnames, $actorBirthdate, $actorNationality); 
        $actorEdited = $actor->update();
        
        return $actorEdited; 
    }

    function deleteActor($actorId){
        $actor = new Actor($actorId, null, null, null, null); 
        $actorDeleted = $actor->delete();

        return $actorDeleted; 
    }
    function getActorData($idActor){
        $actor = new Actor($idActor, null, null, null, null); 
        $actorObject = $actor->getItem(); 

        return $actorObject; 
    }
?>
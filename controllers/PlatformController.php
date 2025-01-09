<?php
    require_once('../../models/Platform.php'); 

    
    function listPlatforms() {
        $model = new Platform(null, null); 
        $platformList = $model->getAll();
        $platformObjectArray = [];

        foreach($platformList as $platformItem){
            $platformObject = new Platform($platformItem->getId(), $platformItem->getName()); 
            array_push($platformObjectArray, $platformObject); 
        }
        return $platformObjectArray; 
    }

    function storePlatform($platformName){ 
        $newPlatform = new Platform(null, $platformName); 
        return $platformCreated = $newPlatform->store(); 
    }

    function updatePlatform($platformId, $platformName){ 
        $platform = new Platform($platformId, $platformName); 
        $platformEdited = $platform->update();
        
        return $platformEdited; 
    }

    function deletePlatform($platformId){
        $platform = new Platform($platformId, null); 
        $platformDeleted = $platform->delete();

        return $platformDeleted; 
    }
    function getPlatformData($idPlatform){
        $platform = new Platform($idPlatform, null); 
        $platformObject = $platform->getItem(); 

        return $platformObject; 
    }
?>
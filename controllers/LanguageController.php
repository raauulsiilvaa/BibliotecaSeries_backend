<?php
    require_once('../../models/Language.php'); 

    
    function listLanguages() {
        $model = new Language(null, null, null); 
        $languageList = $model->getAll();
        $languageObjectArray = [];

        foreach($languageList as $languageItem){
            $languageObject = new Language($languageItem->getId(), $languageItem->getName(), $languageItem->getISOCode()); 
            array_push($languageObjectArray, $languageObject); 
        }
        return $languageObjectArray; 
    }

    function storeLanguage($languageName, $languageISOCode){ 
        $newLanguage = new Language(null, $languageName, $languageISOCode); 
        return $languageCreated = $newLanguage->store(); 
    }

    function updateLanguage($languageId, $languageName, $languageISOCode){ 
        $language = new Language($languageId, $languageName, $languageISOCode); 
        $languageEdited = $language->update();
        
        return $languageEdited; 
    }

    function deleteLanguage($languageId){
        $language = new Language($languageId, null, null); 
        $languageDeleted = $language->delete();

        return $languageDeleted; 
    }
    function getLanguageData($idLanguage){
        $language = new Language($idLanguage, null, null); 
        $languageObject = $language->getItem(); 

        return $languageObject; 
    }
?>
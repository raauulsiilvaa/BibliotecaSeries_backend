<?php
    require_once('../../models/LanguageSeriesAudio.php'); 
   
    function listLanguageAudiosForSeries($series_id) {
        $model = new LanguageSeriesAudio($series_id, null); 
        $languageList = $model->getAll();
        return $languageList; 
    }

    function storeLanguageAudioForSeries($seriesId, $languageId){ 
        $newLanguageAudio = new LanguageSeriesAudio($seriesId, $languageId);
        return $languageCreated = $newLanguageAudio->store(); 
    }
    
    function updateLanguageAudioForSeries($seriesId, $languageId){ 
        $newLanguageAudio = new LanguageSeriesAudio($seriesId, $languageId);
        return $languageEdited = $newLanguageAudio->update(); 
    }

    function deleteLanguageAudioForSeries($seriesId){
        $language = new LanguageSeriesAudio($seriesId, null);
        $languageDeleted = $language->delete();

        return $languageDeleted; 
    }
    function getLanguageAudioDataForSeries($seriesId){
        $language = new LanguageSeriesAudio($seriesId, null); 
        $languageObject = $language->getItem(); 

        return $languageObject; 
    }
?>
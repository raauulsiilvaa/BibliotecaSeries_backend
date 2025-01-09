<?php
    require_once('../../models/LanguageSeriesSubtitles.php'); 
   
    function listLanguageSubtitlessForSeries($series_id) {
        $model = new LanguageSeriesSubtitles($series_id, null); 
        $languageList = $model->getAll();
        return $languageList; 
    }

    function storeLanguageSubtitlesForSeries($seriesId, $languageId){ 
        $newLanguageSubtitles = new LanguageSeriesSubtitles($seriesId, $languageId);
        return $languageCreated = $newLanguageSubtitles->store(); 
    }
    
    function updateLanguageSubtitlesForSeries($seriesId, $languageId){ 
        $newLanguageSubtitles = new LanguageSeriesSubtitles($seriesId, $languageId);
        return $languageEdited = $newLanguageSubtitles->update(); 
    }

    function deleteLanguageSubtitlesForSeries($seriesId){
        $language = new LanguageSeriesSubtitles($seriesId, null);
        $languageDeleted = $language->delete();

        return $languageDeleted; 
    }
    function getLanguageSubtitlesDataForSeries($seriesId){
        $language = new LanguageSeriesSubtitles($seriesId, null); 
        $languageObject = $language->getItem(); 

        return $languageObject; 
    }
?>
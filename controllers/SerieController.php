<?php
require_once('../../models/Serie.php');
require_once('../../controllers/ActorsSeriesController.php');
require_once('../../controllers/LanguageSeriesAudioController.php');
require_once('../../controllers/LanguageSeriesSubtitlesController.php');

function listSeries() {
    $model = new Serie(null, null, null, null); 
    $seriesList = $model->getAll();
    $seriesObjectArray = [];

    foreach($seriesList as $serieItem){
        $seriesObject = new Serie($serieItem->getId(), $serieItem->getTitle(),  $serieItem->getPlatformId(),  $serieItem->getDirectorId()); 
        $seriesObjectArray[] = $seriesObject;
    }
    return $seriesObjectArray; 
}

function storeSeries($title, $platformId, $directorId, $actors, $languagesAudio, $languagesSubtitles) {
    $newSeries = new Serie(null, $title, $platformId, $directorId);
    $seriesCreated = $newSeries->store();

    if ($seriesCreated["isSerieCreated"]) {
        $seriesId = $seriesCreated["seriesIdCreated"];

        // Asociar actores a la serie
        foreach ($actors as $actorId) {
            storeActorForSeries($seriesId, $actorId);
        }

        // Asociar idiomas de audio a la serie
        foreach ($languagesAudio as $languageId) {
            storeLanguageAudioForSeries($seriesId, $languageId);         
        }

        // Asociar idiomas de subtítulos a la serie
        foreach ($languagesSubtitles as $languageId) {
            storeLanguageSubtitlesForSeries($seriesId, $languageId);
        }
    }

    return $seriesCreated;
}

function updateSeries($seriesId, $title, $platformId, $directorId) {
    $series = new Serie($seriesId, $title, $platformId, $directorId);
    $seriesEdited = $series->update();

    return $seriesEdited;
}

function deleteSeries($seriesId) {
    $series = new Serie($seriesId, null, null, null);
    deleteActorForSeries($seriesId);
    deleteLanguageAudioForSeries($seriesId); 
    deleteLanguageSubtitlesForSeries($seriesId);    
    $seriesDeleted = $series->delete();
    
    return $seriesDeleted;
}

function getSeriesData($idSeries) {
    $series = new Serie($idSeries, null, null, null);
    $seriesObject = $series->getItem();

    return $seriesObject;
}
?>

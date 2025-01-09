<?php
    require_once('../../controllers/SerieController.php');
    require_once('../../controllers/PlatformController.php');
    require_once('../../controllers/DirectorController.php');
    require_once('../../controllers/LanguageController.php');
    require_once('../../controllers/ActorsSeriesController.php');
    require_once('../../controllers/LanguageSeriesAudioController.php');
    require_once('../../controllers/LanguageSeriesSubtitlesController.php');
    require_once('../../models/Director.php');
    require_once('../../models/Actor.php');
    require_once('../../models/Platform.php');
    require_once('../../assets/scripts/alertSystem.php');
    
?>

<!DOCTYPE html>
<html>
<head>
    <script src="../../assets/scripts/shared.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<header>
    <a href="../../index.html">
        <img src="/images/house-solid.svg" alt="home" style="margin:20px; width: 40px; height: 40px;">
    </a>
</header>
<body>
    <div class="container">
        <div class="row">
            <h1>Listado de series</h1>
        </div>
        <div class="text-start mb-4 mt-4">
            <a class="btn btn-primary" href="createEdit.php?action=create" role="button">
                <i class="fas fa-plus"></i> Crear serie
            </a>
        </div>
        <div class="row">
            <div class="col">
                <?php 
                    $seriesList = listSeries();
                    if(count($seriesList) > 0) {
                ?>
                <table class="table">
                    <thead>
                        <th>Id</th>
                        <th>Título</th>
                        <th>Plataforma</th>
                        <th>Director</th>
                        <th>Actores</th>
                        <th>Idiomas audio</th>
                        <th>Idiomas subtítulos</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($seriesList as $serie){
                        ?>   
                        <tr>
                            <td>
                                <?php echo $serie->getId(); ?>
                            </td>
                            <td>
                                <?php echo $serie->getTitle(); ?>
                            </td>
                            <td>
                                <?php 
                                    $platformId = $serie->getPlatformId(); 
                                    $platformObject = new Platform($platformId, null); 

                                    echo $platformObject->getItem()->getName();  

                                ?>
                            </td>
                            <td>
                                <?php 
                                    $directorId = $serie->getDirectorId(); 
                                    $directorObject = new Director($directorId, null, null, null, null); 

                                    $directorName = $directorObject->getItem()->getName(); 
                                    $directorSurname = $directorObject->getItem()->getSurnames(); 

                                    echo $directorName . ' ' .  $directorSurname;  

                                ?>
                            </td>
                            <td>
                                <?php 
                                    $idSerie = $serie->getId();
                                    $actors = listActorsForSeries($idSerie); 
                                    $actorNames = array();
                                    foreach($actors as $actorId){
                                        $actorObject = new Actor($actorId, null, null, null, null); 
                                        $actorName = $actorObject->getItem()->getName(); 
                                        $actorSurname = $actorObject->getItem()->getSurnames(); 
                                        $actorNames[] = $actorName . ' ' . $actorSurname;
                                    }

                                    echo implode(', ', $actorNames);
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $idSerie = $serie-> getId();
                                    $languages = listLanguageAudiosForSeries($idSerie); 
                                    $languageNames = array();

                                    foreach($languages as $languageId){
                                        $languageObject = new Language($languageId, null, null); 
                                        $languageNames[] = $languageObject->getItem()->getName();
                                    }

                                    echo implode(', ', $languageNames);
                                 ?>
                            </td>
                            <td>
                                <?php 
                                    $idSerie = $serie-> getId();
                                    $languages = listLanguageSubtitlessForSeries($idSerie); 
                                    $languageNames = array(); 

                                    foreach($languages as $languageId){
                                        $languageObject = new Language($languageId, null, null); 
                                        $languageNames[] = $languageObject->getItem()->getName();
                                    }
                            
                                    echo implode(', ', $languageNames);
                                 ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a class="btn btn-success mr-2" href="createEdit.php?action=edit&id=<?php echo $serie->getId();?>">Editar</a>

                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal_<?php echo $serie->getId(); ?>">
                                        Borrar
                                    </button>
                                    
                                 <?php 
                                      AlertSystem::showDeleteConfirmationModal($serie->getId(), 'Eliminar serie', '¿Estás seguro de eliminar la serie? ');
                                 ?>                         
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
                <?php
                    } else {   
                ?>
                <div class="alert alert-warning" role="alert">Aún no existen series.</div>
                <?php 
                    }       
                ?>
            </div>
        </div>
    </div>

    <script>
        function deleteItem(seriesId) {
            window.location.href = 'delete.php?seriesId=' + seriesId;
        }
    </script>
</body>
</html>

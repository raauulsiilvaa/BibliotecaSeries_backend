<?php 
    require_once('../../controllers/SerieController.php'); 
    require_once('../../controllers/ActorsSeriesController.php');
    require_once('../../controllers/LanguageSeriesAudioController.php');
    require_once('../../controllers/LanguageSeriesSubtitlesController.php');
    require_once('../../assets/scripts/alertSystem.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="../../assets/scripts/shared.js"></script>
    </head>
    <style>
    <body>
        <?php 
                $idSeries = $_GET['seriesId']; 
                $seriesDeleted = deleteSeries($idSeries);

                if ($seriesDeleted) {
                    AlertSystem::showSuccess('Serie eliminada correctamente.', 'list.php', 'Volver al listado de series');
                } else {
                    AlertSystem::showError('La serie no se ha eliminado correctamente.', 'list.php', 'Volver a intentarlo');
                }

            ?>

        </div>
    </body>
</html>


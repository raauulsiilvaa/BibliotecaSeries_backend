<?php 
    require_once('../../controllers/LanguageController.php'); 
    require_once('../../models/LanguageSeriesAudio.php'); 
    require_once('../../models/LanguageSeriesSubtitles.php'); 
      require_once('../../assets/scripts/alertSystem.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="../../assets/scripts/shared.js"></script>
    </head>
    <body>
        <?php 
                $idLanguage = $_GET['languageId']; 

                $languageAudio = new LanguageSeriesAudio(null, $idLanguage);
                $isAssociatedAudio = $languageAudio->isLanguageAssociatedToSeries();

                $languageSubtitles = new LanguageSeriesSubtitles(null, $idLanguage);
                $isAssociatedSubtitles = $languageSubtitles->isLanguageAssociatedToSeries();
               
                if ($isAssociatedAudio || $isAssociatedSubtitles) {
                     AlertSystem::showError('No se puede eliminar el idioma porque está asociado a una serie.' , ' Debe eliminar primero la serie.','list.php', 'Volver a intentarlo');
                } else {
                    $languageDeleted = deleteLanguage($idLanguage);
                }

                if ($languageDeleted) {
                     AlertSystem::showSuccess('Idioma eliminado correctamente.', 'list.php', 'Volver al listado de plataformas');
                } else {
                     AlertSystem::showError('El idioma no se ha eliminado correctamente.', 'list.php', 'Volver a intentarlo');
                }

            ?>

        </div>
    </body>
</html>


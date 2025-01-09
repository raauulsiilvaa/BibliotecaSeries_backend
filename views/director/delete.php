<?php 
    require_once('../../controllers/DirectorController.php'); 
      require_once('../../assets/scripts/alertSystem.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="../../assets/scripts/shared.js"></script>        
    </head>
    <body>
        <?php 
                $idDirector = $_GET['directorId']; 
                $director = new Director($idDirector, null, null, null, null);
                $isAssociated = $director->isDirectorAssociatedToSeries();

                if ($isAssociated) {
                     AlertSystem::showError('No se puede eliminar el director porque está asociado a una serie.', ' Debe eliminar primero la serie.', 'list.php', 'Volver a intentarlo');
                } else {
                    $directorDeleted = deleteDirector($idDirector);
                if ($directorDeleted) {
                     AlertSystem::showSuccess('Director eliminado correctamente.', 'list.php', 'Volver al listado de directors');
                } else {
                     AlertSystem::showError('La director no se ha eliminado correctamente.', 'list.php', 'Volver a intentarlo');
                }
            }

            ?>

        </div>
    </body>
</html>


<?php 
    require_once('../../controllers/ActorController.php'); 
    require_once('../../models/ActorsSeries.php'); 
    require_once('../../assets/scripts/alertSystem.php');
    require_once('../../assets/scripts/validations.php');
    require_once('../../models/Actor.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="../../assets/scripts/shared.js"></script>
    </head>
    <body>
        <?php 
                $idActor = $_GET['actorId']; 
                $actor = new ActorsSeries(null, $idActor);
                $isAssociated = $actor->isActorAssociatedToSeries();
                
                if ($isAssociated) {
                     AlertSystem::showError('No se puede eliminar el actor porque está asociado a una serie.', ' Debe eliminar primero la serie.', 'list.php', 'Volver a intentarlo');
                } else {
                    $actorDeleted = deleteActor($idActor);
                }
                if ($actorDeleted) {
                     AlertSystem::showSuccess('Actor eliminado correctamente.', 'list.php', 'Volver al listado de actors');
                } else {
                     AlertSystem::showError('La actor no se ha eliminado correctamente.', 'list.php', 'Volver a intentarlo');
                }
            ?>

        </div>
    </body>
</html>


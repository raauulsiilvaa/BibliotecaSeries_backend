<?php 
    require_once('../../controllers/PlatformController.php'); 
    require_once('../../assets/scripts/alertSystem.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="../../assets/scripts/shared.js"></script>
    </head>
    <body>
        <?php 
                $idPlatform = $_GET['platformId']; 
                $platform = new Platform($idPlatform, null);
                $isAssociated = $platform->isPlatformAssociatedToSeries();

                if ($isAssociated) {
                    AlertSystem::showError('No se puede eliminar la plataforma porque está asociada a una serie. ', 'Debe eliminar primero la serie.', 'list.php', 'Volver a intentarlo');
                } else {
                    $platformDeleted = deletePlatform($idPlatform);
                }

                if ($platformDeleted) {
                    AlertSystem::showSuccess('Plataforma eliminada correctamente.', 'list.php', 'Volver al listado de plataformas');
                } else {
                    AlertSystem::showError('La plataforma no se ha eliminado correctamente.', 'list.php', 'Volver a intentarlo');
                }
            ?>
    </body>

</html>


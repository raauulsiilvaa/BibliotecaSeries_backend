<?php
    require_once('../../controllers/PlatformController.php');
    require_once('../../assets/scripts/alertSystem.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <script src="../../assets/scripts/shared.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        
    </head>

    <body>
        <header>
            <a href="../../index.html">
                <img src="/images/house-solid.svg" alt="home" style="margin:20px; width: 40px; height: 40px;">
            </a>
        </header>
        <div class="container">
            <div class="row">
                <h1>Listado de plataformas</h1>
            </div>
            <div class="text-start mb-4 mt-4">
                <a class="btn btn-primary" href="createEdit.php?action=create" role="button"><i class="fas fa-plus"></i> Crear plataforma</a>
            </div>
            <div class="row">
                <div class="col">
                    <?php 
                        $platformList = listPlatforms();
                        if(count($platformList) > 0) {
                    ?>
                    <table class="table">
                        <thead>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($platformList as $platform){
                            ?>   
                            <tr>
                                <td>
                                    <?php echo $platform->getId(); ?>
                                </td>
                                <td>
                                    <?php echo $platform->getName(); ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a class="btn btn-success mr-2" href="createEdit.php?action=edit&id=<?php echo $platform->getId();?>">Editar</a>

                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal_<?php echo $platform->getId(); ?>">
                                            Borrar
                                        </button>
                                        
                                    <?php 
                                        AlertSystem::showDeleteConfirmationModal($platform->getId(), 'Eliminar plataforma', '¿Estás seguro de eliminar la plataforma? ');
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
                    <div class="alert alert-warning" role="alert">Aún no existen plataformas.</div>
                    <?php 
                        }       
                    ?>
                </div>
            </div>
        </div>

        <script>
            function deleteItem(platformId) {
                window.location.href = 'delete.php?platformId=' + platformId;
            }
        </script>
    </body>
</html>
